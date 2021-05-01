@extends('layouts.student')
@section('contents')

<!-- <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> -->
<!------ Include the above in your HEAD tag ---------->

<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">

<style type="text/css">
  
  /*
** Style Simple Ecommerce Theme for Bootstrap 4
** Created by T-PHP https://t-php.fr/43-theme-ecommerce-bootstrap-4.html
*/
.bloc_left_price {
    color: #c01508;
    text-align: center;
    font-weight: bold;
    font-size: 150%;
}
.category_block li:hover {
    background-color: #007bff;
}
.category_block li:hover a {
    color: #ffffff;
}
.category_block li a {
    color: #343a40;
}
.add_to_cart_block .price {
    color: #c01508;
    text-align: center;
    font-weight: bold;
    font-size: 200%;
    margin-bottom: 0;
}
.add_to_cart_block .price_discounted {
    color: #343a40;
    text-align: center;
    text-decoration: line-through;
    font-size: 140%;
}
.product_rassurance {
    padding: 10px;
    margin-top: 15px;
    background: #ffffff;
    border: 1px solid #6c757d;
    color: #6c757d;
}
.product_rassurance .list-inline {
    margin-bottom: 0;
    text-transform: uppercase;
    text-align: center;
}
.product_rassurance .list-inline li:hover {
    color: #343a40;
}
.reviews_product .fa-star {
    color: gold;
}
.pagination {
    margin-top: 20px;
}
footer {
    background: #343a40;
    padding: 40px;
}
footer a {
    color: #f8f9fa!important
}

</style>
<?php $apps;?>

    <div class="container">
 <div class="card">
    @if($plan!='N/A')
  <div class="card-header text-center">

  
  </div>
  <div class="justify-content-center" style="padding:25px 0;">
		<ul class="list-group list-group-horizontal-sm justify-content-center">
		  <li class="list-group-item list-group-item-success">Manage Cart</li>
		  <li class="list-group-item">Add Shipping Address</li>
		  <li class="list-group-item">Choose Payment Mode</li>
		  <li class="list-group-item">Review Order</li>
		</ul>
</div>
  <div class="card-body">
    <h5 class="card-title"></h5>
    <div class="card-text text-center">
            @if($plan->level==1)
             <p>Blocks Assigned To:Individual</p>
             <p>Available Blocks:{{$av}}</p> 

             @else
               <p>Blocks Assigned To:Team</p>
               <p>Available Blocks:{{$av}}</p> 
             @endif   

              <p>Block Price:{{$plan->block_price}}</p> 
              </div>   
              @else
              <h3>N/A</h3>
              @endif 
    </div>
	<div class="col-sm-12 col-md-6 text-right">
                    <a href="{{url('removemanufactureitem')}}">Remove Item</a>
                </div>
 
  </div>
</div>
        
            

</div>         
  </div>

