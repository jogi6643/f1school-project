
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v3.8.5">
    <title>Passwrod Reset</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/4.3/examples/album/">

    <!-- Bootstrap core CSS -->
<link href="{{url('resources/assets/website/css/bootstrap.css')}}" rel="stylesheet" >


    <!-- Custom styles for this template -->
    <link href="{{url('resources/assets/website/css/album.css')}}" rel="stylesheet">
  </head>
  <style type="text/css">
       .box{
    position: absolute;
    top:30vh;
    width: 70%;
    right: 89px;
    display: flex;
    flex-direction: column;
    justify-content: center;
   }
  </style>
<body class="text-center" style="background-image: url('public/admin/img/canva.jpg'); background-size: cover; background-position: bottom;">
<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-6">
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
       @if(session()->has('error'))
             <div class="alert alert-danger">
               {{session()->get('error')}}
             </div>
       @endif
       <h2>Password Reset For Trainer</h2>
     <div class="col-md-6">
      <img class="mb-4" src="{{url('resources/assets/image/StretchIndiaWhite.png')}}" alt="" width="520" > 
     </div>
      <div> 
       <form method="post" action="{{url('checkemail')}}"/>
        @csrf
        <div class="form-group">
         <input type="email" name="email" class="form-control m-1" placeholder="Enter your email">
         <input type="submit" name="submit" class="btn btn-lg btn-danger btn-block m-1" value="Submit">
        </div>
       </form>
      </div> 
    </div>
  </div>
</div>

{{-- <div class="row justify-content-center">
  <div class="col-md-6">

     <div class="box">
      


     </div>
   </div>
</div> --}}




   
</body>
</html>
