<?php

namespace App\Http\Controllers\Student;
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
use Session;
use Hash;
use App\Model\AssignedCoursetype;
use App\Model\Manufacture\CarType;
use App\Model\Manufacture\Stcarbodypart;
use App\Model\Competition\Schoolteamcomp;
use App\Model\Student;
use App\Studentinfo;
use App\Model\StudentModel\StudentTeam_Role;
use App\Model\StudentModel\Team_Store;
use Validator;
use App\Model\Cartdetail;
use App\Model\Payment;
use App\Model\Part;
use App\Model\Material;
use App\Model\Partplan;
use App\Model\Manufacture\Orederstaus;
use App\Model\Assignpriceinschool;
use App\Model\Plan;
use App\AcademicYear;
use App\Login_Academic_Year;
use App\Model\Competition\Competitionstore;
use App\Membership;
use App\Participatestudent;
use App\Awards;
use Illuminate\Support\Facades\Input;
use Cookie;
use IlluminateCookieCookieJar;
use Illuminate\Support\Facades\Response;
use App\Otp;
use App\User;
use Crypt;
// use App\Model\Part;
// use App\User;

// namespace App\Http\Middleware;

class Students extends Controller
{
    //public function __construct() { $this->middleware('preventBackHistory'); $this->middleware('auth'); } 
  // Start Mobile Credentails
   public function slogin1(Request $req)
    {
		
       if(isset($req->mobile_no))
	   {        $var = $req->dob;
        $date = str_replace('-', '/', $var);
        $date1 =date('d/m/Y', strtotime($date));

          $exist  = User::where('mobile_no',$req->mobile_no)->where('dob',$date1)->count();
		  $student  = Student::where('mobileno',$req->mobile_no)->where('dob',$date1)->count();
		  if($student==0)
		  {
			  $req->session()->flash('error',"This account not registered");
		
           return view('admin.Student.Mobile_Login');
		  }
        
        if($exist==0)
        {
         
          $mobile_no = $req->mobile_no;
          $dob = $date1;
		  
              $otpnumber = mt_rand(100000, 999999);
              $currenttime = time();
              $expirytime = time()+ 2*60;
              $mobileNumber = $req->mobile_no;

              // OTP Table Insert Data for Username ...
              $otp = new Otp;
              // $otp->username = $otp->username;
              $otp->otp = $otpnumber;
              $otp->mobile_no = $mobileNumber;
              $otp->currenttime = $currenttime;
              $otp->expirytime = $expirytime;
              $otp->dob = $date1;
              $otp->save();
              //End  OTP Table Insert Data for Username ...
             
             $mb=$req->mobile_no;
             $apikey = "YXPskaQxMk6oxtQcQbPo2Q";
             $apisender = "TOSAPP";
             $msg = "Your OTP is ".$otpnumber;
             $num ='91'.$mb;    // MULTIPLE NUMBER VARIABLE PUT HERE...!                 
             $ms = rawurlencode($msg);   //This for encode your message content                     
            $url = 'https://www.smsgatewayhub.com/api/mt/SendSMS?APIKey='.$apikey.'&senderid='.$apisender.'&channel=2&DCS=0&flashsms=0&number='.$num.'&text='.$ms.'&route=1';
                               
           //echo $url;
           $ch=curl_init($url);
           curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
           curl_setopt($ch,CURLOPT_POST,1);
           curl_setopt($ch,CURLOPT_POSTFIELDS,"");
           curl_setopt($ch, CURLOPT_RETURNTRANSFER,2);
           $data = curl_exec($ch);
           echo '<br/><br/>';

           
           Session::put('mobile_no', $req->mobile_no);
		   Session::put('dob', $req->dob);
           

           $trimmobile = substr($mb,-4);

         
          return view('admin.Student.Mobile_Login1',compact('mobile_no','dob'));
        }
        else
         { 
		  $req->session()->flash('error',"Your account has already been created. Please Login instead.");
		
           return view('admin.Student.Student_login');
         } 

	   }
	   else
	   {
		   return view('admin.Student.Student_login');
	   }

         $credentials = $req->only('mobile_no');
         dd( $credentials);
        // $credentials = $req->only('email', 'password');
        
      
      
    
        if (Auth::attempt($credentials)) {
                $email=Auth::user()->email;
                $role=Auth::user()->role;
                 if($role==5)
                 {
                  $check = Student::select('school_id')->where('studentemail',$email)->first();
                  $check11 = Student::where('studentemail',$email)->first();
                  dd($check11);

                  if($check)
                  {
                    $count=School::where('id',$check->school_id)->count();
                    if($count==0)
                    {
                      Auth::logout();  
                      $req->session()
                      ->flash('danger','This user does not exits');
                      return redirect('/studentlogin');
                    }
                  }
                  

                  $lastlogin  =  DB::table('students')->where('studentemail', $email)
                  ->update([

                    "last_login" => time(),

                  ]);  


                 $status= DB::table('students')->where('studentemail',$email)
                              ->first()->status; 
                
                 if($status==1){
                 $studentid= DB::table('students')->where('studentemail',$email)->first()->id; 
                 $schoolid= DB::table('students')->where('studentemail',$email)->first()->school_id; 
                  $details=$this->viewsCousrseS();

                  if($details!=[])
                  {
                   $assigndata  =      $details['details'];
                   $systemdate  =      $details['systemdate'];
                   $pname       =      $details['pname'];
                   $studentid   =      $details['studentid'];
                   $schoolid    =      $details['schoolid'];
                   $planid      =      $details['planid'];
                  // $academicyear=      $details['Academic_year'];
                   }

                   // dd($assigndata);
                  // return view('admin.Student.StudentviewCourse',compact('assigndata','systemdate','pname','studentid','schoolid','planid'));

                 return redirect('/dashboard'); 
              }
              else
              {

                Auth::logout();  
                $req->session()->flash('danger','Dear Student Your Account has been disabled Contact to School');
                return redirect('/studentlogin');
              }


}
    else
{
    Auth::logout(); 
    $req->session()->flash('danger','Permission Denied Please Check Your Url....'); 
    return redirect('/studentlogin');
}

}else{

    
    //   $check1 = Student::where('studentemail',$req->email)->where('register_type','F1Senior')->first()->studentemail??'N/A';
    //   if($check1!='N/A')
    //   {
    //        Auth::logout();
    // $req->session()->flash('danger','These credentials do not match our records.');
    // return redirect('/studentCollegeLogin');
    //   }
    //   else
    //   {
    //       Auth::logout(); 
    //        $req->session()->flash('danger','These credentials do not match our records.'); 
    //             return redirect('/studentlogin');
    //   }

    return redirect('new-user');

      }         
}
  //End Mobile Credentails

public function new_user()
{
  return view('admin.Student.Mobile_Login2');
} 

public function new_user_reg(Request $request)
    {
       
        $var = $request->dob;
        $date = str_replace('-', '/', $var);
        $date1 =date('d/m/Y', strtotime($date));
// dd($request->all());
          $request->validate(
            [
            // 'name'=>'required|regex:/^[a-zA-Z]+$/u|max:255',
              'name'      =>   ['required','regex:/^([a-zA-Z0-9]+|[a-zA-Z0-9]+\s{1}[a-zA-Z0-9]{1,}|[a-zA-Z0-9]+\s{1}[a-zA-Z0-9]{3,}\s{1}[a-zA-Z0-9]{1,})$/i'],
            
            'mobileno'    =>   'required|unique:students|regex:/[0-9]{10}/|digits:10',
            // 'tsize'=>'required',
            'dob'   =>   'required',
            
              ],['name.required'  =>  'The field is required'
              // ,'sutudentmobile.numeric'=>'The Student Phone field  must be a number.'
               ,'mobile.unique'=>'Mobile no already exist.'
            ]
              );
              
            $studentcount =  Studentinfo::where('mobileno',$request->mobileno)->count();
            $usercount = User::where('mobile_no',$request->mobileno)
                         ->where('role',5)->count(); 
           if($studentcount==0&&$usercount==0)
           {
            $st = new Studentinfo();
            $st->name = $request->name;
            $st->mobileno = $request->mobileno;
            $st->dob = $date1;
            $st->save();
            $stid = $st->id;

            $user           =           new User();
            $user->name     =           $request->name;
            $user->role     =           5;
            $user->mobile_no   =        $request->mobileno;
			      $user->email   =            $stid->id ;
            $user->dob      =           $date1;
            $user->username =           strtolower('Student_'.$st->id);
            $user->save();

            Studentinfo::where('id',$st->id)->update(['username'=>strtolower('Student_'.$st->id)]);
             return redirect('/student-login')->with('success','Record Saved.');
           }
           else
           {
           return redirect('/new-user')->with('danger','already exists!.');
           }                          
            die;
      
        // if($st)
        //     return redirect('students/'.base64_encode($request->school_id))->with('success','Record Saved.');
   
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

  public function slogin(Request $req)
    {
           
        $credentials = $req->only('username', 'password');
		    $credentials1 = Auth::attempt(['email'=>$req->username,'password'=>$req->password]);
         
        if (Auth::attempt($credentials)||$credentials1) {
                $email=Auth::user()->email;
                $role=Auth::user()->role;
                $mobile_no = Auth::user()->mobile_no;
                 if($role==5)
                 {
					 
                   $check=Student::select('*')->where('mobileno',Auth::user()->mobile_no)->where('dob',Auth::user()->dob)->first();
				  
                  // $check=Student::select('school_id')->where('username',$email)->first();
                  if($check)
                  {
                    $count=School::where('id',$check->school_id)->count();
                    if($count==0)
                    {
                      Auth::logout();  
                      $req->session()
                      ->flash('danger','This user does not exits');
                      return redirect('/studentlogin');
                    }
                  }
                  

                  $lastlogin  =  DB::table('students')->where('id', $check->id)
                  ->update([

                    "last_login" => time(),
                  ]);  


                  $lastlogin  =  DB::table('students')
                  ->where('mobileno', $mobile_no)
                  ->where('dob',Auth::user()->dob)
                  ->update([

                    "last_login" => time(),
                  ]);      

                 $status= DB::table('students')->where('id',$check->id)
                              ->first()->status; 
              
                 if($status==1){
                 $studentid= DB::table('students')->where('id',$check->id)->first()->id; 
                 $schoolid= DB::table('students')->where('id',$check->id)->first()->school_id; 
                  $details=$this->viewsCousrseS();

                  if($details!=[])
                  {
                   $assigndata  =      $details['details'];
                   $systemdate  =      $details['systemdate'];
                   $pname       =      $details['pname'];
                   $studentid   =      $details['studentid'];
                   $schoolid    =      $details['schoolid'];
                   $planid      =      $details['planid'];
                  // $academicyear=      $details['Academic_year'];
                   }

                   // dd($assigndata);
                  // return view('admin.Student.StudentviewCourse',compact('assigndata','systemdate','pname','studentid','schoolid','planid'));

                 return redirect('/dashboard'); 
              }
              else
              {

                Auth::logout();  
                $req->session()->flash('danger','Dear Student Your Account has been disabled Contact to School');
                return redirect('/studentlogin');
              }


}
    else
{
    Auth::logout(); 
    $req->session()->flash('danger','Permission Denied Please Check Your Url....'); 
    return redirect('/studentlogin');
}

}else{

    
      $check1 = Student::where('studentemail',$req->email)->where('register_type','F1Senior')->first()->studentemail??'N/A';
      if($check1!='N/A')
      {
           Auth::logout();
    $req->session()->flash('danger','These credentials do not match our records.');
    return redirect('/studentCollegeLogin');
      }
      else
      {
          Auth::logout(); 
           $req->session()->flash('danger','These credentials do not match our records.'); 
                return redirect('/student-login');
            }
      }  

       
}


public function student_home(){
  
      //dd(Auth::user()->school_id);


      $email = Auth::user()->email;

       $role=Auth::user()->role;
       if($role==5)
       {
          
       $status= Student::select('*')->where('mobileno',Auth::user()->mobile_no)->where('dob',Auth::user()->dob)
                    ->first()->status; 
      
       if($status==1){
             $studentid= Student::select('*')->where('mobileno',Auth::user()->mobile_no)->where('dob',Auth::user()->dob)
                  ->first()->id; 
             $schoolid= Student::select('*')->where('mobileno',Auth::user()->mobile_no)->where('dob',Auth::user()->dob)
                  ->first()->school_id; 

           $studentiddd = $studentid."_student";
           $checkTeamId = DB::table('team_store')
                      ->where('student_id',$studentiddd)
                      ->where('school_id',$schoolid)
                      ->first();
					
  if($checkTeamId==null){

 $strole= DB::table('studentTeam_Role')
                        ->where('studentid',$studentid)
                        ->where('schoolid',$schoolid)
						
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


       $studentName = DB::table('students')
                      ->select('students.name','schools.school_name','students.register_type')
                      ->join('schools','schools.id','=','students.school_id')
                      ->where('students.id', $studentid)
                      ->first();


        //code start by upanshu               
              $teamrealtedtoschool= DB::table('team_store')
                                    ->where('school_id',$schoolid)->select('student_id')
                                    ->get()->toArray();
									
                                  
              $compId=Schoolteamcomp::where('school_id',$schoolid)->count();
                               
 
              //dd($teamrealtedtoschool);

            if($role==5)
            {
              $student_id =$studentid.'_student';

            }
           
        //code end by upanshu                   
        $details=$this->viewsCousrseS();
         
        if($details!=[])
        {
         $assigndata  =    $details['details'];
         $systemdate  =    $details['systemdate'];
         $pname       =    $details['pname'];
         $studentid   =    $details['studentid'];
         $schoolid    =    $details['schoolid'];
         $planid      =    $details['planid'];
         // $academicyear=    $details['Academic_year'];

         }
           $teams1= DB::table('studentTeam_Role')
                        ->where('studentid',$studentid)
                        ->where('schoolid',$schoolid)
					  ->where('status',1)
                        ->first();
           
				
    if($teams1!=null)
	   {
		   
      $compId=Schoolteamcomp::where('school_id',$schoolid)->where('tmpid',$teams1->teamId)->count();
	
	   }
	   else
	   {
		    $compId=0;
	   }
    
   
     $teamstoreCreateId=DB::table('team_store')
                        ->where('school_id',$schoolid)
                        ->where('student_id',$studentid."_student")
                        // ->where('created_at', date('Y'))
                        ->count();

      $studenteamroleId=DB::table('studentTeam_Role')
                        ->where('schoolid',$schoolid)
                        ->where('studentid',$studentid)
                        // ->where('created_at', date('Y'))
                        ->count();

          
        
  
        return $this->studentprofile(base64_encode($studentid));

        return view('admin.Student.StudentviewCourse',compact('teamstoreCreateId','studenteamroleId','compId','assigndata','systemdate','pname','studentid','schoolid','planid','studentName','creatorteamid','collageTeamId'));
    }
  }
}

public function courseList()
{
        // $email = Auth::user()->email;

       $role=Auth::user()->role;
       if($role==5)
       {

        $status= Student::select('*')
                    ->where('mobileno',Auth::user()->mobile_no)
                    ->where('dob',Auth::user()->dob)
                     ->first()->status; 
      
       if($status==1){
       $studentid = Student::select('*')
                    ->where('mobileno',Auth::user()->mobile_no)
                    ->where('dob',Auth::user()->dob)
                     ->first()->id; 
       $schoolid = Student::select('*')->where('mobileno',Auth::user()->mobile_no)
                   ->where('dob',Auth::user()->dob)
                   ->first()->school_id; 
         $studentiddd=$studentid."_student";
 

          $checkTeamId = Team_Store::
                         where('student_id',$studentiddd)
                          ->where('school_id',$schoolid)
                          ->first();
          
  if($checkTeamId==null){

          $strole= StudentTeam_Role::
                        where('studentid',$studentid)
                        ->where('schoolid',$schoolid)
            
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
    $studentiddd=$studentid."_student";
                  
  }

     $studentName = DB::table('students')
                      ->select('students.name','schools.school_name','students.profileimage','students.register_type','students.order_status','students.last_login')
                      ->join('schools','schools.id','=','students.school_id')
                      ->where('mobileno',Auth::user()->mobile_no)
                       ->where('dob',Auth::user()->dob)
                      ->first();
        //code start by upanshu               
              $teamrealtedtoschool= DB::table('team_store')
                                    ->where('school_id',$schoolid)->select('student_id')
                                    ->get()->toArray();
                  
                                  
                                  $compId=Schoolteamcomp::where('school_id',$schoolid)->count();
                                

              //dd($teamrealtedtoschool);

            if($role==5)
            {
              $student_id =$studentid.'_student';

            }
           
        //code end by upanshu                   
        $details=$this->viewsCousrseS();
         
        if($details!=[])
        {
        $assigndata=$details['details'];
         $systemdate=$details['systemdate'];
         $pname=$details['pname'];
         $studentid=$details['studentid'];
         $schoolid=$details['schoolid'];
         $planid=$details['planid'];
         }
    
           $teams1= DB::table('studentTeam_Role')
                        ->where('studentid',$studentid)
                        ->where('schoolid',$schoolid)
            ->where('status',1)
                        ->first();
        
         if($teams1!=null)
     {
       
      $compId=Schoolteamcomp::where('school_id',$schoolid)->where('tmpid',$teams1->teamId)->count();
  
     }
     else
     {
        $compId=0;
     }
     
    
     $teamstoreCreateId=DB::table('team_store')
                        ->where('school_id',$schoolid)
                        ->where('student_id',$studentid."_student")
                        // ->where('created_at', date('Y'))
                        ->count();

      $studenteamroleId=DB::table('studentTeam_Role')
                        ->where('schoolid',$schoolid)
                        ->where('studentid',$studentid)
                        // ->where('created_at', date('Y'))
                        ->count();


  
        // return $this->studentprofile(base64_encode($studentid));
       // StudentviewCourse
       // course_and_training                 
        return view('admin.Student.course_and_training',compact('teamstoreCreateId','studenteamroleId','compId','assigndata','systemdate','pname','studentid','schoolid','planid','studentName','creatorteamid'));
    }
  }
}

public function student_competition(Request $request, $student_school_id){


  $email = Auth::user()->email;

  $student_school_id = explode("_",base64_decode($student_school_id));
  
  $student_id   = $student_school_id[0];
  $school_id    = $student_school_id[1];
  $studentiddd  = $student_id."_student";
 //team name start
   $studentrole = DB::table('studentTeam_Role')
                        ->where('schoolid',$school_id)
                        ->where('studentid',$student_id)
                        // ->where('created_at', date('Y'))
                        ->first(); 
  
						$teamname = DB::table('team_store')
                      ->where('id',$studentrole->teamId??0)
                    
                      ->first();
						
 //team end

  $checkTeamId = DB::table('team_store')
                      ->where('student_id',$studentiddd)
                      ->where('school_id',$school_id)
                      ->first();
					   $teams= DB::table('studentTeam_Role')
                        ->where('studentid',$student_id)
                        ->where('schoolid',$school_id)
                        ->first();

						$teamid=$teams->teamId??0;
  if($checkTeamId==null){
 $strole= DB::table('studentTeam_Role')
                        ->where('studentid',$student_id)
                        ->where('schoolid',$school_id)
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


  $student_name  = DB::table('students')->find($student_id)->name;
  $school_name   = DB::table('schools')->find($school_id)->school_name;

   $Academicyear = Login_Academic_Year::where('school',$school_id)->first()->academicyear??'N/A';

  $schoolTeamComp = DB::table('schoolteamcomp')
                    ->where('school_id', $school_id)
						        ->where('tmpid',$teams->teamId)
                    ->groupBy('schoolteamcomp.cmpid')
                        ->get(); 


  $competition = [];                   
  foreach ($schoolTeamComp as $compid) 
  {
      $competition[] = $compid->cmpid;                                
  }                                      
            
  $competition = DB::table('Competitionstore')
                        ->whereIn('id', $competition)
                        ->where('academicyear',$Academicyear)
                        ->orderBy('id', 'DESC')
                        ->get();
          

                

                        $hide=[];
 $doc=[];  
  $arr1=[]; 
  foreach($competition as $key1=>$competitions){
    $competition[$key1]->awardsTeam =  Awards::where('compid',$competitions->id)
                  ->where('schooldid',$school_id)
                  ->get();

  if(isset($competition[$key1]->support_title)){                       
  foreach(json_decode($competition[$key1]->support_title) as $key=>$abc)
  {
    $arr=json_decode($competition[$key1]->support_from);
   
    if($arr[$key]==1)
    {
        
        $upload = DB::table('document_upload')->where('school_id',$school_id)->where('team_id',$teamid)->where('competition_id',$competition[$key1]->id)->where('flag',$key)->count();

        $uploads = DB::table('document_upload')->where('school_id',$school_id)->where('team_id',$teamid)->where('competition_id',$competition[$key1]->id)->where('flag',$key)->first();
     
if($uploads!=null)
       {
    
       $student = DB::table('students')
                      ->where('id', $uploads->student_id)
					  
                      ->first(); 
        
      $arr1[$key1][$key]['name']=$student->name;
      $arr1[$key1][$key]['image']=$uploads->image;
     $arr1[$key1][$key]['updated_at']=$uploads->updated1;
      // $arr1[$key1][$key]['updated1'] = date('d/m/Y H:i:s a');
      
  }
    }else{
       if(isset($checkTeamId->id))
     {
     $totalstydents = DB::table('studentTeam_Role')->where('teamId',$checkTeamId->id)->get()->map(function($datas){
      
       return $datas->studentid;
     })->toArray();
        
       foreach($totalstydents as $keys=>$totalstydent)
     {
      $pending = DB::table('document_upload')->where('student_id',$totalstydent)->where('competition_id',$competition[$key1]->id)->where('flag',$key)->first();
             if($pending!=null)
       {
        $student = DB::table('students')
                      ->where('id', $totalstydent)
                      ->first(); 
           $doc[$key1][$key][$keys]['name']=$student->name;
           $doc[$key1][$key][$keys]['status']="Submitted";
            //$docu[$key]->name=
       }
       else{
          $student = DB::table('students')
                      ->where('id', $totalstydent)
                      ->first(); 
           $doc[$key1][$key][$keys]['name']=$student->name;
           $doc[$key1][$key][$keys]['status']="Pending";
            
       }
      
     }
     }

      $uploads = DB::table('document_upload')->where('student_id',$student_id)->where('competition_id',$competition[$key1]->id)->where('flag',$key)->first();
	 
       if($uploads!=null)
       {
     
      $student = DB::table('students')
                      ->where('id', $uploads->student_id)
                      ->first(); 
        
      $arr1[$key1][$key]['name']=$student->name;
      $arr1[$key1][$key]['image']=$uploads->image;
     $arr1[$key1][$key]['updated_at']=$uploads->updated1;
      // $arr1[$key1][$key]['updated1'] = date('d/m/Y H:i:s a');
}
      $upload = DB::table('document_upload')->where('student_id',$student_id)->where('team_id',$teamid)->where('competition_id',$competition[$key1]->id)->where('flag',$key)->count();

   }
    
    if($upload!=0){
      $hide[]=$key; 
    }
	 $arr1[$key1][$key]['enable']=0;
       if(date('m/d/Y') < $competition[$key1]->Start_Date)
       {
         $arr1[$key1][$key]['enable']=1;
		 $arr1[$key1][$key]['date']=$competition[$key1]->Start_Date;
       } 
  
}
 }
  }

    $studentName = DB::table('students')
                      ->select('students.name','schools.school_name','students.register_type')
                      ->join('schools','schools.id','=','students.school_id')
                      ->where('mobileno',Auth::user()->mobile_no)
                      ->where('dob',Auth::user()->dob)->first();    


        $details=$this->viewsCousrseS();
        if($details!=[])
        {
         $assigndata=$details['details'];
         $systemdate=$details['systemdate'];
         $pname=$details['pname'];
         $studentid=$details['studentid'];
         $schoolid=$details['schoolid'];
         $planid=$details['planid'];
        }       
         // $cId=Schoolteamcomp::where('school_id',$schoolid)->where('tmpid',$creatorteamid)->first()->cmpid;

                    
      $test=DB::table('document_upload')
                  ->where('school_id',$schoolid)->where('team_id',$creatorteamid)->get();

      $compId=Schoolteamcomp::where('school_id',$schoolid)->count();
      
 $teamstoreCreateId=DB::table('team_store')
                        ->where('school_id',$schoolid)
                        ->where('student_id',$studentid."_student")
                        // ->where('created_at', date('Y'))
                        ->count();
      $studenteamroleId=DB::table('studentTeam_Role')
                        ->where('schoolid',$schoolid)
                        ->where('studentid',$studentid)
                        // ->where('created_at', date('Y'))
                        ->count();


      return view('admin.Student.studentCompetition12', compact('teamid','teamstoreCreateId','studenteamroleId','compId','creatorteamid','schoolid','planid','assigndata','systemdate','studentid','pname','studentName','school_name','student_name','competition','test','hide','arr1','doc','enable','teamname'));

	  //return view('admin.Student.studentCompetition', compact('teamid','teamstoreCreateId','studenteamroleId','compId','creatorteamid','schoolid','planid','assigndata','systemdate','studentid','pname','studentName','school_name','student_name','competition','test','hide','arr1','doc','enable','teamname'));

	  }


  public function documentUpload(Request $request){

    $school_id      = $request->school_id;
    $student_id     = $request->student_id;
    $competition_id = $request->competition_id;  

    $team_id        = $request->team_id; 

    $title          = $request->title;
    $max_size       = $request->max_size;
    $file_formet    = $request->formet;
    $from_by        = $request->from_by;
    $flag        = $request->flag;
      
     if($request->hasFile('file_name'))
      {
          //$allowedfileExtension = ['pdf','jpg','png','docx'];
          $allowedfileExtension = ['pdf'];
          $file = $request->file('file_name');

          $filename = time()."_".$file->getClientOriginalName();
          $extension = $file->getClientOriginalExtension();

          $check = in_array($extension,$allowedfileExtension);
         
          if($check)
          {

           $file->move(public_path().'/team/doc_image/', $filename);

                  if($from_by == 'Group'){

                    $insertData = [
                            'image' => $filename,
                            'title' => $title,
                            'student_id' => $student_id,
                            'school_id' => $school_id,
                            'competition_id' => $competition_id,
                            'team_id' => $team_id,
                            'upload' => $from_by,
                            'upload_by' => 'Membar',
                            'flag'=>$flag,
                            'updated1'=>date('d/m/Y H:i:s')
                          ];
                  }else{

                      $insertData = [
                            'image' => $filename,
                            'title' => $title,
                            'student_id' => $student_id,
                            'school_id' => $school_id,
                            'competition_id' => $competition_id,
                            'team_id' => $team_id,
                            'upload' => $from_by,
                            'upload_by' => 'Self',
                            'flag'=>$flag,
                            'updated1'=>date('d/m/Y H:i:s')
                          ];
                  }

                $upload = DB::table('document_upload')->insert($insertData);  

                echo "success";      

          }else{
             // echo '<div class="alert alert-warning"><strong>Warning!</strong> Sorry Only Upload png , jpg , doc</div>';
            echo 'Invalid File';
            }
      }

  }

public function slogout(Request $request)
{

    Auth::logout();
    Session::flush();
    return redirect('/student-login');
}

    
    public function viewsCousrseS()
    {
		
         $email=Auth::user()->email;

         $data=[];
         $course_d=[];
         $pname=null;
         $planid=null;

         $studentid = Student::select('*')->where('mobileno',Auth::user()->mobile_no)->where('dob',Auth::user()->dob)->first()
                  ->id; 

         $schoolid = Student::select('*')->where('mobileno',Auth::user()->mobile_no)->where('dob',Auth::user()->dob)->first()
                  ->school_id; 

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
                         // join('memberships','memberships.id')
                        select('doc_types_id','course_masters_id','assigneddate','acyear','priority_set')
                        ->where('school_id',$schoolid)
                        ->where('student_id',$studentid)
                        ->where('acyear',$year)
                        ->where('Plan_id',$planid)
                        ->orderBy('assignedCoursetypes.priority_set', 'asc')
                        ->groupBy('course_masters_id')
                        ->get()->map(function($data){
                        	$data->testname = Course::where('id',$data->course_masters_id)
                        	                  ->first()->title;
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
                       $data->priority_set=$doc_course1['priority_set'];
                        $data->course_masters_id1=$doc_course1['course_masters_id'];

                     $data->resumevedio = $tet;

                      return $data;
                 })->toArray();
                
              }
           


//***************************** End  Select Course From Assigned Course Type *************************
        }        
        } 
      $data=array('details'=>$course_d,'systemdate'=>$systemdate,'pname'=>$pname,'studentid'=>$studentid,'schoolid'=>$schoolid,'planid'=>$planid,'Academic_year',$year);
    
      return $data;
       
    }
    
    
    
