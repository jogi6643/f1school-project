@extends('layouts.student')
@section('contents')
                @if($errors->any())
                 <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                 </div>
                 @endif
                 @if(session()->has('success'))
                       <div class="alert alert-success">{{session()->get('success')}}</div>
                 @endif
                  @if(session()->has('error'))
                       <div class="alert alert-danger">
                         {{session()->get('error')}}
                       </div>
                 @endif
 

@if($studentName->register_type == 'F1Senior')
  @if($studentName->order_status == "Pending ")
   <main role="main">

  <section class="jumbotron text-center">
      <p>
        <a href="javascript:void(0)" class="btn btn-danger buy_now" data-amount="20" data-email="{{$email}}" data-name="{{ $studentName->name }}" data-studentid="{{$studentid}}" data-schoolid="{{$schoolid}}"> Pay Now| 20 </a> 
      </p>
        <div class="clearfix"> &nbsp; </div>   
  </section>
</main>
@else
 <div class="profile-bg">
  <div class="container">
    <div class="row">
         @if(!isset($studentName->profileimage))
      <div class="col-md-3"><div class="profile-image"><img src="{{url('team/pro.jpg')}}"></div></div>
      @else
        <div class="col-md-3"><div class="profile-image"><img src="{{url('studentprofileimage')}}/{{$studentName->profileimage}}"></div></div>
      @endif
      <div class="col-md-9">
        <div class="profile-detail">
          <h1> {{$studentName->name}}</h1>
          <a href="#" class="badge badge-pill badge-secondary">{{$studentName->school_name}}</a>

          @if($data[0]['teamname']!='NO')
          <a href="#" class="badge badge-pill badge-info">{{$data[0]['teamname']}}</a>
          @else
          <a href="#" class="badge badge-pill badge-danger">No Team Assign</a>
          @endif
        </div>
      </div>
    </div>
    <div class="row">
          <div class="col-md-4">
        <div class="profile-info"><p>{{$appieddesign}}<span>Design Approved</span></p></div>
      </div>
      <div class="col-md-4">
        <div class="profile-info"><p>{{$oredersuccess}}<span>Order Placed</span></p></div>
      </div>
      <div class="col-md-4">
        <div class="profile-info"><p>{{$appiedcompetition}}<span>Competition Participated</span></p></div>
      </div>
    </div>
  </div>
</div>


  @endif



@else
<div class="profile-bg">
  <div class="container">
    <div class="row">
         @if(!isset($studentName->profileimage))
      <div class="col-md-3"><div class="profile-image"><img src="{{url('team/pro.jpg')}}"></div></div>
      @else
        <div class="col-md-3"><div class="profile-image"><img src="{{url('studentprofileimage')}}/{{$studentName->profileimage}}"></div></div>
      @endif
      <div class="col-md-9">
        <div class="profile-detail">
          <h1> {{$studentName->name}}</h1>
          <a href="#" class="badge badge-pill badge-secondary">{{$studentName->school_name}}</a>

          @if($data[0]['teamname']!='NO')
          <a href="#" class="badge badge-pill badge-info">{{$data[0]['teamname']}}</a>
          @else
          <a href="#" class="badge badge-pill badge-danger">No Team Assign</a>
          @endif
        </div>
      </div>
    </div>
    <div class="row">
          <div class="col-md-4">
        <div class="profile-info"><p>{{$appieddesign}}<span>Design Approved</span></p></div>
      </div>
      <div class="col-md-4">
        <div class="profile-info"><p>{{$oredersuccess}}<span>Order Placed</span></p></div>
      </div>
      <div class="col-md-4">
        <div class="profile-info"><p>{{$appiedcompetition}}<span>Competition Participated</span></p></div>
      </div>
    </div>
  </div>
</div>



<div class="container emp-profile">

           
                <div class="row">
                 
                    <div class="col-md-6">
                        <div class="profile-head">
                              
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="summary-tab" data-toggle="tab" href="#summary" role="tab" aria-controls="summary" aria-selected="true"><h5>Summary</h5></a>
                                </li>                              
                                <li class="nav-item">
                                    <a class="nav-link" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true"><h5>About</h5></a>
                                </li>
                                <li class="nav-item">
                                  
                                </li>
                            </ul>
                        </div>
                    </div>
                  
                </div>

                <div class="" style="margin-top:45px;">
                    <div class="tab-content profile-tab" id="myTabContent" style="width:100%;">
                        <div class="tab-pane fade show active" id="summary" role="tabpanel" aria-labelledby="summary-tab">
                          <div class="row">
                            <div class="col-sm-12">
                               <div class="col-sm-12" style="background-color: #e84330;">
                               <h2 class="text-center text-white">Course List</h2>
                             </div>
                             <div class="summary_box">
                           
                               <table class="table table-hover table-sm">
                                <tbody>
                                 
                               @if(count($assigndata)>0)
                             @foreach($assigndata as $key=> $assigndata1)
                             @foreach($assigndata1 as $assigndata2)


                 <?php $assigdt = strtotime($assigndata2->asshigneddate);
