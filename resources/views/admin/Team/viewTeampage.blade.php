 @extends(Auth::user()->role==2? 'layouts.coadmin':'layouts.admin')
 @section('content')
 <div class="content-heading">
               <div><h3>Team Name:{{nl2br($ts->team_Name)}}</h3>
                  <small data-localize="dashboard.WELCOME"></small>
               </div>
                <div class="ml-auto">
                  <div class="btn-group">
                     <button type="button" onclick="goBack()" class="btn btn-info">Go Back</button>
                  </div>
               </div>
</div>
<script>
function goBack() {
  window.history.back();
}
</script>

    

@if($errors->any())
   @foreach($errors->all() as $err)
      <div class="alert alert-danger">{{$err}}</div>
   @endforeach
@endif
@if(session()->has('success'))
   <div class="alert alert-info">{{session()->get('success')}}</div>
@endif

@if(session()->has('alert'))
   <div class="alert alert-info">{{session()->get('alert')}}</div>
@endif

  <div class="card-group">
    <div class="card text-primary border-primary">
      <div class="card-body text-left">
        <div class="col-md-12">
          <div class="row">
           <div class="col-md-4">
           
            @if($ts->team_Image==null)
           <img style="height: 100px;width:100px; border-radius: 50%;" src="{{url('team/pro.jpg')}}">
           @else
           <img style="height: 100px;width:100px; border-radius: 50%;" src="{{url('team/')}}/{{ $ts->team_Image }}">
           @endif

           </div>
           <?php $ids=$ts->id."_".$ts->student_id."_".$ts->school_id;?>
           <div class="col-md-8">
           

            <p class="card-text">Team Name:&nbsp;&nbsp;&nbsp;&nbsp;{{$ts->team_Name}}</p>

            @if(count($deatials))
  @foreach($deatials as $ts222)
   <p class="card-text">Total no of Member:&nbsp;&nbsp;&nbsp;&nbsp;{{count($ts222)}}</p>
  @endforeach
  @endif
           
            <p class="card-text">Team Description :&nbsp;&nbsp;&nbsp;&nbsp;{{$ts->team_Description}}</p>
			  
           </div>

          </div>
      </div>
      </div>
    </div>
  </div>
  <div class="card-group">
     <div class="card text-primary border-primary">
      <div class="card-body text-left">

        <?php $schoolid = $schoolinfo->id;?>
        <p class="card-text"><strong style="color:black;" class="m-1 pr-1">School Name :&nbsp;&nbsp;&nbsp;&nbsp;</strong><a href="{{url('schoolv')}}/{{base64_encode($schoolid)}}">{{$schoolinfo->school_name}}</a></p>
        <p class="card-text"><strong style="color:black;" class="m-1 pr-1">Address :&nbsp;&nbsp;&nbsp;&nbsp;</strong>{{$schoolinfo->address}}</p>
		
      </div>
  </div>
  </div>
  <br>
