@extends('layouts.patient')
@section('title', 'Appointment List')
@section('content')
  <div class="content-page  equal-height">
      <div class="content">
          <div class="container">

  <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-11">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Appointment Lists</h5>
                        <div class="ibox-tools">
                          @role('Patient')
                               @endrole
                           <a class="collapse-link">

                          </a>

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
                  <table class="table table-bordered" id="posts">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Speciality</th>
                            <th>Address</th>
                            <th>Options</th>

                      </tr>
                    </thead>
                   </table>
                  </div>

                   </div>
               </div>
           </div>
           </div>
       </div>
       @include('includes.default.footer')

         </div><!--container-->
      </div><!--content-->
      </div><!--content page-->



      <script>
          $(document).ready(function () {
              $('#posts').DataTable({
                  "processing": true,
                  "serverSide": true,
                  "ajax":{
                           "url": "{{ url('systdoctors') }}",
                           "dataType": "json",
                           "type": "POST",
                           "data":{ _token: "{{csrf_token()}}"}
                         },
                  "columns": [
                      { "data": "id" },
                      { "data": "name" },
                      { "data": "speciality" },
                      { "data": "address" },
                      { "data": "options" }
                  ]

              });
          });
      </script>
@endsection
