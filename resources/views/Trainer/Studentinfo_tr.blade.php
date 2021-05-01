 @extends('layouts.trainer')
@section('content')
 
             <div class="content-heading">
               <div>Student Info
                  <small data-localize="dashboard.WELCOME"></small>
               </div> 
            </div>
                <div class="text-right">      
                <button type="button" onclick="goBack()" class="btn btn-info">Go Back</button>

                           <script>
                        function goBack() {
                         window.history.back();
                               }
                        </script>
               </div>



            @if($errors->any())
               @foreach($errors->all() as $err)
                  <div class="alert alert-danger">{{$err}}</div>
               @endforeach
            @endif
            @if(session()->has('success'))
               <div class="alert alert-info">{{session()->get('success')}}</div>
            @endif
        
          <div class="row">
            <div class="col-md-3">
            <a href="{{url('viewTeams-trainer')}}/{{base64_encode($k->id)}}" class="btn btn-outline-primary">View Team</a>
            </div>
            <div class="col-md-3">
             <a  href="{{url('cardesign-trainer')}}/{{base64_encode($k->id)}}" class="btn btn-outline-success">Manufacture Designs</a>
            </div>
           
          </div> 
      

     
        
   
 <table class="table table-hover table-striped">
 	<thead>
    <tr>
         
            @if($k->profileimage==null)
            <th width="25%">Student Profile</th>
           <td><img style="height: 100px;width:100px; border-radius: 50%;" src="{{url('studentprofileimage/pro.jpg')}}"></td>
           @else
             <th width="25%">Student Profile</th>
          <td> <img style="height: 100px;width:100px; border-radius: 50%;" src="{{url('studentprofileimage/')}}/{{ $k->profileimage }}"></td>
           @endif
         
      </tr>
 		<tr>
         <th width="25%">Student Name</th> <td> {{$k->name}}</td>
      </tr>
   </thead>
   <tbody>
     
      <tr>
            <th>Email Id</th><td>{{$k->studentemail}}</td>
         </tr>
      <tr>
         
            <th>Address</th><td>{{$k->address}}</td>
         </tr>
         <tr>
 			<th>D.O.B</th><td> {{$k->dob}}</td>
         </tr>
   
         
         
         <tr>
            <th>Class</th><td>{{$k->class}}</td>
         </tr>
         <tr>
            <th>Section</th><td>{{$k->section}}</td>
         </tr>
         <tr>
            <th>Mobile</th><td>{{$k->mobileno}}</td>
         </tr>
         
         <tr>
            <th>Guardian Name1</th><td>{{$k->guardianname1}}</tdg>
         </tr>
         <tr>
            <th>Guardian Phone1</th><td>{{$k->guardianphone1}}</td>
         </tr>
         <tr>
            <th>Guardian Email1</th><td>{{$k->guardianemail1}}</td>
         </tr>

  <tr>
            <th>Guardian Name2</th><td>{{$k->guardianname2}}</td>
         </tr>
           <tr>
            <th>Guardian Phone 2</th><td>{{$k->guardianphone1}}</td>
         </tr>
           <tr>
            <th>Guardian Email2</th><td>{{$k->guardianemail2}}</td>
         </tr>
        <tr>
            <th>Address</th><td>{{$k->address}}</td>
         </tr>


          <tr>
            <th>T-Size</th><td>{{$k->tsize}}</td>
         </tr>


         
         <tr>
            <th>Status</th><td>@if($k->status==1) Active @else Inactive @endif</td>
         </tr>
         
           <tr>
            <th>Created At</th><td>{{date('d/m/y h:i:s',strtotime($k->updated_at))}}</td>
         </tr>

         <tr>
         <th>Updated At</th><td>{{date('d/m/y h:i:s',strtotime($k->created_at))}} </td>
         </tr>
       
 		
 	
      
 	</tbody>
 </table>






@endsection



