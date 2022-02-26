<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\SignatureInvalidException;

class CheckJwtPresence
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */


    public function handle(Request $request, Closure $next)
    {
        $key = env("JWT_SECRET");

        $tokenId    = base64_encode("hellow");
        $issuedAt   = time();
        $notBefore  = $issuedAt + 10;
        $expire     = $notBefore + 60;
        $serverName = $_SERVER["SERVER_NAME"];


        $k = [
            'iat'  => $issuedAt,
            'jti'  => $tokenId,
            'iss'  => $serverName,
            'nbf'  => $notBefore,
            'exp'  => $expire,
            "userId"  => 1
        ];
        $token = $request->header("Authorization");
        if (!isset($token)) {
            return response()->json(["message" => "Please provide Authorisation  Bearer token  Header"], 401);
        } else {
            $data = explode(" ", $token);
            if (count($data) != 2) {
                return response()->json(["message" => "Please provide Authorisation  Bearer token  Header"], 401);
            } else {
                if ($data[0] != "Bearer") {
                    return response()->json(["message" => "Please provide Authorisation  Bearer token  Header"], 401);
                } else {
                    $jwt = $data[1];
                    try {
                        $decoded = JWT::decode($jwt, new Key($key, 'HS256'));
                        
                        return $next($request);
                    } catch (ExpiredException $e) {
                        return response()->json(["Message" => "Token Expired"], 401);
                    } catch (SignatureInvalidException $e) {
                        return response()->json(["Message" => "Invalid Signature Detected"], 401);
                    } catch (Exception $e) {
                        return response()->json(["Message" => "Could not verify request"], 401);
                    }


                    // $decoded= JWT::encode($k, $key, 'HS256');

                    // return response()->json( $decoded,200);

                }
            }
        }
    }
}
/**
 * {
"iat": 1645600311,
"exp": 1645603911,
"token_type": "Bearer",
"expires_in": 3600,
"user_type": "merchant",
"user_id": "onoff"
}
 * 
 */
