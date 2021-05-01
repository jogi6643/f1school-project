@extends(Auth::user()->role==2? 'layouts.coadmin':'layouts.admin')
@section('content')
<style>
.border-class
{
  border:thin #929292 solid;
  margin:20px;
  padding:20px;
}
</style>
 
             <div class="content-heading">
               <div>School Master
                  <small data-localize="dashboard.WELCOME"></small>
               </div>
               
          
               <!-- START Language list-->
             @if(Auth::user()->role==1)
               <div class="ml-auto">
                  <div class="btn-group">
                     <a href="{{url('schoolcr')}}" class="btn btn-success ">Create</a>
                </div>
                 <div class="btn-group">
                     <a href="{{url('downloadstudentsheet')}}" class="btn btn-warning">Download Student Template</a>
                </div>  
                 <div class="btn-group">
                     <a href="{{url('downloadstudentbyschoolwhole')}}" class="btn btn-primary">Download Student Report</a>  
                </div>              
                 <div class="btn-group">
                     <a href="{{url('downloadschool')}}" class="btn btn-warning">Download School  Template</a>
                </div>
                 
                  <div class="btn-group">
             <a href="{{url('download-school-report')}}" class="btn btn-primary">Download School  Report</a>
          </div>                   
                   
                  </div>
				@else
					<div class="ml-auto">
					@if((session('data')[15]??0)==1)
					
					  <div class="btn-group">
						 <a href="{{url('schoolcr')}}" class="btn btn-success ">Create</a>
					</div>
				    @endif
					@if(isset(session('data')[18]))
					 <div class="btn-group">
						 <a href="{{url('downloadstudentsheet')}}" class="btn btn-warning">Download Student Template</a>
					</div> 
                   @endif
                 @if((session('data')[15]??0)==1)				   
					 <div class="btn-group">
						 <a href="{{url('downloadschool')}}" class="btn btn-warning">Download School  Template</a>
					</div>
			     @endif

            @if((session('data')[15]??0)==1)           
           <div class="btn-group">
             <a href="{{url('download-school-report')}}" class="btn btn-primary">Download School  Report</a>
          </div>
           @endif

           
			                    
					   
                  </div>
			  @endif
               </div>
             <div class="text-right">
                           
                <button type="button" onclick="goBack()" class="btn btn-info">Go Back</button>

                           <script>
                        function goBack() {
                         window.history.back();
                               }
                        </script>
               </div>
                <div class="row " style="margin-left:10px">
                     
                          <div class="col-md-12">
                        
					@if(Auth::user()->role==2)
					  @if((session('data')[15]??0)==1)
                        <div class="col-md-6">
                         <form class="border-class" method="post" action="{{url('uploadschool')}}" enctype="multipart/form-data">
                         @csrf
                         <div class="row">
                         <div class="col-md-4">
                          <div class="form-group">
                            <label for="file">Upload School Templates:</label>
                            <input type="file" class="form-control"  name="files" id="file">
                          </div>
                           
                         </div>
                          <div class="col-md-4">
                            <div class="form-group">
                                 <label style="padding:7%"></label>
                             <button type="submit" class="btn btn-primary">Submit</button>
                             </div>
                         </div>
                        </div>
                         
                        </form>

                        </div>
						@endif
						@if((session('data')[18]??0)==1)
							 <div class="col-md-6">
                     <form class="border-class" method="post" action="{{url('uploadstudent')}}" enctype="multipart/form-data">
                         @csrf
                         <div class="row">
                         <div class="col-md-4">
                          <div class="form-group">
                            <label for="file">Upload Student Templates:</label>
                            <input type="file" class="form-control"  name="files" id="file">
                          </div>
                           
                         </div>
                          <div class="col-md-4">
                            <div class="form-group">
                                 <label style="padding:7%"></label>
                             <button type="submit" class="btn btn-primary">Submit</button>
                             </div>
                         </div>
                        </div>
                         
                        </form>
                        </div>
					    @endif
					  @else
						  
						    <div class="col-md-6">
                         <form class="border-class" method="post" action="{{url('uploadschool')}}" enctype="multipart/form-data">
                         @csrf
                         <div class="row">
                         <div class="col-md-4">
                          <div class="form-group">
                            <label for="file">Upload School Templates:</label>
                            <input type="file" class="form-control"  name="files" id="file">
                          </div>
                           
                         </div>
                          <div class="col-md-4">
                            <div class="form-group">
                                 <label style="padding:7%"></label>
                             <button type="submit" class="btn btn-primary">Submit</button>
                             </div>
                         </div>
                        </div>
                         
                        </form>

                        </div>
						   <div class="col-md-6">
                     <form class="border-class" method="post" action="{{url('uploadstudent')}}" enctype="multipart/form-data">
                         @csrf
                         <div class="row">
                         <div class="col-md-4">
                          <div class="form-group">
                            <label for="file">Upload Student Templates:</label>
                            <input type="file" class="form-control"  name="files" id="file">
                          </div>
                           
                         </div>
                          <div class="col-md-4">
                            <div class="form-group">
                                 <label style="padding:7%"></label>
                             <button type="submit" class="btn btn-primary">Submit</button>
                             </div>
                         </div>
                        </div>
                         
                        </form>
                        </div>
					@endif
                       
                        </div>
			
                     </div>
               <!-- END Language list-->
            </div>
           
       
            @if(session()->has('errors1'))
               <?php $i=1;?>
               @foreach(session('errors1') as $err)
                  <div class="alert alert-danger"><span>{{$i}}.</span> <?php print_r($err); ?></div>
                  <?php $i++;?>
               @endforeach
            @endif

             
            @if(session()->has('success'))
               <div class="alert alert-info">{{session()->get('success')}}</div>
            @endif
            
 <table class="table table-hover table-striped" id="userlistid">
 	<thead>
 		<tr>
 			<th>S.NO</th>
     <!-- *************************************Start Bulk Invite*************** -->
  @if(Auth::user()->role==1)
			<th>
        <div class="row">
          <div class="col-md-2">
            <input type="checkbox"  id="materialUnchecked">
          </div>
          <div class="col-md-2">

       <button class="btn btn-primary" onclick="bulksubmit()">Bulk Invite</button>
          </div>
        </div>
			</th>
         @else
      @if((session('data')[15]??0)==1)
      <th>
        <div class="row">
          <div class="col-md-2">
            <input type="checkbox"  id="materialUnchecked">
          </div>
          <div class="col-md-2">

       <button class="btn btn-primary" onclick="bulksubmit()">Bulk Invite</button>
          </div>
        </div>
      </th>
      @endif

      @endif

      <!-- *************************************End Bulk Invite*************** -->
      <th>Image</th>
      <th>School Name</th>
 			<th>Zone</th>
 			<th>State</th>
 			<th>City</th>
     @if(Auth::user()->role==1)
      <th>Invite</th>
       @else
      @if((session('data')[15]??0)==1)
      <th>Invite</th>
      @endif

      @endif

 			<th>Status</th>
			@if(Auth::user()->role==1)
		  <th>Create Team</th>
	  @else
    @if((session('data')[15]??0)==1)
		  @if((session('data')[14]??0)==1)
		   <th>Create Team</th>
		 @endif
     @endif
	  @endif
    
	  @if(Auth::user()->role==1)
		  <th>View Team</th>
	  @else
    @if((session('data')[15]??0)==1)
		  @if(isset(session('data')[14]))
		  <th>View Team</th>
		 @endif
     @endif
	  @endif
      <th>Created At</th>
      <th>Last Modified</th>
	  @if(Auth::user()->role==1)
		   <th>List Student</th>
		   @else
       @if((session('data')[15]??0)==1)
		  @if(isset(session('data')[18]))
		   <th>List Student</th>
		 @endif
     @endif
	   @endif
	  @if(Auth::user()->role==1)
		  <th></th>
	    @else
		  @if(session('data')[15]??0==1)
		  <th></th>
		 @endif
	   @endif
       
 		</tr>
 	</thead>
 	<tbody>
    <?php $i=1; ?>
      @if(count($eq)>0)
 		@foreach($eq as $k)
    <?php $idd =  $k->adminname.'_'.$k->adminid.'_'.$k->id;?>
		<tr>
		      
			<td>{{$i++}}</td> 
      <td>
          <div class="form-group">
           <a href="{{url('schoolv/'.base64_encode($k->id))}} " target="__blank">
             @if($k->pimage==null)
             <img src="{{ URL::to('/') }}/ImageSchool/schoolimage.png" alt="placeholderpdf" width="50" height="50" style="border-radius: 50%">
             @else
              <img style="border-radius: 50%" src="{{ URL::to('/') }}/ImageSchool/{{$k->pimage}}" alt="placeholderpdf" width="50" height="50">
             @endif
           </a>
              </div>

      </td>

        @if(Auth::user()->role==1)
        <td>  <input type="checkbox" name="sch" class="school"  value="{{$k->id}}">
       @else
      @if((session('data')[15]??0)==1)
        <td>  <input type="checkbox" name="sch" class="school"  value="{{$k->id}}">
      @endif

      @endif
		
          
			</td>
            <td> <a href="{{url('schoolv/'.base64_encode($k->id))}} " target="__blank">{{$k->school_name}}</a></td>
			<td> {{$k->zone}}</td>
         <td>{{$k->state}} </td>
         <td>{{$k->city}} </td>
