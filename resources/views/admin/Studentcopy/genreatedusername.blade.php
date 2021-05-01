

<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v3.8.5">
    <title>Login</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="canonical" href="https://getbootstrap.com/docs/4.3/examples/album/">

    <!-- Bootstrap core CSS -->
    <link href="{{asset('assets/website/css/bootstrap.css')}}" rel="stylesheet" >


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
    <link href="{{asset('assets/website/css/album.css')}}" rel="stylesheet">
  </head>


  <body style="background-image: url('admin/img/canva.jpg'); background-size: cover; background-position: bottom;">


    <div class="container mt-5">

    <div class="row">

      <div class="col-sm-8">
        <img class="mb-4 mt-5" src="{{asset('assets/image/StretchIndiaWhite.png')}}" alt="" width="590" >
      </div>

      <div class="col-sm-4">
      <div class="form-signin">  

      <h1 hidden class="h3 mb-3 font-weight-normal">Please  Register</h1>

      <form method="POST" action="{{ url('generateuser') }}" onsubmit="return check()">
       @csrf

       <div class="form-group">
          <label for="inputEmail" class="sr-only">Username</label>
          <input type="text" id="inputEmail" min="6" max="10" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="username" value="{{ old('email') }}" placeholder="Create Username" name="email" required autofocus>
           @if (session()->has('error'))
              <span class="invalid-feedback" role="alert">
                  <strong>{{session('error') }}</strong>
              </span>
          @endif
        </div>

    <div class="form-group">
      <label for="psw" class="sr-only">Password </label>
      <input type="password" id="psw"  pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"  placeholder="Create Password" name="password" required>

        @if ($errors->has('password'))
            <span class="invalid-feedback" role="alert">
              <strong>{{ $errors->first('password') }}</strong>
            </span>
        @endif
    </div>
			

    <div class="form-group text-left">
	<div id="message">
		  <h3 class="text-white" style="font-size:16px;">Username must contain the following:</h3>
		   <p  class="text-danger" style="margin-bottom:0px !important;" id="letter" class="invalid">Unique Username for every user</b></p>
		    <p  class="text-danger" style="margin-bottom:0px !important;" id="letter" class="invalid">No spaces in Username</p>
			 <h3 class="text-white" style="font-size:16px;">Password  must contain the following:</h3>
		  <p  class="text-danger" style="margin-bottom:0px !important;" id="letter" class="invalid">A <b>lowercase</b></p>
		  <p class="text-danger"  style="margin-bottom:0px !important;" id="capital" class="invalid">A <b>capital (uppercase)</b></p>
		  <p class="text-danger"  style="margin-bottom:0px !important;"  id="number" class="invalid">A <b>number</b></p>
		  <p  class="text-danger"  style="margin-bottom:0px !important;" id="length" class="invalid">Minimum <b>8 characters</b></p>
		</div>
      <div class="checkbox mb-3">
        <label style="color:#FFF!important;">
          You will use this Username & Password to Login into your account.
        </label>
      </div>
    </div>

    

    @if(session()->has('danger'))
         <div class="alert alert-danger">{{session()->get('danger')}}</div>
    @endif
    <button class="btn btn-lg btn-danger btn-block" type="submit">Complete Sign Up</button>
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

 <script>
 function check(){

	 var space=/\s/g.test($("#inputEmail").val());
	  if(space==false)
	  {
		  return true
	  }
	  else
	  {
		  alert("Uername does not have a space");
		  return false;
	  }
	 // return /\s/g.test($("#inputEmail").val());;
	 
 }
 
var myInput = document.getElementById("psw");
var letter = document.getElementById("letter");
var capital = document.getElementById("capital");
var number = document.getElementById("number");
var length = document.getElementById("length");

// When the user clicks on the password field, show the message box
myInput.onfocus = function() {
  document.getElementById("message").style.display = "block";
}

// When the user clicks outside of the password field, hide the message box
myInput.onblur = function() {
  document.getElementById("message").style.display = "none";
}

// When the user starts to type something inside the password field
myInput.onkeyup = function() {
  // Validate lowercase letters
  var lowerCaseLetters = /[a-z]/g;
  if(myInput.value.match(lowerCaseLetters)) {  
    letter.classList.remove("invalid");
    letter.classList.add("valid");
  } else {
    letter.classList.remove("valid");
    letter.classList.add("invalid");
  }
  
  // Validate capital letters
  var upperCaseLetters = /[A-Z]/g;
  if(myInput.value.match(upperCaseLetters)) {  
    capital.classList.remove("invalid");
    capital.classList.add("valid");
  } else {
    capital.classList.remove("valid");
    capital.classList.add("invalid");
  }

  // Validate numbers
  var numbers = /[0-9]/g;
  if(myInput.value.match(numbers)) {  
    number.classList.remove("invalid");
    number.classList.add("valid");
  } else {
    number.classList.remove("valid");
    number.classList.add("invalid");
  }
  
  // Validate length
  if(myInput.value.length >= 8) {
    length.classList.remove("invalid");
    length.classList.add("valid");
  } else {
    length.classList.remove("valid");
    length.classList.add("invalid");
  }
}

 </script>
</body>
</html>



  