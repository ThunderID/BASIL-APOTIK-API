<?php

namespace App\Http\Controllers;

use Gate, Auth, Exception;
use Aws\Rekognition\RekognitionClient as AWS;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;

use App\User;
use App\Org;
use Carbon\Carbon;
use Thunderlabid\HR\Absent;
use Firebase\JWT\JWT;

class HRController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function vision(Request $request){
        try {
            if(!Auth::check()) {
                app()->abort(403);
            }
            $user   = Auth::user();
            $args   = $request->only(['org_id', 'image', 'latitude', 'longitude', 'is_in_office']);

            $source = $user->works_in_hotel->firstwhere('org_id', $args['org_id']);
            $data   = file_get_contents($source['photo_url']);
            $data2  = base64_decode($args['image']);

            $client = new AWS([
                'credentials'   => config()->get('aws.credentials'),
                'region'        => config()->get('aws.region'),
                'version'       => config()->get('aws.version')
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
                return response()->json(['status' => 'fail', 'message' => 'Mismatch']);
            }

            /// CHECK DISTANCE
            $origin     = Org::where('id', $args['org_id'])->firstorfail();
            if(!(isset($args['is_in_office']) && (bool)$args['is_in_office'] === true)){
                $dis    = $this->count_distance($origin->geolocation['latitude'] - $args['latitude'], $origin->geolocation['longitude'] - $args['longitude'], $origin->geolocation['latitude'], $args['latitude']);
                if($dis >= 2.5){
                    return response()->json(['status' => 'fail', 'message' => 'Out of range']);
                }
            }

            //log attendance
            $absent     = Absent::create([
                'date' => \Carbon\Carbon::now()->format('Y-m-d'), 
                'at' => \Carbon\Carbon::now()->format('H:i:s'),
                'user_id' => $user->id,
                'org_id' => $args['org_id'],
                'is_in_office' => (bool)$args['is_in_office'],
                'geolocation' => ['latitude' => $args['latitude'], 'longitude' => $args['longitude']],
                // 'geolocation' => $origin['geolocation'],
                'status' => ($args['is_in_office'] ? 'PRESENT' : 'PRESENT_ON_REMOTE'),
            ]);

            return response()->json(['status' => 'success']);
        } catch (Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
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


    public function history(Request $request){
        try {
            if(!Auth::check()) {
                app()->abort(403);
            }
            $user   = Auth::user();

            $args   = $request->only(['start', 'end', 'org_id']);

            $absent = Absent::where('org_id', $args['org_id'])
                ->where('user_id', $user['id'])
                ->where('date', '>=', Carbon::parse($args['start'])->format('Y-m-d'))
                ->where('date', '<=', Carbon::parse($args['end'])->format('Y-m-d'))
                ->paginate();

            return response()->json(['status' => 'success', 'data' => $absent]);
        } catch (Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }
}
