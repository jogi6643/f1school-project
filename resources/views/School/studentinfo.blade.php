@extends('layouts.school')
@section('content')
 
             <div class="content-heading">
               <div>Student Info
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
            

     
        
   
 <table class="table table-hover table-striped">
 	<thead>
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
         <th>Created At</th><td>{{date('d-F-Y',strtotime($k->created_at))}} </td>
         </tr>
         <tr>
            <th>Updated At</th><td>{{date('d-F-Y',strtotime($k->updated_at))}}</td>
         </tr>
 		
 	
      
 	</tbody>
 </table>






@endsection



