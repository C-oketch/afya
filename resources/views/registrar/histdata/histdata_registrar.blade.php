@extends('layouts.registrar_layout')
@section('title', 'Registrar Dashboard')
@section('content')
<?php $pat=$user->id; ?>

    @include('includes.registrar.topnavbar_v2')

    <div class="row wrapper border-bottom white-bg page-heading">
                  <div class="col-lg-4">
                      <h2>Actions</h2>
                      <ol class="breadcrumb">
                          <li>
                              <a href="index.html">Home</a>
                          </li>
                          <li class="active">
                              <strong>Patient Details</strong>
                          </li>
                      </ol>
                  </div>
                  <div class="col-lg-6">
                      <div class="title-action">
                        <a href="{{ route('registrar.RegUpHist',$pat) }}" class="btn btn-primary"><i class="fa fa-print"></i> Edit Details </a>
                        <a href="{{ url('registrar.shows',$pat) }}" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Back </a>
                      </div>
                  </div>
              </div>
<div class="wrapper wrapper-content animated fadeInRight">
      @include('registrar.private.first_time')

</div>
@endsection
    @section('script-reg')

@endsection
