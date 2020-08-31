@extends('layouts.registrar_layout')
@section('content')
<div class="row">

</div>
 <div class="row">
<div class="col-lg-7">
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5>Patient chronic diseases</h5>
            <div class="ibox-tools">
                <a class="btn btn-success" href="{{url('registrar.shows',$id)}}"><i class="fa fa-arrow-left"></i>GO BACK</a>

            </div>
        </div>
        <div class="ibox-content">
            <div class="row">
                <div>
                    <p>Add Patient chronic diseases.</p>
                    {!! Form::open(array('url' => 'add_chronicprvt','method'=>'POST')) !!}
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden"  value="{{$id}}" name="afya_user_id"  required>
          <div class="form-group">
          <div class="form-group">
          <label  class="col-md-6">Chronic Diseases:</label>
          <select id="facility" name="chronic" class="form-control chronic1" style="width: 100%"></select>
          </div>
          </div>
          <div class="form-group" id="data_3">
            <label class="font-normal">Procedure Date</label>
            <div class="input-group date">
            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
            <input type="text" class="form-control" name="chronic_date" value="01/01/2018">
            </div>
            </div>

                          <button type="submit" class="btn btn-primary">Submit</button>
                        {!! Form::close() !!}

                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
 </div>
@endsection
 @section('script')
  <!-- Page-Level Scripts -->

 @endsection
