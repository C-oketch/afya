@extends('layouts.manufacturer')
@section('title', 'Manufacturer')
@section('content')
  <div class="content-page  equal-height">
      
      <div class="content">
          <div class="container">



            <div class="wrapper wrapper-content animated fadeInRight">
                      <div class="row">
                          <div class="col-lg-11">
                          <div class="ibox float-e-margins">
                              <div class="ibox-title">

                                  <div class="ibox-tools">

                                      <a class="collapse-link">
                                          <i class="fa fa-chevron-up"></i>
                                      </a>
                                      <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                          <i class="fa fa-wrench"></i>
                                      </a>
                                      <ul class="dropdown-menu dropdown-user">

                                          <li><a href="#">Config option 1</a>
                                          </li>
                                          <li><a href="#">Config option 2</a>
                                          </li>
                                      </ul>
                                      <a class="close-link">
                                          <i class="fa fa-times"></i>
                                      </a>
                                  </div>
                              </div>
                              <div class="ibox-content">
                              <a data-toggle="modal" class="btn btn-primary" href="#modal-form">Add Sales Rep</a>
                                <div id="modal-form" class="modal fade" aria-hidden="true">
                            <div class="modal-dialog">
                            <div class="modal-content">
                            <div class="modal-body">
          
      <?php $id=Auth::user()->id;?>
       <form class="form-horizontal" role="form" method="POST" action="/addsalesrep" novalidate>
             <input type="hidden" name="_token" value="{{ csrf_token() }}">
             <input type="hidden" name="id" value="{{$id}}">
             
                       <div class="form-group">
            <label for="exampleInputPassword1">Region</label>
            <select name="user" class="form-control">
            <?php $reps=DB::table('manufacturers_employees')->join('users','users.id','=','manufacturers_employees.users_id')->where('manufacturers_employees.job','=','Sales Representatives')->select('users.*')->get();?>
            @foreach($reps as $rep)
           <option value="{{$rep->id}}">{{$rep->name}}</option>
            @endforeach              
            </select>
             </div>
             <div class="form-group">
            <label for="exampleInputPassword1">Assign Drug</label>
            <select name="drug" class="form-control">
            <?php
            $emp=DB::table('manufacturers_employees')->where('users_id',$id)->first();
            $manufacturer=DB::table('manufacturers')->where('user_id',$emp->manu_id)->first(); 
            $drugs=DB::table('druglists')->where('Manufacturer',$manufacturer->name)->get();?>
            @foreach($drugs as $drug)
           <option value="{{$drug->id}}">{{$drug->drugname}}</option>
            @endforeach              
            </select>
             </div>
             <div class="form-group">
            <label for="exampleInputPassword1">Region</label>
            <select name="region" class="form-control">
            <?php $counties=DB::table('county')->get();?>
            @foreach($counties as $county)
           <option value="{{$county->county}}">{{$county->county}}</option>
            @endforeach              
            </select>
             </div>

            
          

            <input  type="submit" class="btn btn-primary btn btn-block " value="Add">
    </form>
     
      
      </div>
      </div>
      </div>
      </div>
<br><br>
                                  <div class="table-responsive">
                              <table class="table table-striped table-bordered table-hover dataTables-example" >
                              <thead>
                                                                           
        
                                                      <tr>
                                                          <th>No</th>
                                                     <th>Name</th>
                                                     <th>Email</th>
                                                     
                                                    <th>Joined Date</th>

                                                         </tr>
                                                    </tr>
                                                  </thead>

                                                  <tbody>
                                                  <?php $i=1;
                                                  $sales=DB::table('sales_rep')->join('users','users.id','=','sales_rep.users_id')->select('users.*')->where('sales_rep.manager_id',$id)->get();
                                                  ?>
                                                  @foreach($sales as $sale)
                                                  <tr>
                                                  <td>{{$i}}</td>
                                                  <td>{{$sale->name}}</td>
                                                  <td>{{$sale->email}}</td>
                                                  <td>{{$sale->created_at}}</td>
                                                  </tr>
                                                   
                                                   @endforeach
                                                   </tbody>
                                                 
                                                 </table>
                                                     </div>

                                                 </div>
                                             </div>
                                         </div>
                                         </div>
                                     </div>



                         </div>
@include('includes.default.footer')
          </div><!--content-->
      </div><!--content page-->

@endsection
