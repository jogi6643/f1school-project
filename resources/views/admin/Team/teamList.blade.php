@extends(Auth::user()->role==2? 'layouts.coadmin':'layouts.admin')
 @section('content')
            <div class="content-heading">
                  <small data-localize="dashboard.WELCOME"></small>
                  <h3>
                    View Team List
                  </h3>
            </div>
               <style>https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css</style>
               <style>https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css</style>
            </div>

            @if($errors->any())
               @foreach($errors->all() as $err)
                  <div class="alert alert-danger">{{$err}}</div>
               @endforeach
            @endif
            @if(session()->has('success'))
               <div class="alert alert-info">{{session()->get('success')}}</div>
            @endif


    <div class="col-md-12">
           <div class="text-right">
                 <button type="button" onclick="goBack()" class="btn btn-info">Go Back</button>

<script>
function goBack() {
  window.history.back();
}
</script>
          </div>
		 <br> 

				
    </div>

 
    <div class="col-md-12">
      <div class="btn-group" style="float:right">
                     <a href="{{url('teamviewaddexport')}}" class="btn btn-success  ">Download Report</a>
                </div>               
</div>
<br><br><br><br>
   <div class="col-md-12">
    
    <table class="table table-striped table-bordered" id="planlistid">
 	<thead>
 		<tr>
 		   
 			<th>#</th>
      <th>Team Creator Name</th>
	  <th>Member Phone</th>
	   <th>Member Email</th>
        <th>School Name</th>
 			<th>Member</th>
      <th>Team Id</th>
 		  <th>Team Name</th>
      @if(Auth::user()->role==1)
 		  <th>Competition Name</th>
      @else
      @if((session('data')[14]??0)==1)
      <th>Competition Name</th>
      @else
       <th>Competition Name</th>
      @endif
      @endif
    
      <th>Region</th>
      <th>Competition Start Date</th>
 		
         
 		</tr>
 	</thead>
 	<tbody>
 	    <?php $i=1?>
     @if(count($participate)) 
  @foreach($participate as $ts)
  @foreach($ts as $row)



		<tr>
		 <td>{{$i++}}</td>
     <td>{{$row['teamCreator']}}</td>
	 <td>{{$row['phone']}}</td>
	 <td>{{$row['studentemail']}}</td>
        <td> <a href="{{url('schoolv')}}/{{base64_encode($row['schoolid'])}}">{{$row['schname']}}</a></td>
     <td>{{$row['studentname']}}</td>
    <td>{{$row['teamId']}}</td>
    <td><a href="{{url('viewteampage')}}/{{base64_encode($row['teamId'])}}">{{$row['teams_name']}}</a></td>
@if(Auth::user()->role==1)
    @if($row['competionid']=='N/A')
    <td>{{$row['competitionname']}}</td>
    @else
   <td><a href="{{url('nominate')}}/{{base64_encode($row['competionid'])}}"> {{$row['competitionname']}}</a></td>
    @endif
 @else
      @if((session('data')[14]??0)==1)
      @if($row['competionid']=='N/A')
    <td>{{$row['competitionname']}}</td>
    @else
   <td><a href="{{url('nominate')}}/{{base64_encode($row['competionid'])}}"> {{$row['competitionname']}}</a></td>
    @endif
    @else
         @if($row['competionid']=='N/A')
    <td>{{$row['competitionname']}}</td>
    @else
   <td>{{$row['competitionname']}}</td>
    @endif
    @endif


    @endif

     <td>{{$row['Regionname']}}</td>
     <td>{{date('d-m-Y',strtotime($row['compStartdate']))}}</td>
     


        
		</tr>
  @endforeach   
  @endforeach  
  @else
  No Data available
  @endif

 	</tbody>
 </table>
       
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

//   function myfuntemp(arg) {
//       var ad=$(arg).attr('id');
//       var ak=ad.split('-');
//       // alert('val = '+ak[1]);
//       if(confirm("Do you really want to delete this."))
//          window.location.href='{{url("/schooldel")}}/'+btoa(ak[1]);
//          // alert("yes");
//   }
 </script>
@endsection