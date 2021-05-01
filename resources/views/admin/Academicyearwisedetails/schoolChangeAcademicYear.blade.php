  @extends('layouts.admin')
 @section('content')
            <div class="content-heading">
               <div>{{$schoolname}} 
                  <small data-localize="dashboard.WELCOME"></small>
               </div>
            </div>

            @if($errors->any())
               @foreach($errors->all() as $err)
                  <div class="alert alert-danger">{{$err}}</div>
               @endforeach
            @endif
            @if(session()->has('success'))
               <div class="alert alert-info">{{session()->get('success')}}</div>
            @endif
   <div class="col-md-12">
         <form method="post" action="{{url('Academic-year-submit')}}">
            @csrf

<div hidden="" class="col-md-12">
  <input class="form-group" type="text" name="schoolid" value="{{$id}}">
</div>

        <div class="col-md-12">
       <label>Academic Year</label>
            <div class="form-group">
           <select required=""  class="form-control"  name="academicyear">

    <option value="">Academic year</option>
    {{ $year1 = date('Y')+1 }}
    @for ($year = 2015; $year <= $year1; $year++)
   <option value="<?=($year-1)."-".($year);?>"><?=($year-1)."-".$year;?></option>
    @endfor
</select>
           </div>
       </div>

            
           
            <br>
            <div class="text-center"> <button type="submit" class="btn btn-success">change Academic Year</button> </div>
         </form>
      
   </div>

   @endsection