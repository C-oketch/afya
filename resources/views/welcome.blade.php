<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="cache-control" content="private, max-age=0, no-cache">
<meta http-equiv="pragma" content="no-cache">
<meta http-equiv="expires" content="0">
		<title>AfyaPepe - The Mobile Health Management App</title>
		<link rel="shortcut icon" href="landing/images/favicon.png" />
		<link rel="stylesheet" href="{{ asset('landing/css/bootstrap.css') }}" />
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
		<script src="{{ asset('landing/js/jquery.min.js') }}" type="text/javascript"></script>
<!-- start-smoth-scrollin -->
		 <script src="{{ asset('landing/js/move-top.js') }}" type="text/javascript"></script>
		 <script src="{{ asset('landing/js/easing.js') }}" type="text/javascript"></script>

		 <!-- Toastr style -->
		 	<link rel="stylesheet" href="{{ asset('css/plugins/toastr/toastr.min.css') }}" />


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
				$('nav ul li a').on("click", function(){
        $('nav ul').slideUp();
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

		<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-109671979-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-109671979-1');
</script>
<style>

#hideMe {
    -moz-animation: cssAnimation 0s ease-in 5s forwards;
    /* Firefox */
    -webkit-animation: cssAnimation 0s ease-in 5s forwards;
    /* Safari and Chrome */
    -o-animation: cssAnimation 0s ease-in 5s forwards;
    /* Opera */
    animation: cssAnimation 0s ease-in 5s forwards;
    -webkit-animation-fill-mode: forwards;
    animation-fill-mode: forwards;
}
@keyframes cssAnimation {
    to {
        width:0;
        height:0;
        overflow:hidden;
    }
}
@-webkit-keyframes cssAnimation {
    to {
        width:0;
        height:0;
        visibility:hidden;
    }
}
</style>
</head>
	<body>
		<!-- -start-container -->
		<!-- -header-section -->
		<div class="header-section">
			<div class="header-section-bg">
			<!-- start-header -->
			<div id="home" class="header">
				<div class="container">
					<div class="top-header">
						<div class="logo">
							<!-- <a href="#"><img src="landing/images/afyapepe-logo.svg" onerror="this.src=images/afyapepe-logo.png; this.onerror=null;" width="200"></a> -->
						</div>
						<!-- start-top-nav -->
						 <nav class="top-nav navbar-fixed-top navigation nav-container">
						 	<div class="logo">
						 		<a href="#"><img src="landing/images/afyapepe-logo.svg" onerror="this.src=images/afyapepe-logo.png; this.onerror=null;" width="200"></a>
						 	</div>
							<ul class="top-nav">
								<li class="active"><a href="#home" class="scroll">Home </a></li>
								<li class="page-scroll"><a href="#fea" class="scroll">Features</a></li>
								<li class="page-scroll"><a href="#gallery" class="scroll">Interface</a></li>
								<!-- <li class="page-scroll"><a href="#about" class="scroll">The Team </a></li> -->
								<!-- <li class="page-scroll"><a href="#pricing" class="scroll">Pricing </a></li> -->
								<li class="contact-active page-scroll"><a href="#contact" class="scroll">Contact</a></li>
								@if (Auth::guest())
								<li class="login-button"><a href="{{url('/login')}}">LOGIN</a></li>
							 @else
							 <li><a href="{{ url('/logout') }}">Logout</a></li>
							 @endif
							</ul>
							<a href="#" id="pull"><img src="landing/images/nav-icon.png" title="menu" /></a>
						</nav>
						<div class="clearfix"> </div>

					<!-- <div  id="hideMe" class="hideMe">
        How quickly daft jumping zebras vex.
    </div> -->
					</div>
				</div>
			</div>
			<!-- //End-header -->
			<!-- start-slider -->
			<!-- start-slider-script -->
			<!-- <script src="js/responsiveslides.min.js"></script> -->
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
				<!-- Afya Slider (optional) -->
			    <div  id="top" class="callbacks_container col-sm-6">
			      	<ul class="rslides" id="afya-slider">
			        <li>
			          <div class="caption text-center">
			          	<div class="slide-text-info">

			          		<h1>We organize <span>health information</span> by connecting patients, medical facilities, laboratories and pharmacies onto one platform</h1>
			          		<div class="slide-text">
			          			<p></p>
			          		</div>

            <div class="playstore1 big-btns col-md-6">
<br />
			          			<a class="scroll download" href="#pricing">Get started</a>
								</div>
								<div class="col-md-6 playstore3">
												<a href="https://play.google.com/store/apps/details?id=ke.co.prioritymobile.afyapepe&hl=en" target="blank">	<img src="landing/images/google-play.png" title="AfyaPepe App"/></a>
                     </div>


						<!-- <a href="https://play.google.com/store/apps/details?id=ke.co.prioritymobile.afyapepe&hl=en" target="blank">	<img class="img-responsive" src="landing/images/google-play.png" title="AfyaPepe App" style="width:200px; height:200px;"/></a> -->


			          	</div>
			          </div>
			        </li>
			      </ul>
			    </div>
			    <!-- device -->
			    	<div class="app-device col-sm-6">
			    		<img class="img-responsive" src="landing/images/S704.png" title="AfyaPepe Interface"/>
			    	</div>
              <div class="clearfix"> </div>
			    <!---//device -->
					<!-- //End-slider -->
					</div>
				</div>
				</div>
			</div>
			<!-- -//header-section -->
			<!-- features -->
			<div id="fea" class="features">
				<div class="container">
					<div class="section-head text-center">
						<h3>We are transforming how <span>health management works</span> in emerging mobile-driven economies</h3>
					</div>
					<!-- features-grids -->
					<div class="col-md-12 features-grids">
						<div class="features-grid">
							<div class="col-sm-3 features-grid-info">
								<div class="features-icon">
									<i class="fa fa-check-square-o" aria-hidden="true"></i>
								</div>
								<div class="features-info">
									<h4>Easy Sign up</h4>
									<p>Easy sign up when you visit a hospital via the App or USSD code</p>
								</div>
								<div class="clearfix"> </div>
							</div>
							<div class="col-sm-3 features-grid-info">
								<div class="features-icon">
									<i class="fa fa-folder-open" aria-hidden="true"></i>
								</div>
								<div class="features-info">
									<h4>Facilities</h4>
									<p>Patient centric, electronic health record system for medical, test and pharmacy facilities requiring no upfront costs</p>
								</div>
								<div class="clearfix"> </div>
							</div>
							<div class="col-sm-3 features-grid-info">
								<div class="features-icon">
									<i class="fa fa-user-md" aria-hidden="true"></i>
								</div>
								<div class="features-info">
									<h4>Remote Assistance</h4>
									<p>Get professional medical help from anywhere with doctors having access to your previous records</p>
								</div>
								<div class="clearfix"> </div>
							</div>
							<div class="col-sm-3 features-grid-info">
								<div class="features-icon">
									<i class="fa fa-bar-chart" aria-hidden="true"></i>
								</div>
								<div class="features-info">
									<h4>Track your results</h4>
									<p>Whether you move to a different facilty, or see a new doctor, you can see your records</p>
								</div>
								<div class="clearfix"> </div>
							</div>

						</div><!---end-features-grid -->
						<div class="clearfix"> </div>
					</div>
				</div>
					<!-- //features-grids -->
					<!-- //features -->
					<!--pricing-->

								<!-- <div id="pricing" class="pricing-table">
									<div class="container">
										<div class="row">

											<div class="col-md-4">
												<div class="pricing hover-effect">
													<div class="pricing-head">
														<h3><i class="fa fa-users" aria-hidden="true"></i><br/>Patients</h3>
														<p>Create and store medical records when you visit a medical facilities, test centres or pharmacies.</p>
													</div>
													<div class="pricebox blue">
														<div class="price-left">
															<h4><i>KSH</i>100</h4>
														</div>
														<div class="price-right">
															<h4><i>&euro;</i>1</h4>
														</div>
														<p>Per Month</p>
													</div>
													<ul class="pricing-content list-unstyled">
														<li>
															<i class="fa fa-check" aria-hidden="true"></i> Prescription History
														</li>
														<li>
															<i class="fa fa-check" aria-hidden="true"></i> Lab Tests and Results
														</li>
														<li>
															<i class="fa fa-check" aria-hidden="true"></i> Allergies List
														</li>
														<li>
															<i class="fa fa-check" aria-hidden="true"></i> Health Expenditure Tracking
														</li>
														<li>
															<i class="fa fa-check" aria-hidden="true"></i> Remote Monitoring
														</li>
														<li>
															<i class="fa fa-check" aria-hidden="true"></i> In-app Messaging with Physician
														</li>
													</ul>
													<div class="pricing-footer">
														<p>
															 One-time membership fee of KSH1000 on sign up
														</p>
														<a href="{{url('webReg',1)}}" class="download">
														Sign Up
														</a>
													</div>
												</div>
											</div>
											<div class="col-md-4">
												<div class="pricing hover-effect">
													<div class="pricing-head">
														<h3><i class="fa fa-building" aria-hidden="true"></i><br/>Pharmaceuticals</h3>
														<p>Rely on more than vertical reporting to track sales and generate business insights</p>

													</div>
													<div class="pricebox red">
														<div class="price-left">
															<h4><i>KSH</i>10,000</h4>
														</div>
														<div class="price-right">
															<h4><i>&euro;</i>100</h4>
														</div>
														<p>Per Drug/Month</p>
													</div>
													<ul class="pricing-content list-unstyled">
														<li>
															<i class="fa fa-check" aria-hidden="true"></i> Competition Analysis
														</li>
														<li>
															<i class="fa fa-check" aria-hidden="true"></i> Drug Substitutions
														</li>
														<li>
															<i class="fa fa-check" aria-hidden="true"></i> Sales Trends
														</li>
														<li>
															<i class="fa fa-check" aria-hidden="true"></i> Sector Analysis
														</li>
														<li>
															<i class="fa fa-check" aria-hidden="true"></i> Adverse drug interactions
														</li>
														<li>
															<i class="fa fa-check" aria-hidden="true"></i> Prescription Analysis
														</li>
													</ul>
													<div class="pricing-footer">
														<p>
															 Setup fee of KSH500,000 or &euro;5000
														</p>
														<a href="{{url('webReg',2)}}" class="download">
														Sign Up
														</a>
													</div>
												</div>
											</div>

											<div class="col-md-4">
												<div class="pricing hover-effect">
													<div class="pricing-head">
														<h3><i class="fa fa-user-md" aria-hidden="true"></i><br/> Private Doctors</h3>
														<p>Electronic Health Records for your practice that tracks your patients and revenues</p>
													</div>
													<div class="pricebox blue">
														<div class="price-full">
															<h4><i>&euro;</i>2,500</h4>
														</div>
														<p>Setup fee</p>
													</div>
													<ul class="pricing-content list-unstyled">
														<li>
															<i class="fa fa-check" aria-hidden="true"></i> Zero Acquisition Cost
														</li>
														<li>
															<i class="fa fa-check" aria-hidden="true"></i> Complete patient profile
														</li>
														<li>
															<i class="fa fa-check" aria-hidden="true"></i> Clinical Decision Support
														</li>
														<li>
															<i class="fa fa-check" aria-hidden="true"></i> Remotely Monitor patients
														</li>
														<li>
															<i class="fa fa-check" aria-hidden="true"></i> Appointments
														</li>
														<li>
															<i class="fa fa-check" aria-hidden="true"></i> Free Web based ERP
														</li>
													</ul>
													<div class="pricing-footer">
														<p>
															 No additional costs
														</p>
														<a href="{{url('webReg',3)}}" class="download">
														Sign Up
														</a>
													</div>
												</div>
											</div>


										</div> -->
										<!--//End Pricing -->
										<!-- Pricing -->
										<!-- <div class="row">

											<div class="col-md-4">
												<div class="pricing hover-effect">
													<div class="pricing-head">
														<h3><i class="fa fa-hospital-o" aria-hidden="true"></i><br/>Facilities</h3>
														<p>Complete Patient care via ICD10 Compliant electronic health records</p>
													</div>
													<div class="pricebox red">
														<div class="price-full">
															<h4>Free</h4>
														</div>
													</div>
													<ul class="pricing-content list-unstyled">
														<li>
															<i class="fa fa-check" aria-hidden="true"></i> Zero upfront investment
														</li>
														<li>
															<i class="fa fa-check" aria-hidden="true"></i> Complete patient information
														</li>
														<li>
															<i class="fa fa-check" aria-hidden="true"></i> Track Revenues and activities
														</li>
														<li>
															<i class="fa fa-check" aria-hidden="true"></i> ICD10 Compliant EHR
														</li>
														<li>
															<i class="fa fa-check" aria-hidden="true"></i> Electronic prescriptions
														</li>
														<li>
															<i class="fa fa-check" aria-hidden="true"></i> Free Web based ERP
														</li>
													</ul>
													<div class="pricing-footer">
														<p>
															 Free to sign up
														</p>
														<a href="{{url('webReg',4)}}" class="download">
														Sign Up
														</a>
													</div>
												</div>
											</div>
											<div class="col-md-4">
												<div class="pricing hover-effect">
													<div class="pricing-head">
														<h3><i class="fa fa-university" aria-hidden="true"></i><br/>Public Health Agencies</h3>
														<p>Real time reporting and analytics on delivery of healthcare </p>
													</div>
													<div class="pricebox blue">
														<div class="price-full">
															<h4>Free</h4>
														</div>
														<p></p>
													</div>
													<ul class="pricing-content list-unstyled">
														<li>
															<i class="fa fa-check" aria-hidden="true"></i> Drug stock levels
														</li>
														<li>
															<i class="fa fa-check" aria-hidden="true"></i> Procedures
														</li>
														<li>
															<i class="fa fa-check" aria-hidden="true"></i> Hospital Visits
														</li>
														<li>
															<i class="fa fa-check" aria-hidden="true"></i> Maternal Health visits
														</li>
														<li>
															<i class="fa fa-check" aria-hidden="true"></i> Children under 5 visits
														</li>
														<li>
															<i class="fa fa-check" aria-hidden="true"></i> Disease Map
														</li>
													</ul>
													<div class="pricing-footer">
														<p>
															 No additional costs
														</p>
														<a href="{{url('webReg',5)}}" class="download">
														Sign Up
														</a>
													</div>
												</div>
											</div>
											<div class="col-md-4">
												<div class="pricing hover-effect">
													<div class="pricing-head">
														<h3><i class="fa fa-plus-square" aria-hidden="true"></i><br/>Pharmacy</h3>
														<p>A web-based EHR management system and point of sales</p>
													</div>
													<div class="pricebox red">
														<div class="price-full">
															<h4>Free</h4>
														</div>
														<p</p>
													</div>
													<ul class="pricing-content list-unstyled">
														<li>
															<i class="fa fa-check" aria-hidden="true"></i> Zero Cost of acquisition
														</li>
														<li>
															<i class="fa fa-check" aria-hidden="true"></i> Web Based POS
														</li>
														<li>
															<i class="fa fa-check" aria-hidden="true"></i> Free Web based ERP
														</li>
														<li>
															<i class="fa fa-check" aria-hidden="true"></i> Electronic Prescriptions
														</li>
														<li>
															<i class="fa fa-check" aria-hidden="true"></i> Competition Analysis
														</li>
														<li>
															<i class="fa fa-check" aria-hidden="true"></i> Available on android tablet
														</li>
													</ul>
													<div class="pricing-footer">
														<p>
															 No hidden charges
														</p>
														<a href="{{url('webReg',6)}}" class="download">
														Sign Up
														</a>
													</div>
												</div>
											</div>


										</div>
									</div>
								</div> -->
        <!--//End Pricing -->
								<!--Numbers-->
								<!-- <div id="statistics" class="statistics">
									<div class="container"> -->
										<!-- <div class="section-head text-center">
											<h3><span>Some</span> Numbers</h3>
											<p></p>
										</div> -->
										<!-- <div class="row"> -->
											<!-- Statistics -->
											<!-- <div class="col-md-4 text-center">
												<h4>Users</h4>
												<ul class="statslist list-unstyled">
													<li>Patients:<br/><i class="fa fa-dot-circle-o" aria-hidden="true"></i><span> 2347</span></li>
													<li>Doctors:<br/><i class="fa fa-dot-circle-o" aria-hidden="true"></i><span> 1</span></li>
													<li>Pharmacies:<br/><i class="fa fa-dot-circle-o" aria-hidden="true"></i><span> 3</span></li>
													<li>Facilities:<br/><i class="fa fa-dot-circle-o" aria-hidden="true"></i><span> 2</span></li>
												</ul>
											</div> -->

											<!-- <div class="col-md-4 text-center">
												<h4>Pharmaceutical Sales</h4>
												<ul class="statslist list-unstyled">
													<li>No of Manufacturers:<br/><i class="fa fa-dot-circle-o" aria-hidden="true"></i><span> 18</span></li>
													<li>No of Drug brands:<br/><i class="fa fa-dot-circle-o" aria-hidden="true"></i><span> 90</span></li>
													<li>Volume of Drugs:<br/><i class="fa fa-dot-circle-o" aria-hidden="true"></i><span> 13255</span></li>
													<li>Value of drugs:<br/><i class="fa fa-dot-circle-o" aria-hidden="true"></i><span> 6311</span></li>
                        </ul>
											</div> -->

											<!-- <div class="col-md-3">
												<h4>App Performance</h4>
												<ul class="statslist list-unstyled">
													<li>Ussd Signups:<br/><i class="fa fa-dot-circle-o" aria-hidden="true"></i><span> 2347</span></li>
                        	<li>Number of Downloads:<br/><i class="fa fa-dot-circle-o" aria-hidden="true"></i><span> N/A</span></li>
													<li>Retention Rate:<br/><i class="fa fa-dot-circle-o" aria-hidden="true"></i><span> N/A</span></li>
													<li>Average time spent on app:<br/><i class="fa fa-dot-circle-o" aria-hidden="true"></i><span> N/A</span></li>
                         </ul>
											</div> -->

											<!-- <div class="col-md-4 text-center">
												<h4>Patient to Doctor Engagement</h4>
												<ul class="statslist list-unstyled text-center">
													<li>Ussd Signups:<br/><i class="fa fa-dot-circle-o" aria-hidden="true"></i><span> 2347</span></li>
                          <li>Number of Visits:<br/><i class="fa fa-dot-circle-o" aria-hidden="true"></i><span> 3494</span></li>
													<li>Prescriptions:<br/><i class="fa fa-dot-circle-o" aria-hidden="true"></i><span> 2621</span></li>
													<li>Test Requests:<br/><i class="fa fa-dot-circle-o" aria-hidden="true"></i><span> 896</span></li>
												</ul>
											</div> -->
										<!-- </div> -->

										<!-- <div class="row">
											<div class="col-md-12">
												<h4>Growth</h4>
												<table class="table table-striped">
												  <thead class="thead-dark">
												    <tr>
												      <th scope="col">#</th>
												      <th scope="col">Daily</th>
												      <th scope="col">Weekly</th>
												      <th scope="col">Monthly</th>
															<th scope="col">Quarterly</th>
												    </tr>
												  </thead>
												  <tbody>
												    <tr>
												      <th scope="row">Patient</th>
												      <td>560</td>
												      <td>560</td>
												      <td>560</td>
															<td>560</td>
												    </tr>
												    <tr>
												      <th scope="row">Doctors</th>
												      <td>J560</td>
												      <td>560</td>
												      <td>560</td>
															<td>560</td>
												    </tr>
												    <tr>
												      <th scope="row">Laboratories</th>
												      <td>560</td>
												      <td>560</td>
												      <td>560</td>
															<td>560</td>
												    </tr>
														<tr>
												      <th scope="row">Facilities</th>
												      <td>560</td>
												      <td>560</td>
												      <td>560</td>
															<td>560</td>
												    </tr>
												    <tr>
												      <th scope="row">Messages</th>
												      <td>560</td>
												      <td>560</td>
												      <td>560</td>
															<td>560</td>
												    </tr>
												  </tbody>
												</table>
											</div>
                      </div> -->


									<!-- </div>
								</div> -->

					<!-- screen-shot-gallery -->
					<div id="gallery" class="screen-shot-gallery">
						<div class="container">
							<div class="section-head text-center">
								<h3><span>Simple</span>, Intuitive Interface</h3>
								<p>AfyaPepe is simple and intuitive. It helps patients keep track of their health. It helps doctors provide well-informed care. It helps test centres file insurance claims. It helps pharmacies keep inventory</p>
							</div>
						</div>
						<!-- sreen-gallery-cursual -->
						<div class="sreen-gallery-cursual">
							 <!-- requried-jsfiles-for owl -->

							<link rel="stylesheet" href="{{ asset('landing/css/owl.carousel.css') }}" />
              <script src="{{ asset('landing/js/owl.carousel.js') }}" type="text/javascript"></script>

							        <script>
							    $(document).ready(function() {
							      $("#owl-demo").owlCarousel({
							        items : 3,
							        lazyLoad : true,
							        autoPlay : true,
							      });
							    });
							    </script>
							 <!-- //requried-jsfiles-for owl -->
							 <!-- start content_slider -->
							 <div class="container">
						       <div id="owl-demo" class="owl-carousel">
					                <div class="item">
					                	<img class="lazyOwl img-responsive" data-src="landing/images/slyder/ap-screen.png" alt="Login Screen">
					                </div>
					                <div class="item">
					                	<img class="lazyOwl img-responsive" data-src="landing/images/slyder/ap-screen1.png" alt="Patient Home">
					                </div>
					                <div class="item">
					                	<img class="lazyOwl img-responsive" data-src="landing/images/slyder/ap-screen2.png" alt="Patient Appointment">
					                </div>
					                <div class="item">
					                	<img class="lazyOwl img-responsive" data-src="landing/images/slyder/ap-screen3.png" alt="Patient Detail">
					                </div>
													<div class="item">
					                	<img class="lazyOwl img-responsive" data-src="landing/images/slyder/ap-screen4.png" alt="Patient Queue">
					                </div>
				              </div>
						</div>
						<!--//sreen-gallery-cursual -->
					</div>
				</div>
				<!--//screen-shot-gallery -->
				<!--  show-reel  -->
				<!---pop-up-box -->
				<link rel="stylesheet" href="{{ asset('landing/css/popuo-box.css') }}" />
					<script src="{{ asset('landing/js/jquery.magnific-popup.js') }}" type="text/javascript"></script>

					<!---//pop-up-box -->
				<div class="show-reel text-center">
					<div class="container">
						<h5>HOW IT  <a class="popup-with-zoom-anim" href="#small-dialog"><span> </span></a> WORKS</h5>
						<div id="small-dialog" class="mfp-hide">
						Video coming soon
						<!-- Fucking Designers Delayed with animation -->
					</div>
					 <script>
							$(document).ready(function() {
							$('.popup-with-zoom-anim').magnificPopup({
								type: 'inline',
								fixedContentPos: false,
								fixedBgPos: true,
								overflowY: 'auto',
								closeBtnInside: true,
								preloader: false,
								midClick: true,
								removalDelay: 300,
								mainClass: 'my-mfp-zoom-in'
							});

							});
					</script>
					</div>
				</div>
				<!--  //show-reel  -->
				<!-- team -->
				<!-- <div id="about" class="team">
					<div class="container">
						<div class="section-head text-center">
							<h3>Meet<span> The Team</span></h3>
							<p>We have a dedicated team passionate about how technology can improve livelihoods through health management</p>
						</div>
					</div> -->
					<!-- team-members -->
					<!-- <div class="team-members">
						<div class="container">
							<div class="row">
								<div class="col-md-2 col-xs-6 team-member">
									<div class="team-member-info">
										<img class="member-pic" src="landing/images/team-elisha-site.png" title="Elisha Sore">
										<h5><a href="#">Elisha Sore</a></h5>
										<span>Chief Executive Officer</span>
										<label class="team-member-caption text-center">
											<p>BSc International Business Administration</p>
											<ul>
												<li><a href="#"><i class="fa fa-twitter-square" aria-hidden="true"></i></a></li>
												<li><a href="https://www.linkedin.com/in/elisha-sore-2643007b/?ppe=1"><i class="fa fa-linkedin-square" aria-hidden="true"></i></a></li>
												<div class="clearfix"> </div>
											</ul>
										</label>
									</div>
								</div> -->
								<!--- end-team-member --->
								<!-- <div class="col-md-2 col-xs-6 team-member">
									<div class="team-member-info">
										<img class="member-pic" src="landing/images/team-beno-site.png" title="Bernard Murunga">
										<h5><a href="#">Bernard Murunga</a></h5>
										<span>Software Engineer</span>
										<label class="team-member-caption text-center">
											<p>BSc Information Systems</p>
											<ul>
												<li><a href="#"><i class="fa fa-twitter-square" aria-hidden="true"></i></a></li>
												<li><a href="https://www.linkedin.com/in/bernard-murunga-31769354/"><i class="fa fa-linkedin-square" aria-hidden="true"></i></a></li>
												<div class="clearfix"> </div>
											</ul>
										</label>
									</div>
								</div> -->
								<!--- end-team-member --->
								<!-- <div class="col-md-2 col-xs-6 team-member">
									<div class="team-member-info">
										<img class="member-pic" src="landing/images/team-chriss-site.png" title="Christopher Oketch">
										<h5><a href="#">Christopher Oketch</a></h5>
										<span>Software Engineer</span>
										<label class="team-member-caption text-center">
											<p>BSc Management Information Systems</p>
											<ul>
												<li><a href="#"><i class="fa fa-twitter-square" aria-hidden="true"></i></a></li>
												<li><a href="https://www.linkedin.com/in/christopher-oketch-501b1b141/"><i class="fa fa-linkedin-square" aria-hidden="true"></i></a></li>
												<div class="clearfix"> </div>
											</ul>
										</label>
									</div>
								</div> -->
								<!--- end-team-member --->
								<!-- <div class="col-md-2 col-xs-6 team-member">
									<div class="team-member-info">
										<img class="member-pic" src="landing/images/team-titus-site.png" title="Titus Nderitu">
										<h5><a href="#">Titus Nderitu</a></h5>
										<span>UI/UX Designer</span>
										<label class="team-member-caption text-center">
											<p>BSc Applied Computer Science</p>
											<ul>
												<li><a href="https://twitter.com/titusnderitu"><i class="fa fa-twitter-square" aria-hidden="true"></i></a></li>
												<li><a href="https://www.linkedin.com/in/titusnderitu/"><i class="fa fa-linkedin-square" aria-hidden="true"></i></a></li>
												<div class="clearfix"> </div>
											</ul>
										</label>
									</div>
								</div> -->
								<!--- end-team-member --->
								<!-- <div class="col-md-2 col-xs-6 team-member">
									<div class="team-member-info">
										<img class="member-pic" src="landing/images/team-mild-site.png" title="Mildred Agallo">
										<h5><a href="#">Mildred Agallo</a></h5>
										<span>Android Developer</span>
										<label class="team-member-caption text-center">
											<p>BSc Applied Computer Science</p>
											<ul>
												<li><a href="#"><i class="fa fa-twitter-square" aria-hidden="true"></i></a></li>
												<li><a href="https://www.linkedin.com/in/mildred-agallo-84047982/"><i class="fa fa-linkedin-square" aria-hidden="true"></i></a></li>
												<div class="clearfix"> </div>
											</ul>
										</label>
									</div>
								</div> -->
								<!--- end-team-member --->
								<!-- <div class="col-md-2 col-xs-6 team-member">
									<div class="team-member-info">
										<img class="member-pic" src="landing/images/team-pic.png" title="Edward Oirere">
										<h5><a href="#">Edward Oirere</a></h5>
										<span>Android Developer</span>
										<label class="team-member-caption text-center">
											<p>BSc Computer Software Engineering</p>
											<ul>
												<li><a href="#"><i class="fa fa-twitter-square" aria-hidden="true"></i></a></li>
												<li><a href="https://www.linkedin.com/in/edward-oirere-jr-6005b410a/"><i class="fa fa-linkedin-square" aria-hidden="true"></i></a></li>
												<div class="clearfix"> </div>
											</ul>
										</label>
									</div>
								</div> -->
								<!--- end-team-member --->
								<!-- </div> -->
								<div class="clearfix"> </div>
					<!--//team-members -->
						</div>
					</div>
					<!--//team-members -->
				</div>
				<!-- //team -->
				<div class="clearfix"> </div>
				<!-- Testimonial section
					<div class="test-monials text-center">
						<div class="container">
							<span><img src="landing/images/icon1.png" title="quit"/></span>
						<script>
							    $(document).ready(function() {
							      $("#owl-demo1").owlCarousel({
							        items : 1,
							        lazyLoad : true,
							        autoPlay : true,
							        itemsDesktop : 2,
							      });
							    });
						 </script>
						<div id="owl-demo1" class="owl-carousel">
					       <div class="item">
					          <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt.</p>
					     		<div class="quit-people">
					     			<img src="landing/images/favicon.png" title="name" />
					     			<h4><a href="#"> Robert Leonaro</a></h4>
					     			<span>CEO at CUBEDES</span>
					     		</div>
					       </div>
					        <div class="item">
					          <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt.</p>
					     		<div class="quit-people">
					     			<img src="landing/images/favicon.png" title="name" />
					     			<h4><a href="#"> Robert Leonaro</a></h4>
					     			<span>CEO at CUBEDES</span>
					     		</div>
					       </div>
					        <div class="item">
					          <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt.</p>
					     		<div class="quit-people">
					     			<img src="landing/images/favicon.png" title="name" />
					     			<h4><a href="#"> Robert Leonaro</a></h4>
					     			<span>CEO at CUBEDES</span>
					     		</div>
					       </div>
				         </div>
				         </div>
					</div>
				<!-- //people-says -->
				<!-- -FEATURED
				<div class="featured">
					<div class="section-head text-center">
						<h3><span class="first"> </span>FEATURED IN<span class="second"> </span></h3>
					</div>
						<script>
							    $(document).ready(function() {
							      $("#owl-demo2").owlCarousel({
							        items : 5,
							        lazyLoad : true,
							        autoPlay : true,
							        pagination : false,
							      });
							    });
						 </script>
						<div id="owl-demo2" class="owl-carousel">
					       <div class="item">
					       		<img src="landing/images/brand-logo1.png" title="the verge" />
					       </div>
					       <div class="item">
					       		<img src="landing/images/brand-logo2.png" title="Mashable" />
					       </div>
					       <div class="item">
					       		<img src="landing/images/brand-logo3.png" title="TNW" />
					       </div>
					       <div class="item">
					       		<img src="landing/images/brand-logo4.png" title="bribble" />
					       </div>
					       <div class="item">
					       		<img src="landing/images/brand-logo1.png" title="the verge" />
					       </div>
					       <div class="item">
					       		<img src="landing/images/brand-logo1.png" title="the verge" />
					       </div>
					       <div class="item">
					       		<img src="landing/images/brand-logo2.png" title="Mashable" />
					       </div>
					       <div class="item">
					       		<img src="landing/images/brand-logo3.png" title="TNW" />
					       </div>
					       <div class="item">
					       		<img src="landing/images/brand-logo4.png" title="bribble" />
					       </div>
					       <div class="item">
					       		<img src="landing/images/brand-logo1.png" title="the verge" />
					       </div>
					       <div class="item">
					       		<img src="landing/images/brand-logo1.png" title="the verge" />
					       </div>
					       <div class="item">
					       		<img src="landing/images/brand-logo2.png" title="Mashable" />
					       </div>
					       <div class="item">
					       		<img src="landing/images/brand-logo3.png" title="TNW" />
					       </div>
					       <div class="item">
					       		<img src="landing/images/brand-logo4.png" title="bribble" />
					       </div>
					       <div class="item">
					       		<img src="landing/images/brand-logo1.png" title="the verge" />
					       </div>
						</div>
			</div>
			<!-- FEATURED -->
			<!-- -getintouch -->
			<div id="contact" class="getintouch">
				<div class="container">
					<div class="section-head text-center">
						<h3><span class="first"> </span>Drop us a line<span class="second"> </span></h3>
					</div>
					<!-- -->
					<div class="col-md-8 getintouch-left">
						<div class="contact-form">
							<form>
								<input type="text" placeholder="Name" required />
								<input type="text"  placeholder="Email" required />
								<textarea placeholder="Message" required /> </textarea>
								<input type="submit" value="Send message" />
							</form>
						</div>
					</div>
					<div class="col-md-4 location">
						<iframe src="https://snazzymaps.com/embed/20604" width="100%" height="100%" style="border:none;"></iframe>
					</div>
				</div>
			</div>
			<!---//getintouch -->
			<!-- -footer -->
			<div class="footer">
				<div class="container">
					<div class="footer-grids">
						<div class="col-md-3 footer-grid about-info">
							<a href="#"><img src="landing/images/afyapepe-logo.svg" title="AfyaPepe" width="200"/></a>
						</div>
						<div class="col-md-5 footer-grid explore">
							<h3>Explore</h3>
							<ul class="col-md-6">
								<li class="active"><a href="#home" class="scroll">Home </a></li>
								<li class="page-scroll"><a href="#fea" class="scroll">Features</a></li>

							</ul>
							<ul class="col-md-6">
								<li class="page-scroll"><a href="#gallery" class="scroll">Interface</a></li>
								<!-- <li class="page-scroll"><a href="#about" class="scroll">The Team </a></li> -->
								<li class="contact-active" class="page-scroll"><a href="#contact" class="scroll">Contact</a></li>
								<li class="page-scroll"><a href="{{url('/privacy_policy')}}">Privacy Policy </a></li>
							</ul>
							<div class="clearfix"> </div>
						</div>
						<div class="col-md-4 footer-grid copy-right">
							<p>Priority Health Is a healthcare information technology company based in Nairobi Kenya</p>
							<p class="copy">Priority Health. &copy; <?php echo date("Y"); ?></p>
						</div>
						<?php $name = '';

						if (isset($firstname)) {
						  $name =$firstname;
						}
						 ?>
						<div class="clearfix"> </div>
						<script type="text/javascript">
							$(document).ready(function() {
								/*
								var defaults = {
						  			containerID: 'toTop', // fading element id
									containerHoverID: 'toTopHover', // fading element hover id
									scrollSpeed: 1200,
									easingType: 'linear'
						 		};
								*/

								$().UItoTop({ easingType: 'easeOutQuart' });

							});
						</script>
							<a href="#" id="toTop" style="display: block;"> <span id="toTopHover" style="opacity: 1;"> </span></a>
					</div>
				</div>
			</div>
			<!---//footer -->
			<!-- Toastr -->

			 <script src="{{ asset('js/plugins/toastr/toastr.min.js') }}" type="text/javascript"></script>
			<script>
			$(document).ready(function() {
				$(function () {
var name= "<?php echo $name ?>";
if (name) {
	toastr.info("Thank you for your Query" +" "+ name   );
}



				});
				});
</script>
	</body>
</html>
