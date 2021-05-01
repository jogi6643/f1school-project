<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Coadmin;
use App\Label;

use App\Events\Coadmins;
use Auth;
use Mail;
use App\User;
use Session;
use Hash;
class CoadminController extends Controller
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
        $eq=Coadmin::all();

        foreach($eq as $key=>$reqs)
        {
            $eq[$key]->assignedrole=isset(Label::where('id',$reqs['role'])->first()['name'])?Label::where('id',$reqs['role'])->first()['name']:"";
        }
   
        // Alert::info('Your profile is up to date', 'Wonderful!');
    
      
        return view('admin.Coadmin.coadmin',compact('eq'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::user()->role==1)
        {
          return view('admin.Coadmin.addcoadmin');
        }
    }

    /**
     * Store a newly created resource in storage.
     *s
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


$request->validate(['name'=>'required|regex:/^[\pL\s\-]+$/u','phone'=>'required|min:10|numeric','email'=>'required|unique:coadmins'],
        ['name.required'=>'Coadmin Name field is required.','email.required'=>'Coadmin Email field is required','phone'=>'Coadmin phone field is required','email.unique'=>'This email already exsists.']

     );
        if(Auth::user()->role==1)
        {

          try{
       // $request->validate(['name'=>'required','phone'=>'required','email'=>'required|unique:coadmins'],['name.required'=>'Coadmin Name field is required.','email.required'=>'Coadmin Email field is required','phone'=>'Coadmin phone field is required','email.unique'=>'This email already exsists.']);
         $coadmin=Coadmin::insert($request->except('_token'));
          $coadmin=Coadmin::orderby('id','desc')->first();
		  
         $user=new User();
         $user->name=  $coadmin->name;
         $user->email=  $coadmin->email;
         $user->role=2;
         $user->password=bcrypt($coadmin->email);
         $user->save();
		
         $data=array("name"=>  $coadmin->name,'password'=>strtolower($coadmin->name).$coadmin->id,'email'=>  $coadmin->email);
         
         //  Mail::send('Mail.coadminresetpassword', $data, function($message) use($data) {
         // $message->to($data['email'], 'noreply@f1inschoolsindia.com')->subject
         //    ('Welcome Aboard | Season 3 | F1 in Schools™ India');
         // $message->from('noreply@f1inschoolsindia.com','F1School');
         // });

         return redirect('coadmin')->with('success','Record Saved.');
		  }
		  catch(\Exception $e)
		  {
			
			  
			  return redirect('coadmin')->with('error',"Email Already Exsist");
		  }
        }
    }


public function invite_coadmin($id)
{
  $coadmin=Coadmin::where('id',base64_decode($id))->first();

  $data=array("name"=>  $coadmin->name,'password'=>strtolower($coadmin->name).$coadmin->id,'email'=>  $coadmin->email);
         
          Mail::send('Mail.coadminresetpassword', $data, function($message) use($data) {
         $message->to($data['email'])->subject
            ('Welcome Aboard | F1 in Schools™ India');
         $message->from('noreply@timeofsports.com', 'F1 in Schools™ India');
         });

          Coadmin::where('id', base64_decode($id))->update([ 'status' => 2 ]);

         return redirect('coadmin')->with('success','Invitation sent.');
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
    public function edit(Coadmin $tariner,$v)
    { 
        if(Auth::user()->role==1)
        {
        $k = Coadmin::find(base64_decode($v));
        $label=Label::where('status',1)->get();
        return view('admin.Coadmin.editcoadmin',compact('k','label'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Competition  $competition
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        if(Auth::user()->role==1)
        {
        $id=base64_decode($id);
     
$request->validate(['name'=>'required|regex:/^[\pL\s\-]+$/u','phone'=>'required|min:10|numeric']
        // ['name.required'=>'Coadmin Name field is required.','email.required'=>'Coadmin Email field is required','phone'=>'Coadmin phone field is required','email.unique'=>'This email already exsists.']

     );
          try
          {
          $d=Coadmin::where('id',$id)->update($request->except('_token'));
            if($d)
            return redirect('coadmin')->with('success','Record Saved.');
        else
            return redirect('coadmin')->withErrors('Unable to save record.');
          }
          catch (QueryException $e){
                  $error_code = $e->errorInfo[1];
                
       if($error_code == 1062){
             
            //activity()->log('Label Creation faild due to duplicacy');
          // self::delete($lid);
    
        
            return redirect('trainer')->withErrors('Email is already exists');;
             }
              //return redirect('tms_training');
             }
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
        if(Auth::user()->role==1)
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
    }
    public function  traineradd(Request $req,$id)
    {
        

        SchoolTrainer::where('trainer_id',base64_decode($id))->where('year',$req->year)->delete();
        foreach($req->school as $schools){
        $school=new SchoolTrainer();
        $school->trainer_id=base64_decode($id);
        $school->year=$req->year;
        $school->school_id=base64_decode($schools);
        $school->save();
    }
    
  
    
        $SchoolTrainerinfo=DB::table('trainers')->where('id',base64_decode($id))->first();
        foreach($req->school as $schools){
              $schoolinfo= DB::table('schools')->where('id',base64_decode($schools))->first()->email;
              $data=array("SchoolTrainerinfo"=> $SchoolTrainerinfo);
              Mail::send('Mail.trainerdetailsforschool', $data, function($message) use($data) {
              $message->to('jogi.amu@gmail.com', 'noreply@whitegarlic.in')->subject
                ('Welcome to F1school test');
              $message->from('noreply@whitegarlic.in','F1School');
      });
         //  Mail::send('Mail.coadminresetpassword', $data, function($message) use($data) {
         // $message->to($data['email'], 'noreply@f1inschoolsindia.com')->subject
         //    ('Welcome Aboard | Season 3 | F1 in Schools™ India');
         // $message->from('noreply@f1inschoolsindia.com','F1School');
         // });
    
    }
   
            $scid=[];
          foreach($req->school as $schoolid)
          {
             $scid[]=base64_decode($schoolid);
          }
          
          $schoolname=School::whereIn('schools.id',$scid)
          ->join('locations','locations.id','=','schools.zone')
          -> join('tbl_city','tbl_city.id','=','schools.city')
        ->select('schools.id','schools.school_name','locations.zone','tbl_city.name','schools.mobile','website')->get();
        
    
            $event2= DB::table('trainers')->where('id',base64_decode($id))->first();
              $data=array("trainer"=>$event2->name,'password'=>strtolower($event2->name).$event2->id,'email'=>$event2->email,'Schoolinfo'=>$schoolname);
              Mail::send('Mail.SchoolInfo', $data, function($message) use($data) {
              $message->to('jogi.amu@gmail.com', 'noreply@whitegarlic.in')->subject
                ('Welcome to F1school');
              $message->from('noreply@whitegarlic.in','F1School');
      });
      
      
      //event(new assigrntrainerE($req,base64_decode($id)));
       alert()->message('Sweet Alert with message.');
      $tr=Trainer::find(base64_decode($id));
      return redirect('trainer')->with('success',"School have been alloted Successfully Trainer ".$tr->name." Please Check Your Email" );
     
    }
    public function trainerschool()
    {
         $school=SchoolTrainer::where('trainer_id',base64_decode($_GET['trainer']))->where('year',$_GET['data'])->get();;
         
        echo json_encode($school);
    }


    public function coforgetpasswordemail()
    {
         return view('admin.coadminpassword');
    }




    public function Cocheckemail(Request $request)
    {
      $data= $request->all();
    
       $request->validate([
            'email'             => 'required|email',
        ],[
        'studentemail.required' => 'Please enter the email.',
         ]);
        
        try{
           $check =  User::where('email',$data['email'])->where('role',2)->get()->count();

          if($check)
          {
            $name = User::where('email',$data['email'])->first()->name;
            $data = array('email'=>$data['email'],'name'=>$name);
            // dd($data);
            Mail::send('Mail.coadminresetpassword', $data, function($message) use($data) {
            $message->to($data['email'])->subject
              ('Welcome Aboard | Season 3 | F1 in Schools™ India');
            $message->from('noreply@timeofsports.com','F1inSchool');
            });
 
            if(count(Mail::failures()) > 0)
            {
             return redirect()->back()->with('error','Email is not sent');   
            }
             return redirect()->back()->with('success','Password reset link is sent to your email.');
          }
          else
           {
            return redirect()->back()->with('error','Email is not Exists1.');
           }
        }catch(\Exception $e)
        {
          return redirect()->back()->with('error',$e->getMessage());
        }

    }

     public function cotoresetpassword($email)
    {  //dd($email);
      $data = base64_decode(urldecode($email));
      
      return view('admin.coadminpasswordrest',['data'=>$data]);
      // fpresetpage
           
    }

    public function coadmincpasswordreset(Request $request)

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
           return redirect('/login');
          }
          else{
            return redirect()->back()->with('erorr','Password is not reset.'); 
          }
        }catch(\Exception $e){
         return redirect()->back()->with('erorr','Something is Wrong.');
       }

    }

}
