@extends(Auth::user()->role==2? 'layouts.coadmin':'layouts.admin')
@section('content')
 
             <div class="content-heading">
               <div>Competition Master
                  <small data-localize="dashboard.WELCOME"></small>
               </div>
               <!-- START Language list-->
			   @if(Auth::user()->role==1)
				   <div class="ml-auto">
                  <div class="btn-group">
                     <a href="{{url('competitioncr')}}" class="btn btn-warning">Create</a>
                 
                  </div>
               </div>
				   @else
			    @if((session('data')[3]??0)==1)
               <div class="ml-auto">
                  <div class="btn-group">
                     <a href="{{url('competitioncr')}}" class="btn btn-warning">Create</a>
                 
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
			@if(session()->has('error'))
               <div class="alert alert-info">{{session()->get('error')}}</div>
            @endif

             @if(session()->has('F1SeniorMessage'))
               <div class="alert alert-info">{{session()->get('F1SeniorMessage')}}</div>
            @endif
 <table class="table table-hover table-striped" id="userlistid">
 	<thead>
 		<tr>
 			<th>#</th>
         <th>Academic Year</th>
         <th>Type</th>
         <th>Competition Name</th>
         <th>Award</th>
 			<th>Level</th>
 			<th>Short Description</th>
 			<th>Long Description</th>
 			<th>Registration Date</th>
         <th>Start Date</th>
		 @if(Auth::user()->role==1)
		   <th>Nominate</th>
			 <th>View</th>
			<th>Action</th>
		@else
			  
		 @if((session('data')[3]??0)==1)
            <th>View</th>
				  <th>Nominate</th>
				 <th>Action</th>
		   @endif
		
		  @endif
       
 		</tr>
 	</thead>
 	<tbody>
      @if(count($eq)>0)
 		@foreach($eq as $k)

		<tr>
			<td>{{$k->id}}</td> 
        <td>{{$k->academicyear}}</td>
        <td>
         @if($k->typeid=='1')
         College
         @else
         School
         @endif
        </td>
			<td><a href="{{url('referencedocument')}}/{{base64_encode($k->id)}}">{{$k->Competition_name}}</a></td>
         <td><a href="{{url('awards')}}/{{base64_encode($k->id)}}">Award</a></td>
         <td>{{$k->levelnameid}} </td>
         <td>{{$k->Sdescription}} </td>
         <td>{{$k->Ldescription}} </td>
         
			<td>{{$k->Ragistration_Date}} </td>
         <td>{{$k->Start_Date}} </td>
		  @if(Auth::user()->role==1)
		    <td> 
            @if($k->typeid!='1')
            <a class="btn btn-lg btn-outline-success" href="{{url('nominate').'/'.base64_encode($k->id)}}" >Nominate/Remove</a>
            @else
             <a class="btn btn-lg btn-outline-danger" href="{{url('nominate-team-List').'/'.base64_encode($k->id)}}" > Nominate team List</a>
            @endif
         </td>
			 <td>
   
            <a href="{{url('viewschoolincompition').'/'.base64_encode($k->id)}}">View</a>
         </td>
            <td> <a href="{{url('editcompetition').'/'.base64_encode($k->id)}}" class="btn btn-sm btn-outline-success"><i class="fa fa-edit"></i> </a> <button class="btn btn-sm btn-outline-danger" id="tempdelid-{{$k->id}}" onclick="myfuntemp(this)"><i class="fa fa-trash"></i> </button> </td>
		 
		@else
			
		 @if((session('data')[3]??0)==1)
        <td><a href="{{url('viewschoolincompition').'/'.base64_encode($k->id)}}">View</td>
				 <td> <a href="{{url('nominate').'/'.base64_encode($k->id)}}" >Nominate/Remove</a></td>
		
            <td> <a href="{{url('editcompetition').'/'.base64_encode($k->id)}}" class="btn btn-sm btn-outline-success"><i class="fa fa-edit"></i> </a> <button class="btn btn-sm btn-outline-danger" id="tempdelid-{{$k->id}}" onclick="myfuntemp(this)"><i class="fa fa-trash"></i> </button> </td>
		 
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
      alert('val = '+ak[1]);
      // if(confirm("Do you really want to delete this."))
         window.location.href='{{url("/delcompetition")}}/'+btoa(ak[1]);
         // alert("yes");
   }
 </script>
@endsection