
@extends('layouts.app')
@section('title', 'Next Kin')
@section('content')

      <div class="row">
        <div class="col-lg-6 col-md-offset-2">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Next of Kin</h5>
                            <div class="ibox-tools">
                                <a class="collapse-link">
                                    <i class="fa fa-chevron-up"></i>
                                </a>
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                    <i class="fa fa-wrench"></i>
                                </a>

                                <a class="close-link">
                                    <i class="fa fa-times"></i>
                                </a>
                            </div>
                        </div>
    <div class="ibox-content">

    <?php $kin=DB::table('kin_details')->where('afya_user_id',$id)->first(); ?>

     <form class="form-horizontal" role="form" method="POST" action="/updatekin" novalidate>
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="{{$id}}" name="id"  required>

    <div class="form-group">
    <label for="exampleInputEmail1">Name</label>
    <input type="name" class="form-control" value="{{$kin->kin_name}}" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Next Kin Name" name="kin_name"  required>
    </div>

     <div class="form-group">
    <label for="exampleInputPassword1">Phone</label>
    <input type="number" class="form-control" id="exampleInputPassword1" placeholder="Next of Kin Phone" name="phone" value="{{$kin->phone_of_kin}}" required>
    </div>

    <div class="form-group">
     <label for="exampleInputPassword1">Relationship</label>
    <select class="form-control" name="relationship">
    <?php  $kin = DB::table('kin')->get();?>
                  @foreach($kin as $kn)
                   <option value="{{$kn->id}}">{{$kn->relation}}</option>
                 @endforeach
                </select>
    </div>
    
   <button type="submit" class="btn btn-primary btn-sm">Update Details</button>
      {!! Form::close() !!}

</div>


         </div>


</div>
</div>

@endsection
