@extends(Auth::user()->role==2? 'layouts.coadmin':'layouts.admin')
@section('content')
 
             <div class="content-heading">
               <div>Order Details
                  <small data-localize="dashboard.WELCOME"></small>
               </div>
               
               <!-- START Language list-->
               <div class="ml-auto">
                  <div class="btn-group">
                  
                  </div>
               </div>
               <!-- END Language list-->
            </div>

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

<script>
function goBack() {
  window.history.back();
}
</script>
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
        
        
        @if($orderdetailsbyAdmin1->product==0 && $orderdetailsbyAdmin1->mat_id==0)
          <tr>
       <th>Product</th> <td><a href="{{url('Carimage')}}/{{$orderdetailsbyAdmin1->file}}">{{$orderdetailsbyAdmin1->productname}}</a></td>
       </tr>
       @else
          <tr>
       <th>Product</th> <td><a href="{{url('Carimage')}}/{{$orderdetailsbyAdmin1->file}}">{{$orderdetailsbyAdmin1->productname}}</a></td>
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
   <tr  class="alert alert-info">
            <th>Manufacture Cost</th>
            @if(isset($mancost))
            <th>{{$mancost}}</th>
            @else
             <th>N/A</th>
            @endif

            
          
</tr>
   <tr  class="alert alert-info">
            <th>Total</th>
            @if(isset($mancost1))
            <th>{{$mancost1}}</th>
            @else
            <th>N/A</th>
            @endif
            
          
</tr>
    </tbody>
  </table>
        
        
    </div>
    <div class="col-md-6">
     <table class="table table-dark">
    <thead>
   
    </thead>
    <tbody>
      <th colspan="2" class="alert alert-info text-center">Shipping Address</th>
      @if(isset($shipingAddress))
        <td>{{$shipingAddress->fullName.",".$shipingAddress->mobile.",".$shipingAddress->address.",".$shipingAddress->street.",".$shipingAddress->city.",".$shipingAddress->State.",".$shipingAddress->addrestype.",".$shipingAddress->pincode}}</td>
        @else
        <td>N/A</td>
        @endif
    </tbody>
      @if(isset($teaminfo->id))

        <tbody>
     <th colspan="2" class="alert alert-info text-center">Team Name</th>
     <td><a style="color: white" class="btn btn-info" href="{{url('viewteampage')}}/{{base64_encode($teaminfo->id)}}">{{$teaminfo->team_Name}}</a></td>
    </tbody>
  @endif
         <tbody>
   @if(isset($pays))
     <th colspan="2" class="alert alert-info text-center">School Name</th>
     <td><a style="color: white" class="btn btn-info" href="{{url('schoolv')}}/{{base64_encode($school->id)}}">{{$school->school_name}}</a></td>
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
             
         <td>{{date('d-m-Y',strtotime($student->created_at))}}</td>
         </tr>
         <tr>
             <th>Updated at</th>
        <td>{{date('d-m-Y',strtotime($student->updated_at))}}</td>
      </tr>

@endif
    </tbody>

</table>
        
        
    </div>
    </table>
        </div>

  </div>

  
</div>
    

  





@endsection

@section('header')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
@endsection

@section('footer')
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
 <script type="text/javascript">
//    $(document).ready(function(){
//      $('#userlistid').DataTable();
//    });

   function myfuntemp(arg) {
      var ad=$(arg).attr('id');
      var ak=ad.split('-');
      // alert('val = '+ak[1]);
      if(confirm("Do you really want to delete this."))
         window.location.href='{{url("/schooldel")}}/'+btoa(ak[1]);
         // alert("yes");
   }
 </script>
@endsection