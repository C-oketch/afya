@extends('layouts.registrar_layout')
@section('content')
<div class="row">



<div class="col-lg-8 col-md-offset-2">
<div class="ibox float-e-margins">
    <br>
      <div class="ibox-title">
          <h5>Add Patient Allergy Details</h5>
      </div>
      <div class="ibox-content">
        {!! Form::open(array('url' => 'update_allergyreg','method'=>'POST')) !!}
        <input type="hidden" value="{{$id}}" name="id">

        <div class="form-group">
      <label>Drug Allergy</label><br>
      <select multiple="multiple" class="form-control allergies" name="drugs[]">
<?php $druglists = DB::table('allergies_type')->where('allergies_id',1)->get();?>
        @foreach($druglists as $druglist)
         <option value="{{$druglist->id}}">{{$druglist->name}}</option>
       @endforeach
      </select>
    </div>

  <div class="form-group"> <label>Food Allergy</label><br>
    <select multiple="multiple" class="form-control allergies" name="foods[]"  >
       <?php $foods = DB::table('allergies_type')->where('allergies_id',2)->get();?>
             @foreach($foods as $food)
              <option value="{{$food->id}}">{{$food->name}}</option>
            @endforeach
        </select>
     </div>
<div class="form-group"><label>Latex Allergy</label><br>
  <select multiple="multiple" class="form-control allergies" name="latexs[]"  >
<?php $foods = DB::table('allergies_type')->where('allergies_id',3)->get();?>
   @foreach($foods as $food)
    <option value="{{$food->id}}">{{$food->name}}</option>
  @endforeach
 </select>
</div>

<div class="form-group"><label> Mold Allergy </label><br>
   <select multiple="multiple" class="form-control allergies" name="molds[]"  >
    <?php $foods = DB::table('allergies_type')->where('allergies_id',4)->get();?>
          @foreach($foods as $food)
           <option value="{{$food->id}}">{{$food->name}}</option>
         @endforeach
        </select>
  </div>

<div class="form-group"><label>Pet Allergy</label><br>
 <select multiple="multiple" class="form-control allergies" name="pets[]"  >
    <?php $foods =  DB::table('allergies_type')->where('allergies_id',5)->get();?>
          @foreach($foods as $food)
           <option value="{{$food->id}}">{{$food->name}}</option>
         @endforeach
        </select>
  </div>

<div class="form-group"><label>Pollen Allergy</label><br>
 <select multiple="multiple" class="form-control allergies" name="pollens[]"  >
    <?php $foods = DB::table('allergies_type')->where('allergies_id',6)->get();?>
                  @foreach($foods as $food)
                   <option value="{{$food->id}}">{{$food->name}}</option>
                 @endforeach
                </select>
  </div>
<div class="form-group"><label>Insect Allergy</label>
  <select multiple="multiple" class="form-control allergies" name="insects[]"  >
     <?php $foods = DB::table('allergies_type')->where('allergies_id',7)->get();?>
       @foreach($foods as $food)
        <option value="{{$food->id}}">{{$food->name}}</option>
      @endforeach
     </select>
</div>
<button type="submit" class="btn btn-primary">Save</button>
 {!! Form::close() !!}




    </div>
    </div>
    </div>
    </div>


  @include('includes.default.footer')
<script>
  $(document).ready(function() {
      $('.allergies').select2();
  });
</script>
 @endsection
