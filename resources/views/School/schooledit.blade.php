@extends('layouts.school')
 @section('content')
<div class="content-heading">
   <div>Edit School
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
         <form method="post" action="{{url('update-school')}}" enctype="multipart/form-data">
            @csrf
             
             <div class="form-group">
             @if($r->pimage==null)
             <img style="border-radius: 50%" src="{{ URL::to('/') }}/ImageSchool/schoolimage.png" alt="placeholderpdf" width="100" height="100">
             @else
              <img style="border-radius: 50%" src="{{ URL::to('/') }}/ImageSchool/{{$r->pimage}}" alt="placeholderpdf" width="100" height="100">
             @endif
              </div>
               <div class="form-group">
             <input type="file" name="school_image" class="form-control" value="{{old('school_image')?old('school_image'):$r->pimage}}">
             </div>
            <div class="form-group">
               <label>School/College Name <span style="color:red;font-size:20px"class="required">*</span></label>
               <input disabled="" type="text" name="school_name" class="form-control" value="{{old('school_name')?old('school_name'):$r->school_name}}">
               <input hidden="" type="text" name="school_name" class="form-control" value="{{old('school_name')?old('school_name'):$r->school_name}}">
               <input type="hidden" name="sid" class="form-control" value="{{old('sid')?old('sid'):$r->id}}">
            </div>
            <div class="form-group">
               <label>Annual Fee</label>
               <input type="text" name="annual_fees" class="form-control" value="{{old('annual_fees')?old('annual_fees'):$r->annual_fees}}">
            </div>
            <div class="form-group">
               <label>Type</label>
               <select name="type" class="form-control">
                  @if(old('type')) <option value="{{old('type')}}" selected>{!!ucfirst(old('type'))!!} </option> 
                  @else
                     <option value="{{$r->type}}" selected>{!!ucfirst($r->type)!!} </option> 
                  @endif
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
                  @if(old('type')) <option value="{{old('status')}}" selected>{{old('status')?'Active':'Inactive'}} </option> 
                  @else
                     <option value="{{$r->status}}" selected>
                      <?php 
                     if($r->status == '1')
                     {
                      echo'Active';
                     }
                     else
                     {
                      echo'Inactive';
                     }
                      ?>
                      </option> 
                  @endif
                  <option value="0">Inactive</option>
                  <option value="1">Active</option>
               </select>
            </div>
            <div class="form-group">
               <label>Address</label>
               <input type="text" name="address" class="form-control" value="{{old('address')?old('address'):$r->address}}">
            </div>
         <div class="form-group">
               <label>Zone <span style="color:red;font-size:20px"class="required">*</span></label>
               <!-- <input type="text" name="zone" class="form-control" value="{{old('zone')}}"> -->
               <select hidden="" name="zone" class="form-control" id='zonecalid'>
                  <option value="{{$r->zone}}" selected="">{{$zone_name}}</option>
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

                <select disabled="" name="zone" class="form-control" id='zonecalid'>
                  <option value="{{$r->zone}}" selected="">{{$zone_name}}</option>
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
               <label>State <span style="color:red;font-size:20px"class="required">*</span></label>
               <!-- <input type="text" name="state" class="form-control" value="{{old('state')}}"> -->
              <select hidden="" name="state" class="form-control" id="stateid">
                    <option value="{{$r->state}}" selected>{{$state_name}}</option> 
                    <span id="stateid_error" class="text-danger">
                  
               </select>
               <select disabled="" name="state" class="form-control" id="stateid">
                    <option value="{{$r->state}}" selected>{{$state_name}}</option> 
                    <span id="stateid_error" class="text-danger">
                  
               </select>
            </div>
            <div class="form-group">
               <label>City <span style="color:red;font-size:20px"class="required">*</span></label>
             <select hidden="" name="city" class="form-control" id="cityid">
                     <option value="{{$r->city}}" selected>{{$city_name}}</option> 
                    <span id="cityid_error" class="text-danger">
               </select>
               <select disabled="" name="city" class="form-control" id="cityid">
                     <option value="{{$r->city}}" selected>{{$city_name}}</option> 
                    <span id="cityid_error" class="text-danger">
               </select>
            </div>


            <div class="form-group">
               <label>Website</label>
               <input type="text" name="website" class="form-control" value="{{old('website')?old('website'):$r->website}}">
            </div>
            <div class="form-group">
               <label>Email ID <span style="color:red;font-size:20px"class="required">*</span></label>
               <input disabled="" type="email" name="email" id="email" class="form-control" value="{{old('email')?old('email'):$r->email}}">
               <input hidden="" type="email" name="email" id="email" class="form-control" value="{{old('email')?old('email'):$r->email}}">

               <span id="email_error" class="text-danger">
            </div>
            <div class="form-group">
               <label>Phone No.</label>
               <input type="text" name="mobile" id="schoolphone" class="form-control" value="{{old('mobile')?old('mobile'):$r->mobile}}">
                 <span id="schoolphone_error" id="" class="text-danger">
            </div>
            <div class="form-group">
               <label>Principal Name</label>
               <input type="text" name="principal_name" class="form-control" value="{{old('principal_name')?old('principal_name'):$r->principal_name}}">
                  <span id="pmobile_error" class="text-danger">
            </div>
            <div class="form-group">
               <label>Principal Mobile</label>
               <input type="text" name="principal_mobile" id="pmobile" class="form-control" value="{{old('principal_mobile')?old('principal_mobile'):$r->principal_mobile}}">
            </div>
            <div class="form-group">
               <label>Principal Email</label>
               <input type="email" id="pemail" name="principal_email" class="form-control" value="{{old('principal_email')?old('principal_email'):$r->principal_email}}">
                    <span id="pemail_error" id="" class="text-danger">
            </div>




            
            <div class="text-center"> <button type="submit" id="submitschool" class="btn btn-success">Submit</button> </div>
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
        // if ($(this).val() === '') {
            // $(this).css("border-color", "#FF0000");
            // $('#submitschool').attr('disabled', true);
            // $("#annual_fees_error").text("* You have to enter Anual Fee!");

        // } else
        // {
            // $(this).css("border-color", "#2eb82e");
            // $('#submitschool').attr('disabled', false);
            // $("#annual_fees_error").text("");
        // }
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
        // if ($(this).val() === '') {
            // $(this).css("border-color", "#FF0000");
            // $('#submitschool').attr('disabled', true);
            // $("#pemail_error").text("* You have to enter your Principal Email Id!");
        // } else
        // {
            // var email = document.getElementById("email").value;

            // var reg = /^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/;

            // if (reg.test(email)) {
                // $(this).css("border-color", "#2eb82e");
                // $('#submitschool').attr('disabled', false);
                // $("#pemail_error").text("");
            // } else {
                // $(this).css("border-color", "#FF0000");
                // $('#submitschool').attr('disabled', true);
                // $("#pemail_error").text("*Invalid  Email Id!");
            // }

        // }
    // });
    // $("#pname").focusout(function () {
        // if ($(this).val() === '') {
            // $(this).css("border-color", "#FF0000");
            // $('#submitschool').attr('disabled', true);
            // $("#pname_error").text("* You have to enter Principal Name!");
        // } else
        // {
            // $(this).css("border-color", "#2eb82e");
            // $('#submitschool').attr('disabled', false);
            // $("#pname_error").text("");
        // }
    // });
    // $("#address").focusout(function () {
        // if ($(this).val() === '') {
            // $(this).css("border-color", "#FF0000");
            // $('#submitschool').attr('disabled', true);
            // $("#address_error").text("* You have to Enter School Address!");
        // } else
        // {
            // $(this).css("border-color", "#2eb82e");
            // $('#submitschool').attr('disabled', false);
            // $("#address_error").text("");
        // }
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




    $("#schoolphone").focusout(function () {
        if ($(this).val() === '') {
            $(this).css("border-color", "#FF0000");
            $('#submitschool').attr('disabled', true);
            $("#schoolphone_error").text("* You have to enter your Mobile Number!");
        } else
        {
            var mobile = document.getElementById("jobseekermobile").value;
            var pattern = /^\d{10}$/;
            if (pattern.test(mobile)) {

                $(this).css({"border-color": "#2eb82e"});
                $('#submitschool').attr('disabled', false);
                $("#schoolphone_error").text("");
            } else
            {

                $(this).css("border-color", "#FF0000");
                $('#submitschool').attr('disabled', true);
                $("#schoolphone_error").text("Not a valid Mobile Number!");

            }
        }

    });



      // $("#pmobile").focusout(function () {
        // if ($(this).val() === '') {
            // $(this).css("border-color", "#FF0000");
            // $('#submitschool').attr('disabled', true);
            // $("#pmobile_error").text("* You have to enter your Principal Mobile Number!");
        // } 

        // else
        // {
            // var mobile = document.getElementById("pmobile").value;
            // var pattern = /^\d{10}$/;
            // if (pattern.test(mobile)) {

                // $(this).css({"border-color": "#2eb82e"});
                // $('#submitschool').attr('disabled', false);
                // $("#pmobile_error").text("");
            // } else
            // {

                // $(this).css("border-color", "#FF0000");
                // $('#submitschool').attr('disabled', true);
                // $("#pmobile_error").text("Not a valid Mobile Number!");

            // }
        // }

    });





    $("#submitschool").click(function () {
        // if ($('#pmobile').val() === '') {
            // $(this).css("border-color", "#FF0000");
            // $('#submitschool').attr('disabled', true);
            // $("#pmobile_error").text("* You have to enter your Principal Mobile Number!");
        // }
 
        // if ($('#schoolphone').val() === '') {
           // $(this).css("border-color", "#FF0000");
            // $('#submitschool').attr('disabled', true);
            // $("#schoolphone_error").text("* You have to enter your Mobile Number!");
        // }

        if ($('#zonecalid').val() === '') {
        $(this).css("border-color", "#FF0000");
            $('#submitschool').attr('disabled', true);
            $("#zonecalid_error").text("* You have to Select Zone!");
        }
    
        // }
        // if ($('#address').val() === '') {
           // $(this).css("border-color", "#FF0000");
            // $('#submitschool').attr('disabled', true);
            // $("#address_error").text("* You have to Enter School Address!");
        // }

 // if ($('#pname').val() === '') {
        // $(this).css("border-color", "#FF0000");
            // $('#submitschool').attr('disabled', true);
            // $("#pname_error").text("* You have to enter Principal Name!");
        // }


         // if ($('#pemail').val() === '') {
          // $(this).css("border-color", "#FF0000");
            // $('#submitschool').attr('disabled', true);
            // $("#pemail_error").text("* You have to enter your Principal Email Id!");
        // }
 // if ($('#pemail').val() === '') {
          // $(this).css("border-color", "#FF0000");
            // $('#submitschool').attr('disabled', true);
            // $("#pemail_error").text("* You have to enter your Principal Email Id!");
        // }


 // if ($('#annual_fees').val() === '') {
       // $(this).css("border-color", "#FF0000");
            // $('#submitschool').attr('disabled', true);
            // $("#annual_fees_error").text("* You have to enter Anual Fee!");
        // }
 if ($('#school').val() === '') {
        $(this).css("border-color", "#FF0000");
            $('#submitschool').attr('disabled', true);
            $("#school_error").text("* You have to enter School Name!");
        }



    });
});
   </script>

@endsection