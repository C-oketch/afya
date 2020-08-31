@extends('layouts.nurse')
@section('title', 'Patient Details')
@section('content')
<div class="wrapper wrapper-content animated fadeInRight">

    <div class="row">
    <div class="col-lg-6 ">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Dependant Information</h5>

            </div>
            <div class="ibox-content">
            <?php $dependant=DB::table('dependant')->where('id',$id)->first(); ?>

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

            </div>
            <div class="ibox-content">
            <?php $father=DB::table('dependant_parent')->where('dependant_id',$id)->where('relationship','=','Father')->first();?>

            @if(is_null($father))
            <a data-toggle="modal" class="btn btn-primary" href="#modal-formf">Add Father</a>

                            <div id="modal-formf" class="modal fade" aria-hidden="true">
                            <div class="modal-dialog">
                            <div class="modal-content">
                            <div class="modal-body">
          <form class="form-horizontal" role="form" method="POST" action="/addfather" novalidate>
             <input type="hidden" name="_token" value="{{ csrf_token() }}">
             <input type="hidden" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="{{$id}}" name="id"  required>
              <div class="form-group">
             <label for="exampleInputEmail1">Father Name</label>
             <input type="name" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Father Name" name="father_name"    >
             </div>


              <div class="form-group">
             <label for="exampleInputPassword1">Father Phone</label>
             <input type="number" class="form-control" id="exampleInputPassword1" placeholder="Father Phone" name="father_phone"  >
             </div>


             <input type="submit" name="submit" value="Add" >
    </form>

                            </div>
                            </div>
                            </div>
                            </div>
                            @else
                             <div class="form-group">

            <label for="exampleInputPassword1">Father Name</label>
            <input type="text" class="form-control" id="exampleInputPassword1"  name="phone" value="{{$father->name or ''}}" readonly  >
            </div>
             <div class="form-group">
            <label for="exampleInputPassword1">Father Phone</label>
             <input type="text" class="form-control" id="exampleInputPassword1"  name="phone" value="{{$father->phone or ''}}" readonly  >
            </div>
            @endif
             <?php $mother=DB::table('dependant_parent')->where('dependant_id',$id)->where('relationship','=','Mother')->first();?>

   @if(is_null($mother))

             <a data-toggle="modal" class="btn btn-primary" href="#modal-formp">Add Mother</a>

                            <div id="modal-formp" class="modal fade" aria-hidden="true">
                            <div class="modal-dialog">
                            <div class="modal-content">
                            <div class="modal-body">
             <form class="form-horizontal" role="form" method="POST" action="/addmother" novalidate>
             <input type="hidden" name="_token" value="{{ csrf_token() }}">
             <input type="hidden" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="{{$id}}" name="id"  required>
                            <div class="form-group">
            <label for="exampleInputPassword1">Mother Name</label>
            <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Mother Name" name="mother_name">
            </div>
             <div class="form-group">
            <label for="exampleInputPassword1">Mother Phone</label>
             <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Mother Phone" name="mother_phone" >
            </div>
            <div class="form-group">
            <label for="exampleInputPassword1">Birth Number</label>
             <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Birth Number" name="Birth_number" >
            </div>
            <div class="form-group">
            <label for="exampleInputEmail1">Younger sibling(born to mother)?</label>
            No <input type="checkbox" value="No"  name="birth" />
            Yes <input type="checkbox" value="Yes"  name="birth"  />
            <div class="Yes" style="display: none">
             <div class="form-group" id="data_1">
                 <label>Date of Birth</label>
                 <div class="input-group date">
                     <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                     <input type="text" class="form-control" name="dob" value="">
                 </div>
                 </div>
                            </div>

                <input type="submit" name="submit" value="Add">
    </form>
                            </div>
                            </div>
                            </div>
                            </div>
                            </div>
            @else
            <div class="form-group">
            <label for="exampleInputPassword1">Mother Name</label>
            <input type="text" class="form-control" id="exampleInputPassword1" name="phone" value="{{$mother->name or ''}}" readonly  >
            </div>
             <div class="form-group">
            <label for="exampleInputPassword1">Mother Phone</label>
             <input type="text" class="form-control" id="exampleInputPassword1"  name="phone" value="{{$mother->phone or ''}}" readonly  >
            </div>
            @endif

  </div>
  </div>
  </div>
  </form>




 <div class="col-lg-12">
            <div class="tabs-container">
              <!-- <div class="col-lg-12 tbg"> -->
                <ul class="nav nav-tabs">

                     <li class="active"><a data-toggle="tab" href="#tab-7">Baby Details</a></li>
                      <li class=""><a data-toggle="tab" href="#tab-8">Mother Details</a></li>
                      <li class=""><a data-toggle="tab" href="#tab-6">Allergies</a></li>
                       <li class=""><a data-toggle="tab" href="#tab-2">Growth</a></li>

                     <li class=""><a data-toggle="tab" href="#tab-9">Disabilities & Abnormalities</a></li>

                      <li class=""><a data-toggle="tab" href="#tab-1">Immunination Chart</a></li>






                </ul>
    <div class="tab-content">
    <div id="tab-7" class="tab-pane active">
                        <div class="panel-body">
  <table class="table table-small-font table-bordered table-striped">
 <thead>
    <tr>
   <th>No</th>
  <th>Admission Date</th>
  <th>Ip No</th>
  <th>Gestation</th>
   <th>Temperature</th>
    <th>Apgar</th>
   <th>Birth Weight</th>
  <th>Weight Now</th>
   <th>BBA</th>
   <th>Born Where</th>
   <th>Delivery</th>
   <th>Resuscitiation</th>
   <th>View</th>

    </tr>
    <?php
    $i=1; $details=DB::table('infant_details')->where('dependant_id',$id)->get();?>
    </thead>
    @foreach($details as $detail)
    <tbody>
     <tr>
     <td>{{$i}}</td>
     <td>{{$detail->admission_date}}</td>
     <td>{{$detail->ipno}}</td>
     <td>{{$detail->gestation}}</td>
     <td>{{$detail->temperature}}</td>
     <td>{{$detail->apgar}}</td>
     <td>{{$detail->birthweight}}</td>
     <td>{{$detail->weightnow}}</td>
     <td>{{$detail->bba}}</td>
     <td>{{$detail->bba_where}}</td>
     <td>{{$detail->delivery}}</td>
      <td>{{$detail->resuscitation}}</td>
      <td><a data-toggle="modal" class="btn btn-primary" href="#modal-form1">

