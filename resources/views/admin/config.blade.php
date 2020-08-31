
@extends('layouts.admin')

@section('content')
<div class="content-page  equal-height">
          <div class="content">
              <div class="container">
  <div class="row">
   <div class="col-lg-6">
                      <section class="panel">
                          <header class="panel-heading">
                              <h3>Basic Settings</h3>
                          </header>
                          <ul class="list-group">
                              <li class="list-group-item"><a href="{{ url('kins') }}">KINS</a></li>
                              <li class="list-group-item"><a href="{{ url('facility') }}">FACILITIES</a></li>
                              <li class="list-group-item"><a href="{{ url('county') }}">COUNTY</a></li>
                              <li class="list-group-item"><a href="{{ url('constituency') }}">CONSTITUENCIES</a></li>



                          </ul>
                      </section>
                  </div>
                  <div class="col-lg-6">
                      <section class="panel">
                          <header class="panel-heading">
                              <h3>Medical Settings</h3>
                          </header>
                          <div class="list-group">
                              <li class="list-group-item"><a href="{{ url('allergy') }}">
                                 ALLERGIES
                              </a>
                              <li class="list-group-item"><a href="{{ url('illness') }}">ILLNESSES</a></li>
                              <li class="list-group-item"><a href="{{ url('diseases') }}">DISEASES</a></li>
                              <li class="list-group-item"><a href="{{ url('chronic') }}">CHRONIC ILLNESSES</a></li>

                              
                          </div>
                      </section>
                  </div>




</div>
                   </div><!--container-->
                </div><!--content -->
            </div><!--content page-->
@endsection
