<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminCheck
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
        if(!session()->has('adminLogIn') && ($request->path() !== 'admin')){
            return redirect('admin')->with('fail','You must be logged in');
        }
        if(session()->has('adminLogIn') && ($request->path() === 'admin')){
            return back();
        }
        return $next($request);
    }
}
