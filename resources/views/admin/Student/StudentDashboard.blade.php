@extends('layouts.student')
@section('contents')

<div class="bg2" style="background-image: url(public/assets1/img/sld1.jpg);">
  <div class="container">
    <div class="col-sm-4 col-md-3 col-lg-3">
      
    </div>
    <div class="col-sm-8 col-md-9 col-lg-9">
      
    </div>
  </div>
</div>

@if (Auth::check()) 
    <script>
    var timeout = ({{config('session.lifetime')}} * 60000) -10 ;
    setTimeout(function(){
        window.location.reload(1);
    },  timeout);
    </script>
@endif
<div class="dash_profile" style="background-image: url('assets1/img/das-bg.jpg')">
  <div class="container">
    <div class="row">
      <div class="col-sm-4 col-md-3 col-lg-3">
        <div class="profile-image">
        @if($studentName->profileimage!=null)
        <img src="{{url('studentprofileimage')}}/{{$studentName->profileimage}}" width="100%">
        @else
          <img src="{{url('assets1/img/profile-img.png')}}" width="100%">
        @endif
        </div>
      </div>
      <div class="col-sm-8 col-md-9 col-lg-9">
        <h1 class="name">{{$studentName->name}}</h1>
        <h2 class="school">{{$studentName->school_name}}</h2>
        <?php 
        $date = $studentName->last_login;

      
        ?>
     
        <p class="last">
            Last Login: {{ ($studentName->last_login)==''? 'Never Logged-in': date('d F, Y | h:i:a',$date) }}
        <!-- Last Login: {{date('d F, Y | h:i:a',$date)}} -->
      </p>

       
         <img src="{{url('assets1/img/profile-car.png')}}" width="100%">
      
        
<!-- Last Login: 2 May, 2020  -->
      </div>
    </div> 
  </div>
</div>

