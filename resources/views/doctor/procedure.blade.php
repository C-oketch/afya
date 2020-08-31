@extends('layouts.doctor_layout')
@section('title', 'Procedures')
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
         $Did=$pdetails->doc_id;
?>


            @section('leftmenu')
            @include('includes.doc_inc.leftmenu2')
            @endsection
            @include('includes.doc_inc.topnavbar_v2')


  <div class="row wrapper border-bottom">
              <div class="ibox float-e-margins">
                <div class="col-lg-12">
         <div class="tabs-container">
              <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#tab-45">PATIENT PROCEDURES</a></li>
                <li class=""><a data-toggle="tab" href="#tab-44">PROCEDURES LIST</a></li>
              </ul>
          <div class="tab-content">
              <div id="tab-44" class="tab-pane ">
                   <!---  PROCEDURES -------------------------------------------------------->
                  <div class="table-responsive ibox-content">
                           <table class="table table-striped table-bordered table-hover dataTables-main" >
                         <thead>
                         <?php  $data =DB::table('procedures')
                                  ->select('id','code','icd10_codes','description')
                                 ->get();  ?>
                             <tr>

                               <th>Code</th>
                               <th>ICD 10-Codes</th>
                               <th>Description</th>
                               <th>Action</th>

                             </tr>
                           </thead>
                           <?php  $i =1;?>
                           @foreach($data as $item)
                           <?php
                           $datadetails = DB::table('patient_procedure')
                           ->Where([['appointment_id',$app_id],
                                    ['procedure_id',$item->id],
                                   ])
                           ->first();
                           ?>
                           <tr class="item{{$item->id}}">
                             <td>{{$item->code}}</td>
                             <td>{{$item->icd10_codes}}</td>
                             <td>{{$item->description}}</td>
                             @if($datadetails)
                           <td>
                      <button class="btn btn-info"</span>ADDED</button>
                       </td>
                       @else
                       <td>
                  <button class="add-modal btn btn-primary" data-id="{{$item->id}}" data-app="{{$app_id}}"
                     data-code="{{$item->icd10_codes}}" data-desc="{{$item->description}}">
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
                 <!---  PROCEDURES   END-------------------------------------------------------->

                 <!---Patient  PROCEDURES-------------------------------------------------------->
                      <div id="tab-45" class="tab-pane active">

                           <div class="table-responsive ibox-content">
                                <table class="table table-striped table-bordered table-hover dataTables-main" >
                              <thead>
                              <?php  $proc =DB::table('patient_procedure')
                              ->leftjoin('procedures','patient_procedure.procedure_id','=','procedures.id')
                              ->select('patient_procedure.id','patient_procedure.created_at','patient_procedure.notes','patient_procedure.procedure_date',
                              'patient_procedure.status','procedures.code','procedures.icd10_codes','procedures.description')
                              ->get();  ?>
                                  <tr>

                                    <th>#</th>
                                    <th>Code</th>
                                    <th>ICD 10-Codes</th>
                                    <th>Description</th>
                                    <th>Date Diagnosed</th>
                                    <th>Date of procedure</th>
                                    <th>Action</th>

                                  </tr>
                                </thead>
                                <?php  $i =1;?>
                                @foreach($proc as $procs)
                                <tr class="item{{$procs->id}}">
                                  <td>{{$i}}</td>
                                  <td>{{$procs->code}}</td>
                                  <td>{{$procs->icd10_codes}}</td>
                                  <td>{{$procs->description}}</td>
                                  <td>{{$procs->created_at}}</td>
                                  <td>{{$procs->procedure_date}}</td>
                                <td>
                                  @if($procs->status =='DONE') Done @else
                           <button class="edit-modal btn btn-primary" data-id="{{$procs->id}}" data-app="{{$app_id}}"
                              data-code="{{$procs->icd10_codes}}" data-desc="{{$procs->description}}" data-date1="{{$procs->created_at}}"
                              data-date2="{{$procs->procedure_date}}" data-doc="{{$Did}}" data-note="{{$procs->notes}}">
                              <span class="glyphicon glyphicon-plus"></span>EDIT
                            </button>
                            <button class="delete-modal btn btn-danger"  data-id="{{$procs->id}}" data-app="{{$app_id}}"
                               data-code="{{$procs->icd10_codes}}" data-desc="{{$procs->description}}" data-date1="{{$procs->created_at}}"
                               data-date2="{{$procs->procedure_date}}" data-doc="{{$Did}}" data-note="{{$procs->notes}}">Delete
                            </button>
                                 @endif
                                  </td>
                                </tr>
                                <?php $i++; ?>
                                @endforeach
                              </table>
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
                              <form class="form-horizontal" role="form">
                                <div class="form-group">
                                  <!-- <label class="control-label col-sm-2" for="id">ID:</label> -->


                                <div class="form-group">
                                  <label class="control-label col-sm-2" for="name">Procedure Code:</label>
                                  <div class="col-sm-10">
                                    <input type="hidden" class="form-control" id="fid" name="procId" >
                                    <input type="hidden" class="form-control" id="app" name="appoId" >
                                     <input type="text" class="form-control" id="n" name="proc_id" >
                                     <input type="hidden" class="form-control editstuff" id="dc" name="doc_id" >

                                  </div>
                                </div>
                                 <div class="form-group">
                                  <label class="control-label col-sm-2" for="availability">Procedure Description:</label>
                                  <div class="col-sm-10">
                                    <input type="text" class="form-control" id="av" name="description" placeholder="YES or NO" >
                                    </div>
                                </div>
                                <div class="form-group editstuff">
                                 <label class="control-label col-sm-2" for="availability">Date Instructed:</label>
                                 <div class="col-sm-10">
                                   <input type="text" class="form-control" id="dat" name="dat1">
                                   </div>
                               </div>
                               <div class="form-group editstuff">
                                <label class="control-label col-sm-2" for="availability">Date for Procedure:</label>
                                <div class="col-sm-10">
                                  <input type="text" class="form-control" id="dath" name="dath1">
                                  </div>
                              </div>

                                <div class="form-group">
                                 <label class="control-label col-sm-2" for="availability">More Details:</label>
                                 <div class="col-sm-10">
                                   <input type="text" class="form-control" id="nt" name="note" >
                                   </div>
                               </div>
                               <div class="form-group">
                                <label class="control-label col-sm-2" for="availability">Status:</label>
                                  <div class="col-sm-10">
                                    <select class="form-control" name="status"  style="width: 100%">
                                   <option value='Pending'>PENDING</option>
                                  <option value='Done'>DONE</option>
                              </select>

                                </div>







                              </div>
                        {{ csrf_field() }}
                              </form>

                              <div class="modal-footer">
                                <button type="button" class="btn actionBtn" data-dismiss="modal">
                                  <span id="footer_action_button" class='glyphicon'> </span>
                                </button>
                                <button type="button" class="btn btn-warning" data-dismiss="modal">
                                  <span class='glyphicon glyphicon-remove'></span> Close
                                </button>
                              </div>
                            </div>
                          </div>
                        </div>
                       </div>
                     </div>



            </div>
        </div>
       </div>
      </div>
    </div>
    @endsection
    <!-- Section Body Ends-->
    @section('script-test')
     <!-- Page-Level Scripts -->
    <script src="{{ asset('js/procedure.js') }}"></script>
    @endsection
