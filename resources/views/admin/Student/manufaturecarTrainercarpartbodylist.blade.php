 @extends('layouts.school')
 @section('content')
            <div class="content-heading">
               <h2></h2>
                  <small data-localize="dashboard.WELCOME"></small>
               </div>
               <style>https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css</style>
                   <style>https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css</style>
               <!-- START Language list-->
               <!-- <div class="ml-auto">
                  <div class="btn-group">
                     <a href="{{url('agentreg')}}" class="btn btn-warning">Create Agent</a>
                     <button class="btn btn-secondary dropdown-toggle dropdown-toggle-nocaret" type="button" data-toggle="dropdown">English</button>
                     <div class="dropdown-menu dropdown-menu-right-forced animated fadeInUpShort" role="menu"><a class="dropdown-item" href="#" data-set-lang="en">English</a><a class="dropdown-item" href="#" data-set-lang="es">Spanish</a>
                     </div>
                  </div>
               </div> -->
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
 
             
 
      
   </div>

   <br/>
   <div class="col-md-12">
    
    <table class="table table-striped table-bordered" id="planlistid">
 	<thead>
 		<tr>
 		   
 			<th>#</th>
 		
 		 <th>Car body</th>
 		 <th>Status</th>
         
 		</tr>
 	</thead>
 	<tbody>
 	    <?php $i=1?>
 	     @if(count($carbodypart)>0)
 		@foreach($carbodypart as $carbodypart1)
 	
 		
 
 
		<tr>
		     <td>{{$i}}</td>
		    <td>{{$carbodypart1['carbodypart']}}</td> 
		 	 <td>
		 	     @if($carbodypart1['status']==1) Aprpoved 
		 	     @elseif($carbodypart1['status']==2) Rejected 
		 	     @else pending @endif
		 	     
		 	     
		 	     

		 	     
		 	     </td> 
		 
         
        
		</tr>
		<?php $i++?>
		
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