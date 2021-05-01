<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */

    public function handle($request, Closure $next, $guard = null)
    {

  
        
        if(Auth::guard($guard)->check()) {

			 
            //admin
           if(Auth::user()->role == "1"){
            return redirect('/');
           } 
		   
		    if(Auth::user()->role == "2"){
            return redirect('/');
           } 


           //trainer
           if(Auth::user()->role == "3"){
			  
            return redirect('/trainer');
			
           } 

           //school
           if(Auth::user()->role == "4"){
            return redirect('/home');
           } 

           //student
           if(Auth::user()->role == "5"){
           return redirect('dashboard');
           } 

             //F1Seniors

           if(Auth::user()->role == "6"){
           return redirect('studentcollagedashboard');
           } 
        }

        return $next($request);
        
    }
}
