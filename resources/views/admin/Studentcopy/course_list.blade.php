
@extends('layouts.student')
@section('contents')
<!--SLIDER NAV END-->

<div class="bg3">
  <div class="container">
    <div class="row">
      <div class="col-md-6 col-lg-5">
        <!--Course List-->
        <div class="cards">
          <div class="cards_title">
            <span><img src="{{url('assets1/img/update-ico.png')}}" width="100%"></span>Courses and Training</span>
          </div>
          <div class="cards_course_list">

             @if(count($assigndata)>0)
           @foreach($assigndata as $assigndata1)
           @foreach($assigndata1 as $assigndata2)
             <?php 
            $assigdt=strtotime($assigndata2->asshigneddate) ;
            $systmdt=strtotime($systemdate);
            $newDateString = date('d/m/Y', $assigdt);

            $ids=$assigndata2->id."/".$studentid."/".$schoolid."/".$planid."/".$assigndata2->resumevedio."/".$assigndata2->thumbnail."/".$assigndata2->asshigneddate;
                ?>
           @if($assigndata2->id==$vedioid)
          
       @if($newDateString=="12/12/1993")
           <div class="activity">
              <div class="title"><span>{{$assigndata2->title}}</span>
              </div>
          <a class="btn btn-danger" href="{{url('vediojs')}}/{{base64_encode($ids)}}">View</a> 
              <a class="btn btn-outline-danger disabled"   href="#"  target="_blank">
                Attempt
              </a>
              
            </div>
           @else
           <div class="activity">
              <div class="title"><span>{{$assigndata2->title}}</span>
              </div>
          <a class="btn btn-danger" href="{{url('vediojs')}}/{{base64_encode($ids)}}">View</a> 
              <a class="btn btn-outline-danger" @if($assigdt>$systmdt)  disabled @endif    @if($assigdt<=$systmdt) href="{{url('attempvediojs')}}/{{base64_encode($ids)}}"  @endif     target="_blank">
                Attempt
              </a>
              
            </div>
           @endif
           @else
           @if($newDateString=="12/12/1993")
           <div class="activity">
              <div class="title"><span>{{$assigndata2->title}}</span>
              </div>
          <a class="btn btn-danger" href="{{url('vediojs')}}/{{base64_encode($ids)}}">View</a> 
              <a class="btn btn-outline-danger  disabled" href="#"  target="_blank">
                Attempt
              </a>
              
            </div>
           @else
           <div class="activity">
              <div class="title"><span>{{$assigndata2->title}}</span>
              </div>
          <a class="btn btn-danger" href="{{url('vediojs')}}/{{base64_encode($ids)}}">View</a> 
              <a class="btn btn-outline-danger @if($assigdt>$systmdt)  disabled @endif"    @if($assigdt<=$systmdt) href="{{url('attempvediojs')}}/{{base64_encode($ids)}}"  @endif     target="_blank">
                Attempt
              </a>
              
            </div>
           @endif
      
           @endif

        @endforeach
        @endforeach
        @endif
          </div>
        </div>
        <!--Course List END-->
      </div>
      <div class="col-md-6 col-lg-7">
<?php
$newDateString = date('d/m/Y', $assigdt);
$d =date('d/m/Y', strtotime($assigndate));
?>

<!-- img/activity-img.png -->
        <!--Activity-->
        <div class="cards">
          <img src="{{url('docs')}}/{{$thumbnail}}" width="100%">
          <div class="course">
            <h1 class="title">{{$courseinfo[0]->title}}</h1>
            <h2 class="sub_title">{{$courseinfo[0]->course_name}}</h2>
            <p>{{$courseinfo[0]->description}}</p>
             @if($d=="12/12/1993") 
             <div class="detail"><span>Activation Date</span>Date Not Assigned &nbsp;&nbsp;&nbsp;<span>Format</span> {{$courseinfo[0]->type}} &nbsp;&nbsp;&nbsp;<span>Duration</span> 12min</div>
             @else 
            <?php
            $var = $d;
            $date = str_replace('/', '-', $var);
            $date1 =date('Y-m-d', strtotime($date));
          
            ?>
             <div class="detail"><span>Activation Date</span> {{date('d F,Y',strtotime($date1))}}   &nbsp;&nbsp;&nbsp;<span>Format</span> {{$courseinfo[0]->type}} &nbsp;&nbsp;&nbsp;
              <span>Duration</span> 12min</div>
             @endif
            
<!-- 
              <div class="btn btn-dark">Start</div> 
              <div class="btn btn-outline-dark">View Document</div> -->
          </div>
        </div>
        <!--Activity END-->
      </div>
    </div>
  </div>
</div>

<!--Challenges-->
  

@endsection