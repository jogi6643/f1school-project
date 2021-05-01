@extends(Auth::user()->role==2? 'layouts.coadmin':'layouts.admin')
 @section('content')
            <div class="content-heading">
               <div>Activity Entry
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
         <form method="post" action="" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
               <label>Course Name</label>
               <select name="course_masters_id" class="form-control" >
                  <option value="" selected="">Select any</option>
                  @foreach($csm as $dk)
                     @if($dk->id==old('course_masters_id'))
                  <option value="{{$dk->id}}" selected="">{{$dk->course_name}}</option>
                  @else
                  <option value="{{$dk->id}}">{{$dk->course_name}}</option>
                  @endif
                  @endforeach
                  
               </select>
            </div>
            <div class="form-group">
               <label>Title</label>
               <input type="text" name="title" class="form-control" value="{{old('title')}}">
            </div>

             <div class="form-group">
               <label>Email Content</label>
               <input type="text" name="mailcontent" class="form-control" value="{{old('mailcontent')}}" placeholder="Email Content">
            </div>

            <div class="form-group">
               <label>Type</label>
               <select name="doc_types_id" class="form-control" id='doctypeid'>
                  <option value="" selected="">Select any</option>
                  @foreach($dtype as $dk)
                   @if($dk->id==old('doc_types_id'))
                  <option value="{{$dk->id}}" selected="">{{$dk->type}}</option>
                  @else
                  <option value="{{$dk->id}}">{{$dk->type}}</option>
                  @endif
                  @endforeach
                  
               </select>
            </div>
             <div class="form-group">
               <label>Description</label>
               <textarea name="description" class="form-control" >{{old('description')}}</textarea>
               
            </div>
             <div class="form-group">
               <label>Duration</label>
               <input type="time" name="duration" class="form-control" value="{{old('duration')}}">
            </div>
            <div class="form-group" id="videopathid" style="display: none;">
               <label>Video Path</label>
               <input type="text" name="video_path" class="form-control" id="videopathid2" value="{{old('video_path')}}">
            </div>
            <div class="form-group" id="docpathid">
               <label>Document</label>
               <input type="file" name="doc_path" class="form-control" id="docpathid2" value="{{old('doc_path')}}">
            </div>
              <div class="form-group" id="thumbail">
               <label>thumbnail</label>
               <input type="file" name="thumbnail" class="form-control" id="thumbnail2" value="{{old('thumbnail')}}">
            </div>
            <div class="text-center"> <button type="submit" class="btn btn-success">Submit</button> </div>
         </form>
      
   </div>
@endsection

@section('footer')
   <script type="text/javascript">
      $(document).ready(function(){
         $('#doctypeid').change(function(){
            if($('#doctypeid').val()==1){
               $('#videopathid2').val('');
               $('#videopathid').hide();

               $('#docpathid').show();
            }
            else if($('#doctypeid').val()==2){
               $('#docpathid').hide();
               $('#videopathid').show();
               $('#docpathid2').val('');
            }
           else if($('#doctypeid').val()==3){
                $('#docpathid2').val('');
               $('#videopathid2').val('');
               $('#docpathid').show();
               $('#videopathid').show();
              
            }
            else
            {
               $('#docpathid').hide();
               $('#videopathid').hide();
            }
         });

         if($('#doctypeid').val()==1){
               $('#videopathid2').val('');
               $('#videopathid').hide();
               $('#docpathid').show();
            }
            else if($('#doctypeid').val()==2){
               $('#docpathid').hide();
               $('#videopathid').show();
               $('#docpathid2').val('');
            }
            else
            {
               $('#docpathid').hide();
               $('#videopathid').hide();
            }

      });
   </script>


@endsection