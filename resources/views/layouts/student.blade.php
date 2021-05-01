<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{url('public/assets1/css/bootstrap.css')}}">
    <link rel="stylesheet" href="{{url('public/assets1/css/cover.css')}}">

    <!-- Owl Stylesheets -->
    <link rel="stylesheet" href="{{url('public/assets1/assets/owlcarousel/assets/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{url('public/assets1/assets/owlcarousel/assets/owl.theme.default.min.css')}}">

    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->

    <!-- javascript -->
    <script src="{{url('public/assets1/assets/vendors/jquery.min.js')}}"></script>
    <script src="{{url('public/assets1/assets/owlcarousel/owl.carousel.js')}}"></script>    

    <!-- Favicons
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="../assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="shortcut icon" href="../assets/ico/favicon.png">
    <link rel="shortcut icon" href="favicon.ico"> -->

    <title>F1S-TimeOfSports</title>
  </head>

  <body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <!-- logo.png -->
  <!-- tos-logo.png -->
  <a class="navbar-brand" href="{{url('dashboard')}}">
   <img class="" src="{{url('assets/website/img/tos-registered.png')}}" alt="" width="180">
  </a>
  
  <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
    <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
  <li>    
  <a class="navbar-brand right" href="{{url('dashboard')}}">
    
   <img class="" src="{{url('assets/website/img/Stretch-India-White.png')}}" alt="" width="180">
  </a>
</li>
      <li class="nav-item active">
        <a class="nav-link" href="{{url('dashboard')}}">Home <span class="sr-only">(current)</span></a>
      </li>
     
      <li class="nav-item">
        <div class="gettouch" id="touch">
          <img src="{{url('assets1/img/menu.png')}}" width="100%">
        </div>
      </li>
    </ul>
  </div>
</nav>

<!--SLIDER NAV-->
<div class="slide-out">
    <div class="content">
        <h2>STEM CLUB</h2>
    </div>
    <a class="exit">Close</a>
    <ul class="side_navigation list-unstyled">
      <li><a href="#" sid="{{$studentid}}" id="myprofile">Edit Profile</a></li>
      <li><a href="{{url('courseList')}}">Courses and training</a></li>
     

      @if(session('studenteamroleId')==0)
      <li ><a href="{{url('createTeam/')}}/{{base64_encode($studentid.'_'.$schoolid)}}">Create Team</a></li>
      @endif

      @if(session('studenteamroleId')!=0)
       @if(session('compId')!=0)
      <li ><a href="{{url('student/competition')}}/{{base64_encode($studentid.'_'.$schoolid)}}">Competition</a></li>
      @endif
      <li ><a href="{{url('viewTeam/')}}/{{base64_encode($studentid.'_'.$schoolid)}}">View Team</a></li>

      <li ><a href="{{url('orderList/')}}/{{base64_encode($studentid.'_'.$schoolid)}}">Order List</a></li>

      @endif

      @if(session('studenteamroleId')!=0)
      <li ><a href="{{url('manufacturePage/')}}/{{base64_encode($studentid.'.'.$schoolid)}}">Manufacturing Summary</a></li>

      <li><a hidden="" href="{{url('add_sponsership')}}/{{base64_encode($studentid.'_'.$schoolid)}}">Add Sponsorship</a></li>
      @endif
      <li>
         <a href="#"  onclick="event.preventDefault();document.getElementById('logout-form').submit();">                           
                <form id="logout-form" action="{{ url('slogout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
                Logout
       </a>
      </li>

    </ul>
</div>


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
<!-- Modal Start Message  -->
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
<!--End Modal Start Message  -->
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
            <input type="text" name="studentemail" id="studentemail"  class="form-control" >
           
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
           <!--  <select  name="class" id="class" class="form-control">

            </select>
            <select disabled="" name="class1" id="class1" class="form-control">

            </select>  -->   
            <input type="text" disabled="" name="class1" id="class1" class="form-control" > 
            <input hidden="" type="text" name="class" id="class" class="form-control" >        
          </div>
          <div class="form-group">
            <label for="usr">Student Section:</label>
            <input type="text" name="section" id="section" class="form-control" >
          </div>

          <div class="form-group">
               <label>Student Date of Birth</label>
               <input  disabled=""   id="datepicker1"  name="dob" class="form-control">
               <input required="" hidden=""   id="datepicker"  name="dob" class="form-control">
                <span id="e_datepicker" class="text-danger">
           </div>          
          <div class="form-group">
            <label for="usr">Mobile No:</label>
            <input disabled="" type="text" name="mobileno" id="mobileno1" class="form-control" >
             <input hidden="" type="text" name="mobileno" id="mobileno" class="form-control" >
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

