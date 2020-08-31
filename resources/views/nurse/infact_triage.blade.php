@extends('layouts.nurse')

@section('content')
  <div class="row">
    <div class="col-lg-6 ">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Dependant Information</h5>
                <div class="ibox-tools">
                    <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                    </a>
                     <a class="close-link">
                        <i class="fa fa-times"></i>
                    </a>
                </div>
            </div>
            <div class="ibox-content">
            <?php $dependant=DB::table('dependant')->where('id',$id)->first(); ?>
    <form class="form-horizontal" role="form" method="POST" action="/updateuser" novalidate>
             <input type="hidden" name="_token" value="{{ csrf_token() }}">
             <input type="hidden" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="{{$id}}" name="id"  required>
              <div class="form-group">
             <label for="exampleInputEmail1">Name</label>
             <input type="name" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Next Kin Name" name="kin_name"  value="{{$dependant->firstName}}  {{$dependant->secondName}}" readonly=""  >
             </div>


              
             <div class="form-group">
            <label for="exampleInputPassword1">Blood Group</label>
            <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Blood Group" name="phone" value="{{$dependant->blood_type or ''}}" readonly  >
            </div>
             <div class="form-group">
            <label for="exampleInputPassword1">Gender</label>
             <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Next of Kin Phone" name="phone" value="{{$dependant->gender or ''}}" readonly  >
            </div>

            
  </div>
  </div>
  </div>

  <div class="col-lg-6 ">
  <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Parent Information</h5>
                <div class="ibox-tools">
                    <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                    </a>
                     <a class="close-link">
                        <i class="fa fa-times"></i>
                    </a>
                </div>
            </div>
            <div class="ibox-content">
   <div class="form-group">
            <?php $father=DB::table('dependant_parent')->where('dependant_id',$id)->where('relationship','=','Father')->first();?>
            <label for="exampleInputPassword1">Father Name</label>
            <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Next of Kin Phone" name="phone" value="{{$father->name or ''}}" readonly  >
            </div>
             <div class="form-group">
            <label for="exampleInputPassword1">Father Phone</label>
             <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Next of Kin Phone" name="phone" value="{{$father->phone or ''}}" readonly  >
            </div>
             <?php $mother=DB::table('dependant_parent')->where('dependant_id',$id)->where('relationship','=','Mother')->first();?>
             <div class="form-group">
            <label for="exampleInputPassword1">Mother Name</label>
            <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Next of Kin Phone" name="phone" value="{{$mother->name or ''}}" readonly  >
            </div>
             <div class="form-group">
            <label for="exampleInputPassword1">Mother Phone</label>
             <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Next of Kin Phone" name="phone" value="{{$mother->phone or ''}}" readonly  >
            </div>
 
            
  </div>
  </div>
  </div>
  </form>
  </div>
  <div class="tabs-container">
              <!-- <div class="col-lg-12 tbg"> -->
                <ul class="nav nav-tabs">

                  
                    
                    
                    <li class="active"><a data-toggle="tab" href="#tab-1">General Examination</a></li>
                    <li class=""><a data-toggle="tab" href="#tab-2">Allergies</a></li>
                    <li class=""><a data-toggle="tab" href="#tab-3">Abnormalites</a></li>
                    <li class=""><a data-toggle="tab" href="#tab-4">Vitals</a></li>
                    
                   
                </ul>
                
    <div class="tab-content">
                      <div id="tab-1" class="tab-pane active">
                        <div class="panel-body">


<div class="row">
<div class="col-lg-6">
    
      <form action="{{ url('createinfantdetails') }}"   method="post">
 <input type="hidden" name="_token" value="{{ Session::token() }}"/>
 
    <div class="form-group">
    <input type="hidden" class="form-control" id="exampleInputEmail1S" aria-describedby="emailHelp" value="{{$id}}" name="id"  required>
    
  <div class="form-group">
<label>Oral thrush?</label><br>
Yes <input type="checkbox" name="oral" value="Yes" />
No <input type="checkbox" name="oral" value="No" />
  </div>
<div class="form-group">
<label>Lympn N>1cm?</label><br>
Yes <input type="checkbox" name="lympn" value="Yes" />
No <input type="checkbox" name="lympn" value="No" />
  </div>
    <div class="form-group">
   <label for="exampleInputEmail1">Fever?</label><br>
   No<input type="checkbox" value="No_fevers"  name="fevers" />
   Yes <input type="checkbox" value="Yes_fevers"  name="fevers"  />