<div class="bg3">
  <div class="container">
    <div class="row">
      <div class="col-md-8">
        <!--UPDATES-->
      <!--  <div class="cards">
          <div class="cards_title">
            <span><img src="{{url('public/assets1/img/update-ico.png')}}" width="100%"></span>Updates<span class="cards_title_redirect"><img src="{{url('public/assets1/img/redirect.png')}}" width="100%"></span>
          </div>
          <div class="cards_updates">
            <div class="grid_holder">
              <div class="w1"><img src="{{url('public/assets1/img/profile.png')}}"></div>
              <div class="w2">
                <div class="title">Lorem Ipsum</div>
                <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium</p>
                <span>48 min ago</span>
              </div>
            </div>
            <div class="grid_holder">
              <div class="w1"><img src="{{url('public/assets1/img/profile.png')}}"></div>
              <div class="w2">
                <div class="title">Lorem Ipsum</div>
                <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium</p>
                <span>48 min ago</span>
              </div>
            </div>
          </div>
        </div>
		-->
		
        <!--UPDATES END-->

        <!--COURSES AND TRAINING-->
        <div class="cards">
          <div class="cards_title">
            <span><img src="{{url('assets1/img/update-ico.png')}}" width="100%"></span>Courses and Training
            @if(count($assigndata)>0)
            <a href="{{url('courseList')}}"><span class="cards_title_redirect"><img src="{{url('assets1/img/redirect.png')}}" width="100%"></span></a>
            @endif
          </div>
       
          @if(count($assigndata)>0)
          <div class="owl-carousel owl-theme cards_courses">
          @foreach($assigndata as $assigndata1)
          @foreach($assigndata1 as $assigndata2) 
		   <?php $assigdt=strtotime($assigndata2->asshigneddate) ;
                $systmdt=strtotime($systemdate);
                $newDateString = date('d/m/Y', $assigdt);
              
                $ids=$assigndata2->id."/".$studentid."/".$schoolid."/".$planid."/".$assigndata2->resumevedio."/".$assigndata2->thumbnail."/".$assigndata2->asshigneddate;
                ?>
          <div class="item" onclick="location.href='{{url('vediojs')}}/{{base64_encode($ids)}}'">
              <div class="grid_holder">
                <div class="user_name">
                  <span>
                    
                    @if($assigndata2->thumbnail!='')
                    <img src="{{url('docs')}}/{{$assigndata2->thumbnail}}" width="100%">
                    @else
                    <img src="{{url('assets1/img/profile.png')}}" width="100%">
                   @endif
                  </span>
                    {{$assigndata2->title}}
                </div>
                <div class="course_image"> 
                  @if($assigndata2->thumbnail!='')
                  <img src="{{url('docs')}}/{{$assigndata2->thumbnail}}" class="img-fluid";  alt="image"> 
                  @else

                  @endif
                </div>
                <div class="mini_cards_content">
                  <h3 class="title">{{$assigndata2->description}}.</h3>
                 
                  <!-- <div class="mini_cards_controls"><a href="{{url('vediojs')}}/{{base64_encode($ids)}}" class="text-danger" target='_blank'>Countinue Watching</a> </div> -->
                </div>
              </div>
          </div>
           @endforeach
          @endforeach
        </div>
           @else
        <div class="owl-carousel owl-theme cards_courses">
         <div class="item">
            <div class="grid_holder">
                <div class="mini_cards_content">
                  <h3 class="title">No Courses Assigned To The Student.</h3>
                </div>
              </div>
          </div>
          </div>
          @endif
       
        </div>

        <!--COURSES AND TRAINING END-->

        <!--TEAM-->
          @if(count($info)>0)
        <div class="cards">
          <div class="cards_title">
            <span>
            <img  src="{{url('assets1/img/update-ico.png')}}" width="100%">
           </span>Team</span>
             @if(count($info)>0)
              @if($info!='NO')
           <a href="{{url('viewTeam/')}}/{{base64_encode($studentid.'_'.$schoolid)}}"><span class="cards_title_redirect"><img src="{{url('assets1/img/redirect.png')}}" width="100%"></span></a>
           @endif
           @endif

          </div>
          <div class="cards_team">
            @if(count($info)>0)
              @if($info!='NO')
            <div class="cards_team_head">

              <div  class="team_logo" style="background-image: url('./team/{{$info[0]->team_Image}}'">

              </div>

              <div class="team_name">
                @if(count($info)>0)
                @if($info!='NO')
                {{$info[0]->team_Name}}
                @else
                No Team Assigned To The Student
                @endif
                @else
                No Team Assigned To The Student
                @endif
              </div>

              <div class="team_car">
                  <img src="{{url('assets1/img/team-car.jpg')}}" width="100%">
              </div>
            </div>
            @else
            No Team Assign
            @endif
            @else
            No Team Assign
            @endif
          </div>

          
            @if(count($info)>0)
              @if($info!='NO')
            <div class="card_team_content table_red_border">
            <table class="table table-borderless text-center">
              <thead>
                <tr>
                  <th scope="col">Name</th>
                  <th scope="col">Role</th>
                  <th scope="col">Status</th>
                </tr>
              </thead>
              <tbody>
              @if(count($info)>0)
              @if($info!='NO')
              @foreach($info as $key=>$teamMemRole)
                <tr>
                  <td>{{$teamMemRole->MembarName}}</td>
                  <td>{{$teamMemRole->Role}}</td>
                  <td>
                  @if($teamMemRole->MemberStatus==1)
                  Approved
                  @else
                  Pending
                  @endif
                  </td>
                </tr>
               @endforeach
              @endif
              @endif
              </tbody>
            </table>
            </div>
            @endif
            @endif
          
        </div>
          @endif
        <!--TEAM END-->

        <!--Design-->
        @if($appieddesign>0)
        <div class="cards">
          <div class="cards_title">
            <span><img src="{{url('assets1/img/update-ico.png')}}" width="100%"></span>Design</span>
            @if($appieddesign>0)
            <?php $ids1 = $studentid.".".$schoolid ?>
            <a href="{{url('manufacturePage')}}/{{base64_encode($ids1)}}"><span class="cards_title_redirect"><img src="{{url('assets1/img/redirect.png')}}" width="100%"></span></a>
            @endif
          </div>
          <div class="cards_design">
             @if($appieddesign>0)
            <div class="row">
              <div class="col-md-4 col-lg-3">
                <div class="design_details">
                  <dl>
                    <dt>Total Design Uploaded</dt>
                    <dd>{{$appieddesign}}</dd>
                    <dt>Total Design Approved</dt>
                    <dd>{{$designaproved}}</dd>
                    <dt>Total Design Approval Pending</dt>
                    <dd>{{$designpending}}</dd>
                  </dl>
                </div>
              </div>
              <div class="col-md-8 col-lg-9">
                <dl class="row design_details">
                  <dt class="col-sm-4">Total Design Manufactured</dt>
                  <dd class="col-sm-8">{{$oredersuccess}}</dd>
                </dl>
                <?php $ids = $studentid."_".$schoolid ?>
                
                <img src="{{url('assets1/img/car-design.jpg')}}" width="100%">
                <div class="text-right"><a href="{{url('newmanufatureCar')}}/{{base64_encode($ids)}}" class="text-danger">Upload New Design</a>&nbsp|&nbsp<a href="{{url('manufacturePage')}}/{{base64_encode($ids1)}}" class="text-secondary">Check Approval Status</a></div>
              </div>
            </div>
            @else
            <div class="row">
            <div class="col-md-4 col-lg-3">
            <div class="design_details">
              No Manufacturing Designs Uploaded Yet
            </div>
          </div>
            </div>
            @endif
          </div>
        </div>
        @endif
        <!--Design END-->

        <!--Order Status-->
       <!--      <div class="cards">
          <div class="cards_title">
            <span><img src="{{url('public/assets1/img/update-ico.png')}}" width="100%"></span>Order Status</span>
        @if(count($order)>0)
             <?php $ids1 = $studentid."_".$schoolid ?>
            <a href="{{url('orderList')}}/{{base64_encode($ids1)}}"><span class="cards_title_redirect"><img src="{{url('public/assets1/img/redirect.png')}}" width="100%"></span></a>
            @endif
          </div>
           @if(count($order)>0)
          <div class="table_red_border" style="margin-top: 25px;">
            <table class="table table-borderless text-center">
              <thead>
                <tr>
                  <th scope="col">Date</th>
                  <th scope="col">Order Id</th>
                  <th scope="col">Order By</th>
                  <th scope="col">Status</th>
                </tr>
              </thead>
              <tbody>
                @if(count($order)>0)
                @foreach($order as $order1)
                                                    <?php
        $currentTime = date('d/m/Y', strtotime($order1->created_at));
        ?>
                <tr>
                  <td>{{$currentTime}}</td>
                  <td>{{$order1->order_id}}</td>
                  <td>{{$order1->studentname}}</td>
                  <td>
                  @if($order1->transaction_id=="") Failed @else Success @endif
                  </td>
                </tr>
                 @endforeach
                @else
                <tr>No Order Placed Yet.</tr>
                @endif
              </tbody>
            </table>
             </div>
            @else
            No orders Pending!.
            @endif
         
        </div>
		-->
        <!--Order Status END-->

        <!--Competition-->
         @if(count($viewcompetition)>0)
        <div class="cards">
          <div class="cards_title">
            <span><img src="{{url('assets1/img/update-ico.png')}}" width="100%"></span>Competition</span>
               @if(count($viewcompetition)>0)
               <?php $ids = $studentid."_".$schoolid ?>
            <a href="{{url('student/competition')}}/{{base64_encode($ids)}}"><span class="cards_title_redirect"><img src="{{url('assets1/img/redirect.png')}}" width="100%"></span></a>
            @endif
          </div>
          <div class="cards_competition">
           @if(count($viewcompetition)>0)
          @foreach($viewcompetition as $v)
            <div class="cards_comp_container">
              <div class="comp_title">{{$v->Competition_name}}</div>
              <div class="row">
                <div class="col-md-6">
                  <div class="comp_image">
                    <img src="{{url('assets1/img/car.jpg')}}" width="100%">
                  </div>
                </div>
                <div class="col-md-6">
                  <dl>
                    <dt>Last Date of Manufacturing</dt>
                    <dd>{{date('d F ,Y', strtotime($v->Start_Date))}}</dd>
                    <dt>Date of Online Submission</dt>
                    <dd>{{date('d F,Y',strtotime($v->Ragistration_Date))}}</dd>
                    <dt>Date of ELement Submission</dt>
                    <dd>{{date('d F,Y',strtotime($v->Ragistration_Date))}}</dd>
                  </dl>
                  <p>{{date('d F,Y',strtotime($v->Ragistration_Date))}}<br>{{$v->Ldescription}}</p>
                </div>
              </div>
            </div>
            @endforeach
            @else
             <div class="cards_comp_container">
          
              <div class="row">
               
                <div class="col-md-6">
                  <dl>
                    <dt>Relax, no upcoming competitions for you.</dt>
                
                </div>
              </div>
            </div>
            @endif
              @if(count($viewcompetition)>0)
         <?php $ids = $studentid."_".$schoolid ?>
              <div class="text-center"><a href="{{url('student/competition')}}/{{base64_encode($ids)}}" class="text-danger">View More</a></div>
              @endif
          </div>
        </div>
        @endif
        <!--Competition END-->

      </div>

      <div class="col-md-4">
        <!--Notification-->
        <div class="cards">
          <div class="cards_title">
            <span><img src="{{url('assets1/img/update-ico.png')}}" width="100%"></span>Notifications<span class="cards_title_redirect"><img src="{{url('assets1/img/redirect.png')}}" width="100%"></span>
          </div>
          <div class="cards_list">
            <ol>

        <li>Welcome to the STEM Learning platform powered by F1 in Schools™ India</li>
        <li>Update your Email ID in the PROFILE section to stay updated on upcoming courses, certifications, competitions.</li>
            </ol>
          </div>
        </div>
        <!--Notification END-->

        <!--Exploare Certificate Courses-->
         @if(count($assigndata)>0)
        <div class="cards">
          <div class="cards_title">
            <span><img src="{{url('assets1/img/update-ico.png')}}" width="100%"></span>View course documents
          </div>
          <div class="cards_list">

            <ol>
             @if(count($assigndata)>0)
             <?php $i=1; ?>
             @foreach($assigndata as $key=> $assigndata1)
             @foreach($assigndata1 as $assigndata2)
              @if($assigndata2->doc_types_id==1||$assigndata2->doc_types_id==3)
            <?php $assigdt = strtotime($assigndata2->asshigneddate);
            $systmdt = strtotime($systemdate);
            $newDateString = date('d/m/Y', $assigdt);
            $ids = $assigndata2->id . "/" . $studentid . "/" . $schoolid . "/" . $planid . "/" . $assigndata2->resumevedio . "/" . $assigndata2->thumbnail . "/" . $assigndata2->asshigneddate;
            ?>
              <li class="course"><div class="text">{{$i}}. {{$assigndata2->title}}.</div>
                <span>
                @if($assigndata2->doc_types_id==3||$assigndata2->doc_types_id==1)
                   <!-- <a href="{{url('docs')}}/{{$assigndata2->doc_path}}" class="text-danger" target="_blank"> Download Document</a> -->
                    <a @if($assigdt>$systmdt ||$newDateString=="12/12/1993") disabled  @else href="{{url('docs')}}/{{$assigndata2->doc_path}}" @endif    class="text-danger" target="_blank"> Download</a>
                  @endif
                </span>
              </li>
              <?php $i = $i+1; ?>
              @endif
               @endforeach
              @endforeach
               @else
              <li class="course">
                <div class="text">No Plan Assign yet.</div>
              </li>
              @endif
            </ol>

          </div>
        </div>
        @endif
        <!--Exploare Certificate Courses END-->

        <!--Upcoming Events-->
        <div class="cards">
          <div class="cards_title">
            <span><img src="{{url('assets1/img/update-ico.png')}}" width="100%"></span>Upcoming Events
          </div>
          <div class="cards_list">
            <ol>
           <li><b>STEM Challenge 1 – Powered by F1 in Schools India</b><br>
   Test your skills and compete with your friends in unique STEM challenges designed by F1 in Schools™ India
    </li>
        <li><b>Learn the basics of 3D Designing – Live Session</b><br> 

