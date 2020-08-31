@extends('layouts.admin')
@section('title', 'Admin Add Test')
@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
          <div class="content">
              <div class="container">
                <div class="row">
                        <div class="col-lg-11">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <h5>{{$tstname->name}} TESTS</h5>
                                <div class="ibox-tools">
                                    <a class="collapse-link">

                                    </a>
                                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                        <i class="fa fa-wrench"></i>
                                    </a>
                                    <ul class="dropdown-menu dropdown-user">
                                    </ul>
                                    <a class="close-link">
                                    </a>
                                </div>
                            </div>
                            <div class="ibox-content">

                                <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover dataTables-example" >
                            <thead>
                              <tr>
                              <th>No</th>
                              <th>Test Name</th>


                           </tr>
                            </thead>
                            <tbody>
                        <?php
                        $i=1;?>
                        @foreach ($grps as $tst)
                          <tr>
                            <td>{{$i}}</td>
                            <td>{{$tst->tname}}</td>
                          </tr>
                              <?php $i++;  ?>
                              @endforeach
                         </tbody>

                            </tbody>
                            <tfoot>
                            <tr>

                            </tr>
                            </tfoot>
                            </table>
                                </div>

                            </div>
                        </div>
                    </div>
                    </div>


</div>

</div>
</div><!--container-->
@endsection
