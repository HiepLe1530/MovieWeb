<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Auth;

class CheckAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $role = [
            'Admin' => 1,
            'User' => 2
        ];
        if(Auth::check() && Auth::user()->u_r_id == $role['Admin']){
            return $next($request);
        }
        Auth::logout();
        return redirect(route('login'))->with('error', 'Vui lòng đăng nhập bằng tài khoản Admin để vào trang quản trị.');
    }
}
