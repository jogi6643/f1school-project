@extends('layouts.student')
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
   
<div class="bg3">
  <div class="container">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active" aria-current="page">Competition</li>
        </ol>
      </nav>
    <div class="row">
      <div class="col-md-8">
        
          <div class="accordion saf-activity-accordion" id="accordionExample">
		  <?php $btnIncre = 1;?>
@foreach($competition as $key1=>$val)
            <div class="card">
              <div class="card-header" id="headingOne">
                <h2 class="mb-0">
                  <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapse{{$val->id}}" aria-expanded="true" aria-controls="collapseOne">
                    <div class="cards_title">
                        <!--  <span><img src="img/comp.png" width="25px" style="margin-right: 10px;"></span>-->{{ $val->Competition_name }}
                    </div>
                  </button>
                </h2>
              </div>

              <div id="collapse{{$val->id}}" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                <div class="card-body">
                 <!-- <img src="https://picsum.photos/800/300" width="100%"> -->
                    <a  class="btn btn-outline-danger btn-block bg7" data-toggle="collapse" href="#collapseExample1{{$val->id}}" role="button" aria-expanded="false" aria-controls="collapseExample" >Competition short description and Guidelines</a>
						
						<div class="collapse" id="collapseExample1{{$val->id}}">
						  <div class="card card-body">
							<p>Long Description : </br> {{ $val->Ldescription }}</p> 
                           <p>{{ $val->Sdescription }}</p>
						 </div>
						</div>
					
                  <h3 class="f3">Submissions</h3>
				 @if(date('m/d/Y') < $val->Start_Date)
         
                  <ul class="counter-submission">
				     <li><span id="days{{$val->id}}"></span>days</li> :
                    <li><span id="hours{{$val->id}}"></span>Hours</li> :
                    <li><span id="minutes{{$val->id}}"></span>Minutes</li> :
                    <li><span id="seconds{{$val->id}}"></span>Seconds</li>
                    
                    
                  </ul>
				  @else
					  <p style="text-align:center;" >closed</p>
				  @endif
				  			<script>
  const second = 1000,
      minute = second * 60,
      hour = minute * 60,
      day = hour * 24;


var date="{{date('M d, Y 00:00:00',strtotime($val->Start_Date))}}";

let countDown = new Date(date).getTime(),
    x = setInterval(function() {    

      let now = new Date().getTime(),
          distance = countDown - now;

      document.getElementById('days{{$val->id}}').innerText = Math.floor(distance / (day)),
        document.getElementById('hours{{$val->id}}').innerText = Math.floor((distance % (day)) / (hour)),
        document.getElementById('minutes{{$val->id}}').innerText = Math.floor((distance % (hour)) / (minute)),
        document.getElementById('seconds{{$val->id}}').innerText = Math.floor((distance % (minute)) / second);

      //do something later when date is reached
      //if (distance < 0) {
      //  clearInterval(x);
      //  'IT'S MY BIRTHDAY!;
      //}

    }, second)

