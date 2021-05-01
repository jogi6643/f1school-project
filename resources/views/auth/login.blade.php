

<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v3.8.5">
    <title>Login</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/4.3/examples/album/">

    <!-- Bootstrap core CSS -->
    <link href="{{asset('pulic/assets/website/css/bootstrap.css')}}" rel="stylesheet" >


    <style>
    html,
body {
  height: 100%;
}

body {
/*  display: -ms-flexbox;
  display: flex;
  -ms-flex-align: center;*/
  align-items: center;
  padding-top: 40px;
  padding-bottom: 40px;
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
        .imagesetting{
          margin-top: 0px;
          float: none;
          text-align: center;
       
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
      }
/* Small devices (portrait tablets and large phones, 600px and up) */
@media only screen and (max-width: 600px){
         .imagesetting{
          margin-top:-35px;
          float: none;
     
         } 
        .imagealign{
          float: none;
          position: absolute;
          top:595px;
          right:4px;
          width: auto;
          height: 61px;
          text-align: center;
          padding: 0;
          margin: 0
         } 
} 
/* Small devices (portrait tablets and large phones, 600px and up) */
@media only screen and (min-width: 600px) {
           .imagesetting{
          margin-top:-35px;
          float: none;
     
         } 
        .imagealign{
          float: none;
          position: absolute;
          top:595px;
          right:4px;
          width: auto;
          height: 61px;
          text-align: center;
          padding: 0;
          margin: 0;
         }
}

/* Large devices (laptops/desktops, 992px and up) */
@media only screen and (min-width: 992px) {
         .imagesetting{
          margin-top: 30px;
          float: none;
          text-align: center;
          margin-right: 30px;
          padding-top: 0px;
         } 
         .imagealign{
          float: right;
          position: absolute;
          padding-top: 0px;
          margin-right: 40px;
          top:565px;
          right: 55px;
          width: 507px;
          height: 61px;
          padding: 0;
          margin: 0
         }
}      
    </style>
    <!-- Custom styles for this template -->
    <link href="{{asset('public/assets/website/css/album.css')}}" rel="stylesheet">
  </head>


  <body style="background-image: url('public/admin/img/canva.jpg'); background-size: cover; background-position: bottom;">


    <div class="container mt-5">

    <div class="row">

      <div class="col-sm-8">
        <img class="mb-4 mt-5" src="{{asset('public/assets/image/StretchIndiaWhite.png')}}" alt="" width="590" >
      </div>

      <div class="col-sm-4">
      <div class="form-signin">  

      <h1 hidden class="h3 mb-3 font-weight-normal">Please sign in</h1>

      <form method="POST" action="{{ route('login') }}">
       @csrf
	   @if(session()->has('success'))
		     <span class="invalid-feedback" role="alert">
              <strong>{{ session('success') }}</strong>
            </span>
		   @endif
		    
		     <span class="invalid-feedback" role="alert">
              <strong>{{ session('error') }}</strong>
            </span>
		 


       <div class="form-group">
          <label for="inputEmail" class="sr-only">Email address</label>
          <input type="email" id="inputEmail" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" placeholder="Email address" name="email" required autofocus>
           @if ($errors->has('email'))
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $errors->first('email') }}</strong>
              </span>
          @endif
        </div>

    <div class="form-group">
      <label for="inputPassword" class="sr-only">Password1 </label>
      <input type="password" id="inputPassword" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"  placeholder="Password" name="password" required>

        @if ($errors->has('password'))
            <span class="invalid-feedback" role="alert">
              <strong>{{ $errors->first('password') }}</strong>
            </span>
        @endif
    </div>

    <div class="form-group text-center">
      <div class="checkbox mb-3">
        <label style="color:#FFF!important;">
          <input type="checkbox" value="remember-me" > Remember me
        </label>
      </div>
    </div>

    <div class="form-group text-center">
      <div class="checkbox mb-3">
       <a href="{{url('coforgetpasswordemail')}}" class="text-info" style="color:#FFF!important;">Forgot Password?</a>
      </div>
    </div>

    @if(session()->has('danger'))
         <div class="alert alert-danger">{{session()->get('danger')}}</div>
    @endif
    <button class="btn btn-lg btn-danger btn-block" type="submit">Sign in</button>
    </form>
   </div>

</div><!-- col-sm-4-->

</div><!--row-->
 
<br><br><br><br><br><br><br>
<div  class="text-center imagesetting">
  
  <p class=" text-muted pr-4" style="color: #FFF!important;">&copy; F1 in Schools™ India 2019
  </p>
   <img class=" p-0 imagealign"   src="{{asset('assets/website/img/tosregistered.png')}}" alt=""  >
</div>

</div>
<!-- container-->

 
</body>
</html>



  