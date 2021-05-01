<?php
namespace App\Http\Controllers;

use App\Competition;
use App\Model\Competition\Competitionstore;
use App\Model\Competition\Schoolteamcomp;
use Illuminate\Http\Request;
use App\Model\StudentModel\Team_Store;
use App\Model\StudentModel\StudentTeam_Role;
use App\Model\StudentModel\UploadCompTeam;
use App\School;
use DB;
use App\Studentinfo;
use File;
use ZipArchive;
use Carbon\Carbon;
use Auth;
use Mail;
use App\Model\Competition\CronCompetition;
use App\Location;
use App\States;
use App\Awards;

class CompetitionController extends Controller
{

    public function index(Request $req)
    {
		 if(Auth::user()->role==1)
			{
				
			}
			else
			{
			 
			  if(!isset($req->session()->all()['data'][3]))
				{
					$req->session()->flash('status','You do not have right to access this module');
					
					return redirect('/');
				}		 
			}

        $eq = [];
        $eq = Competitionstore::all()->map(function($input){
                 $date=date_create($input['Start_Date']);
                 $input['Start_Date']=date_format($date,"d/m/Y"); 
                 $Ragistration_Date=date_create($input['Ragistration_Date']);
                 $input['Ragistration_Date']=date_format($Ragistration_Date,"d/m/Y"); 
                  return $input;
                      });
  

        return view('admin.Competition.competition', compact('eq'));
    }

    public function create(Request $req)
    {
		
		 if(Auth::user()->role==1)
			{
				
			}
			else
			{
			 
			  if(($req->session()->all()['data'][3]??0)!=1)
				{
					$req->session()->flash('status','You do not have right to access this module');
					
					return redirect('/');
				}		 
			}
        return view('admin.Competition.competitioncreate');
    }

    public function storeCompetition(Request $request)
    {
        $storeImage = [];
		$storeImage1=[];

        $this->validate($request, ['Competition_name' => 'required|unique:Competitionstore', 'Start_Date' => 'required', 'Ragistration_Date' => 'required','levelnameid'=>'required']);

        if ($request->hasFile('file_name'))
        {
            $allowedfileExtension = ['pdf', 'jpg', 'png', 'docx','mp4'];
            $files = $request->file('file_name');

            foreach ($files as $key=>$file)
            {

            $extension = $file->getClientOriginalExtension();
		    $filename = time().$key.'.'.$extension;
				
                $check = in_array($extension, $allowedfileExtension);

                if ($check)
                {
              $file->move('compitision_image',$filename);
                    $storeImage1[]=$filename;

                }
                else
                {
					$storeImage1[]="";
                    echo '<div class="alert alert-warning"><strong>Warning!</strong> Sorry Only Upload png , jpg , doc</div>';
					 return redirect('/competition')
            ->with('error', ' Sorry Only Upload png , jpg , doc');
                }
            }

        }

      

        $data = new Competitionstore();
        $data->Competition_name = $request->Competition_name;
        $data->levelnameid = $request->levelnameid;
        $data->Sdescription = $request->Sdescription;
        $data->Ldescription = $request->Ldescription;
        $data->Ragistration_Date = $request->Ragistration_Date;
        $data->Start_Date = $request->Start_Date;
        $data->title_name = json_encode($request->title_name);
        $data->file_name = json_encode($storeImage1);
        $data->support_title = json_encode($request->support_title);
        $data->support_size = json_encode($request->support_size);
        $data->support_formate = json_encode($request->support_formate);
        $data->support_from = json_encode($request->support_from);
        $data->academicyear = $request->academicyear;
        $data->typeid = $request->typeid;
        $data->status = 0;
        $data->save();

        return redirect('/competition')
            ->with('success', 'Competition Created Successfully');
    }

