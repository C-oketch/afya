@extends('layouts.registrar_layout')
@section('content')
<div class="row">

</div>
 <div class="row">
<div class="col-lg-7">
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5>Self Reported Medication</h5>
            <div class="ibox-tools">
                <a class="btn btn-success" href="{{route('private.show',$id)}}"><i class="fa fa-arrow-left"></i>GO BACK</a>

            </div>
        </div>
        <div class="ibox-content">
            <div class="row">
                <div>
                    <p>Add Self Reported Medication.</p>
                    {!! Form::open(array('route' => 'selfmeds','method'=>'POST')) !!}
                  <input type="hidden" name="_token" value="{{ csrf_token() }}">
                  <input type="hidden" value="{{$id}}" name="afya_user_id">
                       <div class="form-group">
                              <label class="control-label" for="name">Medication Name</label>
                            <select name="drug_id"  data-placeholder="Choose a Drug..." class="chosen-select"  tabindex="2" required="">
                             <option value="">Select</option>
                             @foreach($drugs as $drug)
                                <option value="{{$drug->id}}">{{$drug->drugname}}</option>
                             @endforeach
                             </select>
                             </div>

                             <div class="form-group" id="data_4">
                               <label class="font-normal">Medication Date</label>
                               <div class="input-group date">
                               <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                               <input type="text" class="form-control" name="med_date" value="01/01/2018">
                               </div>
                               </div>
              <button type="submit" class="btn btn-primary">Save</button>
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
<script>

</script>
 @endsection