</script>
                 
				 <?php $file_inc = 0; ?>
				   @if(!empty($val->title_name))
                  <a data-toggle="collapse" data-target="#collapser{{$val->id}}" aria-expanded="true" aria-controls="collapser{{$val->id}}"  class="btn btn-outline-danger btn-block bg7" >Reference Document</a>
                  <div class="collapse" id="collapser{{$val->id}}">
						  <div class="card card-body">
                  <div class="card_team_content table_red_border">
                    <table class="table table-borderless text-center">
                      <thead>
                        <tr>
                          <th scope="col">Title</th>
                          <th scope="col">File</th>
                          <th scope="col">Document Download</th>
                        </tr>
                      </thead>
					 
                      <tbody>
					  @foreach(json_decode($val->title_name) as $title_value)
                        <tr>
                          <td> 
						    <?php
									  $imagee1=json_decode($val->file_name)[$file_inc];
								  
									  $ext = pathinfo("public/team/doc_image/$imagee1", PATHINFO_EXTENSION);
                             ?>
						  @if($ext == 'pdf')
                             <img src="{{url('team/doc_image/pdfdummy.png')}}" width="50px" class="img-fluid"/>&nbsp; &nbsp;   
                          @else
                            <img src="{{url('compitision_image')}}/{{json_decode($val->file_name)[$file_inc] }}"  width="50px" class="img-fluid"/>&nbsp; &nbsp;
                          @endif 
						</td>
                          <td>{{ $title_value }}</td>
						  @if(!empty(json_decode($val->file_name,true)[$file_inc]))
							<td>
							  <a href="{{url('compitision_image')}}/{{json_decode($val->file_name)[$file_inc] }}" target="_blank" class="btn btn-info"> Download Document </a>
							</td>
                          @endif
                          
                        </tr>
						 <?php $file_inc++; ?>
                       @endforeach
                      </tbody>
                    </table>
                  </div>
              </div>
          </div>
				 @endif

				 
				 

  <?php $increse = 0;?>

  @if(!empty($val->support_title))
                  <a  class="btn btn-outline-danger btn-block bg7" data-toggle="collapse" data-target="#collapses{{$val->id}}" aria-expanded="true" aria-controls="collapser{{$val->id}}"  class="btn btn-outline-danger btn-block bg7">Submissions</a>
                 <div class="collapse" id="collapses{{$val->id}}">
						  <div class="card card-body">
                  <div class="card_team_content table_red_border">
                    <table class="table table-borderless text-center">
                      <thead>
                        <tr>
                          <th scope="col">Document Name </th>
                          <th scope="col">Submission By </th>
                          <th scope="col">Uploaded File</th>
						   <th scope="col">Uploaded By</th>
                        </tr>
                      </thead>
					 
                      <tbody>
				 @foreach(json_decode($val->support_title) as $key => $support_value) 
                        <tr>
                          <td> 
						     {{ $support_value }}
						</td>
                          <td>{{json_decode($val->support_from)[$increse] ==1 ? 'Team': 'Individual' }}</td>
						 
	<td> 
	
	
	 @if(in_array($key,$hide))
	  
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
  
	</td>
	<td>
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
 
	</td>
                   
                          
                        </tr>
						 <?php $increse++; ?>
                       @endforeach
                      </tbody>
                    </table>
                  </div>
               </div>
           </div>
				 @endif
					<a data-toggle="collapse" data-target="#collapses{{$val->id}}" aria-expanded="true" aria-controls="collapser{{$val->id}}"
 class="btn btn-outline-danger btn-block bg7">Award List</a>
                <div class="collapse" id="collapses{{$val->id}}">
						  <div class="card card-body">
					<div class="card_team_content table_red_border">
					 @if(count($val->awardsTeam)>0)
                    <table class="table table-borderless text-center">
                      <thead>
                        <tr>
                          <th scope="col">Image</th>
                          <th scope="col">Award Name</th>
                         
                        </tr>
                      </thead>
                      <tbody>
					   
                          @foreach($val->awardsTeam as $aw)
                        <tr>
                          <td><img width="100" height="100" style="border-radius: 50%" src="{{url('compitision_image/15857484210.png')}}" class="img-fluid"></td>
                          <td>{{$aw->awardsname}}</td>
                        </tr>
                       @endforeach
						 
                      </tbody>
					  
                    </table>
					 @else
						 <p style="text-align:center"> No Award </p>
						  @endif
                  </div>
              </div>
          </div>


                </div>
              </div>
            </div>

<?php $btnIncre++;?>
			@endforeach
        
         
          </div>

      </div>
      <div class="col-md-4">
        <!--Notification-->
        <div class="cards">
          <div class="cards_title">
            <span><img src="{{url('assets1/img/update-ico.png')}}" width="100%"></span>Notifications<span class="cards_title_redirect"><img src="{{url('assets1/img/redirect.png')}}" width="100%"></span>
          </div>
          <div class="cards_list">
            <ol>
              <li>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.</li>
              <li>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</li>
              <li>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.</li>
            </ol>
          </div>
        </div>
        <!--Notification END-->

        <!--Exploare Certificate Courses-->
        <div class="cards">
          <div class="cards_title">
            <span><img src="{{url('assets1/img/redirect.png')}}"f width="100%"></span>Explore Certificate Courses
          </div>
          <div class="cards_list">
            <ol>
              <li class="course"><div class="text">1. Lorem Ipsum is simply dummy text of the printing and typesetting industry.</div><span><a href="#" class="text-danger">View</a> <a href="#" class="text-secondary">Attempt</a></span></li>
              <li class="course"><div class="text">2. Lorem Ipsum is simply.</div><span><a href="#" class="text-danger">View</a> <a href="#" class="text-secondary">Attempt</a></span></li>
              <li class="course"><div class="text">3. Dummy text of the printing.</div><span><a href="#" class="text-danger">View</a> <a href="#" class="text-secondary">Attempt</a></span></li>
            </ol>
          </div>
        </div>
        <!--Exploare Certificate Courses END-->

        <!--Upcoming Events-->
        <div class="cards">
          <div class="cards_title">
            <span><img src="{{url('assets1/img/update-ico.png')}}" width="100%"></span>Upcoming Events
          </div>
          <div class="cards_list">
            <ol>
              <li>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.</li>
              <li>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</li>
              <li>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.</li>
            </ol>
          </div>
        </div>
        <!--Upcoming Events END-->
      </div>
    </div>
  </div>
</div>

</div>







  
@endsection 


