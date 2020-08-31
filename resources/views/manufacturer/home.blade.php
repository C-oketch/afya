@extends('layouts.manufacturer')
@section('title', 'Manufacturer')
@section('content')
<div class="content-page  equal-height">
          <div class="content">
              <div class="container">
              <br>
<div class="row">


 <?php
$id=Auth::id();
$emp=DB::table('manufacturers_employees')->where('users_id',$id)->first();
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


 @if(is_null($manufacturer))
<div class="col-lg-6">

<a data-toggle="modal" class="btn btn-primary" href="#modal-formf">Add Details</a>

                            <div id="modal-formf" class="modal fade" aria-hidden="true">
                            <div class="modal-dialog">
                            <div class="modal-content">
                            <div class="modal-body">
          <form class="form-horizontal" role="form" method="POST" action="/addmanu" enctype="multipart/form-data" novalidate>
             <input type="hidden" name="_token" value="{{ csrf_token() }}">
             <input type="hidden" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="{{$id}}" name="user_id"  required>
              <div class="form-group">
             <label for="exampleInputEmail1"> Name</label>
             <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="name">
             </div>
              <div class="form-group">
             <label for="exampleInputPassword1">Location</label>
             <input type="text" class="form-control" id="exampleInputPassword1"  name="location">
             </div>
              <div class="form-group">
             <label for="exampleInputPassword1">Address</label>
             <input type="text" class="form-control" id="exampleInputPassword1"  name="address">
             </div>
              <div class="form-group">
             <label for="exampleInputPassword1">P.O BOX</label>
             <input type="text" class="form-control" id="exampleInputPassword1"  name="box">
             </div>
              <div class="form-group">
             <label for="exampleInputPassword1">Tel</label>
             <input type="text" class="form-control" id="exampleInputPassword1"  name="tel">
             </div>
              <div class="form-group">
             <label for="exampleInputPassword1">Location</label>
             <input type="text" class="form-control" id="exampleInputPassword1"  name="location">
             </div>
             <div class="form-group">
    {!! Form::label('Logo') !!}
    {!! Form::file('logo', null) !!}
</div>
             <input type="submit" name="submit" value="Add" >
    </form>

                            </div>
                            </div>
                            </div>
                            </div>
</div>
@else
@endif

