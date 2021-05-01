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

 <form  method="post" action="{{url('body_Part')}}" enctype="multipart/form-data">
   @csrf
     

<div hidden="" class="form-group">
 <input  class="form-control"  type="text" name="carpart" value="Car Part Body">
 </div>

  <div  hidden="" class="form-group">
      <label for="paragraph" id="Application1">Application ID</label>
      <input disabled="" type="text" id="Application" value="{{$appid}}" class="form-control col-md-3" placeholder="Applicationid" name="Application">

       <input hidden="" type="text" id="Application" value="{{$appid}}" class="form-control col-md-3" placeholder="Applicationid" name="Application">
    </div>

    <div hidden="" class="form-group">
      <label for="paragraph">Studentid:</label>
      <input type="text" class="form-control col-md-3" id="paragraph" placeholder="studentid" name="studentid" value="{{$studentid}}">
  </div>

  <div hidden="" class="form-group">
      <label for="paragraph">Schoolid:</label>
      <input type="text" class="form-control" id="paragraph" placeholder="schoolid" name="schoolid" value="{{$schoolid}}">
    </div>

    <div class="form-group">
     <label for="rule"><strong><h1 class="text-center">Car Body Part:-</h1></strong></label><br>
     <a href="#" class="btn btn-info" id="addsponser">Add Car Body Part</a>
    <div id="addedrules">
     <table class="table table-striped border" id="activityrules">
       <thead>
        <tr class="text-center">
         <th width="10%">S No.</th>
         <th width="10%">Car Body Part</th>
         <th width="10%">File</th>
         <th width="10%">Action</th>
        </tr>
       </thead>
       <?php $j=1 ?>
       <tbody id="addcontentsponser">
        <tr id="row1">
         <td class="text-center">{{$j}}</td>
           <td> 
            <select   class="form-control z" name="partname[]">
            <option value="">Select Part Name</option>
            @foreach($bodypart as $bodypart1)
          <option value="{{$bodypart1->id}}">{{$bodypart1->Partname}}</option>
          @endforeach
          </select>
          </td>


          <td>
             <div class="form-group">
    
    <input required="required"  type="file" name="filename[]" class="form-control-file" id="file1">
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
    <!-- <input type="submit" class="btn btn-info" name="submit" value="Submit"/> -->

            <button type="submit" class="btn btn-primary" style="margin-top:10px">Submit</button>
        <?php $id=$studentid.".".$schoolid ;
       $appid= $studentid."_".$schoolid."_".$appid; 
        
        ?>
        <a href="{{url('skipnewdesign')}}/{{base64_encode($id)}}"><button type="button"  class="btn btn-danger" style="margin-top:10px">Skip</button></a>
        <a href="{{url('cancledesign')}}/{{base64_encode($appid)}}"><button type="button"  class="btn btn-danger" style="margin-top:10px">Cancel</button></a>
   </div>
 </form>  
</div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>


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
  var c;
  var i=2;j=2;k=2;
 //add rules  
 $(document).on('click','#addsponser',function(event){
  event.preventDefault();
  var arr=[];
  var j=0;

    
 $(".z").each(function(option,value)
{
    arr[j]=value.value;
	j=j+1;
});

   c={{count($bodypart)}};
  if(c==j)
  {
     $("#addsponser").hide();
  }
 if(c>j){
  html ='';
  html+='<tr id="row'+i +'">';
  html+='<td class="text-center">'+i+'</td>';



html+='<td><select   class="form-control z"  name="partname[]"><option value="">Select Part Name</option>';

  

@foreach($bodypart as $bodypart)
var id ="{{$bodypart->id}}";
if($.inArray(id,arr)!=-1)
{
	
}
else
{
	html+='<option  value="{{$bodypart->id}}">{{$bodypart->Partname}}</option>';
}
@endforeach
html+="</select></td>";





html+='<td> <input required="required" type="file" name="filename[]"  class="form-control-file" id="file1"></td>';

html+='<td><a href="#" id="'+i +'" class="btn btn-danger remove">Remove</a></td>';

  html+='</tr><tr>';
   i++;
   j++;
  $('#addcontentsponser').append(html);
}
  });
  $(document).on('click','.remove',function(event){
  event.preventDefault();
   id = $(this).attr('id');
  
    var arr=[];
  var j=0;

    
 $(".z").each(function(option,value)
{
    arr[j]=value.value;
  j=j+1;
});

  
   if(c!=j)
   {
    // alert(j);
    
   }
   else
   {
    $("#addsponser").show();
    
   }

     $('#row'+id+'').remove();
 });

});//end  
</script>
@endsection
