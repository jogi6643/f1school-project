<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="StudioKrew">
    <title>Registration </title>

    <link rel="canonical" href="{{url('')}}">
    <!-- Bootstrap core CSS -->

    <!-- <link href="{{url('assets/website/css/album.css')}}" rel="stylesheet"> -->
     <link href="{{url('assets/StudentCollageImage/css/album.css')}}" rel="stylesheet">
    <link href="{{url('assets/StudentCollageImage/css/bootstrap.css')}}" rel="stylesheet">

    <style>
        body {}
        
        .head {
            background: #3e1c1c;
            margin-bottom: 20px;
            padding: 20px 30px 5px 30px;
        }
        
        .bg-style {
            background: #f7f7f7;
        }
        
        .text-color {
            color: white;
            font-family: unset !important;
            font-size: 20px;
        }
    </style>
</head>

<body class="registration-bg">

    <div class="registration-logo">
        <div class="row">
            <div class="col-md-6"><img src="{{url('assets/website/aim/aim.png')}}" alt="" height="50"></div>
            <div class="col-md-6 text-right"><img src="{{url('assets/website/aim/login-tos.png')}}" alt="" height="50"></div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="registration-box">
                    <div class="row">
                        <div class="col-md-6" style="padding-right:0;">
                            <div class="registration-form-holder">
                                <form action="{{url('studentCollegeRegister')}}" method="post">
                                    @csrf @if(Session::has('success'))
                                    <div class="alert alert-success">
                                        <ul>
                                            <li>{{ Session::get('success') }}</li>
                                        </ul>
                                    </div>
                                    @endif @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    @endif
                                    <input type="hidden" name="teamEmail" value="{{ @$team_email }}">
                                    <input type="hidden" name="userRole" value="{{ @$user_role }}">

                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>First Name </label>
                                                <input type="text" name="first_name" value="{{ old('first_name')}}" class="form-control">
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Last Name </label>
                                                <input type="text" name="last_name" value="{{ old('last_name')}}" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <!--inner--row-->

                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label> E-mail <span class="text-danger">*</span></label>
                                                <input type="text" name="email" class="form-control" value="{{ @$user_email }}">
                                            </div>
                                        </div>
                                        <!-- col-sm-6-->

                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label> Phone Number <span class="text-danger">*</span></label>
                                                <input type="text" value="{{ old('phone')}}" name="phone" class="form-control">
                                            </div>
                                        </div>
                                        <!-- col-sm-6-->
                                    </div>
                                    <!--inner row-->

                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label> Date Of Birth </label>
                                                <input type="text" name="dob" value="{{ old('dob')}}" id="datepicker" class="form-control" autocomplete="off">
                                            </div>
                                        </div>
                                        <!-- col-sm-6-->
                                    </div>
                                    <!--inner row-->

                                    <div class="row">

                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label> State </label>
                                                <select name="state" id="state_select" class="form-control">

                                                    @if(count($states) > 0)
                                                    <option> --Select--</option>
                                                    @foreach($states as $state)
                                                    <option value="{{$state->id}}"> {{$state->name}} </option>
                                                    @endforeach @endif

                                                </select>
                                            </div>
                                        </div>
                                        <!-- col-sm-6-->

                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label> City </label>
                                                <select name="city" id="city_select" class="form-control">

                                                </select>
                                            </div>
                                        </div>
                                        <!-- col-sm-6-->

                                    </div>
                                    <!--inner row-->

                                    <div class="row">

                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label> College </label>
                                                <input type="text" value="{{ old('college')}}" name="college" class="form-control">
                                            </div>
                                        </div>
                                        <!-- col-sm-6-->

                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label> T-shirt Size </label>
                                                <input type="text" value="{{ old('tshirt_size')}}" name="tshirt_size" class="form-control">
                                            </div>
                                        </div>
                                        <!-- col-sm-6-->

                                    </div>
                                    <!--inner row-->

                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label> Password <span class="text-danger">*</span> </label>
                                                <input type="password" name="password" class="form-control">
                                            </div>
                                        </div>
                                        <!-- col-sm-6-->

                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Confirm Password <span class="text-danger">*</span> </label>
                                                <input type="password" name="confarmation_password" class="form-control">
                                            </div>
                                        </div>
                                        <!-- col-sm-6-->

                                    </div>
                                    <!-- roqw-->

                                    <div class="form-group text-center" align="center">
                                        <input type="submit" class="btn btn-danger btn-block" value="Register">
                                    </div>

                                </form>
                                <div class="registration-account-nav">
                                    <p>You have already account? | <a href="{{url('studentCollegeLogin')}}" class="text-danger">Sign In</a> </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6" style="padding-left:0;">
                            <img src="{{url('assets/website/aim/login-img.jpg')}}" alt="" style="height: 100%" width="100%">
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="container">

        <div class="footer text-center">
            <p class="registration-footer">www.timeofsports.com | Toll Free: 1800 102 5251</p>
        </div>

    </div>
    <!--container-->

    </body>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <!-- date picker link -->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <script>
        $(document).ready(function() {

            $("#state_select").change(function() {

                var city = $('#state_select').val();

                $('#city_select').empty();
                $.ajax({

                    type: "get",
                    url: "{{ url('get_city')}}",
                    data: {
                        city: city
                    },
                    success: function(data) {

                        $.each(data, function(index, value) {

                            $("#city_select").append("<option value='" + value.id + "'>" + value.name + "</option>");

                        });
                    }

                });

            });
        });
    </script>

    <script>
        $(function() {
            $("#datepicker").datepicker();
        });
    </script>



</html>