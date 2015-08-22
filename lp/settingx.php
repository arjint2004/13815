<?php
$mid=$_GET['movie'];
$url_1      = 'http://go.vid-id.org/?a=1020&s=ryo&source='.$mid.'';
$url_2      = 'http://go.vid-id.org/?a=1020&s=ryo&source='.$mid.'';
$url_3      = 'http://go.vid-id.org/?a=1020&s=ryo&source='.$mid.'';
$url_4      = 'http://go.vid-id.org/?a=1020&s=ryo&source='.$mid.'';

$url_domain = 'http://streamhdfilms.com';
$site_name    = 'Streamhdfilms'; // Nama Situs Movie atau Akun YouTube dll. 
$site_description = 'Watch or Download Full Movie Streaming';

function get_ip()
{
if (!empty($_SERVER['HTTP_CLIENT_IP'])) //check ip from share internet
{
$ip=$_SERVER['HTTP_CLIENT_IP'];
}
elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) //to check ip is pass from proxy
{
$ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
}
else
{
$ip=$_SERVER['REMOTE_ADDR'];
}
return $ip;
}
$countrycode = file_get_contents('http://labs.stoodioo.com/geoip/country.php?ip='.get_ip());

switch ($countrycode) {
        case "GB":
                $aff_link = $url_1;
                break;
        case "US":
                $aff_link =  $url_2;
                break;
        case "CA":
                $aff_link =  $url_1;
                break;
        case "DE":
                $aff_link =  $url_1;
                break;
        case "FR":
                $aff_link =  $url_1;
                break;
        case "ES":
                $aff_link =  $url_1;
                break;
        case "AU":
                $aff_link =  $url_3;
        case "CH":
                $aff_link =  $url_3;
                break;
	case "ID":
		$aff_link = $url_3;
		break;
        default:
		$aff_link =  $url_3;
}

?>