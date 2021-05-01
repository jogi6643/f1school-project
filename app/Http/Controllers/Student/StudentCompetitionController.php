<?php
namespace App\Http\Controllers\Student;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use DB;
use Mail;
use Alert;
use App\Model\StudentModel\Team_Store;
use App\Model\Teammember;
use App\Model\StudentModel\StudentTeam_Role;
use App\Model\AssignedCoursetype;
use App\Model\Competition\Schoolteamcomp;
use App\Studentinfo;
use App\School;
class StudentCompetitionController extends Controller
{

    public function createTeam($stschid)
    {
        // $email = Auth::user()->email;
        $stschId = explode("_", base64_decode($stschid));
        $sid = $stschId[0];
        $scid = $stschId[1];
        $studentiddd=$sid."_student";
        $checkTeamId = DB::table('team_store')
                      ->where('student_id',$studentiddd)
                      ->where('school_id',$scid)
                      ->first();
  if($checkTeamId==null){

 $strole= DB::table('studentTeam_Role')
                        ->where('studentid',$sid)
                        ->where('schoolid',$scid)
                        ->first();
if($strole==null)
{
     $creatorteamid ='N/A';
}
else
{
$creatorteamid =$strole->studentid;
}
                     
                        


  }else{

   $creatorteamid = $checkTeamId->id;                     
  }

        $studentname = DB::table('students')->find($sid)->name;

        $students = DB::table('students')->select('id', 'name')
            ->where('school_id', $scid)->get();

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
        // ->where('created_at', date('Y'))
        ->count();

        return view('StudentCompetition.CreateTeam', compact('creatorteamid','teamstoreCreateId', 'studenteamroleId', 'compId', 'systemdate', 'assigndata', 'planid', 'schoolid', 'studentid', 'pname', 'studentName', 'sid', 'scid', 'students', 'studentname'));
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

public function teamstore(Request $request)
    {
      dd($request->all());
        $this->validate($request, ['Team_Name' => 'required|unique:team_store'
            // 'team_file' => 'required', 'team_file.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'

        ]);

        $date = date('Y');

        $create_at = Team_Store::where('student_id', $request->student_id)
            ->where('school_id', $request->school_Id)
            ->whereraw("year(created_at)=$date")->first();
            
          $request->ids=array_unique($request->ids??[]);
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
                    $s->save();

			// if(count($request->ids)>$count)
			// {
			// 	$new=new Teammember();
			// 	$new->team_id=$team->id;
			// 	$new->member=1;
			// 	$new->save();
			// };

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
                    $studentteamrole->save();
                                      
                    $ids = $students_id . "_" . $team->id;
                    $studentinfo = DB::table('students')->where('id', $students_id)->first();
                    $link =url('/teamstatus')."/".base64_encode($ids);
                    $rejectlink = url('/teamstatusreject')."/".base64_encode($ids);
                    $teamname = Team_Store::find($team->id)->team_Name;

                    $data = array(
                        'username' => $studentinfo->name,
                        'email' => $studentinfo->studentemail,
                        'link' => $link,
                        'rejectlink'=>$rejectlink,
                        'teamname'=>$teamname
                    );
                     // *********************************************Mobile Message****************************************************
             $link2 = url('/invitation-School'). "/" . base64_encode($ids); 

            $student = Studentinfo::find($students_id);
            $schoolname = School::where('id',$student->school_id)->first()->school_name;
             $apikey = "YXPskaQxMk6oxtQcQbPo2Q";
             $apisender = "TOSAPP";
             $msg = "Dear ".strtoupper($student->name).",\r\n".$schoolname." Welcome aboard the world’s largest STEM based challenge for school - F1 in Schools™ online Platform. You have been requested to join the team.".$teamname."\r\nPlease click on the link to accept the invitation\r\n click here:".$link2;

              $num ='91'.$student->mobileno;     // MULTIPLE NUMBER VARIABLE PUT HERE...! 
              // $num ='91'.'8700488718';                
             $ms = rawurlencode($msg);   //This for encode your message content                     
            $url = 'https://www.smsgatewayhub.com/api/mt/SendSMS?APIKey='.$apikey.'&senderid='.$apisender.'&channel=2&DCS=0&flashsms=0&number='.$num.'&text='.$ms.'&route=1';
                               
           //echo $url;
           $ch=curl_init($url);
           curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
           curl_setopt($ch,CURLOPT_POST,1);
           curl_setopt($ch,CURLOPT_POSTFIELDS,"");
           curl_setopt($ch, CURLOPT_RETURNTRANSFER,2);
            $data = curl_exec($ch);
           curl_error($ch);
           // *****************************End *******************************
                 // Mail::send('Mail.StudentInvitationmail', $data, function ($message) use ($data)
                 //        {

                 //            $message->to($data['email'], 'noreply@f1inschoolsindia.com')->subject('Welcome Aboard | Season 3 | F1 in Schools™ India');
                 //            $message->from('noreply@f1inschoolsindia.com','F1 in Schools™ India');

                 //        });
                }
                $idtoview = $request->student_id . '_' . $request->school_Id;
                return redirect('viewTeam/' . base64_encode($idtoview))->with('success', 'Team Created  has been successfully');
               
             
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
                $team->save();
                $team->id;

                    $studentRole = "role_" . $request->student_id;
                    $s = new StudentTeam_Role();
                    $s->teamId = $team->id;
                    $s->schoolid = $request->school_Id;
                    $s->studentid = $request->student_id;
                    $s->Role_studentid = $studentRole;
                    $s->studentRole = $request->CreatorRole;
                     $s->status = 5;
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
                    $studentteamrole->save();
                                      
                    $ids = $students_id . "_" . $team->id;
                    $studentinfo = DB::table('students')->where('id', $students_id)->first();
                    $link =url('/teamstatus')."/".base64_encode($ids);
                      $rejectlink = url('/teamstatusreject')."/".base64_encode($ids);
                       $teamname = Team_Store::find($team->id)->team_Name;
                    $data = array(
                        'username' => $studentinfo->name,
                        'email' => $studentinfo->studentemail,
                        'link' => $link,
                        'rejectlink'=>$rejectlink,
                        'teamname'=>$teamname
                    );

     // *********************************************Mobile Message****************************************************
             $link2 = url('/invitation-School'). "/" . base64_encode($ids); 

            $student = Studentinfo::find($students_id);
            $schoolname = School::where('id',$student->school_id)->first()->school_name;
             $apikey = "YXPskaQxMk6oxtQcQbPo2Q";
             $apisender = "TOSAPP";
             $msg = "Dear ".strtoupper($student->name).",\r\n".$schoolname." Welcome aboard the world’s largest STEM based challenge for school - F1 in Schools™ online Platform. You have been requested to join the team.".$teamname."\r\nPlease click on the link to accept the invitation\r\n click here:".$link2;

              $num ='91'.$student->mobileno;     // MULTIPLE NUMBER VARIABLE PUT HERE...! 
              // $num ='91'.'8700488718';                
             $ms = rawurlencode($msg);   //This for encode your message content                     
            $url = 'https://www.smsgatewayhub.com/api/mt/SendSMS?APIKey='.$apikey.'&senderid='.$apisender.'&channel=2&DCS=0&flashsms=0&number='.$num.'&text='.$ms.'&route=1';
                               
           //echo $url;
           $ch=curl_init($url);
           curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
           curl_setopt($ch,CURLOPT_POST,1);
           curl_setopt($ch,CURLOPT_POSTFIELDS,"");
           curl_setopt($ch, CURLOPT_RETURNTRANSFER,2);
            $data = curl_exec($ch);
           curl_error($ch);
           // *****************************End *******************************
                 // Mail::send('Mail.StudentInvitationmail', $data, function ($message) use ($data)
                 //        {

                 //            $message->to($data['email'], 'noreply@f1inschoolsindia.com')->subject('Welcome Aboard | Season 3 | F1 in Schools™ India');
                 //            $message->from('noreply@f1inschoolsindia.com','F1 in Schools™ India');

                 //        });
                }
                $idtoview = $request->student_id . '_' . $request->school_Id;
                return redirect('viewTeam/' . base64_encode($idtoview))->with('success', 'Team Created  has been successfully');



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
                        $studentteamrole->save();
                     
