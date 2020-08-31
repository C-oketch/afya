<?php
$app_id = $appdetails->id;
$afyauserId= $user->id;
$facd = $path->facilitycode;

$labtestsD0c = DB::table('test_price')->where('facility_id',$facd)->first();
if($labtestsD0c){
$tests = DB::table('tests')
->Join('test_price', 'tests.id', '=', 'test_price.tests_id')
->Join('test_subcategories', 'tests.sub_categories_id', '=', 'test_subcategories.id')
->Join('test_categories', 'test_subcategories.categories_id', '=', 'test_categories.id')
->select('tests.id as testId','tests.name as tname','test_subcategories.name as subname',
'test_categories.name as cname')
->where('test_price.facility_id',$facd)
->get();
}else{
  $tests = DB::table('tests')
  ->Join('test_subcategories', 'tests.sub_categories_id', '=', 'test_subcategories.id')
  ->Join('test_categories', 'test_subcategories.categories_id', '=', 'test_categories.id')
  ->select('tests.id as testId','tests.name as tname','test_subcategories.name as subname',
  'test_categories.name as cname')
  ->get();

}
?>
<div class="container">
  <div class="row">
    <div class="col-md-11">
      <div class="ibox float-e-margins">
        <div class="tab" role="tabpanel">

          <!-- Tab panes -->
          <div role="tabpanel" class="tab-pane fade in active" id="Section2">
<div class="wrapper wrapper-content animated fadeInRight">
                      <div class="row">
                          <div class="col-lg-11">
                          <div class="ibox float-e-margins">
                              <div class="ibox-title">
                                  <a href="{{url('test-all',$app_id)}}" class="btn btn-primary pull-right">TEST RESULTS </a>
                                        <h4>ALL TESTS</h4>
                              </div>
                              <div class="ibox-content">
<div class="table-responsive">
<table class="table table-striped table-bordered table-hover dataTables-example" >
<thead>
  <tr>
  <th>No</th>
  <th>Tests Name</th>
  <th>Action</th>
  </tr>
  </thead>
  <tbody>
    <!-- Imaging OTHER TESTS -->
    <?php
    $i=1;?>
    <?php
 $othertestsD0c = DB::table('test_prices_other')->where('facility_id',$facd)->first();
if($othertestsD0c){
  $othertests = DB::table('other_tests')
 ->Join('test_prices_other', 'other_tests.id', '=', 'test_prices_other.other_id')
 ->where('test_prices_other.facility_id',$facd)
 ->select('other_tests.id','other_tests.name','other_tests.test_cat_id')
 ->orderBy('status', 'desc')
 ->get();
}else{
  $othertests = DB::table('other_tests')
 ->select('id','name','test_cat_id')
 ->orderBy('status', 'desc')
 ->get();
}


    ?>
    @foreach ($othertests as $other)
    <tr class="item{{$other->id}}">
        <td>{{$other->id}}</td>
        <td>{{$other->name}}</td>
    <?php
    $datadetails13 = DB::table('radiology_test_details')
    ->Where([['test',$other->id],
            ['appointment_id',$app_id],
            ['done',0],
            ['test_cat_id',13],
            ['deleted',0],
            ['status','=',0],
          ])
    ->first();
    ?>
    @if($datadetails13)
    <td>
      {!! Form::open(array('url' => 'doc.regRadremove','method'=>'POST')) !!}
      <input type="hidden" name="_token" value="{{ csrf_token() }}">
      <input type="hidden" class="form-control" value="{{$datadetails13->id}}" name="test" >
      <input type="hidden" class="form-control" value="{{$app_id}}" name="appointment" >
      <button type="submit" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-minus"></span>Remove</button>
      {!! Form::close() !!}

    </td>
    @else
    <td>
      {!! Form::open(array('url' => 'doc.save','method'=>'POST')) !!}
      <input type="hidden" name="_token" value="{{ csrf_token() }}">
      <input type="hidden" class="form-control" value="{{$other->id}}"  name="test" >
      <input type="hidden" class="form-control" value="{{$app_id}}" name="appointment" >
      <input type="hidden" class="form-control" value="{{$other->test_cat_id}}" name="cat_id" >
      <button type="submit" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-plus"></span>ADD</button></button>
      {!! Form::close() !!}


    </td>
    @endif
    </tr>
    <?php $i++;  ?>
    @endforeach
    <!-- Imaging X_RAY TESTS -->
    <?php
    $i=$i;?>
    <?php
     $xraytestsD = DB::table('test_prices_xray')
    ->where('test_prices_xray.facility_id',$facd)
    ->first();
