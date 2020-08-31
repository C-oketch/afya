@extends('layouts.nurse')
@section('title', 'Patient Details')
@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
  <div class="row">
    <div class="col-lg-6">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Patient Details</h5>
                <div class="ibox-tools">
                    <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                    </a>
                     <a class="close-link">
                        <i class="fa fa-times"></i>
                    </a>
                </div>
            </div>

            <div class="ibox-content">
              <form class="form-horizontal" role="form" method="POST" action="/updateuser" novalidate>
             <input type="hidden" name="_token" value="{{ csrf_token() }}">
             <input type="hidden" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="{{$patient->id}}" name="id"  required>
              <div class="form-group">
             <label for="exampleInputEmail1">Name</label>
             <input type="name" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Next Kin Name" name="kin_name"  value="{{$patient->firstname}}  {{$patient->secondName}}" readonly=""  >
             </div>


              <div class="form-group">
             <label for="exampleInputPassword1">Age</label>
             <input type="number" class="form-control" id="exampleInputPassword1" placeholder="Next of Kin Phone" name="phone" value="{{$patient->age}}" readonly  >
             </div>
             <div class="form-group">
            <label for="exampleInputPassword1">Blood Group</label>
            <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Blood Group" name="phone" value="{{$patient->blood_type or ''}}" readonly  >
            </div>
             <div class="form-group">
            <label for="exampleInputPassword1">Gender</label>
             <?php $gender=$patient->gender;?>
            <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Next of Kin Phone" name="phone"
             value="@if($gender==1){{"Male"}}@else{{"Female"}}@endif " readonly  >
            </div>
            <div class="form-group">
           <label for="exampleInputPassword1">Phone</label>
           <input type="number" class="form-control" id="exampleInputPassword1" placeholder="" name="phone" value="{{$patient->msisdn}}" readonly=""/>
           </div>
           <div class="form-group">
          <label for="exampleInputPassword1">Constituency</label>
          <input type="text" class="form-control" id="exampleInputPassword1" placeholder="" name="phone" value="<?php
          if ($patient->constituency != "") {$county=DB::Table('constituency')->where('id',$patient->constituency)->first();
          echo $county->Constituency;}
          else{ echo "";} ?>" readonly=""/>
          </div>
          <div class="form-group">
         <label for="exampleInputPassword1">County</label>
         <input type="text" class="form-control" id="exampleInputPassword1" placeholder="" name="phone" value="<?php
         if ($patient->constituency != "") {$county=DB::Table('county')->where('id',$county->cont_id)->first();
         echo $county->county;}
         else{ echo "";} ?>" readonly=""/>
         </div>

  <a href="{{ url('nurseupdate', $patient->id) }}" class="btn btn-primary btn-sm">Update Details</a>


            </div>
          </div>
        </div>
    <div class="col-lg-6">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Next of Kin Details</h5>
                <div class="ibox-tools">
                    <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                    </a>
                     <a class="close-link">
                        <i class="fa fa-times"></i>
                    </a>
                </div>
            </div>
            <div class="ibox-content">
                  @if(is_null($kin))
                  <form class="form-horizontal" role="form" method="POST" action="/nextkin" novalidate>
                 <input type="hidden" name="_token" value="{{ csrf_token() }}">
                 <input type="hidden" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="{{$patient->id}}" name="id"  required>
                  <div class="form-group">
                 <label for="exampleInputEmail1">Name</label>
                 <input type="name" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Next Kin Name" name="kin_name"  value="
                  "  >
                 </div>

                 <div class="form-group">
                  <label for="exampleInputPassword1">Relationship</label>
                 <select class="form-control" name="relationship">
                 <?php  $kin = DB::table('kin')->get();?>
                               @foreach($kin as $kn)
                                <option value="{{$kn->id}}">{{$kn->relation}}</option>
                              @endforeach
                             </select>
                 </div>
                  <div class="form-group">
                 <label for="exampleInputPassword1">Phone</label>
                 <input type="number" class="form-control" id="exampleInputPassword1" placeholder="Next of Kin Phone" name="phone" value=""  >
                 </div>
                 <button type="submit" class="btn btn-primary btn-sm">Create Details</button>
                    {!! Form::close() !!}
                @else
                  <form class="form-horizontal">
                <div class="form-group">
                <label for="exampleInputEmail1">Name</label>
                <input type="name" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Next Kin Name" name="kin_name" value="{{$kin->kin_name}}" readonly="">
                </div>

                <div class="form-group">
                <label for="exampleInputPassword1">Relationship</label>
                <input type="name" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Next Kin Name" name="relation"
                value="{{$kin->relation}}"  readonly="">
                </div>

                <div class="form-group">
                <label for="exampleInputPassword1">Phone</label>
                <input type="number" class="form-control" id="exampleInputPassword1" placeholder="Next of Kin Phone" name="phone"
                value="{{$kin->phone_of_kin}}"readonly="">
                </div>
  <a href="{{ route('createkin', $patient->id) }}" class="btn btn-primary btn-sm">Update Details</a>
                        </div>

        {!! Form::close() !!}
                @endif
            </div>
        </div>
      </div>

  <div class="row">
    <div class="col-lg-6">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Smoking History</h5>
                <div class="ibox-tools">
                    <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                    </a>
                     <a class="close-link">
                        <i class="fa fa-times"></i>
                    </a>
                </div>
            </div>

            <div class="ibox-content">
             @if(is_null($smoking))
             
            {!! Form::open(array('url' => 'smoking-history','method'=>'POST','class'=>'form-horizontal')) !!}


             <input type="hidden" name="_token" value="{{ csrf_token() }}">
             <input type="hidden" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="{{$patient->id}}" name="afya_user_id"  required>
              

            <div class="form-group smoker">
              <label class="col-sm-6 control-label">Are you a smoker?</label>

                  <div class="col-sm-6">
                      <label class="checkbox-inline "> <input type="radio" class="smoker" name="smoker" value="YES" > Yes</label>
                      <label class="checkbox-inline "> <input type="radio" class="smoker" name="smoker" value="NO" > No</label>
                  </div>
            </div> 
            
             <div class="form-group cigarretes">
              <label class="col-sm-6 control-label">How many cigarretes per day?</label>

                  <div class="col-sm-6">
                      <input type="text" name="cigarretes_per_day" class="form-control" >
                      
                  </div>
            </div>     
            
            <div class="form-group eversmoked">
              <label class="col-sm-6 control-label">Have you ever smoked?</label>

                  <div class="col-sm-6">
                      <label class="checkbox-inline "> <input type="radio" class="eversmoked" name="ever_smoked" value="YES"> Yes</label>
                      <label class="checkbox-inline "> <input type="radio" class="eversmoked" name="ever_smoked" value="NO"> No</label>
                  </div>
            </div> 
            
             <div class="form-group stopdate">
              <label class="col-sm-6 control-label">When did you stop?</label>

                  <div class="col-sm-6">
                      <input type="text" name="stop_date" class="form-control monthly" >
                      
                  </div>
            </div>  

            <div class="form-group period">
              <label class="col-sm-6 control-label">How long did you smoke/have you smoked(years)?</label>

                  <div class="col-sm-6">
                    <select name="period_smoked" class="form-control">
                      <option value="1">0-1</option>
                      @for($i=2;$i< 61;$i++)
                      <option value="{{$i}}">{{$i}}</option>
                      @endfor
                    </select>
                  </div>
            </div>    
            
            
          

    <button type="submit" class="btn btn-primary">Submit</button>

      {!! Form::close() !!}

      @else

      {!! Form::model($smoking, ['method' => 'PATCH','route' => ['smoking-history.update', $smoking->id],'class'=>'form-horizontal']) !!}

             <input type="hidden" name="_token" value="{{ csrf_token() }}">
             <input type="hidden" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="{{$patient->id}}" name="afya_user_id"  required>
              

            <div class="form-group smoker">
              <label class="col-sm-6 control-label">Are you a smoker?</label>

                  <div class="col-sm-6">
                      <label class="checkbox-inline"> <input type="radio" class="smoker"  name="smoker" value="YES" @if($smoking->smoker=='YES') checked @endif > Yes</label>
                      <label class="checkbox-inline"> <input type="radio" class="smoker"  name="smoker" value="NO" @if($smoking->smoker=='NO') checked @endif> No</label>
                  </div>
            </div> 
            
             <div class="form-group cigarretes">
              <label class="col-sm-6 control-label">How many cigarretes per day?</label>

                  <div class="col-sm-6">
                      <input type="text" name="cigarretes_per_day" value="{{$smoking->cigarretes_per_day}}" class="form-control" >
                      
                  </div>
            </div>     
            
            <div class="form-group eversmoked">
              <label class="col-sm-6 control-label">Have you ever smoked?</label>

                  <div class="col-sm-6">
                      <label class="checkbox-inline "> <input type="radio" class="eversmoked" name="ever_smoked" value="YES" @if($smoking->ever_smoked=='YES') checked @endif> Yes</label>
                      <label class="checkbox-inline "> <input type="radio" class="eversmoked" name="ever_smoked" value="NO" @if($smoking->ever_smoked=='NO') checked @endif> No</label>
                  </div>
            </div> 
            
             <div class="form-group stopdate">
              <label class="col-sm-6 control-label">When did you stop?</label>

                  <div class="col-sm-6">
                      <input type="text" name="stop_date" value="{{$smoking->stop_date}}" class="form-control monthly" >
                      
                  </div>
            </div>  

            <div class="form-group period">
              <label class="col-sm-6 control-label">How long did you smoke/have you smoked(years)?</label>

                  <div class="col-sm-6">
                    <select name="period_smoked" class="form-control">
                      <option value="{{$smoking->period_smoked}}" >{{$smoking->period_smoked}}</option>
                      <option value="1">0-1</option>
                      @for($i=2;$i< 61;$i++)
                      <option value="{{$i}}">{{$i}}</option>
                      @endfor
                    </select>
                  </div>
            </div>    
            
            
          

    <button type="submit" class="btn btn-primary">Update</button>

 {!! Form::close() !!}

      @endif

            </div>
          </div>
        </div>



    <div class="col-lg-6">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Alcohol/Drug History</h5>
                <div class="ibox-tools">
                    <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                    </a>
                     <a class="close-link">
                        <i class="fa fa-times"></i>
                    </a>
                </div>
            </div>
            <div class="ibox-content">
             @if(is_null($alcohol))
             
            {!! Form::open(array('url' => 'alcohol-history','method'=>'POST','class'=>'form-horizontal')) !!}

             <input type="hidden" name="_token" value="{{ csrf_token() }}">
             <input type="hidden" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="{{$patient->id}}" name="afya_user_id"  required>
              

            <div class="form-group drink">
              <label class="col-sm-6 control-label">Do you drink Alcohol?</label>

                  <div class="col-sm-6">
                      <label class="checkbox-inline "> <input type="radio" class="drink" name="drink" value="YES"> Yes</label>
                      <label class="checkbox-inline "> <input type="radio" class="drink" name="drink" value="NO"> No</label>
                  </div>
            </div> 
            
             <div class="form-group frequency">
              <label class="col-sm-6 control-label">How how frequent?</label>

                  <div class="col-sm-6">
                      <select name="drinking_frequency" class="form-control">
                      <option value="daily">daily</option>
                      <option value="every other day">every other day</option>
                      <option value="weekly">weekly</option>
                      <option value="Once a month">Once a month</option>
                      
                    </select>
                      
                  </div>
            </div>     
            
            <div class="form-group drugs">
              <label class="col-sm-6 control-label">Do you or have you ever used recreational drugs?</label>

                  <div class="col-sm-6">
                      <label class="checkbox-inline "> <input type="radio" class="drugs" name="used_recreational_drugs" value="YES"> Yes</label>
                      <label class="checkbox-inline "> <input type="radio" class="drugs" name="used_recreational_drugs" value="NO"> No</label>
                  </div>
            </div> 
            
             <div class="form-group drug_type">
              <label class="col-sm-6 control-label">If yes state type?</label>

                  <div class="col-sm-6">
                      <input type="text" name="drug_type" class="form-control drug_type" >
                      
                  </div>
            </div>  

          <div class="form-group">
              <label class="col-sm-6 control-label">Do you drink liquids with caffeine - coffee, tea?</label>

                  <div class="col-sm-6">
                      <label class="checkbox-inline "> <input type="radio" name="caffeine_liquids" value="YES"> Yes</label>
                      <label class="checkbox-inline "> <input type="radio" name="caffeine_liquids" value="NO"> No</label>
                  </div>
            </div>    
            
            
          <button type="submit" class="btn btn-primary">Submit</button>

      {!! Form::close() !!}

      @else

      {!! Form::model($alcohol, ['method' => 'PATCH','route' => ['alcohol-history.update', $alcohol->id],'class'=>'form-horizontal']) !!}

         <input type="hidden" name="_token" value="{{ csrf_token() }}">
             <input type="hidden" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="{{$patient->id}}" name="afya_user_id"  required>
              

            <div class="form-group drink">
              <label class="col-sm-6 control-label">Do you drink Alcohol?</label>

                  <div class="col-sm-6">
                      <label class="checkbox-inline "> <input type="radio" class="drink" name="drink" value="YES" @if($alcohol->drink=='YES') checked @endif > Yes</label>
                      <label class="checkbox-inline "> <input type="radio" class="drink" name="drink" value="NO" @if($alcohol->drink=='NO') checked @endif > No</label>
                  </div>
            </div> 
            
             <div class="form-group frequency">
              <label class="col-sm-6 control-label">How how frequent?</label>

                  <div class="col-sm-6">
                      <select name="drinking_frequency" class="form-control">
                      <option value="{{$alcohol->drinking_frequency}}">{{$alcohol->drinking_frequency}}</option>
                      <option value="daily">daily</option>
                      <option value="every other day">every other day</option>
                      <option value="weekly">weekly</option>
                      <option value="Once a month">Once a month</option>
                      
                    </select>
                      
                  </div>
            </div>     
            
            <div class="form-group drugs">
              <label class="col-sm-6 control-label">Do you or have you ever used recreational drugs?</label>

                  <div class="col-sm-6">
                      <label class="checkbox-inline "> <input type="radio" class="drugs" name="used_recreational_drugs" value="YES" @if($alcohol->used_recreational_drugs=='YES') checked @endif > Yes</label>
                      <label class="checkbox-inline "> <input type="radio" class="drugs" name="used_recreational_drugs" value="NO" @if($alcohol->used_recreational_drugs=='NO') checked @endif > No</label>
                  </div>
            </div> 
            
             <div class="form-group drug_type">
              <label class="col-sm-6 control-label">If yes state type?</label>

                  <div class="col-sm-6">
                      <input type="text" name="drug_type"  value="{{$alcohol->drug_type}}" class="form-control" >
                      
                  </div>
            </div>  

          <div class="form-group">
              <label class="col-sm-6 control-label">Do you drink liquids with caffeine - coffee, tea?</label>

                  <div class="col-sm-6">
                      <label class="checkbox-inline "> <input type="radio" name="caffeine_liquids" value="YES" @if($alcohol->caffeine_liquids=='YES') checked @endif > Yes</label>
                      <label class="checkbox-inline "> <input type="radio" name="caffeine_liquids" value="NO" @if($alcohol->caffeine_liquids=='NO') checked @endif > No</label>
                  </div>
            </div>    
            
            
          <button type="submit" class="btn btn-primary">Update</button>

      {!! Form::close() !!}

      @endif
                        </div>

      
            </div>
        </div>
      </div>





  <div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Self Reported Medical History</h5>
                <div class="ibox-tools">
                    <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                    </a>
                     <a class="close-link">
                        <i class="fa fa-times"></i>
                    </a>
                </div>
            </div>

            <div class="ibox-content">
              @if(is_null($medical))
             
            {!! Form::open(array('url' => 'medical-history','method'=>'POST','class'=>'form-horizontal')) !!}
                <div class="col-lg-6">
             <input type="hidden" name="_token" value="{{ csrf_token() }}">
             <input type="hidden" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="{{$patient->id}}" name="afya_user_id"  required>
               
            
            <div class="form-group">
              <label class="col-sm-6 control-label">Hypertension?</label>

                  <div class="col-sm-6">
                      <label class="checkbox-inline "> <input type="radio" name="hypertension" value="YES"> Yes</label>
                      <label class="checkbox-inline "> <input type="radio" name="hypertension" value="NO"> No</label>
                  </div>
            </div> 

            <div class="form-group">
              <label class="col-sm-6 control-label">Diabetes?</label>

                  <div class="col-sm-6">
                      <label class="checkbox-inline "> <input type="radio" name="diabetes" value="YES"> Yes</label>
                      <label class="checkbox-inline "> <input type="radio" name="diabetes" value="NO"> No</label>
                  </div>
            </div>                 
            
            <div class="form-group">
              <label class="col-sm-6 control-label">Heart Attack?</label>

                  <div class="col-sm-6">
                      <label class="checkbox-inline "> <input type="radio" name="heart_attack" value="YES"> Yes</label>
                      <label class="checkbox-inline "> <input type="radio" name="heart_attack" value="NO"> No</label>
                  </div>
            </div> 
            
          
           <div class="form-group">
              <label class="col-sm-6 control-label">Stroke?</label>

                  <div class="col-sm-6">
                      <label class="checkbox-inline "> <input type="radio" name="stroke" value="YES"> Yes</label>
                      <label class="checkbox-inline "> <input type="radio" name="stroke" value="NO"> No</label>
                  </div>
            </div> 

            <div class="form-group">
              <label class="col-sm-6 control-label">Liver Disease?</label>

                  <div class="col-sm-6">
                      <label class="checkbox-inline "> <input type="radio" name="liver_disease" value="YES"> Yes</label>
                      <label class="checkbox-inline "> <input type="radio" name="liver_disease" value="NO"> No</label>
                  </div>
            </div>                 
            
            <div class="form-group">
              <label class="col-sm-6 control-label">Lung Disease?</label>

                  <div class="col-sm-6">
                      <label class="checkbox-inline "> <input type="radio" name="lung_disease" value="YES"> Yes</label>
                      <label class="checkbox-inline "> <input type="radio" name="lung_disease" value="NO"> No</label>
                  </div>
            </div>
           
           <div class="form-group">
              <label class="col-sm-6 control-label">Bowel Disease?</label>

                  <div class="col-sm-6">
                      <label class="checkbox-inline "> <input type="radio" name="bowel_disease" value="YES"> Yes</label>
                      <label class="checkbox-inline "> <input type="radio" name="bowel_disease" value="NO"> No</label>
                  </div>
            </div> 
               
         </div>   
        <div class="col-lg-6"> 
 
                           
            
            <div class="form-group">
              <label class="col-sm-6 control-label">Eye Disease?</label>

                  <div class="col-sm-6">
                      <label class="checkbox-inline "> <input type="radio" name="eye_disease" value="YES"> Yes</label>
                      <label class="checkbox-inline "> <input type="radio" name="eye_disease" value="NO"> No</label>
                  </div>
            </div> 

            <div class="form-group">
              <label class="col-sm-6 control-label">Skin Problems?</label>

                  <div class="col-sm-6">
                      <label class="checkbox-inline "> <input type="radio" name="skin_problems" value="YES"> Yes</label>
                      <label class="checkbox-inline "> <input type="radio" name="skin_problemss" value="NO"> No</label>
                  </div>
            </div>                 
            
            <div class="form-group">
              <label class="col-sm-6 control-label">Pyschological problems?</label>

                  <div class="col-sm-6">
                      <label class="checkbox-inline "> <input type="radio" name="pyschological_problems" value="YES"> Yes</label>
                      <label class="checkbox-inline "> <input type="radio" name="pyschological_problems" value="NO"> No</label>
                  </div>
            </div> 
            <div class="form-group">
              <label class="col-sm-6 control-label">Arthritis/joint disease?</label>

                  <div class="col-sm-6">
                      <label class="checkbox-inline "> <input type="radio" name="arthritis" value="YES"> Yes</label>
                      <label class="checkbox-inline "> <input type="radio" name="arthritis" value="NO"> No</label>
                  </div>
            </div> 

            <div class="form-group">
              <label class="col-sm-6 control-label">Thyroid Disease?</label>

                  <div class="col-sm-6">
                      <label class="checkbox-inline "> <input type="radio" name="thyroid_disease" value="YES"> Yes</label>
                      <label class="checkbox-inline "> <input type="radio" name="thyroid_disease" value="NO"> No</label>
                  </div>
            </div>                 
            <div class="form-group">
              <label class="col-sm-6 control-label">Gyneocological Disease?</label>

                  <div class="col-sm-6">
                      <label class="checkbox-inline "> <input type="radio" name="gyneocological_disease" value="YES"> Yes</label>
                      <label class="checkbox-inline "> <input type="radio" name="gyneocological_disease" value="NO"> No</label>
                  </div>
            </div>                 
            
            

        </div>   
          
          
    <button type="submit" class="btn btn-primary">Submit</button>

      {!! Form::close() !!}

      @else

      {!! Form::model($medical, ['method' => 'PATCH','route' => ['medical-history.update', $medical->id],'class'=>'form-horizontal']) !!}

      <div class="col-lg-6">
             <input type="hidden" name="_token" value="{{ csrf_token() }}">
             <input type="hidden" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="{{$patient->id}}" name="afya_user_id"  required>
               
            
            <div class="form-group">
              <label class="col-sm-6 control-label">Hypertension?</label>

                  <div class="col-sm-6">
                      <label class="checkbox-inline "> <input type="radio" name="hypertension" value="YES" @if($medical->hypertension=='YES') checked @endif > Yes</label>
                      <label class="checkbox-inline "> <input type="radio" name="hypertension" value="NO" @if($medical->hypertension=='NO') checked @endif > No</label>
                  </div>
            </div> 

            <div class="form-group">
              <label class="col-sm-6 control-label">Diabetes?</label>

                  <div class="col-sm-6">
                      <label class="checkbox-inline "> <input type="radio" name="diabetes" value="YES" @if($medical->diabetes=='YES') checked @endif > Yes</label>
                      <label class="checkbox-inline "> <input type="radio" name="diabetes" value="NO" @if($medical->diabetes=='NO') checked @endif > No</label>
                  </div>
            </div>                 
            
            <div class="form-group">
              <label class="col-sm-6 control-label">Heart Attack?</label>

                  <div class="col-sm-6">
                      <label class="checkbox-inline "> <input type="radio" name="heart_attack" value="YES" @if($medical->heart_attack=='YES') checked @endif > Yes</label>
                      <label class="checkbox-inline "> <input type="radio" name="heart_attack" value="NO" @if($medical->heart_attack=='NO') checked @endif > No</label>
                  </div>
            </div> 
            
          
           <div class="form-group">
              <label class="col-sm-6 control-label">Stroke?</label>

                  <div class="col-sm-6">
                      <label class="checkbox-inline "> <input type="radio" name="stroke" value="YES" @if($medical->stroke=='YES') checked @endif > Yes</label>
                      <label class="checkbox-inline "> <input type="radio" name="stroke" value="NO" @if($medical->stroke=='NO') checked @endif > No</label>
                  </div>
            </div> 

            <div class="form-group">
              <label class="col-sm-6 control-label">Liver Disease?</label>

                  <div class="col-sm-6">
                      <label class="checkbox-inline "> <input type="radio" name="liver_disease" value="YES" @if($medical->liver_disease=='YES') checked @endif > Yes</label>
                      <label class="checkbox-inline "> <input type="radio" name="liver_disease" value="NO" @if($medical->liver_disease=='NO') checked @endif > No</label>
                  </div>
            </div>                 
            
            <div class="form-group">
              <label class="col-sm-6 control-label">Lung Disease?</label>

                  <div class="col-sm-6">
                      <label class="checkbox-inline "> <input type="radio" name="lung_disease" value="YES" @if($medical->lung_disease=='YES') checked @endif > Yes</label>
                      <label class="checkbox-inline "> <input type="radio" name="lung_disease" value="NO" @if($medical->lung_disease=='NO') checked @endif > No</label>
                  </div>
            </div>
           
           <div class="form-group">
              <label class="col-sm-6 control-label">Bowel Disease?</label>

                  <div class="col-sm-6">
                      <label class="checkbox-inline "> <input type="radio" name="bowel_disease" value="YES" @if($medical->bowel_disease=='YES') checked @endif > Yes</label>
                      <label class="checkbox-inline "> <input type="radio" name="bowel_disease" value="NO" @if($medical->bowel_disease=='NO') checked @endif > No</label>
                  </div>
            </div> 
               
         </div>   
        <div class="col-lg-6"> 
 
                           
            
            <div class="form-group">
              <label class="col-sm-6 control-label">Eye Disease?</label>

                  <div class="col-sm-6">
                      <label class="checkbox-inline "> <input type="radio" name="eye_disease" value="YES" @if($medical->eye_disease=='YES') checked @endif > Yes</label>
                      <label class="checkbox-inline "> <input type="radio" name="eye_disease" value="NO" @if($medical->eye_disease=='NO') checked @endif > No</label>
                  </div>
            </div> 

            <div class="form-group">
              <label class="col-sm-6 control-label">Skin Problems?</label>

                  <div class="col-sm-6">
                      <label class="checkbox-inline "> <input type="radio" name="skin_problems" value="YES" @if($medical->skin_problems=='YES') checked @endif > Yes</label>
                      <label class="checkbox-inline "> <input type="radio" name="skin_problems" value="NO" @if($medical->skin_problems=='NO') checked @endif > No</label>
                  </div>
            </div>                 
            
            <div class="form-group">
              <label class="col-sm-6 control-label">Pyschological problems?</label>

                  <div class="col-sm-6">
                      <label class="checkbox-inline "> <input type="radio" name="pyschological_problems" value="YES" @if($medical->pyschological_problems=='YES') checked @endif > Yes</label>
                      <label class="checkbox-inline "> <input type="radio" name="pyschological_problems" value="NO" @if($medical->pyschological_problems=='NO') checked @endif > No</label>
                  </div>
            </div> 
            <div class="form-group">
              <label class="col-sm-6 control-label">Arthritis/joint disease?</label>

                  <div class="col-sm-6">
                      <label class="checkbox-inline "> <input type="radio" name="arthritis_joint_disease" value="YES" @if($medical->arthritis_joint_disease=='YES') checked @endif > Yes</label>
                      <label class="checkbox-inline "> <input type="radio" name="arthritis_joint_disease" value="NO" @if($medical->arthritis_joint_disease=='NO') checked @endif > No</label>
                  </div>
            </div> 

            <div class="form-group">
              <label class="col-sm-6 control-label">Thyroid Disease?</label>

                  <div class="col-sm-6">
                      <label class="checkbox-inline "> <input type="radio" name="thyroid_disease" value="YES" @if($medical->thyroid_disease=='YES') checked @endif > Yes</label>
                      <label class="checkbox-inline "> <input type="radio" name="thyroid_disease" value="NO" @if($medical->thyroid_disease=='NO') checked @endif > No</label>
                  </div>
            </div>                 
            <div class="form-group">
              <label class="col-sm-6 control-label">Gyneocological Disease?</label>

                  <div class="col-sm-6">
                      <label class="checkbox-inline "> <input type="radio" name="gyneocological_disease" value="YES" @if($medical->gyneocological_disease=='YES') checked @endif > Yes</label>
                      <label class="checkbox-inline "> <input type="radio" name="gyneocological_disease" value="NO" @if($medical->gyneocological_disease=='NO') checked @endif > No</label>
                  </div>
            </div>                 
            
            

        </div>   
          
          
    <button type="submit" class="btn btn-primary">Update</button>

      @endif
            </div>
          </div>
        </div>
  
      </div>







  <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Self Reported Surgical Procedures</h5>
                        <div class="ibox-tools">
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
<th>Name of surgery</th>
<th>Date </th>