@if(Auth::user()->role==1)
         <td>
          <div>
           @if($k->checkStatus == 1)

           <button  id="{{$k->id}}" sname="{{$k->school_name}}" semail="{{$k->email}}" status="{{$k->checkStatus}}"  class="btn btn-sm btn-danger invite" onclick="myfuninvite(this)">
                      Invited
           @else
             <button  id="{{$k->id}}" sname="{{$k->school_name}}" semail="{{$k->email}}" status="{{$k->email_status}}"  class="btn btn-sm btn-success invite" onclick="myfuninvite(this)">
                      Invite
           @endif
         </button>
         </div>
         </td>
           @else
       
      @if((session('data')[15]??0)==1)
         <td>
          <div>
           @if($k->checkStatus == 1)

           <button  id="{{$k->id}}" sname="{{$k->school_name}}" semail="{{$k->email}}" status="{{$k->checkStatus}}"  class="btn btn-sm btn-danger invite" onclick="myfuninvite(this)">
                      Invited
           @else
             <button  id="{{$k->id}}" sname="{{$k->school_name}}" semail="{{$k->email}}" status="{{$k->email_status}}"  class="btn btn-sm btn-success invite" onclick="myfuninvite(this)">
                      Invite
           @endif
         </button>
         </div>
         </td>
      @endif

      @endif

         <td>@if($k->status==1) Active @else Inactive @endif</td>

         @if(Auth::user()->role==1)
		 <td><a href="{{url('createteambyad/'.base64_encode($idd))}}" class="btn btn-success" id="{{$k->adminid}}">Create Team</a></td>
        
	  @else
		  @if((session('data')[15]??0)==1)
		  @if((session('data')[14]??0)==1)
		  <td><a href="{{url('createteambyad/'.base64_encode($idd))}}" class="btn btn-success" id="{{$k->adminid}}">Create Team</a></td>
       @endif 
		 @endif
	  @endif
          @if(Auth::user()->role==1)
			 <td><a href="{{url('viewTeamad/'.base64_encode($k->id))}}" class="btn btn-success">View team</a></td>
		  @else
      @if((session('data')[15]??0)==1)
			 @if(isset(session('data')[14]))
			 <td><a href="{{url('viewTeamad/'.base64_encode($k->id))}}" class="btn btn-success">View team</a></td>
			 @endif
       @endif
		  @endif
			 <td>{{date('d-m-Y H:i:s',strtotime($k->created_at))}} </td>

      <td>{{date('d-m-Y H:i:s',strtotime($k->updated_at))}} </td>
           @if(Auth::user()->role==1)
			 <td><a href="{{url('students')}}/{{base64_encode($k->id)}}">List Student</a></td>
		    @else
        @if((session('data')[15]??0)==1)
				@if(isset(session('data')[18]))
				<td><a href="{{url('students')}}/{{base64_encode($k->id)}}">List Student</a></td>
			     @endif
           @endif
		   @endif
         @if(Auth::user()->role==1)
         <td> <a href="{{url('schooled').'/'.base64_encode($k->id)}}" class="btn btn-sm btn-outline-success"><i class="fa fa-edit"></i> </a>
          <!-- <button class="btn btn-sm btn-outline-danger" id="tempdelid-{{$k->id}}" onclick="myfuntemp(this)"><i class="fa fa-trash"></i> 
          </button>  -->
         </td>
		 @else
		 
			 @if((session('data')[15]??0)==1)
			 <td> <a href="{{url('schooled').'/'.base64_encode($k->id)}}" class="btn btn-sm btn-outline-success"><i class="fa fa-edit"></i> </a>
          <!-- <button class="btn btn-sm btn-outline-danger" id="tempdelid-{{$k->id}}" onclick="myfuntemp(this)"><i class="fa fa-trash"></i> 
          </button>  -->
         </td>
		 @endif
			 
		 @endif
			
			
		 			
		</tr>
		
		@endforeach
 		@else
         No Record Found.....
      @endif
 	</tbody>
 </table>