if($xraytestsD){
  $xraytests = DB::table('xray')
  ->Join('test_prices_xray', 'xray.id', '=', 'test_prices_xray.xray_id')
  ->where('test_prices_xray.facility_id',$facd)
  ->select('xray.id','xray.name','xray.test_cat_id')
  ->orderBy('status', 'desc')
  ->get();
}else{
  $xraytests = DB::table('xray')
  ->select('id','name','test_cat_id')
  ->orderBy('status', 'desc')
  ->get();
}


    ?>
    @foreach ($xraytests as $xray)
    <tr class="item{{$xray->id}}">
        <td>{{$i}}</td>
        <td>{{$xray->name}}</td>
    <?php
    $datadetails10 = DB::table('radiology_test_details')
    ->Where([['test',$xray->id],
             ['appointment_id',$app_id],
            ['test_cat_id',10],
            ['deleted',0],
            ['status','=',0],])
    ->first();
    ?>
    @if($datadetails10)
    <td>
      {!! Form::open(array('url' => 'doc.regRadremove','method'=>'POST')) !!}
      <input type="hidden" name="_token" value="{{ csrf_token() }}">
      <input type="hidden" class="form-control" value="{{$datadetails10->id}}" name="test" >
      <input type="hidden" class="form-control" value="{{$app_id}}" name="appointment" >
      <button type="submit" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-minus"></span>Remove</button>
      {!! Form::close() !!}
    </td>
    @else
    <td>
      {!! Form::open(array('url' => 'doc.save','method'=>'POST')) !!}
      <input type="hidden" name="_token" value="{{ csrf_token() }}">
      <input type="hidden" class="form-control" value="{{$xray->id}}"  name="test" >
      <input type="hidden" class="form-control" value="{{$app_id}}" name="appointment" >
      <input type="hidden" class="form-control" value="{{$xray->test_cat_id}}" name="cat_id" >
      <button type="submit" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-plus"></span>ADD</button></button>
      {!! Form::close() !!}
    </td>
    @endif
    </tr>
    <?php $i++;  ?>
    @endforeach
    <!-- Imaging MRI TESTS -->
    <?php
    $i=$i;?>
    <?php
     $mritestsD = DB::table('test_prices_mri')
    ->where('facility_id',$facd)
    ->first();
if($mritestsD){
  $mritests = DB::table('mri_tests')
  ->Join('test_prices_mri', 'mri_tests.id', '=', 'test_prices_mri.mri_id')
  ->select('mri_tests.id','mri_tests.name','mri_tests.test_cat_id')
  ->where('test_prices_mri.facility_id',$facd)
  ->orderBy('status', 'desc')
  ->get();
}else{
  $mritests = DB::table('mri_tests')
  ->select('id','name','test_cat_id')
  ->orderBy('status', 'desc')
  ->get();
}

     ?>
    @foreach ($mritests as $mri)
    <tr class="item{{$mri->id}}">
        <td>{{$i}}</td>
        <td>{{$mri->name}}</td>
    <?php
    $datadetails11= DB::table('radiology_test_details')
    ->Where([['test',$mri->id],
            ['appointment_id',$app_id],
            ['test_cat_id',11],
            ['deleted',0],
            ['status','=',0],])
    ->first();
    ?>
    @if($datadetails11)
    <td>
      <td>
        {!! Form::open(array('url' => 'doc.regRadremove','method'=>'POST')) !!}
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" class="form-control" value="{{$datadetails11->id}}" name="test" >
        <input type="hidden" class="form-control" value="{{$app_id}}" name="appointment" >
        <button type="submit" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-minus"></span>Remove</button>
        {!! Form::close() !!}
      </td>
    </td>
    @else
    <td>
      {!! Form::open(array('url' => 'doc.save','method'=>'POST')) !!}
      <input type="hidden" name="_token" value="{{ csrf_token() }}">
      <input type="hidden" class="form-control" value="{{$mri->id}}"  name="test" >
      <input type="hidden" class="form-control" value="{{$app_id}}" name="appointment" >
      <input type="hidden" class="form-control" value="{{$mri->test_cat_id}}" name="cat_id" >
      <button type="submit" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-plus"></span>ADD</button></button>
      {!! Form::close() !!}
    </td>
    @endif
    </tr>
    <?php $i++;  ?>
    @endforeach
    <!-- Imaging ULTRASOUND TESTS -->
    <?php
    $i=$i;?>
    <?php
      $ultrasoundD = DB::table('test_prices_ultrasound')->where('facility_id',$facd)->first();

