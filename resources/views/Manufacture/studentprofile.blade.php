@extends('layouts.admin')
@section('content')
 
             <div class="content-heading">
               <div> User Profile
                  <small data-localize="dashboard.WELCOME"></small>
               </div>
               @include('sweet::alert')
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

        <table class="table table-dark">
    <thead>
      <tr>
       
      </tr>
    </thead>
    <tbody>
     
        <tr>
            <th colspan="2" class="alert alert-info text-center">User Profile</th>
        </tr>
  
      <tr>
    <th>name</th>
    <td>{{$info->fullName}}</td>
      </tr>
      <tr>
        <th>User MailId</th>
        <td>{{$userinfo->studentemail}}</td>
        </tr>
        <tr>
       <th>Mobile No.</th> <td>{{$info->mobile}}</td>
       </tr>
        <tr>
           <th>Pincode</th> <td>{{$info->pincode}}</td>
           </tr>
       <tr>
        <tr>
           <th>Street</th> <td>{{$info->street}}</td>
           </tr>
        <tr>
        <tr>
           <th>City</th> <td>{{$info->city}}</td>
           </tr>
        <tr>

            
           <th>Address</th> <td>{{$info->address}}</td>
           </tr>
           <tr>
               <th>Created at</th>
             
         <td>{{date('D/F/Y',strtotime($info->created_at))}}</td>
         </tr>
         <tr>
             <th>Updated at</th>
        <td>{{date('D/F/Y',strtotime($info->updated_at))}}</td>
      </tr>


    </tbody>
  </table>
        
        
    </div>

  </div>
  <div class="row">
    <div class="col-*-*"></div>
    <div class="col-*-*"></div>
    <div class="col-*-*"></div>
  </div>
  <div class="row">
    ...
  </div>
</div>
    

 	





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
 </script>
@endsection