@extends('layouts.test')
@section('title', 'Tests')
@section('content')

<div class="content-page  equal-height">

		<div class="content">
				<div class="container">
         	<div class="wrapper wrapper-content animated fadeInRight">
<div class="row">
	<div class="col-lg-11">
	<div class="ibox float-e-margins">
	      <div class="ibox-title">
	      <h5> LABORATORY TESTS</h5>
				<div class="ibox-tools">

				<a class="collapse-link">
				<i class="fa fa-chevron-up"></i>
				</a>
				<a class="dropdown-toggle" data-toggle="dropdown" href="#">
				<i class="fa fa-wrench"></i>
				</a>
				<ul class="dropdown-menu dropdown-user">

				<li><a href="#">Config option 1</a>
				</li>
				<li><a href="#">Config option 2</a>
				</li>
				</ul>
				<a class="close-link">
				<i class="fa fa-times"></i>
				</a>
				</div>
				</div>
<div class="ibox-content">
<div class="table-responsive">
<table class="table table-striped table-bordered table-hover dataTables-example" >

<thead>
<tr>
<th>No</th>
<th>Name</th>
<th>Person Treated</th>
<th>Gender</th>
<th>Age</th>
<th>Date Created</th>
<th>Precribing Doctor</th>
<th>Precribing Facility</th>
</tr>
</thead>

<tbody>

<?php $i =1;
if(isset($tsts))
{
	foreach($tsts as $tst)
{

if ($tst->persontreated=='Self') {
$gender= $tst->gender;
$dob=$tst->dob;
$pname= $tst->firstname." ".$tst->secondName;
}else {
$gender= $tst->depgender;
$dob=$tst->depdob;
$pnamed= $tst->depname." ".$tst->depname2;
$pname= $tst->firstname." ".$tst->secondName;
}
if ($gender==1) {$gender='Male';}else{$gender='Female';}
$interval = date_diff(date_create(), date_create($dob));
$age= $interval->format(" %Y Year, %M Months, %d Days Old");
?>
<tr>
<td><a href="{{route('testsdone',$tst->tid)}}">{{$i}}</a></td>
<td><a href="{{route('testsdone',$tst->tid)}}">{{$pname}}</a></td>
<td>
@if($tst->persontreated=='Self')
Primary @else
<a href="{{route('testsdone',$tst->tid)}}">{{$pnamed}}</a>
@endif
</td>
<td>{{$gender}}</td>
<td>{{$age}}</td>
<td>{{$tst->date}}</td>
<td>{{$tst->doc}}</td>
<td>{{$tst->fac}}</td>
</tr>
<?php
$i++;
 }
}
?>

<?php if($alternative)

if(isset($alternative))
{
	foreach($alternative as $alts)
	{
if ($alts->persontreated=='Self') {
$gender= $alts->gender;
$dob=$alts->dob;
$pname= $alts->firstname." ".$alts->secondName;
}else {
$gender= $alts->depgender;
$dob=$alts->depdob;
$pnamed= $alts->depname." ".$alts->depname2;
$pname= $alts->firstname." ".$alts->secondName;
}

if ($gender==1) {$gender='Male';}elseif($gender==2){$gender='Female';}
$interval = date_diff(date_create(), date_create($dob));
$age= $interval->format(" %Y Year, %M Months, %d Days Old");
$i= $i;
?>
<tr>
<td><a href="{{route('testsdone',$alts->tid)}}"></a>{{$i}}</td>
<td><a href="{{route('testsdone',$alts->tid)}}">{{$pname}}</a></td>
<td>
@if($alts->persontreated=='Self')
Primary @else
<a href="{{route('testsdone',$alts->tid)}}">{{$pnamed}}</a>
@endif
</td>
<td>{{$gender}}</td>
<td>{{$age}}</td>
<td>{{$alts->date}}</td>
<td>{{$alts->doc}}</td>
<td>{{$alts->fac}}</td>
</tr>
<?php
$i++;
}
}
  ?>


</tbody>

</table>
</div>

</div>
</div>
</div>
</div>






		   </div>
    </div>
  </div><!--content-->
</div><!--content page-->

@endsection