<i class="fa fa-search" aria-hidden="true"></i>
</a>

                            <div id="modal-form1" class="modal fade" aria-hidden="false">

                            <div class="modal-body">
                            <br>
          <div class="row">
        <div class="col-lg-6 col-lg-offset-2">

  <table class="table table-small-font table-bordered table-striped">
  <tr>
    <th>ROM</th>
    <th>Given Vitamen K </th>
    <th>Given Eye Prophylaxis</th>
    <th>Babies Presenting Problems</th>
    <th>Revelant Drugs( Pre Admission)</th>
    </tr>
    <tbody>
      <tr>
      <td>{{$detail->rom}}</td>
      <td>{{$detail->vitamen}}</td>
      <td>{{$detail->prophylaxis}}</td>
       <td>{{$detail->babyproblem}}</td>
        <td>{{$detail->revelantdrugs}}</td>
      </tr>
    </tbody>
  </table>
</div>

</div>
</div>
</div>
  </td>
     </tr>
     </tbody>
     @endforeach
     <?php  $i++;?>
     </table>


  <a data-toggle="modal" class="btn btn-primary" href="#modal-form">Add</a>

                            <div id="modal-form" class="modal fade" aria-hidden="true">
                            <div class="modal-dialog">
                            <div class="modal-content">
                            <div class="modal-body">
          <div class="row">
      <div class="col-lg-6">
  <div class="ibox float-e-margins">
   <h4><label><u>Baby Details</u></label></h4>

  <div class="ibox-content">


     <form class="form-horizontal" role="form" method="POST" action="/babydetails" novalidate>
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="{{$dependant->id}}" name="id"  required>

   <div class="form-group" id="data_1">
                 <label for="exampleInputPassword1">Admission Date</label>
                 <div class="input-group date">
                     <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                     <input type="text" class="form-control" name="admission_date">
                 </div>
                 </div>
    <div class="form-group">
                 <label for="exampleInputPassword1">IP No</label>
            <input type="text" class="form-control" name="ipno">
    </div>
    <div class="form-group">
                 <label for="exampleInputPassword1">Gestation</label>
  <select name="gestation" class="form-control">
  <option value="24">24 weeks</option>
  <option value="25">25 weeks</option>
  <option value="26">26 weeks</option>
   <option value="27">27 weeks</option>
    <option value="28">28 weeks</option>
     <option value="29">29 weeks</option>
      <option value="30">30 weeks</option>
       <option value="31">31 weeks</option>
        <option value="32">32 weeks</option>
         <option value="33">33 weeks</option>
          <option value="34">34 weeks</option>
           <option value="35">35 weeks</option>
            <option value="36">36 weeks</option>
             <option value="37">37 weeks</option>
              <option value="38">38 weeks</option>
               <option value="39">39 weeks</option>
                <option value="40">40 weeks</option>
                <option value="41">41 weeks</option>
                <option value="42">42 weeks</option>
                <option value="43">43 weeks</option>
                <option value="44">44 weeks</option>
                <option value="45">45 weeks</option>
                <option value="46">46 weeks</option>
</select>
    </div>

    <div class="form-group">
                 <label for="exampleInputPassword1">Temperature</label>
            <input type="number" class="form-control" name="temperature">
    </div>

    <div class="form-group">
    <label for="exampleInputEmail1">APGar</label>
   1m <input type="checkbox" value="1m"  name="apgar"/>
   5m <input type="checkbox" value="5m"  name="apgar"/>
   10m <input type="checkbox" value="10m"  name="apgar"/>
   </div>
     @if(!empty($details))
 @else

   <div class="form-group">
                 <label for="exampleInputPassword1">Birth Weight</label>
            <input type="number" class="form-control" name="birthweight">
    </div>
    @endif
    <div class="form-group">
                 <label for="exampleInputPassword1">Weight Now</label>
            <input type="number" class="form-control" name="weightnow">
    </div>
    </div>

    </div>
    </div>

<div class="col-lg-6">

 @if(!empty($details))
 @else

       <div class="form-group">
   <label for="exampleInputEmail1">BBA</label>
   No <input type="checkbox" value="No"  name="bba" />
   Yes <input type="checkbox" value="yes"  name="bba"  />


<div class="yes"  style="display: none">
    <label>Born Where</label>
  Home  <input type="checkbox" value="Home"  name="bba_where"/>
  Clinic  <input type="checkbox" value="Clinic"  name="bba_where" />
  Other Hospitals <input type="checkbox" value="Other"  name="bba_where" />

</div>
</div>
<div class="form-group">
    <label for="exampleInputEmail1">Delivery</label>
   SDV <input type="checkbox" value="SDV"  name="delivery"/>
   Vacuum <input type="checkbox" value="vaccum"  name="delivery"/>
   Breech <input type="checkbox" value="breech"  name="delivery"/>
   Cs <input type="checkbox" value="cs"  name="delivery"/>

   </div>
