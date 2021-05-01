 @extends('layouts.school')
 @section('content')
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  
            <div class="content-heading">
               <div>Student Information
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
         <form method="post" action="{{url('storestudent')}}" enctype="multipart/form-data">
            @csrf
           

            <div class="form-group" hidden>
               <label>School Ids</label>
               <input type="text" name="school_id" value="{{$schoolid1}}" required class="form-control"  >
           </div>
            <div class="form-group">
             
               <h2>{{$scoolname->school_name}}</h2>
             
           </div>
           <div class="form-group">
               <label>Student Name<span style="color:red;font-size:20px"class="required">*</span></label>
               <input  id="sname" required type="text" name="name" value="{{old('name')}}"  class="form-control">
               <span id="e_sname" class="text-danger">
           </div>
           
            <div class="form-group">
               <label>Email<span style="color:red;font-size:20px"class="required">*</span></label>
               <input id="email"  required type="text" name="studentemail" value="{{old('studentemail')}}" class="form-control">
               <span id="e_mail" class="text-danger">
           </div>
         <!--    <div class="form-group">
               <label>Student Class</label>
               <input  required type="text"  required name="class" class="form-control">
           </div> -->
             <div class="form-group">
               <label>Class<span style="color:red;font-size:20px"class="required">*</span></label>
               <!-- <input type="text" name="state" class="form-control" value="{{old('state')}}"> -->
               <input type="text" list="class" required="" name="class" value="{{old('class')}}" class="form-control"  />
               <datalist id="class">
               <!-- <select name="state" class="form-control" id='zoneid'> -->
               <option value="" selected="">Select Class</option>
                  @if(count($class)>0)
                     @foreach($class as $cl) 
                           
                           <option>{{$cl->class}}</option>
                           @endforeach
                  @endif
               <!-- </select> -->
               </datalist>

            </div>

           <div class="form-group">
               <label>Status</label>
               <select name="status" class="form-control">
                   <option value="0">Inactive</option>
                     <option selected="" value="1">Active</option>
               </select>
             </div>
           <div class="form-group">
               <label>Student Section<span style="color:red;font-size:20px"class="required"></span></label>
               <input  type="text" value="{{old('section')}}"  name="section" class="form-control">
           </div>
               <div class="form-group">
               <label>D.O.B<span style="color:red;font-size:20px"class="required"></span></label>
               <input    id="datepicker"  name="dob" value="{{old('dob')}}" class="form-control">
                <span id="e_datepicker" class="text-danger">
           </div>
            <div class="form-group">

               <label>Mobile No<span style="color:red;font-size:20px"class="required">*</span></label>
               <input  id="mobile" required type="text" value="{{old('mobileno')}}"   required name="mobileno" class="form-control">
                 <span id="e_mobile" class="text-danger">
           </div>
            <div class="form-group">
               <label>Address<span style="color:red;font-size:20px"class="required"></span></label>
               <input  type="text"   name="address" value="{{old('address')}}" class="form-control">
           </div>
           <!--    <div class="form-group">
               <label>T-Shirt Size</label>
               <input  required type="text"  required name="tsize" class="form-control">
           </div> -->

            <div class="form-group">
               <label>T-Shirt</label>
               <!-- <input type="text" name="state" class="form-control" value="{{old('state')}}"> -->
               <input type="text" list="tsize" name="tsize" class="form-control" value="{{old('tsize')}}" />
               <datalist id="tsize">
               <!-- <select name="state" class="form-control" id='zoneid'> -->
               <option value="" selected="">Select T-Size</option>
                  @if(count($tshirt)>0)
                     @foreach($tshirt as $tz) 
                           
                           <option>{{$tz->tsize}}</option>
                           @endforeach
                  @endif
               <!-- </select> -->
               </datalist>

            </div>
            <div class="form-group">
               <label>Guardian Name 1<span style="color:red;font-size:20px"class="required"></span></label>
               <input  type="text" value="{{old('guardianname1')}}"  name="guardianname1" class="form-control">
           </div>
            <div class="form-group">

               <label>Guardian Email 1<span style="color:red;font-size:20px"class="required"></span></label>
               <input   type="text" value="{{old('guardianemail1')}}"   name="guardianemail1" class="form-control">
           </div>
            <div class="form-group">
               <label>Guardian Phone 1<span style="color:red;font-size:20px"class="required"></span></label>
               <input   type="text" value="{{old('guardianphone1')}}"  name="guardianphone1" class="form-control">
           </div>

            <div class="form-group">
               <label>Guardian Name 2</label>
               <input  type="text"   name="guardianname2" value="{{old('guardianname2')}}" class="form-control">
           </div>
          
           
             <div class="form-group">

               <label>Guardian Email 2</label>
               <input   type="text"  name="guardianemail2" value="{{old('guardianemail2')}}" class="form-control">
           </div>
              <div class="form-group">
               <label>Guardian Phone 2</label>
               <input  type="text"  name="guardianphone2" value="{{old('guardianphone2')}}" class="form-control">
           </div>
            <div class="text-center"> <button id="studentsubmit" type="submit" class="btn btn-success">Submit</button> </div>
         </form>
      
   </div>
@endsection

