@extends('layouts.doctor_layout')
@section('title', 'Dashboard')
@section('leftmenu')
  @include('includes.doc_inc.leftmenu')
  @endsection
@section('content')
<?php
use Carbon\Carbon;
use App\Afya_user;
if($youngest){
$interval = date_diff(date_create(), date_create($youngest->dob));
$age1= $interval->format(" %Y Y, %M M, %d D Old");
$youngname = $youngest->firstname . $youngest->secondName;
}
else{
$age1=00;
$youngname ="No data found";
}

if($oldest){
$interval2 = date_diff(date_create(), date_create($oldest->dob));
$age2= $interval2->format(" %Y Y, %M M, %d D Old");
// $age2= $interval2->format(" %Y Y, %M M, %d D Old");
$oldname =  $oldest->firstname . $oldest->secondName;
}
else {
$age2=00;
$oldname ="No data found";
}

 ?>
<div class="row wrapper border-bottom white-bg page-heading">
  <div class="col-md-12">
     <br /><br />
      <div class="col-md-4">
        <address>
        <strong>DOCTOR </strong><br>
        Name: {{$doc->name}}<br>
        Speciality: {{$doc->speciality}}<br>

      </address>
      </div>
      <div class="col-md-4">
        <address>
          <strong>Patient Summary:</strong><br>
          Youngest : {{$youngname}} / Age: {{$age1}}<br>
          <!-- Average :{{$doc->Type}}<br> -->
          Oldest : {{$oldname}}  / Age: {{$age2}}<br>
      </address>
      </div>
      <div class="col-md-4 text-right">
        <address>
          <strong>Facility :</strong><br>
          Name : {{$doc->FacilityName}}<br>
          Type :{{$doc->Type}}
      </address>
      </div>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
      <div class="col-lg-6">
          <div class="ibox float-e-margins">
              <div class="ibox-title">
                  <h5>Total Patients against Age Range</h5>
              </div>
              <div class="ibox-content">
                  <div>
                      <canvas id="barChart" height="140"></canvas>
                  </div>
              </div>
          </div>
      </div>
        <div class="col-lg-6">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Patients Seen For Last 7 days</h5>
                </div>
                <div class="ibox-content">
                    <div>
                        <canvas id="barChart1" height="140"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
      <div class="col-lg-6">
          <div class="ibox float-e-margins">
              <div class="ibox-title">
                  <h5>Up-Coming Appointments for 7 days</h5>
              </div>
              <div class="ibox-content">
                  <div>
                      <canvas id="barChart2" height="140"></canvas>
                  </div>
              </div>
          </div>
      </div>
        <div class="col-lg-6">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Consultation Fee For Last 7 days</h5>
                </div>
                <div class="ibox-content">
                    <div>
                        <canvas id="barChart3" height="140"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Total Consultation Fees By Mode of Payments</h5>

                </div>
                <div class="ibox-content">
                    <div>
                        <canvas id="doughnutChart1" height="140"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>No: of Patients By Gender</h5>

                </div>
                <div class="ibox-content">
                    <div>
                        <canvas id="doughnutChart2" height="140"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>


@endsection
@section('script-test')
<!-- ChartJS-->
<script>
<?php

$doc_id = DB::table('facility_doctor')->select('doctor_id','facilitycode')->where('facility_doctor.user_id', Auth::user()->id)
->first();   $doctor_id=$doc_id->doctor_id;  $facility_id=$doc_id->facilitycode;

// --------------------Total Patients against Age Range------------------------------------


$count1m= DB::table('afya_users')->Join('appointments', 'afya_users.id', '=', 'appointments.afya_user_id')
->whereRaw( 'timestampdiff(year, dob, curdate()) between ? and ?', [0, 14] )->where([['afya_users.gender','Male'],['appointments.doc_id', '=',$doctor_id],['appointments.facility_id', '=',$facility_id]])->distinct()->count('afya_users.id');
$count1f= DB::table('afya_users')->Join('appointments', 'afya_users.id', '=', 'appointments.afya_user_id')
->whereRaw( 'timestampdiff(year, dob, curdate()) between ? and ?', [0, 14] )->where([['afya_users.gender','Female'],['appointments.doc_id', '=',$doctor_id],['appointments.facility_id', '=',$facility_id]])->distinct()->count('afya_users.id');

