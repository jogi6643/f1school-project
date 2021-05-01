@extends('layouts.admin')

@section('content')
<section>
  	<div class="content-wrapper">
    	
    </div>
    <div class="row">
    	<div class="col m12 s12">
            <div class="panel">
               	<div class="panel-heading">
                    <div class="panel-title"></div>
				
               	<div class="panel-wrapper">
               		<div class="panel-body">
                        <form class="col s12" action="{{route('addp')}}"method="post">
	                          {{ csrf_field() }}
							  
                             
							<div class="row">
							<div class="col m12 s12">
							    <?php foreach($des as $dess):?>
                                   
								   <?php endforeach;?>
                               </div>
							   <table id="example" class="display" cellspacing="0" width="100%" style="font-size:12px;">
                                        <thead>
                                            <tr>
												
                                            	<th>Name</th>
                                                <th>Emp No.</th>
                                                 <th>Designation.</th>
                                                <th>Email Id</th>
                                                <th>Mobile</th>
												 <th>Label</th>
                                            </tr>
                                        </thead>
                                        <tbody>
										<?php $i=1;?>
							<?php foreach($des as $dess):?>
                                            <tr>
											    
                                                <td>{{$dess->employee_name}}</td>
                                                <td>{{$dess->employee_id}}</td>
                                                <td>{{$dess->des}}</td>
                                                <td>{{$dess->employee_email}}</td>
												<td>{{$dess->mobile_no}}</td>
												<td>{{$dess->name}}</td>
                                            </tr>
                                <?php $i=$i+1;?>
								<?php endforeach;?>   
                                        </tbody>
                                    </table>	
						
                            </div>
                          </form>	
                      </div>   
               	</div>
            </div>
        </div>
       
    </div>
  </section>
  @endsection