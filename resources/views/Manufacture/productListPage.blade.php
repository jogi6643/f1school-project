@extends('layouts.student')
@section('contents')

<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<main role="main">
    
    <div class="text-right">
    <button type="button" onclick="goBack()" class="btn btn-info">Go Back</button>

         <script>
              function goBack() {window.history.back();}
        </script>
    </div>

  <div class="container">
    
  <div class="card mb-3">
  <div class="row">
  
  <div class="col-md-4">
  <div class="card-body">

  <img class="card-img-top"  style="height:100px;width:100px;border-radius: 50%;" src="{{url('public/team/')}}/previewimg.png" alt="Card image cap">
  <h5 class="card-title">{{$studentname}}</h5>

</div>
</div>

<div class="col-md-8">
    <div class="card-body">
    <h5 class="card-title">{{$schoolname}}</h5>
    <p class="card-text">Description........</p>
   
  </div>
</div>

</div>
</div>
    
  <a href="{{url('item')}}/{{$studentid}}"><i class="fa fa-shopping-cart" style="font-size:36px"></i><span class="badge">{{\Cache::get($studentid)}}</span></a><br>
   <table class="table">
  <thead class="thead-dark">
    <tr>
      <th>S.No</th>
      <th>Application Id</th>
      <th>Type</th>
      <th>Applied On</th>
      <!--<th scope="col">Status</th>-->
      <th>Last Edited</th>
      <th> Add To Cart</th>
   
    </tr>
  </thead>
  <tbody>
      <?php $i=0;?>
      @foreach($carbody as $carbody1) 
      <?php 
      $itemid_studentid=$carbody1->id."_".$studentid;
      // $appid=$carbody1->applicationid;
   
      ?>
    <tr>
      <th scope="row">{{++$i}}</th>

      <th scope="row">{{$carbody1->applicationid}}</th>
      <td>{{$carbody1->type}}</td>
      <td>{{date('d-F-Y',strtotime($carbody1->created_at))}}</td>
      <!--<td> @if($carbody1->status==1)Approved @elseif($carbody1->status==2)Rejected @else Pending @endif </td>-->

      <td>{{date('d-F-Y',strtotime($carbody1->updated_at))}}</td>
      <td>
        <!-- <button type="button" class="btn btn-primary" onclick="addtocard('{{$itemid_studentid}}','{{$carbody1->applicationid}}')">Add to Cart
        </button> -->

        <a href="{{ url('addToCart', [$carbody1->id, $carbody1->applicationid]) }}"> Add To Cart </a>

      </td>
    
    </tr>
    @endforeach
    
    @foreach($cardpartbody as $carbodypart1)
    
    <?php $itemid_studentid=$carbodypart1->id."_".$studentid; ?>
    
      <tr>
      <th scope="row">{{++$i}}</th>
       <th scope="row">{{$carbodypart1->applicationid}}</th>
      <td>{{$carbodypart1->partname}}(Card Body Part)</td>
      <td>{{date('d-F-Y',strtotime($carbodypart1->created_at))}}</td>
      <!--<td> @if($carbodypart1->status==1)Approved @elseif($carbody1->status==2)Rejected @else Pending @endif </td>-->
        <td>{{date('d-F-Y',strtotime($carbodypart1->updated_at))}}</td>
      <td><button type="button" class="btn btn-primary" onclick="addtocard('{{$itemid_studentid}}','{{$carbody1->applicationid}}')">Add to Cart</button></td>
    
    </tr>
    
   @endforeach
   
  </tbody>
</table>


    </div>
  


</main>
@endsection
<script>
    //  var i=1;
   function addtocard(itemid_studentid,applicationid)
   {
      
 
      $.ajax({
            url:"{{url('addcart')}}/"+itemid_studentid+"/"+applicationid,
            
            method:'GET',
            beforeSend:function(){
          
            },
            success:function(data){
              
                console.log(data);

                $(".badge").text("{{\Cache::get($studentid)}}");

                  alert(data);
                },

            headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            error:function(data){
              
              console.log(data);
            }
          });
   }
    
    
</script>


<!-- 
https://webmobtuts.com/backend-development/creating-a-shopping-cart-with-laravel/ -->