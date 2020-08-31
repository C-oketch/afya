@extends('layouts.patient')
@section('title', 'Patient')
@section('content')
<div class="content-page  equal-height">
      <div class="content">
          <div class="container">
          <br>
          <?php $id=$data['id'];
          $dep=$data['dependant']; ?>
 <div class="ibox-title">
      <h5>{{$dep->firstName}} {{$dep->secondName}}</h5>

  </div>





 <div class="row">
        
<div class="col-sm-5">
          
  <br>
         <div class="ibox-content">
               <form class="form-horizontal" role="form" method="POST" action="/createdepselfreport" novalidate>
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
              <input type="hidden" class="form-control" id="exampleInputEmail1"  value="{{$id}}" name="id"  required>
<div class="form-group">
              <label for="exampleInputPassword1">Temperature</label>
              <input type="number" class="form-control" id="exampleInputEmail1"  placeholder="" name="temperature" >
              </div>
              <div class="form-group">
<label>Irritable</label>
 No  <input type="radio" value="No"  name="irritable" />
 Yes <input type="radio" value="Yes"  name="irritable"  />
  
</div>

<div class="form-group">
<label>Reduced movement/tone</label>
 No  <input type="radio" value="No"  name="tone" />
 Yes <input type="radio" value="Yes"  name="tone"  />
  
</div>

              <div class="form-group">
<label>Difficulty Breathing</label>
 No  <input type="radio" value="No"  name="difficulty_breathing" />
 Yes <input type="radio" value="Yes"  name="difficulty_breathing"  />
  
</div>

 <div class="form-group">
   <label for="exampleInputEmail1">Diarrhoea</label>
   No<input type="radio" value="No"  name="diarrhoea" />
   Yes <input type="radio" value="Yes"  name="diarrhoea"  />


</div>


<div class="form-group">
<label>Vomiting</label>
 No  <input type="radio" value="No"  name="vomiting" />
 Yes <input type="radio" value="Yes"  name="vomiting"  />
 
</div>


<div class="form-group">
<label>Difficult Feeding?</label>
 No  <input type="radio" value="No"  name="feeding_difficult" />
 Yes <input type="radio" value="Yes"  name="feeding_difficult"  />
  
</div>

<div class="form-group">
<label>Convulsion</label>
No  <input type="radio" value="No"  name="convulsion" />
 Yes <input type="radio" value="Yes"  name="convulsion"  />
 
  
</div>



              
              

               </div>
          </div>
 <div class="col-sm-5">
          
  <br>
         <div class="ibox-content">
              
             
<div class="form-group">
<label>Partial/Focal Fits?</label>
 No  <input type="radio" value="No"  name="fits" />
 Yes <input type="radio" value="Yes"  name="fits"  />
  
</div>
<div class="form-group">
<label>Murmur?</label>
 No  <input type="radio" value="No"  name="murmur" />
 Yes <input type="radio" value="Yes"  name="murmur"  />
  
</div>
<div class="form-group">
<label>Grunting?</label>
 No  <input type="radio" value="No"  name="grunting" />
 Yes <input type="radio" value="Yes"  name="grunting"  />
  
</div>
<div class="form-group">
<label>Crackles?</label>
 No  <input type="radio" value="No"  name="crackles" />
 Yes <input type="radio" value="Yes"  name="crackles"  />
  
</div>
<div class="form-group">
<label>Cry?</label>   
Normal  <input type="radio" value="Normal"  name="cry" />
 Hoarse <input type="radio" value="Hoarse"  name="cry"  />
 Weak <input type="radio" value="Weak"  name="cry"  />
  
</div>


              
              <button type="submit" class="btn btn-primary btn-block">Create Details</button>
                 {!! Form::close() !!}
               </div>
          </div>
        </div>
        </div>
</div>
</div>
@endsection
