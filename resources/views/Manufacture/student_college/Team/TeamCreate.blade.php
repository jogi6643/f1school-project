
@extends('layouts.student')
@section('contents')
<meta name="csrf-token" content="{{ csrf_token() }}">

<script>
function goBack() {window.history.back();}
</script>

<div class="container">

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


  <form class="form-horizontal" method="post" action="{{url('student/team/store')}}" enctype="multipart/form-data">

    {{csrf_field()}}
    <br>

<div class="card">
  
  <div class="card-header">Create Team By {{$studentname}}</div>
  <div class="text-right" style="margin-top: -44px; margin-right: 10px;">
      <button type="button" onclick="goBack()" class="btn btn-info">Go Back</button>
  </div>

<div class="row">
<div class="col-md-7">
<div class="card-body">

  <div class="form-group">
    <div class="col-sm-10">
      <input type="hidden" value="{{$sid}}" class="form-control" name="student_id" id="student_id" placeholder="student_id">
    </div>
  </div>

   <div class="form-group">
    <div class="col-sm-10">
      <input type="hidden" value="{{$scid}}" class="form-control" name="school_Id" id="school_Id" placeholder="school_Id">
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
       <textarea class="form-control" name="about_team" rows="5" id="comment" placeholder="Description"> </textarea>
    </div>
  </div>

  <div class="form-group"> 
   <div class="row">
    <div class="col-sm-6"> 
       <input type="text" class="form-control" id="search" name="name"  placeholder="Search Student Email">
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

    <div id="usersData">
    
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

  <div class="body" style="margin-top:100px;">

        <div class="row" style="background:#4e4c4c;color: aliceblue;">
          <div class="col-sm-6"> Email</div>
          <div class="col-sm-3"> Role </div>
          <div class="col-sm-3"> Invite </div>
        </div><br>

        <div id="user_invite"></div>

  </div> 

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
              <span type="text" id='student'></span>

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

<!--  -->
    

  <script>
    function role(id,ids)
    {
   
       var count=$('.mycxk').filter(':checked').length;

      if(count>=1 && count<=3)
      {
         $('#student').html($(".name_"+name).html());
     
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
   		var htlmData = '';

  		htlmData += "<tr>";
  		htlmData += "<td><input type='hidden' name='ids[]' value='"+$("#studentid").val()+"'/><p>"+$('#student').html()+"</p></td>";

  		htlmData += "<td><input type='text' name='role_"+$("#studentid").val()+"' value='"+$("#role").val()+"'/></td>";

  		htlmData += "<td><span onclick='cancel(this)'>X</span></td>";
  		htlmData += "</tr>";

  		$("#selectstudent").html(htlmData);

      $('#exampleModal').modal('hide');
}

function cancel(id)
{
 
    $(id).parent().parent().remove();
}


var count = 0; 
function studentsearch(){
   
   	$("#loadings").show();

    var schoolid = $("#school_Id").val();

    var dataHtml = '';
    var invite = '';
     
    $.ajax({
            url:"{{url('/student_colleget_search')}}",
            method:'POST',
            data:{
            	_token: '{!! csrf_token() !!}',
            	schoolid:schoolid,
            	'name':$('#search').val()
            },
            success:function(data){

            var valuech = JSON.parse(data);

  			if(valuech.error){
            
             $("#nodata").html(valuech.error);
             $("#loadings").hide();

        }else if(valuech.email){

            count++;

             if(count <= 5){

                invite += "<form id='formData_"+count+"' method='post'>";
                invite += "<div class='row'>";
                invite += "<p hidden><input type='text' name='team_email' value='"+valuech.email+"'></p>";
                invite += "<p hidden><input type='text' name='user_email' value='"+valuech.email+"'></p>";
                
                invite += "<div class='col-sm-3'>"+ valuech.email +"</div>";
                invite += "<div class='col-sm-6'><input type='text' name='role' id='role'></div>";
                invite += "<div class='col-sm-3'><a href='javascript:void(0)' onclick='form_submit("+count+")' class='btn btn-sm btn-info' id='btndis_"+count+"'>Invite</a></div>";
                invite += "</div>";
                invite += "</form><br>";
                 
                $('#user_invite').append(invite);

             }else{

                alert('max data insert');
             }  
             $("#loadings").hide();
            }else{

              $("#loadings").hide();
              $("#users").empty();
              $("#nodata").hide();

	            var value = JSON.parse(data);

		        dataHtml += "<div class='col-md-12'>";
		        dataHtml += "<label class='col-md-6' id='abc"+value.id+"'>";
		        dataHtml += "<input id='abcxyz"+value.id+"' onclick=role("+value.id+",this) type='checkbox' class='mycxk' name='student[]' value='"+value.id+"' >";

		        dataHtml += "<img style=' border-radius: 50%;width:40px;height:40px' src='{{url('public/team/')}}/previewimg.png'>";

		        dataHtml += "<span class='name_'>"+value.name+"</span>";
		        dataHtml += "</label>";
		        dataHtml += "</div>";

        		$('#usersData').html(dataHtml);

            }
              
            },

            error:function(data){
              
              console.log(data);
            },

          });
}
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
  
  function form_submit(id){

    alert('jsjs');

    var form_data = $('#formData_'+id).serialize(); //Encode form elements for submission
  
    $.ajax({
      url : "{{ url('/inviteUser')}}",
      type: "POST",
      data : form_data,
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      success:function(data){

        alert(data);

        $('#btndis_'+id).html('Invited');
        $('#btndis_'+id).attr('disabled');
        $('#btndis_'+id).css("background", "red");
      }
    });

  }    

  </script>


@endsection