$count2m= DB::table('afya_users')->Join('appointments', 'afya_users.id', '=', 'appointments.afya_user_id')
->whereRaw( 'timestampdiff(year, dob, curdate()) between ? and ?', [15, 18] )->where([['afya_users.gender','Male'],['appointments.doc_id', '=',$doctor_id],['appointments.facility_id', '=',$facility_id]])->distinct()->count('afya_users.id');
$count2f= DB::table('afya_users')->Join('appointments', 'afya_users.id', '=', 'appointments.afya_user_id')
->whereRaw( 'timestampdiff(year, dob, curdate()) between ? and ?', [15, 18] )->where([['afya_users.gender','Female'],['appointments.doc_id', '=',$doctor_id],['appointments.facility_id', '=',$facility_id]])->distinct()->count('afya_users.id');

$count3m= DB::table('afya_users')->Join('appointments', 'afya_users.id', '=', 'appointments.afya_user_id')
->whereRaw( 'timestampdiff(year, dob, curdate()) between ? and ?', [19, 24] )->where([['afya_users.gender','Male'],['appointments.doc_id', '=',$doctor_id],['appointments.facility_id', '=',$facility_id]])->distinct()->count('afya_users.id');
$count3f= DB::table('afya_users')->Join('appointments', 'afya_users.id', '=', 'appointments.afya_user_id')
->whereRaw( 'timestampdiff(year, dob, curdate()) between ? and ?', [19, 24] )->where([['afya_users.gender','Female'],['appointments.doc_id', '=',$doctor_id],['appointments.facility_id', '=',$facility_id]])->distinct()->count('afya_users.id');

$count4m= DB::table('afya_users')->Join('appointments', 'afya_users.id', '=', 'appointments.afya_user_id')
->whereRaw( 'timestampdiff(year, dob, curdate()) between ? and ?', [25, 34] )->where([['afya_users.gender','Male'],['appointments.doc_id', '=',$doctor_id],['appointments.facility_id', '=',$facility_id]])->distinct()->count('afya_users.id');
$count4f= DB::table('afya_users')->Join('appointments', 'afya_users.id', '=', 'appointments.afya_user_id')
->whereRaw( 'timestampdiff(year, dob, curdate()) between ? and ?', [25, 34] )->where([['afya_users.gender','Female'],['appointments.doc_id', '=',$doctor_id],['appointments.facility_id', '=',$facility_id]])->distinct()->count('afya_users.id');

$count5m= DB::table('afya_users')->Join('appointments', 'afya_users.id', '=', 'appointments.afya_user_id')
->whereRaw( 'timestampdiff(year, dob, curdate()) between ? and ?', [35, 44] )->where([['afya_users.gender','Male'],['appointments.doc_id', '=',$doctor_id],['appointments.facility_id', '=',$facility_id]])->distinct()->count('afya_users.id');
$count5f= DB::table('afya_users')->Join('appointments', 'afya_users.id', '=', 'appointments.afya_user_id')
->whereRaw( 'timestampdiff(year, dob, curdate()) between ? and ?', [35, 44] )->where([['afya_users.gender','Female'],['appointments.doc_id', '=',$doctor_id],['appointments.facility_id', '=',$facility_id]])->distinct()->count('afya_users.id');


$count6m= DB::table('afya_users')->Join('appointments', 'afya_users.id', '=', 'appointments.afya_user_id')
->whereRaw( 'timestampdiff(year, dob, curdate()) between ? and ?', [45, 54] )->where([['afya_users.gender','Male'],['appointments.doc_id', '=',$doctor_id],['appointments.facility_id', '=',$facility_id]])->distinct()->count('afya_users.id');
$count6f= DB::table('afya_users')->Join('appointments', 'afya_users.id', '=', 'appointments.afya_user_id')
->whereRaw( 'timestampdiff(year, dob, curdate()) between ? and ?', [45, 54] )->where([['afya_users.gender','Female'],['appointments.doc_id', '=',$doctor_id],['appointments.facility_id', '=',$facility_id]])->distinct()->count('afya_users.id');

