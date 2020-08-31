@extends('layouts.doctor_layout')
@section('title', 'Self Report')
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

                  $name = $patients->firstname." ".$patients->secondName;
                  $gender=$patients->gender;
                  $dob=$patients->dob;
                  if($gender==1){$gender ="Male";}else{$gender ="Female";}
                  $interval = date_diff(date_create(), date_create($dob));
                  $age= $interval->format(" %Y Ys, %M Ms, %d Ds Old");

                    ?>
                  <div class="col-lg-6">
                    <h4>Name : {{$name}}</h4>
                    <h4>Gender : {{$gender}}</h4>
                    <h4>Age : {{$age}}</h4>

                  </div>
                  <div class="col-lg-6 text-right">
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
                                  <h4>Current patient Triage Readings</h4>
                                 <br /><br />
                                       <div class="form-group"><label class="col-lg-4 control-label">Temperature</label>
                                            <div class="col-lg-6">
                                          <input type="text" value="{{$patients->temperature}}" class="form-control" readonly ></div>
                                       </div>
                                       <div class="form-group"><label class="col-lg-4 control-label">BP</label>
                                            <div class="col-lg-6">
                                          <input type="text" value="{{$patients->bp}}" class="form-control" readonly ></div>
                                       </div>
                                       <div class="form-group"><label class="col-lg-4 control-label">Weight</label>
                                            <div class="col-lg-6">
                                          <input type="text" value="{{$patients->weight}}" class="form-control" readonly ></div>
                                       </div>
                                       <div class="form-group"><label class="col-lg-4 control-label">Fasting Sugars</label>
                                            <div class="col-lg-6">
                                          <input type="text" value="{{$patients->fasting_sugars}}" class="form-control" readonly ></div>
                                       </div>
                                       <div class="form-group"><label class="col-lg-4 control-label">Before Meals Sugar</label>
                                            <div class="col-lg-6">
                                          <input type="text" value="{{$patients->before_meal_sugars}}" class="form-control" readonly ></div>
                                       </div>
                                       <div class="form-group"><label class="col-lg-4 control-label">Postprondrial_sugars</label>
                                            <div class="col-lg-6">
                                          <input type="text" value="{{$patients->postprondrial_sugars}}" class="form-control" readonly ></div>
                                       </div>

                                   </form>
                               </div>

                               <div class="col-sm-6"><h4></h4>
                                   <h4>Patient Target Triage Readings</h4>
                                   @if($patientstarget)
                                 <div class="targett" id="targett">
                                  <form class="form-horizontal">
                                  <br /><br />
                                  <div class="form-group"><label class="col-lg-4 control-label">Temperature</label>
                                       <div class="col-lg-6">
                                     <input type="text" value="{{$patientstarget->temptrgt}}" class="form-control" readonly ></div>
                                  </div>
                                  <div class="form-group"><label class="col-lg-4 control-label">BP</label>
                                       <div class="col-lg-6">
                                     <input type="text" value="{{$patientstarget->bptrgt}}" class="form-control" readonly ></div>
                                  </div>
                                  <div class="form-group"><label class="col-lg-4 control-label">Weight</label>
                                       <div class="col-lg-6">
                                     <input type="text" value="{{$patientstarget->weighttrgt}}" class="form-control" readonly ></div>
                                  </div>
                                  <div class="form-group"><label class="col-lg-4 control-label">Fasting Sugars</label>
                                       <div class="col-lg-6">
                                     <input type="text" value="{{$patientstarget->fstrgt}}" class="form-control" readonly ></div>
                                  </div>
                                  <div class="form-group"><label class="col-lg-4 control-label">Before Meals Sugar</label>
                                       <div class="col-lg-6">
                                     <input type="text" value="{{$patientstarget->bmstrgt}}" class="form-control" readonly ></div>
                                  </div>
                                  <div class="form-group"><label class="col-lg-4 control-label">Postprondrial_sugars</label>
                                       <div class="col-lg-6">
                                     <input type="text" value="{{$patientstarget->ppstrgt}}" class="form-control" readonly ></div>
                                  </div>
                                  <br />

                                  </form>
                         </div><!-- Target Triage view-->
                         <div>
                         <h5>Updating Patient Targets</h5>
                         <button class="btn btn-sm btn-primary pull-right m-t-n-xs" id="targ1"><strong>Update</strong></button>
                        </div>
                                <div class="targetupdate ficha" id="targetupdate">
                                  {{ Form::open(array('route' => array('selftargetupdt'),'method'=>'POST','class'=>'form-horizontal')) }}

                                 <div class="form-group"><label class="col-lg-4 control-label">Temperature</label>
                                      <div class="col-lg-6">
                                    <input type="text" value="{{$patientstarget->temptrgt}}" name="temps" class="form-control"  required></div>
                                 </div>
                                 <div class="form-group"><label class="col-lg-4 control-label">BP</label>
                                      <div class="col-lg-6">
                                    <input type="text" value="{{$patientstarget->bptrgt}}" name="bps" class="form-control"  required></div>
                                 </div>
                                 <div class="form-group"><label class="col-lg-4 control-label">Weight</label>
                                      <div class="col-lg-6">
                                    <input type="text" value="{{$patientstarget->weighttrgt}}" name="weights" class="form-control" required ></div>
                                 </div>
                                 <div class="form-group"><label class="col-lg-4 control-label">Fasting Sugars</label>
                                      <div class="col-lg-6">
                                    <input type="text" value="{{$patientstarget->fstrgt}}" name="fastings" class="form-control"  ></div>
                                 </div>
                                 <div class="form-group"><label class="col-lg-4 control-label">Before Meals Sugar</label>
                                      <div class="col-lg-6">
                                    <input type="text" value="{{$patientstarget->bmstrgt}}" name="beforemeals"  class="form-control"  required></div>
                                 </div>
                                 <div class="form-group"><label class="col-lg-4 control-label">Postprondrial_sugars</label>
                                      <div class="col-lg-6">
                                    <input type="text" value="{{$patientstarget->ppstrgt}}" name="postprondrials" class="form-control"  required></div>
                                    <input type="hidden" value="{{$patients->afyaId}}" name="afya_user_id" class="form-control" ></div>

                                    <div>
                                      <button class="btn btn-sm btn-primary pull-right m-t-n-xs" type="submit"><strong>UPDATE</strong></button>
                                    </div>
                                 </div>
                                 </form>

                               </div><!-- Target Triage update-->
                                     @else
                                 ADD TARGET VALUES <br />
                                 <button class="btn btn-lg btn-primary" id="targAdd"><strong>ADD</strong></button>

                                 <div class="targetadd ficha" id="targetadd">
                                    {{ Form::open(array('route' => array('selftarget'),'method'=>'POST','class'=>'form-horizontal')) }}

                                  <br /><br />
                                  <div class="form-group"><label class="col-lg-4 control-label">Temperature</label>
                                       <div class="col-lg-6">
                                     <input type="text" name="temp" class="form-control" required></div>
                                  </div>
                                  <div class="form-group"><label class="col-lg-4 control-label">BP</label>
                                       <div class="col-lg-6">
                                     <input type="text" name="bp" class="form-control" required></div>
                                  </div>
                                  <div class="form-group"><label class="col-lg-4 control-label">Weight</label>
                                       <div class="col-lg-6">
                                     <input type="text" name="weight" class="form-control" required></div>
                                  </div>
                                  <div class="form-group"><label class="col-lg-4 control-label">Fasting Sugars</label>
                                       <div class="col-lg-6">
                                     <input type="text" name="fasting" class="form-control" required></div>
                                  </div>
                                  <div class="form-group"><label class="col-lg-4 control-label">Before Meals Sugar</label>
                                       <div class="col-lg-6">
                                     <input type="text" name="beforemeal" class="form-control" required></div>
                                  </div>
                                  <div class="form-group"><label class="col-lg-4 control-label">Postprondrial_sugars</label>
                                       <div class="col-lg-6">
                                     <input type="text" name="postprondrial" class="form-control" required></div>
                                     <input type="hidden" value="{{$patients->afyaId}}" name="afya_user_id" class="form-control"  ></div>
                                     <div>
                                       <button class="btn btn-sm btn-primary pull-right m-t-n-xs" type="submit"><strong>SUBMIT</strong></button>
                                     </div>
                                  </div>
                                  </form>

                                </div><!-- Target Triageadd-->
                                     @endif

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
                                     <th>BP</th>
                                     <th>Weight</th>
                                     <th>Fasting Sugars</th>
                                     <th>Before Meal Sugars</th>
                                     <th>Postprondrial Sugars</th>
                                     <th>Date Submitted</th>

                                 </tr>
                             </thead>
                             <tbody>
                             <?php  $i =1;?>

                         @foreach($patH as $Hpatient)
                               <tr>
                                 <td>{{$i}}</td>
                                 <td>{{$Hpatient->temperature}}</td>
                                 <td>{{$Hpatient->bp}}</td>
                                 <td>{{$Hpatient->weight}}</td>
                                 <td>{{$Hpatient->fasting_sugars}}</td>
                                 <td>{{$Hpatient->before_meal_sugars}}</td>
                                 <td>{{$Hpatient->postprondrial_sugars}}</td>
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


@endsection
@section('script-test')
<script>
// Add target toogle
$(document).ready(function(){
    $("#targAdd").click(function(){
        $("#targetadd").show();
         $("#targAdd").hide();
    });
});
</script>
<script>
// Add target toogle
$(document).ready(function(){
    $("#targ1").click(function(){
        $("#targetupdate").show();
         $("#targett").hide();
         $("#targ1").hide();
    });
});
</script>
@endsection
