@extends(Auth::user()->role==2? 'layouts.coadmin':'layouts.admin')
@section('content')
 
             <div class="content-heading">
               <div>Sponsorship Details
                  <small data-localize="dashboard.WELCOME"></small>
               </div>
              
            </div>

            @if($errors->any())
               @foreach($errors->all() as $err)
                  <div class="alert alert-danger">{{$err}}</div>
               @endforeach
            @endif
            @if(session()->has('status'))
               <div class="alert alert-danger">{{session()->get('status')}}</div>
            @endif
 <table class="table table-hover table-striped" id="userlistid">
  <thead>
    <tr>
      <th>#</th>
      <th>School Name</th>
         <th>Student Name</th>
         <th>Team id</th>
      <th>Team Name</th>
      <th>Competition Name</th>
      <th>Company Name</th>
         <th>Point of Contact Name</th>
         <th>Email Id</th>
         <th>Phone Number</th>
          <th>Type</th>
          <th>Description</th>
          <th>uploaded Annexure C</th>
          <th>Uploaded on</th>
    </tr>
  </thead>
  <tbody>
      @if(count($s2)>0)
    
      <?php $i=1;?>
    @foreach($s2 as $k)
 
    <tr>
         <td>{{$i}}</td> 
      <td><a href="{{url('schoolv')}}/{{base64_encode($k->schoid)}}">{{$k->schoolname}}</a></td> 
      <td>{{$k->uploadedby}}</td>
      <td>{{$k->teamid}}</td>
         <td>
   @if($k->teamName!='N/A')
          <a href="{{url('viewteampage')}}/{{base64_encode($k->teamid)}}">{{$k->teamName}}</a>
         @else
         N/A
         @endif

           </td>
         
         <td><a href="{{url('nominate')}}/{{base64_encode($k->competition_id)}}">{{$k->Competition}} </a></td>
         <td>{{$k->company_name}} </td>
         <td>
        {{$k->point_of_contact}}
         </td>
      <td>{{$k->EMAILID}} </td>
         <td>{{$k->PHONE_NUMBER}} </td>
         
       <td>{{$k->kmtype}} </td>
           <td>{{$k->DESCRIPTION}} </td>
           <td><a href="{{url('public/Sponserannexure')}}/{{$k->anex}}" target="_blank">View File</td>
            <?php 
            $timestamp = strtotime($k->created_at);
            $new_date = date("d-m-Y", $timestamp);
            ?>
           <td>{{$new_date}}</td>
           
      
          
    </tr>
    <?php $i++?>
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
         window.location.href='{{url("/coursedel")}}/'+btoa(ak[1]);
         // alert("yes");
   }
 </script>
@endsection