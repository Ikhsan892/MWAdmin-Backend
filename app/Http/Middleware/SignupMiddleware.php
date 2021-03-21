<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Validator;

class SignupMiddleware
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
        $validate = Validator::make($request->all(), [
            'firstName' => 'required',
            'lastName' => 'required',
            'email' => 'required',
            'role' => 'required',
            'password' => 'required',
            'profile_image' => 'required',
            'no_telpon' => 'required',
            'jabatan' => 'required',
            'alamat' => 'required',
            'ttl' => 'required',
        ]);
        if ($validate->fails()) {
            return response()->json([
                'message' => $validate->errors()
            ], 401);
        } else {
            return $next($request);
        }
    }
}
