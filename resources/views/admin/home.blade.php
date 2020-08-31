@extends('layouts.admin')
@section('title', 'Admin Dashboard')
@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>Admin Dashboard</h2>
                    <ol class="breadcrumb">
                        <li>
                            <a href="index.html">Home</a>
                        </li>
                        <li>
                            <a>Admin</a>
                        </li>
                        <li class="active">
                            <strong>Dashboard</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
      </div>

<div class="content-page  equal-height">
          <div class="content">
              <div class="container">




<div class="wrapper wrapper-content animated fadeInRight">

            <div class="row">
                    <div class="col-lg-3">

                        <div class="ibox">
                            <div class="ibox-content">
                                <h5>Government Facilities</h5>
                               <a href="{{url('gov-facilities')}}"> <h1 class="no-margins">{{$gov}}</h1></a>

                            </div>
                        </div>

                    </div>
                    <div class="col-lg-3">
                        <div class="ibox">
                            <div class="ibox-content">
                                <h5>Private Facilities</h5>
                            <a href="{{url('priv-facilities')}}"><h1 class="no-margins">{{$priv}}</h1></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="ibox">
                            <div class="ibox-content">
                                <h5>Pharmacies</h5>
                                <a href="{{url('pharm-facilities')}}"><h1 class="no-margins">{{$pharm}}</h1></a>

                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="ibox">
                            <div class="ibox-content">
                                <h5>Manufacturers</h5>
                                <a href="{{url('manu-facilities')}}"><h1 class="no-margins">{{$manu}}</h1></a>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                        <div class="col-lg-3">

                            <div class="ibox">
                                <div class="ibox-content">
                                    <h5>Active Facilities</h5>
                                   <a href="{{url('active_facilities')}}"> <h1 class="no-margins">{{$fac}}</h1></a>

                                </div>
                            </div>

                        </div>
                        <div class="col-lg-3">
                            <div class="ibox">
                                <div class="ibox-content">
                                    <h5>Total Users</h5>
                                <a href="#"><h1 class="no-margins">{{$users + $users2 }}</h1></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="ibox">
                                <div class="ibox-content">
                                    <h5>Active Users</h5>
                                    <a href="#"><h1 class="no-margins">{{$activeuser + $activeuser2}}</h1></a>

                                </div>
                            </div>
                        </div>

                        <!-- <div class="col-lg-3">
                            <div class="ibox">
                                <div class="ibox-content">
                                    <h5>Manufacturers</h5>
                                    <a href="{{url('manu-facilities')}}"><h1 class="no-margins">{{$manu}}</h1></a>

                                </div>
                            </div>
                        </div> -->
                    </div>
<div class="row">
        <div class="col-md-12">
            <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>App Performance </h5>
                        </div>
                <div class="ibox-content">
                    <div class="row">
                  <div class="col-lg-4">


                                <h5>Downloads</h5>
                                <h2>198 009</h2>


                    </div>
                    <div class="col-lg-4">
                                <h5>Retention</h5>
                                <h2>65 000</h2>

                    </div>
                    <div class="col-lg-4">

                                <h5>Conversations</h5>
                                <h2>680 900</h2>

                    </div>

                </div>
               </div>
        </div>
    </div>
 </div>


       <div class="row">
        <div class="col-md-12">
            <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Revenue </h5>
                        </div>
                <div class="ibox-content">
                    <div class="row">
                  <div class="col-lg-4">

                                <h5>Monthly Fees</h5>
                                <h2>198 009</h2>

                    </div>
                    <div class="col-lg-4">

                                <h5>One Time Fees</h5>
                                <h2>65 000</h2>
                    </div>
                    <div class="col-lg-4">

                                <h5>Advertising</h5>
                                <h2>680 900</h2>

                    </div>

                </div>
               </div>
        </div>
    </div>
 </div>


 <div class="row">
        <div class="col-md-12">
            <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Advertising Approvals </h5>
                        </div>
                <div class="ibox-content">
                    <div class="row">

    <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover dataTables-example" >
                    <thead>
                    <tr>
                      <th>Manufacturer</th>
                      <th>Drug Name</th>
                      <th>Advertising Spend</th>
                      <th width="280px">Action</th>
                    </tr>
                    </thead>
                    <tbody>


                    <tr class="gradeC">

                            <td></td>
                            <td></td>
                            <td></td>

                        <td>
                        <a class="btn btn-primary" href="">Approve</a>
                        <a class="btn btn-danger" href="">Reject</a>
                        </td>

                    </tr>


                    </tbody>

                    </table>
        </div>
          </div>
               </div>
        </div>
    </div>
 </div>










 </div>



 </div>



</div><
</div><!--container-->

@endsection
