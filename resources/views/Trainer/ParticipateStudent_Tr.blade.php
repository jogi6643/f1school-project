@extends('layouts.trainer')
@section('content')
        <!-- <link rel="stylesheet" href='{{url("assets/css/bootstrap-example.min.css")}}' type="text/css">
        <link rel="stylesheet" href='{{url("assets/css/prettify.min.css")}}' type="text/css">
        <link rel="stylesheet" href='{{url("assets/css/bootstrap-multiselect.css")}}' type="text/css"/> -->



 <section>
                <div class="text-right">
                           
                           <button type="button" onclick="goBack()" class="btn btn-info">Go Back</button>

<script>
function goBack() {
  window.history.back();
}
</script>
               </div>
<div class="col-sm-12">
    @if($errors->any())
               @foreach($errors->all() as $err)
                  <div class="alert alert-danger">{{$err}}</div>
               @endforeach
            @endif
            @if(session()->has('success'))
               <div class="alert alert-success">{{session()->get('success')}}</div>
            @endif
   @if(session()->has('danger'))
               <div class="alert alert-danger">{{session()->get('danger')}}</div>
            @endif
</div>
<div class="row">
  <div class="col-md-4">
<div class="foo red"></div>
<h3>Already Assigned Another Plan</h3>
</div>
<div class="col-md-4">
<div class="foo green"></div>
<h3>Current Plan</h3>
</div>
<div class="col-md-4">
<div class="foo white"></div>
<h3>Ready To Assign</h3>
</div>
</div>
<style type="text/css">
.foo {
  float: left;
  width: 20px;
  height: 20px;
  margin: 5px;
  border: 1px solid rgba(0, 0, 0, .2);
}

.red {
  background: red;
}

.green {
  background: green;
}

.white {
  background: white;
}
</style>
</br>
  <form action="{{url('sbmitparticipantbyTr')}}" method="post">
 @csrf
  <div class="form-group">
              
               <input type="text" name="schoolid" value="{{base64_decode($schooldp)}}" id="school_id" required class="form-control" hidden>
               <h2>{{$schoolname->school_name}}</h2>
    </div>

    <div class="col-sm-12">
     <div class="form-group">
               
                @if(session()->has('Year'))
             <label><h3 id="replaceyear" style="color: green">Selected Academic Year  :
            {{session()->get('Year')}}
          </h3>
            </label>
           @else
           <label><h3 id="replaceyear" style="color: green">Selected Academic Year  :</h3></label>
            @endif

              <select required="" class="form-control" name="year"  id="year" onchange="membership()">

                @if(session()->has('Year'))
                 <option value="{{session()->get('Year')}}">{{session()->get('Year')}}</option>
                 @endif
                    <option value=''>Select year</option>
               <?php for ($year=2015; $year <= date('Y')+1; $year++): ?>
                <option value="<?=($year-1)."-".($year);?>"><?=($year-1)."-".$year;?></option>
                <?php endfor; ?>
               </select>
    </div>
   
      <div class="form-group">
         
            @if(session()->has('planid1') && session()->has('planname'))
             <label><h3 id="replan" style="color: green">Selected Plan  :
            {{session()->get('planname')}}
          </h3>
            </label>
           @else
           <label><h3 id="replan" style="color: green">Select Plan Name</h3></label>
            @endif
          
          <select required="" class="form-control" name="planid"  id="planid" onchange="participate1()">
          
             <label><h3 id="replan" style="color: green">Selected Plan  :
            {{session()->get('planname')}}
          </h3>
            </label>
              <option value=''>Select Plan</option>
          </select>
      </div>

    <div id="planid"></div>
  
   <label class="btn btn-info" for="selectAll">
      <input type="checkbox" id="selectAll"> Select All 
  </label> 

<table class="table table-bordered" id="participate">
  <thead class="thead-dark">
    
    <tr style="font-size: large;">
       
            <th>#</th>
            <th>Student Name</th>
            <th>Email</th>
            <th>Class</th>
            <th>Plan Name</th>
            <th>Created at</th>

    </tr>
   
  </thead>
  
<!-- <tbody> -->
 @if(session()->has('students1'))
    <?php 
     $check = session()->get('students1')['schoolplan'];
    $i=1;

    ?>
    @foreach($check as $key=>$students1)
    <tr style="font-size: large;">
    <td>{{$i}}</td>  
     <td>
         @if($students1->check==1)
        <input checked="checked" name="student[]" id="{{$students1->id}}" type="checkbox" aria-label="Checkbox for following text input" value="{{$students1->id}}" class="check_All">
        {{$students1->name}}
        @else
         <input name="student[]" id="{{$students1->id}}" type="checkbox" aria-label="Checkbox for following text input" value="{{$students1->id}}" class="check_All">
        {{$students1->name}}
        @endif

    </td>
     
    
         <td>{{$students1->studentemail}}</td>
         <td>{{$students1->class}}</td>
         <td>{{$students1->avplanname}}</td>
        
         <td>{{date('d-F-Y',strtotime($students1->updated_at))}} </td>
    </tr>
    <?php $i=$i+1;?>
    @endforeach


@else

     @if(count($students)>0)
     <?php $i=1;?>
    @foreach($students as $key=>$students1)
    <tr style="font-size: large;">
    
    <td>{{$i}}</td>  
     <td>
        <input name="student[]" id="{{$students1->id}}" type="checkbox" aria-label="Checkbox for following text input" value="{{$students1->id}}" class="check_All">
        {{$students1->name}}
    </td>
     
    
         <td>{{$students1->studentemail}}</td>
         <td>{{$students1->class}}</td>
         <td></td>
        
         <td>{{date('d-F-Y',strtotime($students1->updated_at))}} </td>
    </tr>
    <?php $i=$i+1;?>
    @endforeach
 
      @endif

       @endif
       <!-- </tbody> -->
  
 </table>
    
    <br>
    <div class="form-group">
     <button type="submit"  class="btn btn-success">Submit</button>
     </div>
     
    </div>
   </form>

