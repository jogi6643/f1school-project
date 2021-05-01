@extends(Auth::user()->role==2? 'layouts.coadmin':'layouts.admin')
@section('content')
 
             <div class="content-heading">
               <div>Course Master
                  <small data-localize="dashboard.WELCOME"></small>
               </div>
               <!-- START Language list-->
               <!-- <div class="ml-auto"> -->
                  <!-- <div class="btn-group"> -->
                     <!-- <a href="{{url('locationcr')}}" class="btn btn-warning">Create</a> -->
                     <!-- <button class="btn btn-secondary dropdown-toggle dropdown-toggle-nocaret" type="button" data-toggle="dropdown">English</button>
                     <div class="dropdown-menu dropdown-menu-right-forced animated fadeInUpShort" role="menu"><a class="dropdown-item" href="#" data-set-lang="en">English</a><a class="dropdown-item" href="#" data-set-lang="es">Spanish</a>
                     </div> -->
                  <!-- </div> -->
               <!-- </div> -->
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
 <table class="table table-hover table-striped" id="userlistid2">
 	<tbody>
 		<tr>
 			<th width="20%">#</th>
         <td>{{$k->id}}</td>
      </tr><tr>
         <tr>
         <th>Course Name</th><td>{{isset($k->csm->course_name)?$k->csm->course_name:''}}</td>
      </tr>
 			<th>Title </th><td> {{$k->title}}</td>
         </tr><tr>
 			<th>Type</th><td>{{isset($k->type->type)?$k->type->type:''}} </td>
         </tr><tr>
 			<th>Description</th><td>{{$k->description}} </td>
         </tr><tr>
 			<th>Duration</th><td>{{$k->duration}} </td>
         </tr>
         @if($k->doc_types_id==2)
         <tr>
         <th>Video</th><td>{{$k->video_path}} </td>
         </tr>
         @elseif($k->doc_types_id==1)
         <tr>
         <th>Document</th><td>{{$k->doc_path}} </td>
         </tr>
         @endif
         <tr>
         <th>Created At</th><td>{{$k->created_at}} </td>
         </tr>
         
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