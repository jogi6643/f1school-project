 @extends('layouts.admin')
 @section('content')
    
  <div class="text-right">
 
    <button type="button" onclick="goBack()" class="btn btn-info">Go Back</button>

<script>
function goBack() {window.history.back();}
</script>

</div>

  <div class="content-heading">

   <div> Edit Competition
      <small data-localize="dashboard.WELCOME"></small>
   </div>

  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  
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
   <div class="col-md-12">

         <form method="post" id="Competitionform" action="{{url('updateCompetition')}}" enctype="multipart/form-data">
            @csrf
             <div hidden="" class="form-group">
               <label>Competition Id</label>
               <input type="text" name="id" class="form-control" value="{{$edit->id}}" placeholder="Competition id">
              </div>

    <!-- /***************** Start for Collage Student *********************************/ -->
 <div class="form-group">
               <label>Type</label>
               <select required="" name="typeid" class="form-control" >
                  <option value="0">School</option>
                  <option value="1">College</option>
               </select>
            </div>
<!-- /***************** End  for Collage Student *********************************/ -->

              <div cass="col-md-12">
       <label>Academic Year</label>
            <div class="form-group">

    <select  hidden="" class="form-control"  name="academicyear">
  <option value="<?= $edit->academicyear?>">{{$edit->academicyear}}</option>
    <option value="">Academic year</option>
    {{ $year1 = date('Y')+1 }}
    @for ($year = 2015; $year <= $year1; $year++)
   <option value="<?=($year-1)."-".($year);?>"><?=($year-1)."-".($year);?></option>
    @endfor
</select>


    <select  disabled=""  class="form-control"  name="academicyear">
  <option value="<?= $edit->academicyear?>">{{$edit->academicyear}}</option>
    <option value="">Academic year</option>
    {{ $year1 = date('Y')+1 }}
    @for ($year = 2015; $year <= $year1; $year++)
   <option value="<?=($year-1)."-".($year);?>"><?=($year-1)."-".($year);?></option>
    @endfor
