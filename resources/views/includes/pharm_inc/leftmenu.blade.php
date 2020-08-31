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
            @role(['Pharmacyadmin','Pharmacymanager'])

               <?php
               $today2 = date('Y-m-d');

               $user_id = Auth::id();

               $data = DB::table('pharmacists')
                         ->where('user_id', $user_id)
                         ->first();

               $facility = $data->premiseid;

               $results = DB::table('afya_users')
                       ->join('afyamessages', 'afya_users.msisdn', '=', 'afyamessages.msisdn')
                       ->join('appointments', 'appointments.afya_user_id', '=', 'afya_users.id')
                       ->join('prescriptions', 'prescriptions.appointment_id', '=', 'appointments.id')
                       ->join('prescription_details', 'prescription_details.presc_id', '=', 'prescriptions.id')
                       ->join('doctors', 'doctors.id', '=', 'appointments.doc_id')
                       ->select(DB::raw('count(prescriptions.id) as total'))
                       ->where('afyamessages.facilityCode', '=', $facility)
                       ->whereNotNull('afya_users.dob')
                       ->whereDate('afyamessages.created_at','=',$today2)
                       ->whereIn('prescriptions.filled_status', [0, 2])
                       ->orWhere(function ($query) use ($facility,$today2){
                       $query->where('afyamessages.facilityCode', '=', $facility)
                             ->whereNotNull('afya_users.dob')
                             ->whereDate('afyamessages.created_at','=',$today2)
                             ->where('prescriptions.filled_status', '=', 0);
                       })
                       ->groupBy('appointments.id')
                       ->get();

               $alternatives = DB::table('afya_users')
                             ->join('afyamessages', 'afya_users.msisdn', '=', 'afyamessages.msisdn')
                             ->select('afya_users.*','afyamessages.created_at AS created_at')
                             ->where('afyamessages.facilityCode', '=', $facility)
                             ->whereDate('afyamessages.created_at','=',$today2)
                             ->whereNull('afya_users.dob')
                             ->whereNull('afyamessages.status')
                             ->get();


                $final_count = $results + $alternatives;
                     ?>
@role('Superadmin')

@include('includes.superadmin.menu')

@else

<li><a href="{{ URL::to('pharmacy')}}"><i class="glyphicon glyphicon-tasks"></i> <span>Today's Prescription </span> <span class="badge"><?php   echo count($final_count);?>  </span></a></li>
<li> <a href="{{route('filled_prescriptions')}}"><i class="fa fa-money"></i> <span>Sales</span></a></li>
@endrole

@role(['Pharmacystorekeeper','Pharmacymanager','Pharmacyadmin'])
<li><a href="{{ URL::to('inventory')}}"><i class="fa fa-money"></i> <span>Inventory</span></a>
</li>
@endrole


@role(['Pharmacyadmin','Pharmacymanager'])
<li> <a href="{{route('inventory_report')}}"><i class="fa fa-money"></i> <span>Inventory Report</span></a></li>
@endrole
<li>  <a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i><span>Logout</span> </a> </li>
@endrole
        </ul>

    </div>
</nav>
