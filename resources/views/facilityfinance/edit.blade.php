@extends('layouts.facilityadmin')
@section('title', 'Edit')
@section('content')
<div class="content-page  equal-height">
          <div class="content">
              <div class="container">






<div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5> Edit Finance Officers</h5>
                        <div class="ibox-tools">
               <a class="btn btn-primary" href="{{ route('facility-finance.index') }}"> Back</a>
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

                        

  @if (count($errors) > 0)
<div class="alert alert-danger">
  <strong>Whoops!</strong> There were some problems with your input.<br><br>
<ul>
  @foreach ($errors->all() as $error)
<li>{{ $error }}</li>
  @endforeach
</ul>
</div>
@endif
{!! Form::model($officers, ['method' => 'PATCH','route' => ['facility-finance.update', $officers->id]]) !!}
<div class="row">
<div class="col-xs-4 col-sm-4 col-md-4">
<div class="form-group">
<strong>Name:</strong>
{!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control')) !!}
</div>
  </div>
  <div class="col-xs-4 col-sm-4 col-md-4">
  <div class="form-group">
<strong>Email:</strong>
{!! Form::text('email', null, array('placeholder' => 'Email','class' => 'form-control')) !!}
</div>
</div>



  {!! Form::hidden('role','FacilityFinance')!!}

<div class="col-xs-12 col-sm-12 col-md-12 text-center">
<button type="submit" class="btn btn-primary">Submit</button>
</div>
</div>
  {!! Form::close() !!}



                    </div>
                </div>
            </div>
            </div>
        </div>


</div><!--container-->
</div><!--content -->
</div><!--content page-->
@endsection


