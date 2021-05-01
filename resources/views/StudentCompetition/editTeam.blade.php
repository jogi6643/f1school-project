@extends('layouts.student')
@section('contents')
<!--SLIDER NAV END-->
<img src="" width="100%">
<div class="bg3">
  <div class="container">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active" aria-current="page">Manage Team</li>
        </ol>
      </nav>
      <!--Notification-->
      <div class="cards">
        <div class="cards_title">
          <span><img src="{{url('team/Comp.png')}}" width="100%"></span>Manage Team
        </div>
        <div class="bg8">
          
          <div class="row">
            <div class="col-md-6">
              <div class="row">
                <div class="col-md-5 col-sm-6">
                  <div hidden="" class="profile-image">
                    <img src="{{url('team/team-no-photo.png')}}" width="100%">
                  </div>
                </div>
			</div>
			<form class="form-horizontal" method="post" action="{{url('teamupdate')}}" enctype="multipart/form-data">
                <div class="col-md-7 col-sm-6">
                  <a hidden="" href="#" class="btn btn-dark">Upload Image</a>
 <div hidden class="form-group">
    <label class="control-label col-sm-2" for="team_file">TeamId</label>
    <div class="col-sm-10">
      <input type="text" value="{{$edit->teamId}}" class="form-control" name="teamid" id="team_id" placeholder="teamid">
    </div>
  </div>   
</div>
  <?php $stuid = explode("_", $edit->student_id);
$s = $stuid[0];

?>


    <div hidden=""  class="form-group">
    <label class="control-label col-sm-2" for="team_file">Student Id</label>
    <div class="col-sm-10">
      <input type="text" value="{{$studentid}}" class="form-control" name="student_id" id="student_id" placeholder="student_id">
    </div>
  </div>
  <div hidden class="form-group">
    <label class="control-label col-sm-2" for="school id">School Id</label>
    <div class="col-sm-10">
      <input type="text" value="{{$edit->school_id}}" class="form-control" name="school_Id" id="school_Id" placeholder="school_Id">
    </div>
  </div>
   <div class="form-group">
    
    <label class="control-label col-sm-2" for="team_file"></label>
    <div class="col-sm-10">
    
      @if($edit->team_Image!=null)
      <!-- <img  style="height: 100px;width:100px;" src="{{url('public/team/')}}/{{$edit->team_Image}}"> -->

       <div class="profile-image">
                    <img style="height: 100px;width:100px;" src="{{url('public/team/')}}/{{$edit->team_Image}}" width="100%">
        </div>
       <input type="file" class="form-control" value="{{$edit->team_Image}}" name="team_file" id="team_file" placeholder="Team Image">
       @else
        <!-- <img  style="height: 100px;width:100px;" src="{{url('/team/')}}/pro.jpg"> -->
        <div class="profile-image">
                    <img style="height: 100px;width:100px;" src="{{url('team/team-no-photo.png')}}" width="100%">
        </div>
       <input type="file" class="form-control" value="{{$edit->team_Image}}" name="team_file" id="team_file" placeholder="Team Image">
       @endif

    </div>
  </div>
  
  <div class="form-group">
    <label class="control-label col-sm-4" for="team">Team Name</label>
    <div class="col-sm-8"> 
      <input disabled="" type="text" value="{{$teamstore1->team_Name??""}}"class="form-control" name="Team_Name" id="pwd" placeholder="Enter Team Name">
       <input hidden="" type="text" value="{{$teamstore1->team_Name??""}}"class="form-control" name="Team_Name" id="pwd" placeholder="Enter Team Name">

    </div>
  </div>



