@extends('layouts.nhif')
@section('title', 'Nhif Dashboard')
@section('content')
<div class="content-page  equal-height">
          <div class="content">
              <div class="container">
              <div class="row">
              <div class="col-sm-12">
             
               <div class="panel-body">
                                <div class="ibox float-e-margins">
                              <div class="ibox-title">
                                 <h5>Nhif Facilities</h5>
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
                               
                            
  <div class="modal inmodal" id="modal-add" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content animated flipInY">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">Add Facility</h4>
                    
                </div>
                <div class="modal-body">
          <form class="form-horizontal" role="form" method="POST" action="{{route('nhif.store')}}" novalidate>
             <input type="hidden" name="_token" value="{{ csrf_token() }}">
            
             <div class="form-group">
             <label for="exampleInputEmail1">Facility</label>
               <select name="facility_id" data-placeholder="Choose a Country..." class="chosen-select"  tabindex="2">
                <option value="">Select</option>
                @foreach ($facilities as $fact)
                <option value="{{$fact->id}}">{{$fact->FacilityName}}</option>
                @endforeach
              </select>
             </div>
            
         <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>


        </form>
    </div>
    </div>
    </div>
    </div>
                              <table class="table table-striped table-bordered table-hover dataTables-example" >
                              <thead>

                                                      <tr>
                                                    <th>No</th>
                                                     <th>Facility Code</th>
                                                     <th>Facility Name</th>
                                                     <th>Type</th>
                                                     <th>County</th>
                                                     <th>Constituency</th>                                                     
                                                     <th>Ward</th>
                                                     <th>Bed Capacity</th>                                                     
                                                     <th>Ownership</th>
                                                

                                                         </tr>

                                                  </thead>

                                                  <tbody>
                                                  <?php 
                                                  $i=1;
                                                 ?>
                                                  @foreach ($nhif_facilities as $fact)
                                                    <tr>
                                                    	<td>{{$i}}</td>
                                                    	<td>{{$fact->FacilityCode}}</td>
                                                    	<td>{{$fact->FacilityName}}</td>
                                                    	<td>{{$fact->Type}}</td>
                                                    	<td>{{$fact->County}}</td> 
                                                    	<td>{{$fact->Constituency}}</td> 
                                                    	
                                                    	<td>{{$fact->Ward}}</td> 
                                                    	                                        
                                                      <td>{{$fact->Beds+$fact->Cots}}</td> 
                                                      
                                                      <td>{{$fact->Owner}}</td>

                                              

                                                    	
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
 


 </div>



</div>
                   </div><!--container-->
                
@endsection
