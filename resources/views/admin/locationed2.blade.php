 @extends('layouts.admin')
 @section('content')
            <div class="content-heading">
               <div>Location Entry 
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
         <form method="post" action="{{url('locationed')}} ">
            @csrf
            <div class="form-group">
               <label>Zone</label>
               <input type="text" name="zone" class="form-control" value="{{old('zone')?old('zone'):$lp[0]->zone}}">
               <input type="hidden" name="lid" value="{{old('lid')?old('lid'):$lp[0]->id}}">
            </div>
            <div class="form-group">
               <label>State</label>
                 <select name="state[]"   id='udpcityid' multiple="multiple">
                  <option value="" >Select Any</option>
                  @if(count($loc)>0)
                     @foreach($loc as $lc) 
                        @if(($lc->id==old('state'))||(in_array($lc->id,$state)))
                           <option value="{{$lc->id}}" selected="">{{$lc->name}}</option>
                        @else
                           <option value="{{$lc->id}}">{{$lc->name}}  </option>
                        @endif
                     @endforeach


                  @endif
               </select>
            </div>
            <div class="form-group">
               <label>City</label>
                 <select name="city[]" class="form-control" id='udpcitylist'  multiple>
                  <option value="" >Select Any1</option>
          @foreach($citites as $city)
                  @if(!old('city'))
                     <option value="{{$city->id}}" @if(in_array($city->id,$citys))selected @endif>{{$city->name}} ({{$city->names}}) </option>
                  @endif
          @endforeach
               </select>
            </div>
            <div hidden="" class="form-group">
               <label>Status</label>
               <select name="status" class="form-control">
                  

                  <option value="0" {{old('status')?'':'selected'}}>Inactive</option>
                  <option value="1" {{old('status')?'selected':''}} >Active</option>
                  @if(($lp[0]->status))
                     <option value="{{$lp[0]->status}}" selected="">{{$lp[0]->status?'Active':'Inactive'}}</option>

                  @endif
               </select>
            </div>
            <div class="text-center"> <button type="submit" class="btn btn-success">Submit</button> </div>
         </form>
      
   </div>
@endsection


@section('footer')
 <link rel="stylesheet" href="{{asset('js/jquery.multiselect.css')}}">

<script src="{{asset('js/jquery.multiselect.js')}}"></script>
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
       $("#udpcityid").multiselect('reload');
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
     
         if(v=="")
         {
           v=0;
         }
     
         var nurl="{{url('getcitylists')}}/"+btoa(v)+'/'+"{{$lp[0]->Zone_id}}";
         // alert('ok'+v + " amb " + nurl);
          $.get(nurl,function(data,status){
            // alert("res= "+data);
            $('#udpcitylist').html(data);
          })
      });

     // $('#udpcitylist').html("");

       $('#udpcityid').change(function(){
         var v=$('#udpcityid').val();
           if(v=="")
           {
             v=0;
           }
     
         var nurl="{{url('getcitylists')}}/"+btoa(v)+'/'+"{{$lp[0]->Zone_id}}";
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