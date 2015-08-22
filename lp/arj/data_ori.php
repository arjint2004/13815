<?php 

/*INSTALL LP MOVIE*/
if(isset($_POST['submit'])) {
$DataLP = "<?php

/*-------------------SETTING------------------------*/
//AFF LINK
\$MegaFlix139 = '".$_POST['MegaFlix139']."'; //MegaFlix 139
\$MegaFlix44 = '".$_POST['MegaFlix44']."'; //MegaFlix 44 or PushPlay 104
\$PushPlay116 = '".$_POST['PushPlay116']."'; //PushPlay 116
\$Stream4Stream129 = '".$_POST['Stream4Stream129']."'; //Stream4Stream 129
\$MoviePlay131 = '".$_POST['MoviePlay131']."'; //MoviePlay 131
\$FunkPlay133 = '".$_POST['FunkPlay133']."'; //FunkPlay 133
\$FunkPlay142 = '".$_POST['FunkPlay142']."'; //FunkPlay 142
\$FunkPlay143 = '".$_POST['FunkPlay143']."'; //FunkPlay 143

//DATE TRIAL COUPON (day)
\$TrialDate = '".$_POST['datetrial']."';

//Default ID imdb
\$DefaultIDImdb = '".$_POST['defaultid']."';


?>";

//Create File
$CreateFile = file_put_contents("setting.php", $DataLP);
	if($CreateFile){
		Header('Location: install.php?act=success');
	}else{
		Header('Location: install.php');
	}
}

//URL Error
$urlErrors = 'http://www.google.com/';

include ('setting.php');

//GET IP
function get_ip(){
	if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
		$ip = $_SERVER['HTTP_CLIENT_IP'];
	}elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
		$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	}else{
		$ip = $_SERVER['REMOTE_ADDR'];
	}
	return $ip;
}

$CountryCode = file_get_contents('http://api.hostip.info/country.php?ip='.get_ip());

switch ($CountryCode) {
	//MEGAFLIX 139
    case "FR":
        $aff_link = $MegaFlix139;
        break;
    case "SE":
        $aff_link = $MegaFlix139;
        break;
	//MEGAFLIX 44
    case "US":
        $aff_link = $MegaFlix44;
        break;
    case "UK":
        $aff_link = $MegaFlix44;
        break;
    case "DE":
        $aff_link = $MegaFlix44;
        break;
    case "ES":
        $aff_link = $MegaFlix44;
        break;
    case "IT":
        $aff_link = $MegaFlix44;
        break;
    case "CA":
        $aff_link = $MegaFlix44;
        break;
	//PushPlay 116
    case "AU":
        $aff_link = $PushPlay116;
        break;
	//Stream4Stream 129
    case "AT":
        $aff_link = $Stream4Stream129;
        break;
    case "BG":
        $aff_link = $Stream4Stream129;
        break;
    case "CZ":
        $aff_link = $Stream4Stream129;
        break;
    case "GR":
        $aff_link = $Stream4Stream129;
        break;
    case "NL":
        $aff_link = $Stream4Stream129;
        break;
    case "PL":
        $aff_link = $Stream4Stream129;
        break;
    case "PT":
        $aff_link = $Stream4Stream129;
        break;
    case "RO":
        $aff_link = $Stream4Stream129;
        break;
	//MoviePlay 131
    case "CH":
        $aff_link = $MoviePlay131;
        break;
    case "LU":
        $aff_link = $Stream4Stream129;
        break;
	//FunkPlay 133
    case "BE":
        $aff_link = $FunkPlay133;
        break;
    case "DK":
        $aff_link = $FunkPlay133;
        break;
    case "FI":
        $aff_link = $FunkPlay133;
        break;
    case "NO":
        $aff_link = $FunkPlay133;
        break;
	//FunkPlay 142
    case "KW":
        $aff_link = $FunkPlay142;
        break;
    case "TR":
        $aff_link = $FunkPlay142;
        break;
    case "AE":
        $aff_link = $FunkPlay142;
        break;
    case "NZ":
        $aff_link = $FunkPlay142;
        break;
    case "IE":
        $aff_link = $FunkPlay142;
        break;
	//FunkPlay 144
    case "JP":
        $aff_link = $FunkPlay144;
        break;
    case "TT":
        $aff_link = $FunkPlay144;
        break;
    case "LU":
        $aff_link = $FunkPlay144;
        break;
    case "NL":
        $aff_link = $FunkPlay144;
        break;
    case "CH":
        $aff_link = $FunkPlay144;
        break;
    default:
        $aff_link = $MegaFlix139;
}

