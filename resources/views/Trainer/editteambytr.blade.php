@extends('layouts.trainer')
@section('content')

                    <div class="text-right">
                           
                   <button type="button" onclick="goBack()" class="btn btn-info">Go Back</button>

<script>
function goBack() {
  window.history.back();
}
</script>
               </div>
<div class="container">



  <!-- <din class="row"> -->
   
  <form class="form-horizontal" method="post" action="{{url('teamupdatebytr')}}" enctype="multipart/form-data">
  
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
    {{csrf_field()}}
 
  <div class="card mb-3">
    <div class="card-header">Updated Team By {{$studentname}} </div>
  <div class="row">
<div class="col-md-7">
  <div class="card-body">
  <div hidden class="form-group">
    <label class="control-label col-sm-2" for="team_file">TeamId</label>
    <div class="col-sm-10">
      <input type="text" value="{{$edit->id}}" class="form-control" name="teamid" id="team_id" placeholder="teamid">
    </div>
  </div>   
    <div  hidden class="form-group">
    <label class="control-label col-sm-2" for="team_file">Student Id</label>
    <div class="col-sm-10">
      <input type="text" value="{{$edit->student_id}}" class="form-control" name="student_id" id="student_id" placeholder="student_id">
    </div>
  </div>
  <div hidden class="form-group">
    <label class="control-label col-sm-2" for="school id">School Id</label>
    <div class="col-sm-10">
      <input type="text" value="{{$edit->school_id}}" class="form-control" name="school_Id" id="school_Id" placeholder="school_Id">
    </div>
  </div>
   <div class="form-group">
    
    <label class="control-label col-sm-2 zoom" for="team_file"></label>
    <div class="col-sm-10">
     @if($edit->team_Image==null)
      <img  style="height: 100px;width:100px;" src="{{url('team/')}}/pro.jpg">
      <input type="file" class="form-control" value="{{$edit->team_Image}}" name="team_file" id="team_file" placeholder="Team Image">
      @else
       <img  style="height: 100px;width:100px;" src="{{url('team/')}}/{{$edit->team_Image}}">
      <input type="file" class="form-control" value="{{$edit->team_Image}}" name="team_file" id="team_file" placeholder="Team Image">
      @endif

    </div>
  </div>

  <div class="form-group">
    <label class="control-label col-sm-4" for="team">Team Name</label>
    <div class="col-sm-8"> 
      <input type="text" value="{{$edit->team_Name}}"class="form-control" name="Team_Name" id="pwd" placeholder="Enter Team Name">
    </div>
  </div>
  <div class="form-group"> 
   <label class="control-label col-sm-12" for="des">Description</label>
    <div class="col-sm-10"> 
    <textarea class="form-control" value="{{$edit->team_Description}}" name="about_team"  rows="5" id="comment">  {{$edit->team_Description}}</textarea>
    </div>
  </div>

   <div class="form-group"> 
   <div class="row">
    <div class="col-sm-6"> 
       <input type="text" class="form-control" id="search"   name="name"  placeholder="Student Search">
    </div>
    <div class="col-sm-6"> 
     <button type="button" onclick="studentsearch1()"  class="btn btn-danger" id='searchstudent'>Search</button>
    </div>
   </div>
  </div>
 