                        $ids = $students_id . "_" . $team->id;
                        $teamname = Team_Store::find($team->id)->team_Name;
                        $studentinfo = DB::table('students')->where('id', $students_id)->first();
                      $link = url('/teamstatus')."/".base64_encode($ids);
                      $rejectlink = url('/teamstatusreject')."/".base64_encode($ids);
                        $data = array(
                            'username' => $studentinfo->name,
                            'email' => $studentinfo->studentemail,
                            'link' => $link,
                            'rejectlink'=>$rejectlink,
                            'teamname'=>$teamname
                        );
                          
            // *********************************************Mobile Message****************************************************
             $link2 = url('/invitation-School'). "/" . base64_encode($ids); 

            $student = Studentinfo::find($students_id);
            $schoolname = School::where('id',$student->school_id)->first()->school_name;
             $apikey = "YXPskaQxMk6oxtQcQbPo2Q";
             $apisender = "TOSAPP";
             $msg = "Dear ".strtoupper($student->name).",\r\n".$schoolname." Welcome aboard the world’s largest STEM based challenge for school - F1 in Schools™ online Platform. You have been requested to join the team.".$teamname."\r\nPlease click on the link to accept the invitation\r\n click here:".$link2;

              $num ='91'.$student->mobileno;     // MULTIPLE NUMBER VARIABLE PUT HERE...! 
              // $num ='91'.'8700488718';                
             $ms = rawurlencode($msg);   //This for encode your message content                     
            $url = 'https://www.smsgatewayhub.com/api/mt/SendSMS?APIKey='.$apikey.'&senderid='.$apisender.'&channel=2&DCS=0&flashsms=0&number='.$num.'&text='.$ms.'&route=1';
                               
