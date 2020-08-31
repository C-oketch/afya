@extends('layouts.doctor_layout')
@section('title', 'Admition')
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


<!--tabs Menus-->

<div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-12">
            <div class="tabs-container">
            <div class="tab-content">
           <div id="admit" class="panel-body">
                                    {{ Form::open(array('route' => array('admitting'),'method'=>'POST')) }}

                                    <div class="form-group col-md-8 col-md-offset-1">
                                        <label  class="col-md-6">Facility:</label>
                                         <select id="facility" name="facility" class="form-control facility1" style="width: 100%"></select>
                                    </div>
                                      <div class="form-group col-md-8 col-md-offset-1" id="data_1">
                                          <label class="font-normal">Next Doctor Visit</label>
                                          <div class="input-group date">
                                              <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                              <input type="text" class="form-control" name="next_appointment" value="">
                                          </div>
                                      </div>
                                 {{ Form::hidden('appointment_id',$app_id, array('class' => 'form-control')) }}
                                  {{ Form::hidden('doc_id',$doc_id, array('class' => 'form-control')) }}

                      <div class="form-group col-md-8 col-md-offset-1">
                       <label for="role" class="control-label">Doctor note</label>
                        {{ Form::textarea('doc_note', null, array('placeholder' => 'note..','class' => 'form-control col-lg-8')) }}
                    </div>


                    <div class="form-group  col-md-8 col-md-offset-1">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                  {{ Form::close() }}
                        </div><!--panel body-->

                </div>
              </div><!--tabcontent-->
          </div><!--tabs-container-->
        </div><!--col12-->
        <!--tabs-->

@endsection
