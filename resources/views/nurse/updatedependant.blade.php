@extends('layouts.nurse')
@section('title', 'Patient Details')
@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
    
    <div class="row">
    <div class="col-lg-8 col-lg-offset-2">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Update Dependant Details</h5>
                <div class="ibox-tools">
                    <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                    </a>
                     <a class="close-link">
                        <i class="fa fa-times"></i>
                    </a>
                </div>
            </div>
            <div class="ibox-content">
           
    <form class="form-horizontal" role="form" method="POST" action="/Dependantupdate" novalidate>
             <input type="hidden" name="_token" value="{{ csrf_token() }}">
             <input type="hidden" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="{{$id}}" name="id"  required>
              <div class="form-group">
             <label for="exampleInputEmail1">Father Name</label>
             <input type="name" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Father Name" name="father_name"    >
             </div>


              <div class="form-group">
             <label for="exampleInputPassword1">Father Phone</label>
             <input type="number" class="form-control" id="exampleInputPassword1" placeholder="Father Phone" name="father_phone"  >
             </div>
             <div class="form-group">
            <label for="exampleInputPassword1">Mother Name</label>
            <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Mother Name" name="mother_name">
            </div>
             <div class="form-group">
            <label for="exampleInputPassword1">Mother Phone</label>
             <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Mother Phone" name="mother_phone" >
            </div>
            <div class="form-group">
            <label for="exampleInputPassword1">Birth Number</label>
             <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Birth Number" name="Birth_number" >
            </div>
            <div class="form-group">
            <label for="exampleInputEmail1">Younger sibling(born to mother)?</label>
            No <input type="checkbox" value="No"  name="birth" />
            Yes <input type="checkbox" value="Yes"  name="birth"  />
            <div class="Yes" style="display: none">
             <div class="form-group" id="data_1">
                 <label>Date of Birth</label>
                 <div class="input-group date">
                     <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                     <input type="text" class="form-control" name="dob" value="">
                 </div>
                 </div> 
    
</div>
</div>
             
    <input type="submit" name="submit">
    </form>
    </div>
    </div>
    </div>

  @include('includes.default.footer')
</div>


</div>

@endsection          
            
  
