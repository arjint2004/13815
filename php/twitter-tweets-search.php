<?php
session_start();
require_once("twitteroauth.php"); //Path to twitteroauth library
 
$twitteruser = "GeneralPants_"; 
$search = "generalpants"; //, newseason, gpfashionkilla
$notweets = 5;
$consumerkey = "o1L6iWxtx6WPVFIgZnNAsQ";
$consumersecret = "VYf1uTFmJe9EDWQZIDrEiyLf59tnbd3sDiBqXa8bss";
$accesstoken = "81121579-Cd8JIOWHcGdjXV77HOGViMLhiiSzAY7BPwk3ajbHi";
$accesstokensecret = "0tNpQ7IpfHc6uq1oJPNBwQisr7MWDCwBZBJSiu1NqIk";
 
/*
Consumer key	o1L6iWxtx6WPVFIgZnNAsQ
Consumer secret	VYf1uTFmJe9EDWQZIDrEiyLf59tnbd3sDiBqXa8bss
Access token	81121579-Cd8JIOWHcGdjXV77HOGViMLhiiSzAY7BPwk3ajbHi
Access token secret	0tNpQ7IpfHc6uq1oJPNBwQisr7MWDCwBZBJSiu1NqIk
 */ 
function getConnectionWithAccessToken($cons_key, $cons_secret, $oauth_token, $oauth_token_secret) {
  $connection = new TwitterOAuth($cons_key, $cons_secret, $oauth_token, $oauth_token_secret);
  return $connection;
}
   
$connection = getConnectionWithAccessToken($consumerkey, $consumersecret, $accesstoken, $accesstokensecret);
  
$tweets = $connection->get("https://api.twitter.com/1.1/search/tweets.json?q=".$search."&count=".$notweets);
  
echo json_encode($tweets);
?>