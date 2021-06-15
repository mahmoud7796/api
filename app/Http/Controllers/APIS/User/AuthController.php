<?php

namespace App\Http\Controllers\APIS\User;

use App\Helpers\Traits;
use App\Http\Controllers\Controller;
use Validator;
use Illuminate\Http\Request;
use Auth;
use Tymon\JWTAuth\Facades\JWTAuth;


class authController extends Controller
{
    use Traits;
    public function login(Request $request){
        try{


            $rules = [
                "email" => "required",
                "password" => "required"
            ];
            $validator = Validator::make($request-> all(), $rules);
            if($validator-> fails()){
                $code = $this -> returnCodeAccordingToInput($validator);
                return $this -> returnValidationError($validator, $code );
            }
            //login

            $credentials = $request -> only(['email','password']);

            $token = Auth::guard('api-user')->attempt($credentials);
            if(!$token){
                return $this -> returnError('E001','البيانات غلط');
            }
            //return $token
            $user = Auth::guard('api-user')-> user();
            $user -> api_token = $token;
            return $this -> returnData('user',$user,'token success');
        }catch (\Exception $ex){
            return $this -> returnError($ex-> getcode(), $ex -> getMessage());
        }


    }

    public function logout(Request $request){
        $token = $request-> header('auth-token');
        if($token){
            JWTAuth::setToken($token)-> invalidate();
            return $this -> returnSuccessMessage('loged out successfully');
        }else{
            return $this -> returnError('E301','some thing wronge');
        }

    }

    public function profile(Request $request){
        $credentials = $request -> only(['email','password']);
        $user = Auth::guard('api-user')->attempt($credentials);
        if(!$user){
            return $this -> returnError('E301','wrong data');
        }
    }
}
