@extends(Auth::user()->role==2? 'layouts.coadmin':'layouts.admin')
 @section('content')

                           
 <!--  <button type="button" onclick="goBack()" class="btn btn-info">Go Back</button> -->

<script>
function goBack() {
  window.history.back();
}
</script>

    <style>
      

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
      div.tree-multiselect .auxiliary input.search {
          border: 2px solid #D8D8D8;
          display: table-cell;
          margin: 0;
          padding: 5px;
          width: 100%;
          display: none !important;
      }

      div.tree-multiselect div.title {
          background: #777;
          color: white;
          padding: 2px;
          display: none;
          font-weight: bolder;
      }

    div.tree-multiselect .auxiliary .select-all-container {
        display: inherit !important;
        text-align: left !important;
        margin-bottom: 14px;
    }
    div.tree-multiselect>div.selections div.item {
    margin-left: 0px !important;

    }

    div.tree-multiselect div.section>div.section, div.tree-multiselect div.section>div.item {
     padding-left: 0px !important; 

    }

    


    </style>
 
    <link rel="stylesheet" href="{{url('public/js/jquery.tree-multiselect.min.css')}}">

    <script src="{{asset('js/jquery-1.11.3.min.js')}}"></script>
    <script src="{{asset('js/jquery-ui.min.js')}}"></script>
    <script src="{{asset('js/jquery.tree-multiselect.js')}}"></script>
  </head>


<div class="container">
  <div class="text-right">
    <button type="button" onclick="goBack()" class="btn btn-info">Go Back</button>
    <h4 class="text-left">Nominate - {{$competion_name[0]['Competition_name'] or ''}}</h4>
  </div>
</div>


<div class="container">
<div class="card">
<div class="card-body">

<div class="accordion" id="accordionExample">  

    @if(count($team)>0)

    @foreach($team as $key=>$school)

    <?php  $key1=explode("_",$key);?>

    <!-- <h4 class="card-title text-left">{{$key1[1]}}</h4> -->

    <button class="btn btn-primary btn-lg btn-block text-left text-bold" type="button" data-toggle="collapse" data-target="#collapse_{{ $key1[0] }}" aria-expanded="true" aria-controls="collapse{{ $key1[0] }}" style="border-radius:0px; font-size:16px;">
      <span> + </span> {{ $key1[1] }} 
    </button>
    
    <div id="collapse_{{ $key1[0] }}" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">

    <div class="card-body" id="page_refrece_{{$key1[0]}}">  

      <form id="formData_{{$key1[0]}}"  action="{{url('nominateschoolteam')}}" method="post">

        {{ @csrf_field() }}

        <input type="text"  hidden="" value="{{$compid}}" name="cmpid">
        <input type="text" hidden="" value="{{$key1[0]}}" name=schoolid>

        <select id="test-select-{{$key1[0]}}" hidden="" multiple="multiple" name="schoolTeam[]">

      
      @if(count($school)!=0)
    
       @foreach($school as $scoolteam)
     

           @if($scoolteam['shoolidincomp1']>0)
           <option  value="{{$scoolteam['id']}}" selected >
            {{$scoolteam['team_Name']}}/
           </option>
           @else
            <option value="{{$scoolteam['id']}}" data-section="{{$key1[1]}}">
              {{$scoolteam['team_Name']}}/
            </option>
           @endif
        @endforeach
      @else
        <option  value="No Team Assgin Yet" data-section="{{$key1[1]}}" readonly>
                No Team Assgin Yet</option>
      @endif
       
             <script type="text/javascript">
              var tree1 = $("#test-select-{{$key1[0]}}").treeMultiselect({ 
                 allowBatchSelection: true,
                enableSelectAll: true,
                searchable: true,
                sortable: false,
                startCollapsed: false,
                
                // ui-sortable:false
               });
             </script>
         </select>


          <div id="err"></div>

          @if(count($school)!=0)

            <?php  $storeTeamStatus = []; ?>

            @foreach($school as $scoolteam)
                     
              <?php $storeTeamStatus = $scoolteam['shoolidincomp']; ?>

            @endforeach


            @if($storeTeamStatus==1)
             
              <div class="row">
                <div class="col-md-6">
                   <button   id="btn_{{$key1[0]}}" type="submit" class="btn btn-warning" onclick="selectfunction('{{$key1[0]}}')">Nominate/Remove</button>
                 </div>
                 <div hidden="" btn_{{$key1[0]}}  class="col-md-6">
                  <?php $ids=$compid."_".$key1[0]?>
                   <a href="{{url('nominatedschooldelete')}}/{{base64_encode($ids)}}">
                    <button  id="btnh_{{$compid}}" type="button" class="btn btn-danger">Remove from for Nominate List</button>
                   </a>
                 </div>
                 </div>
                 @else
              <div class="row">
                <div class="col-md-6">
                <?php $ids=$compid."_".$key1[0]?>
                  <input type="submit" id="btn_{{$key1[0]}}" class="btn btn-success" onclick="selectfunction('{{$key1[0]}}')" value="Nominate/Remove"> 
                 </div>

                 <div hidden btn_{{$key1[0]}}  class="col-md-6" hidden="">
                   <a href="{{url('nominatedschooldelete')}}/{{base64_encode($ids)}}">
                    <button  id="btnh_{{$compid}}" type="button" class="btn btn-danger"></button>
                   </a>
                 </div>
                 </div>
            @endif

          @endif

      </form>
   </div> 
  </div>

    @endforeach
    @endif

</div>

</div>
</div>
</div>


@endsection




@section('footer')

<script>

/*
function selectfunction(schoolid)
{

   var data = $("#test-select-"+schoolid).val();
  
   

  $("#formData_"+schoolid).on('submit',(function(e){
  e.preventDefault();
alert(1)
  // alert(0);
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
        // alert(data);
        location.reload();
      },
     error: function(e) 
      {
       // $("#err").text('Error Occured').fadeout();
       // alert('Please Select an Option');
      location.reload();
      }          
    });
 }));
}
*/
</script>


  @endsection
