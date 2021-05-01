@extends('layouts.student1')
@section('contents')

<div class="bg2" style="background-image: url(assets1/img/sld1.jpg);">
  <div class="container">
    <div class="col-sm-4 col-md-3 col-lg-3">
      
    </div>
    <div class="col-sm-8 col-md-9 col-lg-9">
      
    </div>
  </div>
</div>

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
        $date = str_replace('/', '-', $date);
        ?>
     
        <p class="last">Last Login: {{date('d F, Y | g:h:a',strtotime($date))}}</p>

       
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
        <div class="cards">
          <div class="cards_title">
            <span><img src="{{url('assets1/img/update-ico.png')}}" width="100%"></span>Updates<span class="cards_title_redirect"><img src="{{url('assets1/img/redirect.png')}}" width="100%"></span>
          </div>
          <div class="cards_updates">
            <div class="grid_holder">
              <div class="w1"><img src="{{url('assets1/img/profile.png')}}"></div>
              <div class="w2">
                <div class="title">Lorem Ipsum</div>
                <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium</p>
                <span>48 min ago</span>
              </div>
            </div>
            <div class="grid_holder">
              <div class="w1"><img src="{{url('assets1/img/profile.png')}}"></div>
              <div class="w2">
                <div class="title">Lorem Ipsum</div>
                <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium</p>
                <span>48 min ago</span>
              </div>
            </div>
          </div>
        </div>
        <!--UPDATES END-->

        <!--COURSES AND TRAINING-->
        <div class="cards">
          <div class="cards_title">
            <span><img src="{{url('assets1/img/update-ico.png')}}" width="100%"></span>Courses and Training<span class="cards_title_redirect"><img src="{{url('assets1/img/redirect.png')}}" width="100%"></span>
          </div>
          <div class="owl-carousel owl-theme cards_courses">
          @if(count($assigndata)>0)
          @foreach($assigndata as $assigndata1)
          @foreach($assigndata1 as $assigndata2) 
          <div class="item">
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
                  <?php $assigdt=strtotime($assigndata2->asshigneddate) ;
                $systmdt=strtotime($systemdate);
                $newDateString = date('d/m/Y', $assigdt);
              
                $ids=$assigndata2->id."/".$studentid."/".$schoolid."/".$planid."/".$assigndata2->resumevedio."/".$assigndata2->thumbnail."/".$assigndata2->asshigneddate;
                ?>
                  <div class="mini_cards_controls"><a href="{{url('vediojs')}}/{{base64_encode($ids)}}" class="text-danger" target='_blank'>Countinue Watching</a> </div>
                </div>
              </div>
          </div>
           @endforeach
          @endforeach
           @else
         <div class="item">
            <div class="grid_holder">
                <div class="mini_cards_content">
                  <h3 class="title">NO Plan Assign Yet.</h3>
                </div>
              </div>
          </div>
          @endif
        </div>
        </div>

        <!--COURSES AND TRAINING END-->

        <!--TEAM-->
        <div class="cards">
          <div class="cards_title">
            <span>
            <img src="{{url('assets1/img/update-ico.png')}}" width="100%">
           </span>Team</span>
          </div>
          <div class="cards_team">
            <div class="cards_team_head">
              <div class="team_logo"></div>

              <div class="team_name">
                @if($info!='NO')
                {{$info[0]->team_Name}}
                @else
                No Team.
                @endif
              </div>

              <div class="team_car">
              @if($info!='NO')
                <img src="{{url('team')}}/{{$info[0]->team_Image}}" width="100%">
                @else
                <img src="{{url('assets1/img/team-car.jpg')}}" width="100%">
                @endif
              </div>
            </div>
          </div>

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
              @else
              <tr>
               No Team Yet.  
              </tr>
              @endif

               
              </tbody>
            </table>
          </div>
        </div>
        <!--TEAM END-->

        <!--Design-->
        <div class="cards">
          <div class="cards_title">
            <span><img src="{{url('assets1/img/update-ico.png')}}" width="100%"></span>Design</span>
          </div>
          <div class="cards_design">
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
                  <dd class="col-sm-8">01</dd>
                </dl>
                <?php $ids = $studentid."_".$schoolid ?>
                <?php $ids1 = $studentid.".".$schoolid ?>
                <img src="{{url('assets1/img/car-design.jpg')}}" width="100%">
                <div class="text-right"><a href="{{url('newmanufatureCar')}}/{{base64_encode($ids)}}" class="text-danger">Upload New Design</a>&nbsp|&nbsp<a href="{{url('manufacturePage')}}/{{base64_encode($ids1)}}" class="text-secondary">Check Approval Status</a></div>
              </div>
            </div>
          </div>
        </div>
        <!--Design END-->

        <!--Order Status-->
        <div class="cards">
          <div class="cards_title">
            <span><img src="{{url('assets1/img/update-ico.png')}}" width="100%"></span>Order Status</span>
          </div>
          <div class="table_red_border" style="margin-top: 25px;">
            <table class="table table-borderless text-center">
              <thead>
                <tr>
                  <th scope="col">Date</th>
                  <th scope="col">Order Id</th>
                  <th scope="col">Item</th>
                  <th scope="col">Status</th>
                </tr>
              </thead>
              <tbody>
                @if($manufacture!='NO')
                @foreach($manufacture as $key=>$manufact)
                                                    <?php
        $currentTime = date('d/m/Y', strtotime($manufact->created_at));
        ?>
              @if($manufact->applicationid!='N/A')
                <tr>
                  <td>{{$currentTime}}</td>
                  <td>{{$manufact->applicationid}}</td>
                  <td>@mdo</td>
                  <td>
                  @if($manufact->MemberStatus==1)
                  Approved
                  @else
                  Pending
                  @endif
                  </td>
                </tr>
                @endif

                 @endforeach
                @else
                <tr>No Manufacture Yet.</tr>
                @endif
              </tbody>
            </table>
          </div>
        </div>
        <!--Order Status END-->

        <!--Competition-->
        <div class="cards">
          <div class="cards_title">
            <span><img src="{{url('assets1/img/update-ico.png')}}" width="100%"></span>Competition</span>
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
                    <dt>No Competition yet.</dt>
                
                </div>
              </div>
            </div>
            @endif
         <?php $ids = $studentid."_".$schoolid ?>
              <div class="text-center"><a href="{{url('student/competition')}}/{{base64_encode($ids)}}" class="text-danger">View More</a></div>
          </div>
        </div>
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
              <li>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.</li>
              <li>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</li>
              <li>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.</li>
            </ol>
          </div>
        </div>
        <!--Notification END-->

        <!--Exploare Certificate Courses-->
        <div class="cards">
          <div class="cards_title">
            <span><img src="{{url('assets1/img/update-ico.png')}}" width="100%"></span>Explore Certificate Courses
          </div>
          <div class="cards_list">

            <ol>
             @if(count($assigndata)>0)
             @foreach($assigndata as $key=> $assigndata1)
             @foreach($assigndata1 as $assigndata2)
            <?php $assigdt = strtotime($assigndata2->asshigneddate);
            $systmdt = strtotime($systemdate);

            $newDateString = date('d/m/Y', $assigdt);

            $ids = $assigndata2->id . "/" . $studentid . "/" . $schoolid . "/" . $planid . "/" . $assigndata2->resumevedio . "/" . $assigndata2->thumbnail . "/" . $assigndata2->asshigneddate;
            ?>
              <li class="course"><div class="text">{{$key+1}}. {{$assigndata2->title}}.</div>
                <span>
                  <a href="{{url('vediojs')}}/{{base64_encode($ids)}}" class="text-danger" target="_blank">View</a>
                   <a href="{{url('attempvediojs')}}/{{base64_encode($ids)}}" class="text-secondary" target="_blank">Attempt</a>
                </span>
              </li>
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
        <!--Exploare Certificate Courses END-->

        <!--Upcoming Events-->
        <div class="cards">
          <div class="cards_title">
            <span><img src="{{url('assets1/img/update-ico.png')}}" width="100%"></span>Upcoming Events
          </div>
          <div class="cards_list">
            <ol>
              <li>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.</li>
              <li>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</li>
              <li>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.</li>
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
        <div class="img_cards">

          <div class="img_cards_content">
            <h3 class="title">Lorem ipsum dolor sit.</h3>
          </div>

          <div class="img_cards_image">
          </div>

        </div>
      </div>
      <div class="col-lg-3 col-md-6">
        <div class="img_cards">

          <div class="img_cards_content">
            <h3 class="title">Lorem ipsum dolor sit.</h3>
          </div>
          
          <div class="img_cards_image">
          </div>

        </div>
      </div>
      <div class="col-lg-3 col-md-6">
        <div class="img_cards">

          <div class="img_cards_content">
            <h3 class="title">Lorem ipsum dolor sit.</h3>
          </div>
          
          <div class="img_cards_image">
          </div>

        </div>
      </div>
      <div class="col-lg-3 col-md-6">
        <div class="img_cards">

          <div class="img_cards_content">
            <h3 class="title">Lorem ipsum dolor sit.</h3>
          </div>
          
          <div class="img_cards_image">
          </div>

        </div>
      </div>
    </div>
  </div>
  <!--Challenges-->
</div>
@endsection
