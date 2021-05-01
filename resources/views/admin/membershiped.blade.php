 @extends('layouts.admin')
 @section('content')
            <div class="content-heading">
               <div>Edit Plan
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
         <form method="post" action="{{url('membershiped')}}" onsubmit ="return myfunc()">
            @csrf
       
       <div cass="col-md-12">
       <label>Academic Year</label>
            <div class="form-group">
           <select  required=""  class="form-control"  name="academicyear">
<option value="<?= $k->academicyear?>">{{$k->academicyear}}</option>
    <option value="">Academic year</option>
    {{ $year1 = date('Y')+1 }}
    @for ($year = 2015; $year <= $year1; $year++)
   <option value="<?=($year-1)."-".($year);?>"><?=($year-1)."-".$year;?></option>
    @endfor
</select>


           </div>
       </div>


            <div class="form-group">
               <label>Plan Name</label>
               <input type="text" name="name" class="form-control" value="{{$k->name}}">
               <input hidden="" type="text" name="Planid" class="form-control" value="{{$k->id}}">
            </div>
            <div class="form-group">
               <label>Fee per Student</label>
               <input type="text" name="fee_per_student" class="form-control" value="{{$k->fee_per_student}}">
            </div>



            <div class="form-group">
               <label>Activity List </label>   
            </div>
            <div class="row">
              <!-- style="max-height: 300px; overflow-y: auto;" -->
               <div class="col-md-12" >
                
                <?php $y=0; ?>
                  @foreach($array1 as $key=> $c)
                     
                  <div class="card">
                      <div class="row">
                     @if(!in_array($c['id'], $cs))
                     
                     <div class="col-md-6">
                        <input style="margin-top: 20px;" type="checkbox" class="form-control Activity" onclick="course('{{$c['id']}}')" id="course_{{$c['id']}}" name="courselist[]" value="{{$c['id']}}"> {{$key+1}} 
                         {{$c['title']}} 
                     </div>
                     @if($priorty_set[0]=="")
                      <div class="col-md-6">
                          <select style="display: none;" onchange="getPriortity('{{$c['id']}}');" name="Priortity[]" class="form-control Priortity" id="Priortity_{{$c['id']}}">
                           
                            <option value="">Select Priortity</option>
                            @foreach($array1 as $k11=> $c)
                            <option value="{{$k11+1}}">{{$k11+1}}</option>
                            @endforeach
                          </select>

                         </div>
                         @else
                          <div class="col-md-6">
                          <select style="display: none;" onchange="getPriortity('{{$c['id']}}');" name="Priortity[]" class="form-control Priortity" id="Priortity_{{$c['id']}}">
                           
                            <option value="">Select Priortity</option>
                            @foreach($array1 as $k11=> $c)
                            <option value="{{$k11+1}}">{{$k11+1}}</option>
                            @endforeach
                          </select>

                         </div>
                         @endif
                         
                     @else
                     <div class="col-md-6">
                     <input type="checkbox" onclick="course('{{$c['id']}}')" id="course_{{$c['id']}}" class="form-control Activity" checked="checked" name="courselist[]" value="{{$c['id']}}"> 
                         {{$key+1}} 
                         {{$c['title']}} 
                     </div>

                       @if($priorty_set[0]=="")

                         <div class="col-md-6">
                          <select  style="display: none;" onchange="getPriortity('{{$c['id']}}');" name="Priortity[]" class="form-control Priortity" id="Priortity_{{$c['id']}}">
                            
                         
                            <option value="">Select Priortity</option>

                          @foreach($array1 as $k11=> $c)
                             
                            <option value="{{$k11+1}}">{{$k11+1}}</option>
                            @endforeach

                          </select>

                         </div>
                         @else

                         <div class="col-md-6">
                          <select  onchange="getPriortity('{{$c['id']}}');" name="Priortity[]" class="form-control Priortity" id="Priortity_{{$c['id']}}">
                        <option value="">Select Priortity</option>

                          @foreach($array1 as $k11=> $c)
                             
                            <option @if($priorty_set[$y]==$k11+1)selected @endif value="{{$k11+1}}">{{$k11+1}}</option>
                            @endforeach

                          </select>

                         </div>
                         @endif
                        <?php  $y =$y+1;?>
                     @endif

                      </div>
                      </div>
                       
                  @endforeach
                  <!-- <div class="col-md-4 offset-md-8"><button type="button" class="btn btn-success" id="applybtnid">Apply</button></div> -->
                  </div>
               </div>
            </div>
            <br>
            <div class="text-center"> <button type="submit" class="btn btn-success">Submit</button> </div>
         </form>
      
   </div>
   <script type="text/javascript">
    /*Start hide and unhide select box */
   var Priortity_count;
     function course(course_id)
     {
      $('#'+'Priortity_'+course_id).val("");
       Priortity_count = $('.Priortity').filter((i,s) => $(s)[0].selectedIndex > 0).length;
     
       if($('#'+'course_'+course_id).prop("checked") == true){
                alert("Please Set Priortity.");
                $('#'+'Priortity_'+course_id).show();
            }
            else if($('#'+'course_'+course_id).prop("checked") == false){
                // alert("Checkbox is unchecked.");
          // Priortity_count = $('.Priortity').filter((i,s) => $(s)[0].selectedIndex > 0).length;
                $('#'+'Priortity_'+course_id).hide();
                check_priority.remove(priority_value);


            }
     }
     /*End  hide and unhide select box */

     /*Start get value priority */ 
     // var selects = document.getElementsByTagName("select");
   var selects1 = document.getElementsByClassName("Priortity");
   var selected={};
   var selected1={};
   var current;
 
   for(i = 0; i < selects1.length; i++)
   {
   
    
     if(selects1[i].value!="")
      {
        current = selects1[i].selectedIndex;
      
        selected1[selects1[i].value] = true;
      }

      

    }
console.log(selected1);


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
/*End get value Priority*/
</script>
@endsection

