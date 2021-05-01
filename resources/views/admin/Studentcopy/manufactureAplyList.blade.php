@extends('layouts.admin')
@section('content')
 
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
             <div class="content-heading">
               <div>Manufacture List
                  <small data-localize="dashboard.WELCOME"></small>
               </div>
               @include('sweet::alert')
               <!-- START Language list-->
              
               <!-- END Language list-->
            </div>
<h3>{{$schoolname}}</h3>
<h4>{{$studentname}}</h4>

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
 <table class="table table-hover table-striped" id="userlistid">
 	<thead>
 		<tr>
 			<th>#</th>
           <th hidden>Student Name</th>
 			<th hidden>School Name</th>
 			<th>Car Type</th>
 			<th>Part Name</th>
 			<th>view</th>
 			<!--<th>Status</th>-->
 			<th>create Date</th>
 			<th>Action</th> 
 		    
 		   
 			
         
 		</tr>
 	</thead>
 	<tbody>
 

    <?php $i=1;
      
    ?>
  
 		@foreach($k as $k1)
 <?php $ids=$k1['id']."_".$k1['studentid']."_".$k1['schoolid'];


 ?>
		<tr>
			<td>#</td> 
			 <td hidden>{{$k1['id']}}</td>
            <td hidden> {{$k1['studentid']}}</td>
			<td hidden> {{$k1['schoolid']}}</td>
		
            
             <td>{{$k1['type']}} </td>
             	<td></td>
             <td><a href="{{url('public/Carimage/')}}/{{$k1['carimage']}}" class="rounded float-left" alt="..." target="_blank">View File</a></td>
             <td>{{$k1['created_at']}}</td>
             <td>
                
                @if($k1['status']==1) <button disabled id="button{{$ids}}" type="button" class="btn btn-success" onclick="Approved('carbody',{{$ids}}')">Approved</button>
            <button hidden type="button" data-toggle="modal" data-target="#myModal_{{$ids}}" class="btn btn-warning">Reject</button> @else <button id="button" type="button" class="btn btn-info" onclick="Approved('carbody','{{$ids}}')">Approved</button>   <button type="button" data-toggle="modal" data-target="#myModal_{{$ids}}" class="btn btn-warning">Reject</button>@endif

           
             
               <!-- Modal -->
  <div class="modal fade" id="myModal_{{$ids}}" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Modal Header</h4>
        </div>
        <div class="modal-body">
          <p>Remark</p>
          <input class="form-control"  type="text" id="remark" name="CarbodyRemark" value="">
        </div>
        <div class="modal-footer">
             <button type="button" class="btn btn-success"  onclick="reject('carbody','{{$ids}}')">submit</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
             
    
             </td>
             
		</tr>
		<?php $i=$i+1; ?>
	
		@endforeach
		
		
		
		
		
		<!--//car body part-->
		
		
		
		
		
		  <?php $i=1;
      
    ?>
  
 		@foreach($kpart as $kpart1)
 <?php $ids=$kpart1['id']."_".$kpart1['studentidC']."_".$kpart1['schoolidC'];


 ?>
		<tr>
			<td>#</td> 
			 <td hidden>{{$kpart1['id']}}</td>
            <td hidden> {{$kpart1['studentidC']}}</td>
			<td hidden> {{$kpart1['schoolidC']}}</td>
		
            
             <td>{{$kpart1['carbodypart']}} </td>
             	<td>{{$kpart1['Partname']}}</td>
             <td><a href="{{url('public/Carimage/')}}/{{$kpart1['partimage']}}" class="rounded float-left" alt="..." target="_blank">View File</a></td>
             <td>{{$kpart1['created_at']}}</td>
             <td>
                
                @if($kpart1['status']==1) <button disabled id="button{{$ids}}" type="button" class="btn btn-success" onclick="Approved('carpartbody','{{$ids}}')">Approved</button>
            <button hidden type="button" data-toggle="modal" data-target="#myModal_{{$ids}}" class="btn btn-warning">Reject</button>@else <button id="button" type="button" class="btn btn-info" onclick="Approved('carpartbody','{{$ids}}')">Approved</button>  <button type="button" data-toggle="modal" data-target="#myModal_{{$ids}}" class="btn btn-warning">Reject</button>@endif

            
             
               <!-- Modal -->
  <div class="modal fade" id="myModal_{{$ids}}" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Modal Header</h4>
        </div>
        <div class="modal-body">
          <p>Remark</p>
          <input class="form-control form-control"  type="text" name="CarpartbodyRemark" value="">
        </div>
        <div class="modal-footer">
              <button type="button" class="btn btn-success" onclick="reject('carpartbody','{{$ids}}')">submit</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
             
    
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
 
 
 
 <script>
     function Approved(body,ids)
     {
        
         if(body=="carbody")
         {
             
            $.ajax({
             url:'{{url('approvedbyadminmanufacture')}}',
             method:'post',
             data:{_token: '{!! csrf_token() !!}',ids:ids,body:"carbody"},
             success:function(result)
             {
             
            //  alert(result);
              //  $('#button'+ids).text('1');
                    // $('#button'+ids).removeClass('btn-info').addClass('btn-warning');
                    
                    // $('#button'+ids).siblings('#button'+ids).removeClass('btn-success').addClass('btn-primary');
             }
             
             
         });
         }
         else
         {
             alert(ids);
               $.ajax({
             url:'{{url('approvedbyadminmanufacture')}}',
             method:'post',
             data:{_token: '{!! csrf_token() !!}',ids:ids,body:"carpartbody"},
             success:function(result)
             {
             
             alert(result);
              //  $('#button'+ids).text('1');
                    // $('#button'+ids).removeClass('btn-info').addClass('btn-warning');
                    
                    // $('#button'+ids).siblings('#button'+ids).removeClass('btn-success').addClass('btn-primary');
             }
             
             
         });
         }
      
       
          
     }
     
 function reject(body,ids)
     {
       if(body=="carbody")
         {
             var remark=$('#remark').val();
           
             
            $.ajax({
             url:'{{url('rejectedbyadminmanufacture')}}',
             method:'post',
             data:{_token: '{!! csrf_token() !!}',ids:ids,body:"carbody",remark:remark},
             success:function(result)
             {
             
             alert(result);
              //  $('#button'+ids).text('1');
                    // $('#button'+ids).removeClass('btn-info').addClass('btn-warning');
                    
                    // $('#button'+ids).siblings('#button'+ids).removeClass('btn-success').addClass('btn-primary');
             }
             
             
         });
         }
         
             else
         {
          
               $.ajax({
             url:'{{url('rejectedbyadminmanufacture')}}',
             method:'post',
             data:{_token: '{!! csrf_token() !!}',ids:ids,body:"carpartbody",remark:remark},
             success:function(result)
             {
             
             alert(result);
              //  $('#button'+ids).text('1');
                    // $('#button'+ids).removeClass('btn-info').addClass('btn-warning');
                    
                    // $('#button'+ids).siblings('#button'+ids).removeClass('btn-success').addClass('btn-primary');
             }
             
             
         });
         }
     }
     
   
         
     
     
    
 </script>
@endsection