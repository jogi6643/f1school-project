@extends(Auth::user()->role==2? 'layouts.coadmin':'layouts.admin')
 @section('content')
            <div class="content-heading">
                  <small data-localize="dashboard.WELCOME"></small>
                  <h3>
                    Teams Available In School
                  </h3>
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
 		   
 			<th>S.No</th>
 		  <th>Image</th>
      <th>Team Name</th>
      <th>Description</th>
 		  <th>created At</th>
         
 		</tr>
 	</thead>
 	<tbody>
 	    <?php $i=1?>
     @if($t==null)
    
      @else
      <?php $i=1;?>
 @foreach($t as $tm)

    <tr>
     <td>{{$i}}</td>
    <td>
  <a href="{{url('viewteampage')}}/{{base64_encode($tm->id)}}"><img style="height: 100px;width:100px; border-radius: 50%;" src="{{url('public/team/')}}/{{$tm->team_Image}}"></a>
         </td>
      <a href="{{url('viewteampage')}}/{{base64_encode($tm->id)}}"></a></td> 
    <td><a href="{{url('viewteampage')}}/{{base64_encode($tm->id)}}">{{$tm->team_Name}}</a></td> <td>{{$tm->team_Description}}</td>
    <?php $date1=date_create($tm->created_at);
                    $re=date_format($date1,"d-m-Y");?>
     <td>{{$re}}</td>  
   
    </tr>
  <?php $i=$i+1;?>
  @endforeach  
      @endif

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