<div class="Yes_fevers"  style="display: none">
    <label>Number of days</label><br>
  <input type="number" value="No"  name="days"/>
  
     
</div>
</div>
<div class="form-group">
<label>Difficulty Breathing?</label>
 No  <input type="checkbox" value="No"  name="difficulty_breathing" />
 Yes <input type="checkbox" value="Yes"  name="difficulty_breathing"  />
  
</div>

 <div class="form-group">
   <label for="exampleInputEmail1">Diarrhoea?</label><br>
   No<input type="checkbox" value="No_diarrhoea"  name="diarrhoea" />
   Yes <input type="checkbox" value="Yes_diarrhoea"  name="diarrhoea"  />

<div class="Yes_diarrhoea"  style="display: none">
    <label>Number of days</label><br>
  <input type="number" value="No"  name="diarrhoea_days"/>
  
     
</div>
</div>
<div class="form-group">
<label>Contact with TB?</label>
 No  <input type="checkbox" value="No"  name="contact_tb" />
 Yes <input type="checkbox" value="Yes"  name="contact_tb"  />
  
</div>

<div class="form-group">
<label>Chronic Cough(last 12 Months)?</label>
 No  <input type="checkbox" value="No"  name="cough" />
 Yes <input type="checkbox" value="Yes"  name="cough"  />
  
</div>

<div class="form-group">
<label>Diarrhoea-Bloody?</label>
 No  <input type="checkbox" value="No"  name="diarrhoea_bloody" />
 Yes <input type="checkbox" value="Yes"  name="diarrhoea_bloody"  />
  
</div>

<div class="form-group">
<label>Vomiting Yes/No?</label>
 No  <input type="checkbox" value="No_vomiting"  name="vomiting" />
 Yes <input type="checkbox" value="Yes_vomiting"  name="vomiting"  />
 <div class="Yes_vomiting"  style="display: none">
    <label>number per 24 hours</label><br>
  <input type="number"  name="vomiting_hours"/>
  </div>
</div>

<div class="form-group">
<label>Vomits Everything?</label>
 No  <input type="checkbox" value="No"  name="vomits_eveything" />
 Yes <input type="checkbox" value="Yes"  name="vomits_eveything"  />
  
</div>

<div class="form-group">
<label>Difficult Feeding?</label>
 No  <input type="checkbox" value="No"  name="feeding_difficult" />
 Yes <input type="checkbox" value="Yes"  name="feeding_difficult"  />
  
</div>

<div class="form-group">
<label>Convulsion</label>
No  <input type="checkbox" value="No_convulsion"  name="convulsion" />
 Yes <input type="checkbox" value="Yes_convulsion"  name="convulsion"  />
 <div class="Yes_convulsion"  style="display: none">
    <label>number per 24 hours</label><br>
  <input type="number"  name="convulsion_hours"/>
  </div>
  
</div>
<div class="form-group">
<label>Partial/Focal Fits?</label>
 No  <input type="checkbox" value="No"  name="fits" />
 Yes <input type="checkbox" value="Yes"  name="fits"  />
  
</div>

<div class="form-group">
<label>Apnoea?</label>
 No  <input type="checkbox" value="No"  name="apnoea" />
 Yes <input type="checkbox" value="Yes"  name="apnoea"  />
  
</div>
     <div class="form-group">
   <label for="exampleInputEmail1">Hiv status?</label><br>
   Negative <input type="checkbox" value="Negative"  name="hiv" />
   Positive <input type="checkbox" value="Positive"  name="hiv"  />

<div class="Positive"  style="display: none">
    <label>ARV's</label><br>
  No  <input type="checkbox" value="No"  name="arvs"/>
  Yes  <input type="checkbox" value="Yes"  name="arvs" />
     
</div>
</div>
<div class="form-group">
<label>VDRL</label><br>
 Negative <input type="checkbox" value="Negative"  name="vdrl" />
   Positive <input type="checkbox" value="Positive"  name="vdrl"  />
 
</div>

<div class="form-group">
<label>Fever</label><br>
 No <input type="checkbox" value="No"  name="fever" />
   Yes <input type="checkbox" value="Yes"  name="fever"  />
 
