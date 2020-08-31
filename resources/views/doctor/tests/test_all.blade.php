@extends('layouts.doctor_layout')
@section('title', 'Test')
@section('content')
<?php
use App\Http\Controllers\Controller;
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
$stat= $pdetails->status;
$afyauserId= $pdetails->afya_user_id;
$dependantId= $pdetails->persontreated;
$app_id =  $pdetails->id;
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
<div class="row wrapper border-bottom">
  <div class="float-e-margins">
    <div class="col-lg-12">
      <?php $i =1; ?>
      <div class="ibox float-e-margins">
        <div class="ibox-title">
          <h5>ALL TEST RESULTS</h5>
          <div class="ibox-tools">
            <a class="btn btn-primary"  href="{{route('alltestes',$app_id)}}"><i class="fa fa-angle-double-left"></i>&nbsp;BACK</a>
          </div>
        </div>
        <div class="ibox-content">
          <table class="table table-striped table-bordered table-hover dataTables-tests" >
            <thead>
              <tr>
                <th>No</th>
                <th>Date </th>
                <th>Test Name</th>
                <th>Action</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach($otherimaging as $other)
              <tr>
                <td>{{ +$i }}</td>
                <td>{{$other->created_at}}</td>
                <td>{{$other->tname}}</td>
                @if($other->done ==0)
                <td>
                  {{ Form::open(['method' => 'DELETE','route' => ['imaging.deletes', $other->id],'style'=>'display:inline']) }}
                  {{ Form::submit('Remove', ['class' => 'btn btn-danger btn-xs']) }}
                  {{ Form::close() }}
                </td>
                @else
                <td> Done</td>
                @endif
                <td><a class="btn btn-primary btn-xs"  href="{{route('otherReport',$other->id)}}">Results</a></td>
              </tr>
              <?php $i++; ?>
              @endforeach
              @foreach($tstdone as $tstdn)
              <?php    $ptdid =$tstdn->ptdid;
              $prescs=$tstdn->done;
              if (is_null($prescs)) {
                $prescs= 'N/A';
              }
              elseif ($prescs==0) {
                $prescs= 'Pending';
              } elseif($prescs==1) {
                $prescs= 'Complete';
              }
              ?>
              <tr>
                <td>{{$i}}</td>
                <td>{{$tstdn->created_at}}</td>
                <td>{{$tstdn->name}}</td>
                @if($tstdn->done =='0')
                <td>
                  {{ Form::open(['method' => 'DELETE','route' => ['test.deletes', $tstdn->ptdid],'style'=>'display:inline']) }}
                  {{ Form::submit('Remove', ['class' => 'btn btn-danger btn-xs']) }}
                  {{ Form::close() }}
                </td>
                @else
                <td> Done</td>
                @endif
                <td><a class="btn btn-primary btn-xs"  href="{{route('labtestReport',$ptdid)}}">Results</a></td>
              </tr>
              <?php $i++; ?>
              @endforeach
              @foreach($mri as $tstdn)
              <tr>
                <td>{{ +$i }}</td>
                <td>{{$tstdn->created_at}}</td>
                <td>{{$tstdn->tname}}</td>
                @if($tstdn->done =='0')
                <td>
                  {{ Form::open(['method' => 'DELETE','route' => ['imaging.deletes', $tstdn->id],'style'=>'display:inline']) }}
                  {{ Form::submit('Remove', ['class' => 'btn btn-danger btn-xs']) }}
                  {{ Form::close() }}
                </td>
                @else
                <td> Done</td>
                @endif
                <td><a class="btn btn-primary btn-xs"  href="{{route('mrireport',$tstdn->id)}}">Results</a></td>
              </tr>
              <?php $i++; ?>
              @endforeach
              @foreach($ct_scan as $tstdn)
              <tr>
                <td>{{ +$i }}</td>
                <td>{{$tstdn->created_at}}</td>
                <td>{{$tstdn->tname}}</td>
                @if($tstdn->done =='0')
                <td>
                  {{ Form::open(['method' => 'DELETE','route' => ['imaging.deletes', $tstdn->id],'style'=>'display:inline']) }}
                  {{ Form::submit('Remove', ['class' => 'btn btn-danger btn-xs']) }}
                  {{ Form::close() }}
                </td>
                @else
                <td> Done</td>
                @endif
                <td><a class="btn btn-primary btn-xs"  href="{{route('ctreport',$tstdn->id)}}">Results</a></td>
              </tr>
              <?php $i++; ?>
              @endforeach
              @foreach($ultrasound as $tstdn)
              <tr>
                <td>{{ +$i }}</td>
                <td>{{$tstdn->created_at}}</td>
                <td>{{$tstdn->tname}}</td>
                @if($tstdn->done =='0')
                <td>
                  {{ Form::open(['method' => 'DELETE','route' => ['imaging.deletes', $tstdn->id],'style'=>'display:inline']) }}
                  {{ Form::submit('Remove', ['class' => 'btn btn-danger btn-xs']) }}
                  {{ Form::close() }}
                </td>
                @else
                <td> Done</td>
                @endif
                <td><a class="btn btn-primary btn-xs"  href="{{route('ultrareport',$tstdn->id)}}">Results</a></td>
              </tr>
              <?php $i++; ?>
              @endforeach
              @foreach($xray as $tstdn)
              <tr>
                <td>{{ +$i }}</td>
                <td>{{$tstdn->created_at}}</td>
                <td>{{$tstdn->tname}}</td>
                @if($tstdn->done =='0')
                <td>
                  {{ Form::open(['method' => 'DELETE','route' => ['imaging.deletes', $tstdn->id],'style'=>'display:inline']) }}
                  {{ Form::submit('Remove', ['class' => 'btn btn-danger btn-xs']) }}
                  {{ Form::close() }}
                </td>
                @else
                <td> Done</td>
                @endif
                <td><a class="btn btn-primary btn-xs"  href="{{route('xrayreport',$tstdn->id)}}">Results</a></td>
              </tr>
              <?php $i++; ?>
              @endforeach

              @foreach($cardiac as $other)
              <tr>
                <td>{{ +$i }}</td>
                <td>{{$other->created_at}}</td>
                <td>{{$other->tname}}</td>
                @if($other->done ==0)
                <td>
                  {{ Form::open(['method' => 'DELETE','route' => ['cardiac.deletes', $other->id],'style'=>'display:inline']) }}
                  {{ Form::submit('Remove', ['class' => 'btn btn-danger btn-xs']) }}
                  {{ Form::close() }}
                </td>
                @else
                <td> Done</td>
                @endif
                <td><a class="btn btn-primary btn-xs"  href="{{route('cardiacReport',$other->id)}}">Results</a></td>
              </tr>
              <?php $i++; ?>
              @endforeach

              @foreach($neurology as $other)
              <tr>
                <td>{{ +$i }}</td>
                <td>{{$other->created_at}}</td>
                <td>{{$other->tname}}</td>
                @if($other->done ==0)
                <td>
                  {{ Form::open(['method' => 'DELETE','route' => ['neurology.deletes', $other->id],'style'=>'display:inline']) }}
                  {{ Form::submit('Remove', ['class' => 'btn btn-danger btn-xs']) }}
                  {{ Form::close() }}
                </td>
                @else
                <td> Done</td>
                @endif
                <td><a class="btn btn-primary btn-xs"  href="{{route('neurologyReport',$other->id)}}">Results</a></td>
              </tr>
              <?php $i++; ?>
              @endforeach

              @foreach($procedure as $other)
              <tr>
                <td>{{ +$i }}</td>
                <td>{{$other->created_at}}</td>
                <td>{{$other->tname}}</td>
                @if($other->done ==0)
                <td>
                  {{ Form::open(['method' => 'DELETE','route' => ['procedure.deletes', $other->id],'style'=>'display:inline']) }}
                  {{ Form::submit('Remove', ['class' => 'btn btn-danger btn-xs']) }}
                  {{ Form::close() }}
                </td>
                @else
                <td> Done</td>
                @endif
                <td><a class="btn btn-primary btn-xs"  href="{{route('procedureReport',$other->id)}}">Results</a></td>
              </tr>
              <?php $i++; ?>
              @endforeach


            </tbody>
          </table>

        </div>
      </div>

    </div><!-- col md 12" -->
  </div><!-- emargis" -->
</div>
@endsection
@section('script-test')
<!-- Page-Level Scripts -->
<script src="{{ asset('js/tests.js') }}"></script>
@endsection
