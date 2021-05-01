<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use DB;

use \cache;
use Auth;
use Session;
use App\Model\Plan;
use App\Model\Part;
use App\Model\Material;
use App\Model\Partplan;
use Illuminate\Database\QueryException;
use Maatwebsite\Excel\Facades\Excel;
use App\School;
use App\Model\ParticipateStudent;
use App\Studentinfo;
use App\Model\Sponser\SponserShip;
use App\Competition;
use App\Model\StudentModel\Team_Store;
use App\Membership;
use App\Course;

class PlanController extends Controller
{

public function addplan(Request $req)
{
	if(Auth::user()->role==1)
			{
				
			}
			else
			{
			
			  if(($req->session()->all()['data'][11]??0)!=1)
				{
					$req->session()->flash('status','You do not have right to access this module');
					
					return redirect('/');
				}		 
			}
	return view('admin.Plan.addplan');
}
public function addplans(Request $req)
{
	
	 
	   $req->validate(
            [
                'name'=>'unique:plans',
				],
				 [
                'name.unique'=>'The Plan Name has been exist',
              
            ]);
	$plan=new Plan();
	$plan->name=$req->name;
	$plan->manufacturing_cost=$req->manufacturing_cost;
	$plan->number=$req->number;
	$plan->level=$req->level;
	$plan->block_price=$req->block_price;
	$plan->save();
	return redirect('listplan');
}
public function listplan(Request $req)
{
	if(Auth::user()->role==1)
			{
				
			}
			else
			{
			 
			  if(!isset($req->session()->all()['data'][11]))
				{
					$req->session()->flash('status','You do not have right to access this module');
					
					return redirect('/');
				}		 
			}
	$plan=Plan::all();

	return view('admin.Plan.listplan',compact('plan'));
	
	
}
public function editplan($plan)
{
	$plan = Plan::find(base64_decode($plan));   
	return view('admin.Plan.editplan',compact('plan'));
}

public function editplanpost($plan,Request $req)
{
	try
	{
	$plan=base64_decode($plan);
	$plan=Plan::find($plan);
	$plan->name=$req->name;
	$plan->manufacturing_cost=$req->manufacturing_cost;
	$plan->number=$req->number;
	$plan->level=$req->level;
	$plan->status=$req->status;
	$plan->block_price=$req->block_price;
	$plan->save();
	}
	catch(\Illuminate\Database\QueryException $ex){
     		$errors1='Plan name Can not be duplicate';
      
  // Note any method of class PDOException can be called on $ex.
  }
  if(isset($errors1))
  {
	   $errors1='Plan name Can not be duplicate';
	   $req->session()->flash('errors1',$errors1);
  }
  else
  {
	  $success='Plan has been successfully updated';
	   $req->session()->flash('success', $success);
	  
  }
  
  return redirect('listplan');
	
		
}  
public function downloadplan(Request $req)
{
	 
	 $plan=Part::select('id','parts as --')->get()->toArray();
	 $material=Material::all();
	  
	$arr=$plan;
    foreach($arr as $key=>$arrs)
	{
		foreach($material as $materials)
		{
			$arr[$key][$materials->material]="";
		}
		
	}
	
	 ob_end_clean(); // this
         ob_start();
         return Excel::create('Price_Master', function($excel) use ($arr) {
            $excel->sheet('mySheet', function($sheet) use ($arr)
            {
                
                $sheet->fromArray($arr);
            });
         })->download('xlsx');
	 
}  
public function uploadprice(Request $req)
{


	   $path = $req->file('files')->getRealPath();
        $data = Excel::load($path)->get();
		Partplan::where('plan_id',$req->plan)->delete();
		
	    foreach($data as $key=>$datas1)
		{

			foreach($datas1 as $key=>$datas)
			{
				
				$ids=$datas1['id'];
				
			if($key!="id"&&$ids!=null)
			{
				
			
			 if($datas1[$key]!="")
			 { 
			 
			  $mat=Material::where('material',str_replace('_',' ',$key))->first();
			  
			   $partprize=new Partplan();
			   $partprize->part_id=$ids;
			   $partprize->material_id=$mat->id;
			   $partprize->price=$datas1[$key];
			   $partprize->plan_id=$req->plan;
			   $partprize->save();
			 }
			}
			}
			
		}

	
	return redirect('listplan')->with('success','Data Addedd Successfully');
}
public function viewplan(Request $req,$id)
{
	
	$i = explode("_",base64_decode($id));

	$planid = $i[1];
	$schoolid = $i[0]??0;
	// $schoolid=0;
	$part=Partplan::where('plan_id',$planid)->get();
	$arr=[];
	
	$plan = Plan::where('id',$planid)->first()??'N/A';
	
	$SchoolName = School::where('id',$schoolid)->first()->school_name??'N/A';
	
	 foreach($part as $key=>$parts)
	 {
		 
		 $part1=Part::where('id',$parts->part_id)->first();
		  $mat=Material::where('id',$parts->material_id)->first();
		 $arr[$key]['material']=$mat->material;
		  $arr[$key]['parts']=$part1->parts;
		  $arr[$key]['price']=$parts->price;
		
		 
	 }
	 
	 return view('admin.Plan.listplanprice',compact('arr','plan','SchoolName'));
}


public function view_meterial($id)
{
	
	$planid = base64_decode($id);
	// $schoolid = $i[0]??0;
	// $schoolid=0;
	$part = Partplan::where('plan_id',$planid)->get();

	$arr=[];
	

	$plan = Plan::where('id',$planid)->first()??'N/A';
	
	// $SchoolName = School::where('id',$schoolid)->first()->school_name??'N/A';
	
	 foreach($part as $key=>$parts)
	 {
		 
		 $part1=Part::where('id',$parts->part_id)->first();
		  $mat=Material::where('id',$parts->material_id)->first();
		 $arr[$key]['material']=$mat->material;
		  $arr[$key]['parts']=$part1->parts;
		  $arr[$key]['price']=$parts->price;
		
		 
	 }
	 
	
	 return view('admin.Plan.listplanprice1',compact('arr','plan'));
}


public function view_plan_student($student_id)
{
  
 
    $student_id = base64_decode($student_id);
    $studentname = Studentinfo::where('id',$student_id)->first()->name??'N/A';
    $schoolid = Studentinfo::where('id',$student_id)->first()->school_id??'N/A';
    $schoolname = School::where('id',$schoolid)->first()->school_name??'N/A';
    $studentplans = ParticipateStudent::where('student_id',$student_id)->get();
    if(count($studentplans)>0)
    {
     foreach ($studentplans as $key => $value) {
      $studentplans[$key]['planname'] = Membership::where('id',$value->planid)->first()->name??'N/A';
      $studentplans[$key]['fee_per_student'] = Membership::where('id',$value->planid)->first()->fee_per_student??'N/A';
     }
    }
    
     return view('admin.Student.viewstudentplan',compact('schoolname','studentname','studentplans'));
}

public function show_courses_student($planid)
{ 
	  
	  // $email = Auth::user()->email;
   //    dd($email);
   //    $studentname = Studentinfo::where('studentemail',$email)->first()->name??'N/A';
   //    $schoolid = Studentinfo::where('studentemail',$email)->first()->school_id??'N/A';
   //    $schoolname = School::where('id',$schoolid)->first()->school_name??'N/A';

	 $planid = base64_decode($planid);
     $course = Membership::where('id',$planid)->first()->course_list??'N/A';
     $title =[];
     foreach (explode(",", $course) as $key => $value) {
     	   $title [$key]['courseId'] = $value;
     	   $title [$key]['title'] = Course::where('id',$value)->first()->title??'N/A';
     	   $title [$key]['video_path'] = Course::where('id',$value)->first()->video_path??'N/A';
     	   $title [$key]['created_at'] = Course::where('id',$value)->first()->created_at??'N/A';    
     }
     
      return view('admin.Student.viewstudentcourse',compact('title'));
   

}

public function Sponsorship_student($student_id)
{
	 $student_id = base64_decode($student_id);
     $studentname = Studentinfo::where('id',$student_id)->first()->name??'N/A';
     $schoolid = Studentinfo::where('id',$student_id)->first()->school_id??'N/A';
     $schoolname = School::where('id',$schoolid)->first()->school_name??'N/A';
     $upload_by = $student_id."_".$schoolid;
	 $spo = SponserShip::where('uploadedby',$upload_by)->get();
	 if(count($spo)>0)
	 {
       foreach ($spo as $key => $value) {
       	    $spo[$key]['competitionname'] = Competition::where('id',$value->competition_id)->first()->Competition_name??'N/A';
       	    $spo[$key]['teamname'] = Team_Store::where('id',$value->competition_id)->first()->team_Name??'N/A';
       }
	 }

	  return view('admin.Student.viewsponsorship',compact('schoolname','studentname','spo'));
	 
}

}

