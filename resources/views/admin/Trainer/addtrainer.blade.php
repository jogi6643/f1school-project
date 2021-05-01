@extends(Auth::user()->role==2? 'layouts.coadmin':'layouts.admin')
 @section('content')

            <div class="content-heading">
               <div>Trainer Entry
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
             <!-- action="{{url('trainercreate')}}" enctype="multipart/form-data" -->
       <div class="col-md-12">
         <form method="post" id="trainerForm" action="{{url('trainercreate')}}" enctype="multipart/form-data">
            @csrf
           
            <div class="form-group">
             <input type="file" name="pimage" id="pimage" class="form-control" value="">
            </div>
            <div class="form-group">
              
               <label>Trainer Name<span style="color:red;font-size:20px"class="required">*</span></label>
               <input type="text" name="name" id="trainer" required class="form-control" value="{{old('name')}}">
               <span id="trainer_error" class="text-danger">
           </div>
           <div class="form-group">
               <label>Phone No<span style="color:red;font-size:20px"class="required">*</span></label>
               <input  required type="text" name="phone" id="trainerphone" class="form-control" value="{{old('phone')}}">
               <span id="trainerphone_error" class="text-danger">
           </div>
            <div class="form-group">
               <label>Email<span style="color:red;font-size:20px"class="required">*</span></label>
               <input  required type="email"  required name="email" id="traineremail" class="form-control">
               <span id="traineremail_error" class="text-danger">
           </div>
            
            
            <div class="text-center"> <button type="submit" id="submit" class="btn btn-success">Submit</button> </div>
         </form>
      
   </div>
@endsection

@section('footer')
/*
<script type="text/javascript">
 // $(document).ready(function () { 
    // $flag = 1;

    /*Start Trainer Validation */
    // $("#trainer").focusout(function () {
    //     if ($(this).val() === '') {
    //         $(this).css("border-color", "#FF0000");
    //         $('#submit').attr('disabled', true);
    //         $("#trainer_error").text("* You have to enter Trainer Name!");

    //     } else
    //     {
    //         $(this).css("border-color", "#2eb82e");
    //         $('#submit').attr('disabled', false);
    //         $("#trainer_error").text("");
    //     }
    // });

    /*End Trainer name  Validation */

    /*Start trainer phone Validation*/

     //  $("#trainerphone").focusout(function () {
     //    if ($(this).val() === '') {
     //        $(this).css("border-color", "#FF0000");
     //        $('#submit').attr('disabled', true);
     //        $("#trainerphone_error").text("* You have to enter Mobile Number!");
     //    } 

     //    else
     //    {
     //        var mobile = document.getElementById("trainerphone").value;
     //        var pattern = /^\d{10}$/;
     //        if (pattern.test(mobile)) {

     //            $(this).css({"border-color": "#2eb82e"});
     //            $('#submit').attr('disabled', false);
     //            $("#trainerphone_error").text("");
     //        } else
     //        {

     //            $(this).css("border-color", "#FF0000");
     //            $('#submit').attr('disabled', true);
     //            $("#trainerphone_error").text("Not a valid Mobile Number!");

     //        }
     //    }
     // });
     /*End Trainer Phone Validation*/

     /*Start Trainer Email Validation*/

    // $("#traineremail").focusout(function () {
    //     if ($(this).val() === '') {
    //         $(this).css("border-color", "#FF0000");
    //         $('#submit').attr('disabled', true);
    //         $("#traineremail_error").text("* You have to enter your Email Id!");
    //     } else
    //     {
    //         var email = document.getElementById("traineremail").value;

    //         var reg = /^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/;

    //         if (reg.test(email)) {
    //             $(this).css("border-color", "#2eb82e");
    //             $('#submit').attr('disabled', false);
    //             $("#traineremail_error").text("");
    //         } else {
    //             $(this).css("border-color", "#FF0000");
    //             $('#submit').attr('disabled', true);
    //             $("#traineremail_error").text("*Invalid  Email Id!");
    //         }

    //     }
    // });
    /*End Trainer Email Validation*/

/*On Submit Ckick check Validation*/
//     $("#submit").click(function () {

//    if ($("#trainer").val() === '') {
//             $(this).css("border-color", "#FF0000");
//             $('#submit').attr('disabled', true);
//             $("#trainer_error").text("* You have to enter Trainer Name!");

//         }
 
//   if ($("#trainerphone").val() === '') {
//             $(this).css("border-color", "#FF0000");
//             $('#submit').attr('disabled', true);
//             $("#trainerphone_error").text("* You have to enter Phone No!");
//         }

//          if ($("#traineremail").val() === '') {
//             $(this).css("border-color", "#FF0000");
//             $('#submit').attr('disabled', true);
//             $("#traineremail_error").text("* You have to enter your Email Id!");
//         } 
     
// /***********************************************************************************/
//  $('#trainerForm').on('submit',function(event){
//         event.preventDefault();
//         var pimage = $('#pimage').val();
//         var trainer_name = $('#trainer').val();
//         var trainer_phone = $("#trainerphone").val();
//         var trainer_email = $("#traineremail").val();
//  $.ajax({
//             url:"{{url('trainercreate')}}",
//             contentType: false,
//             cache: false,
//             processData:false
//             data:{
//                   _token: '{!! csrf_token() !!}',
//                    name:trainer_name,
//                    email:trainer_email,
//                    phone:trainer_phone,
//                    pimage:pimage,
//                  },
//             method:'POST',
//             success:function(data){
//            alert(data.success);
            
//             },

//             error:function(data){
//               alert("Error1"+data);
//             },

//           });
//   });
//     });

/************************************************************************************/

   


    // $('#trainerForm').on('submit',function(event){
    //     event.preventDefault();
    //       if ($("#trainerphone").val() === '') {
    //         $(this).css("border-color", "#FF0000");
    //         $('#submit').attr('disabled', true);
    //         $("#trainerphone_error").text("* You have to enter Phone No!");
    //     }
    //   alert('testing');
    //     // name = $('#name').val();
    //     // email = $('#email').val();
    //     // mobile_number = $('#mobile_number').val();
    //     // subject = $('#subject').val();
    //     // message = $('#message').val();

    //     // $.ajax({
    //     //   url: "/contact-form",
    //     //   type:"POST",
    //     //   data:{
    //     //     "_token": "{{ csrf_token() }}",
    //     //     name:name,
    //     //     email:email,
    //     //     mobile_number:mobile_number,
    //     //     subject:subject,
    //     //     message:message,
    //     //   },
    //     //   success:function(response){
    //     //     console.log(response);
    //     //   },
    //     //  });
    //     });


// });
 /*On Submit Ckick check Validation*/
   </script>


@endsection