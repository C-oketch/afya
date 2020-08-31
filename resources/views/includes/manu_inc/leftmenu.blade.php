<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
            <?php
$id=Auth::id();
$emp=DB::table('manufacturers_employees')->where('users_id',$id)->where('job','=','Manager')->first();
$rep=DB::table('sales_rep')->where('users_id',$id)->first();
if ($emp) {
  $manufacturer=DB::table('manufacturers')->where('user_id',$emp->manu_id)->first();
}
else if($rep) {
   $manufacturer=DB::table('manufacturers')->where('user_id',$rep->manu_id)->first();
}

else{
$manufacturer=DB::table('manufacturers')->where('user_id', Auth::id())->first();

}
 ?>
                <div class="dropdown profile-element">
                   <span>
                             <img src="/img/{{$manufacturer->logo or ''}}" class="img-circle" style="width:150px; height:80px; border-square:50%;">
                             </span>
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                    <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold">{{ Auth::user()->name }}</strong>
                    </span>
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

@role('Superadmin')

@include('includes.superadmin.menu')

@else

<li ><a href="{{ URL::to('manufacturer')}}"><i class="fa fa-th-large"></i> <span class="nav-label">Dashboards</span></a></li>
@if(!empty($emp))
<li><a href="{{ URL::to('salesrep')}}"><i class="fa fa-users"></i> <span class="nav-label">Sales Rep</span></a></li>
@elseif(!empty($rep))

@else
<li ><a href="{{ URL::to('manufacturerconfig')}}"><i class="fa fa-th-large"></i> <span class="nav-label">Add Competition</span></a></li>
<li><a href="{{ URL::to('manuemployees')}}"><i class="fa fa-users"></i> <span class="nav-label">Employees</span></a></li>
@endif
<li><a href="{{ URL::to('Drugsales') }}"><i class="fa fa-money"></i> <span>Sales</span> </a></li>
<li><a href="{{ URL::to('DrugSubstitution') }}"><i class="fa fa-pie-chart"></i><span>  Drug Substitutions</span></a></li>
<li> <a href="{{ URL::to('manustock')}}"> <i class="glyphicon glyphicon-dashboard "></i> <span>Stock Level</span></a></li>
<li> <a href="{{ URL::to('competition')}}">
<i class="glyphicon glyphicon-dashboard "></i> <span>Competition Analysis</span>

</a></li>
<li> <a href="{{ URL::to('Trends')}}">
<i class="glyphicon glyphicon-stats "></i> <span>Trends</span>

</a></li>
<li> <a href="{{ URL::to('SectorSummary')}}">
<i class="fa fa-list-alt"></i> <span>Sector Summary</span>

</a></li>

<li> <a href="{{ URL::to('ads')}}">
<i class="fa fa-list-alt"></i> <span>Advertising</span>

</a></li>

<li> <a href="{{ URL::to('#')}}">  <i class="fa fa-envelope "></i> <span>Email</span></a></li>
<li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i><span>Logout</span></a></li>

@endrole
        </ul>

    </div>
  </nav>
