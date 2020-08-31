@extends('layouts.doctor_layout')
@section('title', 'Test')
@section('content')
<?php
$doc = (new \App\Http\Controllers\DoctorController);
$Docdatas = $doc->DocDetails();
foreach($Docdatas as $Docdata){


$Did = $Docdata->id;
$Name = $Docdata->name;
$Address = $Docdata->address;
$RegNo = $Docdata->regno;
$RegDate = $Docdata->regdate;
$Speciality = $Docdata->speciality;
$Sub_Speciality = $Docdata->subspeciality;


}
         $stat= $patientD->status;
         $afyauserId= $patientD->afya_user_id;
          $dependantId= $patientD->persontreated;
          $app_id =  $patientD->id;
          $doc_id= $patientD->doc_id;
          $fac_id= $patientD->facility_id;
          $fac_setup= $patientD->set_up;
          $condition  = $patientD->condition;


 if ($dependantId =='Self') {
          $dob=$patientD->dob;
          $gender=$patientD->gender;
          $firstName = $patientD->firstname;
          $secondName = $patientD->secondName;
          $name =$firstName." ".$secondName;

   }else {
           $dependantId=$patientD->persontreated;
//Dependant data to be here

      }
  $interval = date_diff(date_create(), date_create($dob));
  $age= $interval->format(" %Y Year, %M Months, %d Days Old");
?>
        <!--tabs Menus-->
        @section('leftmenu')
        @include('includes.doc_inc.leftmenu2')
        @endsection
        @include('includes.doc_inc.topnavbar_test')

       <div class="wrapper wrapper-content animated fadeInRight">
                 <div class="row">
                 <div class="col-lg-12">
                     <div class="ibox float-e-margins">
                         <div class="ibox-title">
                             <h5>TEST RESULTS</h5>
                             <div class="ibox-tools">
                               <a class="btn btn-primary"  href="{{url('test-all',$app_id)}}"><i class="fa fa-angle-double-left"></i>&nbsp;BACK</a>
                             </div>
                         </div>
                         <div class="ibox-content">
                             <div class="row">
                                 <div class="col-sm-6 b-r"><h3 class="m-t-none m-b"></h3>
                                {{ Form::open(array('route' => array('doc.neurologyResult'),'method'=>'POST')) }}
                  <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                         <div class="form-group">
                                           <label>TEST:</label>
                                           <input type="text" name="radiology" value="{{$tsts1->name}}" class="form-control" readonly/>
                                         </div>

                                             <div class="form-group">
                                               <label>Results :</label></br>
                                               <textarea rows="6" name="note" cols="50">@if($tsts1){{$tsts1->results}} @endif</textarea>
                                             </div>
                                             {{ Form::hidden('cur_appointment_id',$cur_app->id, array('class' => 'form-control')) }}
                                            {{ Form::hidden('appointment_id',$app_id, array('class' => 'form-control')) }}
                                            {{ Form::hidden('rtdid',$tsts1->id, array('class' => 'form-control')) }}
                                            <div class="col-md-12">
                                            <button class=" mtop btn btn-sm btn-primary  m-t-n-xs" type="submit"><strong>Submit</strong></button>
                                            </div>

                                            {{ Form::close() }}
                                 </div>
                                 <div class="col-sm-6"><h4></h4>
                                    {!! Form::open(array('url' => 'doc.neurologyupload','files'=>true)) !!}
                              <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                 <div class="form-group"><label>Choose file:</label>
                                   <input type="file" name="image[]" multiple="multiple" class="form-control">
                                 </div>
                                 {{ Form::hidden('cur_appointment_id',$cur_app->id, array('class' => 'form-control')) }}
                                 {{ Form::hidden('rtdid',$tsts1->id, array('class' => 'form-control')) }}

                                 <div class="col-md-12">
                                 <button class=" mtop btn btn-sm btn-primary  m-t-n-xs" type="submit"><strong>Submit</strong></button>
                                 </div>

                                 {{ Form::close() }}

                                 </div>



       <div class="col-sm-6">
       <form role="form" class="form-inline">
       <?php $images=DB::table('radiology_images')->select('id','image')->where('radiology_td_id',$tsts1->id)->get();

       ?>

       <div class="ibox-content">
       <table class="table table-striped">
       <tbody>
       @foreach($images as $image)
       <tr>

       <td> <a href="{{ asset("$image->image") }} "target="_blank">View Image</a></td>
       <td><a class="btn btn-danger"  href="{{route('remove.xrayupload',$image->id)}}"> Remove </a></td>
       </tr>
       @endforeach
       </tbody>
       </table>
       </div>
       </form>
       </div>

                             </div>
                         </div>
                     </div>
                 </div>
               </div>
            </div>



@endsection
