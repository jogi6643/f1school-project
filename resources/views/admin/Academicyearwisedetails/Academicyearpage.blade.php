 @extends('layouts.admin')
 @section('content')
 
            <div class="content-heading">
               <div>Academic Year ::{{$ac_year}}
                  <small data-localize="dashboard.WELCOME"></small>
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
   <div class="col-md-12">
         <form method="post" action="{{url('check-data-according-to-year-wise')}}">
            @csrf

        <div cass="col-md-12">
       <label>Academic Year</label>
            <div class="form-group">
           <select required=""  class="form-control"  name="academicyear">

    <option value="">Academic year</option>
    {{ $year1 = date('Y')+1 }}
   
    @for ($year = 2015; $year <= $year1; $year++)
     {{ $yesr2 = ($year-1)."-".$year}}
   <option @if($yesr2==$ac_year) selected="selected" @endif value="<?=($year-1)."-".($year);?>"><?=($year-1)."-".$year;?></option>
    @endfor
</select>
           </div>
       </div>

            
           
            <br>
            <div class="text-center"> <button type="submit" class="btn btn-success">Check Data According to Academic Year</button> </div>
         </form>
      
   </div>
<br>
@if(isset($team[0]->academicyear))
<h3 hidden="" class="text-center"> Teams ::{{$team[0]->academicyear}}</h3>

<div hidden="" class="col-md-12">
    <table class="table table-striped table-bordered" id="planlistid">
  <thead>
    <tr>
      <th>#</th>
      <th hidden="">Academic Year</th>
      <th>Image</th>
      <th>Team Name</th>
      <th>School Name</th>
      <th hidden="">Created by</th>
      <th>Created by</th>
      <th>Viem Member</th>
    </tr>
  </thead>
  <tbody>
      <?php $i=1?>
  @foreach($team as $row)
  <?php 
    $ids = $row->id."_".$row->student_id."_".$row->school_id;
  ?>
    <tr>
     <td>{{$i++}}</td>
    <td hidden="">{{$row->academicyear}}</td>
     <td>
      @if($row->team_Image!=null)
      <img style="height: 50px;width:50px; border-radius: 50%;" src="{{url('team/')}}/{{ $row->team_Image }}">
      @else
      <img style="height: 50px;width:50px; border-radius: 50%;" src="{{url('team/pro.jpg')}}">
      @endif

     </td>
  
     <td><a target="__blank" href="{{ url('viewteampage'.'/'.base64_encode($row->id)) }}">{{$row->team_Name}}</a></td>
     <td> <a href="{{url('schoolv'.'/'.base64_encode($row->school_id)) }}" target="__blank">{{$row->school_name}}</a></td>
     
    <th hidden="">{{$row->ss[1]}} </th>
    <th>
      {{$row->Type}}
    </th>
         
      <td>

       <a href="{{url('editteambyad/'.base64_encode($ids))}}"><button type="button" class="btn btn-warning">Edit Team</button></a>

       <a href="{{url('deleteteambyad/'.base64_encode($ids))}}"><button type="button" class="btn btn-danger">Delete Team</button></a>
      </td>  
        
    </tr>
  @endforeach  

  </tbody>
 </table>

@else
<h2 hidden="" class="text-center">No Team </h2>
@endif 
</div>

@if(count($eq)>0)
<div class="col-md-12">
     <h2 class="text-center">Plans</h2>
   <table class="table table-hover table-striped" id="userlistid">
  <thead>
    <tr>
      <th>#</th>
      <th hidden="">Year</th>
         <th>Name</th>
         <th>Fee per Student</th>
         <th>Course List</th>
         <th>Created At</th>
         <th></th>
      @if(Auth::user()->role==1)
          <th></th>
      
        @else
         @if((session('data')[7]??0)==1)
          <th></th>
           @endif
        @endif
         
         
    </tr>
  </thead>
  <tbody>
     <?php $i =1; ?>
    @foreach($eq as $k)
   <?php $info = $k->id."_".$k->academicyear; 
   
   ?>
    <tr>
      <td>{{$i}}</td> 
      <td hidden="">{{$k->academicyear}}</td>
      <td><a href="{{url('available-student-in-plan'.'/'.base64_encode($info)) }}" target="__blank">{{$k->name}}</a></td>
      <td>{{$k->fee_per_student}} </td>
      <td>{{$k->course_list}} </td>
      <td>{{$k->created_at}} </td>
       @if(Auth::user()->role==1)
          <td>
                <a href="{{url('membershiped').'/'.base64_encode($k->id)}}" class="btn btn-sm btn-outline-success"><i class="fa fa-edit"></i> </a> 
              </td>
        @else
         @if((session('data')[7]??0)==1)
          <td>
                 <a href="{{url('membershiped').'/'.base64_encode($k->id)}}" class="btn btn-sm btn-outline-success"><i class="fa fa-edit"></i> </a>
               </td>
           @endif
        @endif  
    </tr>
    <?php $i = $i+1;?>
    @endforeach

  </tbody>
 </table>
 @else
