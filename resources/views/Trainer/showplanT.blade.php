@extends((Auth::user()->role==3?'layouts.trainer':'layouts.admin'))
 @section('content')
            <div class="content-heading">
               <div><h2>{{$schoolname}}</h2> 
                  <small data-localize="dashboard.WELCOME"></small>
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

   <form hidden="" method="post" action="{{url('storeschoolplanmaster-trainer')}}" enctype="multipart/form-data">
            @csrf
           

            <div class="form-group">
              
               <input type="text" name="schoolid" value="{{base64_decode($school)}}" id="school_id" required class="form-control" hidden>
            
           </div>
         
   
            <div class="form-group">
                  <label for="sel1">Select Year</label>
               <select required="" class="form-control" name="year"  id="academicyear" onchange="academicyear()">
                <option value=''>Select year</option>
               <?php for ($year=2015; $year <= date('Y')+1; $year++): ?>
                <option value="<?=($year-1)."-".($year);?>"><?=($year-1)."-".$year;?></option>
                <?php endfor; ?>
               </select>
           </div>

       <div class="form-group">
      <label for="sel1">Select Plan</label>
      <select class="form-control" name="plan[]" id="planid22" multiple="multiple">
          
        
        </select>
     </div>
            
            
            <div class="text-center"> <button type="submit" class="btn btn-success">Submit</button> </div>
         </form>


   <br/>
   <div class="col-md-12">
    

    <table class="table table-striped table-bordered" id="planlistid">
 	<thead>
 		<tr>
 		   
 			<th>#</th>
         
 			<th>Plan Name</th>
 			<th>Academic Year</th>
 			<th>Total Participants</th>
 			<th>Date Created</th>
 			<th>View Course</th>
         
 		</tr>
 	</thead>
 	<tbody>
 	    <?php $i=1?>
 	     @if(count($planperschool)>0)
 		@foreach($planperschool as $key=>$planperschool1)
 		
 	   <?php $plansch=base64_encode($planperschool1->plan.",".$schoolid.",".$planperschool1->year)?>
		<tr>
		 <td>{{$i}}</td>
		 <td><a href="{{url('viewcourseT_trainer')}}/{{$plansch}}" class="btn btn-warning">{{$planperschool1->name}}</a></td> 
         <td>{{$planperschool1->year}}</td>
          <td><a href="{{url('viewstudentlist_trainer')}}/{{$plansch}}" class="btn btn-warning">{{$planperschool1->counts}}</a></td>
         <td>{{$planperschool1->created_at}} </td>

         <td >
          <a href="{{url('viewcourseinPlan_trainer')}}/{{$plansch}}" class="btn btn-warning">View Course
          </a>
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

 <link rel="stylesheet" href="{{asset('js/jquery.multiselect.css')}}">
@endsection

@section('footer')
<script src="{{asset('js/jquery.multiselect.js')}}"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
 <script type="text/javascript">
 	$(document).ready(function(){

      $('#academicyear').change(function(){
      var v=$('#academicyear').val();
    
         $.ajax({
             url:"{{url('schoolplanfetchacademicyear_trainer')}}",
              data:{_token: '{!! csrf_token() !!}','v':v},
            method:'POST',
            success:function(data){
              $("#planid22").empty();
               // $('#planid22').append('<option value="#">please  Select Plan</option>');
                $.each(data,function(index,value) {
               $('#planid22').append('<option value="' + value.id + '">' + value.name+ '</option>');
             }); 
            },
            error:function(data){
              
              console.log('error');
            },
          });
});

    
 		$('#planlistid').DataTable();
 	});

    $('#assignplanlistid').DataTable();
//     $('#planid').multiselect(
// {
//    columns: 4,
//     placeholder: 'Select Plan',
//     search: true,
//     selectAll: true
// }
//       );


 </script>
@endsection