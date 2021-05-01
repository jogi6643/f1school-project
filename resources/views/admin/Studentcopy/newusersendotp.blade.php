
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


    <!-- Custom styles for this template -->
    <link href="{{asset('assets/website/css/album.css')}}" rel="stylesheet">
  </head>
  <style type="text/css">
 
  .textlable{
    text-align: left!important;
    color:#000000;
  }
  </style>
<body  style="background-image: url('public/admin/img/canva.jpg'); background-size: cover; background-position: bottom;">
<div class="container">
<div class="row justify-content-center">
  <div class="col-md-6">

     <div class="mt-5 ">
      @if($errors->any())
       <div class="alert alert-danger">
          <ul>
              @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
              @endforeach
          </ul>
       </div>
       @endif
       @if(session()->has('success'))
             <div class="alert alert-success">{{session()->get('success')}}</div>
       @endif
        @if(session()->has('error'))
             <div class="alert alert-danger">
               {{session()->get('error')}}
             </div>
       @endif
        <h3 class="text-center">Forgot Password</h3>
       <form method="post" action="{{url('Forgot-PassWord')}}"/>
         @csrf
         <div class="form-group">
          <label for="pwd" class="textlable"><strong>Username::</strong></label>
          <input type="text" name="username" class="form-control" id="pwd2">
        </div>
        <div class="form-group">
          <label for="pwd" class="textlable"><strong>Mobile Number:</strong></label>
          <input type="Number" name="mobile_no" class="form-control">
        </div>
        <div class="form-group">
          <input type="submit" name="submit" class="btn btn-lg btn-success btn-block m-1" value="send OTP">
        </div>
       </form>
     </div>
   </div>
</div>
</div>
</body>
</html>
