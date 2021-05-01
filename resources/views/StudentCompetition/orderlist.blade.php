@extends('layouts.student')
@section('contents')

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
<div class="bg3">
  <div class="container">


<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{url('')}}">Home</a></li>
    <li class="breadcrumb-item active" aria-current="page">Order List</li>
  </ol>
</nav>
    <div class="row">
<!--Order Status-->
        <div class="cards">
          <div class="cards_title">
            <span><img src="{{url('assets1/img/update-ico.png')}}" width="100%"></span>Order List</span>
          </div>
           @if(count($order)>0)
          <div class="table_red_border" style="margin-top: 25px;">
             <table class="table table-borderless text-center" id="myTable">
    <thead>
      <tr>
        <th>S.NO</th>
        <th>Order ID</th>
        <th>Order By</th>
        <th>Team Name</th>
        <th>Transaction Id</th>
        <th>Payment Mode</th>
     <th>Amount</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody>
      @if(count($order)>0)
      <?php $i=1;?>
      @foreach($order as $order1)
      <tr>
        <td>{{$i}}</td>
         <td><a href="{{url('ordersdetails')}}/{{encrypt($order1->order_id)}}">{{$order1->order_id}}</a></td>
         <td>{{$order1->studentname}}</td>
         <td>{{$order1->teamname}}</td>
         <td>{{$order1->transaction_id}}</td>
         <td>{{$order1->mode}}</td>
         <td>{{$order1->amount}}</td>
         <td>@if($order1->transaction_id=="") Failed @else Success @endif</td>
      </tr>
      <?php $i=$i+1;?>
      @endforeach

      @else
      <tr>
        <td>NO Data available</td>
      </tr>
      @endif
    </tbody>
  </table>
             </div>
            @else
            No Order Yet.
            @endif
         
        </div>
        <!--Order Status END-->
      </div>
    </div>
  </div>


<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
<script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>

 <script type="text/javascript">
$(document).ready( function () {
    $('#myTable').DataTable();
} );
</script>
@endsection 

