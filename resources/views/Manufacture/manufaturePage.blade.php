@extends('layouts.student')
@section('contents')



   <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">

   <style type="text/css">
  .my-custom-scrollbar {
position: relative;
height: 500px;
overflow: auto;
}
.table-wrapper-scroll-y {
display: block;
}
</style>

<!-- <script src="http://code.jquery.com/jquery-1.11.3.min.js"></script> -->
<main role="main">
       <div class="text-right">
                  <button type="button" onclick="goBack()" class="btn btn-info">Go Back</button>

                  <script>
              function goBack() {
                  window.history.back();
                      }
                 </script>
               </div>
    
     
  
                
    
  </section>

  <!-- <div class="album py-5 bg-light"> -->
    <div class="container">
      <div class="card mb-3">
  <div class="row">
<div class="col-md-4">
  <div class="card-body">

  <img class="card-img-top"  style="height:100px;width:100px;border-radius: 50%;" src="{{url('public/team/')}}/previewimg.png" alt="Card image cap">
  <h5 class="card-title">{{$stuname}}</h5>

</div>
</div>
<div class="col-md-8">
    <div class="card-body">
    <h5 class="card-title">{{$schname}}</h5>
    <p class="card-text">Description........</p>
   
  </div>
</div>

</div>
</div>
<div class="table-wrapper-scroll-y my-custom-scrollbar">
   <table class="table table-bordered table-striped mb-0">
  <thead class="thead-dark">
    <tr>
      <th>S.No</th>
      <th>Application Id</th>
      <th>Type</th>
      <th>Applied On</th>
      <th>Status</th>
      <th>Last Edited</th>
      <th>Remarks</th>
   
    </tr>
  </thead>
  <tbody>
      <?php $i=0;?>
      @if(count($carbody)>0)
      @foreach($carbody as $carbody1) 

      <tr>
      <td>{{$carbody1->applicationid}}</td>
      <td>{{$carbody1->applicationid}}</td>
      <td>{{$carbody1->type}}</td>
      <td>{{date('d-F-Y',strtotime($carbody1->created_at))}}</td>
      <td> @if($carbody1->status==1)Approved @elseif($carbody1->status==2)Rejected @else Pending @endif </td>
        <td>{{date('d-F-Y',strtotime($carbody1->updated_at))}}</td>
      <td> {{$carbody1->remark}}</td>
    </tr>

 @foreach($carbodypart as $carbodypart1)

 @if($carbody1->applicationid==$carbodypart1->applicationid)

  <tr>
      <td>$carbodypart1->applicationid</td> 
      <td>{{$carbodypart1->applicationid}}</td>
      <td>{{$carbodypart1->Partname}}(Card Body Part)</td>
      <td>{{date('d-F-Y',strtotime($carbodypart1->created_at))}}</td>
      <td> @if($carbodypart1->status==1)Approved @elseif($carbodypart1->status==2)Rejected @else Pending @endif </td>
        <td>{{date('d-F-Y',strtotime($carbodypart1->updated_at))}}</td>
      <td> {{$carbodypart1->remark}}</td>
    </tr>

    @endif


     @endforeach
    @endforeach
    @endif

  
  </tbody>
</table>
</div>
<?php $ids=$studentid."_".$schoolid?>
 <div class="text-right">
 <a href='{{url('newmanufatureCar')}}/{{base64_encode($ids)}}'><button type="button" class="btn btn-primary">Submit new Design</button> </a>
      </div>
    </div>
    <!-- </div> -->



<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
<script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>

 <script type="text/javascript">
$(document).ready( function () {
    $('#myTable').DataTable();
} );
</script>
</main>
@endsection

