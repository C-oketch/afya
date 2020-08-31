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
		<div class="">
			<div class="header-section-bg">
			<!-- start-header -->
			<div id="" class="header">
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
								<li class="active"><a href="{{url('/')}}" >Home </a></li>
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


				</div>
			</div>
			<!-- -//header-section -->
			<!-- features -->
			<div id="fea" class="features">
				<div class="container">
					<div class="section-head text-center">
						<h3><span>Privacy Policy</span>
					</div>
				</div>




				<div class="container">


					<!-- features-grids -->
					<div class="col-md-12 features-grids">
						<div class="features-grid">

								<div class="features-info">
								</p> <p>This page is used to inform visitors regarding our policies with the collection, use, and
									disclosure of Personal Information if anyone decided to use our Service.
								</p> <p>If you choose to use our Service, then you agree to the collection and use of information in relation
									to this policy. The Personal Information that we collect is used for providing and improving the
									Service. We will not use or share your information with anyone except as described
									in this Privacy Policy.
								</p> <p>The terms used in this Privacy Policy have the same meanings as in our Terms and Conditions, which is accessible
									at Afyapepe unless otherwise defined in this Privacy Policy.
								</p> <p><strong>Information Collection and Use</strong></p> <p>For a better experience, while using our Service, we may require you to provide us with certain
									personally identifiable information, including but not limited to Audio, Video. The information that we request will be retained by us and used as described in this privacy policy.
								</p> <p>The app does use third party services that may collect information used to identify you.</p> <div><p>Link to privacy policy of third party service providers used by the app</p> <ul><li><a href="https://www.google.com/policies/privacy/" target="_blank">Google Play Services</a></li> <!----> <!----> <!----> <!----> <!----></ul></div> <p><strong>Log Data</strong></p> <p> We want to inform you that whenever you use our Service, in a case of an
									error in the app we collect data and information (through third party products) on your phone
									called Log Data. This Log Data may include information such as your device Internet Protocol (“IP”) address,
									device name, operating system version, the configuration of the app when utilizing our Service,
									the time and date of your use of the Service, and other statistics.
								</p> <p><strong>Cookies</strong></p> <p>Cookies are files with a small amount of data that are commonly used as anonymous unique identifiers. These
									are sent to your browser from the websites that you visit and are stored on your device's internal memory.
								</p> <p>This Service does not use these “cookies” explicitly. However, the app may use third party code and libraries
									that use “cookies” to collect information and improve their services. You have the option to either
									accept or refuse these cookies and know when a cookie is being sent to your device. If you choose to
									refuse our cookies, you may not be able to use some portions of this Service.
								</p> <p><strong>Service Providers</strong></p> <p> We may employ third-party companies and individuals due to the following reasons:</p> <ul><li>To facilitate our Service;</li> <li>To provide the Service on our behalf;</li> <li>To perform Service-related services; or</li> <li>To assist us in analyzing how our Service is used.</li></ul> <p> We want to inform users of this Service that these third parties have access to your
									Personal Information. The reason is to perform the tasks assigned to them on our behalf. However, they
									are obligated not to disclose or use the information for any other purpose.
								</p> <p><strong>Security</strong></p> <p> We value your trust in providing us your Personal Information, thus we are striving
									to use commercially acceptable means of protecting it. But remember that no method of transmission over
									the internet, or method of electronic storage is 100% secure and reliable, and we cannot guarantee
									its absolute security.
								</p> <p><strong>Links to Other Sites</strong></p> <p>This Service may contain links to other sites. If you click on a third-party link, you will be directed
									to that site. Note that these external sites are not operated by us. Therefore, we strongly
									advise you to review the Privacy Policy of these websites. We have no control over
									and assume no responsibility for the content, privacy policies, or practices of any third-party sites
									or services.
								</p> <p><strong>Children’s Privacy</strong></p> <p>These Services do not address anyone under the age of 13. We do not knowingly collect
									personally identifiable information from children under 13. In the case we discover that a child
									under 13 has provided us with personal information, we immediately delete this from
									our servers. If you are a parent or guardian and you are aware that your child has provided us with personal
									information, please contact us so that we will be able to do necessary actions.
								</p> <p><strong>Changes to This Privacy Policy</strong></p> <p> We may update our Privacy Policy from time to time. Thus, you are advised to review
									this page periodically for any changes. We will notify you of any changes by posting
									the new Privacy Policy on this page. These changes are effective immediately after they are posted on
									this page.
								</p>
								 <p><strong>Contact Us</strong></p> <p>If you have any questions or suggestions about our Privacy Policy, do not hesitate to contact
									us.
								</p>


						</div>



						</div><!---end-features-grid -->
						<div class="clearfix"> </div>
					</div>
				</div>








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
