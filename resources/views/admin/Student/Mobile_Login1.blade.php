
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
<link href="{{asset('assets/website/css/bootstrap.css')}}" rel="stylesheet" >


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
	  @if(session()->has('success'))
		     <span class="invalid-feedback" role="alert">
              <strong>{{ session('success') }}</strong>
            </span>
		   @endif
		    
		     <span class="invalid-feedback" role="alert">
              <strong>{{ session('error') }}</strong>
            </span>
            @if(session()->has('success'))
             <div class="alert alert-success">{{session()->get('success')}}</div>
       @endif
        @if(session()->has('error'))
             <div class="alert alert-danger">
               {{session()->get('error')}}
             </div>
       @endif
	   <div class="alert alert-danger">
              OTP sent to {{session('mobile_no')}}
             </div>
      
       <form method="post" action="{{url('verify-OTP-Password-Postregister')}}"/>
         @csrf
        
        <div hidden="" class="form-group">
          <label for="pwd" class="textlable"><strong>Mobile Number:</strong></label>
          <input type="text" name="mobile_no" value={{session('mobile_no')}} class="form-control">
        </div>
       
         <div class="form-group">
          <label for="pwd" class="textlable"><strong></strong></label>
          <input type="text" name="otp" placeholder="Enter OTP" class="form-control" id="pwd2">
        </div>
        <div class="form-group">
          <input type="submit" name="submit" class="btn btn-lg btn-success btn-block m-1" value="Verify OTP">
        </div>
       </form>
        @csrf
       
       
		
      
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
