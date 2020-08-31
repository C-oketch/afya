<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="cache-control" content="private, max-age=0, no-cache">
		<meta http-equiv="pragma" content="no-cache">
		<meta http-equiv="expires" content="0">
		<title>AfyaPepe - The Mobile Health Management App</title>
		<link rel="stylesheet" href="{{ asset('landing/css/bootstrap.css') }}" />
    	<link rel="stylesheet" href="{{ asset('css/style.css') }}" />
		<link rel="stylesheet" href="{{ asset('css/custom.css') }}" />
		<link rel="shortcut icon" href="landing/images/favicon.png" />
		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
		<script src="{{ asset('landing/js/jquery.min.js') }}" type="text/javascript"></script>
		<script type="text/javascript">
      $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
  </script>

		 <!-- start-smoth-scrollin -->
		 <script src="{{ asset('landing/js/move-top.js') }}" type="text/javascript"></script>
		 <script src="{{ asset('landing/js/easing.js') }}" type="text/javascript"></script>
		 <!-- <script src="{{ asset('assets/landing/js/move-top.js') }}" type="text/javascript"></script> -->

		<script type="text/javascript">
			jQuery(document).ready(function($) {
				$(".scroll").click(function(event){
					event.preventDefault();
					$('html,body').animate({scrollTop:$(this.hash).offset().top},1000);
				});
			});
		</script>
		 <!-- Custom Theme files -->

		<link rel="stylesheet" href="{{ asset('landing/css/style.css') }}" />

   	<!-- Custom Theme files -->
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<meta http-equiv="Content-Type" content="text/html;charset=ISO-8859-1">
		<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
		</script>
		<!-- webfonts -->
		<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,800,700' rel='stylesheet' type='text/css'>
		<!-- //webfonts -->
		<!-- FontAwesome Icons -->
		<script src="https://use.fontawesome.com/b4be2c9bc1.js"></script>

		<!-- //FontAwesome Icons -->
		<script>
			$(function() {
				var pull 		= $('#pull');
					menu 		= $('nav ul');
					menuHeight	= menu.height();
				$(pull).on('click', function(e) {
					e.preventDefault();
					menu.slideToggle();
				});
				$(window).resize(function(){
	        		var w = $(window).width();
	        		if(w > 320 && menu.is(':hidden')) {
	        			menu.removeAttr('style');
	        		}
	    		});
			});
		</script>
		<!-- //End-top-nav-script -->
</head>
	<body>
		<!-- -start-container -->
		<!-- -header-section -->
		<div class="header-section">
			<!-- start-header -->
			<div id="home" class="header">
				<div class="container">
					<div class="top-header">
						<div class="logo">
							<a href="#">
								<img alt="AfyaPepe" src="{{ asset("/landing/images/afyapepe-logo.svg") }}" width="200"/>
							</a>
						</div>
						<!-- start-top-nav -->
						 <nav class="top-nav">
							<ul class="top-nav">
								<li class="active"><a href="{{ url('/') }}">Home </a></li>

							</ul>
						</nav>
						<div class="clearfix"> </div>
					</div>
				</div>
			</div>
			<!-- //End-header -->
			<!-- <script src="landing/js/responsiveslides.min.js"></script> -->

      <script src="{{ asset('landing/js/responsiveslides.min.js') }}" type="text/javascript"></script>

			 <script>
			    // You can also use "$(window).load(function() {"
			    $(function () {
			      // Optional Slider
			      $("#afya-slider").responsiveSlides({
			        auto: true,
			        pager: true,
			        nav: true,
			        speed: 500,
			        namespace: "callbacks",
			        before: function () {
			          $('.events').append("<li>before event fired.</li>");
			        },
			        after: function () {
			          $('.events').append("<li>after event fired.</li>");
			        }
			      });

			    });
			  </script>
			<!-- //End-slider-script -->
      <!-- Main view  -->
      @yield('content')

    </div>
    <!-- -//header-section -->

     <link rel="stylesheet" href="{{ asset('landing/css/popuo-box.css') }}" />
    <script src="{{ asset('landing/js/jquery.magnific-popup.js') }}" type="text/javascript"></script>

      <div class="clearfix"> </div>

</body>
</html>
