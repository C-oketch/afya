<!DOCTYPE HTML>
<html>
	<head>
		<title>AfyaPepe - The Mobile Health Management App</title>
		<link rel="shortcut icon" href="landing/images/favicon.png" />
		<link rel="stylesheet" href="{{ asset('landing/css/bootstrap.css') }}" />
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
		<script src="{{ asset('landing/js/jquery.min.js') }}" type="text/javascript"></script>
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
</head>
	<body>
		<!-- -start-container -->
		<?php
$role='';
if($id==1){$role='Patients';} elseif ($id==2){$role='Pharmaceuticals';} elseif ($id==3){$role='Private Doctors';}
 elseif ($id==4){$role='Facilities';} elseif ($id==5){$role='Public Health Agencies';} elseif ($id==6){$role='Pharmacy';}
 else { $role=$id; }

		?>

								<div id="pricing" class="pricing-table">
									<div class="container">
										<div class="row">
											<!-- Pricing -->
											<div class="col-md-10 col-md-offse-1 ">
												<div class="pricing hover-effect">
													<div class="pricing-head">
														<h3><i class="fa fa-users" aria-hidden="true"></i><br/>Users</h3>
														<p>Fill the form accurately and submit.Our agent will get back to you as soon as possible.</p>
														<?php

														if (isset($emailerror)) { ?>
															<div class="alert alert-danger"> {{$emailerror}}</div>

														<?php } ?>
													</div>

													<div class="col-sm-6 b-r">

														{{ Form::open(array('route' => array('webReg'),'method'=>'POST')) }}

																		<div class="form-group"><label>First Name</label> <input type="text" placeholder="First Name" name="firstname" class="form-control" required></div>
																		<div class="form-group"><label>Surname</label> <input type="text" placeholder="surname" name="surname" class="form-control" required></div>
																		<div class="form-group"><label>Email</label> <input type="email" placeholder="Enter email" name="email" class="form-control" required></div>
                                    <div class="form-group"><label>Pone No</label> <input type="text" placeholder="07..." name="phone" class="form-control" required></div>
                                    <div class="form-group"><label>Physical Address</label> <input type="text" placeholder="Your Address" name="address" class="form-control" required></div>

	                            </div>
	                            <div class="col-sm-6">
																<div class="form-group"><label>City</label> <input type="text" placeholder="city" name="city" class="form-control" required></div>
																<div class="form-group"><label>County</label> <input type="text" placeholder="County" name="county" class="form-control" required></div>
																<div class="form-group"><label>Country</label> <input type="text" placeholder="Country" name="country" class="form-control" required></div>
																<div class="form-group"><label>Bussiness Name</label> <input type="text" placeholder="Business Name" name="bss" class="form-control"></div>

																<div class="form-group"><label></label><input type="hidden" Value="{{$role}}" name="user_type" class="form-control"></div>
                                     <br />
	                            </div>
                      <div class="col-sm-10">
															<div class="form-group col-md-8 col-md-offset-1">
															 <label class="control-label">Message</label>
																{{ Form::textarea('note', null, array('placeholder' => 'Talk to us..','class' => 'form-control col-lg-4')) }}
														</div>
                         </div>

													<div class="pricing-footer">
														<a  class="btn download" type="submit"</a>
														<button class="btn btn-lg btn-info btn-rounded download" type="submit"><strong>SUBMIT</strong></button>

													</div>
                       {{ Form::close() }}

												</div>
											</div>


											<!--//End Pricing -->
										</div>

									</div>
								</div>




	</body>
</html>
