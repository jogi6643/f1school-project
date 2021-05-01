@extends('layouts.CollageStudent')
@section('contents')

<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<script type="text/javascript">
  $(document).ready(function() {
    $('#example').DataTable();
} );
</script>
<br>
             <div class="text-right">
                           
                           <button type="button" onclick="goBack()" class="btn btn-danger">Go Back</button>

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
    @if($Teamname->team_Image!="")
    <img class="card-img-top" src="{{url('team/')}}/{{$Teamname->team_Image}}" alt="Card image" style="width:100%;border-radius: 50%;">
    @else
<img class="card-img-top"  style="width:100%;border-radius: 50%;" src="{{url('team/')}}/previewimg.png" alt="Card image cap">
    @endif
    
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
        <th hidden="">Action</th>
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
        @elseif($assignmems->status==0) 
         <td>Pending</td>
         @else
         <td>Rejected</td>
         @endif
        <td>{{date('d-F-Y',strtotime($assignmems->created_at))}}</td>
        <td hidden="">
          <a hidden href="{{url('editteam')}}/{{base64_encode($ids)}}"><button class="btn btn-success">edit</button></a>
         <a hidden="" href="{{url('deletestudentteam')}}/{{base64_encode($ids)}}"><button class="btn btn-danger">delete</button></a>
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