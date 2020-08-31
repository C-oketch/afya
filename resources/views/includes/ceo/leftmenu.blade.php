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








<li class="active">
<a href="#"><i class="fa fa-th-large"></i> <span class="nav-label">Dashboards</span> <span class="fa arrow"></span></a>

</li>
<!-- <li>

<a href="{{ URL::to('#')}}"><i class="glyphicon glyphicon-stats"></i> <span>Statistics</span>
<a href="{{ URL::to('nurse')}}"><i class="fa fa-users"></i> <span>Total Patients</span>       <span class="badge"><?php echo $data; ?></span>
<a href="{{ URL::to('newpatient') }}"><i class="fa fa-pie-chart"></i> <span>New Patients</span>    <span class="badge"><?php echo $newpatient; ?></span>
<a href="{{ URL::to('waitingList')}}">
<i class="glyphicon glyphicon-dashboard "></i> <span>Waiting List</span>   <span class="badge"><?php echo $wList;?></span>

</li> -->
<li><a href="{{ url('#') }}">Doctors</a></li>
<li><a href="{{ url('#') }}">Patients</a></li>
<li><a href="{{ url('#') }}">Drugs</a></li>
<li><a href="{{ url('#') }}">Diagnosis</a></li>
<li><a href="{{ url('#') }}">NHIF</a></li>
<li><a href="{{ url('#') }}">Medical Insurance</a></li>

<li><a href="{{ url('/logout') }}">Logout</a></li>

</ul>

    </div>
</nav>
