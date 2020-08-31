@extends('layouts.facilityadmin')
@section('title', 'Dashboard')
@section('content')

<div class="wrapper wrapper-content animated fadeInRight">
          <div class="content">
              <div class="container">

  <div class="row wrapper border-bottom white-bg page-heading col-lg-11">

               <div class="ibox-title">
                 <h5>Update Laboratory Personnel Details</h5>
               </div>
  {{ Form::open(array('route' => array('updatelabtech'),'method'=>'POST')) }}
    <input type="hidden" name="_token" value="{{ csrf_token() }}">

 <div class="col-lg-3 col-md-offset-1">

            <div class="form-group">
           <label>Address</label>
           <input type="text" name="address" value="{{$labtechs->address}}" class="form-control" >
           </div>
           <input type="text" name="user_id" value="{{$labtechs->user_id}}" class="form-control" >

           <div class="form-group">
          <label>Phone</label>
          <input type="text" name="phone" value="{{$labtechs->phone}}"  class="form-control" >
          </div>

</div>
<div class="col-lg-3 col-md-offset-1">

 <div class="form-group">
 <label for="tag_list" class="">Department:</label>
 <select class="test-multiple" name="department" value="{{$labtechs->department}}"   style="width: 100%" >
 <option value="{{$labtechs->department}}">{{$labtechs->department}}</option>
 <option value='Imaging'>Imaging</option>
 <option value='Laboratory'>Laboratory</option>
 <option value='Neurology'>Neurology</option>
 <option value='Gastrointestinal'>Gastrointestinal</option>
 </select>
 </div>
          <div class="form-group">
         <label>Speciality</label>
         <input type="text" name="speciality" value="{{$labtechs->speciality}}"  class="form-control" >
         </div>
         <div class="form-group">
        <label>Qualification</label>
        <input type="text" name="qualification" value="{{$labtechs->qualification}}"  class="form-control" >
        </div>
      </div>
<div class="col-md-12 col-md-offset-10">
    <button type="submit" class="btn btn-primary">Save</button>
</div>
     {!! Form::close() !!}

    </div>
  </div>


</div>
</div><!--container-->

@include('includes.default.footer')

@endsection
