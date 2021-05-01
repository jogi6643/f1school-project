<?php
namespace App\Http\Controllers;
use App\Schoolmasterplan;
use App\School;
use App\Participatestudent;
use App\Location;
use Illuminate\Http\Request;
use DB;

class SchoolController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $eq=School::all();
          foreach($eq as $key=>$schools)
        {
            
        $zone=isset(DB::table('locations')->where('id',$schools->zone)->first()->zone)?DB::table('locations')->where('id',$schools->zone)->first()->zone:"";
        $state=isset(DB::table('tbl_state')->where('id',$schools->state)->first()->name)?DB::table('tbl_state')->where('id',$schools->state)->first()->name:"";
        $city=isset(DB::table('tbl_city')->where('id',$schools->city)->first()->name)?DB::table('tbl_city')->where('id',$schools->city)->first()->name:"";
         $eq[$key]->zone=$zone; 
        $eq[$key]->state=$state; 
         $eq[$key]->city=$city; 
        }
        return view('admin.school',compact('eq'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
// dd('1');
        $loc=DB::table('locations')
            // ->leftjoin('tbl_state','locations.state','=','tbl_state.id')
            // ->leftjoin('tbl_city','locations.city','=','tbl_city.id')
        ->groupby('Zone_id')
            ->distinct()
            ->get();

        return view("admin.schoolcr",compact('loc'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $r)
    {
        
        $r->validate(['school_name'=>'unique:schools','type'=>'required','address'=>'required',
            'zone'=>'required',
            'state'=>'required',
            'annual_fees'=>'numeric|nullable','mobile'=>'numeric|nullable',
            'principal_mobile'=>'numeric|nullable'


            ],['school_name.required'=>'The School/Collage Name field is required','mobile.numeric'=>'The School/Collage Phone field  must be a number.','principal_mobile.numeric'=>'The Principal Phone field  must be a number.']);
        $data=$r->except('_token');
        $aka=School::insert($data);
        if($aka)
            return redirect('school')->with('success','Rrecord Saved.');
        else
            return redirect('school')->withErrors('Unable to save Record.');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\School  $school
     * @return \Illuminate\Http\Response
     */
    public function show($v)
    {
        
        $k=School::find(base64_decode($v));

        $zone=isset(DB::table('locations')->where('Zone_id',$k->zone)->first()->zone)?DB::table('locations')->where('Zone_id',$k->zone)->first()->zone:"";
        $state=isset(DB::table('tbl_state')->where('id',$k->state)->first()->name)?DB::table('tbl_state')->where('id',$k->state)->first()->name:"";
        $city=isset(DB::table('tbl_city')->where('id',$k->city)->first()->name)?DB::table('tbl_city')->where('id',$k->city)->first()->name:"";
  
        return view('admin.schoolv',compact('k','zone','state','city'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\School  $school
     * @return \Illuminate\Http\Response
     */
    public function edit($v)
    {
        $r=School::find(base64_decode($v));
        
        // $loc=DB::table('locations')
        //     ->leftjoin('tbl_state','locations.state','=','tbl_state.id')
        //     ->leftjoin('tbl_city','locations.city','=','tbl_city.id')
        //     ->select('locations.*','tbl_state.name as state_name','tbl_city.name as city_name')->get();
         $loc=DB::table('locations')
          
        ->groupby('Zone_id')
            ->distinct()
            ->get();
        return view('admin.schooled',compact('r','loc'));
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

        $up=School::find($r->sid);
        if($up)
        {
            $data=$r->except('_token','sid');
            $ok=School::where('id',$r->sid)
                    ->update($data);
            if($ok)
                return redirect('school')->with('success','Record Updated.');
            else
               return redirect('school')->withErrors('Unable to update Record.'); 
        }
        else
            return redirect('school')->withErrors('Unable to update Record.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\School  $school
     * @return \Illuminate\Http\Response
     */
    public function destroy($v)
    {
        $kk=School::find(base64_decode($v));
        if($kk->delete())
            return redirect('school')->with('success','Record Deleted');
        else
            return redirect('school')->withErrors('Unable to delete record.');
    }
    
    public function schoolplanmaster($school)
    {
        
    
              $plans=DB::table('memberships')->get();
            
              $schoolname=DB::table('schools')->select('school_name')->where('id',base64_decode($school))->first();
              
              $planperschool=DB::table('memberships')
              ->join('schoolplanmaster','schoolplanmaster.plan','=','memberships.id')
              ->orderBy('year', 'DESC')
              ->select('*')->where('schoolid',base64_decode($school))->get();
              foreach( $planperschool as $key=>$plans1)
              {
                  $planperschool[$key]->counts=DB::table('participantstudents')->where('year',$plans1->year)->where('schoolid',$plans1->schoolid)->count();
              }
             
              return view('admin.schoolplanmaster',compact('plans','school','schoolname','planperschool'));
        
    }
    
    public function storeschoolplanmaster(Request $request)
    {
           $request->validate([
           'schoolid'=>'required',
            'plan'=>'required',
            'year'=>'required',
            ]);
            $count=0;
        foreach($request->plan as $planid)
            {
             $check=Schoolmasterplan::where('schoolid',$request->schoolid)->where('plan',$planid)
           
             ->where('year',$request->year)->first();
            if($check==null)
              {
                $count=$count+1;
            $plan=new Schoolmasterplan();
            $plan->schoolid=$request->schoolid;
             $plan->plan=$planid;
            $plan->year=$request->year;
            $plan->save();
              }
            }
            if($count!=0)
            {
             return redirect('schoolplanmaster/'.base64_encode($request->schoolid))->with('success','Rrecord Saved.');
            }
             if($count==0){
            return redirect('schoolplanmaster/'.base64_encode($request->schoolid))->withErrors('Data Already exist in database.');
           }
       
    }
    
    
    public function participanrshow()
    {
          $schoolmasterplan=DB::table('schoolplanmaster')
          ->join('schools','schools.id','=','schoolplanmaster.schoolid')
          ->join('students','students.school_id','=','schools.id')
          ->where('schoolid',$_GET['school_id'])->where('year',$_GET['year'])
          ->distinct('students.mobileno')
          ->select('students.id','students.name','students.mobileno','students.created_at')
          ->get();
          foreach($schoolmasterplan as $key=>$value)
          {
            $table=DB::table('participantstudents')->where('student_id',$value->id)->where('year',$_GET['year'])->where('planid',$_GET['planid'])->count();
            if($table>0)
            {
            $schoolmasterplan[$key]->check=1;
            }
            else{
            $schoolmasterplan[$key]->check=0;
            }
        }
           return $Response = array('schoolplan'=>$schoolmasterplan);

    }
    

public function menbershipsata()
{
    $plan=DB::table('schoolplanmaster')->where('schoolid',$_GET['school_id'])->where('year',$_GET['year'])
            ->join('memberships','memberships.id','=','schoolplanmaster.plan')
            ->select('memberships.id','memberships.name')
          ->get();
           return $Response = array('plan'=>$plan);
}


    public function participantlist($schooldp)
    {
        $students=DB::table('students')->where('school_id',base64_decode($schooldp))->get();
        $schoolname=DB::table('schools')->select('school_name')->where('id',base64_decode($schooldp))->first();
   
        return view('admin.participantlist',compact('students','schooldp','schoolname'));
    }
    
public function sbmitparticipant(Request $req)
    {
       
    $test=Participatestudent::where('schoolid',$req->schoolid)->where('planid',$req->planid)->where('year',$req->year)->delete();

// dd($test);
$count=0;
if($req->student!=null)
{
foreach($req->student as $studentspartici){
    $check=Participatestudent::where('schoolid',$req->schoolid)->where('student_id',$studentspartici)->where('year',$req->year)->get();
   
if(count($check)==0)
{
  $studentp=new Participatestudent();
        $studentp->schoolid=$req->schoolid;
        $studentp->planid=$req->planid;
        $studentp->student_id=$studentspartici;
        $studentp->year=$req->year;
        $studentp->save();
}
else
{

  $count=1;

}
      
     
    }
}

    else
    {
        return redirect('participantlist/'.base64_encode($req->schoolid))->with('danger','No students in the current plan.');
    }

if($count==0){

     return redirect('participantlist/'.base64_encode($req->schoolid))->with('success','Rrecord Saved.');
    }

  if($count==1){

     return redirect('participantlist/'.base64_encode($req->schoolid))->with('danger','This Student assign another Plan.');
    }
    
    }
     public function manufacturingapplication()
     {
         echo "Test";
     }
}