    public function show(Competition $competition)
    {
        //
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Competition  $competition
     * @return \Illuminate\Http\Response
     */
    public function edit($compid)
    {

        $edit = Competitionstore::find(base64_decode($compid));
		

        return view('admin.Competition.editcompetition', compact('edit'));
    }
	 public function referencedocument($compid)
    {

        $edit = Competitionstore::find(base64_decode($compid));
		$refdocument = json_decode($edit->title_name);
		$refdocumentfile = json_decode($edit->file_name);
       
        return view('admin.Competition.referencedocument', compact('refdocument','refdocumentfile'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Competition  $competition
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
     $break = 0;
        $storeImage = [];
		 $storeImage1 =[];
     
        
        $this->validate($request, ['Competition_name' => 'required', 'Start_Date' => 'required', 'Ragistration_Date' => 'required']);

     
			if (count($request->title_name) > 0)
        {
            // foreach ($request->file_name as $key => $image)
            // {
                // $storeImage[] = $image;
            // }
			for($i=0;$i<=count($request->title_name);$i++)
			{
				
				$k="file_name_".$i;
				
				$files[]=$request->$k??"0";
				
				
				if($files[$i]!="0"){
				 
				 if($request->file($k)==null)
				 {
					 	$filesname[$i] = 1;
				 }
				 else
				 {
					 	$filesname[$i] = $request->file($k);
				 }
			
				}
			
			}
				
        }
     
            $allowedfileExtension = ['pdf', 'jpg', 'png', 'docx'];
          
         
            foreach ($files as $key=>$file)
            {

			     if(isset($filesname[$key]))
				 {
					 
					 if($filesname[$key]!=1){
					 $extension = $filesname[$key]->getClientOriginalExtension();
					
				$filename = time().$key.'.'.$extension;
				
                $check = in_array($extension, $allowedfileExtension);
 
              
                    $filesname[$key]->move('compitision_image',$filename);
                    $storeImage1[]=$filename ;
					 }
					 else
					 {
						  $storeImage1[]=$file;
					 }
				 }
				 else
				 {
					  $storeImage1[]=0;
				 }

              
			}

        



if($break==0)
{
     $data = Competitionstore::find($request->id);
        $data->Competition_name = $request->Competition_name;
        $data->levelnameid = $request->levelnameid;
        $data->Sdescription = $request->Sdescription;
        $data->Ldescription = $request->Ldescription;
        $data->Ragistration_Date = $request->Ragistration_Date;
        $data->Start_Date = $request->Start_Date;
        $data->title_name = json_encode($request->title_name);
        $data->file_name = json_encode($storeImage1);
        $data->support_title = json_encode($request->support_title);
        $data->support_size = json_encode($request->support_size);
        $data->support_formate = json_encode($request->support_formate);
        $data->support_from = json_encode($request->support_from);
        $data->academicyear = $request->academicyear;
        $data->typeid = $request->typeid;
        $data->status = 1;
        $data->save();
    
        return redirect('/competition')
            ->with('success', 'Competition updated  successfully');
}
else
{
    return redirect('/editcompetition/'.base64_encode($request->id))
            ->with('success', 'Sorry Only Upload png , jpg , doc');
  
}       


echo 1;
die;
      

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Competition  $competition
     * @return \Illuminate\Http\Response
     */
    public function destroy($compid)
    {

        Competitionstore::find(base64_decode($compid))->delete();
        return redirect('/competition')
            ->with('success', 'Competition deleted  successfully');
    }

    public function nominate($compid1,Request $req)
    {
        if(Auth::user()->role==1)
			{
				
			}
			else
			{
			 
			  if(($req->session()->all()['data'][3]??0)!=1)
				{
					$req->session()->flash('status','You do not have right to access this module');
					
					return redirect('/sponsershipadmin');
				}		 
			}
        $compid = base64_decode($compid1);
         $type = Competitionstore::where('id',$compid)->first();"College";
       
        if($type->typeid!='1')
        {
            
        $schoolTeam = Team_Store::all();
        $school = School::where('type','school')->get();
        $competion_name=Competitionstore::where('id',$compid)->select('Competition_name')->get()->toArray();
        foreach ($school as $school1)
        {
            $team[$school1->id . "_" . $school1
                ->school_name] = Team_Store::where('school_id', $school1->id)
                ->select('*')
                ->get()->map(function ($data) use ($school1, $compid)
            {
                $data->schoolname = $school1->school_name;
                $data->shoolidincomp = isset(Schoolteamcomp::where('school_id', $school1->id)
                    ->where('cmpid', $compid)->first()
                    ->status) ? 1 : 0;
                $data->shoolidincomp1 = Schoolteamcomp::where('school_id', $school1->id)
                    ->where('cmpid', $compid)->where('tmpid', $data->id)
                    ->count();
                return $data;
            })->toArray();

        }
    }
    else
    {
       //   $schoolTeam = Team_Store::all();
       //  $school = School::where('type','!=','school')->get()->toArray();
       //  $schoolid = array_column($school, 'id');
        $f1seniorNominate = StudentTeam_Role::where('typeofstudent','F1Senior')->get();
                            Schoolteamcomp::where('cmpid',$compid)->delete();
                            CronCompetition::where('cmpid',$compid)->delete();

        if(count($f1seniorNominate)>0)
        {
             
             foreach ($f1seniorNominate as $key => $value) {
                 

                    $data = new Schoolteamcomp();
                    $data->school_id = $value->schoolid;
                    $data->cmpid = $compid;
                    $data->tmpid = $value->teamId;
                    $data->status = 0;
                    $data->typeid='1';
                    $data->save();

                    $cron = new CronCompetition();
                    $cron->school_id = $value->schoolid;
                    $cron->cmpid = $compid;
                    $cron->tmpid = $value->teamId;
                    $cron->status = 0;
                    $cron->typeid='1';
                    $cron->save();
                }
                // $req->session()->flash('F1SeniorMessage', 'Post was created!');
                return redirect('competition/')->with('F1SeniorMessage', 'Nominated   successfully');
            
        }
        else
        {

        }

       // dd($f1seniorNominate);
       //  dd($school);
       //  $competion_name=Competitionstore::where('id',$compid)->select('Competition_name')->get()->toArray();
       //  foreach ($school as $school1)
       //  {
       //      $team[$school1->id . "_" . $school1
       //          ->school_name] = Team_Store::where('school_id', $school1->id)
       //          ->select('*')
       //          ->get()->map(function ($data) use ($school1, $compid)
       //      {
       //          $data->schoolname = $school1->school_name;
       //          $data->shoolidincomp = isset(Schoolteamcomp::where('school_id', $school1->id)
       //              ->where('cmpid', $compid)->first()
       //              ->status) ? 1 : 0;
       //          $data->shoolidincomp1 = Schoolteamcomp::where('school_id', $school1->id)
       //              ->where('cmpid', $compid)->where('tmpid', $data->id)
       //              ->count();
       //          return $data;
       //      })->toArray();

       //  }
        // redirect('competition')
    }


         $competion_name=Competitionstore::where('id',$compid)->select('Competition_name')->get()->toArray();
         //dd($competion_name[0]['Competition_name']);
       
        return view('admin.Competition.nominate', compact('compid', 'team'),['competion_name'=>$competion_name]);

    }

     public function nominate_team_List($compid1)
     {
        $students = DB::table('students')->limit(10)->get();

        $schoolname = DB::table('schools')->select('school_name')
            ->where('id', 45)->first();
                $schooldp=45;
        $compid = base64_decode($compid1);
        $fetchteam = Schoolteamcomp::select('tmpid')->where('cmpid',$compid)->where('typeid',1)->get()->toArray();
        $teamidindatabase = array_column($fetchteam, 'tmpid');
    
        $compedetal = Competitionstore::where('id',$compid)->where('typeid',1)->first();
        $team = Team_Store::where('typeofstudent','F1Senior')->get();
        
    
        return view('admin.competitionTeam', compact('students', 'schooldp', 'schoolname','compid','team','teamidindatabase','compedetal'));

     }

 public function competitionTeamdata()
    {
        
         $competition = Competitionstore::where('id',$_GET['compid'])->where('typeid',1)->where('academicyear', $_GET['year'])->get();   
              
          return $Response = array(
            'competition' => $competition
        );  

        // $plan = DB::table('schoolplanmaster')->where('schoolid', $_GET['school_id'])->where('year', $_GET['year'])->join('memberships', 'memberships.id', '=', 'schoolplanmaster.plan')
        //     ->select('memberships.id', 'memberships.name')
        //     ->distinct('memberships.id')
        //     ->get();
        // return $Response = array(
        //     'plan' => $plan
        // );
    }
      public function submitnominatecomTeam(Request $req)
      {
        
        if($req->team==null)
        {
                            Schoolteamcomp::where('cmpid',$req->compid)->delete();
                            CronCompetition::where('cmpid',$req->compid)->delete(); 
                             return redirect('nominate-team-List/'.base64_encode($req->compid))->with('F1SeniorMessage', 'Nominated   successfully');

        }
        $f1seniorNominate = StudentTeam_Role::where('typeofstudent','F1Senior')->whereIn('teamId',$req->team)->get();
                            Schoolteamcomp::where('cmpid',$req->compid)->delete();
                            CronCompetition::where('cmpid',$req->compid)->delete();

        if(count($f1seniorNominate)>0)
        {
             
             foreach ($f1seniorNominate as $key => $value) {
                 

                    $data = new Schoolteamcomp();
                    $data->school_id = $value->schoolid;
                    $data->cmpid = $req->compid;
                    $data->tmpid = $value->teamId;
                    $data->status = 0;
                    $data->typeid='1';
                    $data->save();

                    $cron = new CronCompetition();
                    $cron->school_id = $value->schoolid;
                    $cron->cmpid = $req->compid;
                    $cron->tmpid = $value->teamId;
                    $cron->status = 0;
                    $cron->typeid='1';
                    $cron->save();
                }
                // $req->session()->flash('F1SeniorMessage', 'Post was created!');
                return redirect('nominate-team-List/'.base64_encode($req->compid))->with('F1SeniorMessage', 'Nominated   successfully');
            
        }

      }


    public function nominateschoolteam(Request $req)
    {
       
       $selectteamid=[];

         $value=Schoolteamcomp::
           where('school_id',$req->schoolid)
           ->where('cmpid',$req->cmpid)
           ->get()->toArray();

           $team=array_column($value, 'tmpid');
           if($req->schoolTeam==null)
           {
             $selectteamid=array();
           }
           else
           {
               $selectteamid=$req->schoolTeam;
           }
       
$teamids=array_diff($team, $selectteamid);

if($teamids==array())
{
         $value1=Team_Store::
           where('school_id',$req->schoolid)
           ->get()->toArray();
           $teamtestid=array_column($value1, 'id');
		   
    Schoolteamcomp::where('status',0)->where('cmpid',$req->cmpid)->whereIn('tmpid', $teamtestid)->delete();
    CronCompetition::where('status',0)->where('cmpid',$req->cmpid)->whereIn('tmpid', $teamtestid)->delete();
   UploadCompTeam::WhereIn('team_id', $teamids)->where('competition_id',$req->cmpid)->delete();
}
else
{
Schoolteamcomp::where('cmpid',$req->cmpid)->whereIn('tmpid', $teamids)->delete();
CronCompetition::where('cmpid',$req->cmpid)->whereIn('tmpid', $teamids)->delete();
UploadCompTeam::WhereIn('team_id', $teamids)->where('competition_id',$req->cmpid)->delete();
}

       

        if($req->schoolTeam!=null)
         {
        foreach ($req->schoolTeam as $value)
        {
          $count = Schoolteamcomp::where('school_id',$req->schoolid)
                 ->where('cmpid',$req->cmpid)->where('tmpid',$value)->where('status',1)->first();

                if($count==null)
                {
                    $data = new Schoolteamcomp();
                    $data->school_id = $req->schoolid;
                    $data->cmpid = $req->cmpid;
                    $data->tmpid = $value;
                    $data->status = 0;
                    $data->save();

                    $cron = new CronCompetition();
                    $cron->school_id = $req->schoolid;
                    $cron->cmpid = $req->cmpid;
                    $cron->tmpid = $value;
                    $cron->status = 0;
                    $cron->save();
                } 
        }
    }
   

      return redirect('nominate/'.base64_encode($req->cmpid));

    }

    public function nominatedschooldelete($schiid)
    {
        $comp_idsch = explode("_", base64_decode($schiid));

        Schoolteamcomp::where('school_id', $comp_idsch[1])->where('cmpid', $comp_idsch[0])->delete();
        CronCompetition::where('school_id', $comp_idsch[1])->where('cmpid', $comp_idsch[0])->delete();
        return redirect('nominate/' . base64_encode($comp_idsch[0]));
    }

    public function downloadschoolcompitiiondocument($schoolid)
    {
        $school_id = base64_decode($schoolid);

        $data = [];
        $downloadcompdocument = [];
        $compids = Schoolteamcomp::where('school_id', $school_id)->groupBy('cmpid')
            ->get();

        // UploadCompTeam
        if (count($compids) == 0)
        {
            echo 'Not Found Releted Data';
        }
        else
        {

            foreach ($compids as $key => $comp)
            {
                $cmpid = $comp->cmpid;
                if (isset($school_id) && isset($cmpid))
                {
                    $data[$key]['School_Id'] = school::find($school_id)->school_name;
                    $data[$key]['Comp_Id'] = Competitionstore::find($comp->cmpid)->Competition_name;

                    $data[$key]['uploaddocument'] = UploadCompTeam::where('school_id', $school_id)->where('competition_id', $comp->cmpid)
                        ->get()->map(function ($data) use ($school_id, $cmpid)
                    {

                        $data->CompitionName = Competitionstore::find($cmpid)->Competition_name;
                        $data->TeamName = Team_Store::find($data->team_id)->team_Name;
                        $data->StudentName = Studentinfo::find($data->student_id)->name;
                        return $data;
                    });
                }

            }

            foreach ($data as $key => $data1)
            {

                foreach ($data1['uploaddocument'] as $key => $value)
                {
                    $downloadcompdocument[] = $value;

                }
            }

        }

        return view('admin.Competition.documeentdownloadPreview', compact('downloadcompdocument'));

    }

    public function viewschoolincompition($compitionid)
    {
		
        $cmpid = base64_decode($compitionid);
		
        if (isset($cmpid))
        {
            // $cmpid
            $compitionname = Competitionstore::find($cmpid)->Competition_name;
			
            $data = UploadCompTeam::orderBy('created_at','desc')->where('competition_id', $cmpid)->get()->map(function ($data) use ($cmpid)
            {
				
                $data->CompitionName = isset(Competitionstore::find($cmpid)->Competition_name)?Competitionstore::find($cmpid)->Competition_name:'N/A';
                $data->TeamName = isset(Team_Store::find($data->team_id)->team_Name)?Team_Store::find($data->team_id)->team_Name:'N/A';

                $data->school = isset(school::find($data->school_id)->school_name)?school::find($data->school_id)->school_name:'N/A';
                $data->StudentName = isset(Studentinfo::find($data->student_id)->name)?Studentinfo::find($data->student_id)->name:'N/A';
                return $data;
            });
			
			$team=UploadCompTeam::select('team_id')->where('competition_id', $cmpid)->get()->map(function($data){
				$data->teamid;
			})->toArray();
             $data1=Schoolteamcomp::whereNOTIN(
		'tmpid',$team)->where('cmpid',$cmpid)->get()->map(function ($data) use ($cmpid)
            {
				
                $data->CompitionName = isset(Competitionstore::find($cmpid)->Competition_name)?Competitionstore::find($cmpid)->Competition_name:'N/A';
                $data->TeamName = isset(Team_Store::find($data->tmpid)->team_Name)?Team_Store::find($data->tmpid)->team_Name:'N/A';

                $data->school = isset(school::find($data->school_id)->school_name)?school::find($data->school_id)->school_name:'N/A';
                $data->StudentName = isset(Studentinfo::find($data->student_id)->name)?Studentinfo::find($data->student_id)->name:'N/A';
			    $data->documentupload=0;
			
                return $data;
            });;
		
				
             $data->merge($data1);
			
            $downloadcompdocument = $data;
		
            // dd($downloadcompdocument);
            return view('admin.Competition.documeentdownloadPreview', compact('downloadcompdocument', 'compitionname', 'cmpid'));

        }

    }

    public function downloadAlbum($cmpid)
    {
        // $archive_name = "archive12.zip"; // name of zip file
        // $archive_folder ='docs'; // the folder which you archivate
        // $zip = new ZipArchive;
        // if ($zip -> open(public_path($archive_name ), ZipArchive::CREATE) === TRUE)
        // {
        // $dir = $archive_folder;
        // $dir = preg_replace('/[\/]{2,}/', '/', $archive_folder."/");
        // $dirs = array($dir);
        // $zip -> addEmptyDir("XYZ/ABC");
        // while (count($dirs))
        // {
        //$dir = current($dirs);
        //$zip -> addEmptyDir("XYZ/ABC");
        //$dh = opendir($dir);
        // while($file = readdir($dh))
        // {
        // if ($file != '.' && $file != '..')
        // {
        // if (is_file($file))
        // $zip -> addFile($dir.$file, $dir.$file);
        // elseif (is_dir($file))
        // $dirs[] = $dir.$file."/";
        // }
        // }
        //closedir($dh);
        //array_shift($dirs);
        //}
        //}
        //$zip->close();
        $zip = new ZipArchive;
        // $zip->open('/home/harshdeep/Desktop/testzip'.time().'.zip', \ZipArchive::CREATE);
        $fileName = 'Competition1.zip';

        if ($zip->open(public_path($fileName) , ZipArchive::CREATE) === true)
        {
            $cmpid = base64_decode($cmpid);
            $createfolder = UploadCompTeam::where('competition_id', $cmpid)
            // ->groupBy('team_id')
            ->get()->map(function ($data) use ($cmpid)
            {
                $data->CompitionName = Competitionstore::find($cmpid)->Competition_name;
                $data->TeamName = Team_Store::find($data->team_id)->team_Name;
                $data->school = school::find($data->school_id)->school_name;
                $data->StudentName = Studentinfo::find($data->student_id)->name;
                return $data;
            });

          
            foreach ($createfolder as $key => $createfolder)
            {

                if (file_exists($createfolder->image))
                {
                    $zip->addFile(public_path('team/doc_image/' . $createfolder->image) , 'xyz/' . $createfolder->school . '/' . $createfolder->TeamName . '/' . $createfolder->image);
                    $zip->close();
                }
            }
        }
    }

    // Start Competition invite fir team wise student
    

    public function croncompetition()
    {
		
       $runcroncompetition = CronCompetition::where('status', 0)->limit(10)
           ->get();
			// $runcroncompetition = CronCompetition::orderby('id','desc')->limit(1)
            // ->get();
			
        foreach ($runcroncompetition as $key => $runcron)
        {
          
            $schools = School::find($runcron->school_id);
			
            $competition = Competitionstore::find($runcron->cmpid);


        CronCompetition::where('school_id', $runcron->school_id)
                        ->where('tmpid', $runcron->tmpid)
                        ->where('cmpid', $runcron->cmpid)
                        ->update(['status' => 1]);
             
            $todaydate = strtotime(date('m/d/Y'));
			$starttime=strtotime($competition->Start_Date);
            // $todaydate = strtotime(date('11/18/2019'));
            
            $registrationdate = strtotime($competition->Ragistration_Date);
           // echo $registrationdate."<=".$todaydate."||".$todaydate."<".$starttime;
           // echo "<br>";
            
            if (($registrationdate <= $todaydate) && ($todaydate<$starttime))
            {
              // echo $registrationdate.">=".$todaydate."||".$todaydate."<".$starttime;
              // die;
                $team = Team_Store::find($runcron->tmpid);
                    

                if ($team != null && $competition != null)
                {
                    $ss = explode("_", $team->student_id);
                    $stu = $ss[0];
                    $type = $ss[1];
                    switch ($type)
                    {
                        case 'student':
                            $competition_details1 = StudentTeam_Role::where('teamId', $team->id)
                                ->get()->map(function ($id) use ($competition, $team, $stu)
                            {

                                $id->team_name = $team->team_Name;
                                $id->studentemail = Studentinfo::where('id', $id->studentid)
                                    ->first()->studentemail;
                                $id->studentname = Studentinfo::find($id->studentid)->name;
                                $id->competitionname = $competition->Competition_name;
                                $id->Shortdesc = $competition->Ldescription;
                                $id->registrationdate = $competition->Ragistration_Date;
                                $id->Start_Date = $competition->Start_Date;
                                return $id;
                            })->toArray();

                            $competition_details2 = Team_Store::where('id', $team->id)
                                ->get()->map(function ($id) use ($competition, $team, $stu)
                            {
                                $id->team_name = $team->team_Name;
                                $id->teamId = $id->id;
                                $id->studentid = (int)$stu;
                                $id->studentemail = Studentinfo::where('id', $stu)->first()->studentemail;
                                $id->studentname = Studentinfo::find($id->studentid)->name;
                                $id->competitionname = $competition->Competition_name;
                                $id->Shortdesc = $competition->Ldescription;
                                $id->registrationdate = $competition->Ragistration_Date;
                                $id->Start_Date = $competition->Start_Date;
                                return $id;
                            })->toArray();
                            $competition_details = array_merge($competition_details1, $competition_details2);
                        break;
                        default:
                            $competition_details = StudentTeam_Role::where('teamId', $team->id)
                                ->get()->map(function ($id) use ($competition, $team)
                            {
                                $id->team_name = $team->team_Name;
                                $id->studentemail = Studentinfo::find($id->studentid)->studentemail;
                                $id->studentname = Studentinfo::find($id->studentid)->name;
                                $id->competitionname = $competition->Competition_name;
                                $id->Shortdesc = $competition->Ldescription;
                                $id->registrationdate = $competition->Ragistration_Date;
                                $id->Start_Date = $competition->Start_Date;
                                return $id;
                            })->toArray();

                    }
                    
                    foreach ($competition_details as $key => $value)
                    {
                        $data = array(
                            "studentname" => $value['studentname'],
                            'competition' => $value['competitionname']." ".'F1 in Schools™ India',
                            'email' => $value['studentemail'],
                            'Shortdesc' => $value['Shortdesc'],
                            'Start_Date' => $value['Start_Date']
                            
                        );
						
                        Mail::send('Mail.competitioninvite', $data, function ($message) use ($data,$value)
                        {
							
							
                            $message->to([$value['studentemail']])
                                ->subject($data['competition']);
                             $message->from('noreply@timeofsports.com','F1 in Schools™ India');
                        });
						

                    }

                  CronCompetition::where('school_id', $runcron->school_id)
                        ->where('tmpid', $runcron->tmpid)
                        ->where('cmpid', $runcron->cmpid)
                        ->update(['status' => 1]);



                    

                }


            }
        }

        // End Competition invite fir team wise student
        
    }

public function awards($compid)
{
    $comid = base64_decode($compid);
    $comp = Competitionstore::where('id',$comid)->first()??'N/A';
    $showawards = Awards::where('compid',$comid)->orderby('id','desc')->get();
    foreach ($showawards as $key => $value) {
        $teid = Awards::select('teamid')->where('compid',$comid)->get()->toArray();
        $tid = Team_Store::select('team_Name','school_id')->where('id',$value->teamid)->first();
       $school = School::where('id',$tid->school_id)->first()->school_name;
        $showawards[$key]->team = $tid->team_Name;
        $showawards[$key]->schoolname = $school;
        $showawards[$key]->awardsname=$value->awardsname;
    }
     return view('admin.Competition.awards', compact('comp','compid','showawards'));
}
public function add_awards($compid)
{
    $comid = base64_decode($compid);
    $comp = Competitionstore::where('id',$comid)->first()??'N/A';
    $loc = States::all();

    $zone = Location::all();
    $schoolv = Schoolteamcomp::select('school_id')->where('cmpid',$comid)
                   ->groupby('school_id')->get();
    foreach ($schoolv as $key => $value) {
        $schoolv[$key]->Schoolname = School::where('id',$value->school_id)
                      ->first()->school_name??'N/a';
                       
    }         


    return view('admin.Competition.add_awards', compact('comp','compid','loc','zone','schoolv'));
}


    public function getnominateteams($v,$c,$a)
    {  
        $comid = base64_decode($c);
        
        $teams1 = Schoolteamcomp::select('tmpid')->where('cmpid',$comid)
                   ->whereIN('school_id',explode(",",base64_decode($v)))->get();

        $editawards = Awards::whereIN('schooldid',explode(",",base64_decode($v)))->where('compid',$comid)->where('awardid',$a)->get()->toArray();
       $teamid = array_column($editawards, 'teamid');

      // return json_encode($teamid);
        foreach ($teams1 as $key => $value) {
            $check = Team_Store::where('id',$value->tmpid)
              ->first()->team_Name??'N/A';
              if($check!='N/A')
              {
                
               $TeamName =Team_Store::where('id',$value->tmpid)
              ->first()??'N/A';
               $schoolname = school::where('id',$TeamName->school_id)->first()->school_name;

               $teams1[$key]->teamname = $TeamName->team_Name."/".$schoolname;
              }
              else
               {
                 Schoolteamcomp::where('tmpid',$value->tmpid)->delete();
               }


        }
        return view('datas.teams',compact('teams1','teamid'));
    }

        public function getnominateteamsadd($v,$c)
    {  
        $comid = base64_decode($c);
        
        $teams1 = Schoolteamcomp::select('tmpid')->where('cmpid',$comid)
                   ->whereIN('school_id',explode(",",base64_decode($v)))->get();

       //  $editawards = Awards::whereIN('schooldid',explode(",",base64_decode($v)))->where('compid',$comid)->where('awardid',$a)->get()->toArray();
       // $teamid = array_column($editawards, 'teamid');

      // return json_encode($teamid);
        foreach ($teams1 as $key => $value) {
            $check = Team_Store::where('id',$value->tmpid)
              ->first()->team_Name??'N/A';
              if($check!='N/A')
              {
                
               $TeamName =Team_Store::where('id',$value->tmpid)
              ->first()??'N/A';
               $schoolname = school::where('id',$TeamName->school_id)->first()->school_name;

               $teams1[$key]->teamname = $TeamName->team_Name."/".$schoolname;
              }
              else
               {
                 Schoolteamcomp::where('tmpid',$value->tmpid)->delete();
               }


        }
        return view('datas.teams1',compact('teams1'));
    }

    public function awardsstroe(Request $req)
    {

       $awardid = uniqid();
        if($req->teams!=null)
        {
            $showawards = Awards::where('awardid',$awardid)->count();
            if($showawards==0)
            {
            foreach ($req->teams as $key => $value) {
                $aw = new Awards();
                $aw->awardid = $awardid;
                $aw->awardsname = $req->awards[0];
                $aw->texteditorcontent = $req->awrdscontent[0];
                $aw->schooldid = Team_Store::where('id',$value)->first()->school_id;
                $aw->compid = $req->compid;
                $aw->teamid = $value;
                $aw->save();
            }
        }
        }
        return redirect('awards/'.base64_encode($req->compid));
    }

    public function editawards($awards)
    {
        $editawards = Awards::where('awardid',$awards)->get()->toArray();
        $comid = $editawards[0]['compid'];
        $compid = $editawards[0]['compid'];
        $awardname = $editawards[0]['awardsname'];
        $awardcontent = $editawards[0]['texteditorcontent'];
        $comp = Competitionstore::where('id',$comid)->first()??'N/A';

        $teamid = array_column($editawards, 'teamid');

         $schoolid = array_column($editawards, 'schooldid');
         $schoolid2 = array_unique($schoolid);

        $schoolv = Schoolteamcomp::select('school_id')
                      ->where('cmpid',$editawards[0]['compid'])
                      ->groupby('school_id')->get();
    foreach ($schoolv as $key => $value) {
        $schoolv[$key]->Schoolname = School::where('id',$value->school_id)
                      ->first()->school_name??'N/a';
                       
    } 

    /***********************Team ************************************/
         $teams1 = Schoolteamcomp::select('tmpid')->where('cmpid',$comid)
                   ->whereIN('school_id',$schoolid2)->get();

        foreach ($teams1 as $key => $value) {
            $check = Team_Store::where('id',$value->tmpid)
              ->first()->team_Name??'N/A';
              if($check!='N/A')
              {
                
               $TeamName =Team_Store::where('id',$value->tmpid)
              ->first()??'N/A';
               $schoolname = school::where('id',$TeamName->school_id)->first()->school_name;

               $teams1[$key]->teamname = $TeamName->team_Name."/".$schoolname;
              }
              else
               {
                 Schoolteamcomp::where('tmpid',$value->tmpid)->delete();
               } 
        }

        /********************end team***********************************/
      return view('admin.Competition.edit_awards', compact('compid','schoolid2','schoolv','comid','comp','teams1','teamid','awardname','awardcontent','awards'));
    }

    public function editawardsstore(Request $req)
    {
         if($req->teams!=null)
        {  Awards::where('awardid',$req->awardsid)->delete();
            $showawards = Awards::where('awardid',$req->awardsid)->count();
            if($showawards==0)
            {
            foreach ($req->teams as $key => $value) {
                $aw = new Awards();
                $aw->awardid = $req->awardsid;
                $aw->awardsname = $req->awards[0];
                $aw->texteditorcontent = $req->awrdscontent[0];
                $aw->schooldid = Team_Store::where('id',$value)->first()->school_id;
                $aw->compid = $req->compid;
                $aw->teamid = $value;
                $aw->save();
            }
        }
        }
        return redirect('awards/'.base64_encode($req->compid));
    }

    public function  deletewards($awardsid,$compid,$teamid){
    Awards::where('awardid',$awardsid)->where('teamid',$teamid)->delete();
   return redirect('awards/'.base64_encode($compid));
}

}
