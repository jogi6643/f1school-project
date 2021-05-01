
<!doctype html>
<html lang="en">
  <head><meta http-equiv="Content-Type" content="text/html; charset=gb18030">
    
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
     <meta name="description" content="">
    <meta name="author" content="StudioKrew">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>F1 in Seniors India - Participant</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/4.3/examples/album/">
    
    
  <link href="https://vjs.zencdn.net/7.6.0/video-js.css" rel="stylesheet">

  <!-- If you'd like to support IE8 (for Video.js versions prior to v7) -->
  <script src="https://vjs.zencdn.net/ie8/1.1.2/videojs-ie8.min.js"></script>
    <!-- Bootstrap core CSS -->
    
    <!-- <link href="{{asset('assets/website/css/bootstrap.css')}}" rel="stylesheet" > -->
     <link href="{{asset('assets/website/css/vedio.css')}}" rel="stylesheet" >
   <script src='https://vjs.zencdn.net/7.6.0/video.js'></script>
  <!--  <script src="{{url('resources/assets/website/js/vedio.js')}}"></script> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
   <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
    <style>

    <link href="http://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">

      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
      .Tile{
        cursor: auto !important;
      }


 
 .modal-dialog {
  margin-top: 0;
  margin-bottom: 0;
  height: 100vh;
  display: flex;
  flex-direction: column;
  justify-content: center;
}
 
    </style>
    <!-- Custom styles for this template -->
    <!-- <link href="{{asset('assets/website/css/album.css')}}" rel="stylesheet"> -->
    <link href="{{url('assets/StudentCollageImage/css/album.css')}}" rel="stylesheet">
    <link href="{{url('assets/StudentCollageImage/css/bootstrap.css')}}" rel="stylesheet" >
  </head>
    <body>



@if($studentName->register_type == 'F1Senior')
<!--   F1Senior header -->
  <header>
  <div class="collapse bg-dark" id="navbarHeader">
    <div class="container">
      <div class="row">
        <div class="col-sm-8 col-md-7 py-4">
          <h4 class="text-white">
            {{ ($studentName->name)=='' ? '': $studentName->name }} 
          </h4>

          <p class="text-muted">
              {{ ($studentName->school_name)=='' ? '':$studentName->school_name  }}
          </p>
      <div class="row">
            <a href="#" sid="{{$studentid}}" id="myprofile" style="color: #fff;">Edit Profile</a>
      </div>
        </div>
        <div class="col-sm-4 offset-md-1 py-4">
          <h4 class="text-white">Accounts</h4>
          <ul class="list-unstyled">

          @if($studentName->order_status != 'Pending ')  
             @if($collageTeamuserstatus==2)
            <li>
                <a class="text-white" href="{{url('student/create/team')}}/{{base64_encode($studentid.'_'.$schoolid)}}">
                  Create Team 
                </a>
            </li>
            @elseif($collageTeamuserstatus==1)
               <?php
                $sname = $studentName->name;
               $teamname = $collageTeamId->team_Name;
              ?>
            <li>
                <a  class="text-white" href="#" onclick="alreadyTeam('<?=$sname?>','<?=$teamname?>')">
                  Create Team 
                </a>
            </li>
            <li>
            <a class="text-white" href="{{url('student/team/show')}}/{{base64_encode($studentid.'_'.$schoolid)}}">
                  View Team 
                </a>
            </li>

            @if($Checkcomp>0)
             <li>
            <a class="text-white" href="{{url('show-competition')}}/{{base64_encode($studentid.'_'.$schoolid)}}">
                  Competition
                </a>
            </li>
            @endif

            @else
              <?php
                $sname = $studentName->name;
               $teamname = $collageTeamId->team_Name;
              ?>
             <li>
                <a  class="text-white" href="#" onclick="alreadyTeam1('<?=$sname?>','<?=$teamname?>')">
                  Create Team 
                </a>
            </li>
            @endif

    
            @else
            
            

          @endif

            <li>
              <a  href="#" class="text-white" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                                     Logout
                <form id="logout-form" action="{{ url('student_collage_logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
              </a>
            </li>

          </ul>
        </div>
      </div>
    </div>
  </div>
  <div class="navbar navbar-dark shadow-sm" style="background-color:#d70a01; ">
    <div class="container d-flex justify-content-between">
      <a href="{{url('studentcollagedashboard')}}" class="navbar-brand d-flex align-items-center" padding="top:10px;">
       <img class="" src="{{url('assets/website/img/tos-logo.png')}}" alt="" width="180">
      </a>

      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarHeader" aria-controls="navbarHeader" aria-expanded="false" aria-label="Toggle navigation">
        My Account
      </button>
    
    </div>
  </div>
</header>
@endif
  @yield('contents')
  
  
  
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
  <script>window.jQuery || document.write('<script src="/docs/4.3/assets/js/vendor/jquery-slim.min.js"><\/script>')</script>
<!--<script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.3.1.min.js"></script>-->
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<footer class="text-muted">
  <div class="container">
    <p class="float-right">
      <a href="#">Back to top</a>
    </p>
    <p>&copy; 2019 Time Of Sports | All Rights Reserved</p>
    
  </div>
