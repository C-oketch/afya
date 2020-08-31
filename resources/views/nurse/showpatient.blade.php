@extends('layouts.nurse')
@section('title', 'Patient Details')
@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
     <div class="row">
    <div class="col-lg-6">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Patient Details</h5>

            </div>

            <div class="ibox-content">
              <form class="form-horizontal" role="form" method="POST" action="/updateuser" novalidate>
             <input type="hidden" name="_token" value="{{ csrf_token() }}">
             <input type="hidden" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="{{$patient->id}}" name="id"  required>
              <div class="form-group">
             <label for="exampleInputEmail1">Name</label>
             <input type="name" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Next Kin Name" name="kin_name"  value="{{$patient->firstname}}  {{$patient->secondName}}" readonly=""  >
             </div>


              <div class="form-group">
             <label for="exampleInputPassword1">Age</label>
             <input type="number" class="form-control" id="exampleInputPassword1" placeholder="Next of Kin Phone" name="phone" value="{{$patient->age}}" readonly  >
             </div>
             <div class="form-group">
            <label for="exampleInputPassword1">Blood Group</label>
            <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Blood Group" name="blood_type" value="{{$patient->blood_type or ''}}" readonly  >
            </div>
             <div class="form-group">
            <label for="exampleInputPassword1">Gender</label>
             <?php $gender=$patient->gender;?>
            <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Next of Kin Phone" name="phone"
             value="@if($gender==1){{"Male"}}@else{{"Female"}}@endif " readonly  >
            </div>
            <div class="form-group">
           <label for="exampleInputPassword1">Phone</label>
           <input type="number" class="form-control" id="exampleInputPassword1" placeholder="" name="phone" value="{{$patient->msisdn}}" readonly=""/>
           </div>
           <div class="form-group">
          <label for="exampleInputPassword1">Constituency</label>
          <input type="text" class="form-control" id="exampleInputPassword1" placeholder="" name="phone" value="<?php
          if ($patient->constituency != "") {$county=DB::Table('constituency')->where('id',$patient->constituency)->first();
          echo $county->Constituency;}
          else{ echo "";} ?>" readonly=""/>
          </div>
          <div class="form-group">
         <label for="exampleInputPassword1">County</label>
         <input type="text" class="form-control" id="exampleInputPassword1" placeholder="" name="phone" value="<?php
         if ($patient->constituency != "") {$county=DB::Table('county')->where('id',$county->cont_id)->first();
         echo $county->county;}
         else{ echo "";} ?>" readonly=""/>
         </div>



            </div>
          </div>
        </div>
    <div class="col-lg-6">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Next of Kin Details</h5>

            </div>
            <div class="ibox-content">
                  @if(is_null($kin))
                  <form class="form-horizontal" role="form" method="POST" action="/nextkin" novalidate>
                 <input type="hidden" name="_token" value="{{ csrf_token() }}">
                 <input type="hidden" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="{{$patient->id}}" name="id"  required>
                  <div class="form-group">
                 <label for="exampleInputEmail1">Name</label>
                 <input type="name" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Next Kin Name" name="kin_name"  value="
                  "  >
                 </div>

                 <div class="form-group">
                  <label for="exampleInputPassword1">Relationship</label>
                 <select class="form-control" name="relationship">
                 <?php  $kin = DB::table('kin')->get();?>
                               @foreach($kin as $kn)
                                <option value="{{$kn->id}}">{{$kn->relation}}</option>
                              @endforeach
                             </select>
                 </div>
                  <div class="form-group">
                 <label for="exampleInputPassword1">Phone</label>
                 <input type="number" class="form-control" id="exampleInputPassword1" placeholder="Next of Kin Phone" name="phone" value=""  >
                 </div>

                    {!! Form::close() !!}
                @else
                  <form class="form-horizontal">
                <div class="form-group">
                <label for="exampleInputEmail1">Name</label>
                <input type="name" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Next Kin Name" name="kin_name" value="{{$kin->kin_name}}" readonly="">
                </div>

                <div class="form-group">
                <label for="exampleInputPassword1">Relationship</label>
                <input type="name" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Next Kin Name" name="relation"
                value="{{$kin->relation}}"  readonly="">
                </div>

                <div class="form-group">
                <label for="exampleInputPassword1">Phone</label>
                <input type="number" class="form-control" id="exampleInputPassword1" placeholder="Next of Kin Phone" name="phone"
                value="{{$kin->phone_of_kin}}"readonly="">
                </div>

                        </div>

        {!! Form::close() !!}
                @endif
            </div>
        </div>
      </div>

  <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Vaccination Details</h5>

                    </div>
                    <div class="ibox-content">


                     <table class="table table-small-font table-bordered table-striped">
                  <thead>
                      <tr>
                          <th>No</th>
                                 <th>Antigen</th>
                                <th>Vaccinations Name</th>
                                <th>Location(Facility)</th>
                                 <th>Date </th>

                                                                </tr>
                                                              </thead>

                                                              <tbody>
                                                           <?php $i =1; ?>
                                                             @foreach($vaccines as $vaccine)
                                                                  <tr>
                         <td>{{$i}}</td>
                         <td>{{$vaccine->antigen}}</td>
                         <td>{{$vaccine->vaccine_name}}</td>
                         <td>St Jude's Huruma Community Health Services</td>
                          <td>{{ date('d -m- Y', strtotime($vaccine->yesdate)) }}</td>

                         </tr>
                                                                  <?php $i++; ?>

                                                               @endforeach


                                                               </tbody>
                                                             </table>





                    </div>
                </div>
            </div>
        </div>
 <div class="row">
         <div class="col-lg-12">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                              <h5>Patient Allergy</h5>

                            </div>


        <div class="ibox-content">
        <div class="table-responsive">
      <table class="table table-striped table-bordered table-hover dataTables-example" >
      <thead>
       <tr>
      <th>No</th>
  <th>Allery Type</th>
  <th>Allery Name</th>
  </tr>
      </thead>

      <?php $i =1;  $allergies=DB::table('afya_users_allergy')
    ->Join('allergies_type','allergies_type.id','=','afya_users_allergy.allergies_type_id')
    ->Join('allergies','allergies.id','=','allergies_type.allergies_id')
    ->Select('allergies_type.name','allergies.name as Allergy')
    ->Where('afya_users_allergy.afya_user_id','=',$patient->id)
    ->get(); ?>
     <tbody>
       @foreach($allergies as $allergy)

      <tr>
      <td>{{$i}}</td>
       <td>{{$allergy->Allergy}}</td>
      <td>{{$allergy->name}}</td>
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

      <div class="row">
         <div class="col-lg-12">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                              <h5>Patient History</h5>
                              
                            </div>


        <div class="ibox-content">
        <div class="table-responsive">
      <table class="table table-striped table-bordered table-hover dataTables-example" >
      <thead>
       <tr>
           <th>No</th>
            <th>Date</th>
            <th>Time</th>
           <th>Weight</th>
           <th>Height</th>
           <th>BMI</th>
           <th>Temperature</th>
           <th>Systolic_bp</th>
           <th>Diastolic_bp</th>
           <th>Chief Compliant</th>
           <th>Observation</th>
           <th>Symptoms</th>




      </tr>
      </thead>

      <tbody>
      <?php $i =1; ?>
      @foreach($details as $detail)
       <tr>
           <td>{{$i}}</td>
             <td>{{ date('d -m- Y', strtotime($detail->updated_at)) }}</td>
            <td>{{ date('H:i:s', strtotime($detail->updated_at)) }}</td>
           <td>{{$detail->current_weight}}</td>
           <td>{{$detail->current_height}}</td>
            <td><?php $height=$detail->current_height; $weight=$detail->current_weight;
               $bmi =$weight/($height*$height);
               echo number_format($bmi, 2);
            ?></td>
           <td>{{$detail->temperature}}</td>
          <td>{{$detail->systolic_bp}}</td>
         <td>{{$detail->diastolic_bp}}</td>
         <td>{{$detail->chief_compliant}}</td>
         <td>{{$detail->observation}}</td>
         <td>{{$detail->symptoms}}</td>


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
@include('includes.default.footer')
          </div><!--content-->
      </div><!--content page-->

@endsection
