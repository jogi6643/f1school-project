@extends(Auth::user()->role==2? 'layouts.coadmin':'layouts.admin')
@section('content')
<style type="text/css">
  .note-modal-backdrop{
    display: none!important;
  }
</style>
<div class="content-heading">
    <div>Show School Manufacture
     <small data-localize="dashboard.WELCOME"></small>
    </div>
    <div class="ml-auto">
      <div class="btn-group">
  
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
        
         <th>Car Type</th>
         
         <th>Status</th>
      </tr>
   </thead>
   <tbody>
      <?php $i=1;?> 
    
      <!-- blade start for card body part -->

      @if(count($manufacturedata)>0)
    
      @foreach($manufacturedata as $key=> $k)
  
      <tr>
         <td>{{$i++}}</td>
         <td>{{$k->applicationid}}</td>
          <?php $id = $k->schoolidC."_".$k->studentidC; ?>
         <td><a href="{{url('viewstudentinfoadmin')}}/{{base64_encode($id)}}">{{$k->student_name}}  </a></td>
         

         @if($k->carbodypart=='Car Body' && $k->carpartid==0)
         <td>{{$k->carbodypart}}</td>
         
         
       @else
        <td>{{$k->carbodypart}}</td>
       
       @endif
       
         
          @if($k->status==1)
          <td>
          Aprroved
          </td>
          @else
          <td>
          Pending
        </td>
          @endif
        
        
      </tr>
    
      @endforeach
      @endif
   </tbody>
</table>
@section('header')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
@endsection

     <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.16/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.16/dist/summernote-lite.min.js"></script>
<script>
$(document).ready(function(){
  jQuery.noConflict();
$('.reflective1').summernote();


});

  

</script>
<script type="text/javascript">
  $('.reflective1').hide();
</script>

<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
<script type="text/javascript">
   $(document).ready(function(){
     $('#userlistid1').DataTable();
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