<!-- End edit Student profile -->
<!--SLIDER NAV END-->

 @yield('contents')


 <div class="footer">
  <div class="container">
    <div class="row">
      <div class="col-md-2">
        <div class="footer_title">TOS In News</div>
        <ul class="list-unstyled">
          <li><a href="#">About Challenge</a></li>
          <li><a href="#">The Process</a></li>
          <li><a href="#">Register</a></li>
          <li><a href="#">Get In Touch</a></li>
        </ul>
      </div>
      <div class="col-md-2">
        <div class="footer_title">F1 College</div>
        <ul class="list-unstyled">
          <li><a href="#">About Challenge</a></li>
          <li><a href="#">The Process</a></li>
          <li><a href="#">Register</a></li>
          <li><a href="#">Get In Touch</a></li>
        </ul>
      </div>
      <div class="col-md-2">
        <div class="footer_title">Company</div>
        <ul class="list-unstyled">
          <li><a href="#">About Challenge</a></li>
          <li><a href="#">The Process</a></li>
          <li><a href="#">Register</a></li>
          <li><a href="#">Get In Touch</a></li>
        </ul>
      </div> 
      
 <div class="col-md-3"></div>
    <div class="col-md-6"><img src="{{url('assets1/img/footer-bg.jpg')}}" width="100%"></div>
    <div class="col-md-3"></div>
    </div>
    <!-- <div class="row">
      <div class="col-md-3">
      </div>
    <div class="col-md-5">
      &nbsp;  &nbsp;  &nbsp; Contact us : 18001025251 |  queryf1s@timeofsports.com 
  </div>
  <div class="col-md-4">
  </div>
  </div> -->
    <div class="copyright">  &copy; Time of Sports Solutions Pvt Ltd 2020 | All Right Reserved
     
    </div>
  </div>
</div>



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

    <!-- vendors -->
   <script src="{{url('assets1/assets/vendors/highlight.js')}}"></script>
    <script src="{{url('assets1/assets/js/app.js')}}"></script>

    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="{{url('assets1/js/bootstrap.min.js')}}"></script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.2/croppie.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.2/croppie.min.css">
    <!-- Upload image Code  -->

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
  //alert(id);
   $.ajax({
    url:'{{ route('studentprofileedit') }}',
    method:"POST",
    dataType:"json",
    data:{id:id, _token: '{{csrf_token()}}'},
    success:function(data)
    { 
      console.log(data);
      console.log(data[0].id);
      $('#name').val(data[0].name);
    if(data[0].studentemail!="tosnewlogin@gmail.com"){
      $('#studentemail').val(data[0].studentemail);
    }
      $('#teamname').val(data[0].teamname);
      $('#class').val(data[0].class);
      $('#class1').val(data[0].class);
      $('#image111').val(data[0].profileimage);
      // $('#class').html('<option value="'+data[0].class+'">'+data[0].class+'</option>');
      // $('#class1').html('<option value="'+data[0].class+'">'+data[0].class+'</option>');
      
      
      $.each(data[0].classdata, function(i, d) {
      // You will need to alter the below to get the right values from your json object.  Guessing that d.id / d.modelName are columns in your carModels data
      $('#class').append('<option value="' + d.class + '">' + d.class + '</option>');
      });   


      $('#section').val(data[0].section);
      $('#datepicker').val(data[0].dob);
      $('#mobileno').val(data[0].mobileno);
      $('#datepicker1').val(data[0].dob);
      $('#mobileno1').val(data[0].mobileno);
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
      url:"{{route('updatestudentinfo')}}",
      method:"POST",
      data:$(this).serialize(),
      dataType:"json",
      success:function(data)
      {
      console.log(data);
       location.reload();
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

        html = '<div class="alert alert-success">' + data.success + '</div>';
        $('#editprofile').modal('hide');
        location.reload();
      }
       
       $('#sprofile').html(html);
       $('#class').html('<option value="">'+classdata+'</option>');
      

      },
      error:function(data)
      {
        console.log(data);
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

      url: "{{url('upload_image')}}",

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

  <!-- End Upload Image Code  -->
  </body>
</html>