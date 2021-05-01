<?php

namespace App\Http\Controllers\Schoolaccess;
use App\Http\Controllers\Controller;
use Auth;
use App\Course;
use App\DocType;
use App\CourseMaster;
use Illuminate\Http\Request;
use App\Model\SchoolTrainer;
use App\Model\Trainer;
use App\School;
use DB;
use Mail;
use Alert;
use App\Model\AssignedCoursetype;
use App\Model\Manufacture\CarType;
use App\Model\Manufacture\Stcarbodypart;
use App\Studentinfo;
use Maatwebsite\Excel\Facades\Excel;
use App\User;
use App\Model\StudentModel\Team_Store;
use App\Model\StudentModel\StudentTeam_Role;
use App\Membership;
use App\Participatestudent;
use App\Schoolmasterplan;
use App\Model\Competition\Competitionstore;
use App\Model\Competition\Schoolteamcomp;
use App\AcademicYear;
use Session;
use App\Login_Academic_Year;
use App\Awards;

class SchoolaccessController extends Controller
{
	public function  studentviewS()
	{
	    $email = Auth::user()->email;
	    $id = School::where('email',$email)->first()->id;
      $school = Studentinfo::where('school_id',$id)->get();
         
        return view('School.studentv',compact('school','id'));
	    
	}
public function studentCr($schoolid)
{
	$schoolid1=base64_decode($schoolid);
    $scoolname=DB::table('schools')->select('school_name')->where('id',$schoolid1)->first();
    $tshirt=DB::table('tshirt')->get();
    $class=DB::table('class')->get();
      return view('School.studentCr',compact('schoolid1','scoolname','tshirt','class'));
       
}
public function storestudent(Request $request)
{
         $request->validate(
            [
            'name'=>'required',
            'class'=>'required',
            //'section'=>'required|regex:/^[a-zA-Z]+$/u',
            //'dob'=>'required',
            'studentemail'=>'required|unique:students',
            'mobileno'=>'required|min:11|numeric',
            // 'address'=>'required',
            // 'tsize'=>'required',
            // 'guardianemail1'=>'required|email',
            // 'guardianname1'=>'required',
            // 'guardianphone1'=>'required|min:11|numeric',
            // 'guardianname2'=>'required',
            // 'guardianemail2'=>'required|email',
            // 'guardianphone2'=>'required|min:11|numeric',
            'school_id'=>'required',
            'status'=>'required',
            
              ],['studentname.required'=>'The Student Name field is required','sutudentmobile.numeric'=>'The Student Phone field  must be a number.']
              );
              
        $data= $request->except('_token');
        $st=Studentinfo::insert($data);
        $st=Studentinfo::orderby('id','desc')->first();
         $user=new User();
         $user->name=$st->name;
         $user->email=$st->studentemail;
         $user->role=5;
         $user->password=bcrypt(strtolower('admin123'));
         $user->save();
      //    $data=array("studentname"=>$st->name,'password'=>strtolower($st->name).$st->id,'email'=>$st->studentemail);
      //     Mail::send('Mail.studentM', $data, function($message) use($data) {
      //    $message->to('jugendra@studiokrew.com', 'noreply@whitegarlic.in')->subject
      //       ('Welcome to F1school');
      //    $message->from('noreply@whitegarlic.in','F1School');
      // });
        if($st)
            return redirect('studentviewS/')->with('success','Rrecord Saved.');
}


	  public function viewstudentinfo($sstid)
       {
         
         $ids=explode("_",base64_decode($sstid));
         $schoolid=$ids[0];
         $studentid=$ids[1];
         $k=Studentinfo::find($studentid);
         return view('School.studentinfo',compact('k'));
       
       }





