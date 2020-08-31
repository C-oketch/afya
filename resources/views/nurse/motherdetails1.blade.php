@extends('layouts.app')

@section('content')
<div class="col-lg-6">
    <div class="ibox float-e-margins">
      <div class="ibox-title">
          <h5>A&B</h5>

      </div>
      <div class="ibox-content">

 {!! Form::open(array('route' => 'createdetail','method'=>'POST')) !!}
 <div class="form-group">
  <label class="control-label" for="name">Stridor ? </label>
  <input type="radio" value="no"  name="vdrl" checked='checked' autocomplete="off" />
    <label>No</label>
          <input type="radio" value="yes"  name="vdrl" class="youtube" />
        <label>Yes</label>
    </div>
    
    <div class="form-group">
    <label for="exampleInputEmail1">Oxygen Saturation - enter (represent this in %)</label>
    <input type="name" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Weight" name="weight"  required>
    </div>
     <div class="form-group">
  <label class="control-label" for="name">Central Cyanosis ? </label>
  <input type="radio" value="no"  name="vdrl" checked='checked' autocomplete="off" />
    <label>No</label>
          <input type="radio" value="yes"  name="vdrl" class="youtube" />
        <label>Yes</label>
    </div>
    <div class="form-group">
    <label for="exampleInputEmail1">inDrawing </label>
    <input type="name" class="form-control" placeholder="None,Severe,Sternum" name="current_height"
     required>
    </div>
  <div class="form-group">
  <label class="control-label" for="name">Grunting ? </label>
  <input type="radio" value="no"  name="vdrl" checked='checked' autocomplete="off" />
    <label>No</label>
          <input type="radio" value="yes"  name="vdrl" class="youtube" />
        <label>Yes</label>
    </div>
  <div class="form-group">
  <label class="control-label" for="name">Air Entry Bilateral ? </label>
  <input type="radio" value="no"  name="vdrl" checked='checked' autocomplete="off" />
    <label>No</label>
          <input type="radio" value="yes"  name="vdrl" class="youtube" />
        <label>Yes</label>
    </div>
  <div class="form-group">
  <label class="control-label" for="name">Crackles? </label>
  <input type="radio" value="no"  name="vdrl" checked='checked' autocomplete="off" />
    <label>No</label>
          <input type="radio" value="yes"  name="vdrl" class="youtube" />
        <label>Yes</label>
    </div>
   <div class="form-group">
    <label for="exampleInputPassword1">Cry</label>
    <input type="name" class="form-control" id="exampleInputPassword1" placeholder="Normal,Hoarse,Weak" name="temperature"  required>
   </div>

 <h5>C</h5>
     <div class="form-group">
    <label for="exampleInputPassword1">Femoral Pulse</label>
    <input type="name" class="form-control" id="exampleInputPassword1" placeholder="Normal,Weak" name="temperature"  required>
   </div>
    <div class="form-group">
    <label for="exampleInputPassword1">Cap Refill</label>
    <input type="name" class="form-control" id="exampleInputPassword1" placeholder="Possible-in Seconds/Not Possible" name="temperature"  required>
   </div>
    <div class="form-group">
  <label class="control-label" for="name">Murmur ? </label>
  <input type="radio" value="no"  name="vdrl" checked='checked' autocomplete="off" />
    <label>No</label>
          <input type="radio" value="yes"  name="vdrl" class="youtube" />
        <label>Yes</label>
    </div>
    <div class="form-group">
    <label for="exampleInputPassword1">Pallor/Anaemia</label>
    <input type="name" class="form-control" id="exampleInputPassword1" placeholder="0,+,++++" name="temperature"  required>
   </div>
   <div class="form-group">
    <label for="exampleInputPassword1">Skin Cold</label>
    <input type="name" class="form-control" id="exampleInputPassword1" placeholder="Hand,Elbow,Shoulder" name="temperature"  required>
   </div>

   <

    </div>
    </div>
  </div>
</div>






<div class="col-lg-6">
    <div class="ibox float-e-margins">
      <div class="ibox-title">
          <h5>Disability</h5>
      </div>
      <div class="ibox-content">
    <div class="form-group">
  <label class="control-label" for="name">Can suck/Breastfeed ? </label>
  <input type="radio" value="no"  name="vdrl" checked='checked' autocomplete="off" />
    <label>No</label>
          <input type="radio" value="yes"  name="vdrl" class="youtube" />
        <label>Yes</label>
    </div>
    <div class="form-group">
  <label class="control-label" for="name">Stiff Neck ? </label>
  <input type="radio" value="no"  name="vdrl" checked='checked' autocomplete="off" />
    <label>No</label>
          <input type="radio" value="yes"  name="vdrl" class="youtube" />
        <label>Yes</label>
    </div>

    <div class="form-group">
  <label class="control-label" for="name">Bulging fontanelle ? </label>
  <input type="radio" value="no"  name="vdrl" checked='checked' autocomplete="off" />
    <label>No</label>
          <input type="radio" value="yes"  name="vdrl" class="youtube" />
        <label>Yes</label>
    </div>

<div class="form-group">
  <label class="control-label" for="name">Reduced Movement/Tone ? </label>
  <input type="radio" value="no"  name="vdrl" checked='checked' autocomplete="off" />
    <label>No</label>
          <input type="radio" value="yes"  name="vdrl" class="youtube" />
        <label>Yes</label>
    </div>

    <div class="form-group">
    <label for="exampleInputPassword1">Umblilicus</label>
    <input type="name" class="form-control" id="exampleInputPassword1" placeholder="Clean,Local Pus,Pus + Red Skin" name="temperature"  required>
   </div>

    <div class="form-group">
    <label for="exampleInputPassword1">Skin</label>
    <input type="name" class="form-control" id="exampleInputPassword1" placeholder="Brusing,Rash,POstules" name="temperature"  required>
   </div>
    <div class="form-group">
    <label for="exampleInputPassword1">Jaundice</label>
    <input type="name" class="form-control" id="exampleInputPassword1" placeholder="None,+,+++" name="temperature"  required>
   </div>
    <div class="form-group">
    <label for="exampleInputPassword1">Gest/Size</label>
    <input type="name" class="form-control" id="exampleInputPassword1" placeholder="Normal,Premature,SGA/Wasted" name="temperature"  required>
   </div>

    <h5>Abnormalities</h5>
    <table>
      <tr>
      <td>Skull <input type="radio" value="yes"  name="vdrl">Yes</td>
      <td>Limbs <input type="radio" value="yes"  name="vdrl">Yes</td>
      <td>Spine <input type="radio" value="yes"  name="vdrl">Yes</td>
      <td>Palate <input type="radio" value="yes"  name="vdrl">Yes</td>
      <td>Face <input type="radio" value="yes"  name="vdrl">Yes</td>
      <td>Genitals <input type="radio" value="yes"  name="vdrl">Yes</td>
      <td>Annus <input type="radio" value="yes"  name="vdrl">Yes</td>
      <td>Dysmorphic <input type="radio" value="yes"  name="vdrl">Yes</td>
      </tr>
    </table>
   



    <button type="submit" class="btn btn-primary">Save</button>
     {!! Form::close() !!}
    </div>
</div>
    </div>
  @include('includes.default.footer')

</div>
</div>

@endsection
