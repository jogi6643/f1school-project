@extends('layouts.admin')
@section('content')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

             <div class="content-heading">
               <div>{{$comp->Competition_name}}|{{$comp->academicyear}}|Add Awards
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

<!-- Add Awars Form  -->
<div class="container-fluid">
<div class="col-md-12">

 <form method="post" action="{{url('awardsstroe')}}" enctype="multipart/form-data">
   @csrf
   <div class="form-group">
     <input hidden="" class="form-control" name="compid" value="{{base64_decode($compid)}}">
   </div>
    <div class="form-group">
     <a hidden="" href="#" class="btn btn-info" id="addawards">Add Awards</a>
    <div id="addedrules">
   <div class="form-group div" id="addcontentawards">
    <label for="comment">Award Name 1:</label>
    <div class="col-md-4">
    <input type="text" required="" class="form-control" name="awards[]" placeholder="Award Name..">
    </div>
     <textarea class="form-control" id="summernote" placeholder="awards content ..." rows="5" name="awrdscontent[]"></textarea>
    
    <div class="form-group">
               <label>School</label>
               <select required="" name="school[]" class="form-control" id='udpcityid' multiple="multiple">
                  @if(count($schoolv)>0)
                     @foreach($schoolv as $lc) 
                        @if($lc->school_id==old('school_id'))
                           <option value="{{$lc->school_id}}" selected="">{{$lc->Schoolname}}</option>
                        @else
                           <option value="{{$lc->school_id}}">{{$lc->Schoolname}}</option>
                        @endif
                     @endforeach


                  @endif
               </select>
  </div>
      <div class="form-group">
               <label>Teams</label>
               <select required="" name="teams[]" class="form-control xyz" id='udpcitylist' multiple="multiple">
               </select>
            </div>
  </div>
     </div>
    </div>
   <div class="col-md-12 form-group text-center mt-2">
    <input type="submit" class="btn btn-info" name="submit" value="Submit"/>
   </div>
 </form>  
</div>
</div>
<!-- End Awards Form -->



@endsection

@section('header')
@endsection

@section('footer')

<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.16/dist/summernote.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.16/dist/summernote.min.js"></script>
  <script>
    $(document).ready(function() {
        $('#summernote').summernote();
    });
  </script>

<link rel="stylesheet" href="{{asset('js/jquery.multiselect.css')}}">
<script src="{{asset('js/jquery.multiselect.js')}}"></script>

 <script type="text/javascript">
   $(document).ready(function() {
      $('#udpcityid').multiselect({

           columns  : 3,
          search   : true,
          selectAll: true,
          texts    : {
              placeholder: 'Select School',
              search     : 'Search School'
          }
       });
     $('#udpcitylist1').multiselect({

           columns  : 3,
          search   : true,
          selectAll: true,
          texts    : {
              placeholder: 'Select Teams',
              search     : 'Search Teams'
          }
       });


      $('#udpcityid').change(function(){
         var v=$('#udpcityid').val();
         var c = "<?php echo $compid ?>";
        
         var nurl="{{url('getnominateteamsadd')}}/"+btoa(v)+"/"+c;
        
          $.get(nurl,function(data){
            $('#udpcitylist').html(data);


           //  $('#udpcitylist').multiselect({
           //  columns  : 3,
           //  search   : true,
           //  selectAll: true,
           //  texts    : {
           //      placeholder: 'Select cities',
           //      search     : 'Search cities'
           //    }
           // });

        $("#udpcitylist").multiselect('reload');
       
          })

      });

   });

</script>

 <script type="text/javascript">
  
  function money(id)
  {
   
    $('#desc').show();
   $("#"+id).show();
   // alert("#"+id+"_des");
   $("#"+id+"_des").show();
   //alert($("#"+id).parent().parent().next().show());
   
  }
</script>
<script>
$(document).ready(function(){
  $.noConflict();
  //alert(0);
  var i=2;j=2;k=2;
  var numItems = $('.div').length;
  
 //add rules  
 $(document).on('click','#addawards',function(event){
  event.preventDefault();
   var numItems = $('.div').length+1;
  html ='';
  html+='<div class="form-group div" id="row'+i +'">';
  html+='<label for="comment">Award Name:'+numItems+'</label>';
  html+='<div class="col-md-4">';
  html+='<input type="text" class="form-control" name="awards[]" placeholder="Award Name..">';
  html+='</div>';
  html+='<textarea class="form-control" placeholder="awards content ..." name="awrdscontent[]" rows="5" id="comment"></textarea>';
  html+='<a href="#" id="'+i +'" class="btn btn-danger remove">Remove</a>';
  html+='<div class="form-control">';
  html+='<ul id="myUL">';
  html+='<li><span class="box">School Name</span>';
  html+='<ul class="nested">';
  html+='<li><input type="checkbox" name="">Team 1</li>';
  html+='<li><input type="checkbox" name="">Team 2</li>';
  html+='</ul>';
  html+='</li>';
  html+='</ul>';
  html+='</div>';
  html+='</div>';
   i++;
   j++;
// addcontentsponser

  $('#addcontentawards').append(html);
  });
  $(document).on('click','.remove',function(event){
  event.preventDefault();
   id = $(this).attr('id');
     $('#row'+id+'').remove();
 });

});//end 
</script>
@endsection