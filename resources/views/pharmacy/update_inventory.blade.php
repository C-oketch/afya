@extends('layouts.pharmacy')
@section('content')

<div class="wrapper wrapper-content animated fadeInRight">

<div class="row">
  <div class="col-lg-8">
    <div class="ibox-content">

    {!! Form::open(array('route' => 'inventory_update','method'=>'POST','class'=>'form-horizontal','role'=>'form')) !!}

    <?php

    $idd = $idd;
var_dump($idd);

    $count = count($idd);

    for($i=0; $i<$count; $i++)
    {
      $inventory = DB::table('inventory_updates')
                  ->join('inventory', 'inventory.drug_id', '=', 'inventory_updates.drug_id')
                  ->join('druglists','druglists.id','=','inventory.drug_id')
                  ->join('strength','strength.strength','=','inventory.strength')
                  ->select('inventory_updates.*','inventory.*','strength.*',
                  'inventory_updates.quantity AS quantity1','inventory_updates.id AS inv_id')
                  ->where([
                    ['inventory_updates.drug_id', '=', $idd[$i]],
                    ['inventory_updates.status', '=', 1],
                  ])
                  ->orWhere(function ($query) use ($idd,$i) { //the 'use' language construct of Closure class very important

                $query->where('inventory_updates.drug_id', '=', $idd[$i])
                      ->whereNull('inventory_updates.status');
                    })
                  ->get();

    foreach($inventory as $inv)
    {
      if(!empty($inv->quantity1))
      {
        $quantity = $inv->quantity1;
      }
      else
      {
        $quantity = '';
      }
     ?>
       <hr />

     <input type="hidden" name="drug_id[]" value="{{$inv->drug_id}}" />
     <input type="hidden" name="id[]" value="{{$inv->inv_id}}" />

    <div class="form-group">
        <label >Drug:</label>
        <select id="presc1" name="prescription[]" class="form-control presc1" disabled="">
          <option selected="" value="{{$inv->drug_id}}">{{$inv->drugname}}</option>
        </select>
    </div>

    <input type="hidden" name="patient_prescription" class="form-control" value="{{$inv->drug_id}}">

    <div class="form-group"><label>Strength</label> <input type="text" name="strength[]" class="form-control" value="{{$inv->strength.$inv->strength_unit}}" disabled=""></div>

     <div class="form-group"><label>Quantity</label> <input type="number" name="quantity[]" value="{{$quantity}}" class="form-control" ></div>

     <br />
     <br />
     <br />
     <?php
   } //close foreach loop
 }//close for loop
      ?>
    <p> </p>
    <p> </p>
    <p> </p>
    <div class="form-group">
      <div >
      <button class="btn btn-w-m btn-primary" type="submit">Submit</button>
      </div>
    </div>

      {{ Form::close() }}
</div>
<a href="{{route('inventory')}}"><button type="button" class="btn btn-w-m btn-primary">Back</button></a>

</div>

    </div><!--content-->
</div><!--content page-->


@endsection