           //echo $url;
           $ch=curl_init($url);
           curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
           curl_setopt($ch,CURLOPT_POST,1);
           curl_setopt($ch,CURLOPT_POSTFIELDS,"");
           curl_setopt($ch, CURLOPT_RETURNTRANSFER,2);
            $data = curl_exec($ch);
           curl_error($ch);
           // *****************************End *******************************
                        // Mail::send('Mail.StudentInvitationmail', $data, function ($message) use ($data)
                        // {

                        //     $message->to($data['email'], 'noreply@f1inschoolsindia.com')->subject('Welcome Aboard | Season 3 | F1 in Schools™ India');
                        //     $message->from('noreply@f1inschoolsindia.com','F1 in Schools™ India');

                        // });
                    }
                }

            }

            $idtoview = $request->student_id . '_' . $request->school_Id;
            return redirect('viewTeam/' . base64_encode($idtoview))->with('success', 'Team Created  has been successfully');
           
            
        }

    }


public function invitation_School($id)
{

    return view('StudentCompetition.yes_no', compact('id'));
}
    public function invitation(Request $request)
    {
        $s_tid = base64_decode($request->id);
        $arr = explode('_', $request->id);
        $s = $arr[0];
        $t = $arr[1];
        $up = StudentTeam_Role::where('studentid', $s)->where('teamId', $t)->update(['status' => 1]);

        if (($request->no) == 2)
        {
            $up = StudentTeam_Role::where('studentid', $s)->where('teamId', $t)->update(['status' => 2]);
        }
        return redirect('studentlogin');
    }

    public function viewTeam($stschid)
    {
        // $email = Auth::user()->email;

        $stschId = explode("_", base64_decode($stschid));



        // $sid=$stschId[0]."_student";
        $sid = $stschId[0] . "_student";
        $scid = $stschId[1];
        $studentidd = $stschId[0];
        

        $studentiddd=$sid."_student";
 

  $checkTeamId = DB::table('team_store')
                      ->where('student_id',$sid)
                      ->where('school_id',$scid)
                      ->first();
  if($checkTeamId==null){

 $strole= DB::table('studentTeam_Role')
                        ->where('studentid',$sid)
                        ->where('schoolid',$scid)
                        ->first();
if($strole==null)
{
     $creatorteamid ='N/A';
}
else
{
$creatorteamid =$strole->studentid;
}
                     
                        


  }else{

   $creatorteamid = $checkTeamId->id;                     
  }
        $studentname = DB::table('students')->find($studentidd)->name;
        $schoolname = DB::table('schools')->find($scid)->school_name;

        // $ct=Team_Store::
        //        where('student_id',$sid)
        //        ->where('school_id',$scid)->get();
        // dd($ct);
        $ct1 = DB::table('studentTeam_Role')->where('schoolid', $scid)->where('studentid', $stschId[0])
        // ->where('created_at', date('Y'))
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
        $compId = Schoolteamcomp::where('school_id', $schoolid)->count();
        $teamstoreCreateId = DB::table('team_store')->where('school_id', $schoolid)->where('student_id', $studentid . "_student")
        // ->where('created_at', date('Y'))
        ->count();

        $studenteamroleId = DB::table('studentTeam_Role')->where('schoolid', $schoolid)->where('studentid', $studentid)
        // ->where('created_at', date('Y'))
        ->count();
      return redirect("assignmember/".base64_encode($ct->id."_".$ct->school_id."_".$ct->student_id));
        // return view('StudentCompetition.ViewTeam', compact('teamstoreCreateId', 'studenteamroleId', 'compId', 'planid', 'schoolid', 'studentid', 'pname', 'systemdate', 'assigndata', 'studentName', 'sid', 'scid', 'studentname', 'schoolname', 'ct'));
    }

    public function editteam($tssid)
    {

        // $email = Auth::user()->email;

      
        $tssId = explode("_", base64_decode($tssid));
         
        // dd($tssId);
         $studentid = Studentinfo::select('*')
                    ->where('mobileno',Auth::user()->mobile_no)
                    ->where('dob',Auth::user()->dob)
                    ->first()->id; 
    
       $s1 = $studentid;
         $schoolid = Studentinfo::select('*')->where('mobileno',Auth::user()->mobile_no)
                    ->where('dob',Auth::user()->dob)
                    ->first()->school_id; 

          $teamId = $tssId[0];
          $school_id = $tssId[1];
          $student_id=$tssId[2];
         
        $check  = Team_Store::where('id',$teamId)
                    ->first()->student_id??0;

           if($check!=0)
           {
              $check = explode("_", $check);
              if($check[1]=="student")
              {
                $check = $check[0];
              }
              else
              {
                $check = 0;
              }
           }
           else
           {
            $check = 0; 
           }

   
          // $is_type = $tssId[3];

            // switch ($is_type)
            // {
            //     case 'admin':
            //         $studentname = DB::table('users')->find($student_id)->name;
                    
            //     break;

            //     case 'trainer':
            //         $studentname = DB::table('trainers')->find($student_id)->name;
            //     break;

            //     case 'student':
            $studentname = DB::table('students')->find($student_id)->name;
            //     break;
            // }

        $createdby =  $student_id . "_" .'student';
        // $studentname = DB::table('students')->find($tssId[2])->name;

       // $edit = Team_Store::where('id', $teamId)->where('school_id', $school_id)->where('student_id',  $createdby)->first();
        $edit=StudentTeam_Role::
        join('students', 'students.id', '=', 'studentTeam_Role.studentid')->where('schoolid', $school_id)->where('teamId',  $teamId)->first();
        
        $student = StudentTeam_Role::
        join('students', 'students.id', '=', 'studentTeam_Role.studentid')->where('teamId',  $teamId)->get();
        $student1 = StudentTeam_Role::join('students', 'students.id', '=', 'studentTeam_Role.studentid')->select('studentTeam_Role.studentid','students.name','studentTeam_Role.studentRole','studentTeam_Role.status')->where('teamId',  $teamId)->get();
// ->where('studentTeam_Role.status')

       $creatorrole = StudentTeam_Role::join('students', 'students.id', '=', 'studentTeam_Role.studentid')->where('teamId',  $teamId)->where('studentTeam_Role.status',1)->first();
       
   

    $studentName = DB::table('students')->select('students.name', 'schools.school_name','students.register_type')
            ->join('schools', 'schools.id', '=', 'students.school_id')
            ->where('mobileno',Auth::user()->mobile_no)
            ->where('dob',Auth::user()->dob)
            ->first();

        $details = $this->viewsCousrseS();
        //dd($details);
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

        $teamstoreCreateId = DB::table('team_store')->where('school_id', $schoolid)->where('student_id', $s1 . "_student")
        // ->where('created_at', date('Y'))
        ->count();
        $teamstore1 = DB::table('team_store')->where('school_id', $schoolid)->where('student_id', $s1 . "_student")
      
        ->first();
        
        if($teamstore1==null)
        {
            
              $teamstore1 = DB::table('studentTeam_Role')->where('schoolid', $schoolid)->where('studentid', $s1)
        // ->where('created_at', date('Y'))
        ->first();
        $teamstore1 = DB::table('team_store')->where('id',$teamstore1->teamId)
      
        ->first();
      
        

        }
       
      

        $studenteamroleId = DB::table('studentTeam_Role')->where('schoolid', $schoolid)->where('studentid', $s1)
        // ->where('created_at', date('Y'))
        ->count();
        // $data = array(
        //               'username'=>$studentName,
        //               'email'=>$studentinfo->studentemail,
        //               'link'=>$ids
        //             );
        //     Mail::send('Mail.StudelntInvitationmail', $data, function($message)use($data){
        //         $message->to('upanshu.sharma@studiokrew.com', 'noreply@timeofsports.com')
        //         ->subject('Welcome   to F1school');
        //         $message->from('noreply@timeofsports.com','F1School');
        //       });

      
        return view('StudentCompetition.editTeam', compact('teamstore1','teamstoreCreateId', 'studenteamroleId', 'compId', 'planid', 'schoolid', 'studentid', 'pname', 'systemdate', 'assigndata', 'studentName', 'edit','creatorrole', 'student', 'student1', 'studentname','check'));
    }

    public function teamupdate(Request $request)
    {

        $ids = $request->student_id . "_" . $request->school_Id;
        if (!$request->hasfile('team_file'))
        {
           
            $this->validate($request, ['Team_Name' => 'required', ]);

            $count = StudentTeam_Role::where('teamId', $request->teamid)
                ->count();

          dd($request->ids);
            if ($request->ids != null)
            {
                $up = Team_Store::where('id', $request->teamid)
                    ->where('school_id', $request->school_Id)
                    ->update(['team_Name' => $request->Team_Name, 'team_Description' => $request->about_team]);

                       StudentTeam_Role::where('teamId',$request->teamid)
                                    ->where('status',0)
                                    ->delete();
 // Updated Team 
                 $check = StudentTeam_Role::where('teamId',$request->teamid)
                                    ->where('schoolid',$request->school_Id)
                                    ->where('studentid',$request->student_id)
                                    ->first();
                
                 $studentRole = "role_" . $request->student_id;
               if($check!=null)
               {
                  if($check->status==5)
                  {
                    
                    StudentTeam_Role::where('teamId',$request->teamid)
                                    ->where('schoolid',$request->school_Id)
                                    ->where('studentid',$request->student_id)
                                    ->where('status',5)
                                    ->update(['studentRole' => $request->CreatorRole, 'status' => 5]);
                  }
               }

// End Updated Team

                foreach ($request->ids as $students_id)
                {

                    $studentRole = "role_" . $students_id;
                       $checkteamrole=StudentTeam_Role::where('teamId',$request->teamid)
                                    ->where('schoolid',$request->school_Id)
                                    ->where('studentid',$students_id)
                                    ->where('status',5)
                                    ->first();
         
                    if($checkteamrole==null)
                    {   

                        $checkstudent=StudentTeam_Role::where('teamId',$request->teamid)
                                    ->where('schoolid',$request->school_Id)
                                    ->where('studentid',$students_id)
                                    ->where('status',1)
                                    ->first();
            
                    if($checkstudent==null)
                     {
                     
                    $studentteamrole = new StudentTeam_Role();
                    $studentteamrole->teamId = $request->teamid;
                    $studentteamrole->schoolid = DB::table('team_store')
                        ->find($request->teamid)->school_id;
                    $studentteamrole->studentid = $students_id;
                    $studentteamrole->Role_studentid = $studentRole;
                    $studentteamrole->studentRole = $request->$studentRole;
                    $studentteamrole->save();
                    $ids = $students_id . "_" . $request->teamid;
                    $teamname = Team_Store::find($request->teamid)->team_Name;
                    $studentinfo = DB::table('students')->where('id', $students_id)->first();
                    $link =url('/teamstatus')."/".base64_encode($ids);
                    $rejectlink = url('/teamstatusreject')."/".base64_encode($ids);
                    
// *********************************************Mobile Message****************************************************
             $link2 = url('/invitation-School'). "/" . base64_encode($ids); 

            $student = Studentinfo::find($students_id);
            $schoolname = School::where('id',$student->school_id)->first()->school_name;
             $apikey = "YXPskaQxMk6oxtQcQbPo2Q";
             $apisender = "TOSAPP";
             $msg = "Dear ".strtoupper($student->name).",\r\n".$schoolname." Welcome aboard the world’s largest STEM based challenge for school - F1 in Schools™ online Platform. You have been requested to join the team.".$teamname."\r\nPlease click on the link to accept the invitation\r\n click here:".$link2;

              $num ='91'.$student->mobileno;     // MULTIPLE NUMBER VARIABLE PUT HERE...! 
              // $num ='918700488718';                
             $ms = rawurlencode($msg);   //This for encode your message content                     
            $url = 'https://www.smsgatewayhub.com/api/mt/SendSMS?APIKey='.$apikey.'&senderid='.$apisender.'&channel=2&DCS=0&flashsms=0&number='.$num.'&text='.$ms.'&route=1';
                               
           //echo $url;
           $ch=curl_init($url);
           curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
           curl_setopt($ch,CURLOPT_POST,1);
           curl_setopt($ch,CURLOPT_POSTFIELDS,"");
           curl_setopt($ch, CURLOPT_RETURNTRANSFER,2);
            $data = curl_exec($ch);
           curl_error($ch);

        
           // *****************************End *******************************

                   if($studentinfo->studentemail!=null)
                   {
                    $data = array(
                        'username' => $studentinfo->name,
                        'email' => $studentinfo->studentemail,
                        'link' => $link,
                        'rejectlink'=>$rejectlink,
                         'teamname'=> $teamname
                    );


                    // $data['email']
                     // Mail::send('Mail.StudentInvitationmail', $data, function ($message) use ($data)
                     //    {

                     //        $message->to($data['email'], 'noreply@f1inschoolsindia.com')->subject('Welcome Aboard | Season 3 | F1 in Schools™ India');
                     //        $message->from('noreply@f1inschoolsindia.com','F1 in Schools™ India');

                     //    });
                 }

                 }
               else
               {


                  StudentTeam_Role::where('teamId',$request->teamid)
                                    ->where('schoolid',$request->school_Id)
                                    ->where('studentid',$students_id)
                                    ->where('status',1)
                                    ->update(['studentRole' => $request->$studentRole,
                                     // 'Role_studentid'=>$studentRole,     
                                     'status' => 1]);

                    // $studentteamrole = new StudentTeam_Role();
                    // $studentteamrole->teamId = $request->teamid;
                    // $studentteamrole->schoolid = DB::table('team_store')
                    //     ->find($request->teamid)->school_id;
                    // $studentteamrole->studentid = $students_id;
                    // $studentteamrole->Role_studentid = $studentRole;
                    // $studentteamrole->studentRole = $request->$studentRole;
                    // $studentteamrole->save();


               }



}
                

                }

            }
            else
            {
                $up = Team_Store::where('id', $request->teamid)
                    ->delete();

                StudentTeam_Role::where('teamId', $request->teamid)
                    ->delete();

            }

        }
        else
        {

          
            $this->validate($request, ['Team_Name' => 'required', 'team_file' => 'required', 'team_file.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'

            ]);

            if ($request->hasfile('team_file'))
            {

                $image = $request->file('team_file');

               
                $name = $request->Team_Name . "_" . time() . "." . $image->getClientOriginalExtension();
                $image->move(public_path() . '/team/', $name);
                $up = Team_Store::where('id', $request->teamid)
                    // ->where('student_id', $request->student_id)
                    ->where('school_id', $request->school_Id)
                    ->update(['team_Name' => $request->Team_Name, 'team_Description' => $request->about_team, 'team_Image' => $name]);
                
                    StudentTeam_Role::where('teamId',$request->teamid)
                                    ->where('status',0)
                                    ->delete();
 
 // Updated Team 
                 $check= StudentTeam_Role::where('teamId',$request->teamid)
                                    ->where('schoolid',$request->school_Id)
                                    ->where('studentid',$request->student_id)
                                    ->first();
                 $studentRole = "role_" . $request->student_id;
                  if($check->status==5)
                  {
               
                    StudentTeam_Role::where('teamId',$request->teamid)
                                    ->where('schoolid',$request->school_Id)
                                    ->where('studentid',$request->student_id)
                                    ->where('status',5)
                                    ->update(['studentRole' => $request->CreatorRole, 'status' => 5]);
                  }

              
              

                foreach ($request->ids as $students_id)
                {


                 
                    $checkteamrole=StudentTeam_Role::where('teamId',$request->teamid)
                                    ->where('schoolid',$request->school_Id)
                                    ->where('studentid',$students_id)
                                    ->where('status',5)
                                    ->first();
                    

                    if($checkteamrole==null)
                    {  
                       $checkstudent=StudentTeam_Role::where('teamId',$request->teamid)
                                    ->where('schoolid',$request->school_Id)
                                    ->where('studentid',$students_id)
                                    ->where('status',1)
                                    ->first();

                    if($checkstudent==null)
                     {
                    $studentRole = "role_" . $students_id;
                    $studentteamrole = new StudentTeam_Role();
                    $studentteamrole->teamId = $request->teamid;
                    $studentteamrole->schoolid = DB::table('team_store')
                        ->find($request->teamid)->school_id;
                    $studentteamrole->studentid = $students_id;
                    $studentteamrole->Role_studentid = $studentRole;
                    $studentteamrole->studentRole = $request->$studentRole;
                    $studentteamrole->save();

                    $ids = $students_id . "_" . $request->teamid;
                    $teamname = Team_Store::find($request->teamid)->team_Name;
                    $studentinfo = DB::table('students')->where('id', $students_id)->first();
                     $link =url('/teamstatus')."/".base64_encode($ids);
                     $rejectlink = url('/teamstatusreject')."/".base64_encode($ids);
                        // *********************************************Mobile Message****************************************************
             $link2 = url('/invitation-School'). "/" . base64_encode($ids); 

            $student = Studentinfo::find($students_id);
            $schoolname = School::where('id',$student->school_id)->first()->school_name;
             $apikey = "YXPskaQxMk6oxtQcQbPo2Q";
             $apisender = "TOSAPP";
             $msg = "Dear ".strtoupper($student->name).",\r\n".$schoolname." Welcome aboard the world’s largest STEM based challenge for school - F1 in Schools™ online Platform. You have been requested to join the team.".$teamname."\r\nPlease click on the link to accept the invitation\r\n click here:".$link2;

              $num ='91'.$student->mobileno;     // MULTIPLE NUMBER VARIABLE PUT HERE...!
               // $num ='918700488718';                  
             $ms = rawurlencode($msg);   //This for encode your message content                     
            $url = 'https://www.smsgatewayhub.com/api/mt/SendSMS?APIKey='.$apikey.'&senderid='.$apisender.'&channel=2&DCS=0&flashsms=0&number='.$num.'&text='.$ms.'&route=1';
                               
           //echo $url;
           $ch=curl_init($url);
           curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
           curl_setopt($ch,CURLOPT_POST,1);
           curl_setopt($ch,CURLOPT_POSTFIELDS,"");
           curl_setopt($ch, CURLOPT_RETURNTRANSFER,2);
            $data = curl_exec($ch);
           curl_error($ch);

        
           // *****************************End *******************************

                     if($studentinfo->studentemail!=null)
                     {
                    $data = array(
                        'username' => $studentinfo->name,
                        'email' => $studentinfo->studentemail,
                        'link' => $link,
                        'teamname'=> $teamname,
                        'rejectlink'=>$rejectlink,
                    );
    
    // *********************************************Mobile Message****************************************************
             $link2 = url('/invitation-School'). "/" . base64_encode($ids); 

            $student = Studentinfo::find($students_id);
            $schoolname = School::where('id',$student->school_id)->first()->school_name;
             $apikey = "YXPskaQxMk6oxtQcQbPo2Q";
             $apisender = "TOSAPP";
             $msg = "Dear ".strtoupper($student->name).",\r\n".$schoolname." Welcome aboard the world’s largest STEM based challenge for school - F1 in Schools™ online Platform. You have been requested to join the team.".$teamname."\r\nPlease click on the link to accept the invitation\r\n click here:".$link2;

               $num ='91'.$student->mobileno;     // MULTIPLE NUMBER VARIABLE PUT HERE...!
               // $num ='918700488718';                  
             $ms = rawurlencode($msg);   //This for encode your message content                     
            $url = 'https://www.smsgatewayhub.com/api/mt/SendSMS?APIKey='.$apikey.'&senderid='.$apisender.'&channel=2&DCS=0&flashsms=0&number='.$num.'&text='.$ms.'&route=1';
                               
           //echo $url;
           $ch=curl_init($url);
           curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
           curl_setopt($ch,CURLOPT_POST,1);
           curl_setopt($ch,CURLOPT_POSTFIELDS,"");
           curl_setopt($ch, CURLOPT_RETURNTRANSFER,2);
            $data = curl_exec($ch);
           curl_error($ch);

          
           // *****************************End *******************************
           

                    // $data['email']
                    // Mail::send('Mail.StudentInvitationmail', $data, function ($message) use ($data)
                    //     {

                    //         $message->to($data['email'], 'noreply@f1inschoolsindia.com')->subject('Welcome Aboard | Season 3 | F1 in Schools™ India');
                    //         $message->from('noreply@f1inschoolsindia.com','F1 in Schools™ India');

                    //     });
                    }
      
                }

                else
                {
                     StudentTeam_Role::where('teamId',$request->teamid)
                                    ->where('schoolid',$request->school_Id)
                                    ->where('studentid',$students_id)
                                    ->where('status',1)
                                    ->update(['studentRole' => $request->$studentRole,
                                     // 'Role_studentid'=>$studentRole,     
                                     'status' => 1]);
                }

}
                }



            }
        }
        //


        // $ids1 = $request->student_id . "_" . $request->school_Id;
        // // $Id = explode("_", ($request->student_id));
        // $Id = collect($request->student_id);
        // $Id->pop();
        // $Id->push($request->school_Id);
        // $ids1 = $Id;
        // $ids1 = $Id[0] . "_" . $Id[1];



      return redirect("assignmember/".base64_encode($request->teamid."_".$request->school_Id."_".$request->student_id));

        // return redirect('viewTeam/' . base64_encode($ids1))->with('success', 'Team Updated  has been successfully');
        echo 1;
        die;

    }

    public function deleteteam($deltssid)
    {
        $deltssId = explode("_", base64_decode($deltssid));

        $del = Team_Store::where('id', $deltssId[0])->where('student_id', $deltssId[2] . "_" . $deltssId[3])->where('school_id', $deltssId[1])->delete();
        StudentTeam_Role::where('teamId', $deltssId[0])->delete();
        $ids = $deltssId[2] . "_" . $deltssId[1];

        return redirect('viewTeam/' . base64_encode($ids))->with('success', 'Team deleted  has been successfully');
    }
    public function studentseach(Request $req)
    {
        $name = $req->name;
        $schoolid = $req->schoolid;
        $studentideee = $req->student_id;

        $studentroleid = DB::table('studentTeam_Role')
            ->select('studentid')
            ->where('schoolid', $schoolid)->where('status',0)->orwhere('status',1)->get();


        $arra = [];
        $arra2 = [];
         $arra1=[];

        if (count($studentroleid) > 0)
        {
            foreach ($studentroleid as $studentroleid)
            {
                $arra[] = $studentroleid->studentid;
                $arra[] = $studentideee;
            }
            $arra1 = array_unique($arra);
            $studentid = DB::table('students')->select('id')
                ->where('school_id', $schoolid)->get();
            foreach ($studentid as $studentid)
            {
                $arra2[] = $studentid->id;
            }
        }
        else
        {
            $arra1[] = $studentideee;
            $studentid = DB::table('students')->select('id')
                         ->where('school_id', $schoolid)
                         // ->where('status',0)
                         // ->orwhere('status',1)
                         ->where('username','!=',null)
                         ->get();
            foreach ($studentid as $studentid)
            {
                $arra2[] = $studentid->id;
            }
        }
      
        $value = array_diff($arra2, $arra1);
        
        $studentname = DB::table('students')
                       ->select('*')
                       ->where('school_id', $schoolid)
                       ->whereIn('id', $value)
                       ->where('username','!=',null)
                       ->where('name', 'LIKE', "%$name%")
                       ->get();
        return json_encode($studentname);



    }

  
    public function assignmember($tssdid)
    {

        // $email = Auth::user()->email;

        $tssdId = explode("_", base64_decode($tssdid));
        $teamid = $tssdId[0];
        $scid = $tssdId[1];


        // Fetach the Student and SchoolId 
        $studentid = Studentinfo::select('*')
                    ->where('mobileno',Auth::user()->mobile_no)
                    ->where('dob',Auth::user()->dob)
                    ->first()->id; 
    
       $s1 = $studentid;
         $schoolid = Studentinfo::select('*')->where('mobileno',Auth::user()->mobile_no)
                    ->where('dob',Auth::user()->dob)
                    ->first()->school_id; 

        // Fetach the Student and SchoolId

        $studentname = Studentinfo::select('*')->where('mobileno',Auth::user()->mobile_no)->where('dob',Auth::user()->dob)->first()->name; 
        $schoolname = School::where('id', $tssdId[1])->first()->school_name;

        

        $Teamname = Team_Store::select('team_Image', 'team_Name', 'team_Description')
            ->where('id', $tssdId[0])->first();

        $assignmem = StudentTeam_Role::join('students', 'students.id', '=', 'studentTeam_Role.studentid')->select('students.id', 'students.name', 'studentTeam_Role.studentRole', 'studentTeam_Role.status', 'studentTeam_Role.created_at', 'studentTeam_Role.updated_at','students.studentemail','students.mobileno')
            ->where('teamId', $tssdId[0])->get();

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
        // ->where('created_at', date('Y'))
        ->count();
       // dd($studentid);
        $checkstudentstatus = DB::table('studentTeam_Role')
                              ->where('teamId', $tssdId[0])
                              ->where('studentid', $s1)
                              ->where('schoolid', $schoolid)
        ->first();
      
        $edit=$tssdid;
       
        return view('StudentCompetition.Assignmember', compact('teamstoreCreateId', 'studenteamroleId', 'compId', 'planid', 'schoolid', 'studentid', 'pname', 'systemdate', 'assigndata', 'studentName', 'scid', 'assignmem', 'schoolname', 'Teamname', 'studentname', 'teamid','edit','checkstudentstatus'));

    }

    public function deletestudentteam($ssttid)
    {

        $data = explode("_", base64_decode($ssttid));
        $studentid = Team_Store::where('id', $data[1])->where('school_id', $data[2])->first()->student_id;
        $tt = $data[1] . "_" . $data[2] . "_" . $studentid;
        $del = StudentTeam_Role::where('teamId', $data[1])->where('studentid', $data[0])->where('schoolid', $data[2])->delete();
        return redirect('assignmember/' . base64_encode($tt));
    }


