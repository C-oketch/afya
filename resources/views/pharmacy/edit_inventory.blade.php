@extends('layouts.pharmacy')
@section('content')

<div class="wrapper wrapper-content animated fadeInRight">

<div class="row">
  <div class="col-lg-8">
    <div class="ibox-content">

    {!! Form::open(array('route' => 'submit_edited','method'=>'POST','class'=>'form-horizontal','role'=>'form')) !!}
<?php
//$id = $id;
$idd = $idd;
$count = count($idd);

for($i=0; $i<$count; $i++)
{
  $inventory = DB::table('inventory')
              ->join('druglists','druglists.id','=','inventory.drug_id')
              ->join('strength','strength.strength','=','inventory.strength')
              ->join('drug_suppliers', 'drug_suppliers.id', '=', 'inventory.supplier')
              ->select('druglists.Manufacturer','druglists.drugname','drug_suppliers.id AS supplier_id','drug_suppliers.name AS supplier_name',
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

     <div class="form-group">
         <label >Supplier:</label>
         <select id="supplier1" name="supplier[]" class="form-control supplier1" required="">
           <option selected="" value="{{$inv->supplier_id}}">{{$inv->supplier_name}}</option>
         </select>
     </div>

    <div class="form-group">
        <label >Drug:</label>
        <select id="presc1" name="prescription[]" class="form-control presc1" required="">
          <option selected="" value="{{$inv->drug_id}}">{{$inv->drugname}}</option>
        </select>
    </div>

    <div class="form-group">
     <label>Strength</label>
      <select class="form-control" id="testsj" name="strength[]" required="">
        <option selected value="{{$inv->strength}}">{{ $inv->strength  }}  </option>
        <?php $Strengths=DB::table('strength')->distinct()->get(['strength']); ?>
          @foreach($Strengths as $Strengthz)
            <option value="{{$Strengthz->strength}}">{{ $Strengthz->strength  }}  </option>
         @endforeach
     </select>
     </div>

     <div class="form-group">
      <label>Strength Unit</label>
       <select class="form-control" name="strength_unit[]" required="">
         <option value="" disabled selected>Select your option</option>
         <option <?php $inv->strength_unit == 'ml' ? 'selected=""' : '' ?>  value="ml">Ml</option>
         <option <?php $inv->strength_unit == 'mg' ? 'selected=""' : '' ?> value="mg">Mg</option>
      </select>
      </div>

     <div class="form-group"><label>Quantity</label> <input type="number" name="quantity[]" class="form-control" value="{{$inv->quantity}}" required=""></div>

     <div class="form-group"><label>Price</label> <input type="number" name="price[]" class="form-control" value="{{$inv->price}}" required=""></div>

     <div class="form-group"><label>Retail Price</label> <input type="number" name="retail_price[]" class="form-control" value="{{$inv->recommended_retail_price}}" required=""></div>

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