       public function vplan($id1)
       {
       	$id=base64_decode($id1);
        $plans=DB::table('memberships')->get();
         $scname=DB::table('students')->select('id','name','school_id')->where('id',$id)->first();
        $schoolname=DB::table('schools')->select('school_name')->where('id',$scname->school_id)->first();
     
         $tt=DB::table('participantstudents')->select('*')->where('student_id',$id)->get();
          $planyear=array();
         foreach( $tt as $ttt)
         {
             $planyear[] =DB::table('schoolplanmaster')->
             join('memberships','memberships.id','=','schoolplanmaster.plan')
             ->select('*')->where('schoolid',$ttt->schoolid)->where('year',$ttt->year)->get();
         }


         return view('School.vplanbyschool',compact('plans','scname','planyear','schoolname'));
     }



   public function  downloadsstudent($schoolid)
    {
       
     
   $student=DB::table('students')->where('school_id',base64_decode($schoolid))->get();
  if(count($student)>0){
        foreach($student as $key=>$student)
        {
        $arr[$key]["School Ids"]=$student->id;
        $arr[$key]["Student Name"]=$student->name;
        $arr[$key]["Student Class"]=$student->class;
        $arr[$key]["Student Section"]=$student->section;
        $arr[$key]["DOB"]=$student->dob;
        $arr[$key]["Mobile No"]=$student->mobileno;
        $arr[$key]["Address"]=$student->address;
    
         $arr[$key]["Guardian Name 1"]=$student->guardianname1;
        $arr[$key]["Guardian Email 1"]=$student->guardianemail1;
        $arr[$key]["Guardian Phone 1"]=$student->guardianphone1;
        $arr[$key]["Guardian Name 2"]=$student->guardianname2;
        $arr[$key]["Guardian Email 2"]=$student->guardianemail2;
        $arr[$key]["Guardian Phone 2"]=$student->guardianphone2;
        $arr[$key]["School_Id"]=DB::table('schools')->where('id',$student->school_id)->first()->school_name;
        $arr[$key]["T-Shirt Size"]=$student->tsize;
        $arr[$key]["Created_at"]=$student->created_at;
        $arr[$key]["updated_at"]=$student->updated_at;

     
            
        }
       
# Using
         return Excel::create('Student', function($excel) use ($arr) {
            $excel->sheet('mySheet', function($sheet) use ($arr)
            {
                $sheet->cell('A1:O1', function($cell) {
                $cell->setFontWeight('bold');

                });
             
                $sheet->fromArray($arr);
            });
        })->download('xlsx');
        
        }

    }

