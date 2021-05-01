<?php
namespace App\Http\Controllers;
use App\Schoolmasterplan;
use App\School;
use App\Participatestudent;
use App\Location;
use Illuminate\Http\Request;
use DB;
use App\Model\Manufacture\CarType;
use App\Model\Manufacture\Stcarbodypart;
use App\Model\Manufacture\Cardetailspayments;
use App\Model\Manufacture\Orederstaus;
use \cache;
use Auth;
use Session;
use App\Model\AssignedCoursetype;
use App\Model\Competition\Schoolteamcomp;
use App\Model\StudentModel\Team_Store;
use App\Model\StudentModel\StudentTeam_Role;
use App\Model\Plan;
use App\Model\Part;
use App\Model\Material;
use App\Model\Partplan;
use App\Model\Cartdetail;
use App\Model\Payment;
use App\Model\Student;
use App\Studentinfo;
use App\Model\Assignpriceinschool;
use Mail;
use PDF;
use Maatwebsite\Excel\Facades\Excel;
use App\Model\Competition\Competitionstore;
use App\Model\Teammember;

class ManufactureController extends Controller
{

    public function manufacturingapplication(Request $req)
    {
		if(Auth::user()->role==1)
			{
				
			}
			else
			{
			 
			  if(!isset($req->session()->all()['data'][9]))
				{
					$req->session()->flash('status','You do not have right to access this module');
					
					return redirect('/');
				}		 
			}

     $carbodypart1 = [];

     $carbodypart=Stcarbodypart::orderby('created_at','desc')->get();
      $check = Stcarbodypart::latest('id')->first();
     
    // dd($carbodypart->toArray());
       if (count($carbodypart) == 0)
        {
           
            $carbodypart1 = [];
        }
        else
        {
            foreach ($carbodypart as $key => $value) {

                        $schoolname = DB::table('schools')->where('id', $value->schoolidC)
                            ->first();
                        $studname = DB::table('students')->where('id', $value->studentidC)

                            ->where('school_id', $value->schoolidC)
                            ->first();
                        if ($schoolname != null && $studname != null)
                        {

                           $TeamCheck = StudentTeam_Role::where('studentid',$value->studentidC)
                                       ->where('schoolid',$value->schoolidC)->first();
                           
                           if($TeamCheck==null)
                           {
                              $team = Team_Store::where('student_id',$value->studentidC.'_student')
                                      ->where('school_id',$value->schoolidC)->first();

                               if($team==null)
                               {
                                $carbodypart[$key]->teamid = 'N/A';
                                $carbodypart[$key]->teamname = 'N/A';
                                $carbodypart[$key]->Competitionname = 'N/A';
                               } 
                               else
                               {
                                $carbodypart[$key]->teamid=$team->id;
                                $carbodypart[$key]->teamname = Team_Store::where('id',$team->id)->first()->team_Name??'N/A';
                                  $comp =   Schoolteamcomp::
                                              where('school_id',$value->schoolidC)
                                              ->where('tmpid',$team->id)
                                              ->first()->cmpid??'N/A';
                                   if($comp!='N/A')
                                   {
                                    $carbodypart[$key]->Competitionname = Competitionstore::where('id',$comp)->first()->Competition_name??'N/A';
                                   }
                                   else
                                   {
                                    $carbodypart[$key]->Competitionname = 'N/A';
                                   }           

                                 // $carbodypart[$key]->Competitionname = Schoolteamcomp::where('id',$team->id)->first()->team_Name??'N/A';
                               }      

                             

                           }
                           else
                           {
                            
                            $carbodypart[$key]->teamid=$TeamCheck->teamId;
                            $carbodypart[$key]->teamname = Team_Store::where('id',$TeamCheck->teamId)->first()->team_Name??'N/A';

                                $comp =   Schoolteamcomp::
                                              where('school_id',$value->schoolidC)
                                              ->where('tmpid',$TeamCheck->teamId)
                                              ->first()->cmpid??'N/A';
                                   if($comp!='N/A')
                                   {
                                    $carbodypart[$key]->Competitionname = Competitionstore::where('id',$comp)->first()->Competition_name??'N/A';
                                   }
                                   else
                                   {
                                    $carbodypart[$key]->Competitionname = 'N/A';
                                   }
                           }


                            $carbodypart [$key]->schoolname = $schoolname->school_name;

                            $studname = DB::table('students')
                                        ->where('id', $value->studentidC)
                                        ->where('school_id', $value->schoolidC)
                                        ->first();

                            if ($studname != null)
                            {
                                $carbodypart [$key]->studentname = $studname->name;
                            }
                            else
                            {
                                $carbodypart [$key]->studentname = 'N/A';
                            }

                            $trainerid = DB::table('school_trainer')
                                        ->where('school_id', $value->schoolidC)
                                        ->where('year', date("Y"))
                                        ->first();

                            if ($trainerid == null)
                            {
                                $carbodypart [$key]->trainer_name = 'N/A';
                            }
                            else
                            {
                            $carbodypart [$key]->trainer_name = DB::table('trainers')
                                                               ->find($trainerid->trainer_id)->name??'N/A';
                            }
                            $carbodypart [$key]->instype = DB::table('schools')
                                                    ->where('id', $value->schoolidC)
                                                    ->first()->type;

                            $carbodypart [$key]->instype = DB::table('schools')
                                                           ->where('id', $value->schoolidC)
                                                           ->first()->type??'N/A';
                                                           
                           
                            if($value->carpartid!=0)
                                {
                                $carbodypart [$key]->carpartname = DB::table('carbodypart')
                                ->where('id',$value->carpartid)->first()->Partname??'N/A';   
                                }
                                else
                                {
                                $carbodypart [$key]->carpartname ='N/A'; 
                                }    
                               

                        }
                        else
                        {
                            $carbodypart [$key]->studentname = 'N/A';
                            $carbodypart [$key]->schoolname = 'N/A';
                            $carbodypart [$key]->trainer_name = 'N/A';
                            $carbodypart [$key]->instype = 'N/A';
                            $carbodypart[$key]->Competitionname = 'N/A';

                        }
                
            }
          

        }   

   
       return view('Manufacture.manufacturecaraccess', compact('carbodypart','check'));
     

    }

    public function placeorderList($orderId)
    {
        $cardpartbody=[];
        $email = Auth::user()->email;
        $ids = explode(".", base64_decode($orderId));

        $studentid = $ids[0];
        $schoolid = $ids[1];


$studentiddd=$studentid."_student";
  $checkTeamId = DB::table('team_store')
                      ->where('student_id',$studentiddd)
                      ->where('school_id',$schoolid)
                      ->first();
  if($checkTeamId==null){
 $strole= DB::table('studentTeam_Role')
                        ->where('studentid',$studentid)
                        ->where('schoolid',$schoolid)
                        ->first();

if($strole==null)
{
     $creatorteamid ='N/A';
}
else
{
$creatorteamid =$strole->studentid;
}
                    
  }else{

   $creatorteamid = $checkTeamId->id;                     
  }


        $schoolname = DB::table('schools')->find($schoolid)->school_name;
        $studentname = DB::table('students')->find($studentid)->name;

        $carbody = DB::table('carType')->where('studentid', $studentid)->where('schoolid', $schoolid)->where('status', 1)
            ->get()->map(function ($data)
        {
            return $data;
        });

        $cardpartid = DB::table('stCarbodypart')->select('carpartid')
            ->where('studentidC', $studentid)->where('schoolidC', $schoolid)->where('stCarbodypart.status', 1)
            ->get();

        foreach ($cardpartid as $key => $partid)
        {
            $cardpartbody = DB::table('stCarbodypart')->where('studentidC', $studentid)->where('schoolidC', $schoolid)->where('stCarbodypart.status', 1)
                ->get()->map(function ($p) use ($partid)
            {
                $p->partname = DB::table('partmetarial')
                    ->find($partid->carpartid)->partmetarialName;
                return $p;
            });
        }

        $studentName = DB::table('students')->select('students.name', 'schools.school_name')
            ->join('schools', 'schools.id', '=', 'students.school_id')
            ->where('studentemail', $email)->first();

        $details = $this->viewsCousrseS();
        if ($details != [])
        {
            $assigndata = $details['details'];
            $systemdate = $details['systemdate'];
            $pname = $details['pname'];
            $studentid = $details['studentid'];
            $schoolid = $details['schoolid'];
            $planid = $details['planid'];
        }

        $compId = Schoolteamcomp::where('school_id', $schoolid)->count();
        $teamstoreCreateId = DB::table('team_store')->where('school_id', $schoolid)->where('student_id', $studentid . "_student")
        // ->where('created_at', date('Y'))
        ->count();

        $studenteamroleId = DB::table('studentTeam_Role')->where('schoolid', $schoolid)->where('studentid', $studentid)
        // ->where('created_at', date('Y'))
        ->count();
        return view('Manufacture.orderListPage', compact('creatorteamid','teamstoreCreateId', 'studenteamroleId', 'compId', 'pname', 'studentName', 'studentid', 'schoolid', 'schoolname', 'studentname', 'carbody', 'cardpartbody'));

    }

