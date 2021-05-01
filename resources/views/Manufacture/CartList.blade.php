@extends('layouts.student')
@section('contents')

<style>
    
/*#myform {*/
/*    text-align: center;*/
/*    padding: 5px;*/
/*    border: 1px dotted #ccc;*/
/*    margin: 2%;*/
/*}*/
.qty {
    width: 40px;
    height: 25px;
    text-align: center;
}
input.qtyplus { width:25px; height:25px;}
input.qtyminus { width:25px; height:25px;}






</style>
<main role="main">
       <div class="text-right">
                  <button type="button" onclick="goBack()" class="btn btn-info">Go Back</button>

                  <script>
              function goBack() {
                  window.history.back();
                      }
                 </script>
               </div>
     
    <section class="jumbotron text-center">
        <div class="container">
            <h3>{{$studentname}}</h3>

     </div>
                
    
  </section>

  <div class="album py-5 bg-light">
    <div class="container">
        <form method='post' action='{{url('cartdetails')}}'>
             {{ csrf_field() }}
             <input tpye='text' value="{{$id}}" name="studentid" hidden>
   <table class="table table-hover">
  <thead>
    <tr>
      <th scope="col">S.No</th>
      <th scope="col">Application Id</th>
      <th scope="col">Type</th>
      <th scope="col">Material</th>
        <th scope="col">Quantity</th> 
      <th scope="col">Unit Price</th>
      <th scope="col">Price</th>
    
      <th scope="col">Remove</th>
      <!--<th scope="col">Total</th>-->
      
   
    </tr>
  </thead>
  <tbody>
      <?php $i=0?>
      @if(count($body1)>0)
   @foreach($body1 as $arr1)
    <tr id="{{$arr1->id}}_r">
      <td>{{++$i}}</td>
      <td>{{$arr1->applicationid}}</td>
      <td>
         <input hidden type="text" class ="input-form" name='body[]' value="{{$arr1->id}}_a">
      {{$arr1->type}}
        </td>
        <td>
            <select class="form-control" name="{{$arr1->id}}_a_bodymet" onchange="meterialbody_{{$arr1->id}}(this.value)">
                <option value="">Select Material</option>
                @foreach($mate as $mate1)
                <option value="{{$mate1->id}}">{{$mate1->materialname}}</option>
              
                @endforeach
            </select>
            <script>
            // var i=0;
 function meterialbody_{{$arr1->id}}(meterialbody)
    {

          $('#quantity{{$arr1->id}}').val('1');
        
                        $.ajax({
						url:"{{url('meterialbodyprice')}}",
						method:'post',
						data:{'meterialidbodyid':meterialbody},
						beforeSend:function(){
					
						},
						success:function(data){
		
						     $('#{{$arr1->id}}_price').text(data);
						     $('#{{$arr1->id}}_unit').text(data);
          var sum=0;
    $(".yyyy").each(function(){
    //    sum += parseInt($(this).val()) || 0;
        
        sum += parseInt($(this).text())||0;
    });
      
       $(".total").text(sum);
							
						},
						headers: {
    'X-CSRF-TOKEN': '{{csrf_token()}}'
  },
						error:function(data){
							
							console.log(data);
						}
					});
    }
    </script>
        </td>
      
       
      <td> 
    <input type='button' value='-' class='qtyminus_{{$arr1->id}}' field='quantity{{$arr1->id}}_a' />
    <input type='text' id='quantity{{$arr1->id}}' name='quantity{{$arr1->id}}_a' value='1' class='qty' />
    <input type='button' value='+' class='qtyplus_{{$arr1->id}}' field='quantity{{$arr1->id}}_a' />
    
    <script>
    //   var total1=0;
