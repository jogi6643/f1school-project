<?php
namespace App\Http\Controllers\admin\Sponsership;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use \cache;
use Auth;
use Session;
use App\Model\Plan;
use App\Model\Part;
use App\Model\Material;
use App\Model\Partplan;
use App\Model\Assignpriceinschool;
use App\School;
use App\Model\Sponser\SponserShip;
use App\Model\Competition\Schoolteamcomp;
use App\Model\StudentModel\Team_Store;
use App\Model\StudentModel\StudentTeam_Role;
use App\Model\Competition\Competitionstore;
use App\Studentinfo;
class SponsershipadminController extends Controller
{
    public function sponsershipview(Request $req)
    {
      
       if(Auth::user()->role==1)
			{
				
			}
			else
			{
			 
			 //  if(!isset($req->session()->all()['data'][13]))
				// {
				// 	$req->session()->flash('status','You do not have right to access this module');
					
				// 	return redirect('/');
				// }		 
			}
			
     
        $s2 = SponserShip::get()->map(function ($data)
        {
            $data->teamName = isset(Team_Store::find($data->teamid)
                              ->team_Name) ? Team_Store::find($data->teamid)->team_Name : 'N/A';

            $data->Competition = isset(Competitionstore::find($data->competition_id)
                ->Competition_name) ? Competitionstore::find($data->competition_id)->Competition_name : 'N/A';

            $id = explode('_', $data->uploadedby);
            $stuid = $id[0];
            $scid = $id[1];

            $data->schoolname = isset(School::find($scid)->school_name) ? School::find($scid)->school_name : 'N/A';
$data->schoid = $scid;
            $data->uploadedby = isset(Studentinfo::find($stuid)->name) ? Studentinfo::find($stuid)->name : 'N/A';

            return $data;
        });

        return view('admin.Sponsorship.sponsorshipview',compact('s2'));

    }

    // Fetach Plan & School
    public function assignpicemaster(Request $req)
    {
		
		 if(Auth::user()->role==1)
			{
				
			}
			else
			{
			 
			  if(($req->session()->all()['data'][12]??0)!=1)
				{
					$req->session()->flash('status','You do not have right to access this module');
					
					return redirect('/');
				}		 
			}
			
       $price = Plan::where('status',1)->get();
        $school = School::where('status',1)->where('type','school')->get();
        return view('admin.Plan.assignprice', compact('price', 'school'));
    }
    // End Plan & School
    // Start Assign price to School
  public function assignpricetoschool(Request $req)
    {
       
        foreach ($req->school as $key => $value) {
			 $check = Assignpriceinschool::where('schoolid',$value)->where('status',1)->first();
             if($check==null)
             {
            $data = new Assignpriceinschool();
            $data->planid = $req->Price;
            $data->schoolid =$value;
            $data->status = 1;
            $data->save();

             }
             else
             {
              Assignpriceinschool::where('schoolid',$value)->update(array('status' => 0));
              $data = new Assignpriceinschool();
              $data->planid = $req->Price;
               $data->schoolid =$value;
               $data->status = 1;
               $data->save();
             }   
        }
        $arr = array('msg' => 'Price Assign  Added Successfully!', 'status' => true);
        return Response()->json($arr);
    }
    // End  Assign Price to School
    

      public function viewpriceassignschool(Request $req)
    {
		if(Auth::user()->role==1)
			{
				
			}
			else
			{
			 
			  if(!isset($req->session()->all()['data']))
				{
					$req->session()->flash('status','You do not have right to access this module');
					
					return redirect('/');
				}		 
			}
        $p=Assignpriceinschool::get();  
         foreach($p as $key => $value) {
            $p[$key]['planname'] = Plan::where('id',$value->planid)->first()->name;
            $p[$key]['manufacturing_cost'] = Plan::where('id',$value->planid)->first()->manufacturing_cost;
            $p[$key]['number'] = Plan::where('id',$value->planid)->first()->number;
            $p[$key]['level'] = Plan::where('id',$value->planid)->first()->level;
            $p[$key]['block_price'] = Plan::where('id',$value->planid)->first()->block_price;
            $p[$key]['schoolname'] = School::where('id',$value->schoolid)->first()->school_name;

         }
         
            return view('admin.Plan.viewschoolprice',compact('p'));
    }

    
}

