<div class="row bs-wizard" style="border-bottom:0;">
  <?php
  $tst = DB::table('patient_test')->where('appointment_id','=', $app_id)
  ->first();
  ?>

  <?php if (is_null($tst)) {  ?>
      <div class="col-xs-3 bs-wizard-step disabled">
      <div class="text-center bs-wizard-stepnum">TEST</div>
      <div class="progress"><div class="progress-bar"></div></div>
      <a href="#" class="bs-wizard-dot"></a>
    </div>
  <?php }else{    ?>
   <div class="col-xs-3 bs-wizard-step complete">
    <div class="text-center bs-wizard-stepnum">TEST</div>
    <div class="progress"><div class="progress-bar"></div></div>
    <a href="#" class="bs-wizard-dot"></a>
    </div>
  <?php }?>
  <?php
  $diag = DB::table('patient_diagnosis')->where('appointment_id','=', $app_id)
->first();  ?>
  <?php if (is_null($diag)) {  ?>
    <div class="col-xs-3 bs-wizard-step disabled">
      <div class="text-center bs-wizard-stepnum">Diagnosis</div>
      <div class="progress"><div class="progress-bar"></div></div>
      <a href="#" class="bs-wizard-dot"></a>
    </div>
    <?php }else{    ?>
    <div class="col-xs-3 bs-wizard-step complete">
     <div class="text-center bs-wizard-stepnum">Diagnosis</div>
     <div class="progress"><div class="progress-bar"></div></div>
     <a href="#" class="bs-wizard-dot"></a>
     </div>
    <?php }    ?>



    <?php
    $presc = DB::table('prescriptions')->where('appointment_id','=', $app_id)
    ->first();?>
  <?php if (is_null($presc)) {  ?>
    <div class="col-xs-3 bs-wizard-step disabled">
      <div class="text-center bs-wizard-stepnum">PRESCRIPTIONS</div>
      <div class="progress"><div class="progress-bar"></div></div>
      <a href="#" class="bs-wizard-dot"></a>
      </div>
      <?php }else{    ?>
      <div class="col-xs-3 bs-wizard-step complete">
       <div class="text-center bs-wizard-stepnum">PRESCRIPTIONS</div>
       <div class="progress"><div class="progress-bar"></div></div>
       <a href="#" class="bs-wizard-dot"></a>
       </div>
      <?php } ?>

      <?php
      $discharge = DB::table('appointments')
      ->where('id','=', $app_id)->first();

      ?>
<?php if ($discharge->status == 3) {  ?>
      <div class="col-xs-3 bs-wizard-step complete">
      <div class="text-center bs-wizard-stepnum">DISCHARGED</div>
      <div class="progress"><div class="progress-bar"></div></div>
      <a href="#" class="bs-wizard-dot"></a>
    </div>
<?php }else{    ?>
    <div class="col-xs-3 bs-wizard-step disabled">
     <div class="text-center bs-wizard-stepnum">DISCHARGED</div>
     <div class="progress"><div class="progress-bar"></div></div>
     <a href="#" class="bs-wizard-dot"></a>
     </div>
<?php }   ?>
</div>
