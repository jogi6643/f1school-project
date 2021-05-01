@extends(Auth::user()->role==2? 'layouts.coadmin':'layouts.admin')
@section('content')
 
             <div class="content-heading">
               <div>  <h2>{{$compitionname}}</h2>
                  <small data-localize="dashboard.WELCOME"></small>
                  <!-- <a href="{{url('downloadAlbum').'/'.base64_encode($cmpid)}}">Bulk Button</a> -->
               </div>
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
         <th>School Name</th>
         <th>Competition Name</th>
         <th>File Name</th>
      <th>Team Name</th>
      <th>Upload by</th>
         <th>Upload Time</th>
       
         <th>Download</th>
      
    </tr>
  </thead>
  <tbody>
      @if(count($downloadcompdocument)>0)
      <?php $i=1;?>
    @foreach($downloadcompdocument as $key=>$k)
      

    <tr>
      <td>{{$i}}</td> 
        <td> <a href="{{url('schoolv/'.base64_encode($k->school_id))}} " target="__blank">{{$k->school}}</a></td>
      <td><a href="{{url('nominate')}}/{{base64_encode($k->competition_id)}}">{{$k->CompitionName}}</a></td>
      
        <td>{{$k->title}} </td>
        
          @if($k->TeamName!='N/A' )
         <td> <a href="{{url('viewteampage')}}/{{base64_encode($k->team_id)}}">{{$k->TeamName}} </a></td>
            @else
            <td> 
       N/A
           </td>
            @endif

        
         <?php
$ids=$k->school_id."_".$k->student_id;
         ?>
         <td><a href="{{url('viewstudentinfoadmin')}}/{{base64_encode($ids)}}">{{$k->StudentName}} <a></td>
         <td>{{$k->created_at}}</td>
         <td> 
       
     <a href="{{url('public/team/doc_image/')}}/{{$k->image}}" target="_blank" >download file</a>
        </td>
     
        
          
    </tr>
<?php $i=$i+1;?>
    
    @endforeach

    @else
        <h3>Compitition Not Assign For any School Till Now!</h3>
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