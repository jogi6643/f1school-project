<?php

namespace App\Http\Controllers;

use App\Course;
use App\DocType;
use App\CourseMaster;
use Illuminate\Http\Request;
use Auth;
use App\Model\AssignedCoursetype;

class CourseController extends Controller
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
			 
			  if(!isset($req->session()->all()['data'][5]))
				{
					$req->session()->flash('status','You do not have right to access this module');
					
					return redirect('/');
				}		 
			}
			
        $eq=Course::with('type','csm')->get();
	
        return view('admin.course',compact('eq'));
        // dd($eq);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $dtype=DocType::all();
        $csm=CourseMaster::all();
        return view('admin.coursecr',compact('dtype','csm'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $r)
    {
      
        $d='';
        $r->validate(['title'=>'required','doc_types_id'=>'required','description'=>'required','course_masters_id'=>'required'],['course_masters_id.required'=>'The Course Name field is required.','doc_types_id.required'=>'The Document type field is required','mailcontent.required'=>'The Mail Content type field is required']);
        if($r->doc_types_id==1)
            $r->validate(['doc_path'=>'required|mimes:pdf|max:10000']);
        elseif($r->doc_types_id==2)
            $r->validate(['video_path'=>'required']);
        else{
             $r->validate(
        	[
            'doc_path'=>'required|mimes:pdf|max:10000',
        	'video_path'=>'required'
            ]
           );
        }

        $data = $r->except('_token');
       

        if($r->hasFile('doc_path')){            
            $fname=time().".".$r->file('doc_path')->getClientOriginalExtension();
            $pp=public_path('docs/');
            if($r->file('doc_path')->move($pp,$fname))
                $data['doc_path']=$fname;
        }
        
         if($r->hasFile('thumbnail')){            
            $thubnailname=time().".".$r->file('thumbnail')->getClientOriginalExtension();
            $th=public_path('docs/');
            if($r->file('thumbnail')->move($th,$thubnailname))
                $data['thumbnail']=$thubnailname;
        }

        
        $d=Course::insert($data);
        if($d)
            return redirect('course')->with('success','Record Saved.');
        else
            return redirect('course')->withErrors('Unable to save record.');
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function show($v)
    {
        $k=Course::with('type','csm')->find(base64_decode($v));
        return view('admin.coursev',compact('k'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function edit($v,Request $req)
    {
		if(Auth::user()->role==1)
			{
				
			}
			else
			{
			 
			  if(($req->session()->all()['data'][5]??0)!=1)
				{
					$req->session()->flash('status','You do not have right to access this module');
					
					return redirect('/');
				}		 
			}
        $k = Course::with('type','csm')->find(base64_decode($v));

        $dtype=DocType::all();
        $csm=CourseMaster::all();

        return view('admin.courseed',compact('k','dtype','csm'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function update(Request $r)
    {
    
         $d='';
        $r->validate(['title'=>'required','doc_types_id'=>'required','description'=>'required','course_masters_id'=>'required'],['course_masters_id.required'=>'The Course Name field is required.','doc_types_id.required'=>'The Document type field is required','mailcontent.required'=>'The Mail Content type field is required']);
         if($r->doc_types_id==1)
         {
            
         }
            // $r->validate(['doc_path'=>'mimes:pdf|max:10000']);
        elseif($r->doc_types_id==2)
            $r->validate(['video_path'=>'required']);
        else{
             $r->validate(
        	[
            // 'doc_path'=>'required|mimes:pdf|max:10000',
        	'video_path'=>'required'
            ]
           );
        }
        
        $data = $r->except('_token','cid');

       // $data['doc_path']='';
       // $data['thumbnail']='';

           if($r->hasFile('thumbnail')){            
            $thubnailname=time().".".$r->file('thumbnail')->getClientOriginalExtension();
            $th=public_path('docs/');
            if($r->file('thumbnail')->move($th,$thubnailname))
                $data['thumbnail']=$thubnailname;
        }
        if($r->hasFile('doc_path')){            
            $fname=time().".".$r->file('doc_path')->getClientOriginalExtension();
            $pp=public_path('docs/');
            if($r->file('doc_path')->move($pp,$fname))
                 $data['doc_path']=$fname;
             // echo 1;
             // die;
        }
         $count = AssignedCoursetype::where('course_masters_id', $r->cid)->count();
        if($count>0)
        {
        AssignedCoursetype::
        where('course_masters_id', $r->cid)
        ->update(['doc_types_id' => $r->doc_types_id]);
        }

        // if($r->video_path)
        //     $data['doc_path']='';
        
        $d=Course::where('id',$r->cid)->update($data);
            // dd(Course::where('id',$r->cid)->first());
        if($d)
            return redirect('course')->with('success','Record Saved.');
        else
            return redirect('course')->withErrors('Unable to save record.');
        
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function destroy($v)
    {
        $pk=Course::find(base64_decode($v));
        if($pk->delete())
            return redirect('course')->with('success','Record Deleted.');
        else
            return redirect('course')->withErrors('Unable to delete Record.');
    }
    public function getbycs($v)
    {
        $eq=Course::with('csm','type')->where('course_masters_id',base64_decode($v))->get();
        return view('admin.course',compact('eq'));
    }
}