jQuery(document).ready(function(){

    $('.qtyplus_{{$arr1->id}}').click(function(e){
    
        e.preventDefault();
      var sum = parseInt($("#{{$arr1->id}}_unit").text());
      
    $(".yyyy").each(function(){
    //    sum += parseInt($(this).val()) || 0;
        
        sum += parseInt($(this).text())||0;
    });
    
       $(".total").text(sum);
    // alert(sum);
        fieldName = $(this).attr('field');
    

        var currentVal = parseInt($('input[name='+fieldName+']').val());
     
      
        var price1= $('#{{$arr1->id}}_unit').text();
      
      
        $('#{{$arr1->id}}_price').text(((currentVal+1)*price1));
      
 
         var total1=$('#totalincr').text();
        
   
    
        if (!isNaN(currentVal)) {
            
       
            $('input[name='+fieldName+']').val(currentVal+1);
        } else {
    
            $('input[name='+fieldName+']').val(1);
        }
    });
    // This button will decrement the value till 0
    $(".qtyminus_{{$arr1->id}}").click(function(e) {
        // Stop acting like a button
        e.preventDefault();
  
        fieldName = $(this).attr('field');
        // Get its current value
        var currentVal = parseInt($('input[name='+fieldName+']').val());
        // alert(currentVal);
          var price1= $('#{{$arr1->id}}_price').text();
          var priceunit= $('#{{$arr1->id}}_unit').text();
         var total=$('#total').text();
         
        
        //   alert(total-priceunit);
         
        // If it isn't undefined or its greater than 0
        if (!isNaN(currentVal) && currentVal > 1) {
            // Decrement one
      
        
            var sum = parseInt($("#{{$arr1->id}}_unit").text());

    $(".yyyy").each(function(){
        
        sum += -$(this).text();
    });
    var sum1=-(sum);
        // Get the field name
        $(".total").text(sum1);
             $('#{{$arr1->id}}_price').text(price1-priceunit);
            $('input[name='+fieldName+']').val(currentVal-1);
        } else {
            // Otherwise put a 0 there
             
            $('input[name='+fieldName+']').val(1);
        }
    });
});

</script>
       </td>
        <td id="{{$arr1->id}}_unit"></td>
       <td class="yyyy" id="{{$arr1->id}}_price"></td>
     
      
      <td><button type="button"  class="btn btn-danger" onclick="removecart('{{$arr1->keys}}','{{$id}}')">Remove</td>
    
    </tr>
    
 @endforeach
 @endif
 
 <!--Card body Part -->

   @if(count($carbodypart)>0)
       @foreach($carbodypart as $arr1)
    
    <tr id="{{$arr1->id}}_r">
      <td>{{++$i}}</td>
      <td>{{$arr1->applicationid}}</td>
      <td>
          <input hidden type="text" class ="input-form" name='body[]' value="{{$arr1->id}}_b">
          {{$arr1->Partname}}
        </td>
        <td>
        <select class="form-control" name="{{$arr1->id}}_b_bodymet" onchange="meterialbodypart_{{$arr1->id}}(this.value)">
                <option value="">Select Part Meterial</option>
                @foreach($matpart as $matpart1)
                <option value="{{$matpart1->id}}">{{$matpart1->partmetarialName}}</option>
              
                @endforeach
            </select>

      <script>
                     
 function meterialbodypart_{{$arr1->id}}(meterialbodypart)
    {
    
   
          $('#quantitys'+meterialbodypart).val('1');
        
          $.ajax({
            url:"{{url('meterialbodypartprice')}}",
            method:'post',
            data:{'meterialidbodypartid':meterialbodypart},
            beforeSend:function(){
          
            },
            success:function(data){
             
             $('#{{$arr1->id}}_price1').text(data);
                 $('#{{$arr1->id}}_unit1').text(data);

                   $('#totalincr').text(data);
                  var totalbodypart1=$('#totalincr1').text();
                  $('#total').text(parseInt(data)+parseInt(totalbodypart1));
                       var sum = parseInt($("#"+meterialbodypart+"_unit1").text());

           var sum=0;
    $(".yyyy").each(function(){
    //    sum += parseInt($(this).val()) || 0;
        
        sum += parseInt($(this).text())||0;
    });
      
       $(".total").text(sum);

              
            },
            headers: {
    'X-CSRF-TOKEN': '{{csrf_token()}}'
  },
            error:function(data){
              
              console.log(data);
            }
          });
    }
    </script>
      
    
    
    </td>
      
       
      <td> 
       <input type='button' value='-' class='qtyminus{{$arr1->id}}' field='quantity{{$arr1->id}}_b' />
    <input type='text' name='quantity{{$arr1->id}}_b'  id='quantitys{{$arr1->id}}' value='1' class='qty' />
    <input type='button' value='+' class='qtyplus{{$arr1->id}}' field='quantity{{$arr1->id}}_b' />
    
    <script>
       var total1=0;
