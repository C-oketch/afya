@extends('layouts.doctor_layout')
@section('title', 'Prescriptions')

@section('content')



<?php



  $stat= $pdetails->status;
  $afyauserId= $pdetails->afya_user_id;
  $dependantId= $pdetails->persontreated;
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


<?php
 $routem= (new \App\Http\Controllers\TestController);
$routems = $routem->RouteM();

$Strength= (new \App\Http\Controllers\TestController);
$Strengths = $Strength->Strength();

$frequency= (new \App\Http\Controllers\TestController);
$frequent = $frequency->Frequency();

use App\Http\Controllers\Controller;

$diz =DB::table('patient_diagnosis')
->select('disease_id as name','id')
->where('patient_diagnosis.appointment_id',$app_id)
->get();

?>


<div class="wrapper wrapper-content animated">


  <div class="row">
    <div class="col-lg-12">
      <div class="tabs-container">
        <ul class="nav nav-tabs">
          <li class="active"><a data-toggle="tab" href="#tab-501">Diagnosis</a></li>
          <li class=""><a data-toggle="tab" href="#tab-51">Add Prescription</a></li>
          <li class=""><a data-toggle="tab" href="#tab-52">Prescription History</a></li>
            <li class=""><a  href="{{route('printpresc',$app_id)}}" >Print Prescription</a></li>
        </ul>
        <div class="tab-content">
          <div id="tab-501" class="tab-pane active">
            <div class="panel-body">
                <div class="col-md-6">
                  {{ Form::open(array('route' => array('quickdiag'),'method'=>'POST')) }}
                <div class="form-group">
                    <label>Disease Name:</label>
                <select id="diseases" name="disease" multiple="multiple" class="form-control d_list2" style="width: 100%"></select>
                </div>
        <div class="form-group">
                      <label for="tag_list" class="">Type of Diagnosis:</label>
                      <select class="select2_demo_1" name="level"  style="width: 100%" >
                      <option value=''>Choose one</option>
                      <option value='Primary'>Primary</option>
                      <option value='Secondary'>Secondary</option>
                      </select>
                      </div>
                      <div class="form-group">
                      <label for="tag_list" class="">Chronic:</label>
                      <select class="select2_demo_1" name="chronic"  style="width: 100%" >
                      <option value=''>Choose one</option>
                      <option value='Y'>YES</option>
                      <option value='N'>No</option>
                      </select>
                      </div>



                       {{ Form::hidden('state','Normal', array('class' => 'form-control')) }}
                     {{ Form::hidden('appointment_id',$app_id, array('class' => 'form-control')) }}

                       {{ Form::hidden('dependant_id',$dependantId, array('class' => 'form-control')) }}
                       {{ Form::hidden('afya_user_id',$afyauserId, array('class' => 'form-control')) }}
                       {{ Form::hidden('facility_id',$fac_id, array('class' => 'form-control')) }}
                       {{ Form::hidden('doc_id',$doc_id, array('class' => 'form-control')) }}

                 <div class="col-md-offset-5">
                   <button class="btn btn-lg btn-primary  m-t-n-xs" type="submit"><strong>Submit</strong></button>
                 {{ Form::close() }}
                </div>
                  </div>


  <div class="col-lg-6">
              <div class="ibox float-e-margins">

                  <div class="ibox-content">
                    <h3>Diagnosis Made</h3>
                      <table class="table">
                          <thead>
                          <tr>
                              <th>#</th>
                              <th>Condition Name</th>
                          </tr>
                          </thead>
                          <tbody>
                            <?php $i=1; ?>
                            @foreach ($Pdiagnosis as $Pdiag)
                          <tr>
                              <td>{{$i}}</td>
                              <td>{{$Pdiag->name}}</td>
                          </tr>
                          <?php $i++;  ?>
                    @endforeach
                          </tbody>
                      </table>

                  </div>
              </div>
          </div>




            </div>
          </div>



          <div id="tab-51" class="tab-pane">
            <div class="panel-body">
  <div class="col-md-12">
    <div class="table-responsive ibox-content">
             <table class="table table-striped table-bordered table-hover dataTables-main" >
           <thead>
           <?php  $data =DB::table('druglists')
                    ->select('id','drugname','Ingridients')
                   ->get();  ?>
               <tr>

                 <th>#</th>
                 <th>Drug Name</th>
                 <th>Ingridients</th>
                 <th>Action</th>

               </tr>
             </thead>
             <?php  $i =1;?>
             @foreach($data as $item)
             <?php
             $datadetails = DB::table('prescription_details')
             ->Where([
                      ['drug_id',$item->id],
                      ['presc_id',$cript->id],
                     ])
             ->first();
             ?>
             <tr class="item{{$item->id}}">
               <td>{{$item->id}}</td>
               <td>{{$item->drugname}}</td>
               <td>{{$item->Ingridients}}</td>
               @if($datadetails)
             <td>
        <button class="btn btn-info"</span>ADDED</button>
         </td>
         @else
         <td>
    <button class="add-modal btn btn-primary" data-id="{{$item->id}}" data-app="{{$app_id}}"
       data-code="{{$item->drugname}}" data-desc="{{$item->Ingridients}}">
       <span class="glyphicon glyphicon-plus"></span>ADD
     </button>
     </td>
         @endif
             </tr>
             <?php $i++; ?>
             @endforeach
           </table>
         </div>





              </div>

            </div>
          </div>

          <div id="tab-52" class="tab-pane">
            <div class="panel-body">
              <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover dataTables-tests" >
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Condition</th>
                      <th>Drug Details</th>
                      <th>Action</th>

                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $i=1;?>
                    @foreach ($allpresczs as $ctt)

                    <tr class="item{{$ctt->presc_details_id}}">
                      <td>{{$i}}</td>
                      <td>{{$ctt->name}}</td>
                      <td>{{$ctt->drug_id}}</td>
                      <td>
                        @if($app_id == $ctt->appsId)
                        <a class="btn btn-danger" href="{{route('prescs.deletes',$ctt->presc_details_id)}}"><i class="fa fa-remove"></i>Delete</a>
                      @endif</td>

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
  </div>
