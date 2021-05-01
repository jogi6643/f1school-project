
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v3.8.5">
    <title>Student</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/4.3/examples/album/">

    <!-- Bootstrap core CSS -->
<link href="{{asset('/assets/website/css/bootstrap.css')}}" rel="stylesheet" >


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
         }          
      }


/* Small devices (portrait tablets and large phones, 600px and up) */
@media only screen and (min-width: 600px){
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
         .copyright{
          margin-top: 150px;
         }         
}
/* Small devices (portrait tablets and large phones, 600px and up) */
@media only screen and (max-width: 600px){
       
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
         .copyright{
          margin-top: 150px;
         }         
}

/* Large devices (laptops/desktops, 992px and up) */
@media only screen and (min-width: 992px) {
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
         .copyright{
          margin-top: 170px;
         }
}


    </style>
    <!-- Custom styles for this template -->
    <link href="{{asset('assets/website/css/album.css')}}" rel="stylesheet">
  </head>
  <body class="text-center" style="background-image: url('admin/img/canva.jpg'); background-size: cover; background-position: bottom;">

<div class="container mt-5">
  <div class="row">
    <div class="col-md-8">
     <img class="mb-4" src="{{asset('assets/image/StretchIndiaWhite.png')}}" alt="" width="590" > 
    </div>
    <div class="col-md-4">
	
        <form class="form-signin" method="POST" action="{{ url('student-login') }}">
        @csrf
        <!-- <img class="mb-4" src="{{url('resources/assets/website/img/logo.png')}}" alt="" width="260"> -->
        <!-- <h1 class="h3 mb-3 font-weight-normal">Please sign in</h1> -->
        <input type="hidden" name="check" value="5"/>

        <label for="inputMobile" class="sr-only no-arrow">Mobile Number</label>
        <input type="Number" id="inputMobile" class="form-control{{ $errors->has('mobile_no') ? ' is-invalid' : '' }}" name="mobile_no" value="{{ old('mobile_no') }}" placeholder="Registered Mobile Number" name="mobile_no" required autofocus>
         @if ($errors->has('mobile_no'))
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $errors->first('mobile_no') }}</strong>
              </span>
          @endif
<br/>
        <label for="inputDate" class="sr-only">DOB</label>
        <input type="date"  id="inputPassword" class="form-control{{ $errors->has('dob') ? ' is-invalid' : '' }}"  placeholder="Student DOB" name="dob" required>

        @if ($errors->has('dob'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('') }}</strong>
            </span>
        @endif
         @if(session()->has('error'))
			 <br>
             <div class="alert alert-danger">
               {{session()->get('error')}}
             </div>
       @endif
      
        
         @if(session()->has('danger'))
            <div class="alert alert-danger">{{session()->get('danger')}}</div>
         @endif
		 <br/>
        <button class="btn btn-lg btn-danger btn-block" type="submit">PROCEED</button>
		 <a  class="btn btn-lg btn-danger btn-block" href="{{url('student-login')}}" type="submit">SIGN IN</a>
        <p class="mt-5 mb-3 text-muted" style="color: #FFF!important;"></p>
      </form>
    </div>
  </div>
 <img class=" p-0 imagealign"   src="{{asset('assets/website/img/tosregistered.png')}}" alt=""  >
</div>
<div class="container copyright ">
    <div  class="text-center "> 
      <p class=" text-muted  pr-4" style="color: #FFF!important;">&copy; F1 in Schools™ India
      </p>
    </div> 
</div>     
</body>
</html>
