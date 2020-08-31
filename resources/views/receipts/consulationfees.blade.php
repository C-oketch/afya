<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Registrar | Receipt</title>

    <link href="{{ asset('css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{ asset('font-awesome/css/font-awesome.css')}}" rel="stylesheet">

    <link href="{{ asset('css/animate.css')}}" rel="stylesheet">
    <link href="{{ asset('css/style.css')}}" rel="stylesheet">

</head>

<body class="white-bg">
                <div class="wrapper wrapper-content p-xl">
                    <div class="ibox-content p-xl">
                            <div class="row">
                                <div class="col-sm-6">
                                     <address>
                                        <strong>{{$fee->firstname}} {{$fee->secondName}}</strong><br>

                                        {{$fee->email}}<br>
                                        <abbr title="Phone">Phone:</abbr> {{$fee->msisdn}}
                                    </address>
                                </div>

                                <div class="col-sm-6 text-right">
                                    <h4>Receipt No.</h4>
                                    <h4 class="text-navy">{{$number}}</h4>

                                    <address>

                                      Facility :  {{$facility->FacilityName}}<br>
                                      Doctor :  {{$fee->docname}}<br>
                                      County :  {{$facility->County}}<br>
                                      Constituency : {{$facility->Constituency}}<br>

                                    </address>
                                    <p>

                                        <span><strong>Date:</strong> {{$dys}}</span>
                                    </p>
                                </div>
                            </div>

                            <div class="table-responsive m-t">
                                <table class="table invoice-table">
                                    <thead>
                                    <tr>
                                        <th>Details</th>


                                        <th>Total Price</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>Doctor’s consultation fee</td>



                                        <td>{{$fee->amount}}</td>
                                    </tr>



                                    </tbody>
                                </table>
                            </div><!-- /table-responsive -->

                            <table class="table invoice-total">
                                <tbody>

                                <tr>
                                    <td><strong>TOTAL :</strong></td>
                                   <td>{{$fee->amount}}</td>
                                </tr>
                                </tbody>
                            </table>

                        </div>

    </div>

    <!-- Mainly scripts -->
    <script src="{{ asset('js/jquery-3.1.1.min.js')}}"></script>
    <script src="{{ asset('js/bootstrap.min.js')}}"></script>
    <script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js')}}"></script>

    <!-- Custom and plugin javascript -->
    <script src="{{ asset('js/inspinia.js')}}"></script>

    <script type="text/javascript">
        window.print();
    </script>

</body>

</html>