</div>
<br>
<div class="row">
       <div class="col-lg-12">
                    <div class="tabs-container">
                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#tab-1">Sales</a></li>
                            <li class=""><a data-toggle="tab" href="#tab-2">By Prescription</a></li>

                        </ul>
                        <br>
                        <div class="tab-content">
                            <div id="tab-1" class="tab-pane active">
                             <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#tab-1a">Today</a></li>
                            <li class=""><a data-toggle="tab" href="#tab-2a">This Week</a></li>
                             <li class=""><a data-toggle="tab" href="#tab-3a">This Month</a></li>
                          <li class=""><a data-toggle="tab" href="#tab-4a">This Year</a></li>

                        </ul>
                        <br>
                        <div class="tab-content">
                                <div id="tab-1a" class="tab-pane active">
                                <div class="panel-body">
                                <div class="ibox float-e-margins">
                              <div class="ibox-title">

                                  <div class="ibox-tools">

                                      <a class="collapse-link">
                                          <i class="fa fa-chevron-up"></i>
                                      </a>
                                      <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                          <i class="fa fa-wrench"></i>
                                      </a>
                                      <ul class="dropdown-menu dropdown-user">

                                          <li><a href="#">Config option 1</a>
                                          </li>
                                          <li><a href="#">Config option 2</a>
                                          </li>
                                      </ul>
                                      <a class="close-link">
                                          <i class="fa fa-times"></i>
                                      </a>
                                  </div>
                              </div>
                              <!-- sales Today -->
                              <div class="ibox-content">
                              <div>
                                <canvas id="lineChart" height="50"></canvas>
                            </div>

                                                 </div>
                                                 </div>
                                                 </div>

                                </div>
                                                         <div id="tab-2a" class="tab-pane ">
                                <div class="panel-body">
                                <div class="ibox float-e-margins">
                              <div class="ibox-title">

                                  <div class="ibox-tools">

                                      <a class="collapse-link">
                                          <i class="fa fa-chevron-up"></i>
                                      </a>
                                      <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                          <i class="fa fa-wrench"></i>
                                      </a>
                                      <ul class="dropdown-menu dropdown-user">

                                          <li><a href="#">Config option 1</a>
                                          </li>
                                          <li><a href="#">Config option 2</a>
                                          </li>
                                      </ul>
                                      <a class="close-link">
                                          <i class="fa fa-times"></i>
                                      </a>
                                  </div>
                              </div>
                              <div class="ibox-content">
    <!-- sales This week -->
                                  <div>
                                <canvas id="lineCharts" height="50"></canvas>
                            </div>
                                                 </div>
                                                 </div>

                                </div>
                                </div>
                                <div id="tab-3a" class="tab-pane ">
                                <div class="panel-body">
                                <div class="ibox float-e-margins">
                              <div class="ibox-title">

                                  <div class="ibox-tools">

                                      <a class="collapse-link">
                                          <i class="fa fa-chevron-up"></i>
                                      </a>
                                      <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                          <i class="fa fa-wrench"></i>
                                      </a>
                                      <ul class="dropdown-menu dropdown-user">

                                          <li><a href="#">Config option 1</a>
                                          </li>
                                          <li><a href="#">Config option 2</a>
                                          </li>
                                      </ul>
                                      <a class="close-link">
                                          <i class="fa fa-times"></i>
                                      </a>
                                  </div>
                              </div>
                              <div class="ibox-content">
    <!-- sales This Month --><div>
                                <canvas id="lineChartm" height="50"></canvas>
                            </div>

                                                 </div>
                                                 </div>
                                                 </div>

                                </div>

                         <div id="tab-4a" class="tab-pane">
                                <div class="panel-body">
                                <div class="ibox float-e-margins">
                              <div class="ibox-title">

                                  <div class="ibox-tools">

                                      <a class="collapse-link">
                                          <i class="fa fa-chevron-up"></i>
                                      </a>
                                      <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                          <i class="fa fa-wrench"></i>
                                      </a>
                                      <ul class="dropdown-menu dropdown-user">

                                          <li><a href="#">Config option 1</a>
                                          </li>
                                          <li><a href="#">Config option 2</a>
                                          </li>
                                      </ul>
                                      <a class="close-link">
                                          <i class="fa fa-times"></i>
                                      </a>
                                  </div>
                              </div>
                              <div class="ibox-content">
  <!-- sales This Year --><div>
                                <canvas id="lineCharty" height="50"></canvas>
                            </div>


                                                 </div>
                                                 </div>
                                                 </div>

                                </div>




                            </div>
                            </div>
                            <div id="tab-2" class="tab-pane">
                             <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#tab-21a">Today</a></li>
                            <li class=""><a data-toggle="tab" href="#tab-22a">This Week</a></li>
                             <li class=""><a data-toggle="tab" href="#tab-23a">This Month</a></li>
                          <li class=""><a data-toggle="tab" href="#tab-24a">This Year</a></li>

                        </ul>
                        <br>
                        <div class="tab-content">
                                <div id="tab-21a" class="tab-pane active">
                                <div class="panel-body">
                                <div class="ibox float-e-margins">
                              <div class="ibox-title">

                                  <div class="ibox-tools">

                                      <a class="collapse-link">
                                          <i class="fa fa-chevron-up"></i>
                                      </a>
                                      <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                          <i class="fa fa-wrench"></i>
                                      </a>
                                      <ul class="dropdown-menu dropdown-user">

                                          <li><a href="#">Config option 1</a>
                                          </li>
                                          <li><a href="#">Config option 2</a>
                                          </li>
                                      </ul>
                                      <a class="close-link">
                                          <i class="fa fa-times"></i>
                                      </a>
                                  </div>
                              </div>
                              <!-- sales Today -->
                              <div class="ibox-content">
                                 <div>
                                <canvas id="lineChartp" height="50"></canvas>
                            </div>

                                                 </div>
                                                 </div>
                                                 </div>

                                </div>

                         <div id="tab-22a" class="tab-pane ">
                                <div class="panel-body">
                                <div class="ibox float-e-margins">
                              <div class="ibox-title">

                                  <div class="ibox-tools">

                                      <a class="collapse-link">
                                          <i class="fa fa-chevron-up"></i>
                                      </a>
                                      <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                          <i class="fa fa-wrench"></i>
                                      </a>
                                      <ul class="dropdown-menu dropdown-user">

                                          <li><a href="#">Config option 1</a>
                                          </li>
                                          <li><a href="#">Config option 2</a>
                                          </li>
                                      </ul>
                                      <a class="close-link">
                                          <i class="fa fa-times"></i>
                                      </a>
                                  </div>
                              </div>
                              <div class="ibox-content">
    <!-- sales This week -->
                                <div>
                                <canvas id="lineChartsp" height="50"></canvas>
                            </div>

                                                 </div>
                                                 </div>

                                </div>
                                </div>
                                <div id="tab-23a" class="tab-pane ">
                                <div class="panel-body">
                                <div class="ibox float-e-margins">
                              <div class="ibox-title">

                                  <div class="ibox-tools">

                                      <a class="collapse-link">
                                          <i class="fa fa-chevron-up"></i>
                                      </a>
                                      <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                          <i class="fa fa-wrench"></i>
                                      </a>
                                      <ul class="dropdown-menu dropdown-user">

                                          <li><a href="#">Config option 1</a>
                                          </li>
                                          <li><a href="#">Config option 2</a>
                                          </li>
                                      </ul>
                                      <a class="close-link">
                                          <i class="fa fa-times"></i>
                                      </a>
                                  </div>
                              </div>
                              <div class="ibox-content">
    <!-- sales This Month --><div>
                                <canvas id="lineChartmp" height="50"></canvas>
                            </div>


                                                 </div>
                                                 </div>
                                                 </div>

                                </div>

                         <div id="tab-24a" class="tab-pane">
                                <div class="panel-body">
                                <div class="ibox float-e-margins">
                              <div class="ibox-title">

                                  <div class="ibox-tools">

                                      <a class="collapse-link">
                                          <i class="fa fa-chevron-up"></i>
                                      </a>
                                      <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                          <i class="fa fa-wrench"></i>
                                      </a>
                                      <ul class="dropdown-menu dropdown-user">

                                          <li><a href="#">Config option 1</a>
                                          </li>
                                          <li><a href="#">Config option 2</a>
                                          </li>
                                      </ul>
                                      <a class="close-link">
                                          <i class="fa fa-times"></i>
                                      </a>
                                  </div>
                              </div>
                              <div class="ibox-content">
  <!-- sales This Year --><div>
                                <canvas id="lineChartyp" height="50"></canvas>
                            </div>


                                                 </div>
                                                 </div>
                                                 </div>

                                </div>




                            </div>
                            </div>




                            </div>
                        </div>


                    </div>
                </div>


            <br><br><br>
             @include('includes.default.footer')
                   </div><!--container-->
                </div><!--content -->
            </div><!--content page-->
@endsection
