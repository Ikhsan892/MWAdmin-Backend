<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\DB;

class ApiLogin
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
        $secret = DB::table('oauth_clients')
            ->where('id', 2)->pluck('secret')
            ->first();

        $request->merge([
            'grant_type' => 'password',
            'client_id' => 2,
            'client_secret' => $secret,
            'username' => 'mullrich@example.com',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'
        ]);
        return $next($request);
    }
}
