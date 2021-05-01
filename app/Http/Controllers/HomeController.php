<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Auth;
use DB;
use App\School;
use App\Model\Trainer;
use App\Studentinfo;
use App\Coadmin;
use App\Model\Student;
use App\Model\Competition\Competitionstore;
use App\Model\Competition\Schoolteamcomp;
use App\Location;
use App\States;
use App\City;
use App\Model\Manufacture\Stcarbodypart;
use App\Schoolmasterplan;
use App\Membership;
use App\Participatestudent;
use App\Model\SchoolTrainer;
use App\Course;
use App\Model\AssignedCoursetype;
use Maatwebsite\Excel\Facades\Excel;
use App\Login_Academic_Year;
use App\Label;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
		
      /* */
        $vw = $this->selector();
       /* =================Start Admin Dashboard ==================================*/
        if($vw=='admin')
           {
            try
            {
            $totalschools  =School::get()->count();
            //dd($totalschools);
            $totalstudents =Studentinfo::get()->count();
            //dd($totalstudents);
            $totaltrainers =Trainer::get()->count();
            //dd($totaltrainers);
            $totalcoadmins =Coadmin::get()->count();
            //dd($totalcoadmins);
            $currentdate=date('m/d/Y');
			$currentdate1=date('m/d/Y',strtotime('-1 month'));
			 
             //dd($currentdate);
            $data = Competitionstore::where('Start_Date','>=',$currentdate)
                    ->orderBy('Start_Date','ASC')
                    ->skip(0)->take(3)
                    ->get()
                    ->map(function($input){
                        $input['totalteam']=Schoolteamcomp::where('cmpid',$input['id'])->get()->count();
                            $date=date_create($input['Ragistration_Date']); 
                        $input['Ragistration_Date']=date_format($date,"d/m/Y");
                            $date=date_create($input['Start_Date']); 
                        $input['Start_Date']=date_format($date,"d/m/Y");                     
                             return $input;
                              })->toArray();

			$compbyteam= $data = Competitionstore::where('Start_Date','>=',$currentdate1)
			                     ->orderBy('Start_Date','ASC')->get();

			 foreach($compbyteam as $key=>$compbyteams)
			 {
				 $arr[$key]['comp'] = $compbyteams->Competition_name;
				 $arr[$key]['count'] = Schoolteamcomp::
				                      where('cmpid',$compbyteams->id)->count();
			 }
			  
             $school = Location::
                        groupBy('zone')
                        ->get();

             foreach ($school as $key => $value) {
               $school[$key]->Zonename = Location::where('Zone_id',$value->zone)
                                         ->first()->zone??'N/A';
               $school[$key]->schoolcount = School::where('zone',$value->Zone_id)
                                            ->count();

             }

            $zonelocation    = Location::groupBy('zone')->get()->map(function($input){
                $input['stotal'] = School::where('zone',$input['Zone_id'])->get()->map(function($scl){
                $scl['stutotal'] = Studentinfo::where('school_id',$scl['id'])->get()->count();
                return $scl;
               })->toArray();
               $count=0;
                foreach ($input['stotal'] as $key => $value) {
                  $count = $count+ $value['stutotal'];
                }   
              $input['count']=$count;               
              return $input;
            })->toArray();

			  $schoolpart = Stcarbodypart::where('status',0)
			                ->orderby('id','ASC')
			                ->distinct('applicationid')
			                ->limit(5)->get();
			  
			  $schoolpartcount = Stcarbodypart::select("DB::RAW('distinct application_id')")
			                     ->where('status',0)->count();
			 
			
			  $manudacture=[];
			  foreach($schoolpart as $keys=>$schoolparts)
			  { 
				 $students1=Student::where('id',$schoolparts->studentidC)->first();
				  $schoolpart[$keys]->names=$students1->name??"";
				  $schoolpart[$keys]->email=$students1->studentemail??"";
				   $team= DB::table('studentTeam_Role')
                        ->where('studentid',$schoolparts->studentidC)  
                        ->first();
						 $teamname= DB::table('team_store')
                        ->where('id',$team->teamId??0)              
                         ->first();	 
					$schoolpart[$keys]->team=$teamname->team_Name??"";
				  //$manudacture[$keys]->name=$students1->name;  
			  }
			 

            
     
           //dd($data);
            }catch(\Exception $e)
            {
               return redirect()->back()->with('error','something is wrong;'); 
            }


            return view('demo',compact('vw','totalschools','totalstudents','totaltrainers','totalcoadmins','data','school','schoolpart','schoolpartcount','arr'),['zonelocation'=>$zonelocation]); 
           }
         else if($vw=='coadmin')
         {
             $zonelocation = Location::groupBy('zone')->get()->map(function($input){
               $input['stotal'] = School::where('zone',$input['Zone_id'])->get()->map(function($scl){
                $scl['stutotal'] = Studentinfo::where('school_id',$scl['id'])->get()->count();


                return $scl;
               })->toArray();
               $count=0;
                foreach ($input['stotal'] as $key => $value) {
                  $count =$count+ $value['stutotal'];
                }   
              $input['count']=$count;               
              return $input;
            })->toArray();
			  
			      $totalschools  =School::get()->count();
            //dd($totalschools);
            $totalstudents =Studentinfo::get()->count();
            //dd($totalstudents);
            $totaltrainers =Trainer::get()->count();
            //dd($totaltrainers);
            $totalcoadmins =Coadmin::get()->count();
            //dd($totalcoadmins);
             $currentdate=date('m/d/Y');
             //dd($currentdate);
            $data = Competitionstore::where('Start_Date','>=',$currentdate)->orderBy('Start_Date','ASC')->skip(0)->take(3)->get()->map(function($input){
                    $input['totalteam']=Schoolteamcomp::where('cmpid',$input['id'])->get()->count();
                            $date=date_create($input['Ragistration_Date']); 
                    $input['Ragistration_Date']=date_format($date,"d/m/Y");
                            $date=date_create($input['Start_Date']); 
                    $input['Start_Date']=date_format($date,"d/m/Y");                     
                             return $input;
                              })->toArray();

       $schoolpart=Stcarbodypart::where('status',0)->orderby('id','ASC')->distinct('applicationid')->limit(5)->get();

        $schoolpartcount=Stcarbodypart::select("DB::RAW('distinct application_id')")->where('status',0)->count();
       
      
        $manudacture=[];
        foreach($schoolpart as $keys=>$schoolparts)
        {
          
          
           $students1=Student::where('id',$schoolparts->studentidC)->first();
          $schoolpart[$keys]->names=$students1->name??"";
          $schoolpart[$keys]->email=$students1->studentemail??"";
           $team= DB::table('studentTeam_Role')
                        ->where('studentid',$schoolparts->studentidC)  
                        ->first();
             $teamname= DB::table('team_store')
                        ->where('id',$team->teamId??0)              
                         ->first();  
          $schoolpart[$keys]->team=$teamname->team_Name??"";
          //$manudacture[$keys]->name=$students1->name;
          
         
          
        }
        $email = Auth::user()->email;

       $status = Coadmin::where('email',$email)->first()->status;
       $role = Coadmin::where('email',$email)->first()->role??0;
       $rolestatus = Label::where('id',$role)->first()->status??0;
    if($role!=0&&$rolestatus!=0){
			 if($status==1||$status==2)
       {
            return view('demo',compact('vw','data','zonelocation','schoolpart','schoolpartcount'));
        }
        else
         {
           Auth::logout();  
             $request->session()->flash('danger','Your account has been disabled by Time of Sports. Kindly contact f1s@timeofsports.com');
                     return redirect('login');
         }
          }
          else
          {
             Auth::logout();  
             $request->session()->flash('danger','Your account has been disabled by Time of Sports. Kindly contact f1s@timeofsports.com');
                     return redirect('login');
          }

         }

          else if($vw=='trainer')
         {
                $zonelocation = Location::groupBy('zone')->get()->map(function($input){
                $input['stotal'] = School::where('zone',$input['Zone_id'])->get()->map(function($scl){
                $scl['stutotal'] = Studentinfo::where('school_id',$scl['id'])->get()->count();


                return $scl;
               })->toArray();
               $count=0;
                foreach ($input['stotal'] as $key => $value) {
                  $count =$count+ $value['stutotal'];
                }   
              $input['count']=$count;               
              return $input;
            })->toArray();  

            
             // //school vs plan start here
             $traineremail = Auth::user()->email;
             $trainerid =  Trainer::where('email',$traineremail)->first()->id;
              // $traineridd = Trainer::where('email',$traineremail)->first()->id;
                
                 // SchoolTrainer::where('trainer_id',10)->where('school_id',1)->delete();
               $sctr = SchoolTrainer::where('trainer_id',$trainerid)->get()->toArray()??'N/A';
               $totaltrainers = SchoolTrainer::where('trainer_id',$trainerid)->count();
            
             // //dd($trainerid);
             $arr =[];
             $schoolid = SchoolTrainer::where('trainer_id',$trainerid)->groupBy('school_id')->get()->map(function($input) {

             $input['planassignedtoschool'] = Schoolmasterplan::where('schoolid',$input['school_id'])
                                                              ->groupBy('plan')
                                                              ->get()->map(function($input) {   

                $input['planname'] = Membership::where('id',$input['plan'])->first()->name??'N/A';
                 // && isset($activities[0]trainer['course_list']
                if($input['planname']!='N.A')
                {
                  
                 $activities = Membership::where('id',$input['plan'])->select('course_list')->get()->toArray();
                  $test = $activities[0]['course_list']??0;
                  if($test!=0)
                  {
                    $countdelivered=0; 
                    $countupcoming=0;  
                  $arr = explode(',', $activities[0]['course_list']); 
                  $input['countactivities'] = count($arr);
                  $input['unassignedactivies'] = Course::whereNotIn('id',$arr)->get()->count();
                  $input['totaldelivered'] = date('Y-m-d').'___'.date('Y-m-d', strtotime($input['created_at']));
                  $input['testing'] = AssignedCoursetype::whereIN('course_masters_id',$arr)
                                                       ->where('school_id',$input['schoolid'])
                                                       ->where('Plan_id',$input['plan'])
                                                       ->get();

                      foreach($input['testing'] as $t)
                      {
                         
                        if(date('Y-m-d') > date('Y-m-d', strtotime( $t->assigneddate)))
                        {
                          $countdelivered++;
                        }
                        else
                        {
                          $countupcoming++;
                        }

                      }

                    }   
                    else{                               
                  $input['countactivities'] = 0;
                   $input['unassignedactivies'] = 0;
                   $input['totaldelivered'] = 0;
                    $input['testing'] = 0;
                    $countdelivered=0; 
                    $countupcoming=0;
                     $arr =0; 
                  }
                  $input['tstudents'] = participatestudent::where('schoolid',$input['schoolid'])
                                                         ->where('planid',$input['plan'])
                                                         ->select('student_id','created_at')
                                                         ->get()->count();

                        
              

                    
                  
              $input['countdelivered']=$countdelivered; 
              $input['upcomingactivities']=$countupcoming;    
            }  
            else
            {
              $input['countactivities'] = 'N/A';
               $input['unassignedactivies'] = 'N/A';
               $input['totaldelivered'] = 'N/A';
               $input['testing'] = 'N/A';
               $input['tstudents'] = 'N/A';
               $input['countdelivered'] = 'N/A';
               $input['upcomingactivities'] = 'N/A';
               $arr =0;
            }                                                                       
                    return $input;
                  });
                                         
              
              $input['schoolname']=School::where('id',$input['school_id'])->first()->school_name;
                                                                    
              return $input;
               
             });
            // dd($schoolid->toArray());
            //school vs plan end here

             $schoolpart=[];
      		   $school =[];
      		
              $trainerid = Auth::user()->email;
          
               // $status1=School::where('email',$email)->first();

          $arr=[];
            if($sctr!='N/A')
            {
            	$schoolidd = array_column($sctr, 'school_id');
            	// dd($schoolidd);
                       $currentdate=date('m/d/Y');
			        $currentdate1=date('m/d/Y',strtotime('-1 month'));
            	       $compbyteam= $data = Competitionstore::where('Start_Date','>=',$currentdate1)->orderBy('Start_Date','ASC')->get()->map(function($data){
					        return $data->id;
				         })->toArray();
			
				 	      $comp=DB::table('schoolteamcomp')->select('school_id')->whereIN('school_id',$schoolidd)->whereIN('cmpid', $compbyteam)->get()->toArray()??0;
				 	      if($comp==0)
				 	      {
                           $comp = 0;
				 	      }
				 	      else
				 	      {
                            $comp = count(array_unique(array_column($comp, 'school_id'))); 
				 	      }
				 	     
				
					      $compbyteam= $data = Competitionstore::where('Start_Date','>=',$currentdate1)->orderBy('Start_Date','ASC')->get();
					 
					     
					
        			 foreach($compbyteam as $key=>$compbyteams)
        			 {
        				 $arr[$key]['comp']=$compbyteams->Competition_name;
        				 $arr[$key]['count']=Schoolteamcomp::where('cmpid',$compbyteams->id)->whereIN('school_id',$schoolidd)->count();
        			 }
                    $totalstudents =Studentinfo::whereIN('school_id',$schoolidd)->count();
                     $schoolpart = Stcarbodypart::where('status',0)->whereIN('schoolidC',$schoolidd)
                                ->orderby('id','ASC')
                                ->distinct('applicationid')
                                ->limit(5)
                                ->get();
                               
                             
                     $schoolpartcount = Stcarbodypart::select("DB::RAW('distinct application_id')")->whereIN('schoolidC',$schoolidd)->where('status',0)->count();

                  $manudacture=[];
      			  foreach($schoolpart as $keys=>$schoolparts)
      			  {
      				  
      				  
      				  $students1=Student::where('id',$schoolparts->studentidC)->first();
      				  $schoolpart[$keys]->names=$students1->name??"";
      				  $schoolpart[$keys]->email=$students1->studentemail??"";
      				  $team= DB::table('studentTeam_Role')
                              ->where('studentid',$schoolparts->studentidC)
                           
      						
                              ->first();
      						
      						 $teamname= DB::table('team_store')
                              ->where('id',$team->teamId??0)
                           
      						
                               ->first();
      						 
      					$schoolpart[$keys]->team=$teamname->team_Name??"";
      				  //$manudacture[$keys]->name=$students1->name;
      				  $year=date('Y');
      				  $nextyear=date('Y')+1;
      				  $tt=$year.'-'.''.$nextyear;
      				  
      				  $schoolplan = DB::table('schoolplanmaster')->whereIN('schoolid',$schoolidd)->where('year',$tt)->get()->toArray()??0;	

      				   if($schoolplan==0)
				 	      {
                           $schoolplan = 0;
				 	      }
				 	      else
				 	      {
                            $schoolplan = count(array_unique(array_column($schoolplan, 'plan'))); 
				 	      }
      				 		 
      				  
      			    }
            }
            else
            {
            	$school =[];
            	$schoolpartcount = 0;

            }	
              
                  
               

              
            

                 
            $status=Trainer::where('email',$trainerid)->first()->status;
            
            
            // **************************

            // *****************************
               if($status==1)
               { 
                 return view('demo',compact('vw','schoolpartcount','schoolpart','school','arr','zonelocation','schoolid','trainerid','totalstudents','comp','schoolplan','totaltrainers'));
               }
               else
               {
                      Auth::logout();  
                      $request->session()->flash('danger','Your account has been disabled by Time of Sports. Kindly contact f1s@timeofsports.com');
                     return redirect('login'); 
               }

         }
        else if($vw=='school')
         {

               $schoolvsplan=[];
               $zonelocation = Location::groupBy('zone')->get()->map(function($input){
               $input['stotal'] = School::where('zone',$input['Zone_id'])->get()->map(function($scl){
               $scl['stutotal'] = Studentinfo::where('school_id',$scl['id'])->get()->count();


                return $scl;
               })->toArray();
               $count=0;
                foreach ($input['stotal'] as $key => $value) {
                  $count =$count+ $value['stutotal'];
                }   
              $input['count']=$count;               
              return $input;
               })->toArray();
		
             $schoolpartcount=0;
      			 $schoolpart=[];
      			 $school=[];
      			 $arr=[];
              $email=Auth::user()->email;
			       

			        $currentdate=date('m/d/Y');
			        $currentdate1=date('m/d/Y',strtotime('-1 month'));
			 
              $status1=School::where('email',$email)->first();

              $scid = $status1->id;
              $year = Login_Academic_Year::where('school',$scid)
                      ->first()->academicyear??'N/A';
                    
            
              /*Open Competions */
              // $year = '2021-2022';

              $currentdate=date('m/d/Y');
              $currentdate1=date('m/d/Y',strtotime('-1 month'));
              $data = Competitionstore::where('Start_Date','>=',$currentdate)
                    ->where('academicyear',$year)
                    ->orderBy('Start_Date','ASC')
                    ->skip(0)->take(3)
                    ->get()
                    ->map(function($input)use($scid){
                        $input['totalteam']=Schoolteamcomp::where('cmpid',$input['id'])
                        ->where('school_id',$scid)->get()->count();
                            $date=date_create($input['Ragistration_Date']); 
                        $input['Ragistration_Date']=date_format($date,"d/m/Y");
                            $date=date_create($input['Start_Date']); 
                        $input['Start_Date']=date_format($date,"d/m/Y");                     
                             return $input;
                              })->toArray();

                $select_comp = Competitionstore::
                                select('id')
                               ->where('academicyear',$year)
                               ->get()->toArray();
              $last_names = array_column($select_comp, 'id');
              
              $SchoolCompTeam = Schoolteamcomp::select('school_id','cmpid')
                                      ->where('school_id',$scid)
                                      ->whereIN('cmpid',$last_names)
                                      ->groupBy('cmpid')
                                      ->get();

                // print_r($SchoolCompTeam);

                


                    foreach ($SchoolCompTeam as $key => $value) {
                       $SchoolCompTeam[$key]['TotalTeam'] =  Schoolteamcomp::where('cmpid',$value->cmpid)
                                                             ->where('school_id',$value->school_id)->count();
                      $SchoolCompTeam[$key]['competitionName'] =  Competitionstore::
                                                                 where('id',$value->cmpid)
                                                                 ->where('academicyear',$year)
                                                                ->first()->Competition_name;
                      $SchoolCompTeam[$key]['openDate'] =  Competitionstore::
                                                                 where('id',$value->cmpid)
                                                                 ->where('academicyear',$year)
                                                                ->first()->Start_Date;

                    }

                   // dd($SchoolCompTeam);
                    /*End Competiotns*/




			         $status=$status1->status;
			         $totalstudents =Studentinfo::where('school_id',$status1->id)->count();
				       $totaltrainers = DB::table('school_trainer')
                               ->where('school_id',$status1->id)
                               ->where('year',$year)
                               ->count();
			
				       $compbyteam = $data = Competitionstore::
                        where('Start_Date','>=',$currentdate1)
                        ->where('academicyear',$year)
                        ->orderBy('Start_Date','ASC')->get()->map(function($data){
					            return $data->id;
				         })->toArray();
			     
           $comp = Competitionstore::
                    where('academicyear',$year)
                    ->count();
				 	      // $comp=DB::table('schoolteamcomp')->where('school_id',$status1->id)->whereIN('cmpid', $compbyteam)->count();
					 
					      $compbyteam= $data = Competitionstore::
                     where('Start_Date','>=',$currentdate1)
                      ->where('academicyear',$year)
                     ->orderBy('Start_Date','ASC')->get();
					
        			 foreach($compbyteam as $key=>$compbyteams)
        			 {
        				 $arr[$key]['comp']=$compbyteams->Competition_name;
        				 $arr[$key]['count']=Schoolteamcomp::where('cmpid',$compbyteams->id)->where('school_id',$status1->id)->count();
        			 }
			         $schoolpart=Stcarbodypart::where('status',0)->where('schoolidC',$status1->id)->orderby('id','ASC')->distinct('applicationid')->limit(5)->get();
			  
			         $schoolpartcount=Stcarbodypart::select("DB::RAW('distinct application_id')")->where('schoolidC',$status1->id)->where('status',0)->count();
			 
      			
      			  $manudacture=[];
      			  foreach($schoolpart as $keys=>$schoolparts)
      			  {
      				  
      				  
      				  $students1=Student::where('id',$schoolparts->studentidC)->first();
      				  $schoolpart[$keys]->names=$students1->name??"";
      				  $schoolpart[$keys]->email=$students1->studentemail??"";
      				  $team= DB::table('studentTeam_Role')
                              ->where('studentid',$schoolparts->studentidC)
                           
      						
                              ->first();
      						
      						 $teamname= DB::table('team_store')
                              ->where('id',$team->teamId??0)
                           
      						
                               ->first();
      						 
      					$schoolpart[$keys]->team=$teamname->team_Name??"";
      				  //$manudacture[$keys]->name=$students1->name;
      				  $year=date('Y');
      				  $nextyear=date('Y')+1;
      				  $tt=$year.'-'.''.$nextyear;
      				  
      				  $schoolplan = DB::table('schoolplanmaster')
                     ->where('schoolid',$status1->id)
                       ->where('year',$year)->count();				 
      				  
      			    }
           

             // //school vs plan start here
             $schoolemail=Auth::user()->email;
              
              $schoolvsplan= School::where('email',$schoolemail)->get()->map(function($input)use($year){
                 $input['planassignedtoschool']=Schoolmasterplan::
                                             where('schoolid',$input['id'])
                                             ->where('year',$year)
                                             ->get()->map(function($input){
                     $test1 = Membership::where('id',$input['plan'])
                             ->where('academicyear',$year)
                             ->first()->name??'N/A';
                      if($test1!='N/A')
                      {
                      $input['planname'] = $test1;
                     $activities = Membership::where('id',$input['plan'])
                                ->where('academicyear',$year)
                                 ->select('course_list')->get()->toArray();
                      $test2 = $activities[0]['course_list']??0;
                      if($test2!=0)
                      {
                           $arr= explode(',', $activities[0]['course_list']);          
                     $input['countactivities']=count($arr);                                             
                     $input['unassignedactivies']=Course::whereNotIn('id',$arr)->get()->count();
                     $input['testing']=AssignedCoursetype::whereIN('course_masters_id',$arr)
                                                       ->where('acyear',$year)
                                                       ->where('school_id',$input['schoolid'])
                                                       ->where('Plan_id',$input['plan'])
                                                       ->get(); 

                    $countdelivered=0; 
                    $countupcoming=0; 
                       foreach($input['testing'] as $t)
                      {
                         
                        if(date('Y-m-d') > date('Y-m-d', strtotime( $t->assigneddate)))
                        {
                          $countdelivered++;
                        }
                        else
                        {
                          $countupcoming++;
                        }

                      }
                     $input['countdelivered']=$countdelivered; 
                     $input['upcomingactivities']=$countupcoming;

                       }
                       
                                                   


                      }
                      else
                      {
                           $input['planname'] = $test1;
                     // $activities=Membership::where('id',$input['plan'])->select('course_list')->get()->toArray();
                     //       $arr= explode(',', $activities[0]['course_list']);          
                     $input['countactivities'] = 'N/A';                                             
                     $input['unassignedactivies']= 'N/A';
                     $input['testing']= 'N/A'; 
                      }                                 

                     $input['tstudents']=participatestudent::where('schoolid',$input['schoolid'])                                ->where('year',$year)
                                                         ->where('planid',$input['plan'])
                                                         ->select('student_id','created_at')
                                                         ->get()->count();
 
                                        return $input;
                                         });
                     $input['schoolname']=School::where('id',$input['id'])->first()->school_name;
                                                               
                  return $input;
              });

          
            //school vs plan end here 

               if($status==1)
               { 
                 return view('demo',compact('vw','schoolpartcount','schoolpart','school','arr','totalstudents','totaltrainers','comp','arr','schoolplan','zonelocation','schoolvsplan','SchoolCompTeam'));
               }
               else
               {
                      Auth::logout();  
                      $request->session()->flash('danger','Dear School Your Account has been disabled Contact  to TOS');
                     return redirect('login'); 
               }
			   
      			   $schoolpart=Stcarbodypart::where('status',0)->orderby('id','ASC')->where('schoolidC',$status1->id)->distinct('applicationid')->limit(5)->get();
      			  
      			  $schoolpartcount=Stcarbodypart::select("DB::RAW('distinct application_id')")->where('schoolidC',$status1->id)->where('status',0)->count();
			
			
        			  $manudacture=[];
        			  foreach($schoolpart as $keys=>$schoolparts)
        			  {
        				  
        				  
        				   $students1=Student::where('id',$schoolparts->studentidC)->first();
        				  $schoolpart[$keys]->names=$students1->name??"";
        				  $schoolpart[$keys]->email=$students1->studentemail??"";
        				   $team= DB::table('studentTeam_Role')
                                ->where('studentid',$schoolparts->studentidC)

                                ->first();
        						
        						 $teamname= DB::table('team_store')
                                ->where('id',$team->teamId??0)
                             
        						
                                 ->first();
        						 
        					$schoolpart[$keys]->team=$teamname->team_Name??"";
        				  //$manudacture[$keys]->name=$students1->name;
        				  
        				 
        				  
        			  }
			 
         }

       else if($vw=='manufacturer')
         {
             $zonelocation = Location::groupBy('zone')->get()->map(function($input){
               $input['stotal'] = School::where('zone',$input['Zone_id'])->get()->map(function($scl){
                $scl['stutotal'] = Studentinfo::where('school_id',$scl['id'])->get()->count();


                return $scl;
               })->toArray();
               $count=0;
                foreach ($input['stotal'] as $key => $value) {
                  $count =$count+ $value['stutotal'];
                }   
              $input['count']=$count;               
              return $input;
            })->toArray();

            return view('demo',compact('vw','zonelocation'));
         }

        if($vw=='null')
        {
          
        Auth::logout();  
        $request->session()->flash('danger','Permission Denied Please Check Your Url...');
        return redirect('login');  
         }
        else
        {
                  
        Auth::logout();  
        $request->session()->flash('danger','Permission Denied Please Check Your Url...');
        return redirect('login'); 
        }


     
    }
    public function selector()
    {


        $ab=Auth::user()->role;
		

        switch($ab){
            case 1:
                return 'admin';
                break;
            case 2:
                return 'coadmin';
                break;
            case 3:
            return 'trainer';
            break;
                case 4:
                return 'school';
                break;

               // case 5:
               //  return 'student';
               //  break;    

            case 6:
               return 'manufacturer';
               break;
            
            default: 
        
                return 'null';

        }

    }

    public function coadmins()
    {
      
     
        return view('home');
    }


    public function downloadtrainervsplan($id)
    { 

             $trainerid= base64_decode($id);
             $schoolid=SchoolTrainer::where('trainer_id',$trainerid)->get()->map(function($input) {

             $input['planassignedtoschool']=Schoolmasterplan::where('schoolid',$input['school_id'])
                                                              ->get()->map(function($input) {      
                 $input['planname']=Membership::where('id',$input['plan'])->first()->name;
                 $activities=Membership::where('id',$input['plan'])->select('course_list')->get()->toArray();
                           $arr= explode(',', $activities[0]['course_list']);          
                  $input['countactivities']=count($arr);
                  $input['unassignedactivies']=Course::whereNotIn('id',$arr)->get()->count();
                  $input['totaldelivered']=date('Y-m-d').'___'.date('Y-m-d', strtotime($input['created_at']));
                  $input['testing']=AssignedCoursetype::whereIN('course_masters_id',$arr)
                                                       ->where('school_id',$input['schoolid'])
                                                       ->where('Plan_id',$input['plan'])
                                                       ->get();
                   
                  $input['tstudents']=participatestudent::where('schoolid',$input['schoolid'])
                                                         ->where('planid',$input['plan'])
                                                         ->select('student_id','created_at')
                                                         ->get()->count();

                    $countdelivered=0; 
                    $countupcoming=0;      
              

                      foreach($input['testing'] as $t)
                      {
                         
                        if(date('Y-m-d') > date('Y-m-d', strtotime( $t->assigneddate)))
                        {
                          $countdelivered++;
                        }
                        else
                        {
                          $countupcoming++;
                        }

                      }
                  
              $input['countdelivered']=$countdelivered; 
              $input['upcomingactivities']=$countupcoming;                                                                            
                    return $input;
                  });
                                         
              
              $input['schoolname']=School::where('id',$input['school_id'])->first()->school_name;
                                      
                   
                    $countdelivered=0; 
                    $countupcoming=0;      
              
                   foreach ($input['planassignedtoschool'] as $k)
                   { 
                      foreach($k->testing as $t)
                      {
                         
                        if(date('Y-m-d') > date('Y-m-d', strtotime( $t->assigneddate)))
                        {
                          $countdelivered++;
                        }
                        else
                        {
                          $countupcoming++;
                        }

                      }
                   
               

                   }      
              $input['countdelivered']=$countdelivered; 
              $input['upcomingactivities']=$countupcoming;                                             
              return $input;
               
             });
            //dd($schoolid->toArray());
            //school vs plan end here



      if(count($schoolid)>0)
      {     $key1=0;
          foreach($schoolid as $key => $value)
          {  
            foreach($value->planassignedtoschool as $p)
            {
              $arr[$key1]["School Name"]            =           $value->schoolname;
              $arr[$key1]["Plan Name"]              =           $p->planname;
              $arr[$key1]["Total Session"]          =           $p->countactivities;
              $arr[$key1]["Total Delivered"]        =           $p->countdelivered;
              $arr[$key1]["Not Assigned"]           =           $p->unassignedactivies;
              $arr[$key1]["Upcoming Activities"]    =           $p->upcomingactivities;
              $arr[$key1]["Total Student"]          =           $p->tstudents;
              $key1++;
            }
              $key1++;
          }
          //dd($arr);
          ob_end_clean(); // this
          ob_start();
           return Excel::create('SchoolVsPlan', function($excel) use ($arr) {
              $excel->sheet('Sheet', function($sheet) use ($arr)
              {
                  $sheet->cell('A1:G1', function($cell) {
                  $cell->setFontWeight('bold');

                  });
               
                  $sheet->fromArray($arr,null,'A1',true);
              });
          })->download('xlsx');
          
      }

    }

    public function downloadschoolvsplan($id)
    {
             // //school vs plan start here
             $schoolemail=Auth::user()->email;
             
              $schoolvsplan= School::where('email',$schoolemail)->get()->map(function($input){
                 $input['planassignedtoschool']=Schoolmasterplan::where('schoolid',$input['id'])
                                                                ->get()->map(function($input){
                        $check = Membership::where('id',$input['plan'])->first()->name??'N/A';
                        if($check!='N/A')
                        {                                         
                     $input['planname']= $check;
                     $activities=Membership::where('id',$input['plan'])->select('course_list')->get()->toArray();
                        $r =  $activities[0]['course_list']??0;
                         if($r!=0)
                         {
                           $arr= explode(',', $activities[0]['course_list']);          
                         
                     $input['countactivities']=count($arr);                                             
                     $input['unassignedactivies']=Course::whereNotIn('id',$arr)->get()->count();
                     $input['testing']=AssignedCoursetype::whereIN('course_masters_id',$arr)
                                                       ->where('school_id',$input['schoolid'])
                                                       ->where('Plan_id',$input['plan'])
                                                       ->get();
                        }
                        else
                        {

                $input['countactivities']=0;                                             
                     $input['unassignedactivies']=0;
                     $input['testing']=0; 
                     $input['tstudents']=0;

                        }

                     $input['tstudents']=participatestudent::where('schoolid',$input['schoolid'])
                                                         ->where('planid',$input['plan'])
                                                         ->select('student_id','created_at')
                                                         ->get()->count();
                    $countdelivered=0; 
                    $countupcoming=0; 
                      foreach($input['testing'] as $t)
                      {
                         
                        if(date('Y-m-d') > date('Y-m-d', strtotime( $t->assigneddate)))
                        {
                          $countdelivered++;
                        }
                        else
                        {
                          $countupcoming++;
                        }

                      }
                     $input['countdelivered']=$countdelivered; 
                     $input['upcomingactivities']=$countupcoming;

         }
         else
          {
             $input['planname']= $check;
                $input['countactivities']='N/A';                                             
                     $input['unassignedactivies']='N/A';
                     $input['testing']='N/A'; 
                     $input['tstudents']='N/A';

          }
                                        return $input;
                                         });
                     $input['schoolname']=School::where('id',$input['id'])->first()->school_name;
                                                               
                  return $input;
              });
              //$traineridd= Trainer::where('email',$traineremail)->first()->id;
            // dd($schoolvsplan); 
            
            //dd($schoolid->toArray());
            //school vs plan end here

                 if(count($schoolvsplan)>0)
      {     $key1=0;
          foreach($schoolvsplan as $key => $value)
          {  
            foreach($value->planassignedtoschool as $p)
            {
              $arr[$key1]["School Name"]            =           $value->schoolname;
              $arr[$key1]["Plan Name"]              =           $p->planname;
              $arr[$key1]["Total Session"]          =           $p->countactivities;
              $arr[$key1]["Total Delivered"]        =           $p->countdelivered;
              $arr[$key1]["Not Assigned"]           =           $p->unassignedactivies;
              $arr[$key1]["Upcoming Activities"]    =           $p->upcomingactivities;
              $arr[$key1]["Total Student"]          =           $p->tstudents;
              $key1++;
            }
              $key1++;
          }
          //dd($arr);
          ob_end_clean(); // this
          ob_start();
           return Excel::create('SchoolVsPlan', function($excel) use ($arr) {
              $excel->sheet('Sheet1', function($sheet) use ($arr)
              {
                  $sheet->cell('A1:G1', function($cell) {
                  $cell->setFontWeight('bold');

                  });
               
                  $sheet->fromArray($arr,null,'A1',true);
              });
          })->download('xlsx');
          
      }

    }


}
