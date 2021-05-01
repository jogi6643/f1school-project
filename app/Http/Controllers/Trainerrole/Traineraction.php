<?php

namespace App\Http\Controllers\Trainerrole;

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
use App\Model\Assigneddatetable;
use App\Schoolmasterplan;
use App\Participatestudent;
use App\Location;
use Maatwebsite\Excel\Facades\Excel;
use App\Model\StudentModel\StudentTeam_Role;
use App\Model\StudentModel\Team_Store;
use App\Model\Manufacture\Stcarbodypart;
use App\Membership;
use App\Course;
class Traineraction extends Controller
{

public function trainerviewstudents($id)
{
	
       $email=Auth::user()->email;
       $trainerid=DB::table('trainers')->where('email',$email)->first()->id;
        $trainer=DB::table('trainers')->where('email',$email)->first()->name;

         $school=SchoolTrainer::select('school_id')->where('trainer_id',$trainerid)->where('year',date("Y"))->get()->map(function($data){
          return $data->school_id;
         })->toarray();
       $students= Studentinfo::whereIn('school_id',$school)->get();
  return view('Trainer.StudentList',compact('students','trainer'));
}

public function studenteditbyTrainer($ssid)
{
   $email = Auth::user()->email;
   $trainerid = DB::table('trainers')->where('email',$email)->first()->id;
   $trainer = DB::table('trainers')->where('email',$email)->first()->name;
   $ids = explode("_",base64_decode($ssid));
   $studentid = $ids[0];
   $schoolid = $ids[1];
   $student = Studentinfo::where('id',$studentid)->where('school_id',$schoolid)->first();

   $tshirt = DB::table('tshirt')->get();
   $class = DB::table('class')->get();
   return view('Trainer.Student_edT',compact('student','trainer','tshirt','class'));

}

public function editbyTr(Request $request)
{

           $request->validate(
            [
            // 'name'=>'required|regex:/^[a-zA-Z]+$/u|max:255',
             'name'  =>  ['required','regex:/^([a-zA-Z0-9]+|[a-zA-Z0-9]+\s{1}[a-zA-Z0-9]{1,}|[a-zA-Z0-9]+\s{1}[a-zA-Z0-9]{3,}\s{1}[a-zA-Z0-9]{1,})$/i'],
             
            'class'=>'required',
            'class'=>'required',
            // 'section'=>'required|regex:/^[a-zA-Z]+$/u',
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

           return redirect('showliststudent/'.base64_encode($request->school_id))->with('success','Updated  Successfully.');

 
}

public function showliststudent($studentid)
{
       $id = $studentid;
       $email = Auth::user()->email;
       $schoolname = School::where('id',base64_decode($studentid))->first()->school_name??'N/A';
       $trainerid = DB::table('trainers')->where('email',$email)->first()->id;
       $trainer = DB::table('trainers')->where('email',$email)->first()->name;
      $students= Studentinfo::where('school_id',base64_decode($studentid))->get();

  
    return view('Trainer.StudentList',compact('students','trainer','id','schoolname'));
}

public function Participatestudentbytrainer($schooldp)
{
      $students=DB::table('students')->where('school_id',base64_decode($schooldp))->get();
      $schoolname=DB::table('schools')->select('school_name')->where('id',base64_decode($schooldp))->first();
        //  $students = DB::table('students')->where('school_id', base64_decode($schooldp))->get();

        // $schoolname = DB::table('schools')->select('school_name')
        //     ->where('id', base64_decode($schooldp))->first(); 
      return view('Trainer.ParticipateStudent_Tr',compact('students','schooldp','schoolname'));
}
  

  
  public function sbmitparticipantbyTr(Request $req)
  {


//   Participatestudent::where('schoolid', $req->schoolid)
//             ->where('year', $req->year)
//             ->where('planid', $req->planid)
//             ->delete();
//    AssignedCoursetype::where('school_id',$req->schoolid)
//             ->where('acyear',$req->year)
//             ->where('Plan_id',$req->planid)
//             ->delete();

//             if($req->student!=null)
//             {
//            foreach ($req->student as $key => $v1)
//             {
 
//             $studentp = new Participatestudent();
//             $studentp->schoolid = $req->schoolid;
//             $studentp->planid = $req->planid;
//             $studentp->student_id = $v1;
//             $studentp->year = $req->year;
//             $studentp->save();

//             }
//         }

//            $ParticipateStudent = Participatestudent::where('schoolid', $req->schoolid)
//             ->where('year', $req->year)
//             ->where('planid', $req->planid)
//             ->get();
//     /*Assign Participant Student in Plan*/
//     if(count($ParticipateStudent)>0)
//        {
//     $pri = Membership::where('id',$req->planid)->first()->priorty_set;
//     $priorty_set = explode(',',$pri); 
//     $cour = Membership::where('id',$req->planid)->first()->course_list;
//     $course_list2 = explode(',',$cour);    
//       foreach( $ParticipateStudent as  $studentid1)
//        { 
//              $i=0;
//             foreach ($course_list2 as $key => $course_id) {


//                $assigned=new AssignedCoursetype();
//                $assigned->doc_types_id = Course::where('id',$course_id)
//                                          ->first()->doc_types_id;
//                $assigned->course_masters_id = $course_id;
//                $assigned->student_id = $studentid1->student_id;
//                $assigned->school_id = $studentid1->schoolid;
//                $assigned->Plan_id = $req->planid;
//                $assigned->acyear = $req->year;
//                $assigned->priority_set = $priorty_set[$i];
//                $assigned->assigneddate = '12-12-1993';
//                $assigned->edited_by = Auth::user()->id;
//                $assigned->save();
               
              
         
//                 $i = $i+1;
//               } 
             
//        }
// }
/*End Assign Plan for Student*/
            $schoolplan = Schoolmasterplan::
                          where('plan',$req->planid)
                          ->where('schoolid',$req->schoolid)
                          ->where('year',$req->year)->get();

          Participatestudent::where('schoolid', $req->schoolid)
            ->where('year', $req->year)
            ->where('planid', $req->planid)
            ->delete();

        AssignedCoursetype::where('school_id',$req->schoolid)
                    ->where('acyear',$req->year)
                    ->where('Plan_id',$req->planid)
                    ->delete();
                    
    if($req->student!=null)
        {
           foreach ($req->student as $key => $v1)
            {
 
            $studentp = new Participatestudent();
            $studentp->schoolid = $req->schoolid;
            $studentp->planid = $req->planid;
            $studentp->student_id = $v1;
            $studentp->year = $req->year;
            $studentp->save();

            }
        }                           
     /*****************************************************************************/
      $ParticipateStudent = Participatestudent::where('schoolid', $req->schoolid)
            ->where('year', $req->year)
            ->where('planid', $req->planid)
            ->get();

        $assigndate  = Assigneddatetable::where('Plan_id',$req->planid)
                ->where('school_id',$req->schoolid)->where('acyear',$req->year)->get();

        if(count($assigndate)>0)
        { 
        foreach( $ParticipateStudent as  $studentid1)
             { 
            foreach ($assigndate as $key => $value) {
               $assigned = new AssignedCoursetype();
               $assigned->doc_types_id = $value->doc_types_id;
               $assigned->course_masters_id = $value->course_masters_id;
               $assigned->student_id = $studentid1->student_id;
               $assigned->school_id = $req->schoolid;
               $assigned->Plan_id = $req->planid;
               $assigned->acyear = $req->year;
               $assigned->priority_set = $value->priority_set;
                if($value->assigneddate==null)
                {
               $assigned->assigneddate = '12-12-1993';
                }
                else
                 {
              $assigned->assigneddate = $value->assigneddate;
                 }   

               $assigned->edited_by = Auth::user()->id;
               $assigned->save();
            }
          }

        } 


        else
        {
     $ParticipateStudent = Participatestudent::where('schoolid', $req->schoolid)
            ->where('year', $req->year)
            ->where('planid', $req->planid)
            ->get();
    /*Assign Participant Student in Plan*/
    if(count($ParticipateStudent)>0)
    {
    $pri = Membership::where('id',$req->planid)->first()->priorty_set;
    $priorty_set = explode(',',$pri); 
    $cour = Membership::where('id',$req->planid)->first()->course_list;
    $course_list2 = explode(',',$cour);    
      foreach( $ParticipateStudent as  $studentid1)
       { 
             $i=0;
            foreach ($course_list2 as $key => $course_id) {
               $assigned=new AssignedCoursetype();
               $assigned->doc_types_id = Course::where('id',$course_id)
                                         ->first()->doc_types_id;
               $assigned->course_masters_id = $course_id;
               $assigned->student_id = $studentid1->student_id;
               $assigned->school_id = $studentid1->schoolid;
               $assigned->Plan_id = $req->planid;
               $assigned->acyear = $req->year;
               $assigned->priority_set = $priorty_set[$i];
               $assigned->assigneddate = '12-12-1993';
               $assigned->edited_by = Auth::user()->id;
               $assigned->save();
               
              
         
                $i = $i+1;
              } 
             
       }
}
/*End Assign Plan for Student*/
}              

     /********************************************************************************/ 
            
        $student_plan = $this->participanrshowbyTr1($req->schoolid,$req->year,$req->planid);

        // dd($student_plan);
        $planname = Membership::where('id',$req->planid)->first()->name;
        return redirect('Participatestudentbytrainer/' . base64_encode($req->schoolid))
            ->with('success', 'Record Saved.')
            ->with('Year',$req->year)
            ->with('planname',$planname)
            ->with('students1',$student_plan)
            ->with('planid1',$req->planid);

  }

     public function participanrshowbyTr1($schoolid,$year,$planid)
    {

        $schoolmasterplan = DB::table('schoolplanmaster')->join('schools', 'schools.id', '=', 'schoolplanmaster.schoolid')
            ->join('students', 'students.school_id', '=', 'schools.id')
            ->where('schoolid', $schoolid)->where('year', $year)->distinct('students.mobileno')
            ->select('students.id', 'students.name', 'students.studentemail', 'students.class')
            ->get();
        foreach ($schoolmasterplan as $key => $value)
        {
            // ->where('planid', $_GET['planid'])
            $table = DB::table('participantstudents')->where('student_id', $value->id)
                ->where('year', $year)->count();

            if ($table > 0)
            {
                $schoolmasterplan[$key]->check = 1;
                $pid = DB::table('participantstudents')->where('student_id', $value->id)
                    ->where('year', $year)->first()->planid??'N/A';
                $schoolmasterplan[$key]->avplanname = Membership::where('id', $pid)->first()->name??'N/A';
                $schoolmasterplan[$key]->ppid = $pid;
                $schoolmasterplan[$key]->updated_at = DB::table('participantstudents')->where('student_id', $value->id)
                    ->where('year', $year)->first()->updated_at??'N/A';
            }
            else
            {
                $schoolmasterplan[$key]->check = 0;
                $schoolmasterplan[$key]->avplanname = 'N/A';
                $schoolmasterplan[$key]->ppid = 0;
                $schoolmasterplan[$key]->updated_at = 'N/A';


            }
        }
          
        return $Response = array(
            'schoolplan' => $schoolmasterplan,
            'planname'=> Membership::where('id',$planid)->first()->name??'N/A'
        
        );


    }


     public function participanrshowbyTr()
    {


   $schoolmasterplan = DB::table('schoolplanmaster')->join('schools', 'schools.id', '=', 'schoolplanmaster.schoolid')
            ->join('students', 'students.school_id', '=', 'schools.id')
            ->where('schoolid', $_GET['school_id'])->where('year', $_GET['year'])->distinct('students.mobileno')
            ->select('students.id', 'students.name', 'students.studentemail', 'students.class', 'students.updated_at')
            ->get();

        foreach ($schoolmasterplan as $key => $value)
        {
            // ->where('planid', $_GET['planid'])
            $table = DB::table('participantstudents')->where('student_id', $value->id)
                ->where('year', $_GET['year'])->count();

            if ($table > 0)
            {
                $schoolmasterplan[$key]->check = 1;
                $pid = DB::table('participantstudents')->where('student_id', $value->id)
                    ->where('year', $_GET['year'])->first()->planid??'N/A';
                $schoolmasterplan[$key]->avplanname = Membership::where('id', $pid)->first()->name??'N/A';
                $schoolmasterplan[$key]->ppid = $pid;
                  $schoolmasterplan[$key]->updated_at = DB::table('participantstudents')->where('student_id', $value->id)
                    ->where('year', $_GET['year'])->first()->updated_at??'N/A';
            }
            else
            {
                $schoolmasterplan[$key]->check = 0;
                $schoolmasterplan[$key]->avplanname = 'N/A';
                  $schoolmasterplan[$key]->ppid = 0;
                  $schoolmasterplan[$key]->updated_at = 'N/A';


            }
        }
      
        return $Response = array(
            'schoolplan' => $schoolmasterplan,
            'planname'=> Membership::where('id',$_GET['planid'])->first()->name??'N/A'
             // 'ppid'=>$_GET['planid']
        
        );
     

    }



    public function menbershipsataby()
{
           $plan=DB::table('schoolplanmaster')->where('schoolid',$_GET['school_id'])->where('year',$_GET['year'])
            ->join('memberships','memberships.id','=','schoolplanmaster.plan')
            ->select('memberships.id','memberships.name')
          ->get();
           return $Response = array('plan'=>$plan);
}


    public function schoolplanmasterby_Tr($school)
    {
        
    
              $plans=DB::table('memberships')->get();
            
              $schoolname=DB::table('schools')->select('school_name')->where('id',base64_decode($school))->first();
              
              $planperschool=DB::table('memberships')
              ->join('schoolplanmaster','schoolplanmaster.plan','=','memberships.id')
              ->orderBy('year', 'DESC')
              ->select('*')->where('schoolid',base64_decode($school))->get();
              foreach( $planperschool as $key=>$plans1)
              {
                  $planperschool[$key]->counts=DB::table('participantstudents')->where('year',$plans1->year)->where('schoolid',$plans1->schoolid)->count();
              }
             
              return view('admin.schoolplanmaster',compact('plans','school','schoolname','planperschool'));
        
    }

 public function storeschoolplanmaster_trainer(Request $request)
    {
           $request->validate([
           'schoolid'=>'required',
            'plan'=>'required',
            'year'=>'required',
            ]);
            $count=0;
        foreach($request->plan as $planid)
            {
             $check = Schoolmasterplan::where('schoolid',$request->schoolid)->where('plan',$planid)->where('year',$request->year)->first();
            if($check==null)
              {
            $count = $count+1;
            $plan = new Schoolmasterplan();
            $plan->schoolid=$request->schoolid;
             $plan->plan=$planid;
            $plan->year=$request->year;
            $plan->save();
              }
            }
            if($count!=0)
            {
             return redirect('viewplanshowT1/'.base64_encode($request->schoolid))->with('success','Rrecord Saved.');
            }
             if($count==0){
            return redirect('viewplanshowT1/'.base64_encode($request->schoolid))->withErrors('Data Already exist in database.');
           }
       
    }



     public function storeschoolplanmasterbytr(Request $request)
    {
           $request->validate([
           'schoolid'=>'required',
            'plan'=>'required',
            'year'=>'required',
            ]);
            $count=0;
        foreach($request->plan as $planid)
            {
             $check=Schoolmasterplan::where('schoolid',$request->schoolid)->where('plan',$planid)
           
             ->where('year',$request->year)->first();
            if($check==null)
              {
                $count=$count+1;
            $plan=new Schoolmasterplan();
            $plan->schoolid=$request->schoolid;
             $plan->plan=$planid;
            $plan->year=$request->year;
            $plan->save();
              }
            }
            if($count!=0)
            {
             return redirect('viewplanshowT/'.base64_encode($request->schoolid))->with('success','Rrecord Saved.');
            }
             if($count==0){
            return redirect('viewplanshowT/'.base64_encode($request->schoolid))->withErrors('Data Already exist in database.');
           }
       
    }


      public function schoolplanfetchacademicyear_admin(Request $req)
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


    public function  downloadstudentupload(Request $req)
    {
       
        
        $school=School::where('status',1)->get();
        foreach($school as $key=>$schools)
        {
        $arr[$key]["School Ids"]="";
        $arr[$key]["Student Name"]="";
        $arr[$key]["Student Class"]="";
        $arr[$key]["Student Section"]="";
        $arr[$key]["DOB"]="";
        $arr[$key]["Mobile No"]="";
        $arr[$key]["Address"]="";
        $arr[$key]["T-Shirt Size"]="";
         $arr[$key]["Guardian Name 1"]="";
        $arr[$key]["Guardian Email 1"]="";
        $arr[$key]["Guardian Phone 1"]="";
        $arr[$key]["Guardian Name 2"]="";
        $arr[$key]["Guardian Email 2"]="";
        $arr[$key]["Guardian Phone 2"]="";
       
        $arr[$key]["School_Id"]=$schools->id;
        $arr[$key]["School_Name"]=$schools->school_name;
            
        }
       
ob_end_clean(); // this
ob_start();
         return Excel::create('Student_Templates', function($excel) use ($arr) {
            $excel->sheet('mySheet', function($sheet) use ($arr)
            {
                $sheet->cell('A1:O1', function($cell) {
                $cell->setFontWeight('bold');

                });
             
                $sheet->fromArray($arr);
            });
        })->download('xlsx');
        
    }


    public function  trdownloadstudentbyschool($schoolid)
    {
       
     
        $student=DB::table('students')->where('school_id',base64_decode($schoolid))->get();
        
  if(count($student)>0){
        foreach($student as $key=>$student)
        {
        $arr[$key]["Student Ids"]=$student->id;
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
        $arr[$key]["status"]                     =        $student->status;
        $arr[$key]["email_status"]               =        $student->email_status;
        $arr[$key]["last_login"]                 =        $student->last_login;
        $arr[$key]["Created_at"]=$student->created_at;
        $arr[$key]["updated_at"]=$student->updated_at;

     
            
        }
       
ob_end_clean(); // this
ob_start();
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


public function uploadstudentbytr(Request $req)
    {
      
      // dd($req->all());
        // $req->validate([
        //     'files' => 'required'
        // ]);
   
        // $path = $req->file('files')->getRealPath();
        // $data = Excel::load($path)->get();
         
        // foreach($data as $datas)
        // {
            
          
        // if($datas->student_name!=null)
        //   {
        //     $student=new Student();
        //     $student->name=$datas->student_name;
        //     $student->dob=isset($datas->dob)?strtotime($datas->dob):null;
        //     $student->class=$datas->student_class;
        //     $student->section=$datas->student_section;
        //     $student->mobileno=$datas->mobile_no;
        //     $student->address=$datas->address;
        //     $student->tsize=$datas->t_shirt_size;  
        //     $student->guardianname1=$datas->guardian_name_1; 
        //     $student->guardianemail1=$datas->guardian_email_1; 
        //     $student->guardianphone1 =$datas->guardian_phone_1; 
        //     $student->guardianname2=$datas->guardian_name_2; 
        //     $student->guardianemail2=$datas->guardian_email_2; 
        //     $student->guardianphone2 =$datas->guardian_phone_2;
        //     $student->school_id =(string)$datas->school_ids;
        //     $student->save();
          
        //      }
              
             
        // }
         return redirect('showliststudent/'.base64_encode(1)) ->with('success','Record Save Successfully');
        
    }
public function studentinfo($sstid)
{     
        $ids = explode("_",base64_decode($sstid));
        $schoolid = $ids[0];
        $studentid = $ids[1];
        $k = Studentinfo::find($studentid);
        return view('Trainer.Studentinfo_tr',compact('k'));
}

public function viewTeams($student_id)
{
    $studentid = base64_decode($student_id);
    $teamdetails = 'N/A';
    // $schoolname = 'N/A';
    $userType = 'N/A';
    $username = 'N/A';

    $St_rol = StudentTeam_Role::where('studentid',$studentid)->first()??'N/A';
    $schoolid = Studentinfo::where('id',$studentid)->first()->school_id??'N/A';
     $schoolname = School::where('id',$schoolid)->first()->school_name??'N/A';
    if($St_rol!='N/A')
    {
        $St_rol = Team_Store::where('id',$St_rol->teamId)->first()??'N/A';
      
        $data = explode('_', $St_rol->student_id);
        $userId = $data[0];
        $userType = $data[1];
      
        switch ($userType) {
          case 'student':

             $username = Studentinfo::
                    where('id',$userId)->first()->name??'N/A';
            $teamdetails = StudentTeam_Role::where('teamId',$St_rol->id)->get();
            foreach ($teamdetails as $key => $value) {
            $teamdetails[$key]->Studentname = Studentinfo::
                                              where('id',$value->studentid)->first()->name??'N/A';
            $teamdetails[$key]->studentemail = Studentinfo::
                                              where('id',$value->studentid)->first()->studentemail??'N/A';
            $teamdetails[$key]->TeamName = Team_Store::
                                              where('id',$value->teamId)->first()->team_Name??'N/A';
            }
            break;
          
          case 'admin':
            $username = 'admin';
            $teamdetails = StudentTeam_Role::where('teamId',$St_rol->id)->get();
            foreach ($teamdetails as $key => $value) {
            $teamdetails[$key]->Studentname = Studentinfo::
                                              where('id',$value->studentid)->first()->name??'N/A';
            $teamdetails[$key]->studentemail = Studentinfo::
                                              where('id',$value->studentid)->first()->studentemail??'N/A';

            $teamdetails[$key]->TeamName = Team_Store::
                                              where('id',$value->teamId)->first()->team_Name??'N/A';
            }
          
            break;

             case 'trainer':
            $username = Trainer:: where('id',$userId)->first()->name??'N/A';
            $teamdetails = StudentTeam_Role::where('teamId',$St_rol->id)->get();
            foreach ($teamdetails as $key => $value) {
            $teamdetails[$key]->Studentname = Studentinfo::
                                              where('id',$value->studentid)->first()->name??'N/A';
            $teamdetails[$key]->studentemail = Studentinfo::
                                              where('id',$value->studentid)->first()->studentemail??'N/A';
            $teamdetails[$key]->TeamName = Team_Store::
                                              where('id',$value->teamId)->first()->team_Name??'N/A';
            }
            break;
        }


    }
     return view('Trainer.viewTeamTrainer',compact('schoolname','username','userType','teamdetails'));
    // return view('admin.Student.viewTeamadmin',compact('schoolname','username','userType','teamdetails'));
   
}

public function cardesign($studentid)
{
   $studentid = base64_decode($studentid);
   $username = Studentinfo::
                    where('id',$studentid)->first()->name??'N/A';
     $schoolid = Studentinfo::where('id',$studentid)->first()->school_id??'N/A';
     $schoolname = School::where('id',$schoolid)->first()->school_name??'N/A';
   $manufacture =  Stcarbodypart::where('studentidC',$studentid)->get();
   foreach ($manufacture as $key => $value) {
      if($value->carpartid!=0)
      {
     $manufacture[$key]->partname = Part::where('id',$value->carpartid)->first()->parts??'N/A';
       }
      else
       {
           $manufacture[$key]->partname = 'N/A';
       }

   }


return view('Trainer.manufactureinfo',compact('schoolname','username','manufacture'));
}

}