@extends(Auth::user()->role==2? 'layouts.coadmin':'layouts.admin')
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
             @if(Auth::user()->role==2)
               <div class="ml-auto">
		          @if((session('data')[18]??0)==1)
                  <div class="btn-group">
                     <a href="{{url('create/')}}/{{$id}}" class="btn btn-warning">Create</a>
               
                  </div>
				  @endif
                  @if(count($school)>0)
                      <div class="btn-group">
                     <a href="{{url('downloadstudentbyschool')}}/{{$id}}" class="btn btn-warning">Download Student </a>
                       </div>
                       @else
                        <div class="btn-group">
                        <a href="{{url('downloadstudentbyschool')}}/{{$id}}" class="btn btn-warning disabled">Download Student </a>
                       </div>
                       @endif

               </div>
			  @else
				  <div class="ml-auto">
                  <div class="btn-group">
                     <a href="{{url('create/')}}/{{$id}}" class="btn btn-warning">Create</a>
               
                  </div>
                  @if(count($school)>0)
                      <div class="btn-group">
                     <a href="{{url('downloadstudentbyschool')}}/{{$id}}" class="btn btn-warning">Download Student </a>
                       </div>
                       @else
                        <div class="btn-group">
                        <a href="{{url('downloadstudentbyschool')}}/{{$id}}" class="btn btn-warning disabled">Download Student </a>
                       </div>
                       @endif

               </div>
		     @endif
             
            </div>

            @if($errors->any())
               @foreach($errors->all() as $err)
                  <div class="alert alert-danger">{{$err}}</div>
               @endforeach
            @endif
            @if(session()->has('success'))
               <div class="alert alert-info">{{session()->get('success')}}</div>
            @endif
                       <div class="text-right">
                           
                           <button type="button" onclick="goBack()" class="btn btn-info">Go Back</button>

<script>
function goBack() {
  window.history.back();
}
</script>
           
 </div>
 <table class="table table-hover table-striped table-responsive" id="userlistid1">
 	<thead>
 		<tr>
 			<th>#</th>
@if(Auth::user()->role==1)
        <th>
          <div class="row">
            <div class="col-md-2">
          <input type="checkbox"  id="materialUnchecked">
        </div>
        <div class="col-md-2">
          <button class="btn btn-primary" onclick="bulksubmitstudent()">Bulk Invite</button>
        </div>
        </div>
      </th>
 @else 
      @if((session('data')[18]??0)==1)
       <th>
          <div class="row">
            <div class="col-md-2">
          <input type="checkbox"  id="materialUnchecked">
        </div>
        <div class="col-md-2">
          <button class="btn btn-primary" onclick="bulksubmitstudent()">Bulk Invite</button>
        </div>
        </div>
      </th>
      @endif

      @endif

      <th>Student Name</th>
      <th>Username</th>
 			<th>Student Class</th>
      <th>Section</th>
<th>Team Name</th>
 			<th>Mobile Number</th>
      <th>Email</th>
     @if(Auth::user()->role==1)
      <th>Invite</th>
           @else
      @if((session('data')[18]??0)==1)
      <th>Invite</th>
      @endif
      @endif
      <th>Guardian Name1</th>
 			<th>Status</th>
      <th>Last Login</th>
	  @if(Auth::user()->role==1)
		   <th>Edit</th>
		@else
		 @if((session('data')[18]??0)==1)
				  <th>Edit</th>
		   @endif
	   @endif
     
 			<th hidden="">View Plan</th>  
 		</tr>
 	</thead>
 	<tbody>
 

    <?php $i=1;?>
  
 		@foreach($school as $k)
 	
		<tr>
			       <td>{{$i}}</td> 
                            <?php $ids=$id."_".$k->id;?>
@if(Auth::user()->role==1)
    <td><input type="checkbox" name="stu" class="student"  value="{{$k->id}}"> </td>
