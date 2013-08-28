<!DOCTYPE html>
<html>
<head>
<title>Search Results</title>
	<style type="text/css">
		body{
			font-family: Arial, Verdana, Sans-Serif;
			font-size: 13px;
		}
		h1{
			font-style: italic;
			text-align: center;
		}
		div#wrapper{
			margin:auto;
			width: 1000px;
		}
		div#results{
			padding: 5px;
			width: 1000px;
		}
	</style>
</head>
<body>
<div id="wrapper">
<h1>Search Results</h1>
<a href = "inputForm.php">Search Again</a>
	<div id="results">
<?php
		//Setting GET values
		//Trimmed Whitespace from text input: Reduces Error
		$wine_name = trim($_GET['wine_name']);
		$winery_name = trim($_GET['winery_name']);
		$region_name = $_GET['region_name'];
		$grape_variety = $_GET['grape_variety'];
		$min_year = $_GET['min_year'];
		$max_year = $_GET['max_year'];
		$min_stock = trim($_GET['min_stock']);
		$min_ordered = trim($_GET['min_ordered']);
		$min_price = trim($_GET['min_price']);
		$max_price = trim($_GET['max_price']);
</div>
</body>
</html>
