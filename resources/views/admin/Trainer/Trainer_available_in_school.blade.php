@extends(Auth::user()->role==2? 'layouts.coadmin':'layouts.admin')
@section('content')
 
             <div class="content-heading">
               <div>{{$school_name}}::Trainer Details
              
                  <small data-localize="dashboard.WELCOME"></small>
               </div>
            </div>

            @if($errors->any())
               @foreach($errors->all() as $err)
                  <div class="alert alert-danger">{{$err}}</div>
               @endforeach
            @endif
                     @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
 <table class="table table-hover table-striped" id="userlistid">
  <thead>
    <tr>
      <th>#</th>
      <th>Trainer Name</th>
      <th>Phone No</th>
      <th>Email</th>
      <th>Academic Year</th>
      <th>Status</th>   
    </tr>
  </thead>
  <tbody>
    @if(count($trainer)>0)
    <?php $i=1;?>
    @foreach($trainer as $k)
  
    <tr>
      <td>{{$i}}</td> 
      <td> {{$k->name}}</td>
      <td> {{$k->phone}}</td>
      <td>{{$k->email}} </td>
      <td>{{$k->year}}</td>      
      <td>@if($k->status==1) Active @else Inactive @endif</td>
    </tr>
    <?php $i=$i+1; ?>
    @endforeach
      @endif

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
      // alert('val = '+ak[1]);
      if(confirm("Do you really want to delete this."))
         window.location.href='{{url("/schooldel")}}/'+btoa(ak[1]);
         // alert("yes");
   }

   function myfuninvite(arg){
    var id   = $(arg).attr("id");
    var name= $(arg).attr("tname");
    var email= $(arg).attr("temail");
      $.ajax({
        url:"{{url('taineremailpasswordreset')}}",
        method:"POST",
        data:{id:id,name:name,email:email,_token: '{{csrf_token()}}'},
         beforeSend: function() {
           $('#myModal').modal('show'); 
           $('#sendingmessage').text('Sending Email ..');
         },
        success:function(data)
        {  
          $('#sendingmessage').text('Email  sent successfully.');
          //$('#myModal').modal('hide');
             location.reload(); 
           setTimeout(function(){
              $('#myModal').modal('hide')
            }, 2000);
        
        }
      });    
    }
 </script>
  <style >
 .modal-dialog {
  margin-top: 0;
  margin-bottom: 0;
  height: 100vh;
  display: flex;
  flex-direction: column;
  justify-content: center;
}
 </style>
@endsection
<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content" style="background-color: red; color: white;">
      <div class="modal-body">
        <h1 id='sendingmessage' class="text-center"></h1>
      </div>
     
    </div>

  </div>
</div>