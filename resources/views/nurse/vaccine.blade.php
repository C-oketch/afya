@extends('layouts.app')
@section('content')
  <div class="row">
    <div class="col-lg-6 col-md-offset-2">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Vaccines Details</h5>
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


    <div class="multi-fields">
      <form class="form" role="form" method="POST" action="/vaccine" novalidate>
     <input type="hidden" name="_token" value="{{ csrf_token() }}">


                <div class="form-group">
                <input type="hidden" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="{{$id}}" name="id"  required>
                <div class="form-group">

                 <label class="control-label" for="validateSelect">Diseases</label>
                  <select  name="diseases" class="form-control" data-parsley-required="true">
                   <?php  $diseases = DB::table('vaccine')->get();?>
                  @foreach($diseases as $disease)
                   <option value="{{$disease->id}}">{{$disease->disease}}</option>
                 @endforeach
                </select>
                </div>

                <div class="form-group">
                  <label class="control-label" for="name">Vaccine Name</label>
                  <input type="text" name="vaccinename" class="form-control" data-parsley-required="true">
                </div>
              <div class="form-group">
            <label class="control-label" for="name">Vaccinated ?</label>
            <input type="radio" value="no" id="type" name="type" checked='checked' autocomplete="off" />
              <label>No</label>
                    <input type="radio" value="yes" id="type" name="type" class="youtube" />
                  <label>Yes</label>


              </div>


      <!-- <button type="button" class="remove-field">Remove</button> -->
        <a href="javascript:void(0);" class="remove-field" title="Remove field"><i class="glyphicon glyphicon-minus-sign fa-4x" aria-hidden="true"></i></a>


        <!-- <button type="button" class="add-field">Add field</button> -->
      <a href="javascript:void(0);" class="add-field" title="Addfield"><i class="glyphicon glyphicon-plus-sign fa-4x" aria-hidden="true"></i></a>
      <br><br>
     <button type="submit" class="btn btn-primary">Save</button>
      {!! Form::close() !!}
               </div>  <!-- /.form-group -->

              </div>
              </div>
    </div>
    </div>
 </div>
</div>
@endsection
