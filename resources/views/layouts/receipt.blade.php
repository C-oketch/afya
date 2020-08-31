<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="_token" content="{!! csrf_token() !!}" />


    <title>Invoice </title>

    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('font-awesome/css/font-awesome.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/animate.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}" />

    <style type="text/css" media="print">
   @page
   {
       size:  auto;   /* auto is the initial value */
       margin: 0mm;  /* this affects the margin in the printer settings */
   }

   html
   {
       /* background-color: #FFFFFF; */
       margin: 0px;  /* this affects the margin on the html before sending to printer */
   }

   body
   {
       /* border: solid 1px blue ; */
       margin: 0mm 0mm 0mm 0mm; /* margin you want for the content */
   }
   </style>

</head>

<body class="white-bg">

    <!-- Main view  -->
    @yield('content')

    <!-- Mainly scripts -->
      <script src="{{ asset('js/app.js') }}" type="text/javascript"></script>
    <!-- Mainly scripts -->
    <script src="{{ asset('js/jquery-3.1.1.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
          window.print();
      </script>

</body>
</html>
