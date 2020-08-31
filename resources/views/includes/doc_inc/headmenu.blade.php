<div class="row">
  <div class="col-lg-12">
      <div class="tabs-container">
          <ul class="nav nav-tabs">
            <li class="{{ isActiveRoute('showPatient') }}"><a  href="{{route('showPatient',$app_id)}}">Patient Details</a></li>
            <li class="{{ isActiveRoute('patsamury') }}"><a  href="{{route('patsamury',$app_id)}}">Patient Summary</a></li>
           <li class="{{ isActiveRoute('examination') }}"><a  href="{{route('examination',$app_id)}}">Examination</a></li>
            <li class="{{ isActiveRoute('impression') }}"><a  href="{{route('impression',$app_id)}}">Impression</a></li>
            <li class="{{ isActiveRoute('alltestes') }} {{ isActiveRoute('diagnoses') }} {{ isActiveRoute('medicines') }} {{ isActiveRoute('procedure') }}">
              <a  href="{{route('alltestes',$app_id)}} ">Investigation</a></li>
            @if ($condition =='Admitted')
              <li class="{{ isActiveRoute('discharge') }}"><a  href="{{route('discharge',$app_id)}}">Discharge</a></li>
             @else
              <li class="{{ isActiveRoute('admit') }}"><a  href="{{route('admit',$app_id)}}">Admit</a></li>@endif
              <li class="{{ isActiveRoute('transfering') }}"><a  href="{{route('transfering',$app_id)}}">Referral</a></li>
              <li class="{{ isActiveRoute('patienthistory') }}"><a href="{{route('patienthistory',$app_id)}}">Medical Report</a></li>
             <li class="{{ isActiveRoute('endvisit') }}"><a  href="{{route('endvisit',$app_id)}}">Next Visit</a></li>


          </ul>
 </div>
</div>
</div>
<div class="col-md-6 col-md-offset-3">
<div class="tab-content">
  <div id="tab-2" class="tab-pane {{ isActiveRoute('alltestes') }} {{ isActiveRoute('diagnoses') }} {{ isActiveRoute('medicines') }} {{ isActiveRoute('procedure') }}">
    <div class="panel-body">
      <ul class="nav nav-tabs">
        <li class="{{ isActiveRoute('alltestes') }}"><a  href="{{route('alltestes',$app_id)}}">Tests</a></li>
        <li class="{{ isActiveRoute('diagnoses') }}"><a  href="{{route('diagnoses',$app_id)}}">Diagnosis</a></li>
        <li class="{{ isActiveRoute('medicines') }}"><a href="{{route('medicines',$app_id)}}">Prescriptions</a></li>
        <li class="{{ isActiveRoute('procedure') }}"><a  href="{{route('procedure',$app_id)}}">Procedures</a></li>
      </ul>
    </div>
  </div>
</div>
</div>
