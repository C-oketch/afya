@extends('layouts.manufacturer')
@section('title', 'Manufacturer')
@section('content')
<div class="content-page  equal-height">
          <div class="content">
              <div class="container">
              <br>
<div class="row">
<?php
$id=Auth::id();
$manufacturer=DB::table('manufacturers')->where('user_id', Auth::id())->first();
$Mname = $manufacturer->name;
$Mid = $manufacturer->id;

$manufacturerid=DB::table('compe_manufacturer')->where('manu_id',$Mid )->first(); ?>

 @if(is_null($manufacturerid))
<a data-toggle="modal" id="button1" class="btn btn-primary" href="#modal-company">Competition Companies</a>
@else
@endif
<?php $drusg = DB::table('compe_drugs')
                     ->select(DB::raw('count(*) as drugs_count, manu_id'))
                     ->where('manu_id', '=',$Mid)
                     ->groupBy('manu_id')
                     ->first(); ?>
  @if($drusg->drugs_count < 5)
<a data-toggle="modal" id="button2" class="btn btn-primary" href="#modal-drugs">Competition Drugs</a>
@else
@endif
  <!-- Company Drug Competitions -->
  <div class="row" id="company">
  <div class="col-md-6">
  <div class="ibox float-e-margins">
  <div class="ibox-title">
  <h5>Company Competition <small></small></h5>
  <div class="ibox-tools">
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
  <div class="row">
  <div class="col-lg-6">

          <form class="form-horizontal" role="form" method="POST" action="/addcompany" enctype="multipart/form-data" novalidate>
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <div class="form-group">
             <label>Your Company:</label>
                  <select class="drugs-single" name="manuco" multiple="multiple" style="width: 100%">
                    <?php $manuco=DB::table('druglists')->select('id','Manufacturer')->groupBy('Manufacturer')->get(); ?>

                      <option value=''>Please Choose one</option>
                      @foreach($manuco as $comp)
                           <option value='{{$comp->id}}'>{{$comp->Manufacturer}}</option>
                    @endforeach
                    </select>
              </div>
  <div class="hr-line-dashed"></div>
          <div class="form-group">
             <label>Company NO 1:</label>
                  <select class="drugs-single" name="company1" multiple="multiple" style="width: 100%">
                    <?php $manuco=DB::table('druglists')->select('id','Manufacturer')->groupBy('Manufacturer')->get(); ?>

                      <option value=''>Please Choose one</option>
                      @foreach($manuco as $comp)
                           <option value='{{$comp->id}}'>{{$comp->Manufacturer}}</option>
                    @endforeach
                    </select>
              </div>
              <div class="form-group">
                 <label>Company NO 2:</label>
                      <select class="drugs-single" name="company2" multiple="multiple"  style="width: 100%">
                        <option value=''>Please Choose one</option>
                        @foreach($manuco as $comp)
                             <option value='{{$comp->id}}'>{{$comp->Manufacturer}}</option>
                      @endforeach
                        </select>
                  </div>
                  <div class="form-group">
                     <label>Company NO 3:</label>
                          <select class="drugs-single" name="company3" multiple="multiple" style="width: 100%">
                            <option value=''>Please Choose one</option>
                            @foreach($manuco as $comp)
                                 <option value='{{$comp->id}}'>{{$comp->Manufacturer}}</option>
                          @endforeach
                            </select>
                      </div>
                      <div class="form-group">
                         <label>Company NO 4:</label>
                              <select class="drugs-single" name="company4" multiple="multiple"  style="width: 100%">
                                <option value=''>Please Choose one</option>
                                @foreach($manuco as $comp)
                                     <option value='{{$comp->id}}'>{{$comp->Manufacturer}}</option>
                              @endforeach
                                </select>
                          </div>
                          <div class="form-group">
                             <label>Company NO 5:</label>
                                  <select class="drugs-single" name="company5" multiple="multiple" style="width: 100%">
                                    <option value=''>Please Choose one</option>
                                    @foreach($manuco as $comp)
                                         <option value='{{$comp->id}}'>{{$comp->Manufacturer}}</option>
                                  @endforeach
                                    </select>
                              </div>
                              <div class="text-center">
                              {{ Form::hidden('manu_id',$Mid, array('class' => 'form-control')) }}

                              <button class="btn btn-lg btn-primary  m-t-n-xs" type="submit"><strong>Submit</strong></button>
                              </form>
                              </div>


    </div>
