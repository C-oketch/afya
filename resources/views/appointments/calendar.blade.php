<?php use App\Http\controllers\Controller; ?>
<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="_token" content="{!! csrf_token() !!}" />


    <title>Afyapepe- Calendar </title>

    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('font-awesome/css/font-awesome.css') }}" rel="stylesheet">

    <link href="{{ asset('css/plugins/iCheck/custom.css') }}" rel="stylesheet">

    <link href="{{ asset('css/plugins/fullcalendar/fullcalendar.css') }}" rel="stylesheet">
    <link href="{{ asset('css/plugins/fullcalendar/fullcalendar.print.css') }}" rel='stylesheet' media='print'>


    <link href="{{ asset('css/plugins/datapicker/datepicker3.css') }}" rel="stylesheet">

    <link href="{{ asset('css/plugins/clockpicker/clockpicker.css') }}" rel="stylesheet">


    <link href="{{ asset('css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    <style>

      .hidden-btn {
         visibility: hidden;
      }

      .clockpicker-popover {
        z-index: 999999 !important;
        }
      </style>

</head>

<body>

<div id="wrapper">
@if(Auth::user()->role=='Registrar')
  @include('includes.registrar.leftmenuprivate')

@elseif(Auth::user()->role=='Doctor')
 @include('includes.doc_inc.leftmenu')

 @elseif(Auth::user()->role=='Private')
  @include('includes.doc_inc.leftmenu')
@endif

<div id="page-wrapper" class="gray-bg">
<div class="row border-bottom">

</div>

<div class="row wrapper border-bottom white-bg page-heading">
  <div class="col-md-6">
    <address>
      <br />
      <strong>FACILITY :</strong><br>
      <strong> Name :</strong>{{$facility->FacilityName}}<br>
      <strong> Type :</strong> {{$facility->Type}}<br>
    </address>
  </div>
  <div class="col-md-6 text-right">
    <address>
      <br /><br />
      <strong>DATE :</strong><br>
      {{date("l jS \of F Y ")}}
    </address>

  </div>
</div>
<?php


 ?>
<div class="wrapper wrapper-content">
    <div class="row animated fadeInDown">
        <div class="col-lg-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Make Appointment</h5>
                    <div class="ibox-tools">

                    </div>
                </div>
                <div class="ibox-content">

{!! Form::open(array('route' => 'calendar.store','method'=>'POST')) !!}
<div class="row">

  <div class="col-xs-12 col-sm-12 col-md-12">
    <div class="form-group">
    <strong>First Name:</strong>
    {!! Form::text('firstname', null, array('placeholder' => '','class' => 'form-control')) !!}
    </div>
  </div>

  <div class="col-xs-12 col-sm-12 col-md-12">
    <div class="form-group">
    <strong>Second name:</strong>
    {!! Form::text('secondName', null, array('placeholder' => '','class' => 'form-control')) !!}
    </div>
  </div>


    {!! Form::hidden('afya_user_id', null, array()) !!}

  <div class="col-xs-12 col-sm-12 col-md-12">
    <div class="form-group">
      <strong>Gender:</strong>
      <select class="form-control m-b" name="gender">
        <option value="">Please select one</option>
        <option value="Female">Female</option>
        <option value="Male">Male</option>
    </select>
  </div>
  </div>

  <div class="col-xs-12 col-sm-12 col-md-12">
    <div class="form-group">
    <strong>Phone Number:</strong>
    {!! Form::text('msisdn', null, array('placeholder' => 'eg 254000000000','class' => 'form-control')) !!}
    </div>
  </div>


  <!-- <div class="col-xs-12 col-sm-12 col-md-12">
    <div class="form-group">
    <strong>Email address:</strong>
    {!! Form::email('email', null, array('placeholder' => 'Enter the afya user email address','class' => 'form-control')) !!}
    </div>
  </div> -->


  <div class="col-xs-12 col-sm-12 col-md-12">
    <div class="form-group">
    <strong>File Number:</strong>
    {!! Form::text('filenumber', null, array('placeholder' => 'filenumber','class' => 'form-control')) !!}
    </div>
  </div>


  <div class="col-xs-12 col-sm-12 col-md-12">
  <div class="form-group">
  <strong>Appointment Date:</strong>
  {!! Form::text('appointment_date',null, array('class' => 'form-control daily')) !!}
</div>
</div>
<div class="col-xs-12 col-sm-12 col-md-12">
<div class="form-group">
<strong>Appointment Time:</strong>
  <div class="input-group clockpicker" data-autoclose="true">
                    <input type="text" name="appointment_time" class="form-control" value="appointment_time" >
                    <span class="input-group-addon">
                        <span class="fa fa-clock-o"></span>
                    </span>
                </div>
</div>


