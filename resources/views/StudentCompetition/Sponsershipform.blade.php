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
                 <div class="text-left">
  <a href="{{url('prviewsponsership')}}/{{$sch_stu_id}}" class="btn btn-warning">View</a>
</div>
<div class="text-right">
  
  <a href="{{url('/public/docs/AnnexC.pdf')}}" target="_blank" class="btn btn-warning"> Download ANNEXURE -C</a>
</div>
 <form method="post" action="{{url('storesponsership')}}" enctype="multipart/form-data">
   @csrf
     

<input  hidden="" required="required" type="text" name="sch_stu_id" class="form-control"  value="{{$sch_stu_id}}" placeholder="">

   <div class="form-group  col-md-4"> 
<select required="required" class="form-control"  id="competition_name" name="competition_name">
    <option value="">SELECT COMPETION</option>
    @foreach ($comptetion as $id=>$comptetion)
        <option value="{{ $comptetion->id }}">{{ $comptetion->Competition_name }}</option>
    @endforeach
</select>
         </div>
  <div class="form-group  col-md-4">
  <input hidden="" required="required" type="text" name="teamid" class="form-control"  value="{{$ct->id}}" placeholder="Enter the POINT OF CONTACT NAME">
</div>



    <div class="form-group">
     <label for="rule"><strong><h1 class="text-center">Sponsor Details:-</h1></strong></label><br>
     <a href="#" class="btn btn-info" id="addsponser">Add Sponsor</a>
    <div id="addedrules">
     <table class="table table-striped border" id="activityrules">
       <thead>
        <tr class="text-center">
         <th width="10%">S No.</th>
         <!-- <th width="10%">COMPETION NAME</th> -->
         <th width="10%">COMPANY NAME</th>
         <th width="10%">POINT OF CONTACT NAME</th>
        
         <th width="10%"> EMAIL ID</th>
         
         <th width="10%">PHONE NUMBER</th>
         <th width="10%">TYPE</th>
          <!-- id="desc" style="display: none" -->
         <th width="10%">DESCRIPTION</th>
         <th width="10%">upload Annexure C</th>
         <th width="10%">Action</th>
        </tr>
       </thead>
       <?php $j=1 ?>
       <tbody id="addcontentsponser">
        <tr id="row1">
         <td class="text-center">{{$j}}</td>
    
          <td>
          <input required="required" type="text" name="company_name[]" class="form-control"  value="" placeholder="Enter the Company Name">
          </td>
         
           <td> 
            <input  required="required" type="text" name=point_of_contact[] class="form-control"  value="" placeholder="Enter the POINT OF CONTACT NAME">
          </td>
           <td> 
            <input required="required" type="email" name="EMAILID[]" class="form-control"  value="" placeholder="Enter the EMAIL ID">
          </td>

           <td> 
            <input  required="required" maxlength="10" type="number" name="PHONE_NUMBER[]" class="form-control"  value="" placeholder="Enter the PHONE NUMBER">
          </td>


           <td> 
            <!-- onchange="money({{$j}})" -->
    <div required="required" class="form-group">
     <select required="required" class="form-control" id="kmtype" name="kmtype[]" >
      <option value="">TYPE</option>
      <option value="KIND">KIND</option>
      <option value="MONEY">MONEY</option>
     </select>
   </div>
          </td>
 <!-- style="display:none" class="ab" id="{{$j}}" -->
           <td> 
            <input required="required" type="text" name="DESCRIPTION[]" class="form-control" value="" placeholder="Enter the DESCRIPTION">
          </td>
          <td>
             <div class="form-group">
    
    <input required="required"  type="file" name="anex[]" class="form-control-file" id="file1">
  </div>
          </td>
          
         <td>
          <a href="#"  class="btn btn-danger ">Remove</a> 
         </td>
        </tr>
       </tbody> 
      </table>
     </div>
    </div>
   <div class="col-md-12 form-group text-center mt-2">
    <input type="submit" class="btn btn-info" name="submit" value="Submit"/>
   </div>
 </form>  
</div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<!-- id="'+j+'_des" style="display:none" -->
 <!-- onchange="money('+j+')" -->
<script type="text/javascript">
  
  function money(id)
  {
   
    $('#desc').show();
   $("#"+id).show();
   // alert("#"+id+"_des");
   $("#"+id+"_des").show();
   //alert($("#"+id).parent().parent().next().show());
   
  }
</script>
<script>
$(document).ready(function(){
  $.noConflict();
  //alert(0);
  var i=2;j=2;k=2;
 //add rules  
 $(document).on('click','#addsponser',function(event){
  event.preventDefault();
  html ='';
  html+='<tr id="row'+i +'">';
  html+='<td class="text-center">'+i+'</td>';

// html+='<td class="text-center"><div class="form-group"><select class="form-control"id="competition_name" name="competition_name" ><option value="">COMPETION TYPE</option><option value="0">COMPETION 1</option><optionvalue="1">COMPETION 2</option></select></div></td>';

html+='<td><input required="required" type="text" name="company_name[]" class="form-control"  value="" placeholder="Enter the Company Name"></td>';

html+='<td><input required="required" type="text" name=point_of_contact[] class="form-control"  value="" placeholder="Enter the POINT OF CONTACT NAME"></td>';

html+='<td><input required="required" type="email" name="EMAILID[]" class="form-control"  value="" placeholder="Enter the EMAIL ID"></td>';

html+='<td><input required="required" type="text" name="PHONE_NUMBER[]" class="form-control"  value="" placeholder="Enter the PHONE NUMBER"></td>';

html+='<td class="text-center"><div class="form-group"><select required="required"  class="form-control"id="kmtype" name="kmtype[]"><option value="">TYPE</option><option value="KIND">KIND</option><option value="MONEY">MONEY</option></select></div></td>';

html+='<td> <input required="required" type="tel" pattern="[0-9]"   name="DESCRIPTION[]" class="form-control"  value="" placeholder="Enter the PHONE NUMBER"></td>';

html+='<td> <input required="required" type="file" name="anex[]"  class="form-control-file" id="file1"></td>';

html+='<td><a href="#" id="'+i +'" class="btn btn-danger remove">Remove</a></td>';

  html+='</tr><tr>';
   i++;
   j++;
  $('#addcontentsponser').append(html);
  });
  $(document).on('click','.remove',function(event){
  event.preventDefault();
   id = $(this).attr('id');
   //alert(id);
     $('#row'+id+'').remove();
 });

});//end  
</script>
@endsection