@else
@if((session('data')[18]??0)==1)
<td><input type="checkbox" name="stu" class="student"  value="{{$k->id}}"> </td>
@endif
@endif
      
           
           <td> <a href="{{url('viewstudentinfoadmin')}}/{{base64_encode($ids)}}">{{$k->name}}</a></td>
           <td>{{$k->username}}</td>
			       <td> {{$k->class}}</td>
                 <td>{{$k->section}} </td>
            <td>{{$k->teamname}}</td>
          
             <td>{{$k->mobileno}} </td>
              <td>{{$k->studentemail}} </td>
            @if(Auth::user()->role==1)
              <td>
                
                @if($k->email_status == 1)
                  <button  id="{{$k->id}}" smb="{{$k->mobileno}}"  sname="{{$k->name}}" semail="{{$k->studentemail}}" class="btn btn-sm btn-danger invite" onclick="myfuninvite(this)">Invited
                @else
                  <button  id="{{$k->id}}" smb="{{$k->mobileno}}" sname="{{$k->name}}" semail="{{$k->studentemail}}" class="btn btn-sm btn-success invite" onclick="myfuninvite(this)">Invite
                @endif
                </button>
              </td>
          @else
         @if((session('data')[18]??0)==1)
          <td>
                
                @if($k->email_status == 1)
                  <button  id="{{$k->id}}" smb="{{$k->mobileno}}" sname="{{$k->name}}" semail="{{$k->studentemail}}" class="btn btn-sm btn-danger invite" onclick="myfuninvite(this)">Invited
                @else
                  <button  id="{{$k->id}}" smb="{{$k->mobileno}}" sname="{{$k->name}}" semail="{{$k->studentemail}}" class="btn btn-sm btn-success invite" onclick="myfuninvite(this)">Invite
                @endif
                </button>
              </td>
         @endif
         @endif


              <td>{{$k->guardianname1}} </td>
             <td>@if($k->status==1) Active @else Inactive @endif</td>

             <td>
               <?php 
        $date = $k->last_login;

      
        ?>
            <!--   {{ ($k->last_login)==''? 'Never Logged-in': $k->last_login }} -->
            {{ ($k->last_login)==''? 'Never Logged-in': date('d F, Y | h:i:a',$date) }}

             </td>
			  @if(Auth::user()->role==1)
					 <td> <a href="{{url('studenteditbyadd')}}/{{base64_encode($ids)}}">Edit</a></td>
				@else
				 @if((session('data')[18]??0)==1)
						     <td> <a href="{{url('studenteditbyadd')}}/{{base64_encode($ids)}}">Edit</a></td>
			   @endif
			@endif
          
             <td hidden> <a href="{{url('assignplan')}}/{{$k->id}}">View Plan</a></td>
		 			
		</tr>
		<?php $i=$i+1; ?>
		@endforeach
 	
 	</tbody>
 </table>


@endsection

@section('header')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
@endsection

@section('footer')

 
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

    function myfuninvite(arg){
		
    var id   = $(arg).attr("id");
    var sname= $(arg).attr("sname");
    var email= $(arg).attr("semail");
	  var mob= $(arg).attr("smb");

     $.ajax({
        url:"{{url('studentlistformail')}}",
        method:"POST",
        data:{mob:mob,id:id,sname:sname,email:email,_token: '{{csrf_token()}}'},
         beforeSend: function() {
			 
           $('#myModal').modal('show'); 
           
         },
        success:function(data)
        {  
		console.log(data);
		$('#sendingmessage').text('Email sent successfully.');
           location.reload();
          setTimeout(function(){
              $('#myModal').modal('hide')
            }, 2000);
        }
		
      });
    
    }  

  $(document).ready(function () {
    
    $("#materialUnchecked").click(function () {
    
        $(".student").prop('checked', $(this).prop('checked'));
    });
    
   
});
 </script>
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
@endsection
<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content" style="background-color: red; color: white;">
      <div class="modal-body">
        <h1 id='sendingmessage' class="text-center">Sending Email....</h1>
      </div>
     
    </div>

  </div>
</div>

<script type="text/javascript">

  


function bulksubmitstudent()
{

  
            var favorite = [];
              $.each($("input[name='stu']:checked"), function(){
        
                favorite.push($(this).val());
            });
       if(favorite.length===0)
          {
          alert("Please Select Student First...");
         
            // alert("My favourite sports are: " + favorite.join(", "));
          }
          else
          {
          
          
      $.ajax({
        url:"{{url('invitebyemailstudentbulk')}}",
        method:"post",
        data:{student:favorite,_token: '{{csrf_token()}}'},
        beforeSend: function() {
        
         },
        success:function(data)
        { 
        alert('Sending bulk Mail successfully');
         location.reload();
      
        }
      });
    }
            // alert("My favourite sports are: " + favorite.join(", "));
       
}
 </script>