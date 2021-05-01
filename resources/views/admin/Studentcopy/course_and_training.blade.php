@extends('layouts.student')
@section('contents')
<!--SLIDER NAV-->

<!--SLIDER NAV END-->
<style type="text/css">
  }
.cards_list ol li {
  list-style-type: none;
}
</style>

<div class="bg3">

  <div class="container">
    
    <div class="row">
     
      <div class="col-md-8">
        
         @if(count($assigndata)>0)
         <?php $i=1; ?>
    @foreach($assigndata as $assigndata1)
    @foreach($assigndata1 as $assigndata2)
   
    <?php $assigdt=strtotime($assigndata2->asshigneddate) ;
          $systmdt=strtotime($systemdate);
          $newDateString = date('d/m/Y', $assigdt);
          $ids=$assigndata2->id."/".$studentid."/".$schoolid."/".$planid."/".$assigndata2->resumevedio."/".$assigndata2->thumbnail."/".$assigndata2->asshigneddate;
    ?>
        <!--Course-->
        <div class="cards">
          <div class="cards_title">
            <span>
               @if($assigndata2->thumbnail!='')
                    <img src="{{url('docs')}}/{{$assigndata2->thumbnail}}" width="100%">
                    @else
                     <img src="{{url('assets1/img/update-ico.png')}}" width="100%">
                   @endif
             
            </span>{{$assigndata2->title}}</span>
          </div>
          <div class="cards_activity">
            <div class="row">
              <div class="col-md-4 col-lg-5">
                <div class="comp_image">

                  @if($assigndata2->thumbnail!='')
                    <img src="{{url('docs')}}/{{$assigndata2->thumbnail}}" width="100%">
                    @else
                     <img src="{{url('assets1/img/update-ico.png')}}" width="100%">
                   @endif

                </div>
                <div class="comp_title">{{$assigndata2->title}}</div>
                <div class="stats">1K Views  &nbsp; &#9679;  &nbsp; 48 min  &nbsp; &#9679;  &nbsp; @if($newDateString=="12/12/1993") Not Assigned Date @else{{$newDateString}}@endif</div>
              </div>
              <div class="col-md-8 col-lg-7">
                <p>{{$assigndata2->description}}</p>
                <div class="text-right">
                  <a href="{{url('vediojs')}}/{{base64_encode($ids)}}" class="text-danger" target="_blank">View</a>
                  
                  @if($assigndata2->doc_types_id==3||$assigndata2->doc_types_id==1)

                  | <a href="{{url('docs')}}/{{$assigndata2->doc_path}}" class="text-danger" target="_blank"> Download Document</a>
                  @endif
                 |<a href="{{url('attempvediojs')}}/{{base64_encode($ids)}}"  target='_blank' class="text-secondary" target="_blank">
                  <button  @if($assigdt>$systmdt) disabled @endif    @if($newDateString=="12/12/1993") disabled @endif type="button" class="btn btn-sm btn-outline-secondary">Attempt</button>
                 </a>
               </div>
              </div>
            </div>
          </div>
        </div>
        <!--Course END-->
        <?php $i =$i+1;?>
        @endforeach
        @endforeach
        @else
        <div class="cards">
          <div class="cards_title">
            <span>
            </span>Activity</span>
          </div>
          <div class="cards_activity">
            <div class="row">
              <div class="col-md-4 col-lg-5">
                <div class="comp_image">
                </div>
                <div class="comp_title"></div>
                <div class="stats"></div>
              </div>
              <div class="col-md-8 col-lg-7">
                <p>NO Plan Assign Yet.</p>
                <div class="text-right">
               </div>
              </div>
            </div>
          </div>
        </div>
        @endif
        

      </div>
      



      <div class="col-md-4">
        <!--Notification-->
        <div class="cards">
          <div class="cards_title">
            <span><img src="{{url('assets1/img/update-ico.png')}}" width="100%"></span>Notifications<span class="cards_title_redirect"><img src="{{url('assets1/img/redirect.png')}}" width="100%"></span>
          </div>
          <div class="cards_list">
            <ol>
              <li>Yay! Your Design no. 23 has been approved.</li>
              <li>Marketing & Digital Media Strategy is now Open! Click to view.</li>
              <li>Devansh Sharma submitted Design No. 24 for approval</li>
            </ol>
          </div>
        </div>
        <!--Notification END-->

       <!--Exploare Certificate Courses-->
        <div class="cards">
          <div class="cards_title">
            <span><img src="{{url('assets1/img/update-ico.png')}}" width="100%"></span>View course documents
          </div>
          <div class="cards_list">

            <ol>
             
             @if(count($assigndata)>0)
             <?php $i=1;?>
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
                   <a href="{{url('docs')}}/{{$assigndata2->doc_path}}" class="text-danger" target="_blank"> Download Document</a>
                  @endif
                </span>
              </li>
               <?php $i=$i+1;?>
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