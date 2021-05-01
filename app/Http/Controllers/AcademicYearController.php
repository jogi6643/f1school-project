<?php
namespace App\Http\Controllers;
use App\Schoolmasterplan;
use App\School;
use App\Participatestudent;
use App\Location;
use App\AcademicYear;
use App\Login_Academic_Year;
use Illuminate\Http\Request;
use DB;
use App\Model\Manufacture\CarType;
use App\Model\Manufacture\Stcarbodypart;
use App\Model\Manufacture\Cardetailspayments;
use App\Model\Manufacture\Orederstaus;
use \cache;
use Auth;
use Session;
use App\Model\AssignedCoursetype;
use App\Model\Competition\Schoolteamcomp;
use App\Model\StudentModel\Team_Store;
use App\Model\StudentModel\StudentTeam_Role;
use App\Model\Plan;
use App\Model\Part;
use App\Model\Material;
use App\Model\Partplan;
use App\Model\Cartdetail;
use App\Model\Payment;
use App\Studentinfo;
use App\Model\Assignpriceinschool;
use Mail;
use PDF;
use App\Membership;
use App\Model\Competition\Competitionstore;
use App\Model\Trainer;
use App\Model\SchoolTrainer;
use App\Course;



class AcademicYearController extends Controller
{

	public function academic_year_wise_info($ac_year)
	{
	
        $year = date('Y')."-".(date('Y')+1);
         if($ac_year==$year)
         {
         	
              $team = Team_Store::where('academicyear',$ac_year)->get();
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
              

               
        $eq=Membership::where('academicyear',$ac_year)->get();
        foreach($eq as $k=>$q){
            $l1=explode(",",$q->course_list);
            $cn=Course::whereIn('id',$l1)->select('title')->get()->toArray();
            $res = implode(",", array_column($cn, 'title'));
            $eq[$k]->course_list = $res;
        }
     
        $sctr = SchoolTrainer::where('year',$ac_year)
                ->orderby('id','desc')
                ->get();
        foreach ($sctr as $key => $value) {
            $sctr[$key]['school_name'] = School::where('id',$value->school_id)
                                         ->first()->school_name??'N/A';
             $sctr[$key]['trainer_name'] = Trainer::where('id',$value->trainer_id)                            ->first()->name??'N/A';
        }
         
       
      
         }
         else
         {
         	
               $team = Team_Store::where('academicyear',$ac_year)->get();
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

     $eq=Membership::where('academicyear',$ac_year)->get();
        foreach($eq as $k=>$q){
            $l1=explode(",",$q->course_list);
            $cn=Course::whereIn('id',$l1)->select('title')->get()->toArray();
            $res = implode(",", array_column($cn, 'title'));
            $eq[$k]->course_list = $res;
        }
          

       $eq1 = Competitionstore::where('academicyear',$ac_year)->get()->map(function($input){
                 $date=date_create($input['Start_Date']);
                 $input['Start_Date']=date_format($date,"d/m/Y"); 
                 $Ragistration_Date=date_create($input['Ragistration_Date']);
                 $input['Ragistration_Date']=date_format($Ragistration_Date,"d/m/Y"); 
                  return $input;
                      });

        $sctr = SchoolTrainer::where('year',$ac_year)
                ->orderby('id','desc')
                ->get();
        foreach ($sctr as $key => $value) {
            $sctr[$key]['school_name'] = School::where('id',$value->school_id)->first()->school_name??'N/A';
             $sctr[$key]['trainer_name'] = Trainer::where('id',$value->trainer_id)->first()->name??'N/A';
        }

        
         } 

  
  
		return view('admin.Academicyearwisedetails.Academicyearpage',compact('team','eq1','eq','sctr','ac_year'));
	}

	public function check_data_according_to_year_wise(Request $req)
	{
        $count = AcademicYear::get();
        if(count($count)==0)
        {
		       $data = new AcademicYear();
		       $data->admin = 'admin';
		       $data->academicyear = $req->academicyear;
		       $data->save();
	      }
	    else
	    {
	      AcademicYear::where('admin', 'admin')
                      ->update([
                               'academicyear' => $req->academicyear,
                                ]);
	    }
         
	      Session::flash('success', "Updated Academic Year");
      return redirect('academic-year-wise-info/'.$req->academicyear);
	}

