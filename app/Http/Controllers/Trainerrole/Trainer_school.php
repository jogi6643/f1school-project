<?php
namespace App\Http\Controllers\Trainerrole;

use App\Competition;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Model\SchoolTrainer;
use App\Model\Trainer;
use App\School;
use App\Membership;
use App\DocType;  
use DB;
use Mail;
use Alert;
use App\Model\AssignedCoursetype;
use App\Model\Assigneddatetable;
use App\Model\ParticipateStudent;
use App\Course;
use App\Studentinfo;
use App\Schoolmasterplan;
use App\Model\Competition\Schoolteamcomp;
use App\Model\StudentModel\Team_Store;
use App\Location;
use App\States;
use App\City;
use App\Model\Plan;
use App\Model\Competition\Competitionstore;

class Trainer_school extends Controller
{
    public function assignedschool()
    {
        // $year = date("Y");
      
        $trainerid = Auth::user()->email;
        
        $id = Trainer::where('email',$trainerid)->first()->id;
        
        $name = Trainer::where('email',$trainerid)->first()->name;

         $trainerid = $id;
        $trschool = SchoolTrainer::where('trainer_id',$id)->get();
        $sch=array();
        foreach($trschool as $key=>$info1){
         $sch[] = $info1->school_id;
          }
       $grouschid = array_unique($sch); 
       $info = [];
       foreach ($grouschid as $key => $id) {
        $school =  School::where('id',$id)->first();
         $info[$key]['id'] = $id;
        $info[$key]['schoolname'] = School::where('id',$id)->first()->school_name??'N/A';
        $info[$key]['locationname'] =  Location::where('Zone_id',$school->zone)->first()->zone??'N/A';
        $info[$key]['cityname'] = City::where('id',$school->city)->first()->name??'N/A';
        $info[$key]['statename'] = States::where('id',$school->state)->first()->name??'N/A';
       }

        return view('Trainer.assignschool',compact('info','name','trainerid'));
    }
    
    
public function trschooinfo($v)
    {
       
        $k=School::find(base64_decode($v));
        $zone=isset(DB::table('locations')->where('id',$k->zone)->first()->zone)?DB::table('locations')->where('id',$k->zone)->first()->zone:"";
        $state=isset(DB::table('tbl_state')->where('id',$k->state)->first()->name)?DB::table('tbl_state')->where('id',$k->state)->first()->name:"";
        $city=isset(DB::table('tbl_city')->where('id',$k->city)->first()->name)?DB::table('tbl_city')->where('id',$k->city)->first()->name:"";
        return view('Trainer.assignedSchooldetails',compact('k','zone','state','city'));
    }
    
    public function viewplanshowT($school)
    {
        
             $plans = Membership::get();



              $schoolname = School::where('id',base64_decode($school))->first()->school_name;

              $planperschool = Membership::
                              join('schoolplanmaster','schoolplanmaster.plan','=','memberships.id')
                              ->orderBy('schoolplanmaster.plan', 'DESC')
                              ->select('*')
                              ->where('schoolid',base64_decode($school))
                              ->get();
              foreach( $planperschool as $key=>$plans1)
              {
                  $planperschool[$key]->counts=ParticipateStudent::where('year',$plans1->year)->where('planid',$plans1->plan)->where('schoolid',$plans1->schoolid)->count();

                  // $planperschool[$key]->datecreate=ParticipateStudent::where('year',$plans1->year)->where('schoolid',$plans1->schoolid)->first()->created_at??'N/A';
                  
              }
              
              
              $schoolid= base64_decode($school);
               if(Auth::user()->role==1)
			   {
				   return view('Trainer.showplanTs',compact('plans','school','schoolname','planperschool','schoolid'));
			   }
			   else
			   {
				   return view('Trainer.showplanT',compact('plans','school','schoolname','planperschool','schoolid'));
			   }
              
    }

    public function viewplanshow_trainer($school)
    {
          $plans = Membership::get();
              $schoolname = School::where('id',base64_decode($school))->first()->school_name;
              $planperschool = Membership::
                              join('schoolplanmaster','schoolplanmaster.plan','=','memberships.id')
                              ->orderBy('schoolplanmaster.plan', 'DESC')
                              ->select('*')
                              ->where('schoolid',base64_decode($school))
                              ->get();



              foreach( $planperschool as $key=>$plans1)
              {
                  $planperschool[$key]->counts=ParticipateStudent::where('year',$plans1->year)->where('schoolid',$plans1->schoolid)
                    ->where('planid',$plans1->plan)
                    ->count();

                  $planperschool[$key]->datecreate=ParticipateStudent::where('year',$plans1->year)->where('schoolid',$plans1->schoolid)->first()->created_at??'N/A';
                  
              }
              
              
              $schoolid= base64_decode($school);
               if(Auth::user()->role==1)
         {
           return view('Trainer.showplanTs',compact('plans','school','schoolname','planperschool','schoolid'));
         }
         else
         {

           return view('Trainer.showplanT',compact('plans','school','schoolname','planperschool','schoolid'));
         }
    }
    



