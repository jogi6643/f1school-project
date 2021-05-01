<?php
// 30/06/2020
namespace App\Http\Controllers\StudentCollege;

use Illuminate\Http\Request;
use DB;
use Session;
use App\Payment;
use Redirect, Response;
use Auth;
use App\Activateaccount;
use App\CollegePayment;
use Mail;
use Alert;
use App\Model\StudentModel\Team_Store;
use App\Model\StudentModel\StudentTeam_Role;
use App\Model\AssignedCoursetype;
use App\Http\Controllers\Controller;
use App\Studentinfo;
use App\School;
use App\Login_Academic_Year;
use Validator;
// use App\Model\Competition\Schoolteamcomp;
// use App\Model\Manufacture\Stcarbodypart;
// use App\Model\Student;
class CollegeController extends Controller
{
    public function register_form()
    {

        $sendParameter = '';
        $states = DB::table('tbl_state')->get();
        return view('student_college.Register.register', compact('states', 'sendParameter'));
    }

    public function register(Request $request)
    {

        $validatedData = $request->validate(['first_name' => 'required', 'last_name' => 'required', 'email' => 'required|email|unique:schools', 'phone' => 'required|min:11|numeric', 'college' => 'required', 'password' => 'required|min:6', 'confarmation_password' => 'required|same:password', ]);

        if (!empty($request->teamEmail))
        {

            $checkStudent_type = DB::table('students')->where('studentemail', $request->teamEmail)
                ->where('register_type', 'F1Senior')
                ->first();

            if (!empty($checkStudent_type))
            {

                $checkTeam_store = DB::table('team_store')->where('student_id', $checkStudent_type->id)
                    ->where('school_id', $checkStudent_type->school_id)
                    ->first();

                if (!empty($checkTeam_store))
                {

                    $schoolData = DB::table('schools')->insert([

                    'school_name' => $request->college, 'type' => "college", 'state' => $request->state, 'city' => $request->city, 'mobile' => $request->phone, 'email' => $request->email, 'status' => '1']);

                    $get_id_school = DB::table('schools')->where('email', $request->email)
                        ->first()->id;

                    $studentData = DB::table('students')->insert([

                    'name' => $request->first_name . " " . $request->last_name, 'studentemail' => $request->email, 'mobileno' => $request->phone, 'dob' => $request->dob, 'school_id' => $get_id_school, 'register_type' => 'F1Senior', 'tsize' => $request->tshirt_size, 'status' => '1']);

                    $userData = DB::table('users')->insert([

                    'name' => $request->first_name . " " . $request->last_name, 'email' => $request->email, 'password' => bcrypt($request->password) , 'mobile_no' => $request->phone, 'role' => '6'

                    ]);

                    $get_id_student = DB::table('students')->where('studentemail', $request->email)
                        ->first()->id;

                    $userData = DB::table('studentTeam_Role')->insert([

                    'teamid' => $checkTeam_store->id, 'studentid' => $get_id_student, 'Role_studentid' => 'role_' . $get_id_student, 'studentRole' => $request->userRole, 'schoolid' => $get_id_school, 'status' => '1'

                    ]);

                    Session::flash('success', "Registered Successfully.....");

                }
                else
                {
                    Session::flash('success', "Sorry team is not created");
                }
            }
            else
            {

                Session::flash('success', "Sorry Yor are not register because team is not created");
            }

        }
        else
        {

            $schoolData = DB::table('schools')->insert([

            'school_name' => $request->college, 'type' => "college", 'state' => $request->state, 'city' => $request->city, 'mobile' => $request->phone, 'email' => $request->email, 'status' => '1']);

            $get_id_school = DB::table('schools')->where('email', $request->email)
                ->first()->id;

            $studentData = DB::table('students')->insert([

            'name' => $request->first_name . " " . $request->last_name, 'studentemail' => $request->email, 'mobileno' => $request->phone, 'dob' => $request->dob, 'school_id' => $get_id_school, 'register_type' => 'F1Senior', 'tsize' => $request->tshirt_size, 'status' => '1']);

            $userData = DB::table('users')->insert([

            'name' => $request->first_name . " " . $request->last_name, 'email' => $request->email, 'password' => bcrypt($request->password) , 'mobile_no' => $request->phone, 'role' => '6'

            ]);

            Session::flash('success', "Registered Successfully.....");

        }
        return redirect()
            ->back();

    }

    public function login_form()
    {

        return view('student_college.Register.login');
    }