    public function studenteditbyschool($ssid)
    {
     $ids=explode("_",base64_decode($ssid));

	$schoolid=$ids[0];
	$studentid=$ids[1];
    $student= Studentinfo::where('id',$studentid)->where('school_id',$schoolid)->first();

    $tshirt=DB::table('tshirt')->get();
    $class=DB::table('class')->get();
    return view('School.studented',compact('student','tshirt','class'));
    }



public function studentupdatebyschool(Request $request)
{

	         $request->validate(
            [
            'name'=>'required',
            'class'=>'required',
          //  'section'=>'required|regex:/^[a-zA-Z]+$/u',
           // 'dob'=>'required',
            'studentemail'=>'required',
            'mobileno'=>'required|min:11|numeric',
           // 'address'=>'required',
           // 'tsize'=>'required',
            // 'guardianemail1'=>'required|email',
            // 'guardianname1'=>'required',
            // 'guardianphone1'=>'required|min:11|numeric',
            // 'guardianname2'=>'required',
            // 'guardianemail2'=>'required|email',
            // 'guardianphone2'=>'required|min:11|numeric',
            'school_id'=>'required',
            'status'=>'required',
            
              ],['studentname.required'=>'The Student Name field is required','sutudentmobile.numeric'=>'The Student Phone field  must be a number.','section'=>'Specail Character is no Allowed']
              );
           
            $up=DB::table('students')
            ->where('id', $request->student_id)->where('school_id',$request->school_id)
            ->update(['name' => $request->name,'class'=>$request->class,'section'=>$request->section,'dob'=>$request->dob,'studentemail'=> $request->studentemail,'mobileno'=>$request->mobileno,'address'=>$request->address,'tsize'=>$request->tsize,'guardianemail1'=>$request->guardianemail1,'guardianname1'=>$request->guardianname1,'guardianphone1'=>$request->guardianphone1,'guardianname2'=>$request->guardianname2,'guardianemail2'=>$request->guardianemail2,'guardianphone2'=>$request->guardianphone2,'school_id'=>$request->school_id,'status'=>$request->status]);

           //return redirect('studentviewS')->with('success','Updated  Successfully.');
		    return redirect('studentviewS/')->with('success','Updated  Successfully.');

 
}

public function deletestudentbyschool($ssid)
{
	$ids=explode("_",base64_decode($ssid));
	$schoolid=$ids[0];
	$studentid=$ids[1];
    $student= Studentinfo::where('id',$studentid)->where('school_id',$schoolid)->delete();
    return redirect('studentviewS')->with('danger','Deleted  Successfully.');
}






public function vTeamS()
{
	    $email = Auth::user()->email;
      $id = School::where('email',$email)->first()->id;

           // StudentTeam_Role:: 
      $viewteam = Team_Store::where('school_id',$id)->get();
      foreach ($viewteam as $key => $value) {
          $stud = explode("_", $value->student_id);
          $userid = $stud[0];
          $usertype = $stud[1];
          // $awards = Awards::where('teamid',$value->id)->get();

          // dd($awards);
          switch ($usertype) {
            case 'admin':
              $viewteam[$key]->createdby = $usertype;
              break;
             case 'student':
               $viewteam[$key]->createdby = Studentinfo::where('id',$userid)->first()->name??'N/A';
              break;

           case 'trainer':
               $viewteam[$key]->createdby = Trainer::where('id',$userid)->first()->name??'N/A';
              break;
          }
         

      }
    
      // $viemteam = DB::table('team_store')->where('school_id',$id)->get()->map(function($data){
      //   $ss=explode("_", $data->student_id);
      //   $data->studentName =isset($ss[1])?DB::table('trainers')->first()->name." ( Trainer ) ":Studentinfo::find($data->student_id)->name." (Student) ";
      //     return $data;

      // })->toArray();

	   return view('School.teamView',compact('viewteam'));
	  dd($vt);


}


public function viewteambyschool($tssdid) 
{

    

$tssdId=explode("_",base64_decode($tssdid));

  $teamid = $tssdId[0];

  $scid = $tssdId[1];

  
  $Teamname = DB::table('team_store')->select('team_Image','team_Name','team_Description')->where('id',$tssdId[0])->first();

  $assignmem = StudentTeam_Role::
       join('students','students.id','=','studentTeam_Role.studentid')
       ->select('students.id','students.name','studentTeam_Role.studentRole','studentTeam_Role.status','studentTeam_Role.created_at','studentTeam_Role.updated_at')
       ->where('teamId',$tssdId[0])->get();

  return view('School.viewteammembyschool',compact('scid','assignmem','Teamname'));
}



public function Academic_year_school()
{
   $email = Auth::user()->email;
   $school = School::where('email',$email)->first()->id; 
   $school =  base64_encode($school);  
   
        $plans=Membership::get();
        $schoolname    =  School::
                         select('school_name')
                         ->where('id',base64_decode($school))->first();
              
        $planperschool = Membership::
                         join('schoolplanmaster','schoolplanmaster.plan','=','memberships.id')
                           ->orderBy('year', 'DESC')
                           ->select('*')->where('schoolid',base64_decode($school))
                           ->get();

        foreach( $planperschool as $key=>$plans1)
        {        
                  $planperschool[$key]->counts = Participatestudent::
                                                 where('year',$plans1->year)
                                                ->where('schoolid',$plans1->schoolid)
                                                ->where('planid',$plans1->plan)
                                                ->count();
        }
        
        $year = date("Y");
       
        $year = $year."-".($year+1);
         
           $school_master_plan = Schoolmasterplan::
                    where('schoolid',base64_decode($school))
                    ->where('year',$year)
                    ->get();

  foreach ($school_master_plan as $key => $value) {
            $school_master_plan[$key]['Plan_name'] = Membership::where('id',$value->plan)->first()->name??'N/A';
  }
 
   return view('SchoolLogin.Academic_Year_Assign',compact('email','plans','school','schoolname','planperschool','academic_year','school_master_plan'));
  
}

// public function Academic_Year_Wise_System_School(Request $request)
// {
  
//    $email = Auth::user()->email;
//    $school = School::where('email',$email)->first()->id; 
//    $school =  base64_encode($school);  
   
//    $plans=Membership::get();
//    $schoolname    =  School::
//                      select('school_name')
//                      ->where('id',base64_decode($school))->first();

//     $planperschool = Membership::
//                      join('schoolplanmaster','schoolplanmaster.plan','=','memberships.id')
//                      ->orderBy('year', 'DESC')
//                      ->select('*')->where('schoolid',base64_decode($school))
//                      ->get();

//         foreach( $planperschool as $key=>$plans1)
//         {        
//           $planperschool[$key]->counts = Participatestudent::
//                                         where('year',$plans1->year)
//                                         ->where('schoolid',$plans1->schoolid)
//                                         ->where('planid',$plans1->plan)
//                                         ->count();
//         }

//    $school_master_plan = Schoolmasterplan::
//                          where('schoolid',$request->schoolid)
//                          ->where('year',$request->year)
//                          ->get();

//   foreach ($school_master_plan as $key => $value) {
//             $school_master_plan[$key]['Plan_name'] = Membership::where('id',$value->plan)->first()->name??'N/A';
//   }

//   return view('SchoolLogin.Academic_Year_Assign',compact('email','plans','school','schoolname','planperschool','academic_year','school_master_plan'));
// }



