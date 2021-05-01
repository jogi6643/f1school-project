@extends(Auth::user()->role==2? 'layouts.coadmin':'layouts.admin')
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
               <div>View Assign Price School 
                  <small data-localize="dashboard.WELCOME"></small>
               </div>
               
          
               <!-- START Language list-->
               
               </div>
             <div class="text-right">
                  
				 @if(Auth::user()->role==1)
					 <a type="button" href='{{url("assignpicemaster")}}' class="btn btn-success">Create</a>
					@else
					 @if((session('data')[12]??0)==1)
							 <a type="button" href='{{url("assignpicemaster")}}' class="btn btn-success">Create</a>
					   @endif
				   @endif
             	
			
                <button type="button" onclick="goBack()" class="btn btn-success">Go Back</button>

                           <script>
                        function goBack() {
                         window.history.back();
                               }
                        </script>
               </div>

               <!-- END Language list-->
            </div>
         
       
            @if(session()->has('errors1'))
               
                  <div class="alert alert-danger"><span>{{session('errors1')}}</span></div>
               
            @endif

             
            @if(session()->has('success'))
               <div class="alert alert-info">{{session('success')}}</div>
            @endif
            
 <table class="table table-hover table-striped" id="userlistid">
 	<thead>
 		<tr>
 			<th>#</th>

       @if(Auth::user()->role==1)
      <th>Plan Name</th>
      @else
      @if((session('data')[8]??0)==1)
      <th>Plan Name</th>
      @else
       <th>Plan Name</th>
       @endif
      @endif

      <th>School Name</th>
 			<th>Manufacture Cost</th>
 			
			<th>Type</th>
      <th>Available Blocks</th>
			<th>Block Price</th> 
      <th>View</th> 
       <th>Assigned Date/Time</th>
 		</tr>
 	</thead>
 	<tbody>
    <?php $i=1; ?>
      @if(count($p)>0)
  
 		@foreach($p as $k)
		<tr> 
			<td>{{$i++}}</td> 
             @if(Auth::user()->role==1)
      <td> <a href="{{url('editplan/'.base64_encode($k->planid))}} " target="__blank">{{$k->planname}}</a></td>
        @else
       
      @if((session('data')[11]??0)==1)
      <td> <a href="{{url('editplan/'.base64_encode($k->planid))}} " target="__blank">{{$k->planname}}</a></td>
      @else
       <td>{{$k->planname}}</td>
      @endif
      @endif
			
      <td>{{$k->schoolname}}</td>
			<td>{{$k->manufacturing_cost}}</td>
      <td>@if($k->level==1) Individual  @else Team @endif </td>
      <td>{{$k->number}} </td>
		  
			<td>{{$k->block_price}}</td>	
      <?php $ids = $k->schoolid."_".$k->planid;
 

      ?>


       <td><a href="{{url('viewplan')}}/{{base64_encode($ids)}}">view </a></td>	

        <td>{{date('d-F-Y H:i:s',strtotime($k->created_at))}} </td>
		</tr>
		
		@endforeach
 		@else
         No Record Found.....
      @endif
 	</tbody>
 </table>




@endsection

@section('header')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
@endsection

@section('footer')
  <style >
 .modal-dialog {
  margin-top: 0;
  margin-bottom: 0;
  height: 100vh;
  display: flex;
  flex-direction: column;
  justify-content: center;
}
 </style>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
 <script type="text/javascript">
 	$(document).ready(function(){
 		$('#userlistid').DataTable();
 	});

  
 </script>
@endsection
<!-- Modal -->
