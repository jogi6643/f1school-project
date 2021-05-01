	@extends(Auth::user()->role==2? 'layouts.coadmin':'layouts.admin')
@section('content')
                         <div class="text-right">
                           
                           <button type="button" onclick="goBack()" class="btn btn-info">Go Back</button>


<script>
function goBack() {
  window.history.back();
}
</script>  

</div>
<meta name="csrf-token" content="{{ csrf_token() }}">
  <style>
   .error{ color:red; } 
  </style>
<div class="container">
<!-- action="{{url('assignpricetoschool')}}" enctype="multipart/form-data" -->
  <form id="priceplan" class="form-horizontal" method="post"  action="javascript:void(0)">
  
       <div class="alert alert-success d-none" id="msg_div">
              <span id="res_message"></span>
         </div>

      @if (count($errors) > 0)
         <div  class="form-group">
      <div class="alert alert-danger col-sm-10">
        <strong>Whoops!</strong> There were some problems with your input.<br><br>
        <ul>
          @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
       </div>
      @endif
   

        @if(session('success'))
        <div class="form-group">
        <div class="alert alert-success col-sm-10">
          {{ session('success') }}
        </div> 
      </div>
        @endif


        @if(session('danger'))
        <div class="form-group">
        <div class="alert alert-danger col-sm-10">
          {{ session('danger') }}
        </div> 
      </div>
        @endif

    {{csrf_field()}}

  
<div class="card text-center">
  <div class="card-header">
    <h2>Price Master Assign</h2>
  </div>
  <div class="card-body">
   <div class="row">
     <div class="col-md-6">
   <div class="form-group">
     <label class="control-label" for="Price"><strong>Price Plan</strong></label>
     <select required="required" id="price" class="form-control" name="Price">
         <option value="">Select Plan</option>
         @foreach($price as $p)
         <option value="{{$p->id}}">{{$p->name}}</option>
         @endforeach
     </select> 
 </div>
  <span class="text-danger">{{ $errors->first('name') }}</span>
     </div>
      <div class="col-md-6">
         <div class="form-group">
     <label class="control-label" for="School"><strong>School</strong></label>
     <select required="required" id="school" class="form-control" name="school[]" multiple="multiple">
         <option value="">Select School</option>
         @foreach($school as $s)
         <option value="{{$s->id}}">{{$s->school_name}}</option>
         
         @endforeach
     </select> 
 </div>
 <span class="text-danger">{{ $errors->first('name') }}</span>
     </div>

   </div>
     <button id="send_form" type="Submit" class="btn btn-primary">Submit</button>
   </div>
   
  </div>
 
</div>
    

  
  




</form>
</div>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script>
//-----------------
$(document).ready(function(){
$('#send_form').click(function(e){
   e.preventDefault();
   /*Ajax Request Header setup*/
   $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  });

   
   
   /* Submit form data using ajax*/
    var price=$('#price').val();
    var school=$('#school').val();
   
    if(price!='' && school!='')
    {
   $.ajax({
      url: "{{ url('assignpricetoschool')}}",
      method: 'post',
      data: $('#priceplan').serialize(),
        beforeSend: function() {
              $('#send_form').html('Sending..');
           },

      success: function(response){
        
        console.log(response);
       
         //------------------------
            $('#send_form').html('Submit');
            $('#res_message').show();
            $('#res_message').html(response.msg);
            $('#msg_div').removeClass('d-none');

            document.getElementById("priceplan").reset(); 
            setTimeout(function(){
            $('#res_message').hide();
            $('#msg_div').hide();
            },10000);
         //--------------------------
      }});
}
else
{
  alert('Please Select School & Price Plan');
  document.getElementById("priceplan").reset(); 
}



   });
});
//-----------------
</script>





@endsection

