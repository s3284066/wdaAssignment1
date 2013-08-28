<!DOCTYPE html> <html> <head>
	<title>Input Wine Form</title>
	<style type="text/css">
		body{
			font-family: Arial, Verdana, Sans-Serif;
			font-size: 13px;
		}
		h1{
			font-style: italic;
			margin-left: 270px;
		}
		div#wrapper{
			margin:auto;
			width: 500px;
		}
	</style> </head> <body>
	<div id = wrapper>
	<h1>Search Winestore:</h1>
<form action="results.php" method="GET">
		<table border="0">
		<tr><td>Wine Name:</td><td><input type = "text" name = 
"wine_name" /></td>
		<td>Winery Name:</td><td><input type = "text" name = 
"winery_name" /></td></tr>
		<tr><td>Region:</td><td>
		<!-- PHP FOR DROPDOWN BOXES -->

		<?php
		//Includes db.php with all connection attributes defined
		require_once('db.php');
		//Connects to connection with db.php variables
		$connection = mysql_connect(DB_HOST, DB_USER, DB_PW);
		//Selects required Database
		mysql_select_db(DB_NAME, $connection);
		//Sql Statement for the first dropdown box: regions.
		$sql = "SELECT region_name from region";
		//Execute Query
		$region_result = mysql_query($sql,$connection);
		//Create Dropdownbox
		print '<select name="region_name">';
		//Create While Loop for dropdown box
		while($row = mysql_fetch_array($region_result)){
		print	'<option value="'. $row['region_name'] .'">' 
.$row['region_name'] .'</option>';
		}		print '</select></td><td>Grape Variety:</td><td><select 
name="grape_variety"><option value="All">All</option>';
		//Sql Statement for second dropdown box: grape variety.
		$sql = "SELECT variety from grape_variety";
		$variety_result = mysql_query($sql,$connection);
		//Create While Loop for dropdown box
		while($row = mysql_fetch_array($variety_result)){
		print '<option value="'. $row['variety'] .'">' 
.$row['variety'] .'</option>';
		}
		print '</select></td></tr><tr><td>Min 
Year:</td><td><select name="min_year">';
		//Sql Statement for third dropdown box: Min Year
		$sql = "SELECT year AS min_year FROM wine GROUP BY 
year";
		$min_result = mysql_query($sql,$connection);
		while($row = mysql_fetch_array($min_result)){
		print	'<option value="'. $row['min_year'] .'">' 
.$row['min_year'] .'</option>';
		}
		print '</select></td><td>Max Year:</td><td><select 
name="max_year">';
		//Sql Statement for last dropdown box: Max Year
		$sql = "SELECT year AS max_year FROM wine GROUP BY 
year";
		$max_result = mysql_query($sql,$connection);
		while($row = mysql_fetch_array($max_result)){
		print	'<option value="'. $row['max_year'] .'">' 
.$row['max_year'] .'</option>';
		}		
		print '</select></td></tr>';
		mysql_close($connection);
		?>
</div> </body> </html>
