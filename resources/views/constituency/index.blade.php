@extends('layouts.admin')

@section('content')
<div class="content-page  equal-height">
          <div class="content">
              <div class="container">
  <div class="row">

                  <div class="col-lg-12">

                              <h1>Constituency</h1>
                              <br>
                                          <div class="panel-box">
                                          <a href="{{ route('facility.create') }}" class="btn btn-info" role="button">Add New</a>

                                                        <div class="table-responsive">
                                               <table class="table table-striped table-advance table-hover">
                                                  <thead>
                                                      <tr>
                                                          <th><i class="fa fa-list fa-2x"></i> No</th>
                                                          <th><i class="fa fa-map-marker  fa-2x"></i> County</th>
                                                          <th><i class="fa fa-map-marker  fa-2x"></i> Constituency</th>

                                                          <th><i class="fa fa-users   fa-2x"></i> Population</th>




                                                    </tr>
                                                  </thead>
                                       <tbody>
                                                    <?php $i =1; ?>
                                                 @foreach($consts as $const)
                                                      <tr>
                                                          <td>{{$i}}</td>
                                                          <td>{{$const->county}}</td>
                                                          <td>{{$const->Constituency}}</td>
                                                          <td>{{$const->population}}</td>



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
