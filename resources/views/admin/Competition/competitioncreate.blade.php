@extends(Auth::user()->role==2? 'layouts.coadmin':'layouts.admin')
 @section('content')

<div class="text-right">
                           
<button type="button" onclick="goBack()" class="btn btn-info">Go Back</button>

<script>
function goBack() {
  window.history.back();
}
</script>
</div>

<div class="content-heading">
   <div>Competition
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
    
    <form method="post" id="Competitionform" action="{{url('storeCompetition')}}" enctype="multipart/form-data">
            @csrf

            <!-- /***************** Start for Collage Student *********************************/ -->
      <div class="form-group">
               <label>Type</label>
               <select required="" name="typeid" class="form-control" >
                   <option value="" selected="">Select any</option>
                  <option value="School">School</option>
                  <option value="College">College</option>
               </select>
            </div>
<!-- /***************** End  for Collage Student *********************************/ -->
         
    <div cass="col-md-12">
       <label>Academic Year</label>
            <div class="form-group">
           <select required=""  class="form-control"  name="academicyear">
    <option value="">Academic year</option>
    {{ $year1 = date('Y')+1 }}
    @for ($year = 2015; $year <= $year1; $year++)
   <option value="<?=($year-1)."-".($year);?>"><?=($year-1)."-".$year;?></option>
    @endfor
</select>
           </div>
       </div>
                <div class="form-group">
               <label>Competition Name</label>
               <input required="" type="text" name="Competition_name" class="form-control" value="" placeholder="Competition Name">
  
              </div>

            <div class="form-group">
               <label>Level Name</label>
               <select required="" name="levelnameid" class="form-control" >
                  <option value="" selected="">Select any</option>
                  <option value="Region">Region and Zone</option>
                  <option value="School">School</option>
                   <option value="Team">Team</option>
               </select>
            </div>

           
             <div class="form-group">
               <label>Short Description</label>
               <textarea required="" rows="2" name="Sdescription" class="form-control" placeholder="Short Description"></textarea>
               
            </div>
            <div class="form-group">
               <label>Long Description(Mail)</label>
               <textarea required="" rows="3" name="Ldescription" class="form-control" placeholder="Long Description"></textarea>
            </div>

            <div class="row">
               <div class="col-md-6">
             <div class="form-group">
               <label>Registration Date</label>
               <input required="" class="form-control" name="Ragistration_Date" type="text" id="datepicker" placeholder="Ragistration Date">
             </div>
          </div>
          <div class="col-md-6">
             <div class="form-group">
               <label>Start Date</label>
               <input required="" class="form-control" name="Start_Date" type="text" id="datepicker1" placeholder="Start Date">
             </div>
          </div>
           </div>

   

          <!-- add more field -->

          <h3> Reference Documents </h3>

          <div class="field_wrapper">
            <div class="row">
              <div class="col-sm-5">
                <input required="" type="text" name="title_name[]" class="form-control" placeholder="Title">
              </div>
              <div class="col-sm-5">
                <input required="" type="file" name="file_name[]" class="form-control">
              </div>

              <div class="col-sm-2">
                <a href="javascript:void(0);" class="add_button btn btn-info" title="Add field">
                  add</a>
              </div>

            </div><br>
        </div>

        <h3> Online Documents </h3>

          <div class="support_wrapper">
            <div class="row">
              <div class="col-sm-2">
                <input required="" type="text" autocomplete="off" name="support_title[]" class="form-control" placeholder="Title">
              </div>
              <div class="col-sm-3">
                <input required="" type="text" autocomplete="off" name="support_size[]" class="form-control" placeholder="Max Size">
              </div>

              <div class="col-sm-2">
                <input required="" type="text"  autocomplete="off" name="support_formate[]" class="form-control" placeholder="Formate">
              </div>

              <div class="col-sm-3">
                <select required="" name="support_from[]" class="form-control">
                    <option value="" selected="">--Select--</option>
                    <option value="1"> Group </option>
                    <option value="2"> individual </option>
                </select> 
              </div>

              <div class="col-sm-2">
                <a href="javascript:void(0);" class="add_support_button btn btn-info" title="Add field">
                  add</a>
              </div>

            </div><br>
        </div>

      

      <br>      
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
$(document).ready(function(){

    var fieldHTML = '';
    var maxField = 10;
    var addButton = $('.add_button');
    var wrapper = $('.field_wrapper'); 

    fieldHTML += '<div>';
    fieldHTML += '<div class="row">';

    fieldHTML += '<div class="col-sm-5"><input required="" type="text" name="title_name[]" class="form-control" placeholder="Title"></div>'; 
    fieldHTML += '<div class="col-sm-5"><input required="" type="file" name="file_name[]" class="form-control"></div>'; 
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


<!-- support Document -->

<script type="text/javascript">
$(document).ready(function(){

    var fieldHTML = '';
    var maxField = 10;
    var addButton = $('.add_support_button');
    var wrapper = $('.support_wrapper'); 

    fieldHTML += '<div>';
    fieldHTML += '<div class="row">';

    fieldHTML += '<div class="col-sm-2"><input type="text"  autocomplete="off" required="" name="support_title[]" class="form-control" placeholder="Title"></div>'; 
    fieldHTML += '<div class="col-sm-3"><input required="" autocomplete="off" type="text" name="support_size[]" class="form-control" placeholder="Max Size"></div>'; 
    fieldHTML += '<div class="col-sm-2"><input required=""  autocomplete="off" type="text" name="support_formate[]" class="form-control" placeholder="Formate"></div>'; 

    fieldHTML += '<div class="col-sm-3"><select required=""  autocomplete="off" name="support_from[]" class="form-control"><option value="" selected="">--Select--</option><option value="1"> Group </option><option value="2"> individual </option></select> </div>';

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