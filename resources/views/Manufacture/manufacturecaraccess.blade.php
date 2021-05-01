@extends(Auth::user()->role==2? 'layouts.coadmin':'layouts.admin')
@section('content')
<style type="text/css">
  .note-modal-backdrop{
    display: none!important;
  }
</style>
<div class="content-heading">
    <div>Manufacture List
     <small data-localize="dashboard.WELCOME"></small>
    </div>
    <div class="ml-auto">
      <div class="btn-group">
    <a href="{{ url('downloadmanufacuturelist') }}" class="btn btn-warning">Download Manufacuture List</a>&nbsp;    
    <button type="button" onclick="goBack()" class="btn btn-info">Go Back</button>
   <script>
      function goBack() {
        window.history.back();
      }
   </script>
      </div>
    </div>
</div>
     @if($errors->any())
     <div class="alert alert-danger">
      <ul>
       @foreach ($errors->all() as $error)
       <li>{{ $error }}</li>
       @endforeach
      </ul>
     </div>
     @endif
     @if(session()->has('success'))
     <div class="alert alert-success">{{session()->get('success')}}</div>
     @endif
     @if(session()->has('error'))
     <div class="alert alert-danger">
     {{session()->get('error')}}
     </div>
     @endif
<table class="table table-hover table-striped" id="userlistid1">
   <thead>
      <tr>
         <th>#</th>
         <th>Application Id</th>
         <th>Student Name</th>
         <th>Institute</th>
         <th>Institute Name</th>
         <th>Team Name</th>
         <th>Competition Name</th>
         <th>Trainer Name</th>
         <th>Part Type</th>
         <th>Part Name</th>
         <th>attachment</th>
         <th>Prototype attachment</th>
         <th>Applied On</th>
        @if(Auth::user()->role==1)
         <th>Action</th>
        @else
        @if((session('data')[9]??0)==1)
        <th>Action</th>
        @endif
        @endif
      </tr>
   </thead>
   <tbody>
      <?php $i=1;?> 
    
      <!-- blade start for card body part -->

      @if(count($carbodypart)>0)
    
      @foreach($carbodypart as $key=> $k)
  
      <tr>
         <td>{{$i++}}</td>
         <td>{{$k['applicationid']}}</td>
          <?php $ids=$k['schoolidC']."_".$k['studentidC'];?>
         <td><a href="{{url('viewstudentinfoadmin')}}/{{base64_encode($ids)}}">{{$k['studentname']}}  </a></td>
         <td>{{$k['instype']}}  </td>
         <td><a href="{{url('schoolv')}}/{{base64_encode($k['schoolidC'])}}">{{$k['schoolname']}}  </a></td>
         @if($k['teamid']!='N/A')
         <td><a href="{{url('viewteampage')}}/{{base64_encode($k['teamid'])}}">
         {{$k['teamname']}}  </a></td>
         @else
           <td>
         {{$k['teamname']}}</td>
         @endif
         <td>{{$k['Competitionname']}}  </td>
         <td>{{$k['trainer_name']}}  </td>
         

         @if($k['carbodypart']=='Car Body' && $k['carpartid']==0)
         <td>{{$k['carbodypart']}}</td>

         
         <td></td>

       @else

        <td>{{$k['carbodypart']}}</td>
       <td>{{$k['carpartname']}}</td>
       @endif
         <td><a href="{{url('Carimage/')}}/{{$k['partimage']}}" class="rounded float-left" alt="..." target="_blank">View File</a>
         </td>

          <td>
          @if($k['prototypeimage']!=null)
            <a href="{{url('Carimage/')}}/{{$k['prototypeimage']}}" class="rounded float-left" alt="..." target="_blank">View File</a>
            @else
            No File Uploded
            @endif

         </td>
         <?php
            $date=date_create($k['updated_at']);
            $cr=date_format($date,"d-m-Y H:i:s");
         ?>
         <td>{{$cr}}</td>
          @if(Auth::user()->role==1)
         <td>
           @if($k['status']==1)
			   Approved
   
          @elseif($k['status']==2)
		  Rejected
       
		  @else
     
          <button   class="btn btn-success"><a style="color: white;" href="{{url('approvedbyadminmanufacture')}}/{{$k['applicationid']}}">Approve</a></button>
          <button  type="button" data-toggle="modal" data-target="#myModal_{{$k['applicationid']}}" class="btn btn-warning">Reject</button>
</td>
          @endif
          @else
          @if((session('data')[9]??0)==1)
                   <td>
           @if($k['status']==1)
         Approved
   
          @elseif($k['status']==2)
      Rejected
       
      @else
     
          <button   class="btn btn-success"><a style="color: white;" href="{{url('approvedbyadminmanufacture')}}/{{$k['applicationid']}}">Approve</a></button>
          <button  type="button" data-toggle="modal" data-target="#myModal_{{$k['applicationid']}}" class="btn btn-warning">Reject</button>
</td>
          @endif
      @endif
      
      @endif



          <!-- Modal -->
<div class="modal fade" id="myModal_{{$k['applicationid']}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
     <!--  <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Rejected</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div> -->
      <!-- <div class="modal-body"> -->
     <form method="POST"class="form-horizontal" role="form" action="{{url('rejectedbyadminmanufacture')}}" enctype="multipart/form-data">
       @csrf
           <div hidden="" class="form-control">
          <input type="text" name="Appication" class="form-control" 
                        value="{{$k['applicationid']}}" />
           </div>
        <div class="form-control">
          <label>Comment:</label>
       <textarea class="form-control" name="remarks" rows="5"></textarea>
       <label>Comment Image:</label>
       <input type="file" name="commentimage" class="form-control">
       <!--  <textarea class="form-control reflective1" name="remarks" rows="5"></textarea> -->
      </div>

       <input type="submit" class="btn btn-success" value="Save changes">

       </form>     

      <!-- </div> -->
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      
      </div>
    </div>
  </div>
</div>
        </td>
        
      </tr>
    
      @endforeach
      @endif
   </tbody>
</table>
@section('header')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
@endsection

 
 <!--    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.16/dist/summernote-lite.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.16/dist/summernote-lite.min.js"></script>
<script>
$(document).ready(function(){
  jQuery.noConflict();
$('.reflective1').summernote();


});

</script>
 -->
 <script type="text/javascript">
  $('.reflective1').hide();
</script>

<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
<script type="text/javascript">
   $(document).ready(function(){
     // $('#userlistid1').DataTable();
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