</footer>


<!--<script src='https://vjs.zencdn.net/7.6.0/video.js'></script>-->

  <script src="{{asset('assets/website/js/bootstrap.js')}}"></script></body>
</html>
 <!-- Model For Team Check -->
<div  id='modal' hidden="">
<div  id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content" style="background-color: red; color: white;">
      
      <div class="modal-body">
        <h1 id='sendingmessage' class="text-center"></h1>
      </div>
     
    </div>

  </div>
</div>
</div>

<div  id='modal1' hidden="">
<div  id="myModal1" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content" style="background-color: red; color: white;">
      
      <div class="modal-body">
        <h1 id='sendingmessage1' class="text-center"></h1>
      </div>
     
    </div>

  </div>
</div>
</div>





<!-- Modal -->
<div id="editprofile" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
         
        <h4 class="modal-title text-decoration">Student Profile</h4>
        
      </div>
      <span id="sprofile"></span>
      <div class="modal-body">
        <form method="post" id="updatestudent" {{-- action="{{url('updatestudentinfo')}}"  --}}>
          @csrf
          <div class="form-group">
            <label for="usr">Name:</label>
            <input type="text" name="name" id="name" class="form-control" >
          </div>
          <div class="form-group">
            <label for="usr">Student Email:</label>
            <input type="text" name="studentemail" id="studentemail" disabled class="form-control" >
            <input type="hidden" name="studentemail" id="studentemail" class="form-control" >
          </div> 

    <div class="form-group">
            <label for="usr">Select image to crop:</label>
            
          <div class="row">
        <div class="col-md-4 text-center">

        <div id="upload-demo"></div>

        </div>

        <div class="col-md-4">

       
        <input type="file" id="image">
       
        </div>

        <div class="col-md-4">

        <div id="preview-crop-image" style="background:#9d9d9d;width:100px;padding:0px 0px;height:100px;"></div>

          </div>
          <div class="col-md-12 text-center">
             <button type="button" class="btn btn-primary upload-image" style="margin-top:2%">Upload Image</button>
          </div>
        </div>
      </div>


          <div class="form-group">
            <label for="usr">School Name:</label>
            <input type="text" name="schoolname" id="schoolname" disabled value="{{$studentName->school_name}}" class="form-control" >
          </div>
          <div class="form-group">
            <label for="usr">Team Name:</label>
            <input type="text" name="teamname" id="teamname" disabled class="form-control" >
          </div>                     
          <div class="form-group">
            <label >Class:</label>
            <select name="class" id="class" class="form-control">

            </select>            
          </div>
          <div class="form-group">
            <label for="usr">Student Section:</label>
            <input type="text" name="section" id="section" class="form-control" >
          </div>

          <div class="form-group">
               <label>D.O.B</label>
               <input    id="datepicker"  name="dob" class="form-control">
                <span id="e_datepicker" class="text-danger">
           </div>          
          <div class="form-group">
            <label for="usr">Mobile No:</label>
            <input type="text" name="mobileno" id="mobileno" class="form-control" >
          </div>

             <div hidden class="form-group">
            <label for="usr">Image:</label>
            <input type="text" name="image111" id="image111" class="form-control" >
          </div>
          <div class="form-group">
            <label for="usr">Address:</label>
            <input type="text" name="address" id="address" class="form-control" >
          </div>
          <div class="form-group">
            <label >T-shirt:</label>
            <select  name="tsize" id="tsize" class="form-control">

            </select>            
          </div>          
          <div class="form-group">
            <label for="usr">Guardian Name 1:</label>
            <input type="text" name="guardianname1" id="guardianname1" class="form-control" >
          </div>
          <div class="form-group">
            <label for="usr">Guardian Email 1:</label>
            <input type="text" name="guardianemail1" id="guardianemail1" class="form-control" >
          </div>
          <div class="form-group">
            <label for="usr">Guardian Phone 1:</label>
            <input type="text" name="guardianphone1" id="guardianphone1" class="form-control" >
          </div>
          <div class="form-group">
            <label for="usr">Guardian Name 2:</label>
            <input type="text" name="guardianname2" id="guardianname2" class="form-control" >
          </div>
          <div class="form-group">
            <label for="usr">Guardian Email 2:</label>
            <input type="text" name="guardianemail2" id="guardianemail2" class="form-control" >
          </div>
          <div class="form-group">
            <label for="usr">Guardian Phone 2:</label>
            <input type="text" name="guardianphone2" id="guardianphone2" class="form-control" >
          </div>          
           <div class="form-group text-center">
            <input type="hidden" name="hid" id="hid">
            <input type="submit" name="Edit" id="edit" class="btn btn-warning">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>                                                                                       
        </form>
      </div>
{{--       <div class="modal-footer text-center">
        
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div> --}}
    </div>

  </div>
</div>

 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.1/css/bootstrap.min.css">
