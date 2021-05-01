<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Illuminate\Http\Request;
use App\Coadmin;
use App\Model\DealerEmployee;
use App\Model\Dealer;
use App\Model\CustomTrainer;
use App\User;
use App\Model\Areaoffice;
use App\Model\Ard;
use App\Model\ArdSystem;
use App\Labelmodule;
use App\Label;


class LabelMiddleware
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
      
		
		$coadmin=User::find(Auth::id());
		
		if($coadmin['role']==1){
			
			 $request->session()->put(['role'=>1]);
		}

	if($coadmin['role']==2){

		 preg_match_all('!\d+!',$coadmin['email'], $matches);
		
         
		  $data=Coadmin::where('email',$coadmin['email'])->first();
		  
		 
		  $request->session()->put(['email'=>$data['email']]);
		  $request->session()->put(['role'=>2]);
          $request->session()->put(['id'=>$data['id']]);
	
// dd($request->session()->get('id'));

  	if($data->role!=null){

		 $emp=Labelmodule::where('label_id',$data->role)->get()->toArray();
	   	 $labelname=Label::where('id',$data->role)->first();
	   	 $request->session()->put(['labelname'=>$labelname]); 
		 $module_id=[];
		 foreach($emp as $key=>$emps)
		 {
			 $module_id[$emps['module_id']]=$emps['functions'];
		 }
		 dd($module_id);
	     $data=array_column($emp,'module_id');	
	     $function=array_column($emp,'functions');
	     $request->session()->put(['functions'=>$function]); 

		 $request->session()->put(['data'=>$data]);
	
		   return redirect('/');
		
		}
		else
		{
		   
		    Auth::logout();
		     $request->session()->flash('status','Permission Denied');
		     
		    return redirect('/login');
		}
	
	}

		
        return $next($request);
    }
    
}
