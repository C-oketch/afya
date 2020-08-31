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
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addtest">Add Laboratory Test</button>
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
                              <th>Sub-Category</th>
                              <th>Action</th>

                           </tr>
                            </thead>
                            <tbody>
                        <?php
                        $i=1;
                      $tests=DB::table('overall_test')
                       ->join('test_categories','overall_test.id','=','test_categories.overall_test_id')
                       ->join('test_subcategories','test_categories.id','=','test_subcategories.categories_id')
                       ->join('tests','test_subcategories.id','=','tests.sub_categories_id')
                       ->select('overall_test.category as oname','test_categories.name as cname',
                       'test_subcategories.name as sname','test_subcategories.id as sid','tests.name as tname','tests.id as tid')
                      ->orderBy('tid', 'asc')
                      ->get();?>
                        @foreach ($tests as $tst)
                          <tr>
                            <td><a href="{{route('viewgrp',$tst->tid)}}">{{$tst->tid}}</a></td>
                            <td><a href="{{route('teststo',$tst->tid)}}">{{$tst->tname}}</a></td>
                            <td>{{$tst->cname}}</td>
                             <td>{{$tst->sname}}</td>
                            <!-- <td>{{$tst->oname}}</td> -->
                          <td>
                          {!! Form::open(['method' => 'DELETE','route' => ['testts.destroy', $tst->tid],'style'=>'display:inline']) !!}
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

                    <h4 class="modal-title">Add Tests</h4>

                </div>
                <div class="modal-body col-md-8 col-md-offset-2">




        <form class="form-horizontal" role="form" method="POST" action="{{url('addingtest')}}" novalidate>
        <input type="hidden" name="_token" value="{{ csrf_token() }}">




        <div  class="group">
          <div class="form-group">
          <label for="tag_list" class="">Laboratory Category:</label>
          <select class="test-multiple form-control" name="test_cat"  style="width: 100%">
          <?php $Laboratory=DB::table('test_categories')->where('overall_test_id','2')
          ->distinct()->get(['id','name']); ?>
          <option value=''></option>
          @foreach($Laboratory as $lab)
          <option value='{{$lab->id}}'>{{$lab->name}}</option>
          @endforeach
          </select>
          </div>
        </div>




        <!-- <div class="form-group">
        <label>Test Sub-Category</label>
        <input type="text" class="form-control"  name="sub_name">
        </div> -->



        <div class="form-group">
        <label for="tag_list" class="">Test Sub-Category:</label>
        <select class="test-multiple form-control" name="sub_cat_id"  style="width: 100%">
        <?php $sub=DB::table('test_subcategories')->distinct()->get(['id','name']); ?>
        @foreach($sub as $Gcat)
        <option value='{{$Gcat->id}}'>{{$Gcat->name}}</option>
        @endforeach
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
