@extends(Auth::user()->role==2? 'layouts.coadmin':'layouts.admin')
@section('content')
 
             <div class="content-heading">
               <div>{{$comp->Competition_name}}|{{$comp->academicyear}}|Awards
                  <small data-localize="dashboard.WELCOME"></small>
               </div>
               <!-- START Language list-->
			   @if(Auth::user()->role==1)
				   <div class="ml-auto">
                  <div class="btn-group">
                     <a href="{{url('add-awards')}}/{{$compid}}" class="btn btn-warning">Add Awards</a>
                 
                  </div>
               </div>
				   @else
			    @if((session('data')[3]??0)==1)
               <div class="ml-auto">
                  <div class="btn-group">
                     <a href="{{url('add-awards')}}/{{$compid}}" class="btn btn-warning">Add Awards</a>
                 
                  </div>
               </div>
			   @endif
			   @endif
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
         <th>Team Name</th>
         <th>Award</th>
         <th>School Name</th>
       @if(Auth::user()->role==1)
         <th>Action</th>
      @else
           
       @if((session('data')[3]??0)==1)
             <th>Action</th>
         @endif
      
        @endif
       
      </tr>
   </thead>
   <tbody>
  
      @if(count($showawards)>0)
      @foreach($showawards as $key=>$k)
      <tr>
         <td>{{$key+1}}</td>
         <td>{{$k->team}}</td>
         <td><a href="{{url('awards')}}/{{base64_encode($k->awardid)}}">{{$k->awardsname}}</a></td>
         <td>{{$k->schoolname}}</td>
        @if(Auth::user()->role==1)
            <td> <a href="{{url('editawards').'/'.$k->awardid}}" class="btn btn-sm btn-outline-success"><i class="fa fa-edit"></i> </a> 
 <a href="{{url('deletewards').'/'.$k->awardid.'/'.$comp->id.'/'.$k->teamid}}" class="btn btn-sm btn-outline-danger"><i class="fa fa-trash"></i> </a> </td>
      @else
         
       @if((session('data')[3]??0)==1)
            <td> <a href="{{url('editawards').'/'.$k->awardid}}" class="btn btn-sm btn-outline-success"><i class="fa fa-edit"></i> </a> <a href="{{url('deletewards').'/'.$k->awardid.'/'.$comp->id.'/'.$k->teamid}}" class="btn btn-sm btn-outline-danger"><i class="fa fa-trash"></i> </a> </td>
       
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