jQuery(document).ready(function(){
 
    $('.qtyplus{{$arr1->id}}').click(function(e){

        e.preventDefault();
 var sum = parseInt($("#{{$arr1->id}}_unit1").text());
      
    $(".yyyy").each(function(){
  
        
        sum += parseInt($(this).text())||0;
    });
    
       $(".total").text(sum);
        fieldName = $(this).attr('field');
    

        var currentVal = parseInt($('input[name='+fieldName+']').val())+1;
        var price1= $('#{{$arr1->id}}_unit1').text();
      
    
        $('#{{$arr1->id}}_price1').text((currentVal*price1));

        if (!isNaN(currentVal)) {
       
            $('input[name='+fieldName+']').val(currentVal);
        } else {
    
            $('input[name='+fieldName+']').val(1);
        }
    });
  
    $(".qtyminus{{$arr1->id}}").click(function(e) {
     
        e.preventDefault();
        
 
        // Get the field name
        fieldName = $(this).attr('field');
        // Get its current value
        var currentVal = parseInt($('input[name='+fieldName+']').val());
          var price1= $('#{{$arr1->id}}_price1').text();
          var priceunit= $('#{{$arr1->id}}_unit1').text();
  
        if (!isNaN(currentVal) && currentVal > 1) {
            // Decrement one
                
                       var sum = parseInt($("#{{$arr1->id}}_unit1").text());
    $(".yyyy").each(function(){
        
        sum += -$(this).text();
    });
    var sum1=-(sum);
// alert(sum);?
      $(".total").text(sum1);
                
            // $('#total').text(parseInt(total)-parseInt(priceunit));
             $('#{{$arr1->id}}_price1').text(price1-priceunit);
            $('input[name='+fieldName+']').val(currentVal-1);
        } else {
            // Otherwise put a 0 there
             
        $('input[name='+fieldName+']').val(1);
        }
    });
});

</script>
       </td>
       
       
       <td id="{{$arr1->id}}_unit1"></td>
        <td class="yyyy"  id="{{$arr1->id}}_price1"></td>
       <!--<td hidden id="totalincr">0</td>-->
      
      
      <td><button type="button" class="btn btn-danger" onclick="removecart('{{$arr1->keys}}','{{$id}}')">Remove</td>
    
    </tr>
    <?php $i=$i+1;?>
    @endforeach
@endif
<!--End Car body Part-->
  <tr>
      <td></td>
      <td></td>
      
      <td colspan="3"><div >Total </div></td>
      <td colspan="3"><div class="total" ></div></td>
  </tr>
  <tr>
      <td></td>
      <td></td>
   <td></td>
      <td></td>
      <td colspan="3"><button class="btn btn-success" type="submit">Checkout</button></td>
       <td></td>
      
      <td></td>
  </tr>
     </tbody>
</table>


     

      
      
      </form>
    </div>
    
    </div>


</main>
@endsection
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>


<script>
     var i=1;
   function addtocard(itemid_studentid)
   {
      
       

      $.ajax({
						url:"{{url('addcart')}}/"+itemid_studentid+"/"+i,
					  
						method:'GET',
						beforeSend:function(){
					
						},
						success:function(data){
						    i=i+1;
						    alert(data);
				
			//	alert(data);
							
						},
						headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  },
						error:function(data){
							
							console.log(data);
						}
					});
   }
    
    
     
    function removecart(remove,stid)
    {
            alert(remove);
            $.ajax({
            url:"{{url('removefromcartList')}}",
            method:'get',
            data:{'remove':remove,'stid':stid},
            beforeSend:function(){
          
            },
            success:function(data){
      location.reload();
      alert(data);

            },
            headers: {
    'X-CSRF-TOKEN': '{{csrf_token()}}'
  },
            error:function(data){
              
              console.log(data);
            }
          });
        // $('#'+remove).remove();
    }

</script>






