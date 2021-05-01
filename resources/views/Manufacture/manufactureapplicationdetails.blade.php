@extends('layouts.admin')
@section('content')
 
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
             <div class="content-heading">
               <div>Manufacture List1
                  <small data-localize="dashboard.WELCOME"></small>
               </div>
               @include('sweet::alert')
               <!-- START Language list-->
              
               <!-- END Language list-->
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
 <table class="table table-hover table-striped" id="userlistid1">
 	<thead>
 		<tr>
 			<th>#</th>
           <th>Student Name</th>
           <th>Institute Type</th>
 			<th>School Name</th>
 			<th>Trainer Name</th>
 			<th>Car Type</th>
 			<th>Part Name</th>
 			<th>Image</th>
 			<th>Created_at</th>
 			<th>Action</th> 
 		    
 		   
 			
         
 		</tr>
 	</thead>
 	<tbody>
 

    <?php $i=1;
      
    ?>
  @if(count($CARBODY)>0)
	@foreach($CARBODY as $CARBODY1)

 <?php 
 $ids=$CARBODY1->bid."_".$CARBODY1->studentid."_".$CARBODY1->schoolid;
$ids1= $CARBODY1->applicationid;

 
 ?>
		<tr>
			<td>{{$CARBODY1->applicationid}}</td> 
			 <td hidden>{{$CARBODY1->id}}</td>
            <td hidden> {{$CARBODY1->studentid}}</td>
			<td hidden> {{$CARBODY1->schoolid}}</td>
		
             <td>{{$CARBODY1->studentname}} </td>
             <td>{{$CARBODY1->schooltype}} </td>
              <td>{{$CARBODY1->schoolname}} </td>
              <td>{{$CARBODY1->trainer_name}} </td>
             	<td>{{$CARBODY1->type}} </td>
             	<td></td>
             <td><a href="{{url('public/Carimage/')}}/{{$CARBODY1->carimage}}" class="rounded float-left" alt="..." target="_blank">View File</a></td>
             <td>{{date('d-F-Y',strtotime($CARBODY1->created_at))}}</td>
             <td>
                
                @if($CARBODY1->status==1) 
                <button  disabled id="button{{$ids}}" type="button" class="btn btn-success" onclick="Approved('carbody','{{$ids}}')">Approved</button>
<button hidden  type="button" data-toggle="modal" data-target="#myModal_{{$ids}}" class="btn btn-warning">Reject</button>

 @elseif($CARBODY1->status==2) 
 <button hidden="" disabled id="button" type="button" class="btn btn-info" onclick="Approved('carbody','{{$ids}}')">Approved</button> 

             <button disabled="" type="button" data-toggle="modal" data-target="#myModal_{{$ids}}" class="btn btn-warning">Reject</button>

           @else
   <button  id="button" type="button" class="btn btn-info" onclick="Approved('carbody','{{$ids}}','{{$ids1}}')">Approved</button> 

             <button  type="button" data-toggle="modal" data-target="#myModal_{{$ids}}" class="btn btn-warning">Reject</button>
             <!-- @endelseif -->
            @endif

             
             
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
          <input class="form-control"  type="text" id="remark{{$ids}}" name="CarbodyRemark" value="">
        </div>
        <div class="modal-footer">
             <button type="button" class="btn btn-success"  onclick="reject('carbody','{{$ids}}','{{$ids1}}')">submit</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
             
    
             </td>
             
		</tr>
		<?php $i=$i+1; ?>
	
		@endforeach
		@endif
		
		<!--////-->
		<?php $i=1;
      
    ?>
  
	@foreach($CARPARTBODY as $CARPARTBODY1)

 <?php $ids=$CARPARTBODY1->bid."_".$CARPARTBODY1->studentid."_".$CARPARTBODY1->schoolid;

