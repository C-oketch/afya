@extends('layouts.pharmacy')
@section('title', 'Pharmacy')
@section('content')

        <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
        
            <div class="col-lg-11">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                  <h5>Prescription Details</h5>

                </div>
                <div class="ibox-content">

                <div class="table-responsive">
                  <table class="table table-striped table-bordered table-hover dataTables-example" >
                  <thead>
                  <tr>
                  <th>No</th>
                  <th>Name</th>
                  <th>Gender</th>
                  <th>Relationship</th>
                  <th>Date of Birth</th>
                  <th>Place of Birth</th>
                  </tr>
                  </thead>

                  <tbody>
                  <?php $i=1; ?>
                  @foreach($dependants as $dependant)
                  <tr>
                  <td><a href="{{URL('pharmacy.add_prescription',$dependant->id)}}">{{$i}}</a></td>
                  <td><a href="{{URL('pharmacy.add_prescription',$dependant->id)}}">{{$dependant->firstName}} {{$dependant->secondName}}</a></td>
                  <td><a href="{{URL('pharmacy.add_prescription',$dependant->id)}}">{{$dependant->gender}}</a></td>
                  <td><a href="{{URL('pharmacy.add_prescription',$dependant->id)}}">{{$dependant->relationship or ''}}</a></td>
                  <td><a href="{{URL('pharmacy.add_prescription',$dependant->id)}}">{{$dependant->dob or ''}}</a></td>
                  <td><a href="{{URL('pharmacy.add_prescription',$dependant->id)}}">{{$dependant->pob or ''}}</a></td>
                  </tr>
                  <?php $i++; ?>

                  @endforeach
                  </tbody>
                  </table>
              </div>
               <a href="{{URL('pharmacy.add_dependant',$id)}}" class="btn btn-primary btn-block">Add Dependant</a>

                           </div>
                       </div>
                   </div>
                   </div>

               </div>

@endsection
