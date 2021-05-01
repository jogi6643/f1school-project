<?php
namespace App\Http\Controllers;
use App\Schoolmasterplan;
use App\School;
use App\Participatestudent;
use App\Location;
use Illuminate\Http\Request;
use DB;
use App\User;
use Mail;
use Alert;
use App\Model\AssignedCoursetype;
use App\Model\Assigneddatetable;
use Auth;
use App\Model\Cron;
use App\Studentinfo;
use Session;
use Hash;
use App\Membership;
use App\Login_Academic_Year;
use App\Course;

class SchoolController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {

        if (Auth::user()->role == 1)
        {

        }
        else
        {

            if (!in_array(15, array_keys($req->session()
                ->all() ['data'])))
            {
                $req->session()
                    ->flash('status', 'You do not have right to access this module');

                return redirect('/');
            }
        }
        $adminid = Auth::user()->id;
        $adminname = Auth::user()->name;
        $eq = School::orderBy('created_at', 'DESC')->get();

        foreach ($eq as $key => $schools)
        {

            // dd($schools->zone);
            $zone = isset(DB::table('locations')->where('Zone_id', $schools->zone)
                ->first()
                ->zone) ? DB::table('locations')
                ->where('Zone_id', $schools->zone)
                ->first()->zone : "";

            $state = isset(DB::table('tbl_state')->where('id', $schools->state)
                ->first()
                ->name) ? DB::table('tbl_state')
                ->where('id', $schools->state)
                ->first()->name : "";

            $city = isset(DB::table('tbl_city')->where('id', $schools->city)
                ->first()
                ->name) ? DB::table('tbl_city')
                ->where('id', $schools->city)
                ->first()->name : "";

            $eq[$key]->zone = $zone;
            $eq[$key]->state = $state;
            $eq[$key]->city = $city;
            $eq[$key]->adminid = $adminid;
            $eq[$key]->adminname = $adminname;
        }

