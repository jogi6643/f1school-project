@extends('layouts.admin')
@section('content')


<script>
	function goBack() {
	  window.history.back();
	}
</script>

<style>
  * {
    font-family: sans-serif;
  }

  div.tree-multiselect {
   	border: 0px solid #D8D8D8 !important; 
    border-radius: 5px;
    display: table;
    height: inherit;
    width: 100%;
}
div.tree-multiselect>div.selections {
    border-right: solid 0px #D8D8D8 !important;
}
div.tree-multiselect div.title {
    background: #777;
    color: white;
    padding: 2px;
    display: none;
    font-weight: bolder;
}
</style>

<link rel="stylesheet" href="{{url('public/js/jquery.tree-multiselect.min.css')}}">

<script src="{{url('public/js/jquery-1.11.3.min.js')}}"></script>
<script src="{{url('public/js/jquery-ui.min.js')}}"></script>
<script src="{{url('public/js/jquery.tree-multiselect.js')}}"></script>


<div class="container">
	<div class="text-right">
		<button type="button" onclick="goBack()" class="btn btn-info">Go Back</button>
		<h4 class="text-left">Nominate</h4>
	</div>
</div><!-- container--->


<div class="card">
  <div class="card-body">
  

  @if(count($team) > 0)

  @foreach($team as $key=>$school)

  <?php $key1=explode("_",$key); ?>

   <div class="accordion" id="accordionExample">
    
    <button class="btn btn-primary btn-lg btn-block text-left text-bold" type="button" data-toggle="collapse" data-target="#collapse_{{ $key1[0] }}" aria-expanded="true" aria-controls="collapse{{ $key1[0] }}" style="border-radius:0px; font-size:16px;">
      <span> + </span> {{ $key1[1] }} 
    </button>

    <div id="collapse_{{ $key1[0] }}" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">


    <form id="formData_{{$key1[0]}}" method="post">

    {{ @csrf_field() }}

    <div class="row">	
	  <div class="col-sm-12">
        		
	  	<input type="text" hidden value="{{$compid}}" name="cmpid">
      <input hidden type="text" value="{{$key1[0]}}" name=schoolid>

	  	<select id="test-select-{{$key1[0]}}" multiple="multiple" name="schoolTeam[]">	
	  	@if(count($school)!=0)
        
        @foreach($school as $scoolteam)
        @if($scoolteam['shoolidincomp']==1)

            <option value="{{$scoolteam['id']}}" selected="" data-section="{{$key1[1]}}">{{$scoolteam['team_Name']}}</option>

        @else
            <option value="{{$scoolteam['id']}}" data-section="{{$key1[1]}}">{{$scoolteam['team_Name']}}
            </option>
        @endif
        @endforeach
        @else

            <option hidden value="No Team Assgin Yet" data-section="{{$key1[1]}}" readonly>No Team Assgin Yet</option>
        @endif	

        <script type="text/javascript">
          var tree1 = $("#test-select-{{$key1[0]}}").treeMultiselect({ 
            allowBatchSelection: false,
            enableSelectAll: false,
            searchable: false,
            sortable: false,
            startCollapsed: false
        });
     </script>
   </select>

	</div><!-- col-sm-12-->
	</div><!--row-->

  @if(count($school)!=0)

    <?php  $storeTeamStatus = []; ?>

    @foreach($school as $scoolteam)

        <?php $storeTeamStatus = $scoolteam['shoolidincomp']; ?>

    @endforeach


  @if($storeTeamStatus==1)

      <div class="row">

        <div class="col-md-6">
           <button  disabled id="btn_{{$key1[0]}}" type="submit" class="btn btn-warning" onclick="selectfunction('{{$key1[0]}}')"> Nominated</button>
         </div>

         <div btn_{{$key1[0]}}  class="col-md-6">
           <a href="{{url('nominatedschooldelete')}}/{{base64_encode($key1[0])}}">
            <button  id="btnh_{{$key1[0]}}" type="button" class="btn btn-danger">Remove from for Nominate List</button>
           </a>
         </div>

      </div>
      @else

      <div class="row">

        <div class="col-md-6">
          <input type="submit" id="btn_{{$key1[0]}}" class="btn btn-success" onclick="selectfunction('{{$key1[0]}}')" value="Continueing for Nominate"> 
         </div>

         <div btn_{{$key1[0]}}  class="col-md-6" hidden="">
           <a href="{{url('nominatedschooldelete')}}/{{base64_encode($key1[0])}}">
            <button  id="btnh_{{$key1[0]}}" type="button" class="btn btn-danger">Remove from for Nominate List</button>
           </a>
         </div>

      </div>
   @endif

   @endif

  </from>

  </div><!--collapse-->
  </div><!--accordion-->

   @endforeach
   @else
   		<div> No Record... </div>
   	@endif



</div><!-- cared body-->
</div><!-- card -->


@endsection

@section('footer')


<script>


function selectfunction(schoolid)
  {
  
  alert(schoolid);

  var data = $("#test-select-"+schoolid).val();

  $("#formData_"+schoolid).on('submit',(function(e) {
     
  e.preventDefault();

  $.ajax({
   url: "{{url('nominateschoolteam')}}",
   type: "POST",
   data:  new FormData(this),
   contentType: false,
         cache: false,
   processData:false,
   beforeSend : function()
   {
      $("#btn_"+schoolid).text('loading.....');
   },
   success: function(data)
      {
   
        console.log(data);

      //  $("#btn_"+schoolid).text('Nominated');
      // $("#btn_"+schoolid).removeClass("#btn_"+schoolid).addClass("btn  btn-warning"). $("#btn_"+schoolid).attr("disabled", true);
     //location.reload();

      // $("#form_"+schoolid)[0].reset(); 

      },
     error: function(e) 
      {
       $("#err").text('Error Occured').fadeout();
      }          
    });
 }));
}
</script>


@endsection