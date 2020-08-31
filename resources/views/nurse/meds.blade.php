@extends('layouts.nurse')
@section('title', 'Patient Details')
@section('content')


<div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>Add Medication</h2>
                    <ol class="breadcrumb">
                        <li>
                            <a href="index.html">Nurse</a>
                        </li>
                        <li>
                            <a>Medication</a>
                        </li>
                        <li class="active">
                            <strong>Add</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
      </div>

  <div class="row">
    <div class="col-lg-6 col-md-offset-2">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Add Medication</h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                <i class="fa fa-wrench"></i>
                            </a>

                            <a class="close-link">
                                <i class="fa fa-times"></i>
                            </a>
                        </div>
                    </div>
<div class="ibox-content">
   
       {!! Form::open(array('url' => 'med-history','method'=>'POST')) !!}
     <input type="hidden" name="_token" value="{{ csrf_token() }}">


                <div class="form-group">
                <input type="hidden" value="{{$afya_user_id}}" name="afya_user_id">
               

                 <div class="form-group">
                 <label class="control-label" for="name">Medication Name</label>
                <div>
                <select name="drug_id"  data-placeholder="Choose a Drug..." class="chosen-select"  tabindex="2" required="">
                <option value="">Select</option>                
                @foreach($drugs as $drug)
                   <option value="{{$drug->id}}">{{$drug->drugname}}</option>
                @endforeach
                </select>
                </div>
                </div>

                <div class="form-group">
                  <label class="control-label" for="name">Medication Date</label>
                  <input type="text" name="med_date" class="form-control daily" required="true">
                </div>
             

     <button type="submit" class="btn btn-primary">Save</button>

     <a href="{{ route('nurse.show',$afya_user_id) }}" class="btn btn-info">Cancel</a> 
      {!! Form::close() !!}
               </div>  <!-- /.form-group -->

        
              </div>
    </div>
    </div>
 </div>
</div>
@endsection
