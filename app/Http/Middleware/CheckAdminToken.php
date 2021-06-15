<?php

namespace App\Http\Middleware;

use App\Helpers\Traits;
use Closure;
use tymon\jwtauth\Facades\JWTAuth;
class CheckAdminToken
{
    use Traits;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = null;
        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){
                return $this -> returnError('3001','Token is Invalid');
            }else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
                return $this -> returnError('3002','Token is Expired');
            }else{
                return $this -> returnError('3003','Authorization Token not found');
            }
        }
        if(!$user)
            $this -> returnError(trans('Unaauthenticated'));
        return $next($request);
    }
}
