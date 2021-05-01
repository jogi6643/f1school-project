<html>
<head>
 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

<style>
.invoice-title h2, .invoice-title h3 {
    display: inline-block;
}

.table > tbody > tr > .no-line {
    border-top: none;
}

.table > thead > tr > .no-line {
    border-bottom: none;
}

.table > tbody > tr > .thick-line {
    border-top: 2px solid;
}
</style>
</head>
<div class="container">
    <div class="row">
       
    		<div class="col-md-6">
    			<span>Order Id  # {{$invoice}}</span>
    		</div>
			<div class="col-md-6">
    			<p><span>Name : {{$student->name}}</span></p>
				<p><span>Email : {{$student->studentemail}}</span></p>
				<p><span>Email : {{$student->studentemail}}</span></p>
    		</div>
    		<hr>
    	
    </div>
    
    <div class="row">
    	<div class="col-md-12">
    		<div class="panel panel-default">
    			<div class="panel-heading">
    				<h3 class="panel-title"><strong>Order summary</strong></h3>
    			</div>
    			<div class="panel-body">
    				<div class="table-responsive">
    					<table class="table table-condensed">
    						<thead>
                                <tr>
        							<td><strong>Item</strong></td>
        							
									<td class="text-right"><strong>Material</strong></td>
        							<td class="text-center"><strong>Quantity</strong></td>
									<td class="text-center"><strong>Price</strong></td>
        							
                                </tr>
    						</thead>
    						<tbody>
    							<!-- foreach ($order->lineItems as $line) or some such thing here -->
								@foreach($orderdetails as $key=>$order)
    							<tr>
    								<td>BS-200</td>
    								<td class="text-center">{{$order->productname}}</td>
    								<td class="text-center">{{$order->quantity}}</td>
    								<td class="text-right">{{$order->price}}</td>
    							</tr>
                               @endforeach
							   <tr>
    								<td class="no-line"></td>
    								<td class="no-line"></td>
    								<td class="no-line text-center"><strong>Manufacturing Cost</strong></td>
    								<td class="no-line text-right">{{$man_cost}}</td>
    							</tr>
    							<tr>
    								<td class="no-line"></td>
    								<td class="no-line"></td>
    								<td class="no-line text-center"><strong>Total</strong></td>
    								<td class="no-line text-right"><?= $totalprice+$man_cost;?></td>
    							</tr>
    						</tbody>
    					</table>
    				</div>
    			</div>
    		</div>
    	</div>
    </div>
</div>