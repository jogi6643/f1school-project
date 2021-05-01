<?php

namespace App\Http\Controllers\admin;

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
	public function viewTeamtr()
	{
		$trainerid="";
		
	     $currentyear=date("Y");
         $trschool=SchoolTrainer::select('school_id')->where('year',$currentyear)->get()->map(function($data){
         
         	return $data;
         })->toArray();
        
      if($trschool!==[])
       {
            
       	foreach ($trschool as $key => $value) {
                // dd($value['school_id']); 
       		// DB::enableQueryLog(); 
       		$team1[]=DB::table('team_store')->where('school_id',$value['school_id'])->whereraw("year(created_at)=$currentyear")->get()->map(function($data) use($value){
       	        
               $data->school_name=School::find($value['school_id'])->school_name;
            
          $ss=explode("_", $data->student_id);
        $data->student_name =isset($ss[1])?DB::table('trainers')->first()->name." ( Trainer ) ":Studentinfo::find($data->student_id)->name." (Student) ";
       			return $data;
       		})->toArray();
       	}
       }
       
        return view('Trainer.teamList',compact('team1','trainerid'));
	}



  public function viewTeamadd()
  {
	 
    $trainerid="";
      dd(Team_Store::get());
       $currentyear=date("Y");
         $trschool=SchoolTrainer::select('school_id')->where('year',$currentyear)->get()->map(function($data){
         
          return $data;
         })->toArray();
        
      if($trschool!==[])
       {
            
        foreach ($trschool as $key => $value) {
                // dd($value['school_id']); 
          // DB::enableQueryLog(); 
          $team1[]=DB::table('team_store')->where('school_id',$value['school_id'])->whereraw("year(created_at)=$currentyear")->get()->map(function($data) use($value){
                
               $data->school_name=School::find($value['school_id'])->school_name;
            
          $ss=explode("_", $data->student_id);
        $data->student_name =isset($ss[1])?DB::table('trainers')->first()->name." ( Trainer ) ":Studentinfo::find($data->student_id)->name." (Student) ";
            return $data;
          })->toArray();
        }
       }
       
        return view('Trainer.teamList',compact('team1','trainerid'));
  }


	public function viewteambytr($tssdid) 
{

$tssdId=explode("_",base64_decode($tssdid));



  $teamid=$tssdId[0];

  $scid=$tssdId[1];

$currentyear=date("Y");
  $Teamname=DB::table('team_store')
             ->select('team_Image','team_Name','team_Description')
             ->where('id',$tssdId[0])->whereraw("year(created_at)=$currentyear")
  ->first();
$assignmem=StudentTeam_Role::
join('students','students.id','=','studentTeam_Role.studentid')
->select('studentTeam_Role.teamId','studentTeam_Role.schoolid','students.id','students.name','studentTeam_Role.studentRole','studentTeam_Role.status','studentTeam_Role.created_at','studentTeam_Role.updated_at')
  ->where('teamId',$tssdId[0])->whereraw("year(studentTeam_Role.created_at)=$currentyear")->get();
  return view('Trainer.viewteammembytr',compact('scid','assignmem'));
}

public function createteambytr($stschid)
{
 
    $stschId=explode("_",base64_decode($stschid));
    // dd($stschId);
    $tid=$stschId[0];
    $scid=$stschId[1];



    $trainername=Trainer::find($tid)->name;
    
    $students=DB::table('students')->select('id','name')->where('school_id',$scid)->get();
    return view('Trainer.createteambytr',compact('tid','scid','students','trainername'));
}







