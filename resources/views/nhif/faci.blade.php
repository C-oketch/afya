@extends('layouts.nhif')
@section('title', 'Nhif Dashboard')
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
                            <strong>Facility</strong>
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
                    <div class="col-lg-4">
                        
                        <div class="ibox">
                            <div class="ibox-content">
                                <h5>Patients<a href="{{url('faci-patients?facilitycode='.$facilitycode)}}"> <h1 class="no-margins">{{$patients}}</h1></a>
                                
                            </div>
                        </div>
                     
                    </div>
                    <div class="col-lg-4">
                        <div class="ibox">
                            <div class="ibox-content">
                                <h5>Doctors</h5>
                            <a href="{{url('faci-doctors?facilitycode='.$facilitycode)}}"><h1 class="no-margins">{{$doctors}}</h1></a>                                
                            </div>
                        </div>
                    </div>
                  
                </div>


        <div class="row">
                    <div class="col-lg-4">
                        
                        <div class="ibox">
                            <div class="ibox-content">
                                <h5>Patient to Doctor Engagement</h5>
                               <a href="{{url('gov-facilities')}}"> <h1 class="no-margins">20:1</h1></a>
                                
                            </div>
                        </div>
                     
                    </div>
                    <div class="col-lg-4">
                        <div class="ibox">
                            <div class="ibox-content">
                                <h5>Number of Visits</h5>
                            <a href="{{url('priv-facilities')}}"><h1 class="no-margins">{{$doctors}}</h1></a>                                
                            </div>
                        </div>
                    </div>
                   
                </div>


               


 </div>



 </div>



</div>
</div><!--container-->
                
@endsection
