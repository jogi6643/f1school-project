@extends('layouts.'.$vw)


@section('content')
<style>
.stylebox{
 background-color: #d70a01; 
 height: 100px; 
 color:#fff;
 font-size: 30px;   
}


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


<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
{{-- ********** --}}
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
{{-- ************ --}}
 
<?php  $undefineddata=0; ?>
<section>
<div class="container">
          <!-- START cards box-->
            <div class="row">
             @if(Auth::user()->role==1)
               <div class="col-xl-3 col-md-6">
                  <!-- START card-->
                  <div class="card flex-row align-items-center align-items-stretch border-0">
                     <div class="col-4 d-flex align-items-center bg-primary-dark justify-content-center rounded-left">
                        <em class="icon-graduation fa-3x"></em>
                     </div>
                     <div class="col-8 py-3 bg-primary rounded-right">
                        <div class="h2 mt-0">Schools</div>
                        <div class="text-uppercase text-center" style="font-size: 18px;"><strong>{{$totalschools or $undefineddata }}</strong></div>
                     </div>
                  </div>
               </div>
              @endif
               <div class="col-xl-3 col-md-6">
                  <!-- START card-->
                  <div class="card flex-row align-items-center align-items-stretch border-0">
                     <div class="col-4 d-flex align-items-center bg-purple-dark justify-content-center rounded-left">
                        <em class="icon-people fa-3x"></em>
                     </div>
                     <div class="col-8 py-3 bg-purple rounded-right">
                        <div class="h2 mt-0">Students</div>
                        <div class="text-uppercase text-center" style="font-size: 18px;"><strong>{{$totalstudents or $undefineddata}}</strong></div>
                     </div>
                  </div>
               </div>
               <div class="col-xl-3 col-lg-6 col-md-12">
                  <!-- START card-->
                   
                       @if(Auth::user()->role==3)
                     
                    <div class="card flex-row align-items-center align-items-stretch border-0">
                     <div class="col-4 d-flex align-items-center bg-green-dark justify-content-center rounded-left">
                        <em class="icon-badge fa-3x"></em>
                     </div>
                        <div class="col-8 py-3 bg-green rounded-right">
                        <div class="h2 mt-0">School</div>
                        <div class="text-uppercase text-center" style="font-size: 18px;"><strong>{{$totaltrainers or $undefineddata }}</strong>
                        </div>
                     </div>
                     </div>
                     @else
                     <div class="card flex-row align-items-center align-items-stretch border-0">
                     <div class="col-4 d-flex align-items-center bg-green-dark justify-content-center rounded-left">
                        <em class="icon-badge fa-3x"></em>
                     </div>
                        <div class="col-8 py-3 bg-green rounded-right">
                        <div class="h2 mt-0">Trainers</div>
                        <div class="text-uppercase text-center" style="font-size: 18px;"><strong>{{$totaltrainers or $undefineddata }}</strong>
                        </div>
                     </div>
                     </div>
                     @endif

                  
               </div>
              
              @if(Auth::user()->role==1)
               <div class="col-xl-3 col-lg-6 col-md-12">
                  <!-- START date widget-->
                  <div class="card flex-row align-items-center align-items-stretch border-0">
                     <div class="col-4 d-flex align-items-center bg-green-dark justify-content-center rounded-left">
                        <em class="icon-anchor fa-3x"></em>
                     </div>
                     <div class="col-8 py-3 rounded-right">
                        <div class="h2 mt-0">Co-admins</div>
                        <div class="text-uppercase text-center" style="font-size: 18px;"><strong>{{$totalcoadmins or $undefineddata }}</strong></div>
                     </div>
                  </div>
                  <!-- END date widget-->
               </div>
              @else
                   <div class="col-xl-3 col-lg-6 col-md-12">
                  <!-- START date widget-->
                  <div class="card flex-row align-items-center align-items-stretch border-0">
                     <div class="col-4 d-flex align-items-center bg-green-dark justify-content-center rounded-left">
                        <em class="icon-anchor fa-3x"></em>
                     </div>
                     <div class="col-8 py-3 rounded-right">
                        <div class="h2 mt-0">Competition</div>
                        <div class="text-uppercase text-center" style="font-size: 18px;"><strong>@if(isset($comp)){{$comp }}@endif</strong></div>
                     </div>
                  </div>
                  <!-- END date widget-->
               </div>
                <div class="col-xl-3 col-lg-6 col-md-12">
                  <!-- START date widget-->
                  <div class="card flex-row align-items-center align-items-stretch border-0">
                     <div class="col-4 d-flex align-items-center bg-green-dark justify-content-center rounded-left">
                        <em class="icon-anchor fa-3x"></em>
                     </div>
                     <div class="col-8 py-3 rounded-right">
                        <div class="h2 mt-0">Plan</div>
                        <div class="text-uppercase text-center" style="font-size: 18px;"><strong>@if(isset($schoolplan)){{$schoolplan }}@endif</strong></div>
                     </div>
                  </div>
                  <!-- END date widget-->
               </div>
              @endif
            </div>
            <!-- END cards box-->
