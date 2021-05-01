@extends(Auth::user()->role==2? 'layouts.coadmin':'layouts.admin')
 @section('content')
         <div class="content-heading">
 <div>School Name: {{$schoolname}}
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
 			<th>Image</th>
 		  <th>Team Name</th>
 		  <th>School Name</th>
 		  <th hidden="">Created by</th>
 		  <th>Created by</th>
      @if(Auth::user()->role==1)
      <th>Viem Member</th>
    @else
      
     @if((session('data')[14]??0)==1&&(session('data')[15]??0)==1)
        <th>Viem Member</th>
      @elseif((session('data')[14]??0)==1)
       <th>Viem Member</th>
       @endif
     @endif

 		 

         
 		</tr>
 	</thead>
 	<tbody>
 	    <?php $i=1?>
  @foreach($trschool as $row)

  <?php 

    $ids = $row->id."_".$row->student_id."_".$row->school_id;

  ?>

		<tr>
		 <td>{{$i++}}</td>
     <td>
      @if($row->team_Image!=null)
      <img style="height: 50px;width:50px; border-radius: 50%;" src="{{url('team/')}}/{{ $row->team_Image }}">
      @else
      <img style="height: 50px;width:50px; border-radius: 50%;" src="{{url('team/pro.jpg')}}">
      @endif

     </td>
	
		 <td><a href="{{ url('viewteampage'.'/'.base64_encode($row->id)) }}">{{$row->team_Name}}</a></td>
		 <td>{{$row->school_name}}</td>
     
		<th hidden="">{{$row->ss[1]}} </th>
    <th>
      {{$row->student_name}}
    </th>

    @if(Auth::user()->role==1)
    
         <td>
       <a href="{{url('editteambyad/'.base64_encode($ids))}}"><button type="button" class="btn btn-warning">Edit Team</button></a>

       <a href="{{url('deleteteambyad/'.base64_encode($ids))}}"><button type="button" class="btn btn-danger">Delete Team</button></a>
      </td>
    @else
      
     @if((session('data')[14]??0)==1&&(session('data')[15]??0)==1)
        <td>
       <a href="{{url('editteambyad/'.base64_encode($ids))}}"><button type="button" class="btn btn-warning">Edit Team</button></a>

       <a href="{{url('deleteteambyad/'.base64_encode($ids))}}"><button type="button" class="btn btn-danger">Delete Team</button></a>
      </td> 
      @elseif((session('data')[14]??0)==1)
       <td>

       <a href="{{url('editteambyad/'.base64_encode($ids))}}"><button type="button" class="btn btn-warning">Edit Team</button></a>

       <a href="{{url('deleteteambyad/'.base64_encode($ids))}}"><button type="button" class="btn btn-danger">Delete Team</button></a>
      </td> 
       @endif
     @endif


      
        
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

//   function myfuntemp(arg) {
//       var ad=$(arg).attr('id');
//       var ak=ad.split('-');
//       // alert('val = '+ak[1]);
//       if(confirm("Do you really want to delete this."))
//          window.location.href='{{url("/schooldel")}}/'+btoa(ak[1]);
//          // alert("yes");
//   }
 </script>
@endsection