<div id="tab-3" class="tab-pane">
 <ul class="nav nav-tabs">
<li class=" active"><a data-toggle="tab" href="#tab-3-1a">Today</a></li>
<li class=""><a data-toggle="tab" href="#tab-3-2a">This Week</a></li>
 <li class=""><a data-toggle="tab" href="#tab-3-3a">This Month</a></li>
<li class=""><a data-toggle="tab" href="#tab-3-4a">This Year</a></li>
<li class=""><a data-toggle="tab" href="#tab-3-5a">Max</a></li>
 <li class=""><a data-toggle="tab" href="#tab-3-6a">Custom</a></li>
</ul>
<br>
<div class="tab-content">
    <div id="tab-3-1a" class="tab-pane active">
    <div class="panel-body">
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
  <!-- sales Today -->
  <div class="ibox-content">
      <div class="table-responsive">
  <table class="table table-striped table-bordered table-hover dataTables-example" >
  <thead>


                          <tr>
                        <th>No</th>
                          <th>Region</th>
                         <th>Prescribing Doctor</th>
                          <th>Drug Name</th>
                               <th>Facility</th>
                              <th>Pharmacy  name</th>
                             <th> Quantity</th>
                             <th>Dosage</th>
                             <th>Unit Cost</th>
                             <th>Total </th>
                             </tr>

                      </thead>

                      <tbody>
                        <?php $i =1;
                        use Carbon\Carbon;?>
                     @foreach($Dsales as $mandrug)
                     <?php $total= ($mandrug->quantity * $mandrug->price);

                     ?>
                          <tr>
                              <td>{{$i}}</td>
                                <td>{{$mandrug->county}}</td>
                               <td>{{$mandrug->name}}</td>
                              <td> {{$mandrug->drugname}}</td>
                              <td>{{$mandrug->FacilityName}}</td>
                              <td>{{$mandrug->pharmacy}}</td>
                              <td>{{$mandrug->quantity}}</td>
                              <td>{{$mandrug->dose_given}}</td>
                              <td>{{$mandrug->price}}</td>
                              <td>{{$total}}</td>
                            </tr>
                              <?php $i++;  ?>
                            @endforeach

                         </tbody>
                     </table>
                     </div>
                     </div>
                     </div>

    </div>
    </div>
<div id="tab-3-2a" class="tab-pane ">
    <div class="panel-body">
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
<!-- sales This week -->
      <div class="table-responsive">
  <table class="table table-striped table-bordered table-hover dataTables-example" >
  <thead>


                          <tr>
                              <th>No</th>
                              <th>Region</th>
                              <th>Prescribing Doctor</th>
                               <th>Drug Name</th>
                               <th>Facility</th>
                              <th>Pharmacy  name</th>
                             <th> Quantity</th>
                             <th>Dosage</th>
                             <th>Unit Cost</th>
                             <th>Total  </th>
                             </tr>

                      </thead>

                      <tbody>
                        <?php $i =1;?>
                       @foreach($drugw as $mandrug)
                     <?php $total= ($mandrug->quantity * $mandrug->price);

                     ?>
                          <tr>
                              <td>{{$i}}</td>
                                <td>{{$mandrug->county}}</td>
                              <td>{{$mandrug->name}}</td>
                              <td> {{$mandrug->drugname}}</td>
                              <td>{{$mandrug->FacilityName}}</td>
                              <td>{{$mandrug->pharmacy}}</td>
                              <td>{{$mandrug->quantity}}</td>
                              <td>{{$mandrug->dose_given}}</td>
                              <td>{{$mandrug->price}}</td>
                              <td>{{$total}}</td>
                            </tr>
                              <?php $i++;  ?>
                            @endforeach

                         </tbody>
                       </table>
                     </div>
                     </div>
                     </div>

    </div>
    </div>
    <div id="tab-3-3a" class="tab-pane ">
    <div class="panel-body">
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
<!-- sales This Month -->
      <div class="table-responsive">
  <table class="table table-striped table-bordered table-hover dataTables-example" >
  <thead>


                          <tr>
                              <th>No</th>
                              <th>Region</th>
                              <th>Prescribing Doctor</th>
                               <th>Drug Name</th>
                               <th>Facility</th>
                              <th>Pharmacy  name</th>
                             <th> Quantity</th>
                             <th>Dosage</th>
                             <th>Unit Cost</th>
                             <th>Total  </th>
                             </tr>

                      </thead>

                      <tbody>
                        <?php $i =1; ?>
                     @foreach($drugM as $mandrug)
                     <?php $total= ($mandrug->quantity * $mandrug->price);

                     ?>
                          <tr>
                              <td>{{$i}}</td>
                              <td>{{$mandrug->county}}</td>
                              <td>{{$mandrug->name}}</td>
                              <td> {{$mandrug->drugname}}</td><td>{{$mandrug->FacilityName}}</td>
                              <td>{{$mandrug->pharmacy}}</td>
                              <td>{{$mandrug->quantity}}</td>
                              <td>{{$mandrug->dose_given}}</td>
                              <td>{{$mandrug->price}}</td>
                              <td>{{$total}}</td>
                            </tr>
                              <?php $i++;  ?>
                            @endforeach

                         </tbody>

                     </table>
                     </div>
                     </div>
                     </div>

    </div>
    </div>