$ids1=$CARPARTBODY1->applicationid;


 ?>
		<tr>
			<td>{{$CARPARTBODY1->applicationid}}</td> 
			 <td hidden>{{$CARPARTBODY1->id}}</td>
            <td hidden> {{$CARPARTBODY1->studentid}}</td>
			<td hidden> {{$CARPARTBODY1->schoolid}}</td>
		
             <td>{{$CARPARTBODY1->studentname}} </td>
             <td>{{$CARPARTBODY1->schooltype}} </td>
              <td>{{$CARPARTBODY1->schoolname}} </td>
              <td>{{$CARPARTBODY1->trainer_name}} </td>
             
             	<td>{{$CARPARTBODY1->carbodypart}}</td>
             <td>{{$CARPARTBODY1->partname}}</td>
             <td><a href="{{url('public/Carimage/')}}/{{$CARPARTBODY1->carimage}}" class="rounded float-left" alt="..." target="_blank">View File</a></td>
             <td>{{date('d-F-Y',strtotime($CARPARTBODY1->created_at))}}</td>
             <td>
                
                @if($CARPARTBODY1->status==1) <button disabled id="button{{$ids}}" type="button" class="btn btn-success" onclick="Approved('{{$ids1}}','{{$ids}}')">Approved1</button>
           <button hidden type="button" data-toggle="modal" data-target="#myModal_{{$ids}}" class="btn btn-warning">Reject</button>
 @elseif($CARPARTBODY1->status==2)
  <button  hidden id="button" type="button" class="btn btn-info" onclick="Approved('carbodypart','{{$ids}}','{{$ids1}}')">Approved</button>   <button disabled type="button" data-toggle="modal" data-target="#myModal_{{$ids}}p" class="btn btn-warning">Reject</button>
            @else 
           <button id="button" type="button" class="btn btn-info" onclick="Approved('carbodypart','{{$ids}}','{{$ids1}}')">Approved</button>   <button  type="button" data-toggle="modal" data-target="#myModal_{{$ids}}p" class="btn btn-warning">Reject</button>
           @endif

           
    
             
  <div class="modal fade" id="myModal_{{$ids}}p" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Modal Header</h4>
        </div>
        <div class="modal-body">
          <p>Remark</p>
          <input class="form-control"  type="text" id="remarkp{{$ids}}" name="CarbodyRemark" value="">
        </div>
        <div class="modal-footer">
             <button type="button" class="btn btn-success"  onclick="reject('carbodypart','{{$ids}}','{{$ids1}}')">submit</button>
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
//  	$(document).ready(function(){
//  		$('#userlistid1').DataTable();
//  	});

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


 
 <script>
     function Approved(body,ids,appid)
     {
  
    
         if(body=="carbody")
         {
        
             
            $.ajax({
             url:'{{url('approvedbyadminmanufacture')}}',
             method:'post',
             data:{_token: '{!! csrf_token() !!}',ids:ids,body:"carbody",appid:appid},
             success:function(data)
             {
             // alert(data);
           location.reload();
           
             }
             
             
         });
         }
         else
         {
             alert(ids);
               $.ajax({
             url:'{{url('approvedbyadminmanufacture')}}',
             method:'post',
             data:{_token: '{!! csrf_token() !!}',ids:ids,body:body,appid:appid},
             success:function(data)
             {
             
           location.reload();
            
             }
             
             
         });
         }
      
       
          
     }
     
 function reject(body,ids,appid)
     {
     alert(body);
       if(body=="carbody")
         {
             var remark=$('#remark'+ids).val();
           
             alert(remark);
            $.ajax({
             url:'{{url('rejectedbyadminmanufacture')}}',
             method:'post',
             data:{_token: '{!! csrf_token() !!}',ids:ids,body:"carbody",appid:appid,remark:remark},
             success:function(data)
             {
             
             alert(data);
             location.reload();

              //  $('#button'+ids).text('1');
                    // $('#button'+ids).removeClass('btn-info').addClass('btn-warning');
                    
                    // $('#button'+ids).siblings('#button'+ids).removeClass('btn-success').addClass('btn-primary');
             }
             
             
         });
         }
         
             else
         {
        
          
            var remark=$('#remarkp'+ids).val();
            alert(remark);
               $.ajax({
             url:'{{url('rejectedbyadminmanufacture')}}',
             method:'post',
             data:{_token: '{!! csrf_token() !!}',ids:ids,body:body,remark:remark,appid:appid},
             success:function(data)
             {
             
      
            
             location.reload();
             }
             
             
         });
         }
     }
     
   
         
     
     
    
 </script>

