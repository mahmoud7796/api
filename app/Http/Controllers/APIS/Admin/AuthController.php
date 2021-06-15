<?php

namespace App\Http\Controllers\APIS\Admin;

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
        $token = Auth::guard('api-admin')->attempt($credentials);

        if(!$token)
            return $this -> returnError('E001','البيانات غلط');
        //return $token
            $admin = Auth::guard('api-admin')-> user();
            $admin -> api_token = $token;
            return $this -> returnData('admin',$admin,'token success');
        }catch (\Exception $ex){
            return $this -> returnError($ex-> getcode(), $ex -> getMessage());
        }

    }

    public function logout(Request $request){
        try{
         $token = $request -> header('auth-token');
         if($token){
             JWTAUTH::setToken($token)-> invalidate();
         return $this -> returnSuccessMessage('loged out successfully');
    }else{
             return  $this -> returnError('E003','some thing wrong please try again');
         }
    }catch(\Exception $ex){
            return $this -> returnError('E600','لقد حدث خطأ');
        }
    }
}
