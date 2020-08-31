@extends('layouts.admin')
@section('title', 'Admin Dashboard')
@section('content')
    <link rel="stylesheet" href="{!! asset('quot/style.css') !!}" />
@section('style')
@endsection
@section('content')
<?php
use Carbon\Carbon;
$today = Carbon::today();
$one_month = Carbon::today()->addMonths(1);
$upto = $one_month->toDateString();
$now = $today->toDateString();
?>
<div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>INVOICE</h2>
                    <ol class="breadcrumb">
                        <li>
                            <a href="index.html">Home</a>
                        </li>
                        <li>
                            <a>Forms</a>
                        </li>
                        <li class="active">
                            <strong>Create Invoice Form</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>







              <div class="wrapper wrapper-content animated fadeInRight">
                        <div class="row">
                        <div class="col-lg-12">
                            <div class="ibox float-e-margins">
                                <div class="ibox-title">
                                    <h5>Creat Invoice</small></h5>

                                </div>
                                <div class="ibox-content">
                                    <div class="row">


    {!! Form::open(array('url' => 'billquots','method'=>'POST')) !!}
<div class="col-sm-4 b-r"><h3 class="m-t-none m-b"></h3>
        <div class="form-group"><label>Package</label>
          <input type="text" value="{{$package->name}}" class="form-control">
           <input type="hidden" value="{{$package->id}}" name="package" class="form-control">
      </div>

      <div class="form-group"><label>Set Up Fee</label>
     <select class="form-control m-b" name="setup" >
           <option value="">N/A</option>
           <option value="{{$package->setupid}}">{{$package->setup}}</option>
       </select>
    </div>

            <p>Subscription Type ?</p>
            <input type="radio" name="tab" value="month" onclick="show1();" required/>
            Monthly
            <input type="radio" name="tab" value="year" onclick="show2();" required/>
             Yearly

            <div id="div1" class="ficha">
            <div class="form-group"><label>Monthly</label>
                <input type="text" value="{{$package->amount}}"  class="form-control">
                <input type="hidden" value="{{$package->monid}}" name="monthly" class="form-control">
             </div>
             <div class="form-group"><label>Period (in months)</label>
                 <input type="text"  name="period" class="form-control">
              </div>
            </div>
            <div id="div2" class="ficha">
              <div class="form-group"><label>Annually</label>
                <input type="text" value="{{$package->yearly}}" class="form-control">
                 <input type="hidden" value="{{$package->yearlyid}}" name="annually" class="form-control">
            </div>
            </div>

            <div class="form-group"><label>Invoice Date</label>
               <input type="text" value="{{$now}}" name="invoice_date" class="form-control">
            </div>
            <div class="form-group"><label>Due Date</label>
               <input type="text" value="{{$upto}}" name="due_date" class="form-control">
            </div>
</div>
<div class="col-sm-4 b-r"><h4></h4>
  <?php $saf = DB::table('B_addons')->where('id',1)->first();
        $add = DB::table('B_addons')->where('id',2)->first();  ?>
  <div class="form-group"><label>{{$saf->name}}</label>
     <input type="hidden" value="{{$saf->id}}" name="safid">
     <input type="text" name="safdesc" class="form-control" placeholder="Description">

  </div>
  <div class="form-group"><label>Amount </label>
     <input type="text" name="safamount" class="form-control" placeholder="Price">
  </div>
  <div class="form-group"><label>{{$add->name}}</label>
     <input type="hidden" value="{{$add->id}}" name="add_id" class="form-control">
     <input type="text" name="adddesc" class="form-control" placeholder="Description">
  </div>
  <div class="form-group"><label>Amount </label>
     <input type="text" name="addamount" class="form-control" placeholder="Price">
  </div>
</div>
<div class="col-sm-4"><h4></h4>
                                          <div class="form-group"><label>Business Name</label>
                                             <input type="text"  name="bus_name" class="form-control" required>
                                          </div>
                                          <div class="form-group"><label>Building Name</label>
                                             <input type="text"  name="building" class="form-control">
                                          </div>
                                          <div class="form-group"><label>Floor and Room</label>
                                             <input type="text"  name="floor" class="form-control">
                                          </div>
                                          <div class="form-group"><label>Street</label>
                                             <input type="text"  name="street" class="form-control">
                                          </div>
                                          <div class="form-group"><label>Phone</label>
                                             <input type="text"  name="phone" class="form-control">
                                          </div>
                                          <button class="btn btn-primary pull-right " type="submit"><strong>SUBMIT</strong></button>
{{ Form::close() }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>  </div>  </div>
  @endsection
  @section('script')
  <script>
  function show1(){
  document.getElementById('div1').style.display ='block';
  document.getElementById('div2').style.display = 'none';
}
function show2(){
  document.getElementById('div2').style.display = 'block';
  document.getElementById('div1').style.display ='none';
}
   </script>
  @endsection
