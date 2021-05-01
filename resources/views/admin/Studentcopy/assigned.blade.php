@extends('layouts.admin')
@section('content')
        <link rel="stylesheet" href='{{url("resources/assets/css/bootstrap-example.min.css")}}' type="text/css">
        <link rel="stylesheet" href='{{url("resources/assets/css/prettify.min.css")}}' type="text/css">
        <link rel="stylesheet" href='{{url("resources/assets/css/bootstrap-multiselect.css")}}' type="text/css"/>

 <section>
  <form action="{{url('traineradd')}}/{{Route::Input('trainers1')}}" method="post">
 @csrf
    <div class="col-sm-7">
     <div class="form-group">
               <label>Academic Year</label>
               <select required class="form-control" id="train" name="year" onchange="trainer()">
                   <option value="">-- SELECT YEAR ---</option>
                   <?php for($i=date('Y')-10;$i<=date('Y')+10;$i++){ ?>
                   <option value="{{$i}}">{{$i}}-{{$i+1}}</option>
                   <?php } ?>
               </select>
    </div>
    <!--<div class="form-group">
               <label>School Name</label><br>
               <select id="example-getting-started" name="school[]" class="form-control"  multiple="multiple">
                   @foreach($school as $key=>$schools)
                   <option value="{{base64_encode($schools->id)}}">{{$schools->school_name}}</option>
                   @endforeach
               </select>
               
    </div>-->
    
    <table class="table table-hover table-striped" id="userlistid">
 	<thead>
 		<tr>
 		    <th></th>
 			<th>#</th>
            <th>School Name</th>
 			<th>Zone</th>
 			<th>State</th>
 			<th>City</th>
 			<th>Status</th>
         <th>Created At</th>
         <th></th>
 		</tr>
 	</thead>
 	<tbody>
      @if(count($school)>0)
 		@foreach($school as $key=>$schools)
		<tr>
		 <td><input name="school[]" id="{{$schools->id}}" type="checkbox" aria-label="Checkbox for following text input" value="{{base64_encode($schools->id)}}"></td>
		 <td>{{$schools->id}}</td> 
         <td>{{$schools->school_name}}</td>
		 <td>{{$schools->zone}}</td>
         <td>{{$schools->state}} </td>
         <td>{{$schools->city}} </td>
         <td>@if($schools->status==1) Active @else Inactive @endif</td>
         <td>{{$schools->created_at}} </td>
		</tr>
		@endforeach
 		@else
         No Record Found.....
      @endif
 	</tbody>
 </table>
    
    <br>
    <div class="form-group">
     <button type="submit" class="btn btn-success">Submit</button>
     </div>
     
    </div>
   </form>
   <script>
   function trainer()
   {
       var trainer='{{Route::Input('trainers1')}}';
       $.ajax({
						url:"{{url('trainerschool')}}",
					    data:{'data':$('#train').val(),'trainer':trainer},
						method:'GET',
						beforeSend:function(){
						    
						   $( "input[name='school[]']" ).prop('checked',false);
						},
						success:function(data){
						    
							$("#coins").empty();
							$.each(JSON.parse(data),function(index,value){
							
							$("#"+value.school_id).prop('checked',true);
						 });
							
						},
						headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  },
						error:function(data){
							
							console.log(data);
						}
					});
   }
       
   </script>
 </section>
@endsection