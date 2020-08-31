@extends('layouts.manufacturer')
@section('title', 'Ads')
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
                        <h5>Ads Management</h5>
                        <div class="ibox-tools">
							<a class="btn btn-primary" href="{{ route('ads.create') }}">New Ad</a>
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
                      <th>Ad Name</th>
                      <th>Drug Name</th>
					  <th>Created On</th>
					  <th width="280px">Action</th>
                    </tr>
                    </thead>
                    <tbody>

					@foreach ($ads as $ad)
						<tr class="gradeC">

							<td>{{ $ad->ad_name }}</td>
							<td>{{ $ad->drugname }}</td>
							<td>{{ $ad->created_at }}</td>
							
							<td>

        						<a class="btn btn-info" href="{{ $ad->ad_video }}">View Video</a>
                                <a class="btn btn-primary" href="{{ route('ads.edit',$ad->id) }}">Edit</a>

								{!! Form::open(['method' => 'DELETE','route' => ['ads.destroy', $ad->id],'style'=>'display:inline']) !!}

					            {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}

					        	{!! Form::close() !!}
                                                   
                           </td>
											
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

  </div><!--container-->
 </div><!--content -->
</div><!--content page-->
@endsection
