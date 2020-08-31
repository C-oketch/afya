@extends('layouts.admin')
@section('title', 'Admin Dashboard')
@section('content')
    <link rel="stylesheet" href="{!! asset('quot/style.css') !!}" />
@section('style')
@endsection
@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>Basic Form</h2>
                    <ol class="breadcrumb">
                        <li>
                            <a href="index.html">Home</a>
                        </li>
                        <li>
                            <a>Forms</a>
                        </li>
                        <li class="active">
                            <strong>Basic Form</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>





<!------ Include the above in your HEAD tag ---------->
<div class="row wrapper border-bottom white-bg ">
  <div class="container">

      <div class="ibox-content">
      <div class="row">

<div class="col-md-3">
  <?php    $starter=DB::table('B_packages')
  ->join('B_monthly','B_packages.id','=','B_monthly.B_package_id')
  ->join('B_set_up','B_packages.id','=','B_set_up.B_package_id')
  ->join('B_monthlyAnnually','B_packages.id','=','B_monthlyAnnually.B_package_id')
->select('B_packages.id','B_packages.name','B_monthly.id as monid',
'B_monthly.amount','B_set_up.amount as setup','B_monthlyAnnually.amount as yearly')
 ->where('B_packages.id',1)
->first();
       ?>

  					<!-- $starter ITEM -->
  					<div class="panel price panel-blue">
  						<div class="panel-heading arrow_box text-center">
  						<h3>{{$starter->name}}</h3>
  						</div>
  						<div class="panel-body text-center">
  							<p class="lead" style="font-size:30px"><strong>{{$starter->amount}}/ month</strong></p>
                <p> {{$starter->yearly}} Annually</p>
  						</div>
  						<ul class="list-group list-group-flush text-center">
  							<li class="list-group-item"><i class="icon-ok text-info"></i>1 Front Office</li>
  							<li class="list-group-item"><i class="icon-ok text-info"></i>1 Doctor</li>
                <li class="list-group-item"><i class="icon-ok text-info"></i>{{$starter->setup}} Set up Fee</li>

                <li class="list-group-item"><i class="icon-ok text-info"></i> 24/7 support</li>

              	<li class="list-group-item"><i class="icon-ok text-info"></i> </li>


  						</ul>
  						<div class="panel-footer">

  							<a class="btn btn-lg btn-block btn-info" href="{{URL('billquot',$starter->id)}}">SELECT!</a>
                <!-- <button class="tn btn-lg btn-block btn-info"  type="submit"><strong>SELECT</strong></button> -->

  						</div>
  					</div>
  					<!-- /PRICE ITEM -->
</div>
<div class="col-md-3">
  <?php    $regular=DB::table('B_packages')
  ->join('B_monthly','B_packages.id','=','B_monthly.B_package_id')
  ->join('B_set_up','B_packages.id','=','B_set_up.B_package_id')
  ->join('B_monthlyAnnually','B_packages.id','=','B_monthlyAnnually.B_package_id')
->select('B_packages.id','B_packages.name','B_monthly.id as monid',
'B_monthly.amount','B_set_up.amount as setup','B_monthlyAnnually.amount as yearly')
 ->where('B_packages.id',2)
->first();
       ?>

  					<!-- $regular ITEM -->
  					<div class="panel price panel-blue">
  						<div class="panel-heading arrow_box text-center">
  						<h3>{{$regular->name}}</h3>
  						</div>
  						<div class="panel-body text-center">
  							<p class="lead" style="font-size:30px"><strong>{{$regular->amount}}/ month</strong></p>
                <p> {{$regular->yearly}} Annually</p>
  						</div>
  						<ul class="list-group list-group-flush text-center">
  							<li class="list-group-item"><i class="icon-ok text-info"></i>1 Front Office</li>
  							<li class="list-group-item"><i class="icon-ok text-info"></i>1 Nurse</li>
                <li class="list-group-item"><i class="icon-ok text-info"></i>1 Doctor</li>
                <li class="list-group-item"><i class="icon-ok text-info"></i>{{$regular->setup}} Set up Fee</li>


              	<li class="list-group-item"><i class="icon-ok text-info"></i> 27/7 support</li>


  						</ul>
  						<div class="panel-footer">

  							<a class="btn btn-lg btn-block btn-info" href="{{URL('billquot',$regular->id)}}">SELECT!</a>
                <!-- <button class="tn btn-lg btn-block btn-info"  type="submit"><strong>SELECT</strong></button> -->

  						</div>
  					</div>
  					<!-- /PRICE ITEM -->