public function teamstorebytr(Request $request)
    {
        $this->validate($request, [
                 'Team_Name'=>'required|unique:team_store',
                'team_file' => 'required',
                'team_file.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'

        ]);
        $date=date('Y');
       $create_at= Team_Store::first();
       
       if($create_at==null)
       {
          if($request->hasfile('team_file'))
               {

                $image=$request->file('team_file');
                $name=$request->Team_Name."_".time().".".$image->getClientOriginalExtension();
                $image->move(public_path().'/team/', $name);  
                $team= new Team_Store();
                $team->team_Name=$request->Team_Name;
                $team->team_Description=$request->about_team;
                $team->team_Image=$name;
                $team->student_id=$request->student_id."_trainer";
                $team->school_id=$request->school_Id;
                $team->save();
                $team->id;
                foreach ($request->ids as $students_id) {

                  $studentRole="role_".$students_id;
                  $studentteamrole=new StudentTeam_Role();
                     $studentteamrole->teamId=$team->id;
                     $studentteamrole->schoolid=DB::table('team_store')->find($team->id)->school_id;
                     $studentteamrole->studentid=$students_id;
                     $studentteamrole->Role_studentid=$studentRole;
                     $studentteamrole->studentRole=$request->$studentRole;
                  $studentteamrole->save();


         //   $ids=$students_id."_".$team->id;
         //    $studentinfo=DB::table('students')->where('id',$students_id)->first();
         // $data=array('username'=>$studentinfo->name,'email'=>$studentinfo->studentemail,'link'=>"{{url('invitation')}}/{{base64_encode($ids)}}");
         //  Mail::send('Mail.StudentInvitationmail', $data, function($message) use($data) {
         // $message->to('jogi.amu@gmail.com', 'noreply@whitegarlic.in')->subject
         //    ('Welcome to F1school');
         // $message->from('noreply@whitegarlic.in','F1School');
         //        });
         }
         return back()->with('success', 'Team Created  has been successfully');
     
    }

       }
     else
      {
    
        // $acadmicyr=explode('-',$create_at->created_at);
        // if($acadmicyr[0]==$date)
        // {
        
        //      return back()->with('danger', 'Already Created Team this year');
        // }
      // else
      //   {
           if($request->hasfile('team_file'))
         {

                $image=$request->file('team_file');
                $name=$request->Team_Name."_".time().".".$image->getClientOriginalExtension();
                $image->move(public_path().'/team/', $name);  
                $team= new Team_Store();
                $team->team_Name=$request->Team_Name;
                $team->team_Description=$request->about_team;
                $team->team_Image=$name;
                $team->student_id=$request->student_id."_trainer";
                $team->school_id=$request->school_Id;
                $team->save();
                $team->id;
                foreach ($request->ids as $students_id) {

                  $studentRole="role_".$students_id;
                  $studentteamrole=new StudentTeam_Role();
                     $studentteamrole->teamId=$team->id;
                     $studentteamrole->schoolid=DB::table('team_store')->find($team->id)->school_id;
                     $studentteamrole->studentid=$students_id;
                     $studentteamrole->Role_studentid=$studentRole;
                     $studentteamrole->studentRole=$request->$studentRole;
                  $studentteamrole->save();


         //   $ids=$students_id."_".$team->id;
         //    $studentinfo=DB::table('students')->where('id',$students_id)->first();
         // $data=array('username'=>$studentinfo->name,'email'=>$studentinfo->studentemail,'link'=>"{{url('invitation')}}/{{base64_encode($ids)}}");
         //  Mail::send('Mail.StudentInvitationmail', $data, function($message) use($data) {
         // $message->to('jogi.amu@gmail.com', 'noreply@whitegarlic.in')->subject
         //    ('Welcome to F1school');
         // $message->from('noreply@whitegarlic.in','F1School');
         //        });
         }
    // }
    
        }

      
        return back()->with('success', 'Team Created  has been successfully');
       }


     }








public function studentseachbytr(Request $req)
{
  $name=$req->name;
  $schoolid=$req->schoolid;


$studentroleid=DB::table('studentTeam_Role')->select('studentid')->where('schoolid',$schoolid)->get();
   $arra=[];
  $arra2=[];

if($studentroleid!=null)
{
   foreach($studentroleid as $studentroleid)
   {
     $arra[]=$studentroleid->studentid;
   }
   $arra1=array_unique($arra);
   $studentid=DB::table('students')->select('id')->where('school_id',$schoolid)->get();
   foreach($studentid as $studentid)
   {
     $arra2[]=$studentid->id;
   }
 }
   $value=array_diff($arra2,$arra1);
 
  $studentname=DB::table('students')->select('id','name')->where('school_id',$schoolid)->whereIn('id', $value)->where('name', 'LIKE', "%$name%")->get();
  
  return json_encode($studentname);

}







