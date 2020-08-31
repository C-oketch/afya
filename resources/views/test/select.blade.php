@extends('layouts.test')
@section('title', 'Tests')
@section('content')

<div class="row">
	<br /><br /><br /><br /><br /><br />
	<div class="col-sm-5 col-sm-offset-1">

				 <a href="{{URL('test.pinfo',$id)}}" class="btn btn-primary btn-block">{{'Self'}}</a>

			</div>
			<div class="col-sm-5">

						<a href="{{URL('registrar.dependant',$id)}}" class="btn btn-success btn-block">{{'Dependant'}}</a>
</div>
</div>

@endsection
