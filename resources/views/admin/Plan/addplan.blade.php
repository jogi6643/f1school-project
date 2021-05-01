@extends(Auth::user()->role==2? 'layouts.coadmin':'layouts.admin')
@section('content')
                  
<div class="container">

          <div class="text-right">
                           
                           <button type="button" onclick="goBack()" class="btn btn-info">Go Back</button>

<script>
function goBack() {
  window.history.back();
}
</script>
               </div>
  <form class="form-horizontal" method="post" action="{{url('addplan')}}" enctype="multipart/form-data">
  
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
    
    <div class="card-header"><h6>Plan Master</h6></div>

  <div class="row">
<div class="col-md-7">
  <div class="card-body">
   
<div class="form-group">
    <label class="control-label col-sm-4" for="team">Plan Name</label>
    <div class="col-sm-8"> 
    <input type="text"  required class="form-control" name="name" id="pwd" placeholder="Enter Plan Name">
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-4" for="team">Manufacturing Cost</label>
    <div class="col-sm-8"> 
    <input type="number" required class="form-control" name="manufacturing_cost" id="pwd" placeholder="Manufacturing Cost">
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-4" for="team">Block Level</label>
    <div class="col-sm-8"> 
     <select name="level" required>
	 <option value="">--Select block level --</option>
	  <option value="1">Individual</option>
	  <option value="2">Team</option>
	 </select>
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-4" for="team">Number of block</label>
    <div class="col-sm-8"> 
    <input type="number" required class="form-control" min=1 name="number" id="pwd" placeholder="Number of block">
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-4" for="team">Block price</label>
    <div class="col-sm-8"> 
    <input type="number" required class="form-control" min=1 name="block_price" id="pwd" placeholder="Number of block">
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
       
      if(count<=6)
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

    function roles(){

   $("#selectstudent").show();
  $("#selectstudent").append("<tr><td><input type='hidden' name='ids[]' value='"+$("#studentid").val()+"'/><p>"+$('#student').html()+"</p></td><td><input type='text' name='role_"+$("#studentid").val()+"' value='"+$("#role").val()+"'/></td><td><span onclick='cancel(this)'>X</span></td></tr>");

      $('#exampleModal').modal('hide');
}

function cancel(id)
{
 
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
              $('#users').append("<div class='col-md-12'><label class='col-md-6' id='abc"+value.id+"'><input id='abcxyz"+value.id+"' onclick=role("+index+","+value.id+",this) type='checkbox' class='mycxk' name='student[]' value='"+value.id+"' > <img style=' border-radius: 50%;width:40px;height:40px' src='{{url('public/team/')}}/previewimg.png'><span style='display:inline-block' class='name_"+index+"'>"+value.name+"</span></label><span style='display:inline-block' class='email_"+index+"'>"+value.studentemail+"</span></div>");
            
                   });


           }
      }
    })
  });
 
});
</script>





@endsection

