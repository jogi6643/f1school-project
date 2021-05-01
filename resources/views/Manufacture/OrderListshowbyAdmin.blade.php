@extends(Auth::user()->role==2? 'layouts.coadmin':'layouts.admin')
@section('content')
 
             <div class="content-heading">
               <div>Order List
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
               </div>
 <table class="table table-hover table-striped" id="userlistid">
 	<thead>
 		<tr>
 			<th>#</th>
      <th>Order Id</th>

 			
         @if(Auth::user()->role==1)
         <th>Order Status</th>
        @else
        @if((session('data')[15]??0)==1&&(session('data')[18]??0)==1)
        <th>Order Status</th>
        @elseif((session('data')[18]??0)==1)
         <th>Order Status</th>
        @endif
        @endif
      <th>Transaction Id</th>
 			<th>Payment Status</th>
 		
 			<th>Order Date</th>
 		  <th>Delivery Date</th>
 		  <th>Order By</th>

 		</tr>
 	</thead>
 	<tbody>
 

   <?php $i=1;?>
    @foreach($orderlist as $orderlist1)
    <tr>
        <td>{{$i}}</td>
        <td><a href="{{url('orderiddetails')}}/{{base64_encode($orderlist1->order_id)}}">{{$orderlist1->order_id}}</a></td>
       


   @if(Auth::user()->role==1)
         <td><br><button type="button" data-toggle="modal" class="btn btn-sm btn-outline-success" data-target="#order_Id{{$orderlist1->order_id}}"><i class="fa fa-edit"></i> </button>

    <div class="modal fade" id="order_Id{{$orderlist1->order_id}}" role="dialog">
    <div style="margin-top: 60px;min-width: 576px" class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          
        </div>
        <div class="modal-body">
       <form method="post" action="{{url('orderstatusupdate')}}" >
             {{ csrf_field() }}
           <input hidden="" type="text" name="order_Id" value="{{$orderlist1->order_id}}">
          <select class="form-control" id="myselect" name="updatestatus">
          <option value="">select Status</option>
          <option value="Received">Received</option>
          <option value="Under Print">Under Print</option>
           <option value="Packed">Packed</option>
          <option value="Dispatched">Dispatched</option>
          <option value="Delivered">Delivered</option>
         </select>
        </div>
        <div class="modal-footer">
             <button type="submit" class="btn btn-success">updated</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </form>
      </div>
    </div>
  </div>
        </td>
        @else
        @if((session('data')[15]??0)==1&&(session('data')[18]??0)==1)
         <td><br><button type="button" data-toggle="modal" class="btn btn-sm btn-outline-success" data-target="#order_Id{{$orderlist1->order_id}}"><i class="fa fa-edit"></i> </button>

    <div class="modal fade" id="order_Id{{$orderlist1->order_id}}" role="dialog">
    <div style="margin-top: 60px;min-width: 576px" class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          
        </div>
        <div class="modal-body">
       <form method="post" action="{{url('orderstatusupdate')}}" >
             {{ csrf_field() }}
           <input hidden="" type="text" name="order_Id" value="{{$orderlist1->order_id}}">
          <select class="form-control" id="myselect" name="updatestatus">
          <option value="">select Status</option>
          <option value="Received">Received</option>
          <option value="Under Print">Under Print</option>
           <option value="Packed">Packed</option>
          <option value="Dispatched">Dispatched</option>
          <option value="Delivered">Delivered</option>
         </select>
        </div>
        <div class="modal-footer">
             <button type="submit" class="btn btn-success">updated</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </form>
      </div>
    </div>
  </div>
        </td>
        @elseif((session('data')[18]??0)==1)
          <td><br><button type="button" data-toggle="modal" class="btn btn-sm btn-outline-success" data-target="#order_Id{{$orderlist1->order_id}}"><i class="fa fa-edit"></i> </button>

    <div class="modal fade" id="order_Id{{$orderlist1->order_id}}" role="dialog">
    <div style="margin-top: 60px;min-width: 576px" class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          
        </div>
        <div class="modal-body">
       <form method="post" action="{{url('orderstatusupdate')}}" >
             {{ csrf_field() }}
           <input hidden="" type="text" name="order_Id" value="{{$orderlist1->order_id}}">
          <select class="form-control" id="myselect" name="updatestatus">
          <option value="">select Status</option>
          <option value="Received">Received</option>
          <option value="Under Print">Under Print</option>
           <option value="Packed">Packed</option>
          <option value="Dispatched">Dispatched</option>
          <option value="Delivered">Delivered</option>
         </select>
        </div>
        <div class="modal-footer">
             <button type="submit" class="btn btn-success">updated</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </form>
      </div>
    </div>
  </div>
        </td>
        @endif
        @endif


        
        <td>{{$orderlist1->transaction_id}}</td>
        <td>{{$orderlist1->status}}</td>
        <td>{{date('d-F-Y',strtotime($orderlist1->created_at))}}</td>
        <th>{{date('d-F-Y',strtotime($orderlist1->updated_at))}}</th>
        <td><a href="{{url('order-by')}}/{{base64_encode($orderlist1->order_id)}}">{{$orderlist1->fullName}}</a></td>
          </tr>
          <?php $i=$i+1;?>
       @endforeach
 	
 	
 	</tbody>
 </table>




@endsection

@section('header')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
@endsection

@section('footer')
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
 <script type="text/javascript">
 	$(document).ready(function(){
 		$('#userlistid').DataTable();
 	});

   function myfuntemp(arg) {
      var ad=$(arg).attr('id');
      var ak=ad.split('-');
      
      if(confirm("Do you really want to delete this."))
         window.location.href='{{url("/schooldel")}}/'+btoa(ak[1]);
     
   }
 </script>
@endsection