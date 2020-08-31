<?php


$gexam = DB::table('general_examination')->where('appointment_id',$app_id)->first();
$prem = DB::table('result_sofar')->where('appointment_id',$app_id)->first();
// dd($app_id);

?>

  <!-- General Examinations -->
  <div class="wrapper wrapper-content">
    <div class="col-lg-12">
      <div class="ibox float-e-margins">
        <div class="ibox-title">
          <h5>Examinations</h5>

        </div>
        <div class="ibox-content">
          <div class="row">
            <div class="col-sm-4 "><h3 class="m-t-none m-b"></h3>
              <form class="form-horizontal" role="form" method="POST" action="/generalExamination" novalidate>
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                {{ Form::hidden('appointment_id',$app_id, array('class' => 'form-control')) }}
                <div class="form-group"><label>General Examination</label> <input type="text" value="@if($gexam){{$gexam->g_examination}}@endif" name="g_examination" class="form-control"></div>
                <div class="form-group"><label>CVS</label> <input type="text" value="@if($gexam){{$gexam->cvs}}@endif" name="cvs" class="form-control"></div>
              </div>
              <div class="col-sm-4"><h4></h4>
                <div class="form-group"><label>RS</label> <input type="text" value="@if($gexam){{$gexam->rs}}@endif" name="rs" class="form-control"></div>
                <div class="form-group"><label>PA</label> <input type="text" value="@if($gexam){{$gexam->pa}}@endif" name="pa" class="form-control"></div>
              </div>
              <div class="col-sm-4"><h4></h4>
                <div class="form-group"><label>CNS</label> <input type="text" value="@if($gexam){{$gexam->cns}}@endif" name="cns" class="form-control"></div>
                <div class="form-group"><label>MSS</label> <input type="text" value="@if($gexam){{$gexam->mss}}@endif" name="mss" class="form-control"></div>
                <div class="form-group"><label>PERIPHERIES</label> <input type="text" value="@if($gexam){{$gexam->peripheries}}@endif" name="peripheries" class="form-control"></div>
              </div>

              <div class="form-group">
                <div class="col-lg-8"><label>Result So Far </label></div>
                <div class="col-lg-10">
                  <textarea class="form-control" rows="5"  name="results">@if($prem){{$prem->notes}}@endif</textarea>
                </div>
              </div>




              <div class="col-lg-4 col-md-offset-8">
                <button class="btn btn-sm btn-primary pull-right" type="submit"><strong>@if($gexam || $prem)UPDATE @else SUBMIT @endif</strong></button>
              </div>
              {{ Form::close() }}


            </div>
          </div>
        </div>
      </div>
    </div>
