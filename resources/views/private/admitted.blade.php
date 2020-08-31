@extends('layouts.doctor_layout')
@section('title', 'Dashboard')
@section('content')


@section('leftmenu')
@include('includes.doc_inc.leftmenu')
@endsection
  <div class="content-page  equal-height">

      <div class="content">
          <div class="container">

            <div class="wrapper wrapper-content animated fadeInRight">
                      <div class="row">
                          <div class="col-lg-11">
                          <div class="ibox float-e-margins">
                              <div class="ibox-title">

                                  <div class="ibox-tools">
                                  </div>
                              </div>
                              <div class="ibox-content">

                              <div class="table-responsive">
                              <table class="table table-striped table-bordered table-hover dataTables-example" >
                                <thead>
                                  <tr>
                                      <th>No</th>
                                      <th>Name</th>
                                      <th>File No</th>
                                      <th>Gender</th>
                                      <th>Age</th>
                                      <th>Date</th>
                                  
                                </tr>
                              </thead>

                              <tbody>
                                  <?php $i =1; ?>
                               @foreach($patients as $patient)
                    <tr>
                            <td>{{$i}}</td>
                            <td>{{$patient->firstname}} {{$patient->secondName}}</td>
                            <td>{{$patient->file_no}}</td>
                            <td>{{$patient->gender}}</td>
                            <td>
                              <?php
                                  $dob=$patient->dob;
                                  if($dob){
                                  $interval = date_diff(date_create(), date_create($dob));
                                  $age= $interval->format(" %Y Year, %M Months, %d Days Old");
                                }else{
                                  $age=$patient->age;
                                }
                                ?>
                                {{$age}}
                             </td>
                              <td>{{$patient->date_admitted}}</td>

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
@include('includes.default.footer')
          </div><!--content-->
      </div><!--content page-->

@endsection