  public function academic_year_school_wise($ac_year)
  {
     
       $email = Auth::user()->email;
       $school = School::where('email',$email)->first()->id; 

      Login_Academic_Year::where('school',$school)->delete();
      $data = new Login_Academic_Year();
      $data->school = $school;
      $data->academicyear = $ac_year;
      $data->save();

       // dd(Login_Academic_Year::all());
       
        $year = date('Y')."-".(date('Y')+1);
         if($ac_year==$year)
         {
          
              $team = Team_Store::where('academicyear',$ac_year)
                      ->where('school_id',$school)
                      ->get();
              foreach ($team as $key => $value) {
                $team[$key]['school_name'] = School::where('id',$value->school_id)->first()->school_name??'N/A';
          foreach ($team as $key => $value) {
          $team[$key]['school_name'] = School::where('id',$value->school_id)->first()->school_name??'N/A';
            $id = $value->student_id;
            $tssId = explode("_", $id);
            $student_id = $tssId[0];
            $is_type = $tssId[1];
             switch ($is_type)
             {
                case 'admin':
                    $team[$key]['Type'] = DB::table('users')->find($student_id)->name;
                break;

                case 'trainer':
                    $team[$key]['Type'] = DB::table('trainers')->find($student_id)->name."(Trainer)";
                break;

                case 'student':
                    $team[$key]['Type'] = DB::table('students')->find($student_id)->name."(Student)";
                break;
              }
             }
              }
              

              $eq1 = Competitionstore::where('academicyear',$ac_year)->get()->map(function($input){
                 $date=date_create($input['Start_Date']);
                 $input['Start_Date']=date_format($date,"d/m/Y"); 
                 $Ragistration_Date=date_create($input['Ragistration_Date']);
                 $input['Ragistration_Date']=date_format($Ragistration_Date,"d/m/Y"); 
                  return $input;
                      });
           

      $eq = Schoolmasterplan::where('schoolid',$school)
               ->where('year',$ac_year)
               ->orderby('id','desc')
               ->get();
       foreach ($eq as $key => $value) {
                  $check = Membership::where('id',$value->plan)
                              ->count();
                if($check!=0)
                {
                $eq[$key]['planname'] = Membership::where('id',$value->plan)
                              ->first()->name??'N/A';
                $l = Membership::where('id',$value->plan)
                              ->first()->course_list??'N/A';
                $l1=explode(",",$l);
                $cn=Course::whereIn('id',$l1)->select('title')->get()->toArray();
               $res = implode(",", array_column($cn, 'title'));
                $eq[$key]->course_list = $res;
                 $eq[$key]->fee_per_student = Membership::where('id',$value->plan)
                              ->first()->fee_per_student??'N/A';
                            }
                else
                {
                
                  Schoolmasterplan::where('schoolid',$school)
                            ->where('plan',$value->plan)
                            ->where('year',$value->year)
                            ->delete();
                 }

               }   

// echo 1;
// dd($eq);
               
        // $eq = Membership::where('academicyear',$ac_year)->get();
        // foreach($eq as $k=>$q){
        //     $l1=explode(",",$q->course_list);
        //     $cn=Course::whereIn('id',$l1)->select('title')->get()->toArray();
        //     $res = implode(",", array_column($cn, 'title'));
        //     $eq[$k]->course_list = $res;
        // }
     
        $sctr = SchoolTrainer::where('year',$ac_year)
                ->where('school_id',$school)
                ->orderBy('id','desc')
                ->get();

        foreach ($sctr as $key => $value) {
            $sctr[$key]['school_name'] = School::where('id',$value->school_id)
                                         ->first()->school_name??'N/A';
             $sctr[$key]['trainer_name'] = Trainer::where('id',$value->trainer_id)                            ->first()->name??'N/A';
        }
         
       
      
         }
         else
         {
          
               $team = Team_Store::where('academicyear',$ac_year)
                       ->where('school_id',$school)
                       ->get();
               foreach ($team as $key => $value) {
                $team[$key]['school_name'] = School::where('id',$value->school_id)->first()->school_name??'N/A';
            $id = $value->student_id;
            $tssId = explode("_", $id);
            $student_id = $tssId[0];
            $is_type = $tssId[1];
             switch ($is_type)
             {
                case 'admin':
                    $team[$key]['Type'] = DB::table('users')->find($student_id)->name;
                break;

                case 'trainer':
                    $team[$key]['Type'] = DB::table('trainers')->find($student_id)->name."(Trainer)";
                break;

                case 'student':
                   $team[$key]['Type'] = DB::table('students')->find($student_id)->name."(Student)";
                break;
              }
            }

      $eq = Schoolmasterplan::where('schoolid',$school)
               ->where('year',$ac_year)
               ->get();
       foreach ($eq as $key => $value) {
              $check = Membership::where('id',$value->plan)
                              ->count();
                if($check!=0)
                {
                $eq[$key]['planname'] = Membership::where('id',$value->plan)
                              ->first()->name??'N/A';

                $l = Membership::where('id',$value->plan)
                              ->first()->course_list??'N/A';
                $l1=explode(",",$l);
                $cn=Course::whereIn('id',$l1)->select('title')->get()->toArray();
               $res = implode(",", array_column($cn, 'title'));
                $eq[$key]->course_list = $res;
                $eq[$key]->fee_per_student = Membership::where('id',$value->plan)
                              ->first()->fee_per_student??'N/A';
                 }
                else
                {
                
                  Schoolmasterplan::where('schoolid',$school)
                            ->where('plan',$value->plan)
                            // ->where('year',$value->year)
                            ->delete();
                 }


               }        
//  echo 2;
// dd($eq);
     // $eq = Membership::where('academicyear',$ac_year)->get();
     //    foreach($eq as $k=>$q){
     //        $l1=explode(",",$q->course_list);
     //        $cn=Course::whereIn('id',$l1)->select('title')->get()->toArray();
     //        $res = implode(",", array_column($cn, 'title'));
     //        $eq[$k]->course_list = $res;
     //    }
          


       $eq1 = Competitionstore::where('academicyear',$ac_year)->get()->map(function($input){
                 $date=date_create($input['Start_Date']);
                 $input['Start_Date']=date_format($date,"d/m/Y"); 
                 $Ragistration_Date=date_create($input['Ragistration_Date']);
                 $input['Ragistration_Date']=date_format($Ragistration_Date,"d/m/Y"); 
                  return $input;
                      });


        $sctr = SchoolTrainer::where('year',$ac_year)
                ->where('school_id',$school)
                ->orderby('id','desc')
                ->get();
        foreach ($sctr as $key => $value) {
            $sctr[$key]['school_name'] = School::where('id',$value->school_id)->first()->school_name??'N/A';
             $sctr[$key]['trainer_name'] = Trainer::where('id',$value->trainer_id)->first()->name??'N/A';
        }

        
         } 
    return view('SchoolLogin.Academic_Year_Assign',compact('team','eq','eq1','sctr','ac_year'));
    // return view('admin.Academicyearwisedetails.Academicyearpage',compact('team','eq','sctr'));
  }


