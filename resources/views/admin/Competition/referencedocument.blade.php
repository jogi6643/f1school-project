@extends(Auth::user()->role==2? 'layouts.coadmin':'layouts.admin')
@section('content')
 
             <div class="content-heading">
               <div>Competition Master
                  <small data-localize="dashboard.WELCOME"></small>
               </div>
               <!-- START Language list-->
			   @if(Auth::user()->role==1)
				   <div class="ml-auto">
                  <div class="btn-group">
                     
                     <button type="button" onclick="goBack()" class="btn btn-info">Go Back</button>

                           <script>
                        function goBack() {
                         window.history.back();
                               }
                        </script>
                 
                  </div>
               </div>
				   @else
			    @if((session('data')[3]??0)==1)
               <div class="ml-auto">
                  <div class="btn-group">
                     <a href="{{url('competitioncr')}}" class="btn btn-warning">Create
                     </a>
                 
                  </div>
               </div>
			   @endif
			   @endif
			   
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
 <table class="table table-hover table-striped" id="userlistid">
 	<thead>
 		<tr>
 			<th>#</th>
         <th> Reference Document Name</th>
 			<th>Link</th>
 			
       
 		</tr>
 	</thead>
 	<tbody>
      @if(count($refdocument)>0)
     
 		@foreach($refdocument as $key=>$k)
		<tr>
			<td><?= $key+1;?></td> 
        
			<td>{{$k}}</td>
         @if(isset($refdocumentfile[$key]))
           @if($refdocumentfile[$key]!="")
         <td><a target="_blank" href="{{url('compitision_image')}}/{{$refdocumentfile[$key]}}">{{$k}}</a></td>	
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
 <script type="text/javascript">
 	$(document).ready(function(){
 		$('#userlistid').DataTable();
 	});

   function myfuntemp(arg) {
      var ad=$(arg).attr('id');
      var ak=ad.split('-');
      alert('val = '+ak[1]);
      // if(confirm("Do you really want to delete this."))
         window.location.href='{{url("/delcompetition")}}/'+btoa(ak[1]);
         // alert("yes");
   }
 </script>
@endsection