    public function viewsCousrseS()
    {
        $email = Auth::user()->email;
        $data = [];
        $course_d = [];
        $pname = null;
        $planid = null;
        $studentid = DB::table('students')->where('studentemail', $email)->first()->id;

        $schoolid = DB::table('students')->where('studentemail', $email)->first()->school_id;

        $year = date("Y");
        $systemdate = date("Y-m-d");
        // dd($systemdate);
        $acyear = AssignedCoursetype::where('school_id', $schoolid)->where('student_id', $studentid)->first();

        if ($acyear != null)
        {
            $acyear2 = AssignedCoursetype::where('school_id', $schoolid)->where('student_id', $studentid)->first()->acyear;

            // ->acyear
            $planid = AssignedCoursetype::where('school_id', $schoolid)->where('student_id', $studentid)->first()->Plan_id;

            $pname = DB::table('memberships')->find($planid);

            $acyear1 = explode("-", $acyear2);

            if ($year == $acyear1[0])
            {

                $doc_course = AssignedCoursetype::select('doc_types_id', 'course_masters_id', 'assigneddate')->where('school_id', $schoolid)->where('student_id', $studentid)->get()->map(function ($data)
                {
                    return $data;
                })->toArray();

                foreach ($doc_course as $doc_course1)
                {
                    $videoactivity = DB::table('videoactivity')->where('studentid', $studentid)->where('vedioid', $doc_course1['course_masters_id'])->where('schoolid', $schoolid)->where('planid', $planid)->orderby('id', 'desc')
                        ->get()->map(function ($t)
                    {
                        return $t;
                    })->toArray();

                    $tet = isset($videoactivity[0]->resumevedio) ? $videoactivity[0]->resumevedio : 0;

                    $course_d[] = DB::table('courses')->join('course_masters', 'course_masters.id', '=', 'courses.course_masters_id')
                        ->join('doc_types', 'doc_types.id', '=', 'courses.doc_types_id')
                        ->where('courses.doc_types_id', $doc_course1['doc_types_id'])->where('courses.course_masters_id', $doc_course1['course_masters_id'])->get()->map(function ($data) use ($doc_course1, $tet)
                    {
                        $data->asshigneddate = $doc_course1['assigneddate'];
                        $data->resumevedio = $tet;
                        return $data;
                    })->toArray();

                }
            }
        }

        $data = array(
            'details' => $course_d,
            'systemdate' => $systemdate,
            'pname' => $pname,
            'studentid' => $studentid,
            'schoolid' => $schoolid,
            'planid' => $planid
        );
        return $data;

        // }
        // else
        // {
        

        // }
        
    }

   public function addcart($applicationid)
    {

        // $email = Auth::user()->email;
        

        $studentid = DB::table('students')
                  ->where('mobileno',Auth::user()->mobile_no)->where('dob',Auth::user()->dob)->first()->id;

        $schoolid= Student::select('*')->where('mobileno',Auth::user()->mobile_no)->where('dob',Auth::user()->dob)
                  ->first()->school_id; 
        $ids = $studentid . "." . $schoolid;

        session_start();

        // array_push($_SESSION['cart'],base64_decode($applicationid));
        $_SESSION['cart'] = array();

        array_push($_SESSION['cart'], base64_decode($applicationid));
        if (!in_array(base64_decode($applicationid) , $_SESSION['cart']))
        {
            $_SESSION['msg'] = 'added';
        }
        else
        {
            $_SESSION['msg'] = 'adding';
            // array_push($_SESSION['cart'],base64_decode($applicationid));
            
        }

        $item = array_unique($_SESSION['cart']);
        
        return redirect('manufacturePage/' . base64_encode($ids));
        dd($item);

    }

    public function item($id)
    {

        $email = Auth::user()->email;
        $body1 = [];
        $carbodypart = [];
        $mate = [];
        $matpart = [];

        for ($i = 1;$i <= \Cache::get($id) + 1;$i++)
        {
            $keyx = 'key_' . $i . "_" . $id;
            $b = explode("_", \Cache::get('key_' . $i . "_" . $id));
            // echo '<pre>';
            //           print_r($b);
            

            if ($b[0] != null)
            {

                $body = $b[1];
                if ($body == '1')
                {

                    $xy = DB::table('carType')->where('id', \Cache::get('key_' . $i . "_" . $id))->first();
                    $xy->keys = $keyx;
                    $body1[] = $xy;
                    $mate = DB::table('cartypeMeterial')->get();

                    //   dd($mate);art
                    
                }
                else
                {

                    $matpart = DB::table('partmetarial')->get();
                    $xyz = DB::table('stCarbodypart')->where('stCarbodypart.id', \Cache::get('key_' . $i . "_" . $id))->join('carbodypart', 'carbodypart.id', '=', 'stCarbodypart.carpartid')
                        ->first();

                    $xyz->keys = $keyx;
                    $carbodypart[] = $xyz;
                }
            }
        }

        $studentName = DB::table('students')->select('students.name', 'schools.school_name')
            ->join('schools', 'schools.id', '=', 'students.school_id')
            ->where('studentemail', $email)->first();

        $details = $this->viewsCousrseS();
        if ($details != [])
        {
            $assigndata = $details['details'];
            $systemdate = $details['systemdate'];
            $pname = $details['pname'];
            $studentid = $details['studentid'];
            $schoolid = $details['schoolid'];
            $planid = $details['planid'];
        }

        $studentname = DB::table('students')->find($id)->name;

        $compId = Schoolteamcomp::where('school_id', $schoolid)->count();
        $teamstoreCreateId = DB::table('team_store')->where('school_id', $schoolid)->where('student_id', $studentid . "_student")
        // ->where('created_at', date('Y'))
        ->count();

$studentiddd=$studentid."_student";
  $checkTeamId = DB::table('team_store')
                      ->where('student_id',$studentiddd)
                      ->where('school_id',$schoolid)
                      ->first();
  if($checkTeamId==null){
 $strole= DB::table('studentTeam_Role')
                        ->where('studentid',$studentid)
                        ->where('schoolid',$schoolid)
                        ->first();

if($strole==null)
{
     $creatorteamid ='N/A';
}
else
{
$creatorteamid =$strole->studentid;
}
                    
  }else{

   $creatorteamid = $checkTeamId->id;                     
  }


        $studenteamroleId = DB::table('studentTeam_Role')->where('schoolid', $schoolid)->where('studentid', $studentid)
        // ->where('created_at', date('Y'))
        ->count();
        return view('Manufacture.CartList', compact('teamstoreCreateId', 'creatorteamid','studenteamroleId', 'compId', 'planid', 'schoolid', 'studentid', 'pname', 'studentName', 'body1', 'carbodypart', 'id', 'mate', 'matpart', 'studentname'));

    }

    public function meterialbodyprice(Request $req)
    {
        $price = DB::table('cartypeMeterial')->where('id', $req->meterialidbodyid)
            ->first()->price;
        return $price;

    }

