@extends('layouts.student')
@section('contents')


<main role="main">

@if($pname!=null)

  <section hidden="" class="jumbotron text-center ">
      <h1 class="jumbotron-heading">{{ $pname->name }}</h1>

      <p class="lead text-muted">
          Something short and leading about the collection below—its contents, the creator, etc. Make it short and sweet, but not too short so folks don’t simply skip over it entirely.
      </p>
      <p>
        <a href="{{url('placeorderList/')}}/{{base64_encode($studentid.'.'.$schoolid)}}" class="btn btn-danger my-2">Order Now</a>
        <!-- <a href="#" class="btn btn-secondary my-2">Register</a> -->
      </p>
  </section>


</main>
  @endif
@if(session('status')!=null)
<div style="margin:35px 1%; height:auto; overflow:hidden;">
	<div class="alert alert-warning alert-dismissible fade show" role="alert">
	  <strong>{{session('status')}}</strong>
	  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	  </button>
	</div>
</div>

@endif


<div class="container">


  <div class="nav btn-group nav-tabs" id="myTab" style="width:120px; margin: 45px 0;">
    <button type="button" id="home-tab" data-toggle="tab" href="#home" aria-controls="home" class="btn btn-secondary active" aria-selected="true">
<svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px"
width="24" height="24"
viewBox="0 0 172 172"
style=" fill:#000000;"><g fill="none" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode: normal"><path d="M0,172v-172h172v172z" fill="none"></path><g fill="#ffffff"><path d="M28.66667,14.33333v143.33333h114.66667v-7.16667v-136.16667zM43,28.66667h35.83333v28.66667h-35.83333zM93.16667,28.66667h35.83333v28.66667h-35.83333zM43,71.66667h35.83333v28.66667h-35.83333zM93.16667,71.66667h35.83333v28.66667h-35.83333zM43,114.66667h35.83333v28.66667h-35.83333zM93.16667,114.66667h35.83333v28.66667h-35.83333z"></path></g></g></svg>
    </button>
    <button type="button" id="profile-tab" data-toggle="tab" href="#profile" aria-controls="profile"  class="btn btn-secondary" aria-selected="false">
<svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px"
width="24" height="24"
viewBox="0 0 172 172"
style=" fill:#000000;"><g fill="none" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode: normal"><path d="M0,172v-172h172v172z" fill="none"></path><g fill="#ffffff"><path d="M21.5,28.66667l-14.33333,14.33333l14.33333,14.33333l14.33333,-14.33333zM50.16667,35.83333v14.33333h107.5v-14.33333zM21.5,71.66667l-14.33333,14.33333l14.33333,14.33333l14.33333,-14.33333zM50.16667,78.83333v14.33333h107.5v-14.33333zM21.5,114.66667l-14.33333,14.33333l14.33333,14.33333l14.33333,-14.33333zM50.16667,121.83333v14.33333h107.5v-14.33333z"></path></g></g></svg>
    </button>
  </div>
  
  <div class="tab-content" id="myTabContent">
    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
      <div class="row">
        @if(count($assigndata)>0)
    @foreach($assigndata as $assigndata1)
    @foreach($assigndata1 as $assigndata2)
    <div class="col-sm-6 col-xs-12">
      <div class="Tile Tile-mailadmin">
        <div class="TileHeader">
          <p>{{$assigndata2->title}}</p>
        </div>
        <div class="TileBody">
         
          <div class="TileProduct">
            <div class="TileImage">
              <a href=""> 
                <img src="{{url('docs')}}/{{$assigndata2->thumbnail}}" class="img-fluid";  alt="image"> 
              </a>
            </div>
          </div>
          <div class="TileDescription">
            
            <!-- <span>{{$assigndata2->title}}</span> -->

            <span> {{$assigndata2->description}}</span>

            <?php $assigdt=strtotime($assigndata2->asshigneddate) ;
                $systmdt=strtotime($systemdate);
                $newDateString = date('d/m/Y', $assigdt);
              
                $ids=$assigndata2->id."/".$studentid."/".$schoolid."/".$planid."/".$assigndata2->resumevedio."/".$assigndata2->thumbnail."/".$assigndata2->asshigneddate;
                ?>
          </div>
          <div class="TileControl">
          </div>
        </div>

        <div class="d-flex justify-content-between align-items-center" style="margin:5px 25px;">
        <div class="btn-group">
          <a href="{{url('vediojs')}}/{{base64_encode($ids)}}"  target='_blank'>
            <button  type="button" class="btn btn-sm btn-outline-secondary">View</button>
          </a>&nbsp;
          <a href="{{url('attempvediojs')}}/{{base64_encode($ids)}}"  target='_blank'> 
            <button  @if($assigdt>$systmdt) disabled @endif    @if($newDateString=="12/12/1993") disabled @endif type="button" class="btn btn-sm btn-outline-secondary">Attempt</button>
          </a>
        </div>

        @if($newDateString=="12/12/1993") Not Assigned Date @else<small class="text-muted">{{$newDateString}} </small>@endif
      </div>

      </div>

      

    </div>

  @endforeach
  @endforeach
    @else

 

  <section class="jumbotron text-center">
      <h1 class="jumbotron-heading">No Plan . Please Contact Your School .</h1>
  
  </section>
   
    @endif

  

      </div>
    </div>

    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
      <div class="row">

    @if(count($assigndata)>0)
    @foreach($assigndata as $assigndata1)
    @foreach($assigndata1 as $assigndata2)
     <section>
        <div class="col-sm-12 col-xs-12">
          <a class="Tile2 Tile-mailadmin2" href="#"> 
            <div class="TileBody2">
              <div class="TileDescription2">
                <h2>{{$assigndata2->title}}</h2>
                <div style="
    overflow: hidden;
	text-decoration:none;
	color:#212121; margin-bottom:10px;
    text-overflow: ellipsis;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
">{{$assigndata2->description}}</div>
                <?php $assigdt=strtotime($assigndata2->asshigneddate) ;
                $systmdt=strtotime($systemdate);
                $newDateString = date('d/m/Y', $assigdt);
                

                $ids=$assigndata2->id."/".$studentid."/".$schoolid."/".$planid."/".$assigndata2->resumevedio."/".$assigndata2->thumbnail."/".$assigndata2->asshigneddate;
                ?>
                <div class="btn-group">
            
                    <button  onclick="window.location.href = '{{url('vediojs')}}/{{base64_encode($ids)}}';" type="button" class="btn btn-sm btn-outline-secondary">View</button>
                 <button  onclick="window.location.href = '{{url('attempvediojs')}}/{{base64_encode($ids)}}';" @if($newDateString=="12/12/1993") disabled @endif  @if($assigdt>$systmdt) disabled @endif type="button" class="btn btn-sm btn-outline-secondary">Attempt</button>
                
                </div>
                <span style="float:right;">@if($newDateString=="12/12/1993") Not Assigned Date @else {{$newDateString}} @endif</span>
              </div>
            </div>
            <div class="TileHeader2">
                <div class="TileImage2"><img src="{{url('docs')}}/{{$assigndata2->thumbnail}}" width="100%"></div>
            </div>
          </a>
        </div>
		</section>
		
        @endforeach
        @endforeach
		<br>
         @else
      
        
        <section class="jumbotron text-center">
            <h1 class="jumbotron-heading">No Plan . Please Contact Your School .</h1>
        </section>
        @endif


      </div>
    </div>
  </div>

</div>
 


<br><br><br>


@endsection

