@extends('layouts.student')
@section('contents')
<div class="justify-content-center" style="padding:25px 0;">
	<ul class="list-group list-group-horizontal-sm justify-content-center">
	  <li class="list-group-item list-group-item-success">Manage Cart</li>
	  <li class="list-group-item list-group-item-success">Add Detail</li>
	  <li class="list-group-item list-group-item-success">Payment</li>
	  <li class="list-group-item list-group-item-warning">Order</li>
	</ul>
</div>

<div class="container" style="margin:10% auto;">
<h1 class="text-center">Thank You</h1>
<p class="text-center">Your order has been successfully placed. <br>For reference you transaction ID is -  {{$invoice}}</p>

</div>
@endsection