<h2 class="text-center"> No Plan Available </h2>
@endif 
</div>


    @if(count($eq1)>0)
      <?php $m=1;?>
      <h2 class="text-center">Competitions</h2>
  <table class="table table-hover table-striped" id="userlistid">
  <thead>
    <tr>
      <th>#</th>
         <th hidden="">Academic Year</th>
         <th>Competition Name</th>
         <th>School/Team</th>
      <th>Level</th>
      <th>Short Description</th>
      <th>Long Description</th>
      <th>Ragistration Date</th>
         <th>Start Date</th>
     @if(Auth::user()->role==1)
           <th>Nominate</th>
       <th>View</th>
       <th>Action</th>
    @else
        <th>View</th>
     @if((session('data')[3]??0)==1)
          <th>Nominate</th>
        
         <th>Action</th>
       @endif
    
      @endif
       
    </tr>
  </thead>
  <tbody>
    
    @foreach($eq1 as $k)
    <tr>
      <td>{{$m}}</td> 
        <td hidden="">{{$k->academicyear}}</td>
      <td><a href="{{url('referencedocument')}}/{{base64_encode($k->id)}}">{{$k->Competition_name}}</a></td>
      <td><a href="{{url('academic-year-competition-school-Team')}}/{{base64_encode($k->id)}}">School/Team</a></td>
         <td>{{$k->levelnameid}} </td>
         <td>{{$k->Sdescription}} </td>
         <td>{{$k->Ldescription}} </td>
         
      <td>{{date('d-m-Y',strtotime($k->Ragistration_Date))}} </td>
         <td>{{date('d-m-Y',strtotime($k->Start_Date))}} </td>
      @if(Auth::user()->role==1)
         <td> <a href="{{url('nominate').'/'.base64_encode($k->id)}}" >Nominate/Remove</a></td>
       <td><a href="{{url('viewschoolincompition').'/'.base64_encode($k->id)}}">View</td>
            <td> <a href="{{url('editcompetition').'/'.base64_encode($k->id)}}" class="btn btn-sm btn-outline-success"><i class="fa fa-edit"></i> </a> <button class="btn btn-sm btn-outline-danger" id="tempdelid-{{$k->id}}" onclick="myfuntemp(this)"><i class="fa fa-trash"></i> </button> </td>
     
    @else
       <td><a href="{{url('viewschoolincompition').'/'.base64_encode($k->id)}}">View</td>
     @if((session('data')[3]??0)==1)
         <td> <a href="{{url('nominate').'/'.base64_encode($k->id)}}" >Nominate/Remove</a></td>
    
            <td> <a href="{{url('editcompetition').'/'.base64_encode($k->id)}}" class="btn btn-sm btn-outline-success"><i class="fa fa-edit"></i> </a> <button class="btn btn-sm btn-outline-danger" id="tempdelid-{{$k->id}}" onclick="myfuntemp(this)"><i class="fa fa-trash"></i> </button> </td>
     
       @endif
        
     @endif
     
         
              
    </tr>
    <?php $m=$m+1;?>
    @endforeach
   
  </tbody>
 </table>

@else
<h2 class="text-center"> No Competition Available</h2>
@endif


@if(count($sctr)>0)
<div class="col-md-12">
     <h2 class="text-center">School Trainer</h2>
   <table class="table table-hover table-striped" id="userlistid">
  <thead>
    <tr>
      <th>#</th>
      <th hidden="">Academic Year</th>
         <th>School Name</th>
         <th>Trainer</th>
      
         
         
    </tr>
  </thead>
  <tbody>
     <?php $i =1; ?>
    @foreach($sctr as $k)
 
    <tr>
      <td>{{$i}}</td> 
      <td hidden="">{{$k->year}}</td>
      <td><a href="{{url('schoolv'.'/'.base64_encode($k->school_id)) }}" target="__blank">{{$k->school_name}}</a></td>
      <td>{{$k->trainer_name}} </td>
    </tr>
    <?php $i = $i+1;?>
    @endforeach

  </tbody>
 </table>
 @else
<h2 class="text-center"> No School Trainer </h2>
@endif 
</div>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
<script type="text/javascript"  src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
   <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
 <script type="text/javascript">
  $(document).ready(function(){
    $('#planlistid').DataTable();
  });

 </script>
@endsection

