@extends('layouts.registrar_layout')
@section('title', 'Registrar Dashboard')
@section('content')




  <div class="col-sm-8  col-sm-offset-2" style="text-align:left;">
  <br>
  <div class="ibox-title">
      <h5>Dependant Details</h5>
      <?php $kin=DB::table('kin_details')->where('id',$id)->first(); ?>

  </div>
         <div class="ibox-content">
               <form class="form-horizontal" role="form" method="POST" action="/register_update_nextkin" >
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
              <input type="hidden" class="form-control" id="exampleInputEmail1"  value="{{$id}}" name="id"  required>
              <input type="hidden" name="user" value="{{$kin->afya_user_id}}">

              <div class="form-group">
              <label for="exampleInputPassword1">Kin Name</label>
              <input type="name" class="form-control" id="exampleInputEmail1" value="{{$kin->kin_name}}"  name="name" required="">
              </div>

              <div class="form-group">
             <label for="exampleInputPassword1">Kin Phone </label>
             <input type="name" class="form-control" id="exampleInputEmail1" value="{{$kin->phone_of_kin}}" name="phone"  required="">
             </div>


              <div class="form-group">
               <label for="exampleInputPassword1">Relationship</label>
              <select class="form-control" name="relationship">
              <?php  $kin = DB::table('kin')->get();?>
                  @foreach($kin as $kn)
                   <option value="{{$kn->id}}">{{$kn->relation}}</option>
                 @endforeach
                </select>
              </div>


              <button type="submit" class="btn btn-primary btn-sm">Update Details</button>
                 {!! Form::close() !!}
               </div>



</form>
</div>

            @include('includes.default.footer')
             </div>


            @endsection
