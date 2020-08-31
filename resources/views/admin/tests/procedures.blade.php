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
              <h5>ALL PROCEDURES</h5>
              <div class="ibox-tools">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addtest">Add Procedure</button>
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
                      <th>Category</th>
                      <th>Action</th>


                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $i=1;
                    ?>
                    @foreach ($tests as $tst)
                    <tr>
                      <td>{{$i}}</td>
                      <td>{{$tst->name}}</td>
                      <td>{{$tst->category}}</td>
                      <td>
                        {!! Form::open(['method' => 'DELETE','route' => ['test_procedure.destroy', $tst->id],'style'=>'display:inline']) !!}
                        {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                        {!! Form::close() !!}
                      </td>
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

    <div>
      <div class="modal inmodal" id="addtest" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content animated flipInY">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>

              <h4 class="modal-title">Add Procedures</h4>

            </div>
            <div class="modal-body col-md-8 col-md-offset-2">
              <form class="form-horizontal" role="form" method="POST" action="{{url('addingtestprocedure')}}" novalidate>
                <input type="hidden" name="_token" value="{{ csrf_token() }}">



                <div class="form-group">
                <label>Category:</label>
                <select class="test-multiple form-control" name="category"  style="width: 100%">
                <option value=''>Select one ..</option>
                <option value='Cardiac'>Cardiac</option>
                <option value='Neurology'>Neurology</option>
                </select>
                </div>

                <div class="form-group">
                  <label>Test Name</label>
                  <input type="text" class="form-control"  name="test" required="">
                </div>

              </div>

              <div style="clear:both;"></div>
              <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
              </div>


            </form>
          </div>
        </div>
      </div>
    </div>

  </div>

</div>
</div><!--container-->


@endsection
