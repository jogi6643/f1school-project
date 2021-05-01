@extends('layouts.school')
@section('content')
 
             <div class="content-heading">
               <div>Student Participant
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
            
         
                <h2>{{$schoolname->school_name}}</h2>
                       <div class="text-right">
                           
                           <button type="button" onclick="goBack()" class="btn btn-info">Go Back</button>

                           <script>
                        function goBack() {
                         window.history.back();
                               }
                        </script>
               </div>
            
              
               
 <table class="table table-hover table" id="userlistid">
 	<thead>
 		<tr>
 			<th>#</th>
           <th>Plan</th>
           <th>Year</th>
 		
 			
 			
         
 		</tr>
 	</thead>
 	<tbody>
 

    <?php $i=1;
      
    ?>
  @if(count($planyear)>0)
 		@foreach($planyear as $planyear1)
 		@foreach($planyear1 as $planyear2)
 	
		<tr>
		    <td>{{$i}}</td>
<td>{{$planyear2->name}}</td>
<td>{{$planyear2->year}}</td>
			
            
         
		
		 			
		</tr>
		<?php $i=$i+1; ?>
		@endforeach
		@endforeach
		@else
		<h2>No Record Found</h2>
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
 		$('#userlistid').DataTable();
 	});

   function myfuntemp(arg) {
      var ad=$(arg).attr('id');
      var ak=ad.split('-');
      // alert('val = '+ak[1]);
      if(confirm("Do you really want to delete this."))
         window.location.href='{{url("/schooldel")}}/'+btoa(ak[1]);
         // alert("yes");
   }
 </script>
@endsection









