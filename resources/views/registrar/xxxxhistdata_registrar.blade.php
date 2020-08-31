@extends('layouts.registrar_layout')
@section('title', 'Registrar Dashboard')
@section('content')


    @include('includes.registrar.topnavbar_v2')


<div class="wrapper wrapper-content animated fadeInRight">
      @include('registrar.private.first_time')





<div class="wrapper wrapper-content animated fadeInRight">
  <div class="row">
                              <div class="col-lg-4">
                                  <div class="ibox float-e-margins">
                                      <div class="ibox-title">
                                          <h5>Medical History</h5>
                                          <div class="ibox-tools">
                                              <a class="collapse-link">
                                                  <i class="fa fa-chevron-up"></i>
                                              </a>
                                              <a class="close-link">
                                                  <i class="fa fa-times"></i>
                                              </a>
                                          </div>
                                      </div>
                                      <div class="ibox-content">
                                          <table class="table table-hover no-margins">
                                              <thead>
                                              <tr>
                                                  <th>Condition</th>
                                                  <th>Status</th>
                                                  <th>Condition</th>
                                                  <th>Status</th>
                                              </tr>
                                              </thead>
                                              <tbody>
                                                @if($medicalH)
                                              <tr>
                                                  <td>Eye Disease</td><td>{{$medicalH->eye_disease}}</td>
                                                  <td>Skin Problems </td>   <td class="text-navy">{{$medicalH->skin_problems}} </td>
                                              </tr>
                                              <tr>
                                                  <td>Pyschological Problems</td>  <td class="text-navy">{{$medicalH->pyschological_problems}} </td>
                                                  <td> Arthritis Joint Disease</td>   <td class="text-navy">{{$medicalH->arthritis_joint_disease}} </td>
                                              </tr>
                                              <tr>
                                                  <td>Gyneocological Disease</td>   <td class="text-navy"> {{$medicalH->gyneocological_disease}}</td>
                                                  <td> Thyroid Disease</td>   <td class="text-navy">{{$medicalH->thyroid_disease}} </td>
                                              </tr>


                                              <tr>
                                                  <td>Hypertension</td>   <td class="text-navy"> {{$medicalH->hypertension}}</td>
                                                  <td>Diabetes </td>   <td class="text-navy">{{$medicalH->diabetes}} </td>
                                              </tr>
                                              <tr>
                                                  <td>Heart Attack</td>   <td class="text-navy"> {{$medicalH->heart_attack}}</td>
                                                  <td> Stroke</td>   <td class="text-navy"> {{$medicalH->stroke}}</td>
                                              </tr>
                                              <tr>
                                                  <td>Liver Disease</td>   <td class="text-navy">{{$medicalH->liver_disease}} </td>
                                                  <td>Lung Disease </td>   <td class="text-navy"> {{$medicalH->lung_disease}}</td>
                                              </tr>
                                              <tr>
                                                  <td>Bowel Disease</td>   <td class="text-navy">{{$medicalH->bowel_disease}} </td>

                                              </tr>
                                              @else
                                              <tr>
                                                <td class="text-navy">No Data Available </td>

                                              </tr>
                                                @endif
                                              </tbody>
                                          </table>
                                      </div>
                                  </div>
                              </div>
                              <div class="col-lg-4">
                                  <div class="ibox float-e-margins">
                                      <div class="ibox-title">
                                          <h5>Self Medication</h5>
                                          <div class="ibox-tools">
                                              <a class="collapse-link">
                                                  <i class="fa fa-chevron-up"></i>
                                              </a>
                                              <a class="close-link">
                                                  <i class="fa fa-times"></i>
                                              </a>
                                          </div>
                                      </div>
                                      <div class="ibox-content">
                                          <table class="table table-hover no-margins">
                                              <thead>
                                              <tr>
                                                  <th>Drug</th>
                                                  <th>Date</th>
                                              </tr>
                                              </thead>
                                              <tbody>
                                                  @if($medication)
                                                  @foreach($medication as $med)
                                              <tr>
                                                <td>{{$med->drugname}}</td>
                                                <td>{{$med->dosage}}</td>
                                                <td>{{$med->med_date}}</td>
                                              </tr>
                                              @endforeach
                                              @else
                                              <tr>
                                              <td class="text-navy">No Data Available </td>
                                              </tr>
                                              @endif
                                              </tbody>
                                          </table>
                                      </div>
                                  </div>
                              </div>
                              <div class="col-lg-4">
                                  <div class="ibox float-e-margins">
                                      <div class="ibox-title">
                                          <h5>Surgical Procedures</h5>
                                          <div class="ibox-tools">
                                              <a class="collapse-link">
                                                  <i class="fa fa-chevron-up"></i>
                                              </a>
                                              <a class="close-link">
                                                  <i class="fa fa-times"></i>
                                              </a>
                                          </div>
                                      </div>
                                      <div class="ibox-content">
                                          <table class="table table-hover no-margins">
                                              <thead>
                                              <tr>
                                                  <th>Procedure</th>
                                                  <th>Date</th>
                                              </tr>
                                              </thead>
                                              <tbody>

                                                      @foreach($surgery as $procd)
                                               <tr>
                                                  <td>{{$procd->name_of_surgery}}</td>
                                                  <td>{{$procd->surgery_date}}</td>
                                              </tr>
                                              @endforeach

                                              </tbody>
                                          </table>
                                      </div>
                                  </div>
                              </div>
                              <div class="col-lg-8">
                              <div class="col-lg-6">
                                  <div class="ibox float-e-margins">
                                      <div class="ibox-title">
                                          <h5>Chronic Disease</h5>
                                          <div class="ibox-tools">
                                              <a class="collapse-link">
                                                  <i class="fa fa-chevron-up"></i>
                                              </a>
                                              <a class="close-link">
                                                  <i class="fa fa-times"></i>
                                              </a>
                                          </div>
                                      </div>
                                      <div class="ibox-content">
                                          <ul class="todo-list m-t small-list">
                                            @if($chronics)
                                            @foreach($chronics as $chro)
                                            <li>{{$chro->name}}</li>
                                            @endforeach
                                            @else
                                            <li>No Data Available</li>
                                            @endif
                                          </ul>
                                      </div>
                                  </div>
                              </div>
                              <div class="col-lg-6">
                                  <div class="ibox float-e-margins">
                                      <div class="ibox-title">
                                          <h5>Patient Allergies</h5>
                                          <div class="ibox-tools">
                                              <a class="collapse-link">
                                                  <i class="fa fa-chevron-up"></i>
                                              </a>
                                              <a class="close-link">
                                                  <i class="fa fa-times"></i>
                                              </a>
                                          </div>
                                      </div>
                                      <div class="ibox-content">
                                          <ul class="todo-list m-t small-list">
                                                @if($allergies)
                                                @foreach($allergies as $alleg)
                                                <li>{{$alleg->name}}</li>
                                                @endforeach
                                                @else
                                                <li>No Data Available</li>
                                                @endif

                                          </ul>
                                      </div>
                                  </div>
                              </div>
                          </div>
                          <div class="col-lg-8">
                              <div class="ibox float-e-margins">
                                  <div class="ibox-title">
                                      <h5>Vaccination Details</h5>
                                      <div class="ibox-tools">
                                          <a class="collapse-link">
                                              <i class="fa fa-chevron-up"></i>
                                          </a>
                                          <a class="close-link">
                                              <i class="fa fa-times"></i>
                                          </a>
                                      </div>
                                  </div>
                                  <div class="ibox-content">
                                <table class="table table-hover no-margins">
                                            <thead>
                                            <tr>
                                                <th>Disease</th>
                                                <th>Vaccine Name</th>
                                                <th>Date</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                              @if($vaccines)
                                              @foreach($vaccines as $vac)
                                            <tr>
                                                <td>{{$vac->disease}}</td>
                                                <td>{{$vac->vaccine_name}}</td>
                                                  <td>{{$vac->yesdate}}</td>
                                            </tr>
                                            @endforeach
                                            @else
                                            <tr>
                                            <td class="text-navy">No Data Available </td>
                                            </tr>
                                            @endif
                                            </tbody>
                                        </table>

                                  </div>
                              </div>
                          </div>
</div></div>





<div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-4">
                    <h2>Actions</h2>
                    <ol class="breadcrumb">
                        <li>
                            <a href="index.html">Home</a>
                        </li>

                        <li class="active">
                            <strong>Patient Details</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-6">
                    <div class="title-action">
                      <a href="{{ route('registrar.RegUpHist',$pat) }}" class="btn btn-primary"><i class="fa fa-print"></i> Edit Details </a>
                      <a href="{{ url('registrar.shows',$pat) }}" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Back </a>
                        <!-- <a href="invoice_print.html" target="_blank" class="btn btn-primary"><i class="fa fa-print"></i> Print Invoice </a> -->
                    </div>
                </div>
            </div>
</div>
@endsection
    @section('script-reg')

            @endsection