<!-- School Competition Show -->
  <?php //print_r($data); ?>  
            @if(isset($SchoolCompTeam))
            <div class="container">
         @foreach( $SchoolCompTeam as $k )

<div class="card">
  <div class="row" style="background-color: white;">

    <div class="col-md-6">
        <img class="img-fluid rounded thumb64" src="{{asset('admin/img/dummyCompetition.png')}}" alt="image">
        <h4 class="mb-2">{{$k->competitionName}}</h4>
    </div>
    <div class="col-md-3">
       <h4 class="mb-2" style="margin-top: 20px;">Start Date</h4>
        <span>{{date('d-m-Y',strtotime($k->openDate))}}</span>
    </div>
    <div class="col-md-3" style="margin-top: 20px;">
     <h4 class="mb-2">No of  Teams</h4>
     <?php $ids = base64_encode($k->school_id."_".$k->cmpid)?>
     <a href="{{url('team-show-by-school-competition')}}/{{$ids}}"><span class="badge badge-primary badge-pill">{{$k->TotalTeam}}</span></a>
    </div>
  </div>
</div>
                    @endforeach
            </div>
            @endif
<!-- End School Competition -->




            <!-- START Multiple List group-->
         <?php //print_r($data); ?>  
            @if(isset($data))
         @foreach( $data as $k )
            <div class="list-group mb-3">
               <a class="list-group-item" href="{{url('nominate').'/'.base64_encode($k["id"])}}">
                  <table class="wd-wide">
                     <tbody>
                        <tr>
                           <td class="wd-xs">
                              <div class="px-2">
                                 <img class="img-fluid rounded thumb64" src="{{asset('admin/img/dummyCompetition.png')}}" alt="image">
                              </div>
                           </td>
                           <td>
                              <div class="px-2">
                                 <h4 class="mb-2">{{$k['Competition_name']}}</h4>
                                 <small class="text-muted">{{$k['Sdescription']}}</small>
                              </div>
                           </td>
                           <td class="wd-sm d-none d-lg-table-cell">
                              <div class="px-2">
                                 <p class="m-0">Registration Date</p>
                                 <small class="text-muted"><strong>{{date('d-m-Y',strtotime($k['Ragistration_Date']))}}</strong></small>
                              </div>
                           </td>
                           <td class="wd-sm d-none d-lg-table-cell">
                              <div class="px-2">
                                 <p class="m-0">Start Date</p>
                                 <small class="text-muted"><strong>{{date('d-m-Y',strtotime($k['Start_Date']))}}</strong></small>
                              </div>
                           </td>
                           <td class="wd-xs d-none d-lg-table-cell">
                              <div class="px-2">
                                 <p class="m-0 text-muted">
                                    <em class="icon-people mr-2 fa-lg"></em>{{$k['totalteam']}}</p>
                              </div>
                           </td>

                        </tr>
                     </tbody>
                  </table>
               </a>
            </div>
            @endforeach
            @endif
          
            @if(session()->has('status'))
             <div class="alert alert-danger">
             
                    {{session('status')}}
            
             </div>
            @endif

 
