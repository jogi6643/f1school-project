
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="StudioKrew">
    <title>Login Page</title>

    <link rel="canonical" href="{{url('')}}">
    <!-- Bootstrap core CSS -->
    <!-- resources/ -->
    <link href="{{url('assets/StudentCollageImage/css/bootstrap.css')}}" rel="stylesheet" >
    <link href="{{url('assets/StudentCollageImage/css/album.css')}}" rel="stylesheet">
    <!-- <link href="{{url('assets/website/css/album.css')}}" rel="stylesheet"> -->

    <style>
      
      body{
      }

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

<body class="login-bg"> 

<div class="login-logo">
  <div class="row">
    <div class="col-md-6"><img src="{{url('assets/website/aim/aim.png')}}" alt="" height="50"></div>
    <div class="col-md-6 text-right"><img src="{{url('assets/website/aim/login-tos.png')}}" alt="" height="50"></div>
  </div>
</div>


<div class="container">
  <div class="row">
    <div class="col-sm-12">
      <div class="login-box">
        <div class="row">
          <div class="col-md-6" style="padding-right:0;">
            <div class="login-form-holder">
              <form action="{{url('studentcollageloginview')}}" method="post" autocomplete="off">
                @csrf
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                @if(session()->has('danger'))
                <div class="alert alert-danger">{{session()->get('danger')}}</div>
                @endif
                
                <div class="row">
                  <div class="col-sm-12">
                  <h1 class="text-danger">Login</h1>
                    <div class="form-group">
                      <label> E-mail <span class="text-danger">*</span></label>
                      <input type="text" name="email" class="form-control">
                    </div>
                  </div>

                  <div class="col-sm-12">
                    <div class="form-group">
                        <label> Password <span class="text-danger">*</span> </label>
                        <input type="password" name="password" class="form-control">
                    </div>
                  </div>
                </div>
                <div class="form-group text-center" align="center">
                    <input type="submit" class="btn btn-danger btn-block" value="Sign in">
                </div>
              </form>
              <div class="login-account-nav">
                <p>Don't have any account? | <a href="{{route('studentCollegeRegister')}}" class="text-danger">Sign Up</a> </p>
              </div>
            </div>
          </div>
          <div class="col-md-6" style="padding-left:0;">
            <img src="{{url('assets/website/aim/login-img.jpg')}}" alt="" width="100%">
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<div class="container">


  <div class="footer text-center">
     <p class="login-footer">www.timeofsports.com | Toll Free: 1800 102 5251</p>
  </div>  

</div><!--container-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

</body>
</html>
