@extends('layouts.facilityadmin')
@section('title', 'Finance')
@section('content')
<div class="content-page  equal-height">
		<div class="content">
				<div class="container">



	@if ($message = Session::get('success'))

		<div class="alert alert-success">

			<p>{{ $message }}</p>

		</div>

	@endif
	<div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Finance Officers</h5>
                        <div class="ibox-tools">
											@role('FacilityAdmin')	<a class="btn btn-primary" href="{{ route('facility-finance.create') }}"> Create New User</a>@endrole
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
											
                      <th>Name</th>
                      <th>Email</th>
									
					@role('FacilityAdmin')<th width="280px">Action</th>	@endrole
                    </tr>
                    </thead>
                    <tbody>

												@foreach ($officers as $key => $user)
												<tr class="gradeC">
                       

													<td>{{ $user->name }}</td>

													<td>{{ $user->email }}</td>
											@role('FacilityAdmin')
													<td>


														{!! Form::open(['method' => 'DELETE','route' => ['facility-finance.destroy', $user->id],'style'=>'display:inline']) !!}

											            {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}

											        	{!! Form::close() !!}
                           </td>
											@endrole
											</tr>
										@endforeach
	             
                    </tbody>
                    <tfoot>
                    <tr>
											
											<th>Name</th>
											<th>Email</th>											
										 @role('FacilityAdmin')<th width="280px">Action</th>	@endrole
                    </tr>
                    </tfoot>
                    </table>
                        </div>

                    </div>
                </div>
            </div>
            </div>
        </div>
				@include('includes.admin_inc.footer')

  </div><!--container-->
 </div><!--content -->
</div><!--content page-->
@endsection
