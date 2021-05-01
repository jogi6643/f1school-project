@extends(Auth::user()->role==2? 'layouts.coadmin':'layouts.admin')
 @section('content')

 <style>

 </style>
            <div class="content-heading">
               <div>School Master Plan
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
           
           <div class="text-right">
                           
                           <button type="button" onclick="goBack()" class="btn btn-info">Go Back</button>

<script>
function goBack() {
  window.history.back();
}
</script>
               </div>
         <form method="post" action="{{url('storeschoolplanmaster')}}" enctype="multipart/form-data">
            @csrf
           

            <div class="form-group">
              
               <input type="text" name="schoolid" value="{{base64_decode($school)}}" id="school_id" required class="form-control" hidden>
               <h2>{{$schoolname->school_name}}</h2>
           </div>
         
    
            <div class="form-group">
                  <label for="sel1">Select Year</label>
               <select class="form-control" name="year" id="academicyear" >
                    <option value=''>Select year</option>
               <?php for ($year=2015; $year <= date('Y')+1; $year++): ?>
                <option value="<?=($year-1)."-".($year);?>"><?=($year-1)."-".$year;?></option>
                <?php endfor; ?>
               </select>
           </div>

    <div class="form-group">
      <label for="sel1">Select Plan</label>
      <select class="form-control" name="plan[]" id="planid22" multiple="multiple">
          
        
        </select>
     </div>
            
            
            <div class="text-center"> <button type="submit" class="btn btn-success">Submit</button> </div>
         </form>
      
   </div>
   <div cass="col-md-12" hidden>
       
         
       <h1>View Assigned Plan </h1>
            <div class="form-group">
                  <label for="sel1">Select Year</label>
               <select class="form-control" name="year" >
                    <option value=''>Select year</option>
               <? for ($year=2015; $year <= 2020; $year++): ?>
                <option value="<?=($year-1)."-".($year);?>"><?=($year-1)."-".$year;?></option>
                <? endfor; ?>
               </select>
           </div>
   
   </div>
   <br/>
  
       <h2> Assigned Plan</h2>
    <table class="table table-hover table-striped" id="assignplanlistid">
  <thead>
    <tr>
       
      <th>#</th>
         
      <th>Plan Name</th>
      <th>Academic Year</th>
      <th>Total Participants</th>
      <th>Created_at</th>
         
    </tr>
  </thead>
  <tbody>
      <?php $i=1?>
       @if(count($planperschool)>0)
    @foreach($planperschool as $key=>$planperschool1)
    <tr>
     <td>{{$i}}</td>
     <td>{{$planperschool1->name}}</td> 
         <td>{{$planperschool1->year}}</td>
          <td>{{$planperschool1->counts}}</td>
         <td>{{date('d-F-Y',strtotime($planperschool1->created_at))}} </td>
    </tr>
    <?php $i++?>
    @endforeach
    @else
         No Record Found.....
      @endif
  </tbody>
 </table>
       
   
@endsection
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">

@section('footer')
  <link rel="stylesheet" href="{{asset('js/jquery.multiselect.css')}}">
  <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>

<script src="{{asset('js/jquery.multiselect.js')}}"></script>


   <script type="text/javascript">
    $('#assignplanlistid').DataTable();
    $('#planid').multiselect(
{
   columns: 4,
    placeholder: 'Select Plans',
    search: true,
    selectAll: true
}
      );


      $(document).ready(function(){
      $('#academicyear').change(function(){
      var v=$('#academicyear').val();
    
         $.ajax({
             url:"{{url('schoolplanfetchacademicyear')}}",
              data:{_token: '{!! csrf_token() !!}','v':v},
            method:'POST',
            success:function(data){
              $("#planid22").empty();
               // $('#planid22').append('<option value="#">please  Select Plan</option>');
                $.each(data,function(index,value) {
               $('#planid22').append('<option value="' + value.id + '">' + value.name+ '</option>');
             }); 
            },
            error:function(data){
              
              console.log('error');
            },
          });
});


         $('#doctypeid').change(function(){
            
            if($('#doctypeid').val()==1){
               $('#videopathid2').val('');
               $('#videopathid').hide();

               $('#docpathid').show();
            }
            else if($('#doctypeid').val()==2){
               $('#docpathid').hide();
               $('#videopathid').show();
               $('#docpathid2').val('');
            }
            else
            {
               $('#docpathid').hide();
               $('#videopathid').hide();
            }
         });
         if($('#doctypeid').val()==1){
               $('#videopathid2').val('');
               $('#videopathid').hide();

               $('#docpathid').show();
            }
            else if($('#doctypeid').val()==2){
               $('#docpathid').hide();
               $('#videopathid').show();
               $('#docpathid2').val('');
            }
            else
            {
               $('#docpathid').hide();
               $('#videopathid').hide();
            }

      });


   </script>
   
   
   
 


@endsection