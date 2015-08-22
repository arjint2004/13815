<?php include ('data_ori.php'); ?>
<!DOCTYPE html>
<!--[if IE 7]> <html lang="en" class="ie7"> <![endif]-->  
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->  
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->  
<!--[if !IE]><!--> <html lang="en">   <!--<![endif]-->  
	<head>
		<meta charset="utf-8" />
		<title><?php echo $Title; ?> | Movie Box</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<meta name="description" content="" />
		<meta name="author" content="" />

		<link href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
		<link rel="stylesheet" href="assets/font-awesome/css/font-awesome.css" />
		<!--[if IE 7]>
  		<link rel="stylesheet" href="assets/font-awesome/css/font-awesome-ie7.css">
		<![endif]-->		
		<link href="assets/css/style.css" rel="stylesheet" />
		<link href="assets/css/style_responsive.css" rel="stylesheet" />
		<link href="assets/css/effects.css" rel="stylesheet" />
		<link href="assets/fancybox/source/jquery.fancybox.css" rel="stylesheet" />
		<link href="assets/flexslider2/flexslider.css" rel="stylesheet" />
		<link href="assets/fancybox/source/jquery.fancybox.css" rel="stylesheet" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></head>
	<body>

		<div id="header">
			
			<div class="container">
			
				<div class="row-fluid">
						
					<div id="logo">					
						<a href="#"><img src="assets/img/logo.png" alt="Logo" /></a>
					</div><!-- /logo -->
												
				</div><!-- /row-fluid -->
							
			</div><!-- /container -->
			
		</div><!-- /header -->	
		
		<div id="content-title">
			<div class="container">
				<div class="row-fluid">
					<div class="span9">	
						<h3 class="title"><?php echo $Title; ?></h3>
					</div>
				</div>			
			</div>
		
		</div>

		<div id="content-body" class="services">
			
			<div class="container">

				<div class="row-fluid">
					
					<div class="span4">
						<h4 class="title grey">Details</h4>	
						<table class="table">
 							<tr>
 								<td class="bold">Title:</td>
 								<td><?php echo $Title; ?></td>
 							</tr>
 							<tr>
 								<td class="bold">Genre:</td>
 								<td><?php echo $Genre; ?></td>
 							</tr>
 							<tr> 
 								<td class="bold">Director:</td>
 								<td><?php echo $Director; ?></td>
 							</tr>
 							<tr> 
 								<td class="bold">Star:</td>
 								<td><?php echo $Star; ?></td>
 							</tr>
 							<tr>
 								<td class="bold">Country:</td>
 								<td><?php echo $Country; ?></td>
 							</tr>
 							<tr>
 								<td class="bold">Language:</td>
 								<td><?php echo $Language; ?></td>
 							</tr>
 							<tr>
 								<td class="bold">Runtime:</td>
 								<td><?php echo $Runtime; ?></td>
 							</tr>
 							<tr>
 								<td class="bold">Release:</td>
 								<td><?php echo $Release; ?></td>
 							</tr>
 							<?php if($Poster == TRUE ){?>
							<tr>
 								<td colspan="2">
									<div align="center">
										<div class="work img-polaroid" style="width:214px;">
											<a class="fancybox-button" rel="<?php echo $Title; ?>" title="<?php echo $Title; ?>" href="<?php echo $Poster; ?>">										
												<div class="overlay-zoom">	
													<img src="<?php echo $Poster; ?>" alt="<?php echo $Title; ?>" />
													<div class="zoom-icon"></div>	
													<div class="desc"><?php echo $Title; ?></div>					
												</div>											
											</a>																
										</div>
									</div>
								</td>
 							</tr>
							<?php } ?>
						</table>
					</div>

					<div class="span8">

						<div class="row-fluid">
							<div class="span12">
								<div class="flexslider flexslider_single clearfix">
				  					<ul class="slides">
										<li>											
											<div class="work img-polaroid">
												<div class="work-item">
												<div class="play-button"></div>
													<img src="<?php if($Backdrop==FALSE){ echo 'assets/img/blank.jpg'; }else{ echo $Backdrop; } ?>" style="height:600px;" alt="<?php echo $Title; ?>" />
													<div class="timeline"></div>
													<div class="time-duration"><?php echo $Runtime; ?></div>
													<div class="work-info">
														<div class="work-title">LOGIN OR REGISTER</div>
														<table cellpadding="0" cellspacing="0" border="0">
															<tr>
																<td width="50%" valign="top">
																	<div class="work-body">
																		<h3>Don't Have Account?</h3>
																		<p>Sped a little time now for free register and you could benefit later. You will be able to Stream and Download Movie Streaming in High-Definition on your PC (desktop, laptop, tablet, handheld pc etc.) and Mac. Download as many as you like and watch them on your computer, your tablet, TV or mobile device.</p>
																	</div>
																</td>
																<td width="50%" valign="top">
																	<div class="work-body">
																		<h3>Member Benefits</h3>
																		<ul>
																			<li>Watch as many movies you want!</li>
																			<li>Secure and no restrictions!</li>
																			<li>Thousands of movies to choose from - Hottest new releases</li>
																			<li>Click it and Whatch it! - No waiting to download movies, its instant</li>
																			<li>Guaranteed to save time and money - Its quick and hassle free, forget going to the post office</li>
																			<li>Its work on your TV, PC or MAC</li>
																		</ul>
																	</div>
																</td>
															</tr>
															<tr>
																<td width="50%" valign="top">
																	<a class="work-link shake" href="<?php echo $aff_link; ?>"><i class="icon-plus"></i>&nbsp;REGISTER</a>		
																</td>
																<td width="50%" valign="top">
																	<a class="work-link shake" href="<?php echo $aff_link; ?>"><i class="icon-plus"></i>&nbsp;LOGIN</a>		
																</td>
															</tr>
															<tr>
																<td colspan="2" align="center">
																	<div class="work-title" style="margin-top:100px;">
																	<h4>FREE TRIAL valid until <?php echo $DateTrial; ?> (use coupon code: 84N64L8R0)</h4>
																	</div>
																</td>
															</tr>
														</table>
													</div>
												</div>
											</div>
										</li>	
									</ul>
								</div>
							</div>
						</div>

						<div class="row-fluid margin-top-20">
							<h4 class="title grey">Storyline</h4>
							<p><?php echo $Description; ?></p>
							
							<h4 class="title grey"><?php echo $GenreMovie; ?> Movie</h4>
								<div class="flexslider flexslider_single clearfix">
				  					<ul class="slides">
										<?php for($tm=0;$tm<$CountTopMovie;$tm++){?>
										<li>											
											<div class="work img-polaroid">
												<a class="fancybox-button" rel="<?php echo $TopMovieID[$tm]; ?>" title="<a href='./<?php echo $TopMovieID[$tm]; ?>'>Detail <?php echo $TopMovieTitle[$tm]; ?></a>" href="<?php echo $TopBackdrop[$tm]; ?>">										
													<div class="overlay-zoom">	
														<img src="<?php echo $TopBackdrop[$tm]; ?>" alt="<?php echo $TopMovieID[$tm]; ?>" style="height:317px;" />
														<div class="zoom-icon"></div>	
														<div class="desc"><?php echo $TopMovieTitle[$tm]; ?></div>					
													</div>													
												</a>
											</div>
										</li>	
										<?php } ?>
									</ul>
								</div>
						</div><!------>	

					</div>	

				</div>
			</div>				
		
		</div>	
			
		<div id="footer">
			
			<div class="container">
					
				<div class="row-fluid margin-top-20">
					
					<div class="span12">

						<div id="copyright" class="span6 pull-left">
							&copy; <?php echo date('Y'); ?> Movie Box. All Rights Reserved. 
						</div><!-- /copyright -->

					</div>

				</div>

			</div>				

		</div><!-- /footer -->		

		<script src="assets/js/jquery-1.8.2.min.js"></script>
		<script src="assets/bootstrap/js/bootstrap.min.js"></script>	
		<script src="assets/flexslider2/jquery.flexslider-min.js"></script>
		<script src="assets/fancybox/source/jquery.fancybox.pack.js"></script>
		<!--[if lt IE 9]>
		<script src="assets/js/respond.js"></script>
		<![endif]-->		
		<script src="assets/js/app.js"></script>	
	</body>
</html>	
<script>
jQuery(document).ready(function() {
  	App.initInner();
	App.initGeneral();
	App.initProjects();
});
</script>		