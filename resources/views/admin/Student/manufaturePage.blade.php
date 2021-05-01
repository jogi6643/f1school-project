@extends('layouts.student')
@section('contents')
<?php
// Start the session

?>

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

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">



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

  <img class="card-img-top"  style="height:100px;width:100px;border-radius: 50%;" src="{{url('team/')}}/previewimg.png" alt="Card image cap">
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
@if(isset($_SESSION['msg']))
@if($_SESSION['msg']=='adding')
<div class="alert alert-success">
  <strong>Successfully Added...</strong>
</div>
@endif
@if($_SESSION['msg']=='added')
<div class="alert alert-warning">
  <strong>Already Added</strong>
</div>
@endif
@endif


<?php $ids=$studentid."_".$schoolid?>
@if(isset($_SESSION['cart']))
  @if(count(array_unique($_SESSION['cart']))!=0)
<div class="row">
  <div class="col-md-6">
     <a href='{{url('cart')}}'><button type="button" class="btn btn-primary">Cart <?php echo count(array_unique($_SESSION['cart']));?> </button> </a>
   </div>

@endif
<br>
@endif

 <div  class="col-md-6" >
 <a href='{{url('newmanufatureCar')}}/{{base64_encode($ids)}}'><button type="button" class="btn btn-primary">Submit new Design</button> </a>
</div>
</div>
</div>
</div>


<div class="container">
  <div class="table-wrapper-scroll-y my-custom-scrollbar">
 <table class="table table-bordered table-striped mb-0" id="myTable">
 
  <tbody>

 <thead class="thead-dark">
 
    <tr>
      <th>S.No</th>
      
      <th>Application Id</th>
      <th>Type</th>
      <th>Applied On</th>
      <th>Status</th>
      <th>Last Edited</th>
      <th>Remarks</th>
      <th>Remarks Image</th>
    </tr>
  </thead>
 
<?php $i=1;
$des = count($carbodypart);

?>

 @foreach($carbodypart as $key=>$carbodypart1)
<?php $j=1;

?>
<?php
$t=explode("_", $key);
$a=$t[0];
$s=$t[1];

?>
@if($s==1)
   <tr><td>
    <div class="row">
      <div class="col-md-6">
       <button type="button" class="btn btn-dark">DESIGN {{$des}}</button>
      </div>
      <div class="col-md-6">
    <a class="btn btn-primary" onclick="myFunction('{{base64_encode($a)}}')">Add to Cart</a>

  </div>
  </div>
  </td>

  </tr>
  
   @else
   <tr><td>
    <button type="button" class="btn btn-dark">DESIGN {{$des}}</button>
  </td>
  </tr>

   @endif

  @foreach($carbodypart1 as $key=>$carbodypart1)
 
  <tr>

 
     @if($key!=$key+1)

   
      <td>{{$j}}</td>

      <td>
        {{$carbodypart1->applicationid}}

      </td>

       @if($carbodypart1->carbodypart=='Car Body' && $carbodypart1->carpartid==0)
         <td>{{$carbodypart1->carbodypart}}</td>
       @else
       <td>{{$carbodypart1->parts}} ({{$carbodypart1->carbodypart}})</td>
       @endif
      

      <td>{{date('d-F-Y',strtotime($carbodypart1->created_at))}}</td>
      <td>
       @if($carbodypart1->status==1)Approved @elseif($carbodypart1->status==2)Rejected @else Pending @endif </td>
        <td>{{date('d-F-Y',strtotime($carbodypart1->updated_at))}}</td>
        @else

       <td>{{$j}}</td>
      <td>
        {{$carbodypart1->applicationid}}
      </td>

       @if($carbodypart1->carbodypart=='Car Body' && $carbodypart1->carpartid==0)
         <td>{{$carbodypart1->carbodypart}}</td>
       @else
       <td>{{$carbodypart1->parts}} ({{$carbodypart1->carbodypart}})</td>
       @endif
      

      <td>{{date('d-F-Y',strtotime($carbodypart1->created_at))}}</td>
      <td> @if($carbodypart1->status==1)Approved @elseif($carbodypart1->status==2)Rejected @else Pending @endif </td>
        <td>{{date('d-F-Y',strtotime($carbodypart1->updated_at))}}</td>
        @endif
 
        
        <td>{{$carbodypart1->remark}}</td>
        <td> 
        
         @if($carbodypart1->commentimage!="")
          <img height="100px" width="100px" src="{{url('Carimage/')}}/{{$carbodypart1->commentimage}}">
          @endif

        </td>
      

    </tr>


<?php $j=$j+1;

?>
  @endforeach
    <?php $i=$i+1;
 $des = $des-1; 
    ?>
     @endforeach
  
  </tbody>
</table>
</div>
</div>
   

<script type="text/javascript">
$(document).ready(function() {
    $('#myTable1').DataTable();
} );
</script>
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.16/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.16/dist/summernote-lite.min.js"></script>
<script type="text/javascript">
function myFunction(application)
{


  if (confirm("Do You Want Add New Item?")) {
    window.location.href = "{{url('addtocart')}}/"+application;
    
  } else {
    
  }
}  

</script>

</main>
@endsection

