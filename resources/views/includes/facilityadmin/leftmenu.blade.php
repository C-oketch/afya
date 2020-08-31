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
  <?php $Userrole=DB::table('users')
  ->join('facility_admin','users.id','=','facility_admin.user_id')
  ->where('users.id', Auth::id())
  ->first(); ?>

<li><a href="{{ URL::to('laboratory') }}"><i class="fa fa-users"></i> <span>Facility Personnel</span></a></li>
<li><a href="{{ URL::to('testranges') }}"><i class="fa fa-arrows-h"></i> <span>Add Test Ranges</span></a></li>
<li><a href="{{ URL::to('alltestprices') }}"><i class="fa fa-dollar"></i> <span class="nav-label">Tests Prices</span><span class="fa arrow"></span></a></li>
<li><a href="{{ URL::to('testprices') }}"><i class="fa fa-dollar"></i> <span class="nav-label">Laboratory Tests Prices</span><span class="fa arrow"></span></a></li>
<li><a href="{{ URL::to('testpricesct') }}"><i class="fa fa-dollar"></i> <span class="nav-label">CT-Scan Tests Prices</span><span class="fa arrow"></span></a></li>
<li><a href="{{ URL::to('testpricesxray') }}"><i class="fa fa-dollar"></i> <span class="nav-label">X-Ray Tests Prices</span><span class="fa arrow"></span></a></li>
<li><a href="{{ URL::to('testpricesotherIm') }}"><i class="fa fa-dollar"></i> <span class="nav-label">Other Imaging Tests Prices</span><span class="fa arrow"></span></a></li>
<li><a href="{{ URL::to('testpricesultra') }}"><i class="fa fa-dollar"></i> <span class="nav-label">Ultrasound Tests Prices</span><span class="fa arrow"></span></a></li>
<li><a href="{{ URL::to('testpricesmri') }}"><i class="fa fa-dollar"></i> <span class="nav-label">MRI Tests Prices</span><span class="fa arrow"></span></a></li>
<li><a href="{{ URL::to('testpricescardiac') }}"><i class="fa fa-dollar"></i> <span class="nav-label">Cardiac Tests Prices</span><span class="fa arrow"></span></a></li>
<li><a href="{{ URL::to('testpricesneurology') }}"><i class="fa fa-dollar"></i> <span class="nav-label">Neurology Tests Prices</span><span class="fa arrow"></span></a></li>
<li><a href="{{ URL::to('testpricesprocedure') }}"><i class="fa fa-dollar"></i> <span class="nav-label">Procedure Prices</span><span class="fa arrow"></span></a></li>






<li><a href="{{ URL::to('facilityusers') }}"><i class="fa fa-users"></i> <span>Facility Users</span></a></li>
<li><a href="{{ URL::to('alltestprices') }}"><i class="fa fa-dollar"></i> <span class="nav-label">Tests Prices</span><span class="fa arrow"></span></a></li>
<li><a href="{{ URL::to('consltfee') }}"><i class="fa fa-money"></i> <span>Fees Summary</span></a></li>
<li><a href="{{ URL::to('upimages') }}"><span>Upload Images</span></a></li>
<li> <a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i><span>Logout</span></a></li>



<!-- <li> <a href="{{ URL::to('#')}}">  <i class="fa fa-envelope "></i> <span>Email</span></a></li> -->

  </ul>

    </div>
</nav>
