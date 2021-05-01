@extends('layouts.CollageStudent')
@section('contents')

<meta name="csrf-token" content="{{ csrf_token() }}">

<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

<script type="text/javascript">
  $(document).ready(function() {
    $('#example').DataTable();
} );
</script>
<script>
  function goBack() {
    window.history.back();
  }
</script>

<style type="text/css">
    
    .img-set img{

        width: 120px;
        border-radius: 143px;
        border: 1px solid;
        height: 82px;
    }

    #dropBox{
    border: 3px dashed #0087F7;
    border-radius: 5px;
    background: #F3F4F5;
    cursor: pointer;
}
#dropBox{
    min-height: 150px;
    padding: 54px 54px;
    box-sizing: border-box;
}
#dropBox p{
    text-align: center;
    margin: 2em 0;
    font-size: 16px;
    font-weight: bold;
}
#fileInput{
    display: none;
} 

</style>
   
<br>
<div class="container">

<div class="text-right">
  <button type="button" onclick="goBack()" class="btn btn-info">Go Back</button>
</div>

<div class="card mb-3">

  <div class="row">

  <div class="col-md-4">
    <div class="card-body">

      <img class="card-img-top"  style="height:100px;width:100px;border-radius: 50%;" src="{{url('team/')}}/previewimg.png" alt="Card image cap">

      <h5 class="card-title"> {{ $student_name }}  </h5>
      
  </div>
  </div>
  <div class="col-md-8">
     <div class="card-body">

      <h5 class="card-title">{{$teamname->team_Name}}</h5>
      
    </div>
  </div>
  </div>
   <div class="row">
		<div class="col-md-4">
			<div class="card-body">

			  
		  </div>
		  </div>
  <div class="col-md-8">
     <div class="card-body">

      <h5 class="card-title">{{$school_name}}</h5>
      
    </div>
  </div>
 </div>
  
  </div><!-- end row-->
<!-- end card-->

<div class="accordion" id="accordionExample">  

<?php $btnIncre = 1;?>
@foreach($competition as $key1=>$val)

<p>
  <button class="btn btn-dark btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseExample_{{$btnIncre}}" aria-expanded="false" aria-controls="collapseExample">
   {{ $val->Competition_name }}
  </button>
</p>

<div class="collapse show" id="collapseExample_{{$btnIncre}}">
  <div class="card card-body">


    <p> 
     
      {{ $val->Ldescription }} 

      
    </p>

    <p> 
 
      {{ $val->Sdescription }} 
   </p>



  <?php $file_inc = 0; ?>

  @if(!empty($val->title_name))

  <h3> Reference Document </h3><hr>

   <div class="row">
    <div class="col-sm-4">
      <b> Title </b>
    </div>
     <div class="col-sm-4">
        <b> File </b>
    </div>
    <div class="col-sm-4">
        <b> Document Download </b>
    </div>
  </div><hr>
  
  @foreach(json_decode($val->title_name) as $title_value) 

   <div class="row">
   @if(!empty(json_decode($val->file_name,true)[$file_inc]))

  

    <div class="col-sm-4">
      <div class="img-set">
        <?php
      $imagee1=json_decode($val->file_name)[$file_inc];
  
      $ext = pathinfo("public/team/doc_image/$imagee1", PATHINFO_EXTENSION);
      ?>
      @if($ext == 'pdf')
      <img src="{{url('team/doc_image/pdfdummy.png')}}" class="img-fluid"/>&nbsp; &nbsp;   
      @else
     <img src="{{url('compitision_image')}}/{{json_decode($val->file_name)[$file_inc] }}" class="img-fluid"/>&nbsp; &nbsp;
      @endif 
<!-- 
        <img src="{{url('compitision_image')}}/{{json_decode($val->file_name)[$file_inc] }}" class="img-fluid"> -->


      </div>
    </div>
   
 
    @endif



    <div class="col-sm-4">
      {{ $title_value }}
    </div><!--colsm-4-->

    

