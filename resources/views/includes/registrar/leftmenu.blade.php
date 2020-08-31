<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element">
                   <!-- <span><img alt="user" class="img-circle" src="img/profile_small.jpg" /></span> -->
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                    <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold">{{ Auth::user()->name }}</strong>
                    </span> <span class="text-muted text-xs block">{{ Auth::user()->role }} </span> </span> </a>

                </div>
                <div class="logo-element">
                    Afya+
                </div>
            </li>
<?php
    $facility = DB::table('facility_registrar')
              ->join('facilities','facility_registrar.facilitycode','=','facilities.FacilityCode')
              ->select('facility_registrar.facilitycode','facilities.set_up','facilities.path')
              ->where('user_id', Auth::id())
              ->first();
    $facilitycode = $facility->facilitycode;
    $fsetup = $facility->set_up;
$path = $facility->path;
    $allpatients=DB::table('patient_facility')->distinct('afya_user_id')->where('facility_id', $facilitycode)->count('afya_user_id');

    $today = date('Y-m-d');

    $patients1 = DB::table('afyamessages')
            ->distinct('msisdn')
              ->whereNull('status')
              ->where('facilityCode',$facilitycode)
             ->whereDate('created_at','=',$today)
              ->count('msisdn');

$patients2 = DB::table('appointments')
                    ->where('facility_id',$facilitycode)
                    ->whereDate('appointment_date','=',$today)
                    ->distinct()
                  ->count('id');

$patients =$patients1+$patients2;

    $consultation = DB::table('appointments')
                  ->join('afya_users', 'appointments.afya_user_id', '=','afya_users.id' )
                  ->where([
                    ['appointments.status', '=', 10],
                    ['appointments.facility_id', '=', $facilitycode],
                  ])
                  ->whereNotIn('appointments.id',function ($query){
                    $query->select('appointment_id')
                    ->from('payments');
                  })
                  ->count();

  $collect_count = DB::table('appointments')
                 ->join('afya_users', 'appointments.afya_user_id', '=','afya_users.id' )
                 ->select('appointments.id','appointments.created_at','afya_users.msisdn','afya_users.firstname',
                 'afya_users.secondName','afya_users.gender','afya_users.nationalId')
                 ->where([['appointments.facility_id', '=', $facilitycode],])
                 ->whereNotIn('appointments.id',function ($query){
                   $query->select('appointment_id')
                   ->from('payments');
                 })
                 ->count();
?>


<li><a href="{{ URL::to('registrar') }}"><i class="fa fa-users"></i> <span class="nav-label">Waiting List</span> <span class="badge"><?php echo $patients; ?></span></a></li>
<li><a href="{{ URL::to('allpatients') }}"><i class="fa fa-users"></i><span class="nav-label">All Patients</span> <span class="badge">{{$allpatients}}</span></a><li>
<li><a href="{{ URL::to('register_new_patient') }}"><i class="fa fa-users"></i>New Patients</a><li>
  <li class="{{ isActiveRoute('reg.app') }}"><a href="{{ URL::to('appointmentsmade') }}"><i class="fa fa-address-book"></i>Appointments</a><li>
<li class="{{ isActiveRoute('reg.app') }}"><a href="{{ URL::to('calendar') }}"><i class="fa fa-calendar"></i>Calendar</a><li>

@if($fsetup =='Partial')
<li><a href="{{ URL::to('paid_fees') }}"><i class="fa fa-money"></i> <span>Fee Summary</span></a></li>
@else

@if($path =='stano')
<li><a href="{{ URL::to('fees') }}"><i class="fa fa-money"></i><span class="nav-label">Collect Fees</span>  <span class="badge"></span></a></li>
@endif

<li><a href="{{ URL::to('paid_fees') }}"><i class="fa fa-money"></i> <span>Fee Summary</span></a></li>
@endif

<li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i><span>Logout</span></a></li>


</ul>

    </div>
</nav>
