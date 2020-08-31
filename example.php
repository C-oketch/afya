
    <div class="table-responsive">
    <table class="table table-striped table-bordered table-hover dataTables-example" >
    <thead>
    <tr>
        <th>No</th>
        <th>Name</th>
        <th>Age</th>
        <th>Gender</th>
    </tr>
        </thead>
        <tbody>
          <?php   $i=1;   ?>
          @foreach($patientsToday as $todayp)
          <tr>
          <td>{{$i}}</td>
            <td>{{$todayp->firstname}} {{$todayp->secondName}}</td>
              <td>
                <?php
                $dob=$todayp->dob;
                $interval = date_diff(date_create(), date_create($dob));
                $age= $interval->format(" %Y Year, %M Months, %d Days Old");
                ?>
                {{$age}}
                </td>
              <td>{{$todayp->gender}}</td>
          </tr>
          <?php $i++; ?>
         @endforeach
         </tbody>
       </table>
    </div>
