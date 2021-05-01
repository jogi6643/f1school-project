@extends('layouts.admin')
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
               <div>School Master
                  <small data-localize="dashboard.WELCOME"></small>
               </div>
               
          
               <!-- START Language list-->
                
               <div class="ml-auto">
                  <div class="btn-group">
                     <a href="{{url('schoolcr')}}" class="btn btn-warning">Create</a>
                </div>
                 <div class="btn-group">
                     <a href="{{url('downloadstudentupload')}}" class="btn btn-warning">Download Student Upload Templates</a>
                </div>
              
                    
                   
                  </div>
               </div>
             <div class="text-right">
                           
                <button type="button" onclick="goBack()" class="btn btn-info">Go Back</button>

                           <script>
                        function goBack() {
                         window.history.back();
                               }
                        </script>
               </div>
                <div class="row " style="margin-left:10px">
                     
                          <div class="col-md-12">
                     <form class="border-class" method="post" action="{{url('uploadstudent')}}" enctype="multipart/form-data">
                         @csrf
                         <div class="row">
                         <div class="col-md-4">
                          <div class="form-group">
                            <label for="file">Upload Student Templates:</label>
                            <input type="file" class="form-control"  name="files" id="file">
                          </div>
                           
                         </div>
                          <div class="col-md-4">
                            <div class="form-group">
                                 <label style="padding:7%"></label>
                             <button type="submit" class="btn btn-primary">Submit</button>
                             </div>
                         </div>
                        </div>
                         
                        </form>
                       
                        </div>
                     </div>
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
            
 <table class="table table-hover table-striped" id="userlistid">
 	<thead>
 		<tr>
 			<th>#</th>
         <th>School Name</th>
 			<th>Zone</th>
 			<th>State</th>
 			<th>City</th>
      <th>Invite</th>
 			<th>Status</th>
         <th>Created At</th>
           <th>Last Modified</th>
           <th>List Student</th>
         <th></th>
       
 		</tr>
 	</thead>
 	<tbody>
      @if(count($eq)>0)
 		@foreach($eq as $k)
		<tr>
			<td>{{$k->id}}</td> 
         <td> <a href="{{url('schoolv/'.base64_encode($k->id))}} " target="__blank">{{$k->school_name}}</a></td>
			<td> {{$k->zone}}</td>
         <td>{{$k->state}} </td>
         <td>{{$k->city}} </td>
         <td><button  id="{{$k->id}}" sname="{{$k->school_name}}" semail="{{$k->email}}" class="btn btn-sm btn-success invite" onclick="myfuninvite(this)">Invite</button></td>
         <td>@if($k->status==1) Active @else Inactive @endif</td>
		<td>{{date('d-m-Y',strtotime($k->created_at))}} </td>
      <td>{{date('d-m-Y',strtotime($k->updated_at))}} </td>
			 <td><a href="{{url('students')}}/{{base64_encode($k->id)}}">List Student</a></td>
         <td> <a href="{{url('schooled').'/'.base64_encode($k->id)}}" class="btn btn-sm btn-outline-success"><i class="fa fa-edit"></i> </a> <button class="btn btn-sm btn-outline-danger" id="tempdelid-{{$k->id}}" onclick="myfuntemp(this)"><i class="fa fa-trash"></i> </button> </td>
			
			
		 			
		</tr>
		
		@endforeach
 		@else
         No Record Found.....
      @endif
 	</tbody>
 </table>




@endsection

@section('header')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
@endsection

@section('footer')
  <style >
 .modal-dialog {
  margin-top: 0;
  margin-bottom: 0;
  height: 100vh;
  display: flex;
  flex-direction: column;
  justify-content: center;
}
 </style>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
 <script type="text/javascript">
 	$(document).ready(function(){
 		$('#userlistid').DataTable();
 	});

   function myfuntemp(arg) {
      var ad=$(arg).attr('id');
      var ak=ad.split('-');
      // alert('val = '+ak[1]);
      if(confirm("Do you really want to delete this."))
         window.location.href='{{url("/schooldel")}}/'+btoa(ak[1]);
         // alert("yes");
   }

   function myfuninvite(arg){
    var id = $(arg).attr("id");
    var sname= $(arg).attr("sname");
    var email= $(arg).attr("semail");
    alert(sname);
    $.ajax({
        url:"{{url('sendemail')}}",
        method:"post",
        data:{id:id,sname:sname,email:email,_token: '{{csrf_token()}}'},
        beforeSend: function() {
           $('#myModal').modal('show'); 
         },
        success:function(data)
        {
           $('#sendingmessage').text('Email is sent successfully.');
          setTimeout(function(){
              $('#myModal').modal('hide')
            }, 2000);
        }
      });
  }
 </script>
@endsection
<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content" style="background-color: red; color: white;">
      <div class="modal-body">
        <h1 id='sendingmessage' class="text-center">Email is Sending..</h1>
      </div>
     
    </div>

  </div>
</div>