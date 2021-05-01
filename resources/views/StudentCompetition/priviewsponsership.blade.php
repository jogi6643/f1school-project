@extends('layouts.student')
@section('contents')
<div class="content-heading">
    <div>
     <small data-localize="dashboard.WELCOME"></small>
    </div>
    <div class="text-right">
    <button type="button" onclick="goBack()" class="btn btn-info">Go Back</button>
<script>
function goBack() {
  window.history.back();
}
</script>
               </div>
               <br>
<div class="text-right">
  <a href="{{url('add_sponsership')}}/{{$sch_stu_id}}" class="btn btn-info" id="addsponser">Add Sponsorship</a>
</div>
</div>
                @if($errors->any())
                 <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                 </div>
                 @endif
                 @if(session()->has('success'))
                       <div class="alert alert-success">{{session()->get('success')}}</div>
                 @endif
                  @if(session()->has('error'))
                       <div class="alert alert-danger">
                         {{session()->get('error')}}
                       </div>
                 @endif

<div class="container-fluid">
<div class="col-md-12">
  <h1 class="text-center">SponsorShip Details</h1>
    <div class="form-group">
   
    <div id="addedrules">
     <table class="table table-striped border" id="activityrules">
       <thead>
        <tr class="text-center">
         <th width="10%">S No.</th>
         <th width="10%">COMPETION NAME</th>
         <th width="10%">COMPANY NAME</th>
         <th width="10%">POINT OF CONTACT NAME</th>
        
         <th width="10%"> EMAIL ID</th>
         
         <th width="10%">PHONE NUMBER</th>
         <th width="10%">TYPE</th>
          <!-- id="desc" style="display: none" -->
         <th width="10%">DESCRIPTION</th>
         <th width="10%">PREVIEW ANNEXURE C</th>
         <th width="10%">UPLOADED BY</th>
         <th width="10%">UPLOADED DATE</th>
         <th width="10%">Remove</th>
        </tr>
       </thead>
       <?php $j=1 ?>
       <tbody id="addcontentsponser">
        @if(count($sponserdetails)>0)
        @foreach($sponserdetails as $sponserdetails)
        <tr id="row1">
         <td class="text-center">{{$j}}</td>
        
          <td>{{$sponserdetails->Competition_name}}</td>
          <td>{{$sponserdetails->company_name}}</td>
          <td>{{$sponserdetails->point_of_contact}}</td>
          <td>{{$sponserdetails->EMAILID}}</td>
          <td>{{$sponserdetails->PHONE_NUMBER}}</td>
          <td>{{$sponserdetails->kmtype}}</td>
          <td>{{$sponserdetails->DESCRIPTION}}</td>
          <td>{{$sponserdetails->anex}}</td>
          <td>{{$studentname }}</td>
          <td>{{$sponserdetails->created_at}}</td>
          <?php $sponserdetails->company_name?>
           <td><a href="{{url('deletesponsership')}}/{{$sponserdetails->company_name}}/{{$sch_stu_id}}" class="btn btn-danger">REMOVE</a></td>
        </tr>
        <?php $j=$j+1;?>
        @endforeach
        @else
        <h3>No Data Found</h3>
        @endif
       </tbody> 
      </table>
     </div>
    </div>

</div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

@endsection
