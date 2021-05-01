
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


    <!-- Custom styles for this template -->
    <link href="{{asset('assets/website/css/album.css')}}" rel="stylesheet">
  </head>
  <style type="text/css">
 
  .textlable{
    text-align: left!important;
    color:#000000;
  }
  </style>
  <script type="text/javascript">
    document.addEventListener('contextmenu', function(e) {
  e.preventDefault();
});
  </script>
<body oncontextmenu="return false;"  style="background-image: url('admin/img/canva.jpg'); background-size: cover; background-position: bottom;">
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
       <form method="post" action="{{url('reset-Password')}}"/>
         @csrf
        <div hidden=""  class="form-group">
          <label for="pwd" class="textlable"><strong>Username::</strong></label>
          <input type="text" name="username" class="form-control" value="{{$username}}" id="pwd2">
        </div>
        <div hidden="" class="form-group">
          <label for="pwd" class="textlable"><strong>Mobile Number:</strong></label>
          <input type="text" name="mobile_no" value={{$mobile_no}} class="form-control">
        </div>
       
         <div class="form-group">
          <label for="pwd" class="textlable"><strong>Enter Password:</strong></label>
          <input type="text" name="Password"  pattern=".{8,}" title="Password Should have atleast 8 characters" class="form-control" id="pwd2">
        </div>
         <div class="form-group">
          <label for="pwd" class="textlable"><strong>Confirm Password</strong></label>
          <input type="text" name="rePassword"  pattern=".{8,}" title="Password Should have atleast 8 characters" class="form-control" id="pwd2">
        </div>
        <div class="form-group">
          <input type="submit" name="submit" class="btn btn-lg btn-success btn-block m-1" value="Set Password">
        </div>
       </form>
     </div>
   </div>
</div>
</div>



   
</body>
</html>
