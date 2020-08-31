@extends('layouts.admin')

@section('content')
<div class="content-page  equal-height">
          <div class="content">
              <div class="container">
  <div class="row">

                  <div class="col-lg-12">

                              <h1>County</h1>
                              <br>
                                          <div class="panel-box">
                                          <a href="{{ route('facility.create') }}" class="btn btn-info" role="button">Add New</a>

                                                        <div class="table-responsive">
                                               <table class="table table-striped table-advance table-hover">
                                                  <thead>
                                                      <tr>
                                                          <th><i class="fa fa-list fa-2x"></i> No</th>
                                                          <th><i class="fa fa-map-marker  fa-2x"></i> County</th>

                                                          <th><i class="fa fa-users   fa-2x"></i> Population</th>




                                                    </tr>
                                                  </thead>
                                       <tbody>
                                                    <?php $i =1; ?>
                                                 @foreach($counties as $county)
                                                      <tr>
                                                          <td>{{$i}}</td>
                                                          <td>{{$county->county}}</td>

                                                           <td>{{$county->population}}</td>



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
