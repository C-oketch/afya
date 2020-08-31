@extends('layouts.pharmacy')
@section('title', 'Pharmacy')
@section('content')

<div class="wrapper wrapper-content animated fadeInRight">
     <div class="row">

    <div class="col-lg-6">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Customer Information</h5>

            </div>
            <div class="ibox-content">
              <?php
              $user = DB::table('afya_users')
              ->where('id', '=', $id)
              ->first();

              if(! isset($user->dob))
              {
               ?>

              <form class="form-horizontal" role="form" method="POST" action="/insert_parent_dob" >

                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <input type="hidden" class="form-control" name="afya_user_id" value="{{$id}}" readonly="">

              <div class="form-group" >
               <label for="exampleInputPassword1">Date of Birth</label>
               <div class="input-group date" >
                   <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                   <input type="text" class="form-control" name="dob" id="date_2" >
               </div>
               </div>

                 <button type="submit" class="btn btn-primary btn-sm">Submit Details</button>
                 </form>
                 <?php
               }
               else
               {
                  ?>


                  <form class="form-horizontal" role="form" method="POST" action="/edit_parent_dob" >

                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    <input type="hidden" class="form-control" name="afya_user_id" value="{{$id}}" >

                  <div class="form-group" >
                   <label for="exampleInputPassword1">Date of Birth</label>
                   <div class="input-group date">
                       <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                       <input type="text" class="form-control" id="date_2" name="dob" value="{{$user->dob}}" readonly="">
                   </div>
                   </div>

                     <button type="submit" class="btn btn-primary btn-sm">Update Details</button>
                     </form>

                     <?php
                   }
                      ?>


          </div>
          <a href="{{route('pharmacy.show_alternative',$id)}}"><button type="button" class="btn btn-w-m btn-primary">Back</button></a>
        </div>
      </div>


 <div class="col-lg-6">