<div id="tab-3-4a" class="tab-pane">
    <div class="panel-body">
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
<!-- sales This Year -->
      <div class="table-responsive">
  <table class="table table-striped table-bordered table-hover dataTables-example" >
  <thead>


                          <tr>
                              <th>No</th>
                              <th>Region</th>
                              <th>Prescribing Doctor</th>
                               <th>Drug Name</th>
                               <th>Facility</th>
                              <th>Pharmacy  name</th>
                             <th> Quantity</th>
                             <th>Dosage</th>
                             <th>Unit Cost</th>
                             <th>Total  </th>
                             </tr>

                      </thead>

                      <tbody>
                        <?php $i =1;   ?>
                         @foreach($drugY as $mandrug)
                     <?php $total= ($mandrug->quantity * $mandrug->price);

                     ?>
                          <tr>
                              <td>{{$i}}</td>
                                <td>{{$mandrug->county}}</td>
                              <td>{{$mandrug->name}}</td>
                              <td> {{$mandrug->drugname}}</td>
                              <td>{{$mandrug->FacilityName}}</td>
                              <td>{{$mandrug->pharmacy}}</td>
                              <td>{{$mandrug->quantity}}</td>
                              <td>{{$mandrug->dose_given}}</td>
                              <td>{{$mandrug->price}}</td>
                              <td>{{$total}}</td>
                            </tr>
                              <?php $i++;  ?>
                            @endforeach

                         </tbody>

                     </table>
                     </div>
                     </div>
                     </div>

    </div>
    </div>
<div id="tab-3-5a" class="tab-pane">
    <div class="panel-body">
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
<!-- sales All times-->
      <div class="table-responsive">
  <table class="table table-striped table-bordered table-hover dataTables-example" >
  <thead>


                          <tr>
                              <th>No</th>
                              <th>Region</th>
                              <th>Prescribing Doctor</th>
                               <th>Drug Name</th>
                               <th>Facility</th>
                              <th>Pharmacy  name</th>
                             <th> Quantity</th>
                             <th>Dosage</th>
                             <th>Unit Cost</th>
                             <th>Total  </th>
                             </tr>

                      </thead>

                      <tbody>
                        <?php $i =1; ?>
                            @foreach($drugall as $mandrug)
                     <?php $total= ($mandrug->quantity * $mandrug->price);

                     ?>
                          <tr>
                              <td>{{$i}}</td>
                                <td>{{$mandrug->county}}</td>
                              <td>{{$mandrug->name}}</td>
                            <td> {{$mandrug->drugname}}</td>
                              <td>{{$mandrug->FacilityName}}</td>
                              <td>{{$mandrug->pharmacy}}</td>
                              <td>{{$mandrug->quantity}}</td>
                              <td>{{$mandrug->dose_given}}</td>
                              <td>{{$mandrug->price}}</td>
                              <td>{{$total}}</td>
                            </tr>
                              <?php $i++;  ?>
                            @endforeach

                         </tbody>

                     </table>
                     </div>
                     </div>
                     </div>

    </div>
    </div>
<div id="tab-3-6a" class="tab-pane">
    <div class="panel-body">
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
<!-- sales All Custom-->
      <div class="table-responsive">
  <table class="table table-striped table-bordered table-hover dataTables-example" >
  <thead>


                          <tr>
                              <th>No</th>
                              <th>Region</th>
                              <th>Prescribing Doctor</th>
                               <th>Drug Name</th>
                               <th>Facility</th>
                              <th>Pharmacy  name</th>
                             <th> Quantity</th>
                             <th>Dosage</th>
                             <th>Unit Cost</th>
                             <th>Total  </th>
                             </tr>

                      </thead>

                      <tbody>


                       </tbody>

                     </table>
                     </div>
                     </div>
                     </div>

    </div>
    </div>
</div>
</div>
