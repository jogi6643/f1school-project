
<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
   <meta name="description" content="">
   <meta name="keywords" content="">
   <title>School</title>
   <!-- =============== VENDOR STYLES ===============-->
   <!-- FONT AWESOME-->
   <link rel="stylesheet" href="{{asset('public/admin/vendor/font-awesome/css/font-awesome.css')}}">
   <!-- SIMPLE LINE ICONS-->
   <link rel="stylesheet" href="{{asset('public/admin/vendor/simple-line-icons/css/simple-line-icons.css')}}">
   <!-- ANIMATE.CSS-->
   <link rel="stylesheet" href="{{asset('public/admin/vendor/animate.css/animate.css')}}">
   <!-- WHIRL (spinners)-->
   <link rel="stylesheet" href="{{asset('public/admin/vendor/whirl/dist/whirl.css')}}">
   <!-- =============== PAGE VENDOR STYLES ===============-->
   <!-- WEATHER ICONS-->
   <link rel="stylesheet" href="{{asset('public/admin/vendor/weather-icons/css/weather-icons.css')}}">
   <!-- =============== BOOTSTRAP STYLES ===============-->
   <link rel="stylesheet" href="{{asset('public/admin/css/bootstrap.css')}}" id="bscss">
   <!-- =============== APP STYLES ===============-->
   <link rel="stylesheet" href="{{asset('public/admin/css/app.css')}}" id="maincss">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
   <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
@yield('header')

   

</head>
<body>
  <div class="container">
  	<div class="row justify-content-center mt-5">
  	 <div class="col-md-6">
  	 	<h2 class="text-center">Reset Your Password for School</h2>
  	 	    @if($errors->any())
			<div class="alert alert-danger">
			 <ul>
			  @foreach($errors->all() as $error)
			  <li>{{ $error }}</li>
			  @endforeach
			 </ul>
			</div>
			@endif
            @if(session()->has('success'))
               <div class="alert alert-success">{{session()->get('success')}}</div>
            @endif
            @if(session()->has('failure'))
               <div class="alert alert-danger">{{session()->get('failure')}}</div>
            @endif
  	 	<form method="post" action="{{url('newpassword')}}">
        <!-- studentnewpassword -->
  	 		@csrf
		  <div class="form-group">
		    <label for="email">Email address:</label>
		    <input type="email" name="email" class="form-control" id="email" value="{{$data['email']}}" disabled />
		  </div>
		  
		  <div class="form-group">
		    <label for="pwd">Enter new Password:</label>
		    <input type="password" name="password" class="form-control" id="pwd1" value="" placeholder="Enter new Password"/>
		  </div>
		  <div class="form-group">
		    <label for="pwd">Confirm Password:</label>
		    <input type="password" name="password_confirmation" class="form-control" id="pwd2" value="" placeholder="Re-password"/>
		  </div>
		  <input type="hidden" name="hemail" value="{{$data['email']}}" />
		  <button type="submit" id="submit" class="btn btn-primary">Submit</button>
		</form>
  	 </div>
  	</div>
  </div>	
</body>
</html>