<div class="ibox-content" id="one">
   <div class="form-group">
    <label for="exampleInputPassword1">Do you have a written prescription?</label>
     <input type="radio" value="yes"  name="is_prescription" onclick="show1();" required="">Yes
      <input type="radio" value="no"  name="is_prescription" onclick="show2();" required="">No
    </div>
    </div>

     <div class="ibox float-e-margins" id="two" style="display:none">
         <div class="ibox-title">
             <h5>Prescription Details</h5>

         </div>
         <div class="ibox-content">

                 <form class="form-horizontal" role="form" method="POST" action="/presc_details">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" class="form-control"  value="{{$id}}" name="afya_user_id">
                <input type="hidden" class="form-control"  value="{{Auth::id()}}" name="pharmacist">

                <div class="form-group">
                    <label>Prescribing doctor:</label>
                    <select name="doctor" class="form-control thedoctors" style="width:50%" required=""></select>
                </div>

                <div class="form-group">
                 <label for="exampleInputPassword1">Prescription Date</label>
                 <input type="text" class="form-control" id="date_2"  name="date_prescribed" required=""/>
                 </div>

                <div class="form-group">
                    <label >Prescription:</label>
                    <select  name="prescription" class="form-control thedrugs" style="width:50%" required=""></select>
                </div>

                 <div class="form-group">
                   <label class="control-label">Strength</label>
                   <select class="form-control" name="strength" required="">
                      <option value="" selected disabled>Select strength</option>
                     <?php $strengths = DB::table('strength')->get(); ?>
                     @foreach($strengths as $strength)
                            <option value='{{$strength->strength}}'>{{$strength->strength}}</option>
                     @endforeach
                   </select>
                 </div>

                 <div class="form-group">
                 <label>Strength Unit</label>

                 <div class="radio radio-info radio-inline">
                     <input type="radio" id="inlineRadio1" value="ml" name="strength_unit" required="">
                     <label for="inlineRadio1"> Ml</label>
                 </div>
                 <div class="radio radio-inline">
                     <input type="radio" id="inlineRadio2" value="mg" name="strength_unit" required="">
                     <label for="inlineRadio2"> Mg </label>
                 </div>
                 </div>

                 <div class="form-group">
                  <label>Route</label>
                   <select class="form-control" name="routes" required="">
                     <option value="" selected disabled>Select route</option>
                     <?php $routems=DB::table('route')->distinct()->get(['name','id','abbreviation']); ?>
                       @foreach($routems as $routemz)
                         <option value="{{$routemz->id }}">{{ $routemz->abbreviation }}----{{ $routemz->name  }} </option>
                      @endforeach
                   </select>
                </div>

                  <div class="form-group">
                  <label>Frequency</label></td>
                   <select class="form-control"  name="frequency" required="">
                     <option value="" selected disabled>Select frequency</option>
                     <?php $frequent=DB::table('frequency')->distinct()->get(['name','id','abbreviation']); ?>
                       @foreach($frequent as $freq)
                         <option value="{{$freq->id }}">{{ $freq->abbreviation }}----{{ $freq->name  }} </option>
                      @endforeach
                   </select>
                </div>

                <button type="submit" class="btn btn-primary btn-sm">Submit</button>
                   {!! Form::close() !!}

       </div>

     </div><!-- end prescription -->

     <div class="ibox-content" id="three" style="display:none">
        <div class="form-group">
         <label for="exampleInputPassword1">Do you the drug(s) you want?</label>
          <input type="radio" value="yes"  name="is_drug_known" onclick="show3();" >Yes
           <input type="radio" value="no"  name="is_drug_known" onclick="show4();" >No
         </div>
         </div><!-- end  -->

         <div class="ibox float-e-margins" id="four" style="display:none">
             <div class="ibox-title">
                 <h5>Prescription Details</h5>

             </div>
             <div class="ibox-content">

                    <form class="form-horizontal" role="form" method="POST" action="/presc_details">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" class="form-control"  value="{{$id}}" name="afya_user_id">
                    <input type="hidden" class="form-control"  value="{{Auth::id()}}" name="pharmacist">
                    <input type="hidden" value="yes"  name="is_drug_known">

                    <div class="form-group">
                        <label >Prescription:</label>
                        <select  name="prescription" class="form-control presc1" style="width:50%" required=""></select>
                    </div>

                     <div class="form-group">
                       <label>Strength</label>
                        <select class="form-control" name="strength" required="">
                          <option value="" selected disabled>Select strength</option>
                         <?php $strengths = DB::table('strength')->get(); ?>
                         @foreach($strengths as $strength)
                                <option value='{{$strength->strength}}'>{{$strength->strength}}</option>
                         @endforeach
                       </select>
                     </div>

                     <div class="form-group">
                     <label>Strength Unit</label>

                     <div class="radio radio-info radio-inline">
                         <input type="radio" id="inlineRadio1" value="ml" name="strength_unit" required="">
                         <label for="inlineRadio1"> Ml</label>
                     </div>
                     <div class="radio radio-inline">
                         <input type="radio" id="inlineRadio2" value="mg" name="strength_unit" required="">
                         <label for="inlineRadio2"> Mg </label>
                     </div>
                     </div>

                     <div class="form-group">
                      <label>Route</label>
                       <select class="form-control" name="routes" required="">
                         <option value="" selected disabled>Select route</option>
                         <?php $routems=DB::table('route')->distinct()->get(['name','id','abbreviation']); ?>
                           @foreach($routems as $routemz)
                             <option value="{{$routemz->id }}">{{ $routemz->abbreviation }}----{{ $routemz->name  }} </option>
                          @endforeach
                       </select>
                    </div>

                      <div class="form-group">
                      <label>Frequency</label></td>
                       <select class="form-control"  name="frequency" required="">
                         <option value="" selected disabled>Select frequency</option>
                         <?php $frequent=DB::table('frequency')->distinct()->get(['name','id','abbreviation']); ?>
                           @foreach($frequent as $freq)
                             <option value="{{$freq->id }}">{{ $freq->abbreviation }}----{{ $freq->name  }} </option>
                          @endforeach
                       </select>
                    </div>

                    <button type="submit" class="btn btn-primary btn-sm">Submit</button>
                       {!! Form::close() !!}

           </div>

         </div><!-- end new prescription -->

         <div class="ibox-content" id="five" style="display:none">
            <form class="form-horizontal" role="form" method="POST" action="/presc_details" >

           <div class="form-group">
           <label for="exampleInputPassword1">What complaints do you have?</label><br />
           <textarea class="form-control" name="patient_complaints"></textarea>
           </div>

           <div class="form-group">
           <label for="exampleInputPassword1">How long have you been feeling like this?</label><br />
           <textarea class="form-control" name="patient_complaints_duration"></textarea>
           </div>

           <div class="ibox-title">
               <h5>Prescription Details</h5>

           </div>



                  <input type="hidden" name="_token" value="{{ csrf_token() }}">
                  <input type="hidden" class="form-control"  value="{{$id}}" name="afya_user_id" >
                  <input type="hidden" class="form-control"  value="{{Auth::id()}}" name="pharmacist" >

                  <div class="form-group">
                      <label >Prescription:</label>
                      <select  name="prescription" class="form-control presc1" style="width:50%" required=""></select>
                  </div>

                   <div class="form-group">
                     <label>Strength</label>
                      <select class="form-control" name="strength" required="">
                        <option value="" selected disabled>Select strength</option>
                       <?php $strengths = DB::table('strength')->get(); ?>
                       @foreach($strengths as $strength)
                              <option value='{{$strength->strength}}'>{{$strength->strength}}</option>
                       @endforeach
                     </select>
                   </div>

                   <div class="form-group">
                   <label>Strength Unit</label>

                   <div class="radio radio-info radio-inline">
                       <input type="radio" id="inlineRadio1" value="ml" name="strength_unit" required="">
                       <label for="inlineRadio1"> Ml</label>
                   </div>
                   <div class="radio radio-inline">
                       <input type="radio" id="inlineRadio2" value="mg" name="strength_unit" required="">
                       <label for="inlineRadio2"> Mg </label>
                   </div>
                   </div>

                   <div class="form-group">
                    <label>Route</label>
                     <select class="form-control" name="routes" required="">
                       <option value="" selected disabled>Select route</option>
                       <?php $routems=DB::table('route')->distinct()->get(['name','id','abbreviation']); ?>
                         @foreach($routems as $routemz)
                           <option value="{{$routemz->id }}">{{ $routemz->abbreviation }}----{{ $routemz->name  }} </option>
                        @endforeach
                     </select>
                  </div>

                    <div class="form-group">
                    <label>Frequency</label></td>
                     <select class="form-control"  name="frequency" required="">
                       <option value="" selected disabled>Select frequency</option>
                       <?php $frequent=DB::table('frequency')->distinct()->get(['name','id','abbreviation']); ?>
                         @foreach($frequent as $freq)
                           <option value="{{$freq->id }}">{{ $freq->abbreviation }}----{{ $freq->name  }} </option>
                        @endforeach
                     </select>
                  </div>

                  <button type="submit" class="btn btn-primary btn-sm">Submit </button>
                     {!! Form::close() !!}


             </div><!-- end  -->

     </div>
     </div>

      </div>

      <br>

@endsection

@section('date-script')
<script src="{{ asset('js/plugins/datapicker/bootstrap-datepicker.js') }}" type="text/javascript"></script>
@endsection

<script>
function show1()
{
  document.getElementById('two').style.display ='block';
  document.getElementById('three').style.display ='none';
  document.getElementById('four').style.display ='none';
  document.getElementById('five').style.display ='none';
}

function show2()
{
  document.getElementById('two').style.display ='none';
  document.getElementById('three').style.display ='block';
  document.getElementById('four').style.display ='none';
  document.getElementById('five').style.display ='none';
}

function show3()
{
  document.getElementById('two').style.display ='none';
  document.getElementById('three').style.display ='block';
  document.getElementById('four').style.display ='block';
  document.getElementById('five').style.display ='none';
}

function show4()
{
  document.getElementById('two').style.display ='none';
  document.getElementById('three').style.display ='block';
  document.getElementById('four').style.display ='none';
  document.getElementById('five').style.display ='block';
}

</script>
