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
                              <th>Sub-Category</th>
                              <th>Category</th>
                              <!-- <th>Field</th> -->
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
                            <td>{{$tst->sname}}</td>
                            <td>{{$tst->cname}}</td>
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
  <div class="row wrapper border-bottom white-bg page-heading col-lg-11">

<div class="ibox-title">
<h5>Add Tests</h5>
</div>

<form class="form-horizontal" role="form" method="POST" action="/addingtest" novalidate>
<input type="hidden" name="_token" value="{{ csrf_token() }}">
<div class="col-lg-4 col-md-offset-4">
<div class="form-group">
    <label for="tag_list" class="">Overall Category:</label>
<select  id="selectMe" name="overall_cat" class="form-control">
  <?php $overall=DB::table('overall_test')->distinct()->get(['id','category']); ?>
 <option value='9'> Choose one ...</option>
  @foreach($overall as $ovcat)
  <option value='{{$ovcat->id}}'>{{$ovcat->category}}</option>
  @endforeach
  </select>
</div>
<div id="1" class="group">
  <div class="form-group">
  <label for="tag_list" class="">MRI Category:</label>
  <select class="test-multiple" name="test_cat"  style="width: 100%">
  <?php $MRIcat=DB::table('test_categories')->where('overall_test_id','1')
  ->distinct()->get(['id','name']); ?>
  @foreach($MRIcat as $mri)
  <option value='{{$mri->id}}'>{{$mri->name}}</option>
  @endforeach
  </select>
  </div>

</div>
<div id="2" class="group">
  <div class="form-group">
  <label for="tag_list" class="">Laboratory Category:</label>
  <select class="test-multiple" name="test_cat"  style="width: 100%">
  <?php $Laboratory=DB::table('test_categories')->where('overall_test_id','2')
  ->distinct()->get(['id','name']); ?>
  @foreach($Laboratory as $lab)
  <option value='{{$lab->id}}'>{{$lab->name}}</option>
  @endforeach
  </select>
  </div>
</div>
<div id="3" class="group">

<div class="form-group">
<label for="tag_list" class="">Neurology Category:</label>
<select class="test-multiple" name="test_cat"  style="width: 100%">
<?php $Neurology=DB::table('test_categories')->where('overall_test_id','3')
->distinct()->get(['id','name']); ?>
@foreach($Neurology as $neuro)
<option value='{{$neuro->id}}'>{{$neuro->name}}</option>
@endforeach
</select>
</div>
</div>
<div id="4" class="group">

<div class="form-group">
<label for="tag_list" class="">Gastrointestinal Category:</label>
<select class="test-multiple" name="test_cat"  style="width: 100%">
<?php $Gastro=DB::table('test_categories')->where('overall_test_id','4')
->distinct()->get(['id','name']); ?>
@foreach($Gastro as $Gcat)
<option value='{{$Gcat->id}}'>{{$Gcat->name}}</option>
@endforeach
</select>
</div>
</div>

<!-- <div class="form-group">
<label>Test Sub-Category</label>
<input type="text" class="form-control"  name="sub_name">
</div> -->



<div class="form-group">
<label for="tag_list" class="">Test Sub-Category2:</label>
<select class="test-multiple" name="sub_cat_id"  style="width: 100%">
<?php $sub=DB::table('test_subcategories')
->distinct()->get(['id','name']); ?>
@foreach($sub as $Gcat)
<option value='{{$Gcat->id}}'>{{$Gcat->name}}</option>
@endforeach
</select>
</div>


<div class="form-group">
<label>Test Name</label>
<input type="text" class="form-control"  name="test" required="">
</div>
<div class="text-center">
    <button type="submit" class="btn btn-primary">Save</button>
</div>
</div>
     {!! Form::close() !!}

    </div>
  </div>
</div>

</div>
</div><!--container-->
@endsection
