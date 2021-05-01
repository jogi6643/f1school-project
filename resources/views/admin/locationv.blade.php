@extends('layouts.admin')
@section('content')
 
             <div class="content-heading">
               <div>Location Master
                  <small data-localize="dashboard.WELCOME"></small>
               </div>
               <!-- START Language list-->
               <div class="ml-auto">
                  <div class="btn-group">
                     <a href="{{url('locationcr')}}" class="btn btn-warning">Create</a>
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
 <table class="table table-hover table-striped" id="userlistid">
 	 <thead>
 		<tr>
        
 			<th>#</th>
    <th>Zone</th>
      <th>State</th>
      <th>City</th>
      <th>School Name</th>
       <th>Created At</th>
      <th>Last Modified</th>
    
      </tr>
      </thead>

<tbody>
   @if(count($k)>0)
   <?php $i=1;?>
   @foreach($k as $k)
      <tr>
      <td> {{$i}}</td>
 			<td> {{$k->zonename}}</td>
   
 		    <td>{{$k->statename}} </td>
      
 			<td>{{$k->cityname}} </td>

 			<td>{{$k->school_name}} </td>
 
         <td>{{date('d-F-Y',strtotime($k->created_at))}} </td>
         <td>{{date('d-F-Y',strtotime($k->updated_at))}} </td>
 		</tr>
      <?php $i=$i+1?>
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
 <script type="text/javascript">
 	$(document).ready(function(){
 		$('#userlistid').DataTable();
 	});

   function myfuntemp(arg) {
      var ad=$(arg).attr('id');
      var ak=ad.split('-');
      // alert('val = '+ak[1]);
      if(confirm("Do you really want to delete this."))
         window.location.href='{{url("/locationdel")}}/'+btoa(ak[1]);
         // alert("yes");
   }
 </script>
@endsection