</select>

 
           </div>
       </div>

              <div class="form-group">
               <label>Competition Name</label>
               <input required="" type="text" name="Competition_name" class="form-control" value="{{$edit->Competition_name}}" placeholder="Competition Name">
  
              </div>

            <div class="form-group">
               <label>Level Name</label>
               <select required="" name="levelnameid" class="form-control" >
                <option value="<?= $edit->levelnameid ?>">{{$edit->levelnameid}}</option>
                  <option value="">Select any</option>
                  <option value="Region">Region and Zone</option>
                  <option value="School">School</option>
                   <option value="Team">Team</option>
               </select>
            </div>

     
           
             <div class="form-group">
               <label>Short Description</label>
               <textarea required="" rows="2" name="Sdescription" class="form-control" placeholder="Short Description">{{$edit->Sdescription}}</textarea>
               
            </div>



            <div class="form-group">
               <label>Long Description</label>
               <textarea required="" rows="3" name="Ldescription" class="form-control" placeholder="Long Description">{{$edit->Ldescription}}</textarea>
            </div>
            <div class="row">
               <div class="col-md-6">
             <div class="form-group">
               <label>Registration Date</label>
               <input required="" class="form-control" name="Ragistration_Date" type="text" value="{{$edit->Ragistration_Date}}" id="datepicker" placeholder="Ragistration Date">
             </div>
          </div>
          <div class="col-md-6">
             <div class="form-group">
               <label>Start Date</label>
               <input required="" class="form-control" name="Start_Date" value="{{$edit->Start_Date}}" type="text" id="datepicker1" placeholder="Start Date">
             </div>
          </div>
           </div>





               <!-- add more field -->


          <div>
            <div class="row">
                <div class="col-sm-6">
                  <h3> Reference Documents </h3>
                </div>

                <div class="col-sm-5 text-right">
                <a href="javascript:void(0);" class="add_button btn btn-info" title="Add field">
                  add</a>
                </div>
            </div>
          </div> 
          
          

          <div class="field_wrapper">

            @if(!empty(json_decode($edit->title_name)))

            <?php $increase = 0;?>
            @foreach (json_decode($edit->title_name) as $value)

            <div class="row">
              <div class="col-sm-5">
                <input  type="text" name="title_name[]" class="form-control" value="{{$value}}">
              </div>
              
               @if(!empty(json_decode($edit->file_name,true)[$increase]))
              <div class="col-sm-5">

                <input  type="hidden" name="file_name_{{$increase}}" class="form-control" value="{{json_decode($edit->file_name)[$increase] }}">
                 

        <?php
      $imagee1=json_decode($edit->file_name)[$increase];
  
      $ext = pathinfo("public/team/doc_image/$imagee1", PATHINFO_EXTENSION);
      ?>
      @if($ext == 'pdf')
      <img height="50px";width="50px" src="{{url('team/doc_image/pdfdummy.png')}}"/>&nbsp; &nbsp;   
      @else
     <img height="50px";width="50px" src="{{url('compitision_image')}}/{{json_decode($edit->file_name)[$increase] }}"/>&nbsp; &nbsp;
      @endif 
             <!--    <img src="{{url('compitision_image')}}/{{json_decode($edit->file_name)[$increase] }}" class="img-fluid"> -->
                
              </div>
              @else
              <div class="col-sm-5">

                <input type="file" name="file_name_{{$increase}}" class="form-control" value="">
              </div>
               @endif

              <div class="col-sm-2">
                <a href="javascript:void(0);" class="remove_button btn btn-danger">Remove</a>
              </div>

            </div><br>

            <?php
              $increase++; 
            ?>

            @endforeach
            @endif
        </div><hr>


        

        <div>
            <div class="row">

              <div class="col-sm-6">
                <h3> Online Documents </h3>
              </div>

              <div class="col-sm-5 text-right">
                <a href="javascript:void(0);" class="add_support_button btn btn-info" title="Add field">
                  add</a>
              </div>

            </div>
        </div>

          <div class="support_wrapper">
           
          @if(json_decode($edit->support_title))

          <?php $inc = 0;?> 

          @foreach (json_decode($edit->support_title) as $key => $support)

            <div class="row">
              <div class="col-sm-2">
                <input type="text" required="" name="support_title[]" class="form-control" value="{{$support}}">
              </div>
              <div class="col-sm-3">
                <input required="" type="text" name="support_size[]" class="form-control" value="{{ json_decode($edit->support_size)[$inc] }}">
              </div>

              <div class="col-sm-2">
                <input required="" type="text" name="support_formate[]" class="form-control" value="{{json_decode($edit->support_formate)[$inc] }}">
              </div>

              <div class="col-sm-3">
                <select required="" name="support_from[]" class="form-control" value="{{json_decode($edit->support_from)[$inc] }}">
                    <option value="">--Select--</option>
                    <option value="1" {{(json_decode($edit->support_from)[$inc])==1 ? 'selected':'' }}> Group </option>

                    <option value="2" {{(json_decode($edit->support_from)[$inc])==2 ? 'selected':'' }} > individual </option>
                </select> 
              </div>

              <div class="col-sm-2">
                  <a href="javascript:void(0);" class="remove_button btn btn-danger">Remove</a>
              </div>

            </div><br>
            <?php $inc++;?>  
            @endforeach
            @endif
        </div>


            
            <div class="text-center"> <button type="submit" class="btn btn-success">Submit</button> </div>
         </form>
      
   </div>
@endsection