    public function check_data_according_to_year_wise_school(Request $req)
  {

     $email = Auth::user()->email;
    $school = School::where('email',$email)->first()->id; 
    $count = AcademicYear::where('academicyear',$req->academicyear)
              ->where('school',$school)
             ->get();
    
    if(count($count)==0)
        {
    $data = new AcademicYear();
    $data->school = $school;
    $data->academicyear = $req->academicyear;
    $data->save();
      }
      else
      {
        AcademicYear::
        where('school', $school)
          ->update([
          'academicyear' => $req->academicyear,
          'school' => $school,
          ]);
      }

      // $school
      Login_Academic_Year::where('school',$school)->delete();
      $data = new Login_Academic_Year();
      $data->school = $school;
      $data->academicyear = $req->academicyear;
      $data->save();
     Session::flash('success', "Updated Academic Year");
      return redirect('academic-year-school-wise/'.$req->academicyear);
  }

 public function available_student_in_plan_school($info)
  {
     $info = base64_decode($info);
     $info1 = explode("_", $info);
     $plan = $info1[0];
     $school = $info1[1];
     $acyear = $info1[2];

     $planname = Membership::where('id',$plan)->first()->name??'N/A';
     $st = Participatestudent::
           where('year',$acyear)
           ->distinct()
           ->groupby('schoolid')
           ->where('planid',$plan)
           ->where('schoolid',$school)
           ->get();
    foreach ($st as $key => $value) {
          $st[$key]['school_name'] = School::where('id',$value->schoolid)
                                     ->first()->school_name??'N/A';
          $st[$key]['student_count'] =   Participatestudent::select('student_id')                              ->where('year',$acyear)
                                          ->where('planid',$plan)
                                          ->where('schoolid',$value->schoolid)
                                          ->count();                      
    }
    return view('SchoolLogin.AcademicYearWisePlanSchoolParticipatestudent',compact('st','planname','acyear'));
 

  }