<div class="row">
@if(Auth::user()->role==1)
<!-- school vs zone -->
<div class="col-md-6">
<figure class="highcharts-figure">
    <div id="container"></div>
    <p class="highcharts-description">
       ZONE
    </p>
</figure>
</div>
<!-- student vs zone -->
<div class="col-md-6">
<figure class="highcharts-figure">
    <div id="containerstudent"></div>
    <p class="highcharts-description">
       ZONE
    </p>
</figure>
</div>

@endif
@if(Auth::user()->role==1)
<div class="col-md-12">
@else
    <div class="col-md-12">
 @endif
@if(Auth::user()->role!=4)
 <div class="row">
 <div class="col-md-12">
  <center><h4><a href="{{url('manufacturingapplication_ad')}}">Pending For Manufacturing</a> @if(isset($schoolpartcount))(Total Count:- {{$schoolpartcount}})@endif</h4></center>

  </div>
 </div>   
    

<div class="row">
  @if(isset($schoolpart))
<table class="table">
  <thead class="thead-light">
    <tr>
      <th scope="col">#</th>
      <th scope="col">Application Id</th>
      <th scope="col">Student Name</th>
       <th scope="col">Student Email</th>
      <th scope="col">Team Name</th>
      <th scope="col">Applied On</th>
    </tr>
  </thead>
  <tbody>
@if(1)
  @foreach($schoolpart as $key=>$schoolparts)
    <tr>
      <th scope="row"><?= $key+1;?></th>
      <td>{{$schoolparts->applicationid}}</td>
      <td>{{$schoolparts->names}}</td>
      <td>{{$schoolparts->email}}</td>
      <td>{{$schoolparts->team}}</td>
      <td>{{date('d-m-Y H:i:s',strtotime($schoolparts->created_at))}}</td>
    </tr>
   @endforeach
@endif
  </tbody>
</table>
@endif
</div>
@endif
<!-- <figure class="highcharts-figure">
    <div id="container"></div>
    <p class="highcharts-description">
        Pie charts are very popular for showing a compact overview of a
        composition or comparison. While they can be harder to read than
        column charts, they remain a popular choice for small datasets.
    </p>
</figure> -->
</div>
</div>
<div class="row">
    <div class="col-md-12">
    <figure class="highcharts-figure">
    <div id="container1"></div>
    <p class="highcharts-description">
        
    </p>
    </figure>
    </div>
</div>
@if(Auth::user()->role==4)
<div class="row"> 
  <div class="col-md-12">
    <div class="text-center" >
      <h3 style="display: inline-block;">School Vs Plan</h3>
     <!--  @if(isset($schoolvsplan[0]->id)) -->
      <a href="{{ url('downloadschoolvsplan'.'/'.base64_encode($schoolvsplan[0]->id)) }}" class="btn btn-primary float-right" >Download</a>


    </div>
    <table class="table">
      <thead class="thead-light">
        <tr>
          <th scope="col">#</th>
          <th scope="col">School Name</th>
          <th scope="col">Plan Name</th>
          <th scope="col">Total Session</th>
          <th scope="col">Total Delivered</th>
          <th scope="col">Not Assigned</th>
          <th scope="col">Upcoming Activites</th>
          <th scope="col">Total Student</th>
        </tr>
      </thead>
      <tbody>
        <?php $i=1; ?>
       @foreach($schoolvsplan as $k)
        @foreach($k->planassignedtoschool as $p)
        <tr>
        <th scope="row">{{$i}}.</th>
        <td>{{$k->schoolname}}</td>
        <td>  
               {{$p->planname}}<br>
             
        </td>  
        <td>
              
               {{$p->countactivities}}<br>
             
        </td>
        <td>{{$p->countdelivered}}</td>
        <td>
             
               {{$p->unassignedactivies}}<br>
           
        </td>
        <td>{{$p->upcomingactivities}}</td>
        <td>
          {{$p->tstudents}}
        </td> 
        </tr>
    <?php $i++; ?>
         @endforeach

       @endforeach

      </tbody>