    public function meterialbodypartprice(Request $req)
    {
        $price = DB::table('partmetarial')->where('id', $req->meterialidbodypartid)
            ->first()->partMeterialprice;
        return $price;

    }

    public function cartdetails(Request $req)
    {
        if (!isset($req->body))
        {
            return redirect()
                ->back();
        }

        $email = Auth::user()->email;

        $studentid = $req->studentid;
        $carbodyprice = 0;
        $carbodypartprice = 0;
        $carbodyprice = [];

        foreach ($req->body as $body)
        {

            $b = explode("_", $body);

            if ($b[1] == 'a')
            {
                $carbodymeterialid = $body . "_" . "bodymet";
                $q = "quantity" . "" . $body;
                $quantityb = $req->$q;
                $carbodymet = $req->$carbodymeterialid;
                //$carbodyprice=DB::table('cartypeMeterial')->where('id',$carbodymet)->first()->price;
                $carbodyprice[] = DB::table('cartypeMeterial')->where('id', $carbodymet)->get()->map(function ($d) use ($studentid, $quantityb, $carbodymet, $b)
                {
                    $d->studentid = $studentid;
                    $d->metpatid = $carbodymet . "_" . $b[0];
                    $d->Quantity = $quantityb;
                    $d->price = ($quantityb * $d->price);
                    $d->body = "b";

                    return $d;
                })->toArray();
                //   echo $carbodyprice*$quantityb;
                
            }
            else
            {
                $carbodypartid = $body . "_" . "bodymet";
                $q = "quantity" . "" . $body;
                $quantityp = $req->$q;
                $carbodypart = $req->$carbodypartid;

                $carbodypartprice = DB::table('carbodypart')->where('id', $carbodypart)->first()->price;
                $carbodyprice[] = DB::table('partmetarial')->where('id', $carbodypart)->get()->map(function ($d1) use ($studentid, $quantityp, $carbodypart, $b)
                {

                    $d1->studentid = $studentid;
                    $d1->metpatid = $carbodypart . "_" . $b[0];
                    $d1->Quantity = $quantityp;
                    $d1->price = ($quantityp * $d1->partMeterialprice);
                    $d1->body = "p";

                    //   $d1->partname=DB::table('carbodypart')->where('id',$b[0])->first()->Partname;
                    return $d1;
                })->toArray();
            }

        }
        //dd($carbodyprice);
        foreach ($carbodyprice as $price)
        {
            foreach ($price as $price1)
            {
                $t[] = $price1->price;
            }
        }

        try
        {
            $totalpaid = array_sum($t);
        }
        catch(\Exciption $e)
        {
            return redirect()->back();
        }

        $orderid11 = Cardetailspayments::select('orderid')->orderby('id', 'desc')
            ->first();

        if ($orderid11 == null)
        {

            $orderid = "ord_" . $studentid . "_" . sprintf("%'.05d", 1);
        }
        else
        {
            $orderbreak = explode("_", $orderid11->orderid);
            $orderid = "ord_" . $studentid . "_" . sprintf("%'.05d", $orderbreak[2] + 1);
        }

        foreach ($carbodyprice as $carbodyprice1)
        {
            foreach ($carbodyprice1 as $carbodyprice2)
            {
                $orderpayment = new Cardetailspayments();
                $orderpayment->orderid = $orderid;
                $orderpayment->StudentId = $carbodyprice2->studentid;
                $orderpayment->metpatid = $carbodyprice2->metpatid;
                $orderpayment->Quantity = $carbodyprice2->Quantity;
                $orderpayment->body = $carbodyprice2->body;
                $orderpayment->unitprice = $carbodyprice2->price;
                $orderpayment->totalpriceitem = $totalpaid;
                $orderpayment->order_status = 'Pending';
                $orderpayment->save();

            }

        }

        $studentName = DB::table('students')->select('students.name', 'schools.school_name')
            ->join('schools', 'schools.id', '=', 'students.school_id')
            ->where('studentemail', $email)->first();

        $details = $this->viewsCousrseS();
        if ($details != [])
        {
            $assigndata = $details['details'];
            $systemdate = $details['systemdate'];
            $pname = $details['pname'];
            $studentid = $details['studentid'];
            $schoolid = $details['schoolid'];
            $planid = $details['planid'];
        }

        $req->session()
            ->put('key', $orderid);
        $req->session()
            ->put('carbodyprice', $carbodyprice);

        Session::put('set_order_id', $orderid);

        $checkAddress = DB::table('orederstaus')->where('user_id', Auth::user()
            ->id)
            ->first();
        $compId = Schoolteamcomp::where('school_id', $schoolid)->count();
        $compId = Schoolteamcomp::where('school_id', $schoolid)->count();
        $teamstoreCreateId = DB::table('team_store')->where('school_id', $schoolid)->where('student_id', $studentid . "_student")
        // ->where('created_at', date('Y'))
        ->count();

        $studenteamroleId = DB::table('studentTeam_Role')->where('schoolid', $schoolid)->where('studentid', $studentid)
        // ->where('created_at', date('Y'))
        ->count();

$studentiddd=$studentid."_student";
  $checkTeamId = DB::table('team_store')
                      ->where('student_id',$studentiddd)
                      ->where('school_id',$schoolid)
                      ->first();
  if($checkTeamId==null){
 $strole= DB::table('studentTeam_Role')
                        ->where('studentid',$studentid)
                        ->where('schoolid',$schoolid)
                        ->first();

if($strole==null)
{
     $creatorteamid ='N/A';
}
else
{
$creatorteamid =$strole->studentid;
}
                    
  }else{

   $creatorteamid = $checkTeamId->id;                     
  }
        if (empty($checkAddress))
        {

            return view('Manufacture.shippingaddressorder', compact('creatorteamid','teamstoreCreateId', 'studenteamroleId', 'compId', 'planid', 'schoolid', 'studentid', 'pname', 'systemdate', 'assigndata', 'studentName', 'carbodyprice'));

        }
        else
        {

            return redirect('shippingorder');
        }

    }
 public function deliveryaddressalldetails(Request $req)
    {
        
        Orederstaus::where('order_id',$req->appid)->delete();
        session_start();
        $email = Auth::user()->email;
        $userid=Studentinfo::where('studentemail',$email)->first()->id;
        $Orederstaus = new Orederstaus();
        $Orederstaus->order_id = $req->appid;
        $Orederstaus->user_id = $userid;
        $Orederstaus->fullName = $req->fullName;
        $Orederstaus->mobile = $req->mobile;
        $Orederstaus->pincode = $req->Pincode;
        $Orederstaus->address = $req->address;
        $Orederstaus->street = $req->street;
        $Orederstaus->city = $req->city;
        $Orederstaus->State = $req->State;
        $Orederstaus->addrestype = $req->addrestype;
        $Orederstaus->statusupdated = 0;
        $Orederstaus->save();
         $orderid = Cartdetail::select('orderid')->orderby('id', 'desc')
            ->first();
       $_SESSION['orderid']=$orderid->orderid;
       
        return redirect('shippingorder');

    }
  