<div class="form-group"> 
 <div class="row">

   <div class="col-md-12">
            <div id="loadings" style="display:none"><img style="height: 50px;width:50px" src="{{url('team/loading.gif')}}" />
            </div>

    <div  id="users">
      <?php $i=0;?>
      @if(count($student)>0)
   @foreach($student as $student2)

      @if($check==$student2->studentid)

      @if($student2->profileimage=="")
		   <div class='col-md-12'><label id="abc{{$student2->studentid}}"><input  onclick="rolecreator({{$i}},{{$student2->studentid}},this)" type="checkbox" id="abcxyz{{$student2->studentid}}" class='mycxk1' checked name="student[]" value="{{$student2->studentid}}" > <img style=" border-radius: 50%;width:40px;height:40px" src="{{url('assets/image')}}/placeholder.jpg"> <span class='name_{{$i}}'>{{$student2->name}}</span>
       &nbsp;  &nbsp;  <span style='display:inline-block'>{{$student2->studentemail}}</span> 
    &nbsp;  &nbsp;  <span style='display:inline-block'>{{$student2->mobileno}}</span>
      &nbsp;  &nbsp;<span style='display:inline-block'>{{$student2->dob}}</span>
      </label>

      </div>

	 @else
      <div class='col-md-12'><label id="abc{{$student2->studentid}}"><input  onclick="rolecreator({{$i}},{{$student2->studentid}},this)" type="checkbox" id="abcxyz{{$student2->studentid}}" class='mycxk1' checked name="student[]" value="{{$student2->studentid}}" > <img style=" border-radius: 50%;width:40px;height:40px" src="{{url('studentprofileimage')}}/{{$student2->profileimage}}">
        <span class='name_{{$i}}'>{{$student2->name}} </span>
                 &nbsp;  &nbsp;  <span style='display:inline-block'>{{$student2->studentemail}}</span> 
    &nbsp;  &nbsp;  <span style='display:inline-block'>{{$student2->mobileno}}</span>
      &nbsp;  &nbsp;<span style='display:inline-block'>{{$student2->dob}}</span>
      </label>

      </div>

	 @endif<?php $i++?>
    @else
      @if($student2->profileimage=="")
      <div class='col-md-12'><label id="abc{{$student2->studentid}}"><input  onclick="role1({{$i}},{{$student2->studentid}},this)" type="checkbox" id="abcxyz{{$student2->studentid}}" class='mycxk1' checked name="student[]" value="{{$student2->studentid}}" > <img style=" border-radius: 50%;width:40px;height:40px" src="{{url('assets/image')}}/placeholder.jpg"> 
        <span class='name_{{$i}}'>{{$student2->name}}</span>
         
        &nbsp;  &nbsp;  <span style='display:inline-block'>{{$student2->studentemail}}</span> 
    &nbsp;  &nbsp;  <span style='display:inline-block'>{{$student2->mobileno}}</span>
      &nbsp;  &nbsp;<span style='display:inline-block'>{{$student2->dob}}</span>
      </label>
    </div>

   @else
           <div class='col-md-12'><label  id="abc{{$student2->studentid}}"><input  onclick="role1({{$i}},{{$student2->studentid}},this)" type="checkbox" id="abcxyz{{$student2->studentid}}" class='mycxk1' checked name="student[]" value="{{$student2->studentid}}" > <img style=" border-radius: 50%;width:40px;height:40px" src="{{url('studentprofileimage')}}/{{$student2->profileimage}}"> <span class='name_{{$i}}'>{{$student2->name}}</span>

        &nbsp;  &nbsp;  <span style='display:inline-block'>{{$student2->studentemail}}</span> 
    &nbsp;  &nbsp;  <span style='display:inline-block'>{{$student2->mobileno}}</span>
      &nbsp;  &nbsp;<span style='display:inline-block'>{{$student2->dob}}</span>
      </label>

    </div>

   @endif<?php $i++?>
    @endif
   @endforeach
   @else
   <div class="col-md-12"><label></label>No Student Selected Yet</div>
   @endif
      
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
    <div class="col-md-5">

       <table class="table table-bordered" id="selectstudent" style="margin-top:172px;">
        <thead class="thead-dark">
          <th>Student Name</th> 
          <th>Student Role</th> 
           <th>Remove</th> 
         </thead>
          <?php $st = $student1;?>
                @if(count($student1)>0)
            @foreach($student1 as $student1)
            @if($check==$student1->studentid)
           <tr id="{{$student1->studentid}}_row">
            <td><input type="hidden" name="ids[]" value="{{$student1->studentid}}"/><p>{{$student1->name}}</p></td>
            <td><input type='text' name="role_{{$student1->studentid}}" value="{{$student1->studentRole}}"/></td>
            <td><span onclick='rolecreator(this,{{$student1->studentid}},{{$student1->studentid}})'>X</span></td>
          </tr>
          @else
           <tr id="{{$student1->studentid}}_row">
            <td><input type="hidden" name="ids[]" value="{{$student1->studentid}}"/><p>{{$student1->name}}</p></td>
            <td><input type='text' name="role_{{$student1->studentid}}" value="{{$student1->studentRole}}"/></td>
            <td><span onclick='cancel(this)'>X</span></td>
          </tr>
          @endif

          @endforeach
           @else
   <div class="col-md-12"><label></label>No Student Selected Yet</div>
   @endif
       </table>

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
</div>



  <script>

  var length={{count($student)}};

