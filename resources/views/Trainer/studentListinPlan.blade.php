@extends(Auth::user()->role==2? 'layouts.coadmin':'layouts.admin')
 @section('content')
            <div class="content-heading">
                              <small data-localize="dashboard.WELCOME"></small>
               </div>
               <style>https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css</style>
                   <style>https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css</style>
             
               <!-- END Language list-->
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
 
               <h2>Students Participant  in Plan <storng>{{$Planname}}</strong>
 
      
   </div>

   <br/>
   <div class="col-md-12">
    
    <table class="table table-striped table-bordered" id="planlistid">
 	<thead>
 		<tr>
 		   
 			<th>#</th>
 			<th>Student Name</th>
 		  <th>Class</th>
 		  <th>Section</th>
 		  <th>Mobile Number</th>
 		  <th>Address</th>
 		   
         
 		</tr>
 	</thead>
 	<tbody>
 	    <?php $i=1?>
 	     @if(count($ParticipateStudent)>0)
 		@foreach($ParticipateStudent as $key=>$fetachstudent1)
 		
 	  <?php  $scid=$fetachstudent1->id."-".$fetachstudent1->school_id;
 	  ?>
		<tr>
		 <td>{{$i}}</td>
		 <td>{{$fetachstudent1->name}}</td> 
		 <td>{{$fetachstudent1->class}}</td> 
		 <td>{{$fetachstudent1->section}}</td>
		 <td>{{$fetachstudent1->mobileno}}</td>
     <td>{{$fetachstudent1->address}}</td>
        
		</tr>
		<?php $i++?>
		@endforeach
 		@else
       
      @endif
 	</tbody>
 </table>
       
   </div>
@endsection

@section('header')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
<script type="text/javascript"  src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<!--<script type="text/javascript" src="https://https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>-->
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