$count7m= DB::table('afya_users')->Join('appointments', 'afya_users.id', '=', 'appointments.afya_user_id')
->whereRaw( 'timestampdiff(year, dob, curdate()) between ? and ?', [55, 64] )->where([['afya_users.gender','Male'],['appointments.doc_id', '=',$doctor_id],['appointments.facility_id', '=',$facility_id]])->distinct()->count('afya_users.id');
$count7f= DB::table('afya_users')->Join('appointments', 'afya_users.id', '=', 'appointments.afya_user_id')
->whereRaw( 'timestampdiff(year, dob, curdate()) between ? and ?', [55, 64] )->where([['afya_users.gender','Female'],['appointments.doc_id', '=',$doctor_id],['appointments.facility_id', '=',$facility_id]])->distinct()->count('afya_users.id');

$count8m= DB::table('afya_users')->Join('appointments', 'afya_users.id', '=', 'appointments.afya_user_id')
->whereRaw( 'timestampdiff(year, dob, curdate()) between ? and ?', [65, 74] )->where([['afya_users.gender','Male'],['appointments.doc_id', '=',$doctor_id],['appointments.facility_id', '=',$facility_id]])->distinct()->count('afya_users.id');
$count8f= DB::table('afya_users')->Join('appointments', 'afya_users.id', '=', 'appointments.afya_user_id')
->whereRaw( 'timestampdiff(year, dob, curdate()) between ? and ?', [65, 74] )->where([['afya_users.gender','Female'],['appointments.doc_id', '=',$doctor_id],['appointments.facility_id', '=',$facility_id]])->distinct()->count('afya_users.id');

$count9m= DB::table('afya_users')->Join('appointments', 'afya_users.id', '=', 'appointments.afya_user_id')
->whereRaw( 'timestampdiff(year, dob, curdate()) between ? and ?', [75, 200] )->where([['afya_users.gender','Male'],['appointments.doc_id', '=',$doctor_id],['appointments.facility_id', '=',$facility_id]])->distinct()->count('afya_users.id');
$count9f= DB::table('afya_users')->Join('appointments', 'afya_users.id', '=', 'appointments.afya_user_id')
->whereRaw( 'timestampdiff(year, dob, curdate()) between ? and ?', [75, 200] )->where([['afya_users.gender','Female'],['appointments.doc_id', '=',$doctor_id],['appointments.facility_id', '=',$facility_id]])->distinct()->count('afya_users.id');


// dd($count1m,$count2m,$count3m,$count4m,$count5m,$count6m,$count7m,$count8m,$count9m);
// --------------------Patients Seen For Last 7 days------------------------------------

$today= Carbon::today();
$now= Carbon::today();

$day1=Carbon::today()->toDateString();
$day1pat=DB::table('appointments')->where([['created_at','>=',$day1],['doc_id', '=',$doctor_id],['facility_id', '=',$facility_id]])->count();

$day2=$today->subDays(1)->toDateString();
$day2pat=DB::table('appointments')->where([['created_at','>=',$day2],['created_at','<',$day1],['doc_id', '=',$doctor_id],['facility_id', '=',$facility_id]])->count();

$day3=$today->subDays(1)->toDateString();
$day3pat=DB::table('appointments')->where([['created_at','>=',$day3],['created_at','<',$day2],['doc_id', '=',$doctor_id],['facility_id', '=',$facility_id]])->count();

$day4=$today->subDays(1)->toDateString();
$day4pat=DB::table('appointments')->where([['created_at','>=',$day4],['created_at','<',$day3],['doc_id', '=',$doctor_id],['facility_id', '=',$facility_id]])->count();

$day5=$today->subDays(1)->toDateString();
$day5pat=DB::table('appointments')->where([['created_at','>=',$day5],['created_at','<',$day4],['doc_id', '=',$doctor_id],['facility_id', '=',$facility_id]])->count();

$day6=$today->subDays(1)->toDateString();
$day6pat=DB::table('appointments')->where([['created_at','>=',$day6],['created_at','<',$day5],['doc_id', '=',$doctor_id],['facility_id', '=',$facility_id]])->count();

$day7=$today->subDays(1)->toDateString();
$day7pat=DB::table('appointments')->where([['created_at','>=',$day7],['created_at','<',$day6],['doc_id', '=',$doctor_id],['facility_id', '=',$facility_id]])->count();

// --------------------Appointment For Last 7 days------------------------------------