  public function avaiable_student_according_to_School_plan($info)
  {
     $info = base64_decode($info);
     $info1 = explode("_", $info);
     $plan = $info1[0];
     $schoolid = $info1[1];

     $acyear = $info1[2];
     $planname = Membership::where('id',$plan)->first()->name??'N/A';
         $school_name = School::where('id',$schoolid)->first()->school_name??'N/A';
         $partistudent = Participatestudent::where('year',$acyear)
                  ->where('planid',$plan)
                  ->where('schoolid',$schoolid)
                  ->get(); 
         foreach ($partistudent as $key => $value) {
            $partistudent[$key]['studentname'] = Studentinfo::where('id',$value->student_id)->first()->name??'N/A';
         }
return view('SchoolLogin.Acadmicyearschoolforstudent',compact('partistudent','planname','acyear','school_name'));

  return view('admin.Academicyearwisedetails.AcademicYearWisePlanSchoolstudent',compact('st','planname','acyear'));

  }



    /*Show Team by School from Dashboard Click*/

  public function team_show_by_school_competition($ids)
  {
    $ids = explode("_",base64_decode($ids));
    $school_id = $ids[0];
    $comp = $ids[1];
      $SchoolCompTeam = Schoolteamcomp::
                        where('school_id',$school_id)->where('cmpid',$comp)->get();
                       
                    foreach ($SchoolCompTeam as $key => $value) {
                       $SchoolCompTeam[$key]['team_Name'] =  Team_Store::
                                                              where('id',$value->tmpid)->first()->team_Name;
                        $SchoolCompTeam[$key]['team_Image'] =  Team_Store::
                                                              where('id',$value->tmpid)->first()->team_Image;
                       $SchoolCompTeam[$key]['student_id'] =  Team_Store::
                                                              where('id',$value->tmpid)->first()->student_id;
                       $SchoolCompTeam[$key]['school_id'] =  Team_Store::
                                                              where('id',$value->tmpid)->first()->school_id;                                       
                    }
                    return view('School.teamViewdashborad',compact('SchoolCompTeam'));
                    dd($SchoolCompTeam);
  }
   /*End Show Team by School from Dashboard Click*/


