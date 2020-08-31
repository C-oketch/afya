@extends('layouts.facilityadmin')
@section('title', 'Dashboard')
@section('content')
<?php $image=''; ?>
<div class="wrapper wrapper-content animated fadeInRight">
  <div class="row">
  <div class="col-lg-5">
		<div class="ibox float-e-margins">
				<div class="ibox-title">
						<h5>UPLOAD Receipt Logo :</h5>
				</div>
        <?php

        $id = Auth::id();
      $image = DB::table('facility_admin')
      ->join('logo_imgs', 'facility_admin.facilitycode', '=', 'logo_imgs.facility')
      ->select('logo_imgs.id','logo_imgs.directory')
     ->where('facility_admin.user_id', '=',$id)->first();
         ?>
        @if($image)
        <div class="ibox-content">
            <div class="row">
<img alt="image" class="img-circle" src="{{ asset("/img/logos/$image->directory") }}" height="150" width="150"/>
           </div>
       </div>
        @else
				<div class="ibox-content">
						<div class="row">

										<p>Please upload only images with relevant Information.</p>
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
										{!! Form::open(array('url' => 'upimagespst','files'=>true)) !!}
												<div class="form-group"><label>Choose file:</label><input type="file" name="image"  class="form-control"></div>

												<div>
														<button class="btn btn-sm btn-primary pull-right m-t-n-xs" type="submit"><strong>SUBMIT</strong></button>

												</div>
										{!! Form::close() !!}
						</div>
				</div>
        @endif
		   </div>
    </div>
  </div>
</div>

@include('includes.default.footer')

@endsection
