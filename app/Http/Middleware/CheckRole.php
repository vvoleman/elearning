<?php

namespace App\Http\Middleware;

use Closure;

class CheckRole
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return mixed
     */
    public function handle($request, Closure $next, ...$roles)
    {
        if(\Auth::check()){
            $hasRole = false;
            foreach($roles as $role){
                if($request->user()->hasRole($role)){
                    $hasRole = true;
                    break;
                }
            }
            if($hasRole){
                return $next($request);
            }else{
                die("error 403 - zdroj \App\Middleware\CheckRole.php");
            }
        }
        return redirect()->route('login.login');

    }

}