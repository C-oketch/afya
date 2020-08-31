@extends('layouts.nhif')
@section('title', 'Nhif Users')
@section('content')
<?php  use App\Http\Controllers\Controller; ?>
<div class="content-page  equal-height">
          <div class="content">
              <div class="container">
              <div class="row">
              <div class="col-sm-8 col-sm-offset-2">
             
               <div class="panel-body">
                                <div class="ibox float-e-margins">
                              <div class="ibox-title">
                                  {{$patient->firstname}} {{$patient->secondname}}
                                    <div class="ibox-tools">
                                  <a class="btn btn-primary" href="{{ URL::previous() }}">back</a>
                                    
                                  </div>
                                 
                              </div>
                                

                              <div class="ibox-content">
                   <!-- sales All Custom-->
                                  <div class="table-responsive">

                    <div class="col-lg-6">                        
                      <div class="ibox">
                            <div class="ibox-content">
                                <h5>Nhif Number</h5>
                               {{$patient->nhif}}
                                
                            </div>
                      </div>
                    </div>

                    <div class="col-lg-6">                        
                      <div class="ibox">
                            <div class="ibox-content">
                                <h5>ID Number</h5>
                               {{$patient->nationalId}}
                                
                            </div>
                      </div>
                    </div>

                    <div class="col-lg-6">                        
                      <div class="ibox">
                            <div class="ibox-content">
                                <h5>Age</h5>
                               {{$patient->age}}
                                
                            </div>
                      </div>
                    </div>

                    <div class="col-lg-6">                        
                      <div class="ibox">
                            <div class="ibox-content">
                                <h5>Gender</h5>
                               {{Controller::gender($patient->gender)}}
                                
                            </div>
                      </div>
                    </div>


                     <div class="col-lg-6">                        
                      <div class="ibox">
                            <div class="ibox-content">
                                <h5>Phone Number</h5>
                               {{$patient->msisdn}}
                                
                            </div>
                      </div>
                    </div>

                    <div class="col-lg-6">                        
                      <div class="ibox">
                            <div class="ibox-content">
                                <h5>Phone Number</h5>
                               {{$patient->msisdn}}
                                
                            </div>
                      </div>
                    </div>

                    <div class="col-lg-6">                        
                      <div class="ibox">
                            <div class="ibox-content">
                                <h5>Email</h5>
                               {{$patient->email}}
                                
                            </div>
                      </div>
                    </div>

                    <div class="col-lg-6">                        
                      <div class="ibox">
                            <div class="ibox-content">
                                <h5>Place of Birth</h5>
                               {{$patient->pob}}
                                
                            </div>
                      </div>
                    </div>

                    <div class="col-lg-6">                        
                      <div class="ibox">
                            <div class="ibox-content">
                                <h5>Constituency</h5>
                               {{$patient->constituencyl}}
                                
                            </div>
                      </div>
                    </div>

                    <div class="col-lg-6">                        
                      <div class="ibox">
                            <div class="ibox-content">
                                <h5>Next of Kin</h5>
                               {{$patient->kin_name}}
                                
                            </div>
                      </div>
                    </div>

                  <div class="col-lg-6">                        
                      <div class="ibox">
                            <div class="ibox-content">
                                <h5>Kin Phone</h5>
                               {{$patient->phone_of_kin}}
                                
                            </div>
                      </div>
                    </div>

                    <div class="col-lg-6">                        
                      <div class="ibox">
                            <div class="ibox-content">
                                <h5>Next of Kin Relation</h5>
                               {{$patient->relation}}
                                
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
                   </div><!--container-->
                
@endsection
