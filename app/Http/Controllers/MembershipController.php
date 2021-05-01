<?php

namespace App\Http\Controllers;

use App\Membership;
use App\Course;
use Illuminate\Http\Request;
use Auth;
use DB;
use App\Participatestudent;
use App\Model\AssignedCoursetype;
use App\Model\Assigneddatetable;
use App\Schoolmasterplan;
class MembershipController extends Controller
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
             
              if(!isset($req->session()->all()['data'][7]))
                {
                    $req->session()->flash('status','You do not have right to access this module');
                    
                    return redirect('/');
                }        
            }
            

        $eq = Membership::
              orderBy('id','DESC')
              ->get();
             
      
    
        foreach($eq as $k=>$q){

            $l1=explode(",",$q->course_list);
            
            $cn=Course::whereIn('id',$l1)->select('title')->get()->toArray();
            
            
            $res = implode(",", array_column($cn, 'title'));
            $eq[$k]->course_list = $res;
            //$a=array($q,'res'=>$res);
            //dd($a);
            //$asd= $res);
            // dd($res);
            //print_r(in_array("title",$cn));
            // print_r($asd);
            // dd($cn);
            //$eq['courses']=$res;
        }
        return view('admin.membership',compact('eq'));
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
             
              if(($req->session()->all()['data'][7]??0)!=1)
                {
                    $req->session()->flash('status','You do not have right to access this module');
                    
                    return redirect('/');
                }        
            }
        $cs=Course::with('type','csm')->get();
        // dd($cs);
        return view('admin.membershipcr',compact('cs'));
    }

    public function activitysrch($v)
    {
        echo $v;
        // $nv=
        $ab=Course::where('title','like','%'.$v.'%')->get();

        return view('datas.courselist',compact('ab'));
        // dd($ab);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $r)
    {
        
        $P = array_filter($r->Priortity); 
        

      
        $r->validate(['name'=>'required']);
        
        if(!isset($r->name) && !isset($r->fee_per_student))
        {
          return redirect()->back();
        }
        $ab=implode(",",$r->courselist);
        $Priortity = implode(",",$P);

        $mb=new Membership();
        $mb->name=$r->name;
        $mb->fee_per_student=$r->fee_per_student;
        $mb->course_list=$ab;
        $mb->priorty_set=$Priortity;
        $mb->academicyear=$r->academicyear;
        if($mb->save())
            return redirect('membership')->with('success','Record Saved.');
        else
            return redirect('membership')->withErrors('Unable to save record.');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Membership  $membership
     * @return \Illuminate\Http\Response
     */
    public function show(Membership $membership)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Membership  $membership
     * @return \Illuminate\Http\Response
     */
    public function edit($v)
    {
           $k=Membership::find(base64_decode($v));
           // dd($k);
        // $table = DB::table('participantstudents')->where('schoolid', 2)->where('planid',31)
        //         ->where('year', '2020-2021')->delete();
        
           // $k=Membership::where('id',base64_decode($v))->delete();
           // dd(1);
           // Assigneddatetable::where('Plan_id',base64_decode($v))->delete();
           // Schoolmasterplan::where('plan',base64_decode($v))->delete();
           // AssignedCoursetype::where('Plan_id',base64_decode($v))->delete();
           // Participatestudent::where('planid',base64_decode($v))->delete();
           // die;

            $course =  Course::get()->toArray();
             $course_id = implode(",", array_column($course, 'id'));

             $array3 = explode(",", $course_id);

            
             $array2 = explode(",",$k->course_list);

            
             $id_match =  array_intersect($array3,$array2);
             
             $cs = array_values($id_match);

             $priorty_set = explode(",",$k->priorty_set);
              
    
            $array1 = Course::whereIn('id',$array3)->select('id','title')->get()->toArray();
            // dd($array1);
        // $cs=Course::with('type','csm')->get();
        // dd($cs);
        // if($v)
        return view('admin.membershiped',compact('k','cs','array1','priorty_set'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Membership  $membership
     * @return \Illuminate\Http\Response
     */
    public function update(Request $r)
    {
        
        $r->validate(['courselist'=>'required']);
    if(!isset($r->name) && !isset($r->fee_per_student))
        {
          return redirect()->back();
        }
        $ab=implode(",",$r->courselist);
        $P = array_filter($r->Priortity);
        
       
            // Membership::where('id',$r->Planid)
            //     ->where('academicyear',$r->academicyear)
            //     ->delete();
            // $Priortity1 = implode(",",$P);
            // $affectedRows = new Membership();
            // $affectedRows->name = $r->name;
            // $affectedRows->fee_per_student = $r->fee_per_student;
            // $affectedRows->course_list = $ab;
            // $affectedRows->priorty_set = $Priortity1;
            // $affectedRows->academicyear = $r->academicyear;
            // $affectedRows->save();

              // $check =  Membership::where('id',$r->Planid)
              //    ->where('academicyear',$r->academicyear)
              //    ->count();
          
        // if($check==0)
        // {
        //       $Priortity1 = implode(",",$P);

        //     $affectedRows = new Membership();
        //     $affectedRows->name = $r->name;
        //     $affectedRows->fee_per_student = $r->fee_per_student;
        //     $affectedRows->course_list = $ab;
        //     $mb->priorty_set = $Priortity1;
        //     $affectedRows->academicyear = $r->academicyear;
        //     $affectedRows->save();
        // }
        // else
        // {
             
             // $Priortity = implode(",",$P);

             // $affectedRows = Membership::
             //             where('id', $r->Planid)
             //             ->update(array(
             //             'name'=>$r->name,
             //             'fee_per_student'=>$r->fee_per_student,
             //             'course_list'=>$ab,
             //             'priorty_set'=>$Priortity,
             //             'academicyear'=>$r->academicyear
             //          )); 


        // }    
    
/*New Code Start Hear*/
  
  $Priortity = implode(",",$P);

             $affectedRows = Membership::
                         where('id', $r->Planid)
                         ->update(array(
                         'name'=>$r->name,
                         'fee_per_student'=>$r->fee_per_student,
                         'course_list'=>$ab,
                         'priorty_set'=>$Priortity,
                         'academicyear'=>$r->academicyear
                      )); 
           /*Start No Student participate */
      $pri = Membership::where('id',$r->Planid)->first()->priorty_set;
      $priorty_set = explode(',',$pri); 
      $cour = Membership::where('id',$r->Planid)->first()->course_list;
      $course_list2 = explode(',',$cour); 
           
       $schoolplan = Schoolmasterplan::where('plan',$r->Planid)
                ->where('year',$r->academicyear)->get();
        $ParticipateStudent = Participatestudent::
                                where('year', $r->academicyear)
                                ->where('planid', $r->Planid)
                                ->get();

    /*Assign Participant Student in Plan*/
    if(count($ParticipateStudent)>0)
       {
         AssignedCoursetype::
                    where('acyear',$r->academicyear)
                    ->where('Plan_id',$r->Planid)
                    ->delete();
         Assigneddatetable::
                    where('acyear',$r->academicyear)
                    ->where('Plan_id',$r->Planid)
                    ->delete();  

                       

    foreach( $ParticipateStudent as  $studentid1)
       {  
           $i=0;
          foreach ($course_list2 as $key => $course_id) {
            
               /**********************************/
              /*START ASSIGN COURSE TYPE STORE DATA*/ 

               $assigned=new AssignedCoursetype();
               $assigned->doc_types_id = Course::where('id',$course_list2[$i])
                                         ->first()->doc_types_id;
               $assigned->course_masters_id = $course_list2[$i];
               $assigned->student_id = $studentid1->student_id;
               $assigned->school_id = $studentid1->schoolid;
               $assigned->Plan_id = $r->Planid;
               $assigned->acyear = $r->academicyear;
               $assigned->priority_set = $priorty_set[$i];
               $assigned->assigneddate = '12-12-1993';
               $assigned->edited_by = Auth::user()->id;
               $assigned->save();


               /************Assigened Course Type **************/

               /*Start Assigneddatetable */
               $assigned_date = new Assigneddatetable();
               $assigned_date->doc_types_id = Course::where('id',$course_list2[$i])
                                         ->first()->doc_types_id;
               $assigned_date->course_masters_id = $course_list2[$i];
               $assigned_date->Plan_id = $r->Planid;
               $assigned_date->acyear = $r->academicyear;
               $assigned_date->school_id = $studentid1->schoolid;
               $assigned_date->priority_set = $priorty_set[$i];
               $assigned_date->assigneddate = '12-12-1993';
               $assigned_date->edited_by = Auth::user()->id;
               $assigned_date->save();
               /*End Assigneddatetable */
                $i = $i+1;
              } 
              } 
           
           if(count($schoolplan)>0)
           {
                Assigneddatetable::
                   where('acyear',$r->academicyear)
                    ->where('Plan_id',$r->Planid)
                    ->delete();
            foreach ($schoolplan as $key => $value) 
            {
                $j = 0;
                foreach ($course_list2 as $key => $course_id) {
                $assigned_date = new Assigneddatetable();
               $assigned_date->doc_types_id = Course::where('id',$course_list2[$j])
                                         ->first()->doc_types_id;
               $assigned_date->course_masters_id = $course_list2[$j];
               $assigned_date->Plan_id = $value->plan;
               $assigned_date->acyear = $r->academicyear;
               $assigned_date->school_id = $value->schoolid;
               $assigned_date->priority_set = $priorty_set[$j];
               $assigned_date->assigneddate = '12-12-1993';
               $assigned_date->edited_by = Auth::user()->id;
               $assigned_date->save();
               $j = $j+1;

          }
            }

           }


              } 
              else
              {
        if(count($schoolplan)>0)
           {
                Assigneddatetable::
                   where('acyear',$r->academicyear)
                    ->where('Plan_id',$r->Planid)
                    ->delete();
            foreach ($schoolplan as $key => $value) 
            {
                $j = 0;
                foreach ($course_list2 as $key => $course_id) {
                $assigned_date = new Assigneddatetable();
               $assigned_date->doc_types_id = Course::where('id',$course_list2[$j])
                                         ->first()->doc_types_id;
               $assigned_date->course_masters_id = $course_list2[$j];
               $assigned_date->Plan_id = $value->plan;
               $assigned_date->acyear = $r->academicyear;
               $assigned_date->school_id = $value->schoolid;
               $assigned_date->priority_set = $priorty_set[$j];
               $assigned_date->assigneddate = '12-12-1993';
               $assigned_date->edited_by = Auth::user()->id;
               $assigned_date->save();
               $j = $j+1;

          }
            }

           }
              }



              /*School Plan Master*/

           
    
        // $check = AssignedCoursetype::where('Plan_id',$r->Planid)->get();
         // $check = Assigneddatetable::where('Plan_id',$r->Planid)->get();
        if($affectedRows)
            return redirect('membership')->with('success','Record Updated.');
        else
            return redirect('membership')->withErrors('Unable to Record Updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Membership  $membership
     * @return \Illuminate\Http\Response
     */
    public function destroy($v)
    {
        $ar=Membership::find(base64_decode($v));
        if($ar)
            if($ar->delete())
                return redirect('membership')->with('success','Record deleted.');
            
                return redirect('membership')->withErrors('Unable to delete record.');
    }
}
