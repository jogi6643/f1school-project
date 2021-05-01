@extends(Auth::user()->role==2? 'layouts.coadmin':'layouts.admin')
@section('content')
 
             <div class="content-heading">
               <div>Trainer Master
              
                  <small data-localize="dashboard.WELCOME"></small>
               </div>
			    @if(Auth::user()->role==1)
				   <div class="ml-auto">
                  <div class="btn-group">
                     <a href="{{url('trainercreate')}}" class="btn btn-warning">Create</a>
                
                  </div>
               </div>
				@else
				 @if((session('data')[8]??0)==1)
						  <div class="ml-auto">
                  <div class="btn-group">
                     <a href="{{url('trainercreate')}}" class="btn btn-warning">Create</a>
                
                  </div>
               </div>
				   @endif
				@endif
	   
               <!-- START Language list-->
              
               <!-- END Language list-->
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
      <th>Image</th>
      <th>Trainer Name</th>
      <th>Phone No</th>
      <th>Email</th>
      <th>Status</th>
      @if(Auth::user()->role==1)
      <th>Assigned School</th>
      @else
      @if((session('data')[8]??0)==1)
      <th>Assigned School</th>
      @endif
      @endif

      @if(Auth::user()->role==1)
      <th>Invite</th>
      @else
       @if((session('data')[8]??0)==1&&(session('data')[16]??0)==1)
        <th>Invite</th>
        @elseif((session('data')[16]??0)==1)
         <th>Invite</th>
      @endif
      @endif

      <th>Added by</th>
        <th>Created At</th>
        <th>Last Modified</th>
		 @if(Auth::user()->role==1)
				  <th>Action</th>
		@else
			@if((session('data')[8]??0)==1)
					 <th>Action</th>
		 @endif
		@endif
            
     
    
         
    </tr>
  </thead>
  <tbody>
   @if(isset($eq))
    @if(count($eq)>0)
    <?php $i=1;?>
    @foreach($eq as $k)
  
    <tr>
      
      <td>{{$i}}</td>
      <td>
      <div class="form-group">
              @if($k->pimage==null)
             <img style="border-radius: 50%" src="{{ URL::to('/') }}/trainerprofile/trainer.png" alt="trainer" width="50" height="50">
             @else
              <img style="border-radius: 50%" src="{{ URL::to('/') }}/trainerprofile/{{$k->pimage}}" alt="trainer" width="50" height="50">
             @endif
      </div>
      </td> 
      <td> {{$k->name}}</td>
      <td> {{$k->phone}}</td>
      <td>{{$k->email}} </td>    
      <td>@if($k->status==1) Active @else Inactive @endif</td>
             
            
     @if(Auth::user()->role==1)
     <td>
     <a class="btn btn-outline-success"  href="{{url('trainerassigned')}}/{{base64_encode($k->id)}}">Assigned School</a>
   </td>
      @else
       @if((session('data')[8]??0)==1&&(session('data')[16]??0)==1)
       <td>
      <a class="btn btn-outline-success"  href="{{url('trainerassigned')}}/{{base64_encode($k->id)}}">Assigned School</a>
    </td>
        @elseif((session('data')[16]??0)==1)
        <td>
         <a class="btn btn-outline-success"  href="{{url('trainerassigned')}}/{{base64_encode($k->id)}}">Assigned School</a>
       </td>
      @endif
      @endif

           
            
         @if(Auth::user()->role==1)
         <td>
              @if($k->status==1)
              <a  class="btn btn-outline-success" href="{{url('invite-trainer')}}/{{base64_encode($k->id)}}">Invite</a>
              @else
               <a class="btn btn-danger"  href="#">Invite</a>
             @endif
           </td>
          @else
          @if((session('data')[8]??0)==1)
          <td>
            @if($k->status==1)

              <a  class="btn btn-outline-success" href="{{url('invite-trainer')}}/{{base64_encode($k->id)}}">Invite</a>
              @else
               <a class="btn btn-danger"  href="#">Invite</a>
             @endif
             </td>
          @endif
          @endif

           

            <td>@if($k->roleby==1) Admin @else Others @endif</td>
              <td>{{date('d/m/Y i:h:s',strtotime($k->created_at))}} </td>
               <td>{{date('d/m/Y i:h:s',strtotime($k->updated_at))}} </td>

			    @if(Auth::user()->role==1)

				    <td>
              @if($k->status==1)
             <a href="{{url('edittrainer').'/'.base64_encode($k->id)}}" class="btn btn-sm btn-outline-success"><i class="fa fa-edit"></i> </a>  
              @else
              <a href="{{url('edittrainer').'/'.base64_encode($k->id)}}" class="btn btn-sm btn-outline-success"><i class="fa fa-edit"></i> </a>
              @endif
           </td>
          
				@else
				 @if((session('data')[8]??0)==1)

					 <td> 
            @if($k->status==1)
            <a href="{{url('edittrainer').'/'.base64_encode($k->id)}}" class="btn btn-sm btn-outline-success"><i class="fa fa-edit"></i> </a> 
            @else
              <a href="{{url('edittrainer').'/'.base64_encode($k->id)}}" class="btn btn-sm btn-outline-success"><i class="fa fa-edit"></i> </a> 
            @endif
             </td>
          
				   @endif
				@endif
            
    </tr>
    <?php $i=$i+1; ?>
    @endforeach
    @else
        
      @endif
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