    public function login(Request $req)
    {

        $validatedData = $req->validate(['email' => 'required|email', 'password' => 'required']);
        $credentials = $req->only('email', 'password');
        if (Auth::attempt($credentials))
        {
        
            $email = Auth::user()->email;
            $role = Auth::user()->role;
          
            if ($role == 6)
            {

                $check = Studentinfo::select('school_id')->where('studentemail', $email)->first();
                if ($check)
                {
                    $count = School::where('id', $check->school_id)
                        ->count();
                    if ($count == 0)
                    {
                        Auth::logout();
                        $req->session()
                            ->flash('danger', 'This user does not exits');
                        return redirect('/studentCollegeLogin');
                    }
                }

                $lastlogin = DB::table('students')->where('studentemail', $email)->update([

                "last_login" => time() ,

                ]);

                $status = DB::table('students')->where('studentemail', $email)->first()->status;

                if ($status == 1)
                {
                    $studentid = DB::table('students')->where('studentemail', $email)->first()->id;
                    $schoolid = DB::table('students')->where('studentemail', $email)->first()->school_id;
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

                    return redirect('/studentcollagedashboard');
                }
                else
                {

                    Auth::logout();
                    $req->session()
                        ->flash('danger', 'Dear Student Your Account has been disabled Contact to School');
                    return redirect('/studentCollegeLogin');
                }

            }
            else
            {
                Auth::logout();
                $req->session()
                    ->flash('danger', 'Permission Denied Please Check Your Url....');
                return redirect('/studentCollegeLogin');
            }

        }
        else
        {
            Auth::logout();
            $req->session()
                ->flash('danger', 'These credentials do not match our records.');
            return redirect('/studentCollegeLogin');
        }

    }

    public function student_home()
    {

        $email = Auth::user()->email;

        $role = Auth::user()->role;
        if ($role == 6)
        {

            $status = Studentinfo::where('studentemail', $email)->first()->status;

            if ($status == 1)
            {
                $studentid = Studentinfo::where('studentemail', $email)->first()->id;
                $schoolid = Studentinfo::where('studentemail', $email)->first()->school_id;

                $studentName = Studentinfo::select('students.name', 'schools.school_name', 'students.register_type','students.profileimage')
                    ->join('schools', 'schools.id', '=', 'students.school_id')
                    ->where('studentemail', $email)->first();


                //code start by upanshu
            

                //code end by upanshu
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
            
                return $this->studentprofile(base64_encode($studentid));

            }
        }
    }

    public function studentprofile($studentid)
    {

        $email = Auth::user()->email;
        $role = Auth::user()->role;

        if ($role == 6)
        {
            $status = Studentinfo::where('studentemail', $email)->first()->status;
            if ($status == 1)
            {
                
                    $studentid= Studentinfo::where('studentemail',$email)->first()->id;
                    $schoolid= Studentinfo::where('studentemail',$email)->first()->school_id;

                  $studentName = Studentinfo::select('students.name', 'schools.school_name', 'students.register_type','order_status','students.profileimage')
                    ->join('schools', 'schools.id', '=', 'students.school_id')
                    ->where('studentemail', $email)->first();
                //code end by upanshu
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

                $collageTeamId = StudentTeam_Role::where('studentid', $studentid)->first()->teamId??'N/A';
                if ($collageTeamId != 'N/A')
                {
                    $status = StudentTeam_Role::where('studentid', $studentid)->first()->status;
                    if ($status == 2)
                    {
                        $collageTeamId = 'N/A';
                        $collageTeamuserstatus = 2;
                    }
                    else
                    {
                        $collageTeamId = Team_Store::where('id', $collageTeamId)->first() ??'N/A';
                        $collageTeamuserstatus = $status;
                    }

                }
                else
                {
                    $collageTeamId = 'N/A';
                    $collageTeamuserstatus = 2;

                }

               

                 $data= Studentinfo::where('id',$studentid)->get()->map(function($input)use($studentid){
              $teamid = StudentTeam_Role::where('studentid',$studentid)->first()->teamId??"NO";
           
              $input['teamname']=Team_Store::where('id',$teamid)->first()->team_Name??"NO";
            

              $input['teamid']=Team_Store::where('id',$teamid)->first()->id??"NO";
              $input['classdata']=db::table('class')->select('id','class')->get()->toArray();
              $input['tshirt']=db::table('tshirt')->select('id','tsize')->get()->toArray();
                return $input;
                })->toArray();



                return view('student_college.Student.Collage_student_view', compact('assigndata', 'systemdate', 'pname', 'studentid', 'schoolid', 'planid', 'studentName', 'creatorteamid', 'data', 'appieddesign', 'oredersuccess', 'appiedcompetition', 'info', 'manufacture', 'email', 'collageTeamId', 'collageTeamuserstatus'));

            }
        }
    }

    public function get_city(Request $request)
    {

        $city = DB::table('tbl_city')->where('state_id', $request->city)
            ->get();
        return $city;
    }

    public function college_pay(Request $request)
    {

        $userid = Auth::user()->id;
        $useremail = Auth::user()->email;

        $data = ['user_id' => $userid, 'user_email' => $useremail, 'school_id' => $request->school_id, 'student_id' => $request->student_id, 'payment_id' => $request->razorpay_payment_id, 'amount' => $request->totalAmount, 'type' => 'F1senior', 'status' => 'success'];

        $getId = CollegePayment::insertGetId($data);
        $arr = array(
            'msg' => 'Payment successfully credited',
            'status' => true
        );

        $orderSuccess = DB::table('students')->where('studentemail', $useremail)->update([

        'order_status' => 'Success']);

        return Response()
            ->json($arr);
    }

