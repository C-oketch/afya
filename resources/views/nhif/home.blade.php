@extends('layouts.nhif')
@section('title', 'Nhif Dashboard')
@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>Nhif Dashboard</h2>
                    <ol class="breadcrumb">
                        <li>
                            <a href="index.html">Home</a>
                        </li>
                        <li>
                            <a>Nhif</a>
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
                                <h5>Outpatient</h5>
                               <a href="{{url('dashboard-details?dep=outpatient')}}"> <h1 class="no-margins">{{$outpatient}}</h1></a>
                                
                            </div>
                        </div>
                     
                    </div>
                    <div class="col-lg-3">
                        <div class="ibox">
                            <div class="ibox-content">
                                <h5>Inpatient</h5>
                            <a href="{{url('dashboard-details?dep=inpatient')}}"><h1 class="no-margins">{{$inpatient}}</h1></a>                                
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="ibox">
                            <div class="ibox-content">
                                <h5>Maternity</h5>
                                <a href="{{url('dashboard-details?dep=matarnity')}}"><h1 class="no-margins">{{$maternity}}</h1></a>
                                
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="ibox">
                            <div class="ibox-content">
                                <h5>Renal</h5>
                                <a href="{{url('dashboard-details?dep=renal')}}"><h1 class="no-margins">{{$renal}}</h1></a>
                                
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="ibox">
                            <div class="ibox-content">
                                <h5>Radiology</h5>
                                <a href="{{url('dashboard-details?dep=radiology')}}"><h1 class="no-margins">{{$radiology}}</h1></a>
                                
                            </div>
                        </div>
                    </div>

                     <div class="col-lg-3">
                        <div class="ibox">
                            <div class="ibox-content">
                                <h5> Oncology</h5>
                            <a href="{{url('dashboard-details?dep=oncology')}}"><h1 class="no-margins">{{$oncology}}</h1></a>
                                
                            </div>
                        </div>
                    </div>
               
                 <div class="col-lg-3">
                        <div class="ibox">
                            <div class="ibox-content">
                                <h5>Facilities</h5>
                                <a href="{{url('dashboard-details')}}"><h1 class="no-margins">{{$faci}}</h1></a>
                                
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
