@extends('layouts.nhif')
@section('title', 'Nhif Dashboard')
@section('content')
<div class="content-page  equal-height">
          <div class="content">
              <div class="container">
              <br><br>
  <div class="col-sm-6  col-sm-offset-2">
  <div class="ibox-title">
      <h5>Enter a claim</h5>

  </div>
        <div class="ibox-content">
        <form class="form-horizontal" role="form" method="POST" action="{{route('claims.store')}}" novalidate>
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
          
          
          <div class="form-group">
           <label for="exampleInputEmail1">Facility</label>
             <select name="facility_id" data-placeholder="facility..." class="chosen-select"  tabindex="2">
              <option value="">Select</option>
              @foreach ($facilities as $faci)
              <option value="{{$faci->FacilityCode}}">{{$faci->FacilityName}}</option>
              @endforeach
            </select>
          </div>

          <div class="form-group">
           <label for="exampleInputEmail1">Nhif Member Number</label>
             <select name="nhif" data-placeholder="nhif..." class="chosen-select"  tabindex="2">
              <option value="">Select</option>
              @foreach ($users as $user)
              <option value="{{$user->nhif}}">{{$user->nhif}}</option>
              @endforeach
            </select>
          </div>

          <div class="form-group">
           <label for="exampleInputEmail1">Doctor/ Clinical Officer</label>
             <select name="doc_co_id" data-placeholder="doctor.." class="chosen-select"  tabindex="2">
              <option value="">Select</option>
              @foreach ($doctors as $doc)
              <option value="{{$doc->id}}">{{$doc->name}}</option>
              @endforeach
            </select>
          </div>

          <div class="form-group">
           <label for="exampleInputEmail1">Procedure Code</label>
             <select name="procedure_code" data-placeholder="procedure.." class="chosen-select"  tabindex="2">
              <option value="">Select</option>
              @foreach ($procedures as $procedure)
              <option value="{{$procedure->icd10_codes}}">{{$procedure->description}}</option>
              @endforeach
            </select>
          </div>



          <div class="form-group">
             <label for="exampleInputPassword1">Treatment</label>
             <textarea name="treatment" class="form-control"></textarea>
          </div>
             
          <div class="form-group">
             <label for="exampleInputPassword1">Cost</label>
             <input type="number" class="form-control" name="cost"/>
          </div>
            
             
          <button type="submit" class="btn btn-primary">Save</button>
     {!! Form::close() !!}
    </div>
</div>



</div>
                   </div><!--container-->

@endsection
