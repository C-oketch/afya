@extends('layouts.test2')
@section('title', 'Tests')
@section('content')

<div class="content-page  equal-height">

		<div class="content">
				<div class="container">
         	<div class="wrapper wrapper-content animated fadeInRight">



<div class="col-lg-11">
<div class="ibox float-e-margins">
<div class="ibox-title">
<h5>Update Patient Details</h5>
<div class="ibox-tools">
<a class="collapse-link">
<i class="fa fa-chevron-up"></i>
</a>
<a class="dropdown-toggle" data-toggle="dropdown" href="#">
<i class="fa fa-wrench"></i>
</a>
<ul class="dropdown-menu dropdown-user">
<li><a href="#">Config option 1</a>
</li>
<li><a href="#">Config option 2</a>
</li>
</ul>
<a class="close-link">
<i class="fa fa-times"></i>
</a>
</div>
</div>
<div class="ibox-content">

<address>
<strong>Name : {{$info->firstname}} {{$info->secondName}}</strong><br>
Gender :@if($info->gender===1) {{"Male"}} @else {{"Female"}} @endif<br>
Age : {{$info->age}}<br>
</address>


<form class="form-horizontal" role="form" method="POST" action="/uppat" novalidate>
<input type="hidden" name="_token" value="{{ csrf_token() }}">

<input type="hidden" class="form-control" value="{{$info->id}}" name="afya_user_id" >

<div class="form-group" id="data_2">
 <label class="col-lg-4 control-label">Date of Birth</label>
 <div class="input-group date  col-lg-8">
		 <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
		 <input type="text" class="form-control" name="dob" value="">
 </div>
 </div>
<div class="form-group"><label class="col-lg-4 control-label">NHIF:</label>
<div class="col-lg-8"><input type="text" placeholder="Nhif" name="nhif" class="form-control"></div>
</div>
<div class="form-group"><label class="col-lg-4 control-label">National Id No:</label>
<div class="col-lg-8"><input type="text" placeholder="ID NO" name="nationalId" class="form-control"></div>
</div>

<div class="form-group">
<div class="col-lg-offset-2 col-lg-8">
<button class="btn btn-sm btn-white" type="submit">Submit</button>
</div>
</div>
</form>
</div>
</div>
</div>
     </div>
    </div>
  </div><!--content-->
</div><!--content page-->

@endsection
@section('script')
 <!-- Page-Level Scripts -->


@endsection
