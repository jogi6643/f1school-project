
@extends('layouts.student')
@section('contents')
<style>
    a.disabled {
  pointer-events: none;
  cursor: default;
}
</style> 
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

                $ids=$assigndata2->id."/".$studentid."/".$schoolid."/".$planid."/".$assigndata2->resumevedio."/".$assigndata2->thumbnail."/".$assigndata2->asshigneddate;
                ?>
           <a class="btn btn-sm btn-outline-secondary" href="{{url('vediojs')}}/{{base64_encode($ids)}}">
            View
          </a>&nbsp;
            <a href="{{url('attempvediojs')}}/{{base64_encode($ids)}}"  target='_blank'> 
            <button  @if($assigdt>$systmdt) disabled @endif    @if($newDateString=="12/12/1993") disabled @endif type="button" class="btn btn-sm btn-outline-secondary">Attempt</button>
          </a>
          <small class="text-muted">@if($newDateString=="12/12/1993") @else {{$newDateString}} @endif</small>
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
          <!-- <a @if($assigdt>$systmdt) disabled @endif class="btn btn-sm btn-outline-secondary" href="{{url('attempvediojs')}}/{{base64_encode($ids)}}">Attempt
          </a> -->
            <a href="{{url('attempvediojs')}}/{{base64_encode($ids)}}"  target='_blank'> 
            <button  @if($assigdt>$systmdt) disabled @endif    @if($newDateString=="12/12/1993") disabled @endif type="button" class="btn btn-sm btn-outline-secondary">Attempt</button>
          </a>
          <small class="text-muted">@if($newDateString=="12/12/1993")@else {{$newDateString}} @endif</small>
  </li>
@endif

  @endforeach
  @endforeach
 @endif
</ul>       
</div>
<div class="col-md-8">
          <?php
// $myDateTime = DateTime::createFromFormat('Y-m-d', $assigndate);
// $newDateString = $myDateTime->format('d/m/Y');
$newDateString = date('d/m/Y', $assigdt);
$d =date('d/m/Y', strtotime($assigndate));

?>
        <div class=“course-brief”>
              <img src={{url('docs')}}/{{$thumbnail}} width=“100%“>
              <h1>{{$courseinfo[0]->title}}</h1>
              <h2>{{$courseinfo[0]->course_name}}</h2>
              <p>{{$courseinfo[0]->description}}</p>
              <hr>
              <dl class=“row”>
                <dt class=“col-sm-3">Activation Date</dt>
                <dd class=“col-sm-9”>@if($d=="12/12/1993")Date Not Assigned @else {{$d}} @endif</dd>
                <dt class=“col-sm-3">Format</dt>
                <dd class=“col-sm-9”>{{$courseinfo[0]->type}}</dd>
                <dt class=“col-sm-3">Duration</dt>
                <dd class=“col-sm-9">{{$courseinfo[0]->duration}}</dd>
              </dl>
              <hr>
            </div>   
      </div>
    </div>
@endsection


