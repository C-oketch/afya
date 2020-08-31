@extends('layouts.pharmacy')
@section('title', 'Pharmacy')
@section('content')

<div class="wrapper wrapper-content animated fadeInRight">
     <div class="row">
    <div class="col-lg-6">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Customer Information</h5>

            </div>
            <div class="ibox-content">
              <?php
              $user = DB::table('afya_users')
              ->where('id', '=', $id)
              ->first();

                  ?>

                  <form class="form-horizontal" role="form" method="POST" action="/update_parent_dob" >

                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    <input type="hidden" class="form-control" name="afya_user_id" value="{{$id}}" readonly="">

                  <div class="form-group" >
                   <label for="exampleInputPassword1">Date of Birth</label>
                   <div class="input-group date">
                       <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                       <input type="text" class="form-control" id="date_2" name="dob" value="{{$user->dob}}" >
                   </div>
                   </div>

                     <button type="submit" class="btn btn-primary btn-sm">Update Details</button>
                     </form>

          </div>
        </div>
      </div>

    </div>
  </div>


      <br>


@endsection

@section('date-script')
<script src="{{ asset('js/plugins/datapicker/bootstrap-datepicker.js') }}" type="text/javascript"></script>
@endsection
