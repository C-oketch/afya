@extends('layouts.registrar_layout')
@section('title', 'Registrar Dashboard')
@section('content')
@include('includes.registrar.topnavbar_v1')
<div class="wrapper wrapper-content animated fadeIn">
  <div class="row">
    <div class="col-lg-4 pull-right">
      <button id="apptbut1" class="btn btn-primary pull-right ficha">Show Appointment</button>
      <button id="apptbut2" class="btn btn-primary pull-right">Create Appointment</button>
    </div>
  </div>
  <div class="row" id="appt1">
    <div class="col-lg-12">
      <div class="tabs-container">
        <ul class="nav nav-tabs">
          <li class="active"><a data-toggle="tab" href="#tab-1">Today Appointments</a></li>
          <li class=""><a data-toggle="tab" href="#tab-2">Tomorrow Appointments</a></li>
          <li class=""><a data-toggle="tab" href="#tab-3"> This Week Appointments</a></li>
          <li class=""><a data-toggle="tab" href="#tab-4">This Month Appointments</a></li>
        </ul>
        <div class="tab-content">
          <div id="tab-1" class="tab-pane active">
            <div class="panel-body">
              <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover dataTables-example" >
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Name</th>
                      <th>File No</th>
                      <th>Gender</th>
                      <th>Phone</th>
                      <th>Appointment Date</th>
                      <th>Appointment Time</th>
                      <th>Doctor</th>
                    </thead>

                    <tbody>
                      <?php $i =1; ?>
                      @foreach($patients as $patient)
                      <tr>
                        <td>{{$i}}</td>
                        @if($patient->persontreated==="Self")
                        <td>{{$patient->first}} {{$patient->second}}</td>
                      <td>{{$patient->file_no}}</td>
                        <td>{{$patient->gender}}</td>
                        <?php
                        $in = $patient->msisdn;
                        $result =  str_replace("254","0",$in);
                        ?>
                        <td>{{$result}}</td>
                        @else
                        <!-- dependants data---------------------->

                        <td>{{$patient->dfirst}} {{$patient->dsecond}}</td>

                        <td>{{$patient->dgender}}</td>
                        <?php
                        $in = $patient->msisdn;
                        $result =  str_replace("254","0",$in);
                        ?>
                        <td>{{$result}}</td>
                        @endif
                        <td>{{$patient->appointment_date}}</td>
                        <td>{{$patient->appointment_time}}</td>
                        <td>{{$patient->doc_name}}</td>
                      </tr>
                      <?php $i++; ?>

                      @endforeach

                    </tbody>

                  </table>
                </div>

              </div>
            </div>
            <div id="tab-2" class="tab-pane">
              <div class="panel-body">
                <div class="table-responsive">
                  <table class="table table-striped table-bordered table-hover dataTables-example" >
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Name</th>
                        <th>File No</th>
                        <th>Gender</th>
                        <th>Phone</th>
                        <th>Appointment Date</th>
                        <th>Appointment Time</th>
                        <th>Doctor</th>
                      </thead>

                      <tbody>
                        <?php $i =1; ?>
                        @foreach($patients2 as $patient)
                        <tr>
                          <td>{{$i}}</td>
                          @if($patient->persontreated==="Self")

                          <td>{{$patient->first}} {{$patient->second}}</td>
                          <td>{{$patient->file_no}}</td>
                          <td>{{$patient->gender}}</td>
                          <?php
                          $in = $patient->msisdn;
                          $result =  str_replace("254","0",$in);
                          ?>
                          <td>{{$result}}</td>
                          @else
                          <!-- dependants data---------------------->

                          <td>{{$patient->dfirst}} {{$patient->dsecond}}</td>

                          <td>{{$patient->dgender}}</td>
                          <?php
                          $in = $patient->msisdn;
                          $result =  str_replace("254","0",$in);
                          ?>
                          <td>{{$result}}</td>
                          @endif
                          <td>{{$patient->appointment_date}}</td>
                          <td>{{$patient->appointment_time}}</td>
                          <td>{{$patient->doc_name}}</td>
                        </tr>
                        <?php $i++; ?>

                        @endforeach

                      </tbody>

                    </table>
                  </div>

                </div>
              </div>
              <div id="tab-3" class="tab-pane">
                <div class="panel-body">
                  <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover dataTables-example" >
                      <thead>
                        <tr>
                          <th>No</th>
                          <th>Name</th>
                          <th>File No</th>
                          <th>Gender</th>
                          <th>Phone</th>
                          <th>Appointment Date</th>
                          <th>Appointment Time</th>
                          <th>Doctor</th>
                        </thead>

                        <tbody>
                          <?php $i =1; ?>
                          @foreach($patients3 as $patient)
                          <tr>
                            <td>{{$i}}</td>
                            @if($patient->persontreated==="Self")

                            <td>{{$patient->first}} {{$patient->second}}</td>
                             <td>{{$patient->file_no}}</td>
                            <td>{{$patient->gender}}</td>
                            <?php
                            $in = $patient->msisdn;
                            $result =  str_replace("254","0",$in);
                            ?>
                            <td>{{$result}}</td>
                            @else
                            <!-- dependants data---------------------->

                            <td>{{$patient->dfirst}} {{$patient->dsecond}}</td>

                            <td>{{$patient->dgender}}</td>
                            <?php
                            $in = $patient->msisdn;
                            $result =  str_replace("254","0",$in);
                            ?>
                            <td>{{$result}}</td>
                            @endif
                            <td>{{$patient->appointment_date}}</td>
                            <td>{{$patient->appointment_time}}</td>
                            <td>{{$patient->doc_name}}</td>
                          </tr>
                          <?php $i++; ?>

                          @endforeach

                        </tbody>

                      </table>
                    </div>

                  </div>
                </div>
                <div id="tab-4" class="tab-pane">
                  <div class="panel-body">
                    <div class="table-responsive">
                      <table class="table table-striped table-bordered table-hover dataTables-example" >
                        <thead>
                          <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>File No</th>
                            <th>Gender</th>
                            <th>Phone</th>
                            <th>Appointment Date</th>
                            <th>Appointment Time</th>
                            <th>Doctor</th>
                          </thead>

                          <tbody>
                            <?php $i =1; ?>
                            @foreach($patients4 as $patient)
                            <tr>
                              <td>{{$i}}</td>
                              @if($patient->persontreated==="Self")

                              <td>{{$patient->first}} {{$patient->second}}</td>
                              <td>{{$patient->file_no}}</td>
                              <td>{{$patient->gender}}</td>
                              <?php
                              $in = $patient->msisdn;
                              $result =  str_replace("254","0",$in);
                              ?>
                              <td>{{$result}}</td>
                              @else
                              <!-- dependants data---------------------->

                              <td>{{$patient->dfirst}} {{$patient->dsecond}}</td>

                              <td>{{$patient->dgender}}</td>
                              <?php
                              $in = $patient->msisdn;
                              $result =  str_replace("254","0",$in);
                              ?>
                              <td>{{$result}}</td>
                              @endif
                              <td>{{$patient->appointment_date}}</td>
                              <td>{{$patient->appointment_time}}</td>
                              <td>{{$patient->doc_name}}</td>
                            </tr>
                            <?php $i++; ?>

                            @endforeach

                          </tbody>

                        </table>
                      </div>

                    </div>
                  </div>
                </div>


              </div>
            </div>
          </div>
          <div class="ibox-content">
            <?php
            $facility = DB::table('facility_registrar')
            ->join('facilities', 'facilities.FacilityCode', '=', 'facility_registrar.facilitycode')
            ->select('facility_registrar.facilitycode','facilities.set_up')
            ->where('facility_registrar.user_id', Auth::user()->id)
            ->first();
            $facilitycode = $facility->facilitycode;
            $setup = $facility->set_up;

            $doctor = DB::table('facility_doctor')
            ->join('doctors', 'facility_doctor.doctor_id', '=','doctors.id' )
            ->select('doctors.name','doctors.id')
            ->where('facility_doctor.facilitycode', '=', $facilitycode)
            ->get();
            ?>
            <div class="row">
              <div class="ficha" id="appt2">
                <div class="col-lg-12 ">
                  {{ Form::open(array('url' => array('nxtappt-reg2'),'method'=>'POST')) }}

                  <div class="col-lg-6 b-r">
                    <div class="form-group col-md-8 col-md-offset-1">
                      <label class="control-label" for="name">First Name</label>
                      <input type="text" name="firstname" class="form-control">
                    </div>
                    <div class="form-group col-md-8 col-md-offset-1">
                      <label class="control-label" for="name">second Name</label>
                      <input type="text" name="secondname" class="form-control">
                    </div>
                    <div class="form-group col-md-8 col-md-offset-1">
                      <label class="control-label" for="name">Phone Number</label>
                      <input type="text" name="phone" class="form-control">
                      <p>please enter in following format 2547......</p>
                    </div>
                  </div>
                  <div class="col-lg-6 ">
                    <div class="form-group col-md-8 col-md-offset-1">
                      <label class="control-label" for="name">Doctor</label>
                      <select name="doc" class="form-control required">
                        <option value="">Select Doctor</option>
                        @foreach($doctor as $doc)
                        <option value="{{$doc->id}}">{{$doc->name}}</option>
                        @endforeach>
                      </select>
                    </div>
                    <div class="form-group col-md-8 col-md-offset-1" id="data_1">
                      <label class="font-normal">Next Doctor Visit</label>
                      <div class="input-group date">
                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                        <input type="text" class="form-control" name="next_appointment" value="">
                      </div>
                    </div>
                    <div class="form-group col-md-8 col-md-offset-1" id="data_1">
                      <label class="font-normal">Time For Visit</label>
                      <div class="input-group clockpicker" data-autoclose="true">
                        <input type="text" class="form-control" name="next_time" placeholder="09:30" > <span class="input-group-addon">
                          <span class="fa fa-clock-o"></span>   </span>
                        </div>
                      </div>
                    

                      {{ Form::hidden('facility',$facilitycode, array('class' => 'form-control')) }}
                      <div class="form-group  col-md-8 col-md-offset-1">
                        <button type="SUBMIT" class="btn btn-primary">Submit</button>
                      </div>
                      {{ Form::close() }}
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          @include('includes.default.footer')
          @endsection
            @section('script-reg')
          <script>

          $(document).ready(function(){
            $("#apptbut1").click(function(){
              $("#appt2").hide();
              $("#appt1").show();
              $("#apptbut1").hide();
              $("#apptbut2").show();
            });
            $("#apptbut2").click(function(){
              $("#appt1").hide();
              $("#appt2").show();
              $("#apptbut2").hide();
              $("#apptbut1").show();
            });
          });
        </script>

        <script>
        $('#data_1 .input-group.date').datepicker({
                    startView: 1,
                    todayBtn: "linked",
                    keyboardNavigation: false,
                    forceParse: false,
                    autoclose: true,
                    format: "yyyy-mm-dd"
                });
  $('.clockpicker').clockpicker();
        </script>

        @endsection
