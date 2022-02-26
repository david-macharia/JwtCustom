<?php

namespace App\Http\Controllers;

use App\Http\Requests\JwtAuntenticableRequest;
use App\Http\Tools\CreateJwt;
use Illuminate\Http\Request;

class JwtUserController extends Controller
{
    use CreateJwt;
    public  $claims =  [
        'iat'  => 1645600311,
        'jti'  => 1645600311,
        'iss'  => "next_layer",
        'nbf'  => 1645600311,
        'exp'  => 60,
        "token_type" => "Bearer",
        "expires_in" => 3600,
        "user_type" => "merchant",
        "user_id" => "onoff"
    ];
    public function testApi()
    {;
        return $this->createJwt($this->claims);
    }
    public function refreshToken()
    {
    }
    public function login(JwtAuntenticableRequest $request)
    {
   
       return [
           "token"=>$request->createJwt($this->claims),
           "refreshToken"=>$request->createRefreshJwt($this->claims)
       ];

       
    }
}