</table>
<!-- @endif -->
  </div>
</div>
@endif

@if(isset($schoolid))
<div class="row"> 
  <div class="col-md-12">
    <div class="text-center" >
      <h3 style="display: inline-block;">School Vs Plan</h3>
     @if(isset($trainerid))
      <a href="{{ url('downloadtrainervsplan').'/'.base64_encode($trainerid) }}" class="btn btn-primary float-right" >Download</a>
@endif

    </div>
    <table class="table">
      <thead class="thead-light">
        <tr>
          <th scope="col">#</th>
          <th scope="col">School Name</th>
          <th scope="col">Plan Name</th>
          <th scope="col">Total Session</th>
          <th scope="col">Total Delivered</th>
          <th scope="col">Not Assigned</th>
          <th scope="col">Upcoming Activites</th>
          <th scope="col">Total Student</th>
        </tr>
      </thead>
      <tbody>
        <?php $i=1; ?>
       @foreach($schoolid as $k)
        @foreach($k->planassignedtoschool as $p)
        <tr>
        <th scope="row">{{$i}}.</th>
        <td>{{$k->schoolname}}</td>
        <td>  
               {{$p->planname}}<br>
             
        </td>  
        <td>
              
               {{$p->countactivities}}<br>
             
        </td>
        <td>{{$p->countdelivered}}</td>
        <td>
             
               {{$p->unassignedactivies}}<br>
           
        </td>
        <td>{{$p->upcomingactivities}}</td>
        <td>
          {{$p->tstudents}}
        </td> 
        </tr>
    <?php $i++; ?>
         @endforeach

       @endforeach

      </tbody>
</table>
  </div>
</div>
@endif

          <!-- END Multiple List group-->


  </div>


</section>
<!-- school vs zone script -->
<script type="text/javascript">
   
   Highcharts.chart('container', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
    title: {
        text: 'Schools According to Zone'
    },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.y}</b>'
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
                format: '<b>{point.name}</b>: {point.y}'
            }
        }
    },
    series: [{
        name: 'School',
        colorByPoint: true,
        data: [
        <?php if(isset($school)): ?>
        
   <?php foreach ($school as $key => $value): ?>
          {
            name:  '{{$value->zone}}',
            y: {{$value->schoolcount}}
          } 
    <?php if (count($school)!=$key-1): ?>
          ,
    <?php endif ?>
    <?php endforeach ?>
  
    <?php endif ?>
         ]
    }]
});
</script>
<!-- student vs zone script -->
<script type="text/javascript">
   
   Highcharts.chart('containerstudent', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
    title: {
        text: 'Students According to Zone'
    },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.y}</b>'
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
                format: '<b>{point.name}</b>: {point.y}'
            }
        }
    },
    series: [{
        name: 'Student',
        colorByPoint: true,
        data: [
   @foreach($zonelocation as $k)
          {
            name:  '{{$k['zone']}}',
            y: {{$k['count']}}
          } ,
    @endforeach
         ]
    }]
});
</script>
<script>
// Create the chart

// Create the chart
Highcharts.chart('container1', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Total Team Per Competition '
    },
  
    xAxis: {
        categories: [
  @if(isset($school))
        @foreach($arr as $arrs)
            "{{$arrs['comp']}}",
           @endforeach
@endif
        ],
        crosshair: true
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Number Of Team'
        }
    },
    tooltip: {
        headerFormat: '<span style=“font-size:10px”>{point.key}</span><table>',
        pointFormat: '<tr><td style=“color:{series.color};padding:0">{series.name}: </td>' +
            '<td style=“padding:0”><b>{point.y} </b></td></tr>',
        footerFormat: '</table>',
        shared: true,
        useHTML: true
    },
    plotOptions: {
        column: {
            pointPadding: 0.2,
            borderWidth: 0
        }
    },
    series: [{
        name: 'Number of Teams',
        data: [
@if(isset($arr))
        @foreach($arr as $arrs)
            {{$arrs['count']}},
           @endforeach

@endif
           ]
    }]
});
</script>

@endsection