</div>

<div class="col-md-3">
  <?php    $plus=DB::table('B_packages')
  ->leftjoin('B_monthly','B_packages.id','=','B_monthly.B_package_id')
  ->join('B_set_up','B_packages.id','=','B_set_up.B_package_id')
  ->join('B_monthlyAnnually','B_packages.id','=','B_monthlyAnnually.B_package_id')
->select('B_packages.id','B_packages.name','B_monthly.id as monid',
'B_monthly.amount','B_set_up.amount as setup','B_monthlyAnnually.amount as yearly')
 ->where('B_packages.id',3)
->first();
       ?>

  					<!-- PRICE ITEM -->
  					<div class="panel price panel-blue">
  						<div class="panel-heading arrow_box text-center">
  						<h3>{{$plus->name}}</h3>
  						</div>
  						<div class="panel-body text-center">
  							<p class="lead" style="font-size:30px"><strong>{{$plus->amount}}/ month</strong></p>
                <p> {{$plus->yearly}} Annually</p>
  						</div>
  						<ul class="list-group list-group-flush text-center">
  							<li class="list-group-item"><i class="icon-ok text-info"></i>2 Front Office</li>
  							<li class="list-group-item"><i class="icon-ok text-info"></i>3 Nurse</li>
                <li class="list-group-item"><i class="icon-ok text-info"></i>5 Doctor</li>
                <li class="list-group-item"><i class="icon-ok text-info"></i>{{$plus->setup}} Set up Fee</li>


              	<li class="list-group-item"><i class="icon-ok text-info"></i> 27/7 support</li>


  						</ul>
  						<div class="panel-footer">

  							<a class="btn btn-lg btn-block btn-info" href="{{URL('billquot',$plus->id)}}">SELECT!</a>
                <!-- <button class="tn btn-lg btn-block btn-info"  type="submit"><strong>SELECT</strong></button> -->

  						</div>
  					</div>
  					<!-- /PRICE ITEM -->
</div>

<div class="col-md-3">
  <?php    $enterprise=DB::table('B_packages')
  ->join('B_monthly','B_packages.id','=','B_monthly.B_package_id')
  ->join('B_set_up','B_packages.id','=','B_set_up.B_package_id')
  ->join('B_monthlyAnnually','B_packages.id','=','B_monthlyAnnually.B_package_id')
  ->select('B_packages.id','B_packages.name','B_monthly.id as monid','B_monthly.amount','B_set_up.amount as setup','B_monthlyAnnually.amount as yearly')
 ->where('B_packages.id',4)
 ->first();
       ?>

  					<!-- PRICE ITEM -->
  					<div class="panel price panel-blue">
  						<div class="panel-heading arrow_box text-center">
  						<h3>{{$enterprise->name}}</h3>
  						</div>
  						<div class="panel-body text-center">
  							<p class="lead" style="font-size:30px"><strong>{{$enterprise->amount}}/ month</strong></p>
                <p> {{$enterprise->yearly}} Annually</p>
  						</div>
  						<ul class="list-group list-group-flush text-center">
  							<li class="list-group-item"><i class="icon-ok text-info"></i>2 Front Office</li>
                <li class="list-group-item"><i class="icon-ok text-info"></i>3 Nurse</li>
  							<li class="list-group-item"><i class="icon-ok text-info"></i>10 Doctor</li>
                <li class="list-group-item"><i class="icon-ok text-info"></i>{{$enterprise->setup}} Set up Fee</li>


              	<li class="list-group-item"><i class="icon-ok text-info"></i> 27/7 support</li>


  						</ul>
  						<div class="panel-footer">

  							<a class="btn btn-lg btn-block btn-info" href="{{URL('billquot',$enterprise->id)}}">SELECT!</a>
                <!-- <button class="tn btn-lg btn-block btn-info"  type="submit"><strong>SELECT</strong></button> -->

  						</div>
  					</div>
  					<!-- /PRICE ITEM -->
</div>











 </div>
  </div>


  <!-- /Yearly -->

  </div>
  </div>

  @endsection
  @section('script')
  @endsection