</div>
  </div>

  </div>
  </div>
  </div>
  </div>

  <!-- DrugsCompetitions -->
                            <div class="row" id="drugs">
              <div class="col-lg-12">
                  <div class="ibox float-e-margins">
                      <div class="ibox-title">
                          <h5>Drugs Competition <small></small></h5>
                          <div class="ibox-tools">
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
                          <div class="row">
                              <div class="col-sm-6 b-r"><h3 class="m-t-none m-b">{{$manufacturer->name}} Drugs</h3>

                                    <form class="form-horizontal" role="form" method="POST" action="/adddrugs" enctype="multipart/form-data" novalidate>
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <div class="form-group col-sm-8">
                                       <label>Drug Name:</label>
                                            <select class="drugs-single" name="base_drug" multiple="multiple" style="width: 100%">
                                              <?php $biotests=DB::table('druglists')->where('Manufacturer', 'like',$Mname.'%')->distinct()->get(['id','drugname']); ?>
                                                <option value=''>Please Choose one</option>
                                                @foreach($biotests as $biotest)
                                                     <option value='{{$biotest->id}}'>{{$biotest->drugname}}</option>
                                              @endforeach
                                              </select>
                                        </div>







                              </div>
                              <div class="col-sm-6"><h4>Competition Drug</h4>
                                <div class="form-group">
                                <label for="presc" class="col-md-6">Competition Drug No 1:</label>
                                <select id="presc" name="compe_drug_1" multiple="multiple" class="form-control drugs1" style="width: 100%">
                              </select>
                            </div>
                            <div class="form-group">
                            <label for="presc" class="col-md-6">Competition Drug No 2:</label>
                            <select id="presc" name="compe_drug_2" multiple="multiple" class="form-control drugs1" style="width: 100%"></select>
                            </div>
                            <div class="form-group">
                           <label for="presc" class="col-md-6">Competition Drug No 3:</label>
                           <select id="presc" name="compe_drug_3" multiple="multiple" class="form-control drugs1" style="width: 100%"></select>
                          </div>
                          <div class="form-group">
                         <label for="presc" class="col-md-6">Competition Drug No 4:</label>
                         <select id="presc" name="compe_drug_4" multiple="multiple" class="form-control drugs1" style="width: 100%"></select>
                         </div>
                        <div class="form-group">
                      <label for="presc" class="col-md-6">Competition Drug No 5:</label>
                      <select id="presc" name="compe_drug_5" multiple="multiple" class="form-control drugs1" style="width: 100%"></select>
                       </div>
                        </div>
                           </div>
                          <div class="row text-center">
                            {{ Form::hidden('manu_id',$Mid, array('class' => 'form-control')) }}
                          <button class="btn btn-lg btn-primary  m-t-n-xs" type="submit"><strong>Submit</strong></button>
                           </form>
                           </div>
                      </div>
                  </div>
              </div>
              </div>
              <div class="row" id="company">
              <div class="col-md-12">
              <div class="ibox float-e-margins">
              <div class="ibox-title">
              <h5> Competition <small></small></h5>
              <div class="ibox-tools">
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
              <div class="row">
            <div class="col-sm-4"><h3 class="m-t-none m-b">Competition Companies</h3>

               <?php $Companiez=DB::table('compe_manufacturer')
               ->select('compe_manufacturer.*')
                ->where('manu_id', '=',$Mid)
                ->get(); ?>

               @foreach($Companiez as $compz)


            <div class="form-group">
            <?php $Companiez1=DB::table('druglists')  ->where('id', '=',$compz->competition_1)->distinct()->first(['Manufacturer']); ?>
            <input type="text" value="{{$Companiez1->Manufacturer}}" class="form-control">
            </div>
            <div class="form-group">
          <?php $Companiez2=DB::table('druglists')  ->where('id', '=',$compz->competition_2)->distinct()->first(['Manufacturer']); ?>
            <input type="text" value="{{$Companiez2->Manufacturer}}" class="form-control">
            </div>
            <div class="form-group">
      <?php $Companiez3=DB::table('druglists')  ->where('id', '=',$compz->competition_3)->distinct()->first(['Manufacturer']); ?>
            <input type="text" value="{{$Companiez3->Manufacturer}}" class="form-control">
            </div>

            <div class="form-group">
        <?php $Companiez4=DB::table('druglists')  ->where('id', '=',$compz->competition_4)->distinct()->first(['Manufacturer']); ?>
            <input type="text" value="{{$Companiez4->Manufacturer}}" class="form-control">
            </div>

        @if($compz->competition_5)
            <div class="form-group">
      <?php $Companiez5=DB::table('druglists')  ->where('id', '=',$compz->competition_5)->distinct()->first(['Manufacturer']); ?>
            <input type="text" value="{{$Companiez5->Manufacturer}}" class="form-control">
            </div>
            @endif
                @endforeach
             </div>


            <?php $Companiesd=DB::table('compe_drugs')
            ->select('compe_drugs.*')
             ->where('manu_id', '=',$Mid)
             ->get(); ?>

            @foreach($Companiesd as $cosd)
<div class="col-sm-4"><h3 class="m-t-none m-b">Company Drug</h3>
<form role="form">
<div class="form-group">
  <?php $companydrugs=DB::table('druglists')->where('id', '=',$cosd->company)->distinct()->first(['drugname']); ?>
<input type="text" value="{{$companydrugs->drugname}}" class="form-control">
</div>

<button class="btn btn-white text-center" type="submit">Vs</button>
<h3 class="m-t-none m-b">Competition Drugs</h3>
<div class="form-group">
  <?php $compe1=DB::table('druglists')->where('id', '=',$cosd->competition_1)->distinct()->first(['drugname']); ?>
<input type="text" value="{{$compe1->drugname}}" class="form-control">
</div>
<div class="form-group">
  <?php $compe2=DB::table('druglists')->where('id', '=',$cosd->competition_2)->distinct()->first(['drugname']); ?>
<input type="text" value="{{$compe2->drugname}}" class="form-control">
</div>
<div class="form-group">
  <?php $compe3=DB::table('druglists')->where('id', '=',$cosd->competition_3)->distinct()->first(['drugname']); ?>
<input type="text" value="{{$compe3->drugname}}" class="form-control">
</div>
<div class="form-group">
  <?php $compe4=DB::table('druglists')->where('id', '=',$cosd->competition_4)->distinct()->first(['drugname']); ?>
<input type="text" value="{{$compe4->drugname}}" class="form-control">
</div>
<div class="form-group">
  <?php $compe5=DB::table('druglists')->where('id', '=',$cosd->competition_5)->distinct()->first(['drugname']); ?>
<input type="text" value="{{$compe5->drugname}}" class="form-control">
</div>

<br />
</form>
  </div>
  @endforeach
  </div>
  </div>

  </div>
  </div>







</div>
<br>



             @include('includes.default.footer')
                   </div><!--container-->
                </div><!--content -->
            </div><!--content page-->
@endsection
