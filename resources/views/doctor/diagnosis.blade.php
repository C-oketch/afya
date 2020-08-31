@extends('layouts.doctor_layout')
@section('title', 'Quick Diagnosis')
@section('content')

<?php

           $stat= $pdetails->status;
         $afyauserId= $pdetails->afya_user_id;
          $dependantId= $pdetails->persontreated;
          $app_id_prev= $pdetails->last_app_id;
          $app_id= $pdetails->id;
          $doc_id= $pdetails->doc_id;
          $fac_id= $pdetails->facility_id;
          $fac_setup= $pdetails->set_up;
          $dependantAge = $pdetails->depdob;
          $AfyaUserAge = $pdetails->dob;
        $condition = $pdetails->condition;
?>

@section('leftmenu')
@include('includes.doc_inc.leftmenu2')
@endsection
@include('includes.doc_inc.topnavbar_v2')


<!--tabs Menus-->

<div class="row wrapper border-bottom  page-heading">


   <div class="col-lg-6">
     <div class="ibox float-e-margins">
       <div class="ibox-title">
         <h5>Patient Diagnosis</h5>
       </div>
       <div class="ibox-content">
         {{ Form::open(array('route' => array('quickdiag'),'method'=>'POST' ,'class'=>'form-horizontal')) }}
         <input type="hidden" name="_token" value="{{ csrf_token() }}">

         {{ Form::hidden('state','Normal', array('class' => 'form-control')) }}
         {{ Form::hidden('appointment_id',$app_id, array('class' => 'form-control')) }}
         {{ Form::hidden('afya_user_id',$afyauserId, array('class' => 'form-control')) }}

         <!-- <div class="form-group ">
         <label  class="control-label">Condition:</label>
           <input type="text" class="form-control" value="" name="disease"  required/>
           <select id="diseases" name="disease" class="form-control d_list2" style="width: 100%"></select>
         </div> -->
 <div class="table-responsive">
     <table class="table borderless" id="employee_table">
     <tr id="row1">
     <td><input type="text" name="disease[0]" placeholder="Condition" class="form-control" required/></td>
     </tr>
     </table>
     <input type="button" onclick="add_row();" value="ADD MORE"  class='btn btn-primary'>
     <input type="submit" class='btn btn-primary' name="submit_row" value="SUBMIT">

     </div>

         {{ Form::close() }}
       </div>
     </div>
   </div>

   <div class="col-lg-6">
     <div class="ibox float-e-margins">
       <div class="ibox-title">
         <h5>Impression</h5>
        <a  href="{{route('impression',$app_id)}}" class="pull-right"><i class="fa fa-pencil-square-o"></i><span class="nav-label">Edit Impression</span></a></li>

       </div>
       <div class="ibox-content">
         <table class="table table-striped">
           <thead>
             <tr>
               <th>#</th>
               <th>Impression</th>
               <!-- <th colspan="2">Action</th> -->
             </tr>
           </thead>
           <tbody>
             <?php   $i=1;   ?>
             @foreach($imp as $imps)
             <tr>
               <td>{{$i}}</td>
               <td><span>{{ $imps->notes }}</span></td>
               <!-- <td><a href="{{route('impression_edit',$imps->id)}}">edit</a></td>
               <td><a href="{{route('impression_remove',$imps->id)}}">remove</a></td> -->
             </tr>
             <?php   $i++;   ?>
             @endforeach
           </tbody>
         </table>
       </div>
     </div>

     <div class="ibox float-e-margins">
       <div class="ibox-title">
         <h5>Diagnosis</h5>
       </div>
       <div class="ibox-content">
         <table class="table table-striped">
           <thead>
             <tr>
               <th>#</th>
               <th>Condition</th>
               <th colspan="2">Action</th>
             </tr>
           </thead>
           <tbody>
             <?php   $i=1;   ?>
             @foreach($condy as $conds)
             <tr>
               <td>{{$i}}</td>
               <td><span>{{ $conds->name }}</span></td>
               <td><a href="{{route('diagnosis_edit',$conds->id)}}">edit</a></td>
               <td><a href="{{route('diagnosis_remove',$conds->id)}}">remove</a></td>
             </tr>
             <?php   $i++;   ?>
             @endforeach
           </tbody>
         </table>
       </div>
     </div>







   </div>




</div><!-- row -->

@endsection
<!-- Section Body Ends-->
@section('script-test')
<!-- Put your scripts here -->
<script>
$(".select2_demo_1").select2();
</script>
<script type="text/javascript">
function add_row()
{
data:$('#add_name').serializeArray(),
 $rowno=$("#employee_table tr").length;
 $rowno=$rowno+1;
 $("#employee_table tr:last").after("<tr id='row"+$rowno+"'><td><input type='text' name='disease["+$rowno+"]' class='form-control 'placeholder='Condition'></td><td><input type='button' class='btn btn-danger' value='DELETE' onclick=delete_row('row"+$rowno+"')></td></tr>");
}
function delete_row(rowno)
{
 $('#'+rowno).remove();
}
</script>
@endsection