    public function shippingOrder(Request $req)
    {

        // dd(Session::get('set_order_id'));
        session_start();

      
        $productname = [];
        // $email = Auth::user()->email;
         // $userid=Studentinfo::where('studentemail',$email)->first()->id;
      
        // $studentid = DB::table('students')->where('studentemail', $email)->first()->id;
        // $schoolid = DB::table('students')->where('studentemail', $email)->first()->school_id;

         $studentid = DB::table('students')
                  ->where('mobileno',Auth::user()->mobile_no)->where('dob',Auth::user()->dob)->first()->id;

        $schoolid= Student::select('*')->where('mobileno',Auth::user()->mobile_no)->where('dob',Auth::user()->dob)
                  ->first()->school_id; 
         $scho = $schoolid;

         $planId = DB::table('assignpriceinschool')->where('schoolid', $schoolid)->orderBy('id', 'DESC')
                    ->first();
         $planId = isset($planId) ? $planId->planid : 0;
          $plan1 = DB::table('plans')->where('id', $planId)->first();
           ;

                $studentiddd = $studentid . "_student";
                $checkTeamId = DB::table('team_store')->where('student_id', $studentiddd)->where('school_id', $schoolid)->first();
                  $team = DB::table('studentTeam_Role')->where('studentid', $studentid)->where('schoolid', $schoolid)->first();
                 if($plan1->level==2)
                  {
                    
                      $team=$team->teamId??0;
                      
                    $pm=Payment::where('teamid',$team)->orderby('id','desc')->first();
                    $pm->block??0;
                  }
                  else
                  {
					  
                    $team=$team->teamId??0;
                      $teamtotal = DB::table('studentTeam_Role')->where('teamId', $team)->count();
                
                    $pm=Payment::where('teamid',$team)->orderby('id','desc')->first();
                    $pm->block??0;
                  }
                if ($checkTeamId == null)
                {

                    $strole = DB::table('studentTeam_Role')->where('studentid', $studentid)->where('schoolid', $schoolid)->first();
                    if ($strole == null)
                    {
                        $creatorteamid = 'N/A';
                    }
                    else
                    {
                        $creatorteamid = $strole->studentid;
                    }

                }
                else
                {

                    $creatorteamid = $checkTeamId->id;
                }


       $order_id = $_SESSION['orderid'];
       
        $orderidaddress = Orederstaus::where('order_id', $order_id)
            ->first();
			
        $productdetails = Cartdetail::where('orderid', $order_id)->get();
       $quan=0;
      foreach ($productdetails as $key => $value) {
        if($value->product==0)
        {
        $productdetails[$key]['productname']='carbody';
         $productdetails[$key]['materialname']='carbody';
		 $quan=$value->quantity;
        }
        else
        {
			$mat=Material::where('id',$value->mat_id)->first();
			if(isset($mat->material))
			{
				$productdetails[$key]['productname']=Part::where('id',$value->product)->first()->parts;
          $productdetails[$key]['materialname']=$mat->material;
			}
			else
			{
				unset($productdetails[$key]);
			}
			
         
        }    
      }
    $tot=$productdetails->toArray();
    $totalprice =  array_sum(array_column($tot, 'price'));



          $studentName = DB::table('students')
                      ->select('students.name','schools.school_name','students.profileimage','students.register_type','students.order_status','students.last_login')
                      ->join('schools','schools.id','=','students.school_id')
                      ->where('mobileno',Auth::user()->mobile_no)
                       ->where('dob',Auth::user()->dob)
                      ->first();


        $details = $this->viewsCousrseS();
        if ($details != [])
        {
            $assigndata = $details['details'];
            $systemdate = $details['systemdate'];
            $pname = $details['pname'];
            $studentid = $details['studentid'];
            $schoolid = $details['schoolid'];
            $planid = $details['planid'];
        }
         
         $schoolid= $scho;
          $compId = Schoolteamcomp::where('school_id', $schoolid)->count();
                $teamstoreCreateId = DB::table('team_store')->where('school_id', $schoolid)->where('student_id', $studentid . "_student")
                // ->where('created_at', date('Y'))
                ->count();

                $studenteamroleId = DB::table('studentTeam_Role')->where('schoolid', $schoolid)->where('studentid', $studentid)
                // ->where('created_at', date('Y'))
                ->count();
                 $planId = DB::table('assignpriceinschool')->where('schoolid', $schoolid)->orderBy('id', 'DESC')
                    ->first();

                $planId = isset($planId) ? $planId->planid : 0;

                $plan1 = DB::table('plans')->where('id', $planId)->first();
                $mt=$plan1->manufacturing_cost*$quan;
        return view('Manufacture.previewshippingaddressorder', compact('email', 'order_id', 'planid', 'schoolid', 'studentid', 'pname', 'systemdate', 'assigndata', 'studentName', 'orderidaddress', 'productdetails', 'productname','compId','teamstoreCreateId','creatorteamid','mt','totalprice'));

    }

    public function orderListshowbyAdmin(Request $req)
    {
		
		 if(Auth::user()->role==1)
			{
				
			}
			else
			{
			 
			  if(!isset($req->session()->all()['data'][10]))
				{
					$req->session()->flash('status','You do not have right to access this module');
					
					return redirect('/');
				}		 
			}
			

    $orderlist = Orederstaus::groupby('order_id')->orderby('id','desc')->get();

        foreach($orderlist as $key=>$or)
        {
            $payment=Payment::where('order_id',$or->order_id)->first();
            if(isset($payment->order_id))
            {
               if($payment->transaction_id!=null)
               {
                $orderlist[$key]->status="Success";
                $orderlist[$key]->transaction_id = $payment->transaction_id??'N/A';

               }
               else
               {
                  $orderlist[$key]->status='Failed';
                  $orderlist[$key]->transaction_id = $payment->transaction_id??'N/A';
               }
            }
             else
            {
                $orderlist[$key]->status="Failed";
                $orderlist[$key]->transaction_id = $payment->transaction_id??'N/A';
            }
        }
        return view('Manufacture.OrderListshowbyAdmin', compact('orderlist'));
    }

    public function orderstatusupdate(Request $req)
    {
        
       
        $orderidaddress = Orederstaus::where('order_id', $req->order_Id)
            ->update(array(
            'statusupdated' => $req->updatestatus
        ));

            

             $checkorder = Orederstaus::where('order_id', $req->order_Id)->first()??"";
            
             // $studentid = DB::table('students')
             //      ->where('mobileno',Auth::user()->mobile_no)->where('dob',Auth::user()->dob)->first()->id;

        // $schoolid= Student::select('*')->where('mobileno',Auth::user()->mobile_no)->where('dob',Auth::user()->dob)
        //           ->first()->school_id; 

            $student = Studentinfo::find($checkorder->user_id);

            // dd($student);
            $schoolname = School::where('id',$student->school_id)->first()->school_name;



           $apikey = "YXPskaQxMk6oxtQcQbPo2Q";
             $apisender = "TOSAPP";
            

           
            $msg = "Dear ".strtoupper($student->name).",\r\nThe status of your order ".$req->order_Id." has been updated to ".$req->updatestatus;

            // $msg = "Dear ".$req->sname.",Explore STEM Learning Platform powered by F1 in Schools India. Now Learning will be Fun! Signup: ".url('studentlogin');
            
             $num ='91'.$checkorder->mobile;    // MULTIPLE NUMBER VARIABLE PUT HERE...!       
             // $num ='91'.'8700488718';           
             $ms = rawurlencode($msg);   //This for encode your message content                     
            $url = 'https://www.smsgatewayhub.com/api/mt/SendSMS?APIKey='.$apikey.'&senderid='.$apisender.'&channel=2&DCS=0&flashsms=0&number='.$num.'&text='.$ms.'&route=1';
                               
           //echo $url;
           $ch=curl_init($url);
           curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
           curl_setopt($ch,CURLOPT_POST,1);
           curl_setopt($ch,CURLOPT_POSTFIELDS,"");
           curl_setopt($ch, CURLOPT_RETURNTRANSFER,2);
            $data = curl_exec($ch);
            
           curl_error($ch);
        if($this->checkemail1($student->studentemail))
        {
        // $link = "route('/studentlogin')";
        $data = array(
            'name' => $student->name,
            'email' => $student->studentemail,
            'delivery'=>$req->updatestatus,
             'oderid'=> $req->order_Id
        );

        Mail::send('Mail.deliveremailTemplate', $data, function ($message) use ($data)
        {
            $message->to($data['email'], 'noreply@f1inschoolsindia.com')->subject('Welcome Aboard | F1 in Schools™ India');
            $message->from('noreply@timeofsports.com', 'F1 in Schools™ India');
        });
       
       
        }
        
        return redirect('order-list');
    }


   

