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
use App\Schoolmasterplan;
use App\Participatestudent;
use App\Location;
use Maatwebsite\Excel\Facades\Excel;
use App\Model\StudentModel\Team_Store;
use App\Model\StudentModel\StudentTeam_Role;

class Trainerteamaction extends Controller
{
	public function viewTeamtr($trschid)
	{

       $tssdId = explode("_",base64_decode($trschid));
       $trainerid = $tssdId[0];
       $scid = $tssdId[1];
       $schoolname = School::where('id',$scid)->first()->school_name??'N/A';
        $currentyear = date("Y");
       $viewTeam = Team_Store::where('school_id',$scid)
                  ->whereraw("year(created_at)=$currentyear")
                   ->get();
        foreach ($viewTeam as $key => $value) {
                 $data = explode('_', $value->student_id);
                 $userId = $data[0];
                 $type = $data[1];
                 switch ($type) {
                   case 'admin':
                       $viewTeam[$key]->createdName = 'Admin';
                       $viewTeam[$key]->createdBy = 'Admin';
                     break;
                    case 'trainer':
                       $viewTeam[$key]->createdName = Trainer::where('id',$userId)->first()->name??'N/A';
                       $viewTeam[$key]->createdBy = 'Trainer';
                     break;
                     case 'student':
                       $viewTeam[$key]->createdName = Studentinfo::where('id',$userId)->first()->name??'N/A';
                       $viewTeam[$key]->createdBy = 'Student';
                     break;
                 }
        }
        
        return view('Trainer.teamList',compact('viewTeam','trainerid','schoolname'));
      
	}



	public function viewteambytr($tssdid) 
{

    

$tssdId = explode("_",base64_decode($tssdid));

  $teamid = $tssdId[0];

  $scid = $tssdId[1];

  $schoolname = School::where('id',$scid)->first()->school_name??'N/A';

$currentyear=date("Y");
  $Teamname=DB::table('team_store')
  ->select('team_Image','team_Name','team_Description')
  ->where('id',$tssdId[0])
  ->whereraw("year(created_at)=$currentyear")
  ->first();
  
$assignmem=StudentTeam_Role::
join('students','students.id','=','studentTeam_Role.studentid')
->select('studentTeam_Role.teamId','studentTeam_Role.schoolid','students.id','students.name','studentTeam_Role.studentRole','studentTeam_Role.status','studentTeam_Role.created_at','studentTeam_Role.updated_at')
  ->where('teamId',$tssdId[0])->whereraw("year(studentTeam_Role.created_at)=$currentyear")->get();
  return view('Trainer.viewteammembytr',compact('scid','assignmem','schoolname'));
}

public function createteambytr($stschid)
{
 
    $stschId = explode("_",base64_decode($stschid));
    $tid = $stschId[0];
    $scid = $stschId[1];
    $trainername = Trainer::find($tid)->name;
    $students = DB::table('students')->select('id','name')->where('school_id',$scid)->get();
    return view('Trainer.createteambytr',compact('tid','scid','students','trainername'));
}







public function teamstorebytr(Request $request)
    {
        $this->validate($request, [
                 'Team_Name'=>'required|unique:team_store'
                // 'team_file' => 'required',
                // 'team_file.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'

        ]);
          $request->ids=array_unique($request->ids??[]);
         
          if($request->hasfile('team_file'))
               {

                $image = $request->file('team_file');
                $name =$request->Team_Name."_".time().".".$image->getClientOriginalExtension();
                
                $image->move(public_path().'/team/', $name);  
                $team = new Team_Store();
                $team->team_Name = $request->Team_Name;
                $team->team_Description = $request->about_team;
                $team->team_Image = $name;
                $team->student_id = $request->student_id."_trainer";
                $team->school_id = $request->school_Id;
                $team->save();
                $team->id;
                foreach ($request->ids as $students_id) {

                $studentRole = "role_".$students_id;
                StudentTeam_Role::where('studentid',$students_id)->where('status',2)->delete();
                $studentteamrole = new StudentTeam_Role();
                $studentteamrole->teamId = $team->id;
                $studentteamrole->schoolid = Team_Store::where('id',$team->id)->first()->school_id??'N/A';
                $studentteamrole->studentid = $students_id;
                $studentteamrole->Role_studentid = $studentRole;
                $studentteamrole->studentRole = $request->$studentRole;
                $studentteamrole->status = 1;
                $studentteamrole->save();

         }
       
    }
    else
    {

               
                $team = new Team_Store();
                $team->team_Name = $request->Team_Name;
                $team->team_Description = $request->about_team;
                // $team->team_Image = $name;
                $team->student_id = $request->student_id."_trainer";
                $team->school_id = $request->school_Id;
                $team->save();
                $team->id;
                foreach ($request->ids as $students_id) {

                $studentRole = "role_".$students_id;
                StudentTeam_Role::where('studentid',$students_id)->where('status',2)->delete();
                $studentteamrole = new StudentTeam_Role();
                $studentteamrole->teamId = $team->id;
                $studentteamrole->schoolid = Team_Store::where('id',$team->id)->first()->school_id??'N/A';
                $studentteamrole->studentid = $students_id;
                $studentteamrole->Role_studentid = $studentRole;
                $studentteamrole->studentRole = $request->$studentRole;
                $studentteamrole->status = 1;
                $studentteamrole->save();

    }

       }


// $tssdId = encode();
        $email = Auth::user()->email;
       $trainerid = Trainer::where('email',$email)->first()->id;

       $ids = $trainerid."_".$request->school_Id;



  return redirect('viewTeamtr/'.base64_encode($ids))->with('success', 'Team Created successfully');

     }


public function studentseachbytr(Request $req)
{
  $name=$req->name;
  $schoolid=$req->schoolid;


$studentroleid=DB::table('studentTeam_Role')
               ->select('studentid')
               ->where('schoolid',$schoolid)
               ->where('status',0)->orwhere('status',1)->orwhere('status',5)->get();
   $arra=[];
  $arra2=[];

if($studentroleid!=null)
{
   foreach($studentroleid as $studentroleid)
   {
     $arra[]=$studentroleid->studentid;
   }
   $arra1=array_unique($arra);
   $studentid = DB::table('students')
                ->select('id')
                ->where('school_id',$schoolid)
                // ->where('status',0)
                // ->orwhere('status',1)
                // ->orwhere('status',5)
                 ->where('username','!=',null)
                ->get();
   foreach($studentid as $studentid)
   {
     $arra2[]=$studentid->id;
   }
 }
   $value=array_diff($arra2,$arra1);
 
  $studentname=DB::table('students')
               ->select('*')
               ->where('school_id',$schoolid)
               ->whereIn('id', $value)
               ->where('username','!=',null)
               ->where('name', 'LIKE', "%$name%")
               ->get();
  
  return json_encode($studentname);

}







////

