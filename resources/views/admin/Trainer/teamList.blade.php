 @extends('layouts.trainer')
 @section('content')
            <div class="content-heading">
               
                  <small data-localize="dashboard.WELCOME"></small>
                  <h3>
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
 
          
 
      
   </div>


       
     trainerid  
                     

   <div class="col-md-12">
    
    <table class="table table-striped table-bordered" id="planlistid">
 	<thead>
 		<tr>
 		   
 			<th>#</th>
 			<th>Image</th>
 		  <th>Team Name</th>
 		  <th>School Name</th>
 		  <th hidden="">Created by</th>
 		  <th>Created by</th>
 		    <th>Viem Member</th>
         
 		</tr>
 	</thead>
 	<tbody>
 	    <?php $i=1?>
 	     @if(count($team1)>0)

 		@foreach($team1 as $key=>$t2)
 		 @foreach($t2 as $key=>$team)
 	  
 	<?php $ids=$team->id."_".$team->student_id."_".$team->school_id;?>
  <?php $idscr=$trainerid."_".$team->student_id."_".$team->school_id;?>
		<tr>
		 <td>{{$i}}</td>

     <td><img style="height: 50px;width:50px; border-radius: 50%;" src="{{url('public/team/')}}/{{ $team->team_Image }}"></td>
	
		 <td>{{$team->team_Name}}</td> 
		 <td>{{$team->school_name}}</td>
     
		<th hidden="">{{$team->student_id}}</th>
    <th>{{$team->student_name}}</th>
         
         <td>
          <a href="{{url('viewteambytr')}}/{{base64_encode($ids)}}"><button type="button" class="btn btn-info">View Member</button></a>
         
           <a href="{{url('editteambytr')}}/{{base64_encode($ids)}}"><button type="button" class="btn btn-warning">Edit Team</button></a>

        <a href="{{url('deleteteambytr')}}/{{base64_encode($ids)}}"><button type="button" class="btn btn-danger">Delete Team</button></a>
         </td>
        
		</tr>
		<?php $i++?>
      @endforeach
		@endforeach
 		@else
         No Record Found.....
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