    public function viewcourseT($planid)
    {
      
        $planid1=explode(",",base64_decode($planid));

		
		 
        $cid = Membership::where('id',$planid1[0])->select('course_list','priorty_set')->first()??'NO';
        
        if($cid!='NO')
        {
        $courseid = explode(",",$cid->course_list);
        $priotyid = explode(",",$cid->priorty_set);
        $schoolid = $planid1[1];
        $acyear  = $planid1[2];
        $planidd = $planid1[0];
        $currentyear = date("Y");
        $excludeyear = explode("-",$acyear);
        $exyr = $excludeyear[0];
       
        $arr = array_combine($courseid,$priotyid);
       
          $Course = Course::
                join('doc_types','courses.doc_types_id','=','doc_types.id')
                ->join('course_masters','course_masters.id','=','courses.course_masters_id')
               ->select('courses.id','doc_types.id as doctypeid','course_masters.course_name','courses.title','course_masters.id as coursemaster_id','doc_types.type')
              ->whereIn('courses.id',$courseid)
              ->get();
             foreach ($Course as $key => $value) {
              $Course[$key]->priotyid = $arr[$value->id];
             }
             $Course = $Course->sortBy('priotyid');
        

          $assign = Assigneddatetable::where('Plan_id',$planid1[0])
                ->where('school_id',$planid1[1])->where('acyear',$planid1[2])->take(count($Course))->get();
// dd($assign);
			  // $assign = AssignedCoursetype::where('Plan_id',$planid1[0])
     //            ->where('school_id',$planid1[1])->where('acyear',$planid1[2])->take(count($Course))->get();
	      ;   foreach($assign  as $key=>$assigns)
		      {
				  $ass[$assigns['course_masters_id']]=$assigns->assigneddate;
			  }
			  
             $k=School::find($schoolid)->school_name??'NO';
             $planname=Membership::where('id',$planid1[0])->first()->name??'NO';
          
        }
        else
        {
          $k='NO';
          $planname = 'NO';
          $Course = 'NO';
          $schoolid = 'NO'; 
          $acyear = 'NO';
          $planidd = 'NO';
          $currentyear = 'NO';
          $exyr = 'NO';

        }
if(Auth::user()->role==1){
  // echo 1;
  // die;
             return view('Trainer.showcourseT',compact('k','planname','Course','schoolid','acyear','planidd','currentyear','exyr','ass'));
    }
    else
    {
      // echo 2;
      // die;
       return view('Trainer.showcourseT',compact('k','planname','Course','schoolid','acyear','planidd','currentyear','exyr','ass'));
    }
        
    }
    
    
    public function intimation(Request $req)
    {


      $assigndate=$req->AssignDate;

      $arrkeys = array_keys($req->all());
      $arrvalue = array_values($req->all());
     
      $keys = array_splice($arrkeys,2,count($req->all()));
	  
      $values = array_splice($arrvalue,2,count($req->all()));
      $all = array_combine($keys, $values);
      
      $data = explode('_',$keys[0]);
      $school_id = $data[1];
      $plan_id = $data[2];
      
      $year = $data[3];
      $course_id = $data[4];
      $doctype_id = $data[5]; 
      $coursemasid = $data[6];
    
    $schoolplan = Schoolmasterplan::where('plan',$plan_id)
                ->where('schoolid',$school_id)
                ->where('year',$year)->get();
      $ParticipateStudent = ParticipateStudent::
                          where('planid',$plan_id)
                         ->where('schoolid',$school_id)
                         ->where('year',$year)->get();
                         // where('year','2020-2021')
                         // ->delete();
                         // die;
       Assigneddatetable::where('school_id',$school_id)
                       ->where('acyear',$year)
                       ->where('Plan_id',$plan_id)
                       ->delete();
      

     if(count($ParticipateStudent)>0)
       {
       AssignedCoursetype::where('school_id',$school_id)
                       ->where('acyear',$year)
                       ->where('Plan_id',$plan_id)
                       ->delete();


   $pri = Membership::where('id',$plan_id)->first()->priorty_set;
    $priorty_set = explode(',',$pri); 
    $cour = Membership::where('id',$plan_id)->first()->course_list;
    $course_list2 = explode(',',$cour);            
     $arr1=array_combine($course_list2, $priorty_set);

      foreach( $ParticipateStudent as  $studentid1)
       { 
             $i=0;
    
            foreach ($all as $key => $value) {
               $info = explode('_', $key);
               // echo "<pre>";
               // print_r($info);
               $school_id = $info[1];
               $plan_id = $info[2];
               $year = $info[3];
               $course_id = $info[4];
               $doctype_id = $info[5];
               /*sTART ASSIGN COURSE TYPE STORE DATA*/ 
               $assigned=new AssignedCoursetype();
               $assigned->doc_types_id = Course::where('id',$course_id)
                                         ->first()->doc_types_id;
               $assigned->course_masters_id = $course_id;
               $assigned->student_id = $studentid1->student_id;
               $assigned->school_id = $studentid1->schoolid;
               $assigned->Plan_id = $plan_id;
               $assigned->acyear = $year;
               $assigned->priority_set = $arr1[$course_id];

               if($value==null)
               {
                
                $assigned->assigneddate = '12-12-1993';
               }
               else
               {
                $assigned->assigneddate = $value;
               }
               
			         $assigned->edited_by = Auth::user()->id;
               $assigned->save();
               /*END ASSIGN COURSE TYPE STORE DATA*/ 
         
                $i = $i+1;
              } 

               /*************Mailing Process Of Assigned Date***********/ 
               $assineddate_mail = AssignedCoursetype::
                                   where('school_id',$studentid1->schoolid)
                                   ->where('acyear',$year)
                                   ->where('Plan_id',$plan_id)
                                   ->where('student_id',$studentid1->student_id)
                                   ->get();
              $school_name = School::where('id',$studentid1->schoolid)->first()->school_name;
              $student = Studentinfo::where('id',$studentid1->student_id)->first();
              $plan_name = Membership::where('id',$plan_id)->first()->name;                   

                foreach ($assineddate_mail as $key => $value) {
                $assineddate_mail[$key]->course_Tittle =  Course::
                                                      where('id',$value->course_masters_id)->first()->title??'N/A'; 
                $assineddate_mail[$key]->course_Mail =  Course::
                                                      where('id',$value->course_masters_id)->first()->mailcontent??'N/A'; 
                if($value->doc_types_id==1)
                {
                $assineddate_mail[$key]->filetype =  'docs';
                }
                elseif($value->doc_types_id==2)
                 {
                  $assineddate_mail[$key]->filetype =  'vedio';
                 } 
                 else
                 {
                   $assineddate_mail[$key]->filetype =  'both';
                 }
               

                }


  $data=array("school_name"=>  $school_name,'student_email'=>$student->studentemail,'student_name'=>  $student->name,'plan_name'=>$plan_name,'assineddate_mail'=>$assineddate_mail);
         
          Mail::send('Mail.Assigneddatemailer', $data, function($message) use($data) {
         $message->to('str1@yopmail.com', 'noreply@timeofsports.com')->subject
            ('Welcome Aboard | Season 3 | F1 in Schools™ India');
         $message->from('noreply@timeofsports.com','F1 in Schools India');
         });                   
                          
               /************End Mailing Process of Assigned Date *******/
             
       }


     /****************************************/
        if(count($schoolplan)>0)
       {
        
       // AssignedCoursetype::where('school_id',$school_id)
       //                 ->where('acyear',$year)
       //                 ->where('Plan_id',$plan_id)
       //                 ->delete();


   $pri = Membership::where('id',$plan_id)->first()->priorty_set;
    $priorty_set = explode(',',$pri); 
    $cour = Membership::where('id',$plan_id)->first()->course_list;
    $course_list2 = explode(',',$cour);            
     $arr1=array_combine($course_list2, $priorty_set);

      foreach( $schoolplan as  $c1)
       { 
             $i=0;
      
            foreach ($all as $key => $value) {
               $info = explode('_', $key);
               // echo "<pre>";
               // print_r($info);
               $school_id = $info[1];
               $plan_id = $info[2];
               $year = $info[3];
               $course_id = $info[4];
               $doctype_id = $info[5];


               /*START ASSIGNDATE TABLE UPDATE*/

                $assigned_date = new Assigneddatetable();
               $assigned_date->doc_types_id = Course::where('id',$course_id)
                                         ->first()->doc_types_id;
               $assigned_date->course_masters_id = $course_id;
               $assigned_date->Plan_id = $plan_id;
               $assigned_date->acyear = $year;
               $assigned_date->priority_set = $arr1[$course_id];
                $assigned_date->school_id = $c1->schoolid;

               if($value==null)
               {
                
                $assigned_date->assigneddate = '12-12-1993';
               }
               else
               {
                $assigned_date->assigneddate = $value;
               }
               
               $assigned_date->edited_by = Auth::user()->id;
               $assigned_date->save();
               /*END ASSIGNDATE TABLE UPDATE*/
         
                $i = $i+1;
              }  
             
       }

       /****************************************/
      

     }  
     
   }
     else
     {
      
/*Start No Student participate */
    $pri = Membership::where('id',$plan_id)->first()->priorty_set;
    $priorty_set = explode(',',$pri); 
    $cour = Membership::where('id',$plan_id)->first()->course_list;
    $course_list2 = explode(',',$cour); 
      $arr1=array_combine($course_list2, $priorty_set);
            $i=0;

            foreach ($all as $key => $value) {
               $info = explode('_', $key);
               $school_id = $info[1];
               $plan_id = $info[2];
               $year = $info[3];
               $course_id = $info[4];
               $doctype_id = $info[5];

               $assigned_date = new Assigneddatetable();
               $assigned_date->doc_types_id = Course::where('id',$course_id)
                                         ->first()->doc_types_id;
               $assigned_date->course_masters_id = $course_id;
               $assigned_date->Plan_id = $plan_id;
               $assigned_date->acyear = $year;
               $assigned_date->school_id = $school_id;
               $assigned_date->priority_set = $arr1[$course_id];

               if($value==null)
               {
                
                $assigned_date->assigneddate = '12-12-1993';
               }
               else
               {
                // echo $value;
                $assigned_date->assigneddate = $value;
               }
               
               $assigned_date->edited_by = Auth::user()->id;
               $assigned_date->save();
               
              
         
                $i = $i+1;
              }


       // $check = Assigneddatetable::
       //          where('Plan_id',$plan_id)
       //          ->where('school_id',$school_id)
       //          ->where('acyear',$year)
       //          ->get();
       // dd($check);
       $plansch=base64_encode($plan_id.",".$school_id.",".$year);
     if(Auth::user()->role==1){
       return redirect('viewcourseT/'.$plansch)->with('success',"Date Assigned Successfully.." );
       }

      else
      {
        return redirect('viewcourseT_trainer/'.$plansch)->with('success',"Date Assigned Successfully..");
      }
  /*END No Student participate */    
      }
// $check = Assigneddatetable::get();
//        dd($check);
/*Start Available Student in Participate */
    $plansch=base64_encode($plan_id.",".$school_id.",".$year);
    if(Auth::user()->role==1){
       return redirect('viewcourseT/'.$plansch)->with('success',"Date Assigned Successfully.." );
     }
     else
     {
       return redirect('viewcourseT_trainer/'.$plansch)->with('success',"Date Assigned Successfully.." );
     }
/*End Available Student in Participate */

    }


    
    
    
    public function viewcourseinPlan($pcy)
    {
         $ids = explode(",",base64_decode($pcy));


         $planid = $ids[0];
         $schoolid = $ids[1];
         $acyear = $ids[2];

        


         $assignedcourse =  AssignedCoursetype::where('school_id',$schoolid)
                            -> where('Plan_id',$planid)
                            ->where('acyear',$acyear)->get();
            foreach ($assignedcourse as $key => $data) {
                 $data->scoolname = School::where('id',$data->school_id)->first()->school_name??'N/A';
                 $data->planname = Membership::where('id',$data->Plan_id)->first()->name??'N/A';
                  $data->Coursename = Course::where('id',$data->course_masters_id)->first()->title??'N/A';
                    $data->Studentname = Studentinfo::where('id',$data->student_id)->first()->name??'N/A';
                   
                    }                


              
              $schoolname = DB::table('schools')->select('school_name')->where('id',$schoolid)->first()->school_name;
               // $Planname = $planperschool->name;
            if(Auth::user()->role==1){
            
              return view('Trainer.courseListinPlan',compact('courselist','schoolname','assignedcourse'));
            }
            else
            {

               return view('Trainer.courseListinPlan_trainer',compact('courselist','schoolname','assignedcourse'));
            }
          
    }
    
    
    public function viewstudentlist($pcy)
    {
         $ids = explode(",",base64_decode($pcy));
         $plan_id = $ids[0];
         $school_id = $ids[1];
         $year = $ids[2];
        
           $ParticipateStudent = ParticipateStudent::
                          where('planid',$plan_id)
                         ->where('schoolid',$school_id)
                         ->where('year',$year)->get();


          
          foreach ($ParticipateStudent as $key => $value) {
            $ParticipateStudent[$key]->name = Studentinfo::where('id',$value->student_id)->first()->name??'N/A';
             $ParticipateStudent[$key]->class = Studentinfo::where('id',$value->student_id)->first()->class??'N/A';
             $ParticipateStudent[$key]->section = Studentinfo::where('id',$value->student_id)->first()->section??'N/A';
             $ParticipateStudent[$key]->mobileno = Studentinfo::where('id',$value->student_id)->first()->mobileno??'N/A';
              $ParticipateStudent[$key]->address = Studentinfo::where('id',$value->student_id)->first()->address??'N/A';
             $ParticipateStudent[$key]->schoolname = School::where('id',$value->schoolid)->first()->school_name??'N/A';
          }
          

          $Planname = Membership::where('id',$plan_id)->first()->name;

         // $studentList=ParticipateStudent::where('schoolid',$schoolid)->where('year',$acyear)->select('student_id')->get()->map(function($Studentids)
         // {
         //     return $Studentids->student_id;
         // })->toArray();
       
         // $fetachstudent=DB::table('students')->whereIn('id',$studentList)->get()->map(function($std){
         //     return $std;
         // })->toArray();
         
    
         //      $schoolname=DB::table('schools')->select('school_name')->where('id',$schoolid)->first()->school_name;
        
if(Auth::user()->role==1){
        return view('Trainer.studentListinPlan',compact('ParticipateStudent','Planname'));
      }
      else
      {
         return view('Trainer.studentListinPlan_trainer',compact('ParticipateStudent','Planname'));
         }
         dd($fetachstudent); 
        
    }
    
    
    public function viewcompetitionT($School_id)
    {
        // $school_id = base64_decode($School_id1);

        $trainer_email = Auth::user()->email;
        $id = Trainer::where('email',$trainer_email)->first()->id;
         $Trainer = Trainer::where('email',$trainer_email)->first()->name;
       
        // $name=Trainer::where('email',$trainerid)->first()->name;
           $trschoolinfo = SchoolTrainer::
                           where('trainer_id',$id)
                           ->where('school_id',base64_decode($School_id))
                           // ->where('year',date("Y"))
                           ->first()??'N/A';
           if($trschoolinfo=='N/A')
           {
             $schoolteamcomp = 'N/A';
           } 
           else
           {
              $schoolteamcomp = Schoolteamcomp::
                             where('school_id',base64_decode($School_id))
                             // ->where('status',1)
                             ->get();


              foreach ($schoolteamcomp as $key => $value)
               {
                  $schoolteamcomp[$key]->Competition =   Competitionstore::
                                                         where('id',$value->cmpid)->first()->Competition_name??'N/A';
                  $schoolteamcomp[$key]->schoolname =   School::
                                                         where('id',$value->school_id)->first()->school_name??'N/A';
                  $schoolteamcomp[$key]->teamname =   Team_Store::
                                                         where('id',$value->tmpid)->first()->team_Name??'N/A';

              } 
                           
           }  

          return view('Trainer.veiwcompetition',compact('schoolteamcomp','Trainer'));             
  
    } 
    
    public function schoolplanfetchacademicyear_trainer(Request $req)
    {
        $req->v;
        // $ab=Schoolmasterplan::
        //     ->leftjoin('memberships','memberships.id','=','tbl_state.id')
        //           //  where('schoolid',$request->schoolid)
        //           // ->where('plan',$planid)
        

        $ab = Membership::where('academicyear', $req->v)
            ->get();
        return $ab;
    }
    

    public function edit()
    {
        $trainer_email = Auth::user()->email;
        $id = Trainer::where('email',$trainer_email)->first()->id;
        $k=Trainer::find($id);
        return view('Trainer.Edit_trainer_profile',compact('k'));
        dd($id);
    }

    public function update(Request $r)
    {
        if($r->hasFile('pimage')){            
            $fname=time().".".$r->file('pimage')->getClientOriginalExtension();
            $pp=public_path('trainerprofile/');
            $r->file('pimage')->move($pp,$fname);
        }
        else
        {
          $fname ='';
        }  

      $up = Trainer::where('email',$r->email)
       ->update([
           'name' => $r->name,
           'phone' =>$r->phone,
           'pimage' => $fname

      ]);
      return redirect('edit-profile-trainer')->with('success','Updated  Successfully.');
      dd($r->all());
    }
    
}