  public function available_student_in_plan($info)
  {
     $info = base64_decode($info);
     $info1 = explode("_", $info);
     $plan = $info1[0];

     $planname = Membership::where('id',$plan)->first()->name??'N/A';
     $acyear = $info1[1];
     $st = Participatestudent::
           where('year',$acyear)
           ->distinct()
           ->groupby('schoolid')
           ->where('planid',$plan)->get();
    foreach ($st as $key => $value) {
          $st[$key]['school_name'] = School::where('id',$value->schoolid)
                                     ->first()->school_name??'N/A';
          $st[$key]['student_count'] =   Participatestudent::select('student_id')                              ->where('year',$acyear)
                                          ->where('planid',$plan)
                                          ->where('schoolid',$value->schoolid)
                                          ->count();                      
    }
  return view('admin.Academicyearwisedetails.AcademicYearWisePlanSchoolstudent',compact('st','planname','acyear'));

  }

  public function avaiable_student_in_School_plan($info1)
  {    
          
         $info = explode("_",  base64_decode($info1));
         $acyear = $info[0];
         $plan = $info[1];
         $schoolid = $info[2];
         $planname = Membership::where('id',$plan)->first()->name??'N/A';
         $school_name = School::where('id',$schoolid)->first()->school_name??'N/A';
         $partistudent = Participatestudent::where('year',$acyear)
                  ->where('planid',$plan)
                  ->where('schoolid',$schoolid)
                  ->get(); 
         foreach ($partistudent as $key => $value) {
            $partistudent[$key]['studentname'] = Studentinfo::where('id',$value->student_id)->first()->name??'N/A';
         }

    return view('admin.Academicyearwisedetails.PlanStudentList',compact('partistudent','planname','acyear','school_name'));

  }

  public function academic_year_competition_school_Team($comp_id)
  {
      $comp_id = base64_decode($comp_id);
       $compname = Competitionstore::where('id',$comp_id)->first()->Competition_name??'N/A';
      $get = Schoolteamcomp::where('cmpid',$comp_id)
             ->groupby('school_id')
             ->get();
      foreach ($get as $key => $value) {
        $get[$key]['school_name'] = School::where('id',$value->school_id)
                                    ->first()->school_name??'N/A';
        $get[$key]['teamcount'] = Schoolteamcomp::
                                  select('tmpid')
                                  ->where('cmpid',$comp_id)
                                  ->where('school_id',$value->school_id)
                                  ->count();
      }

  return view('admin.Academicyearwisedetails.AcademicyearCompTeam',compact('compname','get'));
      dd($get);

  }

  public function academicYear_team_in_competition_School($ids)
  {
    $id = explode("_", base64_decode($ids));
    $schoolid = $id[0];
    $compid = $id[1];
     $compname = Competitionstore::where('id',$compid)->first()->Competition_name??'N/A';
    $team = Schoolteamcomp::where('cmpid',$compid)
                    ->where('school_id',$schoolid)
                    ->get();
    foreach ($team as $key => $value) {
     $team[$key]['teamname'] = Team_Store::where('id',$value->tmpid)
                               ->first()->team_Name??'N/A';                
    }
    return view('admin.Academicyearwisedetails.AcademicyearAvailableTeam',compact('compname','team'));
  }


  public function change_academic_year($id)
  {
      $schoolname = School::where('id',base64_decode($id))->first()->school_name??'N/A';
    
    return view('admin.Academicyearwisedetails.schoolChangeAcademicYear',compact('id','schoolname'));

  }

  public function Academic_year_submit(Request $req)
  {
        $schoolid = base64_decode($req->schoolid);
        Login_Academic_Year::where('school',$schoolid)->delete();
           $data = new Login_Academic_Year();
           $data->school = $schoolid;
           $data->academicyear = $req->academicyear;
           $data->save();
      

   return redirect('schoolv/'.$req->schoolid);
  }



}


?>