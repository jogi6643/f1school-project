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
               <div>Price Master 
                  <small data-localize="dashboard.WELCOME"></small>
               </div>
               
          
               <!-- START Language list-->
               
               </div>
			   
			   @if(Auth::user()->role==1)
					 <div class="text-right">
            
            <div class="btn-group">
            <a href="{{url('viewpriceassignschool')}}" class="btn btn-outline-danger"> View Price School</a>
            </div>
                    <div class="btn-group">
                     <a href="{{url('addplan')}}" class="btn btn-outline-success">Create Price</a>
                </div> 
				
               <div class="btn-group">
                     <a href="{{url('downloadplan')}}" class="btn btn-outline-info">Download Price</a>
                </div>  				
                <button type="button" onclick="goBack()" class="btn btn-success">Go Back</button>

                           <script>
                        function goBack() {
                         window.history.back();
                               }
                        </script>
               </div>
				@else
				
					 @if((session('data')[11]??0)==1)
						
							  <div class="text-right">
						<div class="btn-group">
						 <a href="{{url('addplan')}}" class="btn btn-warning">Create Price</a>
					</div> 
					
				   <div class="btn-group">
						 <a href="{{url('downloadplan')}}" class="btn btn-info">Download Price</a>
					</div>  				
					<button type="button" onclick="goBack()" class="btn btn-success">Go Back</button>

							   <script>
							function goBack() {
							 window.history.back();
								   }
							</script>
				   </div>
					   @endif
				@endif
	   
			   
            
               <!-- END Language list-->
            </div>
			 @if(Auth::user()->role==1)
					  <div class="row " style="margin-left:10px">
                     
                          <div class="col-md-12">
                         <div class="col-md-6">
                     <form class="border-class" method="post" action="{{url('uploadprice')}}" enctype="multipart/form-data">
                         <input type="hidden" name="_token" value="{{csrf_token()}}"> 
                       <div class="row">
					   <div class="col-md-12">
                          <div class="form-group">
                            <label for="file">Plan:</label>
                             <select name="plan">
							 @foreach($plan as $plans)
							  <option value="{{$plans->id}}">{{$plans->name}}</option>
							  @endforeach
							 </select>
                          </div>
                           
                         </div>						
                         <div class="col-md-12">
                          <div class="form-group">
                            <label for="file">Upload Price Templates:</label>
                            <input type="file" class="form-control" name="files" id="file">
                          </div>
                           
                         </div>
					  </div>
						 <div class="row">
                          <div class="col-md-4">
                            <div class="form-group">
                                 <label style="padding:7%"></label>
                             <button type="submit" class="btn btn-primary">Submit</button>
                             </div>
                         </div>
						 </div>
                       
                         
                        </form>
                        </div>
                       
                       
                        </div>
			
                     </div>
				@else
				
					 @if((session('data')[11]??0)==1)
						   <div class="row " style="margin-left:10px">
                     
                          <div class="col-md-12">
                         <div class="col-md-6">
                     <form class="border-class" method="post" action="{{url('uploadprice')}}" enctype="multipart/form-data">
                         <input type="hidden" name="_token" value="{{csrf_token()}}"> 
                       <div class="row">
					   <div class="col-md-12">
                          <div class="form-group">
                            <label for="file">Plan:</label>
                             <select name="plan">
							 @foreach($plan as $plans)
							  <option value="{{$plans->id}}">{{$plans->name}}</option>
							  @endforeach
							 </select>
                          </div>
                           
                         </div>						
                         <div class="col-md-12">
                          <div class="form-group">
                            <label for="file">Upload Price Templates:</label>
                            <input type="file" class="form-control" name="files" id="file">
                          </div>
                           
                         </div>
					  </div>
						 <div class="row">
                          <div class="col-md-4">
                            <div class="form-group">
                                 <label style="padding:7%"></label>
                             <button type="submit" class="btn btn-primary">Submit</button>
                             </div>
                         </div>
						 </div>
                       
                         
                        </form>
                        </div>
                       
                       
                        </div>
			
                     </div>
				@endif
			 @endif
         
       
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
 			<th>Manufacture Cost</th>
 			<th>Status</th>
			<th>Type</th>
      <th>Available Blocks</th>
			<th>Block Price</th>
			<th>View Part/Material Price</th>
			
    
       
 		</tr>
 	</thead>
 	<tbody>
    <?php $i=1; ?>
      @if(count($plan)>0)
 		@foreach($plan as $k)
		<tr>
		      
			<td>{{$i++}}</td> 
			 @if(Auth::user()->role==1)
      <td> <a href="{{url('editplan/'.base64_encode($k->id))}} " target="__blank">{{$k->name}}</a></td>
        @else
       
      @if((session('data')[11]??0)==1)
      <td> <a href="{{url('editplan/'.base64_encode($k->id))}} " target="__blank">{{$k->name}}</a></td>
      @else
       <td>{{$k->name}}</td>
      @endif
      @endif

			<td> {{$k->manufacturing_cost}}</td>
          <td>@if($k->status==1) Active @else Inactive @endif</td>
         
		    <td>@if($k->level==1) Individual  @else Team @endif </td>
        <td>{{$k->number}} </td>
			<td>{{$k->block_price}}</td>
          <td><a href="{{url('view_meterial')}}/{{base64_encode($k->id)}}">view </a></td>
		 

         

         
  
			
			
		 			
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