Not able to learn 3D designing by yourself ? Do not worry. We have got you covered. Keep learning through your STEM course and a live 3D designing training session will come for you soon.
    </li>
    <li><b>Industry Expert Session</b>
Want to learn more about making the right career choices and learning about various industries ? The Industry Expert Session by F1 in Schools™ India will be right place for you to explore all possible opportunities. 
    </li>
            </ol>
          </div>
        </div>
        <!--Upcoming Events END-->
      </div>
    </div>
  </div>
</div>

<!--Challenges-->
  <div class="container">
    <div class="row">
      <h2 class="f2">Explore and Grow</h2>
      <div class="col-lg-3 col-md-6">
        <div class="img_cards"  >

          <div class="img_cards_content">

            <h3 class="title">STEM Courses and Certificates.</h3>
          </div>

          <div class="img_cards_image">
            <img height="100%" src="{{url('assets/website/img/1.jpg')}}">
          </div>

        </div>
      </div>
      <div class="col-lg-3 col-md-6">
        <div class="img_cards">

          <div class="img_cards_content" >
            <h3 class="title">STEM Challenges.</h3>
          </div>
          
          <div class="img_cards_image" >
            <img height="100%" src="{{url('assets/website/img/2.jpg')}}">
          </div>

        </div>
      </div>
      <div class="col-lg-3 col-md-6">
        <div class="img_cards">

          <div class="img_cards_content">
            <h3 class="title">F1 in Schools India Competition.</h3>
          </div>
          
          <div class="img_cards_image">
            <img height="100%" src="{{url('assets/website/img/3.jpg')}}">
          </div>

        </div>
      </div>
      <div class="col-lg-3 col-md-6">
        <div class="img_cards">

          <div class="img_cards_content">
            <h3 class="title">Industry Expert Sessions.</h3>
          </div>
          
          <div class="img_cards_image">
         
            <img height="100%" src="{{url('assets/website/img/4.jpg')}}" alt="">
          </div>

        </div>
      </div>
    </div>
  </div>
  <!--Challenges-->
</div>
@endsection
