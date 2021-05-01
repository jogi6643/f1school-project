@extends(Auth::user()->role==2? 'layouts.coadmin':'layouts.admin')
@section('content')

<div class="content-heading">
 <div>School Name: {{$data['schoolname']}}
     <small data-localize="dashboard.WELCOME"></small>
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
<div class="container">
  <form class="form-horizontal" method="post" action="{{url('teamstorebyad')}}" enctype="multipart/form-data">
  
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
    
    <div class="card-header">Create Team By {{$data['admin_name']}} </div>

  <div class="row">
<div class="col-md-7">
  <div class="card-body">
    <div  class="form-group">
    
    <div class="col-sm-10">
      <input type="hidden"  value="{{$data['admin_id']}}" class="form-control" name="admin_id" id="admin_id" placeholder="admin_id">
    </div>
  </div>

   <div  class="form-group">

    <div class="col-sm-10">
      <input type="hidden"  value="{{$data['school_id']}}" class="form-control" name="school_Id" id="school_Id" placeholder="school_Id">
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
    <input required="" type="text" class="form-control" name="team_Name" id="pwd" placeholder="Enter Team Name">
    </div>
  </div>

   <div class="form-group"> 
   <label class="control-label col-sm-12" for="des">Description</label>
    <div class="col-sm-10"> 
       <textarea class="form-control" name="about_team"  rows="5" id="comment" placeholder="Describe here..."></textarea>
    </div>
  </div>
<!-- <div cass="col-md-12">
       <label>Academic Year</label>
            <div class="form-group">
           <select required=""  class="form-control"  name="academicyear">
    <option value="">Academic year</option>
    {{ $year1 = date('Y')+1 }}
    @for ($year = 2015; $year <= $year1; $year++)
   <option value="<?=($year-1)."-".($year);?>"><?=($year-1)."-".($year);?></option>
    @endfor
</select>
           </div>
       </div> -->


  <div class="form-group"> 
   <div class="row">
    <div class="col-sm-6"> 
       <input type="text" class="form-control" id="search"   name="name"  placeholder="Search Student">
    </div>
    <div class="col-sm-6"> 
     <button type="button"   class="btn btn-danger" id='searchstudent'>Search</button>
    </div>
   </div>
    
  </div>

  <div class="form-group"> 
 <div class="row">
    
   <div class="col-md-12">
            <div id="loadings" style="display:none"><img style="height: 50px;width:50px" src="{{url('team/loading.gif')}}" />
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
    var len=1;
    function role(e,id,ids)
    {
	if($("#abcxyz"+id).prop("checked")==true)
       {    
		   if($("#"+id+"_row").length==0)
		   {
			 
			  if(len<=6)
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
				
				alert('This student is already added');
			}
     }
		else
		{
			$("#"+id+"_row").remove();
		}

     
    }

    function roles(){
    len=len+1;
   $("#selectstudent").show();
  $("#selectstudent").append("<tr id='"+$("#studentid").val()+"_row'><td><input type='hidden' name='ids[]' value='"+$("#studentid").val()+"'/><p>"+$('#student').html()+"</p></td><td><input type='text' name='role_"+$("#studentid").val()+"' value='"+$("#role").val()+"'/></td><td><span onclick='cancel(this)'>X</span></td></tr>");
    
      $('#exampleModal').modal('hide');
}

function cancel(id)
{
   len=len-1;
    $(id).parent().parent().remove();
}



// function studentsearch(){
//    //$("#loadings").show();
//     var schoolid=$("#school_Id").val();
//     alert($schoolid);
       
    // $.ajax({
    //         url:"{{url('studentseachbytr')}}",
    //           data:{_token: '{!! csrf_token() !!}',schoolid:schoolid,'name':$('#search').val()},
    //         method:'POST',
    //         success:function(data){
        
    //           // alert(data.length);
    //        if(data.length == 4)
    //        {
           
            
    //          $("#nodata").html('<span style="color:red">No Student available for creating Team</span>');
    //          $("#loadings").hide();
    //        }
    //        else{


    //           $("#loadings").hide();
    //           $("#users").empty();
    //           $.each(JSON.parse(data),function(index,value){
    //           $('#users').append("<div class='col-md-12'><label class='col-md-6' id='abc"+value.id+"'><input id='abcxyz"+value.id+"' onclick=role("+index+","+value.id+",this) type='checkbox' class='mycxk' name='student[]' value='"+value.id+"' > <img style=' border-radius: 50%;width:40px;height:40px' src='{{url('public/team/')}}/previewimg.png'> <span class='name_"+index+"'>"+value.name+"</span></label></div>");
            
    //                });


    //        }
              
    //         },

    //         error:function(data){
              
    //           console.log(data);
    //         },

    //       });
    
    
//}
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script type="text/javascript">
$(document).ready(function(event){

  $(document).on('click','#searchstudent',function(){
    var schoolid = $("#school_Id").val();
    // alert(schoolid);
    $.ajax({
      url:"{{url('studentseachbyad')}}",
      method:'POST',
      data:{_token: '{!! csrf_token() !!}',schoolid:schoolid,'name':$('#search').val()},
       beforeSend: function(){
        $("#loadings").show();
        },
      success:function(data)
      {
         console.log(data);
         //alert(data);
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

