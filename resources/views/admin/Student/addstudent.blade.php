 @extends('layouts.admin')
 @section('content')
            <div class="content-heading">
               <div>Course Entry
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
         <form method="post" action="{{url('trainercreate')}}" enctype="multipart/form-data">
            @csrf
           

            <div class="form-group">
               <label>Trainer Name</label>
               <input type="text" name="name" required class="form-control">
           </div>
           <div class="form-group">
               <label>Phone No</label>
               <input  required type="text" name="phone" class="form-control">
           </div>
            <div class="form-group">
               <label>Email</label>
               <input  required type="email"  required name="email" class="form-control">
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