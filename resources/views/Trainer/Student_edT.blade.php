 @extends('layouts.trainer')
 @section('content')
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  
            <div class="content-heading">
               <div>Edit Student Details
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
         <form method="post" action="{{url('editbyTr')}}" enctype="multipart/form-data">
            @csrf
           

            <div class="form-group" hidden>
               <label>School Ids</label>
               <input  type="text" name="school_id" value="{{$student->school_id}}" required class="form-control">
           </div>
            <div class="form-group" hidden>
             
                 <label>student Id</label>
               <input type="text" name="student_id" value="{{$student->id}}" required class="form-control">
             
           </div>
           <div class="form-group">
               <label>Student Name<span style="color:red;font-size:20px"class="required">*</span></label>
               <input  id="sname" required type="text" name="name" value="{{$student->name}}"  class="form-control">
               <span id="e_sname" class="text-danger">
           </div>
           
            <div class="form-group" hidden="">
               <label>Email<span style="color:red;font-size:20px" class="required">*</span></label>
               <input id="email" hidden  required type="text" name="studentemail" value="{{$student->studentemail}}" class="form-control">
               <span id="e_mail" class="text-danger">
           </div>
    
             <div class="form-group">
               <label>Class<span style="color:red;font-size:20px"class="required">*</span></label>
               <!-- <input type="text" name="state" class="form-control" value="{{old('state')}}"> -->
               <input type="text" list="class" required="" name="class" value="{{$student->class}}" class="form-control"  />
               <datalist id="class">
               <!-- <select name="state" class="form-control" id='zoneid'> -->
               <option value="{{$student->class}}" selected="">Select Class</option>
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
                @if($student->status==0)
                   <option value="0">Inactive</option>
                  @else
                     <option value="1">Active</option>
                @endif
                <option value="1">Active</option>
                 <option value="0">Inactive</option>
               </select>

             </div>
             <!-- <span style="color:red;font-size:20px"class="required">*</span> -->
           <div class="form-group">
               <label>Student Section</label>
               <input   type="text" value="{{$student->section}}"  name="section" class="form-control">
           </div>
           <!-- <span style="color:red;font-size:20px"class="required">*</span> -->
               <div class="form-group">
               <label>D.O.B</label>
               <input    id="datepicker"  name="dob" value="{{$student->dob}}" class="form-control">
                <span id="e_datepicker" class="text-danger">
           </div>
            <div class="form-group">

               <label>Mobile No<span style="color:red;font-size:20px"class="required">*</span></label>
               <input  id="mobile" required type="text" value="{{$student->mobileno}}"   required name="mobileno" class="form-control">
                 <span id="e_mobile" class="text-danger">
           </div>
           <!-- <span style="color:red;font-size:20px"class="required">*</span> -->
            <div class="form-group">
               <label>Address</label>
               <input   type="text"  name="address" value="{{$student->address}}" class="form-control">
           </div>
           <!--    <div class="form-group">
               <label>T-Shirt Size</label>
               <input  required type="text"  required name="tsize" class="form-control">
           </div> -->

            <div class="form-group">
               <label>T-Shirt</label>
               <!-- <input type="text" name="state" class="form-control" value="{{old('state')}}"> -->
               <input type="text" list="tsize" name="tsize" class="form-control" value="{{$student->tsize}}" />
               <datalist id="tsize">
               <!-- <select name="state" class="form-control" id='zoneid'> -->
               <option value="{{$student->tsize}}" selected="">Select T-Size</option>
                  @if(count($tshirt)>0)
                     @foreach($tshirt as $tz) 
                           
                           <option>{{$tz->tsize}}</option>
                           @endforeach
                  @endif
               <!-- </select> -->
               </datalist>

            </div>
            <!-- <span style="color:red;font-size:20px"class="required">*</span> -->
            <div class="form-group">
               <label>Guardian Name 1</label>
               <input   type="text" value="{{$student->guardianname1}}"  name="guardianname1" class="form-control">
           </div>
            <div class="form-group">
<!-- <span style="color:red;font-size:20px"class="required">*</span> -->
               <label>Guardian Email 1</label>
               <input   type="text" value="{{$student->guardianemail1}}"   name="guardianemail1" class="form-control">
           </div>
           <!-- <span style="color:red;font-size:20px"class="required">*</span> -->
            <div class="form-group">
               <label>Guardian Phone 1</label>
               <input   type="text" value="{{$student->guardianphone1}}"  name="guardianphone1" class="form-control">
           </div>

            <div class="form-group">
               <label>Guardian Name 2</label>
               <input  type="text"   name="guardianname2" value="{{$student->guardianname2}}" class="form-control">
           </div>
          
           
             <div class="form-group">

               <label>Guardian Email 2</label>
               <input   type="text"  name="guardianemail2" value="{{$student->guardianemail2}}" class="form-control">
           </div>
              <div class="form-group">
               <label>Guardian Phone 2</label>
               <input  type="text"  name="guardianphone2" value="{{$student->guardianphone2}}" class="form-control">
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

            var reg = /^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/;

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
            var mobile = document.getElementById("mobile").value;
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