</div>





 
    </div>
    </div>
  

<div class="col-lg-6">
<div class="form-group">
<label>Antibiotics?</label><br>
Yes <input type="checkbox" name="antibiotics" value="Yes" />
No <input type="checkbox" name="antibiotics" value="No" />
  
</div>

<div class="form-group">
<label>Diabetes?</label><br>
Yes <input type="checkbox" name="diabetes" value="Yes" />
No <input type="checkbox" name="diabetes" value="No" />
  
</div>
<div class="form-group">
<label>TB Positive?</label><br>
Yes <input type="checkbox" name="tb" value="Yes" />
No <input type="checkbox" name="tb" value="No" />
  
</div>
<div class="form-group">
<label>TB Treatment?</label><br>
Yes <input type="checkbox" name="tb_treatment" value="Yes" />
No <input type="checkbox" name="tb_treatment" value="No" />
  
</div>


<div class="form-group">
<label>Hypertention?</label><br>
Yes <input type="checkbox" name="hypertention" value="Yes" />
No <input type="checkbox" name="hypertention" value="No" />
  </div>

<div class="form-group">
<label>APH?</label><br>
Yes <input type="checkbox" name="aph" value="Yes" />
No <input type="checkbox" name="aph" value="No" />
  </div>
<div class="form-group">
<label>Babies Presenting Problems?</label>
<textarea name="babyproblem" class="form-control"></textarea>
  
</div>

<div class="form-group">
<label>Mother Presenting Problems?</label>
<textarea name="motherproblem" class="form-control"></textarea>
  
</div>
<div class="form-group">
<label>Revelant Drugs( Pre Admission)</label>
<textarea name="revelantdrugs" class="form-control"></textarea>
  </div>


    <a class="btn btn-primary btnNext" >Next</a>
</div>
</div>

</div>
</div>




 <div id="tab-2" class="tab-pane">
                        <div class="panel-body">


<div class="col-lg-10">
    <div class="ibox float-e-margins">
     
      <div class="ibox-content">

<div class="form-group">
<label>Allergies</label><br>
 Drug Allergy <input type="checkbox" value="drug"  name="drug" />
 <div class="drug"  style="display: none">
    <label>Drug Name</label><br>
 <select multiple="multiple" class="form-control" name="drugs[]">
    <?php $druglists = DB::table('druglists')->get();?>
                  @foreach($druglists as $druglist)
                   <option value="{{$druglist->id}}">{{$druglist->drugname}}</option>
                 @endforeach
                </select>
    </div>

 Food Allergy <input type="checkbox" value="food"  name="food" />
 <div class="food"  style="display: none">
    <label>Food Allergy Name</label><br>
 <select multiple="multiple" class="form-control" name="foods[]"  >
    <?php $foods = DB::table('food_allergy')->get();?>
                  @foreach($foods as $food)
                   <option value="{{$food->id}}">{{$food->name}}</option>
                 @endforeach
                </select>
  </div>
 Latex Allergy <input type="checkbox" value="latex"  name="latex" />
 <div class="latex"  style="display: none">
    <label>Latex Allergy Name</label><br>
   <select multiple="multiple" class="form-control" name="latexs[]"  >
    <?php $latexs = DB::table('Latex_allergy')->get();?>
                  @foreach($latexs as $latex)
                   <option value="{{$latex->id}}">{{$latex->name}}</option>
                 @endforeach
                </select>
  </div>
 Mold Allergy  <input type="checkbox" value="mold"  name="mold" />
 <div class="mold"  style="display: none">
    <label>Mold Allergy</label><br>
 <select multiple="multiple" class="form-control" name="molds[]"  >
    <?php $molds = DB::table('mold_allergy')->get();?>
                  @foreach($molds as $mold)
                   <option value="{{$mold->id}}">{{$mold->name}}</option>
                 @endforeach
                </select>
  </div>
 Pet Allergy   <input type="checkbox" value="pet"  name="pet" />
 <div class="pet"  style="display: none">
    <label>Pet Allergy Name</label><br>
 <select multiple="multiple" class="form-control" name="pets[]"  >
    <?php $pets = DB::table('pet_allergy')->get();?>
                  @foreach($pets as $pet)
                   <option value="{{$pet->id}}">{{$pet->name}}</option>
                 @endforeach
                </select>
  </div>
 Pollen Allergy  <input type="checkbox" value="pollen"  name="pollen" />
 <div class="pollen"  style="display: none">
    <label>Pollen Allergy Name</label><br>
  <select multiple="multiple" class="form-control" name="pollens[]"  >
    <?php $pollens = DB::table('pollen_allergy')->get();?>
                  @foreach($pollens as $pollen)
                   <option value="{{$pollen->id}}">{{$pollen->name}}</option>
                 @endforeach
                </select>
  </div>
 Insect Allergy  <input type="checkbox" value="insect"  name="insect"  />
 
  <div class="insect"  style="display: none">
    <label>Insect Allergy Name</label><br>
    <select multiple="multiple" class="form-control" name="insects[]"  >
    <?php $insects = DB::table('insect_allergy')->get();?>
                  @foreach($insects as $insect)
                   <option value="{{$insect->id}}">{{$insect->name}}</option>
                 @endforeach
                </select>
  </div>
