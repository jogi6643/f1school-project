 @extends('layouts.admin')

@section('content')
<section>

    	
               <div class="content-heading">
               <div>Role 
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
              <div class="container">
				<div class="row">
               	     <div class="col-md-12">
							<form  action="{{url('addrole')}}"method="post">
							    <table class="table table-hover table-striped">
                               
                                     <tr>   
								   {{ csrf_field() }}
								   <td> <label for="abc">Role:</label></td>
								   <td>
    								  <div class="row">
    									<div class="form-group">
    									  <input required="" id="abc" name="name" class="form-control" type="text" class="validate">
    									 
    									</div>
									</td>
									
								</div>
								</tr>
								<tr >
								<td colspan="1" align="center">
    							
    								    	<button  type="submit" class="btn btn-success">Save</a>
    							
							   </td>
								</tr>
						 </table>
								</form>	
					 
				</div>
				</div>
			</div>

  </section>
@endsection