@endsection

@section('header')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
@endsection

@section('footer')

<script type="text/javascript">

    // $(document).ready(function(){
                   // $('.p').DataTable({
                      // "destroy": true, //use for reinitialize datatable
                   // });

    $('#selectAll').click(function(){

      if($('#selectAll').is(':checked')){

       $(".check_All").attr ( "checked" ,"checked" );
      
      }else{

            $(".check_All").removeAttr('checked');
        }

    });
  });

</script>
     
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
  
  <script>


$(document).ready(function(){
var check = $('#year').val();
if(check==='')
{
   
}
else
{
 membership();
 participate1();
}
});



// $(function() {
//    membership();
// });

   function membership()
   {
  

      var school_id= $('#school_id').val();
      var year = $('#year').val();
    
          $.ajax({
            url:"{{url('menbershipsataby')}}",
              data:{'school_id':school_id,'year':year},
            method:'GET',
            beforeSend:function(){
                
          $('#participate tbody').empty();
          $('#planid').empty();

            },
            success:function(data){

              if(data.plan.length > 0){

                $("#planid").css({"color":"black !important","border":"0px solid"});

                $('#planid').append('<option value="#">Select Plan</option>');
                  $.each((data.plan),function(index,value){

                  $('#planid').append('<option value="'+value.id+'">'+value.name+'</option>');
                });

                $('#replaceyear').html('Selected Academic Year :'+ year);
              }else{

                $('#planid').append('<option value="#"> First Asign School Plan </option>');
                $("#planid").css({"color":"red","border":"1px solid red"});
              } 

              
            },
            headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  },
            error:function(data){
              
              console.log(data);
            }
          });
   }






     function participate1()
   {

      var school_id= $('#school_id').val();
      var year = $('#year').val();
      var plan = $('#planid').val();
      // alert(plan);
        $("#selectAll").removeAttr('checked');
          $.ajax({
            url:"{{url('participanrshowbyTr')}}",
            "dataSrc": "tableData",
              data:{'school_id':school_id,'year':year,'planid':plan},
            method:'GET',
            beforeSend:function(){
                
          $('#participate tbody').empty();
            // $('#participate').empty();
          // $('#planid').empty();

            },
            success:function(data){
      
           

              $.each((data.schoolplan),function(index,value){
               var index=index+1;
            
               if(plan==value.ppid)
               {
               
              if(value.check==1)
              {

            $('#participate').append('<tr style="background-color:green;color:white;font-size: large;"><td>'+index+'</td><td><input class="check_All" checked name="student[]" id="'+value.id+'" type="checkbox"  aria-label="Checkbox for following text input" value="'+value.id+'">'+value.name+'</td><td>'+value.studentemail+'</td><td>'+value.class+'</td><td>'+value.avplanname+'</td><td>'+value.updated_at+'</td></tr>');
              }
              else
              {
               $('#participate').append('<tr style="font-size: large;"><td>'+index+'</td><td><input class="check_All" name="student[]" id="'+value.id+'" type="checkbox" aria-label="Checkbox for following text input" value="'+value.id+'">'+value.name+'</td><td>'+value.studentemail+'</td><td>'+value.class+'</td><td>'+value.avplanname+'</td><td>'+value.updated_at+'</td></tr>');
              }
              }
              else
              {
            if(value.check==1)
              {
             if(value.ppid!=0)
             {
            $('#participate').append('<tr  style="background-color:red;color:white;font-size: large;"><td>'+index+'</td><td><input class="check_All"  name="_" id="'+value.id+'" type="hidden"  aria-label="Checkbox for following text input" value="'+value.id+'">'+value.name+'</td><td>'+value.studentemail+'</td><td>'+value.class+'</td><td>'+value.avplanname+'</td><td>'+value.updated_at+'</td></tr>');
             }
             else{
               $('#participate').append('<tr style="font-size: large;"><td>'+index+'</td><td><input class="check_All" name="student[]" id="'+value.id+'" type="checkbox" aria-label="Checkbox for following text input" value="'+value.id+'">'+value.name+'</td><td>'+value.studentemail+'</td><td>'+value.class+'</td><td>'+value.avplanname+'</td><td>'+value.updated_at+'</td></tr>');
             }

              }
              else 
              {
               $('#participate').append('<tr style="font-size: large;"><td>'+index+'</td><td><input class="check_All" name="student[]" id="'+value.id+'" type="checkbox" aria-label="Checkbox for following text input" value="'+value.id+'">'+value.name+'</td><td>'+value.studentemail+'</td><td>'+value.class+'</td><td>'+value.avplanname+'</td><td>'+value.updated_at+'</td></tr>');
              }
              }
             
            
             });


          $.each((data.plan),function(index,value){
             $('#planid').append('<option value="'+value.id+'">'+value.name+'</option>');
              });
                   $('#participate1').DataTable({
                      "destroy": true, //use for reinitialize datatable
                   });

                 
                    if(plan !==null)
                    {
                      $('#replan').html('Selected Plan :'+ data.planname);
                    }
                    
              
            },
            headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  },
            error:function(data){
              
              console.log(data);
            }
          });
   }
       
   </script>




 </section>
@endsection