$systmdt = strtotime($systemdate);

$newDateString = date('d/m/Y', $assigdt);

$ids = $assigndata2->id . "/" . $studentid . "/" . $schoolid . "/" . $planid . "/" . $assigndata2->resumevedio . "/" . $assigndata2->thumbnail . "/" . $assigndata2->asshigneddate;
?>
                                  <tr>
                                    <th scope="row">{{$key+1}}</th>
                                    <td>{{$assigndata2->title}}</td>
                                    
                                    <td>
                                <div class="btn-group">
          <a href="{{url('vediojs')}}/{{base64_encode($ids)}}"  target='_blank'>
            <button  type="button" class="btn btn-sm btn-outline-secondary">View</button>
          </a>&nbsp;
          <a href="{{url('attempvediojs')}}/{{base64_encode($ids)}}"  target='_blank'> 
            <button  @if($assigdt>$systmdt) disabled @endif    @if($newDateString=="12/12/1993") disabled @endif type="button" class="btn btn-sm btn-outline-secondary">Attempt</button>
          </a>
                                    </div>
                                    </td>
                                    <td>
                                     

                                    </td>
                                  </tr>
                                  @endforeach
                                @endforeach
                                  @else
                             <section class="jumbotron text-center">
                                 <h1 class="jumbotron-heading">No Plan . Please Contact Your School .</h1>
                             </section>
                                  @endif

                                
                               
                                </tbody>
                              </table>    
                              <!--   </div> -->
                            </div>

  </div>
</div>
<div class="row">
                            <div class="col-sm-12">
                              <br>
                               <div class="col-sm-12" style="background-color: #e84330;">
                                <h2 class="text-center text-white">School Vs Team</h2>
                              </div>
                              <div class="summary_box">
                              <figure class="highcharts-figure">
                                  <div id="container"></div>
                                  <p class="highcharts-description">
                                  </p>
                              </figure>
                              </div>
                            </div>
</div>
<div class="row">
                            <div class="col-sm-12">
                              <br>
                               <div class="col-sm-12" style="background-color: #e84330;">
                               <h2 class="text-center text-white">Team Members and Their Roles</h2>
                             </div>
                              <div class="summary_box">
                              <table class="table table-hover table-sm">
                                <thead class="thead-dark">
                                  <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Member Name</th>
                                    <th scope="col">Role</th>
                                    <th scope="col">Image</th>
                                    <th scope="col">Status</th>
                                  </tr>
                                </thead>
                                <tbody>
                                 
                                 @if($info!='NO')
                                 @foreach($info as $key=>$teamMemRole)
                                  <tr>
                                    <th scope="row">{{$key+1}}</th>
                                    <td>{{$teamMemRole->MembarName}}</td>
                                    <td>{{$teamMemRole->Role}}</td>
                                    <td>
                                      @if($teamMemRole->ProfileImage!=null)
                                       <img border-radius="50%" width="50" height="50" src="{{url('studentprofileimage')}}/{{$teamMemRole->ProfileImage}}">

                                      @else
                                       <img border-radius="50%" width="50" height="50" src="{{url('team/pro.jpg')}}">
                                      @endif
                                    </td>
                                    <td>
                                      @if($teamMemRole->MemberStatus==1)
                                      Approved
                                      @else
                                      Pending
                                      @endif

                                    </td>
                                  </tr>
                                  @endforeach
                                  @else
                                    <tr>
                                    <th scope="row">N/A</th>
                                  </tr>
                                  @endif

                                
                               
                                </tbody>
                              </table>
                             </div>
                            </div>
</div>

