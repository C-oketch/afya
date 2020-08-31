@extends('layouts.patient')
@section('title', 'Patient')
@section('content')

<div class="wrapper wrapper-content animated fadeInRight">
          <div class="row">
          <div class="col-lg-12">
              <div class="ibox float-e-margins">
                  <div class="ibox-title">
  <h5>Self Reporting Target Details </h5>
                      <div class="ibox-tools">
                          <a class="collapse-link">
                              <i class="fa fa-chevron-up"></i>
                          </a>
                          <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                              <i class="fa fa-wrench"></i>
                          </a>

                          <a class="close-link">
                              <i class="fa fa-times"></i>
                          </a>
                      </div>
                  </div>
                  <div class="ibox-content">
                      <div class="row">
                          <div class="col-sm-6 b-r">
                            <form class="form-horizontal">

                            <div class="form-group"><label class="col-lg-4 control-label">Temperature</label>
                                 <div class="col-lg-6">
                               <input type="text" value="{{$patientstarget->temptrgt}}" class="form-control" readonly ></div>
                            </div>
                            <div class="form-group"><label class="col-lg-4 control-label">BP</label>
                                 <div class="col-lg-6">
                               <input type="text" value="{{$patientstarget->bptrgt}}" class="form-control" readonly ></div>
                            </div>
                            <div class="form-group"><label class="col-lg-4 control-label">Weight</label>
                                 <div class="col-lg-6">
                               <input type="text" value="{{$patientstarget->weighttrgt}}" class="form-control" readonly ></div>
                            </div>
                            </form>



                          </div>
                          <div class="col-sm-6">
                            <form class="form-horizontal">
                            <div class="form-group"><label class="col-lg-4 control-label">Fasting Sugars</label>
                                 <div class="col-lg-6">
                               <input type="text" value="{{$patientstarget->fstrgt}}" class="form-control" readonly ></div>
                            </div>
                            <div class="form-group"><label class="col-lg-4 control-label">Before Meals Sugar</label>
                                 <div class="col-lg-6">
                               <input type="text" value="{{$patientstarget->bmstrgt}}" class="form-control" readonly ></div>
                            </div>
                            <div class="form-group"><label class="col-lg-4 control-label">Postprondrial_sugars</label>
                                 <div class="col-lg-6">
                               <input type="text" value="{{$patientstarget->ppstrgt}}" class="form-control" readonly ></div>
                            </div>
                            <br />
                             </form>
                            </div>

                      </div>
                  </div>
              </div>
          </div>
        </div>

<div class="row">
<div class="col-lg-12">
<div class="ibox float-e-margins">
  <div class="ibox-title">
    <h5>Self Reporting</h5>
    <div class="ibox-tools">
      <a class="collapse-link">
        <i class="fa fa-chevron-up"></i>
      </a>

      <a class="close-link">
        <i class="fa fa-times"></i>
      </a>
    </div>
  </div>
  <div class="ibox-content">


    <div class="table-responsive">
      <table class="table table-striped table-bordered table-hover dataTables-example" >
        <thead>
          <tr>
            <th>No</th>
            <th>Date </th>
            <th>Temperature</th>
            <th>Weight</th>
            <th>BP</th>
            <th>Fasting Sugars</th>
            <th>Before Meals Sugars</th>
            <th>Postprondrial Sugars</th>
        </tr>
        </thead>

        <tbody>
          <?php $i=1;
          ?>
          @foreach($selfs as $self)
          <tr>
            <td>{{$i}}</td>
            <td>{{$self->created_at}}</td>
            <td>{{$self->temperature}}</td>
            <td>{{$self->weight}}</td>
            <td>{{$self->bp}}</td>
            <td>{{$self->fasting_sugars}}</td>
            <td>{{$self->before_meal_sugars}}</td>
            <td>{{$self->postprondrial_sugars}}</td>
          </tr>
        <?php $i++; ?>
          @endforeach

        </tbody>
      </table>


    </div>
    <a href="{{URL('patient.addselfreport',$afyaId)}}" class="btn btn-primary btn-block">Add Details</a>
  </div>
</div>
</div>

  </div>
</div>
@endsection