$todayapp =Carbon::today();
$apday1=$todayapp->toDateString();
$apday1pat=DB::table('appointments')->where([['appointment_date','=',$apday1],['doc_id', '=',$doctor_id],['facility_id', '=',$facility_id]])->count();

$apday2=$todayapp->addDays (1)->toDateString();
$apday2pat=DB::table('appointments')->where([['appointment_date','=',$apday2],['doc_id', '=',$doctor_id],['facility_id', '=',$facility_id]])->count();

$apday3=$todayapp->addDays (1)->toDateString();
$apday3pat=DB::table('appointments')->where([['appointment_date','=',$apday3],['doc_id', '=',$doctor_id],['facility_id', '=',$facility_id]])->count();

$apday4=$todayapp->addDays (1)->toDateString();
$apday4pat=DB::table('appointments')->where([['appointment_date','=',$apday4],['doc_id', '=',$doctor_id],['facility_id', '=',$facility_id]])->count();

$apday5=$todayapp->addDays (1)->toDateString();
$apday5pat=DB::table('appointments')->where([['appointment_date','=',$apday5],['doc_id', '=',$doctor_id],['facility_id', '=',$facility_id]])->count();

$apday6=$todayapp->addDays (1)->toDateString();
$apday6pat=DB::table('appointments')->where([['appointment_date','=',$apday6],['doc_id', '=',$doctor_id],['facility_id', '=',$facility_id]])->count();

$apday7=$todayapp->addDays (1)->toDateString();
$apday7pat=DB::table('appointments')->where([['appointment_date','=',$apday7],['doc_id', '=',$doctor_id],['facility_id', '=',$facility_id]])->count();

// --------------------Consultation Fee For Last 7 days------------------------------------
$cat=DB::table('payments_categories')->where('category_name', '=', 'Consultation fee')->Select('id')->first();
$cat_id=$cat->id;
$consday= Carbon::today();

$consday1=$consday->toDateString();
$feeday1=DB::table('appointments')
->join('payments','appointments.id','=','payments.appointment_id')
->where([['payments.payments_category_id','=',$cat_id],['payments.created_at','>=',$consday1],['appointments.doc_id', '=',$doctor_id],['appointments.facility_id', '=',$facility_id]])
->sum('payments.amount');

$consday2=$consday->subDays(1)->toDateString();
$feeday2=DB::table('appointments')
->join('payments','appointments.id','=','payments.appointment_id')
->where([['payments.payments_category_id','=',$cat_id],['payments.created_at','>=',$consday2],['payments.created_at','<',$consday1],['appointments.doc_id', '=',$doctor_id],['appointments.facility_id', '=',$facility_id]])
->sum('payments.amount');

$consday3=$consday->subDays(1)->toDateString();
$feeday3=DB::table('appointments')
->join('payments','appointments.id','=','payments.appointment_id')
->where([['payments.payments_category_id','=',$cat_id],['payments.created_at','>=',$consday3],['payments.created_at','<',$consday2],['appointments.doc_id', '=',$doctor_id],['appointments.facility_id', '=',$facility_id]])
->sum('payments.amount');

$consday4=$consday->subDays(1)->toDateString();
$feeday4=DB::table('appointments')
->join('payments','appointments.id','=','payments.appointment_id')
->where([['payments.payments_category_id','=',$cat_id],['payments.created_at','>=',$consday4],['payments.created_at','<',$consday3],['appointments.doc_id', '=',$doctor_id],['appointments.facility_id', '=',$facility_id]])
->sum('payments.amount');

$consday5=$consday->subDays(1)->toDateString();
$feeday5=DB::table('appointments')
->join('payments','appointments.id','=','payments.appointment_id')
->where([['payments.payments_category_id','=',$cat_id],['payments.created_at','>=',$consday5],['payments.created_at','<',$consday4],['appointments.doc_id', '=',$doctor_id],['appointments.facility_id', '=',$facility_id]])
->sum('payments.amount');

$consday6=$consday->subDays(1)->toDateString();
$feeday6=DB::table('appointments')
->join('payments','appointments.id','=','payments.appointment_id')
->where([['payments.payments_category_id','=',$cat_id],['payments.created_at','>=',$consday6],['payments.created_at','<',$consday5],['appointments.doc_id', '=',$doctor_id],['appointments.facility_id', '=',$facility_id]])
->sum('payments.amount');

