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
                        <li><a href="{{ URL::to('patient')}}">Profile</a></li>
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

@role('Superadmin')

@include('includes.superadmin.menu')

@else

<li>
<a href="{{ URL::to('patient')}}"><i class="fa fa-user"></i> <span>Your Profile</span> </a></li>
<li><a href="{{ URL::to('patappointments')}}"><i class="fa fa-plus-square"></i>Appointments</a></li>
<li><a href="{{ URL::to('self_reporting')}}"><i class="fa fa-plus-square"></i>Self Reporting</a></li>
<li><a href="{{ URL::to('PatientAllergies')}}"><i class="fa fa-plus-square" aria-hidden="true"></i><span>Patient Details</span></a></li>
<li><a href="{{ route('patientnhif')}}">  <i class="fa fa-money "></i> <span>NHIF </span></a></li>
<li><a href="{{ URL::to('expenditure')}}">  <i class="fa fa-money "></i> <span>Health Expenditure</span></a></li>


<!-- <li><a href="{{ URL::to('#')}}">  <i class="glyphicon glyphicon-calendar "></i> <span>Calendar</span></a></li> -->
<!-- <li><a href="{{ URL::to('#')}}">  <i class="fa fa-envelope "></i> <span>Email</span></a></li> -->
<li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i><span>Logout</span></a></li>

@endrole







        </ul>

    </div>
</nav>
