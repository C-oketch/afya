
@extends('layouts.manufacturer')

@section('content')
<div class="content-page  equal-height">
          <div class="content">
              <div class="container">

                <div class="col-sm-12 ">
                    <div class="panel-box">
                      <div class="table-responsive">
                        <table class="table table-small-font table-bordered table-striped">
                            <thead>
                                <tr>

                                    <th>No</th>
                                    <th>Drug</th>
                                    <th>Manufacturer</th>
                                    <th>Reg No</th>
                                    <th>Ingredients</th>


                              </tr>
                            </thead>

                            <tbody>
                            <?php $i =1; ?>
                           @foreach($manuf as $manu)
                                <tr>

                                    <td>{{ +$i }}</td>
                                    <td>{{$manu->drugname}}</td>
                                    <td>{{$manu->manufacturer}}</td>
                                    <td>{{$manu->RegNo}}</td>
                                    <td>{{$manu->Ingredients}}</td>


                                </tr>
                                <?php $i++; ?>

                             @endforeach

                             </tbody>
                           </table>
                         </div>

                        </div>
                        </div>
                   </div><!--container-->
                </div><!--content -->
            </div><!--content page-->
@endsection
