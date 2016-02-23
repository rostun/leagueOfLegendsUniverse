<!--
	Rosa Tung
	CS 340
	Final Project
	lolgendsMain.php
-->

<?php
	ini_set('display_errors', 'On'); //Turn on error reporting
	//Connect to the database
	$mysqli = new mysqli("oniddb.cws.oregonstate.edu","tungr-db","6cBDKtK64QENNcPP","tungr-db");
	if($mysqli->connect_errno){
		echo "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<title>LOLGENDS</title>
		<meta charset="utf-8"/>
		<link rel="stylesheet" type="text/css" href="style.css" />
	</head>
	<body>
		<legend class="topLabel"> Explore the Lolgends Universe</legend>
		<label >Look Up Champion:</label>
		<table>
			<thead>
				<tr>
					<th> Champion </th>
					<th> Gender </th>
					<th> Race </th>
					<th> Origin(Nation/Faction, Region) </th>
					<th> Date Released </th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<th> Kennen </th>
					<td> M </td>
					<td> Yordle </td> 
					<td> Bandle City, Ruddynip Valley </td> 
					<td> 2010-04-08 </td>
				</tr>
			</tbody>
		</table>
	</body>
</html>




