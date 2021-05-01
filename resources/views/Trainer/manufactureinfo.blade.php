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
             
                <h4>Student Name :{{$username}}</h4>
             
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
 <h3>Applying Manufacture List </h3>
 <table class="table">
 	<thead class="thead-dark">
 		<tr>
 			<th>#</th>
      <th>Application Id</th>
      <th>Type</th>
 			<th>Part Name</th>
      
      <th>Status</th>
 		</tr>
 	</thead>
 	<tbody>
 

    <?php $i=1;?>
  @if(count($manufacture)>0)
 		@foreach($manufacture as $k)
 	
		<tr>
       <td>{{$i}}</td> 
       <td>{{$k->applicationid}}</td>  
			 <td>{{$k->carbodypart}}</td> 
       @if($k->partname!='N/A')   
       <td>{{$k->partname}}</td> 
       @else
       <td></td> 
       @endif 
        @if($k->status==0)
       <td>pending</td>   
       @elseif($k->status==1)
         <td>Approved</td>  
       @else
         <td>Rejected</td> 
       @endif
		 			
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

