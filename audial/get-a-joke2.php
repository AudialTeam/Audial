<?php
$jokes = array(
	array("q"=>"What do you call a very small valentine?","a"=>"A valen-tiny!"),
	array("q"=>"What did the dog say when he rubbed his tail on the sandpaper?","a"=>"Ruff, Ruff!"),
	array("q"=>"Why don't sharks like to eat clowns?","a"=>"Because they taste funny!"),
	array("q"=>"What did the boy cat say to the girl cat?","a"=>"You're Purr-fect!"),
	array("q"=>"What is a frog's favorite outdoor sport?","a"=>"Fly fishing!"),
	array("q"=>"What do you call a computer program that has a writing error?","a"=>"Pro Grammatically incorrect!")
);

$numJokes = count($jokes);
$randomJoke = $jokes[mt_rand(0,$numJokes-1)];
if(array_key_exists('callback',$_GET)){
	$string = "(".$_GET['callback'];
}

$string = json_encode($randomJoke);

if(array_key_exists('callback',$_GET)){
	$string.=")";
}

header('content-type:application/json');

echo $string;
?>