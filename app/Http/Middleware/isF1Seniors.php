<?php

namespace App\Http\Middleware;
use App\Model\StudentModel\StudentTeam_Role;
use App\Model\Competition\Schoolteamcomp;
use Closure;
use Auth;
use DB;


class isF1Seniors
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

        if(auth()->user()->role == '6') {
            
			$email = Auth::user()->email;
			$status= DB::table('students')->where('studentemail',$email)->first();
			$studentid= DB::table('students')->where('studentemail',$email)->first()->id; 
           $schoolid= DB::table('students')->where('studentemail',$email)->first()->school_id;		
         return $next($request);
        }
        return redirect('studentCollegeLogin');
    }
}
