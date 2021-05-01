@extends('layouts.student')
@section('contents')

<main role="main">

<div class="container"><br>  
       
  <div class="text-right">
    <button type="button" onclick="goBack()" class="btn btn-danger">Go Back</button>
     <script>
          function goBack() {window.history.back();}
    </script>
  </div>
  <div class="justify-content-center" style="padding:25px 0;">
	<ul class="list-group list-group-horizontal-sm justify-content-center">
	  <li class="list-group-item list-group-item-success">Manage Cart</li>
	  <li class="list-group-item list-group-item-warning">Add Detail</li>
	  <li class="list-group-item">Payment</li>
	  <li class="list-group-item">Order</li>
	</ul>
</div>

  <h2>Shipping Address</h2><hr>

  <form method="post" action="{{url('deliveryaddressalldetails')}}" >
  {{ csrf_field() }}


      <input type="hidden" class="form-control" id="appid" name="appid" value="{{$appid}}">
   
  <div class="row">

    <div class="col-sm-6">
      <div class="form-group">
      <label for="full">Full Name:</label>
      <input type="text" required class="form-control" id="fullName" name="fullName">
    </div>
    </div>

    <div class="col-sm-6">
      <div class="form-group">
      <label for="full">Mobile Number:</label>
      <input type="number" pattern="[789][0-9]{9}"  required="required" class="form-control" id="mobile" name="mobile"  title="Phone number with 7-9 and remaing 9 digit with 0-9">
      <span id="e_mobile" class="text-danger">
      </div>
    </div>

  </div><!--row end-->


  <div class="row">

    <div class="col-sm-6">
      <div class="form-group">
      <label for="full">Town/City: </label>
      <input type="text" required class="form-control" id="city" name="city">
    </div>
    </div>

    <div class="col-sm-6">
      <div class="form-group">
      <label for="full"> State:  </label>
      <input type="text" required class="form-control" id="State" name="State">
    </div>
    </div>

  </div><!--row end-->

  <div class="row">

    <div class="col-sm-6">
      <div class="form-group">
        <label for="full">Area, Colony, Street, Sector, Village: </label>
        <input type="text" required class="form-control" id="street" name="street">
    </div>
    </div>

    <div class="col-sm-6">
      <div class="form-group">
      <label for="full">Flat, House no., Building, Company, Apartment:</label>
      <input type="text" required class="form-control" id="address" name="address">
    </div>
    </div>

  </div><!--row end-->

  <div class="row">

   <div class="col-sm-6">
      <div class="form-group">
      <label for="full">Pincode:</label>
      <input type="number" required class="form-control" id="Pincode" name="Pincode">
       <span id="e_Pincode" class="text-danger">
    </div>
    </div>

    <div class="col-sm-6">
      <div class="form-group">
        <label for="full">Landmark e.g. near apollo hospital: </label>
        <input type="text" required class="form-control" id="street" name="street">
      </div>
    </div>

  </div><!--row end-->

  <!-- <div class="form-group">
    <label for="full"> Address Type:</label>
    <select class="form-control" name="addrestype" required>
      <option selected>Select an Address Type</option>
      <option value="Home(7am-9pm delivery)">Home(7am-9pm delivery)</option>
      <option value="Office/Commercial(10am-5pm delivery)">Office/Commercial(10am-5pm delivery)</option>
    </select>
  </div> -->
  <br>

  <div class="text-right">
   <button id="submit1" type="submit" class="btn btn-success">Delivery to this Address</button>
 </div>
    
  </form>
</div><!--container-->

</main><br><br>
<script type="text/javascript">
  
   $(document).ready(function (){

  // Mobile Validation For Single person
     $("#mobile").focusout(function () {
        if ($(this).val() === '') {
            $(this).css("border-color", "#FF0000");
            $('#submit1').attr('disabled', true);
            $("#e_mobile").text("* You have to enter your Mobile Number!");
        } else
        {
            var mobile = document.getElementById("mobile").value;
            var pattern = /^[5-9]\d{2}[2-9]\d{2}\d{4}$/;
            if (pattern.test(mobile)) {

                $(this).css({"border-color": "#2eb82e"});
                $('#submit1').attr('disabled', false);
                $("#e_mobile").text("");
            } else
            {

                $(this).css("border-color", "#FF0000");
                $('#submit1').attr('disabled', true);
                $("#e_mobile").text("Not a valid Mobile Number!");

            }
        }

    });

        $("#Pincode").focusout(function () {
        if ($(this).val() === '') {
            $(this).css("border-color", "#FF0000");
            $('#submit1').attr('disabled', true);
            $("#e_Pincode").text("* You have to enter your Pincode!");
        } else
        {
            var Pincode = document.getElementById("Pincode").value;
            var pattern = /^\d{6}$/;
            if (pattern.test(Pincode)) {

                $(this).css({"border-color": "#2eb82e"});
                $('#submit1').attr('disabled', false);
                $("#e_Pincode").text("");
            } else
            {

                $(this).css("border-color", "#FF0000");
                $('#submit1').attr('disabled', true);
                $("#e_Pincode").text("Not a valid Pincode!");

            }
        }

    });
// /End Mobile Validation/


// On submit start 
 $("#submit1").click(function () {
        if ($('#mobile').val() === '') {
            $(this).css("border-color", "#FF0000");
            $('#submit1').attr('disabled', true);
            $("#e_mobile").text("* You have to enter your Mobile Number!");
        } 

         if ($('#Pincode').val() === '') {
            $(this).css("border-color", "#FF0000");
            $('#submit1').attr('disabled', true);
            $("#e_Pincode").text("* You have to enter your Pincode!");
        } 
       
    });
// On submit end 
   });
</script>>
@endsection