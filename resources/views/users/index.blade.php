@extends('layouts.admin')
@section('title', 'users')
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
                        <h5>Users Management</h5>
                        <div class="ibox-tools">
											@role('Admin')	<a class="btn btn-primary" href="{{ route('users.create') }}"> Create New User</a>@endrole
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
                      <th>Name</th>
                      <th>Email</th>
											<th>Department</th>
                    	<th>Roles</th>
								     @role('Admin')<th width="280px">Action</th>	@endrole
                    </tr>
                    </thead>
                    <tbody>

												@foreach ($data as $key => $user)
												<tr class="gradeC">
                        <td>{{ ++$i }}</td>

													<td>{{ $user->name }}</td>

													<td>{{ $user->email }}</td>
											    <td>{{ $user->role }}</td>
													<td>

														@if(!empty($user->roles))

															@foreach($user->roles as $v)

																<label class="label label-success">{{ $v->display_name }}</label>

															@endforeach

														@endif

													</td>
											@role('Admin')
													<td>
@if($user->id !=1)
												<a class="btn btn-info" href="{{ route('users.show',$user->id) }}">Show</a>
                                                <a class="btn btn-primary" href="{{ route('users.edit',$user->id) }}">Edit</a>

														{!! Form::open(['method' => 'DELETE','route' => ['users.destroy', $user->id],'style'=>'display:inline']) !!}
											            {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
											        	{!! Form::close() !!}
            @endif
                           </td>
											@endrole
											</tr>
										@endforeach
	               {!! $data->render() !!}
                    </tbody>
                    <tfoot>
                    <tr>
											<th>No</th>
											<th>Name</th>
											<th>Email</th>
											<th>Department</th>
											<th>Roles</th>
										 @role('Admin')<th width="280px">Action</th>	@endrole
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