function roles(){
   $("#selectstudent").show();
  $("#selectstudent").append("<tr id='"+$("#studentid").val()+"_row'><td><input type='hidden' name='ids[]' value='"+$("#studentid").val()+"'/><p>"+$('#student').html()+"</p></td><td><input type='text' name='role_"+$("#studentid").val()+"' value='"+$("#role").val()+"'/></td><td><span onclick='cancel(this)'>X</span></td></tr>");

      $('#exampleModal').modal('hide');
    length=length+1;

}

function cancel(id,id1)
{
 
var count1=$('.mycxk').filter(':checked').length;


$("#abcxyz"+id1).prop("checked",false);
    $(id).parent().parent().remove();
  length=length-1;

}


function role(e,id,ids)
{


var count1=$('.mycxk').filter(':checked').length;

 count=length;


 if($("#"+id+"_row").length==0){
  
if($("#abcxyz"+id).prop("checked")==true)
{ 
    
      if(count<6)
      {
    
       $('#student').html($(".name_"+e).html());
       $("#studentid").val(id);
       $('#role').val("");
       $('#exampleModal').modal('show');
      }

      else
      {
        alert('You Can not select more than 6');
     
         $("#abcxyz"+id).prop('checked',true);
          $("#abcxyz"+id).prop('checked',false);
      }
}


else
{
  $("#"+id+"_row").remove();
}

}
else
{
  alert('This student is already added');
}
}

function rolecreator(e,id,ids)
{
  alert("You cannot remove the creator of the team");
     $("#abcxyz"+id).prop('checked',true);
  // $("#abcxyz"+id).prop('checked',false);
}
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script type="text/javascript">
$(document).ready(function(event){

  $(document).on('click','#searchstudent',function(){
    var schoolid = $("#school_Id").val();
    
    $.ajax({
      url:"{{url('studentseachbytr')}}",
      method:'POST',
      data:{_token: '{!! csrf_token() !!}',schoolid:schoolid,'name':$('#search').val()},
       beforeSend: function(){
        $("#loadings").show();
        },
      success:function(data)
      {
        
        // $("#loadings").hide();
          if(data.length == 4)
           {
           
            
             $("#nodata").html('<span style="color:red">No Student available for creating Team</span>');
             $("#loadings").hide();
           }
           else{


              $("#loadings").hide();
              $("#users").empty();
              $.each(JSON.parse(data),function(index,value){
          
          if(value.profileimage==null)
          {
             $('#users').append("<div class='col-md-12'><label  id='abc"+value.id+"'><input id='abcxyz"+value.id+"' onclick=role("+index+","+value.id+",this) type='checkbox' class='mycxk' name='student[]' value='"+value.id+"' > <img style=' border-radius: 50%;width:40px;height:40px' src='{{url('assets/image')}}/placeholder.jpg'><span style='display:inline-block' class='name_"+index+"'>"+value.name+"</span></label><label > &nbsp;  &nbsp;<span style='display:inline-block' class='email_"+index+"'>"+value.studentemail+"</span> &nbsp;  &nbsp;<span style='display:inline-block;float-left' class='email_"+index+"'>"+value.mobileno+"</span>&nbsp;  &nbsp;<span style='display:inline-block' class='email_"+index+"'>"+value.dob+"</span></label></div>");
              
          }
          else
          {
              $('#users').append("<div class='col-md-12'><label  id='abc"+value.id+"'><input id='abcxyz"+value.id+"' onclick=role("+index+","+value.id+",this) type='checkbox' class='mycxk' name='student[]' value='"+value.id+"' > <img style=' border-radius: 50%;width:40px;height:40px' src='{{url('studentprofileimage/')}}/"+value.profileimage+"'> &nbsp;  &nbsp;<span style='display:inline-block' class='name_"+index+"'>"+value.name+"</span></label> &nbsp;  &nbsp;<label><span style='display:inline-block' class='email_"+index+"'>"+value.studentemail+"</span> &nbsp;  &nbsp;<span style='display:inline-block' class='email_"+index+"'>"+value.mobileno+"</span>&nbsp;  &nbsp;<span style='display:inline-block;float-left' class='email_"+index+"'>"+value.dob+"</span></label></div>");
            
          }
              
                   });


           }
      }
    })
  });
 
});
</script>
@endsection