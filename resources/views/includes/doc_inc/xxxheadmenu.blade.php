<div class="row border-bottom">
<nav class="navbar" role="navigation">
  <div class="navbar-collapse " id="navbar">
        <ul class="nav navbar-nav">
          <li class="active"><a role="button" href="{{route('showPatient',$app_id)}}">Patient Details</a></li>
         <li><a role="button" href="{{route('patienthistory',$app_id)}}">Medical Report</a></li>
         <li class=""><a role="button" href="{{route('examination',$app_id)}}">Examination</a></li>

          <li><a role="button" href="{{route('alltestes',$app_id)}}">Tests</a></li>
           <li><a role="button" href="{{route('diagnoses',$app_id)}}">Diagnosis</a></li>
          <li><a role="button" href="{{route('medicines',$app_id)}}">Prescriptions</a></li>
          <li><a role="button" href="{{route('procedure',$app_id)}}">Procedures</a></li>

          @if ($condition =='Admitted')
            <li><a role="button" href="{{route('discharge',$app_id)}}">Discharge</a></li>
           @else
            <li><a role="button" href="{{route('admit',$app_id)}}">Admit</a></li>@endif
            <li><a role="button" href="{{route('transfering',$app_id)}}">Referral</a></li>
           <li><a role="button" href="{{route('endvisit',$app_id)}}">End Visit</a></li>
         </ul>
     </div>
</nav>
</div>
