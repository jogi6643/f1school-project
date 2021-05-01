@extends('layouts.trainer')
 @section('content')
            <div class="content-heading">
                  <small data-localize="dashboard.WELCOME"></small>
               </div>
              
           
          
            </div>
            

            @if($errors->any())
               @foreach($errors->all() as $err)
                  <div class="alert alert-danger">{{$err}}</div>
               @endforeach
            @endif
            @if(session()->has('success'))
               <div  class="alert alert-info">{{session()->get('success')}}</div>
            @endif

            @if(session()->has('error1'))
               <div  class="alert alert-info">{{session()->get('error1')}}</div>
            @endif

       <div class="col-md-12">
           
           <div class="text-right">
                           
                           <button type="button" onclick="goBack()" class="btn btn-info">Go Back</button>

<script>
function goBack() {
  window.history.back();
}
</script>
               </div>
               @if($planname!='NO')
                   <h2>{{$k}}</h2>
             <h3>{{$planname}}</h3>
          

   </div>
  
   <br/>
   <div class="col-md-12">


         @if($currentyear==$exyr)
      <form method="post" action="{{url('intimation')}}">
           {{ csrf_field() }}


      
          
           
   
    <table class="table table-striped table-bordered" id="courselistid">
  <thead>
    <tr>
       
      <th>#</th>
         
      <th>Course Tittle</th>
      <th>Type</th>
      <th>Assign Date 
      <!-- <button type="submit"  class="btn btn-primary">Intimation</button> -->
      </th>
    

  
         
    </tr>
  </thead>
  <tbody>
     
      <?php $i=1?>
       @if(count($Course)>0)
    @foreach($Course as $key=>$Course1)
    <tr>
     <td>{{$i}}</td>

     <td id="courseid".{{$Course1->id}}>{{$Course1->title}}<input hidden="" type="text" value="{{ $schoolid}}_{{ $planidd}}_{{$acyear}}_{{$Course1->id}}_{{$Course1->doctypeid}}"></td> 

     <td id="doctype".{{$Course1->id}}>{{$Course1->type}}</td>

    <td id="bday".{{$Course1->doctypeid}}>
    <input required="" type="date" name="data_{{ $schoolid}}_{{ $planidd}}_{{$acyear}}_{{$Course1->id}}_{{$Course1->doctypeid}}_{{$Course1->coursemaster_id}}"  value="@if(isset($ass[$Course1->id])){{$ass[$Course1->id]}}@endif"  />
		
	</td>
    </tr>
    <?php $i++?>
    @endforeach
    @else
         No Record Found.....
      @endif
     
  </tbody>
  
 </table>
       <div class="form-group">
    
    <div class="text-center"> 
    <button type="submit" class="btn btn-success btn-lg active">Submit</button> 
</div>

   </div>
 </form>
 
  @else
  
       <form method="post" action="{{url('intimation')}}">
           {{ csrf_field() }}
          <!--  
            <button type="submit"  class="btn btn-primary">Intimation</button> -->
   
         
    <table class="table table-striped table-bordered" id="courselistid">
  <thead>
    <tr>
       
      <th>#</th>
         
      <th>Course Tittle</th>
      <th>Type</th>
       <th>Assign Date
       <!-- <button type="submit"  class="btn btn-primary">Intimation</button> -->
       </th>

  
         
    </tr>
  </thead>
  <tbody>
     
      <?php $i=1?>
    @if(count($Course)>0)
    @foreach($Course as $key=>$Course1)
  <tr>
     <td>{{$i}}</td>

     <td id="courseid".{{$Course1->id}}>{{$Course1->title}}<input hidden="" type="text" value="{{ $schoolid}}_{{ $planidd}}_{{$acyear}}_{{$Course1->id}}_{{$Course1->doctypeid}}"></td> 

     <td id="doctype".{{$Course1->id}}>{{$Course1->type}}</td>

    <td id="bday".{{$Course1->doctypeid}}>
    <input required="" type="date" name="data_{{ $schoolid}}_{{ $planidd}}_{{$acyear}}_{{$Course1->id}}_{{$Course1->doctypeid}}_{{$Course1->coursemaster_id}}"  value="@if(isset($ass[$Course1->id])){{$ass[$Course1->id]}}@endif"  />
    
  </td>
    </tr>
    <?php $i++?>
    @endforeach
    @else
         No Record Found.....
      @endif
     
  </tbody>
  
 </table>
       <div class="form-group">
    
    <div class="text-center"> 
    <button type="submit" class="btn btn-success btn-lg active">Submit</button> 
</div>

   </div>
 </form>
 
 @endif

       
   </div>
@else
<h3> NO Data Avaible</h3>
@endif
              
@endsection

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">

<script type="text/javascript"  src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>



@section('footer')
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
 <script type="text/javascript">
  $(document).ready(function(){
    $('#courselistid').DataTable();
  });




function intimation(schoolid)
{
    alert("ok"+schoolid);
}

  $('#datepicker').datepicker({minDate: new Date(2000,1-1,1), maxDate: '-17Y',
      dateFormat: 'dd/mm/yy',
      changeMonth: true,
      changeYear: true,
      yearRange: '-110:-17'});

 </script>

 


@endsection