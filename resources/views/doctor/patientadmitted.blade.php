@extends('layouts.doctor')
  @section('content')
            <?php
            $doc = (new \App\Http\Controllers\DoctorController);
            $Docdatas = $doc->DocDetails();
            foreach($Docdatas as $Docdata){
            $Did = $Docdata->id;
            $Name = $Docdata->name;
          }

            if ( empty ($Name ) ) {
            // return view('doctor.create');

            return redirect('doctor.create');
            }
            ?>

  <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-11">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Patients List</h5>
                        <div class="ibox-tools">
                          @role('Doctor')
                           <a class="collapse-link">
                            {{$Name}}
                          </a>  @endrole
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                <i class="fa fa-wrench"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-user">

                                <li><a href="#">Config option 1</a>
                                </li>
                                <li><a href="#">Config option 2</a>
                                </li>
                            </ul>
                            <a class="close-link">
                                <i class="fa fa-times"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">
                       <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover dataTables-main" >
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Chief Complaint</th>
                            <th>Gender</th>
                            <th>Age</th>
                            <th>Facility</th>
                            <th>Date Admitted</th>
                          </tr>
                    </thead>

                    <tbody>
                      <?php $i =1; ?>
                   @foreach($patients as $apatient)

                          <?php
                          if ($apatient->persontreated=='Self') {
                             $dob=$apatient->dob;
                             $gender=$apatient->gender;
                           }else {
                            $dob=$apatient->Infdob;
                            $gender=$apatient->Infgender;
                          }
                            $interval = date_diff(date_create(), date_create($dob));
                           $age= $interval->format(" %Y Year, %M Months, %d Days Old");

                           ?>

                          @if ($apatient->persontreated=='Self')
                          <tr>
                            <td><a href="{{route('showPatient',$apatient->appid)}}">{{$i}}</a></td>
                            <td><a href="{{route('showPatient',$apatient->appid)}}">{{$apatient->firstname}}  {{$apatient->secondName}}</a></td>
                            <td><a href="{{route('showPatient',$apatient->appid)}}">{{$apatient->chief_compliant}}</a></td>
                            <td>{{$gender}}</td>
                            <td>{{$age}}</td>
                            <td>{{$apatient->FacilityName}}</td>
                            <td>{{$apatient->date_admitted}}</td>

                          </tr>

                              @else
                            <tr>
                              <td><a href="{{route('showPatient',$apatient->appid)}}">{{$i}}</a></td>
                              <td><a href="{{route('showPatient',$apatient->appid)}}">{{$apatient->Infname}} {{$apatient->InfName}}</a></td>
                              <td><a href="{{route('showPatient',$apatient->appid)}}">{{$apatient->Infcompliant}}</a></td>
                              <td>{{$gender}}</td>
                              <td>{{$age}}</td>
                              <td></td>
                            </tr>
                                @endif
                                <!-- <td>{{$apatient->Constituency}}</td> -->


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
       @include('includes.default.footer')


@endsection