</tr>
</thead>

<tbody>
@foreach($surgeries as $proc)
<tr>
<td>{{$proc->id}}</td>
<td>{{$proc->name_of_surgery}}</td>
<td>{{$proc->surgery_date}}</td>

</tr>
@endforeach
</tbody>
</table>
<a href="{{ route('surgical-history.show',$patient->id) }}" class="btn btn-primary btn-sm">Add Procedure</a>




                    </div>
                </div>
            </div>
        </div>
  </div>

  <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Self Reported medication</h5>
                        <div class="ibox-tools">
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
<th>Drug name</th>
<th>Date</th>
</tr>
</thead>

<tbody>
  @foreach($meds as $med)
<tr>
<td>{{$med->id}}</td>
<td>{{$med->drugname}}</td>
<td>{{$med->med_date}}</td>
</tr>
 @endforeach
</tbody>
</table>
<a href="{{ route('med-history.show', $patient->id) }}" class="btn btn-primary btn-sm">Add Medication</a>




                    </div>
                </div>
            </div>
        </div>
  </div>





  <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Vaccination Details</h5>
                        <div class="ibox-tools">
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
                                 <th>Antigen</th>
                                <th>Vaccinations Name</th>
                                <!-- <th>Location(Facility)</th> -->
                                 <th>Date </th>

                                                                </tr>
                                                              </thead>

                                                              <tbody>
                                                           <?php $i =1; ?>
                                                             @foreach($vaccines as $vaccine)
                                                                  <tr>
                         <td>{{$i}}</td>
                         <td>{{$vaccine->antigen}}</td>
                         <td>{{$vaccine->vaccine_name}}</td>
                         <!-- <td>St Jude's Huruma Community Health Services</td> -->
                          <td>{{ date('d -m- Y', strtotime($vaccine->yesdate)) }}</td>

                         </tr>
                                                                  <?php $i++; ?>

                                                               @endforeach


                                                               </tbody>
                                                             </table>
                                                               <a href="{{ route('vaccinescreate', $patient->id) }}" class="btn btn-primary btn-sm">Update Details</a>




                    </div>
                </div>
            </div>
        </div>
  </div>

      <div class="row">
         <div class="col-lg-12">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                              <h5>Patient Allergy</h5>
                                <div class="ibox-tools">
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
  <th>Allery Type</th>
  <th>Allery Name</th>
  </tr>
      </thead>

      <?php $i =1;  $allergies=DB::table('afya_users_allergy')
    ->Join('allergies_type','allergies_type.id','=','afya_users_allergy.allergies_type_id')
    ->Join('allergies','allergies.id','=','allergies_type.allergies_id')
    ->Select('allergies_type.name','allergies.name as Allergy')
    ->Where('afya_users_allergy.afya_user_id','=',$patient->id)
    ->get(); ?>
     <tbody>
       @foreach($allergies as $allergy)

      <tr>
      <td>{{$i}}</td>
       <td>{{$allergy->Allergy}}</td>
      <td>{{$allergy->name}}</td>
      </tr>

       <?php $i++; ?>

      @endforeach

        </tbody>
      </table>

      <a href="{{ url('add_allergy', $patient->id) }}" class="btn btn-primary btn-sm">Update Details</a>


   </div>