</div>
</div>
</div>
</div>
</div>
</div>
<div id="tab-3" class="tab-pane">
                        <div class="panel-body">
<div class="col-lg-6 col-lg-offset-2">

  <h2> Abnormalities-Tick All Relevant and Describe</h2>
<?php $abs=DB::table('abnormalities')->get(); ?>
@foreach($abs as $ab )
<div class="form-group">
   <label for="chkPassport">
    <input type="checkbox" id="chkPassport" name="abs[]" value="{{$ab->name}}"/>
   {{$ab->name}}
</label>

<div class="{{$ab->name}}"  style="display: none">
    <label>Describe:</label><br>
    <textarea rows="3" cols="50" name="abs_detail"></textarea>
</div>
</div>
@endforeach
</div>
</div>
</div>
<div id="tab-4" class="tab-pane">
                        <div class="panel-body">
                        <div class="col-lg-6">

<div class="form-group">
    <label for="exampleInputEmail1">Weight</label>
    <input type="name" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Weight" name="weight"  required>
    </div>
    <div class="form-group">
    <label for="exampleInputEmail1">Height</label>
    <input type="name" class="form-control" placeholder="Height in Metres" name="current_height"
     required>
    </div>
   <div class="form-group">
    <label for="exampleInputPassword1">Temperature</label>
    <input type="name" class="form-control" id="exampleInputPassword1" placeholder="Temperature" name="temperature"  required>
   </div>

    <div class="form-group">
    <label for="exampleInputPassword1">Systolic BP</label>
    <input type="name" class="form-control" id="exampleInputPassword1" placeholder="Systolic BP" name="systolic"  required>
    </div>
    <div class="form-group">
    <label for="exampleInputEmail1">Diastolic BP</label>
    <input type="name" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Diastolic BP" name="diastolic"  required>
    </div>
 
    </div>
     <div class="col-lg-6">

     <div class="form-group">
    <label for="exampleInputPassword1">Chief Compliant</label>
    <select multiple="multiple" class="form-control" name="chiefcompliant[]"  >
    <?php $chiefs = DB::table('chief_compliant_table')->get();?>
                  @foreach($chiefs as $chief)
                   <option value="{{$chief->name}}">{{$chief->name}}</option>
                 @endforeach
                </select>
    </div>
    <div class="form-group">
    <label for="exampleInputPassword1">Observation</label>
    <select  class="form-control" name="observation" id="observation" >
    
                  @foreach($observations as $observation)
                   <option value="{{$observation->name}}">{{$observation->name}}</option>
                 @endforeach
                </select>
    </div>
    <div class="form-group">
    <label for="exampleInputPassword1">symptoms</label>
    <select  class="form-control" name="symptoms" id="symptoms">
     @foreach($symptoms as  $symptom)
                   <option value="{{$symptom->name}}">{{$symptom->name}}</option>
                 @endforeach
    
                </select>
    </div>
    

    <div class="form-group">
    <label for="exampleInputPassword1">Nurse Notes</label>
    <textarea class="form-control" placeholer="" name="nurse" required>
    </textarea>

    </div>
    

    <button type="submit" class="btn btn-primary">Save</button>
     {!! Form::close() !!}
    </div>
    </div>
</div>

    
    
    </div>
    </div>

<br><br><br>
  @include('includes.default.footer')
</div>

@endsection
