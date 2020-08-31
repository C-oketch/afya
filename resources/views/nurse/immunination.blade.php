@extends('layouts.app')
@section('content')
  <div class="row">
    <div class="col-lg-10 col-md-offset-1">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Immunization Details</h5>
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


    <div class="multi-fields">
      <form class="form" role="form" method="POST" action="/immunization" novalidate>
     <input type="hidden" name="_token" value="{{ csrf_token() }}">


                <div class="form-group">
                <input type="hidden" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="{{$id}}" name="id"  required>
         <?php  $vaccine=DB::table('dependant_vaccination')->leftjoin('vaccine','dependant_vaccination.vaccine_id','=','vaccine.id')->select('vaccine.*','dependant_vaccination.*')->where('dependant_vaccination.id',$id)->first(); ?>
         <input type="hidden" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="{{$vaccine->dependent_id}}" name="userid"  required>
 
                                                        
     

    <div class="form-group">
    <label for="exampleInputEmail1">Disease</label>
    <input type="text" class="form-control" id="exampleInputPassword1" placeholder="" name="phone" value="{{$vaccine->disease or ''}}" readonly  >
    </div>
    <div class="form-group">
    <label for="exampleInputEmail1">Antigen</label>
    <input type="text" class="form-control" id="exampleInputPassword1" placeholder="" name="phone" value="{{$vaccine->antigen or ''}}" readonly  >
    </div>

     <div class="form-group">
   <label for="exampleInputEmail1">Status</label>
   Not Done <input type="checkbox" value="NotDone"  name="status" />
   Done <input type="checkbox" value="Done"  name="status"  />
    

<div class="Done"  style="display: none">
   
                 
                 <div class="form-group" id="data_1">
                 <label for="exampleInputPassword1">Date of Vaccine</label>
                 <div class="input-group date">
                     <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                     <input type="text" class="form-control" name="vaccine_date" value="">
                 </div>
                 </div>
                 
               
  
</div>
</div>

<br>
                                                       
     <button type="submit" class="btn btn-primary">Save</button>
      {!! Form::close() !!}
               </div>  <!-- /.form-group -->

              </div>
            
    </div>
    </div>
 </div>
</div>
 @include('includes.default.footer')
             </div>
           
            
            @endsection
