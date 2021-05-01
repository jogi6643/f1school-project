<?php
namespace App\Http\Controllers\admin\Team;

use App\Competition;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Model\SchoolTrainer;
use App\Model\Trainer;
use App\School;
use App\Studentinfo;
use DB;
use Mail;
use Alert;
use App\Model\AssignedCoursetype;
use App\Schoolmasterplan;
use App\Participatestudent;
use App\Location;
use Maatwebsite\Excel\Facades\Excel;
use App\Model\StudentModel\Team_Store;
use App\Model\StudentModel\StudentTeam_Role;
use App\Model\Competition\Schoolteamcomp;
use App\Model\Competition\Competitionstore;
use App\Model\Payment;
use App\Model\Manufacture\Orederstaus;
use App\Model\Sponser\SponserShip;
use App\Model\UploadDocument;
use App\Model\TeamBlock;
use App\Model\Cartdetail;


class TeamController extends Controller
{

    public function teamviewadd(Request $req)
    {
		
		           if(Auth::user()->role==1)
					{
						
					}
					else
					{
					 
					  if(!isset($req->session()->all()['data']))
						{
							$req->session()->flash('status','You do not have right to access this module');
							
							return redirect('/');
						}		 
					}
			
                   $creator = Team_Store::where('student_id', "1_admin")->get();
                   
                       if(count($creator)!=0)
                       {
                       foreach($creator as $creator){
                        $co = Schoolteamcomp::where('tmpid', $creator->id)->orderby('id','desc')
                            ->first();
   
                        if ($co != null)
                        {
                            $idd = $co->cmpid;
                            $admin[] = StudentTeam_Role::where('teamId', $creator->id)
                                ->get()->map(function ($data) use ($idd)
                            {
                                $data->teamCreator = 'Admin';
                                $data->competitionname = Competitionstore::find($idd)->Competition_name;
                                $data->Regionname = Competitionstore::find($idd)->levelnameid;
                                $data->compStartdate = Competitionstore::find($idd)->Start_Date;
                                $data->competionid = $idd;
								 $data->phone = isset(Studentinfo::find($data->studentid)->mobileno) ? Studentinfo::find($data->studentid)->mobileno : 'N/A';
								
								 	 $data->studentemail = isset(Studentinfo::find($data->studentid)->studentemail) ? Studentinfo::find($data->studentid)->studentemail : 'N/A';
								 
                                $data->teams_name = Team_Store::find($data->teamId)->team_Name;
                                $data->studentname = Studentinfo::find($data->studentid)->name;
                                $data->schname = School::find($data->schoolid)->school_name;
                                return $data;

                            })->toArray();
         
                          }
                          else
                          {
                          $admin[] = StudentTeam_Role::where('teamId', $creator->id)
                               ->get()->map(function ($data)
                            {
                                $data->teamCreator = 'Admin';
                                $data->competitionname = 'N/A';
                                $data->Regionname = 'N/A';
								 $data->phone = isset(Studentinfo::find($data->studentid)->mobileno) ? Studentinfo::find($data->studentid)->mobileno : 'N/A';
								
								 	 $data->studentemail = isset(Studentinfo::find($data->studentid)->studentemail) ? Studentinfo::find($data->studentid)->studentemail : 'N/A';
								 
                                $data->compStartdate = 'N/A';
                                $data->competionid = 'N/A';
                                $data->teams_name = Team_Store::find($data->teamId)->team_Name;
                                $data->studentname = Studentinfo::find($data->studentid)->name;
                                $data->schname = School::find($data->schoolid)->school_name;
                                return $data;
                            })->toArray();
                           }


                        }
                    }
                 else
                 {
                    $admin=[];
                 }


                 $tr = Team_Store::where('student_id',  'LIKE', '%_trainer%')->get();
   

                 if(count($tr)!=0)
                 {
                    foreach ($tr as $key => $tr1) {
                      
                       
                    $co = Schoolteamcomp::where('tmpid', $tr1->id)
                            ->first();
                      
                        if ($co != null)
                        {
                            $idd = $co->cmpid;
                            $trainer[] = StudentTeam_Role::where('teamId', $tr1->id)
                                ->get()->map(function ($data) use ($idd)
                            {
                                $data->teamCreator = 'Trainer';
                                $data->competitionname = Competitionstore::find($idd)->Competition_name;
                                $data->Regionname = Competitionstore::find($idd)->levelnameid;
                                $data->compStartdate = Competitionstore::find($idd)->Start_Date;
								 $data->phone = isset(Studentinfo::find($data->studentid)->mobileno) ? Studentinfo::find($data->studentid)->mobileno : 'N/A';
								
								 	 $data->studentemail = isset(Studentinfo::find($data->studentid)->studentemail) ? Studentinfo::find($data->studentid)->studentemail : 'N/A';
								 
                                $data->competionid = $idd;
                                $data->teams_name = Team_Store::find($data->teamId)->team_Name;
                                $data->studentname = Studentinfo::find($data->studentid)->name;
                                $data->schname = School::find($data->schoolid)->school_name;
                                return $data;

                            })->toArray();


                             
                        }
                        else
                        {
                        $user=[];
                        $trainer[] = StudentTeam_Role::where('teamId', $tr1->id)
                             ->get()->map(function ($data) use ($user)
                            {
                                $data->teamCreator = 'Trainer';
                                $data->competitionname = 'N/A';
                                $data->Regionname = 'N/A';
                                $data->compStartdate = 'N/A';
								  $data->phone = isset(Studentinfo::find($data->studentid)->mobileno) ? Studentinfo::find($data->studentid)->mobileno : 'N/A';
								
								 	 $data->studentemail = isset(Studentinfo::find($data->studentid)->studentemail) ? Studentinfo::find($data->studentid)->studentemail : 'N/A';
								 
                                $data->competionid = 'N/A';
                                $data->teams_name = Team_Store::find($data->teamId)->team_Name??'N/A';
                                $data->studentname = Studentinfo::find($data->studentid)->name??'N/A';
                                $data->schname = School::find($data->schoolid)->school_name;

                                return $data;
                            })->toArray();

                            

                        }

                   
                    }
                 }
                 else
                  {

                 
                      $trainer=[];
                     
                  }  
   
        $ts = Team_Store::get();
       
        if (count($ts) > 0)
        {
                 


            foreach ($ts as $key => $type1)
            {
            
                $ids = explode('_', $type1->student_id);
                
                
                if(isset($ids[1]) && isset($ids[0]))
                {
                $user = $ids[0];    
                $type = $ids[1];
                switch ($type)
                {
                    case 'student':

                        $creator = Team_Store::where('student_id', $user . "_" . $type)->first();
                        $co = Schoolteamcomp::where('tmpid', $creator->id)
                            ->first();

                        if ($co != null)
                        {

                            $idd = $co->cmpid;

                            $student[] = StudentTeam_Role::where('teamId', $creator->id)
                                ->get()->map(function ($data) use ($user, $idd)
                            {
								
                                $data->teamCreator = isset(Studentinfo::find($user)->name) ? Studentinfo::find($user)->name : 'N/A';
								 $data->phone = isset(Studentinfo::find($data->studentid)->mobileno) ? Studentinfo::find($data->studentid)->mobileno : 'N/A';
								
								 	 $data->studentemail = isset(Studentinfo::find($data->studentid)->studentemail) ? Studentinfo::find($data->studentid)->studentemail : 'N/A';
								 
                                $data->competitionname = Competitionstore::find($idd)->Competition_name;
                                $data->Regionname = Competitionstore::find($idd)->levelnameid;
                                $data->compStartdate = Competitionstore::find($idd)->Start_Date;
                                $data->competionid = $idd;
                                $data->teams_name = Team_Store::find($data->teamId)->team_Name;

                                $data->studentname = Studentinfo::find($data->studentid)->name;
                                $data->schname = School::find($data->schoolid)->school_name;
                                return $data;

                            })->toArray();

                        }
                        else
                        {


                            $student[] = StudentTeam_Role::where('teamId', $creator->id)
                                ->get()->map(function ($data) use ($user)
                            {
                                $data->teamCreator = Studentinfo::find($user)->name;
                                $data->competitionname = 'N/A';
                                $data->Regionname = 'N/A';
                                $data->compStartdate = 'N/A';
                                $data->competionid = 'N/A';
                                $data->teams_name = Team_Store::find($data->teamId)->team_Name;
                                $data->studentname = Studentinfo::find($data->studentid)->name;
                                $data->schname = School::find($data->schoolid)->school_name;
								 $data->phone = isset(Studentinfo::find($data->studentid)->mobileno) ? Studentinfo::find($data->studentid)->mobileno : 'N/A';
								
								 	 $data->studentemail = isset(Studentinfo::find($data->studentid)->studentemail) ? Studentinfo::find($data->studentid)->studentemail : 'N/A';
								 
                                return $data;
                            })->toArray();

                        }

                    break;
                  
                }

            }
        }

        }
       // $trainer = $trainer->toArray(); 
       
   
      $participate = array_merge($admin,$student,$trainer);
    
        return view('admin.Team.teamList', compact('participate'));
    }


// View Page Team

