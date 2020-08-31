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
            $data = DB::table("patients")->count();
            $wList=DB::table('afya_users')
                         ->Join('patients', 'afya_users.id', '=', 'patients.afya_user_id')
                         ->select('afya_users.*', 'patients.allergies')
                         ->where('afya_users.status',2)->count();
            $newpatient= DB::table('afya_users')
                         ->Join('patients', 'afya_users.id', '=', 'patients.afya_user_id')
                         ->select('afya_users.*', 'patients.allergies')
                         ->where('afya_users.status',1)->count();

                     ?>

<li class="active"><a href="{{ URL::to('admin')}}"><i class="fa fa-th-large"></i> <span class="nav-label">Dashboards</span> <span class="fa arrow"></span></a></li>
<li><a href="{{ URL::to('users')}}"><i class="fa fa-users"></i> <span>Users</span></a></li>
<li><a href="{{ URL::to('facilities')}}"><i class="fa fa-users"></i> <span>Facilities</span></a></li>

<li><a href="{{ URL::to('addtest') }}"><i class="fa fa-users"></i> <span> Laboratory Tests</span></a></li>
<li><a href="{{ URL::to('addtestrady') }}"><i class="fa fa-users"></i> <span>ImagingTest </span></a></li>
<li><a href="{{ URL::to('testcardiac') }}"><i class="fa fa-users"></i> <span> Cardiac Tests</span></a></li>
<li><a href="{{ URL::to('testneurology') }}"><i class="fa fa-users"></i> <span> Neurology Tests</span></a></li>
<li><a href="{{ URL::to('testprocedure') }}"><i class="fa fa-users"></i> <span> Procedures</span></a></li>





<li><a href="{{ URL::to('facilityAdmin')}}"><i class="fa fa-users"></i> <span>Facility Admin</span></a></li>
<li><a href="{{ URL::to('nhif')}}"><i class="fa fa-h-square"></i> <span>NHIF</span></a></li>

<li><a href="{{ route('quotation')}}"><i class="fa fa-h-square"></i> <span>Quotation</span></a></li>

<li> <a href="{{ URL::to('#')}}">  <i class="fa fa-envelope "></i> <span>Email</span></a></li>
<li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i><span>Logout</span></a></li>





        </ul>

    </div>
</nav>
