@extends('layouts.admin')

@section('content')
<div class="content-page  equal-height">
          <div class="content">
              <div class="container">
  <div class="row">
  
                  <div class="col-lg-12">

                              <h1>Facilities</h1>
                              <br>
                                          <div class="panel-box">
                                          <a href="{{ route('facility.create') }}" class="btn btn-info" role="button">Add New</a>

                                                        <div class="table-responsive">
                                               <table class="table table-striped table-advance table-hover">
                                                  <thead>
                                                      <tr>
                                                          <th><i class="fa fa-list fa-2x"></i> No</th>
                                                          <th><i class="fa fa-user  fa-2x"></i> FacilityCode</th>
                                                          <th><i class="fa fa-hospital-o fa-2x"></i> FacilityName</th>
                                                          <th><i class="fa fa-h-square  fa-2x"></i> Type</th>
                                                          <th><i class="fa fa-map-marker  fa-2x"></i> County</th>
                                                          <th><i class="fa fa-map-marker   fa-2x"></i> District</th>
                                                          <th><i class="fa fa-map-marker   fa-2x"></i> Division</th>
                                                          <th><i class="fa fa-map-marker  fa-2x"></i> Town</th>
                                                          

                                                         
                                                    </tr>
                                                  </thead>
                                       <tbody>
                                                    <?php $i =1; ?>
                                                 @foreach($facilities as $facility)
                                                      <tr>
                                                          <td>{{$i}}</td>
                                                          <td>{{$facility->FacilityCode}}</td>
                                                          <td>{{$facility->FacilityName}}</td>
                                                           <td>{{$facility->Type}}</td>
                                                           <td>{{$facility->County}}</td>
                                                           <td>{{$facility->District}}</td>
                                                           <td>{{$facility->Division}}</td>
                                                           <td>{{$facility->NearestTown}}</td>
                                                          

                                                           </tr>
                                                      <?php $i++; ?>

                                                   @endforeach

                                                   </tbody>
                                                 </table>
                                               </div>


        
                  

    

</div>
                   </div><!--container-->
                </div><!--content -->
            </div><!--content page-->
@endsection
