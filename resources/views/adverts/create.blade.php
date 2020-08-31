@extends('layouts.manufacturer')
@section('title', 'create Ad')
@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>Advertisment</h2>
                    <ol class="breadcrumb">
                        <li>
                            <a href="index.html">Manufacturer</a>
                        </li>
                        <li>
                            <a>Ads</a>
                        </li>
                        <li class="active">
                            <strong>Create</strong>
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
                        <h5>Create Advertisement</h5>
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
   
       {!! Form::open(array('route' => 'ads.store','method'=>'POST','files'=>'true')) !!}
     <input type="hidden" name="_token" value="{{ csrf_token() }}">
     <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">

                <div class="form-group">
                  
                  <div class="form-group">
                  <label class="control-label" for="name">Ad Name</label>
                  <input type="text" name="ad_name" class="form-control daily" required="true">
                </div>
             

                 <div class="form-group">
                 <label class="control-label" for="name">Drug Name</label>
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
                  
                  <div class="form-group">
                  <label class="control-label" for="name">Ad Video</label>
                  <input type="file" name="thefile" class="form-control " required="true">
                </div>






                

     <button type="submit" class="btn btn-primary">Save</button>

    <a href="{{url('ads')}}" class="btn btn-info">Cancel</a>
      {!! Form::close() !!}
               </div>  <!-- /.form-group -->

        
              </div>
    </div>
    </div>
 </div>
</div>
@endsection
