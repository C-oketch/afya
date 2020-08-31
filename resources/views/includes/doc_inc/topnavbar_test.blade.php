<div class="row wrapper border-bottom white-bg page-heading">
 <div class="row">
     <div class="col-md-12">

     <div class="col-md-6">
       <address>
         <br />
       <strong>Patient:</strong><br>
       Name: {{$name}}<br>
       Gender: {{$gender}}<br>
       Age: {{$age}}
      </address>

     </div>
     <div class="col-md-5 text-right">
       <?php
       $datetime = explode(" ",$tsts1->created_at);
       $date1 = $datetime[0];
       ?>
       <address>
         <br />
         <strong>Requested By:</strong><br>
         Doctor :{{$tsts1->docname}} <br>
         {{$Sub_Speciality}} <br>
         LAB :  {{$tsts1->FacilityName}} <br>
         Date : {{$date1}} <br>


       </address>
     </div>
     <div class="col-lg-1">
       <br>
<a  href="{{route('endvisit',$app_id)}}" class="btn btn-primary btn-lg dim "><i class="fa fa-close"></i></a>
<small>END VISIT</small>
     </div>
   </div>
</div>
</div>
