
<html>
<head>
    @include('includes.default.head')
</head>
    <body class="fixed-left">
     <div id="wrapper">

<!--top bar-->
  @include('includes.default.topbar')
<!--end top bar-->

<!--left menu start-->
  @include('includes.default.loginmenu')
<!--left menu end-->
 <!--page-->
  @yield('content')
<!--page-->
    </div>

  <!--page-->
              @include('includes.default.footer')
  <!--page-->
    </body>
</html>
