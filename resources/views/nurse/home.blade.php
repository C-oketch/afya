@extends('layouts.nurse')
@section('title', 'All patients')
@section('content')
  <div class="content-page  equal-height">

      <div class="content">
          <div class="container">



            <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
            <div class="col-lg-10 col-lg-offset-1">
            <div class="ibox float-e-margins">
            <div class="ibox-title">
             <h5>All Patient  Details</h5>

                </div>
                <div class="ibox-content">

                <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover dataTables-example" >
            <thead>
              <tr>
                  <th>No</th>
                  <th>Name</th>
                  <th>Gender</th>
                  <th>Age</th>
                  <th>Date</th>
            </tr>
          </thead>

            <tbody>
              <?php $i =1; ?>
           @foreach($patients as $patient)
                <tr>
                    <td><a href="{{url('showpatient',$patient->id)}}">{{$i}}</a></td>
                    <td><a href="{{url('showpatient',$patient->id)}}">{{$patient->firstname}} {{$patient->secondName}}</a></td>

                    <td><?php $gender=$patient->gender;?>
                      @if($gender==1){{"Male"}}@else{{"Female"}}@endif</a>
                    </td>
              <td><?php $dob=$patient->dob;
                  $interval = date_diff(date_create(), date_create($dob));
             $age= $interval->format(" %Y Year, %M Months, %d Days Old");?> {{$age}}

             </td>

                  <td>{{$patient->created_at}}</td>



              </tr>
              <?php $i++; ?>

           @endforeach

           </tbody>

                     </table>
                         </div>

                     </div>
                 </div>
             </div>
             </div>
         </div>



                         </div>
@include('includes.default.footer')
          </div><!--content-->
      </div><!--content page-->

@endsection