@endif

   <div class="form-group">
   <label>Resuscitation</label>
   None <input type="checkbox" value="None"  name="resuscitation"/>
   Oxygen <input type="checkbox" value="Oxygen"  name="resuscitation"/>
   Bag/Mask <input type="checkbox" value="Bag/Mask"  name="resuscitation"/>
   </div>

   <div class="form-group">
   <label>ROM</label>
  12 h<input type="checkbox" value="-<12h" name="rom"/>
  12-18>18<input type="checkbox" value="12-18>18h" name="rom"/>

   </div>
   <div class="form-group">
   <label>Given Vitamen: K</label>
   Yes <input type="checkbox" name="vitamen" value="Yes">
   No <input type="checkbox" name="vitamen" value="No">

   </div>

   <div class="form-group">
     <label>Given Eye Prophylaxis</label>
      Yes <input type="checkbox" name="prophylaxis" value="Yes">
   No <input type="checkbox" name="prophylaxis" value="No">
   </div>

   <div class="form-group">
<label>Babies Presenting Problems</label>
<textarea name="babyproblem" class="form-control"></textarea>

</div>
<div class="form-group">
<label>Revelant Drugs( Pre Admission)</label>
<textarea name="revelantdrugs" class="form-control"></textarea>

</div>
   </div>

   <button type="submit" class="btn btn-primary">Save</button>
     {!! Form::close() !!}

   </div>
   </form>
   </div>
   </div>
   </div>
   </div>
   </div>
      </div>


      <div id="tab-8" class="tab-pane">
                        <div class="panel-body">

<table class="table table-small-font table-bordered table-striped">
 <thead>
    <tr>
   <th>No</th>
  <th>Gravidity</th>
  <th>Parity</th>
   <th>Hiv</th>
  <th>ARV's</th>
   <th>Vdrl</th>
   <th>Fever</th>
   <th>Antibiotics</th>
   <th>Diabetes</th>
   <th>View</th>

    </tr>
    <?php
    $i=1; $mothers=DB::table('mother_details')->where('dependant_id',$id)->get();?>
    </thead>
    @foreach($mothers as $mother)
    <tbody>
     <tr>
     <td>{{$i}}</td>
     <td>{{$mother->gravity or ''}}</td>
     <td>{{$mother->parity or ''}}</td>
     <td>{{$mother->hiv or ''}}</td>
     <td>{{$mother->arvs or ''}}</td>
     <td>{{$mother->vdrl or ''}}</td>
     <td>{{$mother->fever or ''}}</td>
     <td>{{$mother->antibioties or ''}}</td>
      <td>{{$mother->diabetes or ''}}</td>
      <td><a data-toggle="modal" class="btn btn-primary" href="#modal-form3">

<i class="fa fa-search" aria-hidden="true"></i>
</a>

                            <div id="modal-form3" class="modal fade" aria-hidden="false">

                            <div class="modal-body">
                            <br>
          <div class="row">
        <div class="col-lg-6 col-lg-offset-2">

  <table class="table table-small-font table-bordered table-striped">
  <tr>
    <th>Tb</th>
    <th>Tb Type</th>
    <th>Tb Treatment</th>
    <th>Labour 1</th>
    <th>Labour 2</th>
    <th>Hypertension</th>
    <th>Aph</th>
    <th>Mother Problem</th>
    <th>Revelant Drugs</th>
    </tr>
    <tbody>
      <tr>
      <td>{{$mother->tb or ''}}</td>
      <td>{{$mother->tb_type or ''}}</td>
      <td>{{$mother->tb_treatment or ''}}</td>
       <td>{{$mother->labour1 or ''}}</td>
        <td>{{$mother->labour2 or ''}}</td>
        <td>{{$mother->hypertension or ''}}</td>
        <td>{{$mother->aph or ''}}</td>
         <td>{{$mother->motherproblem or ''}}</td>
          <td>{{$mother->revelantdrugs or ''}}</td>
      </tr>
    </tbody>
  </table>
</div>

</div>
</div>
</div>
  </td>
     </tr>
     </tbody>
     @endforeach
     <?php  $i++;?>
     </table>


  <a data-toggle="modal" class="btn btn-primary" href="#modal-form2">Add</a>
  <div id="modal-form2" class="modal fade" aria-hidden="true">
                            <div class="modal-dialog">
                            <div class="modal-content">
                            <div class="modal-body">
  <div class="wrapper wrapper-content">
          <div class="row animated fadeInRight">

          <div class="row">
          <div class="col-lg-6">
 <form class="form-horizontal" data-parsley-validate="" role="form" method="POST" action="/motherdetails" novalidate>
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="{{$dependant->id}}" name="id"  required>
 @if(!empty($mothers))
 @else
  <div class="form-group" id="data_1">
                 <label for="exampleInputPassword1">Date of Birth</label>
                 <div class="input-group date">
                     <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                     <input type="text" class="form-control" name="dob" value="">
                 </div>
                 </div>

  @endif
  <div class="form-group">
  <label>Gravidity</label><br>
  <input type="text" name="gravidity" id="gravidity" maxlength="6" autocomplete="off" placeholder="mother gravidity" class="form-control" />

  </div>
  <div class="form-group">
  <label>Parity</label><br>
  <input type="text" name="parity" class="form-control" placeholder="mother parity" />

  </div>

  <div class="form-group">
   <label for="exampleInputEmail1">Hiv status</label>
   Negative <input type="checkbox" value="Negative"  name="hiv" />
   Positive <input type="checkbox" value="Positive"  name="hiv"  />

