@extends(Auth::user()->role==2? 'layouts.coadmin':'layouts.admin')
@section('content')
 
             <div class="content-heading">
               <div>Course 
                  <small data-localize="dashboard.WELCOME"></small>
               </div>
               <!-- START Language list-->
			   @if(Auth::user()->role==1)
				    <div class="ml-auto">
                  <div class="btn-group">
                     <a href="{{url('coursenamecr')}}" class="btn btn-warning">Create</a>
                     
                  </div>
               </div>
				@else
				 @if((session('data')[6]??0)==1)
						   <div class="ml-auto">
                  <div class="btn-group">
                     <a href="{{url('coursenamecr')}}" class="btn btn-warning">Create</a>
                   
                  </div>
               </div>
				   @endif
			   @endif
              
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
 <table class="table table-hover table-striped" id="userlistid">
 	<thead>
 		<tr>
 			<th>#</th>
 			
         <th>Course Name</th>
         <th>Created At</th>
         @if(Auth::user()->role==1)
               <th></th> 
            @else
             @if((session('data')[6]??0)==1)
                  <th></th>   
               @endif
            @endif
         
 		</tr>
 	</thead>
 	<tbody>
      @if(count($eq)>0)
 		@foreach($eq as $k)
		<tr>
			<td>{{$k->id}}</td> 
			
         <td>
            @if(isset($k->course_name))
               <a href="{{url('coursecs/'.base64_encode($k->id))}} " target="__blank">{{$k->course_name}} </a>
            @endif
         </td>
			<td>{{date('d-m-Y',strtotime($k->created_at))}} </td>
			
			  @if(Auth::user()->role==1)
				    <td> <a href="{{url('coursenameed').'/'.base64_encode($k->id)}}" class="btn btn-sm btn-outline-success"><i class="fa fa-edit"></i> </a> <button class="btn btn-sm btn-outline-danger" id="tempdelid-{{$k->id}}" onclick="myfuntemp(this)"><i class="fa fa-trash"></i> </button> </td>
		
				@else
				
				 @if((session('data')[6]??0)==1)
					 <td> <a href="{{url('coursenameed').'/'.base64_encode($k->id)}}" class="btn btn-sm btn-outline-success"><i class="fa fa-edit"></i> </a> <button class="btn btn-sm btn-outline-danger" id="tempdelid-{{$k->id}}" onclick="myfuntemp(this)"><i class="fa fa-trash"></i> </button> </td>
		
				   @endif
			   @endif
        	
			
		 			
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
         window.location.href='{{url("/coursenamedel")}}/'+btoa(ak[1]);
         // alert("yes");
   }
 </script>
@endsection