      public function checkemail1($str) {

         return (!preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $str)) ? FALSE : TRUE;
   }
    /*End Delivery Status*/
    public function orderiddetails($orderid,Request $req)
    {
		
		if(Auth::user()->role==1)
			{
				
			}
			else
			{
			 
			  if(!isset($req->session()->all()['data'][10]))
				{
					$req->session()->flash('status','You do not have right to access this module');
					
					return redirect('/');
				}		 
			}

        $orderid=base64_decode($orderid);
		$quan=$orderdetails = Cartdetail::where('orderid',$orderid)->where('product','0')->first();
// $carbodypart = Stcarbodypart::where('applicationid', 'SHU-YOP-0167')
//                         ->get();
// dd($carbodypart);
		$quan=$quan->quantity??0;
  
        $orderdetails = Cartdetail::where('orderid',$orderid)->get()->map(function($data){
			        
              if($data->product==0 && $data->mat_id==0)
              {
             $data->productname='carbody';
             $data->materialname='meterial';
            
              $data->file = Stcarbodypart::
                            where('applicationid', $data->applicationid)
                            ->where('carpartid',$data->product)
                            // ->where('carpartid',$data->mat_id)
                           ->first()->partimage??0;
              }
              else
               {
                 $data->productname=Part::where('id',$data->product)->first()->parts??0;;
                 $data->materialname=Material::where('id',$data->mat_id)->first()->material??0;
              
                 $data->file = Stcarbodypart::
                            where('applicationid', $data->applicationid)
                        
                            ->where('carpartid',$data->product)
                           ->first()->partimage??0;
               }
          
             return $data;
 });
 
    $tot=$orderdetails->toArray();
    $totalprice =  array_sum(array_column($tot, 'price'));
    
    $pay=Orederstaus::where('order_id',$orderid)->orderby('id','desc')->first();
    if(isset($pay))
    {
    $pays = Payment::where('order_id',$pay->order_id)->first();
    if(isset($pays))
    {
    $student=Studentinfo::where('id',$pays->student_id)->first();
    $checkteamstudent=StudentTeam_Role::where('studentid',$pays->student_id)->first();
  ;
    $teamid=$checkteamstudent->teamId??0;
    //$checkteamstudent->teamId=$checkteamstudent->teamId??0;
    $teaminfo=Team_Store::where('id',$teamid)->first();
    $schoolid=$student->school_id??0;
    $school=School::where('id',$schoolid)->first();
    $plan=Assignpriceinschool::where('schoolid',$schoolid)->orderby('id','desc')->first();
     if(isset($plan))
    {
    $shipingAddress=Orederstaus::where('order_id',$orderid)->first();

    $plans=Plan::where('id',$plan->planid)->first();
   
    $mancost=$plans->manufacturing_cost*$quan;
    $mancost1=$mancost+$totalprice;
     }
     else
     {
      $shipingAddress = 'N/A';
     }
    }

    }
 
return view('Manufacture.orderdetailsshowbyAdmin', compact('orderdetails','shipingAddress','totalprice','mancost','mancost1','teaminfo','school','student','pays'));
 }

    public function showdetailsstudentbyAdmin($orderId)
    {
        $orderId1 = explode("_", base64_decode($orderId));
        $info = Orederstaus::where('order_id', base64_decode($orderId))->first()??'N/A';
        $userinfo = DB::table('students')->find($orderId1[1]);
        return view('Manufacture.studentprofile', compact('userinfo','info'));

    }

    public function viewmeterial($meterialId)
    {
        $meterialinfo = DB::table('cartypeMeterial')->select('*')
            ->where('id', base64_decode($meterialId))->first();
        //   dd($meterialinfo);
        return view('Manufacture.viewmetarial', compact('meterialinfo'));
    }
    public function viewPart($partId)
    {
        //   dd(base64_decode($partId));
        $partview = DB::table('partmetarial')->select('*')
            ->where('id', base64_decode($partId))->first();
        // dd($partview);
        return view('Manufacture.viewcarbodypart', compact('partview'));
    }

    public function skipnewdesign($skipid)
    {
       // dd(base64_decode($skipid));
        return redirect('manufacturePage/' . $skipid);
    }

    public function cancledesign($skipid)
    {
        $data = explode("_", base64_decode($skipid));
        if($data[2]!=='Null')
        {
        Stcarbodypart::where('applicationid',$data[2])->delete();
        }
        $skipid1 = $data[0].".".$data[1];
        return redirect('manufacturePage/' . base64_encode($skipid1));

    }


    // payment Function
    

    public function paymentInfo(Request $request)
    {

        $amount = $request->amount;
        $name = $request->firstname;
        $email = $request->email;
        $productinfo = $request->productinfo;

        $PAYU_BASE_URL = "https://test.payu.in/_payment";

        //$MERCHANT_KEY = "gtKFFx";
        //$SALT = "3xBv2BeX";
        $MERCHANT_KEY = "gtKFFx";
        $SALT = "eCwWELxi";

        $txnid = substr(hash('sha256', mt_rand() . microtime()) , 0, 20);

        $hashSequence = "key|txnid|amount|productinfo|firstname|email|udf1|udf2|udf3|udf4|udf5|udf6|udf7|udf8|udf9|udf10";

        $hash_string = $MERCHANT_KEY . "|" . $txnid . "|" . $amount . "|" . $productinfo . "|" . $name . "|" . $email . "|" . $SALT;

        $hash = strtolower(hash('sha512', $hash_string));

        return redirect($PAYU_BASE_URL);

    }
    public function cart(Request $req)
    {

        
        session_start();
       
        $apps = [];

        // $email = Auth::user()->email;
        $role = Auth::user()->role;
        if ($role == 5)
        {

            $status = DB::table('students')->where('mobileno',Auth::user()->mobile_no)->where('dob',Auth::user()->dob)->first()->status;

            if ($status == 1)
            {
                $studentid = DB::table('students')->where('mobileno',Auth::user()->mobile_no)->where('dob',Auth::user()->dob)->first()->id;

                $schoolid = DB::table('students')->where('mobileno',Auth::user()->mobile_no)->where('dob',Auth::user()->dob)->first()->school_id;
                $scho = $schoolid;
             $scho = $schoolid;
                $studentiddd = $studentid . "_student";

                $checkTeamId = DB::table('team_store')->where('student_id', $studentiddd)->where('school_id', $schoolid)->first();
                if ($checkTeamId == null)
                {

                    $strole = DB::table('studentTeam_Role')->where('studentid', $studentid)->where('schoolid', $schoolid)->first();
                    if ($strole == null)
                    {
                        $creatorteamid = 'N/A';
                    }
                    else
                    {
                        $creatorteamid = $strole->studentid;
                    }

                }
                else
                {

                    $creatorteamid = $checkTeamId->id;
                }

                $studentName = DB::table('students')->select('students.name', 'schools.school_name')
                    ->join('schools', 'schools.id', '=', 'students.school_id')
                    ->where('mobileno',Auth::user()->mobile_no)->where('dob',Auth::user()->dob)->first();
                //code start by upanshu
                $teamrealtedtoschool = DB::table('team_store')->where('school_id', $schoolid)->select('student_id')
                    ->get()
                    ->toArray();

                $compId = Schoolteamcomp::where('school_id', $schoolid)->count();

                //dd($teamrealtedtoschool);
                if ($role == 5)
                {
                    $student_id = $studentid . '_student';

                }

                //code end by upanshu
                $details = $this->viewsCousrseS();

                if ($details != [])
                {
                    $assigndata = $details['details'];
                    $systemdate = $details['systemdate'];
                    $pname = $details['pname'];
                    $studentid = $details['studentid'];
                    $schoolid = $details['schoolid'];
                    $planid = $details['planid'];
                }
                $schoolid= $scho;
           
                $compId = Schoolteamcomp::where('school_id', $schoolid)->count();
                $teamstoreCreateId = DB::table('team_store')->where('school_id', $schoolid)->where('student_id', $studentid . "_student")
                // ->where('created_at', date('Y'))
                ->count();

                $studenteamroleId = DB::table('studentTeam_Role')->where('schoolid', $schoolid)->where('studentid', $studentid)
                // ->where('created_at', date('Y'))
                ->count();
                $teamroleId = DB::table('studentTeam_Role')->where('schoolid', $schoolid)->where('studentid', $studentid)
                // ->where('created_at', date('Y'))
                ->orderby('id','desc')->first();
                $team=$teamroleId->teamId??0;

                $test = array_unique($_SESSION['cart'])??0;
            
                $appid="";
                foreach ($test as $key => $value)
                {
                    
                    // $apps=stCarbodypart::where('applicationid',$value)->get()->toArray();
                    $apps[] = DB::table('stCarbodypart')->leftjoin('parts', 'parts.id', '=', 'stCarbodypart.carpartid')
                        ->select('stCarbodypart.studentidC', 'stCarbodypart.schoolidC', 'parts.parts', 'stCarbodypart.status', 'stCarbodypart.remark', 'stCarbodypart.created_at', 'stCarbodypart.updated_at', 'stCarbodypart.applicationid', 'stCarbodypart.carbodypart', 'stCarbodypart.carpartid', 'stCarbodypart.partimage')
                        // ->where('studentidC', $studentid)
                        // ->where('schoolidC', $schoolid)
                        ->where('applicationid', $value)->orderBy('applicationid', 'DESC')
                    // ->groupBy('applicationid')
                    
                        ->get()
                        ->toArray();
                    $appid = $value;
                    

                }

               
                $material = DB::table('materials')->get();

                $planId = DB::table('assignpriceinschool')->where('schoolid', $scho)->orderBy('id', 'DESC')
                    ->first();
                    
            
                $planId = isset($planId) ? $planId->planid : 0;
               

                $carpartidfetch = array_column($apps[0], 'carpartid');
				foreach ($carpartidfetch as $key => $value) {
                    // $part[$key]['meterial'] = Partplan::where('plan_id',$planId)
                    //         ->where('part_id',$value)->get();

                $matname = Partplan::where('plan_id',$planId)
                            ->where('part_id',$value)->get();

                            foreach ($matname as $key1 => $value) {
                               $matname[$key1]['matnname'] = Material::where('id',$value->material_id)
                                    ->first()->material;   
                
                            }
                            $part[$key]['meterial']=$matname;

                            // dd($matname);
                }
                
          
    //              foreach ($variable as $key => $value) {
    //                  # code...
    //              }
    //              dd($part[0]['meterial']);
				 


                $plan1 = DB::table('plans')->where('id', $planId)->first();
             
                 if($plan1->level==2)
                 {
                    $payment=Payment::where('teamid',$team)->where('plan_id',$planId)->where('transaction_id','!=',"")->orderby('id','desc')->sum('block');
                      $plan2=$plan1->number??0;
				 }
              
                 else
                 {
					    $member=Teammember::where('team_id',$team)->orderby('id','desc')->first();
						if(!isset($member->member)){
							 $studenteamroleId = DB::table('studentTeam_Role')->where('teamId', $team)->where('status',1)->count();
					   $plan2=$plan1->number*$studenteamroleId ??0;
						}
						else{
							$plan2=$plan1->number*$member->member??0;
						}
					
                     $payment=Payment::where('plan_id',$planId)->where('teamid',$team)->where('transaction_id','!=',"")->orderby('id','desc')->sum('block');
					  
                 }
          
                $block=$payment;
                if ($plan1 == null)
                {
                    $plan = 'N/A';
                     $av = 'N/A';
                }
                else
                {
                 
                    $av=$plan2-$block+$req->session()->all()['av'];
                    if($av<0)
                    {
                        $av=0;
                    }
                    $plan = $plan1;
                }
				$orderid11 = Cartdetail::select('orderid')->orderby('id', 'desc')
            ->first();

				if ($orderid11 == null)
				{

					$orderid = "ORD_" . $studentid . "_" . sprintf("%'.05d", 1);
				}
				else
				{
					$orderbreak = explode("_", $orderid11->orderid);
					$orderid = "ORD_" . $studentid . "_" . sprintf("%'.05d", $orderbreak[2] + 1);
				}
				$_SESSION['orderid']=$orderid;
				
                return view('Manufacture.cart', compact('teamstoreCreateId', 'studenteamroleId', 'compId', 'assigndata', 'systemdate', 'pname', 'studentid', 'schoolid', 'planid', 'studentName', 'creatorteamid', 'apps', 'material', 'plan', 'appid','av','part'));
            }
        }

    }
   public function materialperice(Request $req)
    {

        if ($req->from == 1)
        {
            // $email = Auth::user()->email;
            $role = Auth::user()->role;

            // $studentid = DB::table('students')->where('studentemail', $email)->first()->id;
            // $schoolid = DB::table('students')->where('studentemail', $email)->first()->school_id;
            $studentid= Student::select('*')->where('mobileno',Auth::user()->mobile_no)->where('dob',Auth::user()->dob)
                  ->first()->id; 
             $schoolid= Student::select('*')->where('mobileno',Auth::user()->mobile_no)->where('dob',Auth::user()->dob)
                  ->first()->school_id; 


            $planId = DB::table('assignpriceinschool')->where('schoolid', $schoolid)->orderBy('id', 'DESC')
                ->first();

            $planId = isset($planId) ? $planId->planid : 0;
            $price = Partplan::where('part_id', $req->productid)
                ->where('material_id', $req->materialid)
                ->where('plan_id', $planId)->first();

            $price = isset($price->price) ? $price->price : 0;
            $price = $price * $req->materialquan;
            return $price;

        }
        else
        {
            // $email = Auth::user()->email;
            $role = Auth::user()->role;
          $studentid= Student::select('*')->where('mobileno',Auth::user()->mobile_no)->where('dob',Auth::user()->dob)
                  ->first()->id; 
             $schoolid= Student::select('*')->where('mobileno',Auth::user()->mobile_no)->where('dob',Auth::user()->dob)
                  ->first()->school_id; 

            $planId = DB::table('assignpriceinschool')->where('schoolid', $schoolid)->orderBy('id', 'DESC')
                ->first();
            $planId = isset($planId) ? $planId->planid : 0;
            $price = Plan::where('id', $planId)->first();
            $price = isset($price->block_price) ? $price->block_price : 0;
            $price = $price * $req->materialquan;
            return $price;

        }
    }
   public function cartsave(Request $req)
    {


        session_start();

        
        $apps = [];

        $email = Auth::user()->email;
        $role = Auth::user()->role;
        if ($role == 5)
        {

            $status = DB::table('students')->where('studentemail', $email)->first()->status;

            if ($status == 1)
            {
                $studentid = DB::table('students')
                  ->where('mobileno',Auth::user()->mobile_no)->where('dob',Auth::user()->dob)->first()->id;

        $schoolid= Student::select('*')->where('mobileno',Auth::user()->mobile_no)->where('dob',Auth::user()->dob)
                  ->first()->school_id; 
                  $scho = $schoolid;

                $studentiddd = $studentid . "_student";
                $checkTeamId = DB::table('team_store')->where('student_id', $studentiddd)->where('school_id', $schoolid)->first();
                if ($checkTeamId == null)
                {

                    $strole = DB::table('studentTeam_Role')->where('studentid', $studentid)->where('schoolid', $schoolid)->first();
                    if ($strole == null)
                    {
                        $creatorteamid = 'N/A';
                    }
                    else
                    {
                        $creatorteamid = $strole->studentid;
                    }

                }
                else
                {

                    $creatorteamid = $checkTeamId->id;
                }

                $studentName = DB::table('students')
                      ->select('students.name','schools.school_name','students.profileimage','students.register_type','students.order_status','students.last_login')
                      ->join('schools','schools.id','=','students.school_id')
                      ->where('mobileno',Auth::user()->mobile_no)
                       ->where('dob',Auth::user()->dob)
                      ->first();
                                      //code start by upanshu
                $teamrealtedtoschool = DB::table('team_store')->where('school_id', $schoolid)->select('student_id')
                    ->get()
                    ->toArray();

                $compId = Schoolteamcomp::where('school_id', $schoolid)->count();

                if ($role == 5)
                {
                    $student_id = $studentid . '_student';

                }

                //code end by upanshu
                $details = $this->viewsCousrseS();

                if ($details != [])
                {
                    $assigndata = $details['details'];
                    $systemdate = $details['systemdate'];
                    $pname = $details['pname'];
                    $studentid = $details['studentid'];
                    $schoolid = $details['schoolid'];
                    $planid = $details['planid'];
                }
                $schoolid=$scho;
                $compId = Schoolteamcomp::where('school_id', $schoolid)->count();
                $teamstoreCreateId = DB::table('team_store')->where('school_id', $schoolid)->where('student_id', $studentid . "_student")
                // ->where('created_at', date('Y'))
                ->count();

                $studenteamroleId = DB::table('studentTeam_Role')->where('schoolid', $schoolid)->where('studentid', $studentid)
                // ->where('created_at', date('Y'))
                ->count();

                $i = 0;
                $email = Auth::user()->email;
                $role = Auth::user()->role;

                // $studentid = DB::table('students')->where('studentemail', $email)->first()->id;
                // $schoolid = DB::table('students')->where('studentemail', $email)->first()->school_id;

                $studentid = DB::table('students')
                  ->where('mobileno',Auth::user()->mobile_no)->where('dob',Auth::user()->dob)->first()->id;

             $schoolid= Student::select('*')->where('mobileno',Auth::user()->mobile_no)->where('dob',Auth::user()->dob)
                  ->first()->school_id; 
                $planId = DB::table('assignpriceinschool')->where('schoolid', $schoolid)->orderBy('id', 'DESC')
                    ->first();
                $planId = isset($planId) ? $planId->planid : 0;



        

// Save data in Payment Table during create OderId 
              $payment=Payment::where('order_id',$_SESSION['orderid'])->count();
			            $team = DB::table('studentTeam_Role')->where('studentid', $studentid)->where('schoolid', $schoolid)->first();
                 
            if($payment==0)
			{
              $pay = new Payment();
              $pay->order_id=$_SESSION['orderid'];
			         $pay->teamid=$team->teamId??0;
			        $pay->student_id=$studentid;
			         $pay->plan_id=$planId;
			        $pay->mode="Online";
              $pay->save();
            }
         

                foreach ($req->partid as $key => $value)
                {

                    if ($value == 0)
                    {
                
                        $i = $i + 1;
                        $price = Plan::where('id', $planId)->first();
						
               if($price->level==2)
                  {
                    
                    $team=$team->teamId??0;
                    $pm=Payment::where('teamid',$team)->where('plan_id',$planId)->orderby('id','desc')->sum('block');
					 $p=$price->number??0;
                    $pm=$pm??0;
					
                  }
                  else
                  {
                    $team=$team->teamId??0;
                    $pm=Payment::where('teamid',$team)->where('plan_id',$planId)->where('transaction_id','!=',"")->orderby('id','desc')->sum('block');
				$member=Teammember::where('team_id',$team)->orderby('id','desc')->first();
						if(!isset($member->member)){
							    $total = DB::table('studentTeam_Role')->where('teamId', $team)
                // ->where('created_at', date('Y'))
                ->count();
					 
						}
						else{
							$total=$member->member??0;
						}
				 $p=$total* $price->number;
                    $pm=$pm??0;
                  }
				   
					
                    $avbl=$p-$pm+$req->session()->all()['av'];
					  $avbl=$avbl>0?$avbl:0;
					  
                    $quan=$req->quant[$key];
                    $quan=$quan-$avbl;
					
					if($quan>0)
					{
                    $price = isset($price->block_price) ? $price->block_price : 0;
					}
					else
					{
						$price=0;
					}
                    $cost = ($quan)* $price;
					
                    }
                    else
                    {
                    $price = Partplan::where('part_id', $value)->where('material_id', $req->mat[$key])->where('plan_id', $planId)->first();
                    $price = isset($price->price) ? $price->price : 0;
                    $cost = $price * $req->quant[$key];
                    $quan=$req->quant[$key];

                    }
					 $payment=Cartdetail::where('orderid',$_SESSION['orderid'])->where('product',$value)->count();
					
					 if($payment==0)
					 {
                    $cart = new Cartdetail();
                    $cart->orderid=$_SESSION['orderid'];
                    $cart->product = $value;
                    $cart->mat_id=$req->mat[$key];
                    $cart->price = $cost;
                    $cart->quantity =$req->quant[$key];
                    $cart->student_id = $studentid;
                    $cart->applicationid = $req->applicationid;
                    $cart->school_id = $schoolid;
                    $cart->save();
				

					 }
                }
                $appid= $_SESSION['orderid'];
                return view('Manufacture.shippingaddressorder', compact('teamstoreCreateId', 'studenteamroleId', 'compId', 'assigndata', 'systemdate', 'pname', 'studentid', 'schoolid', 'planid', 'studentName', 'creatorteamid', 'apps', 'appid'));
            }

        
    }
        
}
public function payment(Request $req)
{
    
    // $email = Auth::user()->email;
     $studentid = DB::table('students')
                  ->where('mobileno',Auth::user()->mobile_no)->where('dob',Auth::user()->dob)->first()->id;

        $schoolid= Student::select('*')->where('mobileno',Auth::user()->mobile_no)->where('dob',Auth::user()->dob)
                  ->first()->school_id; 

      // $scho =    $schoolid;  
    $teamid= StudentTeam_Role::where('studentid',$studentid)->first()->teamId;
    $block= Payment::where('teamid',$teamid)->count()+1;

    $planId = DB::table('assignpriceinschool')->where('schoolid', $schoolid)->orderBy('id', 'DESC')
                    ->first();
    $planId = isset($planId) ? $planId->planid : 0;
    $plan1 = DB::table('plans')->where('id', $planId)->first();

    if ($plan1 == null)
        {
        $plan = 'N/A';
        }
        else
        {
        $plan = $plan1;
        }

    $orderid=$req->order_id;
    $transactionid=$req->transaction_id;
    Payment::where('order_id', $orderid)
       ->update([
           'transaction_id' => $transactionid,
           'teamid' => $teamid,
           'block' => $block,
           'student_id' => $studentid

        ]);


           

}
public function invoice($invoice,$pa)
{       $invoice=decrypt($invoice);
 $orderid=$invoice;

 $orderdetails = Cartdetail::where('orderid',$orderid)->get()->map(function($data){
	 
              if($data->product==0 && $data->mat_id==0)
              {
             $data->productname='carbody';
             $data->materialname='meterial';
              }
              else
               {
                 $data->productname=Part::where('id',$data->product)->first()->parts??"";
                 $data->materialname=Material::where('id',$data->mat_id)->first()->material??"";
               }
             return $data;
 });
    $tot=$orderdetails->toArray();
	$pay=Orederstaus::where('order_id',$orderid)->first();
$pays=Payment::where('order_id',$pay->order_id)->first();

$student=Student::where('id',$pays->student_id)->first();
$schoolid=$student->school_id??2;
$plan=Assignpriceinschool::where('schoolid',$schoolid)->first();
$shipingAddress=Orederstaus::where('order_id',$orderid)->first();
$plans=Plan::where('id',$plan->planid)->first();
$schools=School::find($schoolid);
$man_cost=$plans->manufacturing_cost;

	;
    $totalprice =  array_sum(array_column($tot, 'price'));
	
	 //$pdf = PDF::loadView('mails',compact('orderdetails','totalprice','man_cost','invoice','student','schools'));
	
$shipingAddress=Orederstaus::where('order_id',$orderid)->first();
		// $data=array("schoolname"=>"test",'password'=>'test123','email'=>'test@email');
      
	 // Mail::send('Mail.school', $data, function($message) use($data,$pdf){
         // $message->to('harshdeep521@gmail.com', 'noreply@f1inschoolsindia.com')
         // ->subject('Welcome Aboard | Season 3 | F1 in Schools™ India')->attachData($pdf->output(), "invoice.pdf");
         // $message->from('noreply@f1inschoolsindia.com','F1 in Schools™ India');
        // });

    session_start();
     $_SESSION['cart']=[];
	$_SESSION['msg']="";
	unset($_SESSION['orderid']);
	
	
	
        // $email=Auth::user()->email;
     $studentid = DB::table('students')
                  ->where('mobileno',Auth::user()->mobile_no)->where('dob',Auth::user()->dob)->first()->id;

        $schoolid= Student::select('*')->where('mobileno',Auth::user()->mobile_no)->where('dob',Auth::user()->dob)
                  ->first()->school_id; 

         $studentName = DB::table('students')->select('students.name', 'schools.school_name')
            ->join('schools', 'schools.id', '=', 'students.school_id')
            ->where('mobileno',Auth::user()->mobile_no)->where('dob',Auth::user()->dob)
            ->first();

             $compId = Schoolteamcomp::where('school_id', $schoolid)->count();

   
	$cartdetail=Cartdetail::where('orderid',$invoice)->where('product',0)->first();
	$quantity=$cartdetail->quantity??0;
	$teamid= StudentTeam_Role::where('studentid',$studentid)->first();
	
	$teamid=$teamid->teamId??0;
	
	// if($cartdetail!=null)
	// {
	    Payment::where('order_id',$invoice)->update(['transaction_id'=>$pa ,'teamid' => $teamid,
           'block' => $quantity,
           'student_id' => $studentid
]);	
	// }

  return view('payments/thankyou',compact('invoice','studentName','studentid','compId','schoolid'));
}
public function orderiddetails1($orderid)
{
 $orderid=decrypt($orderid);
 $orderid11 = Cartdetail::select('orderid')->where('orderid',$orderid)->orderby('id', 'desc')
            ->first();
 dd($orderid11);
}
public function removeitem($appid)
    {
		dd($appid);
		
        if (isset($appid))
        {
            session_start();
            $_SESSION['cart'] = array_unique($_SESSION['cart']);
            $key = array_search($appid, $_SESSION['cart']);
			
            if ($key !== false)
            unset($_SESSION['cart'][$key]);
            $_SESSION['cart'] = array_values($_SESSION['cart']);
		
            return redirect('cart');
        }
    }
