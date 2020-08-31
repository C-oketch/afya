<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element">
                  <?php
                  
                  ?>
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
        ->select('facility_doctor.doctor_id','facilities.set_up','facilities.FacilityCode')->where('facility_doctor.user_id', Auth::user()->id)
        ->first();

$doctor_id=$doc_id->doctor_id;
$setUp=$doc_id->set_up;
$f_code = $doc_id->FacilityCode;

$allpatients = DB::table('patient_facility')
->join('appointments', 'patient_facility.afya_user_id', '=', 'appointments.afya_user_id')
->join('afya_users', 'patient_facility.afya_user_id', '=', 'afya_users.id')
->distinct('appointments.afya_user_id')
->where([['patient_facility.facility_id', $f_code],['appointments.doc_id', $doctor_id],])
->count('afya_users.id');

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
$newpatient =  DB::table('appointments')
->where([ ['appointments.created_at','>=',$today],
['appointments.status', '=', 2],
['appointments.doc_id', '=',$doctor_id],
])->count();



}
$selfreport =  DB::table('self_report')
->whereNull('status')
->count();
$selfreportHistory=  DB::table('self_report')->count();
$admitted =  DB::table('appointments')
->Join('patient_admitted', 'appointments.id', '=', 'patient_admitted.appointment_id')
->where([ ['appointments.status', '=', 4],
      ['patient_admitted.condition', '=','Admitted'],
      ['appointments.doc_id', '=',$doctor_id],
     ])
->count();
?>
@role('Superadmin')

@include('includes.superadmin.menu')

@else
@if($setUp =='Partial')

 <li class="{{ isActiveRoute('privdashboard') }}"><a href="{{ route('privdashboard') }}"><i class="fa fa-th-large"></i> <span>Dashboards</span></a></li>
 <li class="{{ isActiveRoute('pwaitingp') }}"><a href="{{ url('pwaitingp') }}"><i class="fa fa-users"></i><span> Waiting List </span>   <span class="badge"><?php echo $newpatientpartial; ?></span></a></li>
 <li class="{{ isActiveRoute('privadmpat') }}"><a href="{{ route('privadmpat') }}"><i class="fa fa-hospital-o"></i><span>Admitted Patients</span> <span class="badge"><?php echo $admitted; ?></span></a></li>
 <li class="{{ isActiveRoute('allpatientsDOC') }}"><a href="{{ URL::to('allpatientsDOC') }}"><i class="fa fa-users"></i><span class="nav-label">All Patients</span> <span class="badge">{{$allpatients}}</span></a><li>



@else

<li class="active"><a href="{{ url('doctor') }}"><i class="fa fa-th-large"></i> <span>Doctor Dashboards</span></a></li>
<li><a href="{{ route('doctorpatient') }}"><i class="fa fa-users"></i><span> Waiting List </span>   <span class="badge"><?php echo $newpatient; ?></span></a></li>
<li><a href="{{ route('admitted') }}"><i class="fa fa-hospital-o"></i><span>Admitted Patients</span> <span class="badge"><?php echo $admitted; ?></span></a></li>
 <li class="{{ isActiveRoute('allpatientsDOC') }}"><a href="{{ URL::to('allpatientsDOC') }}"><i class="fa fa-users"></i><span class="nav-label">All Patients</span> <span class="badge">{{$allpatients}}</span></a><li>

@endif

 <li class="{{ isActiveRoute('appointmentsmadedoc') }}"><a href="{{ URL::to('appointmentsmadedoc') }}"><i class="fa fa-address-book"></i>Appointments</a><li><li>

<li class="{{ isActiveRoute('appcalendar') }}"><a href="{{ URL::to('appcalendar') }}"><i class="fa fa-calendar"></i>Calendar</a><li>
              <!-- <li><a href="{{ url('slfrprtng') }}"><i class="fa fa-money"></i><span>Self Reporting</span><span class="fa arrow"> <span class="badge"><?php echo $selfreport; ?></span></span></a></li> -->
              <!-- <li><a href="{{ route('slfrprtngHist') }}"><i class="fa fa-money"></i><span>Self Reporting History</span><span class="fa arrow"> <span class="badge"><?php echo $selfreportHistory; ?></span></span></a></li> -->
  <li class="{{ isActiveRoute('private.fees') }}"><a href="{{ URL::to('private.fees')}}"><i class="fa fa-money"></i> <span>Fees Summary</span></a></li>

              <!-- <li><a href="{{ URL::to('calendar')}}">  <i class="glyphicon glyphicon-calendar "></i> <span>Calendar</span><span class="fa arrow"></span></a></li> -->

              <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Logout<span class="fa arrow"></span></a></li>
      @endrole
           </ul>

    </div>
</nav>
