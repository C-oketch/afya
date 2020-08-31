@extends('layouts.test')
@section('title', 'Tests')
@section('content')
<div class="wrapper wrapper-content animated fadeInRight white-bg">
		<div class="row">
						<div class="col-lg-12">
							<div class="col-md-6">
								<address>
							<h2></h2><strong>Patient Details:</strong><br />
							<strong>NAME : </strong>{{$info->firstname}} {{$info->secondName}}<br />
							<strong>Gender :</strong> {{$info->gender}}<br />
							<?php $interval = date_diff(date_create(), date_create($info->dob));
							     $aged= $interval->format(" %Y Year, %M Months");
							?>
							<strong>Age:</strong> {{$aged}}
							</div>
							<div class="col-md-6 text-right">
								<address>
									<h2></h2><strong>Facility:</strong><br />
									{{$facid->FacilityName}}<br>
									<strong>{{$facid->speciality}} :</strong><br />
									{{$facid->firstname}} {{$facid->secondname}}<br>
                 </address>
							</div>
          </div>
       </div>
			</div>





  <div class="col-lg-12">
		<div class="ibox float-e-margins">
    <div class="ibox-title">
        <h5>Added Tests</h5>


			<div class="ibox-tools">
				<a href="{{URL('test')}}" class="btn btn-primary btn-sm">Back</a>

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

					@foreach($alternativetets as $item)

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
