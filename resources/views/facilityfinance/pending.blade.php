@extends('layouts.finance')
@section('title', 'Pending')
@section('content')
  <div class="content-page  equal-height">
      <div class="content">
          <div class="container">

  <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-11">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Pending Payments</h5>
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

                        <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover dataTables-example" >
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Name</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Action</th>


                      </tr>
                    </thead>

                    <tbody>
            <?php $i=1; $total=0;?>
            @foreach($fees as $fee)
            <tr>
                <td>{{$i}}</td>
                <td><?php $dt=$fee->created_at; echo date("d-m-Y ", strtotime( $dt));?></td>
                <td><?php $dy=$fee->created_at; echo date("g-i-a ", strtotime( $dy));?></td>
                <td>{{$fee->firstname}} {{$fee->secondName}}</td>
                <td>{{$amount}}</td>
                <td>{{$fee->status}}</td>
                <td>
         
                  {!! Form::open(array('url' => 'paid','method'=>'POST','files'=>'true')) !!}
                    <input type="hidden" name="id" value="{{$fee->id}}">
                    <input type="hidden" name="category_id" value="{{$fee->payments_category_id}}">
                    <input type="hidden" name="appointment_id" value="{{$fee->appointment_id}}">
                    <button  type="submit" class="btn btn-xs btn-outline btn-primary">Mark as Paid</button>
                  {!! Form::close() !!}




                </td>
            </tr>
          <?php $i++; $total+=$amount ?>
            @endforeach


                     </tbody>
                     <tfooter>
                        <tr>
                            <th colspan="6" style="text-align: right;" >Total</th>
                           
                           
                            <th>{{$total}}</th>


                      </tr>
                    </tfooter>
                   </table>
                       </div>

                   </div>
               </div>
           </div>
           </div>
       </div>


         </div><!--container-->
      </div><!--content-->
      </div><!--content page-->
             @include('includes.admin_inc.footer')

@endsection
