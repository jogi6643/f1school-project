@extends((Auth::user()->role==3?'layouts.trainer':'layouts.admin'))
@section('content')
 
             <div class="content-heading">
               <div>School Details
                  <small data-localize="dashboard.WELCOME"></small>
               </div>
               
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
            
     <div class="row">
    <div hidden="" class="col-md-3">
      <a  href="{{url('studentsdd')}}/{{base64_encode($k->id)}}" class="btn btn-outline-primary">View Student</a>
   </div>
       <div class="col-md-3">
      <a  href="{{url('Participatestudentbytrainer')}}/{{base64_encode($k->id)}}" class="btn btn-outline-success">Participate Student</a>
      </div>

   <div class="col-md-3">
      <a  href="{{url('viewplanshow_trainer')}}/{{base64_encode($k->id)}}" class="btn btn-outline-danger">View Plan</a>
   </div>
     <div class="col-md-3">
      <a  href="{{url('viewcompetitionT')}}/{{base64_encode($k->id)}}" class="btn btn-outline-dark">View Competition</a>
   </div>
            </div>
       
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
            <th>Status</th><td>@if($k->status==1) Active @else Inactive @endif</td>
         </tr>
         <tr>
         <th>Created At</th><td>{{$k->created_at}} </td>
         </tr>
         <tr>
            <th>Updated At</th><td>{{$k->updated_at}}</td>
         </tr>
 		
 	
      
 	</tbody>
 </table>






@endsection



