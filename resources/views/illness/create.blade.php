@extends('layouts.admin')

@section('content')
<div class="content-page  equal-height">
          <div class="content">
              <div class="container">
  <div class="row">

                  <div class="col-lg-6 col-lg-offset-3">


                              <div class="col-sm-6 ">
                                              <h2>Add illnesses</h2>

                                        {!! Form::open(array('route' => 'illness.store')) !!}
                                       <div class="form-group">
                                          <label for="exampleInputEmail1">Name</label>
                                         <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="illness" name="illness"  required>
                                          </div>
                                        {{Form::submit('Add',array('class' =>'btn btn-success btn-lg btn-block','style'=>'margin-top:20px;'))}}
                                        {!! Form::close() !!}
                                       </div>
                   </div><!--container-->
                </div><!--content -->
            </div><!--content page-->
@endsection
