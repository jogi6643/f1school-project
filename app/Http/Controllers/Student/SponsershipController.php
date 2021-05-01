<?php
namespace App\Http\Controllers\Student;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use DB;
use Mail;
use App\Model\StudentModel\Team_Store;
use App\Model\StudentModel\StudentTeam_Role;
use App\Model\AssignedCoursetype;
use App\Model\Competition\Schoolteamcomp;
use App\Model\Competition\Competitionstore;
use App\Model\Sponser\SponserShip;
use Response;
use App\Login_Academic_Year;
use Cookie;
use App\Studentinfo;
use App\School;

class SponsershipController extends Controller
{
 
 public function add_sponsership($sch_stu_id)
 {
        
        // $email = Auth::user()->email;
    $studentid=Studentinfo::select('*')
               ->where('mobileno',Auth::user()
               ->mobile_no)->where('dob',Auth::user()->dob)
               ->first()->id; 

$schoolid = Studentinfo::select('*')->where('mobileno',Auth::user()->mobile_no)->where('dob',Auth::user()->dob)->first()->school_id;


        $stschId = explode("_", base64_decode($sch_stu_id));
        $sid = $stschId[0] . "_student";
        $scid = $stschId[1];
        $studentidd = $stschId[0];

        $studentname = Studentinfo::find($studentidd)->name;
        $schoolname = School::find($schoolid)->school_name;

        
        $ct1 = StudentTeam_Role::where('schoolid', $schoolid)
               ->where('studentid', $stschId[0])
               ->first();
               dd($ct1);
        $comp = Schoolteamcomp::select('cmpid')
                 ->where('school_id',$ct1->schoolid)
                 ->where('tmpid',$ct1->teamId)->get()->map(function($data){
			return $data->cmpid;
		})->toArray();

        if ($ct1 != null)
        {
            $ct = Team_Store::where('id', $ct1->teamId)
                ->first();
        }
        else
        {
            $ct = Team_Store::where('student_id', $sid)->where('school_id', $scid)->first();

        }


       $studentName = DB::table('students')->select('students.name', 'schools.school_name','students.register_type')
            ->join('schools', 'schools.id', '=', 'students.school_id')
            ->where('mobileno',Auth::user()->mobile_no)
            ->where('dob',Auth::user()->dob)
            ->first();

        $details = $this->viewsCousrseS();
        if ($details != [])
        {
            $assigndata = $details['details'];
            $systemdate = $details['systemdate'];
            $pname = $details['pname'];
            $studentid = $details['studentid'];
            $schoolid = $details['schoolid'];
            $planid = $details['planid'];
        }

        $compId = Schoolteamcomp::where('school_id', $schoolid)->count();
        $teamstoreCreateId = DB::table('team_store')->where('school_id', $schoolid)->where('student_id', $studentid . "_student")
        // ->where('created_at', date('Y'))
        ->count();

        $studenteamroleId = DB::table('studentTeam_Role')->where('schoolid', $schoolid)->where('studentid', $studentid)
        ->count();
          $Academicyear = Login_Academic_Year::where('school',$schoolid)->first()->academicyear??'N/A';
          
          $comptetion = Competitionstore::whereIN('id',$comp)
                         ->where('academicyear',$Academicyear)
                        ->get();

            
             // dd($my_cookie);
      //Create a response instance
                        $schoolid = $scid;
        
          return view('StudentCompetition.Sponsershipform', compact('teamstoreCreateId', 'studenteamroleId', 'compId', 'planid', 'schoolid', 'studentid', 'pname', 'systemdate', 'assigndata', 'studentName', 'sid', 'scid', 'studentname', 'schoolname', 'ct','comptetion','sch_stu_id'));
    
 }





 public function viewsCousrseS()
    {
        $email = Auth::user()->email;
        $data = [];
        $course_d = [];
        $pname = null;
        $planid = null;
        $studentid = DB::table('students')->where('studentemail', $email)->first()->id;

        $schoolid = DB::table('students')->where('studentemail', $email)->first()->school_id;

        $year = date("Y");
        $systemdate = date("Y-m-d");
        // dd($systemdate);
        $acyear = AssignedCoursetype::where('school_id', $schoolid)->where('student_id', $studentid)->first();

        if ($acyear != null)
        {
            $acyear2 = AssignedCoursetype::where('school_id', $schoolid)->where('student_id', $studentid)->first()->acyear;

            // ->acyear
            $planid = AssignedCoursetype::where('school_id', $schoolid)->where('student_id', $studentid)->first()->Plan_id;

            $pname = DB::table('memberships')->find($planid);

            $acyear1 = explode("-", $acyear2);

            if ($year == $acyear1[0])
            {

                $doc_course = AssignedCoursetype::select('doc_types_id', 'course_masters_id', 'assigneddate')->where('school_id', $schoolid)->where('student_id', $studentid)->get()->map(function ($data)
                {
                    return $data;
                })->toArray();

                //  $videoactivity= DB::table('videoactivity')->where('studentid',$studentid)->where('schoolid',$schooid)->where('planid',$planid)->orderby('id','desc')->first();
                foreach ($doc_course as $doc_course1)
                {
                    $videoactivity = DB::table('videoactivity')->where('studentid', $studentid)->where('vedioid', $doc_course1['course_masters_id'])->where('schoolid', $schoolid)->where('planid', $planid)->orderby('id', 'desc')
                        ->get()->map(function ($t)
                    {
                        return $t;
                    })->toArray();

                    $tet = isset($videoactivity[0]->resumevedio) ? $videoactivity[0]->resumevedio : 0;

                    $course_d[] = DB::table('courses')->join('course_masters', 'course_masters.id', '=', 'courses.course_masters_id')
                        ->join('doc_types', 'doc_types.id', '=', 'courses.doc_types_id')
                        ->where('courses.doc_types_id', $doc_course1['doc_types_id'])->where('courses.course_masters_id', $doc_course1['course_masters_id'])->get()->map(function ($data) use ($doc_course1, $tet)
                    {
                        $data->asshigneddate = $doc_course1['assigneddate'];
                        $data->resumevedio = $tet;
                        return $data;
                    })->toArray();

                }
            }
        }

        $data = array(
            'details' => $course_d,
            'systemdate' => $systemdate,
            'pname' => $pname,
            'studentid' => $studentid,
            'schoolid' => $schoolid,
            'planid' => $planid
        );
        return $data;
        
    }