<div class="row">
                            <div class="col-sm-12">
                              <br>
                              <div class="col-sm-12" style="background-color: #e84330;">
                                <h2 class="text-center text-white">Manufacturing Submitted by Team Members.</h2>
                              </div>
                             <div class="summary_box">
                              <table class="table table-hover table-sm">
                                <thead class="thead-dark">
                                  <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Manufacture Id</th>
                                    <th scope="col">Submitted By</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Status</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  @if($manufacture!='NO')
                                 @foreach($manufacture as $key=>$manufact)
                                  <tr>
                                    <th scope="row">{{$key+1}}</th>
                                     @if($manufact->applicationid!='N/A')
                                    <td>{{$manufact->applicationid}}</td>
                                    <td>{{$manufact->MembarName}}</td>
                                    <?php
// date_default_timezone_set('Asia/Kolkata');
$currentTime = date('d/m/Y', strtotime($manufact->created_at));

?>
                                    <td>{{$currentTime}}</td>
                                    <td>
                                      @if($manufact->MemberStatus==1)
                                      Approved
                                      @else
                                      Pending
                                      @endif

                                    </td>
                                   @else
                                      <td>N/A</td>
                                    <td>{{$manufact->MembarName}}</td>
                                  <td>N/A</td>
                                    <td>
                                    N/A

                                    </td>
                                   @endif

                                  </tr>
                                  @endforeach
                                  @else
                                    <tr>
                                    <th scope="row">N/A</th>
                                  </tr>
                                  @endif
                                </tbody>
                              </table>
                             </div>
                            </div>
                          </div>                          
                        </div>
                        <div class="tab-pane fade" id="home" role="tabpanel" aria-labelledby="home-tab">
                          <div class="card text-white" style="background-color: #ff9766">
                             <div class="card-body">
                                   

                                      <div class="row">
                                        <div class="col-md-6">
                                            <h4 class="card-title">Name </h4>
                                        </div>
                                        <div class="col-md-6">
                                            <h4 class="card-title">{{$data[0]['name']}}</h4>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h4 class="card-title">User Email</h4>
                                        </div>
                                        <div class="col-md-6">
                                            <h4 class="card-title">{{$data[0]['studentemail']}}</h4>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h4 class="card-title">Address</h4>
                                        </div>
                                        <div class="col-md-6">
                                            <h4 class="card-title">{{$data[0]['address']}}</h4>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h4 class="card-title">Date Of Birth</h4>
                                        </div>
                                        <div class="col-md-6">
                                            <h4 class="card-title">{{$data[0]['dob']}}</h4>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h4 class="card-title">Class</h4>
                                        </div>
                                        <div class="col-md-6">
                                            <h4 class="card-title">{{$data[0]['class']}}</h4>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h4 class="card-title">Section</h4>
                                        </div>
                                        <div class="col-md-6">
                                            <h4 class="card-title">{{$data[0]['section']}}</h4>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h4 class="card-title">Mobile</h4>
                                        </div>
                                        <div class="col-md-6">
                                            <h4 class="card-title">{{$data[0]['mobileno']}}</h4>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h4 class="card-title">Guardianname1</h4>
                                        </div>
                                        <div class="col-md-6">
                                            <h4 class="card-title">{{$data[0]['guardianname1']}}</h4>
                                        </div>
                                    </div>

                                      <div class="row">
                                        <div class="col-md-6">
                                            <h4 class="card-title">Guardianemail1</h4>
                                        </div>
                                        <div class="col-md-6">
                                            <h4 class="card-title">{{$data[0]['guardianemail1']}}</h4>
                                        </div>
                                    </div>


                                      <div class="row">
                                        <div class="col-md-6">
                                            <h4 class="card-title">Guardianphone1</h4>
                                        </div>
                                        <div class="col-md-6">
                                            <h4 class="card-title">{{$data[0]['guardianphone1']}}</h4>
                                        </div>
                                    </div>

                                       <div class="row">
                                        <div class="col-md-6">
                                            <h4 class="card-title">Guardianname2</h4>
                                        </div>
                                        <div class="col-md-6">
                                            <h4 class="card-title">{{$data[0]['guardianname2']}}</h4>
                                        </div>
                                    </div>
                                      <div class="row">
                                        <div class="col-md-6">
                                           <h4 class="card-title">Guardianemail2</h4>
                                        </div>
                                        <div class="col-md-6">
                                            <h4 class="card-title">{{$data[0]['guardianemail2']}}</h4>
                                        </div>
                                    </div>


                                      <div class="row">
                                        <div class="col-md-6">
                                            <h4 class="card-title">Guardianphone2</h4>
                                        </div>
                                        <div class="col-md-6">
                                            <h4 class="card-title">{{$data[0]['guardianphone2']}}</h4>
                                        </div>
                                    </div>
                                      <div class="row">
                                        <div class="col-md-6">
                                            <h4 class="card-title">T-size</h4>
                                        </div>
                                        <div class="col-md-6">
                                            <h4 class="card-title">{{$data[0]['tsize']}}</h4>
                                        </div>
                                    </div>

                                      <div class="row">
                                        <div class="col-md-6">
                                            <h4 class="card-title">Last Login</h4>
                                        </div>
                                        <div class="col-md-6">
                                            <h4 class="card-title">{{$data[0]['last_login']}}</h4>
                                        </div>
                                    </div>
                        </div>
                      </div>
                      </div>
                    </div>
                </div>
               
        </div>
        @endif
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>

