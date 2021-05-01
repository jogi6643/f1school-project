@extends((Auth::user()->role==2)? 'layouts.coadmin':((Auth::user()->role==3)?'layouts.trainer':'layouts.admin'))
 @section('content')

            <div class="content-heading">
               <div>Location Entry
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
         <form method="post" action="">
            @csrf

             <div class="form-group">
               <label>Zone</label>
               <input type="text" list="zone" name="zone" class="form-control"  />
               <datalist id="zone">
               <option value="" selected="">Select Zone</option>
                  @if(count($zone)>0)
                     @foreach($zone as $zn) 
                           
                           <option>{{$zn->zone}}</option>
                           @endforeach
                  @endif
               </datalist>

            </div>
            <div class="form-group">
               <label>State</label>
               <select name="state[]" class="form-control" id='udpcityid' multiple="multiple">
                 
                  @if(count($loc)>0)
                     @foreach($loc as $lc) 
                        @if($lc->id==old('state'))
                           <option value="{{$lc->id}}" selected="">{{$lc->name}}</option>
                        @else
                           <option value="{{$lc->id}}">{{$lc->name}}</option>
                        @endif
                     @endforeach


                  @endif
               </select>
            </div>
            <div class="form-group">
               <label>City</label>
               <select name="city[]" class="form-control xyz" id='udpcitylist' multiple="multiple">
                 
                  
               </select>
            </div>
            <div hidden="" class="form-group">
               <label>Status</label>
               <select name="status" class="form-control">
                  
                  <option value="0" {{old('status')?'':'selected'}}>Inactive</option>
                  <option value="1" {{old('status')?'selected':''}} >Active</option>
               </select>
            </div>
            <div class="text-center"> <button type="submit" class="btn btn-success">Submit</button> </div>
         </form>
      
   </div>
@endsection

@section('footer')
  <link rel="stylesheet" href="{{asset('js/jquery.multiselect.css')}}">

<script src="{{asset('js/jquery.multiselect.js')}}"></script>
 <!-- <script type="text/javascript" src="js/bootstrap-multiselect/bootstrap-multiselect.js"></script> -->
<script type="text/javascript">
   $(document).ready(function() {
      $('#udpcityid').multiselect({

           columns  : 3,
          search   : true,
          selectAll: true,
          texts    : {
              placeholder: 'Select States',
              search     : 'Search States'
          }
       });
     $('#udpcitylist').multiselect({

           columns  : 3,
          search   : true,
          selectAll: true,
          texts    : {
              placeholder: 'Select cities',
              search     : 'Search cities'
          }
       });


      $('#udpcityid').change(function(){
         var v=$('#udpcityid').val();

         var nurl="{{url('getcitylist')}}/"+btoa(v);
          $.get(nurl,function(data,status){
            $('#udpcitylist').html(data);


            $('#udpcitylist').multiselect({
            columns  : 3,
            search   : true,
            selectAll: true,
            texts    : {
                placeholder: 'Select cities',
                search     : 'Search cities'
              }
           });

        $("#udpcitylist").multiselect('reload');
       
          })

      });

   });

</script>

@endsection