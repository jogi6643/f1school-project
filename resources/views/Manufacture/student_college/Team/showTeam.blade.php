@extends('layouts.student')
@section('contents')
<!-- <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script> -->
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<script type="text/javascript">
  $(document).ready(function() {
    $('#example').DataTable();
} );
</script>
   <div class="text-right">
                 
                 <button type="button" onclick="goBack()" class="btn btn-info">Go Back</button>

<script>
function goBack() {
  window.history.back();
}
</script>

</div>

<div class="container">
                <div class="card mb-3">
  <div class="row">
<div class="col-md-4">
  <div class="card-body">

  <img class="card-img-top"  style="height:100px;width:100px;border-radius: 50%;" src="{{url('public/team/')}}/previewimg.png" alt="Card image cap">
  <h5 class="card-title">{{$studentname}}</h5>

</div>
</div>
<div class="col-md-8">
    <div class="card-body">
    <h5 class="card-title">{{$schoolname}}</h5>
    <p class="card-text">Description........</p>
   
  </div>
</div>

</div>
</div>

 <table id="example" class="table table table-striped">
    <thead class="thead-dark">
      <tr>
        <th>Team Image</th>
        <th>Team Name</th>
        <th>Description</th>
        <th>View Team Member</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      @if(count($ct)>0)
     @foreach($ct as $cts)
     <?php $ids=$cts->id."_".$cts->school_id."_".$cts->student_id;?>
           <tr>
        <td><img style="height: 50px;width:50px;" src="{{url('public/team/')}}/{{$cts->team_Image}}"></td>
        <td>{{$cts->team_Name}}</td>
        <td>{{$cts->team_Description}}</td>
        <td><a href="{{url('student/team/view_team_member')}}/{{base64_encode($ids)}}"><button class="btn btn-info">View Team Member</button></a></td>
        
        <td>
          <a href="{{url('editteam')}}/{{base64_encode($ids)}}"><button class="btn btn-success">edit</button></a>
<a href="{{url('deleteteam')}}/{{base64_encode($ids)}}"><button class="btn btn-danger">delete</button></a>
        </td>
      </tr>
      @endforeach
      @else
      <tr>
        <td><td>
          
        <td colspan="2">No Team Create Yet</td>
       
      </tr>
      @endif
    </tbody>
  </table>
</div>

@endsection 