    public function video_activity(Request $request)
    {
        if($request->lengthOfVideo==$request->resumevedio)
        {
      $data=array(
            'schoolid'=>$request->schoolid,
            'studentid'=>$request->studentid,
            'planid'=>$request->planid,
            'vedioid'=>$request->vedioid,
            'lengthOfVideo'=>$request->lengthOfVideo,
            'leftremaining'=>$request->leftremaining,
            'resumevedio'=>$request->resumevedio,
            'status'=>1
            );
            DB::table('videoactivity')->insert($data);
        }
        else
        {
              $data=array(
            'schoolid'=>$request->schoolid,
            'studentid'=>$request->studentid,
            'planid'=>$request->planid,
            'vedioid'=>$request->vedioid,
            'lengthOfVideo'=>$request->lengthOfVideo,
            'leftremaining'=>$request->leftremaining,
            'resumevedio'=>$request->resumevedio,
            'status'=>0
            );
            DB::table('videoactivity')->insert($data);
        }
         
         
        
    }
    
    
    public function manufactureS($studentid1)
    {
		
     session_start();
     $timeout = 60;

      $arr=[];
      // $email=Auth::user()->email;

        // dd($studentid1);
      $studentid=base64_decode($studentid1);
     

       $data= explode(".",$studentid);
      
       $studentid=$data[0];
       $schoolid=$data[1];

       $studentiddd=$studentid."_student";
$checkTeamId = DB::table('team_store')
                      ->where('student_id',$studentiddd)
                      ->where('school_id',$schoolid)
                      ->first();
  if($checkTeamId==null){
 $strole= DB::table('studentTeam_Role')
                        ->where('studentid',$studentid)
                        ->where('schoolid',$schoolid)
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

                        
  } $studenteamroleId=DB::table('studentTeam_Role')
                        ->where('schoolid',$schoolid)
                        ->where('studentid',$studentid)
                        // ->where('created_at', date('Y'))
                        ->count();
						 $studenteamroleIdteam = DB::table('studentTeam_Role')
                        ->where('schoolid',$schoolid)
                        ->where('studentid',$studentid)
                        // ->where('created_at', date('Y'))
                        ->first();
                 //        echo $schoolid."==".$studentid;
                 // dd($studenteamroleIdteam);       
      // dd($compId);
	  $all=DB::table('studentTeam_Role')
                        ->where('teamId',$studenteamroleIdteam->teamId)
                        
                        // ->where('created_at', date('Y'))
                        ->get()->map(function($data){
							return $data->studentid;
						})->toArray();

       $stuname = DB::table('students')->find($data[0])->name;
       $schname = DB::table('schools')->find($data[1])->school_name;
       // $carbody=DB::table('carType')->where('studentid',$studentid)->where('schoolid',$schoolid)->get();
    $carbodypart=DB::table('stCarbodypart')->leftjoin('parts','parts.id','=','stCarbodypart.carpartid')
       ->select('stCarbodypart.studentidC','stCarbodypart.schoolidC','parts.parts','stCarbodypart.status','stCarbodypart.remark','stCarbodypart.created_at','stCarbodypart.updated_at','stCarbodypart.applicationid','stCarbodypart.carbodypart','stCarbodypart.carpartid','stCarbodypart.partimage','stCarbodypart.commentimage')
       ->whereIN('studentidC',$all)
       ->orderBy('applicationid', 'DESC')
       // ->groupBy('applicationid')
       ->get();

      foreach($carbodypart as $carbodyparts)
      {
        $arr[$carbodyparts->applicationid."_".$carbodyparts->status][]=$carbodyparts;
        
      }

      $carbodypart=$arr;
    // $carbodypart=Stcarbodypart::get();

     $studentName = DB::table('students')->select('students.name', 'schools.school_name','students.register_type')
            ->join('schools', 'schools.id', '=', 'students.school_id')
            ->where('mobileno',Auth::user()->mobile_no)
            ->where('dob',Auth::user()->dob)
            ->first();                     

    $details=$this->viewsCousrseS();
        if($details!=[])
        {
         $assigndata=$details['details'];
         $systemdate=$details['systemdate'];
         $pname=$details['pname'];
         $studentid=$details['studentid'];
         $schoolid=$details['schoolid'];
         $planid=$details['planid'];
         }   


      $compId=Schoolteamcomp::where('school_id',$schoolid)->count();
 $teamstoreCreateId=DB::table('team_store')
                        ->where('school_id',$schoolid)
                        ->where('student_id',$studentid."_student")
                        // ->where('created_at', date('Y'))
                        ->count();
	
       return view('admin.Student.manufaturePage',compact('teamstoreCreateId','studenteamroleId','compId','pname','studentName','studentid','schoolid','stuname','schname','carbodypart','creatorteamid'));    

     }
    
    
    public function newmanufatureCar($stuschid)
    {

     $arr=[];
        // $email = Auth::user()->email;
        
        $data= explode("_",base64_decode($stuschid));

        $studentid=$data[0];
        $schoolid=$data[1];

$studentiddd=$studentid."_student";
 

  $checkTeamId = DB::table('team_store')
                      ->where('student_id',$studentiddd)
                      ->where('school_id',$schoolid)
                      ->first();
                      
  if($checkTeamId==null){
 $strole= DB::table('studentTeam_Role')
                        ->where('studentid',$studentid)
                        ->where('schoolid',$schoolid)
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




        $stuname=DB::table('students')->find($data[0])->name;
        $schname=DB::table('schools')->find($data[1])->school_name;
         $planid = Assignpriceinschool::orderby('id','DESC')->where('schoolid',$data[1])->first()->planid??0;
        if($planid!=0)
        {
              $part = Partplan::where('plan_id',$planid)->get()->toArray();
              $partid = array_column($part, 'part_id');
              $partid = array_unique($partid);
              $bodypart = Part::whereIn('id',$partid)->get();

              
        }
        else
         {
            $bodypart = Part::where('id',0)->get();
         } 
        $cartype= DB::table('carType')->get();
       
        $studentName = DB::table('students')->select('students.name', 'schools.school_name','students.register_type')
            ->join('schools', 'schools.id', '=', 'students.school_id')
            ->where('mobileno',Auth::user()->mobile_no)
            ->where('dob',Auth::user()->dob)
            ->first();                    

    $details=$this->viewsCousrseS();
        if($details!=[])
        {
         $assigndata=$details['details'];
         $systemdate=$details['systemdate'];
         $pname=$details['pname'];
         $studentid=$details['studentid'];
         $schoolid=$details['schoolid'];
         $planid=$details['planid'];
         }   

   $compId=Schoolteamcomp::where('school_id',$schoolid)->count();
       $compId=Schoolteamcomp::where('school_id',$schoolid)->count();
                $teamstoreCreateId=DB::table('team_store')
                        ->where('school_id',$schoolid)
                        ->where('student_id',$studentid."_student")
                        // ->where('created_at', date('Y'))
                        ->count();


            $studenteamroleId=DB::table('studentTeam_Role')
                        ->where('schoolid',$schoolid)
                        ->where('studentid',$studentid)
                        // ->where('created_at', date('Y'))
                        ->count();

      return view('admin.Student.manufaturenewCar',compact('creatorteamid','teamstoreCreateId','studenteamroleId','compId','pname','systemdate','assigndata','studentName','studentid','schoolid','stuname','schname','bodypart','cartype'));
    }
    
    public function cartype(Request $request)
    {
       
        $this->validate($request, [
                'filename' => 'required',
                'prototypefilename'=>'required',
                 // 'filename' => 'required|prototypefilename|same',
        ]);
/* Below code for Prototypt Image */
  $prototypeimage = $request->hasfile('prototypefilename');
  $prototypeimage1 = $request->file('prototypefilename');
  if($prototypeimage1==null)
  {
     $prototypeimage = '';
  }
  else
  {
     $prototypeextension = $prototypeimage1->getClientOriginalExtension();
     $prototypesize=$request->file('prototypefilename')->getSize();
     // ||$prototypeextension=='stl' && $prototypesize<='20000000'||$prototypeextension=='iges'&& $prototypesize<='20000000'
if($prototypeextension=='f3d' && $prototypesize<='20000000')
       {

                 // $prototypeimage = time().'prototypeimage'.".".$prototypeextension;
                  $prototypeimage = $prototypeimage1->getClientOriginalName();
                  
       }
       else
       {
                $this->validate($request, [
                // 'filename' => 'required',
                'prototypefilename' => 'mimes:stl,f3d,iges'
        ]);
       }

  }

/*Code for Prototype End */
  // ||$extension=='stl' && $size<='20000000'||$extension=='iges'&& $size<='20000000'

  $image = $request->hasfile('filename');
  $test = $request->file('filename');
  $extension = $test->getClientOriginalExtension();
  $size=$request->file('filename')->getSize();
  if($extension=='stl' && $size<='20000000')
  {
            if($request->hasfile('filename'))
         {
                 $schoolname=School::find($request->schoolid)->school_name;
                 $studentname=Studentinfo::find($request->studentid)->name;
                 $sch = substr($schoolname, 0, 3);
                 $stu = substr($studentname, 0, 3);
                 $cr = Stcarbodypart::
                    orderBy('id', 'desc')
                    ->first();
                 $image= $request->file('filename') ;
                 $car=$image->getClientOriginalExtension();

                 $name = $image->getClientOriginalName();
                 // $name = time().'.'.$car;
                 $image->move(public_path().'/Carimage/', $name);
                 // Prototype Image
                  if($prototypeimage1!=null)
                   {
                    
                    $prototypeimage1->move(public_path().'/Carimage/', $prototypeimage);
                   }
                   else
                   {
                     $prototypeimage = '';
                   }

             //  if($prototypeimage!=$name)
             //     {
             //    $this->validate($request, [
             //    // 'filename' => 'required',
             //    'filename' => 'mimes:stl,f3d,iges'
             // ]);
   
                 // }
                 $bodyCarpart= new Stcarbodypart();
                 $bodyCarpart->studentidC=$request->studentid;
                 $bodyCarpart->schoolidC=$request->schoolid;
                 $bodyCarpart->carbodypart=$request->type;
                 $bodyCarpart->partimage=$name;
                 $bodyCarpart->prototypeimage=$prototypeimage;
                 $bodyCarpart->status=0;
                 

                if($cr==null)
                    {
                        $ids=strtoupper($stu)."-".strtoupper($sch)."-".sprintf('%04d',1);
                        $bodyCarpart->applicationid=$ids;
                    }
                    else
                    {
                         $test=explode('-',$cr->applicationid);
                        $ids=strtoupper($stu)."-".strtoupper($sch)."-".sprintf('%04d', $test[2]+1);
                        $bodyCarpart->applicationid=$ids;
                    }
                 $bodyCarpart->save();
                 $check = Stcarbodypart::where('id',$bodyCarpart->id)->first();

         }
                $stsc=$request->studentid."_".$request->schoolid;
                $stuschid=base64_encode($stsc);
                $test=$ids."_".$stuschid;
             return redirect('car_bodypart_type/'.$test);
  }
  else
   {
                 $this->validate($request, [
                // 'filename' => 'required',
                'filename' => 'mimes:stl,f3d'
        ]);
   }
   }
    
    
    public function carbodypart(Request $request)
    {
           $this->validate($request, [
                 'filename' => 'required',
                // 'filename' => 'mimes:stl,f3d,iges|max:2048'
        ]);
$e=0;
if($request->Application!='Null')
{
        $partname=$request->partname;
        if($request->hasfile('filename'))
         {
             $err=count($request->file('filename'));
            foreach($request->file('filename') as $key=> $image)
            {
                 $extension = $image->getClientOriginalExtension();
                 $size=$image->getSize();
    if($extension=='f3d' && $size<='20000000'||$extension=='stl' && $size<='20000000'||$extension=='iges'&& $size<='20000000
      ')
                   {
                    $e=$e+1;
               }
               else{
      $this->validate($request, [
                // 'filename' => 'required',
                'filename' => 'mimes:stl,f3d,iges'
        ]);
               }
            }
             $schoolname=School::find($request->schoolid)->school_name;
                 $studentname=Studentinfo::find($request->studentid)->name;
                 $sch = substr($schoolname, 0, 3);
                 $stu = substr($studentname, 0, 3);
                 $cr = Stcarbodypart::
                    orderBy('id', 'desc')
                    ->first();
       if($cr==null)
                    {
                        $ids=strtoupper($stu)."-".strtoupper($sch)."-".sprintf('%04d',1);
                    }
                    else
                    {
                         $test=explode('-',$cr->applicationid);
                        $ids=strtoupper($stu)."-".strtoupper($sch)."-".sprintf('%04d', $test[2]+1);
                    }
        if($err==$e){
          foreach($request->file('filename') as $key=> $image)
            {
                 $id=Stcarbodypart::orderby('id','DESC')->first()->id;
                 $carbody=$image->getClientOriginalExtension();
                 // $name = time().$id.'.'.$carbody;

                 $name =  $image->getClientOriginalName();
                 $image->move(public_path().'/Carimage/', $name);
                 $bodyCarpart= new Stcarbodypart();
                 $bodyCarpart->studentidC=$request->studentid;
                 $bodyCarpart->schoolidC=$request->schoolid;
                 $bodyCarpart->carbodypart=$request->carpart;
                 $bodyCarpart->carpartid=$partname[$key];
                 $bodyCarpart->partimage=$name;
                 $bodyCarpart->status=0;
                 $bodyCarpart->applicationid=$request->Application;
                 $bodyCarpart->save();
               }
               }
            $st_sc_id=$request->studentid.".".$request->schoolid;
  }
             return redirect('manufacturePage/'.base64_encode($st_sc_id));
         }
         else
         {
          $e=0;
            $partname=$request->partname;
        if($request->hasfile('filename'))
         {
           $err=count($request->file('filename'));
            foreach($request->file('filename') as $key=> $image)
            {
                 $extension = $image->getClientOriginalExtension();
                 $size=$image->getSize();
if($extension=='f3d' && $size<='20000000'||$extension=='stl' && $size<='20000000'||$extension=='iges'&& $size<='20000000
')
              {
             $e=$e+1;
              }
              else
              {
                      $this->validate($request, [
                // 'filename' => 'required',
                'filename' => 'mimes:stl,f3d,iges'
                ]);
              }
            }
              $schoolname=School::find($request->schoolid)->school_name;
                 $studentname=Studentinfo::find($request->studentid)->name;
                 $sch = substr($schoolname, 0, 3);
                 $stu = substr($studentname, 0, 3);
                 $cr = Stcarbodypart::
                    orderBy('id', 'desc')
                    ->first();
             if($cr==null)
                    {
                        $ids=strtoupper($stu)."-".strtoupper($sch)."-".sprintf('%04d',1);
                    }
                    else
                    {
                         $test=explode('-',$cr->applicationid);
                        $ids=strtoupper($stu)."-".strtoupper($sch)."-".sprintf('%04d', $test[2]+1);
                    }
          if($err==$e){
          foreach($request->file('filename') as $key=> $image)
            {
                 $id=Stcarbodypart::orderby('id','DESC')->first()->id;
                 $carbody=$image->getClientOriginalExtension();
                 // $name = time().$id.'.'.$carbody;
                $name =  $image->getClientOriginalName();
                 $image->move(public_path().'/Carimage/', $name);
                 $bodyCarpart= new Stcarbodypart();
                 $bodyCarpart->studentidC=$request->studentid;
                 $bodyCarpart->schoolidC=$request->schoolid;
                 $bodyCarpart->carbodypart=$request->carpart;
                 $bodyCarpart->carpartid=$partname[$key];
                 $bodyCarpart->partimage=$name;
                 $bodyCarpart->status=0;
                 $bodyCarpart->applicationid=$ids;
                 $bodyCarpart->save();
               }
               }
            $st_sc_id=$request->studentid.".".$request->schoolid;
            return redirect('manufacturePage/'.base64_encode($st_sc_id));
         }
    }

    }
    
    
    public function manufacturecaraplyList($schoolidm)
    {
    
    // $kpart=[];

    $k=CarType::where('schoolid',base64_decode($schoolidm))->get()->map(function($data){return $data;})->toArray();
    $kpart=Stcarbodypart::
        join('carbodypart','carbodypart.id','=','stCarbodypart.carpartid')
        ->
        select('stCarbodypart.id','studentidC','schoolidC','carbodypart','carpartid','partimage','stCarbodypart.status','Partname')->
        where('schoolidC',base64_decode($schoolidm))->get()->map(function($data){return $data;})->toArray();
    
   return view('admin.Student.manufactureAplyList',compact('k','kpart'));
    }
    
    public function approvedbyadminmanufacture($Appid)
    {
      $approved=Stcarbodypart::where('applicationid',$Appid)->update(array('status' => 1));
     return redirect('manufacturing-applications');
      // echo 'ok';

      // if($request->body=="carbody"){
      //     // $ids=explode("_",$request->ids);
         
      //      $approved=CarType::where('applicationid',$request->appid)->update(array('status' => 1));
      //      echo $approved;
      // }
      // else
      // {
      //      // $ids=explode("_",$request->ids);
      //     $approved=Stcarbodypart::where('applicationid',$request->appid)->where('id',$request->ids)->update(array('status' => 1));
      //     echo $approved;
         
      // }
    }

    public function approveData(Request $request)
    {

      // if($request->body=="carbody"){
          
          // echo "approve";
           $approved=CarType::where('applicationid',$request->appid)->update(array('status' => 1));

            $approved=Stcarbodypart::where('applicationid',$request->appid)->update(array('status' => 1));
          echo $approved;
      // }
      // else
      // {
          
      //     $approved=Stcarbodypart::where('applicationid',$request->appid)->where('id',$request->ids)->update(array('status' => 1));
      //     echo $approved;
         
      // }
    }
    
    public function rejectedbyadminmanufacture(Request $request)
    {
     $this->validate($request, [
                'commentimage' => 'mimes:jpeg,jpg,png,gif'
        ]);
       if($request->hasfile('commentimage'))
         {
       $image = $request->file('commentimage');
       $car=$image->getClientOriginalExtension();
       $name = time().'.'.$car;
        $image->move(public_path().'/Carimage/', $name);
       }
       else
       {
        $name = "";
       }
      Stcarbodypart::where('applicationid',$request->Appication)
      ->update(array('remark' => $request->remarks,'commentimage'=>$name,'status' => 2));
       return redirect('manufacturing-applications');

////
    if($request->body=="carbody"){
   
         $reject=CarType::where('applicationid',$request->appid)->update(array('remark' => $request->remark,'status' => 2));
         Stcarbodypart::where('applicationid',$request->appid)->update(array('remark' => $request->remark,'status' => 2));
    }
    else
    {
       
        $reject=Stcarbodypart::where('applicationid',$request->appid)->update(array('remark' => $request->remark,'status' => 2));
        CarType::where('applicationid',$request->appid)->update(array('remark' => $request->remark,'status' => 2));
    }
    }
    
    public function carmanufacturestatus($scid)
    {
       $ssid=explode("-",base64_decode($scid));
       if($ssid[2]=="body")
       {
       $carbodyt=CarType::where('studentid',$ssid[0])->where('schoolid',$ssid[1])->get()->map(function($data){return $data;})->toArray();
        
       
       return view('admin.Student.manufaturecarTrainercarbodylist',compact('carbodyt'));
      
       }
       else
      
       {
            $ssid=explode("-",base64_decode($scid));
           
           $carbodypart=Stcarbodypart::where('studentidC',$ssid[0])->where('schoolidC',$ssid[1])->get()->map(function($data){return $data;})->toArray();
         
             return view('admin.Student.manufaturecarTrainercarpartbodylist',compact('carbodypart'));
           
          
       }
    }
    
    public function vediojs($vedio)
    {
        $email = Auth::user()->email;
        $ids=explode("/",base64_decode($vedio));
        $vedioid=$ids[0];
        $studentid=$ids[1];
        $schoolid=$ids[2];
        $planid=$ids[3];
        $resumevedio=$ids[4];
        $thumbnail=$ids[5];
        $assigndate=$ids[6];

     
        $studentiddd=$studentid."_student";
 

  $checkTeamId = DB::table('team_store')
                      ->where('student_id',$studentiddd)
                      ->where('school_id',$schoolid)
                      ->first();
  if($checkTeamId==null){

 $strole= DB::table('studentTeam_Role')
                        ->where('studentid',$studentid)
                        ->where('schoolid',$schoolid)
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
       

        $courseinfo= DB::table('courses')
        ->join('course_masters','course_masters.id','=','courses.course_masters_id')
        ->join('doc_types','doc_types.id','=','courses.doc_types_id')
        ->where('courses.id',$vedioid)
        ->get()->map(function($data){return $data;});
     
       

        $studentName = DB::table('students')
                      ->select('students.name','schools.school_name','students.register_type')
                      ->join('schools','schools.id','=','students.school_id')
                      // ->where('studentemail', $email)
                      ->where('mobileno',Auth::user()->mobile_no)
                      ->where('dob',Auth::user()->dob)
                      ->first();   


   $details=$this->viewsCousrseS();
        if($details!=[])
        {
         $assigndata=$details['details'];
         $systemdate=$details['systemdate'];
         $pname=$details['pname'];
         $studentid=$details['studentid'];
         $schoolid=$details['schoolid'];
         $planid=$details['planid'];
         } 
       $compId=Schoolteamcomp::where('school_id',$schoolid)->count();
       $compId=Schoolteamcomp::where('school_id',$schoolid)->count();
      $teamstoreCreateId=DB::table('team_store')
                        ->where('school_id',$schoolid)
                        ->where('student_id',$studentid."_student")
                        // ->where('created_at', date('Y'))
                        ->count();

      $studenteamroleId=DB::table('studentTeam_Role')
                        ->where('schoolid',$schoolid)
                        ->where('studentid',$studentid)
                        // ->where('created_at', date('Y'))
                        ->count();
              // viewvedio   

        return view('admin.Student.course_list',compact('compId','teamstoreCreateId','studenteamroleId','pname','studentName','vedioid','studentid','schoolid','planid','resumevedio','thumbnail','assigndate','courseinfo','creatorteamid','assigndata','systemdate','pname','vedioid'));
    }

    
    public function attempvediojs($vedio)
    {
        $email = Auth::user()->email;
        $ids = explode("/",base64_decode($vedio));
       // dd($ids);
        $vedioid=$ids[0];
        $studentid=$ids[1];
        $schoolid=$ids[2];
        $planid=$ids[3];
        $resumevedio=$ids[4];
        $thumbnail=$ids[5];
        $assigndate=$ids[6];
        $vedioplayurl=$vedioid."/".$studentid."/".$schoolid."/".$planid."/".$resumevedio;

        

        $studentiddd=$studentid."_student";
 

  $checkTeamId = DB::table('team_store')
                      ->where('student_id',$studentiddd)
                      ->where('school_id',$schoolid)
                      ->first();
  if($checkTeamId==null){

 $strole= DB::table('studentTeam_Role')
                        ->where('studentid',$studentid)
                        ->where('schoolid',$schoolid)
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

        $courseinfo= DB::table('courses')
        ->join('course_masters','course_masters.id','=','courses.course_masters_id')
        ->join('doc_types','doc_types.id','=','courses.doc_types_id')
        ->where('courses.id',$vedioid)
        ->get()->map(function($data){return $data;});
      

        $studentName = DB::table('students')
                      ->select('students.name','schools.school_name','students.register_type')
                      ->join('schools','schools.id','=','students.school_id')
                      // ->where('studentemail', $email)
                      ->where('mobileno',Auth::user()->mobile_no)
                      ->where('dob',Auth::user()->dob)
                      ->first();                     

   $details=$this->viewsCousrseS();
        if($details!=[])
        {
         $assigndata=$details['details'];
         $systemdate=$details['systemdate'];
         $pname=$details['pname'];
         $studentid=$details['studentid'];
         $schoolid=$details['schoolid'];
         $planid=$details['planid'];
         } 
          $compId=Schoolteamcomp::where('school_id',$schoolid)->count();

        $teamstoreCreateId=DB::table('team_store')
                        ->where('school_id',$schoolid)
                        ->where('student_id',$studentid."_student")
                        // ->where('created_at', date('Y'))
                        ->count();

        $studenteamroleId=DB::table('studentTeam_Role')
                        ->where('schoolid',$schoolid)
                        ->where('studentid',$studentid)
                        // ->where('created_at', date('Y'))
                        ->count();
//viewattempvedio
   return view('admin.Student.course_list1',compact('compId','teamstoreCreateId','studenteamroleId','pname','studentName','vedioid','studentid','schoolid','planid','resumevedio','thumbnail','assigndate','courseinfo','creatorteamid','assigndata','systemdate','pname','vedioid','vedioplayurl'));

        // return view('admin.Student.viewattempvedio',compact('teamstoreCreateId','studenteamroleId','compId','pname','studentName','vedioid','studentid','schoolid','planid','resumevedio','thumbnail','assigndate','courseinfo','vedioplayurl','creatorteamid')); 
    }
    
    public function Attepmtplayvedio($attemptid)
    {
       

        $email = Auth::user()->email;
        $ids = explode("/",base64_decode($attemptid));
        $vedioid = $ids[0];
        $studentid = $ids[1];
        $schoolid = $ids[2];
        $planid = $ids[3];
        $resumevedio = $ids[4];
        $studentiddd = $studentid."_student";
        
        // AssignedCoursetype::where('student_id',$studentid)
        //                     ->where('')
      

    $checkTeamId = DB::table('team_store')
                      ->where('student_id',$studentiddd)
                      ->where('school_id',$schoolid)
                      ->first();
  if($checkTeamId==null){

 $strole= DB::table('studentTeam_Role')
                        ->where('studentid',$studentid)
                        ->where('schoolid',$schoolid)
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
        $video = DB::table('courses')->where('id', $vedioid)->first();
         $studentName = DB::table('students')
                      ->select('students.name','schools.school_name','students.register_type')
                      ->join('schools','schools.id','=','students.school_id')
                      // ->where('studentemail', $email)
                      ->where('mobileno',Auth::user()->mobile_no)
                      ->where('dob',Auth::user()->dob)
                      ->first();


        $details=$this->viewsCousrseS();
        if($details!=[])
        {
         $assigndata=$details['details'];
         $systemdate=$details['systemdate'];
         $pname=$details['pname'];
         $studentid=$details['studentid'];
         $schoolid=$details['schoolid'];
         $planid=$details['planid'];
         } 

              
              $compId=Schoolteamcomp::where('school_id',$schoolid)->count();
              $teamstoreCreateId=DB::table('team_store')
                        ->where('school_id',$schoolid)
                        ->where('student_id',$studentid."_student")
                        // ->where('created_at', date('Y'))
                        ->count();

      $studenteamroleId=DB::table('studentTeam_Role')
                        ->where('schoolid',$schoolid)
                        ->where('studentid',$studentid)
                        // ->where('created_at', date('Y'))
                        ->count();
              // playattempvedio          
        return view('admin.Student.attemp_course',compact('teamstoreCreateId','studenteamroleId','compId','video','pname','studentName','vedioid','studentid','schoolid','planid','resumevedio','creatorteamid')); 
    }

    public function emailSendPassword(){

      $createPassword = time('his');

      $data = DB::table('students')
                    ->where('password_send', '0')
                    ->first();

      $user = new User();

       $user->name      = $data->name;
       $user->email     = $data->studentemail;
       $user->password  = bcrypt($createPassword.$data->id);
       $user->role      = 5;
       $user->save();

      $emailData = [
                "studentname" =>  $data->name,
                'email'       =>  $data->studentemail,
                'password'    =>  $createPassword.$data->id
              ];

          Mail::send('Mail.studentM', $emailData, function($message) use($emailData){
              
              $message->to($emailData['email'], 'noreply@whitegarlic.in')
                      ->subject('Welcome to F1school');

              $message->from('noreply@whitegarlic.in','F1School');
          });

      $update = DB::table('students')
                    ->where('id', $data->id)
                    ->update(['password_send'=>'1']);

          echo "Mail Send Successfully..";          

    }
  //**************************************
public function studentprofileedit(Request $req)
   {
       if($req->ajax())
       {
        $studentid=$req->id;
        //$data= Student::where('id',$studentid)->first()->toArray();
              $data= Student::where('id',$studentid)->get()->map(function($input) use($studentid){
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
   public function updatestudentinfo(Request $request)
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
        
            $check = Studentinfo::where('id', $data['hid'])->update(['name' => $data['name'], 'class' => $data['class'], 'section' => $data['section'], 'dob' => $data['dob'], 'mobileno' => $data['mobileno'], 'address' => $data['address'],'studentemail'=>$data['studentemail'], 'tsize' => $data['tsize'], 'guardianname1' => $data['guardianname1'], 'guardianemail1' => $data['guardianemail1'], 'guardianphone1' => $data['guardianphone1'], 'guardianname2' => $data['guardianname2'], 'guardianemail2' => $data['guardianemail2'], 'guardianphone2' => $data['guardianphone2'],'profileimage'=>$data['image111']]);
             User::where('dob',$data['dob'])->where('mobile_no',$data['mobileno'])->update(['email'=>$data['studentemail']]);

              return response()->json(['success' => 'Data Updated Successfully.']);
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


  //*************************************





   public function car_bodypart_type($Appid)
   {

        $application_id=explode("_", $Appid); 

        // $email = Auth::user()->email;

        $appid=$application_id[0];
        $data= explode("_",base64_decode($application_id[1]));
        $studentid=$data[0];
        $schoolid=$data[1];
        $studentiddd=$studentid."_student";
          $checkTeamId = DB::table('team_store')
                      ->where('student_id',$studentiddd)
                      ->where('school_id',$schoolid)
                      ->first();
                      
  if($checkTeamId==null){
 $strole= DB::table('studentTeam_Role')
                        ->where('studentid',$studentid)
                        ->where('schoolid',$schoolid)
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




        $stuname = DB::table('students')->find($data[0])->name;
        $schname = DB::table('schools')->find($data[1])->school_name;
        // $bodypart = DB::table('carbodypart')->get();

       $planid = Assignpriceinschool::orderby('id','DESC')->where('schoolid',$data[1])->first()->planid??0;
        if($planid!=0)
        {
              $part = Partplan::where('plan_id',$planid)->get()->toArray();
              $partid = array_column($part, 'part_id');
              $partid = array_unique($partid);
              $bodypart = Part::whereIn('id',$partid)->get();

              
        }
        else
         {
            $bodypart = Part::where('id',0)->get();
         } 

        
        // $bodypart = DB::table('carbodypart')->get();
        $cartype = DB::table('carType')->get();
       
         $studentName = DB::table('students')
                      ->select('students.name','schools.school_name','students.register_type')
                      ->join('schools','schools.id','=','students.school_id')
                     ->where('mobileno',Auth::user()->mobile_no)
                      ->where('dob',Auth::user()->dob)
                      ->first();                     

    $details=$this->viewsCousrseS();
        if($details!=[])
        {
         $assigndata=$details['details'];
         $systemdate=$details['systemdate'];
         $pname=$details['pname'];
         $studentid=$details['studentid'];
         $schoolid=$details['schoolid'];
         $planid=$details['planid'];
         }   

       $compId = Schoolteamcomp::where('school_id',$schoolid)->count();
       $compId = Schoolteamcomp::where('school_id',$schoolid)->count();
       $teamstoreCreateId = DB::table('team_store')
                        ->where('school_id',$schoolid)
                        ->where('student_id',$studentid."_student")
                        // ->where('created_at', date('Y'))
                        ->count();


            $studenteamroleId = DB::table('studentTeam_Role')
                              ->where('schoolid',$schoolid)
                              ->where('studentid',$studentid)
                        // ->where('created_at', date('Y'))
                              ->count();

      return view('admin.Student.Carbodypart',compact('creatorteamid','teamstoreCreateId','studenteamroleId','compId','pname','systemdate','assigndata','studentName','studentid','schoolid','stuname','schname','bodypart','cartype','appid'));


   }

 // Order List Show by student
    public function orderList($stuschid)
    {
      
        // $email = Auth::user()->email;
        $data = explode("_", base64_decode($stuschid));

        $studentid = $data[0];
        $schoolid = $data[1];
        $studentiddd = $studentid . "_student";
        $checkTeamId = DB::table('team_store')->where('student_id', $studentiddd)->where('school_id', $schoolid)->first();

        if ($checkTeamId == null)
        {
            $strole = DB::table('studentTeam_Role')->where('studentid', $studentid)->where('schoolid', $schoolid)->first();
            if ($strole == null)
            {
                $creatorteamid = 'N/A';
            }
            else
            {
                $creatorteamid = $strole->studentid;
            }

        }
        else
        {

            $creatorteamid = $checkTeamId->id;

        }

        $stuname = DB::table('students')->find($data[0])->name;
        $schname = DB::table('schools')->find($data[1])->school_name;
        $bodypart = DB::table('carbodypart')->get();
        $cartype = DB::table('carType')->get();

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
        $compId = Schoolteamcomp::where('school_id', $schoolid)->count();
        $teamstoreCreateId = DB::table('team_store')->where('school_id', $schoolid)->where('student_id', $studentid . "_student")
        // ->where('created_at', date('Y'))
        ->count();

        $studenteamroleId = DB::table('studentTeam_Role')->where('schoolid', $schoolid)->where('studentid', $studentid)
        // ->where('created_at', date('Y'))
        ->count();

        $checkteamstudent = StudentTeam_Role::where('studentid', $studentid)
            ->first();
        $checkteamstudent->teamId;
        $studentids=StudentTeam_Role::where('teamId',$checkteamstudent->teamId)->get();
        $teaminfo = Team_Store::where('id', $checkteamstudent->teamId)
            ->first();

        // $pay=Orederstaus::where('order_id',$orderid)->first();
        // $order = Payment::where('student_id', $studentid)->get();
          $order = Payment::where('teamid', $checkteamstudent->teamId)
                   ->orderBy('order_id','DESC')
                   ->get();
          foreach ($order as $key => $value) {
            $order[$key]->studentname=Studentinfo::where('id',$value->student_id)->first()->name;
            $order[$key]->teamname=Team_Store::where('id', $checkteamstudent->teamId)
            ->first()->team_Name;

/*************start amount Details *****************************/
        $quan=0;
     $quan = Cartdetail::where('orderid', $value->order_id)->where('product',0)->first();
     $quan=$quan->quantity??0;
        $orderdetails = Cartdetail::where('orderid', $value->order_id)->get()->map(function ($data)
        {
      
            if ($data->product == 0 && $data->mat_id == 0)
            {
                $data->productname = 'carbody';
                $data->materialname = 'meterial';
        
            }
            else
            {

                if ($data->mat_id == 0 || $data->product == 0)
                {
                    $data->productname = Part::where('id', 1)
                        ->first()->parts;
                    $data->materialname = Material::where('id', 1)
                        ->first()->material;
                }
                else
                {
                    $data->productname = Part::where('id', $data->product)
                        ->first()->parts;
                    $data->materialname = Material::where('id', $data->mat_id)
                        ->first()->material;
                }
            }
            return $data;
        });


        $tot = $orderdetails->toArray();
        $totalprice = array_sum(array_column($tot, 'price'));

         $order[$key]->amount = $totalprice;
        
        $pay = Orederstaus::where('order_id', $value->order_id)->first()->order_id??0;
        if($pay!=0)
        {
        $pays = Payment::where('order_id', $pay)
            ->first()->student_id??0;

       if($pays!=0)
       {
        $student = Studentinfo::where('id', $pays)
            ->first();
        $checkteamstudent = StudentTeam_Role::where('studentid', $pays)
            ->first();
        $checkteamstudent->teamId;
        $teaminfo = Team_Store::where('id', $checkteamstudent->teamId)
            ->first();
        $schoolid = $student->school_id;

        $school = School::where('id', $schoolid)->first();
        $plan = Assignpriceinschool::where('schoolid', $schoolid)->orderby('id','desc')->first();
      
        $shipingAddress = Orederstaus::where('order_id', $value->order_id)->first();
        $plans = Plan::where('id', $plan->planid)
            ->first();
          }
        $mancost = $plans->manufacturing_cost*$quan;
    
        $mancost1 = $mancost + $totalprice;
        $order[$key]->amount = $mancost1;
/************* start amount Details ******************************/

          }
        }

        return view('StudentCompetition.orderlist', compact('creatorteamid', 'teamstoreCreateId', 'studenteamroleId', 'compId', 'pname', 'systemdate', 'assigndata', 'studentName', 'studentid', 'schoolid', 'stuname', 'schname', 'bodypart', 'cartype', 'order'));
    }



 // Transaction View
    public function ordersdetails($orderid)
    {

        $email = Auth::user()->email;

        $data = Studentinfo::where('studentemail', $email)->first();

        $studentid = $data->id;
        $schoolid = $data->school_id;

        $studentiddd = $studentid . "_student";

        $checkTeamId = DB::table('team_store')->where('student_id', $studentiddd)->where('school_id', $schoolid)->first();

        if ($checkTeamId == null)
        {
            $strole = DB::table('studentTeam_Role')->where('studentid', $studentid)->where('schoolid', $schoolid)->first();
            if ($strole == null)
            {
                $creatorteamid = 'N/A';
            }
            else
            {
                $creatorteamid = $strole->studentid;
            }

        }
        else
        {

            $creatorteamid = $checkTeamId->id;

        }

        $stuname = DB::table('students')->find($studentid)->name;
        $schname = DB::table('schools')->find($schoolid)->school_name;
        $bodypart = DB::table('carbodypart')->get();
        $cartype = DB::table('carType')->get();

        $studentName = DB::table('students')->select('students.name', 'schools.school_name','students.register_type')
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

        $compId = Schoolteamcomp::where('school_id', $schoolid)->count();
        $compId = Schoolteamcomp::where('school_id', $schoolid)->count();
        $teamstoreCreateId = DB::table('team_store')->where('school_id', $schoolid)->where('student_id', $studentid . "_student")
        // ->where('created_at', date('Y'))
        ->count();

        $studenteamroleId = DB::table('studentTeam_Role')->where('schoolid', $schoolid)->where('studentid', $studentid)
        // ->where('created_at', date('Y'))
        ->count();

        // Order List detailsa
        $orderid = decrypt($orderid);
        $quan=0;
		 $quan = Cartdetail::where('orderid', $orderid)->where('product',0)->first();
		 $quan=$quan->quantity??0;
        $orderdetails = Cartdetail::where('orderid', $orderid)->get()->map(function ($data)
        {
			
            if ($data->product == 0 && $data->mat_id == 0)
            {
                $data->productname = 'carbody';
                $data->materialname = 'meterial';
				
            }
            else
            {

                if ($data->mat_id == 0 || $data->product == 0)
                {
                    $data->productname = Part::where('id', 1)
                        ->first()->parts;
                    $data->materialname = Material::where('id', 1)
                        ->first()->material;
                }
                else
                {
                    $data->productname = Part::where('id', $data->product)
                        ->first()->parts;
                    $data->materialname = Material::where('id', $data->mat_id)
                        ->first()->material;
                }
            }
            return $data;
        });


        $tot = $orderdetails->toArray();
        $totalprice = array_sum(array_column($tot, 'price'));

      $pay = Orederstaus::where('order_id', $orderid)->first()??'N/A';

       if($pay!='N/A')
       {
       
        $pays = Payment::where('order_id', $pay->order_id)
            ->first()??'N/A';
       if($pays!='N/A'){
        $student = Studentinfo::where('id', $pays->student_id)
            ->first();
        $checkteamstudent = StudentTeam_Role::where('studentid', $pays->student_id)
            ->first();
        $checkteamstudent->teamId;
        $teaminfo = Team_Store::where('id', $checkteamstudent->teamId)
            ->first();
        $schoolid = $student->school_id;

        $school = School::where('id', $schoolid)->first();
        $plan = Assignpriceinschool::where('schoolid', $schoolid)->orderby('id','desc')->first();
      
        $shipingAddress = Orederstaus::where('order_id', $orderid)->first();
        $plans = Plan::where('id', $plan->planid)
            ->first();

        $mancost = $plans->manufacturing_cost*$quan;
		
        $mancost1 = $mancost + $totalprice;
      }
      }

        return view('StudentCompetition.orderslist', compact('creatorteamid', 'teamstoreCreateId', 'studenteamroleId', 'compId', 'pname', 'systemdate', 'assigndata', 'studentName', 'studentid', 'schoolid', 'stuname', 'schname', 'bodypart', 'cartype', 'orderdetails', 'shipingAddress', 'totalprice', 'mancost', 'mancost1', 'teaminfo', 'school', 'student', 'pays','pay'));

    }


public function uploadImage(Request $request)

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


   public function studentprofile($studentid)
   {

      $email = Auth::user()->email;
       $role=Auth::user()->role;
       if($role==5)
       {
       $status= Student::select('*')->where('mobileno',Auth::user()->mobile_no)->where('dob',Auth::user()->dob)
                    ->first()->status;
       if($status==1){
       $studentid= Student::select('*')->where('mobileno',Auth::user()->mobile_no)->where('dob',Auth::user()->dob)->first()->id;
       $schoolid= Student::select('*')->where('mobileno',Auth::user()->mobile_no)->where('dob',Auth::user()->dob)->first()->school_id;
    $studentiddd=$studentid."_student";
    $checkTeamId = DB::table('team_store')
                      ->where('student_id',$studentiddd)
                      ->where('school_id',$schoolid)
                      ->first();
  if($checkTeamId==null){
 $strole= DB::table('studentTeam_Role')
                        ->where('studentid',$studentid)
                        ->where('schoolid',$schoolid)
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
       $studentName = DB::table('students')
                      ->select('students.name','schools.school_name','students.profileimage','students.register_type','students.order_status','students.last_login')
                      ->join('schools','schools.id','=','students.school_id')
                      ->where('students.id',$studentid)
                      ->first();
             
        //code start by upanshu
              $teamrealtedtoschool= DB::table('team_store')
                                    ->where('school_id',$schoolid)->select('student_id')
                                    ->get()->toArray();
          // $compId=Schoolteamcomp::where('school_id',$schoolid)->count();
              //dd($teamrealtedtoschool);
            if($role==5)
            {
              $student_id =$studentid.'_student';
            }
        //code end by upanshu
        $details=$this->viewsCousrseS();
        if($details!=[])
        {
        $assigndata=$details['details'];
         $systemdate=$details['systemdate'];
         $pname=$details['pname'];
         $studentid=$details['studentid'];
         $schoolid=$details['schoolid'];
         $planid=$details['planid'];
         }
      $compId=Schoolteamcomp::where('school_id',$schoolid)->count();

     $teamstoreCreateId=DB::table('team_store')
                        ->where('school_id',$schoolid)
                        ->where('student_id',$studentid."_student")
                        // ->where('created_at', date('Y'))
                        ->count();
      $studenteamroleId=DB::table('studentTeam_Role')
                        ->where('schoolid',$schoolid)
                        ->where('studentid',$studentid)
                        // ->where('created_at', date('Y'))
                        ->count();


// Team Member In Perticular
         $teamid = StudentTeam_Role::where('studentid',$studentid)->first()->teamId??"NO";
         $info = StudentTeam_Role::where('teamId',$teamid)->get()??"NO";

              if($info!='NO')
              foreach ($info as $key => $value) {
                $info[$key]['MembarName'] = Studentinfo::where('id',$value->studentid)->first()->name;
                 $info[$key]['Role'] = StudentTeam_Role::where('studentid',$value->studentid)->first()->studentRole;
                 $info[$key]['ProfileImage'] = Studentinfo::where('id',$value->studentid)->first()->profileimage;
                 $info[$key]['MemberStatus'] = StudentTeam_Role::where('studentid',$value->studentid)->first()->status;
                 $info[$key]['team_Name'] = Team_Store::where('id',$teamid)->first()->team_Name;
                 $info[$key]['team_Image'] = Team_Store::where('id',$teamid)->first()->team_Image;
              }
            
           $manufacture =   StudentTeam_Role::where('teamId',$teamid)->get()??"NO"; 
          if($manufacture!='NO')
              foreach ($manufacture as $key => $value) {
                $manufacture[$key]['MembarName'] = Studentinfo::where('id',$value->studentid)->first()->name;
                 $manufacture[$key]['applicationid'] = Stcarbodypart::where('studentidC',$value->studentid)->first()->applicationid??'N/A';
                 $manufacture[$key]['created_at'] = Studentinfo::where('id',$value->studentid)->first()->created_at;
                 $manufacture[$key]['created_at'] = Studentinfo::where('id',$value->studentid)->first()->created_at;
                 $manufacture[$key]['MemberStatus'] = Stcarbodypart::where('studentidC',$value->studentid)->first()->status??'N/A';
              } 

          /*******Order Status*******/
          // $studentid
        $checkteamstudentid = StudentTeam_Role::where('studentid', $studentid)
            ->first()->teamId??0;
        $order = Payment::where('teamid', $checkteamstudentid)
                   ->orderBy('order_id','DESC')
                   ->take(4)
                   ->get();
        if($checkteamstudentid!=0)
        {
        $studentids=StudentTeam_Role::where('teamId',$checkteamstudentid)->get();
        $teaminfo = Team_Store::where('id', $checkteamstudentid)
            ->first();
            // $checkteamstudentid
          $order = Payment::where('teamid', $checkteamstudentid)
                   ->orderBy('order_id','DESC')
                   ->take(4)
                   ->get();



          foreach ($order as $key => $value) {
            $order[$key]->studentname=Studentinfo::where('id',$value->student_id)->first()->name;
            $order[$key]->teamname=Team_Store::where('id', $checkteamstudentid)
            ->first()->team_Name;

            /***************************/
      $quan=0;
     $quan = Cartdetail::where('orderid', $value->order_id)->where('product',0)->first();
     $quan=$quan->quantity??0;
        $orderdetails = Cartdetail::where('orderid', $value->order_id)->get()->map(function ($data)
        {
      
            if ($data->product == 0 && $data->mat_id == 0)
            {
                $data->productname = 'carbody';
                $data->materialname = 'meterial';
        
            }
            else
            {

                if ($data->mat_id == 0 || $data->product == 0)
                {
                    $data->productname = Part::where('id', 1)
                        ->first()->parts;
                    $data->materialname = Material::where('id', 1)
                        ->first()->material;
                }
                else
                {
                    $data->productname = Part::where('id', $data->product)
                        ->first()->parts;
                    $data->materialname = Material::where('id', $data->mat_id)
                        ->first()->material;
                }
            }
            return $data;
        });


        $tot = $orderdetails->toArray();
        $totalprice = array_sum(array_column($tot, 'price'));
            /***************************/
        $order[$key]->o = Orederstaus::where('order_id', $value->order_id)->first();
        $order[$key]->o1 = $totalprice;
          }
        }
          /******End order Status*******/   
//  Info Team Member
             


          $data= Student::where('id',$studentid)->get()->map(function($input)use($studentid){
              $teamid = StudentTeam_Role::where('studentid',$studentid)->first()->teamId??"NO";
           
              $input['teamname']=Team_Store::where('id',$teamid)->first()->team_Name??"NO";
            

              $input['teamid']=Team_Store::where('id',$teamid)->first()->id??"NO";
              $input['classdata']=db::table('class')->select('id','class')->get()->toArray();
              $input['tshirt']=db::table('tshirt')->select('id','tsize')->get()->toArray();
                return $input;
                })->toArray();
         /*Design Code*/
          $appieddesign = Stcarbodypart::where('studentidC',$studentid)->where('schoolidC',$schoolid)->count();
         
          $designaproved = Stcarbodypart::where('studentidC',$studentid)->where('schoolidC',$schoolid)->where('status',1)->count();
          $designpending = Stcarbodypart::where('studentidC',$studentid)->where('schoolidC',$schoolid)->where('status',0)->count();
          $designreject = Stcarbodypart::where('studentidC',$studentid)->where('schoolidC',$schoolid)->where('status',2)->count();
          /*End Design Code*/
          $oredersuccess = Payment::where('student_id',$studentid)->where('transaction_id','!=','')->count();

          // $appiedcompetition = Schoolteamcomp::where('tmpid', $data[0]['teamid'])->count();

            $Academicyear = Login_Academic_Year::where('school',$schoolid)->first()->academicyear??'N/A';
              $schoolTeamComp = Schoolteamcomp::
                        where('school_id', $schoolid)
                        ->where('tmpid',$data[0]['teamid'])
                           ->groupBy('schoolteamcomp.cmpid')
                            ->get(); 
// dd($schoolTeamComp);

  // $competition = [];  
    $appiedcompetition = 0;               
  foreach ($schoolTeamComp as $compid) 
  {
      $checkyear = Competitionstore::where('id',$compid->cmpid)
                       ->where('academicyear',$Academicyear)
                       ->first()->academicyear??'N/A';  
      if($Academicyear==$checkyear)
      {
          $appiedcompetition = $appiedcompetition+1;
      }                                               
  }                                      
                       
                          $collageTeamId = StudentTeam_Role::
                                        // where('schoolid',$schoolid)
                                        where('studentid',$studentid)
                                        // ->where('status',1)
                                        ->first()->teamId??'N/A';
                 if($collageTeamId!='N/A')
                 {
                     $status = StudentTeam_Role::where('studentid',$studentid)->first()->status;
                     if($status==2)
                     {
                     $collageTeamId = 'N/A';
                     $collageTeamuserstatus = 2;
                    }
                     else
                     {
                     $collageTeamId = Team_Store::where('id',$collageTeamId)->first()??'N/A';
                     $collageTeamuserstatus = $status;
                     }

                 }
                 else
                 {
                   $collageTeamId = 'N/A';
                   $collageTeamuserstatus =2;

                 }    
                 $team = StudentTeam_Role::where('schoolid',$schoolid)
                        ->where('studentid',$studentid)
                        ->first()->teamId??'No'; 


                
               $viewcompetition = Schoolteamcomp::where('tmpid',$team)->take(1)->get();
               foreach ($viewcompetition as $key => $value) {
                 $viewcompetition[$key]->Competition_name = Competitionstore::
                                                         where('id',$value->cmpid)
                                                         ->first()->Competition_name;
                $viewcompetition[$key]->Sdescription = Competitionstore::
                                                         where('id',$value->cmpid)
                                                         ->first()->Sdescription??'No';
                $viewcompetition[$key]->Ldescription = Competitionstore::
                                                         where('id',$value->cmpid)
                                                         ->first()->Ldescription??'No'; 
                $viewcompetition[$key]->Ragistration_Date = Competitionstore::
                                                         where('id',$value->cmpid)
                                                         ->first()->Ragistration_Date??'No';
                $viewcompetition[$key]->Start_Date = Competitionstore::
                                                         where('id',$value->cmpid)
                                                         ->first()->Start_Date??'No';                                        
               }
               
                  // $collageTeamuserstatus = 0;
                  // dd($collageTeamuserstatus);
                 // s1testing
                 // studentview
               // StudentDashboard
                    // dd($manufacture);
					
                return view('admin.Student.StudentDashboard', compact('teamstoreCreateId', 'studenteamroleId', 'compId', 'assigndata', 'systemdate', 'pname', 'studentid', 'schoolid', 'planid', 'studentName', 'creatorteamid', 'data','appieddesign','oredersuccess','appiedcompetition','info','manufacture','email','collageTeamId','collageTeamuserstatus','designaproved','designpending','designreject','viewcompetition','order'));
      
       }
     }
   }

// Start Mobile Login Process....
    // UserName And Password Change 
    public function forgotUserName()
    {
        return view('admin.Student.ForgotUserName');
    }
    public function forgotPassWord()
    {

        return view('admin.Student.ForgotPassWord');
    }
    // End Username And Password 


    // Check Username And Password BY Post Method


    public function forgotUserNamePost(Request $req)
    {
       $req->validate([
            'mobile_no'             => 'required|regex:/[0-9]{10}/|digits:10',
            'dob'                   => 'required',
        ]);
        $var = $req->dob;
        $date = str_replace('-', '/', $var);
        $date1 =date('d/m/Y', strtotime($date));

           try{
			  
           $check =  User::where('mobile_no',$req->mobile_no)->where('dob',$date1)->get()->count();
		   
          if($check)
          {
			             $check =  User::where('mobile_no',$req->mobile_no)->where('dob',$date1)->orderby('id','desc')->first();
						 
						 $dd=explode(' ',$check->name);
						 
			  if(strtolower($dd[0])!=strtolower($req->firstname))
		   {
			   return redirect()->back()->with('error','First Name is Incorrect'); 
		   }
            $name = User::where('mobile_no',$req->mobile_no)->where('dob',$date1)->first()->email;

              $otpnumber = mt_rand(100000, 999999);
              $currenttime = time();
              $expirytime = time()+ 2*60;
              $mobileNumber = $req->mobile_no;

              // OTP Table Insert Data for Username ...
              $otp = new Otp;
              // $otp->username = $otp->username;
              $otp->otp = $otpnumber;
              $otp->mobile_no = $mobileNumber;
              $otp->currenttime = $currenttime;
              $otp->expirytime = $expirytime;
              $otp->dob = $date1;
              $otp->save();
              //End  OTP Table Insert Data for Username ...
             
             $mb=$req->mobile_no;
             $apikey = "YXPskaQxMk6oxtQcQbPo2Q";
             $apisender = "TOSAPP";
             $msg = $otpnumber." is Your OTP for Forgot Username.";
             $num ='91'.$mb;    // MULTIPLE NUMBER VARIABLE PUT HERE...!                 
             $ms = rawurlencode($msg);   //This for encode your message content                     
            $url = 'https://www.smsgatewayhub.com/api/mt/SendSMS?APIKey='.$apikey.'&senderid='.$apisender.'&channel=2&DCS=0&flashsms=0&number='.$num.'&text='.$ms.'&route=1';
                               
           //echo $url;
           $ch=curl_init($url);
           curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
           curl_setopt($ch,CURLOPT_POST,1);
           curl_setopt($ch,CURLOPT_POSTFIELDS,"");
           curl_setopt($ch, CURLOPT_RETURNTRANSFER,2);
           $data = curl_exec($ch);
           echo '<br/><br/>';


           Session::put('mobile_no', $req->mobile_no);
           Session::put('dob', $req->dob);
           Session::put('username', $name);

           $trimmobile = substr($mb,-4);
         return redirect('verify-OTP-Username')->with('success','OTP is sent Your Mobile Number ending with ...'.$trimmobile);
          }
          else
           {
            return redirect()->back()->with('error','User Not Found.');
           }
        }catch(\Exception $e)
        {
          return redirect()->back()->with('error',$e->getMessage());
        }

    }
    /*Verify Username Sent Otp */
  public function   verify_OTP_Username_Post(Request $req)
  {

        $var = $req->dob;
        $date = str_replace('-', '/', $var);
        $date1 =date('d/m/Y', strtotime($date));

      try{
            $checkotp = Otp::where('mobile_no',$req->mobile_no)
                        ->where('dob',$date1)
                        ->where('otp',$req->otp)->first();
          if($checkotp!=null)
          {
            $currenttime = time();
            $expirytime = $checkotp->expirytime;
              if($currenttime<=$expirytime)
              {
             $name = User::where('mobile_no',$req->mobile_no)->where('dob',$date1)->first()->username;
             $mb=$req->mobile_no;
             $apikey = "YXPskaQxMk6oxtQcQbPo2Q";
             $apisender = "TOSAPP";
             $msg = $name." is Your Username";
             $num ='91'.$mb;    // MULTIPLE NUMBER VARIABLE PUT HERE...!                 
             $ms = rawurlencode($msg);   //This for encode your message content                     
            $url = 'https://www.smsgatewayhub.com/api/mt/SendSMS?APIKey='.$apikey.'&senderid='.$apisender.'&channel=2&DCS=0&flashsms=0&number='.$num.'&text='.$ms.'&route=1';
                               
           //echo $url;
           $ch=curl_init($url);
           curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
           curl_setopt($ch,CURLOPT_POST,1);
           curl_setopt($ch,CURLOPT_POSTFIELDS,"");
           curl_setopt($ch, CURLOPT_RETURNTRANSFER,2);
           $data = curl_exec($ch);
           echo '<br/><br/>';

           Session::put('mobile_no', $req->mobile_no);
           Session::put('dob', $req->dob);
           Session::put('username', $name);

           $trimmobile = substr($mb,-4);
         return redirect('Username-success-page')->with('success','Username is sent Your Mobile Number ending with ...'.$trimmobile);
           }
           else
           {
             return redirect()->back()->with('error','Your OTP has been Expired...');
           }

          }
          else
           {
            return redirect()->back()->with('error','OTP NOT Match...');
           }
        }catch(\Exception $e)
        {
          return redirect()->back()->with('error',$e->getMessage());
        }
  }

  public function Username_success_page()
  {
    return view('admin.Student.Username_success_page');
  }

    /*End Verify Username Sent Otp */

     public function forgotPassWordPost(Request $req)
    {
             $req->validate([
            'mobile_no'             => 'required',
            'username'                   => 'required',
        ]);
      
           try{
           $check=  User::where('mobile_no',$req->mobile_no)->where('username',$req->username)->get()->count();
		  
          if($check)
          {
            $name = User::where('mobile_no',$req->mobile_no)->where('username',$req->username)->first()->username;
              $otpnumber = mt_rand(100000, 999999);
              $currenttime = time();
              $expirytime = time()+ 2*60;
              $mobileNumber = $req->mobile_no;

              // OTP Table Insert Data for Username ...
              $otp = new Otp;
              $otp->username = $req->username;
              $otp->otp = $otpnumber;
              $otp->mobile_no = $mobileNumber;
              $otp->currenttime = $currenttime;
              $otp->expirytime = $expirytime;
              // $otp->dob = $date1;
              $otp->save();

             $mb=$req->mobile_no;
             $apikey = "YXPskaQxMk6oxtQcQbPo2Q";
             $apisender = "TOSAPP";
             $msg = $otpnumber." is Your OTP for Forgot Username.";
             $num ='91'.$mb;    // MULTIPLE NUMBER VARIABLE PUT HERE...!                 
             $ms = rawurlencode($msg);   //This for encode your message content                     
            $url = 'https://www.smsgatewayhub.com/api/mt/SendSMS?APIKey='.$apikey.'&senderid='.$apisender.'&channel=2&DCS=0&flashsms=0&number='.$num.'&text='.$ms.'&route=1';
                               
           //echo $url;
           $ch=curl_init($url);
           curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
           curl_setopt($ch,CURLOPT_POST,1);
           curl_setopt($ch,CURLOPT_POSTFIELDS,"");
           curl_setopt($ch, CURLOPT_RETURNTRANSFER,2);
           $data = curl_exec($ch);
           echo '<br/><br/>';
      
           Session::put('mobile_no', $req->mobile_no);
           Session::put('dob', $req->dob);
           Session::put('username', $name);
           
           $trimmobile = substr($mb,-4);
         return redirect('verify-OTP-Password')->with('success',' OTP is sent Your Mobile Number ending with ...'.$trimmobile);
        
          }
          else
           {
            return redirect()->back()->with('error','User Not Found.');
           }
        }catch(\Exception $e)
        {
          return redirect()->back()->with('error',$e->getMessage());
        }

    }

     public function   verify_OTP_Password_Post(Request $req)
  {
      try{
            $checkotp = Otp::where('mobile_no',$req->mobile_no)
                        ->where('username',$req->username)
                        ->where('otp',$req->otp)->first();
          if($checkotp!=null)
          {
            $currenttime = time();
            $expirytime = $checkotp->expirytime;
              if($currenttime<=$expirytime)
              {
             $name = User::where('mobile_no',$req->mobile_no)->where('username',$req->username)->first()->username;
           //   $mb=$req->mobile_no;
           //   $apikey = "YXPskaQxMk6oxtQcQbPo2Q";
           //   $apisender = "TOSAPP";
           //   $msg = $name." is Your Username";
           //   $num ='91'.$mb;    // MULTIPLE NUMBER VARIABLE PUT HERE...!                 
           //   $ms = rawurlencode($msg);   //This for encode your message content                     
           //  $url = 'https://www.smsgatewayhub.com/api/mt/SendSMS?APIKey='.$apikey.'&senderid='.$apisender.'&channel=2&DCS=0&flashsms=0&number='.$num.'&text='.$ms.'&route=1';
                               
           // //echo $url;
           // $ch=curl_init($url);
           // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
           // curl_setopt($ch,CURLOPT_POST,1);
           // curl_setopt($ch,CURLOPT_POSTFIELDS,"");
           // curl_setopt($ch, CURLOPT_RETURNTRANSFER,2);
           // $data = curl_exec($ch);
           // echo '<br/><br/>';

           Session::put('mobile_no', $req->mobile_no);
           // Session::put('dob', $req->dob);
           Session::put('username', $name);

           // $trimmobile = substr($mb,-4);
         return redirect('set-Password')->with('success','Thank you for verifying. Your password has been reset. Login with your Username and new password');
           }
           else
           {
             return redirect()->back()->with('error','Your OTP has been Expired...');
           }

          }
          else
           {
            return redirect()->back()->with('error','OTP NOT Match...');
           }
        }catch(\Exception $e)
        {
          return redirect()->back()->with('error',$e->getMessage());
        }
  }

public function set_Password()
{
       $mobile_no = Crypt::encrypt(Session::get('mobile_no'));
       $dob = Session::get('dob');
       $username = Crypt::encrypt(Session::get('username'));

  return view('admin.Student.setPassword',compact('mobile_no','username'));
}
public function reset_Password(Request $req)
{
    $req->validate([
            'Password'   => 'required_with:rePassword|same:rePassword',
            'rePassword' => 'required'
        ],[
        'Password.required'    =>'Please Enter the password.',   
        'rePassword.required'  =>'Repassword should be same.',
         ]);
        // $p1 =Crypt::encrypt($req->mobile_no);
        $username =Crypt::decrypt($req->username);
        $mobile_no =Crypt::decrypt($req->mobile_no);


      try
        {
          $status= User::where('username',$username)
                  ->where('mobile_no',$mobile_no)
                  ->update(['password'=>Hash::make($req->Password)]);
          if($status)
          { 
            Session::put('username', $username);
           return redirect('Password-success-page');
          }
          else{
            return redirect()->back()->with('erorr','Password is not reset.'); 
          }
        }catch(\Exception $e){
         return redirect()->back()->with('erorr','Something is Wrong.');
       }


}
public function Password_success_page()
{
  return view('admin.Student.Password_success_page');
}

    public function verify_OTP_Username()
    {
       $mobile_no = Session::get('mobile_no');
       $dob = Session::get('dob');
       $username = Session::get('username');

       return view('admin.Student.verify_OTP_Username',compact('mobile_no','dob'));
       dd($mobile_no);

    }

      public function verify_OTP_Password()
    {
       $mobile_no = Session::get('mobile_no');
       // $dob = Session::get('dob');
       $username = Session::get('username');
       return view('admin.Student.verify_OTP_PassWord',compact('mobile_no','username'));
    }
	
	  public function verify_OTP_Password_Postregister(Request $req)
    {
		
		$otp= Otp::where('mobile_no',$req->mobile_no)->orderby('id','desc')->first();
		 if($otp!=null){
			 
			 if($otp->otp==$req->otp){
				 return view('admin.Student.genreatedusername');
			 }
			 else
			 {
				 	 $req->session()->flash('error',"Wrong Otp");
				return view('admin.Student.Mobile_Login1'); 
			 }
			 
		 }
       $mobile_no = Session::get('mobile_no');
       // $dob = Session::get('dob');
       $username = Session::get('username');
       return view('admin.Student.verify_OTP_PassWord',compact('mobile_no','username'));
    }
	public function generateuser(Request $req){
		$student=Student::where('dob',date('d/m/Y',strtotime($req->session()->all()['dob'])))->where('mobileno',$req->session()->all()['mobile_no'])->first();
		
		$user=User::where('email',$req->username)->orwhere('username',$req->username)->count();
		if($user==0)
		{       $user           =           new User();
            $user->name     =           $student->name;
            $user->email    =           $student->studentemail;
            $user->role     =           5;
            $user->mobile_no   =        $student->mobileno;
            $user->dob      =           $student->dob;
            $user->username =            $req->username;
            $user->password =           bcrypt($req->password);
            $user->save();
            Student::where('dob',date('d/m/Y',strtotime($req->session()->all()['dob'])))->where('mobileno',$req->session()->all()['mobile_no'])->update(['username'=>$req->username]);

			$req->session()->flash('success',"Thank you for verifying. Your username has been sent to your mobile number ".$student->mobileno);
			 $apikey = "YXPskaQxMk6oxtQcQbPo2Q";
             $apisender = "TOSAPP";
             $msg = "Your username is ". $req->username;
             $num ='91'.$student->mobileno;    // MULTIPLE NUMBER VARIABLE PUT HERE...!                 
             $ms = rawurlencode($msg);   //This for encode your message content                     
            $url = 'https://www.smsgatewayhub.com/api/mt/SendSMS?APIKey='.$apikey.'&senderid='.$apisender.'&channel=2&DCS=0&flashsms=0&number='.$num.'&text='.$ms.'&route=1';
                               
           //echo $url;
           $ch=curl_init($url);
           curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
           curl_setopt($ch,CURLOPT_POST,1);
           curl_setopt($ch,CURLOPT_POSTFIELDS,"");
           curl_setopt($ch, CURLOPT_RETURNTRANSFER,2);
           $data = curl_exec($ch);
			 return redirect('student-login');
			
		}
		 else
		 {
			
			 $req->session()->flash('error',"Username already exist");
			  return view('admin.Student.genreatedusername');
			 
		 }
		 
		
	}
    //End Check Username And Password BY Post Method
  // End Mobile Login Check Process
  

}