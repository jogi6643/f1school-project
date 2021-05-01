@extends(Auth::user()->role==2? 'layouts.coadmin':'layouts.admin')
 @section('content')
         <div class="content-heading">
 <div>
  <h3 class="text-left">{{$planname}}::{{$acyear}}</h3>
     <small data-localize="dashboard.WELCOME"></small>
  </div>
</div>
               <style>https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css</style>
               <style>https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css</style>
            </div>

            @if($errors->any())
               @foreach($errors->all() as $err)
                  <div class="alert alert-danger">{{$err}}</div>
               @endforeach
            @endif
            @if(session()->has('success'))
               <div class="alert alert-info">{{session()->get('success')}}</div>
            @endif


    <div class="col-md-12">
           <div class="text-right">
                 <button type="button" onclick="goBack()" class="btn btn-info">Go Back</button>

<script>
function goBack() {
  window.history.back();
}
</script>
          </div>
    </div>


        
                     

   <div class="col-md-12">
    
    <table class="table table-striped table-bordered" id="planlistid">
 	<thead>
 		<tr>
 		   
 			<th>#</th>
      <th>Academic Year</th>
 		  <th>School Name</th>
      <th>Participate Students</th>
 		</tr>
 	</thead>
 	<tbody>
 	    <?php $i=1?>
      
  @foreach($st as $row)

  <?php 

    $ids = $row->year."_".$row->planid."_".$row->schoolid;

  ?>

		<tr>
		 <td>{{$i++}}</td>
    <td>{{$row->year}}</td>
		 <td><a href="{{url('schoolv'.'/'.base64_encode($row->schoolid)) }}" target="__blank">{{$row->school_name}}</a></td>
     <td><a class="btn btn-info" href="{{ url('avaiable-student-in-School-plan'.'/'.base64_encode($ids)) }}">{{$row->student_count}}</a></td>  

		</tr>
  @endforeach  

 	</tbody>
 </table>
       
   </div>
@endsection

@section('header')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
<script type="text/javascript"  src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>

@endsection

@section('footer')
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
 <script type="text/javascript">
 	$(document).ready(function(){
 		$('#planlistid').DataTable();
 	});

 </script>
@endsection