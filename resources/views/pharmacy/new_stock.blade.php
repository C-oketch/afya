@extends('layouts.pharmacy')
@section('content')


<div class="wrapper wrapper-content animated fadeInRight">

<div class="row">
  <div class="col-lg-8">
    <div class="ibox-content">

    {!! Form::open(array('route' => 'add_stock','method'=>'POST','class'=>'form-horizontal','role'=>'form')) !!}
    <!-- <div class="form-group">
        <label >Manufacturer:</label>
        <select id="manufacturer1" name="manufacturer" class="form-control manufacturer1" ></select>
    </div> -->

    <div class="form-group">
        <label >Supplier:</label>
        <select id="supplier1" name="supplier" class="form-control supplier1" required=""></select>
    </div>

    <div class="form-group">
        <label >Drug:</label>
        <select id="presc1" name="prescription" class="form-control thedrugs" required=""></select>
    </div>

    <div class="form-group">
     <label>Strength</label>
      <select class="form-control" id="testsj" name="strength" required="">
        <?php $Strengths=DB::table('strength')->distinct()->get(['strength']); ?>
          @foreach($Strengths as $Strengthz)
            <option value="{{$Strengthz->strength}}">{{ $Strengthz->strength  }}  </option>
         @endforeach
     </select>
     </div>

     <div class="form-group">
     <label>Strength Unit</label>

     <div class="radio radio-info radio-inline">
         <input type="radio" id="inlineRadio1" value="ml" name="strength_unit" >
         <label for="inlineRadio1"> Ml</label>
     </div>
     <div class="radio radio-inline">
         <input type="radio" id="inlineRadio2" value="mg" name="strength_unit">
         <label for="inlineRadio2"> Mg </label>
     </div>
     </div>

     <div class="form-group"><label>Quantity</label> <input type="number" name="quantity" class="form-control" required=""></div>

     <div class="form-group"><label>Price</label> <input type="number" name="price" class="form-control" required=""></div>
     <div class="form-group"><label>Retail Price</label> <input type="number" name="retail_price" class="form-control" required=""></div>


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
</div>
    </div><!--content-->
</div><!--content page-->


@endsection
