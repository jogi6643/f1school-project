@extends('layouts.student')
@section('contents')

<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="csrf-token" content="{{ csrf_token() }}">
<main role="main">

<div class=" container text-right">
    <button type="button" onclick="goBack()" class="btn btn-sm btn-danger">Go Back</button>

    <script>
        function goBack() {window.history.back();}
    </script>
</div>
    <div class="justify-content-center" style="padding:25px 0;">
		<ul class="list-group list-group-horizontal-sm justify-content-center">
		  <li class="list-group-item list-group-item-warning">Manage Cart</li>
		  <li class="list-group-item list-group-item-warning">Add Detail</li>
		  <li class="list-group-item list-group-item-success">Payment</li>
		  <li class="list-group-item">Order</li>
		</ul>
    </div>          

<div class="container">

<div class="row">

  <div class="col-sm-12">

  <h3>Order Details</h3>  

  <table class="table table-hover">
    <thead>
    <th>S.No</th>
    <th hidden>Order Id</th>
    <th>Product</th> 
    
      <th>Material</th> 
       <th>Quantity</th>         
      
      <th>Total Price</th>
     
    </thead>
    <tbody>
  <?php
$i=1;

  ?>
      @foreach($productdetails as $productdetails2)
        <tr>
          <td>{{$i}}</td>
            <td hidden="">{{$productdetails2->orderid}}</td>
            <td>{{$productdetails2->productname}}</td>
            @if($productdetails2->materialname=='carbody')
            <td></td>
            @else
            <td>{{$productdetails2->materialname}}</td>
            @endif
            
            <td>{{$productdetails2->quantity}}</td>
         
            <td>{{$productdetails2->price}}</td>

        </tr>

      <?php $i=$i+1;?>
       @endforeach
    <tr>
          <td></td>
          <td></td>
           <td></td>
         
          
          <td>Manufacturing Cost</td>
          <td> {{$mt}}</td>
        </tr>

        <tr>
          <td></td>
          <td></td>
           <td></td>
         
          
          <td>Amout payable</td>
          <td> {{$totalprice+$mt}}</td>
        </tr>

    </tbody>
  </table>


  <button class="btn btn-danger float-right buy_now" data-amount="{{$totalprice+$mt}}" data-order-id="{{ $order_id }}" data-email="" data-name="{{ $studentName->name }}"> Place Order | {{$totalprice+$mt}} </button> 

  <div class="clearfix"> &nbsp; </div>
<br>
 <div>
        <h3>Shipping address</h3>
        <p>{{$orderidaddress->fullName}}</p>
        <p>{{$orderidaddress->mobile}}</p>
        <p>{{$orderidaddress->street." ".$orderidaddress->city." ".$orderidaddress->State." ".$orderidaddress->address}}</p>
       PinCode <p>{{$orderidaddress->pincode}}</p>
 </div>

 </div>



  </div>
  </div>


</main>
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>


<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>

         var SITEURL = '{{URL::to('')}}';
         $.ajaxSetup({
           headers: {
               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
           }
         }); 

         $('.buy_now').on('click', function(e){

           var totalAmount = '{{$totalprice+$mt}}';
           var order_id =  '{{ encrypt($order_id) }}';
           var user_name =  '{{$studentName->name}}';
       
           
          
           // var totalAmount = $(this).attr("data-amount");
           // var order_id =  $(this).attr("data-order-id");
           // var user_name =  $(this).attr("data-name");
           // var user_email =  $(this).attr("data-email");

           var options = {
           "key": "rzp_test_Cr9ufbKsTwLJJW",
           "amount": (totalAmount*100), // 2000 paise = INR 20
           "name": user_name,
           "razorpay_order_id":'kun123',
           "description": "Payment message",
           "image": "http://167.99.198.174/assets/website/img/tos-registered.png",
           "handler": function (response){
                 $.ajax({
                   url: SITEURL + '/paysuccess',
                   type: 'post',
                   headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                   dataType: 'json',

                   data: {
                     razorpay_payment_id: response.razorpay_payment_id, 
                     totalAmount : totalAmount,
                     order_id : order_id,
                   }, 
                   success: function (msg,data) {
                    $.ajax({
              
              url:"{{url('payment')}}",
              data:{_token: '{!! csrf_token() !!}','order_id' : order_id,'transaction_id':response.razorpay_payment_id},
              method:'POST',
              success:function(data){
               
               window.location.href = SITEURL + '/thankyou/'+order_id+'/'+response['razorpay_payment_id'];
            },

            error:function(data){
              alert(data);
              console.log(data);
            },

                         

                    







                    });
       
                     
                   },
                   
               });
             
           },
          "prefill": {
               "contact": 'xxxxxxxxxx'
               // "email":   user_email,
           },
           "notes":{
                "address": "note value"
            },
           "theme": {
               "color": "#528FF0"
           }
         };

         var rzp1 = new Razorpay(options);
         rzp1.open();
         e.preventDefault();
         });

         /*document.getElementsClass('buy_plan1').onclick = function(e){
           rzp1.open();
           e.preventDefault();
         }*/
      </script>

@endsection

