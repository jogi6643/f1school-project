@extends('layouts.admin')
@section('content')
        <link rel="stylesheet" href='{{url("resources/assets/css/bootstrap-example.min.css")}}' type="text/css">
        <link rel="stylesheet" href='{{url("resources/assets/css/prettify.min.css")}}' type="text/css">
        <link rel="stylesheet" href='{{url("resources/assets/css/bootstrap-multiselect.css")}}' type="text/css"/>
 <div class="content-heading">
               <div>Trainer School
                  <small data-localize="dashboard.WELCOME"></small>
               </div>
  </div>

         @if (session('errors'))
    <div class="alert alert-danger">
        {{ session('errors') }}
    </div>
    @endif
 <section>
  <form action="{{url('traineradd')}}/{{Route::Input('trainers1')}}" method="post">
 @csrf
    <div class="col-sm-7">
     <div class="form-group">
               <label>Academic Year</label>
               <select required class="form-control" id="train" name="year" onchange="trainer()">
                   <option value="">-- SELECT YEAR ---</option>
                   <?php for($i=2015;$i<=date('Y')+1;$i++){ ?>
                   <option value="{{$i}}-{{$i+1}}">{{$i}}-{{$i+1}}</option>
                   <?php } ?>
               </select>
    </div>

    <table class="table table-hover table-striped" id="userlistid1">
 	<thead>
 		<tr>
 		   
 			<th>#</th>
            <th>School Name</th>
 			<th>Zone</th>
 			<th>State</th>
 			<th>City</th>
 			<th>Status</th>
         <th>Created At</th>
         <th>Last Modified</th>
 		</tr>
 	</thead>
 	<tbody>
      @if(count($school)>0)
      <?php $i=1;?>
 		@foreach($school as $key=>$schools)
		<tr>
         <td>{{$i}}</td> 
		 <td><input name="school[]" id="{{$schools->id}}" type="checkbox" aria-label="Checkbox for following text input" value="{{base64_encode($schools->id)}}">{{$schools->school_name}}</td>
		 <td>{{$schools->zone}}</td>
         <td>{{$schools->state}} </td>
         <td>{{$schools->city}} </td>
         <td>@if($schools->status==1) Active @else Inactive @endif</td>
         <td>{{$schools->created_at}} </td>
         <td>{{$schools->updated_at}} </td>
		</tr>
    <?php $i=$i+1;?>
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
   @endsection

@section('header')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
@endsection

@section('footer')
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
   <script>
      $(document).ready(function(){
    $('#userlistid1').DataTable();
  });
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