</div>



</div>
</div>

</div>
<div class="row">
         <div class="col-lg-12">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                              <h5>Patient chronic diseases</h5>
                                <div class="ibox-tools">
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
  <th>Disease Name</th>
  <th>Date</th>

  </tr>
      </thead>

      <?php $i =1;
      $diseases=DB::table('patient_diagnosis')
      ->join('appointments','patient_diagnosis.appointment_id','=','appointments.id')
      ->join('diseases','diseases.id','=','patient_diagnosis.disease_id')
      ->select('diseases.name as name','patient_diagnosis.*')
      ->where('appointments.afya_user_id',$patient->id)
      ->get(); ?>
     <tbody>
       @foreach($diseases as $ds)

      <tr>
      <td>{{$i}}</td>
       <td>{{$ds->name}}</td>
      <td>{{$ds->created_at}}</td>
      </tr>

       <?php $i++; ?>

      @endforeach

        </tbody>
      </table>





</div>

      <a href="{{ url('add_chronic', $patient->id) }}" class="btn btn-primary btn-sm">Update Details</a>




</div>



</div>
</div>

</div>

      <div class="row">
         <div class="col-lg-12">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                              <h5>Patient History</h5>
                                <div class="ibox-tools">
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
            <th>Date</th>
            <th>Time</th>
           <th>Weight</th>
           <th>Height</th>
           <th>BMI</th>
           <th>Temperature</th>
           <th>Systolic_bp</th>
           <th>Diastolic_bp</th>
           <th>Chief Compliant</th>
            <th>Observation</th>
           <th>Symptoms</th>




      </tr>
      </thead>

      <tbody>
      <?php $i =1; ?>
      @foreach($details as $detail)
       <tr>
           <td>{{$i}}</td>
            <td>{{ date('d -m- Y', strtotime($detail->updated_at)) }}</td>
            <td>{{ date('H:i:s', strtotime($detail->updated_at)) }}</td>
           <td>{{$detail->current_weight}}</td>
           <td>{{$detail->current_height}}</td>
            <td><?php $height=$detail->current_height; $weight=$detail->current_weight;
               $bmi =$weight/($height*$height);
               echo number_format($bmi, 2);
            ?></td>
           <td>{{$detail->temperature}}</td>
          <td>{{$detail->systolic_bp}}</td>
         <td>{{$detail->diastolic_bp}}</td>
         <td>{{$detail->chief_compliant}}</td>
         <td>{{$detail->observation}}</td>
         <td>{{$detail->symptoms}}</td>

       </tr>
       <?php $i++; ?>

      @endforeach


        </tbody>
      </table>
      <a href="{{ route('details', $patient->id) }}" class="btn btn-primary btn-sm">Add Details</a>

   </div>

</div>



</div>
</div>

</div>
</div>
@endsection