if($ultrasoundD){
  $ultrasound = DB::table('ultrasound')
->Join('test_prices_ultrasound', 'ultrasound.id', '=', 'test_prices_ultrasound.ultrasound_id')
->select('ultrasound.id','ultrasound.name','ultrasound.test_cat_id')
->where('test_prices_ultrasound.facility_id',$facd)
->orderBy('status', 'desc')->get();
}else{
  $ultrasound = DB::table('ultrasound')
->select('id','name','test_cat_id')
->orderBy('status', 'desc')
->get();
}


     ?>
    @foreach ($ultrasound as $ultra)
    <tr class="item{{$ultra->id}}">
        <td>{{$i}} </td>
        <td>{{$ultra->name}}</td>
    <?php
    $datadetails12 = DB::table('radiology_test_details')
    ->Where([['test',$ultra->id],
            ['appointment_id',$app_id],
            ['test_cat_id',12],
            ['deleted',0],
            ['status','=',0],])
    ->first();
    ?>
    @if($datadetails12)
    <td>
      <td>
        {!! Form::open(array('url' => 'doc.regRadremove','method'=>'POST')) !!}
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" class="form-control" value="{{$datadetails12->id}}" name="test" >
        <input type="hidden" class="form-control" value="{{$app_id}}" name="appointment" >
        <button type="submit" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-minus"></span>Remove</button>
        {!! Form::close() !!}
      </td>
    </td>
    @else
    <td>
    {!! Form::open(array('url' => 'doc.save','method'=>'POST')) !!}
      <input type="hidden" name="_token" value="{{ csrf_token() }}">
      <input type="hidden" class="form-control" value="{{$ultra->id}}"  name="test" >
      <input type="hidden" class="form-control" value="{{$app_id}}" name="appointment" >
      <input type="hidden" class="form-control" value="{{$ultra->test_cat_id}}" name="cat_id" >
      <button type="submit" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-plus"></span>ADD</button></button>
      {!! Form::close() !!}
    </td>
    @endif
    </tr>
    <?php $i++;  ?>
    @endforeach
    <!-- Imaging CTSCAN TESTS -->
    <?php
    $i=$i;?>
    <?php
      $ctscanD = DB::table('test_prices_ct_scan')
    ->where('.facility_id',$facd)
    ->first();
if($ctscanD){
  $ctscan = DB::table('ct_scan')
->Join('test_prices_ct_scan', 'ct_scan.id', '=', 'test_prices_ct_scan.ct_scan_id')
->select('ct_scan.id','ct_scan.name','ct_scan.test_cat_id')
->where('test_prices_ct_scan.facility_id',$facd)
->orderBy('status', 'desc')->get();

}else{
  $ctscan = DB::table('ct_scan')
->select('id','name','test_cat_id')
->orderBy('status', 'desc')
->get();

}



    ?>
    @foreach ($ctscan as $cts)
    <tr class="item{{$cts->id}}">
        <td>{{$i}}</td>
        <td>{{$cts->name}}</td>
    <?php
    $datadetails9 = DB::table('radiology_test_details')
    ->Where([['test',$cts->id],
            ['appointment_id',$app_id],
            ['test_cat_id',9],
            ['deleted',0],
            ['status','=',0],])
    ->first();
    ?>
    @if($datadetails9)
    <td>
      <td>
        {!! Form::open(array('url' => 'doc.regRadremove','method'=>'POST')) !!}
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" class="form-control" value="{{$datadetails9->id}}" name="test" >
        <input type="hidden" class="form-control" value="{{$app_id}}" name="appointment" >
        <button type="submit" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-minus"></span>Remove</button>
        {!! Form::close() !!}
      </td>
    </td>
    @else
    <td>
      {!! Form::open(array('url' => 'doc.save','method'=>'POST')) !!}
      <input type="hidden" name="_token" value="{{ csrf_token() }}">
      <input type="hidden" class="form-control" value="{{$cts->id}}" name="test" >
      <input type="hidden" class="form-control" value="{{$app_id}}" name="appointment" >
      <input type="hidden" class="form-control" value="{{$cts->test_cat_id}}" name="cat_id" >
      <button type="submit" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-plus"></span>ADD</button></button>

      {!! Form::close() !!}

    </td>
    @endif
    </tr>
    <?php $i++;  ?>
    @endforeach
 <!-- LAB TESTS -->
  <?php
  $i=$i;?>
  @foreach ($tests as $tsts)
  <tr class="item{{$tsts->testId}}">
  <td>{{$i}}</td>
  <td>{{$tsts->tname}}</td>

  <?php
  $datadetailsl = DB::table('patient_test_details')
  ->Where([['tests_reccommended',$tsts->testId],
  ['appointment_id',$app_id],
  ['deleted',0],
  ['status',0],])
  ->first();
  ?>

  @if($datadetailsl)
  <td>
  {!! Form::open(array('url' => 'doc.labremove','method'=>'POST')) !!}
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" class="form-control" value="{{$datadetailsl->id}}" name="ptd_id" >
    <input type="hidden" class="form-control" value="{{$app_id}}" name="appointment_id" >
    <button type="submit" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-minus"></span>Remove</button>
    {!! Form::close() !!}
  </td>
  @else
  <td>
  {!! Form::open(array('url' => 'doc.savelab','method'=>'POST')) !!}
  <input type="hidden" name="_token" value="{{ csrf_token() }}">
  <input type="hidden" class="form-control" value="{{$tsts->testId}}" name="test_id" >
  <input type="hidden" class="form-control" value="{{$app_id}}" name="appointment_id" >
  <button type="submit" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-plus"></span>ADD</button></button>
  {!! Form::close() !!}
</td>
  @endif
  </tr>
  <?php $i++;  ?>
  @endforeach

  </tbody>
  </table>
  </div>
</div>
</div>
</div>
</div>
</div>
