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
               <div>
                  School Name :-{{$SchoolName}}|
                  @if($plan!='N/A')
                  Price Master (Plan:-{{$plan->name}})
                  @else
                  Plan Not Available
                  @endif
                
                  <small data-localize="dashboard.WELCOME"></small>
               </div>
               
          
               <!-- START Language list-->
               
               </div>
             

               <!-- END Language list-->
            </div>
          <div class="text-right">
          <button type="button" onclick="goBack()" class="btn btn-success">Go Back</button>

               </div>
			   <script>
                        function goBack() {
                         window.history.back();
                               }
                        </script>

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
	
             <th>Parts Name</th>
 			<th>Material Name</th>
 			<th>Price</th>
 		
			
    
       
 		</tr>
 	</thead>
 	<tbody>
    <?php $i=1; ?>
     
 		@foreach($arr as $k)
		<tr>
		      
			<td>{{$i++}}</td> 
			
            <td>{{$k['parts']}}</a></td>
			<td> {{$k['material']}}</td>
			<td> {{$k['price']}}</td>
         
			
		 			
		</tr>
		
		@endforeach
 
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