    public function create_team($stschid)
    {

        //dd('ksks');
        $email = Auth::user()->email;
        $stschId = explode("_", base64_decode($stschid));
        $sid = $stschId[0];
        $scid = $stschId[1];
        $studentname = DB::table('students')->find($sid)->name;

        $students = DB::table('students')->select('id', 'name')
            ->where('school_id', $scid)->get();

        $studentName = DB::table('students')->select('students.id as student_id', 'students.name', 'students.register_type', 'students.order_status', 'schools.school_name', 'schools.id as school_id','students.profileimage')
            ->join('schools', 'schools.id', '=', 'students.school_id')
            ->where('studentemail', $email)->first();

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

        $collageTeamId = StudentTeam_Role::
        // where('schoolid',$schoolid)
        where('studentid', $studentid)
        // ->where('status',1)
        ->first()->teamId??'N/A';
        if ($collageTeamId != 'N/A')
        {
            $status = StudentTeam_Role::where('studentid', $studentid)->first()->status;
            if ($status == 2)
            {
                $collageTeamId = 'N/A';
                $collageTeamuserstatus = 2;
            }
            else
            {
                $collageTeamId = Team_Store::where('id', $collageTeamId)->first() ??'N/A';
                $collageTeamuserstatus = $status;
            }

        }
        else
        {
            $collageTeamId = 'N/A';
            $collageTeamuserstatus = 2;

        }
        //return view('student_college.Team.test');
        return view('student_college.Team.TeamCreate', compact('systemdate', 'assigndata', 'planid', 'schoolid', 'studentid', 'pname', 'studentName', 'sid', 'scid', 'students', 'studentname', 'collageTeamId', 'collageTeamuserstatus'));
    }