  public function editteambytr($tssid)
    {
          $tssId = explode("_",base64_decode($tssid));

          $studentname = Trainer::where('id',$tssId[0])->first()->name??'N/A';
          $edit = Team_Store::where('id',$tssId[1])
                    // ->where('school_id',$tssId[2])
                    // ->where('student_id',$tssId[1])
                    ->first();
          $check  = Team_Store::where('id',$tssId[1])
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
           $student = StudentTeam_Role::
                      join('students','students.id','=','studentTeam_Role.studentid')
                      ->where('teamId',$tssId[1])->get();
            $student1 = StudentTeam_Role::
                        join('students','students.id','=','studentTeam_Role.studentid')
                        ->where('teamId',$tssId[1])->get();
            $student = StudentTeam_Role::
                        join('students','students.id','=','studentTeam_Role.studentid')
                        ->where('teamId',$tssId[1])->get();
           
      return view('Trainer.editteambytr',compact('edit','student','student1','studentname','check'));
         
    }




public function teamupdatebytr(Request $request)
    {

      $request->hasfile('team_file');
      $image=$request->file('team_file');
      $ids=$request->student_id."_".$request->school_Id;

        if($image==null)
        {
           $this->validate($request, [
            'Team_Name'=>'required',
                ]);


              $up=Team_Store::where('id',$request->teamid)->where('student_id',$request->student_id)->where('school_id',$request->school_Id)->update(['team_Name' => $request->Team_Name,'team_Description'=>$request->about_team]);
                StudentTeam_Role::where('teamId',$request->teamid)->delete();
                $request->ids=array_unique($request->ids??[]);
                          foreach ($request->ids as $students_id) {

                  $studentRole="role_".$students_id;
                  StudentTeam_Role::where('studentid',$students_id)->where('status',2)->delete();
                  $studentteamrole=new StudentTeam_Role();
                  $studentteamrole->teamId=$request->teamid;
                  $studentteamrole->schoolid=DB::table('team_store')->find($request->teamid)->school_id;
                  $studentteamrole->studentid=$students_id;
                  $studentteamrole->Role_studentid=$studentRole;
                  $studentteamrole->studentRole=$request->$studentRole;
                  $studentteamrole->status=1;
                  $studentteamrole->save();

         //   $ids=$students_id."_".$request->teamid;
         //    $studentinfo=DB::table('students')->where('id',$students_id)->first();
         // $data=array('username'=>$studentinfo->name,'email'=>$studentinfo->studentemail,'link'=>"{{url('invitation')}}/{{base64_encode($ids)}}");
         //  Mail::send('Mail.StudentInvitationmail', $data, function($message) use($data) {
         // $message->to('jogi.amu@gmail.com', 'noreply@whitegarlic.in')->subject
         //    ('Welcome to F1school');
         // $message->from('noreply@whitegarlic.in','F1School');
         //        });
         }


              }
              else
              {
                  $this->validate($request, [
                 'Team_Name'=>'required',
                'team_file' => 'required',
                'team_file.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'

        ]);

       if($request->hasfile('team_file'))
         {
                $image=$request->file('team_file');
                $name=$request->Team_Name."_".time().".".$image->getClientOriginalExtension();
                $image->move(public_path().'/team/', $name);  
                $up=Team_Store::where('id',$request->teamid)->where('student_id',$request->student_id)->where('school_id',$request->school_Id)->update(['team_Name' => $request->Team_Name,'team_Description'=>$request->about_team,'team_Image'=>$name]);
                     StudentTeam_Role::where('teamId',$request->teamid)->delete();
                foreach ($request->ids as $students_id) {

                    $studentRole="role_".$students_id;
                  StudentTeam_Role::where('studentid',$students_id)->where('status',2)->delete();
                  $studentteamrole=new StudentTeam_Role();
                     $studentteamrole->teamId=$request->teamid;
                     $studentteamrole->schoolid=DB::table('team_store')->find($request->teamid)->school_id;
                     $studentteamrole->studentid=$students_id;
                     $studentteamrole->Role_studentid=$studentRole;
                     $studentteamrole->studentRole=$request->$studentRole;
                         $studentteamrole->status=1;
                  $studentteamrole->save();


         //   $ids=$students_id."_".$request->teamid;
         //    $studentinfo=DB::table('students')->where('id',$students_id)->first();
         // $data=array('username'=>$studentinfo->name,'email'=>$studentinfo->studentemail,'link'=>"{{url('invitation')}}/{{base64_encode($ids)}}");
         //  Mail::send('Mail.StudentInvitationmail', $data, function($message) use($data) {
         // $message->to('jogi.amu@gmail.com', 'noreply@whitegarlic.in')->subject
         //    ('Welcome to F1school');
         // $message->from('noreply@whitegarlic.in','F1School');
         //        });
         }
            

         }
      }
$id = explode('_', $request->student_id);
    $ids1 = $id[0]."_".$request->school_Id;
     

  return redirect('viewTeamtr/'.base64_encode($ids1))->with('success', 'Team Updated  has been successfully');

    }


public function deleteteambytr($deltssid)
{
   $deltssId=explode("_",base64_decode($deltssid));
  $del=Team_Store::where('id',$deltssId[0])->delete();
     StudentTeam_Role::where('teamId',$deltssId[0])->delete();
   $ids=$deltssId[2]."_".$deltssId[1];
   return redirect('viewTeamtr')->with('success', 'Team deleted  has been successfully');
}

public function deletestudentteamby($ssttid) 
{
  
  $data=explode("_",base64_decode($ssttid));

   
  // $studentid=Team_Store::where('id',$data[1])->where('school_id',$data[2])->first()->student_id;
  // $tt=$data[1]."_".$data[2]."_".$studentid;

    $check=StudentTeam_Role::where('teamId',$data[0])->get();
    if(count($check)==1)
    {
        $del=StudentTeam_Role::where('teamId',$data[0])->where('studentid',$data[1])->where('schoolid',$data[2])->delete();
        $studentid=Team_Store::where('id',$data[0])->delete();

    }
    else
    {
       
        $del=StudentTeam_Role::where('teamId',$data[0])->where('studentid',$data[1])->where('schoolid',$data[2])->delete();
    }


  return redirect('viewTeamtr')->with('success', 'Student deleted from Team successfully');;
}



}