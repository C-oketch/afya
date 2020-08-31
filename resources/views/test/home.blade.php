@extends('layouts.test')
@section('title', 'Tests')
@section('content')


					<div class="row wrapper border-bottom white-bg page-heading">
					  <div class="col-md-6">
					    <address>
					      <br />
					      <strong>FACILITY :</strong><br>
					      <strong> Name :</strong>{{$facid->FacilityName}}<br>
					      <strong> Type :</strong> {{$facid->Type}}<br>
					    </address>
					  </div>
					  <div class="col-md-6 text-right">
					    <address>
					      <br /><br />
					      <strong>DATE :</strong><br>
					      {{date("l jS \of F Y ")}}
					    </address>
					  </div>
					</div>

         	<div class="wrapper wrapper-content animated fadeInRight">
						@if($facid->department==='Laboratory')

<?php if ($facid->speciality==='Registrar') {?>
	@include('test.labreg')
<?php } else { ?>
@include('test.lab')
<?php } ?>


						@elseif($facid->department ==='Radiology')

						<?php
						if ($facid->speciality==='Registrar') {?>
							@include('test.radyreg')
						<?php } else { ?>
						@include('test.rady')
						<?php } ?>


						@endif

		   </div>


@endsection
