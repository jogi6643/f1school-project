<!DOCTYPE html>
<html lang="en">
<head>
  <title>Course</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
   <div class="card" style="width:400px">
    <div class="card-body">
      <h2 class="card-title">{{$student_name}}</h2>
      <h2 class="card-text">School Name:{{$school_name}}</h2>
      <h2 class="card-text">Plan Name:{{$plan_name}}</h2>
    </div>
  </div>

  <h3>Course List</h3>
@if(isset($assineddate_mail))
 @foreach($assineddate_mail as $key=>$c)
<h3>{{$key+1}}</h3>
  <div class="card-deck" style="min-width:400px">
    <div class="card bg-primary">
      <div class="card-body text-center">
        <p class="card-text">Course Mail:{{$c->course_Mail}}</p>
        <p class="card-text">Course Title:{{$c->course_Tittle}}</p>
        <p class="card-text">File Type:{{$c->filetype}}</p>
        <p class="card-text">Priority:{{$c->priority_set}}</p>
        <?php $d = date("d/m/y",strtotime($c->assigneddate)); ?>
          @if($d!="12/12/93")
        <p class="card-text">Assigned Date:{{date("d/m/y",strtotime($c->assigneddate))}}</p>
         @else
         <p class="card-text">Date Not Assigned</p>
         @endif

      </div>
    </div>
    @endforeach
    @else
    <a href="#" class="list-group-item list-group-item-success">No Courses</a>
    @endif
</div>

</body>
</html>
