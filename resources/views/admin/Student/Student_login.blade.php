
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="author" content="StudioKrew">
   		<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
	<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-168444054-1"></script>
<script>
 window.dataLayer = window.dataLayer || [];
 function gtag(){dataLayer.push(arguments);}
 gtag('js', new Date());
 
 gtag('config', 'UA-168444054-1');
</script>
<title>Welcome to F1 In Schools</title> <!-- Bootstrap core CSS -->
<link href="{{asset('public/assets/website/css/bootstrap.css')}}" rel="stylesheet" >


     <style>
    html,
body {
  height: 100%;
}
.text-color{
  color:#fff;
}
body {
/*  display: -ms-flexbox;
  display: flex;
  -ms-flex-align: center;
  align-items: center;*/

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
/* Medium devices (landscape tablets, 768px and up) */
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
        .imagealign{
          float: right;
          position: absolute;
          margin-right: 40px;
          top:495px;
          right: 55px;
          width: 350px;
          height: 61px;
          padding: 0;
          margin: 0;
         }
         .copyright{
          margin-top: 150px;
              bottom: 0;
    position: absolute;
    width: 100%;
    text-align: center;
         }          
      }


/* Small devices (portrait tablets and large phones, 600px and up) */
@media only screen and (min-width: 600px){
        .imagealign{
          float: none;
          top:595px;
          right:4px;
          width: auto;
          height: 61px;
          text-align: center;
          padding: 0;
          margin: 0;
         }
         .copyright{
          margin-top: 150px;
    bottom: 0;
    position: absolute;
    width: 100%;
    text-align: center;
         }         
}
/* Small devices (portrait tablets and large phones, 600px and up) */
@media only screen and (max-width: 600px){
       
        .imagealign{
          float: none;
          text-align: center;
          padding:25px;
         } 
         .copyright{
          margin-top: 150px;
    bottom: 0;
    position: absolute;
    width: 100%;
    text-align: center;
         }         
}

/* Large devices (laptops/desktops, 992px and up) */
@media only screen and (min-width: 992px) {
         .imagealign{
          float: right;
          padding-top: 0px;
          margin-right: 40px;
          height: 61px;
         }
         .copyright{
          margin-top: 170px;
    bottom: 0;
    position: absolute;
    width: 100%;
    text-align: center;
         }
}


    </style>
    <!-- Custom styles for this template -->
    <link href="{{asset('public/assets/website/css/album.css')}}" rel="stylesheet">
  </head>
  <body class="text-center" style="background-image: url('public/admin/img/canva.jpg'); background-size: cover; background-position: bottom;">

<div class="container mt-5">
  <div class="row">
    <div class="col-md-8">
     <img class="mb-4" src="{{asset('public/assets/image/StretchIndiaWhite.png')}}" alt="" width="100%" style=" max-width: 380px;"> 
    </div>
    <div class="col-md-4">
	  @if(session()->has('success'))
		     <span class="invalid-feedback" role="alert">
              <strong>{{ session('success') }}</strong>
            </span>
		   @endif
		    
		     <span class="invalid-feedback" role="alert">
              <strong>{{ session('error') }}</strong>
            </span>
        <form class="form-signin" method="POST" action="{{ url('slogin') }}">
        @csrf
        <!-- <img class="mb-4" src="{{url('resources/assets/website/img/logo.png')}}" alt="" width="260"> -->
        <!-- <h1 class="h3 mb-3 font-weight-normal">Please sign in</h1> -->
        <input type="hidden" name="check" value="5"/>

        <!-- <label for="inputEmail" class="sr-only">Email address</label>
        <input type="email" id="inputEmail" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" placeholder="Email address" name="email" required autofocus>
         @if ($errors->has('email'))
                                     <span class="invalid-feedback" role="alert">
                                              <strong>{{ $errors->first('email') }}</strong>
                                          </span>
                                      @endif -->

          <label for="inputEmail" class="sr-only">Username</label>
        <input type="text"  class="form-control" name="username" value="" placeholder="Username" required autofocus>
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




       <!--  <label for="inputEmail" class="sr-only">Email address</label>
        <input type="email" id="inputEmail" class="form-control" placeholder="Email address" name="email" required autofocus>
        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" id="inputPassword" class="form-control" placeholder="Password" name="password" required> -->
       
        <div class="checkbox mb-3 ">
          <label>
            <a hidden="" href="{{url('studentemailfpassword')}}" class="text-color">Forgot Password</a>
            <a href="{{url('Forgot-UserName')}}" class="text-color">Forgot Username</a>
          </label>
           <a href="{{url('Forgot-PassWord')}}" class="text-color">Forgot Password</a>
        </div>
		 @if(session()->has('error'))
            <div class="alert alert-danger">{{session()->get('error')}}</div>
         @endif
         @if(session()->has('success'))
            <div class="alert alert-success">{{session()->get('success')}}</div>
         @endif
         @if(session()->has('danger'))
            <div class="alert alert-danger">{{session()->get('danger')}}</div>
         @endif
        <button class="btn btn-lg btn-danger btn-block" type="submit">Sign in</button>
		 <a href="{{url('studentlogin')}}" class="btn btn-lg btn-danger btn-block" type="submit">Logging In for the first Time ? Click Here</a>

        <div style="color:#ffffff; font-weight:600; padding-top:15px;">
      <p class=“” style=“color: #FFF!important;“>Having Trouble Signing in? <br><a style=“color:white;” href="https://docs.google.com/forms/d/1DsNbfENO4UBYHl8MeVucYrNrFe9tls9WyUlAQgO_ce4/edit">Click Here</a></p>
         <p>Contact: <a href="tel:1800 10 25251">1800 10 25251</a>
       <br>
        Email: <a href="mailto:queryf1s@timeofsports.com">queryf1s@timeofsports.com</a>
      </p>
    </div>
      </form>
    </div>
  </div>
 <img class=" p-0 imagealign"   src="{{asset('public/assets/website/img/tosregistered.png')}}" alt=""  width="100%" style="float:right; max-width: 380px;">
</div>
<div class="copyright ">
    <div  class="text-center "> 
      <p class=" text-muted  pr-4" style="color: #FFF!important;">&copy; F1 in Schools™ India
      </p>
    </div> 
</div>     
</body>
</html>
