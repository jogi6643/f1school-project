@extends('layouts.admin')
@section('content')
 
             <div class="content-heading">
               <div>Competition Master
                  <small data-localize="dashboard.WELCOME"></small>
               </div>
               <!-- START Language list-->
               <div class="ml-auto">
                  <div class="btn-group">
                     <a href="{{url('competitioncr')}}" class="btn btn-warning">Create</a>
                     <!-- <button class="btn btn-secondary dropdown-toggle dropdown-toggle-nocaret" type="button" data-toggle="dropdown">English</button>
                     <div class="dropdown-menu dropdown-menu-right-forced animated fadeInUpShort" role="menu"><a class="dropdown-item" href="#" data-set-lang="en">English</a><a class="dropdown-item" href="#" data-set-lang="es">Spanish</a>
                     </div> -->
                  </div>
               </div>
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

            @if(session()->has('success'))
               <div class="alert alert-info">{{session()->get('success')}}</div>
            @endif

             @if(session()->has('F1SeniorMessage'))
               <div class="alert alert-info">{{session()->get('F1SeniorMessage')}}</div>
            @endif
 <table class="table table-hover table-striped" id="userlistid">
 	<thead>
 		<tr>
 			<th>#</th>
         <th>Competition Name</th>
 			<th>Level</th>
 			<th>Short Description</th>
 			<th>Long Description</th>
 			<th>Ragistration Date</th>
         <th>Start Date</th>
         <th>Nominate</th>
         <th>Action</th>
 		</tr>
 	</thead>
 	<tbody>
      @if(count($eq)>0)
 		@foreach($eq as $k)
		<tr>
			<td>{{$k->id}}</td> 
        <?php dd(1);?>
			<td>{{$k->Competition_name}}</td>
         <td>{{$k->levelnameid}} </td>
         <td>{{$k->Sdescription}} </td>
         <td>{{$k->Ldescription}} </td>
         
			<td>{{$k->Ragistration_Date}} </td>
            <td>{{$k->Start_Date}} </td>
            <td> <a href="{{url('nominate').'/'.base64_encode($k->id)}}" class="btn btn-sm btn-outline-success"> Nominate</a></td>
         <td> <a href="{{url('editcompetition').'/'.base64_encode($k->id)}}" class="btn btn-sm btn-outline-success"><i class="fa fa-edit"></i> </a> <button class="btn btn-sm btn-outline-danger" id="tempdelid-{{$k->id}}" onclick="myfuntemp(this)"><i class="fa fa-trash"></i> </button> </td>
			
			
		 			
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