<div class="Positive"  style="display: none">
    <label>ARV's</label>
  No  <input type="checkbox" value="No"  name="arvs"/>
  Yes  <input type="checkbox" value="Yes"  name="arvs" />

</div>
</div>
<div class="form-group">
<label>VDRL</label>
 Negative <input type="checkbox" value="Negative"  name="vdrl" />
   Positive <input type="checkbox" value="Positive"  name="vdrl"  />

</div>

<div class="form-group">
<label>Fever</label>
 No <input type="checkbox" value="No"  name="fever" />
   Yes <input type="checkbox" value="Yes"  name="fever"  />

</div>
<div class="form-group">
<label>Antibiotics</label>
Yes <input type="checkbox" name="antibiotics" value="Yes" />
No <input type="checkbox" name="antibiotics" value="No" />

</div>

<div class="form-group">
<label>Diabetes</label>
Yes <input type="checkbox" name="diabetes" value="Yes" />
No <input type="checkbox" name="diabetes" value="No" />

</div>
<div class="form-group">
<label>TB Positive</label>

Yes <input type="checkbox" name="tb" value="Yes" />
No <input type="checkbox" name="tb" value="No" />
<div class="Yes"  style="display: none">
    <label>TB Type </label>
  Latent TB  <input type="checkbox" value="Latent TB"  name="tb_type"/>
  TB Disease  <input type="checkbox" value="TB Disease"  name="tb_type" />

</div>

</div>
<div class="form-group">
<label>TB Treatment</label>
Yes <input type="checkbox" name="tb_treatment" value="Yes" />
No <input type="checkbox" name="tb_treatment" value="No" />

</div>
</div>
<div class="col-lg-6">
@if(is_null($mothers))
<div class="form-group">
<label>Labour</label><br>
1 stage <input type="text" name="labour1" class="form-control" placeholder="Enter Hours"/>
2 stage <input type="text" name="labour2" class="form-control" placeholder="Enter Minutes"/>
</div>
@endif
<div class="form-group">
<label>Hypertention</label>
Yes <input type="checkbox" name="hypertention" value="Yes" />
No <input type="checkbox" name="hypertention" value="No" />
  </div>

<div class="form-group">
<label>APH</label>
Yes <input type="checkbox" name="aph" value="Yes" />
No <input type="checkbox" name="aph" value="No" />
  </div>


<div class="form-group">
<label>Mother Presenting Problems?</label>
<textarea name="motherproblem" class="form-control"></textarea>

</div>
<div class="form-group">
<label>Revelant Drugs( Pre Admission)</label>
<textarea name="revelantdrugs" class="form-control"></textarea>

</div>

<button type="submit" class="btn btn-primary">Save</button>
     {!! Form::close() !!}

      </div>
      </div>
      </div>
      </div>
      </div>
      </div>
      </div>
      </div>
      </div>
      </div>

                      <div id="tab-1" class="tab-pane">
                        <div class="panel-body">

  <div class="wrapper wrapper-content">
          <div class="row animated fadeInRight">

           <div class="col-lg-10 col-lg-offset-1">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Immunination Chart</h5>

                    </div>
                    <div class="ibox-content">



         <table class="table table-small-font table-bordered table-striped">
      <thead>
          <tr>

              <th>Disease</th>
              <th>Antigen</th>
              <th>Duration</th>


              <th>Date Guideline</th>

              <th>Status</th>
              <th>Vaccination Date</th>


          </tr>
        </thead>

  <?php  $vaccines=DB::table('vaccine')->join('dependant_vaccination','dependant_vaccination.vaccine_id','=','vaccine.id')->distinct()->select('vaccine.*','dependant_vaccination.*','dependant_vaccination.id as userid')
   ->where('vaccine.age','=>',$length)->get(); ?>
    <?php $i=1; ?>
  @foreach($vaccines as $vaccine)

        <tbody>

     <tr>

   <td><a href="{{url('immunination',$vaccine->userid)}}">{{$vaccine->disease}}</a></td>
   <td><a href="{{url('immunination',$vaccine->userid)}}">{{$vaccine->antigen}}</a></td>

         <td><?php $age=$vaccine->age;
         if($age==0){echo("Birth");}
         else if($age==42){echo("6 Weeks");}
         else if($age==70){echo("10 Weeks");}
         else if($age==98){echo("14 Weeks");}
         else if($age==183){echo("6 months");}
         else if($age==274){echo("9 months");}
         else if($age==335){echo("11 months");}
         else if($age==456){echo("15 months");}
         else if($age==730){echo("2 Years");}?></td>
         <td>{{$vaccine->date_guideline or ''}}</td>
          <td>{{$vaccine->status or ''}}</td>
          <td>{{$vaccine->status_date or ''}}</td>

             </tr>
               </tbody>
           <?php $i++ ?>
          @endforeach


             </table>





                    </div>

                </div>
            </div>
      </div>
      </div>
      </div>
      </div>

<div id="tab-5" class="tab-pane">
                        <div class="panel-body">

  <div class="wrapper wrapper-content">
          <div class="row animated fadeInRight">
    <?php $infants=DB::table('infant_details')->where('dependant_id',$dependant->id)->get();
    $abs=DB::table('infant_abnormalities')->where('dependant_id',$dependant->id)->get();
    ?>

      <div class="row">
      <div class="col-lg-6">
<h4><label><u>Vitals</u></label></h4>
<form class="form-horizontal" role="form" method="POST" action="/vitaldetails" novalidate>
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="{{$dependant->id}}" name="id"  required>
 <div class="form-group">
   <label for="exampleInputEmail1">Fever</label>
   No<input type="checkbox" value="No_fevers"  name="fevers" />
   Yes <input type="checkbox" value="Yes_fevers"  name="fevers"  />

