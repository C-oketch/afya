<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element">
                   <!-- <span><img alt="user" class="img-circle" src="img/profile_small.jpg" /></span> -->
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                    <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold">{{ Auth::user()->name }}</strong>
                    </span> <span class="text-muted text-xs block">{{ Auth::user()->role }} <b class="caret"></b></span> </span> </a>
                    <ul class="dropdown-menu animated fadeInRight m-t-xs">
                        <li><a href="#">Profile</a></li>
                        <li><a href="#">Contacts</a></li>
                        <li><a href="#">Mailbox</a></li>
                        <li class="divider"></li>
                    </ul>
                </div>
                <div class="logo-element">
                    Afya+
                </div>
            </li>

<?php
use Carbon\Carbon;
$today = Carbon::today();
$today = $today->toDateString();

$doc_id = DB::table('facility_doctor')
        ->Join('facilities', 'facility_doctor.facilitycode', '=', 'facilities.FacilityCode')
        ->select('facility_doctor.doctor_id','facilities.set_up','facilities.FacilityCode')
        ->where('facility_doctor.user_id', Auth::id())
        ->first();

$doctor_id = $doc_id->doctor_id;
$setUp = $doc_id->set_up;
$f_code = $doc_id->FacilityCode;

$allpatients=DB::table('patient_facility')->distinct('afya_user_id')->where('facility_id', $f_code)->count('afya_user_id');

$newpatient1 =  DB::table('appointments')
->where([['appointments.status', '=', 1],['appointments.facility_id', '=', $f_code],
['appointments.doc_id', '=',$doctor_id],])->whereDate('appointments.created_at','=',$today)->count();

$newpatient2 =  DB::table('appointments')
->where([['appointments.status', '=', 2],['appointments.facility_id', '=', $f_code],
  ['appointments.doc_id', '=',$doctor_id],])->whereDate('appointments.created_at','=',$today)->count();
$newpatient = $newpatient1 + $newpatient2;


$pendingpatient1 =  DB::table('appointments')
->where([['appointments.status', '=', 1],['appointments.facility_id', '=', $f_code],
['appointments.doc_id', '=',$doctor_id],])->count();

$pendingpatient2 =  DB::table('appointments')
->where([['appointments.status', '=', 2],['appointments.facility_id', '=', $f_code],
  ['appointments.doc_id', '=',$doctor_id],])->count();
$pendingpatient = $pendingpatient1 + $pendingpatient2;


$admitted = DB::table('appointments')
          ->Join('patient_admitted', 'appointments.id', '=', 'patient_admitted.appointment_id')
          ->where([
          ['appointments.status', '=', 4],
          ['patient_admitted.condition', '=','Admitted'],
          ['appointments.doc_id', '=',$doctor_id],
          ['appointments.facility_id', '=', $f_code],
          ])
          ->count();

$selfreport =  DB::table('self_report')
            ->whereNull('status')
            ->count();

$selfreportHistory=  DB::table('self_report')->count();
?>

@if($setUp =='Partial')
<li class="active"><a href="{{ route('privdashboard') }}"><i class="fa fa-th-large"></i> <span>Dashboards</span></a></li>
<li><a href="{{ url('private') }}"><i class="fa fa-users"></i><span> Waiting List </span> <span class="badge"><?php echo $newpatient; ?></span></a></li>
<li><a href="{{ url('pendingpatient') }}"><i class="fa fa-users"></i><span> Pending Patients</span> <span class="badge"><?php echo $pendingpatient; ?></span></a></li>
<li><a href="{{ route('privadmpat') }}"><i class="fa fa-hospital-o"></i><span>Admitted Patients</span> <span class="badge"><?php echo $admitted; ?></span></a></li>
<li><a href="{{ URL::to('allpatientsDOC') }}"><i class="fa fa-users"></i><span class="nav-label">All Patients</span> <span class="badge">{{$allpatients}}</span></a><li>


  <li> <a href="{{ URL::to('private.fees')}}"><i class="fa fa-money"></i> <span>Fees Summary</span></a></li>

@else

<li class="active"><a href="#"><i class="fa fa-th-large"></i> <span>Doctor Dashboards</span></a></li>
 <li><a href="{{ url('doctor') }}"><i class="fa fa-users"></i><span> Waiting List </span> <span class="badge"><?php echo $newpatient; ?></span></a></li>
  <li><a href="{{ route('admitted') }}"><i class="fa fa-hospital-o"></i><span>Admitted Patients</span> <span class="badge"><?php echo $admitted; ?></span></a></li>
  <li><a href="{{ URL::to('allpatientsDOC') }}"><i class="fa fa-users"></i><span class="nav-label">All Patients</span> <span class="badge">{{$allpatients}}</span></a><li>

@endif
 <li class="{{ isActiveRoute('reg.app') }}"><a href="{{ URL::to('appointmentsmadedoc') }}"><i class="fa fa-address-book"></i>Appointments</a><li>
<li><a href="{{ URL::to('calendar') }}"><i class="fa fa-calendar"></i>Calendar</a><li>
<li> <a href="{{ route('change_password')}}">  <i class="fa fa-envelope "></i> <span>Change Password</span></a></li>
<li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i><span>Logout</span></a></li>

</ul>

    </div>
</nav>
