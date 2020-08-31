@extends('layouts.registrar_layout')
@section('content')
<div class="row">

</div>
 <div class="row">
<div class="col-lg-7">
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5>Self Reported Surgical Procedures</h5>
            <div class="ibox-tools">
                <a class="btn btn-success" href="{{route('private.show',$id)}}"><i class="fa fa-arrow-left"></i>GO BACK</a>

            </div>
        </div>
        <div class="ibox-content">
            <div class="row">
                <div>
                    <p>Add Self Reported Surgical Procedures.</p>
                    {!! Form::open(array('route' => 'surgical-private','method'=>'POST')) !!}
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" value="{{$id}}" name="afya_user_id">
               <div class="form-group">
                    <label class="control-label" for="name">Procedure Name</label>
                    <input type="text" name="name_of_surgery" class="form-control" required="true">
                    </div>

                  <div class="form-group" id="data_3">
                    <label class="font-normal">Procedure Date</label>
                    <div class="input-group date">
                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                    <input type="text" class="form-control" name="surgery_date" value="01/01/2018">
                    </div>
                    </div>

                          <button type="submit" class="btn btn-primary">Submit</button>
                        {!! Form::close() !!}
                        </div>
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