<!-- ******************************************************************************* -->
@if(Auth::user()->role==1)
   <p  class="card-text"><h3>&nbsp;&nbsp;Available Block :{{$block}} @if($level==1)(Plan:- Individual) @endif @if($level==2) (Plan:- Team) @endif</h3></p> <br>
    <p  class="card-text"><h3>&nbsp;&nbsp;Alloted Block :{{$blocks}} @if($level==1)(Plan:- Individual) @endif @if($level==2) (Plan:- Team) @endif</h3></p> <br>
    
	 <div class=" col-md-6">
     <div class="card text-primary border-primary">
      <div class="card-body text-left">
           <form action="{{url('addblock')}}" method='POST'>
			   @csrf
		  <div class="form-group">
			
			<input type="number" required=""  name='block'    min="0" class="form-control" placeholder="Block" id="email">
			<input type="hidden"  name="teamid" class="form-control" placeholder="Block" value="{{$ts->id}}">
		  </div>
		   <div class="form-group">
			<button type="submit" class="btn btn-primary" onclick = "getConfirmation();">Add Block</button>
		  </div>
       </div>
	   </form>
  </div>
  </div>

     <script type = "text/javascript">
         
            function getConfirmation() {
               var retVal = confirm("Do you want to modify blocks?");
               if( retVal == true ) {
                  // document.write ("User wants to continue!");
                  return true;
               }
               else {
                event.preventDefault();
                  // document.write ("User does not want to continue!");
                  return false;
               }
            }
         //-->
      </script>
  <br>
  <div class="card-group col-md-6">
     <div class="card text-primary border-primary">
      <div class="card-body text-left">
           <form action="{{url('removeblock')}}" method='POST'>
		  <div class="form-group">
			 @csrf
			<input type="number" required="" name='block'  max="{{$block}}"    min="0" class="form-control" placeholder="Block" id="email">
			<input type="hidden" name="teamid"   class="form-control" placeholder="Block" value="{{$ts->id}}">
		  </div>
		   <div class="form-group">
			<button type="submit" class="btn btn-primary" onclick = "getConfirmation();">Remove Block</button>
		  </div>
       </div>
	   </form>
  </div>
  </div>
      @else
      @if((session('data')[14]??0)==1)
         <p  class="card-text"><h3 hidden="">&nbsp;&nbsp;Available Block :{{$block}} @if($level==1)(Plan:- Individual) @endif @if($level==2) (Plan:- Team) @endif</h3></p> <br>
    <p  class="card-text"><h3 hidden="">&nbsp;&nbsp;Alloted Block :{{$blocks}} @if($level==1)(Plan:- Individual) @endif @if($level==2) (Plan:- Team) @endif</h3></p> <br>
    
   <div  class=" col-md-6">
     <div class="card text-primary border-primary">
      <div class="card-body text-left">
           <form action="{{url('addblock')}}" method='POST'>
         @csrf
      <div class="form-group">
      
      <input type="number" required=""  name='block'    min="0" class="form-control" placeholder="Block" id="email">
      <input type="hidden"  name="teamid" class="form-control" placeholder="Block" value="{{$ts->id}}">
      </div>
       <div class="form-group">
      <button type="submit" class="btn btn-primary" onclick = "getConfirmation();">Add Block</button>
      </div>
       </div>
     </form>
  </div>
  </div>

     <script type = "text/javascript">
         
            function getConfirmation() {
               var retVal = confirm("Do you want to modify blocks?");
               if( retVal == true ) {
                  // document.write ("User wants to continue!");
                  return true;
               }
               else {
                event.preventDefault();
                  // document.write ("User does not want to continue!");
                  return false;
               }
            }
         //-->
      </script>
  <br>
  <div class="card-group col-md-6" >
     <div class="card text-primary border-primary">
      <div class="card-body text-left">
           <form action="{{url('removeblock')}}" method='POST'>
      <div class="form-group">
       @csrf
      <input type="number" required="" name='block'  max="{{$block}}"    min="0" class="form-control" placeholder="Block" id="email">
      <input type="hidden" name="teamid"   class="form-control" placeholder="Block" value="{{$ts->id}}">
      </div>
       <div class="form-group">
      <button type="submit" class="btn btn-primary" onclick = "getConfirmation();">Remove Block</button>
      </div>
       </div>
     </form>
  </div>
  </div>
      @endif
      
      @endif

  <!-- /***************************************************************************/ -->

  <br>
<h3>Complete Block Summary</h3>
 
  <table class="table">
  <thead  class="thead-dark">
    <tr>
      <th>S.No</th>
      <th>Remark</th>
      <th>Blocks modified</th>
      <th>Total Available block</th>
      <th>Date</th>
      <th>Updated By</th>
    </tr>
  </thead>
  <tbody>

  <?php $i=1;?>



      @if(count($userAndAssociate))
  @foreach($userAndAssociate as $row)
    @if(isset($row->type))
    <tr>
      <td >{{$i}}</td>
     <?php  $ids = $row->schoolid."_".$row->student_id?>
       <td ><a href="{{url('orderiddetails')}}/{{base64_encode($row->order_id)}}">{{$row->order_id}}</a></td>
      <td>
        {{$row->quantity}} 
      </td>
      <td >{{$block}}</td>
        <?php $date1=date_create($row->created_at);
                    $re=date_format($date1,"d/m/Y");?>
      <td>{{$re}}</td>
      <td ><a href="{{url('viewstudentinfoadmin')}}/{{base64_encode($ids)}}">{{$row->Studentname}}</a></td>
    </tr>
    @else
    <tr>
      <td >{{$i}}</td>
       <td>Updated by Admin</td>
      <td>
         @if($row->block>0)
            Added: {{$row->block}} 
         @else
         <?php $remove = abs($row->block) ?>
          Removed: {{$remove}} 
         @endif
       

      </td>
      <td >{{$block}}</td>
        <?php $date1=date_create($row->created_at);
                    $re=date_format($date1,"d/m/Y");?>
      <td>{{$re}}</td>
      <td >Admin</td>
    </tr>
    @endif

    <?php $i=$i+1;?>
      @endforeach
 
      @endif  
  </tbody>
