 @extends('layouts.trainer')
 @section('content')
            <div class="content-heading">
               
                  <small data-localize="dashboard.WELCOME"></small>
                  <h3>School Name:-{{$schoolname}}|Trainer : {{$trainer}}<h3>
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
        <div class="text-left">
            @if(count($students)>0)
                      <div class="btn-group">
                     <a href="{{url('trdownloadstudentbyschool')}}/{{$id}}" class="btn btn-warning">Download Student </a>
                       </div>
                       @else
                        <div class="btn-group">
                        <a href="{{url('trdownloadstudentbyschool')}}/{{$id}}" class="btn btn-warning disabled">Download Student </a>
                       </div>
                       @endif
        </div>
           <div class="text-right">
                           
                           <button type="button" onclick="goBack()" class="btn btn-info">Go Back</button>

<script>
function goBack() {
  window.history.back();
}
</script>
               </div>
 
          
 
      
   </div>


       
                     
              <div hidden="" class="col-md-12">
                     <form class="border-class" method="post" action="{{url('uploadstudentbytr')}}" enctype="multipart/form-data">
                         @csrf
                         <div class="row">
                         <div class="col-md-4">
                          <div class="form-group">
                            <label for="file">Upload Student Templates:</label>
                            <input type="file" class="form-control"  name="files" id="file">
                          </div>

                          <div  hidden="" class="form-group">
                            <label for="sch">schoolId:</label>
                            <input type="text" class="form-control" value={{$id}}  name="schoolid" >
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
                     

   <br/>
   <div class="col-md-12">
    
    <table class="table table-striped table-bordered" id="planlistid">
  <thead>
    <tr>
       
      <th>#</th>
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
      <th>Student Name</th>
      <th>Student Class</th>
      <th>Section</th>
      <th>Team Name</th>
      <th>Mobile Number</th>
      <th>Email</th>
      <th>Invite</th>
      <th>Status</th>
      <th>Last Login</th>
      <th>Action</th>
         
    </tr>
  </thead>
  <tbody>
      <?php $i=1?>
       @if(count($students)>0)
     
    @foreach($students as $key=>$students1)
    
    <?php  $scid=$students1->id."_".$students1->school_id;
    $ids = $students1->school_id."_".$students1->id;
    ?>
    <tr>
     <td>{{$i}}</td>
     <td><input type="checkbox" name="stu" class="student"  value="{{$students1->id}}"> 
      </td>
           
     <td><a href="{{url('studentinfo')}}/{{base64_encode($ids)}}">{{$students1->name}}</a></td> 
     <td>{{$students1->class}}</td> 
     <td>{{$students1->section}}</td>
     <td>Team Name</td>
     <td>{{$students1->mobileno}}</td>
     <td>{{$students1->studentemail}}</td>
    <td>
     @if($students1->status==1)  
    @if($students1->email_status == 1)
     <button  id="{{$students1->id}}" sname="{{$students1->name}}" semail="{{$students1->studentemail}}" class="btn btn-sm btn-danger invite" onclick="myfuninvite(this)">Invited
     @else
   <button  id="{{$students1->id}}" sname="{{$students1->name}}" semail="{{$students1->studentemail}}" class="btn btn-sm btn-success invite" onclick="myfuninvite(this)">Invite
                @endif
                </button>
          @else
          <button disabled=""  id="{{$students1->id}}" sname="{{$students1->name}}" semail="{{$students1->studentemail}}" class="btn btn-sm btn-warning invite" >Invite</button>
          @endif

    </td>
    
    @if($students1->status==1)
     <td>Active</td>
     @else
     <td>Inactive</td>
     @endif

      <td>{{$students1->last_login}}</td>
         <td>
          <a h href="{{url('studenteditbyTrainer')}}/{{base64_encode($scid)}}"><button type="button" class="btn btn-success">Edit</button></a>
           <a hidden="" class="" href="#"><button type="button"  class="btn btn-danger disabled">Delete</button></a>
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

@endsection

@section('footer')
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
 <script type="text/javascript">
  $(document).ready(function(){
    $('#planlistid').DataTable();
  });



   function myfuninvite(arg){
    var id   = $(arg).attr("id");
    var sname= $(arg).attr("sname");
    var email= $(arg).attr("semail");
    $.ajax({
        url:"{{url('studentlistformail')}}",
        method:"POST",
        data:{id:id,sname:sname,email:email,_token: '{{csrf_token()}}'},
         beforeSend: function() {
           $('#myModal').modal('show'); 
           
         },
        success:function(data)
        {  $('#sendingmessage').text('Email sent successfully.');
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
@endsection
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
          alert(data);
        alert('Sending bulk Mail successfully');
      
        }
      });
    }
            // alert("My favourite sports are: " + favorite.join(", "));
       
}
</script>