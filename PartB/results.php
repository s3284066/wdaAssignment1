<!DOCTYPE html>
<html>
<head>
<title>Results for Winestore:</title>
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
//Always a Value for years
				$sql .= " AND year BETWEEN '" . $min_year . "' AND '" . $max_year . "'";
			if(!empty($min_stock))
			{
				$sql .= " AND on_hand <= '" . $min_stock . "'";
			}
			if(!empty($min_ordered))
			{
				$sql .= " AND qty <= " . $min_ordered . "'";
			}		 
			if(!empty($min_price) && !empty($max_price))
			{
				$sql .= " AND price BETWEEN '" . $min_price. "' AND '" . $max_price . "'";
			}
			else if(!empty($min_price) && empty($max_price)){
				$sql .= " AND price >= " . $min_price;
			}
			else if(empty($min_price) && !empty($max_price)){
				$sql .= " AND price <= '" . $max_price . "'";
			}	
			//Group duplicates
			$sql .= " GROUP BY wine.wine_id;";		
			//Includes db.php with all connection attributes defined
			require_once('db.php');
			//Connects to connection with db.php variables
			if (!($connection = mysql_connect(DB_HOST, DB_USER, DB_PW))){
					die("Could not connect");
			}	
			//Selects required Database
			mysql_select_db(DB_NAME, $connection);
			//Run the query	
			$query_result = mysql_query($sql,$connection);
			//Count Rows Found
			$resultRows = mysql_num_rows($query_result);
			//If rows returned is greater then 0 then create and display a table
			if($resultRows > 0){
				print "<table width='1000px' border='1'><tr><th>Wine Name</th><th>Variety</th><th>Year</th><th>Winery</th><th>Region</th><th>Oh Hand</th><th>Quantity</th><th>Price</th><th>Revenue</th></tr>";
//While loop to fetch the data
				while($rows = mysql_fetch_array($query_result)) {
						print "<tr>"; 
						print "<td>" . $rows['wine_name'] . "</td>";
						print "<td>" . $rows['variety'] . "</td>";
						print "<td>" . $rows['year'] . "</td>";	
						print "<td>" . $rows['winery_name'] . "</td>";		
						print "<td>" . $rows['region_name'] . "</td>";		
						print "<td>" . $rows['on_hand'] . "</td>";		
						print "<td>" . $rows['qty'] . "</td>";
						print "<td>$" . $rows['price'] . "</td>";			
						print "<td>$" . $rows['maths'] . "</td>";		
						print "</tr>";
				}
				print "</table>";
				print "<br />Returned " . $resultRows . " Rows";
			}
			else{
				print "<br />No Rows Found!";
			}
			mysql_close($connection);
		}
	?>
	</div>				
</div>
</body>
</html>
