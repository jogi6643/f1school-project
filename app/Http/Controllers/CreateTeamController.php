<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Trainer;
use App\School;
use App\User;
use App\Model\SchoolTrainer;
use Mail;
use DB;
use Illuminate\Database\QueryException;
use Alert;
use App\Events\assigrntrainerE;
use App\Email\NotificationMail;
use App\Model\Teammember;
use Auth;
use App\Model\StudentModel\Team_Store;
use App\Model\StudentModel\StudentTeam_Role;
use App\Studentinfo;

class CreateTeamController extends Controller
{
    public function index()
    {

        try
        {
            $schoolnames = DB::table('schools')->select('id', 'school_name')
                ->get()
                ->toArray();

        }
        catch(\Exception $e)
        {
            return $e->getMessage();
        }
        return view('admin.ViewTeam.assignschool', compact('schoolnames'));
    }

    public function createteambyad($id,Request $req)
    {
        $d = explode('_', base64_decode($id));
		if(Auth::user()->role==1)
			{
				
			}
			else
			{
			 
			  if(($req->session()->all()['data'][14]??0)!=1)
				{
					$req->session()->flash('status','You do not have right to access this module');
					
					return redirect('/schoolv/'.base64_encode($d[2]));
				}		 
			}
        
        $data['admin_name'] = $d[0];
        $data['admin_id'] = $d[1];
        $data['school_id'] = $d[2];
        $data['schoolname'] = School::where('id',$d[2])->first()->school_name;
        return view('admin.ViewTeam.createteambyad', compact('data'));
    }

