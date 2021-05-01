@extends(Auth::user()->role==2? 'layouts.coadmin':'layouts.admin')
 @section('content')
            <div class="content-heading">
               <div>Create Plan
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
   <div class="col-md-12">
         <form method="post" action="" id="form" onsubmit ="return myfunc()">
            @csrf
               <div cass="col-md-12">
       <label>Academic Year</label>
            <div class="form-group">
           <select required=""  class="form-control"  name="academicyear">
    <option value="">Academic year</option>
    {{ $year1 = date('Y')+1 }}
    @for ($year = 2015; $year <= $year1; $year++)
   <option value="<?=($year-1)."-".($year);?>"><?=($year-1)."-".($year);?></option>
    @endfor
</select>
           </div>
       </div>

            <div class="form-group">
               <label>Plan Name</label>
               <input required="" type="text" name="name" class="form-control" value="{{old('name')}}">
            </div>
            <div class="form-group">
               <label>Fee per Student</label>
               <input  required="" type="text" name="fee_per_student" class="form-control" value="{{old('fee_per_student')}}">
            </div>


 
            <div class="form-group">
               <label>Activity List </label>

               
            </div>
            <div class="row">
             <!-- style="max-height: 300px; overflow-y: auto;" -->
               <div class="col-md-12">
                  
                  @foreach($cs as $k=> $c)
                  <div class="card">
                     <div class="row">
                         <div class="col-md-6">
                            <input style="margin-top: 20px;" type="checkbox" id="course_{{$c->id}}" onclick="course('{{$c->id}}')" class="form-control Activity" name="courselist[]" value="{{$c->id}}"> {{$k+1}}. {{$c->title}} ({{isset($c->type->type)?$c->type->type:''}}) 
                         </div>
                         <div class="col-md-6">
                          <select style="display: none;" onchange="getPriortity('{{$c->id}}');" name="Priortity[]" class="form-control Priortity" id="Priortity_{{$c->id}}">
                            <option value="">Select Priortity</option>
                              @foreach($cs as $k1=> $c)
                              <option value="{{$k1+1}}">{{$k1+1}}</option>
                              @endforeach
                          </select>

                         </div>
                    </div>
                  </div>
                  @endforeach
               </div>
            </div>
            <br>
            <div class="text-center"> <button type="submit"  class="btn btn-success">Submit</button> </div>
         </form>
      
   </div>
   <script type="text/javascript">
    /*Start hide and unhide select box */




     function course(course_id)
     {
      $('#'+'Priortity_'+course_id).val("");
       
       if($('#'+'course_'+course_id).prop("checked") == true){
                alert("Please Set Priortity.");
                $('#'+'Priortity_'+course_id).show();

               // course_count = course_count+1;
            }
            else if($('#'+'course_'+course_id).prop("checked") == false){
                // alert("Checkbox is unchecked.");
                $('#'+'Priortity_'+course_id).hide();
                // course_count = course_count-1;

            }
     }
     /*End  hide and unhide select box */

     /*Start get value priority */ 
   var Priortity_count;
     function getPriortity(course_id)
     {
        Priortity_count = $('.Priortity').filter((i,s) => $(s)[0].selectedIndex > 0).length;
     
   var priority_value = $('#'+'Priortity_'+course_id).val();
  var selects = document.getElementsByTagName("select"),
      i,
      current,
      selected = {};
  for(i = 0; i < selects.length; i++){

    if(selects[i].value!=""){
    current = selects[i].selectedIndex;
    if (selected[current]) {
      $('#'+'Priortity_'+course_id).prop('selectedIndex', 0);
      alert("Priortity may not be selected more than once.");
      return false;
    } else
      selected[current] = true;
    }
    
  }
  return true;
     
     }
/*End get value Priority*/



function myfunc()
{
  var  Priortity_count = $('.Priortity').filter((i,s) => $(s)[0].selectedIndex > 0).length;
  var activityOfChecked = $('.Activity:checked').length;
   // alert(activityOfChecked+"=="+Priortity_count);
  if(Priortity_count!==activityOfChecked)
  {
      alert("Please first Select  the  priority ");
     return false;
  }
  if(activityOfChecked==0)
  {
    alert("Please first Select  the  activity ");
     return false;
  }

  
}
</script>
@endsection