<div class="form-group">
    <label class="control-label col-sm-4" for="Creator">Creator's Role</label>
    <div class="col-sm-8"> 
    <input type="text" value="{{$creatorrole->studentRole??''}}" class="form-control" name="CreatorRole"  placeholder="Creator's Role">
    </div>
  </div>



  <div class="form-group"> 
   <label class="control-label col-sm-12" for="des">Description</label>
    <div class="col-sm-10"> 
       <textarea class="form-control" value="{{$edit->team_Description}}" name="about_team"  rows="5" id="comment">{{$edit->team_Description}}</textarea>
    </div>
  </div>

   <div class="form-group"> 
   <div class="row">
    <div class="col-sm-6"> 
       <input type="text" class="form-control" id="search"   name="name"  placeholder="Student Search">
    </div>
    <div class="col-sm-6"> 
     <button type="button"  onclick="studentsearch()"  class="btn btn-danger" id='band'>Search</button>
    </div>
   </div>
    
  </div>
      

                </div>
             
           
            <div class="col-md-6">
              <div class="card_team_content table_red_border">
                <table class="table table-borderless text-center" id="selectstudent">
                  <thead>
                    <tr>
                      <th scope="col">Name</th>
                      <th scope="col">Role</th>
                      <th scope="col">Status</th>
                    </tr>
                  </thead>
                  <tbody>
                @if(count($student1)>0)
                @foreach($student1 as $student2)
                @if($check==$student2->studentid)
               <tr id="xyz{{$student2->studentid}}">
               <td><input type="hidden" name="ids[]" value="{{$student2->studentid}}"/><p>{{$student2->name}}</p></td>
                <td><input hidden="" type='text' name="role_{{$student2->studentid}}" value="{{$student2->studentRole}}"/>
                <input hidden="" type='text' @if($teamstore1!=null) @if($teamstore1->student_id!=$studentid.'_student') disabled="disabled"  @endif  @else disabled @endif name="role_{{$student2->studentid}}" value="{{$student2->studentRole}}"/>
               </td>
               <td> @if($student2->status!=1)<span onclick='rolecreator(this,{{$student2->studentid}},{{$student2->studentid}})'>X</span>@endif</td>
                </tr>
                    @else
               <tr id="xyz{{$student2->studentid}}">
               <td><input  type="hidden" name="ids[]" value="{{$student2->studentid}}"/><p>{{$student2->name}}</p></td>
               <td><input hidden="" type='text' name="role_{{$student2->studentid}}" value="{{$student2->studentRole}}"/>
               <input type='text' @if($teamstore1!=null) @if($teamstore1->student_id!=$studentid.'_student') disabled="disabled"  @endif     @else disabled @endif name="role_{{$student2->studentid}}" value="{{$student2->studentRole}}"/>
               </td>
               <td> @if($student2->status!=1)<span onclick='cancel(this)'>X</span>@endif</td>
               </tr>
                    @endif
                    @endforeach
                    @endif

                  </tbody>
                </table>
              </div>

              <div class="bg9">
                <h5 class="f4">Notes</h5>
                <div class="cards_list">
                  <ol>
                    <li>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.</li>
                    <li>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</li>
                    <li>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.</li>
                  </ol>
                </div>
              </div>

            </div>
      

          <div class="row">
            <div class="col-sm-10">
              <div class="card_team_content table_red_border">
                <table class="table table-borderless text-center" id="users">
                  <thead>
                    <tr>
                      <th></th>
                      <th scope="col">Participant</th>
                      <th scope="col">Email Id</th>
                      <th scope="col">Contact No.</th>
                      <th scope="col">Date of Birth</th>
                    </tr>
                  </thead>
                  <tbody>

                    <div  id="">
                    <?php $i = 0; ?>
                    @if(count($student)>0)
                      @foreach($student as $student)
                      @if($check==$student->studentid)
                    <tr>
                      <td><input onclick="rolecreator({{$i}},{{$student->studentid}},this)" id="abc1ff{{$student->studentid}}" checked name="student[]" value="{{$student->studentid}}" type="checkbox" class="form-check-input" id="exampleCheck1"></td>
                      <td><div class="team_profile"><img class="profile-image" src="{{url('/team/')}}/pro.jpg"> <span>{{$student->name}}</span></div></td>
                      <td style="line-height:4;">{{$student->studentemail}}</td>
                      <td style="line-height:4;">{{$student->mobileno}}</td>
                      <td style="line-height:4;">{{$student->dob}}</td>
                    </tr>
                    @else
                    <tr>
                      <td><input type="checkbox" class="form-check-input" onclick="role1({{$i}},{{$student->studentid}},this)" type="checkbox" id="abc1ff{{$student->studentid}}" checked name="student[]" value="{{$student->studentid}}" id="exampleCheck1"></td>
                      <td><div class="team_profile"><img class="profile-image" src="{{url('/team/')}}/pro.jpg"> <span>{{$student->name}}</span></div></td><td style="line-height:4;">{{$student->studentemail}}</td>
                      <td style="line-height:4;">{{$student->mobileno}}</td>
                      <td style="line-height:4;">{{$student->dob}}</td>
                    </tr>
                    @endif
                    @endforeach
                    @endif
                  </tbody>
                </table>
              </div>

            </div>
          </div>

      <!--Notification END-->
 

  </div>
