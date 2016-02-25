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
		<legend class="topLabel"> Explore the Lolgends Lore Universe</legend> <br>
			<label> Explore </label> <br>
				<div class="button"><a href="champions.php">See Champion List</a></div> <br> <!--go to general table-->
				<div class="button"><a href="regions.php">See Region List</a></div> <br> <!--go to regions table-->
				<div class="button"><a href="factions.php">See Faction/Nation List</a></div> <br> <!--go to factions table-->
				<div class="button"><a href="races.php">See Race List</a></div> <br> <!--go to races table-->
				<div class="button"><a href="occupations.php">See Occupations List</a></div> <br> <!--go to races table-->
				<div class="button"><a href="aliases.php">See Champion Aliases</a></div> <br> <!--go to general table-->
				<div class="button"><a href="champOccupations.php">See Champion Occupations</a></div> <br> <!--go to general table-->
				<div class="button"><a href="champAllegiances.php">See Champion Allegiances</a></div> <br> <!--go to general table-->
			<label> Contribute </label> <br>
				<div class="button"><a href="lolgendsAdd.php">Add to the Database</a></div> <br> <!--go back to add page-->
			<label> Update </label> <br>
				<div class="button"><a href="lolgendsUpdate.php">Alter the Database</a></div> <br> <!--go back to add page-->
			<label> Prune </label> <br>
				<div class="button"><a href="lolgendsDelete.php">Delete from the Database</a></div> <br> <!--go back to add page-->
	</body>
</html>