    public function team_store(Request $request)
    {

        $this->validate($request, ['Team_Name' => 'required|unique:team_store'
        // 'team_file' => 'required', 'team_file.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        $date = date('Y');
        $create_at = Team_Store::where('student_id', $request->student_id . "_student")
            ->where('school_id', $request->school_Id)
            ->whereraw("year(created_at)=$date")->first();

        $request->ids = array_unique($request->ids??[]);
        if ($create_at == null)
        {
            if ($request->hasfile('team_file'))
            {
                $image = $request->file('team_file');
                $name = $request->Team_Name . "_" . time() . "." . $image->getClientOriginalExtension();
                $image->move(public_path() . '/team/', $name);
                $team = new Team_Store();
                $team->team_Name = $request->Team_Name;
                $team->team_Description = $request->about_team;
                $team->team_Image = $name;
                $team->student_id = $request->student_id . "_student";
                $team->school_id = $request->school_Id;
                $team->typeofstudent = 'F1Senior';
                $team->save();
                
                $team->id;
                $studentRole = "role_" . $request->student_id;
                $s = new StudentTeam_Role();
                $s->teamId = $team->id;
                $s->schoolid = $request->school_Id;
                $s->studentid = $request->student_id;
                $s->Role_studentid = $studentRole;
                $s->studentRole = $request->CreatorRole;
                $s->status = 1;
                $s->typeofstudent = 'F1Senior';
                $s->save();

                foreach ($request->ids as $students_id)
                {

                    $studentRole = "role_" . $students_id;
                    $studentteamrole = new StudentTeam_Role();
                    $studentteamrole->teamId = $team->id;
                    $studentteamrole->schoolid = DB::table('team_store')
                        ->find($team->id)->school_id;
                    $studentteamrole->studentid = $students_id;
                    $studentteamrole->Role_studentid = $studentRole;
                    $studentteamrole->studentRole = $request->$studentRole;
                     $studentteamrole->typeofstudent = 'F1Senior';
                    $studentteamrole->save();

                    $ids = $students_id . "_" . $team->id;
                    $studentinfo = DB::table('students')->where('id', $students_id)->first();

                    $link = url('/collage_teamstatus') . "/" . base64_encode($ids);
                    $teamname = Team_Store::find($team->id)->team_Name;
                    $link1 = url('/collage_teams_no') . "/" . base64_encode($ids);
                    $data = array(
                        'username' => $studentinfo->name,
                        'email' => $studentinfo->studentemail,
                        'link' => $link,
                        'link1' => $link1,
                        'teamname' => $teamname
                    );

                    Mail::send('Mail.studentcollageinvitation', $data, function ($message) use ($data)
                    {

                        $message->to($data['email'], 'noreply@f1inschoolsindia.com')->subject('Welcome Aboard |F1 in Schools™ India');
                        $message->from('noreply@f1inschoolsindia.com', 'F1 in Schools™ India');

                    });
                }
                $idtoview = $request->student_id . '_' . $request->school_Id;
                return redirect('student/team/show/' . base64_encode($idtoview))->with('success', 'Team Created  has been successfully');
                // return back()->with('success', 'Team Created  has been successfully');
                
            }

            else
            {

                // $image = $request->file('team_file');
                // $name = $request->Team_Name . "_" . time() . "." . $image->getClientOriginalExtension();
                // $image->move(public_path() . '/team/', $name);
                $team = new Team_Store();
                $team->team_Name = $request->Team_Name;
                $team->team_Description = $request->about_team;
                $team->team_Image = '';
                $team->student_id = $request->student_id . "_student";
                $team->school_id = $request->school_Id;
                $team->typeofstudent = 'F1Senior';
                $team->save();
                
                $team->id;

                $studentRole = "role_" . $request->student_id;
                $s = new StudentTeam_Role();
                $s->teamId = $team->id;
                $s->schoolid = $request->school_Id;
                $s->studentid = $request->student_id;
                $s->Role_studentid = $studentRole;
                $s->studentRole = $request->CreatorRole;
                $s->status = 1;
                 $s->typeofstudent = 'F1Senior';
                $s->save();

                foreach ($request->ids as $students_id)
                {

                    $studentRole = "role_" . $students_id;
                    $studentteamrole = new StudentTeam_Role();
                    $studentteamrole->teamId = $team->id;
                    $studentteamrole->schoolid = DB::table('team_store')
                        ->find($team->id)->school_id;
                    $studentteamrole->studentid = $students_id;
                    $studentteamrole->Role_studentid = $studentRole;
                    $studentteamrole->studentRole = $request->$studentRole;
                     $studentteamrole->typeofstudent = 'F1Senior';
                    $studentteamrole->save();

                    $ids = $students_id . "_" . $team->id;
                    $studentinfo = DB::table('students')->where('id', $students_id)->first();
                    $link = url('/collage_teamstatus') . "/" . base64_encode($ids);
                    $link1 = url('/collage_teams_no') . "/" . base64_encode($ids);
                    $teamname = Team_Store::find($team->id)->team_Name;
                    $data = array(
                        'username' => $studentinfo->name,
                        'email' => $studentinfo->studentemail,
                        'link' => $link,
                        'link1' => $link1,
                        'teamname' => $teamname
                    );

                    Mail::send('Mail.studentcollageinvitation', $data, function ($message) use ($data)
                    {

                        $message->to($data['email'], 'noreply@f1inschoolsindia.com')->subject('Welcome Aboard |F1 in Schools™ India');
                        $message->from('noreply@f1inschoolsindia.com', 'F1 in Schools™ India');

                    });
                }
                $idtoview = $request->student_id . '_' . $request->school_Id;
                return redirect('student/team/show/' . base64_encode($idtoview))->with('success', 'Team Created  has been successfully');
                return back()
                    ->with('success', 'Team Created  has been successfully');

            }

        }
        else
        {

            $acadmicyr = explode('-', $create_at->created_at);
            if ($acadmicyr[0] == $date)
            {

                return back()->with('danger', 'Already Created Team this year');
            }
            else
            {
                if ($request->hasfile('team_file'))
                {

                    $image = $request->file('team_file');
                    $name = $request->Team_Name . "_" . time() . "." . $image->getClientOriginalExtension();
                    $image->move(public_path() . '/team/', $name);
                    $team = new Team_Store();
                    $team->team_Name = $request->Team_Name;
                    $team->team_Description = $request->about_team;
                    $team->team_Image = $name;
                    $team->student_id = $request->student_id;
                    $team->school_id = $request->school_Id;
                    $team->typeofstudent = 'F1Senior';
                    $team->save();
                    
                    $team->id;

                    $studentRole = "role_" . $request->student_id;
                    $s = new StudentTeam_Role();
                    $s->teamId = $team->id;
                    $s->schoolid = $request->school_Id;
                    $s->studentid = $request->student_id;
                    $s->Role_studentid = $studentRole;
                    $s->studentRole = $request->CreatorRole;
                    $s->status = 1;
                    $s->typeofstudent = 'F1Senior';
                    $s->save();

                    foreach ($request->ids as $students_id)
                    {

                        $studentRole = "role_" . $students_id;
                        $studentteamrole = new StudentTeam_Role();
                        $studentteamrole->teamId = $team->id;
                        $studentteamrole->schoolid = DB::table('team_store')
                            ->find($team->id)->school_id;
                        $studentteamrole->studentid = $students_id;
                        $studentteamrole->Role_studentid = $studentRole;
                        $studentteamrole->studentRole = $request->$studentRole;
                        $studentteamrole->typeofstudent = 'F1Senior';
                        $studentteamrole->save();
                        
                        $ids = $students_id . "_" . $team->id;

                        $teamname = Team_Store::find($team->id)->team_Name;
                        $studentinfo = DB::table('students')->where('id', $students_id)->first();
                        $link = url('/collage_teamstatus') . "/" . base64_encode($ids);
                        $link1 = url('/collage_teams_no') . "/" . base64_encode($ids);
                        $teamname = Team_Store::find($team->id)->team_Name;
                        $data = array(
                            'username' => $studentinfo->name,
                            'email' => $studentinfo->studentemail,
                            'link' => $link,
                            'link1' => $link1,
                            'teamname' => $teamname
                        );

                        Mail::send('Mail.studentcollageinvitation', $data, function ($message) use ($data)
                        {

                            $message->to($data['email'], 'noreply@f1inschoolsindia.com')->subject('Welcome Aboard |F1 in Schools™ India');
                            $message->from('noreply@f1inschoolsindia.com', 'F1 in Schools™ India');

                        });
                    }
                }

            }

            $idtoview = $request->student_id . '_' . $request->school_Id;

            return redirect('student/team/show/' . base64_encode($idtoview))->with('success', 'Team Created  has been successfully');
            // return back()->with('success', 'Team Created  has been successfully');
            
        }
    }

    public function view_team($stschid)
    {

        $email = Auth::user()->email;

        $stschId = explode("_", base64_decode($stschid));

        $sid = $stschId[0];

        $scid = $stschId[1];

        $studentname = DB::table('students')->find($sid)->name;
        $schoolname = DB::table('schools')->find($scid)->school_name;

        $check = StudentTeam_Role::where('studentid', $sid)->where('status', 1)
            ->first()->teamId??'N/A';

        if ($check != 'N/A')
        {
            // where('student_id',$sid."_student")->where('school_id',$scid)->
            $ct = Team_Store::where('id', $check)->get();
        }
        else
        {
            $ct = Team_Store::where('student_id', $sid . "_student")->where('school_id', $scid)->get();
        }

        $studentName = DB::table('students')->select('students.id as student_id', 'students.name', 'students.register_type', 'students.order_status', 'schools.school_name', 'schools.id as school_id'.'students.profileimage')
            ->join('schools', 'schools.id', '=', 'students.school_id')
            ->where('studentemail', $email)->first();

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

        $collageTeamId = StudentTeam_Role::
        // where('schoolid',$schoolid)
        where('studentid', $studentid)
        // ->where('status',1)
        ->first()->teamId??'N/A';
        if ($collageTeamId != 'N/A')
        {
            $status = StudentTeam_Role::where('studentid', $studentid)->first()->status;
            if ($status == 2)
            {
                $collageTeamId = 'N/A';
                $collageTeamuserstatus = 2;
            }
            else
            {
                $collageTeamId = Team_Store::where('id', $collageTeamId)->first() ??'N/A';
                $collageTeamuserstatus = $status;
            }

        }
        else
        {
            $collageTeamId = 'N/A';
            $collageTeamuserstatus = 2;

        }

        return view('student_college.Team.showTeam', compact('planid', 'schoolid', 'studentid', 'pname', 'systemdate', 'assigndata', 'studentName', 'sid', 'scid', 'studentname', 'schoolname', 'ct', 'collageTeamId', 'collageTeamuserstatus'));
    }

    public function view_team_member($tssdid)
    {

        $email = Auth::user()->email;

        $tssdId = explode("_", base64_decode($tssdid));

        $teamid = $tssdId[0];
        $scid = $tssdId[1];
        $studentname = DB::table('students')->where('id', $tssdId[2])->first()->name;

        $schoolname = DB::table('schools')->where('id', $tssdId[1])->first()->school_name;

        $Teamname = DB::table('team_store')->select('team_Image', 'team_Name', 'team_Description')
            ->where('id', $tssdId[0])->first();

        $assignmem = StudentTeam_Role::join('students', 'students.id', '=', 'studentTeam_Role.studentid')->select('students.id', 'students.name', 'studentTeam_Role.studentRole', 'studentTeam_Role.status', 'studentTeam_Role.created_at', 'studentTeam_Role.updated_at')
            ->where('teamId', $tssdId[0])->get();

        $studentName = DB::table('students')->select('students.id as student_id', 'students.name', 'students.register_type', 'students.order_status', 'schools.school_name', 'schools.id as school_id','students.profileimage')
            ->join('schools', 'schools.id', '=', 'students.school_id')
            ->where('studentemail', $email)->first();

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
        $collageTeamId = StudentTeam_Role::
        // where('schoolid',$schoolid)
        where('studentid', $studentid)
        // ->where('status',1)
        ->first()->teamId??'N/A';
        if ($collageTeamId != 'N/A')
        {
            $status = StudentTeam_Role::where('studentid', $studentid)->first()->status;
            if ($status == 2)
            {
                $collageTeamId = 'N/A';
                $collageTeamuserstatus = 2;
            }
            else
            {
                $collageTeamId = Team_Store::where('id', $collageTeamId)->first() ??'N/A';
                $collageTeamuserstatus = $status;
            }

        }
        else
        {
            $collageTeamId = 'N/A';
            $collageTeamuserstatus = 2;

        }

        return view('student_college.Team.view_team_member', compact('planid', 'schoolid', 'studentid', 'pname', 'systemdate', 'assigndata', 'studentName', 'scid', 'assignmem', 'schoolname', 'Teamname', 'studentname', 'teamid', 'collageTeamId', 'collageTeamuserstatus'));

    }

    public function student_college_search(Request $req)
    {

        $name = $req->name;

        $schoolid = $req->schoolid;

        $checkStudent = DB::table('students')->where('studentemail', $name)->first();

        if (!empty($checkStudent))
        {

            $getid = $checkStudent->id;

            if ($checkStudent->register_type == 'F1Senior')
            {

                //    $datacheck = StudentTeam_Role::where('studentid', $getid)->where('status',1)->first();
                // if(!empty($datacheck)){
                //  return json_encode(['error' => 'This person already exists in a team. Please try again with a new id.']);
                // }else{
                //  $data = DB::table('students')->where('studentemail', $name)->first();
                //  return json_encode($data);
                // }
                $status = StudentTeam_Role::where('studentid', $getid)->first()->status??2;
                if ($status == 2)
                {

                    // $users = User::where('id', '!=', Auth::id())->get();
                    $email = Auth::user()->email;
                    if ($email == $name)
                    {
                        return json_encode(['error' => 'OOps This Is  team Creator. Please try again with a new id.']);
                    }
                    else
                    {
                        $data = DB::table('students')->where('studentemail', $name)->first();
                        return json_encode($data);
                    }

                }
                else if ($status == 1)
                {
                    return json_encode(['error' => 'This person already exists in a team. Please try again with a new id.']);
                }
                else
                {

                    return json_encode(['error' => 'You have been already invited to a team. Please check your mail and complete the steps..']);

                }

                // if(!empty($datacheck)){
                //     return json_encode(['error' => 'This person already exists in a team. Please try again with a new id.']);
                // }else{
                //     $data = DB::table('students')->where('studentemail', $name)->first();
                //     return json_encode($data);
                // }
                

                
            }
            else
            {
                return json_encode(['error' => 'This email already asign to school']);
            }
        }
        else
        {

            return json_encode(['email' => $name]);
        }

    }

    public function inviteUser(Request $request)
    {

        $invite_email = Auth::user()->email;

        $user_email = $request->user_email;
        $user_role = $request->role;

        $sendUrl = $invite_email . "_" . $user_email . "_" . $user_role;

        $sendParameter = base64_encode($sendUrl);
        $sendParameter1 = base64_encode($sendUrl);

        $data = array(
            'username' => $user_email,
            'link' => $sendParameter,
            'link1' => $sendParameter1
        );

        $sendMail = Mail::send('Mail.userInvetitation', $data, function ($message) use ($data)
        {

            $message->to($data['username'], 'noreply@f1inschoolsindia.com')->subject('Welcome Aboard |F1 in Schools™ India');
            $message->from('noreply@f1inschoolsindia.com', 'F1 in Schools™ India');

        });

        return "success";
    }

    public function user_invitation($id)
    {

        $sendParameter = base64_decode($id);

        $explode = explode('_', $sendParameter);

        $team_email = $explode[0];
        $user_email = $explode[1];
        $user_role = $explode[2];

        $states = DB::table('tbl_state')->get();
        return view('student_college.Register.register', compact('states', 'sendParameter', 'team_email', 'user_email', 'user_role'));

    }

    public function user_invitation_reject($id)
    {

        $sendParameter = base64_decode($id);

        $explode = explode('_', $sendParameter);

        $team_email = $explode[0];
        $user_email = $explode[1];
        $user_role = $explode[2];

        $states = DB::table('tbl_state')->get();
        return view('student_college.Register.register', compact('states', 'sendParameter', 'team_email', 'user_email', 'user_role'));

    }

    public function viewsCousrseS()
    {
        $email=Auth::user()->email;
         $data=[];
         $course_d=[];
         $pname=null;
         $planid=null;

         $studentid = Studentinfo::where('studentemail',$email)->first()->id; 

         $schoolid = Studentinfo::where('studentemail',$email)->first()->school_id; 

         // $planid = DB::table('participantstudents')->where('schoolid',$schoolid)
         //         ->where('student_id',$studentid)->orderBy('id','desc')->first()->planid??0;
         $year=date("Y");
         $systemdate  =  date("Y-m-d");
         
        $year = Login_Academic_Year::where('school',$schoolid)->first()->academicyear??'N/A';
        if($year!='N/A')
        {
        $planid = Participatestudent::where('schoolid',$schoolid)
                 ->where('student_id',$studentid)
                 ->where('year',$year)
                 ->first()->planid??0;
        if($planid!=0)
        {
          $pname = Membership::where('id',$planid)->where('academicyear',$year)->first();
          $doc_course = AssignedCoursetype::
                        select('doc_types_id','course_masters_id','assigneddate')
                        ->where('school_id',$schoolid)
                        ->where('student_id',$studentid)
                        ->where('acyear',$year)
                        ->where('Plan_id',$planid)
                        ->orderBy('assignedCoursetypes.course_masters_id', 'asc')
                        ->groupBy('course_masters_id')
                        ->get()->map(function($data){
                         return $data;
                         })->toArray();
//***************************** Select Course From Assigned Course Type *************************

              foreach($doc_course as $doc_course1)
              {
                  $tet=isset($videoactivity[0]->resumevedio)?$videoactivity[0]->resumevedio:0;
               
                 $course_d[]=DB::table('courses')
                ->select('courses.id','courses.doc_types_id','courses.title','courses.description','courses.duration','courses.video_path','courses.doc_path','courses.thumbnail','doc_types.type')
                 ->join('course_masters','course_masters.id','=','courses.course_masters_id')
                 ->join('doc_types','doc_types.id','=','courses.doc_types_id')
                 ->where('courses.doc_types_id',$doc_course1['doc_types_id'])
                 ->where('courses.id',$doc_course1['course_masters_id'])
                 ->get()->map(function($data) use($doc_course1,$tet) {
                      $data->asshigneddate=$doc_course1['assigneddate'];

                     $data->resumevedio = $tet;

                      return $data;
                 })->toArray();
                
              }
//***************************** End  Select Course From Assigned Course Type *************************
        }        
        } 
      $data=array('details'=>$course_d,'systemdate'=>$systemdate,'pname'=>$pname,'studentid'=>$studentid,'schoolid'=>$schoolid,'planid'=>$planid);
     
      return $data;

    }

    public function collage_teamstatus($ids)
    {

        $arr = explode("_", base64_decode($ids));

        $s = $arr[0];
        $t = $arr[1];
        $up = StudentTeam_Role::where('studentid', $s)->where('teamId', $t)->update(['status' => 1]);
        return redirect('/studentCollegeLogin');

    }

    public function collage_teams_no($ids)
    {
        $arr = explode("_", base64_decode($ids));

        $s = $arr[0];
        $t = $arr[1];
        $up = StudentTeam_Role::where('studentid', $s)->where('teamId', $t)->update(['status' => 2]);
        return redirect('/studentCollegeLogin');
    }

    public function edit_team($ids)
    {

        $email = Auth::user()->email;

        $tssdId = explode("_", base64_decode($ids));

        $teamid = $tssdId[0];
        $school = $tssdId[1];
        $student = $tssdId[2];
        $studentname = Studentinfo::where('id', $tssdId[2])->first()->name;

        $schoolname = School::where('id', $tssdId[1])->first()->school_name;

        $editTeam = Team_Store::select('team_Image', 'team_Name', 'team_Description')->where('id', $tssdId[0])->first();

        $student = StudentTeam_Role::join('students', 'students.id', '=', 'studentTeam_Role.studentid')->where('teamId', $tssdId[0])->get();

        $student1 = StudentTeam_Role::join('students', 'students.id', '=', 'studentTeam_Role.studentid')->select('studentTeam_Role.studentid', 'students.name', 'studentTeam_Role.studentRole', 'studentTeam_Role.status')
            ->where('teamId', $tssdId[0])->get();

        $studentName = DB::table('students')->select('students.id as student_id', 'students.name', 'students.register_type', 'students.order_status', 'schools.school_name', 'schools.id as school_id','students.profileimage')
            ->join('schools', 'schools.id', '=', 'students.school_id')
            ->where('studentemail', $email)->first();

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
        $collageTeamId = StudentTeam_Role::
        // where('schoolid',$schoolid)
        where('studentid', $studentid)
        // ->where('status',1)
        ->first()->teamId??'N/A';
        if ($collageTeamId != 'N/A')
        {
            $status = StudentTeam_Role::where('studentid', $studentid)->first()->status;
            if ($status == 2)
            {
                $collageTeamId = 'N/A';
                $collageTeamuserstatus = 2;
            }
            else
            {
                $collageTeamId = Team_Store::where('id', $collageTeamId)->first() ??'N/A';
                $collageTeamuserstatus = $status;
            }

        }
        else
        {
            $collageTeamId = 'N/A';
            $collageTeamuserstatus = 2;

        }

        return view('student_college.Team.EditCollageTeam', compact('planid', 'schoolid', 'studentid', 'pname', 'systemdate', 'assigndata', 'studentName', 'scid', 'assignmem', 'schoolname', 'editTeam', 'student', 'student1', 'studentname', 'teamid', 'collageTeamId', 'collageTeamuserstatus'));
    }

    public function update_team(Request $req)
    {
        // dd($req->all());
        StudentTeam_Role::where('teamId', $req->Team_id)
            ->delete();
        $req->ids = array_unique($req->ids??[]);
        foreach ($req->ids as $students_id)
        {

            $y = explode("_", $students_id);
            $students_id = $y[0];
            $status = $y[1];
            $studentRole = "role_" . $students_id;
            $studentteamrole = new StudentTeam_Role();
            $studentteamrole->teamId = $req->Team_id;
            $studentteamrole->schoolid = DB::table('team_store')
                ->find($req->Team_id)->school_id;
            $studentteamrole->studentid = $students_id;
            $studentteamrole->Role_studentid = $studentRole;
            $studentteamrole->studentRole = $req->$studentRole;
            $studentteamrole->status = $status;
            $studentteamrole->typeofstudent = 'F1Senior';
            $studentteamrole->save();

            $ids = $students_id . "_" . $req->Team_id;
            $teamname = Team_Store::find($req->Team_id)->team_Name;
            $studentinfo = DB::table('students')->where('id', $students_id)->first();
            $link = url('/collage_teamstatus') . "/" . base64_encode($ids);
            $link1 = url('/collage_teams_no') . "/" . base64_encode($ids);
            $teamname = Team_Store::find($req->Team_id)->team_Name;
            $data = array(
                'username' => $studentinfo->name,
                'email' => $studentinfo->studentemail,
                'link' => $link,
                'link1' => $link1,
                'teamname' => $teamname
            );

            Mail::send('Mail.studentcollageinvitation', $data, function ($message) use ($data)
            {

                $message->to($data['email'], 'noreply@f1inschoolsindia.com')->subject('Welcome Aboard |F1 in Schools™ India');
                $message->from('noreply@f1inschoolsindia.com', 'F1 in Schools™ India');

            });

            // }
            
        }
        // dd($req->hasfile('team_file'));
        if ($req->hasfile('team_file'))
        {
            $image = $req->file('team_file');
            $name = $req->Team_Name . "_" . time() . "." . $image->getClientOriginalExtension();
            $image->move(public_path() . '/team/', $name);
            Team_Store::where('id', $req->Team_id)
                ->update(['team_Name' => $req->Team_Name, 'team_Description' => $req->about_team, 'team_Image' => $name, ]);

        }
        else
        {
            Team_Store::where('id', $req->Team_id)
                ->update(['team_Name' => $req->Team_Name, 'team_Description' => $req->about_team,
            // 'team_Image' => $name,
            ]);
        }
        $ids = $req->Team_id . "_" . $req->school_Id . "_" . $req->student_id;
        return redirect('/student/team/view_team_member/' . base64_encode($ids));
        dd($req->all());
    }


    public function student_Collage_profileedit(Request $req)
   {
       if($req->ajax())
       {
        $studentid=$req->id;
        //$data= Student::where('id',$studentid)->first()->toArray();
              $data= Studentinfo::where('id',$studentid)->get()->map(function($input) use($studentid){
              $teamid=StudentTeam_Role::where('studentid',$studentid)->select('teamid')->first();
               if(isset($teamid))
               {
                $teamid=StudentTeam_Role::where('studentid',$studentid)->select('teamid')->first()->toArray();
                $input['teamname']=Team_Store::where('id',$teamid)->first()->team_Name; 
               }
               else{
                $input['teamname']='No Team Exists';
               }                           
              $input['classdata']=db::table('class')->select('id','class')->get()->toArray();  
              $input['tshirt']=db::table('tshirt')->select('id','tsize')->get()->toArray(); 
                return $input;
                })->toArray();
              return response()->json($data);
       // echo json_encode($data);
       }

   }

      public function updatestudentCollageinfo(Request $request)
   {  
    $data = $request->all();

    

        $rules = array(
            'name' => ['regex:/^([a-zA-Z0-9]+|[a-zA-Z0-9]+\s{1}[a-zA-Z0-9]{1,}|[a-zA-Z0-9]+\s{1}[a-zA-Z0-9]{3,}\s{1}[a-zA-Z0-9]{1,})$/i'],
         'mobileno' => 'digits:10',
            'guardianname1' => ['sometimes',
            'nullable',
            'regex:/^([a-zA-Z0-9]+|[a-zA-Z0-9]+\s{1}[a-zA-Z0-9]{1,}|[a-zA-Z0-9]+\s{1}[a-zA-Z0-9]{3,}\s{1}[a-zA-Z0-9]{1,})$/i'],
            'guardianphone1' => 'sometimes|nullable|digits:10',
            'guardianemail1' => 'sometimes|nullable|email',
            'guardianname2' => ['sometimes',
            'nullable',
            'regex:/^([a-zA-Z0-9]+|[a-zA-Z0-9]+\s{1}[a-zA-Z0-9]{1,}|[a-zA-Z0-9]+\s{1}[a-zA-Z0-9]{3,}\s{1}[a-zA-Z0-9]{1,})$/i'],
            'guardianphone2' => 'sometimes|nullable|digits:10',
            'guardianemail2' => 'sometimes|nullable|email'
        );

        $error = Validator::make($request->all() , $rules);

        if ($error->fails())
        {
            return response()
                ->json(['errors' => $error->errors()
                ->all() ]);
        }

        try
        {
        
            $check = Studentinfo::where('id', $data['hid'])->update(['name' => $data['name'], 'class' => $data['class'], 'section' => $data['section'], 'dob' => $data['dob'], 'mobileno' => $data['mobileno'], 'address' => $data['address'], 'tsize' => $data['tsize'], 'guardianname1' => $data['guardianname1'], 'guardianemail1' => $data['guardianemail1'], 'guardianphone1' => $data['guardianphone1'], 'guardianname2' => $data['guardianname2'], 'guardianemail2' => $data['guardianemail2'], 'guardianphone2' => $data['guardianphone2'],'profileimage'=>$data['image111']]);
        }
        catch(\Exception $e)
        {
             echo json_encode($e->getMessage());
            return response()->json(['errors' => $e]);
        }

        //dd($check);
        if ($check)
        {
            return response()->json(['success' => 'Data Updated Successfully.']);

           
        }


   }

public function upload_image_StudentCollage(Request $request)

    {

        $image = $request->image;



        list($type, $image) = explode(';', $image);

        list(, $image)      = explode(',', $image);

        $image = base64_decode($image);
       
        $image_name= time().'.png';

        $path = public_path('studentprofileimage/'.$image_name);



        file_put_contents($path, $image);

        return response()->json(['status'=>$image_name]);

    }

// *******************************************Competition Process in Student Collage**************************************

//***********************************End Competition Process in Student Collage**************************************

    public function logout()
    {
        Auth::logout();
        Session::flush();
        return redirect('/studentCollegeLogin');
    }

}

