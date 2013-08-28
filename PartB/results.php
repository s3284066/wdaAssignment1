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
$sql = "SELECT wine_name, variety, year, winery_name, region_name, on_hand, qty, price, qty * price AS maths
				FROM wine, winery, wine_variety, grape_variety, region, inventory, items
				WHERE wine.winery_id = winery.winery_id AND grape_variety.variety_id = wine_variety.variety_id AND 
				winery.region_id = region.region_id AND wine.wine_id = items.wine_id AND wine_variety.wine_id = wine.wine_id AND wine.wine_id = inventory.wine_id";
		
		//Validation Methods
		//Check each numeric field: If a number has been entered
if(!empty($min_stock) && !is_numeric($min_stock) || !empty($min_ordered) && !is_numeric($min_ordered) 
		|| !empty($min_price) && !is_numeric($min_price) || !empty($max_price) && !is_numeric($max_price))
		{
			print "Non Numeric character Entered to numeric field";
		}
		//Check if Min year is greater then max year
		else if($min_year > $max_year || !empty($min_price) && !empty($max_price) && $min_price > $max_price){
			print "Minimum Year Greater then Maximum or Min Price greater then max price";
		}
		//No Errors Run the query
		else{
			//Conditional Statements to construct the sql query
			if(!empty($wine_name)){
				$sql .= " AND wine_name LIKE '%" . $wine_name . "%'";
			}
			if(!empty($winery_name)){
				$sql .= " AND winery_name LIKE '%" . $winery_name . "%'";
			}
			if($region_name != 'All'){
				$sql .= " AND region_name = '" . $region_name . "'";
			}
			if($grape_variety != 'All')
			{
				$sql .= " AND variety = '" . $grape_variety . "'";
			}
</div>
</body>
</html>
