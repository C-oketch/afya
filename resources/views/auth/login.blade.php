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
								<img src="landing/images/afyapepe-logo.svg" onerror="this.src=images/afyapepe-logo.png; this.onerror=null;" width="200">
							</a>
						</div>
						<!-- start-top-nav -->
						 <nav class="top-nav">
							<ul class="top-nav">
								<li class="active"><a href="{{ url('/') }}" >Home </a></li>

							</ul>
						</nav>
						<div class="clearfix"></div>
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
			<div class="container">
				<div class="row header-content">


        <div class="col-lg-4 center-div">
                    <div class="float-e-margins">
                        <div class="text-center">
                          <h3 class="fnt-white">Welcome to Afyapepe+</h3>

                        </div>
                        <div class="">
                          <form class="m-t" role="form" method="POST" action="{{ url('/login') }}">
                              <input type="hidden" name="_token" value="{{ csrf_token() }}">

                              <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
                              <input id="email" type="text" class="form-control" name="email" placeholder="Email/Phone NO:" value="{{ old('email') }}">

                              @if ($errors->has('email'))
                                  <span class="help-block">
                                      <strong>{{ $errors->first('email') }}</strong>
                                  </span>
                              @endif

                            </div>
                              <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <input id="password" type="password" class="form-control" placeholder="Password" name="password">

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <button type="submit" class="btn btn-primary block full-width m-b">Login</button>

														<div class="form-group">
															<br />
																<div class="col-md-12 text-center">

																	<a class="fnt-white" href="{{ url('/password/reset') }}">Forgot Your Password?</a>

																	</div>
																	<div class="col-md-12 text-center">

																				<label>
																					<div class="col-md-3">
																						<input  type="checkbox"  name="remember"></div><div class="col-md-9"><h4 class="fnt-white">Remember Me</h4></div>
																				</label>

																</div>
														</div>
                            <!-- <p class="text-muted text-center"><small>Do not have an account?</small></p>
                            <a class="btn btn-sm btn-white btn-block" href="{{ url('/register') }}">Create an account</a> -->
                        </form>
                        </div>
                    </div>
                </div>



           <div class="clearfix"> </div>
			    <!---//device -->
					<!-- //End-slider -->
					</div>
				</div>
			</div>
			<!-- -//header-section -->

			 <link rel="stylesheet" href="{{ asset('landing/css/popuo-box.css') }}" />
      		<script src="{{ asset('landing/js/jquery.magnific-popup.js') }}" type="text/javascript"></script>



				<div class="clearfix"> </div>



	</body>
</html>
