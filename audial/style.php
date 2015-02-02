.overlay{
	position: absolute;
	z-index: 2;
	min-height: 50px;
	min-width: 50px;
	float: left;
}

.plus{
	
}

.minus{
	
}

html{
	background-color: <?php
			if(array_key_exists('mode',$_GET)){
				$mode = $_GET['mode'];
			}
			else{
				$mode = "music";
			}
			if($mode == "music"){
				echo "rgb(51,106,127)";
			}
			else
				echo "rgb(0,51,63)";
		?>;
}

button{
	float: top;
	text-align: center;
	width: 100%;
	height 50px;
	padding: 50px;
	background-color: rgb(0,51,63);
	opacity: 0.5;
}

@font-face {
	font-family: 'Norm';
	src: url('norm.otf');
}

*{
	text-align: center;
}

.norm{
	font-family: 'Norm';
}

#topSection{
	opacity: 0;
	z-index: 1;
	background-color: <?php
			if(array_key_exists('mode',$_GET)){
				$mode = $_GET['mode'];
			}
			else{
				$mode = "music";
			}
			if($mode == "music"){
				echo "rgb(51,106,127)";
			}
			else
				echo "rgb(0,51,63)";
		?>;
	width: 100%;
}

#input{
	width: 100%;
}

a, a:hover, a:visited, a:active{
	color: rgb(102,204,204);
	text-decoration: none;
}

input{
	color: rgb(102,204,204);
	width: 100%;
	height: 50px;
	padding-top: 25px;
	padding-bottom: 20px;
	font-size: 36px;
	box-shadow: inset 0 0 0 10px rgb(102,153,153);
	border: none;
	background: rgb(51,153,153);
}

.desc{
	color: rgb(102,153,153);
	letter-spacing: 1px;
}

.result_image{
	height: 100px !important;
	width: 100px !important;
}

#hero_image{
	height: 150px !important;
	display: block;
	background-color: <?php
			if(array_key_exists('mode',$_GET)){
				$mode = $_GET['mode'];
			}
			else{
				$mode = "music";
			}
			if($mode == "music"){
				echo "rgb(51,106,127)";
			}
			else
				echo "rgb(0,51,63)";
		?>;
	background-image: <?php
			if(array_key_exists('mode',$_GET)){
				$mode = $_GET['mode'];
			}
			else{
				$mode = "music";
			}
			if($mode == "music"){
				echo "url('0.png')";
			}
			else
				echo "url('0-2.png')";
		?>;
	background-size: contain;
	background-repeat: no-repeat;
	background-position: center;
}

#ResultHeader{
	color: rgb(132,234,234) !important;
	padding-bottom: 20px;
}

body>a>section>p{height: 20px !important;}

.table, th, td, tr{
	margin: 0 auto;
    vertical-align: middle;
    padding: 0px !important;
	color: #FFE8B0 !important;
}
.table > td{ height: 24px; width: 24px; 
	padding: 5px !important; 
	color: #FFE8B0 !important; vertical-align: middle; }
.table > tr{ height: 24px !important; font-size: 20px; 
	color: #FFE8B0 !important;}
tr:first{ width: 24px; }

.table {
	background-color: #AA422C;
	color: #FFE8B0 !important;
	padding: 5px !important;
}
.embed > tr { font-size: 12px; height: 12px; }
.embed > tr > td {	height: 12px !important; 
	color: #FFE8B0 !important;}
.embed > tr > td > audio { max-height: 12px !important; 
	color: #FFE8B0 !important; }

.row { background-color: #CA624C; margin: 10px; 
	color: #FFE8B0 !important;}
.table a { color: #FFE8B0 !important; vertical-align: middle !important; margin: 10px; }
.table audio { color: #FFE8B0 !important; vertical-align: middle !important; margin: 20px; }