@extends('layouts.welcome')
@section('content')
<div class="content-page  equal-height">
              <div class="content">
                  <div class="container">
                      <div class="page-title">
                          <h3>My Dashboard</h3>
                          <a href="#"><i class="fa fa-plus"></i> Add Widget</a>
                          <a href="#"><i class="fa fa-share"></i> Share</a>
                          <a href="#"><i class="fa fa-envelope"></i> Email</a>
                      </div><!--end page title-->

                      <div class="widget-row">
                          <div class="row">
                              <div class="col-lg-4">
                                  <div class="widget-box clearfix">
                                      <div class="pull-left">
                                          <h4>User Performance</h4>
                                          <h2>17,50</h2>
                                      </div>
                                      <div class="text-right">
                                          <span id="sparkline8"></span>
                                      </div>
                                  </div>
                              </div>
                              <div class="col-lg-8">
                                  <div class="row">
                                      <div class="col-md-3">
                                          <div class="widget-box clearfix">
                                              <div>
                                                  <h4>Total new orders</h4>
                                                  <h2>580 <i class="fa fa-plus pull-right"></i></h2>
                                              </div>
                                          </div>
                                      </div>
                                      <div class="col-md-3">
                                          <div class="widget-box clearfix">
                                              <div>
                                                  <h4>Total sale today</h4>
                                                  <h2>$970 <i class="fa fa-shopping-cart pull-right"></i></h2>
                                              </div>
                                          </div>
                                      </div>
                                      <div class="col-md-3">
                                          <div class="widget-box clearfix">
                                              <div>
                                                  <h4>Pending Orders</h4>
                                                  <h2>256 <i class="fa fa-tasks pull-right"></i></h2>
                                              </div>
                                          </div>
                                      </div>
                                      <div class="col-md-3">
                                          <div class="widget-box clearfix">
                                              <div>
                                                  <h4>Total Income</h4>
                                                  <h2>$9.7k <i class="fa fa-usd pull-right"></i></h2>
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div><!--end widget-->

                      <div class="row">
                          <div class="col-sm-8">
                              <div class="panel-box">
                                  <h4>Total Product Sales</h4>
                                  <div>
                                      <canvas id="lineChart" height="120"></canvas>
                                  </div>


                              </div>
                          </div>
                          <div class="col-sm-4">
                              <div class="panel-box">
                                  <h4>Monthly sale Compare</h4>
                                  <canvas id="polarChart" height="242"></canvas>

                              </div>
                          </div>
                      </div>

                      <div class="row">
                          <div class="col-sm-4">
                              <div class="panel-box">
                                  <h4>Weekly Overview</h4>
                                  <div>
                                      <canvas id="barChart" height="150"></canvas>
                                  </div>

                              </div>
                          </div>
                          <div class="col-sm-4">
                              <div class="panel-box">
                                  <h4>Radar Chart</h4>
                                  <div>
                                      <canvas id="radarChart"></canvas>
                                  </div>
                              </div>
                          </div>
                          <div class="col-sm-4">
                              <div class="panel-box">
                                  <h4>Browser Support</h4>
                                  <div>
                                      <canvas id="doughnutChart" height="150"></canvas>
                                  </div>

                              </div>
                          </div>
                      </div>

                      <div class="row">
                          <div class="col-sm-6">
                              <div class="panel-box">
                                  <h4>Overall Sales Average</h4>
                                  <div id="morris-line-chart"></div>
                              </div>
                          </div>
                          <div class="col-sm-6">
                              <div class="panel-box">

                                  <div class="table-responsive">
                                      <table class="table">
                                          <thead>
                                              <tr>
                                                  <th>Name</th>
                                                  <th>Phone</th>
                                                  <th>Street Address</th>
                                                  <th>% Share</th>

                                                  <th>Action</th>
                                              </tr>
                                          </thead>
                                          <tbody>
                                              <tr>
                                                  <td>Abraham</td>
                                                  <td>076 9477 4896</td>
                                                  <td>294-318 Duis Ave</td>
                                                  <td><div class="sparkline8"><canvas width="17" height="17" style="display: inline-block; width: 17px; height: 17px; vertical-align: top;"></canvas></div> </td>

                                                  <td><a href="#" class="btn btn-default btn-xs">View</a></td>
                                              </tr>
                                              <tr>
                                                  <td>Phelan</td>
                                                  <td>0500 034548</td>
                                                  <td>680-1097 Mi Rd.</td>
                                                  <td><div class="sparkline10"><canvas width="17" height="17" style="display: inline-block; width: 17px; height: 17px; vertical-align: top;"></canvas></div></td>

                                                  <td><a href="#" class="btn btn-default btn-xs">View</a></td>
                                              </tr>
                                              <tr>
                                                  <td>Raya</td>
                                                  <td>(01315) 27698</td>
                                                  <td>Ap #289-8161 In Avenue</td>
                                                  <td><div class="sparkline11"><canvas width="17" height="17" style="display: inline-block; width: 17px; height: 17px; vertical-align: top;"></canvas></div></td>

                                                  <td><a href="#" class="btn btn-default btn-xs">View</a></td>
                                              </tr>
                                              <tr>
                                                  <td>Azalia</td>
                                                  <td>0500 854198</td>
                                                  <td>226-4861 Augue. St.</td>
                                                  <td><div class="sparkline12"><canvas width="17" height="17" style="display: inline-block; width: 17px; height: 17px; vertical-align: top;"></canvas></div></td>

                                                  <td><a href="#" class="btn btn-default btn-xs">View</a></td>
                                              </tr>
                                              <tr>
                                                  <td>Garth</td>
                                                  <td>(01662) 59083</td>
                                                  <td>3219 Elit Avenue</td>
                                                  <td><div class="sparkline13"><canvas width="17" height="17" style="display: inline-block; width: 17px; height: 17px; vertical-align: top;"></canvas></div></td>

                                                  <td><a href="#" class="btn btn-default btn-xs">View</a></td>
                                              </tr>
                                              <tr>
                                                  <td>Garth</td>
                                                  <td>(01662) 59083</td>
                                                  <td>3219 Elit Avenue</td>
                                                  <td><div class="sparkline13"><canvas width="17" height="17" style="display: inline-block; width: 17px; height: 17px; vertical-align: top;"></canvas></div></td>

                                                  <td><a href="#" class="btn btn-default btn-xs">View</a></td>
                                              </tr>
                                              <tr>
                                                  <td>Garth</td>
                                                  <td>(01662) 59083</td>
                                                  <td>3219 Elit Avenue</td>
                                                  <td><div class="sparkline13"><canvas width="17" height="17" style="display: inline-block; width: 17px; height: 17px; vertical-align: top;"></canvas></div></td>

                                                  <td><a href="#" class="btn btn-default btn-xs">View</a></td>
                                              </tr>
                                              <tr>
                                                  <td>Garth</td>
                                                  <td>(01662) 59083</td>
                                                  <td>3219 Elit Avenue</td>
                                                  <td><div class="sparkline13"><canvas width="17" height="17" style="display: inline-block; width: 17px; height: 17px; vertical-align: top;"></canvas></div></td>

                                                  <td><a href="#" class="btn btn-default btn-xs">View</a></td>
                                              </tr>
                                          </tbody>
                                      </table>
                                  </div>
                              </div>
                          </div>
                      </div>

                  </div><!--content-->
              </div><!--content page-->
          </div><!--end wrapper-->
@endsection