</table>

  <br>
<h3>Created By {{$deatials[0][0]['teamCreator']}}</h3>
@if(Auth::user()->role==1)
 <div class="float-right"> <a href="{{url('editteambyad')}}/{{base64_encode($ids)}}"><button type="button" class="btn btn-outline-success">Edit Team</button></a></div>
  @else
  @if((session('data')[14]??0)==1)
  <div class="float-right"> <a href="{{url('editteambyad')}}/{{base64_encode($ids)}}"><button type="button" class="btn btn-outline-success">Edit Team</button></a></div>
  @endif
   @endif

  <table class="table">
  <thead  class="thead-dark">
    <tr>
      <th>S.No</th>
      <th>Student Name</th>
      <th>Designation</th>
      <th>Contact Number</th>
      <th>Student Email</th>
      <th>Class</th>
    </tr>
  </thead>
  <tbody>
  @if(count($deatials))
  @foreach($deatials as $ts)
  <?php $i=1;?>
 
  @foreach($ts as $row)

    <?php $ids=$row['schoolid']."_".$row['studentid'];?>
    <tr>
      <td >{{$i}}</td>
      <td ><a href="{{url('viewstudentinfoadmin')}}/{{base64_encode($ids)}}">{{$row['studentname']}}</a></td>
      <td >{{$row['studentRole']}}</td>
      <td >{{$row['mobileno']}}</td>
      <td>{{$row['studentemail']}}</td>
      <td >{{$row['class']}}</td>
    </tr>
    <?php $i=$i+1;?>
      @endforeach
      @endforeach
      @endif
  </tbody>
</table>
<br>
<h3>List of Competitions</h3>
  <table class="table">
  <thead  class="thead-dark">
    <tr>
      <th>S.No</th>
      <th>Competition Name</th>
      <th>Short Description</th>
       <th>Long Description</th>
        <th>Ragistration Date</th>
        <th>Start Date</th>
    </tr>
  </thead>
  <tbody>
   @if($deatials[0][0]['comp']!='N/A')
        @if(count($deatials[0][0]['comp']))
        <?php $j=1;?>
  @foreach($deatials[0][0]['comp'] as $ts)
  @foreach($ts->cname as $t)
  
    <tr>
      <td>{{$j}}</td>
      <td><a href="{{url('referencedocument')}}/{{base64_encode($t->id)}}">{{$t['Competition_name']}}</a></td>
      <td>{{$t['Sdescription']}}</td>
      <td>{{$t['Ldescription']}}</td>
      <?php $date1=date_create($t['Ragistration_Date']);
                    $re=date_format($date1,"d/m/Y");
           
$date2=date_create($t['Start_Date']);
                    $st=date_format($date2,"d/m/Y");
                    ?>

      <td>{{$re}}</td>
      <td>{{$st}}</td>
    </tr>
     <?php $j=$j+1;?>
      @endforeach
      @endforeach
      @endif
@else
<th>N/A</th>
@endif
  </tbody>
</table>
<br>



<h3>List of Uploaded Online Documents by Team</h3>
  <table class="table">
  <thead  class="thead-dark">
    <tr>
      <th>S.No</th>
     
      <th>competition Name</th>
      <th>Student Name</th>
      <th>School Name</th>
      <th>Tittle</th>
      <th>Online Documents</th>
      <th>Upload</th>
      <th>Upload By</th>
      
    </tr>
  </thead>
  <tbody>
   @if(count($team_document)>0)
   
   <?php $i = 1;?>
   @foreach($team_document as $key=>$te_docu)
   <?php $ids=$te_docu->school_id."_".$te_docu->student_id;?>
   <tr>
      <td>{{$i}}</td>
     
      <td><a href="{{url('referencedocument')}}/{{base64_encode($te_docu->competition_id)}}">{{$te_docu->compname}}</a></td>
      <td><a href="{{url('viewstudentinfoadmin')}}/{{base64_encode($ids)}}">{{$te_docu->studentname}}</a></td>
      <td><a href="{{url('schoolv')}}/{{base64_encode($te_docu->school_id)}}">{{$te_docu->schoolname}}</a></a></td>
      <td>{{$te_docu->title}}</td>
      <td><a target="_blank" href="{{url('team/doc_image')}}/{{$te_docu->image}}">{{$te_docu->title}}</a></td>
      <td>{{$te_docu->upload}}</td>
      <td>{{$te_docu->upload_by}}</td>
    </tr>
    <?php $i = $i+1;?>
   @endforeach