@section('footer')
<!-- <script src="https://code.jquery.com/jquery-1.12.4.js"></script> -->
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
   <script type="text/javascript">
      $(document).ready(function(){

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
     <script>

  // $( function() {
  //   $( "#datepicker" ).datepicker();
  // } );
  //   $( function() {
  //   $( "#datepicker1" ).datepicker();
  // } );


     $(function() {
      // Get tomorrow 
      var tomorrow = new Date();
      tomorrow.setDate(new Date().getDate());

      $("#datepicker").datepicker({
        minDate: tomorrow,
        onSelect: function(dateText, inst) {
          // Get the selected date
          var inDate = new Date($(this).val());
          $("#out").datepicker('option', 'minDate', inDate);
        }
      });
      $('#datepicker1').datepicker({
        minDate: tomorrow
      })
    });
  </script>

  <script type="text/javascript">
// $(document).ready(function (e) {
//  $("#Competitionform").on('submit',(function(e) {
     
//   e.preventDefault();
//   $.ajax({
//    url: "{{url('storeCompetition')}}",
//    type: "POST",
//    data:  new FormData(this),
//    contentType: false,
//          cache: false,
//    processData:false,
//    beforeSend : function()
//    {
 
//    },
//    success: function(data)
//       {
        
//   alert('jfhkbd');
        
    
  
//      $("#Competitionform")[0].reset(); 

//       },
//      error: function(e) 
//       {
//     $("#err").html(e).fadeIn();
//       }          
//     });
//  }));
// });
</script>



<script type="text/javascript">
$(document).ready(function(){

    var fieldHTML = '';
    var maxField = 10;
var x = parseInt("{{count(json_decode($edit->title_name))}}")+1;
    var addButton = $('.add_button');
    var wrapper = $('.field_wrapper'); 

    fieldHTML += '<div>';
    fieldHTML += '<div class="row">';

    fieldHTML += '<div class="col-sm-5"><input type="text" required="" name="title_name[]" class="form-control" placeholder="Title"></div>'; 
    fieldHTML += '<div class="col-sm-5"><input  type="file" name="file_name_'+x+'" class="form-control"></div>'; 
    fieldHTML += '<div class="col-sm-2"><a href="javascript:void(0);" class="remove_button btn btn-danger">Remove</a></div>';

    fieldHTML += '</div><br>';
    fieldHTML += '</div>';

    

    $(addButton).click(function(){
    
        if(x < maxField){ 
            x++;
            $(wrapper).append(fieldHTML);
        }
    });
    
    //Once remove button is clicked
    $(wrapper).on('click', '.remove_button', function(e){
        e.preventDefault();
        $(this).parent('div').parent('div').remove(); //Remove field html
        x--; //Decrement field counter
    });
});
</script>


<!-- support Document -->

<script type="text/javascript">
$(document).ready(function(){

    var fieldHTML = '';
    var maxField = 10;
    var addButton = $('.add_support_button');
    var wrapper = $('.support_wrapper'); 

    fieldHTML += '<div>';
    fieldHTML += '<div class="row">';

    fieldHTML += '<div class="col-sm-2"><input type="text" required="" name="support_title[]" class="form-control" placeholder="Title"></div>'; 
    fieldHTML += '<div class="col-sm-3"><input required="" type="text" name="support_size[]" class="form-control" placeholder="Max Size"></div>'; 
    fieldHTML += '<div class="col-sm-2"><input required="" type="text" name="support_formate[]" class="form-control" placeholder="Formate"></div>'; 

    fieldHTML += '<div class="col-sm-3"><select required="" name="support_from[]" class="form-control"><option value="">--Select--</option><option value="1"> Group </option><option value="2"> individual </option></select> </div>';

    fieldHTML += '<div class="col-sm-2"><a href="javascript:void(0);" class="remove_button btn btn-danger">Remove</a></div>';

    fieldHTML += '</div><br>';
    fieldHTML += '</div>';

    var x = 1;

    $(addButton).click(function(){
    
        if(x < maxField){ 
            x++;
            $(wrapper).append(fieldHTML);
        }
    });
    
    //Once remove button is clicked
    $(wrapper).on('click', '.remove_button', function(e){
        e.preventDefault();
        $(this).parent('div').parent('div').remove(); //Remove field html
        x--; //Decrement field counter
    });
});
</script>


@endsection