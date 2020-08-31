<nav class="navbar-default navbar-static-side" role="navigation">
<div class="sidebar-collapse">
<ul class="nav metismenu" id="side-menu">
<li class="nav-header">
<div class="dropdown profile-element">
<!-- <span><img alt="user" class="img-circle" src="img/profile_small.jpg" /></span> -->
<a data-toggle="dropdown" class="dropdown-toggle" href="#">
<span class="clear"> <span class="block m-t-xs"> <strong class="font-bold">{{ Auth::user()->name }}</strong>
</span> <span class="text-muted text-xs block">{{ Auth::user()->role }} </span> </span> </a>
<!-- <ul class="dropdown-menu animated fadeInRight m-t-xs">
<li><a href="#">Profile</a></li>
<li><a href="#">Contacts</a></li>
<li><a href="#">Mailbox</a></li>
<li class="divider"></li>
<li><a href="{{ url('/logout') }}">Logout</a></li>

</ul> -->
</div>
<div class="logo-element">
Afya+
</div>
</li>
<?php
$today = date('Y-m-d');
$facility=DB::table('facility_nurse')->where('user_id', Auth::user()->id)->first();
$facilitycode = $facility->facilitycode;

$newpatient =DB::table('appointments')
->distinct('afya_user_id')
->where([['facility_id', $facilitycode],['appointments.status',1]])
->whereDate('appointments.created_at','=',$today)
->count('afya_user_id');
?>

<li class="active"><a href="#"><i class="fa fa-th-large"></i> <span class="nav-label">Dashboards</span> <span class="fa arrow"></span></a></li>

<li><a href="{{ URL::to('nurse') }}"><i class="fa fa-users"></i> <span>Waiting List</span>  <span class="badge">{{$newpatient}}</span></a></li>
<li><a href="{{ route('pathistory.show',$pat) }}" ><i class="fa fa-print"></i> Edit Details </a></li>
<li><a href="{{ route('details',$pat) }}" ><i class="fa fa-print"></i> Triage Details </a></li>

<li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i><span>Logout</span></a></li>



</ul>
</div>
</nav>
