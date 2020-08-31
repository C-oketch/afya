@extends('layouts.registrar_layout')
@section('title', 'Dashboard')

@section('content')
  <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
              <table class="table table-bordered" id="posts">
                   <thead>
                          <th>No</th>
                          <th>Name</th>
                          <th>Code</th>
                          <th>Description</th>
                          <th>Options</th>
                   </thead>
              </table>
            </div>
        </div>
    </div>
@endsection
@section('script-reg')
<script>
    $(document).ready(function () {
        $('#posts').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax":{
                     "url": "{{ url('allPosts') }}",
                     "dataType": "json",
                     "type": "POST",
                     "data":{ _token: "{{csrf_token()}}"}
                   },
            "columns": [
                { "data": "id" },
                { "data": "code" },
                { "data": "name" },
                { "data": "long_desc" },
                { "data": "options" }
            ]

        });
    });
</script>
@endsection
