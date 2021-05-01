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
<div class="row">
  <div class="col-md-3">
    </div>
    <div class="col-md-6">
  <div  class="card" style="width:400px">
    <img class="card-img-top" src="{{url('public/team/')}}/{{$Teamname->team_Image}}" alt="Card image" style="width:100%">
    <div class="card-body">
      <h6 class="card-text">Created By : {{$studentname}}</h6>
      <h6 class="card-text">School Name : {{$schoolname}}</h6>
      <h6 class="text-text">Team Name : {{$Teamname->team_Name}}</h6>
    </div>
  </div>
</div>
 <div class="col-md-3">
    </div>
</div>
<hr>


 <table id="example" class="table table-striped">
    <thead class="thead-dark">
      <tr>
        <th>Student Name</th>
         <th>Student Role</th>
        <th>Status</th>
        <th>Created_at</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      @if(count($assignmem)>0)
     @foreach($assignmem as $assignmems)
     <?php $ids=$assignmems->id."_".$teamid."_".$scid;

     ?>

      <tr>
      
        <td>{{$assignmems->name}}</td>
        <td>{{$assignmems->studentRole}}</td>
        @if($assignmems->status==1)
        <td>Accept</td>
        @else 
         <td>Pending</td>
         @endif
        <td>{{date('d-F-Y',strtotime($assignmems->created_at))}}</td>
        <td>
          <a hidden href="{{url('editteam')}}/{{base64_encode($ids)}}"><button class="btn btn-success">edit</button></a>
         <a href="{{url('deletestudentteam')}}/{{base64_encode($ids)}}"><button class="btn btn-danger">delete</button></a>
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