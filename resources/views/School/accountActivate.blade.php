



<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
	<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
	<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>

    <title>Album example · Bootstrap</title>



    <style>
    html,
body {
  height: 100%;
}

body {
  display: -ms-flexbox;
  display: flex;
  -ms-flex-align: center;
  align-items: center;
  padding-top: 40px;
  padding-bottom: 40px;
  background-color: #f5f5f5;
}
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
      }

      .buy_now{
      	background: #d62924 !important;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;

        }
      }
    </style>
    <!-- Custom styles for this template -->
    <link href="{{url('resources/assets/website/css/album.css')}}" rel="stylesheet">
  </head>

  <body>


<div class="container text-center">

  <img class="mb-4" src="{{url('resources/assets/website/img/logo.png')}}" alt="" width="260">
  <h1 class="h3 mb-3 font-weight-normal">Activation Fee </h1><br>


	 <div class="text-center">
	  	
	  	@if($data->status == 0)

	  	<a href="javascript:void(0)" class="btn btn-lg btn-danger buy_now" data-amount="100" data-email="{{$data->email}}" data-name="{{$data->school_name}}" data-schoolid="{{$schoolid}}" data-getid="{{base64_encode($schoolid)}}" data-school_name="{{$data->school_name}}"> Amount Payable | 100 </a> 

	  	@else

	  			<p class="text-success"> Your account activated successfully 
	  				<a href="{{url('/')}}"> Login account </a></p>

	  	@endif

	</div><br><br>

  	<p class="mt-5 mb-3 text-muted">&copy; F1 School 2019</p>

</div>




<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>

         var SITEURL = '{{URL::to('')}}';

         $.ajaxSetup({
           headers: {
               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
           }
         }); 

         $('.buy_now').click(function(e){

           var totalAmount = $(this).attr("data-amount");
           var school_id =  $(this).attr("data-schoolid");
           var school_name =  $(this).attr("data-name");
           var user_email =  $(this).attr("data-email");
           var user_getid =  $(this).attr("data-user_getid");

           var options = {
           "key": "rzp_test_Cr9ufbKsTwLJJW",
           "amount": (totalAmount*100), // 2000 paise = INR 20
           "name": school_name,
           "description": "Payment for account activation",
           "image": "http://localhost/angular_laravel/school_new/f1school/resources/assets/website/img/tos-logo.png",
           "handler": function (response){

                 $.ajax({
                   url: SITEURL + '/activateAccount',
                   type: 'post',
                   headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                   dataType: 'json',

                   data: {
                     razorpay_payment_id: response.razorpay_payment_id, 
                     totalAmount : totalAmount,
                     school_id : school_id,
                     user_email : user_email
                   }, 
                   success: function (msg) {
                      
                    console.log(msg);
                    window.location.href = SITEURL + 'activateCollege/'+user_getid;
                   }
               });
             
           },
          "prefill": {
               "contact": 'xxxxxxxxxx',
               "email":   user_email,
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

      </script>


</body>
</html>



  