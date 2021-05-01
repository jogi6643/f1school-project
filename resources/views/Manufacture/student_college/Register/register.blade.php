
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v3.8.5">
    <title> Student College Registration F1 School </title>

    <link rel="canonical" href="https://getbootstrap.com/docs/4.3/examples/album/">
    <!-- Bootstrap core CSS -->
    <link href="{{url('resources/assets/website/css/bootstrap.css')}}" rel="stylesheet" >
    <link href="{{url('resources/assets/website/css/album.css')}}" rel="stylesheet">

    <style>
      
      body{}

      .head{
        background:#3e1c1c;
        margin-bottom: 20px;
        padding: 20px 30px 5px 30px;
      }

      .bg-style{
        background:#f7f7f7;
      }
      .text-color{
        color:white;
        font-family: unset !important;
        font-size: 20px;
      }

    </style>
  </head>

<body>

 <div class="head">   
  <div class="row">
    <div class="col-sm-2">
        <img src="{{url('public/Carimage/StretchIndiaWhite.png')}}" alt="" width="200px">
    </div>

   <div class="col-sm-8" align="center">
      <p class="text-color"> Student College Register </p>
    </div>

    <div class="col-sm-2" align="right">
      <a href="{{url('studentCollegeLogin')}}" class="btn btn-warning btn-sm"> Login </a>
    </div>

  </div>
</div><!--heead-->
  

<div class="container">
  <div class="row">


    <div class="col-sm-8 offset-md-2">

    @if(Session::has('success'))
    <div class="alert alert-success">
        <ul>
            <li>{{ Session::get('success') }}</li>
        </ul>
    </div>
    @endif

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="card">
    <div class="card-body bg-style"> 

      <form action="{{url('studentCollegeRegister')}}" method="post">
        @csrf

        <input type="hidden" name="teamEmail" value="{{ @$team_email }}">
        <input type="hidden" name="userRole" value="{{ @$user_role }}">

        <div class="row">
          <div class="col-sm-6">
            <div class="form-group">
                <label>First Name </label>
                <input type="text" name="first_name" class="form-control">
            </div>
          </div>

          <div class="col-sm-6">
              <div class="form-group">
                <label>Last Name </label>
                <input type="text" name="last_name" class="form-control">
            </div>
          </div>
        </div><!--inner--row-->

      <div class="row">
        <div class="col-sm-6">
          <div class="form-group">
            <label> E-mail <span class="text-danger">*</span></label>
            <input type="text" name="email" class="form-control" value="{{ @$user_email }}">
          </div>
        </div><!-- col-sm-6-->

        <div class="col-sm-6">
          <div class="form-group">
            <label> Phone Number <span class="text-danger">*</span></label>
            <input type="text" name="phone" class="form-control">
          </div>
        </div><!-- col-sm-6-->
      </div><!--inner row-->

      <div class="row">
        <div class="col-sm-12">
          <div class="form-group">
            <label> Date Of Birth </label>
            <input type="text" name="dob" id="datepicker" class="form-control" autocomplete="off">
          </div>
        </div><!-- col-sm-6-->
      </div><!--inner row-->

      <div class="row">

        <div class="col-sm-6">
          <div class="form-group">
            <label> State </label>
            <select name="state" id="state_select" class="form-control">

              @if(count($states) > 0)
                <option> --Select--</option>
              @foreach($states as $state)
                <option value="{{$state->id}}"> {{$state->name}} </option>
              @endforeach
              @endif
              
            </select>
          </div>
        </div><!-- col-sm-6-->

        <div class="col-sm-6">
          <div class="form-group">
            <label> City </label>
            <select name="city" id="city_select" class="form-control">
              
            </select>
          </div>
        </div><!-- col-sm-6-->

      </div><!--inner row-->

      <div class="row">

        <div class="col-sm-6">
          <div class="form-group">
          <label> College </label>
          <input type="text" name="college" class="form-control">
          </div>
        </div><!-- col-sm-6-->

        <div class="col-sm-6">
          <div class="form-group">
            <label> T-shirt Size </label>
            <input type="text" name="tshirt_size" class="form-control">
          </div>
        </div><!-- col-sm-6-->

      </div><!--inner row-->

      <div class="row">

        <div class="col-sm-6">
          <div class="form-group">
              <label> Password <span class="text-danger">*</span> </label>
              <input type="password" name="password" class="form-control">
          </div>
        </div><!-- col-sm-6-->

        <div class="col-sm-6">
          <div class="form-group">
              <label> Password <span class="text-danger">*</span> </label>
              <input type="password" name="confarmation_password" class="form-control">
          </div>
        </div><!-- col-sm-6-->

      </div><!-- roqw-->

      <br>


      <div class="form-group" align="right">
          <input type="submit" class="btn btn-danger" value="College Register">
      </div>

      </form>
        

    </div><!--card body-->
    </div><!-- card-->
    </div><!--col-sm-6-->

  </div><!--row-->



  <div class="footer text-center">
      <p class="mt-5 mb-3 text-muted">&copy; F1 School 2019</p>
  </div>  

</div><!--container-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<!-- date picker link -->
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script>
  
  $(document).ready(function(){

    $("#state_select").change(function(){

      var city = $('#state_select').val();

      $('#city_select').empty(); 
      $.ajax({

        type: "get",
        url: "{{ url('get_city')}}",
        data :{city:city},
        success:function(data){

          $.each(data, function( index, value ) {
            
            $("#city_select").append("<option value='"+ value.id+"'>" + value.name + "</option>");

          });
        }

      });

    });
  });

</script>

<script>
  $( function() {
    $( "#datepicker" ).datepicker();
  });
</script>


</body>
</html>