//FREE TRIAL DATE
$DateTrial = date('M d, Y', strtotime(''.$TrialDate.' days', strtotime(date('M d, Y'))));

/*function FilterUrl($url=""){
	$parts = parse_url($url);
	if($parts['host']==$Domain){
		return true;
	}else{
		return false;
	}
}*/
//LINK VALID AFF
$LinkValid = array('tv.aff-id.com','go.vid-id.org','stream.aff-id.com','play.aff-id.com','watch.aff-id.com');

$LinkMegaFlix139 = explode('/',$MegaFlix139);
$LinkMegaFlix44 = explode('/',$MegaFlix44);
$LinkPushPlay116 = explode('/',$PushPlay116);
$LinkStream4Stream129 = explode('/',$Stream4Stream129);
$LinkMoviePlay131 = explode('/',$MoviePlay131);
$LinkFunkPlay133 = explode('/',$FunkPlay133);
$LinkFunkPlay142 = explode('/',$FunkPlay142);
$LinkFunkPlay143 = explode('/',$FunkPlay143);

if(!in_array($LinkMegaFlix139[2],$LinkValid)) {
	header('Location: '.$urlErrors);
}elseif(!in_array($LinkMegaFlix44[2],$LinkValid)){
	header('Location: '.$urlErrors);	
}elseif(!in_array($LinkPushPlay116[2],$LinkValid)){
	header('Location: '.$urlErrors);	
}elseif(!in_array($LinkStream4Stream129[2],$LinkValid)){
	header('Location: '.$urlErrors);	
}elseif(!in_array($LinkMoviePlay131[2],$LinkValid)){
	header('Location: '.$urlErrors);
}elseif(!in_array($LinkFunkPlay133[2],$LinkValid)){
	header('Location: '.$urlErrors);
}elseif(!in_array($LinkFunkPlay142[2],$LinkValid)){
	header('Location: '.$urlErrors);
}elseif(!in_array($LinkFunkPlay143[2],$LinkValid)){
	header('Location: '.$urlErrors);
}

//GET ID
if(!isset($_GET['id'])){
	if($DefaultIDImdb == FALSE){
		$imdbID = '1502712';
	}else{
		$imdbID = $DefaultIDImdb;
	}
}else{
	$imdbID = $_GET['id'];
}

//MOVIE
$Content = json_decode(file_get_contents('http://idmovapi.com/'.$imdbID), true);

	$IDimdb = $Content['ID IMDB'];
	$Title = $Content['TITLE'];
	$Poster = $Content['POSTER'];
	$Genre = $Content['GENRE'];
	$Director = $Content['DIRECTOR'];
	$Star = $Content['STAR'];
	$Description = $Content['DESCRIPTION'];
	$Country = $Content['COUNTRY'];
	$Language = $Content['LANGUAGE'];
	$Release = $Content['RELEASE DATE'];
	$Runtime = $Content['RUNTIME'];
	$Backdrop = $Content['BACKDROP'];
	$Trailer = $Content['TRAILER'];
	
//TOP MOVIE
$XGenre = explode("&#44; ", $Content['GENRE']);
$GenreMovie = $XGenre[0];
$GenreRandom = json_decode(file_get_contents('http://idmovapi.com/genre/'.$GenreMovie.'/random'), true);
 // echo "<pre>";
 // print_r($GenreRandom);
 // echo "</pre>";
	if($GenreRandom['total movie'] < 10){
		$CountTopMovie = $GenreRandom['total movie'];
	}else{
		$CountTopMovie = 10;
	}
	for($tm=0;$tm<$CountTopMovie;$tm++){
		$TopMovieID[$tm] = $GenreRandom['movie list'][$tm]['ID IMDB'];
		$TopMovieTitle[$tm] = $GenreRandom['movie list'][$tm]['TITLE'];
		$TopBackdrop[$tm] = $GenreRandom['movie list'][$tm]['POSTER'];
		$TopDesc[$tm] = $GenreRandom['movie list'][$tm]['DESCRIPTION'];
	}

?>