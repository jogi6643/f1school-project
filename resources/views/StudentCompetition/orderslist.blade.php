@extends('layouts.student')
@section('contents')




            @if($errors->any())
               @foreach($errors->all() as $err)
                  <div class="alert alert-danger">{{$err}}</div>
               @endforeach
            @endif
            @if(session()->has('success'))
               <div class="alert alert-info">{{session()->get('success')}}</div>
            @endif
                       <div class="text-right">
                           
                           <button type="button" onclick="goBack()" class="btn btn-info">Go Back</button>
                         </div>
                       
<script>
function goBack() {
  window.history.back();
}
</script>
<div class="container">
  
    <div class="card bg-info">
      <div class="card-body text-center">
        <p class="card-text" style="color: white;">ORDER DETAILS</p>
      </div>
    </div>
  
</div>
<br>



<div class="container">
 

  <div class="row">
    <div class="col-md-6">

        <table class="table table-dark" id="userlistid">
    <thead>
   
    </thead>
    <tbody>
        <?php $i=1;
        ?>
         @foreach($orderdetails as $orderdetailsbyAdmin1)
        <tr>
            <th colspan="2" class="alert alert-info text-center">Product  Details {{$i}} /{{count($orderdetails)}}</th>
        </tr>
     
     
         <tr>
                <th>Order Id</th>
                <td>{{$orderdetailsbyAdmin1->orderid}}</td>
      </tr>
      <tr>
        <td>DESIGN ID</td>
        <td>{{$orderdetailsbyAdmin1->applicationid}}</td>
      </tr>
        
        
        @if($orderdetailsbyAdmin1->product==0 && $orderdetailsbyAdmin1->mat_id==0)
          <tr>
       <th>Product</th> <td>{{$orderdetailsbyAdmin1->productname}}</td>
       </tr>
       @else
          <tr>
       <th>Product</th> <td>{{$orderdetailsbyAdmin1->productname}}</td>
       </tr>

          <tr>
       <th>material</th> <td>{{$orderdetailsbyAdmin1->materialname}}</td>
       </tr>
       @endif



        <tr>
       <th>Quantity</th> <td>{{$orderdetailsbyAdmin1->quantity}}</td>
       </tr>
       <tr>
           <th>Price</th> <td>{{$orderdetailsbyAdmin1->price}}</td>
           </tr>
         
      
      <?php $i=$i+1;?>
      @endforeach
      @if($pay!='N/A')
   <tr  class="alert alert-info">
            <th>Manufacture Cost</th>
            <th>{{$mancost}}</th>
            
            
          
</tr>
   <tr  class="alert alert-info">
            <th>Total</th>
            <th>{{$mancost1}}</th>
            
            
          
</tr>
@endif
    </tbody>
  </table>
        
        
    </div>



    <div class="col-md-6">
   
     <table class="table table-dark">
    <thead>
   
    </thead>
    @if($pay!='N/A')
    <tbody>
          <th colspan="2" class="alert alert-info text-center">Shipping Address</th>
        <td>{{$shipingAddress->fullName.",".$shipingAddress->mobile.",".$shipingAddress->address.",".$shipingAddress->street.",".$shipingAddress->city.",".$shipingAddress->State.",".$shipingAddress->addrestype.",".$shipingAddress->pincode}}</td>
    </tbody>
    @endif
@if($pay!='N/A')
@if($pays!='N/A')
        <tbody>
     <th colspan="2" class="alert alert-info text-center">Team Name</th>
     <td><a style="color: white" class="btn btn-info" href="#">{{$teaminfo->team_Name}}</a></td>
    </tbody>

         <tbody>
     <th colspan="2" class="alert alert-info text-center">School Name</th>
     <td><a style="color: white" class="btn btn-info" href="#">{{$school->school_name}}</a></td>
    </tbody>

     <tbody>
     <th colspan="12" class="alert alert-info text-center">Payment</th>
     
    </tbody>
         <tbody>
          
     <th colspan="2" class="alert alert-info text-center">Transaction Id</th>
     <td>{{$pays->transaction_id}}</td>
    </tbody>

   <tbody>
     <th colspan="2" class="alert alert-info text-center">Mode</th>
     <td>{{$pays->mode}}</td>
    </tbody>

       <tbody>
     <th colspan="2" class="alert alert-info text-center">Transaction Date</th>
     <td>{{date("d-m-Y",strtotime($pays->updated_at))}}</td>
    </tbody>

      <div class="col-md-6">

        <table class="table table-dark">
    <thead>
      <tr>
       
      </tr>
    </thead>
      <tr>
            <th colspan="2" class="alert alert-info text-center">User Profile</th>
        </tr>
      <tr>
                <th>name</th>
                <td>{{$student->name}}</td>
      </tr>
      <tr>
        <th>User MailId</th>
        <td>{{$student->studentemail}}</td>
        </tr>
        <tr>
       <th>Mobile No.</th> <td>{{$student->mobileno}}</td>
       </tr>
       <tr>
           <th>Address</th> <td>{{$student->address}}</td>
           </tr>
           <tr>
               <th>Created at</th>
             
         <td>{{date('D-F-Y',strtotime($student->created_at))}}</td>
         </tr>
         <tr>
             <th>Updated at</th>
        <td>{{date('D-F-Y',strtotime($student->updated_at))}}</td>
      </tr>


    </tbody>

</table>
@endif
      @endif  
        
    </div>
    </table>
        </div>

  </div>

  
</div>

    
@endsection 