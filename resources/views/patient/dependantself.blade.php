@extends('layouts.patient')
@section('title', 'Patient')
@section('content')
<div class="content-page  equal-height">
      <div class="content">
          <div class="container">
          <br>
          <div class="row">
            <div class="col-lg-11">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5><?php $dep=$data['dependant'];?> {{$dep->firstName}} {{$dep->secondName}}</h5>
                        <div class="ibox-tools"
                            <a class="collapse-link">                                    
                                <i class="fa fa-chevron-up"></i>
                            </a>

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
                                                                      <th>Date </th>
                                 <th>Temperature</th>
                                <th>Irritable</th>
                                <th>Reduced movement</th>
                                <th>Difficulty Breathing</th>
                                <th>Diarrhoea</th>
                                <th>Vomiting</th>
                                <th>Difficult Feeding</th>
                               <th>Convulsion</th>
                               <th>Partial/Focal Fits</th>
                               <th>Murmur</th>
                               <th>Grunting</th>
                               <th>Crackles</th>
                               <th>Cry</th>
                                 






                                                                </tr>
                                                              </thead>
                                      
                                                              <tbody>
                                                              <?php $i=1; $selfs=$data['selfs']; $id=$data['id'];?>
                                                              @foreach($selfs as $self)
                                                              <tr>
                                                              <td>{{$i}}</td>
                                                               <td>{{$self->created_at}}</td>
                                                              <td>{{$self->temperature}}</td>
                                                              <td>{{$self->irritable}}</td>
                                                              <td>{{$self->reduced_movement}}</td>
                                                              <td>{{$self->difficulty_breathing}}</td>
                                                              <td>{{$self->diarrhoea}}</td>
                                                              <td>{{$self->vomiting}}</td>
                                                              <td>{{$self->difficult_feeding}}</td>
                                                              <td>{{$self->convulsion}}</td>
                                                              <td>{{$self->partial_focalfits}}</td>
                                                              <td>{{$self->murmur}}</td>
                                                              <td>{{$self->grunting}}</td>
                                                              <td>{{$self->crackles}}</td>
                                                              <td>{{$self->cry}}</td>
                                                             


                                                                


                                                              </tr>
                                                          
                                                              


                                                              <?php $i++; ?>
                                                              @endforeach 

                                                               </tbody>
                                                             </table>
                                                               



                    </div>
                    <a href="{{URL('patient.dep_addselfreport',$id)}}" class="btn btn-primary btn-block">Add Details</a>
                </div>
            </div>
        </div>
         

 
        </div>
</div>
@endsection
