<html>
<head>
	<meta charset="UTF-8">
	<title>Install LP MOVIE</title>
	<link href="asset/css/install.css" rel="stylesheet" />
</head>
<body>
	<div id="header">
		<div id="logo"><img src="asset/images/logo.png" alt="Logo" /></div>
	</div>
	<div id="content">
		<?php if(isset($_GET['act'])){?>
		<div id="warning">
			<span><b>SUCCESS</b></span>
			<p>install LP Movie complate</p>
			<p>url format : http://[domain]/[id imdb]</p>
			<p>example : http://<?php echo $_SERVER['HTTP_HOST']; ?>/9876543</p>
			<p><button type="button" class="button">HOME</button></p>
		</div>
		<?php }else{ ?>
		<form method="POST" id="FormInstall" action="data.php">
		<div id="form-install">
			<input type="text" name="MegaFlix139" class="required input" placeholder="AFF Link MegaFlix 139">
		</div>
		<div id="form-install">
			<input type="text" name="MegaFlix44" class="required input" placeholder="AFF Link MegaFlix 44 or PushPlay 104">
		</div>
		<div id="form-install">
			<input type="text" name="PushPlay116" class="required input" placeholder="AFF Link PushPlay 116">
		</div>
		<div id="form-install">
			<input type="text" name="Stream4Stream129" class="required input" placeholder="AFF Link Stream4Stream 129">
		</div>
		<div id="form-install">
			<input type="text" name="MoviePlay131" class="required input" placeholder="AFF Link MoviePlay 131">
		</div>
		<div id="form-install">
			<input type="text" name="FunkPlay133" class="required input" placeholder="AFF Link FunkPlay 133">
		</div>
		<div id="form-install">
			<input type="text" name="FunkPlay142" class="required input" placeholder="AFF Link FunkPlay 142">
		</div>
		<div id="form-install">
			<input type="text" name="FunkPlay143" class="required input" placeholder="AFF Link FunkPlay 143">
		</div>
		<div id="form-install" style="margin-top:50px;">
			<input type="text" name="datetrial" class="required input" placeholder="Date Trial Coupon (day), ex: 16">
		</div>
		<div id="form-install">
			<input type="text" name="defaultid" class="required input" placeholder="Default ID IMDB, ex: 1234567">
		</div>
		<div id="form-submit">
			<input type="submit" name="submit" value="SUBMIT" class="submit">
		</div>
		</div class="clear"></div>
		</form>
		<?php } ?>
	</div>
	<script type='text/javascript' src='asset/js/jquery.js'></script>
	<script type='text/javascript' src='asset/js/jquery.validate.min.js'></script>
	<script type='text/javascript' src='asset/js/install.js'></script>
</body>
</html>