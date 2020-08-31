@extends('layouts.registrar_layout')
@section('title', 'Dashboard')
@section('content')
<?php
$dependantId = $pdetails->persontreated;
$afyauserId = $pdetails->afya_user_id;
$app_id = $pdetails->appid;



if ($dependantId =='Self')   {
 $afyadetails = DB::table('afya_users')
->select('dob','gender','firstname','secondName','msisdn','age')
->where('id', '=',$afyauserId)->first();

 $dob=$afyadetails->dob;
 $age2=$afyadetails->age;
 $gender=$afyadetails->gender;
 $firstName = $afyadetails->firstname;
 $secondName = $afyadetails->secondName;
 $name =$firstName." ".$secondName;
 $phone =$afyadetails->msisdn;
}else{
$deppdetails = DB::table('dependant')
 ->select('dob','gender','firstName','secondName')
->where('id', '=',$dependantId)
->first();

          $dob=$deppdetails->dob;
           $gender=$deppdetails->gender;
           $age2=$deppdetails->age;
           $firstName = $deppdetails->firstName;
           $secondName = $deppdetails->secondName;
           $name =$firstName." ".$secondName;
}

if($dob){
  $interval = date_diff(date_create(), date_create($dob));
  $age= $interval->format(" %Y Years Old");
}elseif ($age2) {
$age =$user->$age2;
}else{
$age1 ='Not Set';
}



$year= date('y');
$date=date('M , d, Y');
?>
<div class="row wrapper border-bottom white-bg page-heading">
      <div class="col-lg-8">
          <h2>Invoice</h2>
          <ol class="breadcrumb">
              <li>
                  <a href="index.html">Home</a>
              </li>
              <li>
                  Fees
              </li>
              <li class="active">
                  <strong>Patient Tests</strong>
              </li>
          </ol>
      </div>
      <div class="col-lg-4">
          <div class="title-action">
              <a href="{{ URL::to('registrar.printout',$afyauserId) }}" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Back </a>
              <input name="b_print" type="button" class="btn btn-primary"   onClick="printdiv('div_print');" value=" Print ">

          </div>
      </div>
  </div>
<div class="wrapper wrapper-content animated fadeInRight">
<div id="div_print">
  <div class="row">
          <div class="col-lg-10">
              <div class="wrapper wrapper-content animated fadeInRight">
                  <div class="ibox-content p-xl">
                          <div class="row">
                              <div class="col-sm-6">
                                  <h5>Patient:</h5>
                                  <address>
                                      <strong>Name: {{$name}}.</strong><br>
                                      Gender: {{$gender}}<br>
                                      Age: {{$age}}<br>
                                    <abbr title="Phone">P:</abbr>{{$phone}}
                                  </address>
                              </div>

                              <div class="col-sm-6 text-right">
                                  <h4>Ref No.</h4>
                                  <h4 class="text-navy">PT-000{{$pdetails->appid}}-{{$year}}</h4>
                                  <span>To:</span>
                                  <address>
                                    <strong>Requested By:</strong><br>
                                     {{$pdetails->docname}}<br>
                                    {{$pdetails->FacilityName}}<br>
                                      <!-- <abbr title="Phone">P:</abbr> (120) 9000-4321 -->
                                  </address>
                                  <p>
                                      <span><strong>Date: </strong> {{$date}} </span><br/>
                                  </p>
                              </div>
                          </div>

                          <div class="table-responsive m-t">
                              <table class="table">
                                  <thead>
                                  <tr>
                                      <th>Prescription List</th>
                                  </tr>
                                  </thead>
                                  <tbody>
                                    <?php $i =1; ?>

                                    @foreach($prescriptions as $presc)

                                      <tr>
                                      <td width="10%">{{$i}}</td>
                                      <td width="90%">{{$presc->drug_id}}</td>
                                    </tr>
                                  <?php $i++; ?>
                                @endforeach

                                  </tbody>
                              </table>
                          </div><!-- /table-responsive -->

                          <table class="table invoice-total">
                              <tbody>

                              <tr>
                                  <td><strong>Sign :</strong></td>
                              </tr>

                              </tbody>
                          </table>


<!-- <div class="well m-t"><strong>Comments</strong>
  It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less
</div> -->
                      </div>
              </div>
          </div>
      </div>





       </div>
</div>








@endsection
@section('script-reg')
<script>
function printdiv(printpage)
{
var headstr = "<html><head><title></title></head><body>";
var footstr = "</body>";
var newstr = document.all.item(printpage).innerHTML;
var oldstr = document.body.innerHTML;
document.body.innerHTML = headstr+newstr+footstr;
window.print();
document.body.innerHTML = oldstr;
return false;
}
</script>
@endsection
