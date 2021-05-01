 @extends('layouts.admin')
 @section('content')


   <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
            <div class="content-heading">
               <div>School Entry
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
   <div class="col-md-10 offset-md-1">

         <form method="post" action="" enctype="multipart/form-data">
            @csrf
            
             <div class="form-group">
             <input type="file" name="pimage" class="form-control" value="">
             </div>

            <div class="form-group">
             
               <label>School/College Name <span style="color:red;font-size:20px"class="required">*</span></label>
               <input type="text" name="school_name" id="school" class="form-control" value="{{old('school_name')}}">
               <span id="school_error" class="text-danger">
            </div>
            <div class="form-group">
               <label>Annual Fee<span style="color:red;font-size:20px"class="required"></span></label>
               <input type="text" name="annual_fees" id="annual_fees" class="form-control" value="{{old('annual_fees')}}">
            <span id="annual_fees_error" class="text-danger">
            </div>
            <div class="form-group">
               <label>Type</label>
               <select name="type" class="form-control">
                  @if(old('type')) <option value="{{old('type')}}" selected>{!!ucfirst(old('type'))!!} </option> @endif
                  <option value="school">School</option>
                  <option value="college">College</option>
               </select>
            </div>

            <!-- <div class="form-group">
               <label>Annual Fee</label>
               <input type="text" name="annual_fees" class="form-control" value="{{old('annual_fees')}}">
            </div> -->
            <div class="form-group">
               <label>Status</label>
               <select name="status" class="form-control">
               
                  <option value="0" {{old('status')?'':'selected'}}>Inactive</option>
                  <option selected="" value="1" {{old('status')?'selected':''}} >Active</option>
               </select>
            </div>
            <div class="form-group">
               <label>Address<span style="color:red;font-size:20px"class="required"></span></label>
               <input type="text" id="address" name="address" class="form-control" value="{{old('address')}}">
                 <span id="address_error" class="text-danger">
            </div>
            <div class="form-group">
               <label>Zone<span style="color:red;font-size:20px"class="required"></span></label>
               <!-- <input type="text" name="zone" class="form-control" value="{{old('zone')}}"> -->
               <select name="zone" class="form-control" id='zonecalid'>
                  <option value="" selected="">Select Any</option>
                  @if(count($loc)>0)
                     @foreach($loc as $lc) 
                        @if($lc->zone==old('zone'))
                           <option value="{{$lc->Zone_id}}" selected="">{{$lc->zone}}</option>
                        @else
                           <option value="{{$lc->Zone_id}}">{{$lc->zone}}</option>
                        @endif
                     @endforeach


                  @endif
               </select>
                       <span id="zonecalid_error" class="text-danger">
            </div>
            <div class="form-group">
               <label>State<span style="color:red;font-size:20px"class="required"></span></label>
               <!-- <input type="text" name="state" class="form-control" value="{{old('state')}}"> -->
               <select name="state" class="form-control" id="stateid">
                    <span id="stateid_error" class="text-danger">
                  
               </select>
            </div>
            <div class="form-group">
               <label>City<span style="color:red;font-size:20px"class="required"></span></label>
               <!-- <input type="text" name="city" class="form-control" value="{{old('city')}}"> -->
               <select name="city" class="form-control" id="cityid">
                    <span id="cityid_error" class="text-danger">
               </select>
            </div>
            <div class="form-group">
               <label>Website</label>
               <input type="text" name="website" class="form-control" value="{{old('website')}}">
            </div>
            <div class="form-group">
               <label>Email ID<span style="color:red;font-size:20px"class="required">*</span></label>
               <input type="email" id="email" name="email" class="form-control" value="{{old('email')}}">
               <span id="email_error" class="text-danger">
            </div>
            <div class="form-group">
               <label>Phone No.<span style="color:red;font-size:20px"class="required">*</span></label>
               <input type="text" name="mobile" id="schoolphone" class="form-control" value="{{old('mobile')}}">
                <span id="schoolphone_error" id="" class="text-danger">
            </div>
            <div class="form-group">
               <label>Principal Name<span style="color:red;font-size:20px"class="required"></span></label>
               <input type="text" name="principal_name" class="form-control" id="pname" value="{{old('principal_name')}}">
                    <span id="pname_error" id="" class="text-danger">
            </div>
            <div class="form-group">
               <label>Principal Mobile<span style="color:red;font-size:20px"class="required"></span></label>
               <input type="text" id="pmobile" name="principal_mobile" class="form-control" value="{{old('principal_mobile')}}">
                    <span id="pmobile_error" class="text-danger">
            </div>
            <div class="form-group">
               <label>Principal Email<span style="color:red;font-size:20px"class="required"></span></label>
               <input type="email" id="pemail" name="principal_email" class="form-control" value="{{old('principal_email')}}">
                    <span id="pemail_error" id="" class="text-danger">
            </div>
            
            <div class="text-center">
             <button id="submitschool" type="submit" class="btn btn-success">Submit</button> 
           </div>
         </form>
      
   </div>
