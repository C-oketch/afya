@extends('layouts.pharmacy')
@section('title', 'Pharmacy')
@section('content')

             <?php

             $facilitycode=DB::table('pharmacists')
             ->where('user_id',Auth::user()->id)
             ->first();

            ?>
<div class="wrapper wrapper-content animated fadeInRight">
  <br><br><br><br><br><br>


  <div class="row">
            <div class="col-sm-5 col-sm-offset-1">
               <a href="{{URL('pharmacy.showparent',$id)}}" class="btn btn-primary btn-block">{{'Self'}}</a>
            </div>

            <div class="col-sm-5">
                  <a href="{{URL('pharmacy.showdependant',$id)}}" class="btn btn-success btn-block">{{'Dependant'}}</a>
            </div>

          </div>

        </div>


     @endsection