public function teamstatus($ids)
{

   $team_student=base64_decode($ids);
    $tt=explode("_",$team_student);
 $scheck = StudentTeam_Role::where('studentid', $tt[0])->where('teamId', $tt[1])->where('status' , 1)->orwhere('status',2)->count();
  
  if($scheck==0)
  {
    $team_student=base64_decode($ids);
    $tt=explode("_",$team_student);
    $check = StudentTeam_Role::where('studentid',$tt[0])
    ->orwhere('status',2)->orwhere('status',0)->get();
    if(count($check)==0)
    {
    $teamname = Team_Store::find($tt[1])->team_Name;
    StudentTeam_Role::where('teamId',$tt[1])->where('studentid',$tt[0])
    ->update(['status'=>1]);
    }
    else
    {
       foreach ($check as $key => $value) {
        
		   $team=Teammember::where('team_id',$tt[1])->orderby('id','desc')->get();
        
		   if(count($team)==0){
			   $new=new Teammember();
				$new->team_id=$tt[1];
				$new->member=1;
				$new->save();
		   }
		   else{
			    $team=Teammember::find($team[0]->id);
				$team->member=1;
				$team->save();
			   
		   }
           if($value->teamId==$tt[1])
           {
           
              $teamname = Team_Store::find($tt[1])->team_Name;
             StudentTeam_Role::where('teamId',$tt[1])->where('studentid',$tt[0])
             ->update(['status'=>1]);
           }
           else
           {
             // echo $value->teamId."==".$tt[1];
             StudentTeam_Role::where('studentid',$tt[0])->
             where('teamId',$value->teamId)->delete();
           }
       }

    }    

    ?>
    <script type="text/javascript">
      alert("Congratulations! Now you are a part of the <?= $teamname; ?>");
      location.href="http://167.99.198.174/studentlogin";
    </script>
      <?php
  }
  else
  {
    return view('StudentCompetition.message');
  }
    
  }

  public function teamstatusreject($ids)
{
    $team_student=base64_decode($ids);
 
    $tt=explode("_",$team_student);

 $team_student=base64_decode($ids);
    $tt=explode("_",$team_student);
 $scheck = StudentTeam_Role::where('studentid', $tt[0])->where('teamId', $tt[1])->where('status' , 1)->orwhere('status',2)->count();
  
  if($scheck==0)
  {
    $teamname = Team_Store::find($tt[1])->team_Name;
   
    StudentTeam_Role::where('teamId',$tt[1])->where('studentid',$tt[0])
    ->update(['status'=>2]);
    ?>
    <script type="text/javascript">
      alert("Your response has been sent to the admin!");
      location.href="http://167.99.198.174/studentlogin";
    </script>
      <?php
    
  }
  else
  {
     return view('StudentCompetition.message');
  }
}

}

