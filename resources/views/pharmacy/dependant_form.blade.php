@extends('layouts.pharmacy')
@section('title', 'Pharmacy')
@section('content')

<div class="wrapper wrapper-content animated fadeInRight">
     <div class="row">

    <div class="col-lg-6">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Customer Information</h5>

            </div>
            <div class="ibox-content">
              <?php
              $user = DB::table('afya_users')
              ->where('id', '=', $id)
              ->first();

              if(! isset($user->dob))
              {
               ?>

              <form class="form-horizontal" role="form" method="POST" action="/insert_parent_dob" >

                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <input type="hidden" class="form-control" name="afya_user_id" value="{{$id}}" readonly="">

              <div class="form-group" >
               <label for="exampleInputPassword1">Date of Birth</label>
               <div class="input-group date" >
                   <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                   <input type="text" class="form-control" name="dob" id="date_2" >
               </div>
               </div>

                 <button type="submit" class="btn btn-primary btn-sm">Create Details</button>
                 </form>
                 <?php
               }
               else
               {
                  ?>


                  <form class="form-horizontal" role="form" method="POST" action="/edit_parent_dob" >

                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    <input type="hidden" class="form-control" name="afya_user_id" value="{{$id}}" >

                  <div class="form-group" >
                   <label for="exampleInputPassword1">Date of Birth</label>
                   <div class="input-group date">
                       <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                       <input type="text" class="form-control" id="date_2" name="dob" value="{{$user->dob}}" readonly="">
                   </div>
                   </div>

                     <button type="submit" class="btn btn-primary btn-sm">Update Details</button>
                     </form>

                     <?php
                   }
                      ?>


          </div>
          <a href="{{route('pharmacy.show_alternative',$id)}}"><button type="button" class="btn btn-w-m btn-primary">Back</button></a>
        </div>
      </div>


 <div class="col-lg-6">
     <div class="ibox float-e-margins">
         <div class="ibox-title">
             <h5>Dependant Details</h5>

         </div>
         <div class="ibox-content">
           <div class="ibox-content">

             <form class="form-horizontal" role="form" method="POST" action="/create_alt_dependent" >

            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="{{$id}}" name="id"  >

            <div class="form-group">
            <label for="exampleInputEmail1">First Name</label>
            <input type="name" class="form-control"  aria-describedby="emailHelp"  name="first" required="" />
            </div>

            <div class="form-group">
           <label for="exampleInputEmail1">Second Name</label>
           <input type="name" class="form-control"  aria-describedby="emailHelp"  name="second" required="" />
           </div>

           <div class="form-group">
            <label for="exampleInputPassword1">Gender</label>
             <input type="radio" value="Male" id="optionsRadios2" name="gender" required="">Male
              <input type="radio" value="Female" id="optionsRadios3" name="gender" required="">Female
            </div>

            <div class="form-group">
           <label for="exampleInputPassword1">Relationship</label>
          <select class="form-control" name="relationship" required="">
            <option value="" selected disabled>Select Relation</option>
          <?php  $kin = DB::table('kin')->get();?>
                        @foreach($kin as $kn)
                         <option value="{{$kn->relation}}">{{$kn->relation}}</option>
                       @endforeach
                      </select>
          </div>

          <div class="form-group">
         <label for="exampleInputPassword1">Blood Type</label>
        <select class="form-control" name="blood" required="">
          <option value="" selected disabled>Select blood type</option>
        <?php  $types = DB::table('blood_types')->get();?>
              @foreach($types as $type)
               <option value="{{$type->type}}">{{$type->type}}</option>
             @endforeach
          </select>
        </div>

               <div class="form-group">
                <label for="exampleInputPassword1">Place of Birth</label>
                <input type="text" class="form-control" id="exampleInputPassword1"  name="birth_place" required=""/>
                </div>

                <div class="form-group">
                 <label for="exampleInputPassword1">Date of Birth</label>
                 <input type="text" class="form-control" id="date_2"  name="dep_dob" required=""/>
                 </div>

              <button type="submit" class="btn btn-primary btn-sm">Create Details</button>
                 {!! Form::close() !!}

       </div>
       </div>
       </div>

     </div>
     </div>

      </div>

      <br>

@endsection

@section('date-script')
<script src="{{ asset('js/plugins/datapicker/bootstrap-datepicker.js') }}" type="text/javascript"></script>
@endsection
