<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <link href='http://fonts.googleapis.com/css?family=Press Start 2P' rel='stylesheet' type='text/css'>
  <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
  <link rel="icon" href="/favicon.ico" type="image/x-icon">
  <title>Audial&copy;</title>
	<!-- Import jQuery -->
  <script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
  <script><?php header('Access-Control-Allow-Origin: *'); ?></script>
  <style>
	<?php include 'style.php';?>
	hr{border-color: #000;}
  </style>
  <script src="http://connect.soundcloud.com/sdk.js"></script>
  <script>
	"use strict";
	
	(function(){var count = 0;
	// Currently does nothing
	function launchIntoFullscreen(element) {
	  if(element.requestFullscreen) {
		element.requestFullscreen();
	  } else if(element.mozRequestFullScreen) {
		element.mozRequestFullScreen();
	  } else if(element.webkitRequestFullscreen) {
		element.webkitRequestFullscreen();
	  } else if(element.msRequestFullscreen) {
		element.msRequestFullscreen();
	  }
	}
	SC.initialize({ // Initializes a Soundcloud object (to be used later)
  	  client_id: "fb069dd353f50db8f88345486468990f"
    });
	
	// uses php to set the mode of the page and determine the API being used
	var mode = "<?php 
		if(array_key_exists('mode',$_GET)){
			$mode = $_GET['mode'];
		}
		else{
			$mode = "music";
		}
		echo $mode;
	?>"+"_query";
	var user = {logged_in: false}
	var playlist = [];
	var main_img_src = "";
	// SoundCloud
	var old_key = {};
	var clientIDAppend = "fb069dd353f50db8f88345486468990f";
	var SCfindSoundsByQuery="http://api.soundcloud.com/search/sounds?filter=streamable&client_id=" + clientIDAppend; // append &q= /queryterm/
	
	// Freesound.org
	var SFX_ID = "dc74d4a10105d90232d376895a08917f61833419";
	var FindSFX= "http://www.freesound.org/apiv2/search/text/?format=json&token=" + SFX_ID; // append &q= /queryterm/
	var Find1 = "http://www.freesound.org/apiv2/sounds/";
	
	var results = [];
	var query = "";
	var RETURN_KEY = 13;
	$("#topSection").hide();
	window.onload = init;
	
	function doKeyup(e){
		if(e.keyCode == RETURN_KEY){
			results = [];
			if(mode=="music_query")
				doSearchSC();
			else
			{
				count = 0;
				doSearchFreeSound();			
			}
			saveLastSearch();
			// doSearchSpotify();			
		}
		return false;
	}
	
	function addToPlaylist(obj){
		// not yet implemented
	}
	
	function refreshPlaylist(){
		// not yet implemented
	}
	
	function doSearchFreeSound(){ // searches freesound's database of SFX by keywords
		// build up our URL string	
		try{
			var url = (mode=="sfx_query")? FindSFX: "null";
			
			// get value of form field
			var value = document.querySelector("#searchterm").value;
			
			old_key.search_term = value;
			// get rid of any leading and trailing spaces
			value = value.trim();
			value = value.split(" ");
			value = value.join(",");
			
			// if there's no band to search then bail out of the function (return does this)
			if(value.length < 1) return;
			document.querySelector("#dynamicContent").innerHTML = "<b>Searching for " + value + "</b>";
			
			// replace spaces the user typed in the middle of the term with %20
			// %20 is the hexadecimal value for a space
			value = encodeURI(value); 
			
			// finally, add the artist name to the end of the string
			url += "&query=" + value;	
			
			var count = document.querySelector("#limit").value;
			// get rid of any leading and trailing spaces
			count = count.trim();
			old_key.count = count;
			// if there's no band to search then bail out of the function (return does this)
			if(count.length < 1 || count == 0){ alert("PLEASE GIVE A NUMBER OF RESULTS DESIRED GREATER THAN 0!"); return;}
			url += "&limit="+count;	
			// call the web service, and download the file
			$("#dynamicContent").fadeOut(250);
			
			$.getJSON(url).done(function(data){eventFSJSONLoaded(data);});
		}
		catch(error){
			return;
		}
	}

	function save() { // meant to save playlists serialized as JSON into the local storage in the browser
		if (!supportsLocalStorage()) { return false; }
		else{
			localStorage["playlist"] = JSON.stringify(playlist);
		}
		return true;
	}
	
	function saveLastSearch() { // meant to save playlists serialized as JSON into the local storage in the browser
		if (!supportsLocalStorage()) { return false; }
		else{
			localStorage["AudialLastSearch"+mode] = JSON.stringify(old_key);
		}
		return true;
	}

	// checks to make sure the browser supports localStorage 
	function supportsLocalStorage() {
	  try {
		return 'localStorage' in window && window['localStorage'] !== null;
	  } catch (e) {
		return false;
	  }
	}

	function load() { // meant to load playlists serialized as JSON from the local storage in the browser
		if (!supportsLocalStorage()) { return []; }
		if(!localStorage["playlist"]){
			return [];
		}
		return JSON.parse(localStorage["playlist"]);
	}
	
	function checkForExistingSearches() { // meant to load playlists serialized as JSON from the local storage in the browser
		if (!supportsLocalStorage()) { return []; }
		if(!localStorage["AudialLastSearch"+mode]){
			return;
		}
		old_key = JSON.parse(localStorage["AudialLastSearch"+mode]);
		document.querySelector("#searchterm").value = old_key.search_term;
		document.querySelector("#limit").value = old_key.count;
		doKeyup(RETURN_KEY);
	}
	
	function init(){
		document.querySelector("#searchterm").onkeyup = doKeyup;
		document.querySelector("#limit").onkeyup = doKeyup;
		playlist = load();
		$("#topSection").delay(500).slideDown("slow").animate({opacity:1.0}).delay(2000).slideUp("slow");
		
		checkForExistingSearches();
	}
	
	// searches soundcloud for music based on a query
	function doSearchSC(){
		// build up our URL string	
		try{
			var url = (mode=="music_query")? SCfindSoundsByQuery: "null";
			
			// get value of form field
			var value = document.querySelector("#searchterm").value;
			// get rid of any leading and trailing spaces
			value = value.trim();
			value = value.split(" ");
			value = value.join(",");
			old_key.search_term = value;
			// if there's no band to search then bail out of the function (return does this)
			if(value.length < 1) return;
			
			document.querySelector("#dynamicContent").innerHTML = "<b>Searching for " + value + "</b>";
			
			// replace spaces the user typed in the middle of the term with %20
			// %20 is the hexadecimal value for a space
			value = encodeURI(value); 
			
			// finally, add the artist name to the end of the string
			url += "&q=" + value;	
			
			var count = document.querySelector("#limit").value;
			// get rid of any leading and trailing spaces
			count = count.trim();
			old_key.count = count;
			// if there's no band to search then bail out of the function (return does this)
			if(count.length < 1 || count == 0){ alert("PLEASE GIVE A NUMBER OF RESULTS DESIRED GREATER THAN 0!"); return;}
			url += "&limit="+count;	
			// call the web service, and download the file
			$("#dynamicContent").fadeOut(250);
			
			$.getJSON(url).done(function(data){eventSCJSONLoaded(data);});
		}
		catch(error){
			return;
		}
	}
	
	// responds on soundcloud result load
	function eventSCJSONLoaded(obj){
		
		if(obj.error){ // this catches a bad API key, missing parameter, etc...
			var message = obj.message;
			document.querySelector("#dynamicContent").innerHTML = "<b>Error: " + message + "</b>";
			//$("#dynamicContent").fadeIn(1000);
			return; // bail out
		}
		
		if (obj.collection && obj.collection.total_results == 0){ // if no events are found
			document.querySelector("#dynamicContent").innerHTML = "<p>No events found</p>";
			//$("#dynamicContent").fadeIn(1000);
			return; // bail out
		}
		
		// otherwise, start parsing!
		var total = obj.collection.total_results;
		
		var allTracks = obj.collection;
		
		if (!(allTracks instanceof Array)){
			allTracks = [allTracks]; // put the object in an array
		}
		for (var i=0;i<allTracks.length;i++)
		{
			var line = "";
			// get a bunch of values
			var track = allTracks[i];
			var title = track.title;
			title = title.trim();
			var artist = track.user.username;
			var trackLink = track.permalink_url;
			var artistLink = track.user.permalink_url;
			var img = track.artwork_url||track.user.avatar_url;
					
			// do a bunch of concatenation	
			//IMAGE
			line+= "<tr class='norm row'><td><img class='result_image' src='" + img + "' alt='"+title+"'/></td>";
			
			//Link to Track and Track Name w/ Audio
			line+= "<td>";
			line+="<table width='100%' height='100%' class='embed'>"
			line+="<tr>";
			line+="<td style='text-align:center; width: 100%;'>"
			line+="<a href='"+trackLink+"'>" +  title + "</a>"
			line+="</td>";
			line+="</tr>";
			line+="<tr><td><audio class='norm' src='"+track.stream_url+"?client_id="+clientIDAppend+"' controls>NO HTML5 AUDIO SUPPORT</audio></td></tr>";
			line+="</table>";
			line+="</td>";
			
			//Link to Artist and Artist Name
			line+= "<td><p><a href='"+artistLink+"'>"+artist+ "</a></p></td></tr>";
			
			results.push({
				html:line
			});
		}	
		displayResults();
	}		
		
	// responds on freesound, sound result load
	function eventFSJSONLoaded(obj){
		results=[];
		// console.log("obj = " +obj);
		// console.log("obj stringified = " + JSON.stringify(obj));

		if (obj.results && obj.results == 0){ // if no events are found
			document.querySelector("#dynamicContent").innerHTML = "<p>No events found</p>";
			//$("#dynamicContent").fadeIn(1000);
			return; // bail out
		}
		
		// otherwise, start parsing!
		var total = obj.results.length;
		var allTracks = obj.results;
		// console.log("allTracks.length = " + allTracks.length);
		
		if (!(allTracks instanceof Array)){
			allTracks = [allTracks]; // put the object in an array
		}
		count = total;
		// console.log(count);
		for (var i=0;i<allTracks.length;i++)
		{
			// build up our URL string	
			try{
				var url = Find1+allTracks[i].id+"/?format=json&token="+SFX_ID;
				$.getJSON(url).done(function(data){
					eventSFXJSONLoaded(data); 
				});
			}
			catch(error){
				continue;
			}
		}	
		
		if(count == 0){
			displayResults();
		}
	}
	
	// responds on load of freesound sfx itself
	function eventSFXJSONLoaded(obj){
		// console.log("obj stringified = " + JSON.stringify(obj));
		
		count=count-1;
		// console.log(count);
		if (obj.results && obj.results == 0){ // if no events are found
			document.querySelector("#dynamicContent").innerHTML = "<p>No SFX found</p>";
			//$("#dynamicContent").fadeIn(1000);
			return; // bail out
		}
		
		var line = "";
		// get a bunch of values
		var track = obj;
		var title = track.name;
		title = title.trim();
		// console.log(title);
		var artist = track.username;
		var trackLink = track.url;
		// var artistLink = track.;
		var img = track.images.waveform_l;
		
		var musicLink;
		// console.log(track.previews['preview-lq-mp3']);
		try{
			musicLink = track.previews['preview-hq-mp3'];
		}
		catch(e){
		    musicLink = track.previews['preview-lq-mp3'];
		}
			
		var audio = "<audio style='background-color: #0B3E52;' src='"+musicLink+"' controls>NO HTML5 AUDIO SUPPORT</audio>";
		
		// do a bunch of concatenation	
		line+= "<img class='image' src='" + img + "' alt='"+title+"'/>";
		line+= "<section class='text' style='text-align:center; width: 100%;'><h2 class='title' style='text-align:center; width: 100%;'><a href='"+trackLink+"'>" +  title + "</a><h2>";
		line+= "<h4 class='data-b'>"+artist+"</h4>";
		line+=audio+"</section>";
		results.push({
			html:"<section class='item'><div class='overlay'></div>"+line+"</section>"
		});

		if(count <= 0){
			displayResults();
		}
	}
	
	// pushes current list of results to the results section of the page
	function displayResults(){
		// update our UI
		var items = "";
		// console.log("5");
		if(results.length==0)
			items = "<p>NO RESULTS</p>";
		// results = shuffle(results);
		items= "<table class='table'>";
		for(var i = 0; i< results.length; i++){
			items += results[i].html;
		}
		items+= "</table>";
		if(results.length==0)
			items = "<p>NO RESULTS</p>";
		document.querySelector("#dynamicContent").innerHTML = items;
		$("#dynamicContent").fadeIn(500);
	}
	
	// mixes up the results for randomness purposes so the result isn't always the same
	function shuffle(array) {
	  var currentIndex = array.length, temporaryValue, randomIndex ;

	  // While there remain elements to shuffle...
	  while (0 != currentIndex) {

		// Pick a remaining element...
		randomIndex = Math.floor(Math.random() * currentIndex);
		currentIndex -= 1;

		// And swap it with the current element.
		temporaryValue = array[currentIndex];
		array[currentIndex] = array[randomIndex];
		array[randomIndex] = temporaryValue;
	  }

	  return array;
	}})();
  </script>
</head>
<body style="margin: 0px;" class="norm">
<a href='index.php' style='height: 24px; padding: 0px; margin: 0px;'><section style='background-color:rgb(51,153,153); left: 0px; top: 0px; float: left; height: 20px; width: margin: 0 auto; padding: 0px; width: 100%'><?php
		if(array_key_exists('mode',$_GET)){
			$mode = $_GET['mode'];
			
			if($mode!="music"){
				if($mode!="sfx"){
					$mode = "music";
				}
			}
		}
		else{
			$mode = "music";
		}
		
		echo "<p style='margin: 0 auto; background-color:rgb(51,153,153); font-size:".'12px !important'." display: inline-block; ; color:#6CC; float: left; vertical-align: middle;'> <img src='reverse.png' width='auto' height='20px' style=''> <p style=' display: inline-block; vertical-align: middle; position: absolute; top: -17px; left: 32px;'>Mode:  ".$mode."</p></p>";
?></section></a>
<div id="content">
	<div id="topContainer">
		<br>
		<section id="hero_image" width='100%'>
		</section>
		<section id="topSection">
			<h1 class='desc norm'>Where Your Audio Lives</h2>
			<hr/>
			<br/>
		</section>
	</div>
	<div id="user"> 
	</div>
	<section id="input">
		<p class='desc norm' style="font-size:36px; margin-bottom: 0px;">ENTER KEYWORD</p>
		<input id="searchterm" type="text" size="30" maxlength="50" value="Argzero" class="norm" style="text-align: center; display: inline; max-width: 480px;" autofocus x-webkit-speech/> 
		<br/>
		<p class='desc norm'>Enter The Number of Desired Results</p>
		<input id="limit" type="text" class="typed norm" size="20" maxlength="3" value="15" style="text-align: center; display: inline; max-width: 480px;" autofocus x-webkit-speech/> 
	</section>
	<section id="RESULTS">
		<h2 id="ResultHeader" style="color:rgb(132,234,234);">Results</h2>
		
		<div id="dynamicContent">
			<p style="color:#fff;">No data yet!</p>
		</div>
	</section>
</div>
<div id="botFloat">
	
</div>
</body>
</html>