@endif
  </tbody>
</table>



<br>
<h3>Orders Team</h3>
  <table class="table">
  <thead  class="thead-dark">
    <tr>
      <th>S.No</th>
      <th>Order Id</th>
      <th>Order Status</th>
      <th>Payment Status</th>
      <th>Order Date</th>
      <th>Delivery Date</th>
      <th>Order By</th>
    </tr>
  </thead>
  
    @if(count($orderlist1)>0)
     <tbody>

     @foreach($orderlist1 as $key=>$orderlist1)

  <tr>
  
        <td>{{$key+1}}</td>
        <td><a href="{{url('orderiddetails')}}/{{base64_encode($orderlist1->order_id)}}">{{$orderlist1->order_id}}</a></td>

      @if($orderlist1->details!='N/A')
        <td>{{$orderlist1->details->statusupdated}}<br><button type="button" data-toggle="modal" class="btn btn-sm btn-outline-success" data-target="#order_Id{{$orderlist1->order_id}}"><i class="fa fa-edit"></i> </button>

    <div class="modal fade" id="order_Id{{$orderlist1->order_id}}" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Modal Header</h4>
        </div>
        <div class="modal-body">
       <form method="post" action="{{url('orderstatusupdate')}}" >
             {{ csrf_field() }}
           <input  type="text" name="order_Id" value="{{$orderlist1->order_id}}">
          <select class="form-control" id="myselect" name="updatestatus">
          <option value="">select Status</option>
          <option value="Received">Received</option>
          <option value="Under Print">Under Print</option>
           <option value="Packed">Packed</option>
          <option value="Dispatched">Dispatched</option>
          <option value="Delivered">Delivered</option>
         </select>
        </div>
        <div class="modal-footer">
             <button type="submit" class="btn btn-success">updated</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </form>
      </div>
    </div>
  </div>
        
        </td>
        @else
        <td>{{$orderlist1->details}}</td>
        @endif

        <td>{{$orderlist1->status}}</td>
       
       
        <td>{{date('d-F-Y',strtotime($orderlist1->created_at))}}</td>
        <th>{{date('d-F-Y',strtotime($orderlist1->updated_at))}}</th>
          @if($orderlist1->details!='N/A')
        <td><a href="{{url('showdetailsstudentbyAdmin')}}/{{base64_encode($orderlist1->order_id)}}">{{$orderlist1->details->fullName}}</a></td>
        @else
        <td>{{$orderlist1->details}}</td>
        @endif 

     
      </tr>
    @endforeach
      @else
        <tr><td>N/A</td></tr>
        @endif
  </tbody>
      
</table>

<h3>List  sponsorships</h3>
  <table class="table">
  <thead  class="thead-dark">
    <tr>
      <th>S.No</th>
      <th>Company Name</th>
      <th>Point of Contact</th>
       <th>Email</th>
       <th>Phone Number</th>
       <th>Type</th>
       <th>Description</th>
       <th>Competition Name</th>
       <th>Team Name</th>
        <th>Upload By</th>
       <th>Created_at</th>
       <th>Updated_at</th>
      
    </tr>
  </thead>
  <tbody>
  @if(count($sponser_details)>0)
  <?php $i=1; ?>
  @foreach($sponser_details as $s)
    <tr>
      <td>{{$i}}</td>
      <td>{{$s->company_name}}</td>
       <td>{{$s->point_of_contact}}</td>
       <td>{{$s->EMAILID}}</td>
       <td>{{$s->PHONE_NUMBER}}</td>
       <td>{{$s->kmtype}}</td>
       <td>{{$s->DESCRIPTION}}</td>
       <td>{{$s->compname}}</td>
       <td>{{$s->teamname}}</td>
        <td>{{$s->studentname}}</td>
      <?php $date1=date_create($s->created_at);
                    $re=date_format($date1,"d/m/Y");
                    ?>
        <?php $date2=date_create($s->updated_at);
                    $st=date_format($date2,"d/m/Y");
                    ?>
       <td>{{$re}}</td>
       <td>{{$st}}</td>
      
      
    </tr>
    <?php $i=$i+1;?>
      @endforeach
      @else
      <tr>
      <td>N/A<td>
      </tr>
        @endif
   

  </tbody>
</table>
</div>
    </div>
   </div>
@endsection
@section('header')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
<script type="text/javascript"  src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
@endsection
@section('footer')
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
 <script type="text/javascript">
  $(document).ready(function(){
    $('#planlistid').DataTable();
  });
//   }
 </script>
@endsection