@section('footer')
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
   <script type="text/javascript">
      $(document).ready(function(){
         
    $('.datepicker').datepicker();


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

      $( function() {
    $( "#datepicker" ).datepicker();
  } );
   </script>
   
   <script>
   
   
   $(document).ready(function () {
       
      
    $flag = 1;
    $("#sname").focusout(function () {
        if ($(this).val() === '') {
            $(this).css("border-color", "#FF0000");
            $('#studentsubmit').attr('disabled', true);
            $("#e_sname").text("* You have to enter Student Name!");

        } else
        {
            $(this).css("border-color", "#2eb82e");
            $('#studentsubmit').attr('disabled', false);
            $("#e_sname").text("");
        }
    });
    $("#jobseekerlastname").focusout(function () {
        if ($(this).val() === '') {
            $(this).css("border-color", "#FF0000");
            $('#jobseekersubmit').attr('disabled', true);
            $("#error_jobseekerlastname").text("* You have to enter your Last Name!");

        } else
        {
            $(this).css("border-color", "#2eb82e");
            $('#jobseekersubmit').attr('disabled', false);
            $("#error_jobseekerlastname").text("");
        }
    });
    $("#email").focusout(function () {
        if ($(this).val() === '') {
            $(this).css("border-color", "#FF0000");
            $('#jobseekersubmit').attr('disabled', true);
            $("#e_mail").text("* You have to enter your Email Id!");
        } else
        {
            var email = document.getElementById("email").value;

            var reg = /^[a-zA-Z]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/;

            if (reg.test(email)) {
                $(this).css("border-color", "#2eb82e");
                $('#studentsubmit').attr('disabled', false);
                $("#e_mail").text("");
            } else {
                $(this).css("border-color", "#FF0000");
                $('#studentsubmit').attr('disabled', true);
                $("#e_mail").text("*Invalid  Email Id!");
            }

        }
    });
/*
    $("#datepicker").focusout(function () {
        if ($(this).val() === '') {
            $(this).css("border-color", "#FF0000");
            $('#studentsubmit').attr('disabled', true);
            $("#e_datepicker").text("* You have to enter your Date of Birth!");
        } else
        {
            $(this).css("border-color", "#2eb82e");
            $('#studentsubmit').attr('disabled', false);
            $("#e_datepicker").text("");
        }
    });
	*/
    $("#jobseekergender").focusout(function () {
        if ($(this).val() === '') {
            $(this).css("border-color", "#FF0000");
            $('#jobseekersubmit').attr('disabled', true);
            $("#error_jobseekergender").text("* You have to Select your Gender!");
        } else
        {
            $(this).css("border-color", "#2eb82e");
            $('#jobseekersubmit').attr('disabled', false);
            $("#error_jobseekergender").text("");
        }
    });




    $("#mobile").focusout(function () {
        if ($(this).val() === '') {
            $(this).css("border-color", "#FF0000");
            $('#studentsubmit').attr('disabled', true);
            $("#e_mobile").text("* You have to enter your Mobile Number!");
        } else
        {
            var mobile = document.getElementById("jobseekermobile").value;
            var pattern = /^\d{10}$/;
            if (pattern.test(mobile)) {

                $(this).css({"border-color": "#2eb82e"});
                $('#studentsubmit').attr('disabled', false);
                $("#e_mobile").text("");
            } else
            {

                $(this).css("border-color", "#FF0000");
                $('#studentsubmit').attr('disabled', true);
                $("#e_mobile").text("Not a valid Mobile Number!");

            }
        }

    });






    $("#studentsubmit").click(function () {
        if ($('#sname').val() === '') {
            $(this).css("border-color", "#FF0000");
            $('#studentsubmit').attr('disabled', true);
            $("#e_sname").text("* You have to enter your First Name!");
        }
        // if ($('#jobseekerlastname').val() === '') {
        //     $(this).css("border-color", "#FF0000");
        //     $('#studentsubmit').attr('disabled', true);
        //     $("#error_jobseekerlastname").text("* You have to enter your Last Name!");
        // }
        if ($('#email').val() === '') {
            $(this).css("border-color", "#FF0000");
            $('#studentsubmit').attr('disabled', true);
            $("#e_mail").text("* You have to enter your Email Id!");
        }

        // if ($('#datepicker').val() === '') {
            // $(this).css("border-color", "#FF0000");
            // $('#studentsubmit').attr('disabled', true);
            // $("#e_datepicker").text("* You have to enter your Date of Birth!");
        // }
        // if ($('#jobseekergender').val() === '') {
        //     $(this).css("border-color", "#FF0000");
        //     $('#jobseekersubmit').attr('disabled', true);
        //     $("#error_jobseekergender").text("* You have to Select your Gender!");
        // }
        if ($('#mobile').val() === '') {
            $(this).css("border-color", "#FF0000");
            $('#studentsubmit').attr('disabled', true);
            $("#e_mobile").text("* You have to enter your Mobile Number!");
        }
    });
});
 $('#datepicker').datepicker({minDate: new Date(2000,1-1,1), maxDate: '-17Y',
      dateFormat: 'dd/mm/yy',
      changeMonth: true,
      changeYear: true,
      yearRange: '-110:-17'});
   </script>


@endsection