        return view('admin.school', compact('eq'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $req)
    {
        if (Auth::user()->role == 1)
        {

        }
        else
        {

            if (($req->session()
                ->all() ['data'][15]??0) != 1)
            {
                $req->session()
                    ->flash('status', 'You do not have right to access this module');

                return redirect('/');
            }
        }
        $loc = DB::table('locations')->where('status', 1)
            ->where('Zone_id', '!=', '')
            ->groupby('Zone_id')
            ->distinct()
            ->get();
        return view("admin.schoolcr", compact('loc'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $r)
    {

        $r->validate(['school_name' => 'required|regex:/^[a-zA-Z0-9 ]*$/',

        'type' => 'required',
        // 'address'=>'required',
        'city' => 'required',

        'zone' => 'required',

        'state' => 'required', 
        'email' => 'required|unique:schools|unique:users',

        // 'annual_fees'=>'numeric|nullable',
        'mobile' => 'numeric|nullable',
        // 'principal_mobile'=>'unique:schools','numeric|nullable'
        ], ['school_name.required' => 'The School/Collage Name field is required', 'mobile.numeric' => 'The School/Collage Phone field  must be a number.', 'email.unique' => 'You can use Email Id Please provide alternate Id.'
        // 'principal_mobile.numeric'=>'The Principal Phone field  must be a number.'
        ]);

          if($r->hasFile('pimage')){            
            $fname=time().".".$r->file('pimage')->getClientOriginalExtension();
            $pp=public_path('ImageSchool/');
            $r->file('pimage')->move($pp,$fname);
        }
        else
        {
          $fname ='';
        }

        $userPassword = time('his');
        $data = $r->except('_token');
        $data['status'] = "1";

        $aka = School::insert($data);

        $school = School::orderby('id', 'desc')->first();

        $user = new User();
        $user->name = $school->school_name;
        $user->email = $school->email;
        $user->role = 4;
        $user->password = bcrypt($userPassword . $school->id);
        $user->save();

        $aca1 = (int)date("Y");
        $aca2 =  $aca1+1;
        $academicyear = $aca1."-".$aca2;
        $academic = new Login_Academic_Year();
        $academic->school = $school->id;
        $academic->academicyear = $academicyear;
        $academic->save();

        // $data = array(
        //            "schoolname"=> $school->school_name,
        //            'password'=> $userPassword.$school->id,
        //            'email'=> $school->email,
        //            'schoolid'=>  base64_encode($school->id)
        //        );
        // $data['email']
        //  Mail::send('Mail.school', $data, function($message)use($data){
        //    $message->to($data['email'], 'noreply@f1inschoolsindia.com')
        //            ->subject('Welcome Aboard | Season 3 | F1 in Schools™ India');
        //    $message->from('noreply@f1inschoolsindia.com','F1School');
        // });
        //   implementation of sms logic by upanshu
        // $schooldata=DB::table('trainers')->select('name','phone')->where('id',$req->id)->first();
        // $mb=$r->mobile;
        //    $apikey = "YXPskaQxMk6oxtQcQbPo2Q";
        //    $apisender = "TOSAPP";
        //    $msg ="Welcome ".$r->school_name.",we have sent you a email for new password reset.Thank You.";
        //    $num ='91'.$mb;    // MULTIPLE NUMBER VARIABLE PUT HERE...!
        //    $ms = rawurlencode($msg);   //This for encode your message content
        //   $url = 'https://www.smsgatewayhub.com/api/mt/SendSMS?APIKey='.$apikey.'&senderid='.$apisender.'&channel=2&DCS=0&flashsms=0&number='.$num.'&text='.$ms.'&route=1';
        //  //echo $url;
        //  $ch=curl_init($url);
        //  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        //  curl_setopt($ch,CURLOPT_POST,1);
        //  curl_setopt($ch,CURLOPT_POSTFIELDS,"");
        //  curl_setopt($ch, CURLOPT_RETURNTRANSFER,2);
        //  $data = curl_exec($ch);
        //  echo '<br/><br/>';
        // print($data); /* result of API call*/
        if ($aka) return redirect('school')->with('success', 'Rrecord Saved.');
        else return redirect('school')
            ->withErrors('Unable to save Record.');

    }

    public function activateCollege($school_id)
    {

        $schoolid = base64_decode($school_id);

        //dd($schoolid);
        $data = DB::table('schools')->where('id', $schoolid)->first();

        return view('School.accountActivate', compact('schoolid', 'data'));

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\School  $school
     * @return \Illuminate\Http\Response
     */
    public function show(Request $req, $v)
    {

        if (Auth::user()->role == 1)
        {

        }
        else
        {

            if (!isset($req->session()
                ->all() ['data'][15]))
            {
                $req->session()
                    ->flash('status', 'You do not have right to access this module');

                return redirect('/');
            }
        }
        $k = School::find(base64_decode($v));
        $Academicyear = Login_Academic_Year::where('school',base64_decode($v))->first()->academicyear??'N/A';

    

        $zone = isset(DB::table('locations')->where('Zone_id', $k->zone)
            ->first()
            ->zone) ? DB::table('locations')
            ->where('Zone_id', $k->zone)
            ->first()->zone : "";

        $state = isset(DB::table('tbl_state')->where('id', $k->state)
            ->first()
            ->name) ? DB::table('tbl_state')
            ->where('id', $k->state)
            ->first()->name : "";

        $city = isset(DB::table('tbl_city')->where('id', $k->city)
            ->first()
            ->name) ? DB::table('tbl_city')
            ->where('id', $k->city)
            ->first()->name : "";

        return view('admin.schoolv', compact('k', 'zone', 'state', 'city','Academicyear'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\School  $school
     * @return \Illuminate\Http\Response
     */
    public function edit($v, Request $req)
    {
        if (Auth::user()->role == 1)
        {

        }
        else
        {

            if (($req->session()
                ->all() ['data'][18]??0) != 1)
            {
                $req->session()
                    ->flash('status', 'You do not have right to access this module');

                return redirect('/');
            }
        }

        $r = School::find(base64_decode($v));

        $zone_name = DB::table('locations')->where('Zone_id', $r->zone)
            ->first()->zone??"";
        $state_name = DB::table('tbl_state')->where('id', $r->state)
            ->first()->name??"";
        $city_name = DB::table('tbl_city')->where('id', $r->city)
            ->first()->name??"";
        $loc = DB::table('locations')
         ->groupby('Zone_id')
            ->distinct()
            ->get();
        return view('admin.schooled', compact('r', 'loc', 'zone_name', 'state_name', 'city_name'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\School  $school
     * @return \Illuminate\Http\Response
     */
    public function update(Request $r)
    {

        $r->validate(['school_name' => 'required|regex:/^[a-zA-Z0-9 ]*$/',
        // 'school_name'  =>  ['required','regex:/^([a-zA-Z0-9]+|[a-zA-Z0-9]+\s{1}[a-zA-Z0-9]{1,}|[a-zA-Z0-9]+\s{1}[a-zA-Z0-9]{3,}\s{1}[a-zA-Z0-9]{1,})$/i'],
        // 'school_name'=>'required',
        'type' => 'required',
        // 'address'=>'required',
        'city' => 'required',
        // 'email'=>'required|unique:schools|unique:users',
        'zone' => 'required',

        'state' => 'required',
        // 'annual_fees'=>'numeric|nullable',
        'mobile' => 'numeric|nullable',
        // 'principal_mobile'=>'unique:schools','numeric|nullable'
        ], ['school_name.required' => 'The School/Collage Name field is required', 'mobile.numeric' => 'The School/Collage Phone field  must be a number.', 'email.unique' => 'You can use Email Id Please provide alternate Id.'
        // 'principal_mobile.numeric'=>'The Principal Phone field  must be a number.'
        ]);
        $up = School::find($r->sid);
      if($r->hasFile('pimage')){            
            $fname = time().".".$r->file('pimage')->getClientOriginalExtension();
            $pp = public_path('ImageSchool/');
            $r->file('pimage')->move($pp,$fname);

        }
        else
        {
          $fname =$up->pimage;
        } 

        
        if ($up)
        {
            $data = $r->except('_token', 'sid');
            $data['status'] = $r->status;
            $data['pimage'] = $fname;
            $ok = School::where('id', $r->sid)
                ->update($data);
            $aca1 = (int)date("Y");
            $aca2 =  $aca1+1;
            // ."-".(int)date("Y")+1;
            $academicyear = $aca1."-".$aca2;
           
            Login_Academic_Year::where('school', $r->sid)
                         ->update([
                               'academicyear' => $academicyear,
                                ]);
            if ($ok) return redirect('school')->with('success', 'Record Updated.');
            else return redirect('school')
                ->withErrors('Unable to update Record.');
        }
        else return redirect('school')
            ->withErrors('Unable to update Record.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\School  $school
     * @return \Illuminate\Http\Response
     */
    public function destroy($v)
    {
        $kk = School::find(base64_decode($v));
        if ($kk->delete()) return redirect('school')
            ->with('success', 'Record Deleted');
        else return redirect('school')
            ->withErrors('Unable to delete record.');
    }

    public function schoolplanmaster($school)
    {
        // dd(Schoolmasterplan::get());
        $plans = DB::table('memberships')->get();
        $schoolname = DB::table('schools')->select('school_name')
            ->where('id', base64_decode($school))->first();

        $planperschool = DB::table('memberships')->join('schoolplanmaster', 'schoolplanmaster.plan', '=', 'memberships.id')
            ->orderBy('schoolplanmaster.id', 'DESC')
            ->orderBy('schoolplanmaster.year', 'DESC')

            ->select('*')
            ->where('schoolid', base64_decode($school))->get();

        foreach ($planperschool as $key => $plans1)
        {
            $planperschool[$key]->counts = DB::table('participantstudents')
                ->where('year', $plans1->year)
                ->where('schoolid', $plans1->schoolid)
                ->where('planid', $plans1->plan)

                ->count();
        }

        return view('admin.schoolplanmaster', compact('plans', 'school', 'schoolname', 'planperschool'));

    }

    public function storeschoolplanmaster(Request $request)
    {
        $request->validate(['schoolid' => 'required', 'plan' => 'required', 'year' => 'required', ]);
        $count = 0;
        foreach ($request->plan as $planid)
        {
            $check = Schoolmasterplan::where('schoolid', $request->schoolid)
                ->where('plan', $planid)->where('year', $request->year)
                ->first();
            if ($check == null)
            {
                $count = $count + 1;
                $plan = new Schoolmasterplan();
                $plan->schoolid = $request->schoolid;
                $plan->plan = $planid;
                $plan->year = $request->year;
                $plan->save();
            }
        }
        if ($count != 0)
        {
            return redirect('schoolplanmaster/' . base64_encode($request->schoolid))
                ->with('success', 'Rrecord Saved.');
        }
        if ($count == 0)
        {
            return redirect('schoolplanmaster/' . base64_encode($request->schoolid))
                ->withErrors('Data Already exist in database.');
        }

    }

    public function participanrshow()
    {

        $schoolmasterplan = DB::table('schoolplanmaster')->join('schools', 'schools.id', '=', 'schoolplanmaster.schoolid')
            ->join('students', 'students.school_id', '=', 'schools.id')
            ->where('schoolid', $_GET['school_id'])->where('year', $_GET['year'])->distinct('students.mobileno')
            ->select('students.id', 'students.name', 'students.studentemail', 'students.class', 'students.updated_at')
            ->get();

         // $schoolmasterplan = DB::table('participantstudents')->join('schools', 'schools.id', '=', 'participantstudents.schoolid')
         //    ->join('students', 'students.school_id', '=', 'schools.id')
         //    ->where('')
         //    ->where('participantstudents.schoolid', $_GET['school_id'])->where('participantstudents.year', $_GET['year'])->distinct('students.mobileno')
         //    ->select('students.id', 'students.name', 'students.studentemail', 'students.class', 'participantstudents.updated_at')
         //    ->get();

        foreach ($schoolmasterplan as $key => $value)
        {
            // ->where('planid', $_GET['planid'])
            $table = DB::table('participantstudents')->where('student_id', $value->id)
                ->where('year', $_GET['year'])->count();

            if ($table > 0)
            {$schoolmasterplan[$key]->updated_at = DB::table('participantstudents')->where('student_id', $value->id)
                    ->where('year', $_GET['year'])->first()->updated_at??'N/A';
                $schoolmasterplan[$key]->check = 1;
                $pid = DB::table('participantstudents')->where('student_id', $value->id)
                    ->where('year', $_GET['year'])->first()->planid??'N/A';
                $schoolmasterplan[$key]->avplanname = Membership::where('id', $pid)->first()->name??'N/A';
                $schoolmasterplan[$key]->ppid = $pid;
                $schoolmasterplan[$key]->updated_at = DB::table('participantstudents')->where('student_id', $value->id)
                    ->where('year', $_GET['year'])->first()->updated_at??'N/A';
            }
            else
            {
                $schoolmasterplan[$key]->check = 0;
                $schoolmasterplan[$key]->avplanname = 'N/A';
                  $schoolmasterplan[$key]->ppid = 0;
                  $schoolmasterplan[$key]->updated_at = 'N/A';


            }
        }
      
        return $Response = array(
            'schoolplan' => $schoolmasterplan,
            'planname'=> Membership::where('id',$_GET['planid'])->first()->name??'N/A'
             // 'ppid'=>$_GET['planid']
        
        );

    }

     public function participanrshow1($schoolid,$year,$planid)
    {

        $schoolmasterplan = DB::table('schoolplanmaster')->join('schools', 'schools.id', '=', 'schoolplanmaster.schoolid')
            ->join('students', 'students.school_id', '=', 'schools.id')
            ->where('schoolid', $schoolid)->where('year', $year)->distinct('students.mobileno')
            ->select('students.id', 'students.name', 'students.studentemail', 'students.class', 'schoolplanmaster.updated_at')
            ->get();

       // $schoolmasterplan = DB::table('participantstudents')->join('schools', 'schools.id', '=', 'participantstudents.schoolid')
       //      ->join('students', 'students.school_id', '=', 'schools.id')
       //      ->where('participantstudents.schoolid', $schoolid)->where('participantstudents.year', $year)->distinct('students.mobileno')
       //      ->select('students.id', 'students.name', 'students.studentemail', 'students.class', 'participantstudents.updated_at')
       //      ->get();

        foreach ($schoolmasterplan as $key => $value)
        {
            // ->where('planid', $_GET['planid'])
            

            $table = DB::table('participantstudents')->where('student_id', $value->id)
                ->where('year',  $year)->count();

            if ($table > 0)
            {

                $schoolmasterplan[$key]->check = 1;
                $pid = DB::table('participantstudents')->where('student_id', $value->id)
                    ->where('year', $year)->first()->planid??'N/A';
                $schoolmasterplan[$key]->avplanname = Membership::where('id', $pid)->first()->name??'N/A';
                $schoolmasterplan[$key]->ppid = $pid;
                 $schoolmasterplan[$key]->updated_at = DB::table('participantstudents')->where('student_id', $value->id)
                    ->where('year', $year)->first()->updated_at??'N/A';
            }
            else
            {
                $schoolmasterplan[$key]->check = 0;
                $schoolmasterplan[$key]->avplanname = 'N/A';
                $schoolmasterplan[$key]->ppid = 0;
                $schoolmasterplan[$key]->updated_at = 'N/A';


            }
        }
          
        return $Response = array(
            'schoolplan' => $schoolmasterplan,
            'planname'=> Membership::where('id',$planid)->first()->name??'N/A'
        
        );


    }

    public function menbershipsata()
    {
         // DB::table('schoolplanmaster')->where('schoolid', $_GET['school_id'])
         //      ->where('year', $_GET['year'])
         //      ->where('plan',$_GET['year'])
         //      ->delete();
              
        $plan = DB::table('schoolplanmaster')->where('schoolid', $_GET['school_id'])->where('year', $_GET['year'])->join('memberships', 'memberships.id', '=', 'schoolplanmaster.plan')
            ->select('memberships.id', 'memberships.name')
            ->distinct('memberships.id')
            ->get();
        return $Response = array(
            'plan' => $plan
        );
    }

    public function participantlist($schooldp, Request $req)
    {
        // $ids = AssignedCoursetype::get();
        // dd($ids);
        if (Auth::user()->role == 1)
        {

        }
        else
        {

            if (($req->session()
                ->all() ['data'][18]??0) != 1)
            {
                $req->session()
                    ->flash('status', 'You do not have right to access this module');

                return redirect('/');
            }
        }
        $students = DB::table('students')->where('school_id', base64_decode($schooldp))->get();

        $schoolname = DB::table('schools')->select('school_name')
            ->where('id', base64_decode($schooldp))->first();

        return view('admin.participantlist', compact('students', 'schooldp', 'schoolname'));
    }

    public function sbmitparticipant(Request $req)
    {
         $schoolplan = Schoolmasterplan::
                       where('plan',$req->planid)
                       ->where('schoolid',$req->schoolid)
                       ->where('year',$req->year)->get();

          Participatestudent::where('schoolid', $req->schoolid)
            // ->where('year', '2020-2021')
            ->where('year', $req->year)
            ->where('planid', $req->planid)
            ->delete();

        AssignedCoursetype::where('school_id',$req->schoolid)
                    ->where('acyear',$req->year)
                    ->where('Plan_id',$req->planid)
                    ->delete();
                    
    if($req->student!=null)
        {
           foreach ($req->student as $key => $v1)
            {
 
            $studentp = new Participatestudent();
            $studentp->schoolid = $req->schoolid;
            $studentp->planid = $req->planid;
            $studentp->student_id = $v1;
            $studentp->year = $req->year;
            $studentp->save();

            }
        }                           
     /*****************************************************************************/
      $ParticipateStudent = Participatestudent::where('schoolid', $req->schoolid)
            ->where('year', $req->year)
            ->where('planid', $req->planid)
            ->get();

        $assigndate  = Assigneddatetable::where('Plan_id',$req->planid)
                ->where('school_id',$req->schoolid)->where('acyear',$req->year)->get();

        if(count($assigndate)>0)
        { 
        foreach( $ParticipateStudent as  $studentid1)
             { 
            foreach ($assigndate as $key => $value) {
                $assigned=new AssignedCoursetype();
               $assigned->doc_types_id = $value->doc_types_id;
               $assigned->course_masters_id = $value->course_masters_id;
               $assigned->student_id = $studentid1->student_id;
               $assigned->school_id = $req->schoolid;
               $assigned->Plan_id = $req->planid;
               $assigned->acyear = $req->year;
               $assigned->priority_set = $value->priority_set;
                if($value->assigneddate==null)
                {
               $assigned->assigneddate = '12-12-1993';
                }
                else
                 {
              $assigned->assigneddate = $value->assigneddate;
                 }   

               $assigned->edited_by = Auth::user()->id;
               $assigned->save();
            }
          }

        } 


        else
        {
     $ParticipateStudent = Participatestudent::where('schoolid', $req->schoolid)
            ->where('year', $req->year)
            ->where('planid', $req->planid)
            ->get();
    /*Assign Participant Student in Plan*/
    if(count($ParticipateStudent)>0)
    {
    $pri = Membership::where('id',$req->planid)->first()->priorty_set;
    $priorty_set = explode(',',$pri); 
    $cour = Membership::where('id',$req->planid)->first()->course_list;
    $course_list2 = explode(',',$cour);    
      foreach( $ParticipateStudent as  $studentid1)
       { 
             $i=0;
            foreach ($course_list2 as $key => $course_id) {
               $assigned=new AssignedCoursetype();
               $assigned->doc_types_id = Course::where('id',$course_id)
                                         ->first()->doc_types_id;
               $assigned->course_masters_id = $course_id;
               $assigned->student_id = $studentid1->student_id;
               $assigned->school_id = $studentid1->schoolid;
               $assigned->Plan_id = $req->planid;
               $assigned->acyear = $req->year;
               $assigned->priority_set = $priorty_set[$i];
               $assigned->assigneddate = '12-12-1993';
               $assigned->edited_by = Auth::user()->id;
               $assigned->save();
               
              
         
                $i = $i+1;
              } 
             
       }
}
/*End Assign Plan for Student*/
}              

     /********************************************************************************/       

        $student_plan = $this->participanrshow1($req->schoolid,$req->year,$req->planid);

       
        $planname = Membership::where('id',$req->planid)->first()->name;
        return redirect('participantlist/' . base64_encode($req->schoolid))
            ->with('success', 'Record Saved.')
            ->with('Year',$req->year)
            ->with('planname',$planname)
            ->with('students1',$student_plan)
            ->with('planid1',$req->planid);

    }
    // public function manufacturingapplication()
    // {
    //     echo "Test";
    // }
    //upanshu
    //school
    public function invitebyemail(Request $school)
    {

        // school
        // $data['email']
        // $data['email']
        $link = "route('/passwordreset')";
        $data = array(
            "name" => $school->sname,
            'password' => strtolower('school') . $school->id,
            'email' => $school->email,
            "link" => $link
        );
        Mail::send('Mail.schoolpasswordresetmail', $data, function ($message) use ($data)
        {
            $message->to($data['email'])->subject('Welcome Aboard | F1 in Schools™ India');
            $message->from('noreply@timeofsports.com', 'F1 in Schools™ India');
        });
        $statuschool = DB::table('schools')->where('id', $school->id)
            ->update(['checkStatus' => "1"]);

        //implementation of sms logic by upanshu
        // $schooldata=DB::table('schools')->select('school_name','mobile')->where('id',$school->id)->first();
        // $mb=$schooldata->mobile;
        //    $apikey = "YXPskaQxMk6oxtQcQbPo2Q";
        //    $apisender = "TOSAPP";
        //    $msg ="Welcome ".$schooldata->school_name.",we have sent you a email for new password reset.Thank You.";
        //    $num ='91'.$mb;    // MULTIPLE NUMBER VARIABLE PUT HERE...!
        //    $ms = rawurlencode($msg);   //This for encode your message content
        //   $url = 'https://www.smsgatewayhub.com/api/mt/SendSMS?APIKey='.$apikey.'&senderid='.$apisender.'&channel=2&DCS=0&flashsms=0&number='.$num.'&text='.$ms.'&route=1';
        //echo $url;
        // $ch=curl_init($url);
        // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        // curl_setopt($ch,CURLOPT_POST,1);
        // curl_setopt($ch,CURLOPT_POSTFIELDS,"");
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER,2);
        // $data = curl_exec($ch);
        //echo '<br/><br/>';
        // print($data); /* result of API call*/
        echo "Email  Sent Successfully";
    }

    public function passwordreset(Request $request)
    {
        $data = array(
            'email' => $request->email
        );

        return view('School.passwordresetpage', compact('data'));
        // view('School.passwordresetpage');
        
    }

    // public function passwordreset(Request $request)
    // {
    //       $data = array('email'=>$request->email);
    //       return view('School.passwordresetpage',compact('data'));
    //       // view('School.passwordresetpage');
    // }
    public function newpassword(Request $req)
    {
        $req->validate(['password' => 'required|required_with:password_confirmation|same:password_confirmation', 'password_confirmation' => '']);
        $userEmail = $req->hemail;
        $password = bcrypt($req->password);

        if (DB::table('users')
            ->where('email', $userEmail)->exists())
        {
            DB::table('users')
                ->where('email', $userEmail)->limit(1)
                ->update(array(
                'password' => $password
            ));
            return redirect('/');
        }
        return redirect('passwordreset')->with('failure', 'something is wrong.');
    }

    //liststudent
    public function studentpasswordreset(Request $req)
    {
        //echo $req->email;
        $data = array(
            'email' => $req->email
        );

        return view('School.studentpasswordresetpage', compact('data'));

    }

    public function studentnewpassword(Request $req)
    {

        $req->validate(['password' => 'required|required_with:password_confirmation|same:password_confirmation', 'password_confirmation' => '']);
        $userEmail = base64_decode(urldecode($req->hemail));

        $password = bcrypt($req->password);

        if (DB::table('users')
            ->where('email', $userEmail)->exists())
        {
            DB::table('users')
                ->where('email', $userEmail)->limit(1)
                ->update(array(
                'password' => $password
            ));

            return redirect('studentlogin');
        }
        return redirect('studentpasswordreset')->with('failure', 'something is wrong.');
    }

    public function studentlistformail(Request $req)
    {
		

	$apikey = "YXPskaQxMk6oxtQcQbPo2Q";
             $apisender = "TOSAPP";
               $msg = "Dear ".$req->sname.",Explore STEM Learning Platform powered by F1 in Schools India. Now Learning will be Fun! Signup:Link <a href=".url('studentlogin').">click</a>";
            
             $num ='91'.$req->mob;    // MULTIPLE NUMBER VARIABLE PUT HERE...!                 
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
		 
       // $link = "route('/studentnewpassword')";
	   $link = "route('/studentlogin')";
        $data = array(
            'name' => $req->sname,
            'password' => strtolower($req->email . $req->id) ,
            'email' => $req->email,
            "link" => $link
        );

        Mail::send('Mail.listStudent', $data, function ($message) use ($data)
        {
            $message->to($data['email'], 'noreply@f1inschoolsindia.com')->subject('Welcome Aboard | F1 in Schools™ India');
            $message->from('noreply@timeofsports.com', 'F1 in Schools™ India');
        });

        $statuschool = DB::table('students')->where('id', $req->id)
            ->update(['email_status' => "1"]);

        // //implementation of sms logic by upanshu
        // $schooldata=DB::table('students')->select('name','mobileno')->where('id',$req->id)->first();
        // $mb=$schooldata->mobileno;
        //    $apikey = "YXPskaQxMk6oxtQcQbPo2Q";
        //    $apisender = "TOSAPP";
        //    $msg ="Hi ".$schooldata->name.",we have sent you a email for new password reset.Thank You.";
        //    $num ='91'.$mb;    // MULTIPLE NUMBER VARIABLE PUT HERE...!
        //    $ms = rawurlencode($msg);   //This for encode your message content
        //   $url = 'https://www.smsgatewayhub.com/api/mt/SendSMS?APIKey='.$apikey.'&senderid='.$apisender.'&channel=2&DCS=0&flashsms=0&number='.$num.'&text='.$ms.'&route=1';
        //echo $url;
        // $ch=curl_init($url);
        // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        // curl_setopt($ch,CURLOPT_POST,1);
        // curl_setopt($ch,CURLOPT_POSTFIELDS,"");
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER,2);
        // $data = curl_exec($ch);
        //echo '<br/><br/>';
        // print($data); /* result of API call*/
        echo "Email  Sent Successfully";
    }

    //Jogi create on 19 Octer 2019
    public function createteamadd($stschid)
    {

        $stschId = explode("_", base64_decode($stschid));

        $admin_id = $stschId[0];
        $scid = $stschId[1];

        // $trainername=Trainer::find($tid)->name;
        $students = DB::table('students')->select('id', 'name')
            ->where('school_id', $scid)->get();

        return view('Trainer.createteambytr', compact('admin_id', 'scid', 'students', 'trainername'));
    }
    public function invitebyemailbulk()
    {
        foreach ($_POST['school'] as $schools)
        {
            $schools = School::find($schools);
            $cron = new Cron();
            $cron->schoolid = $schools->id;
            $cron->emailid = $schools->email;
            $cron->save();

        }

        return 1;

    }

    public function cronstartschool()
    {
        $runcron = Cron::where('status', 0)->limit(10)
            ->get();

        foreach ($runcron as $runcron)
        {
            $schools = School::find($runcron->schoolid);

            $link = "route('/passwordreset')";
            $data = array(
                "schoolname" => $schools->school_name,
                'password' => strtolower('school') . $schools->id,
                'email' => $schools->email,
                "link" => $link
            );
            Mail::send('Mail.school', $data, function ($message) use ($data)
            {
                $message->to($data['email'])->subject('Welcome Aboard | F1 in Schools™ India');
                $message->from('noreply@timeofsports.com', 'F1 in Schools™ India');
            });

            $statuschool = Cron::where('schoolid', $runcron->schoolid)
                ->update(['status' => "1"]);

            $statuschool = School::where('id', $runcron->schoolid)
                ->update(['checkStatus' => "1"]);

        }
    }

    public function invitebyemailstudentbulk()
    {
        foreach ($_POST['student'] as $student)
        {
            $student = Studentinfo::find($student);
            $cron = new Cron();
            $cron->studentid = $student->id;
            $cron->emailid = $student->studentemail;
			$cron->mob = $student->mobileno;
            $cron->save();
        }

        // return ;
        
    }
    public function cronstratstudent()
    {

        // $data['email']
        $runcron = Cron::where('status', 0)->limit(10)
            ->get();
        // dd($runcron);
        foreach ($runcron as $runcron)
        {
			$student = Studentinfo::find($runcron->studentid);
			 $apikey = "YXPskaQxMk6oxtQcQbPo2Q";
             $apisender = "TOSAPP";
			   //$msg = "Dear ".$student->name.",.Welcome to Tech Club! Complete your Sign Up and start your journey on your very own STEM platform.Link ".url('studentlogin')." click>";
              $msg = "Dear ".$student->name.",Explore STEM Learning Platform powered by F1 in Schools India. Now Learning will be Fun! Signup:Link ".url('studentlogin')." click";
            
            // $msg = "Dear ".$student->name.",.Welcome to Tech Club! Complete your Sign Up and start your journey on your very own STEM platform.Link ".url('studentlogin')." click>";
             $num ='91'.$runcron->mob;    // MULTIPLE NUMBER VARIABLE PUT HERE...!                 
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
		 

	   $link = "route('/studentlogin')";
            
            //$link = "route('/studentnewpassword')";
            $data = array(
                'name' => $student->name,
                'password' => strtolower($student->studentemail . $student->id) ,
                'email' => $student->studentemail,
                "link" => $link
            );
            Mail::send('Mail.listStudent', $data, function ($message) use ($data)
            {
                $message->to($data['email'])->subject('Welcome Aboard | F1 in Schools™ India');
                $message->from('noreply@timeofsports.com', 'F1 in Schools™ India');
            });

            $statuschool = Cron::where('studentid', $runcron->studentid)
                ->update(['status' => "1"]);

            $statuschool = Studentinfo::where('id', $runcron->studentid)
                ->update(['email_status' => "1"]);
        }
    }

    // Reset Password
    public function forgetpasswordemail()
    {
        return view('School.schoolpasswordpage');
    }
    public function checkemail(Request $request)
    {
        $data = $request->all();
        $request->validate(['email' => 'required|email', ], ['studentemail.required' => 'Please enter the email.', ]);

        try
        {
            $check = User::where('email', $data['email'])->where('role', 4)
                ->get()
                ->count();

            if ($check)
            {
                $name = User::where('email', $data['email'])->first()->name;
                $data = array(
                    'email' => $data['email'],
                    'name' => $name
                );
                // dd($data);
                Mail::send('Mail.schoolpasswordresetmail', $data, function ($message) use ($data)
                {
                    $message->to($data['email'])->subject('Welcome Aboard | F1 in Schools™ India');
                    $message->from('noreply@timeofsports.com', 'F1 in Schools™ India');
                });

                if (count(Mail::failures()) > 0)
                {
                    return redirect()
                        ->back()
                        ->with('error', 'Email is not sent');
                }
                return redirect()
                    ->back()
                    ->with('success', 'Password reset link is sent to your email.');
            }
            else
            {
                return redirect()
                    ->back()
                    ->with('error', 'Email is not Exists.');
            }
        }
        catch(\Exception $e)
        {
            return redirect()->back()
                ->with('error', $e->getMessage());
        }

    }

    public function toresetpassword($email)
    { //dd($email);
        $data = base64_decode(urldecode($email));

        return view('School.schoolnewpassword', ['data' => $data]);

    }

    public function cpasswordreset(Request $request)
    {
        $data = $request->all();
        //base64_decode($data['hemail'])
        // dd(base64_decode($data['hemail']));
        $request->validate(['password' => 'required_with:repassword|same:repassword', 'repassword' => 'required'], ['password.required' => 'Please Enter the password.', 'repassword.required' => 'Repassword should be same.', ]);

        try
        {
            $status = User::where('email', base64_decode($data['hemail']))->update(['password' => Hash::make($data['password']) ]);

            if ($status)
            {
                return redirect('/schoollogin');
            }
            else
            {
                return redirect()->back()
                    ->with('erorr', 'Password is not reset.');
            }
        }
        catch(\Exception $e)
        {
            return redirect()->back()
                ->with('erorr', 'Something is Wrong.');
        }

    }
    //End Reset Password
    

    public function schoollogin()
    {
        return view('School.schoollogin');
    }

    public function sclogin(Request $req)
    {
        $credentials = $req->only('email', 'password');

        if (Auth::attempt($credentials))
        {
            $email = Auth::user()->email;
            $role = Auth::user()->role;

            if ($role == 4)
            {

                $check = School::where('email', $email)->first();
                if ($check->status == 1)
                {

                    return redirect('/home');

                }
                else
                {
                    Auth::logout();
                    $req->session()
                        ->flash('danger', 'Dear School Your Account has been disabled Contact to School');
                    return redirect('/schoollogin');
                }

            }
            else
            {

                Auth::logout();
                $req->session()
                    ->flash('danger', 'Permission Denied Please Check Your Url....');
                return redirect('/schoollogin');
            }

        }

        else
        {
            Auth::logout();
            $req->session()
                ->flash('danger', 'These credentials do not match our records.');
            return redirect('/schoollogin');
        }

    }

    public function schoolplanfetchacademicyear(Request $req)
    {
        $req->v;
        // $ab=Schoolmasterplan::
        //     ->leftjoin('memberships','memberships.id','=','tbl_state.id')
        //           //  where('schoolid',$request->schoolid)
        //           // ->where('plan',$planid)
        

        $ab = Membership::where('academicyear', $req->v)
            ->get();
        return $ab;
    }

    public function sclogout(Request $request)
    {

        Auth::logout();
        Session::flush();
        return redirect('/schoollogin');
    }

}