    public function teamstorebyad(Request $request)
    {
        // $data=$request->admin_id;
       
        $this->validate($request, ['team_Name' => 'required|unique:team_store',
        // 'team_file' => 'required',
        // 'team_file.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        if ($request->hasfile('team_file'))
        {

            $image = $request->file('team_file');
            $name = $request->team_Name . "_" . time() . "." . $image->getClientOriginalExtension();
            $image->move(public_path() . '/team/', $name);

            $team = new Team_Store();

            $team->team_Name = $request->team_Name;
            $team->team_Description = $request->about_team;
            $team->team_Image = $name;
            $team->student_id = $request->admin_id . "_admin";
            $team->school_id = $request->school_Id;
            // $team->academicyear = $request->academicyear;
            $team->save();

            $team->id;
			if(count($request->ids)>$count)
			{
				$new=new Teammember();
				$new->team_id=$team->id;
				$new->member=count($request->ids);
				$new->save();
			};

            foreach ($request->ids as $students_id)
            {

                $studentRole = "role_" . $students_id;
                 StudentTeam_Role::where('studentid',$students_id)->where('status',2)->delete();
                $studentteamrole = new StudentTeam_Role();
                $studentteamrole->teamId = $team->id;
                $studentteamrole->schoolid = DB::table('team_store')
                    ->find($team->id)->school_id;
                $studentteamrole->studentid = $students_id;
                $studentteamrole->Role_studentid = $studentRole;
                $studentteamrole->studentRole = $request->$studentRole;
                $studentteamrole->save();

            }
            $ids = $students_id . "_" . $team->id;
            $studentinfo = DB::table('students')->where('id', $students_id)->first();

            $schoolid = base64_encode($request->school_Id);
            return redirect('viewTeamad/' . $schoolid)->with('success', 'Team Created  has been successfully');

        }

        else
        {
            $team = new Team_Store();

            $team->team_Name = $request->team_Name;
            $team->team_Description = $request->about_team;
            $team->student_id = $request->admin_id . "_admin";
            $team->school_id = $request->school_Id;
            $team->academicyear = $request->academicyear;
            $team->save();

            $team->id;

            foreach ($request->ids as $students_id)
            {

                $studentRole = "role_" . $students_id;
                  StudentTeam_Role::where('studentid',$students_id)->where('status',2)->delete();
                $studentteamrole = new StudentTeam_Role();
                $studentteamrole->teamId = $team->id;
                $studentteamrole->schoolid = DB::table('team_store')
                    ->find($team->id)->school_id;
                $studentteamrole->studentid = $students_id;
                $studentteamrole->Role_studentid = $studentRole;
                $studentteamrole->studentRole = $request->$studentRole;
                $studentteamrole->status = 1;
                $studentteamrole->save();

            }
            $ids = $students_id . "_" . $team->id;
            $studentinfo = DB::table('students')->where('id', $students_id)->first();

            $schoolid = base64_encode($request->school_Id);
            return redirect('viewTeamad/' . $schoolid)->with('success', 'Team Created  has been successfully');
        }

    }

    public function studentseachbyad(Request $req)
    {
      $name = $req->name;
        $schoolid = $req->schoolid;

        $studentroleid = DB::table('studentTeam_Role')->select('studentid')
            ->where('schoolid', $schoolid)->where('status',0)->orwhere('status',1)->orwhere('status',5)->get();

           $teamstudentcreate = Team_Store::select('student_id')
            ->where('school_id', $schoolid)->get();
           
            $teamstudent=[];
            if(count($teamstudentcreate)!=0)
            {
            foreach($teamstudentcreate as $teamstudentcreate1)
            {
                  $s=explode("_", $teamstudentcreate1->student_id);
                if($s[1]=="student")
                {
                  
                         $teamstudent[]=$s[0];
                    
                   

                }
            }
        }

         


        $arra = [];
        $arra2 = [];

        if ($studentroleid != null)
        {
            foreach ($studentroleid as $studentroleid)
            {
                $arra[] = $studentroleid->studentid;
            }

          

            $arra1 = array_unique($arra);

              $a2=array_merge($arra1,$teamstudent);

            $studentid = DB::table('students')
                         ->select('id')
                         ->where('school_id', $schoolid)
                         // ->where('status',0)
                         // ->orwhere('status',1)
                         // ->orwhere('status',5)
                         ->where('username','!=',null)
                         ->get();
            foreach ($studentid as $studentid)
            {
                $arra2[] = $studentid->id;
            }
        }
        $value = array_diff($arra2, $a2);


        $studentname = DB::table('students')
                       ->select('*')
                       ->where('school_id', $schoolid)
                       ->whereIn('id', $value)
                       ->where('username','!=',null)
                       ->where('name', 'LIKE', "%$name%")
                       ->get();
            return json_encode($studentname);
       
    }

    public function viewTeamad($id,Request $req)
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
        $email = Auth::user()->email;
        $name = Auth::user()->name;
         $currentyear = date("Y");
         $id = base64_decode($id);
          $schoolname = School::where('id',$id)->first()->school_name;
        

        // $trschool=DB::table('team_store')->where('school_id',$id)->get();
        
        // $trschool = DB::table('team_store')->where('school_id', $id)->
        //  StudentTeam_Role::where('teamId',140)->delete();
        // DB::table('team_store')->where('id',140)->delete();
        // echo 1;
        // die;
        $trschool = DB::table('team_store')->where('school_id', $id)->get()->map(function ($data) use ($name)
        {
            $data->school_name = School::find($data->school_id)->school_name;
            $data->ss = explode("_", $data->student_id);
            if ($data->ss[1] == 'trainer')
            {
                $data->student_name = DB::table('trainers')
                    ->first()->name . "(Trainer)";
            }
            elseif ($data->ss[1] == 'student')
            {
                $data->student_name = Studentinfo::find($data->student_id)->name . "(Student)";
            }
            else
            {
                $data->student_name = $name . "(admin)";
            }
            return $data;
        })->toArray();
        return view('admin.ViewTeam.teamList', compact('trschool','schoolname'));
    }

    public function deleteteambyad($id)
    {

        $deltssId = explode("_", base64_decode($id));
        $del = Team_Store::where('id', $deltssId[0])->delete();
        StudentTeam_Role::where('teamId', $deltssId[0])->delete();
        $ids = $deltssId[2] . "_" . $deltssId[1];
        return redirect()->back()
            ->with('success', 'Team deleted  has been successfully');
    }

    public function editteambyad($id)
    {

        $tssId = explode("_", base64_decode($id));
        //dd($tssId);
        $id_team_store_table = $tssId[0];
        $admin_id = $tssId[1];
        $createdby = $tssId[2];
        $school_id = $tssId[3];
        //kundan
        if (count($tssId) == 3)
        {

            $studentname = DB::table('students')->find($tssId[1])->name;

            $edit = Team_Store::where('id', $tssId[0])->where('school_id', $tssId[2])->where('student_id', $tssId[1])->first();

            $student = StudentTeam_Role::join('students', 'students.id', '=', 'studentTeam_Role.studentid')->where('teamId', $tssId[0])->get();
            $student1 = StudentTeam_Role::join('students', 'students.id', '=', 'studentTeam_Role.studentid')->where('teamId', $tssId[0])->get();
        }
        else
        {

            $student_id = $tssId[1];
            $is_type = $tssId[2];

            switch ($is_type)
            {
                case 'admin':
                    $studentname = DB::table('users')->find($student_id)->name;
                    $check = $student_id;
                break;

                case 'trainer':
                    $studentname = DB::table('trainers')->find($tssId[1])->name;
                    $check = $tssId[1];
                break;

                case 'student':
                    $studentname = DB::table('students')->find($student_id)->name;
                    $check = $student_id;
                break;
            }

            $trid = $tssId[1] . "_" . $tssId[2];

            $edit = Team_Store::where('id', $tssId[0])->where('school_id', $tssId[3])->where('student_id', $trid)->first();

            $student = StudentTeam_Role::join('students', 'students.id', '=', 'studentTeam_Role.studentid')->where('teamId', $tssId[0])->get();

            $student1 = StudentTeam_Role::join('students', 'students.id', '=', 'studentTeam_Role.studentid')->where('teamId', $tssId[0])->get();

        }
        return view('admin.ViewTeam.editteambyad', compact('edit', 'student', 'student1', 'studentname','check'));

    }
    public function teamupdatebyad(Request $request)
    {
        // $data = $request->all();
        // echo"<pre>"; print_r($data);die;
        
  $count = StudentTeam_Role::where('teamId', $request->teamid)
                ->count();
				
        $request->hasfile('team_file');
        $image = $request->file('team_file');
        $ids = $request->student_id . "_" . $request->school_Id;
        if ($image == null)
        {
            $this->validate($request, ['Team_Name' => 'required', ]);

            $up = Team_Store::where('id', $request->teamid)
                ->where('student_id', $request->student_id)
                ->where('school_id', $request->school_Id)
                ->update(['team_Name' => $request->Team_Name, 
                    'team_Description' => $request->about_team,
                    'team_Description' => $request->about_team,
                    // 'academicyear' => $request->academicyear,
                ]);

                   StudentTeam_Role::where('teamId', $request->teamid)
                     ->delete();
					 if(count($request->ids)>$count)
			{
				$new=new Teammember();
				$new->team_id=$request->teamid;
				$new->member=count($request->ids);
				$new->save();
			};
            foreach ($request->ids as $students_id)
            {
                 StudentTeam_Role::where('studentid',$students_id)->where('status',2)->delete();
                $studentRole = "role_" . $students_id;
                $studentteamrole = new StudentTeam_Role();
                $studentteamrole->teamId = $request->teamid;
                $studentteamrole->schoolid = DB::table('team_store')
                    ->find($request->teamid)->school_id;
                $studentteamrole->studentid = $students_id;
                $studentteamrole->Role_studentid = $studentRole;
                $studentteamrole->status = 1;

                $studentteamrole->studentRole = $request->$studentRole;
                $studentteamrole->save();

            }

        }
        else
        {
            $this->validate($request, ['Team_Name' => 'required', 'team_file' => 'required', 'team_file.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'

            ]);

            if ($request->hasfile('team_file'))
            {

                // dd($request->teamid);
                $image = $request->file('team_file');
                $name = $request->Team_Name . "_" . time() . "." . $image->getClientOriginalExtension();
                $image->move(public_path() . '/team/', $name);
                $up = Team_Store::where('id', $request->teamid)
                       ->where('student_id', $request->student_id)
                        ->where('school_id', $request->school_Id)
                        ->update(['team_Name' => $request->Team_Name, 
                                  'team_Description' => $request->about_team, 
                                  'team_Image' => $name,
                                  // 'academicyear' => $request->academicyear,
                              ]);
                StudentTeam_Role::where('teamId', $request->teamid)
                    ->delete();
                foreach ($request->ids as $students_id)
                {
                    StudentTeam_Role::where('studentid',$students_id)->where('status',2)->delete();
                    $studentRole = "role_" . $students_id;
                    $studentteamrole = new StudentTeam_Role();
                    $studentteamrole->teamId = $request->teamid;
                    $studentteamrole->schoolid = DB::table('team_store')
                        ->find($request->teamid)->school_id;
                    $studentteamrole->studentid = $students_id;
                    $studentteamrole->Role_studentid = $studentRole;
                    $studentteamrole->studentRole = $request->$studentRole;
                    $studentteamrole->status = 1;
                    $studentteamrole->save();

                }

            }
        }
        //
        $ids1 = $request->student_id . "_" . $request->school_Id;
        $schoolidforview = explode("_", $ids1);
        $schoolidViewTeam = $schoolidforview[2];
        // dd($schoolidViewTeam);
        return redirect('viewTeamad/' . base64_encode($schoolidViewTeam))->with('success', 'Team Updated  has been successfully');
    }

} //endofclass

