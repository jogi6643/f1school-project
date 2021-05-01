@extends(Auth::user()->role==2? 'layouts.coadmin':'layouts.admin')
@section('content')
 
             
<div class="content-heading">
               <div><h3>{{$k->school_name}}</h3>
                <h3>{{$Academicyear}}</h3>
                  <small data-localize="dashboard.WELCOME"></small>
               </div>
                <div class="ml-auto">
                  <div class="btn-group">
                     <button type="button" onclick="goBack()" class="btn btn-info">Go Back</button>
                  </div>
               </div>
</div>
<script>
function goBack() {
  window.history.back();
}
</script>

            @if($errors->any())
               @foreach($errors->all() as $err)
                  <div class="alert alert-danger">{{$err}}</div>
               @endforeach
            @endif
            
            @if(session()->has('success'))
               <div class="alert alert-info">{{session()->get('success')}}</div>
            @endif
            @if(session()->has('status'))
               <div class="alert alert-danger">{{session()->get('status')}}</div>
            @endif
         
<!-- **************************************Start Assign Plan**********************             -->
    <div class="row">
        @if(Auth::user()->role==1)
			 <div class="col-md-2">
			<a href="{{url('schoolplanmaster')}}/{{base64_encode($k->id)}}" class="btn btn-outline-primary">
		  Asign School Plan</a>
		  </div>
		@else
		 @if((session('data')[15]??0)==1&&(session('data')[7]??0)==1)
			<div class="col-md-2">
					<a href="{{url('schoolplanmaster')}}/{{base64_encode($k->id)}}" class="btn btn-outline-secondary">
					Asign School Plan</a>
			</div>
      @elseif((session('data')[7]??0)==1)
         <div class="col-md-2">
          <a href="{{url('schoolplanmaster')}}/{{base64_encode($k->id)}}" class="btn btn-outline-secondary">
          Asign School Plan</a>
      </div>
      @elseif((session('data')[15]??0)==1)
      <div class="col-md-2">
          <a href="{{url('schoolplanmaster')}}/{{base64_encode($k->id)}}" class="btn btn-outline-secondary">
          Asign School Plan</a>
      </div>
		   @endif
	   @endif
     <!-- ******************End Assign Plan *************************** -->
      
      <!-- *******************************start view student************************/***** -->
	   @if(Auth::user()->role==1)
		
		<div class="col-md-2">
         <a href="{{url('students')}}/{{base64_encode($k->id)}}" class="btn btn-outline-success">Edit/View Student</a>
        </div>
		@else
			
		 @if((session('data')[18]??0)==1&&(session('data')[15]??0)==1)
			<div class="col-md-2">
              <a href="{{url('students')}}/{{base64_encode($k->id)}}" class="btn btn-outline-info">Edit/View Student</a>
           </div>
           @elseif((session('data')[18]??0)==1)
              <div class="col-md-2">
              <a href="{{url('students')}}/{{base64_encode($k->id)}}" class="btn btn-outline-info">Edit/View Student</a>
           </div>
           @elseif((session('data')[15]??0)==1)
              <div class="col-md-2">
              <a href="{{url('students')}}/{{base64_encode($k->id)}}" class="btn btn-outline-info">Edit/View Student</a>
           </div>
		   @endif
	   @endif
<!-- **************************view student******************************************** -->

      <!-- ******************************Start participate student************************* -->
	  @if(Auth::user()->role==1)
		
		 <div class="col-md-2">
      <a href="{{url('participantlist')}}/{{base64_encode($k->id)}}" class="btn btn-outline-warning">Participant Student</a>
      </div>
		@else
			
		 @if((session('data')[18]??0)==1&&(session('data')[7]??0)==1&&(session('data')[15]??0)==1)
			 <div class="col-md-2">
      <a href="{{url('participantlist')}}/{{base64_encode($k->id)}}" class="btn btn-outline-danger">Participant Student</a>
      </div>
      @elseif((session('data')[18]??0)==1)
       <div class="col-md-2">
      <a href="{{url('participantlist')}}/{{base64_encode($k->id)}}" class="btn btn-outline-danger">Participant Student</a>
      </div>
      @elseif((session('data')[7]??0)==1)
      <div class="col-md-2">
      <a href="{{url('participantlist')}}/{{base64_encode($k->id)}}" class="btn btn-outline-danger">Participant Student</a>
      </div>
      @elseif((session('data')[15]??0)==1)
      <div class="col-md-2">
      <a href="{{url('participantlist')}}/{{base64_encode($k->id)}}" class="btn btn-outline-danger">Participant Student</a>
      </div>
		   @endif
	   @endif
     <!-- ******************************End participate student************************* -->
	   <!-- *********************************START manufacture*********************** -->
       @if(Auth::user()->role==1)
		 <div class="col-md-2">
			<a href="{{url('school_show_manufacture')}}/{{base64_encode($k->id)}}" class="btn btn-outline-dark">Manufacture</a>
		</div>

		@else
			
		 @if((session('data')[9]??0)==1&&(session('data')[15]??0)==1)
			<div class="col-md-2">
					<a href="{{url('school_show_manufacture')}}/{{base64_encode($k->id)}}" class="btn btn-outline-dark">Manufacture</a>
			</div>
      @elseif((session('data')[15]??0)==1)
      <div class="col-md-2">
          <a href="{{url('school_show_manufacture')}}/{{base64_encode($k->id)}}" class="btn btn-outline-dark">Manufacture</a>
      </div>
      @elseif((session('data')[9]??0)==1)
            <div class="col-md-2">
          <a href="{{url('school_show_manufacture')}}/{{base64_encode($k->id)}}" class="btn btn-outline-dark">Manufacture</a>
      </div>
		   @endif
	   @endif

     <!-- *********************************End manufacture*********************** -->

    <!-- *************************View Team************************* -->
	   @if(Auth::user()->role==1)
		
    <!-- {{url('viewSchTeamcompdetails')}}/{{base64_encode($k->id)}} -->
		  <div class="col-md-2">
      <a href="{{url('viewTeamad/'.base64_encode($k->id))}}" class="btn btn-outline-success">View Team</a>
      </div>
		@else
			
		 @if((session('data')[14]??0)==1&&(session('data')[15]??0)==1)
			 <div class="col-md-2">
      <a href="{{url('viewTeamad/'.base64_encode($k->id))}}" class="btn btn-outline-danger">View Team</a>
      </div>
      @elseif((session('data')[15]??0)==1)
       <div class="col-md-2">
      <a href="{{url('viewTeamad/'.base64_encode($k->id))}}" class="btn btn-outline-danger">View Team</a>
      </div>
      @elseif((session('data')[14]??0)==1)
      <div class="col-md-2">
      <a href="{{url('viewTeamad/'.base64_encode($k->id))}}" class="btn btn-outline-danger">View Team</a>
      </div>
		   @endif
	   @endif

     <!-- ******************************End View Team********************************* -->
     <!-- ***********************************Create Team************************ -->

       @if(Auth::user()->role==1)
         <?php $idd =  'admin'.'_'.'1'.'_'.$k->id;?>
       <div class="col-md-2">
      <a href="{{url('createteambyad/'.base64_encode($idd))}}" class="btn btn-outline-danger">Create Team</a>
      </div>
         @else
      @if((session('data')[14]??0)==1&&(session('data')[15]??0)==1)
      <?php $idd =  'admin'.'_'.'1'.'_'.$k->id;?>
       <div class="col-md-2">
      <a href="{{url('createteambyad/'.base64_encode($idd))}}" class="btn btn-outline-danger">Create Team</a>
      </div>
      @elseif((session('data')[15]??0)==1)
       <?php $idd =  'admin'.'_'.'1'.'_'.$k->id;?>
       <div class="col-md-2">
      <a href="{{url('createteambyad/'.base64_encode($idd))}}" class="btn btn-outline-danger">Create Team</a>
      </div>
      @elseif((session('data')[14]??0)==1)
       <?php $idd =  'admin'.'_'.'1'.'_'.$k->id;?>
       <div class="col-md-2">
      <a href="{{url('createteambyad/'.base64_encode($idd))}}" class="btn btn-outline-danger">Create Team</a>
      </div>
      @endif
      @endif
      <!-- **********************End Create Team**************************************** -->

      <!-- ***************************View Plan******************************************* -->
      @if(Auth::user()->role==1)
     <div class="col-md-2">
      <a href="{{url('viewplanshowTs/'.base64_encode($k->id))}}" class="btn btn-outline-success">View Plan</a>
      </div>
    @else
      @if((session('data')[7]??0)==1&&(session('data')[15]??0)==1)
       <div class="col-md-2">
      <a href="{{url('viewplanshowTs/'.base64_encode($k->id))}}" class="btn btn-outline-success">View Plan</a>
      </div>
      @elseif((session('data')[15]??0)==1)
       <div class="col-md-2">
      <a href="{{url('viewplanshowTs/'.base64_encode($k->id))}}" class="btn btn-outline-success">View Plan</a>
      </div>
      @elseif((session('data')[7]??0)==1)
       <div class="col-md-2">
      <a href="{{url('viewplanshowTs/'.base64_encode($k->id))}}" class="btn btn-outline-success">View Plan</a>
      </div>
      @endif
      @endif
      <!-- ***********************************End view plan**************************  -->


      <div class="col-md-2">
      <a href="{{url('change-academic-year/'.base64_encode($k->id))}}" class="btn btn-outline-danger">Change Academic Year</a>
      </div>
      <!-- ********************************************view trainer********************** -->
  @if(Auth::user()->role==1)
      <div class="col-md-2">
      <a href="{{url('view-trainer/'.base64_encode($k->id))}}" class="btn btn-outline-danger">View Trainer</a>
      </div>
       @else
      @if((session('data')[8]??0)==1&&(session('data')[15]??0)==1)
       <div class="col-md-2">
      <a href="{{url('view-trainer/'.base64_encode($k->id))}}" class="btn btn-outline-danger">View Trainer</a>
      </div>
      @elseif((session('data')[15]??0)==1)
        <div class="col-md-2">
      <a href="{{url('view-trainer/'.base64_encode($k->id))}}" class="btn btn-outline-danger">View Trainer</a>
      </div>
      @elseif((session('data')[8]??0)==1)
       <div class="col-md-2">
      <a href="{{url('view-trainer/'.base64_encode($k->id))}}" class="btn btn-outline-danger">View Trainer</a>
      </div>
      @endif
      @endif
      <!-- *****************************End view trainer *************************** -->

       
 <table class="table table-hover table-striped">
   <thead>
      <tr>
         <th width="25%">School Name</th> <td> {{$k->school_name}}</td>
      </tr>
   </thead>
   <tbody>
      <tr>
         <th>#</th><td>{{$k->id}}</td>
      </tr>
      <tr>
            <th>Annual Fees</th><td>{{$k->annual_fees}}</td>
         </tr>
      <tr>
         
            <th>Address</th><td>{{$k->address}}</td>
         </tr>
         <tr>
         <th>Zone</th><td> {{$zone}}</td>
         </tr>
         <tr>
         <th>State</th><td>{{$state}} </td>
         </tr>
         <tr>
         <th>City</th><td>{{$city}} </td>
         </tr>
         
         
         <tr>
            <th>Website</th><td>{{$k->website}}</td>
         </tr>
         <tr>
            <th>Mobile</th><td>{{$k->mobile}}</td>
         </tr>
         <tr>
            <th>Email</th><td>{{$k->email}}</td>
         </tr>
         
         <tr>
            <th>Principal Name</th><td>{{$k->principal_name}}</td>
         </tr>
         <tr>
            <th>Principal Mobile</th><td>{{$k->principal_mobile}}</td>
         </tr>
         <tr>
            <th>Principal Email</th><td>{{$k->principal_email}}</td>
         </tr>
         <tr>
            <th>Status</th>
            @if($k->status==1)
            <td>Active</td>
               @else

             <td>InActive </td>
             @endif
         </tr>
         <tr>
         <th>Created At</th><td>{{date('d-F-Y',strtotime($k->created_at))}} </td>
         </tr>
         <tr>
            <th>Updated At</th><td>{{date('d-F-Y',strtotime($k->updated_at))}}</td>
         </tr>
      
   
      
   </tbody>
 </table>






@endsection



