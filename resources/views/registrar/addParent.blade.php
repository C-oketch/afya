@extends('layouts.registrar_layout')
@section('title', 'Registrar Dashboard')
@section('content')
<br><br><br>
<div class="row">
     <div class="col-lg-6 col-md-offset-3">
    <div class="ibox-title">
        <h5>Add Parent</h5>

    </div>

    <div class="ibox-content">


          <div class="row">
          <div class="col-md-12">
             {!! Form::open(array('url' => 'addParent','method'=>'POST')) !!}
              <input type="hidden" name="_token" value="{{ csrf_token() }}">

          <input type="hidden" name="dep_id" value="{{$dep_id}}">
           <input type="hidden" name="user_id" value="{{$id}}">

          <div class="form-group">
          <label for="first">First Name</label>
          <input type="name" class="form-control" name="first" value="{{ old('first') }}" required=""/>
          </div>

          <div class="form-group">
          <label for="second">Second Name</label>
          <input type="name" class="form-control" name="second" value="{{ old('second') }}" required=""/>
          </div>

          <div class="form-group {{$errors->has('phone') ? 'has-error' : ''}}">
          <label for="phone">Phone (2547---)</label>
          <input type="number" class="form-control"  name="phone" value="{{ old('phone') }}" required=""/>
          <span class="text-danger">{{ $errors->first('phone') }}</span>
          </div>

          <div class="form-group">
          <label for="gender">Gender</label>
          <input type="radio" value="Male" @if( old('gender') == 'Male') checked @endif name="gender" required="" />
          <label>Male</label>
          <input type="radio" value="Female" @if( old('gender') == 'Female') checked @endif name="gender" required="" />
          <label>Female</label>
          </div>

          <div class="form-group" id="data_2">
           <label for="age">Date of Birth</label>
           <div class="input-group date">
               <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
               <input type="text" class="form-control daily" name="age" value="{{ old('age') }}" required=""/>
           </div>
           </div>


           <div class="form-group">
             <label for="exampleInputPassword1">Relationship</label>
            <select class="form-control {{ $errors->has('relationship') ? 'has-error' : '' }}" name="relationship" required="">
              <option selected value="{{ old('relationship') }}" >{{ old('relationship') }}</option>
              <?php
              $kin = DB::table('kin')
                  ->select('relation')
                  ->where('relation', '<>', old('relationship'))
                  ->get();
               ?>
                @foreach($kin as $kn)
                 <option value="{{$kn->relation}}">{{$kn->relation}}</option>
               @endforeach
              </select>
              </div>

          <button class="btn btn-sm btn-primary" type="submit"><strong>Add</strong></button>

          {{ Form::close() }}
            </div>
            </div>





     </div>
   </div>
    </div>


@include('includes.default.footer')
</div>


</div>

@endsection
