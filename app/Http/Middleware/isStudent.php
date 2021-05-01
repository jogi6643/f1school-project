<?php

namespace App\Http\Middleware;
use App\Model\StudentModel\StudentTeam_Role;
use App\Model\Competition\Schoolteamcomp;
use Closure;
use Auth;
use DB;
use App\Model\Student;

class isStudent
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
        if(auth()->user()->role == '5') {
		$email = Auth::user()->email;
		$status = Student::select('*')->where('mobileno',Auth::user()->mobile_no)->where('dob',Auth::user()->dob)->first();
		
		$studentid = $status->id; 
        $schoolid = $status->school_id;
       
		$teams1 = DB::table('studentTeam_Role')
                         ->where('studentid',$studentid)
                         ->where('schoolid',$schoolid)
					     // ->orwhere('status',1)
					     // ->where('status',5)
                         ->first()??"NO";

                    if($teams1!='NO')
                    {

                    if($teams1->status==1||$teams1->status==5)
                    {
				     if(isset($teams1->teamId)){

				      	$compId = Schoolteamcomp::
					          where('school_id',$schoolid)
					          ->where('tmpid',$teams1->teamId)
					          ->count();
						}
						else
						{
							$compId=0;
						}
					}
					else
					{
						$compId=0;
					}

				}
				else
				{
					$compId=0;
				}
		
		   $studenteamroleId=DB::table('studentTeam_Role')
                        ->where('schoolid',$schoolid)
                        ->where('studentid',$studentid)
                        // ->where('created_at', date('Y'))
                        ->count();
						 
		  $request->session()->put('role',5);
		   $planId = DB::table('assignpriceinschool')->where('schoolid', $schoolid)->orderBy('id', 'DESC')
                    ->first();
		if($planId!=null)
		{       if(isset($teams1->teamId))
			{
			   $block=DB::table('team_block')->where('plan',$planId->planid)->where('team_id',$teams1->teamId)->sum('block')??0;
			}
			else
			{
				 $block=0;
			}
		}
		 else
		 {
			  $block=0;
		 }
		  $block=(int)$block;
		  $request->session()->put('av',$block);
		  $request->session()->put('compId',$compId);
		  $request->session()->put('studentid',$studentid);
		  $request->session()->put('schoolid',$status->school_id);
		  $request->session()->put('studenteamroleId',$studenteamroleId);
         return $next($request);
        }
        return redirect('login');
    }
}
