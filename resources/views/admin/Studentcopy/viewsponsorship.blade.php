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
               <div>Show Plan Student
                <br>
                <h4>{{$schoolname}}|{{$studentname}}</h4>
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
 <table class="table table-hover table-striped table-responsive" id="userlistid1">
 	<thead>
 		<tr>
 			<th>#</th>
      <th>Company Name</th>
 			<th>Point of Contact</th>
      <th>Email ID</th>
      <th>Phone Number</th>
      <th>kmtype</th>
      <th>DESCRIPTION</th>
      <th>anex</th>
      <th>Competition Name</th>
      <th>Team Name</th>
      <th>Created_at</th>

 		</tr>
 	</thead>
 	<tbody>
 

    <?php $i=1;?>
  
 		@foreach($spo as $k)
 	
		<tr>
			       <td>{{$i}}</td> 
			       <td> {{$k->company_name}}</td>
             <td>{{$k->point_of_contact}} </td>
             <td>{{$k->EMAILID}} </td>
             <td>{{$k->PHONE_NUMBER}} </td>
             <td>{{$k->kmtype}} </td>
             <td>{{$k->DESCRIPTION}} </td>
             <td> <a  target="_blank" href="{{url('Sponserannexure')}}/{{$k->anex}}"> Sponserannexure</a> </td>
             <td>{{$k->competitionname}} </td>
             <td>{{$k->teamname}} </td>
            <?php $date= date("d-m-Y", strtotime($k->created_at));?>
             <td>{{ $date}} </td>	
		</tr>
		<?php $i=$i+1; ?>
		@endforeach
 	
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
    $('#userlistid1').DataTable();
  });

   function myfuntemp(arg) {
      var ad=$(arg).attr('id');
      var ak=ad.split('-');
      // alert('val = '+ak[1]);
      if(confirm("Do you really want to delete this."))
         window.location.href='{{url("/locationdel")}}/'+btoa(ak[1]);
         // alert("yes");
   }

    function myfuninvite(arg){
    var id   = $(arg).attr("id");
    var sname= $(arg).attr("sname");
    var email= $(arg).attr("semail");
    $.ajax({
        url:"{{url('studentlistformail')}}",
        method:"POST",
        data:{id:id,sname:sname,email:email,_token: '{{csrf_token()}}'},
         beforeSend: function() {
           $('#myModal').modal('show'); 
           
         },
        success:function(data)
        {  $('#sendingmessage').text('Email sent successfully.');
           location.reload();
          setTimeout(function(){
              $('#myModal').modal('hide')
            }, 2000);
        }
      });
    
    }  

  $(document).ready(function () {
    
    $("#materialUnchecked").click(function () {
    
        $(".student").prop('checked', $(this).prop('checked'));
    });
    
   
});
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


<script type="text/javascript">

  


function bulksubmitstudent()
{

  
            var favorite = [];
              $.each($("input[name='stu']:checked"), function(){
        
                favorite.push($(this).val());
            });
       if(favorite.length===0)
          {
          alert("Please Select Student First...");
         
            // alert("My favourite sports are: " + favorite.join(", "));
          }
          else
          {
          
          
      $.ajax({
        url:"{{url('invitebyemailstudentbulk')}}",
        method:"post",
        data:{student:favorite,_token: '{{csrf_token()}}'},
        beforeSend: function() {
        
         },
        success:function(data)
        { 
        alert('Sending bulk Mail successfully');
      
        }
      });
    }
            // alert("My favourite sports are: " + favorite.join(", "));
       
}
 </script>