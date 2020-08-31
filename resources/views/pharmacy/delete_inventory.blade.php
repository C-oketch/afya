@extends('layouts.pharmacy')
@section('content')

<div class="wrapper wrapper-content animated fadeInRight">

<div class="row">
  <div class="col-lg-8">
    <div class="ibox-content">

  {!! Form::open(array('route' => 'delete_inventory','method'=>'POST','class'=>'form-horizontal')) !!}
<?php
//$id = $id;
$idd = $idd;
$count = count($idd);

for($i=0; $i<$count; $i++)
{
  $inventory = DB::table('inventory')
              ->join('druglists','druglists.id','=','inventory.drug_id')
              ->join('strength','strength.strength','=','inventory.strength')
              ->select('druglists.Manufacturer','druglists.drugname',
              'druglists.id AS drug_id','strength.strength','inventory.*','inventory.id AS inventory_id')
              ->where('inventory.drug_id', '=', $idd[$i])
              ->get();
 ?>
    <!-- <div class="form-group">
        <label >Manufacturer:</label>
        <select id="manufacturer1" name="manufacturer" class="form-control manufacturer1" ></select>
    </div> -->
    <?php
    foreach($inventory as $inv)
    {
     ?>
     <hr />
     <input type="hidden" name="inventory_id[]" value="{{$inv->inventory_id}}" />

     <div class="form-group"><label>Drug</label> <input type="text" name="prescription[]" class="form-control" value="{{$inv->drugname}}" disabled=""></div>

     <div class="form-group"><label>Strength</label> <input type="text" name="strength[]" class="form-control" value="{{$inv->strength}}" disabled=""></div>

     <div class="form-group"><label>Strength Unit</label> <input type="text" name="strength_unit[]" class="form-control" value="{{$inv->strength_unit}}" disabled=""></div>

     <div class="form-group"><label>Quantity</label> <input type="number" name="quantity[]" class="form-control" value="{{$inv->quantity}}" disabled=""></div>

     <div class="form-group"><label>Price</label> <input type="number" name="price[]" class="form-control" value="{{$inv->price}}" disabled=""></div>

     <br />
     <br />
     <br />

     <?php
   }//close foreach loop

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