</div>
</div>


<?php
$Pdiagnosis2=DB::table('patient_diagnosis')
->leftjoin('icd10_option','patient_diagnosis.disease_id','=','icd10_option.id')
->leftjoin('severity','patient_diagnosis.severity','=','severity.id')
->select('icd10_option.name','patient_diagnosis.level','patient_diagnosis.id as diag_id',
'severity.name as severity','icd10_option.id')

->where([
              ['patient_diagnosis.appointment_id',$app_id],
              ['patient_diagnosis.state', '=', 'Normal'],

             ])
->get();
 ?>



                      <div id="myModal" class="modal fade" role="dialog">
                        <div class="modal-dialog">
                          <!-- Modal content-->
                          <div class="modal-content">
                            <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                              <h4 class="modal-title"></h4>
                            </div>
                            <div class="modal-body">
                              {!! Form::open(array('url' => 'insert-presc2','method'=>'POST', 'class'=>'form-horizontal')) !!}
                              <input type="hidden" name="_token" value="{{ csrf_token() }}">

                              <!-- <form class="form-horizontal" role="form"> -->

                                <div class="form-group">


                                  <!-- <label class="control-label col-sm-2" for="id">ID:</label> -->
                      <div class="form-group">
                       <label class="control-label col-sm-2" for="availability">Condition:</label>
                         <div class="col-sm-10">
                           <select class="form-control" name="condition"  style="width: 100%">
                             @foreach ($Pdiagnosis2 as $Pdiag)
                               <option value='{{$Pdiag->diag_id}}'>{{$Pdiag->name}}</option>
                               @endforeach
                     </select>

                       </div>
                     </div>

                                <div class="form-group">
                                  <label class="control-label col-sm-2" for="name">Drug:</label>
                                  <div class="col-sm-10">
                                    <input type="hidden" class="form-control" id="fid" name="drug_id" >
                                    <input type="hidden" class="form-control" id="app" name="appId" >
                                     <input type="text" class="form-control" id="n" name="proc_id" >

                                  </div>
                                </div>
                                 <div class="form-group">
                                  <label class="control-label col-sm-2" for="availability">Ingridients:</label>
                                  <div class="col-sm-10">
                                    <input type="text" class="form-control" id="av" name="description" placeholder="YES or NO" >
                                    </div>
                                </div>



                                <div class="form-group">
                                 <label class="control-label col-sm-2" for="availability">Dosage:</label>
                                 <div class="col-sm-10">
                                   <input type="text" class="form-control" id="nt" name="notes" >
                                   </div>
                               </div>


                              <div class="modal-footer">
                                <!-- <button type="button" class="btn actionBtn" data-dismiss="modal">
                                  <span id="footer_action_button" class='glyphicon'> </span>
                                </button> -->


                                  <button class="btn btn-sm btn-primary" type="submit"><strong>Submit</strong></button>

                                {{ Form::close() }}
                                <button type="button" class="btn btn-warning" data-dismiss="modal">
                                  <span class='glyphicon glyphicon-remove'></span> Close
                                </button>
                              </div>
                            </div>
                          </div>
                        </div>
                       </div>
                     </div>
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
 $("#employee_table tr:last").after("<tr id='row"+$rowno+"'><td><input type='text' name='drug["+$rowno+"]' class='form-control 'placeholder='Drug Details'></td><td><input type='button' class='btn btn-danger' value='DELETE' onclick=delete_row('row"+$rowno+"')></td></tr>");
}
function delete_row(rowno)
{
 $('#'+rowno).remove();
}
</script>
<script src="{{ asset('js/prescription2.js') }}"></script>
@endsection
