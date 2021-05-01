@extends(Auth::user()->role==2? 'layouts.coadmin':'layouts.admin')
@extends(Auth::user()->role==5? 'layouts.studentarticlelayout':'layouts.withoutlogin')
 @section('content')
 <?php header('X-Frame-Options: *'); ?>
            <div class="content-heading">
               <div>Edit Course
                  <small data-localize="dashboard.WELCOME"></small>
               </div>
               <!-- START Language list-->
               <!-- <div class="ml-auto">
                  <div class="btn-group">
                     <a href="{{url('agentreg')}}" class="btn btn-warning">Create Agent</a>
                     <button class="btn btn-secondary dropdown-toggle dropdown-toggle-nocaret" type="button" data-toggle="dropdown">English</button>
                     <div class="dropdown-menu dropdown-menu-right-forced animated fadeInUpShort" role="menu"><a class="dropdown-item" href="#" data-set-lang="en">English</a><a class="dropdown-item" href="#" data-set-lang="es">Spanish</a>
                     </div>
                  </div>
               </div> -->
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
   <div class="col-md-12">
         <form method="post" action="{{url('courseed')}}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
               <label>Course Name</label>
           
               <select name="course_masters_id" class="form-control" >

                   <option value="{{$k->csm->id}}" selected="">{{$k->csm->course_name}}</option>
                  @foreach($csm as $dk)
                    
                     @if(($dk->id==old('course_masters_id'))||($dk->id==$k->course_master_id))
                     }
                  <option value="{{$dk->id}}" selected="">{{$dk->course_name}}</option>
                  @else
                  <option value="{{$dk->id}}">{{$dk->course_name}}</option>
                  @endif
                  @endforeach 
            
                  
                  
               </select>
            </div>

            <div class="form-group">
               <label>Title</label>
               <input type="text" name="title" class="form-control" value="{{old('title')?old('title'):$k->title}}">
               <input type="hidden" name="cid" value="{{old('cid')?old('cid'):$k->id}}">
            </div>
       <div class="form-group">
               <label>Email Content</label>
               <input type="text" name="mailcontent" class="form-control" value="{{$k->mailcontent}}" placeholder="Email Content">
            </div>

            <div class="form-group">
               <label>Type</label>
               <select name="doc_types_id" class="form-control" id='doctypeid'>
                  @foreach($dtype as $dk)
                     @if(($dk->id==old('doc_types_id'))||($dk->id==$k->doc_types_id))
                  <option value="{{$dk->id}}" selected="">{{$dk->type}}</option>
                  @else
                  <option value="{{$dk->id}}">{{$dk->type}}</option>
                  @endif
                  @endforeach
                  
               </select>
            </div>
             <div class="form-group">
               <label>Description</label>
               <textarea name="description" class="form-control" >{{old('description')?old('description'):$k->description}}</textarea>
               
            </div>
             <div class="form-group">
               <label>Duration</label>
               <input type="time" name="duration" class="form-control" value="{{old('duration')?old('duration'):$k->duration}}">
            </div>
            <div class="form-group" id="videopathid" style="display: none;">
               <label>Video Path</label>
               <input type="text" name="video_path" class="form-control" id="videopathid2" value="{{old('video_path')?old('video_path'):$k->video_path}}">
                @if(($k->doc_types_id)==2||($k->doc_types_id)==3)
                 <!--  <div>

                   <iframe width="320" height="240" src="https://www.youtube.com/watch?v=nsNioLhsW_I&feature=youtu.be" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" ng-show="showvideo" allowfullscreen></iframe>

                  </div> -->
                 @endif
            </div>
            <div class="form-group" id="docpathid">
               <label>Document</label>
               <input type="file" name="doc_path" class="form-control" id="docpathid2" value="{{old('doc_path')?old('doc_path'):$k->doc_path}}">
               <div>
                     
                 @if(($k->doc_types_id)==1||($k->doc_types_id)==3)
                <!--   <div><img src="{{ URL::to('/') }}/docs/{{$k->doc_path }}" class="img-thumbnail" width="75" alt="No thumbnail for doc" /></div> -->
                  <div><a target="_blank" href="{{ URL::to('/') }}/docs/{{$k->doc_path}}">
                     
                     <img src="{{ URL::to('/') }}/docs/placeholderpdf.png" alt="placeholderpdf" width="50" height="50">
                  </a></div>
                 @endif
                
               </div>
            </div>
             <div class="form-group" id="thumbail">
               <label>Thumbnail</label>
               <input type="file" name="thumbnail" class="form-control" id="thumbnail2" value="{{old('thumbnail')}}">
               @if(($k->thumbnail)!='')
               <div><img src="{{ URL::to('/') }}/docs/{{$k->thumbnail }}" class="img-thumbnail" width="75" alt="No thumbnail" /></div>
               @endif
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
            else if($('#doctypeid').val()==3){
               $('#docpathid').show();
               $('#videopathid').show();
            }
            else
            {
               $('#docpathid').hide();
               $('#videopathid').hide();
            }

      });
   </script>


@endsection