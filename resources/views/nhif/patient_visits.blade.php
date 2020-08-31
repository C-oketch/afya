@extends('layouts.nhif')
@section('title', 'Claims')
@section('content')
<div class="content-page  equal-height">
          <div class="content">
              <div class="container">
              <div class="row">
              <div class="col-sm-12">
             
               <div class="panel-body">
                                <div class="ibox float-e-margins">
                              <div class="ibox-title">
                                  <h5>{{$patients[0]->FacilityName}}</h5>
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
                   <!-- sales All Custom-->
                                  <div class="table-responsive">
                               
                        <table class="table table-striped table-bordered table-hover dataTables-example" >
                              <thead>


                                                      <tr>
                                                     <th>Name</th>
                                                     <th>Nhif No</th>
                                                     <th>Doctor</th>
                                                     <th>Procedure</th>
                                                     <th>Treatment</th>
                                                     <th>Cost</th>
                                                     <th>Submitted on</th>
                                                     


                                                         </tr>

                                                  </thead>

                                                  <tbody>
                                                 
                                                @foreach ($patients as $claim)
                                                    <tr>
                                                      
                                                      <td><a href="{{url('patient-claiming?ptn='.$claim->ptn)}}">{{$claim->firstname}} {{$claim->secondName}}</a></td>
                                                      <td>{{$claim->nhif}}</td>
                                                      <td>{{$claim->docname}}</td>
                                                      <td>{{$claim->procedure_code}}</td> 
                                                      <td>{{$claim->treatment}}</td>
                                                      <td>{{$claim->cost}}</td> 
                                                      <td>{{$claim->created_at}}</td>
                                                                          
                                                    </tr>
                                                @endforeach
                                                   </tbody>

                                                 </table>
                                                 </div>
                                                 </div>
                                                 </div>

                                </div>
                                </div>
 


 </div>



</div>
                   </div><!--container-->
                
@endsection
