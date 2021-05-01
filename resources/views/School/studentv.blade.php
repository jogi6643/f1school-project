@extends('layouts.school')
@section('content')

<style>
.border-class
{
  border:thin #929292 solid;
  margin:20px;
  padding:20px;
}
</style>
 
             <div class="content-heading">
               <div>List Student
                  <small data-localize="dashboard.WELCOME"></small>
               </div>
       
               <!-- START Language list-->
               <div class="ml-auto">
                  <div class="btn-group">
                     <a href="{{url('studentCr/')}}/{{base64_encode($id)}}" class="btn btn-warning">Create</a>
               
                  </div>
                  @if(count($school)>0)
                      <div class="btn-group">
                     <a href="{{url('downloadsstudent')}}/{{base64_encode($id)}}" class="btn btn-warning">Download Student </a>
                       </div>
                       @else
                        <div class="btn-group">
                        <a href="{{url('downloadsstudent')}}/{{base64_encode($id)}}" class="btn btn-warning disabled">Download Student </a>
                       </div>
                       @endif
					 

               </div>
             
            </div>

            @if($errors->any())
               @foreach($errors->all() as $err)
                  <div class="alert alert-danger">{{$err}}</div>
               @endforeach
            @endif
             @if(session()->has('success'))
               <div class="alert alert-success">{{session()->get('success')}}</div>
            @endif
               @if(session()->has('danger'))
               <div class="alert alert-danger">{{session()->get('danger')}}</div>
            @endif
                       <div class="text-right">
                           
                           <button type="button" onclick="goBack()" class="btn btn-info">Go Back</button>

<script>
function goBack() {
  window.history.back();
}
</script>
              
 </div>
 <table class="table table-hover table-striped" id="userlistid1">
 	<thead>
 		<tr>
 			<th>#</th>
      <th>Student Name</th>
 			<th>Student Class</th>
      <th>Section</th>
 			<th>DOB</th>
 			<th>Mobile Number</th>
      <th>Email</th>
      <th>Guardian Name1</th>
 			<th>Status</th>
 
      <th>Action</th>
 		</tr>
 	</thead>
 	<tbody>
 

    <?php $i=1;?>
  
 		@foreach($school as $k)
 	
		<tr>
			       <td>{{$i}}</td> 
              <?php $ids=$id."_".$k->id;?>
           <td> <a href="{{url('viewstudentinfo')}}/{{base64_encode($ids)}}">{{$k->name}}</a></td>
			       <td> {{$k->class}}</td>
             <td>{{$k->section}} </td>
             <td>{{$k->dob}} </td>
             <td>{{$k->mobileno}} </td>
             <td>{{$k->studentemail}} </td>
             <td>{{$k->guardianname1}} </td>
             <td>@if($k->status==1) Active @else Inactive @endif</td>
             <td>
          <a href="{{url('studenteditbyschool')}}/{{base64_encode($ids)}}"><button type="button" class="btn btn-success">Edit</button></a>
          <!--  <a  href="{{url('deletestudentbyschool')}}/{{base64_encode($ids)}}"><button type="button"  class="btn btn-danger ">Delete</button></a> -->
           </td>
		</tr>
		<?php $i=$i+1; ?>
		@endforeach
 	
 	</tbody>
 </table>


@endsection

@section('header')

@endsection

@section('footer')

 <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
 <script type="text/javascript">
  $(document).ready(function(){
    $('#userlistid1').DataTable();
  });

   function myfuntemp(arg) {
      var ad=$(arg).attr('id');
      var ak=ad.split('-');
      // alert('val = '+ak[1]);
      if(confirm("Do you really want to delete this."))
         window.location.href='{{url("/locationdel")}}/'+btoa(ak[1]);
         // alert("yes");
   }
 </script>
@endsection