</div>
 <div class="col-xs-12 col-sm-12 col-md-12">
    <div class="form-group">
    <strong>Doctor:</strong>
    <select  class="form-control" name="doc_id">
      @foreach($doctors as $doc)
      <option value="{{$doc->id}}">{{$doc->name}}</option>
      @endforeach
    </select>
    </div>
  </div>



<div class="col-xs-12 col-sm-12 col-md-12 text-center">
<button type="submit" class="btn btn-primary">Submit</button>
</div>
</div>
  {!! Form::close() !!}




                </div>
            </div>

        </div>
        <div class="col-lg-9">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Appointments </h5>
                    <div class="ibox-tools">

                    </div>
                </div>
                <div class="ibox-content">
                    <div id="calendar"></div>
                </div>
            </div>
        </div>
    </div>
</div>
 @include('includes.default.footer')


 <?php

$events="";
    foreach($appointments as $appointment)
     {


    $afya_user=Controller::afya_user_name($appointment->afya_user_id);

     $y=date('Y',strtotime($appointment->appointment_date));
     $m=date('n',strtotime($appointment->appointment_date))-1;
     $d=date('d',strtotime($appointment->appointment_date));
     $h=date('H',strtotime($appointment->appointment_time));
     $i=date('i',strtotime($appointment->appointment_time));

     $h_end=date('H',strtotime($appointment->appointment_time)+1800);
     $i_end=date('i',strtotime($appointment->appointment_time)+1800);


    if($events!="")$events=$events.",";
    $events=$events."{
        id: '".$appointment->id."',
        title: '".$afya_user."',
        start: new Date(".$y.",".$m.",".$d.",".$h.",".$i."),
        end: new Date(".$y.",".$m.",".$d.",".$h_end.",".$i_end.")

        }";

?>



  <button type="button" data-toggle="modal" data-target="#{{$appointment->id}}m" id="{{$appointment->id}}" class="hidden-btn"></button>

                                </div>
                            <div class="modal inmodal" id="{{$appointment->id}}m" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog">
                                <div class="modal-content animated bounceInRight">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                            <i class="fa fa-clock modal-icon"></i>
                                            <h4 class="modal-title">{{date('d M Y',strtotime($appointment->appointment_date))}} {{$appointment->appointment_time}}</h4>
                                            <small class="font-bold"></small>
                                        </div>
                                        <div class="modal-body">

                                      <p><strong>Name:</strong> {{Controller::afya_user_name($appointment->afya_user_id)}}</p>

                                      <p><strong>Phone Number:</strong> {{Controller::afya_user_phone($appointment->afya_user_id)}}</p>

                                      <p><strong>File Number:</strong>{{Controller::FileNo($appointment->afya_user_id)}}</p>
                                            <p><strong>Created By:</strong> {{Controller::user_name($appointment-> created_by_users_id)}}</p>
                                            <p><strong>Created ON:</strong> {{$appointment->created_at}}</p>


                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                                             <button type="button" data-dismiss="modal" data-toggle="modal" data-target="#{{$appointment->id}}edit"class="btn btn-primary">Edit Appointment</button>

                  {!! Form::open(['method' => 'DELETE','route' => ['calendar.destroy', $appointment->id],'style'=>'display:inline', 'onsubmit' => 'return ConfirmDelete()']) !!}
                  {!! Form::submit('Cancel Appointment', ['class' => 'btn btn-danger']) !!}
                  {!! Form::close() !!}



                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="modal inmodal" id="{{$appointment->id}}edit" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog">
                                <div class="modal-content animated bounceInRight">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                            <i class="fa fa-clock modal-icon"></i>
                                            <h4 class="modal-title">{{date('d M Y',strtotime($appointment->appointment_date))}} {{$appointment->appointment_time}}</h4>
                                            <small class="font-bold">Edit</small>
                                        </div>
                                        <div class="modal-body">


  {!! Form::model($appointment, ['method' => 'PATCH','route' => ['calendar.update', $appointment->id]]) !!}
<div class="row">
  <input type="hidden" name="id" value="{{$appointment->id}}" >


  <div class="col-xs-12 col-sm-12 col-md-12">
    <div class="form-group">
    <strong>File Number:</strong>
    {!! Form::text('filenumber', null, array('placeholder' => 'filenumber','class' => 'form-control')) !!}
    </div>
  </div>


  <div class="col-xs-12 col-sm-12 col-md-12">
  <div class="form-group">
  <strong>Appointment Date:</strong>
  {!! Form::text('appointment_date',null, array('class' => 'form-control daily')) !!}
</div>
</div>
<div class="col-xs-12 col-sm-12 col-md-12">
<div class="form-group">
<strong>Appointment Time:</strong>
  <div class="input-group clockpicker_edit" data-autoclose="true">

                    {!! Form::text('appointment_time',null, array('class' => 'form-control')) !!}

                    <span class="input-group-addon">
                        <span class="fa fa-clock-o"></span>
                    </span>
                </div>
