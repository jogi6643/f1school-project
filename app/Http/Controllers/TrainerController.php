<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Model\Trainer;
use App\School;
use App\User;
use App\Model\SchoolTrainer;
use Mail;
use Hash;
use DB;
use Illuminate\Database\QueryException;
use Alert;
use App\Events\assigrntrainerE;
use App\Email\NotificationMail;
use Auth;
use Session;
class TrainerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
		   if(Auth::user()->role==1)
			{
				
			}
			else
			{
			 
			  if(!isset($req->session()->all()['data'][8]))
				{
					$req->session()->flash('status','You do not have right to access this module');
					
					return redirect('/');
				}		 
			}
        $eq=Trainer::all();
        // Alert::info('Your profile is up to date', 'Wonderful!');
    
        
        return view('admin.Trainer.trainer',compact('eq'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $req)
    {
		   if(Auth::user()->role==1)
			{
				
			}
			else
			{
			 
			  if(($req->session()->all()['data'][8]??0)!=1)
				{
					$req->session()->flash('status','You do not have right to access this module');
					
					return redirect('/');
				}		 
			}
			
          return view('admin.Trainer.addtrainer');
    }

    /**
     * Store a newly created resource in storage.
     *s
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // public function store(Request $request)
    // {
    // // $request->validate([

    // //       'name'      => 'required','regex:/^([a-zA-Z0-9]+|[a-zA-Z0-9]+\s{1}[a-zA-Z0-9]{1,}|[a-zA-Z0-9]+\s{1}[a-zA-Z0-9]{3,}\s{1}[a-zA-Z0-9]{1,})$/i',
    // //       'phone'=>'required|regex:/^[0-9]{10}+$/',
    // //       // 'pimage' =>'pimage|mimes:jpeg,png,jpg,gif,svg|max:2048',
    // //       'email'=>'required|unique:trainers|unique:users'],['name.required'=>'Trainer Name field is required.','email.required'=>'Trainer Email field is required','phone'=>'Trainer phone field is required','email.unique'=>'This Email Id already exists.']);
        
    //     if($request->hasFile('pimage')){            
    //     $fname=time().".".$request->file('pimage')->getClientOriginalExtension();
    //         $pp=public_path('trainerprofile/');
    //         $request->file('pimage')->move($pp,$fname);
    //     }
    //     else
    //     {
    //       $fname ='';
    //     } 
    //     return response()->json(['success'=>$fname]);
    //     $email=Auth::user()->first();
    //     $trainer=new Trainer();
    //     $trainer->name=$request->name;
    //     $trainer->email=$request->email;
    //     $trainer->phone=$request->phone;
    //     $trainer->status=1;
    //     $trainer->pimage=$fname;
    //     $trainer->addedby=$email->email;
    //     $trainer->roleby=$email->role;
    //     // $trainer->save();
    //      $trainer=Trainer::orderby('id','desc')->first();
    //      $user=new User();
    //      $user->name=$trainer->name;
    //      $user->email=$trainer->email;
    //      $user->role=3;
    //      $user->password=bcrypt(strtolower($trainer->name).$trainer->id);
    //      // $user->save();
    //     return response()->json(['success'=>'Form is successfully submitted!']);
    //      // $data=array("trainer"=>$trainer->name,'password'=>strtolower($trainer->name).$trainer->id,'email'=>$trainer->email);
    //      //  Mail::send('Mail.trainer', $data, function($message) use($data) {
    //      // $message->to($data['email'], 'noreply@whitegarlic.in')->subject
    //      //    ('Welcome to F1school');
    //      // $message->from('noreply@whitegarlic.in','F1School');
    //      // });
    
    //  //implementation of sms logic by upanshu
    //       //$schooldata=DB::table('schools')->select('school_name','mobile')->where('id',$school->id)->first();
          
    //        //  $mb=$request->phone;
        
    //        //   $apikey = "YXPskaQxMk6oxtQcQbPo2Q";
    //        //   $apisender = "TOSAPP";
    //        //   $msg ="Hi ".$request->name.",A new Trainer has been added.Thank You.";
    //        //   $num ='91'.$mb;    // MULTIPLE NUMBER VARIABLE PUT HERE...!                 
           
    //        //   $ms = rawurlencode($msg);   //This for encode your message content                     
           
    //        //  $url = 'https://www.smsgatewayhub.com/api/mt/SendSMS?APIKey='.$apikey.'&senderid='.$apisender.'&channel=2&DCS=0&flashsms=0&number='.$num.'&text='.$ms.'&route=1';
                               
    //        // //echo $url;
    //        // $ch=curl_init($url);
    //        // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    //        // curl_setopt($ch,CURLOPT_POST,1);
    //        // curl_setopt($ch,CURLOPT_POSTFIELDS,"");
    //        // curl_setopt($ch, CURLOPT_RETURNTRANSFER,2);
    //        // $data = curl_exec($ch);
    //        //echo '<br/><br/>';
    //       // print($data); /* result of API call*/
    //         return redirect('/atrainer')->withSuccess('success','Record Saved.');
         
    // }





     public function store(Request $request)
    {
    $request->validate([

          'name'      => 'required','regex:/^([a-zA-Z0-9]+|[a-zA-Z0-9]+\s{1}[a-zA-Z0-9]{1,}|[a-zA-Z0-9]+\s{1}[a-zA-Z0-9]{3,}\s{1}[a-zA-Z0-9]{1,})$/i',
          'phone'=>'required|regex:/^[0-9]{10}+$/',
          // 'pimage' =>'pimage|mimes:jpeg,png,jpg,gif,svg|max:2048',
          'email'=>'required|unique:trainers|unique:users'],['name.required'=>'Trainer Name field is required.','email.required'=>'Trainer Email field is required','phone'=>'Trainer phone field is required','email.unique'=>'This Email Id already exists.']);
        
        if($request->hasFile('pimage')){            
        $fname=time().".".$request->file('pimage')->getClientOriginalExtension();
            $pp=public_path('trainerprofile/');
            $request->file('pimage')->move($pp,$fname);
        }
        else
        {
          $fname ='';
        } 
        $email=Auth::user()->first();
        $trainer=new Trainer();
        $trainer->name=$request->name;
        $trainer->email=$request->email;
        $trainer->phone=$request->phone;
        $trainer->status=1;
        $trainer->pimage=$fname;
        $trainer->addedby=$email->email;
        $trainer->roleby=$email->role;
        $trainer->save();
         $trainer=Trainer::orderby('id','desc')->first();
         $user=new User();
         $user->name=$trainer->name;
         $user->email=$trainer->email;
         $user->role=3;
         $user->password=bcrypt(strtolower($trainer->name).$trainer->id);
         $user->save();
         // $data=array("trainer"=>$trainer->name,'password'=>strtolower($trainer->name).$trainer->id,'email'=>$trainer->email);
         //  Mail::send('Mail.trainer', $data, function($message) use($data) {
         // $message->to($data['email'], 'noreply@whitegarlic.in')->subject
         //    ('Welcome to F1school');
         // $message->from('noreply@whitegarlic.in','F1School');
         // });
     //implementation of sms logic by upanshu
          //$schooldata=DB::table('schools')->select('school_name','mobile')->where('id',$school->id)->first();
          
           //  $mb=$request->phone;
        
           //   $apikey = "YXPskaQxMk6oxtQcQbPo2Q";
           //   $apisender = "TOSAPP";
           //   $msg ="Hi ".$request->name.",A new Trainer has been added.Thank You.";
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
           //echo '<br/><br/>';
          // print($data); /* result of API call*/
            return redirect('/atrainer')->withSuccess('success','Record Saved.');
         
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Competition  $competition
     * @return \Illuminate\Http\Response
     */
    public function show(Competition $competition)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Competition  $competition
     * @return \Illuminate\Http\Response
     */
    public function edit(Trainer $tariner,$v,Request $req)
    {
		  if(Auth::user()->role==1)
			{
				
			}
			else
			{
			 
			  if(($req->session()->all()['data'][8]??0)!=1)
				{
					$req->session()->flash('status','You do not have right to access this module');
					
					return redirect('/');
				}		 
			}
			
        $k=Trainer::find(base64_decode($v));
     
        return view('admin.Trainer.edittrainer',compact('k'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Competition  $competition
     * @return \Illuminate\Http\Response
     */
    public function update(Request $r,$id)
    {
        
            $id=base64_decode($id);
     
         $r->validate([

          'name'      =>   ['required','regex:/^([a-zA-Z0-9]+|[a-zA-Z0-9]+\s{1}[a-zA-Z0-9]{1,}|[a-zA-Z0-9]+\s{1}[a-zA-Z0-9]{3,}\s{1}[a-zA-Z0-9]{1,})$/i'],

          'phone'=>'required|min:11|numeric'
          // ,'email'=>'required|unique:trainers|unique:users'
        ],
          ['name.required'=>'Trainer Name field is required.',
          'email.required'=>'Trainer Email field is required',
          'phone'=>'Trainer phone field is required',
          // 'email.unique'=>'You can use Email Id Please provide alternate Id.'

        ]);
          try
          {

          
         $pimage = Trainer::where('email',$r->email)->first();
        if($r->hasFile('pimage')){            
        $fname=time().".".$r->file('pimage')->getClientOriginalExtension();
            $pp=public_path('trainerprofile/');
            $r->file('pimage')->move($pp,$fname);
        }
        else
        {
          $fname = $pimage->pimage;
        } 
      $d = Trainer::where('email',$r->email)
       ->update([
           'name' => $r->name,
           'phone' =>$r->phone,
           'pimage' => $fname,
           'status' =>$r->status

      ]);
            // $d=Trainer::where('id',$id)->update($request->except('_token'));

            
            if($d)
            return redirect('atrainer')->with('success','Record Saved.');
        else
            return redirect('atrainer')->withErrors('Unable to save record.');
          }
          catch (QueryException $e){
                  $error_code = $e->errorInfo[1];
                
       if($error_code == 1062){
             
            //activity()->log('Label Creation faild due to duplicacy');
          // self::delete($lid);
    
        
            return redirect('atrainer')->withErrors('Email is already exists');;
             }
              //return redirect('tms_training');
             }
      
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Competition  $competition
     * @return \Illuminate\Http\Response
     */
    public function destroy(Competition $competition)
    {
        //
    }
    public function assigned()
    {
        $school=School::where('status',1)->get();
        foreach($school as $key=>$schools)
        {
            
        $zone=isset(DB::table('locations')->where('id',$schools->zone)->first()->zone)?DB::table('locations')->where('id',$schools->zone)->first()->zone:"";
        $state=isset(DB::table('tbl_state')->where('id',$schools->state)->first()->name)?DB::table('tbl_state')->where('id',$schools->state)->first()->name:"";
        $city=isset(DB::table('tbl_city')->where('id',$schools->city)->first()->name)?DB::table('tbl_city')->where('id',$schools->city)->first()->name:"";
         $school[$key]->zone=$zone; 
         $school[$key]->state=$state; 
         $school[$key]->city=$city; 
        }
       
        return view('admin.Trainer.assigned',compact('school'));
        
    }
    public function traineradd(Request $req, $id)
    {
    
        $check = SchoolTrainer::where('trainer_id', base64_decode($id))->where('year', $req->year)
            ->count();
     
        if ($check == 0)
        {

            if ($req->school != null)
            {

                foreach ($req->school as $schools)
                {
                    $school = new SchoolTrainer();
                    $school->trainer_id = base64_decode($id);
                    $school->year = $req->year;
                    $school->school_id = base64_decode($schools);
                    $school->save();
                }

                  $event2 = DB::table('trainers')->where('id', base64_decode($id))->first();
            // $data=array("trainer"=>$event2->name,'password'=>strtolower($event2->name).$event2->id,'email'=>$event2->email,'Schoolinfo'=>$schoolname);
            // $data['email']
            $data = array(
                "trainername" => $event2->name,
                'password' => strtolower($event2->name) . $event2->id,
                'email' => $event2->email
            );

            Mail::send('Mail.trainer', $data, function ($message) use ($data)
            {
                $message->to(trim($data['email']))->subject('Welcome Aboard | F1 in Schools™ India');
                $message->from('noreply@timeofsports.com', 'F1 in Schools™ India');
            });
            $tr = Trainer::find(base64_decode($id));
          
            return redirect('atrainer')->with('success', "Trainer Added Successfully.Invitation sent");

            }

          return redirect('/trainerassigned/'.$id)->with('errors',"Please Select At Least One School....");
          
        }
        else
        {

            SchoolTrainer::where('trainer_id', base64_decode($id))->where('year', $req->year)
                ->delete();
            if ($req->school != null)
            {
                foreach ($req->school as $schools)
                {
                    $school = new SchoolTrainer();
                    $school->trainer_id = base64_decode($id);
                    $school->year = $req->year;
                    $school->school_id = base64_decode($schools);
                    $school->save();
                }

                 $tr = Trainer::find(base64_decode($id));

            return redirect('atrainer')->with('success', "Trainer Added Successfully.Invitation sent");
            }
           return redirect('/trainerassigned/'.$id)->with('errors',"Please Select At Least One School....");
        
            
        }

        //     $SchoolTrainerinfo=DB::table('trainers')->where('id',base64_decode($id))->first();
        //     foreach($req->school as $schools){
        //           $schoolinfo= DB::table('schools')->where('id',base64_decode($schools))->first()->email;
        //           $data=array("SchoolTrainerinfo"=> $SchoolTrainerinfo,
        //                        "email" =>$schoolinfo
        //                       );
        //           Mail::send('Mail.trainerdetailsforschool', $data, function($message) use($data) {
        //           $message->to('jugendra@studiokrew.com', 'noreply@timeofsports.com')->subject('Welcome to F1school test');
        //           $message->from('noreply@timeofsports.com','F1School');
        //   });
        // }
        $scid = [];
        if ($req->school != null)
        {
            foreach ($req->school as $schoolid)
            {
                $scid[] = base64_decode($schoolid);
            }
        }

        $schoolname = School::whereIn('schools.id', $scid)->join('locations', 'locations.id', '=', 'schools.zone')
            ->join('tbl_city', 'tbl_city.id', '=', 'schools.city')
            ->select('schools.id', 'schools.school_name', 'locations.zone', 'tbl_city.name', 'schools.mobile', 'website')
            ->get();

    }



    public function invite_trainer($id)
    {
        $event2 = Trainer::where('id', base64_decode($id))->first();
        
            // $data=array("trainer"=>$event2->name,'password'=>strtolower($event2->name).$event2->id,'email'=>$event2->email,'Schoolinfo'=>$schoolname);
            // $data['email']
            $data = array(
                "trainername" => $event2->name,
                'password' => strtolower($event2->name) . $event2->id,
                'email' => $event2->email
            );

            Mail::send('Mail.trainer', $data, function ($message) use ($data)
            {
                $message->to(trim($data['email']))
                ->subject('Welcome Aboard | F1 in Schools™ India');
                $message->from('noreply@timeofsports.com', 'F1 in Schools™ India');
            });
            $tr = Trainer::find(base64_decode($id));
          
            return redirect('atrainer')->with('success', "Trainer Added Successfully.Invitation sent");
    }


    public function trainerschool()
    {
         $school=SchoolTrainer::where('trainer_id',base64_decode($_GET['trainer']))->where('year',$_GET['data'])->get();;
         
        echo json_encode($school);
    }

    //upanshu
    public function taineremailpasswordreset(Request $req)
    {      
        
          $link ="route('/trainerpasswordreset')";
          $data=array("id"=>$req->id,"trainername"=>$req->name,'password'=>strtolower('school').$req->id,'email'=>base64_decode($req->email),"link"=>$link);
          // print_r($data);die;
          Mail::send('Mail.trainer', $data, function($message) use($data) {
          $message->to($data['email'])->subject
          ('Welcome Aboard | F1 in Schools™ India');
         $message->from('noreply@timeofsports.com','F1 in Schools™ India');
          });
           $statuschool = DB::table('trainers')
                           ->where('id',$req->id)
                           ->update([
                         'email_status' => "1"
                           ]);
          //implementation of sms logic by upanshu
          // $schooldata=DB::table('trainers')->select('name','phone')->where('id',$req->id)->first();
          
          // $mb=$schooldata->phone;
        
          //    $apikey = "YXPskaQxMk6oxtQcQbPo2Q";
          //    $apisender = "TOSAPP";
          //    $msg ="Hi ".$schooldata->name.",we have sent you a email for new password reset.Thank You.";
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
           //echo '<br/><br/>';
          // print($data); /* result of API call*/
          echo "Email  Sent Successfully";     
   }
   public function trainerpasswordreset(Request $req)
   {
               $data = array('email'=>$req->email);
               return view('Trainer.passwordresetpage',compact('data'));
   } 
   public function tainernewpassword(Request $req)
   {
       $req->validate([
                'password'        =>  'required|required_with:password_confirmation|same:password_confirmation',
                'password_confirmation'        =>  ''
            ]);
          $userEmail=base64_decode(urldecode($req->hemail));

          $password = bcrypt($req->password);
        
        
        if( DB::table('users')->where('email',$userEmail)->exists())
        {
            DB::table('trainers')
                     ->where('email',$userEmail)
                     ->limit(1)
                     ->update(array('status'=>'1'));
          DB::table('users')
                 ->where('email', $userEmail)  
                 ->limit(1)  
                 ->update(array('password' => $password)); 
          return redirect('/trainerlogin'); 
        }
         return redirect('trainerpasswordreset')->with('failure', 'something is wrong.'); 
   }



    public function forgetpasswordemail()
    {
        return view('admin.Trainer.fpemail');
    }
 public function checkemail(Request $request)
    {
      $data= $request->all();
       $request->validate([
            'email'             => 'required|email',
        ],[
        'studentemail.required' => 'Please enter the email.',
         ]);
        
        try{
           $check =  User::where('email',$data['email'])->where('role',3)->get()->count();

          if($check)
          {
            $name = User::where('email',$data['email'])->first()->name;
            $data = array('email'=>$data['email'],'name'=>$name);
            // dd($data);
            Mail::send('Mail.passwordresetmail', $data, function($message) use($data) {
            $message->to($data['email'])->subject
              ('Welcome Aboard | F1 in Schools™ India');
         $message->from('noreply@timeofsports.com','F1 in Schools™ India');
            });
 
            if(count(Mail::failures()) > 0)
            {
             return redirect()->back()->with('error','Email is not sent');   
            }
             return redirect()->back()->with('success','Password reset link is sent to your email.');
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

    public function toresetpassword($email)
    {  //dd($email);
      $data = base64_decode(urldecode($email));
    
      return view('Trainer.fpresetpage',['data'=>$data]);
           
    }

    public function cpasswordreset(Request $request)
    {
      $data= $request->all();
      //base64_decode($data['hemail'])
      //dd($data);
      $request->validate([
            'password'   => 'required_with:repassword|same:repassword',
            'repassword' => 'required'
        ],[
        'password.required'    => 'Please Enter the password.',   
        'repassword.required'  => 'Repassword should be same.',
         ]);
          // dd($data);

        try
        {
          $status= User::where('email',base64_decode($data['hemail']))->update(['password'=>Hash::make($data['password'])]);
          if($status)
          {
           return redirect('/trainerlogin');
          }
          else{
            return redirect()->back()->with('erorr','Password is not reset.'); 
          }
        }catch(\Exception $e){
         return redirect()->back()->with('erorr','Something is Wrong.');
       }

    }


    public function trainerlogin()
    {
      return view('Trainer.trainerlogin');
    }



    public function trlogin(Request $req)
    {
          $credentials = $req->only('email', 'password');

        if (Auth::attempt($credentials)) {
                $email=Auth::user()->email;
                $role=Auth::user()->role;

                 if($role==3)
                 {

                  $check=Trainer::where('email',$email)->first();
                  if($check->status==1)
                  {
                    
                    
                      return redirect('/atrainer');
                   
                  }
                  else
                  {
                       Auth::logout();  
                $req->session()->flash('danger','Your account has been disabled by Time of Sports. Kindly contact f1s@timeofsports.com');
                return redirect('/trainerlogin');
                  }  
                
              }
              else
              {

                Auth::logout();  
                $req->session()->flash('danger','Permission Denied Please Check Your Url....');
                return redirect('/trainerlogin');
              }


}

else
{
    Auth::logout(); 
    $req->session()->flash('danger','These credentials do not match our records.'); 
                return redirect('/trainerlogin');
}


    }



public function trlogout(Request $request)
{

    Auth::logout();
    Session::flush();
    return redirect('/trainerlogin');
}
 

public function view_trainer($schoolid)
{
    $school_name = School::where('id',base64_decode($schoolid))
                   ->first()->school_name??'N/A';  
    $trainer = SchoolTrainer::
               where('school_id',base64_decode($schoolid))
               ->orderby('id','DESC')
               ->get();
    foreach ($trainer as $key => $value) 
    { 
      $check =Trainer::where('id',$value->trainer_id)->count();
      if($check!=0){
      $trainer[$key]->name = Trainer::where('id',$value->trainer_id)->first()->name??'N/A';
      $trainer[$key]->email = Trainer::where('id',$value->trainer_id)->first()->email??'N/A';
      $trainer[$key]->phone = Trainer::where('id',$value->trainer_id)->first()->phone??'N/A';
      $trainer[$key]->status = Trainer::where('id',$value->trainer_id)->first()->status??'N/A';
      }
      else
      {
        // SchoolTrainer::where('trainer_id',$value->trainer_id)->delete();
      }
    }
// dd($trainer);
    return view('admin.Trainer.Trainer_available_in_school',compact('trainer','school_name'));                         
}

}