////

  public function editteambytr($tssid)
    {
      $tssId=explode("_",base64_decode($tssid));
     
           if(count($tssId)==3)
           {
            $studentname=DB::table('students')->find($tssId[1])->name;
           $edit=Team_Store::where('id',$tssId[0])->where('school_id',$tssId[2])->where('student_id',$tssId[1])->first();
           
           $student=StudentTeam_Role::

           join('students','students.id','=','studentTeam_Role.studentid')
           ->where('teamId',$tssId[0])->get();
            $student1=StudentTeam_Role::
           join('students','students.id','=','studentTeam_Role.studentid')
           ->where('teamId',$tssId[0])->get();
         }
         else
         {
    
          $studentname=DB::table('trainers')->find($tssId[1])->name;
          $trid=$tssId[1]."_".$tssId[2];
           $edit=Team_Store::where('id',$tssId[0])->where('school_id',$tssId[3])->where('student_id',$trid)->first();
           
           $student=StudentTeam_Role::

           join('students','students.id','=','studentTeam_Role.studentid')
           ->where('teamId',$tssId[0])->get();
            $student1=StudentTeam_Role::
           join('students','students.id','=','studentTeam_Role.studentid')
           ->where('teamId',$tssId[0])->get();

         }
           
      return view('Trainer.editteambytr',compact('edit','student','student1','studentname'));
         
    }




        public function teamupdatebytr(Request $request)
    {

       

               $request->hasfile('team_file');
               $image=$request->file('team_file');
               $ids=$request->student_id."_".$request->school_Id;
              if($image==null)
              {
                 $this->validate($request, [
                 'Team_Name'=>'required|unique:team_store',
               ]);


              $up=Team_Store::where('id',$request->teamid)->where('student_id',$request->student_id)->where('school_id',$request->school_Id)->update(['team_Name' => $request->Team_Name,'team_Description'=>$request->about_team]);
                StudentTeam_Role::where('teamId',$request->teamid)->delete();
                          foreach ($request->ids as $students_id) {

                  $studentRole="role_".$students_id;
                  $studentteamrole=new StudentTeam_Role();
                     $studentteamrole->teamId=$request->teamid;
                     $studentteamrole->schoolid=DB::table('team_store')->find($request->teamid)->school_id;
                     $studentteamrole->studentid=$students_id;
                     $studentteamrole->Role_studentid=$studentRole;
                     $studentteamrole->studentRole=$request->$studentRole;
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

// dd($request->teamid);
                $image=$request->file('team_file');
                $name=$request->Team_Name."_".time().".".$image->getClientOriginalExtension();
                $image->move(public_path().'/team/', $name);  
                $up=Team_Store::where('id',$request->teamid)->where('student_id',$request->student_id)->where('school_id',$request->school_Id)->update(['team_Name' => $request->Team_Name,'team_Description'=>$request->about_team,'team_Image'=>$name]);
                     StudentTeam_Role::where('teamId',$request->teamid)->delete();
                          foreach ($request->ids as $students_id) {

                  $studentRole="role_".$students_id;
                  $studentteamrole=new StudentTeam_Role();
                     $studentteamrole->teamId=$request->teamid;
                     $studentteamrole->schoolid=DB::table('team_store')->find($request->teamid)->school_id;
                     $studentteamrole->studentid=$students_id;
                     $studentteamrole->Role_studentid=$studentRole;
                     $studentteamrole->studentRole=$request->$studentRole;
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
// 
    $ids1=$request->student_id."_".$request->school_Id;
     

  return redirect('viewTeamtr')->with('success', 'Team Updated  has been successfully');

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