</div>


</div>
 <div class="col-xs-12 col-sm-12 col-md-12">
    <div class="form-group">

    <strong>Doctor:</strong>
    <select  class="form-control" name="doc_id">
      @foreach($doctors as $doc)
      <option value="{{$doc->id}}">{{$doc->name}}</option>
      @endforeach

    </select>
    </div>
  </div>



                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                                             <button type="submit" class="btn btn-primary">Submit</button>
                                            <button type="button" class="btn btn-primary">Cancel Appointment</button>
                                        </div>

 {!! Form::close() !!}
                                    </div>
                                </div>
                            </div>

<?php

    }


 ?>



</div>
</div>




<!-- Mainly scripts -->
<script src="{{ asset('js/plugins/fullcalendar/moment.min.js') }}"></script>
<script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
<script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

<!-- Custom and plugin javascript -->
<script src="{{ asset('js/inspinia.js') }}"></script>
<script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>

<!-- jQuery UI  -->
<script src="{{ asset('js/plugins/jquery-ui/jquery-ui.min.js') }}"></script>

<!-- iCheck -->
<script src="{{ asset('js/plugins/iCheck/icheck.min.js') }}"></script>

<!-- Full Calendar -->
<script src="{{ asset('js/plugins/fullcalendar/fullcalendar.min.js') }}"></script>

<script>

    $(document).ready(function() {

            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green'
            });

        /* initialize the external events
         -----------------------------------------------------------------*/


        $('#external-events div.external-event').each(function() {

            // store data so the calendar knows to render an event upon drop

            // make the event draggable using jQuery UI
            $(this).draggable({
                zIndex: 1111999,
                revert: true,      // will cause the event to go back to its
                revertDuration: 0  //  original position after the drag
            });

        });


        /* initialize the calendar
         -----------------------------------------------------------------*/
        var date = new Date();
        var d = date.getDate();
        var m = date.getMonth();
        var y = date.getFullYear();




        $('#calendar').fullCalendar({
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay'
            },
            editable: true,
            droppable: true, // this allows things to be dropped onto the calendar
            drop: function() {
                // is the "remove after drop" checkbox checked?
                if ($('#drop-remove').is(':checked')) {
                    // if so, remove the element from the "Draggable Events" list
                    $(this).remove();
                }
            },
            events: [
              <?php echo $events;?>
            ],
             eventClick: function(event) {

             $('#'+event.id).click();
            }
        });


    });

</script>



 <!-- Data picker -->
   <script src="{{ asset('js/plugins/datapicker/bootstrap-datepicker.js') }}"></script>

    <!-- Page-Level Scripts -->
    <script>
        $(document).ready(function(){
            $('.dataTables-example').DataTable({
                pageLength: 25,
                responsive: true,
                sort:false,
                info:false,
                "bLengthChange": false,
                dom: '<"html5buttons"B>lTfgitp',
                buttons: [
                    {extend: 'copy'},
                    {extend: 'csv'},
                    {extend: 'excel', title: 'ExampleFile'},
                    {extend: 'pdf', title: 'ExampleFile'},

                    {extend: 'print',
                     customize: function (win){
                            $(win.document.body).addClass('white-bg');
                            $(win.document.body).css('font-size', '10px');

                            $(win.document.body).find('table')
                                    .addClass('compact')
                                    .css('font-size', 'inherit');
                    }
                    }
                ]

            });

              $('.details').DataTable({
                pageLength: 25,
                responsive: true,
                filter:false,
                paging:false,
                sort:false,
                info:false,
                dom: '<"html5buttons"B>lTfgitp',
                buttons: [
                    {extend: 'copy'},
                    {extend: 'csv'},
                    {extend: 'excel', title: 'ExampleFile'},
                    {extend: 'pdf', title: 'ExampleFile'},

                    {extend: 'print',
                     customize: function (win){
                            $(win.document.body).addClass('white-bg');
                            $(win.document.body).css('font-size', '10px');

                            $(win.document.body).find('table')
                                    .addClass('compact')
                                    .css('font-size', 'inherit');
                    }
                    }
                ]

            });

        });

    </script>



    <script>
    $(document).ready(function(){
          $('.daily').datepicker({
                todayBtn: "linked",
                keyboardNavigation: false,
                forceParse: false,
                calendarWeeks: true,
                autoclose: true,
                format: "yyyy-mm-dd"
            });

            $('.yearly').datepicker({
                startView: "years",
                minViewMode: "years"
            });

             $('.monthly').datepicker({
                startView: "months",
                minViewMode: "months"
            });



    });
    </script>

    <script src="{{ asset('js/plugins/clockpicker/clockpicker.js') }}"></script>
    <script>
      $('.clockpicker').clockpicker();
      $('.clockpicker_edit').clockpicker();

          </script>




</body>

</html>
