<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <link href='http://fonts.googleapis.com/css?family=Press Start 2P' rel='stylesheet' type='text/css'>
  <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
  <link rel="icon" href="/favicon.ico" type="image/x-icon">
  <title>AudialTestApplication&trade;</title>
	<!-- Import jQuery -->
  <script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
  <?php header('Access-Control-Allow-Origin: *'); ?>
  <style>
	<?php include 'style.php';?>
	hr{border-color: #000;}
  </style>
  <script src="http://connect.soundcloud.com/sdk.js"></script>
  <script>
	"use strict";

	var RETURN_KEY = 13;
	$("#topSection").hide();
	window.onload = init;
	
	function init(){
		$("#topSection").delay(500).slideDown("slow").animate({opacity:1.0});
		$("#SFXBtn").click(function() {window.location.href = "audial.php?mode=sfx";});
		$("#MusicBtn").click(function() {window.location.href = "audial.php?mode=music";});
	}
  </script>
</head>
<body>
<div id="content">
	<div id="topContainer" style="">
		<section id="hero_image" width='100%'>
		</section>
		<section id="topSection">
			<h1 class='desc norm' style="">Where Your Audio Lives</h2>
			<h6 class='desc norm' style="">Your indispensable service for collection of your favorite artists and songs from all of your favorite sites!</h6>
			<br/>
			<p class='desc norm'> <a href='http://people.rit.edu/fzs7217/330/project2/audial/'>See the original design doc here!</a></p>
			<br/>
			<hr/>
			<br/>
		</section>
	</div>
	<button id="MusicBtn" class='norm' style="font-size: 36px; text-align: center; display: inline; max-width: 480px; padding-bottom: 30px; padding-top: 30px; border-color: #000;">Search for Songs!</button>
	<button id="SFXBtn" class='norm' style="font-size: 36px; text-align: center; display: inline; max-width: 480px; padding-bottom: 30px; padding-top: 30px; border-color: #000;">Search for Sound Effects!</button>
</div>
</body>
</html>
