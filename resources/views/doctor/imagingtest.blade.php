<!-- Imaging Tests starts}} -->
<div class="col-lg-12">
    <div class="tabs-container">
        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#tab-90">X-RAY</a></li>
            <li class=""><a data-toggle="tab" href="#tab-91">CT SCAN</a></li>
            <li class=""><a data-toggle="tab" href="#tab-92">MRI</a></li>
            <li class=""><a data-toggle="tab" href="#tab-93">ULTRASOUND</a></li>
        </ul>
<div class="tab-content">
    <div id="tab-90" class="tab-pane active">
        <div class="panel-body">
          {{ Form::open(array('route' => array('Radtest'),'method'=>'POST')) }}
          <!--.......................... X-RAY...................................-->
            <div class="col-sm-6 b-r">
              <div class="form-group ">
              <label for="d_list2">Clinical Information:</label>
              <textarea rows="4" name="cixray" cols="50" placeholder="reason for test" class="form-control"></textarea>
              </div>
       </div>
            <div class="col-sm-6">
             <div class="form-group">
                <label for="tag_list" class="">X-RAY TESTS:</label>
                <select class="test-multiple" name="xray[]" multiple="multiple" style="width: 100%">
                <?php $xray=DB::table('xray')->get(); ?>
                @foreach($xray as $xy)
                <option value='{{$xy->id}}'>{{$xy->name}}</option>
                @endforeach
                </select>
                </div>
                <div class="form-group">
                   <label for="tag_list" class="">X-Ray Target:</label>
                   <select class="test-multiple" name="xraytarget"  style="width: 100%">
                  <option value=''>Choose one ...</option>
                <option value='Left'>LEFT</option>
                <option value='Right'>Right</option>
                <option value='Both'>Both</option>
                   </select>
                   </div>
              </div>

    </div>
</div>
<!--.......................... CT Scan...................................-->
  <div id="tab-91" class="tab-pane">
        <div class="panel-body">
          <div class="col-sm-6 b-r">
            <div class="form-group ">
            <label for="d_list2">Clinical Information:</label>
            <textarea rows="4" name="cict" cols="50" placeholder="i.e Female 45yrs. History of Headach" class="form-control"></textarea>
            </div>
     </div>
          <div class="col-sm-6">
           <div class="form-group">
              <label for="tag_list" class="">CT-SCAN TESTS:</label>
              <select class="test-multiple" name="ctscan[]" multiple="multiple" style="width: 100%">
              <?php $ctscan=DB::table('ct_scan') ->get(); ?>
              @foreach($ctscan as $cts)
              <option value='{{$cts->id}}'>{{$cts->name}}</option>
              @endforeach
              </select>
              </div>
              <div class="form-group">
                 <label for="tag_list" class="">Ct-Scan Target:</label>
                 <select class="test-multiple" name="cttarget"  style="width: 100%">
                <option value=''>Choose one ...</option>
              <option value='Left'>LEFT</option>
              <option value='Right'>Right</option>
              <option value='Both'>Both</option>
                 </select>
                 </div>
            </div>
    </div>
</div>
<!--.......................... MRI...................................-->
    <div id="tab-92" class="tab-pane">
        <div class="panel-body">
          <div class="col-sm-6 b-r">
            <div class="form-group ">
            <label for="d_list2">Clinical Information:</label>
            <textarea rows="4" name="cimri" cols="50" placeholder="reason for test" class="form-control"></textarea>
            </div>
     </div>
          <div class="col-sm-6">
           <div class="form-group">
              <label for="tag_list" class="">MRI TESTS:</label>
              <select class="test-multiple" name="mri[]" multiple="multiple" style="width: 100%">
              <?php $mri=DB::table('mri_tests') ->get(); ?>
              @foreach($mri as $mriz)
              <option value='{{$mriz->id}}'>{{$mriz->name}}</option>
              @endforeach
              </select>
              </div>
              <div class="form-group">
                 <label for="tag_list" class="">MRI Target:</label>
                 <select class="test-multiple" name="mritarget"  style="width: 100%">
                <option value=''>Choose one ...</option>
              <option value='Left'>LEFT</option>
              <option value='Right'>Right</option>
              <option value='Both'>Both</option>
                 </select>
                 </div>
            </div>
      </div>
  </div>
<!--.......................... Ultrasound...................................-->
  <div id="tab-93" class="tab-pane">
      <div class="panel-body">
        <div class="col-sm-6 b-r">
          <div class="form-group ">
          <label for="d_list2">Clinical Information:</label>
          <textarea rows="4" name="ciultra" cols="50" placeholder="reason for test" class="form-control"></textarea>
          </div>
   </div>
        <div class="col-sm-6">
         <div class="form-group">
            <label for="tag_list" class="">ULTRASOUND TESTS:</label>
            <select class="test-multiple" name="ultra[]" multiple="multiple" style="width: 100%">
            <?php $ultra=DB::table('ultrasound') ->get(); ?>
            @foreach($ultra as $xyu)
            <option value='{{$xyu->id}}'>{{$xyu->name}}</option>
            @endforeach
            </select>
            </div>
            <div class="form-group">
               <label for="tag_list" class="">X-Ray Target:</label>
               <select class="test-multiple" name="ultratarget"  style="width: 100%">
              <option value=''>Choose one ...</option>
            <option value='Left'>LEFT</option>
            <option value='Right'>Right</option>
            <option value='Both'>Both</option>
               </select>
               </div>
          </div>
    </div>
</div>


{{ Form::hidden('appointment_id',$app_id, array('class' => 'form-control')) }}
{{ Form::hidden('ct_catid',9, array('class' => 'form-control')) }}
{{ Form::hidden('xray_catid',10, array('class' => 'form-control')) }}
{{ Form::hidden('mri_catid',11, array('class' => 'form-control')) }}
{{ Form::hidden('ultra_catid',12, array('class' => 'form-control')) }}
    <button class=" mtop btn btn-sm btn-primary pull-left m-t-n-xs" type="submit"><strong>Submit</strong></button>

    {{ Form::close() }}
          </div>


      </div>
   </div>
<!--.......................... Imaging Tests Ends...................................-->