<link href="http://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">  
<script src="http://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>  
<script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.2/croppie.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.2/croppie.min.css">
<script>

   function alreadyTeam(studentname,teamname){
   
          $('#modal').show();
           document.getElementById("modal").hidden = false;
           $('#myModal').modal('show'); 
           $('#sendingmessage').html(studentname+' can not create a team as he is a member of the '+teamname+' team');
          setTimeout(function(){
              $('#myModal').modal('hide')
            }, 20000);
  
  }

    function alreadyTeam1(studentname,teamname){
   
          $('#modal1').show();
           document.getElementById("modal1").hidden = false;
           $('#myModal1').modal('show'); 
           $('#sendingmessage1').html('You have been already invited to a team. Please check your mail and complete the steps.');
          setTimeout(function(){
              $('#myModal1').modal('hide')
            }, 20000);
  
  }

  
$(document).ready(function(){ 
 //fetching student profile data
 $('#myprofile').click(function(){   
  id= $('#myprofile').attr('sid');
   $.ajax({
    url:'{{ url('student_Collage_profileedit') }}',
    method:"POST",
    dataType:"json",
    data:{id:id, _token: '{{csrf_token()}}'},
    success:function(data)
    { 
      // console.log(data);
      console.log(data[0].id);
      $('#name').val(data[0].name);
      $('#studentemail').val(data[0].studentemail);
      $('#teamname').val(data[0].teamname);

      $('#class').html('<option value="'+data[0].class+'">'+data[0].class+'</option>');
      
      $.each(data[0].classdata, function(i, d) {
      // You will need to alter the below to get the right values from your json object.  Guessing that d.id / d.modelName are columns in your carModels data
      $('#class').append('<option value="' + d.class + '">' + d.class + '</option>');
      });   


      $('#section').val(data[0].section);
      $('#datepicker').val(data[0].dob);
      $('#mobileno').val(data[0].mobileno);
      $('#address').val(data[0].address);

      $('#tsize').html('<option value="'+data[0].tsize+'">'+data[0].tsize+'</option>');
      $.each(data[0].tshirt, function(i, d) {
      // You will need to alter the below to get the right values from your json object.  Guessing that d.id / d.modelName are columns in your carModels data
      $('#tsize').append('<option value="' + d.tsize + '">' + d.tsize + '</option>');
      });

      $('#guardianname1').val(data[0].guardianname1);
      $('#guardianemail1').val(data[0].guardianemail1);
      $('#guardianphone1').val(data[0].guardianphone1);
      $('#guardianname2').val(data[0].guardianname2);
      $('#guardianemail2').val(data[0].guardianemail2);
      $('#guardianphone2').val(data[0].guardianphone2);
      $('#hid').val(data[0].id);
      $('#editprofile').modal('show');

      //alert(data);

    }
   });
 });

  //updateing student profile data
  $(document).on('submit','#updatestudent',function(event){

    event.preventDefault();
    classdata=$('#class').val();
          $.ajaxSetup({
  headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});
    //alert(classdata);
    $.ajax({
      url:'{{url('updatestudentCollageinfo')}}',
      method:"POST",
      data:$(this).serialize(),
      dataType:"json",
      success:function(data)
      {
      

    
      if(data.errors)
      {
      
        html='';
        html = '<div class="alert alert-danger m-1">';
        for(var count = 0; count < data.errors.length; count++)
        {
         html += '<p>' + data.errors[count] + '</p>';
        }
        html += '</div>';
      }
      if(data.success)
      {
          alert(data.success);
        html = '<div class="alert alert-success">' + data.success + '</div>';
        $('#editprofile').modal('hide');
        location.reload();
      }
       
       $('#sprofile').html(html);
       $('#class').html('<option value="">'+classdata+'</option>');
      

      }


     });
   })

      // $('#datepicker').datepicker({minDate: new Date(2000,1-1,1), maxDate: '-17Y',
      // dateFormat: 'dd/mm/yy',
      // changeMonth: true,
      // changeYear: true,
      // yearRange: '-110:-17'});
         $(function() {  
            $( "#datepicker" ).datepicker({dateFormat: 'dd/mm/yy'});  
         });  
 
});
</script>  

<script type="text/javascript">
var resize = $('#upload-demo').croppie({

    enableExif: true,

    enableOrientation: true,    

    viewport: { 

        width: 100,

        height: 100,

        type: 'circle'

    },

    boundary: {

        width: 100,

        height: 100

    }

});



$('#image').on('change', function () { 

  var reader = new FileReader();

    reader.onload = function (e) {

      resize.croppie('bind',{

        url: e.target.result

      }).then(function(){

        console.log('jQuery bind complete');

      });

    }

    reader.readAsDataURL(this.files[0]);

});



$('.upload-image').on('click', function (ev) {

  resize.croppie('result', {

    type: 'canvas',

    size: 'viewport'

  }).then(function (img) {

    $.ajax({

      url: '{{url('upload_image_StudentCollage')}}',

      type: "POST",

      data: {"image":img,"_token": "{{ csrf_token() }}"},

      success: function (data) {

        html = '<img src="' + img + '" />';
       
        $("#preview-crop-image").html(html);
        $("#image111").val(data.status);


      }

    });

  });

});
$.ajaxSetup({

  headers: {

    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

  }

});





</script>