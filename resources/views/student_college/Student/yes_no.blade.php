
<!DOCTYPE html>
<html lang="en">
<head>
  <title></title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</head>
<body>

<div class="jumbotron text-center">
 
 

  
<div class="container">
  <div class="row">
    <div class="col-sm-6">
 <a class="btn btn-success btn-lg" href="{{url('college_teamstatus')}}/{{$id}}">Yes</a>
    </div>
    <div class="col-sm-6">

<a class="btn btn-danger btn-lg" href="{{url('college_teams_no')}}/{{$id}}">No</a>
    </div>
  
  </div>
</div>
</div>

</body>
</html>
