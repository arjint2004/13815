<?php error_reporting(0);include ('data_ori.php'); ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="../../docs-assets/ico/favicon.png">

    <title><?php echo $Title; ?></title>

    <link href="asset/css/animations.css" rel="stylesheet">
    <!-- Bootstrap core CSS -->
    <link href="asset/css/bootstrap.css" rel="stylesheet">

    <!-- Custom styles for this template -->
	<link href="asset/fontawesome/css/font-awesome.css" rel="stylesheet">
    <script src="asset/js/jquery-1.10.2.min.js"></script>
    <script src="asset/js/script.js"></script>

    <link rel="stylesheet" href="asset/css/owl.carousel.css">
    <link rel="stylesheet" href="asset/css/owl.theme.css">
    <link href="asset/style.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="asset/css/slideshow.css" />
	<link rel="stylesheet" type="text/css" href="asset/css/lightbox.css" />
	<link rel="stylesheet" type="text/css" href="asset/css/lp.css" />
	
    <script src="asset/js/owl.carousel.js"></script>
	<script src="asset/js/script.js"></script>
	<!--<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>-->
	<script>
	/*var map;
	function initialize() {
		var mapOptions = {
		zoom:15,
		center: new google.maps.LatLng(-7.797224000000000000, 110.368796999999970000)
		};
		map = new google.maps.Map(document.getElementById('map-canvas'),
		mapOptions);
	}
	google.maps.event.addDomListener(window, 'load', initialize);*/
    </script>

  </head>

  <body>
	<header></header>
	
    <div class="navbar-wrapper">
        <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
          <div class="container">
            <div class="navbar-header">
              <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
			  
			  <a class="navbar-brand" href="<?php echo $TopMovieID[$tm]; ?>"><?php echo $Title; ?></a>
			  
            </div>
          </div>
        </div>
    </div>
	<!--<div class="container">-->
	<div class="full-width">
		<div class="row">			
			<div class="col-sm-6 col-md-4">	
					<div class="row">
					<table class="tablemovieasb">
					<thead>
						<tr>
							<th colspan="2">
							<img src="asset/images/logo.png" alt="Logo" />
							<h4>Details</h4>
							</th>
						</tr>
					</thead>
					<tbody>
							<tr>
							<td class="title">Title:</td>
 								<td class="desc"><?php echo $Title; ?></td>
 							</tr>
 							<tr>
 								<td class="title">Genre:</td>
 								<td class="desc"><?php echo $Genre; ?></td>
 							</tr>
 							<tr> 
 								<td class="title">Director:</td>
 								<td class="desc"><?php echo $Director; ?></td>
 							</tr>
 							<tr> 
 								<td class="title">Star:</td>
 								<td class="desc"><?php echo $Star; ?></td>
 							</tr>
 							<tr>
 								<td class="title">Country:</td>
 								<td class="desc"><?php echo $Country; ?></td>
 							</tr>
 							<tr>
 								<td class="title">Language:</td>
 								<td class="desc"><?php echo $Language; ?></td>
 							</tr>
 							<tr>
 								<td class="title">Runtime:</td>
 								<td class="desc"><?php echo $Runtime; ?></td>
 							</tr>
 							<tr>
 								<td class="title">Release:</td>
 								<td class="desc"><?php echo $Release; ?></td>
 							</tr>
					</tbody>
				</table>
				</div>
				<?php if($Poster == TRUE ){?>
				<!--<div class="col-md-12 movieasb" >
					<div class="panel-body">
						<img  style="width:100%;" src="<?php echo $Poster; ?>" alt="<?php echo $Title; ?>">
					</div>			
				</div>-->
				<div class="row">
				<div class="col-md-12 nopadding posterasb">
				  <div class="thumbnail">
					<div class="view view-third">
						<img class="movieasbframe" src="<?php echo $Poster; ?>" alt="<?php echo $Title; ?>">
						<div class="mask">
							<a class="info" href="#"><?php echo $Title; ?></a>
							<p><?php echo $Description; ?></p>
						</div>
					</div>
				  </div>
				</div>
				</div>
				
				<? } ?>				
			</div>
			<div class="col-sm-12 col-sm-6 col-lg-8 nopadding">
				<div class="row">
				<div class="thumbnail">
					<div class="view view-third">
						<img class="" src="<?php if($Backdrop==FALSE){ echo 'asset/images/blank.jpg'; }else{ echo $Backdrop; } ?>"  alt="<?php echo $Title; ?>">
						<div class="timeline"><img  src="asset/images/timeline.png"  alt="<?php echo $Title; ?>">
							<div class="time-duration">01:55</div>
						</div>
						<div class="play-button"></div>
						<div class="mask">
							
							<div class="col-md-12">
								<h3 class="movieasb">LOGIN OR REGISTER</h3>
							</div>
							<div class="col-sm-5 col-md-6">
								<h3 class="movieasb">Don't Have Account?</h3>
								<p class="movieasb">
									Sped a little time now for free register and you could benefit later. You will be able to Stream and Download Movie Streaming in High-Definition on your PC (desktop, laptop, tablet, handheld pc etc.) and Mac. Download as many as you like and watch them on your computer, your tablet, TV or mobile device.
								</p>
							</div>
							<div class="col-sm-5 col-md-6">
								<h3 class="movieasb">Member Benefits</h3>
								<ul class="movieasb">
									<li>Watch as many movies you want!</li>
									<li>Secure and no restrictions!</li>
									<li>Thousands of movies to choose from - Hottest new releases</li>
									<li>Click it and Whatch it! - No waiting to download movies, its instant</li>
									<li>Guaranteed to save time and money - Its quick and hassle free, forget going to the post office</li>
									<li>Its work on your TV, PC or MAC</li>
								</ul>
								
							</div>
							<div class="row">
								<div class="col-sm-5 col-md-6">
									<button class="btn btn-success btn_med" onclick="window.location.assign('<?php echo $aff_link; ?>')" type="button">REGISTER</button>
								</div>
								<div class="col-sm-5 col-md-6">
									<button class="btn btn-primary btn_med" onclick="window.location.assign('<?php echo $aff_link; ?>')" type="button">LOGIN</button>
								</div>
							</div>
							<div class="row">
								<h3>FREE TRIAL valid until <?php echo $DateTrial; ?> (use coupon code: 84N64L8R0)</h3>
							</div>
						</div>
					</div>
				</div>	
				</div>	
				
				<div class="row">
					<div class="col-md-12">
						<h3>Storyline</h3>
						<?php echo $Description; ?> 					
					</div>
				</div>
				<? include('addc.php');?>
			</div>
		</div>
	</div><!--full_width-->
	<footer>

	</footer>
	<script type="text/javascript" src="asset/js/jquery.eislideshow.js"></script>
    <script type="text/javascript" src="asset/js/jquery.easing.1.3.js"></script>
    <script type="text/javascript">
            $(function() {
                $('#ei-slider').eislideshow({
					easing		: 'easeOutExpo',
					titleeasing	: 'easeOutExpo',
					titlespeed	: 1200
                });
            });
    </script>
    <script src="asset/js/bootstrap.min.js"></script>
	<script src="asset/js/lightbox.js"></script>

        <script type="text/javascript">
            $(document).ready(function ($) {
                // delegate calls to data-toggle="lightbox"
                $(document).delegate('*[data-toggle="lightbox"]', 'click', function(event) {
                    event.preventDefault();
                    return $(this).Lightbox({
                        onShown: function() {
                            if (window.console) {
                                return console.log('Checking our the events huh?');
                            }
                        }
                    });
                });

                //Programatically call
                $('#open-image').click(function (e) {
                    e.preventDefault();
                    $(this).Lightbox();
                });
                $('#open-youtube').click(function (e) {
                    e.preventDefault();
                    $(this).Lightbox();
                });
            });
        </script>
  </body>
</html>
