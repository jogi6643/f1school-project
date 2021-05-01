@extends('layouts.student')
@section('contents')
                          <div class="text-right">
                           
                           <button type="button" onclick="goBack()" class="btn btn-info">Go Back</button>

<script>
function goBack() {
  window.history.back();
}
</script>
               </div>
<div class="container">

  
  <form class="form-horizontal" method="post" action="{{url('teamstore')}}" enctype="multipart/form-data">
  
      @if (count($errors) > 0)
         <div  class="form-group">
      <div class="alert alert-danger col-sm-10">
        <strong>Whoops!</strong> There were some problems with your input.<br><br>
        <ul>
          @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
       </div>
      @endif
   

        @if(session('success'))
        <div class="form-group">
        <div class="alert alert-success col-sm-10">
          {{ session('success') }}
        </div> 
      </div>
        @endif


        @if(session('danger'))
        <div class="form-group">
        <div class="alert alert-danger col-sm-10">
          {{ session('danger') }}
        </div> 
      </div>
        @endif

    {{csrf_field()}}

  <div class="card mb-3">
    <div class="card-header">Create Team By {{$studentname}}</div>
  <div class="row">
<div class="col-md-7">
  <div class="card-body">
    <div hidden class="form-group">
    <label class="control-label col-sm-2" for="team_file">Student Id</label>
    <div class="col-sm-10">
      <input type="text" value="{{$sid}}" class="form-control" name="student_id" id="student_id" placeholder="student_id">
    </div>
  </div>

   <div hidden class="form-group">
    <label class="control-label col-sm-2" for="school id">School Id</label>
    <div class="col-sm-10">
      <input type="text" value="{{$scid}}" class="form-control" name="school_Id" id="team_file" placeholder="school_Id">
    </div>
  </div>


  <div class="form-group">
    <label class="control-label col-sm-2" for="team_file"></label>
    <div class="col-sm-10">
      <input type="file" class="form-control" name="team_file" id="team_file" placeholder="Team Image">
    </div>
  </div>


  <div class="form-group">
    <label class="control-label col-sm-4" for="team">Team Name</label>
    <div class="col-sm-8"> 
      <input type="text" class="form-control" name="Team_Name" id="pwd" placeholder="Enter Team Name">
    </div>
  </div>

   <div class="form-group"> 
   <label class="control-label col-sm-12" for="des">Description</label>
    <div class="col-sm-10"> 
       <textarea class="form-control" name="about_team"  rows="5" id="comment">  Description</textarea>
    </div>
  </div>

  <div class="form-group"> 
   <div class="row">
    <div class="col-sm-6"> 
       <input type="text" class="form-control" id="search"   name="name"  placeholder="Search Student">
    </div>
    <div class="col-sm-6"> 
     <button type="button" onclick="studentsearch()"  class="btn btn-danger" id='band'>Search</button>
    </div>
   </div>
    
  </div>

  <div class="form-group"> 
 <div class="row">
    
   <div class="col-md-6">
            <div id="loadings" style="display:none"><img style="height: 50px;width:50px" src="{{url('public/team/loading.gif')}}" />
            </div>
    <div  id="users">
    </div>
    <div  id="nodata">
    </div>
    </div>
  
  </div>
</div>

<div class="form-group"> 
    <div class="col-sm-offset-2 col-sm-10">
      <button type="submit" class="btn btn-success">Submit</button>
    </div>
  </div>
</div>


</div>
<!-- </div> -->
<div class="col-md-5">

    <!-- <div class="card-body"> -->
 

       <table class="table table-bordered" id="selectstudent" style="margin-top:172px;display:none">
        <thead class="thead-dark">
          <th>Student Name</th> 
          <th>Student Role</th> 
           <th>Remove</th> 
         </thead>
       </table>

    
   
  <!-- </div> -->
</div>

</div>
</div>
</div>
</form>





<!-- Modal Start --->
<div class="row">
    <div class="modal fade" style="z-index:99999999" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Student Name : 
              <span type="hidden" id='student'>
            </span>
            <input type="hidden" id='studentid'/></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
              
            <div>
                <div class="form-group">
                    <label for="role">Role : </label>
                    <input type="email" class="form-control" id="role">
                </div>
            </div>
          </div>
          <div class="modal-footer">
           
            <button type="button" onclick="roles()" id="saves" class="btn btn-primary">Save</button>
          </div>
        </div>
      </div>
    </div>
</div>
</div>

<!-- Modal End --->
  <!-- </div> -->
</div>


<script type="text/javascript">



</script>
    

  <script>
    function role(e,id,ids)
    {
       var count=$('.mycxk').filter(':checked').length;

      if(count>=1 && count<=3)
      {
         $('#student').html($(".name_"+e).html());
     
      $("#studentid").val(id);

       $('#exampleModal').modal('show');
      }
      else
      {
        alert('You Can not select more than 3');
     
         $("#abcxyz"+id).prop('checked',true);
          $("#abcxyz"+id).prop('checked',false);
      }

     
    }

    function roles(){

   $("#selectstudent").show();
  $("#selectstudent").append("<tr><td><input type='hidden' name='ids[]' value='"+$("#studentid").val()+"'/><p>"+$('#student').html()+"</p></td><td><input type='text' name='role_"+$("#studentid").val()+"' value='"+$("#role").val()+"'/></td><td><span onclick='cancel(this)'>X</span></td></tr>");

      $('#exampleModal').modal('hide');
}

function cancel(id)
{
 
    $(id).parent().parent().remove();
}



function studentsearch(){
   $("#loadings").show();
       var schoolid=$("#school_Id").val();
       alert
    $.ajax({
            url:"{{url('studentseach')}}",
              data:{_token: '{!! csrf_token() !!}',schoolid:schoolid,'name':$('#search').val()},
            method:'POST',
            success:function(data){
  if(data.length == 6)
           {
           
            
             $("#nodata").html('<span style="color:red">No Student available for creating Team</span>');
             $("#loadings").hide();
           }
           else{


              $("#loadings").hide();
              $("#users").empty();
              $.each(JSON.parse(data),function(index,value){
        $('#users').append("<div class='col-md-12'><label class='col-md-6' id='abc"+value.id+"'><input id='abcxyz"+value.id+"' onclick=role("+index+","+value.id+",this) type='checkbox' class='mycxk' name='student[]' value='"+value.id+"' > <img style=' border-radius: 50%;width:40px;height:40px' src='{{url('public/team/')}}/previewimg.png'> <span class='name_"+index+"'>"+value.name+"</span></label></div>");
            
                   });

            }
              
            },

            error:function(data){
              
              console.log(data);
            },

          });
    
    
}





  </script>






@endsection