</div>

</div>
</div>



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
         <div class="form-group"> 
    <div class="col-sm-offset-2 col-sm-10">
      <button type="submit" class="btn btn-success">Submit</button>
    </div>
  </div>
</div>
</form>



<script>
$(document).ready(function() {
    $('.gettouch').click(function(){
    $('.slide-out').css('right', '0');
    $('.gettouch').css('right', '330px');
   });
    
     $('.touchtoreg').click(function(){
     $('.slide-out').css('right', '0');
     $('.gettouch').css('right', '330px');
    });

$('.exit').click(function(){
  $('.slide-out').css('right', '-335px');
  $('.gettouch').css('right', '50px');
 });


});
</script>

<script>
  $(document).ready(function() {
    $('.owl-carousel').owlCarousel({
      loop: true,
      margin: 10,
      nav: false,
      lazyLoad: true,
      lazyLoadEager: 1,
      stagePadding:10,
      responsiveClass: true,
      responsive: {
        0: {
          items: 1,
          nav: true
        },
        600: {
          items: 2,
          nav: false
        },
        1000: {
          items: 3,
          margin: 20
        }
      }
    })
  })
</script>
<script>
  const second = 1000,
      minute = second * 60,
      hour = minute * 60,
      day = hour * 24;

let countDown = new Date('July 30, 2020 00:00:00').getTime(),
    x = setInterval(function() {    

      let now = new Date().getTime(),
          distance = countDown - now;

      document.getElementById('days').innerText = Math.floor(distance / (day)),
        document.getElementById('hours').innerText = Math.floor((distance % (day)) / (hour)),
        document.getElementById('minutes').innerText = Math.floor((distance % (hour)) / (minute)),
        document.getElementById('seconds').innerText = Math.floor((distance % (minute)) / second);

      //do something later when date is reached
      //if (distance < 0) {
      //  clearInterval(x);
      //  'IT'S MY BIRTHDAY!;
      //}

    }, second)
</script>
<!-- Searech box -->
  <script>
   var len=1;
    function role(e,id,ids)
    {

          $("#role").val(" ");
          if($("#abcxyz"+id).prop("checked")==true)
{
      var count=$('.mycxk').filter(':checked').length;
      if(len<=5)
      {
      $('#student').html($(".name_"+e).html());
      $("#studentid").val(id);
      $('#exampleModal').modal('show');
     

         // $("#abcxyz"+id).prop('checked',false);
         // $("#abcxyz"+id).is(':disabled');
      }
      else
      {
        alert('You Can not select more than 6');
         $("#abcxyz"+id).prop('checked',true);
         $("#abcxyz"+id).prop('checked',false);
      }
}
else{
  $("#"+id+"_row").remove();
  
}

     
    }

    function roles(){
    len=len+1;
   $("#selectstudent").show();
  $("#selectstudent").append("<tr id="+$("#studentid").val()+"_row><td><input type='hidden' name='ids[]' value='"+$("#studentid").val()+"'/><p>"+$('#student').html()+"</p></td><td><input type='text' name='role_"+$("#studentid").val()+"' value='"+$("#role").val()+"'/></td><td><span onclick='cancel(this,"+$("#studentid").val()+")'>X</span></td></tr>");

      $('#exampleModal').modal('hide');
}

