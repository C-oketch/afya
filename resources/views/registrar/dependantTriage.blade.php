@extends('layouts.registrar_layout')
@section('title', 'Registrar Dashboard')
@section('content')

<div class="wrapper wrapper-content animated fadeInRight">
     <div class="row">

<div class="col-sm-6 col-sm-offset-2">
  <div class="ibox float-e-margins">
    <div class="ibox-title">
        <h5>Consultation description</h5>
        <?php   $facilitycode=DB::table('facility_registrar')
              ->Join('facilities', 'facility_registrar.facilitycode', '=', 'facilities.facilitycode')
              ->select('facilities.set_up','facility_registrar.facilitycode')
             ->where('user_id', Auth::user()->id)
             ->first();
             ?>

             <?php   $amount=DB::table('consultation_fees')
             ->where('facility_code', '=',$facilitycode->facilitycode)
             ->first();
          ?>

</div>
     @if($facilitycode->set_up == 'Partial')
       <div class="ibox-content">
    <form class="form-horizontal" role="form" method="POST" action="{{url('/privateDependentconsultationfee')}}" >

<input type="hidden" name="_token" value="{{ csrf_token() }}">
<input type="hidden" name="facility" value="{{$facilitycode->facilitycode}}">
  <input type="hidden" class="form-control" id="exampleInputEmail1S" aria-describedby="emailHelp" value="{{$id}}" name="id"  required>
  <input type="hidden" class="form-control" id="exampleInputEmail1S" aria-describedby="emailHelp" value="{{$user->afya_user_id}}" name="afya_user"  required>

  <div class="form-group">
  <label class="control-label" for="name">Consultation Fee ?</label>
  <input type="radio" value="No" id="type" name="type" autocomplete="off" required />
  <label>No</label>
  <input type="radio" value="Yes" id="type" name="type" class="youtube" required />
  <label>Yes</label>

        <script type="text/javascript">
               $('input[name="type"]').attr('checked', 'checked').on( "change", function(){
                   if($(this).attr("value")=="No")
                   {
                       $("#embedcode2").show('slow');
                       $("#embedcode").hide('slow');
                   }

                   if($(this).attr("value")=="Yes")
                   {
                       $("#embedcode").show('slow');
                       $("#embedcode2").hide('slow');
                   }
               });
            $('input[name="type"]').trigger('click');

         </script>

         <div id="embedcode2" style="display:none">
           Reason: <select name="no_payment_reason">
             <option value="" selected disabled>Select reason</option>
             <option value="free">Free</option>
             <option value="triage">Follow up with triage</option>
             <option value="no_triage">Follow up without triage</option>
           </select>
         </div>


        <div id="embedcode" style="display:none">
          <?php   $amount=DB::table('consultation_fees')->where('facility_code', '=', $facilitycode->facilitycode)->first();  ?>
      Payment Mode: <select name="mode">
        <option value="" selected disabled>Select</option>
        <option value="Cash">Cash</option>
        <option value="Mpesa">Mpesa</option>
        <option value="Insurance">Insurance</option>
      </select>
       Amount: <input type="number"  placeholder="Amount" name="amount" value="{{$amount->consultation_fee}}" readonly="">
      </div>
    </div>

  <?php
  $category_id = DB::table('payments_categories')
  ->where('payments_categories.category_name', '=', 'Consultation')
  ->first();
  $cat_id = $category_id->id;
   ?>
   <input type="hidden" name="cat_id" value="{{$cat_id}}" />

  <button type="submit" class="btn btn-primary btn-sm">Submit</button>
    {!! Form::close() !!}
    </div>
     @else
    <div class="ibox-content">
    <form class="form-horizontal" role="form" method="POST" action="{{url('/Dependentconsultationfee')}}" >

<input type="hidden" name="_token" value="{{ csrf_token() }}">
<input type="hidden" name="facility" value="{{$facilitycode->facilitycode}}">
  <input type="hidden" class="form-control" id="exampleInputEmail1S" aria-describedby="emailHelp" value="{{$id}}" name="id"  required>
  <input type="hidden" class="form-control" id="exampleInputEmail1S" aria-describedby="emailHelp" value="{{$user->afya_user_id}}" name="afya_user"  required>

  <div class="form-group">
  <label class="control-label" for="name">Consultation Fee ?</label>

  <input type="radio" value="No" id="type" name="type" autocomplete="off" />
    <label>No</label>

    <input type="radio" value="Yes" id="type" name="type" class="youtube" />
  <label>Yes</label>

        <script type="text/javascript">
               $('input[name="type"]').attr('checked', 'checked').on( "change", function(){
                   if($(this).attr("value")=="No")
                   {
                       $("#embedcode2").show('slow');
                       $("#embedcode").hide('slow');
                   }

                   if($(this).attr("value")=="Yes")
                   {
                       $("#embedcode").show('slow');
                       $("#embedcode2").hide('slow');
                   }
               });
            $('input[name="type"]').trigger('click');

         </script>

         <div id="embedcode2" style="display:none">
           Reason: <select name="no_payment_reason">
             <option value="" selected disabled>Select reason</option>
             <option value="free">Free</option>
             <option value="triage">Follow up with triage</option>
             <option value="no_triage">Follow up without triage</option>
           </select>
         </div>


        <div id="embedcode" style="display:none">
          <?php   $amount=DB::table('consultation_fees')->where('facility_code', '=', $facilitycode->facilitycode)->first();  ?>
      Payment Mode: <select name="mode">
        <option value="" selected disabled>Select</option>
        <option value="Cash">Cash</option>
        <option value="Mpesa">Mpesa</option>
        <option value="Insurance">Insurance</option>
      </select>
      <?php
      if(is_null($amount))
      {
        ?>
        Amount: <input type="number"  name="amount" placeholder="Enter consultation fees">
        <?php
      }
      else
      {
       ?>
       Amount: <input type="text"  name="amount" value="{{$amount->consultation_fee}}" readonly="">
       <?php
      }
        ?>
      </div>
    </div>

  <?php
  $category_id = DB::table('payments_categories')
  ->where('payments_categories.category_name', '=', 'Consultation')
  ->first();
  $cat_id = $category_id->id;
   ?>
   <input type="hidden" name="cat_id" value="{{$cat_id}}" />

  <button type="submit" class="btn btn-primary btn-sm">Submit</button>
    {!! Form::close() !!}
    </div>
    @endif
  </div>
</div>
</div>
</div>
<br>


@include('includes.default.footer')
          </div><!--content-->
      </div><!--content page-->

@endsection
