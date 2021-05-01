<?php

namespace App\Http\Controllers\Trainerrole;
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

class Trainer_Academic_Year extends Controller
{

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



  public function academic_year_trainer_wise($ac_year)
  {
     
       $email = Auth::user()->email;
dd($ac_year);
    
       $school = School::where('email',$email)->first()->id; 
       
      
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
               ->get();
       foreach ($eq as $key => $value) {
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
                ->get();
        foreach ($sctr as $key => $value) {
            $sctr[$key]['school_name'] = School::where('id',$value->school_id)->first()->school_name??'N/A';
             $sctr[$key]['trainer_name'] = Trainer::where('id',$value->trainer_id)->first()->name??'N/A';
        }

        
         } 
    return view('SchoolLogin.Academic_Year_Assign',compact('team','eq','eq1','sctr'));
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

      dd('jkk');
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

}