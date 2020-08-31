@extends('layouts.registrar_layout')
@section('content')
 <div class="row" id="">
 <div class="ibox float-e-margins">
 <div class="col-md-12 white-bg">
 <div class="ibox-title">
   <a class="btn btn-success" href="{{url('registrar.shows',$id)}}"><i class="fa fa-arrow-left"></i>GO BACK</a>
 VACCINES</h5>

</div>
 <div class="ibox-content">

 <div class="table-responsive">
 <table class="table table-striped table-bordered table-hover dataTables-example" >
 <thead>
 <tr>
   <th>#</th>
   <th>Disease</th>
   <th>Antigen</th>
   <th>Added</th>
   <th>Actions</th>

 </tr>
 </thead>
 <tbody>
 <?php
 $i=1;?>
 <?php  $diseases = DB::table('vaccine')->get();?>
 @foreach ($diseases as $dss)

   <tr class="item{{$dss->id}}">
     <td>{{$dss->id}}</td>
     <td>{{$dss->disease}}</td>
     <td>{{$dss->antigen}}</td>


 <?php
 $vacdetails = DB::table('vaccination')
 ->Where([['userId',$id],['diseaseId',$dss->id],])
 ->first();
 ?>

 <td>
    @if($vacdetails)
<button class= "edit-modal btn btn-info"  data-name="{{$dss->disease}}"  data-antgen="{{$dss->antigen}}" data-yesdate="{{$vacdetails->yesdate}}" data-vacname="{{$vacdetails->vaccine_name}}" >
  View</button>
 @else
 @endif
 </td>
 <td>
 <button class="add-modal btn btn-primary" data-id="{{$dss->id}}" data-afya="{{$id}}"
     data-name="{{$dss->disease}}"  data-antgen="{{$dss->antigen}}">
     <span class="glyphicon glyphicon-plus"></span>ADD
   </button>
 </td>

 </tr>
 <?php $i++;  ?>
 @endforeach
 </tbody>

 </tbody>
 <tfoot>
 <tr>

 </tr>
 </tfoot>
 </table>
 </div>

 </div>
 </div>
 </div>
 </div>


 <div id="myModal" class="modal fade" role="dialog">
 <div class="modal-dialog">
 <!-- Modal content-->
 <div class="modal-content">
 <div class="modal-header">
 <button type="button" class="close" data-dismiss="modal">&times;</button>
 <h4 class="modal-title"></h4>
 </div>
 <div class="modal-body">
   <form class="form" role="form">
   <!-- <form class="form" role="form" method="POST" action="/vaccine" novalidate> -->
   <input type="hidden" name="_token" value="{{ csrf_token() }}">

 <div class="form-group">
 <label>Disease Name:</label>
<input type="text" class="form-control" id="n" readonly>
 <input type="hidden" class="form-control" id="fid" name="vaccine_id" >
 <input type="hidden" class="form-control" id="afyaid" name="afya_user_id" >
</div>

 <div class="form-group">
 <label>Antigen:</label>
 <input type="text" class="form-control" id="ant" readonly>
 </div>

 <div class="form-group">
 <label>Vaccine Name:</label>
   <input type="text" class="form-control" id="vacname" name="vaccine_name" >
</div>
</div>

 <div class="modal-footer">
   <button type="button" class="btn actionBtn" data-dismiss="modal">
     <span id="footer_action_button" class='glyphicon'> </span>
   </button>



   <button type="button" class="btn btn-warning" data-dismiss="modal">
 <span class='glyphicon glyphicon-remove'></span> Close
 </button>
 {!! Form::close() !!}
 </div>
 </div>
 </div>
 </div>


 <div id="myModaledit" class="modal fade" role="dialog">
 <div class="modal-dialog">
 <!-- Modal content-->
 <div class="modal-content">
 <div class="modal-header">
 <button type="button" class="close" data-dismiss="modal">&times;</button>
 <h4 class="modal-title"></h4>
 </div>
 <div class="modal-body">
  <form class="form">

    <div class="form-group">
    <label>Disease Name:</label>
    <input type="text" class="form-control" id="n1" readonly>
    </div>

     <div class="form-group">
     <label>Antigen:</label>
     <input type="text" class="form-control" id="ant1" readonly>
    </div>

     <div class="form-group">
     <label>Vaccine Name:</label>
       <input type="text" class="form-control" id="vacname1" readonly>
    </div>
   <div class="form-group">
     <label>Date given:</label>
       <input type="text" class="form-control" id="yesdate1"  readonly>
    </div>


</div>

 <div class="modal-footer">
<button type="button" class="btn btn-warning" data-dismiss="modal">
 <span class='glyphicon glyphicon-remove'></span> Close
 </button>
 {!! Form::close() !!}
 </div>
 </div>
 </div>
 </div>

 @endsection
 @section('script-reg')
  <!-- Page-Level Scripts -->
 <script src="{{ asset('js/nurse/vaccine.js') }}"></script>
 @endsection
