@extends('layouts.admin')
@section('title', 'Admin Add Test')
@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
          <div class="content">
              <div class="container">



  <div class="row wrapper border-bottom white-bg page-heading col-lg-11">

               <div class="ibox-title">
                 <h5></h5>
               </div>
<form class="form-horizontal" role="form" method="POST" action="/addingtestsb" novalidate>
    <input type="hidden" name="_token" value="{{ csrf_token() }}">

<div class="col-lg-4 col-md-offset-4">
<div class="form-group">
<label>Overall Category</label>
<input type="text" class="form-control" value="{{$tests->oname}}" readonly="">
</div>
<div class="form-group">
<label>Category</label>
<input type="text" class="form-control" value="{{$tests->cname}}" readonly="">
</div>
<div class="form-group">
<label>Sub-Category</label>
<input type="text" class="form-control" value="{{$tests->sname}}" readonly="">
<input type="hidden" class="form-control" value="{{$tests->test_id}}" name="main_test">
</div>

<div class="form-group">
<label>Test </label>
<input type="text" class="form-control"  value="{{$tests->test_name}}">
</div>
<!-- <div class="form-group">
    <label>Sub Test:</label>
     <select id="facility" name="facility" class="form-control facility" style="width: 100%"></select>
</div> -->
<div class="form-group">
<label for="tag_list" class="">Tests:</label>
<select class="test-multiple" name="sub_test" class="form-control"  style="width: 100%">
<?php $tests=DB::table('tests')
->distinct()->get(['tests.id','tests.name']); ?>
@foreach($tests as $tsts)
<option value='{{$tsts->id}}'>{{$tsts->id}}-{{$tsts->name}}</option>
@endforeach
</select>
</div>

<div class="text-center">
    <button type="submit" class="btn btn-primary">Save</button>
</div>
</div>
{!! Form::close() !!}

</div>
</div>
</div>
</div><!--container-->
<!--container-->
@endsection
