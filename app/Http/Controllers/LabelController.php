<?php

namespace App\Http\Controllers;
//use Spatie\Activitylog\Models\Activity;
use Illuminate\Http\Request;
use App\Label;
use DB;
use App\Labelmodule;
use App\Module;
use Illuminate\Database\QueryException;
use Excel;
use Auth;
class LabelController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
	public function listrole(){
	    if(Auth::user()->role==1){
		 // \LogActivity::addToLog('View Lable');
        
		  
		$label=new Label();
		$label=$label->orderBy('name','asc')->get();
		foreach($label as $key=>$lables){
			$data=Labelmodule::select('module_id')->where('label_id',$lables->id)->get()->toArray();
			
		
			$data=Module::select('name')->whereIn('id',$data)->get()->toArray();
			
			$label[$key]['label']=implode(',',array_column($data,'name'));
		}

		return view('admin.Label/listlabel',compact('label'));
	    }
	}
	public function addrole(){
	      if(Auth::user()->role==1){
		// \LogActivity::addToLog('Add Lable');
		 
		return view('admin.Label/addlabel');
	      }
	}
	public function saverole(Request $req){
	      if(Auth::user()->role==1){
		
		try{
			 //\LogActivity::addToLog('Lable Creation Success');
		  $label=new Label();
          $label->name=$req->name;
	      $label->save();
		  $req->session()->flash('status', 'Role Added');
			 }
			 catch (QueryException $e){
				  $error_code = $e->errorInfo[1];
				
        if($error_code == 1062){
			 //\LogActivity::addToLog('Label Creation faild due to duplicacy');
			//activity()->log('Label Creation faild due to duplicacy');
           // self::delete($lid);
             $req->session()->flash('status', 'Duplicate Entry not allowed');
			 }
			 }
	  return redirect('listrole');
	      }
		
	
	}
	
    public function rolemodule($id){
		
          if(Auth::user()->role==1){
			 
    $xmldata = simplexml_load_file("module.xml") or die("Failed to load");
	
		//\LogActivity::addToLog('Label Edit Page see');
		//activity()->log('Label Edit Page see');
		$id=base64_decode($id);
		$module['module']=$xmldata;
		$module['status']=DB::select(DB::raw("select  status  from labels where id={$id}"))[0]->status;
		
		$module['selected']=DB::select(DB::raw("select  *  from  labe_module where label_id={$id}"));
		foreach($module['selected'] as $key=>$selected){
			$arr[$key]=$selected->module_id;
		
			$arr1[$selected->module_id]['functions']=$selected->functions;
		}
		 if(isset($arr)>0){
		$module['selected']=$arr;
		 }
		 if(isset($arr1)>0){
		$module['sel']=$arr1;
		 }
		
		$module['id']=$id;
	     
		return view('admin.Label/editlabel',compact('module'));
          }
	}
	
	public function editrolemodule(){
	
	      if(Auth::user()->role==1){
	       
	//	\LogActivity::addToLog('Label edited ');
	//	activity()->log('Label edited ');
		$module['module']=DB::select(DB::raw("select  *  from  labe_module"));
		Labelmodule::where('label_id',$_POST['id'])->delete();
               if(isset($_POST['module_id'])){
		foreach($_POST['module_id'] as $module){
			
			$label=new Labelmodule();
			$label->label_id=$_POST['id'];
			$label->module_id=$module;
		
			$label->functions=isset($_POST[$module.'_function'])?$_POST[$module.'_function']:0;
		
			$label->save();
		
		}
		 $new=Label::find($_POST['id']);
		 $new->status=$_POST['status'];
		 $new->save();
}
         
		//return redirect('label_define_module/'.$_POST['id']);
        return redirect('listrole');
	      }
	}
 public function labeldetail($id)
 {
       if(Auth::user()->role==1){
	 $label=Label::where('id',$id)->first();
	 return $label;
       }
 }
	
	
}
