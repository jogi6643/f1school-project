@extends((Auth::user()->role==1?'layouts.admin':'layouts.admin'))

@section('content')
 
             <div class="content-heading">
               <div>School List
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

             <div class="text-right">
               <div class="btn-group">
                     <a href="{{url('trdownloadstudentbyschool')}}" class="btn btn-warning">Download Student Upload Templates</a>
               </div>
             </div>
             <div class="text-right">
                           
                <button type="button" onclick="goBack()" class="btn btn-info">Go Back</button>

                        <script>
                        function goBack() {
                         window.history.back();
                               }
                        </script>
             </div>
               <h2>schoolname</h2>
            
 <table class="table table-striped table-bordered" id="schollistid">
  <thead>
    <tr>
      <th>#</th>
          
      <th>School Name</th>
    
      <th>View Student list</th>
         
    </tr>
  </thead>
  <tbody>
 

    <?php $i=1;
      
    ?>
  @foreach($schoolnames as $row)
    <tr>
      <td>{{$i++}}</td> 
      <td> <a href="">{{$row->school_name}}</a></td>
      <td><a href="{{url('liststudent/'.$row->id)}}">List Student </td>
        <td>
         <a href=""><button type="button" class="btn btn-success">Create Team</button></a>
        </td>
     </tr>
  @endforeach 
  
  
  
  </tbody>
 </table>
       




@endsection

@section('header')
<!--<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">-->
<script type="text/javascript"  src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
@endsection

@section('footer')
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
 <script type="text/javascript">
  $(document).ready(function(){
    $('#schollistid').DataTable();
  });

//   function myfuntemp(arg) {
//       var ad=$(arg).attr('id');
//       var ak=ad.split('-');
//       // alert('val = '+ak[1]);
//       if(confirm("Do you really want to delete this."))
//          window.location.href='{{url("/schooldel")}}/'+btoa(ak[1]);
//          // alert("yes");
//   }
 </script>
@endsection