$consday7=$consday->subDays(1)->toDateString();
$feeday7=DB::table('appointments')
->join('payments','appointments.id','=','payments.appointment_id')
->where([['payments.payments_category_id','=',$cat_id],['payments.created_at','>=',$consday7],['payments.created_at','<',$consday6],['appointments.doc_id', '=',$doctor_id],['appointments.facility_id', '=',$facility_id]])
->sum('payments.amount');
// --------------------Payment modes ------------------------------------
$cat_id=$cat->id;
$cash=DB::table('appointments')
->join('payments','appointments.id','=','payments.appointment_id')
->where([['payments.mode','=','1'],['appointments.doc_id', '=',$doctor_id],['appointments.facility_id', '=',$facility_id]])
->sum('payments.amount');

$micro=DB::table('appointments')
->join('payments','appointments.id','=','payments.appointment_id')
->where([['payments.mode','=','2'],['appointments.doc_id', '=',$doctor_id],['appointments.facility_id', '=',$facility_id]])
->sum('payments.amount');

$corporate=DB::table('appointments')
->join('payments','appointments.id','=','payments.appointment_id')
->where([['payments.mode','=','3'],['appointments.doc_id', '=',$doctor_id],['appointments.facility_id', '=',$facility_id]])
->sum('payments.amount');
$credit=DB::table('appointments')
->join('payments','appointments.id','=','payments.appointment_id')
->where([['payments.mode','=','4'],['appointments.doc_id', '=',$doctor_id],['appointments.facility_id', '=',$facility_id]])
->sum('payments.amount');
$mpesa=DB::table('appointments')
->join('payments','appointments.id','=','payments.appointment_id')
->where([['payments.mode','=','5'],['appointments.doc_id', '=',$doctor_id],['appointments.facility_id', '=',$facility_id]])
->sum('payments.amount');
// dd($cash,$mpesa,$micro,$corporate,$credit);
// --------------------Patients Male/Female ------------------------------------
$patientsm= DB::table('afya_users')->Join('appointments', 'afya_users.id', '=', 'appointments.afya_user_id')
->where([['afya_users.gender','Male'],['appointments.doc_id', '=',$doctor_id],['appointments.facility_id', '=',$facility_id]])->distinct()->count('afya_users.id');
$patientsf= DB::table('afya_users')->Join('appointments', 'afya_users.id', '=', 'appointments.afya_user_id')
->where([['afya_users.gender','Female'],['appointments.doc_id', '=',$doctor_id],['appointments.facility_id', '=',$facility_id]])->distinct()->count('afya_users.id');

