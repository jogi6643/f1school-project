
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
      <p class="text-color"> Student College Login </p>
    </div>

    <div class="col-sm-2" align="right">
      <a href="{{route('studentCollegeRegister')}}" class="btn btn-warning btn-sm"> Register </a>
    </div>

  </div>
</div><!--heead-->
  

<div class="container">
  <div class="row">

    <div class="col-sm-8 offset-md-2">
      
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

      <form action="{{url('slogin')}}" method="post">
        @csrf

      <div class="row">
        <div class="col-sm-12">
          <div class="form-group">
            <label> E-mail <span class="text-danger">*</span></label>
            <input type="text" name="email" class="form-control">
          </div>
        </div><!-- col-sm-6-->

        <div class="col-sm-12">
          <div class="form-group">
              <label> Password <span class="text-danger">*</span> </label>
              <input type="password" name="password" class="form-control">
          </div>
        </div><!-- col-sm-6-->
      </div><!-- roqw-->
  <br>

      <div class="form-group" align="right">
          <input type="submit" class="btn btn-danger" value="College Login">
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

</body>
</html>