<div class="Yes_fevers"  style="display: none">
    <label>Number of days</label>
  <input type="number" value="No"  name="days"/>


</div>
</div>
<div class="form-group">
<label>Difficulty Breathing</label>
 No  <input type="checkbox" value="No"  name="difficulty_breathing" />
 Yes <input type="checkbox" value="Yes"  name="difficulty_breathing"  />

</div>

 <div class="form-group">
   <label for="exampleInputEmail1">Diarrhoea</label>
   No<input type="checkbox" value="No_diarrhoea"  name="diarrhoea" />
   Yes <input type="checkbox" value="Yes_diarrhoea"  name="diarrhoea"  />

<div class="Yes_diarrhoea"  style="display: none">
    <label>Number of days</label>
  <input type="number" value="No"  name="diarrhoea_days"/>


</div>
</div>
<div class="form-group">
<label>Diarrhoea-Bloody</label>
 No  <input type="checkbox" value="No"  name="diarrhoea_bloody" />
 Yes <input type="checkbox" value="Yes"  name="diarrhoea_bloody"  />

</div>

<div class="form-group">
<label>Vomiting Yes/No?</label>
 No  <input type="checkbox" value="No_vomiting"  name="vomiting" />
 Yes <input type="checkbox" value="Yes_vomiting"  name="vomiting"  />
 <div class="Yes_vomiting"  style="display: none">
    <label>number per 24 hours</label>
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
<h4> <label><U>Circulation</U></label></h4>
    <div class="form-group">
    <label>Femoral Pulse</label>
    Normal <input type="checkbox" value="Normal"  name="femoral_pulse"/>
    Weak <input type="checkbox" value="Weak"  name="femoral_pulse"/>
    </div>
  <div class="form-group">
    <label>Cap Refill</label>
    Possible <input type="checkbox" name="refill" value="possible" />
    Not Possible <input type="checkbox" name="refill" value="notpossible">
    <div class="possible"  style="display: none">
    <label>In Seconds</label>
  <input type="number" name="Seconds">

</div>
  </div>

  <div class="form-group">
    <label>Murmur</label>
    Yes <input type="checkbox" name="Murmur" value="Murmur_Yes" />
    No <input type="checkbox" name="Murmur" value="Murmur_No">
    <div class="possible"  style="display: none">
    <label>Yes?</label>
  <input type="text" name="murmur_yes">

</div>
</div>
<div>
<label>Pallor/Anaemia</label>
0 <input type="checkbox" name="pallor" value="0" />
+ <input type="checkbox" name="pallor" value="+" />
+++ <input type="checkbox" name="pallor" value="+++" />

</div>


<div class="form-group">
<label>Skin cold</label>
Hand <input type="checkbox" name="skincold" value="Hand" />
Elbow <input type="checkbox" name="skincold" value="Elbow" />
Shoulder <input type="checkbox" name="skincold" value="Shoulder" />
  </div>
      <h4> <label><u>General Examination</u></label></h4>

          <div class="form-group">
    <label for="exampleInputPassword1">Skin</label>
    Bruising <input type="checkbox" value="Bruising"  name="skin"/>
    Rash <input type="checkbox" value="Rash"  name="skin"/>
    Pustules <input type="checkbox" value="Pustules"  name="skin"/>
    </div>
    <div class="form-group">
    <label>Jaundice</label>
    None <input type="checkbox" value="None"  name="jaundice"/>
    +  <input type="checkbox" value="+"  name="jaundice"/>
    +++ <input type="checkbox" value="+++"  name="jaundice"/>
    </div>
    <div class="form-group">
    <label>Gest/Size</label>
    Normal <input type="checkbox" value="Normal"  name="gest_size"/>
    Perm <input type="checkbox" value="Perm"  name="gest_size"/>
    SGA/wasted  <input type="checkbox" value="SGA/wasted"  name="gest_size"/>
    </div>

    <h4> <label><u>Umbilicus</u></label></h4>
    <div class="form-group">
    <label>Umbilicus</label>
    Clean <input type="checkbox" value="Clean"  name="umbilicus"/>
    Local Pus <input type="checkbox" value="LocalPus"  name="umbilicus"/>
    Pus + red skin  <input type="checkbox" value="Pus red skin "  name="umbilicus"/>
    </div>

  </div>

