@extends((Auth::user()->role==2)? 'layouts.coadmin':((Auth::user()->role==3)?'layouts.trainer':'layouts.admin'))
@section('content')
<style>
.border-class
{
  border:thin #929292 solid;
  margin:20px;
  padding:20px;
}
.switch {
  position: relative;
  display: inline-block;
  width: 60px;
  height: 34px;
}

.switch input { 
  opacity: 0;
  width: 0;
  height: 0;
}
/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}
.slider.round:before {
  border-radius: 50%;
}

</style>


    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css"  /> -->
     <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" ></script> -->
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>

             <div class="content-heading">
               <div>Location Master
                  <small data-localize="dashboard.WELCOME"></small>
                  
               </div>
               <!-- START Language list-->
               <div class="ml-auto">
                  <div class="btn-group">
                     @if(Auth::user()->role==1)
                     
                    
                  
                     @endif
					  @if(Auth::user()->role==1)
		
			 <a href="{{url('locationcr')}}" class="btn btn-warning">Create</a>
		@else
			
		 @if((session('data')[2]??0)==1)
			<a href="{{url('locationcr')}}" class="btn btn-warning">Create</a>
		   @endif
	   @endif
                
                  </div>
               </div>
               <!-- END Language list-->
            </div>

            @if($errors->any())
               @foreach($errors->all() as $err)
                  <div class="alert alert-danger">{{$err}}</div>
               @endforeach
            @endif
            @if(session()->has('success'))
               <div class="alert alert-info">{{session()->get('success')}}</div>
            @endif
 <table class="table table-hover table-striped" id="userlistid1">
  <thead>
    <tr>
      <th>#</th>
      <th>Zone</th>
      <th>Zone Id</th>
      <th>State</th>
      <th>City</th>
       @if(Auth::user()->role==1)
     <th>Status</th>
    @else
      
     @if((session('data')[2]??0)==1)
       <th>Status</th>
       @endif
     @endif
     
     
         <th>Created At</th>
         <th>Last Modified</th>
		  @if(Auth::user()->role==1)
		<th>Action</th>
		@else
			
		 @if((session('data')[2]??0)==1)
			<th>Action</th>
		   @endif
	   @endif
         
    </tr>
  </thead>
  <tbody>
    <?php $i=1?>
      @if(count($eq)>0)
    @foreach($eq as $k)
    <tr>
      <td>{{ $i++  }}</td> 
      {{-- <td><a href="{{url('locationv/'.base64_encode($k->id))}}" target="__blank"> {{$k->zone}}</a></td> --}}
      <td>{{$k->zone}}</td>
      <td>{{$k->Zone_id}}</td>
         <td>
            <?php

            $countState = 0;
            $totalState = count(Helper::getState($k->Zone_id));
               foreach(Helper::getState($k->Zone_id) as $state) {

                  echo $state->state_name;
                  echo"&nbsp;&nbsp;<b>". $state->state_id . "<b>";


                  $countState = $countState+1;
                  if($countState < $totalState){

                     echo " <b>|</b> ";
                  }
               }
            ?>
         </td>

         <td>
            <?php

            $countCity = 0;
            $totalCity = count(Helper::getCity($k->Zone_id));
               foreach(Helper::getCity($k->Zone_id) as $city) {

                  echo $city->city_name;

                  echo"&nbsp;&nbsp;<b>". $city->city_id. "</b>";

                  $countCity = $countCity+1;
                  if($countCity < $totalCity){

                     echo " <b>|</b> ";
                  }
               }
            ?>
         </td>
       

           @if(Auth::user()->role==1)
      <td><label class="switch"><input data-zone_id="{{$k->Zone_id}}" id="{{$k->Zone_id}}" class="toggle-class" class="switch" type="checkbox" data-onstyle="success" data-offstyle="danger" data-toggle="toggle" data-on="Active" data-off="InActive" {{ $k->status ? 'checked' : ''}}><span class="slider"></span></label></td> 
    @else
      
     @if((session('data')[2]??0)==1)
        <td><label class="switch"><input data-zone_id="{{$k->Zone_id}}" id="{{$k->Zone_id}}" class="toggle-class" class="switch" type="checkbox" data-onstyle="success" data-offstyle="danger" data-toggle="toggle" data-on="Active" data-off="InActive" {{ $k->status ? 'checked' : ''}}><span class="slider"></span></label></td> 
       @endif
     @endif

          

           

      <td>{{date('d-m-Y',strtotime($k->created_at))}} </td>
         <td>{{date('d-m-Y',strtotime($k->updated_at))}} </td>
		   @if(Auth::user()->role==1)
		@if($k->status==1)
         <td> 
            <button id="tttt{{$k->Zone_id}}" class="btn btn-sm btn-outline-success" onclick="myFunction('{{$k->Zone_id}}')">
               <i class="fa fa-edit"></i> 
            </button> 

            <button hidden class="btn btn-sm btn-outline-danger" id="tempdelid-{{$k->id}}" onclick="myfuntemp(this)"><i class="fa fa-trash"></i> </button>
         </td>

      @else
        <td > 
            <button disabled="" class="btn btn-sm btn-outline-success" id="tttt{{$k->Zone_id}}" onclick="myFunction('{{$k->Zone_id}}')">
               <i class="fa fa-edit"></i> 
            </button> 

            <button hidden class="btn btn-sm btn-outline-danger" id="tempdelid-{{$k->id}}" onclick="myfuntemp(this)"><i class="fa fa-trash"></i> </button>
         </td>

         @endif
		@else
			
		 @if((session('data')[2]??0)==1)
			@if($k->status==1)
         <td> 
            <button id="tttt{{$k->Zone_id}}" class="btn btn-sm btn-outline-success" onclick="myFunction('{{$k->Zone_id}}')">
               <i class="fa fa-edit"></i> 
            </button> 

            <button hidden class="btn btn-sm btn-outline-danger" id="tempdelid-{{$k->id}}" onclick="myfuntemp(this)"><i class="fa fa-trash"></i> </button>
         </td>

      @else
        <td > 
            <button disabled="" class="btn btn-sm btn-outline-success" id="tttt{{$k->Zone_id}}" onclick="myFunction('{{$k->Zone_id}}')">
               <i class="fa fa-edit"></i> 
            </button> 

            <button hidden class="btn btn-sm btn-outline-danger" id="tempdelid-{{$k->id}}" onclick="myfuntemp(this)"><i class="fa fa-trash"></i> </button>
         </td>

         @endif
		   @endif
	   @endif


      
    </tr>
 
    
    @endforeach
    @else
         No Record Found.....
      @endif
  </tbody>
 </table>







