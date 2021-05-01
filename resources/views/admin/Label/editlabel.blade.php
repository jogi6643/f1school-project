@extends('layouts.admin')
@section('content')
            <div class="content-heading">
               <div>Edit Module
                  <small data-localize="dashboard.WELCOME"></small>
               </div>
               <!-- START Language list-->
               <div class="ml-auto">
                  <!-- <div class="btn-group">
                     <button class="btn btn-secondary dropdown-toggle dropdown-toggle-nocaret" type="button" data-toggle="dropdown">English</button>
                     <div class="dropdown-menu dropdown-menu-right-forced animated fadeInUpShort" role="menu"><a class="dropdown-item" href="#" data-set-lang="en">English</a><a class="dropdown-item" href="#" data-set-lang="es">Spanish</a>
                     </div>
                  </div> -->
               </div>
               <!-- END Language list-->
            </div>
  <form class="col s12" action="" method="post">
	                          {{ csrf_field() }}
 <table class="table table-hover table-striped" id="transactionid">
     	<thead>
      <tr>
            
 	        <td>
 	        <label>Status :</label>
 	        <select name="status" id="status">
							 
		     <option value="0" <?php if($module['status']==0){echo "selected";}?>>Inactive</option>
			 <option value="1" <?php if($module['status']==1){echo "selected";}?>>Active</option>
							 
			 </select>
			 <input type="hidden" name="id" value="{{$module['id']}}"/>
			</td>
 	    </tr>
 
 		<tr>
 		    <th>---</th>
 			<th>Module</th>
 			<th>Function</th>
 		
 		</tr>
 		
 	</thead>
 	<tbody>
 	   

  <?php foreach($module['module'] as $dess):?>	 
		<tr>
			 <td>
				<label for="{{$dess->id}}">
				<input type="checkbox" onclick="test(this)" name="module_id[]" <?php if(in_array($dess->id,$module['selected'])){echo "checked"; } ?> value="{{$dess->id}}" id="{{$dess->id}}" />
						
					</label>
			</td>
			<td><span>{{$dess->modulename}}</span></td>
		  <td> 
		  
		  @if(in_array($dess->id,$module['selected']))
		  <?php $x=(int)$dess->id;?>
		  <select name="{{$dess->id}}_function"  id="{{$dess->id}}_function" required>
	        @foreach((array)$dess->rights->name as $key=>$names)
		     
		      <option  @if($key==$module['sel'][$x]['functions']) selected  @endif  value="{{$key}}">{{$names}}</option>
			 @endforeach   
			
		</select>
		 @else
			 
		 <select name="{{$dess->id}}_function" class="functions"  id="{{$dess->id}}_function" required>
		     <option>--Select Function</option>
			
		     @foreach((array)$dess->rights->name as $keys=>$names)
		     
		      <option  value="{{$keys}}">{{$names}}</option>
			 @endforeach        
			
		</select>
		 @endif
		 
		</td>

		 			
		</tr>
		
		@endforeach
 		<tr>
         <td colspan="2" align="center">
          <button type="submit" class="btn btn-success col-md-2">Update</button>
          </td>
          </tr>
 	</tbody>
 </table>
</form>



@endsection

@section('header')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
@endsection

@section('footer')
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
 <script type="text/javascript">
  
   
  $(".area").hide(); 
  $(".functions").hide();
     function test(ids){
	
		if(ids.checked){
			
		 $("#"+ids.id+"_function").show();
		
		}
		else{
			
		 $("#"+ids.id+"_function").hide();
		  
		
		
		 
	 }
	 }
	 </script>

@endsection