@endsection

@section('header')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
@endsection

@section('footer')
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
    var id = $(arg).attr("id");
    var sname= $(arg).attr("sname");
    var email= $(arg).attr("semail");

    
    $.ajax({
        url:"{{url('sendemail')}}",
        method:"post",
        data:{id:id,sname:sname,email:email,_token: '{{csrf_token()}}'},
        beforeSend: function() {
          // $('#modal').show();
           document.getElementById("modal").hidden = false;
           $('#myModal').modal('show'); 
         },
        success:function(data)
        {
           $('#sendingmessage').text('Email sent successfully.');
               $('#id').text('Invited');
              location.reload();
          setTimeout(function(){
              $('#myModal').modal('hide')
            }, 2000);
        }
      });
  }
  $(document).ready(function () {
    $("#materialUnchecked").click(function () {
		
        $(".school").prop('checked', $(this).prop('checked'));
    });
    
   
});
function bulksubmit()
{
	
            var favorite = [];
             $.each($("input[name='sch']:checked"), function(){
        
                favorite.push($(this).val());
            });


          if(favorite.length==0)
          {
            alert('Please select school First..');
          }

			else
      {
           
			$.ajax({
        url:"{{url('sendemailbuk')}}",
        method:"post",
        data:{school:favorite,_token: '{{csrf_token()}}'},
        beforeSend: function() {
          
         },
        success:function(data)
        { 
		    alert('Sending bulk Mail successfully');
    
        }
      });
            // alert("My favourite sports are: " + favorite.join(", "));

          }
       
}
 </script>
@endsection
<!-- Modal -->
<div  id='modal' hidden="">
<div  id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content" style="background-color: red; color: white;">
      <div class="modal-body">
        <h1 id='sendingmessage' class="text-center">Sending Email...</h1>
      </div>
     
    </div>

  </div>
</div>
</div>