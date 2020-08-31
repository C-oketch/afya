@extends('layouts.admin')

@section('content')
<div class="content-page  equal-height">
          <div class="content">
              <div class="container">
  <div class="row">
  
                  <div class="col-lg-6 col-lg-offset-3">

                              <h1>Next of Kins</h1>
                              <br>
                                          <div class="panel-box">
                                          <a href="{{ route('kins.create') }}" class="btn btn-info" role="button">Add New</a>

                                                        <div class="table-responsive">
                                               <table class="table table-striped table-advance table-hover">
                                                  <thead>
                                                      <tr>
                                                          <th><i class="fa fa-list fa-2x"></i> No</th>
                                                          <th><i class="fa fa-user  fa-2x"></i> Full Name</th>
                                                          

                                                         
                                                    </tr>
                                                  </thead>
                                       <tbody>
                                                    <?php $i =1; ?>
                                                 @foreach($kins as $kin)
                                                      <tr>
                                                          <td>{{$i}}</td>
                                                          <td>{{$kin->relation}}</td>
                                                          

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