function cancel(id,studentid)
{
  len=len-1;
    $(id).parent().parent().remove();
     // alert(id);
     $("#abcxyz"+studentid).prop('disabled',false);
      $("#abcxyz"+studentid).prop('checked',false);
}



function studentsearch(){
   $("#loadings").show();
       var schoolid=$("#school_Id").val();
       var student_id=$("#student_id").val();
       
    $.ajax({
            url:"{{url('studentseach')}}",
              data:{_token: '{!! csrf_token() !!}','student_id':student_id,'schoolid':schoolid,'name':$('#search').val()},
            method:'POST',
            success:function(data){
        if(data.length == 4)
           {
             $("#nodata").html('<span style="color:red">No Student available for creating Team</span>');
             $("#loadings").hide();
            
           }
           else{

             
              $("#loadings").hide();
              $("#users tbody").empty();

              $.each(JSON.parse(data),function(index,value){
          if(value.profileimage==null)
          {
           
              
    
   $('#users tbody').append("<tr><td><input id='abcxyz"+value.id+"' onclick=role("+index+","+value.id+",this) type='checkbox' class='mycxk' name='student[]' value='"+value.id+"' ></td><td><div class='team_profile'><img class='profile-image' src='{{url('assets/image')}}/placeholder.jpg'><span class='name_"+index+"'>"+value.name+"</span></div></td><td style='line-height:4;'>"+value.studentemail+"</td><td style='line-height:4;'>"+value.mobileno+"</td><td style='line-height:4;'>"+value.dob+"</td></tr>");
              

          // $('#users').append("<div class='col-md-12'><label  id='abc"+value.id+"'> <img style=' border-radius: 50%;width:40px;height:40px' src='{{url('assets/image')}}/placeholder.jpg'><span style='display:inline-block' class='name_"+index+"'>"+value.name+"</span></label><label > &nbsp;  &nbsp;<span style='display:inline-block' class='email_"+index+"'>"+value.studentemail+"</span> &nbsp;  &nbsp;<span style='display:inline-block;float-left' class='email_"+index+"'>"+value.mobileno+"</span>&nbsp;  &nbsp;<span style='display:inline-block' class='email_"+index+"'>"+value.dob+"</span></label></div>");
              
          }
          else
          {

            $('#users tbody').append("<tr><td><input id='abcxyz"+value.id+"' onclick=role("+index+","+value.id+",this) type='checkbox' class='mycxk' name='student[]' value='"+value.id+"' ></td><td><div class='team_profile'><img class='profile-image' '{{url('studentprofileimage/')}}/"+value.profileimage+"'><span>"+value.name+"</span></div></td><td style='line-height:4;'>"+value.studentemail+"</td><td style='line-height:4;'>"+value.mobileno+"</td><td style='line-height:4;'>"+value.dob+"</td></tr>");
              
            // $('#users').append("<div class='col-md-12'><label  id='abc"+value.id+"'><input id='abcxyz"+value.id+"' onclick=role("+index+","+value.id+",this) type='checkbox' class='mycxk' name='student[]' value='"+value.id+"' > <img style=' border-radius: 50%;width:40px;height:40px' src='{{url('studentprofileimage/')}}/"+value.profileimage+"'> &nbsp;  &nbsp;<span style='display:inline-block' class='name_"+index+"'>"+value.name+"</span></label> &nbsp;  &nbsp;<label><span style='display:inline-block' class='email_"+index+"'>"+value.studentemail+"</span> &nbsp;  &nbsp;<span style='display:inline-block' class='email_"+index+"'>"+value.mobileno+"</span>&nbsp;  &nbsp;<span style='display:inline-block;float-left' class='email_"+index+"'>"+value.dob+"</span></label></div>");
            
          }
       
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


 