   public function edit_profile_school()
   {
        $email = Auth::user()->email;
        $v = School::where('email',$email)->first()->id; 
        $r = School::find($v);
        $zone_name = DB::table('locations')->where('Zone_id', $r->zone)
            ->first()->zone??"";
        $state_name = DB::table('tbl_state')->where('id', $r->state)
            ->first()->name??"";
        $city_name = DB::table('tbl_city')->where('id', $r->city)
            ->first()->name??"";
        $loc = DB::table('locations')
         ->groupby('Zone_id')
            ->distinct()
            ->get();

        return view('School.schooledit',compact('r', 'loc', 'zone_name', 'state_name', 'city_name'));
        dd($school);
   }

   public function update(Request $r)
   {
        $r->validate(['school_name' => 'required|regex:/^[a-zA-Z0-9 ]*$/',
        'type' => 'required',
        'city' => 'required',
        'zone' => 'required',
        'state' => 'required',
        'mobile' => 'numeric|nullable',
        'pimage' =>'pimage|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ], ['school_name.required' => 'The School/Collage Name field is required', 'mobile.numeric' => 'The School/Collage Phone field  must be a number.', 'email.unique' => 'You can use Email Id Please provide alternate Id.'
        ]);
    
      $pimage = School::where('id',$r->sid)->first();
      if($r->hasFile('school_image')){            
            $fname=time().".".$r->file('school_image')->getClientOriginalExtension();
            $pp=public_path('ImageSchool/');
            $r->file('school_image')->move($pp,$fname);
        }
        else
        {
          $fname = $pimage->pimage;
        }  
  
        $up = School::where('id',$r->sid)
              ->update(
                [
                  'school_name' => $r->school_name,
                  'annual_fees' => $r->annual_fees,
                  'type' => $r->type,
                  'status' => $r->status,
                  'address' => $r->address,
                  'zone' => $r->zone,
                  'state' => $r->state,
                  'city' => $r->city,
                  'website' => $r->website,
                  'email' => $r->email,
                  'mobile' => $r->mobile,
                  'principal_name' => $r->principal_name,
                  'principal_mobile' => $r->principal_mobile,
                  'principal_email' => $r->principal_email,
                  'pimage' => $fname
                ]); 
          
              return redirect('edit-profile-school')->with('success','Updated  Successfully.');
  
   }

   public function team_awards($teamid)
   {
     $teamId = base64_decode($teamid);
     $schoolid = Team_Store::where('id',$teamId)->first()->school_id??'N/A';
     $TeamName = Team_Store::where('id',$teamId)->first()->team_Name??'N/A';
     $schoolName = School::where('id',$schoolid)->first()->school_name;
     $awards = Awards::where('teamid',$teamId)->get();
     foreach ($awards as $key => $value) {
       $awards[$key]->compeName = Competitionstore::where('id',$value->compid)->first()->Competition_name??'N/A';
     }
      return view('School.awardsTeam',compact('TeamName','schoolName','awards'));
     dd($awards);
   }


}



//view Team


