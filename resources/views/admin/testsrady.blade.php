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
                                <h5>ALL TESTS</h5>
                                <div class="ibox-tools">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addtestrady">Add Tests</button>
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
                              <th>Name</th>
                              <th>Description</th>
                              <th>Status</th>
                              <th>Categories</th>

                           </tr>
                            </thead>
                            <tbody>
                              <?php
                              $i=1;

                              $otherIM=DB::table('other_tests')->select('name','technique','status')
                              ->orderBy('name', 'asc')
                              ->get();?>
                                @foreach ($otherIM as $other)
                                  <tr>
                                    <td>{{$other->name}}</td>
                                     <td>{{$other->technique}}</td>
                                     <td>@if($other->status == 2) Common @else Normal @endif</td>
                                      <td>OTHER IMAGING TEST</td>
                                  </tr>
                                <?php $i++;  ?>
                                    @endforeach
                        <?php
                        $i=$i;

                        $xray=DB::table('xray')->select('name','technique','status')
                        ->orderBy('name', 'asc')
                        ->get();?>
                          @foreach ($xray as $tst)
                            <tr>
                              <td>{{$tst->name}}</td>
                               <td>{{$tst->technique}}</td>
                               <td>@if($tst->status == 2) Common @else Normal @endif</td>
                                  <td>Xray</td>
                            </tr>
                          <?php $i++;  ?>
                              @endforeach

                              <?php
                              $i=$i;

                              $ultra=DB::table('ultrasound')->select('name','technique','status')
                              ->orderBy('name', 'asc')
                              ->get();?>
                                @foreach ($ultra as $tst)
                                  <tr>
                                    <td>{{$tst->name}}</td>
                                     <td>{{$tst->technique}}</td>
                                     <td>@if($tst->status == 2) Common @else Normal @endif</td>
                                     <td>Ultrasound</td>
                                  </tr>
                                <?php $i++;  ?>
                                    @endforeach

                                    <?php
                                    $i=$i;
                                    $mri=DB::table('mri_tests')->select('name','technique','status')
                                    ->orderBy('name', 'asc')
                                    ->get();?>
                                      @foreach ($mri as $tst)
                                        <tr>
                                          <td>{{$tst->name}}</td>
                                           <td>{{$tst->technique}}</td>
                                           <td>@if($tst->status == 2) Common @else Normal @endif</td>
                                           <td>MRI Tests</td>
                                        </tr>
                                      <?php $i++;  ?>
                                          @endforeach
                                          <?php
                                          $i=$i;
                                          $ct=DB::table('ct_scan')->select('name','technique','status')
                                          ->orderBy('name', 'asc')
                                          ->get();?>
                                            @foreach ($ct as $tst)
                                              <tr>
                                                <td>{{$tst->name}}</td>
                                                 <td>{{$tst->technique}}</td>
                                                 <td>@if($tst->status == 2) Common @else Normal @endif</td>
                                                 <td>Ct Scan Test</td>
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
    <div class="modal inmodal" id="addtestrady" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content animated flipInY">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>

                    <h4 class="modal-title">Add Tests</h4>

                </div>
                <div class="modal-body col-md-8 col-md-offset-2">




        <form class="form-horizontal" role="form" method="POST" action="{{url('addingtestrdy')}}" novalidate>
        <input type="hidden" name="_token" value="{{ csrf_token() }}">



        <div class="group">
          <div class="form-group">
          <label for="tag_list" class="">Category:</label>
          <select class="test-multiple form-control" name="test_cat"  style="width: 100%">
          <?php $MRIcat=DB::table('test_categories')->where('overall_test_id','1')
          ->distinct()->get(['id','name']); ?>
          <option value=''></option>
          @foreach($MRIcat as $mri)
          <option value='{{$mri->id}}'>{{$mri->name}}</option>
          @endforeach
          </select>
          </div>

        </div>

        <div class="form-group">
        <label>Test Name</label>
        <input type="text" class="form-control"  name="test" placeholder="Test Name" required="">
        </div>

        <div class="form-group">
        <label>Test Technique</label>
        <input type="text" class="form-control"  name="technique" placeholder="Test Technique" >
        </div>

        <div class="group">
          <div class="form-group">
          <label for="tag_list" class="">Status:</label>
          <select class="test-multiple form-control" name="status"  style="width: 100%">
          <option value=''>Select one </option>
          <option value='1'>Normal </option>
          <option value='2'>Common </option>
          </select>
          </div>

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
