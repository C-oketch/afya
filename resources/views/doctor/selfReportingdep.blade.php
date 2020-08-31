@extends('layouts.doctor')
@section('title', 'Your Fees')
@section('content')
  <div class="content-page  equal-height">
      <div class="content">
          <div class="container">
            <?php
            $doc = (new \App\Http\Controllers\DoctorController);
            $Docdatas = $doc->DocDetails();
            foreach($Docdatas as $Docdata){
            $Did = $Docdata->id;
            $Name = $Docdata->name;
          }

            ?>



  <div class="wrapper wrapper-content animated fadeInRight white-bg">
            <div class="row">
              <div class="col-lg-11">
                <div class="ibox float-e-margins">
                  <div class="ibox-title">
                  <?php

                $name = $patients->Infname." ".$patients->InfName;
                 $gender=$patients->Infgender;
                 $dob=$patients->Infdob;
                  $interval = date_diff(date_create(), date_create($dob));
                  $age= $interval->format(" %Y Ys, %M Ms, %d Ds Old");

                    ?>
                  <div class="col-lg-6">
                    <h4>Name : {{$name}}</h4>
                    <h4>Gender : {{$gender}}</h4>
                    <h4>Age : {{$age}}</h4>

                  </div>
                  <div class="col-lg-6">
                  <ol class="breadcrumb">
                  <li class="active"><strong>Doctor : {{$Name}} </strong></li>
                  </ol>
                  </div>
                  </div>
                    </div>

  <div class="ibox float-e-margins">
                     <div class="ibox-title">
                         <h5>Self Reporting</h5>
                         <div class="ibox-tools">

                         </div>
                     </div>
                       <div class="ibox-content">
                           <div class="row">
                              <div class="col-sm-6 b-r"><h3 class="m-t-none m-b"></h3>
                                <form class="form-horizontal">
                                 <br /><br />
                                       <div class="form-group"><label class="col-lg-3 control-label">Temperature</label>
                                            <div class="col-lg-6">
                                          <input type="text" value="{{$patients->temperature}}" class="form-control" readonly ></div>
                                       </div>
                                      <div class="form-group"><label class="col-lg-3 control-label">Weight</label>
                                            <div class="col-lg-6">
                                          <input type="text" value="{{$patients->weight}}" class="form-control" readonly ></div>
                                       </div>
                                       <div class="form-group"><label class="col-lg-3 control-label">Irritable</label>
                                             <div class="col-lg-6">
                                           <input type="text" value="{{$patients->irritable}}" class="form-control" readonly ></div>
                                        </div>
                                        <div class="form-group"><label class="col-lg-3 control-label">Reduced Movement</label>
                                              <div class="col-lg-6">
                                            <input type="text" value="{{$patients->reduced_movement}}" class="form-control" readonly ></div>
                                         </div>
                                         <div class="form-group"><label class="col-lg-3 control-label">Difficulty Breathing</label>
                                               <div class="col-lg-6">
                                             <input type="text" value="{{$patients->difficulty_breathing}}" class="form-control" readonly ></div>
                                          </div>
                                          <div class="form-group"><label class="col-lg-3 control-label">Diarrhoea</label>
                                                <div class="col-lg-6">
                                              <input type="text" value="{{$patients->diarrhoea}}" class="form-control" readonly ></div>
                                           </div>
                                           <div class="form-group"><label class="col-lg-3 control-label">Vomiting</label>
                                                 <div class="col-lg-6">
                                               <input type="text" value="{{$patients->vomiting}}" class="form-control" readonly ></div>
                                            </div>

                                   </form>
                               </div>

                               <div class="col-sm-6"><h4></h4>
                                 <form class="form-horizontal">
                                  <br /><br />
                                  <div class="form-group"><label class="col-lg-4 control-label">Difficult Feeding</label>
                                       <div class="col-lg-6">
                                     <input type="text" value="{{$patients->difficult_feeding}}" class="form-control" readonly ></div>
                                  </div>
                                  <div class="form-group"><label class="col-lg-4 control-label">Convulsion</label>
                                       <div class="col-lg-6">
                                     <input type="text" value="{{$patients->convulsion}}" class="form-control" readonly ></div>
                                  </div>
                                  <div class="form-group"><label class="col-lg-4 control-label">Partial Focal fits</label>
                                       <div class="col-lg-6">
                                     <input type="text" value="{{$patients->partial_focalfits}}" class="form-control" readonly ></div>
                                  </div>
                                  <div class="form-group"><label class="col-lg-4 control-label">Murmur</label>
                                       <div class="col-lg-6">
                                     <input type="text" value="{{$patients->murmur}}" class="form-control" readonly ></div>
                                  </div>
                                  <div class="form-group"><label class="col-lg-4 control-label">Gruntingr</label>
                                       <div class="col-lg-6">
                                     <input type="text" value="{{$patients->grunting}}" class="form-control" readonly ></div>
                                  </div>
                                  <div class="form-group"><label class="col-lg-4 control-label">Crackles</label>
                                       <div class="col-lg-6">
                                     <input type="text" value="{{$patients->crackles}}" class="form-control" readonly ></div>
                                  </div>
                                  <div class="form-group"><label class="col-lg-4 control-label">Cry</label>
                                       <div class="col-lg-6">
                                     <input type="text" value="{{$patients->cry}}" class="form-control" readonly ></div>
                                  </div>
                                  </form>
                               </div>


                           </div>

                       </div>




                       <div class="ibox-title">
                           <h5>Self Reporting History</h5>

                       </div>
                       <div class="ibox-content">

                           <div class="table-responsive">
                       <table class="table table-striped table-bordered table-hover dataTables-example" >
                             <thead>
                               <tr>
                                     <th>No</th>
                                     <th>Temperature</th>
                                     <th>Weight</th>
                                     <th>Irritable</th>
                                     <th>Difficulty Breathing</th>
                                     <th>Diarrhoea</th>
                                     <th>Vomiting</th>
                                     <th>Difficulty Feeding</th>
                                     <th>Convulsion</th>
                                     <th>Partial Focal FIts</th>
                                     <th>Murmur</th>
                                    <th>Reduced Movement</th>
                                    <th>Grunting</th>
                                    <th>Crackles</th>
                                    <th>Cry</th>
                                     <th>Date Submitted</th>



                                 </tr>
                             </thead>
                             <tbody>
                             <?php  $i =1;?>

                         @foreach($patH as $Hpatient)
                               <tr>
                                 <td>{{$i}}</td>
                                 <td>{{$Hpatient->temperature}}</td>
                                 <td>{{$Hpatient->weight}}</td>
                                 <td>{{$Hpatient->irritable}}</td>
                                 <td>{{$Hpatient->difficulty_breathing}}</td>
                                 <td>{{$Hpatient->diarrhoea}}</td>
                                 <td>{{$Hpatient->vomiting}}</td>
                                 <td>{{$Hpatient->difficult_feeding}}</td>
                                 <td>{{$Hpatient->convulsion}}</td>
                                 <td>{{$Hpatient->partial_focalfits}}</td>
                                 <td>{{$Hpatient->murmur}}</td>
                                 <td>{{$Hpatient->reduced_movement}}</td>
                                 <td>{{$Hpatient->grunting}}</td>
                                 <td>{{$Hpatient->crackles}}</td>
                                 <td>{{$Hpatient->cry}}</td>
                                 <td>{{$Hpatient->created_at}}</td>
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

         </div><!--container-->
      </div><!--content-->
      </div><!--content page-->

@endsection
