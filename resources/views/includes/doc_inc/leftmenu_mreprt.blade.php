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
                        <li><a href="{{ url('/logout') }}">Logout</a></li>

                    </ul>
                </div>
                <div class="logo-element">
                    Afya+
                </div>
            </li>
            <?php
              use Carbon\Carbon;
              $today = Carbon::today();



$doc_id = DB::table('facility_doctor')
        ->Join('facilities', 'facility_doctor.facilitycode', '=', 'facilities.FacilityCode')
        ->select('facility_doctor.doctor_id','facilities.set_up','facilities.FacilityCode')
        ->where('facility_doctor.user_id', Auth::user()->id)
        ->first();


    $user = DB::table('appointments')
        ->leftJoin('patient_admitted', 'appointments.id', '=', 'patient_admitted.appointment_id')
        ->select('patient_admitted.condition','appointments.afya_user_id','appointments.visit_type')
        ->where('appointments.id', '=',$app_id)->first();

if($user->condition){ $condition=$user->condition;  } else { $condition='';}
$afyauserId=$user->afya_user_id;

$doctor_id=$doc_id->doctor_id;
$setUp=$doc_id->set_up;
$f_code = $doc_id->FacilityCode;

  $allpatients=DB::table('appointments')->distinct('afya_user_id')
  ->where('facility_id', $f_code)->count('afya_user_id');

if($setUp =='Partial'){
$newpatientpartial1 =  DB::table('appointments')
->where([ ['appointments.created_at','>=',$today],
['appointments.status', '=', 1],
['appointments.facility_id', '=', $f_code],
['appointments.doc_id', '=',$doctor_id],
])->count();

$newpatientpartial2 =  DB::table('appointments')
->where([ ['appointments.created_at','>=',$today],
['appointments.facility_id', '=', $f_code],
['appointments.status', '=', 2],
['appointments.doc_id', '=',$doctor_id],
])
->count();
$newpatientpartial =($newpatientpartial1 + $newpatientpartial2);
}else{
$newpatientpartial =  DB::table('appointments')
->where([ ['appointments.created_at','>=',$today],
['appointments.status', '=', 2],
['appointments.doc_id', '=',$doctor_id],
])->count();



}
$pendingpatient1 =  DB::table('appointments')
->where([['appointments.status', '=', 1],['appointments.facility_id', '=', $f_code],
['appointments.doc_id', '=',$doctor_id],])->count();

$pendingpatient2 =  DB::table('appointments')
->where([['appointments.status', '=', 2],['appointments.facility_id', '=', $f_code],
  ['appointments.doc_id', '=',$doctor_id],])->count();
$pendingpatient = $pendingpatient1 + $pendingpatient2;

?>
@if($user->visit_type == "Review")
<li><a href="{{ url('private') }}"><i class="fa fa-th-large"></i><span class="nav-label"> Waiting List </span>   <span class="badge"><?php echo $newpatientpartial; ?></span></a></li>
<li><a href="{{ url('pendingpatient') }}"><i class="fa fa-users"></i><span> Pending Patients</span> <span class="badge"><?php echo $pendingpatient; ?></span></a></li>
<li class="{{ isActiveRoute('nurseVitals') }}"><a  href="{{route('nurseVitals',$app_id)}}"><i class="fa fa-thermometer"></i><span class="nav-label">Triage</a></span></li>
<li class="{{ isActiveRoute('showPatient') }}"><a  href="{{route('showPatient',$app_id)}}"><i class="fa fa-briefcase"></i> <span class="nav-label">Patient Details</span></a></li>
<li class="{{ isActiveRoute('patreview') }}"><a  href="{{route('patreview',$app_id)}}"><i class="fa fa-undo"></i> <span class="nav-label">Patient Review</span></a></li>
@else
<li><a href="{{ url('private') }}"><i class="fa fa-th-large"></i><span class="nav-label"> Waiting List </span>   <span class="badge"><?php echo $newpatientpartial; ?></span></a></li>
<li><a href="{{ url('pendingpatient') }}"><i class="fa fa-users"></i><span> Pending Patients</span> <span class="badge"><?php echo $pendingpatient; ?></span></a></li>

<li class="{{ isActiveRoute('nurseVitals') }}"><a  href="{{route('nurseVitals',$app_id)}}"><i class="fa fa-thermometer"></i><span class="nav-label">Triage</a></span></li>
<li class="{{ isActiveRoute('showPatient') }}"><a  href="{{route('showPatient',$app_id)}}"><i class="fa fa-briefcase"></i> <span class="nav-label">Patient Details</span></a></li>
<li class="{{ isActiveRoute('patreview') }}"><a  href="{{route('patreview',$app_id)}}"><i class="fa fa-undo"></i> <span class="nav-label">Patient Review</span></a></li>
  <li class="{{ isActiveRoute('patsamury') }}"><a  href="{{route('patsamury',$app_id)}}"><i class="fa fa-pencil"></i><span class="nav-label">Patient Summary</span></a></li>
   <li class="{{ isActiveRoute('examination') }}"><a  href="{{route('examination',$app_id)}}"><i class="fa fa-pencil-square"></i><span class="nav-label">Examination</span></a></li>
    <li class="{{ isActiveRoute('impression') }}"><a  href="{{route('impression',$app_id)}}"><i class="fa fa-pencil-square-o"></i><span class="nav-label">Impression</span></a></li>
    <li class="{{ isActiveRoute('alltestes') }}"><a  href="{{route('alltestes',$app_id)}}"><i class="fa fa-stethoscope"></i><span class="nav-label">Tests</span></a></li>
    <li class="{{ isActiveRoute('doc.diagnosis') }}"><a href="{{route('doc.diagnosis',$app_id)}}"><i class="fa fa-plus-square"></i><span class="nav-label">Diagnosis</span></a></li>
  <li class="{{ isActiveRoute('medicines') }}"><a href="{{route('medicines',$app_id)}}"><i class="fa fa-plus-square"></i><span class="nav-label">Prescriptions</span></a></li>
    <!-- <li class="{{ isActiveRoute('procedure') }}"><a  href="{{route('procedure',$app_id)}}"><i class="fa fa-eyedropper"></i>Procedures</a></li> -->

@endif

  @if ($condition =='Admitted')
      <li class="{{ isActiveRoute('discharge') }}"><a  href="{{route('discharge',$app_id)}}"><i class="fa fa-stethoscope"></i><span class="nav-label">Discharge</span></a></li>
     @else
      <li class="{{ isActiveRoute('admit') }}"><a  href="{{route('admit',$app_id)}}"><i class="fa fa-hospital-o"></i><span class="nav-label">Admit</span></a></li>
      @endif
      <li class="{{ isActiveRoute('transfering') }}"><a  href="{{route('transfering',$app_id)}}"><i class="fa fa-external-link-square"></i><span class="nav-label">Referral</span></a></li>
      <li class="{{ isActiveRoute('patienthistory') }}"><a href="{{route('patienthistory',$app_id)}}"><i class="fa fa-file-text"></i><span class="nav-label">Medical Report</span></a></li>

        <li class="{{ isActiveRoute('appcalendar21') }}"><a href="{{route('appcalendar21',$afyauserId)}}"><i class="fa fa-calendar"></i><span class="nav-label">Next Visit</span></a><li>

  <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i><span class="nav-label">Logout</span><span class="fa arrow"></span></a></li>

           </ul>

    </div>
</nav>