    public function viewteampage($teamid,Request $req)
    {
		  
		if(Auth::user()->role==1)
			{
				
			}
			else
			{
			 
			  if(!isset($req->session()->all()['data'][14]))
				{
					$req->session()->flash('status','You do not have right to access this module');
					
					return redirect('/');
				}		 
			}
        $tid = base64_decode($teamid);
        

        $ts = Team_Store::where('id',$tid)->first();
          
       
        if ($ts == null)
        {
            echo 'No Data available';
        }
        else
        {
            $usertype = $ts->student_id;

            $ids = explode('_', $usertype);

            $user = $ids[0];
            $type = $ids[1];
            $schoolinfo = School::where('id',$ts->school_id)->first();
            
               switch ($type)
                {
                    case 'student':

                        $creator = Team_Store::where('student_id', $user . "_" . $type)->where('id',$tid)->first();
                        $co = Schoolteamcomp::where('tmpid', $creator->id)->orderby('id','desc')
                            ->first();
                           
                        
                        if ($co != null)
                        {

                            $idd = $co->cmpid;
                            $deatials[] = StudentTeam_Role::where('teamId', $creator->id)
                                ->get()->map(function ($data) use ($user, $idd)
                            {
                                $data->teamCreator = isset(Studentinfo::find($user)->name) ? Studentinfo::find($user)->name : 'N/A';
                                $data->competitionname = Competitionstore::find($idd)->Competition_name;
                                $data->Regionname = Competitionstore::find($idd)->levelnameid;
                                $data->compStartdate = Competitionstore::find($idd)->Start_Date;
                                $data->competionid = $idd;
                                $data->teams_name = Team_Store::find($data->teamId)->team_Name;
                                $data->comp=Schoolteamcomp::
                                            groupBy('cmpid')
                                            ->where('tmpid',$data->teamId)
                                            ->get()
                                            ->map(function($c){
                                                $c->cname=Competitionstore::
                                                where('id',$c->cmpid)->get();
                                                return $c;
                                            });
                                         
                             
                                $data->studentname = Studentinfo::find($data->studentid)->name;
                                  $data->studentemail = Studentinfo::find($data->studentid)->studentemail;
                                $data->class = Studentinfo::find($data->studentid)->class;
                                 $data->mobileno = Studentinfo::find($data->studentid)->mobileno;
                                $data->schname = School::find($data->schoolid)->first()->id;
                                return $data;

                            })->toArray();

                

                        }
                        else
                        {

                            $deatials[] = StudentTeam_Role::where('teamId', $creator->id)
                                ->get()->map(function ($data) use ($user)
                            {
                                $data->teamCreator = Studentinfo::find($user)->name;
                                $data->competitionname = 'N/A';
                                $data->Regionname = 'N/A';
                                $data->compStartdate = 'N/A';
                                $data->competionid = 'N/A';

                                $data->comp='N/A';
                                $data->teams_name = Team_Store::find($data->teamId)->team_Name;
                                $data->studentname = Studentinfo::find($data->studentid)->name;
                                $data->class = Studentinfo::find($data->studentid)->class;
                                 $data->mobileno = Studentinfo::find($data->studentid)->mobileno;
                                  $data->studentemail = Studentinfo::find($data->studentid)->studentemail;
                                $data->schname = School::find($data->schoolid)->first();
                                return $data;
                            })->toArray();

                        }

                    break;
                    case 'admin':
					
                        $creator = Team_Store::where('student_id', $user . "_" . $type)->where('id',$tid)->first();
						
                        $co = Schoolteamcomp::where('tmpid', $creator->id)->orderby('id','desc')
                            ->first();

                        if ($co != null)
                        {
                            $idd = $co->cmpid;
                            $deatials[] = StudentTeam_Role::where('teamId', $creator->id)
                                ->get()->map(function ($data) use ($user, $idd)
                            {
                                $data->teamCreator = 'Admin';
                                $data->competitionname = Competitionstore::find($idd)->Competition_name;
                                $data->Regionname = Competitionstore::find($idd)->levelnameid;
                                $data->compStartdate = Competitionstore::find($idd)->Start_Date;
                                $data->competionid = $idd;

                                $data->comp=Schoolteamcomp::
                                            groupBy('cmpid')
                                            ->where('tmpid',$data->teamId)
                                            ->get()
                                            ->map(function($c){
                                                $c->cname=Competitionstore::
                                                where('id',$c->cmpid)->get();
                                                return $c;
                                            });
                                $data->teams_name = Team_Store::find($data->teamId)->team_Name;
                                $data->studentname = Studentinfo::find($data->studentid)->name;
                                 $data->studentemail = Studentinfo::find($data->studentid)->studentemail;
                                $data->class = Studentinfo::find($data->studentid)->class;
                                 $data->mobileno = Studentinfo::find($data->studentid)->mobileno;
                                $data->schname = School::find($data->schoolid)->first();
                                return $data;

                            })->toArray();

                        }
                        else
                        {

                            $deatials[] = StudentTeam_Role::where('teamId', $creator->id)
                                ->get()->map(function ($data) use ($user)
                            {
                                $data->teamCreator = 'Admin';
                                $data->competitionname = 'N/A';
                                $data->Regionname = 'N/A';
                                $data->compStartdate = 'N/A';
                                $data->competionid = 'N/A';
                                $data->comp='N/A';
                                $data->teams_name = Team_Store::find($data->teamId)->team_Name;
                                $data->studentname = Studentinfo::find($data->studentid)->name;
                                $data->class = Studentinfo::find($data->studentid)->class;
                                 $data->mobileno = Studentinfo::find($data->studentid)->mobileno;
                                  $data->studentemail = Studentinfo::find($data->studentid)->studentemail;
                                $data->schname = School::find($data->schoolid)->first();

                                return $data;
                            })->toArray();

                        }

                    break;
                    case 'trainer':
                  
                        $creator = Team_Store::where('student_id', $user . "_" . $type)->where('id',$tid)->first();
                         
                        $co = Schoolteamcomp::where('tmpid', $creator->id)->orderby('id','desc')
                            ->first();

                        if ($co != null)
                        {
                            $idd = $co->cmpid;
                            $deatials[] = StudentTeam_Role::where('teamId', $creator->id)
                                ->get()->map(function ($data) use ($user, $idd)
                            {
                                $data->teamCreator = 'Trainer';
                                $data->competitionname = Competitionstore::find($idd)->Competition_name;
                                $data->Regionname = Competitionstore::find($idd)->levelnameid;
                                $data->compStartdate = Competitionstore::find($idd)->Start_Date;
                                $data->competionid = $idd;
                                $data->teams_name = Team_Store::find($data->teamId)->team_Name;
                                $data->comp=Schoolteamcomp::
                                            groupBy('cmpid')
                                            ->where('tmpid',$data->teamId)
                                            ->get()
                                            ->map(function($c){
                                                $c->cname=Competitionstore::
                                                where('id',$c->cmpid)->get();
                                                return $c;
                                            });
                                $data->studentname = Studentinfo::find($data->studentid)->name;
                                $data->class = Studentinfo::find($data->studentid)->class;
                                 $data->mobileno = Studentinfo::find($data->studentid)->mobileno;
                                  $data->studentemail = Studentinfo::find($data->studentid)->studentemail;
                                $data->schname = School::find($data->schoolid)->first();
                                return $data;

                            })->toArray();

                        }
                        else
                        {

                            $deatials[] = StudentTeam_Role::where('teamId', $creator->id)
                                ->get()->map(function ($data) use ($user)
                            {
                                $data->teamCreator = 'Trainer';
                                $data->competitionname = 'N/A';
                                $data->Regionname = 'N/A';
                                $data->compStartdate = 'N/A';
                                $data->competionid = 'N/A';
                                $data->comp='N/A';
                                $data->teams_name = Team_Store::find($data->teamId)->team_Name;
                                $data->studentname = Studentinfo::find($data->studentid)->name;
                                $data->class = Studentinfo::find($data->studentid)->class;
                                 $data->mobileno = Studentinfo::find($data->studentid)->mobileno;
                                  $data->studentemail = Studentinfo::find($data->studentid)->studentemail;
                                $data->schname = School::find($data->schoolid)->first();

                                return $data;
                            })->toArray();

                        }

                    break;
                }
  
        }


        // Payment Order List 
        $orderlist1 = Payment::where('teamid',$tid)->get();
        foreach ($orderlist1 as $key => $orderlist) {
       
            if(isset($orderlist->order_id))
            {
               if($orderlist->transaction_id!=null)
               {
                
                $orderlist1[$key]->status = "Success";
                $orderlist1[$key]->details = Orederstaus::where('order_id',$orderlist->order_id)->first()??'N/A';

               }
               else
               {
                  $orderlist1[$key]->status='Failed';
                  $orderlist1[$key]->details = Orederstaus::where('order_id',$orderlist->order_id)->first()??'N/A';
               }
            }
             else
            {
                $orderlist1[$key]->status="Failed";
                $orderlist1[$key]->details = Orederstaus::where('order_id',$orderlist->order_id)->first()??'N/A';
            }
        
}



// Sponsership Details for the Student 

        $sponser_details = SponserShip::where('teamid',$tid)->get();
        foreach ($sponser_details as $key => $value) {
            $sponser_details[$key]->compname = Competitionstore::where('id',$value->competition_id)->first()->Competition_name??'N/A';
            $sponser_details[$key]->teamname = Team_Store::where('id',$value->teamid)->first()->team_Name??'N/A';
            $up = explode('_', $value->uploadedby);
             $sponser_details[$key]->studentname = Studentinfo::where('id',$up[0])->first()->name??'N/A';
              $sponser_details[$key]->schoolname = School::where('id',$up[1])->first()->school_name??'N/A';

        }
     
     
//  List Compettition View Document in Team Wise Competition 
        
        $team_document = UploadDocument::where('team_id',$tid)->get();
		$block=0;
        // dd($team_document);
        foreach ($team_document as $key => $value) {
            $team_document[$key]->studentname = Studentinfo::where('id',$value->student_id)->first()->name??'N/A';
              $team_document[$key]->schoolname = School::where('id',$value->school_id)->first()->school_name??'N/A';
                $team_document[$key]->compname = Competitionstore::where('id',$value->competition_id)->first()->Competition_name??'N/A';
                $team_document[$key]->teams_name = Team_Store::find($value->team_id)->team_Name??'N/A';
        }
		
        $planId = DB::table('assignpriceinschool')->where('schoolid', $schoolinfo->id)->orderBy('id', 'DESC')
                    ->first();
              $planid=$planId->planid??0;   

                $planId = isset($planId) ? $planId->planid : 0;

				
                $plan1 = DB::table('plans')->where('id', $planId)->first();
				
				
				$blocks=0;
				$level=$plan1->level??0;
				if($plan1!=null)
				{
					 if($plan1->level==2)
                 {
					 $payment=Payment::where('teamid',$ts->id)->where('plan_id',$planId)->where('transaction_id','!=',"")->orderby('id','desc')->sum('block');
                   		
                    $block=$plan1->number-$payment;
					$blocks=$plan1->number;
					
				 }
                 else
                 {
					  $payment=Payment::where('plan_id',$planId)->where('teamid',$ts->id)->where('transaction_id','!=',"")->orderby('id','desc')->sum('block');
					  
					 $teamcount=StudentTeam_Role::where('teamId', $ts->id)
                                ->count();  
						
				      $block=$teamcount* $plan1->number-$payment;
					  $blocks=$teamcount* $plan1->number;
                 }
				}
                $team=TeamBlock::where('team_id',$ts->id)->where('plan',$planid)->orderby('id','desc')->sum('block');
                 
                  // $team11=TeamBlock::where('team_id',$ts->id)->where('plan',$planid)->orderby('id','desc')->get();
		
			     if($team!='')
					 
				 {
					
					 $block=$block+(int)$team;
                     if($block>0)
                     {
                       $block = $block;
                     }
                     // else
                     // {
                      // $block = "Block Should be greater than 0";
                     // }
					
				 }


         $summaryblock = TeamBlock::where('team_id',$tid)->orderby('id','asc')->get();
         
          $summaryblock1 = Payment::where('teamid',$tid)->orderby('id','asc')->get();
        
        // dd($summaryblock1);
         foreach ($summaryblock1 as $key => $value) {
           $p = Cartdetail::where('orderid',$value->order_id)->first()->product??'N/A';

           if($p==0)
           {
                $summaryblock1[$key]['type'] = 1;
             $summaryblock1[$key]['avblock'] = Cartdetail::where('orderid',$value->order_id)->first()->avblock??'N/A';
             $summaryblock1[$key]['quantity'] = Cartdetail::where('orderid',$value->order_id)->first()->quantity??'N/A';

              $tudentid = Cartdetail::where('orderid',$value->order_id)->first()->student_id??'N/A';
              if($tudentid!='N/A')
              {
               $summaryblock1[$key]['Studentname'] = Studentinfo::where('id',$tudentid)->first()->name??'N/A';
               $summaryblock1[$key]['schoolid'] = Studentinfo::where('id',$tudentid)->first()->school_id??'N/A';
              }

              
            }

       }
      
      $userAndAssociate = $summaryblock->merge($summaryblock1);
     $userAndAssociate = $userAndAssociate->sortByDesc('created_at');
      

        return view('admin.Team.viewTeampage', compact('ts','deatials','schoolinfo','orderlist1','sponser_details','team_document','team','block','level','blocks','summaryblock','summaryblock1','userAndAssociate'));
    }

// View Team According to School all type of Competition 


public function viewSchTeamcompdetails($schid,Request $req)
{
   if(Auth::user()->role==1)
			{
				
			}
			else
			{
			 
			  if(!isset($req->session()->all()['data'][14]))
				{
					$req->session()->flash('status','You do not have right to access this module');
					
					return redirect('/');
				}		 
			}
    $scid = base64_decode($schid);

    $team=Team_Store::where('school_id',$scid)->first();
    if($team==null)
    {
       $t=$team;
    }
    else
     {
       $t= Team_Store::where('school_id',$scid)->get();
     }  
return view('admin.Team.viewTeamListinSchool', compact('t'));  
}
    public function teamviewaddexport()
    { 
                  		
		           if(Auth::user()->role==1)
					{
						
					}
					else
					{
					 
					  if(!isset($req->session()->all()['data']))
						{
							$req->session()->flash('status','You do not have right to access this module');
							
							return redirect('/');
						}		 
					}
			
                   $creator = Team_Store::where('student_id', "1_admin")->get();
                   
                       if(count($creator)!=0)
                       {
                       foreach($creator as $creator){
                        $co = Schoolteamcomp::where('tmpid', $creator->id)->orderby('id','desc')
                            ->first();
   
                        if ($co != null)
                        {
                            $idd = $co->cmpid;
                            $admin[] = StudentTeam_Role::where('teamId', $creator->id)
                                ->get()->map(function ($data) use ($idd)
                            {
                                $data->teamCreator = 'Admin';
                                $data->competitionname = Competitionstore::find($idd)->Competition_name;
                                $data->Regionname = Competitionstore::find($idd)->levelnameid;
                                $data->compStartdate = Competitionstore::find($idd)->Start_Date;
                                $data->competionid = $idd;
								 $data->phone = isset(Studentinfo::find($data->studentid)->mobileno) ? Studentinfo::find($data->studentid)->mobileno : 'N/A';
								
								 	 $data->studentemail = isset(Studentinfo::find($data->studentid)->studentemail) ? Studentinfo::find($data->studentid)->studentemail : 'N/A';
								 
                                $data->teams_name = Team_Store::find($data->teamId)->team_Name;
                                $data->studentname = Studentinfo::find($data->studentid)->name;
                                $data->schname = School::find($data->schoolid)->school_name;
                                return $data;

                            })->toArray();
         
                          }
                          else
                          {
                          $admin[] = StudentTeam_Role::where('teamId', $creator->id)
                               ->get()->map(function ($data)
                            {
                                $data->teamCreator = 'Admin';
                                $data->competitionname = 'N/A';
                                $data->Regionname = 'N/A';
								 $data->phone = isset(Studentinfo::find($data->studentid)->mobileno) ? Studentinfo::find($data->studentid)->mobileno : 'N/A';
								
								 	 $data->studentemail = isset(Studentinfo::find($data->studentid)->studentemail) ? Studentinfo::find($data->studentid)->studentemail : 'N/A';
								 
                                $data->compStartdate = 'N/A';
                                $data->competionid = 'N/A';
                                $data->teams_name = Team_Store::find($data->teamId)->team_Name;
                                $data->studentname = Studentinfo::find($data->studentid)->name;
                                $data->schname = School::find($data->schoolid)->school_name;
                                return $data;
                            })->toArray();
                           }


                        }
                    }
                 else
                 {
                    $admin=[];
                 }


                 $tr = Team_Store::where('student_id',  'LIKE', '%_trainer%')->get();
   

                 if(count($tr)!=0)
                 {
                    foreach ($tr as $key => $tr1) {
                      
                       
                    $co = Schoolteamcomp::where('tmpid', $tr1->id)
                            ->first();
                      
                        if ($co != null)
                        {
                            $idd = $co->cmpid;
                            $trainer[] = StudentTeam_Role::where('teamId', $tr1->id)
                                ->get()->map(function ($data) use ($idd)
                            {
                                $data->teamCreator = 'Trainer';
                                $data->competitionname = Competitionstore::find($idd)->Competition_name;
                                $data->Regionname = Competitionstore::find($idd)->levelnameid;
                                $data->compStartdate = Competitionstore::find($idd)->Start_Date;
								 $data->phone = isset(Studentinfo::find($data->studentid)->mobileno) ? Studentinfo::find($data->studentid)->mobileno : 'N/A';
								
								 	 $data->studentemail = isset(Studentinfo::find($data->studentid)->studentemail) ? Studentinfo::find($data->studentid)->studentemail : 'N/A';
								 
                                $data->competionid = $idd;
                                $data->teams_name = Team_Store::find($data->teamId)->team_Name;
                                $data->studentname = Studentinfo::find($data->studentid)->name;
                                $data->schname = School::find($data->schoolid)->school_name;
                                return $data;

                            })->toArray();


                             
                        }
                        else
                        {
                        $user=[];
                        $trainer[] = StudentTeam_Role::where('teamId', $tr1->id)
                             ->get()->map(function ($data) use ($user)
                            {
                                $data->teamCreator = 'Trainer';
                                $data->competitionname = 'N/A';
                                $data->Regionname = 'N/A';
                                $data->compStartdate = 'N/A';
								  $data->phone = isset(Studentinfo::find($data->studentid)->mobileno) ? Studentinfo::find($data->studentid)->mobileno : 'N/A';
								
								 	 $data->studentemail = isset(Studentinfo::find($data->studentid)->studentemail) ? Studentinfo::find($data->studentid)->studentemail : 'N/A';
								 
                                $data->competionid = 'N/A';
                                $data->teams_name = Team_Store::find($data->teamId)->team_Name??'N/A';
                                $data->studentname = Studentinfo::find($data->studentid)->name??'N/A';
                                $data->schname = School::find($data->schoolid)->school_name;

                                return $data;
                            })->toArray();

                            

                        }

                   
                    }
                 }
                 else
                  {

                 
                      $trainer=[];
                     
                  }  
   
        $ts = Team_Store::get();
    
        if (count($ts) > 0)
        {
                 


            foreach ($ts as $key => $type1)
            {
            
                $ids = explode('_', $type1->student_id);
               if(count($ids)==2)
               {
                $user = $ids[0];
                $type = $ids[1];
                switch ($type)
                {
                    case 'student':

                        $creator = Team_Store::where('student_id', $user . "_" . $type)->first();
                        $co = Schoolteamcomp::where('tmpid', $creator->id)
                            ->first();

                        if ($co != null)
                        {

                            $idd = $co->cmpid;

                            $student[] = StudentTeam_Role::where('teamId', $creator->id)
                                ->get()->map(function ($data) use ($user, $idd)
                            {
								
                                $data->teamCreator = isset(Studentinfo::find($user)->name) ? Studentinfo::find($user)->name : 'N/A';
								 $data->phone = isset(Studentinfo::find($data->studentid)->mobileno) ? Studentinfo::find($data->studentid)->mobileno : 'N/A';
								
								 	 $data->studentemail = isset(Studentinfo::find($data->studentid)->studentemail) ? Studentinfo::find($data->studentid)->studentemail : 'N/A';
								 
                                $data->competitionname = Competitionstore::find($idd)->Competition_name;
                                $data->Regionname = Competitionstore::find($idd)->levelnameid;
                                $data->compStartdate = Competitionstore::find($idd)->Start_Date;
                                $data->competionid = $idd;
                                $data->teams_name = Team_Store::find($data->teamId)->team_Name;

                                $data->studentname = Studentinfo::find($data->studentid)->name;
                                $data->schname = School::find($data->schoolid)->school_name;
                                return $data;

                            })->toArray();

                        }
                        else
                        {


                            $student[] = StudentTeam_Role::where('teamId', $creator->id)
                                ->get()->map(function ($data) use ($user)
                            {
                                $data->teamCreator = Studentinfo::find($user)->name;
                                $data->competitionname = 'N/A';
                                $data->Regionname = 'N/A';
                                $data->compStartdate = 'N/A';
                                $data->competionid = 'N/A';
                                $data->teams_name = Team_Store::find($data->teamId)->team_Name;
                                $data->studentname = Studentinfo::find($data->studentid)->name;
                                $data->schname = School::find($data->schoolid)->school_name;
								 $data->phone = isset(Studentinfo::find($data->studentid)->mobileno) ? Studentinfo::find($data->studentid)->mobileno : 'N/A';
								
								 	 $data->studentemail = isset(Studentinfo::find($data->studentid)->studentemail) ? Studentinfo::find($data->studentid)->studentemail : 'N/A';
								 
                                return $data;
                            })->toArray();

                        }

                    break;
                  
                }
            }

            }

        }
       // $trainer = $trainer->toArray(); 
       
   
      $participate = array_merge($admin,$student,$trainer);
    
	 $i=0;
 foreach($participate as $key=>$ts)
 {
  foreach($ts as $keys=>$row)
  {
	  $arr[$i]['Team Creator Name']=$row['teamCreator'];
	   $arr[$i]['Member Phone']=$row['phone'];
	    $arr[$i]['Member Email']=$row['studentemail'];
		$arr[$i]['Member']=$row['studentname'];
		$arr[$i]['School Name']=$row['schname'];
		 $arr[$i]['Team Id']=$row['teamId'];
		  $arr[$i]['Team Name']=$row['teams_name'];
		   $arr[$i]['Region']= $row['Regionname'];
		   $arr[$i]['Competition Start Date']=$row['compStartdate'];
		   $i++;
	 
  }
  
  $i++;
   
 }
 

ob_end_clean(); // this
         ob_start();
        return Excel::create('View_Team', function($excel) use ($arr) {
            $excel->sheet('mySheet', function($sheet) use ($arr)
            {
                $sheet->cell('A1:O1', function($cell) {
                $cell->setFontWeight('bold');

                });
             
                $sheet->fromArray($arr);
            });
         })->download('xlsx');
    }
public function addblock(Request $req)
{
	 $tr = Team_Store::where('id',$req->teamid)->first();
	
	 $planId = DB::table('assignpriceinschool')->where('schoolid', $tr->school_id)->orderBy('id', 'DESC')
                    ->first();
                  

	$team=new TeamBlock();
	$team->team_id=$req->teamid;
	$team->block=$req->block;
	$team->plan=$planId->planid??0;
	$team->save();
	return redirect('viewteampage/'.base64_encode($req->teamid));
	
	
}
public function  removeblock(Request $req)
{
	
	$tr = Team_Store::where('id',$req->teamid)->first();
	
	 $planId = DB::table('assignpriceinschool')->where('schoolid', $tr->school_id)->orderBy('id', 'DESC')
                    ->first();
              
	$team=new TeamBlock();
	$team->team_id=$req->teamid;
	$team->block='-'.$req->block;
	$team->plan=$planId->planid??0;
	$team->save();
	return redirect('viewteampage/'.base64_encode($req->teamid));
}

}
    