    // Store SponserShip


    public function storesponsership(Request $req)
    {

        $validatedData = $req->validate([
        'competition_name' => 'required',
        'company_name' => 'required',
        'point_of_contact' => 'required',
        'EMAILID' => 'required',
        'PHONE_NUMBER' => 'required',
        'kmtype' => 'required',
        'DESCRIPTION' => 'required',
        'anex' => 'required',
        'teamid'=>'required',
        

    ]);
        
    
if ($req->hasFile('anex')) {
        $files = $req->file('anex');
       foreach ($req->company_name as $key => $value) {
         $image =$files[$key]->getClientOriginalExtension();
         $images = time().'.'.$image;
         $files[$key]->move(public_path('Sponserannexure'), $images);
         $data=new SponserShip();
         $data->competition_id=$req->competition_name;
          $data->teamid=$req->teamid;
         $data->company_name=$req->company_name[$key];
         $data->point_of_contact=$req->point_of_contact[$key];
         $data->EMAILID=$req->EMAILID[$key];
         $data->PHONE_NUMBER=$req->PHONE_NUMBER[$key];
         $data->kmtype=$req->kmtype[$key];
         $data->DESCRIPTION=$req->DESCRIPTION[$key];
         $data->anex=$images;
         $data->uploadedby=base64_decode($req->sch_stu_id);
         $data->save();
         
       } 
    }
    // $this->prviewsponsership($req->sch_stu_id);
    return redirect('prviewsponsership/'.$req->sch_stu_id);


    }


public function prviewsponsership($sch_stu_id)
{

        $stschId = explode("_", base64_decode($sch_stu_id));
        $sid = $stschId[0] . "_student";
        $scid = $stschId[1];

        $studentidd = $stschId[0];
       // $email = Auth::user()->email;
        $studentname = DB::table('students')->find($studentidd)->name;
        $schoolname = DB::table('schools')->find($scid)->school_name;

        
        $ct1 = DB::table('studentTeam_Role')->where('schoolid', $scid)->where('studentid', $stschId[0])
        ->first();

        if ($ct1 != null)
        {
            $ct = Team_Store::where('id', $ct1->teamId)
                ->first();
        }
        else
        {
            $ct = Team_Store::where('student_id', $sid)->where('school_id', $scid)->first();

        }

       $studentName = DB::table('students')->select('students.name', 'schools.school_name','students.register_type')
            ->join('schools', 'schools.id', '=', 'students.school_id')
            ->where('mobileno',Auth::user()->mobile_no)
            ->where('dob',Auth::user()->dob)
            ->first();

        $details = $this->viewsCousrseS();
        if ($details != [])
        {
            $assigndata = $details['details'];
            $systemdate = $details['systemdate'];
            $pname = $details['pname'];
            $studentid = $details['studentid'];
            $schoolid = $details['schoolid'];
            $planid = $details['planid'];
        }
        dd($schoolid);
        $compId = Schoolteamcomp::where('school_id', $schoolid)->count();
        $teamstoreCreateId = DB::table('team_store')->where('school_id', $schoolid)->where('student_id', $studentid . "_student")
        // ->where('created_at', date('Y'))
        ->count();

        $studenteamroleId = DB::table('studentTeam_Role')->where('schoolid', $schoolid)->where('studentid', $studentid)
        ->count();

         $comptetion = Competitionstore::all();
         $sponserdetails=SponserShip::where('uploadedby',base64_decode($sch_stu_id))
         ->join('Competitionstore','Competitionstore.id','=','SponserShip.competition_id')
         ->get();

    return view('StudentCompetition.priviewsponsership', compact('teamstoreCreateId', 'studenteamroleId', 'compId', 'planid', 'schoolid', 'studentid', 'pname', 'systemdate', 'assigndata', 'studentName', 'sid', 'scid', 'studentname', 'schoolname', 'ct','comptetion','sponserdetails','sch_stu_id'));
}

public function deletesponsership($company_name,$sch_stu_id)
{
  SponserShip::where('company_name',$company_name)->delete();
  return redirect('prviewsponsership/'.$sch_stu_id);
}

}

