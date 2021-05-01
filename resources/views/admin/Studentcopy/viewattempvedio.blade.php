@extends('layouts.student')
@section('contents')


  <div class="album py-5 bg-light">
    <div class="container-fluid">

      <div class="row">
<div class="col-md-4">
          
  <ul class="list-group">
   @if(count($assigndata)>0)
    @foreach($assigndata as $assigndata1)
    @foreach($assigndata1 as $assigndata2)
    @if($assigndata2->id==$vedioid)     
  <li class="list-group-item active">
    {{$assigndata2->title}}</p>
    <img src="{{url('docs')}}/{{$assigndata2->thumbnail}}" class="img-fluid" width="40px"  alt="image"> 

            <?php $assigdt=strtotime($assigndata2->asshigneddate) ;
                $systmdt=strtotime($systemdate);
                $newDateString = date('d/m/Y', $assigdt);
                // $myDateTime = DateTime::createFromFormat('Y-m-d', $assigndata2->asshigneddate);
                // $newDateString = $myDateTime->format('d/m/Y');

                $ids=$assigndata2->id."/".$studentid."/".$schoolid."/".$planid."/".$assigndata2->resumevedio."/".$assigndata2->thumbnail."/".$assigndata2->asshigneddate;
                ?>

           <a class="btn btn-sm btn-outline-secondary" href="{{url('vediojs')}}/{{base64_encode($ids)}}">
            View
          </a>&nbsp;
    
            <a href="{{url('attempvediojs')}}/{{base64_encode($ids)}}"  target='_blank'> 
            <button  @if($assigdt>$systmdt) disabled @endif    @if($newDateString=="12/12/1993") disabled @endif type="button" class="btn btn-sm btn-outline-secondary">Attempt</button>
          </a>
          @if($newDateString=="12/12/1993")
           <small class="text-muted">Date Not Assigned</small>
          @else
          <small class="text-muted">{{$newDateString}}</small>
          @endif
  </li>
@else
    <li class="list-group-item">
    {{$assigndata2->title}}</p>
    <img src="{{url('docs')}}/{{$assigndata2->thumbnail}}" class="img-fluid" width="40px"  alt="image"> 

            <?php $assigdt=strtotime($assigndata2->asshigneddate) ;
                $systmdt=strtotime($systemdate);
                $newDateString = date('d/m/Y', $assigdt);
                // $myDateTime = DateTime::createFromFormat('Y-m-d', $assigndata2->asshigneddate);
                // $newDateString = $myDateTime->format('d/m/Y');

                $ids=$assigndata2->id."/".$studentid."/".$schoolid."/".$planid."/".$assigndata2->resumevedio."/".$assigndata2->thumbnail."/".$assigndata2->asshigneddate;
                ?>
          <a class="btn btn-sm btn-outline-secondary" href="{{url('vediojs')}}/{{base64_encode($ids)}}">
            View
          </a>&nbsp;
    
            <a href="{{url('attempvediojs')}}/{{base64_encode($ids)}}"  target='_blank'> 
            <button  @if($assigdt>$systmdt) disabled @endif    @if($newDateString=="12/12/1993") disabled @endif type="button" class="btn btn-sm btn-outline-secondary">Attempt</button>
          </a>
          @if($newDateString=="12/12/1993")
           <small class="text-muted">Date Not Assigned</small>
          @else
          <small class="text-muted">{{$newDateString}}</small>
          @endif
  </li>
@endif

  @endforeach
  @endforeach
 @endif

    


  
</ul>       
</div>
<div class="col-md-8">
          <?php
          $newDateString = date('d/m/Y', $assigdt);
          $d =date('d/m/Y', strtotime($assigndate));
?>

            @foreach($courseinfo as $courseinfo1)
               <?php $test = $courseinfo1->video_path; ?>
            <div class=“course-brief”>
              <img src={{url('docs')}}/{{$thumbnail}} width=“100%“>
              <h1>{{$courseinfo1->title}}</h1>
              <h2>{{$courseinfo1->course_name}}</h2>
              <p>{{$courseinfo1->description}}</p>
              <hr>
              <dl class=“row”>
                <dt class=“col-sm-3">Activation Date</dt>
                @if($d=="12/12/1993")
            <dd class=“col-sm-9”>Date Not Assigned</dd>
          @else
          <dd class=“col-sm-9”>{{$newDateString}}</dd>
          @endif
                
                <dt class=“col-sm-3">Format</dt>
                <dd class=“col-sm-9”>{{$courseinfo1->type}}</dd>
                <dt class=“col-sm-3">Duration</dt>
                <dd class=“col-sm-9">{{$courseinfo1->duration}}</dd>
                <dt class=“col-sm-3">
                 @if($courseinfo1->doc_types_id==1)
                  <a class="btn btn-warning btn-block" href="{{url('docs')}}/{{$courseinfo1->doc_path}}" target="_blank">Show Document</a>
                @elseif($courseinfo1->doc_types_id==2)

                  <a class="btn btn-warning btn-block" href="{{url('Attepmtplayvedio')}}/{{base64_encode($vedioplayurl)}}">Start</a>
                  @else
                    <a class="btn btn-warning btn-block" href="{{url('docs')}}/{{$courseinfo1->doc_path}}" target="_blank"> Read Document</a>
                    <a class="btn btn-warning btn-block" href="{{url('Attepmtplayvedio')}}/{{base64_encode($vedioplayurl)}}">Start</a>
                @endif
              </dt>
                <dd class=“col-sm-9”></dd>
              </dl>
              <hr>
            </div>
              @endforeach
        </div>
    </div>
    
    
    


</main>
@endsection


