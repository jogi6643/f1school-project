@extends(Auth::user()->role==2? 'layouts.coadmin':'layouts.admin')
@section('content')
 
             <div class="content-heading">
               <div>Course 
                  <small data-localize="dashboard.WELCOME"></small>
               </div>
               <!-- START Language list-->
               
               <!-- END Language list-->
            </div>

            @if($errors->any())
               @foreach($errors->all() as $err)
                  <div class="alert alert-danger">{{$err}}</div>
               @endforeach
            @endif
            @if(session()->has('success'))
               <div class="alert alert-info">{{session()->get('success')}}</div>
            @endif
            <div class="row">
            	<div class="col-md-4 offset-md-4">
            		<form method="post" action="{{url('coursenameed')}} ">
            			@csrf
            			<div class="form-group">
            				<label>Course Name</label>	
            				<input type="text" name="course_name" value="{{old('course_name')?old('course_name'):$k->course_name}}">
            				<input type="hidden" name="cid" value="{{old('cid')?old('cid'):$k->id}}">
            			</div>
            			<div class="text-center">
            				<button type="submit" class="btn btn-success">Save</button>
            			</div>
            		</form>
            	</div>
            </div>


@endsection            