<div class="col-lg-6">
   <h4> <label><u>Airways & Breathing</u></label></h4>

    <div class="form-group">
    <label for="exampleInputPassword1">Stridor</label>
    No <input type="checkbox" value="No"  name="stridor"/>
    Yes  <input type="checkbox" value="Yes"  name="stridor"/>
    </div>

    <div class="form-group">
    <label>Oxygen Saturation (enter(represent this in %)</label>
    <input type="text" name="oxygen_saturation" class="form-control">
    </div>
    <div class="form-group">
    <label>Central Cyanosis</label>
    No <input type="checkbox" value="No"  name="cyanosis"/>
    Yes  <input type="checkbox" value="Yes"  name="cyanosis"/>
    </div>
    <div class="form-group">
    <label>InDrawing</label>
    None <input type="checkbox" name="indrawing" value="None">
    Severe <input type="checkbox" name="indrawing" value="Severe">
    Sternum <input type="checkbox" name="indrawing" value="Sternum">

    </div>
    <div class="form-group">
    <label for="exampleInputPassword1">Grunting</label>
    No <input type="checkbox" value="No"  name="grunting"/>
    Yes  <input type="checkbox" value="Yes"  name="grunting"/>
    </div>
    <div class="form-group">
    <label for="exampleInputPassword1">Air Entry Bilateral</label>
    No <input type="checkbox" value="No"  name="air_entry"/>
    Yes  <input type="checkbox" value="Yes"  name="air_entry"/>
    </div>
    <div class="form-group">
    <label>Crackles</label>
    No <input type="checkbox" value="No"  name="crackles"/>
    Yes  <input type="checkbox" value="Yes"  name="crackles"/>
    </div>
    <div class="form-group">
    <label>Cry</label>
    Normal <input type="checkbox" value="No"  name="cry"/>
    Hoarse  <input type="checkbox" value="Yes"  name="cry"/>
    Weak  <input type="checkbox" value="Yes"  name="cry"/>
    </div>


     <h4> <label><u>Other Vitals</u></label></h4>
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
    <label for="exampleInputEmail1">Head Head Measurement</label>
    <input type="name" class="form-control" placeholder="" name="cir">
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



     <div class="form-group">
    <label for="exampleInputPassword1">Chief Complaint/Reason for visit</label>
    <select multiple="multiple" class="form-control" name="chiefcompliants[]"  >
    <?php $chiefs = DB::table('chief_compliant_table')->get();?>
                  @foreach($chiefs as $chief)
                   <option value="{{$chief->name}}">{{$chief->name}}</option>
                 @endforeach
                </select>
    </div>
    <div class="form-group">
    <label for="exampleInputPassword1">Observation</label>
    <select  multiple="multiple"  class="form-control" name="observations[]" id="observation" >

                  @foreach($observations as $observation)
                   <option value="{{$observation->name}}">{{$observation->name}}</option>
                 @endforeach
                </select>
    </div>
    <div class="form-group">
    <label for="exampleInputPassword1">symptoms</label>
    <select multiple="multiple" class="form-control" name="symptoms[]" id="symptoms">
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
    <div class="form-group">
    <label for="exampleInputEmail1">Consulting Physician</label>
    <select class="form-control" name="doctor" >
    <?php $doctors = DB::table('users')->Where('role', '=','Doctor')->get();?>
                  @foreach($doctors as $doctor)
                   <option value="{{$doctor->id}}">{{$doctor->name}}</option>
                 @endforeach
                </select>
    </div>


   <button type="submit" class="btn btn-primary">Save</button>
     {!! Form::close() !!}




</div>







  </div>
  </div>

      </div>
      </div>
      </div>

 <div id="tab-6" class="tab-pane ">
                        <div class="panel-body">

  <div class="wrapper wrapper-content">
          <div class="row animated fadeInRight">

 <div class="col-lg-10">
    <div class="ibox float-e-margins">

      <div class="ibox-content">
<table class="table table-small-font table-bordered table-striped">
 <thead>
    <tr>
   <th>No</th>
  <th>Allery Type</th>
  <th>Allery Name</th>
  </tr>
  </thead>
    </tr>
    <?php $i=1;?>
    <?php  $allergies=DB::table('patient_allergy')
    ->Join('allergies_type','allergies_type.id','=','patient_allergy.allergy_id')
    ->Join('allergies','allergies.id','=','allergies_type.allergies_id')
    ->Select('allergies_type.name','allergies.name as Allergy')
    ->Where('patient_allergy.dependant_id','=',$dependant->id)
    ->get(); ?>
    @foreach($allergies as $allergy)
    <tbody>
      <tr>
      <td>{{$i}}</td>
       <td>{{$allergy->Allergy}}</td>
      <td>{{$allergy->name}}</td>



      </tr>
    </tbody>
    <?php $i++; ?>
    @endforeach
    </table>
     <a data-toggle="modal" class="btn btn-primary" href="#modal-form6">Add</a>
     <div id="modal-form6" class="modal fade" aria-hidden="true">
                            <div class="modal-dialog">
                            <div class="modal-content">
                            <div class="modal-body">
    <form class="form-horizontal" role="form" method="POST" action="/allergies" novalidate>
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="{{$dependant->id}}" name="id"  required>

<div class="form-group">

 Drug Allergy <input type="checkbox" value="drug"  name="drug" />
 <div class="drug"  style="display: none">
    <label>Drug Name</label><br>
 <select multiple="multiple" class="form-control" name="drugs[]">
    <?php $druglists = DB::table('allergies_type')->where('allergies_id',1)->get();?>
                  @foreach($druglists as $druglist)
                   <option value="{{$druglist->id}}">{{$druglist->name}}</option>
                 @endforeach
                </select>
    </div>

 Food Allergy <input type="checkbox" value="food"  name="food" />
 <div class="food"  style="display: none">
    <label>Allergy Name</label><br>
 <select multiple="multiple" class="form-control" name="foods[]"  >
    <?php $foods = DB::table('allergies_type')->where('allergies_id',2)->get();?>
                  @foreach($foods as $food)
                   <option value="{{$food->id}}">{{$food->name}}</option>
                 @endforeach
                </select>
  </div>
  Latex Allergy <input type="checkbox" value="latex"  name="latex" />
 <div class="latex"  style="display: none">
    <label>Allergy Name</label><br>
 <select multiple="multiple" class="form-control" name="latexs[]"  >
    <?php $foods = DB::table('allergies_type')->where('allergies_id',3)->get();?>
                  @foreach($foods as $food)
                   <option value="{{$food->id}}">{{$food->name}}</option>
                 @endforeach
                </select>
  </div>
  Mold Allergy <input type="checkbox" value="mold"  name="molds" />
 <div class="mold"  style="display: none">
    <label>Allergy Name</label><br>
 <select multiple="multiple" class="form-control" name="molds[]"  >
    <?php $foods = DB::table('allergies_type')->where('allergies_id',4)->get();?>
                  @foreach($foods as $food)
                   <option value="{{$food->id}}">{{$food->name}}</option>
                 @endforeach
                </select>
  </div>
  Pet Allergy <input type="checkbox" value="pet"  name="pets" />
 <div class="pet"  style="display: none">
    <label>Allergy Name</label><br>
 <select multiple="multiple" class="form-control" name="pets[]"  >
    <?php $foods =  DB::table('allergies_type')->where('allergies_id',5)->get();?>
                  @foreach($foods as $food)
                   <option value="{{$food->id}}">{{$food->name}}</option>
                 @endforeach
                </select>
  </div>
  Pollen Allergy <input type="checkbox" value="pollen"  name="pollens" />
 <div class="pollen"  style="display: none">
    <label>Allergy Name</label><br>
 <select multiple="multiple" class="form-control" name="pollens[]"  >
    <?php $foods = DB::table('allergies_type')->where('allergies_id',6)->get();?>
                  @foreach($foods as $food)
                   <option value="{{$food->id}}">{{$food->name}}</option>
                 @endforeach
                </select>
  </div>
  Insect Allergy <input type="checkbox" value="insect"  name="insects" />
 <div class="insect"  style="display: none">
    <label>Allergy Name</label><br>
 <select multiple="multiple" class="form-control" name="insects[]"  >
    <?php $foods = DB::table('allergies_type')->where('allergies_id',7)->get();?>
                  @foreach($foods as $food)
                   <option value="{{$food->id}}">{{$food->name}}</option>
                 @endforeach
                </select>
  </div>


<br><br>
  <button type="submit" class="btn btn-primary">Save</button>

</div>
</form>
</div>
</div>
</div>
</div>
</div>
      </div>
      </div>
      </div>
</div>
</div>
</div>
<div id="tab-2" class="tab-pane">
                        <div class="panel-body">

  <div class="wrapper wrapper-content">
          <div class="row animated fadeInRight">
 <div class="col-lg-10 col-lg-offset-1">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                              <h4>Measures of  Growth & Weight</h4>

                            </div>


        <div class="ibox-content">
        <div class="table-responsive">
      <table class="table table-striped table-bordered table-hover dataTables-example" >
      <thead>
       <tr>
           <th>No</th>
            <th>Date</th>
           <th>Weight</th>
           <th>Height</th>
           <th>Head Measurement</th>


      </tr>
      </thead>
       <?php
    $i=1; $mothers=DB::table('triage_infants')->where('dependant_id',$id)->get();?>

    @foreach($mothers as $mother)

      <tbody>

      <td>{{$i}}</td>
       <td>{{$mother->updated_at}}</td>
        <td>{{$mother->weight}}</td>
         <td>{{$mother->height}}</td>
          <td>{{$mother->head_circum}}</td>

     </tbody>
   <?php $i++;?>
   @endforeach

      </table>

   </div>

      </div>
      </div>
      </div>
 <div class="col-lg-10 col-lg-offset-1">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                              <h4>MUAC/Nutrition Test</h4>
                                
                            </div>


        <div class="ibox-content">
        <div class="table-responsive">
      <table class="table table-striped table-bordered table-hover dataTables-example" >
      <thead>
       <tr>
           <th>No</th>
            <th>Date</th>
           <th>Time</th>
           <th>MUAC</th>
           <th>Score</th>



      </tr>
      </thead>

<?php $i=1;  $nutritions=DB::table('dependant_nutrition_test')->where('dependent_id',$id)->get();?>
@foreach($nutritions as $nutrition)
      <tbody>
      <tr>
<td>{{$i}}</td>
<td>{{ date('d -m- Y', strtotime($nutrition->created_at))}}</td>
<td>{{ date('H:i:s', strtotime($nutrition->created_at))}}</td>
 <td>{{$nutrition->score}}</td>
 <td><?php $score=$nutrition->score;
 if ($score<=110) {
   echo '<div style="color:red">Severe Acute Malnutrition (SAM)</div>';
 }
elseif($score>111 & $score<=125){
  echo '<div style="color:orange">Moderate Acute Malnutrition (MAM)</div>';
}
elseif($score>126 & $score<=135){
  echo '<div style="color:yellow"><b>Growth Promotion and Monitoring (GPM)</b></div>';
}
else{
  echo ' <div style="color:green">Well Nourished.</div>';
}
  ?></td>


</tr>
        </tbody>
        <?php $i++; ?>
@endforeach
      </table>

              <a data-toggle="modal" class="btn btn-primary" href="#modal-form10">Add</a>

                            <div id="modal-form10" class="modal fade" aria-hidden="true">
                            <div class="modal-dialog">
                            <div class="modal-content">
                            <div class="modal-body">
                            <div class="row">
                            <div class="col-sm-6">
                               {!! Form::open(array('url' => 'nurse.nutrition','method'=>'POST')) !!}
                              <input type="hidden" name="patient_id" value="{{$dependant->id}}">
                               <div class="form-group">
    <label for="exampleInputEmail1">MUAC Reading</label>
    <input type="number" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder=" in mm" name="muac"  required>
    </div>

                                      <button class="btn btn-sm btn-primary" type="submit"><strong>Submit</strong></button>
                                  </div>
                              {{ Form::close() }}
                                </div>
                                        </div>
                                    </div>
                                    </div>
                                </div>


      </div>
      </div>
      </div>
      </div>
      </div>
      </div>
      </div>
      </div>


<div id="tab-9" class="tab-pane">
                        <div class="panel-body">

  <div class="wrapper wrapper-content">
          <div class="row animated fadeInRight">
          <div class="row">
          <div class="col-lg-10 col-lg-offset-1">
<table class="table table-small-font table-bordered table-striped">
 <thead>
    <tr>
   <th>No</th>
    <th>Disability Name</th>
    <th>Date</th>
  </tr>
  </thead>
    </tr>
    <?php $i=1;?>
    <?php  $allergies=DB::table('patient_disabilities')
        ->Where('patient_disabilities.dependant_id','=',$dependant->id)
    ->get(); ?>
    @foreach($allergies as $allergy)
    <tbody>
      <tr>
      <td>{{$i}}</td>

      <td>{{$allergy->name}}</td>
      <td>{{ date('d -m- Y', strtotime($allergy->created_at))}}</td>



      </tr>
    </tbody>
    <?php $i++; ?>
    @endforeach
    </table>
     <a data-toggle="modal" class="btn btn-primary" href="#modal-form11">Add</a>
     <div id="modal-form11" class="modal fade" aria-hidden="true">
                            <div class="modal-dialog">
                            <div class="modal-content">
                            <div class="modal-body">



    <h2> <label><u>Disability</u></label></h2>
     <form class="form-horizontal" role="form" method="POST" action="/disability" novalidate>
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="{{$dependant->id}}" name="id"  required>
    <div class="form-group">
<label>Can suck/breastfeed</label>
Yes <input type="checkbox" name="breastfeed" value="Yes" />
No <input type="checkbox" name="breastfeed" value="No" />

</div>

<div class="form-group">
<label>Stiff neck</label>
Yes <input type="checkbox" name="neck" value="Yes" />
No <input type="checkbox" name="neck" value="No" />

</div>
<div class="form-group">
<label>Bulging fontanelle</label>
Yes <input type="checkbox" name="fontanelle" value="Yes" />
No <input type="checkbox" name="fontanelle" value="No" />

</div>
<div class="form-group">
<label>Irritable</label>
Yes <input type="checkbox" name="irritable" value="Yes" />
No <input type="checkbox" name="irritable" value="No" />

</div>


<div class="form-group">
<label>Reduced movement/tone</label>
Yes <input type="checkbox" name="tone" value="Yes" />
No <input type="checkbox" name="tone" value="No" />
  </div>
  <button type="submit" class="btn btn-primary">Save</button>
     {!! Form::close() !!}
    </div>
    </div>
    </div>
    </div>
    <br> <br>
    <table class="table table-small-font table-bordered table-striped">
 <thead>
    <tr>
   <th>No</th>
    <th>Abnormalities</th>
    <th>Abnormalities Details</th>
    <th>Date</th>
  </tr>
  </thead>
    </tr>
    <?php $i=1;?>
    <?php  $allergies=DB::table('patient_abnormalities')
        ->Where('dependant_id','=',$dependant->id)
    ->get(); ?>
    @foreach($allergies as $allergy)
    <tbody>
      <tr>
      <td>{{$i}}</td>

      <td>{{$allergy->name}}</td>
      <td>{{$allergy->notes}}</td>
      <td>{{ date('d -m- Y', strtotime($allergy->created_at))}}</td>



      </tr>
    </tbody>
    <?php $i++; ?>
    @endforeach
    </table>
     <a data-toggle="modal" class="btn btn-primary" href="#modal-formab">Add</a>
     <div id="modal-formab" class="modal fade" aria-hidden="true">
                            <div class="modal-dialog">
                            <div class="modal-content">
                            <div class="modal-body">



    <h2> <label><u>Abnormalities</u></label></h2>
   <div class="row animated fadeInRight">
 <form class="form-horizontal" role="form" method="POST" action="/abnormalities" novalidate>
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="{{$dependant->id}}" name="id"  required>
 Skull <input type="checkbox" value="skull"  name="skull" />
 <div class="skull"  style="display: none">
 <label>Describe</label>
    <textarea name="skull_descr" class="form-control"></textarea>
  </div>

  Limbs <input type="checkbox" value="limbs"  name="limbs" />
 <div class="limbs"  style="display: none">
 <label>Describe</label>
    <textarea name="limbs_descr" class="form-control"></textarea>
  </div>
  Spine <input type="checkbox" value="spine"  name="spine" />
 <div class="spine"  style="display: none">
 <label>Describe</label>
    <textarea name="spine_descr" class="form-control"></textarea>
  </div>
  Palate <input type="checkbox" value="palate"  name="palate" />
 <div class="palate"  style="display: none">
 <label>Describe</label>
    <textarea name="palate_descr" class="form-control"></textarea>
  </div>
  Face <input type="checkbox" value="face"  name="face" />
 <div class="face"  style="display: none">
 <label>Describe</label>
    <textarea name="face_descr" class="form-control"></textarea>
  </div>
  Anus <input type="checkbox" value="anus"  name="anus" />
 <div class="anus"  style="display: none">
 <label>Describe</label>
    <textarea name="anus_descr" class="form-control"></textarea>
  </div>
  Dysmorphic <input type="checkbox" value="dysmorphic"  name="dysmorphic" />
 <div class="dysmorphic"  style="display: none">
 <label>Describe</label>
    <textarea name="dysmorphic_descr" class="form-control"></textarea>
  </div>
  <br>
  <button type="submit" class="btn btn-primary">Save</button>
     {!! Form::close() !!}
    </div>
    </div>
    </div>
    </div>
    </div>
    </div>

      </div>
      </div>
      </div>
      </div>
<div id="tab-4" class="tab-pane">
                        <div class="panel-body">

  <div class="wrapper wrapper-content">
          <div class="row animated fadeInRight">
      </div>
      </div>
      </div>
      </div>

      </div>

</div><!--3tabs-->
</div>
</div>
</div>

<br><br>


 @include('includes.default.footer')

        </div>

      </div><!--content page-->

@endsection
