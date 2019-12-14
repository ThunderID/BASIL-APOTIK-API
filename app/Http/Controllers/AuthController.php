<?php

namespace App\Http\Controllers;

use Gate, Auth, Exception;
use Aws\Rekognition\RekognitionClient as AWS;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;

use App\User;
use App\Org;
use Thunderlabid\HR\Absent;
use Firebase\JWT\JWT;

class AuthController extends Controller
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

    //
    public function login(Request $request){
        try {
            $args   = $request->only(['username', 'password']);
            $user   = User::authenticate($args['username'], $args['password']);

            $user   = User::where('id', $user->id)->with(['partners', 'partners.membership', 'works_in_hotel'])->firstorfail();

            $org    = array_column($user->works_in_hotel->toarray(), 'org');

            $token  = array(
                "iss" => config('jwt.JWT_ISS'),
                "aud" => config('jwt.JWT_AUD'),
                "iat" => now()->timestamp,
                "username" => $user->username
            );
            $jwt = JWT::encode($token, config('jwt.JWT_KEY'), config('jwt.JWT_ALGORITHM'));

            return response()->json(['status' => 'success', 'data' => [
                'user'                  => $user->toarray(),
                'jwt_token'             => $jwt,
                'orgs'                  => $org,
            ]]);
        } catch (Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }

        //
    public function whoami(Request $request){
        try {
            if(!Auth::check()) {
                app()->abort(403);
            }
            $user   = User::where('username', Auth::user()['username'])->With(['works_in_hotel', 'works_in_hotel.org'])->firstorfail();

            $org    = array_column($user->works_in_hotel->toarray(), 'org');

            $token  = array(
                "iss" => config('jwt.JWT_ISS'),
                "aud" => config('jwt.JWT_AUD'),
                "iat" => now()->timestamp,
                "username" => $user->username
            );
            $jwt = JWT::encode($token, config('jwt.JWT_KEY'), config('jwt.JWT_ALGORITHM'));

            return response()->json(['status' => 'success', 'data' => [
                'user'                  => $user->toarray(),
                'jwt_token'             => $jwt,
                'access_organization'   => $org
            ]]);
        } catch (Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }
}