?>
$(document).ready(function(){
// --------------------Patient by ages ------------------------------------

var barData = {
 labels: ["0-14", "15-18", "19-24", "25-34", "35-44", "45-54", "55-64","65-74","75 >"],
 datasets: [
     {
         label: "Male",
          backgroundColor: 'rgba(120, 320, 120, 0.5)',
         pointBorderColor: "#fff",
         data: [<?php echo $count1m; ?>,<?php echo $count2m; ?>,<?php echo $count3m; ?>,<?php echo $count4m; ?>,<?php echo $count5m; ?>,<?php echo $count6m; ?>,<?php echo $count7m; ?>,<?php echo $count8m; ?>,<?php echo $count9m; ?>]
     },
     {
         label: "Female",
         backgroundColor: 'rgba(26,179,148,0.5)',
         borderColor: "rgba(26,179,148,0.7)",
         pointBackgroundColor: "rgba(26,179,148,1)",
         pointBorderColor: "#fff",
         data: [<?php echo $count1f; ?>,<?php echo $count2f; ?>,<?php echo $count3f; ?>,<?php echo $count4f; ?>,<?php echo $count5f; ?>,<?php echo $count6f; ?>,<?php echo $count7f; ?>,<?php echo $count8f; ?>,<?php echo $count9f; ?>]
     }
 ]
};

var barOptions = {
 responsive: true,
 scales: {
 yAxes: [{
     ticks: {
         beginAtZero: true,
     }
 }]
}

};
var ctx2 = document.getElementById("barChart").getContext("2d");
new Chart(ctx2, {type: 'bar', data: barData, options:barOptions});
// --------------------Patient by ages end ------------------------------------

// --------------------Patient seen ------------------------------------

var barData = {
 labels: ["Today",'<?php echo $day2; ?>', '<?php echo $day3; ?>', '<?php echo $day4; ?>', '<?php echo $day5; ?>', '<?php echo $day6; ?>','<?php echo $day7; ?>'],
 datasets: [
     {
         label: "Patients",
         backgroundColor: 'rgba(26,179,148,0.5)',
         pointBorderColor: "#fff",
         data: [<?php echo $day1pat; ?>,<?php echo $day2pat; ?>,<?php echo $day3pat; ?>,<?php echo $day4pat; ?>,<?php echo $day5pat; ?>,<?php echo $day6pat; ?>,<?php echo $day7pat; ?>]
     }
 ]
};

var barOptions = {
 responsive: true,
 scales: {
 yAxes: [{
     ticks: {
         beginAtZero: true,
     }
 }]
}

};
var ctx2 = document.getElementById("barChart1").getContext("2d");
new Chart(ctx2, {type: 'bar', data: barData, options:barOptions});

// --------------------Patient seen Ends ------------------------------------
// --------------------Appointments ------------------------------------


var barData = {
labels: ["Today",'<?php echo $apday2; ?>', '<?php echo $apday3; ?>', '<?php echo $apday4; ?>', '<?php echo $apday5; ?>', '<?php echo $apday6; ?>','<?php echo $apday7; ?>'],
datasets: [
    {
        label: "Patients",
        backgroundColor: 'rgba(26,179,148,0.5)',
        pointBorderColor: "#fff",
        data: [<?php echo $apday1pat; ?>,<?php echo $apday2pat; ?>,<?php echo $apday3pat; ?>,<?php echo $apday4pat; ?>,<?php echo $apday5pat; ?>,<?php echo $apday6pat; ?>,<?php echo $apday7pat; ?>]
    }
]
};

var barOptions = {
responsive: true,
scales: {
yAxes: [{
    ticks: {
        beginAtZero: true,

    }
}]
}

};
var ctx2 = document.getElementById("barChart2").getContext("2d");
new Chart(ctx2, {type: 'bar', data: barData, options:barOptions});

// --------------------Appointments Ends ------------------------------------

var barData = {
labels: ["Today",'<?php echo $consday2; ?>', '<?php echo $consday3; ?>', '<?php echo $consday4; ?>', '<?php echo $consday5; ?>', '<?php echo $consday6; ?>','<?php echo $consday7; ?>'],
datasets: [
    {
        label: "KSH",
        backgroundColor: 'rgba(26,179,148,0.5)',
        pointBorderColor: "#fff",
        data: [{{$feeday1}},{{$feeday2}},{{$feeday3}},{{$feeday4}},{{$feeday5}},{{$feeday6}},{{$feeday7}},]
    }
]
};

var barOptions = {
responsive: true,
scales: {
yAxes: [{
    ticks: {
        beginAtZero: true,

    }
}]
}

};
var ctx2 = document.getElementById("barChart3").getContext("2d");
new Chart(ctx2, {type: 'bar', data: barData, options:barOptions});
// --------------------Pie Chart Mode of payment ------------------------------------

var doughnutData = {
labels: ["Cash","Mpesa","Micro insurance","corporate insurance","Credit"],
datasets: [{
    data: [{{$cash}},{{$mpesa}},{{$micro}},{{$corporate}},{{$credit}},],
    backgroundColor: ["#a3e1d4","#99ff99","#b5b8cf","#38ad94","#194d42"]
}]
} ;


var doughnutOptions = {
responsive: true
};


var ctx4 = document.getElementById("doughnutChart1").getContext("2d");
new Chart(ctx4, {type: 'doughnut', data: doughnutData, options:doughnutOptions});

// --------------------Pie Chart Male/Female ------------------------------------

var doughnutData = {
labels: ["Male","Female"],
datasets: [{
    data: [{{$patientsm}},{{$patientsf}}],
    backgroundColor: ["#a3e1d4","#dedede"]
}]
} ;


var doughnutOptions = {
responsive: true
};


var ctx4 = document.getElementById("doughnutChart2").getContext("2d");
new Chart(ctx4, {type: 'doughnut', data: doughnutData, options:doughnutOptions});

});
</script>

@endsection