<script type="text/javascript">
  
  function money(id)
  {
   
    $('#desc').show();
   $("#"+id).show();
   $("#"+id+"_des").show();
   
  }
Highcharts.chart('container', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
    title: {
        text: 'School Vs Team'
    },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
    },
    accessibility: {
        point: {
            valueSuffix: '%'
        }
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: true,
                format: '<b>{point.name}</b>: {point.percentage:.1f} %'
            }
        }
    },
    series: [{
        name: 'Brands',
        colorByPoint: true,
        data: [{
            name: 'Chrome',
            y: 61.41,
            sliced: true,
            selected: true
        }, {
            name: 'Internet Explorer',
            y: 11.84
        }, {
            name: 'Firefox',
            y: 10.85
        }, {
            name: 'Edge',
            y: 4.67
        }, {
            name: 'Safari',
            y: 4.18
        }, {
            name: 'Sogou Explorer',
            y: 1.64
        }, {
            name: 'Opera',
            y: 1.6
        }, {
            name: 'QQ',
            y: 1.2
        }, {
            name: 'Other',
            y: 2.61
        }]
    }]
});  
</script>

<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>

         var SITEURL = '{{URL::to('')}}';

         $.ajaxSetup({
           headers: {
               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
           }
         }); 

         $('body').on('click', '.buy_now', function(e){

          var totalAmount = $(this).attr("data-amount");
          var user_name =  $(this).attr("data-name");
          var user_email =  $(this).attr("data-email");
          var student_id =  $(this).attr("data-studentid");
          var school_id =  $(this).attr("data-schoolid");

           var options = {
           "key": "rzp_test_Cr9ufbKsTwLJJW",
           "amount": (totalAmount*100), // 2000 paise = INR 20
           "name": user_name,
           "razorpay_order_id":'kun123',
           "description": "College Activation pay",
           "image": "{{url('assets/website/img/tos-logo.png')",
           "handler": function (response){

                 $.ajax({
                   url: SITEURL + '/college_pay',
                   type: 'post',
                   dataType: 'json',
                   data: {
                     razorpay_payment_id: response.razorpay_payment_id, 
                     totalAmount : totalAmount,
                     student_id : student_id,
                     school_id : school_id
                   }, 
                   headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                   success: function (data) {
                      
                      console.log(data.msg);
                      alert(data.msg)
                     window.location.href = SITEURL + '/dashboard';
                   }
               });
             
           },
          "prefill": {
               "contact": 'xxxxxxxxxx',
               "email":   user_email,
           },
           "notes":{
                "address": "note value"
            },
           "theme": {
               "color": "#528FF0"
           }
         };

         var rzp1 = new Razorpay(options);
         rzp1.open();
         e.preventDefault();
         });

      </script>


@endsection
<style type="text/css">
  .highcharts-figure, .highcharts-data-table table {
    min-width: 320px; 
    max-width: 800px;
    margin: 1em auto;
}

.highcharts-data-table table {
  font-family: Verdana, sans-serif;
  border-collapse: collapse;
  border: 1px solid #EBEBEB;
  margin: 10px auto;
  text-align: center;
  width: 100%;
  max-width: 500px;
}
.highcharts-data-table caption {
    padding: 1em 0;
    font-size: 1.2em;
    color: #555;
}
.highcharts-data-table th {
  font-weight: 600;
    padding: 0.5em;
}
.highcharts-data-table td, .highcharts-data-table th, .highcharts-data-table caption {
    padding: 0.5em;
}
.highcharts-data-table thead tr, .highcharts-data-table tr:nth-child(even) {
    background: #f8f8f8;
}
.highcharts-data-table tr:hover {
    background: #f1f7ff;
}


input[type="number"] {
  min-width: 50px;
}
</style>
