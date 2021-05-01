<?php

namespace App\Http\Controllers;

use App\Location;
use App\States;
use App\City;
use DB;
use App\School;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Auth;
use Helper;
class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
 
    

     // $eq = DB::table('locations')
     //        ->where('Zone_id', '!=','')
     //        // ->where('status',1)
     //       ->groupBy('locations.Zone_id')
     //       ->get();

         $eq = DB::table('locations')
            ->where('Zone_id', '!=','')
            // ->where('status',0)
            ->groupBy('locations.Zone_id')
            ->orderBy('Zone_id', 'desc')
            ->get();
        return view('admin.location',compact('eq'));
    }




public function zone_list(Request $request){
        // return $request->zone_id;
        $result = DB::table('locations')
       ->where('Zone_id', $request->zone_id)
       ->where('status',1)
       ->leftjoin('tbl_state','locations.state','=','tbl_state.id')
       ->leftjoin('tbl_city','locations.city','=','tbl_city.id')
       ->select('locations.*','tbl_state.name as state_name','tbl_city.name as city_name')
       ->get();
       return $result;
   }

    public function create()
    {
        $loc=States::all();
        $zone = Location::groupby('zone')->get();
        return view('admin.locationed',compact('loc','zone'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $req)
    {
        
        // try{
         $req->validate(['zone'=>'required','state'=>'required','city'=>'required','status'=>'required']);
     

   $zonechech=Location::where('zone',$req->zone)->first(); 


if($zonechech==null)
{
    
 $zone=Location::select('zone_id')->orderby('zone_id','desc')->first();


    if($zone->zone_id==null)
    {
   
      $zoneid="zoneid"."_".sprintf("%'.05d", 1);
    
    }
    else
    {
         $orderbreak=explode("_",$zone->zone_id);
      
         $zoneid="zoneid"."_".sprintf("%'.05d", $orderbreak[1]+1);
       
    }


if(count($req->state)>0){

    foreach ($req->city as $city) {

        $ab =City::where('id',$city)->get()->first();
    
        if($ab!=[])
         {
           
             $lo=new Location();
             $lo->Zone_id=$zoneid;
             $lo->zone=$req->zone;
           
              $lo->state=$ab->state_id;
             $lo->city=$city;
              $lo->status=1;
             $lo->save();

         }
        
       }
   
     
    
     return redirect('location')->with('success','Record Saved.');

      }
     else
     {
     return redirect('location')->withErrors('Unable to save.');
     }
// die;
     }
     else
     {
         return redirect('location')->withErrors('Unable to save.');
     }


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function show($v)
    {
        // $id=base64_decode($v);
        // dd($id);
        $k=School::join('tbl_state','tbl_state.id','=','schools.state')
        ->join('tbl_city','tbl_city.id','=','schools.city')
        ->join('locations','locations.id','=','schools.zone')->
        select('locations.zone as zonename','tbl_state.name as statename' ,'tbl_city.name as cityname','school_name','schools.created_at','schools.updated_at')->where('schools.zone',base64_decode($v))->get();

        

         
        return view('admin.locationv',compact('k'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function edit($v)
    {
       
        // dd($v);
        // $lp=Location::find(base64_decode($v));
        $lp=DB::table('locations')
            ->leftjoin('tbl_state','locations.state','=','tbl_state.id')
            ->leftjoin('tbl_city','locations.city','=','tbl_city.id')
            ->where('locations.Zone_id','=',$v)
            ->where('status',1)
            ->select('locations.*','tbl_state.name as state_name','tbl_city.name as city_name')->get()->toArray();
          $state=array_column($lp,'state');
          $citys=array_column($lp,'city');
         
        $loc=States::all();
        $citites=DB::table('tbl_city')->select('tbl_state.name as names','tbl_city.*')->join('tbl_state','tbl_city.state_id','=','tbl_state.id')->whereIN('state_id',$state)->get();
        
         if($lp)
        return view('admin.locationed2',compact('lp','loc','state','citites','citys'));
        else
            return redirect('location')->withErrors('Request record not found.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function update(Request $r)
    {
        
        try{

        $up2 = Location::find($r->lid);
        $up1=Location::where('zone',$up2->zone)->update(['status'=>1]);

        if($up2!=null){
    $check =0;  
    
    if($r->city!=null)  
{
    foreach ($r->city as $city) {
      
        $ab =City::where('id',$city)->get()->first();
       $count = Location::where('Zone_id',$up2->Zone_id)
           ->where('city',$city)->where('state',$ab->state_id)->count();
         
        
        if($count==0)
         {
           
          $check = $check+1;
            $up=new Location();
            $up->zone=$r->zone;
            // $up->state=1;
            $up->city=$city;
             $up->Zone_id=$up2->Zone_id;
              $up->state=$ab->state_id;
              $up->status=1;
             $upz=$up->save();

         }
        
       }
   }
   else
   {
     return redirect()->back()->withErrors("Please Select States and  Cities  First.");
   }

   

            if($check!=0)
                return redirect('location')->with('success','Record updated.');
            else
                return redirect('location')->withErrors('Unable to update record.');

        }
        else
        {
            return redirect()->back()->withErrors("Unable to update record.");
        }
        }catch (QueryException $e){
            dd($e);
                  $error_code = $e->errorInfo[1];
                
       if($error_code == 1062){
             \LogActivity::addToLog('Try to insert duplicate Zone Name');
            //activity()->log('Label Creation faild due to duplicacy');
          // self::delete($lid);
    
            $req->session()->flash('status', 'Zone name can not be duplicate');
             }
              //return redirect('tms_training');
             }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function destroy($v)
    {
        $sd=Location::find(base64_decode($v));
        if($sd->delete())
            return redirect('location')->with('success','Record deleted.');
        else
            return redirect('location')->withErrors('Unable to delete record.');
    }

    public function getcitylist($v)
    {
         $lp=DB::table('locations')
            ->leftjoin('tbl_state','locations.state','=','tbl_state.id')
            ->leftjoin('tbl_city','locations.city','=','tbl_city.id')
            ->whereIN('locations.state',explode(",",base64_decode($v)))
            ->where('status',1)
            ->select('locations.*','tbl_state.name as state_name','tbl_city.name as city_name')->get()->toArray();
          $state=array_column($lp,'state');
          $citys=array_column($lp,'city');
        
       $city=City::select('tbl_state.name as names','tbl_city.*')->join('tbl_state','tbl_city.state_id','=','tbl_state.id')->whereIn('state_id',explode(",",base64_decode($v)))->get();
       
        return view('datas.citys',compact('city','citys'));
    }
    public function getcitylists($v,$v2)
    {
         $lp=DB::table('locations')
            ->leftjoin('tbl_state','locations.state','=','tbl_state.id')
            ->leftjoin('tbl_city','locations.city','=','tbl_city.id')
            ->whereIN('locations.state',explode(",",base64_decode($v)))
            ->where('status',1)
            ->where('Zone_id',$v2)
            ->select('locations.*','tbl_state.name as state_name','tbl_city.name as city_name')->get()->toArray();
          $state=array_column($lp,'state');
          $citys=array_column($lp,'city');
        
        $city=City::select('tbl_state.name as names','tbl_city.*')->join('tbl_state','tbl_city.state_id','=','tbl_state.id')->whereIn('state_id',explode(",",base64_decode($v)))->get();
        return view('datas.city',compact('city','citys'));
    }
    public function locationbyzone(Request $req)
    {
        $req->v;
        $ab=DB::table('locations')
            ->leftjoin('tbl_state','locations.state','=','tbl_state.id')
              ->groupby('tbl_state.name')
            ->distinct()
            ->where('locations.Zone_id','=',$req->v)->select('locations.*','tbl_state.name as state_name')->get();
            return $ab;
    }



    public function statebycity(Request $req)
    {
        
           $ab=DB::table('locations')
            ->leftjoin('tbl_city','locations.city','=','tbl_city.id')
            //   ->groupby('tbl_city.name')
            // ->distinct()
            ->where('locations.Zone_id','=',$req->z)->where('locations.state','=',$req->s)->select('locations.city as cityid','tbl_city.name')->get();
            return $ab;
    }
    public function zone_Active_inctive(Request $request)
    {

        Location::where('Zone_id', $request->zone_id)
            ->update(['status' => $request->status]);
       
  
        return response()->json(['success'=>'Status change successfully.']);
    }
}