@endsection

@section('footer')
<script type="text/javascript">
   $(document).ready(function() {
      $('#zonecalid').change(function(){
      var v=$('#zonecalid').val();
         $.ajax({
            url:"{{url('locationbyzone')}}",
              data:{_token: '{!! csrf_token() !!}','v':v},
            method:'POST',
            success:function(data){
              $("#stateid").empty();
               $('#stateid').append('<option value="#">Select State</option>');
                $.each(data,function(index,value) {
               $('#stateid').append('<option value="' + value.state + '">' + value.state_name + '</option>');
             });
            
              
            },

            error:function(data){
              
              console.log(data);
            },

          });
});


      $('#stateid').change(function(){
        
        var z=$('#zonecalid').val();
        var s=$('#stateid').val();
      
     $.ajax({
            url:"{{url('statebycity')}}",
            data:{_token: '{!! csrf_token() !!}','z':z,'s':s},
            method:'POST',
            success:function(data){
           
              $("#cityid").empty();
               $('#cityid').append('<option value="#">Select City</option>');
                $.each(data,function(index,value) {
               $('#cityid').append('<option value="' + value.cityid + '">' + value.name + '</option>');
             });
            
            },

            error:function(data){
              console.log(data);
            },

          });




   });
    });
</script>
<script type="text/javascript">
 $(document).ready(function () { 
    $flag = 1;
    $("#school").focusout(function () {
        if ($(this).val() === '') {
            $(this).css("border-color", "#FF0000");
            $('#submitschool').attr('disabled', true);
            $("#school_error").text("* You have to enter School Name!");

        } else
        {
            $(this).css("border-color", "#2eb82e");
            $('#submitschool').attr('disabled', false);
            $("#school_error").text("");
        }
    });

    // $("#annual_fees").focusout(function () {
    //     if ($(this).val() === '') {
    //         $(this).css("border-color", "#FF0000");
    //         $('#submitschool').attr('disabled', true);
    //         $("#annual_fees_error").text("* You have to enter Anual Fee!");

    //     } else
    //     {
    //         $(this).css("border-color", "#2eb82e");
    //         $('#submitschool').attr('disabled', false);
    //         $("#annual_fees_error").text("");
    //     }
    // });
    
    $("#email").focusout(function () {
        if ($(this).val() === '') {
            $(this).css("border-color", "#FF0000");
            $('#submitschool').attr('disabled', true);
            $("#email_error").text("* You have to enter your Email Id!");
        } else
        {
            var email = document.getElementById("email").value;

            var reg = /^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/;

            if (reg.test(email)) {
                $(this).css("border-color", "#2eb82e");
                $('#submitschool').attr('disabled', false);
                $("#email_error").text("");
            } else {
                $(this).css("border-color", "#FF0000");
                $('#submitschool').attr('disabled', true);
                $("#email_error").text("*Invalid  Email Id!");
            }

        }
    });

    // $("#pemail").focusout(function () {
    //     if ($(this).val() === '') {
    //         $(this).css("border-color", "#FF0000");
    //         $('#submitschool').attr('disabled', true);
    //         $("#pemail_error").text("* You have to enter your Principal Email Id!");
    //     } else
    //     {
    //         var email = document.getElementById("email").value;

    //         var reg = /^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/;

    //         if (reg.test(email)) {
    //             $(this).css("border-color", "#2eb82e");
    //             $('#submitschool').attr('disabled', false);
    //             $("#pemail_error").text("");
    //         } else {
    //             $(this).css("border-color", "#FF0000");
    //             $('#submitschool').attr('disabled', true);
    //             $("#pemail_error").text("*Invalid  Email Id!");
    //         }

    //     }
    // });

    // $("#pname").focusout(function () {
    //     if ($(this).val() === '') {
    //         $(this).css("border-color", "#FF0000");
    //         $('#submitschool').attr('disabled', true);
    //         $("#pname_error").text("* You have to enter Principal Name!");
    //     } else
    //     {
    //         $(this).css("border-color", "#2eb82e");
    //         $('#submitschool').attr('disabled', false);
    //         $("#pname_error").text("");
    //     }
    // });

    // $("#address").focusout(function () {
    //     if ($(this).val() === '') {
    //         $(this).css("border-color", "#FF0000");
    //         $('#submitschool').attr('disabled', true);
    //         $("#address_error").text("* You have to Enter School Address!");
    //     } else
    //     {
    //         $(this).css("border-color", "#2eb82e");
    //         $('#submitschool').attr('disabled', false);
    //         $("#address_error").text("");
    //     }
    // });

        $("#zonecalid").focusout(function () {
        if ($(this).val() === '') {
            $(this).css("border-color", "#FF0000");
            $('#submitschool').attr('disabled', true);
            $("#zonecalid_error").text("* You have to Select Zone!");
            // $("#stateid_error").text("* You have to Select State!");
            // $("#cityid_error").text("* You have to Select City!");
        } else
        {
            $(this).css("border-color", "#2eb82e");
            $('#submitschool').attr('disabled', false);
            $("#zonecalid_error").text("");

            // $("#stateid_error").text("");
            // $("#cityid_error").text("");
        }
    });




    // $("#schoolphone").focusout(function () {
    //     if ($(this).val() === '') {
    //         $(this).css("border-color", "#FF0000");
    //         $('#submitschool').attr('disabled', true);
    //         $("#schoolphone_error").text("* You have to enter your Mobile Number!");
    //     } else
    //     {
    //         var mobile = document.getElementById("jobseekermobile").value;
    //         var pattern = /^\d{10}$/;
    //         if (pattern.test(mobile)) {

    //             $(this).css({"border-color": "#2eb82e"});
    //             $('#submitschool').attr('disabled', false);
    //             $("#schoolphone_error").text("");
    //         } else
    //         {

    //             $(this).css("border-color", "#FF0000");
    //             $('#submitschool').attr('disabled', true);
    //             $("#schoolphone_error").text("Not a valid Mobile Number!");

    //         }
    //     }

    // });



      // $("#pmobile").focusout(function () {
      //   if ($(this).val() === '') {
      //       $(this).css("border-color", "#FF0000");
      //       $('#submitschool').attr('disabled', true);
      //       $("#pmobile_error").text("* You have to enter your Principal Mobile Number!");
      //   } 

      //   else
      //   {
      //       var mobile = document.getElementById("pmobile").value;
      //       var pattern = /^\d{10}$/;
      //       if (pattern.test(mobile)) {

      //           $(this).css({"border-color": "#2eb82e"});
      //           $('#submitschool').attr('disabled', false);
      //           $("#pmobile_error").text("");
      //       } else
      //       {

      //           $(this).css("border-color", "#FF0000");
      //           $('#submitschool').attr('disabled', true);
      //           $("#pmobile_error").text("Not a valid Mobile Number!");

      //       }
      //   }

    });





    $("#submitschool").click(function () {

        // if ($('#pmobile').val() === '') {
        //     $(this).css("border-color", "#FF0000");
        //     $('#submitschool').attr('disabled', true);
        //     $("#pmobile_error").text("* You have to enter your Principal Mobile Number!");
        // }
 
        if ($('#schoolphone').val() === '') {
           $(this).css("border-color", "#FF0000");
            $('#submitschool').attr('disabled', true);
            $("#schoolphone_error").text("* You have to enter your Mobile Number!");
        }

        if ($('#zonecalid').val() === '') {
        $(this).css("border-color", "#FF0000");
            $('#submitschool').attr('disabled', true);
            $("#zonecalid_error").text("* You have to Select Zone!");
        }
    
        // }

        // if ($('#address').val() === '') {
        //    $(this).css("border-color", "#FF0000");
        //     $('#submitschool').attr('disabled', true);
        //     $("#address_error").text("* You have to Enter School Address!");
        // }

 // if ($('#pname').val() === '') {
 //        $(this).css("border-color", "#FF0000");
 //            $('#submitschool').attr('disabled', true);
 //            $("#pname_error").text("* You have to enter Principal Name!");
 //        }


        //  if ($('#pemail').val() === '') {
        //   $(this).css("border-color", "#FF0000");
        //     $('#submitschool').attr('disabled', true);
        //     $("#pemail_error").text("* You have to enter your Principal Email Id!");
        // }

 // if ($('#pemail').val() === '') {
 //          $(this).css("border-color", "#FF0000");
 //            $('#submitschool').attr('disabled', true);
 //            $("#pemail_error").text("* You have to enter your Principal Email Id!");
 //        }


 // if ($('#annual_fees').val() === '') {
 //       $(this).css("border-color", "#FF0000");
 //            $('#submitschool').attr('disabled', true);
 //            $("#annual_fees_error").text("* You have to enter Anual Fee!");
 //        }
 if ($('#school').val() === '') {
        $(this).css("border-color", "#FF0000");
            $('#submitschool').attr('disabled', true);
            $("#school_error").text("* You have to enter School Name!");
        }



    });
});
   </script>
@endsection