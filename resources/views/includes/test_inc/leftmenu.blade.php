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

            $facid = DB::table('facility_test')->where('user_id', '=', Auth::user()->id)->first();
    $newpatient = DB::table('afya_users')
            ->Join('afyamessages', 'afya_users.msisdn', '=', 'afyamessages.msisdn')
            ->where('afyamessages.test_center_code', '=',$facid->facilitycode)
            ->whereNull('afyamessages.status')
            ->count('afyamessages.id');




            $newpatientL = DB::table('afyamessages')
            ->Join('afya_users', 'afya_users.msisdn', '=', 'afyamessages.msisdn')
            ->Join('appointments', 'afya_users.id', '=', 'appointments.afya_user_id')
            ->Join('patient_test', 'afya_users.id', '=', 'patient_test.afya_user_id')
            ->whereNull('afyamessages.status')
            ->where([['afyamessages.test_center_code', '=',$facid->facilitycode],['appointments.p_status', '=',11],['patient_test.test_status', '!=', 1],])
             ->GroupBy('appointments.id')
            ->count('afya_users.id');


               $transfer = DB::table('tests_transfers')
               ->Join('patient_test_details', 'tests_transfers.specimen_no', '=', 'patient_test_details.specimen_no')
               ->where([ ['tests_transfers.facility_to', '=',$facid->facilitycode],
               ['patient_test_details.done', '=',0],  ])
               ->count('tests_transfers.id');



            ?>
@role('Superadmin')

@include('includes.superadmin.menu')

@else
<li class="active">
<a href="#"><i class="fa fa-th-large"></i> <span class="nav-label"> TESTS DASHBOARD</span> <span class="fa arrow"></span></a>
</li>

<?php  $facid = DB::table('facility_test')->where('user_id', '=', Auth::user()->id)->first();  ?>
@if($facid->department==='Laboratory')
<?php if ($facid->speciality==='Registrar') {?>
  <li><a href="{{ url('test') }}"><i class="glyphicon glyphicon-tasks"></i> <span>Waiting List</span><span class="fa arrow"> <span class="badge"><?php echo $newpatient; ?></span></span></a></li>
  <li><a href="{{ route('transfered') }}"><i class="fa fa-hospital-o"></i><span>Transfer List</span> <span class="fa arrow">  <span class="badge"><?php echo $transfer; ?></span></span></a></li>
  <li><a href="{{ URL::to('testesd')}}"><i class="glyphicon glyphicon-tasks"></i> <span>Test History</span></a></li>

  <?php } else { ?>
    <li><a href="{{ url('test') }}"><i class="glyphicon glyphicon-tasks"></i> <span>Waiting List</span><span class="fa arrow"> <span class="badge"><?php echo $newpatientL; ?></span></span></a></li>
    <li><a href="{{ route('transfered') }}"><i class="fa fa-hospital-o"></i><span>Transfer List</span> <span class="fa arrow">  <span class="badge"><?php echo $transfer; ?></span></span></a></li>

    <?php } ?>


@elseif($facid->department ==='Radiology')
<li><a href="{{ url('test') }}"><i class="glyphicon glyphicon-tasks"></i> <span>Waiting List</span></a></li>
<li><a href="{{ URL::to('testesdR')}}"><i class="glyphicon glyphicon-tasks"></i> <span>Test History</span></a>   </li>
@elseif($facid->department ==='Neurology')
<li><a href="{{ url('test') }}"><i class="glyphicon glyphicon-tasks"></i> <span>Waiting List</span></a></li>
@elseif($facid->department ==='Gastrointestinal')
<li><a href="{{ url('test') }}"><i class="glyphicon glyphicon-tasks"></i> <span>Waiting Listt</span></a></li>
@endif
@yield('left-menu')

<li><a href="{{ URL::to('testsales')}}"><i class="fa fa-money"></i> <span>Sales</span></span></a></li>
<li><a href="{{ URL::to('testanalytics') }}"><i class="glyphicon glyphicon-stats"></i> <span>Analytics</span></a>   </li>
<li><a href="{{ URL::to('#')}}"><i class="fa fa-envelope "></i> <span>Email</span> </a>  </li>
<li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i><span>Logout</span> </a>  </li>


@endrole
    </ul>
  </div>
</nav>
