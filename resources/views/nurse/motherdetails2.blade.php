@extends('layouts.app')

@section('content')
<div class="col-lg-6">
    <div class="ibox float-e-margins">
      <div class="ibox-title">
          <h5>Under Test Menu</h5>

      </div>
      <div class="ibox-content">

 {!! Form::open(array('route' => 'createdetail','method'=>'POST')) !!}
    
    <div class="form-group">
    <label for="exampleInputEmail1">Malaria</label>
    <input type="name" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Blood Slide,Rapid Test" name="weight"  required>
    </div>
     <div class="form-group">
    <label for="exampleInputEmail1">Haemotology </label>
    <input type="name" class="form-control" placeholder="Hb,HCT,Full Haemogram" name="current_height"
     required>
    </div>
    <div class="form-group">
    <label for="exampleInputEmail1">Microbiology</label>
    <input type="name" class="form-control" placeholder="Lumbar Puncture,Blood Cult" name="current_height"
     required>
    </div>

    <div class="form-group">
    <label for="exampleInputEmail1">Xray</label>
    <input type="name" class="form-control" placeholder="CXR,AXR,Other" name="current_height"
     required>
    </div>
    <div class="form-group">
    <label for="exampleInputEmail1">Glucose</label>
    <input type="name" class="form-control" placeholder="Stick test,Laboratory" name="current_height"
     required>
    </div>
    <div class="form-group">
    <label for="exampleInputEmail1">Chemistry</label>
    <input type="name" class="form-control" placeholder="Na +k,Urea,Creatine,LFT" name="current_height"
     required>
    </div>
    <div class="form-group">
    <label for="exampleInputEmail1">HIV</label>
    <input type="name" class="form-control" placeholder="Rapid Test,PCR" name="current_height"
     required>
    </div>
    <h5>Admission Diagnosis/Diagnoses</h5>

   <div class="form-group">
    <label for="exampleInputEmail1">Birth Asphyxia</label>
    <input type="name" class="form-control" placeholder="Na +k,Urea,Creatine,LFT" name="current_height"
     required>
    </div>
    <div class="form-group">
    <label for="exampleInputEmail1">Premature/LBW</label>
    <input type="name" class="form-control" placeholder="Na +k,Urea,Creatine,LFT" name="current_height"
     required>
    </div>

    <div class="form-group">
    <label for="exampleInputEmail1">Neonatal Sepsis</label>
    <input type="name" class="form-control" placeholder="Na +k,Urea,Creatine,LFT" name="current_height"
     required>
    </div>


     <div class="form-group">
    <label for="exampleInputEmail1">Meconium Aspiration</label>
    <input type="name" class="form-control" placeholder="Na +k,Urea,Creatine,LFT" name="current_height"
     required>
    </div>

     <div class="form-group">
    <label for="exampleInputEmail1">Twin Delivery</label>
    <input type="name" class="form-control" placeholder="Na +k,Urea,Creatine,LFT" name="current_height"
     required>
    </div>


     <div class="form-group">
    <label for="exampleInputEmail1">Jaundice</label>
    <input type="name" class="form-control" placeholder="0,+,+++" name="current_height"
     required>
    </div>

     <div class="form-group">
    <label for="exampleInputEmail1">Menengitis</label>
    <input type="name" class="form-control" placeholder="Na +k,Urea,Creatine,LFT" name="current_height"
     required>
    </div>

     <div class="form-group">
    <label for="exampleInputEmail1">Other Diagnosis</label>
    <input type="name" class="form-control" placeholder="Na +k,Urea,Creatine,LFT" name="current_height"
     required>
    </div>
 

    </div>
    </div>
  </div>
</div>






<div class="col-lg-6">
    <div class="ibox float-e-margins">
      <div class="ibox-title">
          <h5>Supportive Care</h5>
      </div>
      <div class="ibox-content">
   
    
    <div class="form-group">
    <label for="exampleInputPassword1">Vitamin K</label>
    <input type="name" class="form-control" id="exampleInputPassword1" placeholder="Normal,Premature,SGA/Wasted" name="temperature"  required>
   </div>

    <div class="form-group">
    <label for="exampleInputPassword1">Nutrition Feeds</label>
    <input type="name" class="form-control" id="exampleInputPassword1" placeholder="Normal,Premature,SGA/Wasted" name="temperature"  required>
   </div>


    <div class="form-group">
    <label for="exampleInputPassword1">iv Fluids</label>
    <input type="name" class="form-control" id="exampleInputPassword1" placeholder="Normal,Premature,SGA/Wasted" name="temperature"  required>
   </div>

    <div class="form-group">
    <label for="exampleInputPassword1">Incubator/Keep Warm</label>
    <input type="name" class="form-control" id="exampleInputPassword1" placeholder="Normal,Premature,SGA/Wasted" name="temperature"  required>
   </div>


    <div class="form-group">
    <label for="exampleInputPassword1">Arv's for PMTCT</label>
    <input type="name" class="form-control" id="exampleInputPassword1" placeholder="Normal,Premature,SGA/Wasted" name="temperature"  required>
   </div>


    <div class="form-group">
    <label for="exampleInputPassword1">Oxygen</label>
    <input type="name" class="form-control" id="exampleInputPassword1" placeholder="Normal,Premature,SGA/Wasted" name="temperature"  required>
   </div>

    <div class="form-group">
    <label for="exampleInputPassword1">Blood Transfusion</label>
    <input type="name" class="form-control" id="exampleInputPassword1" placeholder="Normal,Premature,SGA/Wasted" name="temperature"  required>
   </div>

    <div class="form-group">
    <label for="exampleInputPassword1">Phototherapy</label>
    <input type="name" class="form-control" id="exampleInputPassword1" placeholder="Normal,Premature,SGA/Wasted" name="temperature"  required>
   </div>

 <div class="form-group">
    <label for="exampleInputPassword1">Result of Investigations</label>
    <textarea class="form-control" id="exampleInputPassword1"  name="temperature"  required>
    </textarea> 
   </div>
    
   



    <button type="submit" class="btn btn-primary">Save</button>
     {!! Form::close() !!}
    </div>
</div>
    </div>
  @include('includes.default.footer')


</div>
</div>
@endsection
