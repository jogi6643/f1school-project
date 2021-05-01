 @extends('layouts.admin')
 @section('content')
            <div class="content-heading">
               <div>Co-admin Edit
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
         <form method="post" action="{{url('updatecoadmin')}}/{{Route::Input('coadmin')}}" enctype="multipart/form-data">
            @csrf
           

            <div class="form-group">
               <label>Trainer Name</label>
               <input type="text" name="name" value="{{$k->name}}" required class="form-control">
           </div>
           <div class="form-group">
               <label>Phone No</label>
               <input  required type="text" value="{{$k->phone}}"  name="phone" class="form-control">
           </div>
            <div class="form-group">
               <label>Email</label>
               <input disabled=""  required type="email"  required value="{{$k->email}}"  name="email" class="form-control">
               <input hidden=""  required type="email"  required value="{{$k->email}}"  name="email" class="form-control">
           </div>
           <div class="form-group">
               <label>Assigned Role</label>
               <select name="role" class="form-control">
                   <option value="">-- Select Role ---</option>
                   @foreach($label as $roles)
                    <option @if($k->role==$roles->id)) selected  @endif value="{{$roles->id}}">{{$roles->name}}</option>
                   @endforeach
                   
               </select>
           </div>
              <div class="form-group">
               <label>Status</label>
               @if($k->status==0)
               <select name="status" class="form-control">
                   <option value="0" @if($k->status==0) selected @endif>Inactive</option>
                     <option value="1" @if($k->status==1) selected @endif>Active</option>
               </select>
               @endif
                 @if($k->status==1)
               <select name="status" class="form-control">
                   <option value="0" @if($k->status==0) selected @endif>Inactive</option>
                     <option value="1" @if($k->status==1) selected @endif>Active</option>
               </select>
               @endif
                 @if($k->status==2)
               <select name="status" class="form-control">
                   <option value="0" @if($k->status==0) selected @endif>Inactive</option>
                     <option value="2" @if($k->status==2) selected @endif>Active</option>
               </select>
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