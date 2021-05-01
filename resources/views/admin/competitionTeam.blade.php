@extends(Auth::user()->role==2? 'layouts.coadmin':'layouts.admin')
@section('content')

 <div class="content-heading">
               <div>Nominate:Competition Name:{{$compedetal->Competition_name}}|Academic year:{{$compedetal->academicyear}}
                  <small data-localize="dashboard.WELCOME"></small>
                  
               </div>
</div>
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
            @if(session()->has('F1SeniorMessage'))
               <div class="alert alert-info">{{session()->get('F1SeniorMessage')}}</div>
            @endif
</div>

  <form action="{{url('submitnominatecomTeam')}}" method="post">
 @csrf

  <div class="form-group" hidden="">
    <input type="text" name="compid" value="{{$compid}}" id="compid" required class="form-control" >   
  </div>

   <div class="form-group" hidden="">
        <input type="text" value="{{$compedetal->academicyear}}" class="form-control" name="year">
      </div>

    <div id="planid"></div>
  
   <label class="btn btn-info" for="selectAll">
      <input type="checkbox" id="selectAll"> Select All 
  </label> 

  <table class="table table-bordered" id="participate44">
  <thead class="thead-dark">
    
    <tr style="font-size: large;">
       
            <th>#</th>
            <th>Team Name</th>
            

    </tr>
   
  </thead>
  
<!-- <tbody> -->
 
<?php $i=1; ?>
    @foreach($team as $key=>$t)
    
    @if(in_array($t->id, $teamidindatabase ))
    <tr style="font-size: large;">
     <td>{{$i}}</td>
     <td>
        <input name="team[]" id="{{$t->id}}" checked="" type="checkbox" aria-label="Checkbox for following text input" value="{{$t->id}}" class="check_All">
        {{$t->team_Name}}
    </td>
    </tr>
    @else
     <tr style="font-size: large;">
     <td>{{$i}}</td>
     <td>
        <input name="team[]" id="{{$t->id}}" type="checkbox" aria-label="Checkbox for following text input" value="{{$t->id}}" class="check_All">
        {{$t->team_Name}}
    </td>
    </tr>
    @endif
    <?php $i=$i+1;?>
    @endforeach


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

    $(document).ready(function(){
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



   function membership()
   {
  

      var compid= $('#compid').val();
      var year = $('#year').val();
   
          $.ajax({
            url:"{{url('competitionTeamdata')}}",
              data:{'compid':compid,'year':year},
            method:'GET',
            beforeSend:function(){
                
          // $('#participate tbody').empty();
          $('#planid').empty();

            },
            success:function(data){

              if(data.competition.length > 0){

                $("#planid").css({"color":"black !important","border":"0px solid"});

                $('#planid').append('<option value="#">Select Plan</option>');
                  $.each((data.competition),function(index,value){
                  
                  $('#planid').append('<option value="'+value.id+'">'+value.Competition_name+'</option>');
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
            url:"{{url('participanrshow')}}",
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

            $('#participate').append('<tbody><tr style="background-color:green;color:white;font-size: large;"><td>'+index+'</td><td><input class="check_All" checked name="student[]" id="'+value.id+'" type="checkbox"  aria-label="Checkbox for following text input" value="'+value.id+'">'+value.name+'</td><td>'+value.studentemail+'</td><td>'+value.class+'</td><td>'+value.avplanname+'</td><td>'+value.updated_at+'</td></tr></tbody>');
              }
              else
              {
               $('#participate').append('<tbody><tr style="font-size: large;"><td>'+index+'</td><td><input class="check_All" name="student[]" id="'+value.id+'" type="checkbox" aria-label="Checkbox for following text input" value="'+value.id+'">'+value.name+'</td><td>'+value.studentemail+'</td><td>'+value.class+'</td><td>'+value.avplanname+'</td><td>'+value.updated_at+'</td></tr></tbody>');
              }
              }
              else
              {
            if(value.check==1)
              {
     
            if(value.ppid!=0){
            $('#participate').append('<tbody><tr  style="background-color:red;color:white;font-size: large;"><td>'+index+'</td><td><input class="check_All"  name="_" id="'+value.id+'" type="hidden"  aria-label="Checkbox for following text input" value="'+value.id+'">'+value.name+'</td><td>'+value.studentemail+'</td><td>'+value.class+'</td><td>'+value.avplanname+'</td><td>'+value.updated_at+'</td></tr></tbody>');
          }
          else
          {
               $('#participate').append('<tbody><tr style="font-size: large;"><td>'+index+'</td><td><input class="check_All" name="student[]" id="'+value.id+'" type="checkbox" aria-label="Checkbox for following text input" value="'+value.id+'">'+value.name+'</td><td>'+value.studentemail+'</td><td>'+value.class+'</td><td>'+value.avplanname+'</td><td>'+value.updated_at+'</td></tr><tbody>');
          
          }
              }
              else
              {
               $('#participate').append('<tbody><tr style="font-size: large;"><td>'+index+'</td><td><input class="check_All" name="student[]" id="'+value.id+'" type="checkbox" aria-label="Checkbox for following text input" value="'+value.id+'">'+value.name+'</td><td>'+value.studentemail+'</td><td>'+value.class+'</td><td>'+value.avplanname+'</td><td>'+value.updated_at+'</td></tr><tbody>');
              }
              }
             
            
             });


          $.each((data.plan),function(index,value){
             $('#planid').append('<option value="'+value.id+'">'+value.name+'</option>');
              });
                   $('#participate1').DataTable({
                      "destroy": true, 
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