<?php

namespace App\Http\Middleware;

use Closure;
use App\Labelmodule;
use App\Label;
use App\User;
use Auth;
use App\Coadmin;

class isAdmin
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

        
        if(auth()->user()->role == '1') {
            return $next($request);

        }
		if(auth()->user()->role == '2') {
			$coadmin=User::find(Auth::id());
			 preg_match_all('!\d+!',$coadmin['email'], $matches);
		  $data=Coadmin::where('email',$coadmin['email'])->first();
		  $emp=Labelmodule::where('label_id',$data->role)->get()->toArray();
		  $module_id=[];
		 foreach($emp as $key=>$emps)
		 {
			 $module_id[$emps['module_id']]=$emps['functions'];
		 }
		 $request->session()->put(['data'=>$module_id]);
            return $next($request);

        }

        return redirect('login');
    }
}
