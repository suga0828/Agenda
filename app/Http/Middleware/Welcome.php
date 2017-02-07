<?php

namespace App\Http\Middleware;

use Closure;

class Welcome
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
        $user=\Auth::user();
        if($user->perfil_id==1){
           return $next($request); 
       }else{
         return redirect('home');
       }
    }
}