public function removemanufactureitem(Request $req)
{
	session_start();
	
	unset($_SESSION['cart'][0]);
	unset($_SESSION['msg']);

	
	return redirect('manufacturePage/'.base64_encode(session('studentid').'.'.session('schoolid')));
}
public function pdf($orderdetails,$totalprice,$shipingAddress)
    {
		dd($orderdetails);
     $pdf = \App::make('dompdf.wrapper');
     $pdf->loadHTML('');
     return $pdf->stream();
    }

  public function downloadmanufacuturelist()
  {
        if(Auth::user()->role==1)
            {
                
            }
            else
            {
             
              if(!isset($req->session()->all()['data'][9]))
                {
                    $req->session()->flash('status','You do not have right to access this module');
                    
                    return redirect('/');
                }        
            }

     $carbodypart1 = [];
     $carbodypart=Stcarbodypart::orderby('created_at','desc')->get();
    // dd($carbodypart->toArray());
       if (count($carbodypart) == 0)
        {
           
            $carbodypart1 = [];
        }
        else
        {
            foreach ($carbodypart as $key => $value) {

                        $schoolname = DB::table('schools')->where('id', $value->schoolidC)
                            ->first();
                        $studname = DB::table('students')->where('id', $value->studentidC)

                            ->where('school_id', $value->schoolidC)
                            ->first();
                        if ($schoolname != null && $studname != null)
                        {

                           $TeamCheck=StudentTeam_Role::where('studentid',$value->studentidC)->where('schoolid',$value->schoolidC)->first();
                           
                           if($TeamCheck==null)
                           {
                              $team = Team_Store::where('student_id',$value->studentidC.'_student')
                                      ->where('school_id',$value->schoolidC)->first();

                               if($team==null)
                               {
                                $carbodypart[$key]->teamid = 'N/A';
                                $carbodypart[$key]->teamname = 'N/A';
                               } 
                               else
                               {
                                $carbodypart[$key]->teamid=$team->id;
                                $carbodypart[$key]->teamname = Team_Store::where('id',$team->id)->first()->team_Name??'N/A';
                               }      

                             

                           }
                           else
                           {
                            
                            $carbodypart[$key]->teamid=$TeamCheck->teamId;
                            $carbodypart[$key]->teamname = Team_Store::where('id',$TeamCheck->teamId)->first()->team_Name??'N/A';
                           }


                            $carbodypart [$key]->schoolname = $schoolname->school_name;
                            $studname = DB::table('students')->where('id', $value->studentidC)

                                ->where('school_id', $value->schoolidC)
                                ->first();
                            if ($studname != null)
                            {
                                $carbodypart [$key]->studentname = $studname->name;
                            }
                            else
                            {
                                $carbodypart [$key]->studentname = 'N/A';
                            }

                            $trainerid = DB::table('school_trainer')->where('school_id', $value->schoolidC)
                                ->where('year', date("Y"))
                                ->first();

                            if ($trainerid == null)
                            {
                                $carbodypart [$key]->trainer_name = 'N/A';
                            }
                            else
                            {
                                $carbodypart [$key]->trainer_name = DB::table('trainers')
                                    ->find($trainerid->trainer_id)->name??'N/A';
                            }
                            $carbodypart [$key]->instype = DB::table('schools')
                                ->where('id', $value->schoolidC)
                                ->first()->type;
                                    $carbodypart [$key]->instype = DB::table('schools')
                                    ->where('id', $value->schoolidC)
                                    ->first()->type??'N/A';
                           
                            if($value->carpartid!=0)
                                {
                                $carbodypart [$key]->carpartname = DB::table('carbodypart')
                                ->where('id',$value->carpartid)->first()->Partname??'N/A';   
                                }
                                else
                                {
                                $carbodypart [$key]->carpartname ='N/A'; 
                                }    
                               

                        }
                        else
                        {
                            $carbodypart [$key]->studentname = 'N/A';
                            $carbodypart [$key]->schoolname = 'N/A';
                            $carbodypart [$key]->trainer_name = 'N/A';
                            $carbodypart [$key]->instype = 'N/A';

                        }
                
            }
          

        }   
  // dd($carbodypart->toArray());



        // dd($teacher);
        $text='';
     if(count($carbodypart)>0)
     {  
        foreach($carbodypart as $key=>$value)
        {
        $arr[$key]["Application id"]=$value->applicationid;
        $arr[$key]["Student Name"]=$value->studentname;
        $arr[$key]["Institute"]=$value->instype;
        $arr[$key]["Institute Name"]=$value->schoolname;
        $arr[$key]["Team Name"]=$value->teamname;
        $arr[$key]["Trainer Name"]=$value->trainer_name;
        $arr[$key]["Part Type"]=$value->carbodypart;
        $arr[$key]["Part Name"]=$value->carpartname;

        //$cr=date_format($date,"d-m-Y H:i:s");
        $arr[$key]["Applied On"]=date_format($value->updated_at,"d-m-Y H:i:s");
           if($value->status ==1)
            {
              $text="Approved";
            }
            elseif ($value->status==2) {
              $text="Rejected";
            }
            else
            {
              $text="Pending";
            }

        $arr[$key]["Action"]=$text;

   
        }
        ob_end_clean(); // this
        ob_start();
         return Excel::create('Download Manufacture', function($excel) use ($arr) {
            $excel->sheet('manufacturelist', function($sheet) use ($arr)
            {
                $sheet->cell('A1:J1', function($cell) {
                $cell->setFontWeight('bold');
                });
                $sheet->fromArray($arr, null, 'A1', true);
            });
        })->download('xlsx');
      }

  }

  public function school_show_manufacture($school_Id)
  {
    $school_Id =  base64_decode($school_Id);

    $manufacturedata = Stcarbodypart::where('schoolidC',$school_Id)->get();
    if(count($manufacturedata)>0)
    {
       foreach ($manufacturedata as $key => $value) {
           $manufacturedata[$key]['student_name'] = Studentinfo::where('id',$value->studentidC)->first()->name??'N/A'; 
       }
    }
  
    return view('Manufacture.School_Show_Manufacture',compact('manufacturedata'));
    

  } 

}

