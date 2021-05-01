@extends(session('role')==2? 'layouts.coadmin':'layouts.admin')
@section('content')
 
             <div class="content-heading">
               <div>Coadmin Master
               
                  <small data-localize="dashboard.WELCOME"></small>
               </div>
               <!-- START Language list-->
               <div class="ml-auto">
                  <div class="btn-group">
                     <a href="{{url('coadmincreate')}}" class="btn btn-warning">Create</a>
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
               <div  class="alert alert-info">{{session()->get('success')}}</div>
            @endif
			@if(session()->has('error'))
               <div  class="alert alert-info">{{session()->get('error')}}</div>
            @endif
 <table class="table table-hover table-striped" id="userlistid">
 	<thead>
 		<tr>
 			<th>#</th>
           <th> Name</th>
 			<th>Phone No</th>
 			<th>Email</th>
 			<th>Assigned Role</th>
      <th>Invite</th>
 			<th>Created At</th>
 			<th>Status</th>
 			
 			<th>----</th>
 		
         
 		</tr>
 	</thead>
 	<tbody>
 	 @if(isset($eq))
    @if(count($eq)>0)
    <?php $i=1;?>
 		@foreach($eq as $k)
 	
		<tr>
			<td>{{$i}}</td> 
            <td> {{$k->name}}</td>
			<td> {{$k->phone}}</td>
             <td>{{$k->email}} </td>
             <td>{{$k->assignedrole}} </td>
             <td>
              @if($k->status==1)
              <a  class="btn btn-outline-success" href="{{url('Invite-coadmin').'/'.base64_encode($k->id)}}" class="btn btn-sm btn-outline-success">Invite</a>
              @endif

              @if($k->status==2)
              <button   class="btn btn-outline-danger" href="{{url('Invite-coadmin').'/'.base64_encode($k->id)}}" >Invited</button>
              @endif

              @if($k->status==0)
              <button  class="btn btn-outline-danger" href="javascript:void(0)">Inactive</button>
              @endif

            </td>
             <td>{{date('d/m/Y i:h:s',strtotime($k->created_at))}} </td>
             <td>@if($k->status==1||$k->status==2) Active @else Inactive @endif</td>
   
             <td> <a href="{{url('editcoadmin').'/'.base64_encode($k->id)}}" class="btn btn-sm btn-outline-success"><i class="fa fa-edit"></i> </a>  </td>
			
            
         
		
		 			
		</tr>
		<?php $i=$i+1; ?>
		@endforeach
 		@else
        
      @endif
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
         window.location.href='{{url("/schooldel")}}/'+btoa(ak[1]);
         // alert("yes");
   }
 </script>
@endsection