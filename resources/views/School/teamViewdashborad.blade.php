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
               <div>List Teams
                  <small data-localize="dashboard.WELCOME"></small>
               </div>
       
               <!-- START Language list-->
            
             
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
 			<th>S.no </th>
      <th>Image</th>
 			<th>Team Name</th>
      <th>view team Member</th>
 		
 		</tr>
 	</thead>
 	<tbody>
 

    <?php $i=1;?>

  
 		@foreach($SchoolCompTeam as $k)
    <?php
$ids=$k->tmpid."_".$k->student_id."_".$k->school_id;
     ?>
		<tr>
      <td>{{$i}}</td>
            <td>

       @if($k->team_Image!=null)
      <img style="height: 50px;width:50px; border-radius: 50%;" src="{{url('team/')}}/{{ $k->team_Image }}">
      @else
      <img style="height: 50px;width:50px; border-radius: 50%;" src="{{url('team/pro.jpg')}}">
      @endif

            </td>

			       <td>{{ $k->team_Name }}</td>
           

                <td>
          <a href="{{url('viewteambyschool')}}/{{base64_encode($ids)}}"><button class="btn btn-success">View</button></a>

        </td>
          	
		</tr>
		<?php $i=$i+1; ?>

		@endforeach
 	
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