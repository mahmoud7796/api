<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Tymon\JWTAuth\Facades\JWTAuth;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::group(['middleware'=>['api','checkPassword','apilang'],'namespace'=>'APIS'], function(){
Route::post('/category','apiController@index');
Route::post('/categoryId','apiController@categoryId');
Route::post('/ChangeStatus','apiController@ChangeStatus');

Route::group(['prefix'=>'admin','namespace'=>'Admin'], function(){
    Route::post('/login','AuthController@login');
    Route::post('/logout','AuthController@logout')->middleware ('auth.guard:api-admin');

});

Route::group(['prefix'=>'user','namespace'=>'User'], function(){
        Route::post('/login','AuthController@login');
        Route::post('/logout','AuthController@logout')-> middleware('auth.guard:api-user');

});

    Route::group(['prefix'=>'user','namespace'=>'User','middleware'=>'auth.guard:api-user'], function(){
        Route::post('/profile',function(){
            return \Auth::user();

        });
    });
});

/*Route::group(['prefix'=>'user','namespace'=>'User','api','checkPassword'], function(){
    Route::post('/login','AuthController@userlogin');
});*/