<div class="container mb-4">
    <div class="row">
        <div class="col-12">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                           
                            <th scope="col">Product</th>
                            <th scope="col">Material</th>
                        
                            <th scope="col" class="text-center">Quantity</th>
                            <th scope="col" class="text-right">Price</th>
                           
                        </tr>
                    </thead>
                    <tbody>
    <form  method="post" action="{{url('cartsave')}}" enctype="multipart/form-data">
   @csrf
       .<input type="hidden" name="applicationid" value="{{$appid}}">
                      @foreach($apps as $key=>$items)
                       @foreach($items as $key=>$items1)
                      @if($items1->carpartid==0)
                        <tr>
                        
                            <td>
                              {{$items1->parts}} Car Body
                              <input hidden="" type="text" name='partid[]' value="{{$items1->carpartid}}">
                            </td>
                            <td>   
                               <select hidden="" name='mat[]' class="form-control"  id="mat_{{$items1->carpartid}}">
                                <option value="0">
                                0
                                </option>
                            
                           
                                </select>
                              
                            </td>
                            <td>
                         <select name='quant[]' class="form-control" onchange="materialchange({{$items1->carpartid}},2)" id="qua_{{$items1->carpartid}}">

								                @for($i=0;$i<=50;$i++)
                                <option value="{{$i}}">{{$i}}</option>
                               @endfor
                                </select>
                              
                            </td>
                            <td class="text-right price_part" id="price_{{$items1->carpartid}}">
                            
                               0 
                          </td>
                          
                              <td> <input hidden="" id="price_i{{$items1->carpartid}}" type="text" name='prrice[]' value=""></td>

                                   </tr>
                        @else
                           <tr>
                           
                            <td>
                              {{$items1->parts}}
                            <input hidden="" type="text" name='partid[]' value="{{$items1->carpartid}}">
                            </td>
                            <td>
                              
                                
                              @foreach($part as $keys=> $materilas)
                              @if($key==$keys)
                               <select name='mat[]' class="form-control" onchange="materialchange({{$items1->carpartid}},1)" id="mat_{{$items1->carpartid}}">
                                <option>--Select Material--</option>
                               @foreach($materilas['meterial'] as $m1)
                             
                                <option value="{{$m1->material_id}}">
                                  {{$m1->matnname}}
                                </option>
                            
                              @endforeach
                                </select>
                                @endif

                              @endforeach
                              
                              
                            </td>

                             <td>
                               <select name='quant[]' class="form-control" onchange="materialchange({{$items1->carpartid}},1)" id="qua_{{$items1->carpartid}}">
                                <option value="0">0</option>
                                @for($i=1;$i<=50;$i++)
                                <option value="{{$i}}">{{$i}}</option>
                               @endfor
                         
                                </select>
                              
                            </td>

                            <!-- <td><input class="form-control" type="text" id="qua_{{$items1->carpartid}}" value="1" /></td> -->
                           <td class="text-right price_part" id="price_{{$items1->carpartid}}">0
                           
                           </td>
                           <td> <input hidden="" id="price_i{{$items1->carpartid}}" type="text" name='prrice[]' value=""></td>
                                </tr>
                        @endif
                        @endforeach
                        @endforeach
                       
                        <tr>
                         
                           
                            <td></td>
                            <td></td>
                            <td>Manufacture Cost</td>
                            <td class="text-right1">0</td>
                        </tr>
						 <tr>
                         
                            
                            <td></td>
                            <td></td>
                            <td>Sub-Total</td>
                            <td class="text-right" id="subtotal">@if($av==0) {{$plan->block_price}} @endif</td>
                        </tr>
                        <tr>
                         
                           
                            <td></td>
                            <td></td>
                            <td><strong>Total</strong></td>
                            <td  hidden class="text-right10" id="total10"><strong>@if($av==0)<?= $plan->manufacturing_cost+$plan->block_price; ?> @else <?= $plan->manufacturing_cost; ?> @endif</strong></td>
                            <td   class="text-right" id="total">0</strong></td>
                        
						</tr>
                    </tbody>

             
                </table>
            </div>
        </div>
        <div class="col mb-2">
            <div class="row">
                <div class="col-sm-12  col-md-6">
                   
                </div>
                <div class="col-sm-12 col-md-6 text-right">
                    <button type="submit" class="btn btn-lg btn-block btn-success text-uppercase">Checkout</button>
                </div>
            </div>
        </div>

             </form>
    </div>
</div>

<script>
  function materialchange(id,from)
  {

if(from==1)
{
	
    var productid = id;
    var materialid=$("#mat_"+id).val();
    var materialquan=$("#qua_"+id).val();
	

  $.ajax({
    // url:"{{url('payment')}}"
      url:"{{url('materialperice')}}",
      method:"POST",
      data:{'productid':productid,'materialid':materialid,'materialquan':materialquan,'from':from, _token: '{!! csrf_token() !!}'
    },
      dataType:"json",
      success:function(data)
      {
		  
         $("#price_"+productid).html(data);
         $("#price_i"+productid).val(data);
         var sum=0;
         $(".price_part").each(function(){
        sum += parseInt($(this).text())||0;
    });
       $("#subtotal").text(sum);
     
       if(typeof $("#qua_0").val()=="undefined")
       {
             var qu=0;
       }
       else
       {
var qu=$("#qua_0").val();
       }
	   // alert(parseInt({{$plan->manufacturing_cost}}*$("#qua_0").val()));
      $("#total").text(parseInt({{$plan->manufacturing_cost}}*qu)+parseInt(sum));
      }
      ,
      error:function(data)
      {

      }
    
    });

}
else
{
	
   var productid=id;
    var materialid=$("#mat_"+id).val();
    var materialquan=$("#qua_"+id).val();
    var plan={{$av}};
    var quan=plan-materialquan;
    if(quan<0)
    {

        materialquan=Math.abs(quan);
   
    
  $.ajax({
      url:"{{url('materialperice')}}",
      method:"POST",
      data:{'productid':productid,'materialid':materialid,'materialquan':materialquan,'from':from, _token: '{!! csrf_token() !!}'
    },
      dataType:"json",
      success:function(data)
      { 

		$(".text-right1").html({{$plan->manufacturing_cost}}*$("#qua_0").val());  
        $("#price_"+productid).html(data);
         $("#price_i"+productid).val(data);
        var sum=0;

         $(".price_part").each(function(){
        sum += parseInt($(this).text())||0;
    });
       $("#subtotal").text(sum);
	   
          $("#total").text(parseInt({{$plan->manufacturing_cost}}*$("#qua_0").val())+sum);
      }
      ,
      error:function(data)
      {

      }
    
    });
}
else
{
  
    $("#price_"+productid).html(0);
	$(".text-right1").html({{$plan->manufacturing_cost}}*materialquan);
	  var sum=0;
         $(".price_part").each(function(){
        sum += parseInt($(this).text())||0;
    });
	 $("#subtotal").text(sum);
	  $("#total").text(parseInt({{$plan->manufacturing_cost}}*$("#qua_0").val())+sum);
}


}
 


  }





</script>
@endsection