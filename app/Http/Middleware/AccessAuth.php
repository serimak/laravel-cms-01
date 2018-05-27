<?php
use Symfony\Component\HttpKernel\Exception\HttpException;
namespace App\Http\Middleware;
use Illuminate\Http\JsonResponse;
use Closure;

class AccessAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $AuthorizationHeader = $request->header('Authorization');
        $response = explode(' ', $AuthorizationHeader);
        return response()->json([
            "resultCode"=>"40100",
            "resultDescription"=>"Unauthorized",
            "developerMessage"=>"Invalid credentials",
            "Token"=>$response[count($response)-1],
            "errors"=>NULL
        ], 401);
        //return $next($request);
    }
}
