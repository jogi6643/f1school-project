@extends('layouts.school')
@section('content')

<style>
.border-class
{
  border:thin #929292 solid;
  margin:20px;
  padding:20px;
}
</style>
 
             <div class="content-heading">
                 
       @if($Teamname->team_Image!=null)
       <div class="row"> 
        <div class="col-md-4">
      <img style="height: 50px;width:50px; border-radius: 50%;" src="{{url('team/')}}/{{ $Teamname->team_Image }}">
    </div>
       <div class="col-md-8">
       <h2 >{{$Teamname->team_Name}}</h2>
     </div>
   </div>
      @else
<div class="row">
  <div class="col-md-8">
      <img style="height: 50px;width:50px; border-radius: 50%;" src="{{url('team/pro.jpg')}}">
      </div>
        <div class="col-md-4">
      {{$Teamname->team_Name}}
    </div>
</div>
      @endif
                  <small data-localize="dashboard.WELCOME"></small>
               </div>
             
            </div>

            @if($errors->any())
               @foreach($errors->all() as $err)
                  <div class="alert alert-danger">{{$err}}</div>
               @endforeach
            @endif
             @if(session()->has('success'))
               <div class="alert alert-success">{{session()->get('success')}}</div>
            @endif
               @if(session()->has('danger'))
               <div class="alert alert-danger">{{session()->get('danger')}}</div>
            @endif
                       <div class="text-right">
                           
                           <button type="button" onclick="goBack()" class="btn btn-info">Go Back</button>

<script>
function goBack() {
  window.history.back();
}
</script>
              
 </div>
 <table class="table table-hover table-striped" id="userlistid1">
  <thead>
    <tr>
        <th>S.No</th>
        <th>Student Name</th>
        <th>Student Role</th>
        <th>Status</th>
        <th>Created_at</th>

    
    </tr>
  </thead>
    <tbody>
      @if(count($assignmem)>0)
     
     @foreach($assignmem as $key=>$assignmems)
     <?php $ids = base64_encode($assignmems->id."_".$scid)?>
      <tr>
        <td>{{$key+1}}</td>
        <td><a href="{{url('viewstudentinfo')}}/{{$ids}}">{{$assignmems->name}}</a></td>
        <td>{{$assignmems->studentRole}}</td>
        @if($assignmems->status==1)
        <td>Accept</td>
        @else 
         <td>Pending</td>
         @endif
        <td>{{date('d-F-Y',strtotime($assignmems->created_at))}}</td>
      
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


@endsection

@section('header')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
@endsection

@section('footer')

 
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
 <script type="text/javascript">
  $(document).ready(function(){
    $('#userlistid1').DataTable();
  });

   function myfuntemp(arg) {
      var ad=$(arg).attr('id');
      var ak=ad.split('-');
      // alert('val = '+ak[1]);
      if(confirm("Do you really want to delete this."))
         window.location.href='{{url("/locationdel")}}/'+btoa(ak[1]);
         // alert("yes");
   }
 </script>
@endsection