@endsection

@section('header')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
@endsection

@section('footer')

 
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="position: absolute;">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="exampleModalLabel">Zone List</h4>
      </div>
      <div class="modal-body">
         
         <div id="ZoneListData"> sdafbvdj </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script>
   function myFunction(zone_id) {
    
      var appendData = '';
      $.ajax({
            type: "get",
            url: "{{url('zone_list')}}",
            data: {zone_id:zone_id},
            
            success: function(data){

            appendData += '<table class="table table-hover table-striped" id="userlistid1">';
            appendData += '<thead>';
            appendData += '<tr>';
            appendData += '<td> # </td>';
            appendData += '<td> Zone </td>';
            appendData += '<td> State </td>';
            appendData += '<td> City </td>';
            appendData += '<td colspan="2"> Action </td>';
            appendData += '</tr>';
            appendData += '</thead>';
            appendData += '<tbody>';

               $.each(data, function(index, item) {

                  console.log(item);
               
                  appendData += '<tr>';
                  appendData += '<td>'+ item.id  +'</td>';
                  appendData += '<td>'+ item.zone  +'</td>';
                  appendData += '<td>'+ item.state_name  +'</td>';
                  appendData += '<td>'+ item.city_name  +'</td>';

         appendData += '<td> <a href="{{url("locationed")}}/'+item.Zone_id+'" class="btn btn-sm btn-outline-success"><i class="fa fa-edit"></i> </a> </td>';

                  appendData += '<td> <button class="btn btn-sm btn-outline-danger" id="tempdelid-'+item.id+'" onclick="myfuntemp(this)"><i class="fa fa-trash"></i> </button> </td>';

                  appendData += '</tr>';

               });

                

            appendData += '</tbody>';
            appendData += '</table>';

            $('#myModal').modal('show');
            $('#ZoneListData').html(appendData);

            }

            });

   }
</script>

 <script type="text/javascript">
  $(document).ready(function(){
    $('#userlistid13').DataTable({
         // "order": [[ 0, "asc" ]]
      });
  });

   function myfuntemp(arg) {
      var ad=$(arg).attr('id');
      var ak=ad.split('-');
      // alert('val = '+ak[1]);
      if(confirm("Do you really want to delete this."))
         window.location.href='{{url("/locationdel")}}/'+btoa(ak[1]);
         // alert("yes");
   }
 </script>


<script>
  $(function() {
    $('.toggle-class').change(function() {
          
        var status = $(this).prop('checked') == true ? 1 : 0; 
        var zone_id = $(this).data('zone_id'); 
      
        var r = confirm("Do You want to change status");
            if(r == true)
            {

        $.ajax({
            type: "GET",
            dataType: "json",
            url: "{{url('zone_Active_inctive')}}",
            data: {'status': status, 'zone_id': zone_id},
            success: function(data){
              console.log(data.success);
        
              if(status==0)
              {
                 $('#tttt'+zone_id).attr('disabled', true);
              }
              else
              {
                $('#tttt'+zone_id).attr('disabled', false);
              }
             

            }
        });
        }
       else
        {
          
         
           s=1-status;

         
           if(s==0)
           {
        
          $('#'+zone_id).prop("checked", false);
            }
            else
            {
             
            $('#'+zone_id).prop("checked", true);
            }
          
         }


    })
  })
</script>




@endsection



