
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v3.8.5">
    <title>F1 in Schools India - Participant</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/4.3/examples/album/">

    <!-- Bootstrap core CSS -->
<link href="{{url('assets/website/css/bootstrap.css')}}" rel="stylesheet" >


    <style>
    html,
body {
  height: 100%;
}
.text-color{
  color:#fff;
}
body {
  display: -ms-flexbox;
  display: flex;
  -ms-flex-align: center;
  align-items: center;
  padding-top: 40px;
  padding-bottom: 80px;
  background-color: #f5f5f5;
}
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
        .title-undreline{
          border-top: 5px solid red;
          width: 100%;
         
          position: absolute;
          z-index: -1;
          
         
        }
      }
    </style>
    <!-- Custom styles for this template -->
    <link href="{{url('assets/website/css/album.css')}}" rel="stylesheet">
  </head>
  <body class="text-center" style="background-image: url('admin/img/canva.jpg'); background-size: cover; background-position: bottom;">

<div class="container">
  <div class="row">
    <div class="col-md-8">
     <img class="mb-4" src="{{url('assets/image/StretchIndiaWhite.png')}}" alt="" width="590" > 
    </div>
    <div class="col-md-4">
        <form class="form-signin" method="POST" action="{{ url('trlogin') }}">
        @csrf
        <!-- <img class="mb-4" src="{{url('resources/assets/website/img/logo.png')}}" alt="" width="260"> -->
        <!-- <h1 class="h3 mb-3 font-weight-normal">Please sign in</h1> -->
        <input type="hidden" name="check" value="5"/>



        <label for="inputEmail" class="sr-only">Email address</label>
        <input type="email" id="inputEmail" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" placeholder="Email address" name="email" required autofocus>
         @if ($errors->has('email'))
                                          <span class="invalid-feedback" role="alert">
                                              <strong>{{ $errors->first('email') }}</strong>
                                          </span>
                                      @endif
        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" id="inputPassword" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"  placeholder="Password" name="password" required>

        @if ($errors->has('password'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('password') }}</strong>
            </span>
        @endif




        <div class="checkbox mb-3 text-color">
          <label>
            <input type="checkbox" value="remember-me"> Remember me
          </label>
        </div>
        <div class="checkbox mb-3 ">
          <label>
            <a href="{{url('forgetpasswordemail')}}" class="text-color">Forgot Password </a>
          </label>
        </div>
        
         @if(session()->has('danger'))
            <div class="alert alert-danger">{{session()->get('danger')}}</div>
         @endif
        <button class="btn btn-lg btn-danger btn-block" type="submit">Sign in</button>
        <p class="mt-5 mb-3 text-muted">&copy; F1 in School 2019</p>
      </form>
    </div>
  </div>
  <div class="row">
    <div class="col-12">
      <div class="title-underline"></div>
    </div>
  </div>
</div>    
   
</body>
</html>
