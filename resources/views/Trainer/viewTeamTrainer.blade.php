 @extends('layouts.trainer')
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
               <div>School Name: {{$schoolname}} |
                @if($username!='N/A')
                <h4>Created By :{{$username}}({{$userType}})</h4>
                @else 
                <h4>NO Team Available</h4> 
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
               <div class="alert alert-info">{{session()->get('success')}}</div>
            @endif
                       <div class="text-right">
                           
                           <button type="button" onclick="goBack()" class="btn btn-info">Go Back</button>

<script>
function goBack() {
  window.history.back();
}
</script>
           
 </div>
 <table class="table">
 	<thead class="thead-dark">
 		<tr>
 			<th>#</th>
      <th>Student Name</th>
 			<th>Student Mail</th>
      <th>Team Name</th>
 		</tr>
 	</thead>
 	<tbody>
 

    <?php $i=1;?>
  @if($teamdetails!='N/A')
 		@foreach($teamdetails as $k)
 	
		<tr>
       <td>{{$i}}</td> 
			 <td>{{$k->Studentname}}</td>    
       <td>{{$k->studentemail}}</td>  
       <td>{{$k->TeamName}}</td>    
		 			
		</tr>
		<?php $i=$i+1; ?>
		@endforeach
    @endif
 	
 	</tbody>
 </table>


@endsection

@section('header')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
@endsection

@section('footer')

 
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
<!--  <script type="text/javascript">
  $(document).ready(function(){
    $('#userlistid1').DataTable();
  });



</script> -->

@endsection

