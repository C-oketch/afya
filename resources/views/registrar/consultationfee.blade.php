@extends('layouts.registrar_layout')
@section('title', 'Registrar Dashboard')
@section('content')
<div class="col-lg-6 col-md-offset-2">
    <div class="ibox float-e-margins">
      <div class="ibox-title">
          <h5>Patient Details</h5>
       <?php   $facilitycode=DB::table('facility_registrar')->where('user_id', Auth::user()->id)->first(); ?>


      </div>
      <div class="ibox-content">
      <form class="form-horizontal" role="form" method="POST" action="/consultationfee" novalidate>

  <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" class="form-control" id="exampleInputEmail1S" aria-describedby="emailHelp" value="{{$id}}" name="id"  required>
    <input type="hidden" name="facility" value="{{$facilitycode->facilitycode}}">
    <div class="form-group">
    <label for="exampleInputEmail1">Consultation descr</label>
    <input type="name" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Descr" name="descr"  required>
    </div>

      <div class="form-group">
  <label class="control-label" for="name">Consultation Fee ?</label>
  <input type="radio" value="no" id="type" name="type" checked='checked' autocomplete="off" />
    <label>No</label>
          <input type="radio" value="yes" id="type" name="type" class="youtube" />
        <label>Yes</label>
        <div id="embedcode">
      Payment Mode: <select name="mode"><option value="">Select</option><option value="Cash">Cash</option><option value="Mpesa">Mpesa</option><option value="Insurance">Insurance</option></select>
       Amount: <input type="number"  placeholder="Amount" name="amount" >
      </div>
    </div>

    <button type="submit" class="btn btn-primary btn-sm">Update Details</button>
      {!! Form::close() !!}
      </div>
    </div>
  </div>
</div>







    </div>
  @include('includes.default.footer')


@endsection
