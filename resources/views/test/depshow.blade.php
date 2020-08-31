@extends('layouts.test')
@section('title', 'Tests')
@section('content')

<div class="container">
	<div class="col-lg-11 white-bg">
		<div class="ibox-content">
		<div class="col-lg-6">
	<h2>Patient : {{$info->firstName}} {{$info->secondName}}</h2>
	<ol class="breadcrumb">
	<li><a>@if($info->gender==1){{'Gender :'}}{{"Male"}}@else{{'Gender :'}}{{"Female"}}@endif</a></li>
	<li><a>{{'Age :'}}{{$info->age}}</a> </li>

	</ol>
	</div>
<div class="col-lg-5">

</ol>
</div>
</div>
	</div>




  <div class="col-lg-11">
		<div class="ibox float-e-margins">
    <div class="ibox-title">
        <h5>Aded Tests</h5>
				<div class="ibox-tools">

									<a href="{{URL('test.deppinfo',$info->id)}}">
										<button class="btn btn-info">Show Added Tests</button>

									</a>
								 </div>
						</div>
<div class="ibox-content">
       <div class="table-responsive">
          <table class="table table-striped table-bordered table-hover dataTables-example" >
        <thead>
  					<tr>
  						<th>#</th>
							<th>Test</th>
  						<th>Categories</th>
              <th>Group</th>
              <th>Actions</th>
  					</tr>
  				</thead>
          <?php  $i =1;?>

  				@foreach($tets as $item)

  				<tr class="item{{$item->id}}">
						<td>{{$i}}</td>
						<td>{{$item->name}}</td>
  					<td>{{$item->created_at}}</td>
  					<td>{{'category'}}</td>
            <td><a href="{{URL('test.remove',$item->id)}}">
							<button class="btn btn-danger">Remove Tests</button>
          </a></td>

  				</tr>
          <?php $i++; ?>
  				@endforeach
  			</table>
  		</div>
			</div>
    </div>
</div>


    @endsection
    <!-- Section Body Ends-->
    @section('script')
     <!-- Page-Level Scripts -->

    @endsection
