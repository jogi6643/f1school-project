@extends('layouts.student')
@section('contents')

<main role="main">
     <!--@include('sweet::alert')-->
       <div class="text-right">
                  <button type="button" onclick="goBack()" class="btn btn-info">Go Back</button>

                  <script>
              function goBack() {
                  window.history.back();
                      }
                 </script>
               </div>
    <section class="text-center">
        <div class="container">
         <h1 class="jumbotron-heading">{{$schname}}</h1>
         <p class="lead text-muted">{{$stuname}}</p>
     </div>
                
    
  </section>

  <!--<div class="album py-5 bg-light">-->
    <div class="container">

      @if (count($errors) > 0)
      <div class="alert alert-danger">
        <strong>Whoops!</strong> There were some problems with your input.<br><br>
        <ul>
          @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
      @endif

        @if(session('success'))
        <div class="alert alert-success">
          {{ session('success') }}
        </div> 
        @endif

    
<div class="container">

</div>
    <div class="card" style="width: 50rem;" >


  <div class="card-body">
      
      
 <div  id="body">

<form id="carbodyupload" method="post" action="{{url('cartype')}}" enctype="multipart/form-data">
  {{csrf_field()}}
  
   <div class="row" >
    <div class="form-group" hidden>
      <label for="paragraph">Studentid:</label>
      <input type="text" class="form-control" id="studentid" placeholder="studentid" name="studentid" value="{{$studentid}}">
    </div>
      
     <div class="form-group" hidden>
      <label for="paragraph">Schoolid:</label>
      <input type="text" class="form-control" id="schoolid" placeholder="schoolid" name="schoolid" value="{{$schoolid}}">
    </div>
  </div>

 
 <div class="row" hidden>
 <input class="form-control" id='carbody' type="text" name="type" value="Car Body">
 </div>
<div class="row">

    <div class="form-group form-group col-md-6">
      <p class="card-text">Upload Car Body</p>
    <input style="padding:3px" type="file" name="filename" class="form-control">     
 </div>
    <div class="form-group form-group col-md-6">
      <p class="card-text">Upload Prototype Car Body</p>
    <input style="padding:3px" type="file" name="prototypefilename" class="form-control">     
 </div>
</div>

          
   <button type="submit" id="carbody" class="btn btn-primary" style="margin-top:10px">Submit</button>
   <?php 
 $s=$studentid."_".$schoolid;
   $id="Null_".base64_encode($s);
      
        
        ?>
            <a href="{{url('car_bodypart_type')}}/{{$id}}"><button type="button"  class="btn btn-danger" style="margin-top:10px">Skip</button></a>

  </form> 
  
</div>


  </div>
</div>
<!--car Body Part-->

    
    


  
 
  
  <div id="err"></div>


</div>

    </div>
    </div>


</main>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<!-- <script type="text/javascript">
$(document).ready(function (e) {
 $("#carbodyupload").on('submit',(function(e) {
     
  e.preventDefault();
  $.ajax({
         url: "{{url('cartype')}}",
   type: "POST",
   data:  new FormData(this),
   contentType: false,
         cache: false,
   processData:false,
   beforeSend : function()
   {
      
    $("#preview").fadeOut();
    $("#err").fadeOut();
   },
   success: function(data)
      {
        
    if(data=='invalid')
    {
   
     $("#err").html("Invalid File !").fadeIn();
    }
    else
    {
        $('#Application').val(data);
    
      alert("Car Body Successfully uploaded");
     $("#preview").html(data).fadeIn();
     $("#carbodyupload")[0].reset(); 
     $('#Application').val(data);
      $("#part").show();
      $("#body").hide();
      $("#Type").hide();
    //   $("#cardbodypart").show()
      

     
    }
      },
     error: function(e) 
      {
    $("#err").html(e).fadeIn();
      }          
    });
 }));
});
</script>
 -->
<script type="text/javascript">

function type()
{
     var x = document.getElementById("type").value;
}

    $(document).ready(function() {

      $(".btn-success").click(function(){ 
        
          var html = $(".clone").html();
        
          $(".increment").after(html);
      });

      $("body").on("click",".btn-danger",function(){ 
          $(this).parents(".control-group").remove();
      });

    });

</script>



<script>
// function myFunction() {
//   var x = document.getElementById("mySelect").value;
// //  $('#'+x).show();
// if(x=='body'){
//     document.getElementById('body').style.display = "block";
//      document.getElementById('part').style.display = "none";
//    } else{
//     document.getElementById('part').style.display = "block";
//      document.getElementById('body').style.display = "none";
//    }

// }
</script>
@endsection