@if(!empty(json_decode($val->file_name,true)[$file_inc]))
    <div class="col-sm-4">
      <a href="{{url('compitision_image')}}/{{json_decode($val->file_name)[$file_inc] }}" target="_blank" class="btn btn-info"> Download Document </a>
    </div>
    @endif

 

  </div><!-- inner row--><br>
  <?php $file_inc++; ?>

  @endforeach
  @endif



  <?php $increse = 0;?>

  @if(!empty($val->support_title))

  <h3> Submissions </h3><hr>
  <div class="row">

    <div class="col-sm-3">
     <b> Document Name </b>
    </div>
   <div class="col-sm-2">
      <b> Submission By </b>
    </div>
    <div class="col-sm-3">
      <b> Uploaded File </b>
    </div>
   <div class="col-sm-3">
      <b> Uploaded By </b>
    </div>
  </div>

  @foreach(json_decode($val->support_title) as $key => $support_value) 
   <div class="row">
   <div class="col-sm-12">
      <div class="progress_{{$key}}_{{$key1}}">
		  <div id="dynamic_{{$key}}_{{$key1}}" class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
			<span id="current-progress"></span>
		  </div>
    </div>
		</div>
		<br>
    <div class="col-sm-3">
      {{ $support_value }}
    </div>
  <div class="col-sm-2">
        {{json_decode($val->support_from)[$increse] ==1 ? 'Team': 'Individual' }}

    </div>

     <div class="col-sm-3">
    
    @if(!in_array($key,$hide))
	  
      @if($arr1[$key1][$key]['enable'])
      
      <form id="formData_{{$key}}_{{$key1}}" action="" enctype="multipart/data">
        @csrf
        <input type="hidden" name="flag" id="school_id" value="{{ $key }}">
        <input type="hidden" name="school_id" id="school_id" value="{{ $schoolid }}">
        <input type="hidden" name="student_id" id="student_id" value="{{ $studentid }}">
        <input type="hidden" name="competition_id" id="competition_id" value="{{ $val->id }}">

        <input type="hidden" name="team_id" id="team_id" value="{{ $teamid }}">

        <input type="hidden" name="title" id="title" value="{{ $support_value }}">

        <input type="hidden" name="max_size" id="max_size" value="{{json_decode($val->support_size)[$increse] }}">

        <input type="hidden" name="formet" id="formet" value="{{json_decode($val->support_formate)[$increse] }}">

        <input type="hidden" name="from_by" id="from_by" value="{{json_decode($val->support_from)[$increse] ==1 ? 'Group': 'Individual' }}">
        
        <input type="file" name="file_name" id="upload_file_{{$key}}_{{$key1}}">
      </form>
	  <br>
		
      @else
         <strong>Closed</strong>
      @endif
      <script>
		  $("#dynamic_{{$key}}_{{$key1}}").parent().hide();
		  $(function() {
	  var current_progress = 0;
	  var interval = setInterval(function() {
		  current_progress += 10;
		  $("#dynamic_{{$key}}_{{$key1}}")
		  .css("width", current_progress + "%")
		  .attr("aria-valuenow", current_progress)
		  .text(current_progress + "% Complete");
		  if (current_progress >= 100)
			  clearInterval(interval);
	  }, 1000);
	});
        $(document).ready(function(){

        $("#upload_file_{{$key}}_{{$key1}}").unbind().change(function() {
		
          var formData = new FormData($('#formData_{{$key}}_{{$key1}}')[0]);
          //alert(formData);
          $.ajax({
            type: "POST",
            url: "{{ url('documentUpload') }}",
            data: formData,
            contentType: false,
            processData: false,
			beforeSend:function(data){
				 $("#dynamic_{{$key}}_{{$key1}}").parent().show();
			},
            success: function(data){
              alert(data);
			  $("#dynamic_{{$key}}_{{$key1}}").hide();
              location.reload();
              // console.log(data);
            },
			
			 error: function(data){
              console.log(data);
             
              // console.log(data);
            },
			
            headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
          });
        });
        
        });
      </script>
   @endif

    @if(isset($arr1[$key1][$key]['name']))
     <?php 
      $imagee=$arr1[$key1][$key]['image'];
      //echo $imagee;
      $ext = pathinfo("public/team/doc_image/$imagee", PATHINFO_EXTENSION);
      ?>
      @if($ext == 'pdf')
      <img src="{{url('team/doc_image/pdfdummy.png')}}" width="50px" height="50px"/>&nbsp; &nbsp;   
      @else
     <img src="{{url('team/doc_image/')}}/{{$arr1[$key1][$key]['image']}}" width="50px" height="50px"/>&nbsp; &nbsp;
      @endif 
    @endif

         <p><b>Max Size: </b>{{json_decode($val->support_size)[$increse] }}</p>
         <p><b>Format: </b> {{json_decode($val->support_formate)[$increse] }}</p>
    </div>
    <div class="col-sm-3">
  @if(isset($arr1[$key1][$key]['name']))
      
     

      <p><b>Name:</b> {{$arr1[$key1][$key]['name']}} </span>
    
    <p><b>Upload Time:</b><?php echo date($arr1[$key1][$key]['updated_at'])?></p>
   

   @endif
 
   @if(json_decode($val->support_from)[$increse] !=1)
	   
	  @if(isset($doc[$key1][$key]))
     <br></br>
       <b style="margin-left:40px">Document Status</b><br>
      <table class="table table-bordered">
     <tr>
        <th>Name</th>
        <th>Document Status</th>
       
         </tr>
     
		@foreach($doc[$key1][$key] as $k1=>$docs)
     <tr>
       <td>{{$docs['name']}}:</td> <td>{{$docs['status']}}</td>
     </tr>
	 @endforeach
      
     </table>
	 @endif
   @endif
          
    </div>
    
    <div class="col-sm-3">
     
   
  <!-- //Documemt opload end-->

  <!-- upload document then upload file -->

  
  </div><!--cols0m3-->
  

  </div><!-- inner row--><hr>
  
  <?php $increse++; ?>
  @endforeach
  @endif
   
   <h2> Award List</h2>
   @if(count($val->awardsTeam)>0)
 @foreach($val->awardsTeam as $aw)
<table class="table">
    <thead>
      <tr>
        <th>Image</th>
        <th>Award Name</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td><img width="100" height="100" style="border-radius: 50%" src="{{url('compitision_image/15857484210.png')}}" class="img-fluid"></td>
        <td>{{$aw->awardsname}}</td>
      </tr>      
     
    </tbody>
  </table>
@endforeach
  @else
  <h1>No Award </h1>
  @endif
</div><!-- card-->
</div><br>


<div class="card">

</div>

<?php $btnIncre++;?>
@endforeach

</div>
</div><!-- container-->

@endsection 


