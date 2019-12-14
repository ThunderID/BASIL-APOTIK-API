<?php

namespace App\GraphQL\Mutation\HR;

use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use Rebing\GraphQL\Support\SelectFields;

use Illuminate\Validation\ValidationException;

use GraphQL;
use Auth;
use Firebase\JWT\JWT;
use App\User;
use App\Models\HR\Absent;

class AuthorizeAttendanceUsingPhoto extends Mutation
{
    protected $attributes = [
        'name' => 'AuthorizeAttendanceUsingPhoto',
        'description' => 'A mutation'
    ];

    public function authorize($args){
        return Auth::check();
    }

    public function type(){
        return Type::boolean();
    }

    public function args(){
        return [
            'org_id'            =>  [
                                    'name'  => 'org_id',
                                    'type'  => Type::int(),
                                ],
            'image'             =>  [
                                    'name'  => 'image',
                                    'type'  => Type::string(),
                                ],
            'latitude'          =>  [
                                    'name'  => 'latitude',
                                    'type'  => Type::string(),
                                ],
            'longitude'     =>  [
                                    'name'  => 'longitude',
                                    'type'  => Type::string(),
                                ],
        ];
    }

    public function resolve($root, $args) {
        // Get User
        $user   = Auth::user();
        $work   = $user->works_in_hotel->firstWhere('org_id', '=', $args['org_id']);

        $source = $work->photo_url;
        $data   = file_get_contents($source);
        $data2  = base64_decode($args['image']);

        $client = new AWS([
            'credentials'   => env('AWS_CREDENTIALS'),
            'region'        => env('AWS_REGION'),
            'version'       => env('AWS_VERSION')
        ]);
        $th     = 99;
        $result = $client->compareFaces([
            'SimilarityThreshold' => $th,
            'SourceImage' => [ // REQUIRED
                'Bytes' => $data,
            ],
            'TargetImage' => [ // REQUIRED
                'Bytes' => $data2,
            ],
        ]);

        if(!isset($result['FaceMatches']['0']['Similarity']) || $result['FaceMatches']['0']['Similarity'] < $th){
            throw ValidationException::withMessages(['image' => [config()->get('errors.mismatch')]]);
        }

        /// CHECK DISTANCE
        $origin = \App\Org::where('id', $args['org_id'])->firstorfail();
        $dis    = $this->count_distance($origin->geolocation['latitude'] - $args['latitude'], $origin->geolocation['longitude'] - $args['longitude'], $origin->geolocation['latitude'], $args['latitude']);
        if($dis >= 2.5){
            throw ValidationException::withMessages(['latitude' => ['out of range'], 'longitude' => ['out of range']]);
        }

        //log attendance

        return true;
    }

    private function count_distance($delta_lat, $delta_lon, $lat_a, $lat_b){
        $earth_radius = 6372.795477598;

        $alpha    = $delta_lat/2;
        $beta     = $delta_lon/2;
        $a        = sin(deg2rad($alpha)) * sin(deg2rad($alpha)) + cos(deg2rad($lat_a)) * cos(deg2rad($lat_b)) * sin(deg2rad($beta)) * sin(deg2rad($beta)) ;
        $c        = asin(min(1, sqrt($a)));
        $distance = 2*$earth_radius * $c;
        $distance = round($distance, 4);

        return $distance;
    }
}