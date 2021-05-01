<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CourseMaster;
use Auth;

class CourseMasterController extends Controller
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
			 
			  if(!isset($req->session()->all()['data'][6]))
				{
					$req->session()->flash('status','You do not have right to access this module');
					
					return redirect('/');
				}		 
			}
			
        $eq=CourseMaster::all();
        return view('admin.coursename',compact('eq'));
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
			 
			  if(!isset($req->session()->all()['data'][6]))
				{
					$req->session()->flash('status','You do not have right to access this module');
					
					return redirect('/');
				}		 
			}
        return view('admin.coursenamecr');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $r)
    {
        $r->validate(['course_name'=>'required|regex:/^[\pL\s\-]+$/u']);
        $data=$r->except('_token');
        if(CourseMaster::insert($data))
            return redirect('coursename')->with('success','Record Saved.');
        else
            return redirect('coursename')->withErrors('Unable to save record.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id,Request $req)
    {
		 if(Auth::user()->role==1)
			{
				
			}
			else
			{
			 
			  if(($req->session()->all()['data'][6]??0)!=1)
				{
					$req->session()->flash('status','You do not have right to access this module');
					
					return redirect('/');
				}		 
			}
			
        $k=CourseMaster::find(base64_decode($id));
        return view('admin.coursenameed',compact('k'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $r)
    {
        $r->validate(['course_name'=>'required']);
        $data=$r->except('_token','cid');
        $aa=CourseMaster::where('id',$r->cid)->update($data);
        if($aa)
            return redirect('coursename')->with('success','Record updated.');
        else
            return redirect('coursename')->withErrors('Unable to update record');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ak=CourseMaster::find(base64_decode($id));
        if($ak)
            if($ak->delete())
                return redirect('coursename')->with('success','Record deleted');
            else
                return redirect('coursename')->withErrors('Unable to delete record.');
        else
            return redirect('coursename')->withErrors('Record not found.');
    }
}
