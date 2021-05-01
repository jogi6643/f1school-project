<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;
use App\Model\Student;
use App\School;
use App\Studentmaster;
use App\Studentinfo;
use Mail;
use Alert;
use App\User;
use Auth;
use Hash;
use Maatwebsite\Excel\Facades\Excel;
use App\Model\StudentModel\StudentTeam_Role;
use App\Model\StudentModel\Team_Store;
use App\Model\Manufacture\Stcarbodypart;
use App\Model\Plan;
use App\Model\Part;
use App\Model\Material;
use App\Model\Partplan;
use App\Model\Cartdetail;
use App\Model\Payment;
use App\Model\Assignpriceinschool;
use App\Model\Trainer;
use Session;
use App\Otp;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($schoolid,Request $req)
    {
      
    
          if(Auth::user()->role==1)
            {
                
            }
            else
            {
             
              if(($req->session()->all()['data'][18]??0)!=1)
                {
                    $req->session()->flash('status','You do not have right to access this module');
                    
                    return redirect('/');
                }        
            }
          $schoolid1    =    base64_decode($schoolid);
          $scoolname    =    DB::table('schools')->select('school_name')->where('id',$schoolid1)->first();
          $tshirt       =    DB::table('tshirt')->get();
          $class        =    DB::table('class')->get();
          $schoolid1=base64_decode($schoolid);
          return view('admin.Student.createstudentdetails',compact('schoolid1','scoolname','tshirt','class'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
//     public function store(Request $request)
//     {
       

// // dd($request->all());
//           $request->validate(
//             [
//             // 'name'=>'required|regex:/^[a-zA-Z]+$/u|max:255',
//               'name'      =>   ['required','regex:/^([a-zA-Z0-9]+|[a-zA-Z0-9]+\s{1}[a-zA-Z0-9]{1,}|[a-zA-Z0-9]+\s{1}[a-zA-Z0-9]{3,}\s{1}[a-zA-Z0-9]{1,})$/i'],
//             'class'       =>   'required',
//             // 'class'=>'required',
//            // 'section'     =>   'regex:/^[a-zA-Z]+$/u',
//             'studentemail'=>   'required|unique:students',

//             'email'=>'unique:users',
//             'mobileno'    =>   'numeric',
//             // 'tsize'=>'required',
//             'school_id'   =>   'required',
//             'status'      =>   'required',
            
//               ],['studentname.required'  =>  'The Student Name field is required'
//               // ,'sutudentmobile.numeric'=>'The Student Phone field  must be a number.'
//                ,'email.unique'=>'You can use Email Id Please provide alternate Id.'
//             ]
//               );
              
//             $data           =           $request->except('_token');
//             $st             =           Studentinfo::insert($data);
//             $st             =           Studentinfo::orderby('id','desc')->first();

//             $user           =           new User();
//             $user->name     =           $request->name;
//             $user->email    =           $request->studentemail;
//             $user->role     =           5;
//             $user->mobile_no   =           $request->mobileno;
//             $user->dob      =           $request->dob;
//             $user->username =           'Student_'.$st->id;
//             $user->password =           bcrypt(strtolower("racer").$st->id);
//             $user->save();

    
//         if($st)
//             return redirect('students/'.base64_encode($request->school_id))->with('success','Record Saved.');
   
        
//     }

        public function store(Request $request)
    {
       

// dd($request->all());
          $request->validate(
            [
            // 'name'=>'required|regex:/^[a-zA-Z]+$/u|max:255',
              'name'      =>   ['required','regex:/^([a-zA-Z0-9]+|[a-zA-Z0-9]+\s{1}[a-zA-Z0-9]{1,}|[a-zA-Z0-9]+\s{1}[a-zA-Z0-9]{3,}\s{1}[a-zA-Z0-9]{1,})$/i'],
            'class'       =>   'required',
            // 'class'=>'required',
           // 'section'     =>   'regex:/^[a-zA-Z]+$/u',
               'dob'=>'required',
          
            'mobileno'    =>   'required|regex:/[0-9]{10}/|digits:10',
            // 'tsize'=>'required',
            'school_id'   =>   'required',
            'status'      =>   'required',
            
              ],['studentname.required'  =>  'The Student Name field is required'
              // ,'sutudentmobile.numeric'=>'The Student Phone field  must be a number.'
               ,'email.unique'=>'You can use Email Id Please provide alternate Id.'
            ]
              );
              
            $studentcount =  Studentinfo::where('mobileno',$request->mobileno)->where('dob',$request->dob)->count();
            $usercount = User::where('mobile_no',$request->mobileno)->where('dob',$request->dob)
                         ->where('role',5)->count();
						 
           if($studentcount==0&&$usercount==0)
           {
                $data           =    $request->except('_token');
			 
						 if($data['studentemail']==null){
							
							 $data['studentemail']="tosnewlogin@gmail.com";
							
						 }
						 
						
            $st             =           Studentinfo::insert($data);
            $st             =           Studentinfo::orderby('id','desc')->first();
             
          
             return redirect('students/'.base64_encode($request->school_id))->with('success','Record Saved.');
           }
           else
           {
           return redirect('create/'.base64_encode($request->school_id))->with('danger','already exists!.');
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
    public function show($id)
    {
    
        
        // $school=School::find(base64_decode($id))->students;
           $school = School::find(base64_decode($id))->students->map(function($input){
            $teamid = StudentTeam_Role::where('studentid',$input['id'])
                      ->select('teamId')->first();
            if(!empty($teamid))
            {
              $input['teamname'] = Team_Store::where('id',$teamid->teamId)
                                 ->select('team_Name')->first()->team_Name;
            }
            else
            {
              $input['teamname'] = "No Team";
            }
            return $input;
        });

        // dd($school);
        return view('admin.Student.liststudent',compact('school','id'));
    }

public function studenteditbyadd($ssid,Request $req)
{

   if(Auth::user()->role==1)
            {
                
            }
            else
            {
             
              if(($req->session()->all()['data'][18]??0)!=1)
                {
                    $req->session()->flash('status','You do not have right to access this module');
                    
                    return redirect('/');
                }        
            }
  // $email=Auth::user()->email;
  // $trainerid=DB::table('trainers')->where('email',$email)->first()->id;
  // $trainer=DB::table('trainers')->where('email',$email)->first()->name;
    $ids             =    explode("_",base64_decode($ssid));
    $schoolid        =    base64_decode($ids[0]);
    $studentid       =    $ids[1];
    $student         =    Studentinfo::where('id',$studentid)->where('school_id',$schoolid)->first();
    $tshirt          =    DB::table('tshirt')->get();
    $class           =    DB::table('class')->get();

    
     return view('admin.Student.Studentedit',compact('student','tshirt','class'));
    // return view('Trainer.Student_edT',compact('student','trainer','tshirt','class'));

}
public function editbyadd(Request $request)
{
          $request->validate(
            [
            'name'=>'required|regex:/^[a-zA-Z0-9 ]*$/',
       
            'class'       =>   'required',
            'dob'=>'required',
           // 'section'     =>   'regex:/^[a-zA-Z]+$/u',
            // 'studentemail'=>   'required|unique:students|unique:users',
            // 'mobileno'    =>   'required|regex:/(01)[0-9]{9}/',
            // 'tsize'=>'required',
            'school_id'   =>   'required',
            'status'      =>   'required',
            
              ],['studentname.required'  =>  'The Student Name field is required'
              ,'sutudentmobile.numeric'=>'The Student Phone field  must be a number.'
               
            ]
              );


           
            $up=DB::table('students')
            ->where('id', $request->student_id)->where('school_id',$request->school_id)
            ->update(['name' => $request->name,'class'=>$request->class,'section'=>$request->section,'studentemail'=> $request->studentemail,'mobileno'=>$request->mobileno,'address'=>$request->address,'tsize'=>$request->tsize,'guardianemail1'=>$request->guardianemail1,'guardianname1'=>$request->guardianname1,'guardianphone1'=>$request->guardianphone1,'guardianname2'=>$request->guardianname2,'guardianemail2'=>$request->guardianemail2,'guardianphone2'=>$request->guardianphone2,'school_id'=>$request->school_id,'status'=>$request->status]);

           return redirect('students'.'/'.base64_encode($request->school_id))->with('success','Updated  Successfully.');

 
}

  public function viewstudentinfoadmin($sstid,Request $req)
       {
         
         if(Auth::user()->role==1)
            {
                
            }
            else
            {
             
             //  if(($req->session()->all()['data'][18]??0)!=1)
                // {
                //  $req->session()->flash('status','You do not have right to access this module');
                    
                //  return redirect('/');
                // }         
            }
         $ids=explode("_",base64_decode($sstid));
         $schoolid=$ids[0];
         $studentid=$ids[1];
          $k=Studentinfo::find($studentid);
          
         return view('admin.Student.studentv',compact('k'));
       }

    /**

     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    // DOWNLOAD STUDENT EXCEL 
    public function  downloadstudentupload(Request $req)
    {
      $school=School::where('status',1)->get();
        foreach($school as $key=>$schools)
        {
                $arr[$key]["School Ids"]             =        "";
                $arr[$key]["Student Name"]           =        "";
                $arr[$key]["Student Class"]          =        "";        
                $arr[$key]["Student Section"]        =        "";
                $arr[$key]["DOB"]                    =        "";
                $arr[$key]["Mobile No"]              =        "";
                $arr[$key]["Address"]                =        "";
                $arr[$key]["T-Shirt Size"]           =        "";
                $arr[$key]["Guardian Name 1"]        =        "";
                $arr[$key]["Guardian Email 1"]       =        "";
                $arr[$key]["Guardian Phone 1"]       =        "";
                $arr[$key]["Guardian Name 2"]        =        "";
                $arr[$key]["Guardian Email 2"]       =        "";
                $arr[$key]["Guardian Phone 2"]       =        "";
                $arr[$key]["School_Id"]              =        $schools->id;
                $arr[$key]["School_Name"]            =        $schools->school_name;
            
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
// ***************** Upload Student ****************************
    public function uploadstudent(Request $req)
    {
        $req->validate([
            'files' => 'required'
        ]);

   
        $path = $req->file('files')->getRealPath();
        $data = Excel::load($path)->get();

// dd($data);
        $error=[];

     // Validation for Xecel File Upload in student Table 
         foreach ($data as $key=>$datas) {
			        $datas->dob = date('d/m/Y',strtotime($datas->dob));
           
               $count_student=Studentinfo::where('mobileno',$datas->mobile_no)->where('dob',$datas->dob)->first();
             
			   if($count_student!=null)
				   
             {
                    $line=$key+2;
                 $error[]="Student with same mobileno and dob  already exist exist at Line no {$line}";
             }
 // validation on Name 
             if(empty($datas->student_name))
             {
                    $line=$key+2;
                 $error[]="Student Name two does not exist at Line no {$line}";
             }

             if(!preg_match('/^[a-z0-9 .\-]+$/i', $datas->student_name))
             {
                     $line=$key+2;
                 $error[]="Student Name can not use Special character at Line no {$line}";

             }
             // if (!ctype_alpha(str_replace(' ', '', $datas->student_name)))
             // {
             //    $line=$key+2;
             //     $error[]="Student Name can not use Special character at Line no {$line}";
             // } 
// end Validation on Name

// Email Validation on Email 
            
          
     
        
           


              

// End Email validation
             if(empty($datas->student_class))
              {
                  $line=$key+2;
                 $error[]="Student  Class  at Line no {$line} does not exist";
              }

              if(!empty($datas->student_section))
              {
           
            // if (!ctype_alpha(str_replace(' ', '', $datas->student_section)))
            //  {
            //     $line=$key+2;
            //      $error[]="Student Section can not use Special character at Line no {$line}";
            //  } 



              } 

              if(!empty($datas->address))
              {

             //  if (!ctype_alpha(str_replace(' ', '', $datas->address)))
             // {
             //    $line=$key+2;
             //     $error[]="Student Address can not use Special character at Line no {$line}";
             // }

              }

              // Mobile Validation 
             if(empty($datas->mobile_no))
              {
                  $line=$key+2;
                 $error[]="Mobile No  at Line no {$line} does not exist";

              
              }
              if(!is_numeric($datas->mobile_no))
              {
            
                 $line=$key+2;
                 $error[]="Mobile Number Should be numeric formate   at Line no {$line}";
                    if(strlen($datas->mobile_no)<10)
                    {
                       $line=$key+2;
                       $error[]="Mobile No Should be 10 Digit at Line no {$line}";
                    }
                 if(strlen($datas->mobile_no)>10){
                      $line=$key+2;
                      $error[]="Mobile No Should be 10 Digit at Line no {$line}";
                     }
              }
            if(strlen($datas->mobile_no)<10)
                    {
                       $line=$key+2;
                       $error[]="Mobile No Should be less then 10 Digit at Line no {$line}";
                    }
                 if(strlen($datas->mobile_no)>10){
                      $line=$key+2;
                      $error[]="Mobile No Should be greater then 10 Digit at Line no {$line}";
                }
               //End  Mobile Validation 


              // if(empty($datas->dob))
              // {
              //   $line=$key+2;
              //    $error[]="DOB  at Line no {$line} does not exist";
              // }

              // Start School Id Validation
              if(empty($datas->school_id))
              {
                 $line=$key+2;
                 $error[]="School Id   at Line no {$line} does not exist";
              }
                if(!is_numeric($datas->school_id))
              {
                 $line=$key+2;
                  $error[]="Student Id Should be in Numerical Format at Line no {$line}";
                 
              }
            $count=School::where('id',$datas->school_id)->count();
             if($count==0)
             {
                 $line=$key+2;
                  $error[]="This School Id not matach in School table  at Line no {$line}";
             }
              // End School Id Validation
             



// validation of guardian_name_1

            if(!empty($datas->guardian_name_1))
             {
              

             // if (!ctype_alpha(str_replace(' ', '',$datas->guardian_name_1)))
             // {
             //    $line=$key+2;
             //     $error[]="guardian_name_1 can not use Special character at Line no {$line}";
             // } 

           if(!preg_match('/^[a-z0-9 .\-]+$/i', $datas->guardian_name_1))
             {
                 $line=$key+2;
                 $error[]="guardian_name_1 Name can not use Special character at Line no {$line}";

              }

             }

          

// End validation of guardian_name_1



             // validation of guardian_name_2

            if(!empty($datas->guardian_name_2))
             {
                 

             // if (!ctype_alpha(str_replace(' ', '', $datas->guardian_name_2)))
             // { 
             //    $line=$key+2;
             //     $error[]="guardian_name_2 can not use Special character at Line no {$line}";
             // } 
             
             if(!preg_match('/^[a-z0-9 .\-]+$/i', $datas->guardian_name_1))
             {
                     $line=$key+2;
                 $error[]="guardian_name_2 Name can not use Special character at Line no {$line}";

              }

             }


// End validation of guardian_name_2


               // Mobile guardian_phone_1 

             // if(!empty($datas->guardian_phone_1))
             //  {
                

             //   if(!is_numeric($datas->guardian_phone_1))
             //  {
            
             //     $line=$key+2;
             //     $error[]="guardian1 Mobile Number Should be numericals format   at Line no {$line}";
             //        if(strlen($datas->guardian_phone_1)<10)
             //        {
             //           $line=$key+2;
             //           $error[]="guardian1 Mobile No Should be 10 Digit at Line no {$line}";
             //        }
             //     if(strlen($datas->guardian_phone_1)>10){
             //          $line=$key+2;
             //          $error[]="guardian1 Mobile No Should be 10 Digit at Line no {$line}";
             //         }
             //  }

              
             //  }

          
            // if(strlen($datas->guardian_phone_1)<10)
            //         {
            //            $line=$key+2;
            //            $error[]="guardian1 Mobile No Should not be less then 10 Digit at Line no {$line}";
            //         }
            //      if(strlen($datas->guardian_phone_1)>10){
            //           $line=$key+2;
            //           $error[]="guardian1 Mobile No Should not be greater then 10 Digit at Line no {$line}";
            //     }

               //End guardian_phone_1 Mobile Validation 


 // Mobile guardian_phone_2 
             // if(!empty($datas->guardian_phone_2))
             //  {
            
             //  if(!is_numeric($datas->guardian_phone_2))
             //  {
            
                
             //        if(strlen($datas->guardian_phone_2)<10)
             //        {
             //           $line=$key+2;
             //           $error[]="guardian2 Mobile No Should be 10 Digits at Line no {$line}";
             //        }
             //     if(strlen($datas->guardian_phone_1)>10){
             //          $line=$key+2;
             //          $error[]="guardian2 Mobile No Should be 10 Digits at Line no {$line}";
             //         }
             //  }
              
             //  }
            
        
               //End guardian_phone_2 Mobile Validation 

 // Email guardian_email_1 

          // if(!empty($datas->guardian_email_1))
          //     {
                
          //        if((!$this->valid_email($datas->guardian_email_1))){
          //       $line=$key+2;
          //        $error[]="guardian1  Mail is not Valid at Line no {$line}";
          //       }
          //     }
          


              // if(($this->valid_email($datas->guardian_email_1))){
              //   $line=$key+2;
              //    $error[]="guardian1  Mail is not Valid at Line no {$line}";
              //   }

// End guardian_email_1 



                 // Email guardian_email_2 
          // if(!empty($datas->guardian_email_2))
          //     {
               
          //        if((!$this->valid_email($datas->guardian_email_2))){
          //       $line=$key+2;
          //        $error[]="guardian2  Mail is not Valid at Line no {$line}";
          //       }
          //     }
          


              
// End guardian_email_1 



         }

    
         if($error!=array())
         {
      
            
             // return redirect('school')->with('errors',$error);
             $req->session()->flash('errors1',$error);
               
            
              return redirect('school');
         }
         else
         {

      
      // Studentinfo::query()->truncate();
       // User::where('role',5)->delete();

        foreach($data as $datas)
        {
          
            
         
            $count=User::where('role',5)->where('mobile_no',$datas->mobile_no)->where('dob',$datas->dob)->first();
            $count_student=Studentinfo::where('mobileno',$datas->mobile_no)->where('dob',$datas->dob)->first();
            if($count==null)
            {
         
          if($data[$key]->student_name!=null)
            {
				
				 if($datas->student_email==null){
							
							 $datas->student_email="tosnewlogin@gmail.com";
							
						 }
				
							
							
							
						 
         
            $student                     =          new Studentinfo();
            $student->name               =          $datas->student_name;
            $student->studentemail       =          $datas->student_email;  
            $student->dob                =           $datas->dob;
            $student->class              =          $datas->student_class;
            $student->section            =          $datas->student_section;
            $student->mobileno           =          $datas->mobile_no;
            $student->address            =          $datas->address;
            $student->tsize              =          $datas->t_shirt_size;  
            $student->guardianname1      =          $datas->guardian_name_1; 
            $student->guardianemail1     =          $datas->guardian_email_1; 
            $student->guardianphone1     =          $datas->guardian_phone_1; 
            $student->guardianname2      =          $datas->guardian_name_2; 
            $student->guardianemail2     =          $datas->guardian_email_2; 
            $student->guardianphone2     =          $datas->guardian_phone_2;
            $student->school_id          =           $datas->school_id;
            $student->status             =          1; 
            $student->last_login         =          $datas->last_login;
            $student->email_status       =           $datas->email_status;
            $student->save();



          
             }
              
              }
              else
              {
				  if($datas->student_email==null){
							
							 $datas->student_email="tosnewlogin@gmail.com";
							
						 }
             $student                     =          Studentinfo::find($count_student->id);
            $student->name               =          $datas->student_name;
            $student->studentemail       =          $datas->student_email;  
            $student->dob                =          $student->dob;
            $student->class              =          $datas->student_class;
            $student->section            =          $datas->student_section;
            $student->mobileno           =          $student->mobile_no;
            $student->address            =          $datas->address;
            $student->tsize              =          $datas->t_shirt_size;  
            $student->guardianname1      =          $datas->guardian_name_1; 
            $student->guardianemail1     =          $datas->guardian_email_1; 
            $student->guardianphone1     =          $datas->guardian_phone_1; 
            $student->guardianname2      =          $datas->guardian_name_2; 
            $student->guardianemail2     =          $datas->guardian_email_2; 
            $student->guardianphone2     =          $datas->guardian_phone_2;
            $student->school_id          =           $datas->school_id;
            $student->status     =          $datas->status; 
            $student->last_login     =          $datas->last_login;
            $student->email_status          =           $datas->email_status;
            $student->save();


                 //   $user                 =          User::find($count->id);
                 //  $user->name                  =          $datas->student_name;
                 // $user->save();

              }
             
        }

             return redirect('school') ->with('success','Record Save Successfully');
         }

          echo '<pre>';
         print_r($error);
         die;
      
        
        
    }
// ********************  Email Validation *****************

function valid_email($str) {
  return (!preg_match( 
"^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^", $str)) 
        ? FALSE : TRUE; 
}

// ********************  End Email Validation *****************

    public function  downloadstudentbyschool($schoolid)
    {               
        $student=DB::table('students')->where('school_id',base64_decode($schoolid))->get();
        // $student=DB::table('students')->get();

    if(count($student)>0){
        foreach($student as $key=>$student)
        {
        $arr[$key]["id"]                         =        $student->id;
        $arr[$key]["Student Name"]               =        $student->name;
        $arr[$key]["Student Email"]              =        $student->studentemail;
        $arr[$key]["Student Class"]              =        $student->class;
        $arr[$key]["Student Section"]            =        $student->section;
        $arr[$key]["DOB"]                        =        $student->dob;
        $arr[$key]["Mobile No"]                  =        $student->mobileno;
        $arr[$key]["Address"]                    =        $student->address;
        $arr[$key]["Guardian Name 1"]            =        $student->guardianname1;
        $arr[$key]["Guardian Email 1"]           =        $student->guardianemail1;
        $arr[$key]["Guardian Phone 1"]           =        $student->guardianphone1;
        $arr[$key]["Guardian Name 2"]            =        $student->guardianname2;
        $arr[$key]["Guardian Email 2"]           =        $student->guardianemail2;
        $arr[$key]["Guardian Phone 2"]           =        $student->guardianphone2;
        $arr[$key]["School_Id"]                  =        $student->school_id;
        $arr[$key]["status"]                     =        $student->status;
        $arr[$key]["email_status"]               =        $student->email_status;
        $arr[$key]["last_login"]                 =        $student->last_login;
        $arr[$key]["T-Shirt Size"]               =        $student->tsize;
        $arr[$key]["Created_at"]                 =        $student->created_at;
        $arr[$key]["updated_at"]                 =        $student->updated_at;

     
            
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
// *********************Whole school data downloaded from *****************

/*************************School Report Download******************/
    public function  downloadschoolreport()
    {               
        $school=School::all();
        // $student=DB::table('students')->get();

    if(count($school)>0){
     foreach($school as $key=>$school)
        { 
        $arr[$key]["id"]                        =         $school->id;
        $arr[$key]["school_name"]               =         $school->school_name;
        $arr[$key]["type"]                      =         $school->type;
        $arr[$key]["zone"]                      =         $school->zone;
        $arr[$key]["state"]                     =         $school->state;
        $arr[$key]["city"]                      =         $school->city;
        $arr[$key]["address"]                   =         $school->address;
        $arr[$key]["website"]                   =         $school->website;
        $arr[$key]["mobile"]                    =         $school->mobile;
        $arr[$key]["email"]                     =         $school->email;
        $arr[$key]["annual_fees"]               =         $school->annual_fees;
        $arr[$key]["principal_name"]            =         $school->principal_name;
        $arr[$key]["principal_mobile"]          =         $school->principal_mobile;
        $arr[$key]["principal_email"]           =         $school->principal_email;
        $arr[$key]["status"]                    =         $school->status;
        $arr[$key]["checkStatus"]               =         $school->checkStatus;
        $arr[$key]["Created_at"]                =         $school->created_at;
        $arr[$key]["updated_at"]                =         $school->updated_at;    
        }
       
        ob_end_clean(); // this
          ob_start();
         return Excel::create('SchoolReport', function($excel) use ($arr) {
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
// *********************Whole school data downloaded from *****************
/*************************End School Report **********************/ 



  public function  downloadschool()
    {

        // $student=DB::table('students')->where('school_id',base64_decode($schoolid))->get();
        $school=DB::table('schools')->get()->toArray();
        $arr          = ["id","school_name","type","zone","state","city","address","website","mobile","email","annual_fees","principal_name","status","checkStatus"];
     
        
        if(count($school)>0){
        // foreach($school as $key=>$school)
        // { 
        // $arr[$key]["id"]                        =         $school->id;
        // $arr[$key]["school_name"]               =         $school->school_name;
        // $arr[$key]["type"]                      =         $school->type;
        // $arr[$key]["zone"]                      =         $school->zone;
        // $arr[$key]["state"]                     =         $school->state;
        // $arr[$key]["city"]                      =         $school->city;
        // $arr[$key]["address"]                   =         $school->address;
        // $arr[$key]["website"]                   =         $school->website;
        // $arr[$key]["mobile"]                    =         $school->mobile;
        // $arr[$key]["email"]                     =         $school->email;
        // $arr[$key]["annual_fees"]               =         $school->annual_fees;
        // $arr[$key]["principal_name"]            =         $school->principal_name;
        // $arr[$key]["principal_mobile"]          =         $school->principal_mobile;
        // $arr[$key]["principal_email"]           =         $school->principal_email;
        // $arr[$key]["status"]                    =         $school->status;
        // $arr[$key]["checkStatus"]               =         $school->checkStatus;
        // $arr[$key]["Created_at"]                =         $school->created_at;
        // $arr[$key]["updated_at"]                =         $school->updated_at;    
        // }
       
          ob_end_clean(); // this
          ob_start();
         return Excel::create('School Template', function($excel) use ($arr) {
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

//


// downloadschool

// *********************upload School********************************** 
public function uploadschool(Request $req)
{
  $req->validate([
            'files' => 'required'
        ]);
        $path = $req->file('files')->getRealPath();

        $data = Excel::load($path)->get();
         
        $error=[];

        foreach ($data as $key => $datas) {




             if(empty($datas->school_name))
             {
                 $line=$key+2;
                 $error[]="School Name  at Line no {$line} does not exist";
             }

             // if (!ctype_alpha(str_replace(' ', '', $datas->school_name)))
             // {
             //    $line=$key+2;
             //     $error[]="School Name can not use Special character at Line no {$line}";
             // } 
             

            if(!preg_match('/^[a-z0-9 .\-]+$/i', $datas->school_name))
             {
                     $line=$key+2;
                 $error[]="Student Name can not use Special character at Line no {$line}";

             }

             $l1=DB::table('locations')
                         ->where('Zone_id',$datas->zone)
                         ->first();
              

                         $l2=DB::table('locations')
                        
                         ->where('state',$datas->state)
                       
                         ->first();
                         $l3=DB::table('locations')
                        
                         ->where('city',$datas->city)
                         ->first();
                         
             if($l1==null)
             {
             
                 $line=$key+2;
                 $error[]="School Zone  at Line no {$line} does not exist";
             }
          if($l2==null)
             {
             
                 $line=$key+2;
                 $error[]="School State  at Line no {$line} does not exist";
             }
               if($l2==null)
             {
             
                 $line=$key+2;
                 $error[]="School city  at Line no {$line} does not exist";
             }

               if(empty($datas->type))
             {
                 $line=$key+2;
                 $error[]="School Type  at Line no {$line} does not exist";
             }

if(!empty($datas->email))
{
         $count= User::where('email',$datas->email)->where('role','!=',4)->first();
          

          if($count==null)
          {

          }
          else
          {
            if($count->email==$datas->email)
            {
              $line=$key+2;
                 $error[]="{$datas->email} already Exist in database at Line no {$line}";
            }
           
          }
}
else
{
  $line=$key+2;
                 $error[]="Empty Email Id  in database at Line no {$line}";
}


           //$ff=count($datas->email);
           if(!isset($arr[$datas->email]))
{
  $arr[$datas->email]=1;
}
else
{
    $arr[$datas->email]=$arr[$datas->email]+1;
}
         

           $Schoo=School::where('email',$datas->email)->count();

           if($Schoo>1)
           {
               $line=$key+2;
                 $error[]="{$datas->email} already Exist in database at Line no {$line}";
           }
           
          

            if(empty($datas->email))
              {
                  
                //     if(!($this->valid_email($datas->email))){
                // $line=$key+2;
                //  $error[]="School mail is not Valid at Line no {$line}";
                // }
                   $line=$key+2;
                   $error[]="School mail is not Valid at Line no {$line}";                
                // $regex = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/';
                // if(preg_match($regex, $datas->email)) 
                // {
                //    $line=$key+2;
                //    $error[]="School mail is not Valid at Line no {$line}";
                // }                
              }
          
           


                    // Mobile Validation studenteamroleId
             if(!empty($datas->mobile))
              {
               
               if(!is_numeric($datas->mobile))
              {
            
                 $line=$key+2;
                 $error[]="Mobile Number Should be in numericals   at Line no {$line}";
                    if(strlen($datas->mobile)<10)
                    {
                       $line=$key+2;
                       $error[]="Mobile No Should  be 10 Digits at Line no {$line}";
                    }
                 if(strlen($datas->mobile)>10){
                      $line=$key+2;
                      $error[]="Mobile No Should be 10 Digits at Line no {$line}";
                     }
              }

            if(strlen($datas->mobile)<10)
                    {
                       $line=$key+2;
                       $error[]="Mobile No Should be less then 10 Digit at Line no {$line}";
                    }
                 if(strlen($datas->mobile)>10){
                      $line=$key+2;
                      $error[]="Mobile No Should be greater then 10 Digit at Line no {$line}";
                }


              
              }
            //   if(!is_numeric($datas->mobile))
            //   {
            
            //      $line=$key+2;
            //      $error[]="Mobile Number Should be in numericals   at Line no {$line}";
            //         if(strlen($datas->mobile)<10)
            //         {
            //            $line=$key+2;
            //            $error[]="Mobile No Should  be 10 Digits at Line no {$line}";
            //         }
            //      if(strlen($datas->mobile)>10){
            //           $line=$key+2;
            //           $error[]="Mobile No Should be 10 Digits at Line no {$line}";
            //          }
            //   }

            // if(strlen($datas->mobile)<10)
            //         {
            //            $line=$key+2;
            //            $error[]="Mobile No Should be less then 10 Digit at Line no {$line}";
            //         }
            //      if(strlen($datas->mobile)>10){
            //           $line=$key+2;
            //           $error[]="Mobile No Should be greater then 10 Digit at Line no {$line}";
            //     }
// mobile



                           //pricle Mobile Validation

             if(!empty($datas->principal_mobile))
              {
               
                
                    if(strlen($datas->mobile)<10)
                    {
                       $line=$key+2;
                       $error[]="principal_mobile No Should  be 10 Digits at Line no {$line}";
                    }
                 if(strlen($datas->mobile)>10){
                      $line=$key+2;
                      $error[]="principal_mobile  No Should be 10 Digits at Line no {$line}";
                     }
              }

            // if(strlen($datas->mobile)<10)
            //         {
            //            $line=$key+2;
            //            $error[]="principal_mobile No Should be less then 10 Digit at Line no {$line}";
            //         }
            //      if(strlen($datas->mobile)>10){
            //           $line=$key+2;
            //           $error[]="principal_mobile No Should be greater then 10 Digit at Line no {$line}";
            //     }
              
            //   }


            //   if(!is_numeric($datas->principal_mobile))
            //   {
            
            //      $line=$key+2;
            //      $error[]="principal Mobile Number Should be in numericals at Line no {$line}";
            //         if(strlen($datas->principal_mobile)<10)
            //         {
            //            $line=$key+2;
            //            $error[]="principal Mobile No Should  be 10 Digit at Line no {$line}";
            //         }
            //      if(strlen($datas->principal_mobile)>10){
            //           $line=$key+2;
            //           $error[]="principal Mobile No Should be 10 Digit at Line no {$line}";
            //          }
            //   }
            // if(strlen($datas->principal_mobile)<10)
            //         {
            //            $line=$key+2;
            //            $error[]="principal Mobile No Should not be less then 10 Digits at Line no {$line}";
            //         }
            //      if(strlen($datas->principal_mobile)>10){
            //           $line=$key+2;
            //           $error[]="principal Mobile No Should not be greater then 10 Digits at Line no {$line}";
            //     }



              //    if(empty($datas->principal_email))
              // {
                  
              //   //   if(!($this->valid_email($datas->principal_email))){
              //   // $line=$key+2;
              //   //  $error[]="Principal mail is not Valid at Line no {$line}";
              //   // }
              //   // $regex = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/';
              //   // if(preg_match($regex, $datas->email)) 
              //   // {
              //   //    $error[]="School mail is not Valid at Line no {$line}";
              //   // }
              //   $line=$key+2;
              //    $error[]="Principal mail is not Valid at Line no {$line}";                

              // }
          
             
                

            if(!empty($datas->principal_name))
             {
                
                 if (!ctype_alpha(str_replace(' ', '', $datas->principal_name)))
             {
                $line=$key+2;
                 $error[]="principal Name can not use Special character at Line no {$line}";
             } 

             }
            }


foreach ($arr as $key => $value) {
     if($value>1)
     {
         
                 $error[]="Email {$key } repeated  {$value} times";
     }
}


          if($error!=array())
         {
      
            
             // return redirect('school')->with('errors',$error);
             $req->session()->flash('errors1',$error);
               
            
              return redirect('school');
         }
        else
        {
       // School Truncate Table  
      
       // School::query()->truncate();
       // User::where('role',4)->delete();
       // die;

        foreach($data as $datas)
        {


             
         
            // $user                              =      new User();
            // $user->name                        =      $datas->school_name;
            // $user->email                       =      $datas->email;
            // $user->role                        =      4;
            // $user->password                    =      bcrypt($datas->email.$school->id);
            // $user->save();


      $count=User::where('role',4)->where('email',$datas->email)->first();
      $count_school=School::where('email',$datas->email)->first();
            if($count==null && $count_school==null)
            {
         
          
           $school                            =     new School();
            $school->school_name               =     $datas->school_name;
            $school->type                      =     $datas->type;
            $school->zone                      =     $datas->zone;
            $school->state                     =     $datas->state;
            $school->city                      =     $datas->city;
            $school->address                   =     $datas->address;
            $school->website                   =     $datas->website;
            $school->mobile                    =     $datas->mobile;
            $school->email                     =     $datas->email;
            $school->annual_fees               =     $datas->annual_fees;
            $school->principal_name            =     $datas->principal_name;
            $school->principal_mobile          =     $datas->principal_mobile;
            $school->principal_email           =     $datas->principal_email;
            $school->status                    =     1;
            $school->checkstatus               =     $datas->checkstatus;

            $school->save();
         

            $user                        =          new User();
            $user->name                  =          $datas->school_name;
            $user->email                 =          $datas->email;
            $user->role                  =          4;
            $user->password              =          bcrypt(strtolower($datas->email).$school->id);
            $user->save();
             
              
              }
              else
              {
             $school                            =     School::find($count_school->id);
             
            $school->school_name               =     $datas->school_name;
            $school->type                      =     $datas->type;
            $school->zone                      =     $datas->zone;
            $school->state                     =     $datas->state;
            $school->city                      =     $datas->city;
            $school->address                   =     $datas->address;
            $school->website                   =     $datas->website;
            $school->mobile                    =     $datas->mobile;
            $school->email                     =     $datas->email;
            $school->annual_fees               =     $datas->annual_fees;
            $school->principal_name            =     $datas->principal_name;
            $school->principal_mobile          =     $datas->principal_mobile;
            $school->principal_email           =     $datas->principal_email;
            $school->status                    =     $datas->status;
            $school->checkstatus               =     $datas->checkstatus;

            $school->save();
             
                 //   $user                 =          User::find($count->id);
                 //  $user->name                  =          $datas->school_name;
                 // $user->save();

              }
          
         
              
             //End School Truncate
        }
           return redirect('school') ->with('success','Record Save Successfully');
        }

      

}
// End School    



//***************************** DOWNLOAD SCHOOL**************************

 public function  downloadstudentbyschoolwhole()
    {
        // $student=DB::table('students')->where('school_id',base64_decode($schoolid))->get();
      try{       
        $student=Studentinfo::all();

            // ->map(function($input){
            //       $input['school_name']=School::where('id',$input['school_id'])
            //                                     ->first()->school_name;
            //                return $input;
            //                    });
        }catch(\Exception $e)
        {
          return redirect()->back()->with('error','Something is wrong');
        }
     // dd($student);


    if(count($student)>0){
        foreach($student as $key=>$student)
        {
        $arr[$key]["id"]                   =           $student->id;
        $arr[$key]["Student Name"]         =           $student->name;
        $arr[$key]["Student Email"]        =           $student->studentemail;
        $arr[$key]["Student Class"]        =           $student->class;
        $arr[$key]["Student Section"]      =           $student->section;
        $arr[$key]["DOB"]                  =           $student->dob;
        $arr[$key]["Mobile No"]            =           $student->mobileno;
        $arr[$key]["Address"]              =           $student->address;
        $arr[$key]["Guardian Name 1"]      =           $student->guardianname1;
        $arr[$key]["Guardian Email 1"]     =           $student->guardianemail1;
        $arr[$key]["Guardian Phone 1"]     =           $student->guardianphone1;
        $arr[$key]["Guardian Name 2"]      =           $student->guardianname2;
        $arr[$key]["Guardian Email 2"]     =           $student->guardianemail2;
        $arr[$key]["Guardian Phone 2"]     =           $student->guardianphone2;
        $arr[$key]["School_Id"]            =           $student->school_id;
        $arr[$key]["school_name"]          =           $student->school_name;
        $arr[$key]["status"]               =           $student->status;
        $arr[$key]["email_status"]         =           $student->email_status;
        $arr[$key]["last_login"]           =           $student->last_login;
        $arr[$key]["T-Shirt Size"]         =           $student->tsize;
        $arr[$key]["Created_at"]           =           $student->created_at;
        $arr[$key]["updated_at"]           =           $student->updated_at;

     
            
        }
       
         ob_end_clean(); // this
        ob_start();
         return Excel::create('Student', function($excel) use ($arr) {
            $excel->sheet('mySheet', function($sheet) use ($arr)
            {
                $sheet->cell('A1:V1', function($cell) {
                $cell->setFontWeight('bold');

                });
             
                $sheet->fromArray($arr);
            });
        })->download('xlsx');
        
        }

    }
// End Download School     
//download excel sheet template for student
  public function downloadstudentsheet()
  {
   
    try{       
        $student = Studentinfo::all();

               // ->map(function($input){
               //    $input['school_name']=School::where('id',$input['school_id'])
               //                                  ->first()->school_name;
               //             return $input;
               //                 });
        
        }catch(\Exception $e)
        {
          // dd($e);
          // dd(123);
          return redirect()->back()->with('error','Something is wrong');
        }
     // dd($student);

    if(count($student)>0){
        foreach($student as $key=>$student)
        {
        $arr[$key]["id"]                   =           '';
        $arr[$key]["Student Name"]         =           '';
        $arr[$key]["Student Email"]        =           '';
        $arr[$key]["Student Class"]        =           '';
        $arr[$key]["Student Section"]      =           '';
        $arr[$key]["DOB"]                  =           '';
        $arr[$key]["Mobile No"]            =           '';
        $arr[$key]["Address"]              =           '';
        $arr[$key]["Guardian Name 1"]      =           '';
        $arr[$key]["Guardian Email 1"]     =           '';
        $arr[$key]["Guardian Phone 1"]     =           '';
        $arr[$key]["Guardian Name 2"]      =           '';
        $arr[$key]["Guardian Email 2"]     =           '';
        $arr[$key]["Guardian Phone 2"]     =           '';
        $arr[$key]["School_Id"]            =           '';
        $arr[$key]["status"]               =           '';
        $arr[$key]["email_status"]         =           '';
        $arr[$key]["last_login"]           =           '';
        $arr[$key]["T-Shirt Size"]         =           '';
        $arr[$key]["Created_at"]           =           '';
        $arr[$key]["updated_at"]           =           '';  

        }
       
        ob_end_clean(); // this
        ob_start();
         return Excel::create('Student', function($excel) use ($arr) {
            $excel->sheet('mySheet', function($sheet) use ($arr)
            {
                $sheet->cell('A1:V1', function($cell) {
                $cell->setFontWeight('bold');
                });
             
                $sheet->fromArray($arr);
            });
        })->download('xlsx');
        
        }

  }
//
// ***********************ASSIGN PLAN ******************************

    public function assignplan($id)
    {
        $plans            =    DB::table('memberships')->get();
        $scname           =    DB::table('students')
                              ->select('id','name','school_id')
                              ->where('id',$id)->first();

        $schoolname       =   DB::table('schools')
                              ->select('school_name')
                              ->where('id',$scname->school_id)->first();
     
         $tt              =   DB::table('participantstudents')
                              ->select('*')->where('student_id',$id)->get();

        $planyear=array();
         foreach( $tt as $ttt)
         {
             $planyear[]   =DB::table('schoolplanmaster')
                            ->join('memberships','memberships.id','=','schoolplanmaster.planid')
                            ->join('participantstudents.schoolid','=','schoolplanmaster.schoolid')
                            ->select('*')
                            ->where('participantstudents.schoolid',$ttt->schoolid)->where('participantstudents.year',$ttt->year)->where('participantstudents.student_id',$id)->get();
         }
       
       // dd($planyear); 
    return view('admin.Student.assignplan',compact('plans','scname','planyear','schoolname'));
    }
    
    public function storestudentplanmaster(Request $request)
    {
     
        $request->validate([
           'schoo_id'     =>     'required',
            'stu_id'      =>     'required',
            'plan'        =>     'required',
             'year'       =>     'required',
            ]);
            

             $check   =   Studentmaster::
                          where('schoo_id',$request->schoo_id)
                          ->where('stu_id',$request->stu_id)
                          ->where('plan',$request->plan)
                          ->where('year',$request->year)->first();
             
              if($check==null)
              {
                      $data=$request->except('_token');
                     $plan=Studentmaster::insert($data);
                   
                     return redirect('school')->with('success','Rrecord Saved.');
              }
              else{
                // return redirect('school')->withErrors('Data Already exist in database.');
             }
    }
    
    // Start Student Login
    public function studentlogin()
    {
      // Student_login     
     // Mobile_Login

     return view('admin.Student.Mobile_Login');
    }
    // End Student Login 

    public function studentemailfpassword()
    {
        return view('admin.Student.studentemail');
    }




private function email($id)
{
    $i=0;
    $str=str_split('#%^{}[]:;“’,<>/?');
    foreach($str as $strs)
    {
        
        if(is_numeric(strpos($id,$strs)))
        {
             $i=$i+1;
        }
    }
    if(preg_match('/\s/',trim($id)))
        {
            $i=$i+1;
        }
        
    return $i;
    
}
private function emails($id)
{
    $i=0;
    $str=str_split('.@');
    foreach($str as $strs)
    {
        
        if(is_numeric(strpos($id,$strs)))
        {
             $i=$i+1;
        }
    }
    return $i;
    
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
    return view('admin.Student.viewTeamadmin',compact('schoolname','username','userType','teamdetails'));
   
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
   
return view('admin.Student.invimanufacturestudent',compact('schoolname','username','manufacture'));
}
  public function studentforgetpassword(Request $request)
    {
      $data= $request->all();
       $request->validate([
            'email'             => 'required|email',
        ],[
        'studentemail.required' => 'Please enter the email.',
         ]);
        

        try{
           $check=  User::where('email',$data['email'])->get()->count();
          if($check)
          {
            $name=User::where('email',$data['email'])->first()->name;
            $data=array('email'=>$data['email'],'name'=>$name);
            // print_r($data);
            Mail::send('Mail.studentpasswordreset', $data, function($message) use($data) {
            $message->to($data['email'])->subject
               ('Welcome Aboard | F1 in Schools™ India');
            $message->from('noreply@timeofsports.com','F1 in Schools™ India');
            });
 
            if(count(Mail::failures()) > 0)
            {
             return redirect()->back()->with('error','Email is not sent');   
            }
             return redirect()->back()->with('success','A Password Reset Link has been sent to your email. Please check.');
          }
          else
           {
            return redirect()->back()->with('error','Email is not Exists.');
           }
        }catch(\Exception $e)
        {
          return redirect()->back()->with('error',$e->getMessage());
        }

    }



    public function stududentforegetpass($email)
    {  //dd($email);
      $data=$email;
      // dd($data);
      return view('admin.Student.passwordresetpage',['data'=>$data]);
           
    }
    public function passwordresetstudent(Request $request)
    {
      $data= $request->all();

      $request->validate([
            'password'   => 'required_with:repassword|same:repassword',
            'repassword' => 'required'
        ],[
        'password.required'    =>'Please Enter the password.',   
        'repassword.required'  =>'Repassword should be same.',
         ]);
        try
        {
          $status= User::where('email',urldecode(base64_decode(urldecode($data['hemail']))))->update(['password'=>Hash::make($data['password'])]);
          if($status)
          {
           return redirect('studentlogin');
          }
          else{
            return redirect()->back()->with('erorr','Password is not reset.'); 
          }
        }catch(\Exception $e){
         return redirect()->back()->with('erorr','Something is Wrong.');
       }

    }
}
