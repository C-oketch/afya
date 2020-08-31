@extends('layouts.pharmacy')
@section('title', 'Pharmacy')
@section('content')

        <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-11">
            <div class="ibox float-e-margins">

                <div class="ibox-title">
                  <h5>Prescription Details</h5>
                </div>

                <div class="ibox-content">

                <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover dataTables-example" >
                <thead>
                      <tr>
                          <th>No</th>
                          <th>Patient Name</th>
                          <th>Age</th>
                          <th>Gender</th>
                          <th>Prescribing Doctor</th>
                          <th>Date of Prescription</th>
                    </tr>
                  </thead>

                  <tbody>
                    <?php
                    if(isset($results))
                    {
                     $i =1;

                    foreach($results as $result)
                    {
                      $name = $result->firstname.'  '.$result->secondName;

                      $age = $result->dob;
                      $interval = date_diff(date_create(), date_create($age));
                      $age = $interval->format(" %Y Year, %M Months, %d Days Old");
                      $gender = $result->gender;

                      $person = $result->persontreated;
                      $af_id = $result->af_id;


                    //  $allergies = $result->allergies;
                      $daktari = $result->name;

                      $presc_date = $result->presc_date;
                      $my_date = strtotime($presc_date);
                      $presc_date = date("Y-m-d",$my_date);

                  ?>
                      <tr>
                          <td><a href="{{route('pharmacy.show',$result->presc_id)}}">{{$i}}</a></td>
                          <?php if($person === 'Self')
                          {
                             ?>
                          <td><a href="{{route('pharmacy.show',$result->presc_id)}}">{{$name}}</a></td>
                          <td><a href="{{route('pharmacy.show',$result->presc_id)}}">{{$age}}</td>
                          <td><a href="{{route('pharmacy.show',$result->presc_id)}}">{{$gender}}</a></td>

                          <td><a href="{{route('pharmacy.show',$result->presc_id)}}">{{$daktari}} </td>
                          <td><a href="{{route('pharmacy.show',$result->presc_id)}}">{{$presc_date}}</td>

                          <?php
                        }
                        else
                        {
                          $depends = DB::table('dependant')
                                    ->select('dependant.firstName AS fname', 'dependant.secondName AS sname',
                                    'dependant.gender AS d_gender', 'dependant.dob AS d_dob')
                                    ->where('afya_user_id', '=', $af_id)
                                    ->first();

                          $name1 = $depends->fname.' '.$depends->sname;
                          $gg = $depends->d_gender;
                          $dob = $depends->d_dob;
                          $interval = date_diff(date_create(), date_create($dob));
                          $age1 = $interval->format(" %Y Year, %M Months, %d Days Old");
                           ?>
                           <td><a href="{{route('pharmacy.show',$result->presc_id)}}">{{$name1}}</a></td>
                           <td><a href="{{route('pharmacy.show',$result->presc_id)}}">{{$age1}}</td>
                           <td><a href="{{route('pharmacy.show',$result->presc_id)}}">{{$gg}}</a></td>
                           <td><a href="{{route('pharmacy.show',$result->presc_id)}}">{{$daktari}} </td>
                           <td><a href="{{route('pharmacy.show',$result->presc_id)}}">{{$presc_date}}</td>

                          <?php
                        }
                        $i++;
                    }

                        } //end if isset results

                        if(isset($alternatives))
                        {
                          $i = $i;

                         foreach($alternatives as $alternative)
                         {
                           $name = $alternative->firstname.'  '.$alternative->secondName;
                           $gender = $alternative->gender;

                       ?>
                           <tr>
                               <td><a href="{{route('pharmacy.show_alternative',$alternative->id)}}">{{$i}}</a></td>

                               <td><a href="{{route('pharmacy.show_alternative',$alternative->id)}}">{{$name}}</a></td>
                               <td></td>
                               <td><a href="{{route('pharmacy.show_alternative',$alternative->id)}}">{{$gender}}</a></td>
                               <td></td>
                               <td></td>

                               <?php
                           }

                           ?>

                      </tr>
                      <?php $i++;
                    } //end isset alternatives

                      // if(isset($old_alternatives))
                      // {
                      //   $i =$i;
                      //
                      //  foreach($old_alternatives as $old_alternative)
                      //  {
                      //    $name = $old_alternative->firstname.'  '.$old_alternative->secondName;
                      //    $gender = $old_alternative->gender;
                      //
                      //    $age = $old_alternative->dob;
                      //    $interval = date_diff(date_create(), date_create($age));
                      //    $age = $interval->format(" %Y Year, %M Months, %d Days Old");
                      //

                     ?>
                         <!-- <tr>
                             <td><a href="{{-- route('pharmacy.show_alternative',$old_alternative->id) --}}">{{-- $i --}}</a></td>

                             <td><a href="{{-- route('pharmacy.show_alternative',$old_alternative->id) --}}">{{-- $name --}}</a></td>
                             <td><a href="{{-- route('pharmacy.show_alternative',$old_alternative->id) --}}">{{-- $age --}}</a></td>
                             <td><a href="{{-- route('pharmacy.show_alternative',$old_alternative->id) --}}">{{-- $gender --}}</a></td>
                             <td></td>
                             <td></td> -->

                             <?php
                         // }
                         // $i++;
                         ?>

                    <!-- </tr> -->
                    <?php
                    //}
                       ?>
                   </tbody>

                 </table>
              </div>

                           </div>
                       </div>
                   </div>
                   </div>

               </div>

@endsection
