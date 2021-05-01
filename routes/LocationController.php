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

     public function __construct()
    {
        $this->middleware('is_admin');
    }
    
    public function index(Request $req)
    {

     $eq = DB::table('locations')
            ->where('Zone_id', '!=','')
           ->groupBy('locations.Zone_id')

           ->get();
        return view('admin.location',compact('eq'));
    }




public function zone_list(Request $request){
        // return $request->zone_id;
        $result = DB::table('locations')
       ->where('Zone_id', $request->zone_id)
       ->leftjoin('tbl_state','locations.state','=','tbl_state.id')
       ->leftjoin('tbl_city','locations.city','=','tbl_city.id')
       ->select('locations.*','tbl_state.name as state_name','tbl_city.name as city_name')
       ->get();
       return $result;
   }

    public function create()
    {
        $loc=States::all();
       $zone=Location::all();
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
 $zone=Location::select('zone_id')->orderby('id','desc')->first();


    if($zone->zone_id==null)
    {
   
      $zoneid="zoneid"."_".sprintf("%'.05d", 1);
    
    }
    else
    {
        $orderbreak=explode("_",$zone->zone_id);
      
         $zoneid="zoneid"."_".sprintf("%'.05d", $orderbreak[1]+1);
       
    }
// dd($zoneid);

if(count($req->state)>0){
  foreach ($req->state as $state) {
    foreach ($req->city as $city) {

        $ab =City::where('state_id',$state)->where('id',$city)->get()->first();
        if($ab!=[])
         {
           
             $lo=new Location();
             $lo->Zone_id=$zoneid;
             $lo->zone=$req->zone;
             $lo->state=$state;
             $lo->city=$city;
             $lo->status=1;
             $lo->save();

         }
        
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
        ->join('locations','locations.id','=','schools.zone')
        ->select('locations.zone as zonename','tbl_state.name as statename' ,'tbl_city.name as cityname','school_name','schools.created_at','schools.updated_at')->where('schools.zone',base64_decode($v))->get();

        

         
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
            ->where('locations.id','=',$v)
            ->select('locations.*','tbl_state.name as state_name','tbl_city.name as city_name')->first();
// dd($lp);
        $loc=States::all();
        if($lp)
        return view('admin.locationed2',compact('lp','loc'));
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
        $up=Location::find($r->lid);

        if($up){
            $up->zone=$r->zone;
            $up->state=$r->state;
            $up->city=$r->city;
            $up->status=1;
            $up->save();
            $up1=Location::find($r->lid)->Zone_id;
           
            Location::where('Zone_id', $up1)
            ->update(['zone' => $r->zone]);

            if($up->wasChanged())
                return redirect('location')->with('success','Record updated.');
            else
                return redirect('location')->withErrors('Unable to update record.');

        }
        else
        {
            return redirect()->back()->withErrors("Unable to update record.");
        }
        }catch (QueryException $e){
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
        $city=City::whereIn('state_id',explode(",",base64_decode($v)))->get();
        return view('datas.city',compact('city'));
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
