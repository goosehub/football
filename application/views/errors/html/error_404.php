<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>404 Page Not Found</title>
<style type="text/css">

::selection { background-color: #E13300; color: white; }
::-moz-selection { background-color: #E13300; color: white; }

body {
	background-color: #fff;
	margin: 40px;
	font: 13px/20px normal Helvetica, Arial, sans-serif;
	color: #4F5155;
}

a {
	color: #003399;
	background-color: transparent;
	font-weight: normal;
}

h1 {
	color: #444;
	background-color: transparent;
	border-bottom: 1px solid #D0D0D0;
	font-size: 19px;
	font-weight: normal;
	margin: 0 0 14px 0;
	padding: 14px 15px 10px 15px;
}

code {
	font-family: Consolas, Monaco, Courier New, Courier, monospace;
	font-size: 12px;
	background-color: #f9f9f9;
	border: 1px solid #D0D0D0;
	color: #002166;
	display: block;
	margin: 14px 0 14px 0;
	padding: 12px 10px 12px 10px;
}

#container {
	margin: 10px;
	border: 1px solid #D0D0D0;
	box-shadow: 0 0 8px #D0D0D0;
}

p {
	margin: 12px 15px 12px 15px;
}
</style>
</head>
<body>
	<div id="container">
		<h1><?php echo $heading; ?></h1>
		<?php echo $message; ?>
		<p><strong>Please email goosepostbox@gmail.com with information on this problem</strong></p>
		<p><a href="#" onclick="history.back();">Return to last page</a></p>

		<?php
		// Shhhh
		$easter_egg = array(
		    'Dude, where\'s my page',
		    'This is not the page you\'re looking for',
		    'Where\'s the page Lebowski? Where\'s the page?'
		    ); 
		shuffle($easter_egg);
		?>
		<style>
			blockquote {
			  background: #f9f9f9;
			  border-left: 10px solid #ccc;
			  margin: 1.5em 10px;
			  padding: 0.5em 10px;
			  quotes: "\201C""\201D""\2018""\2019";
			}
			blockquote:before {
			  color: #ccc;
			  content: open-quote;
			  font-size: 4em;
			  line-height: 0.1em;
			  margin-right: 0.25em;
			  vertical-align: -0.4em;
			}
			blockquote p {
			  display: inline;
			}
		</style>
		<blockquote><?php echo $easter_egg[0]; ?>...</blockquote>
	</div>
</body>
</html>