<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Validator;

class ConfirmedMiddleware
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
        $validate = Validator::make([
            'name' => 'required'
        ]);
        if ($validate->fails()) {
            return response()->json([
                'message' => $validate->errors()
            ], 400);
        } else {
            return $next($request);
        }
    }
}
