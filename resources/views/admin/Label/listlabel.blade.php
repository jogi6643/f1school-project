@extends('layouts.admin')
@section('content')
            <div class="content-heading">
               <div>Role
                  <small data-localize="dashboard.WELCOME"></small>
               </div>
               <!-- START Language list-->
               <div class="ml-auto">
                   <div class="btn-group">
                     <a href="{{url('addrole')}}" class="btn btn-warning">Add Role</a>
                    </div>
                  <!-- <div class="btn-group">
                     <button class="btn btn-secondary dropdown-toggle dropdown-toggle-nocaret" type="button" data-toggle="dropdown">English</button>
                     <div class="dropdown-menu dropdown-menu-right-forced animated fadeInUpShort" role="menu"><a class="dropdown-item" href="#" data-set-lang="en">English</a><a class="dropdown-item" href="#" data-set-lang="es">Spanish</a>
                     </div>
                  </div> -->
               </div>
               <!-- END Language list-->
            </div>
 
 <table class="table table-hover table-striped" id="transactionid">
 	<thead>
 		<tr>
 		<th>#</th>
         <th>Name</th>
	    <th>Role</th>
         <th>Status</th>
         <th>Updated at</th>
		<th>Edit</th>
 		</tr>
 	</thead>
 	<tbody>
<?php $i=1;?>
<?php foreach($label as $dess):?>
    <tr>
        <td>{{$i}}</td>
        <td><a href="#">{{$dess->name}}</a></td>
		<td>{{$dess->label}}</td>
		 @if($dess->status==1)
           <td>Active</td>
          @else <td>Inactive</td>
         @endif
         <td>{{date('d-m-Y',strtotime($dess->updated_at))}}</td>
		       <td> <a href="{{url('role_define_module')}}/{{base64_encode($dess->id)}}" class="btn btn-sm btn-outline-success"><i class="fa fa-edit"></i> </a>
                           
	</tr>
 	<?php $i=$i+1;?>
	<?php endforeach;?>
 		
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
 		$('#transactionid').DataTable({
 			"order": [[ 3, "desc" ]]
 		});
 	});
 </script>
@endsection