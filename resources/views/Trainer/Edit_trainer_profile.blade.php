@extends('layouts.trainer')
 @section('content')
            <div class="content-heading">
               <div>Edit-profile
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
         <form method="post" action="{{url('update-trainer-profile')}}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">

             @if($k->pimage==null)
             <img style="border-radius: 50%" src="{{ URL::to('/') }}/trainerprofile/trainer.png" alt="trainer" width="100" height="100">
             @else
              <img style="border-radius: 50%" src="{{ URL::to('/') }}/trainerprofile/{{$k->pimage}}" alt="trainer" width="100" height="100">
             @endif
              </div>
               <div class="form-group">
             <input type="file" name="pimage" class="form-control" value="{{old('pimage')?old('pimage'):$k->pimage}}">
             </div>
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
               <input  hidden required type="email"  required value="{{$k->email}}"  name="email" class="form-control">
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