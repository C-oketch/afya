@extends('layouts.patient')
@section('title', 'Patient')
@section('content')
<div class="content-page  equal-height">
      <div class="content">
          <div class="container">
          <br><br><br><br><br>
         
 <div class="row">
        

            <div class="col-sm-5 col-sm-offset-1">

               <a href="{{URL('patient.self',$id)}}" class="btn btn-primary btn-block">{{'Self'}}</a>

            </div>
            <div class="col-sm-5">

                  <a href="{{URL('patient.dependant',$id)}}" class="btn btn-success btn-block">{{'Dependant'}}</a>

            </div>
          </div>
 
        </div>
</div>
@endsection
