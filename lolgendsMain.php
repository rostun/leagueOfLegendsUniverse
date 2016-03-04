<!--
	Rosa Tung
	Main Page
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
		<legend class="topLabel"> The Lolgends Lore Universe</legend> <br>
			<label> Search </label> <br>
				<div class="button"><a href="lolgendsSearch.php">Available Queries</a></div> <br> <!--go to search page-->
			<label> Contribute </label> <br>
				<div class="button"><a href="lolgendsAdd.php">Add to the Database</a></div> <br> <!--go to add page-->
			<label> Explore </label> <br>
				<div class="button"><a href="champions.php">See Champion List</a></div> <br> <!--go to general table-->
				<div class="button"><a href="regions.php">See Region List</a></div> <br> <!--go to regions table-->
				<div class="button"><a href="factions.php">See Faction/Nation List</a></div> <br> <!--go to factions table-->
				<div class="button"><a href="races.php">See Race List</a></div> <br> <!--go to races table-->
				<div class="button"><a href="occupations.php">See Occupations List</a></div> <br> <!--go to races table-->
				<div class="button"><a href="aliases.php">See Champion Aliases</a></div> <br> <!--go to general table-->
				<div class="button"><a href="champOccupations.php">See Champion Occupations</a></div> <br> <!--go to general table-->
				<div class="button"><a href="champAllegiances.php">See Champion Allegiances</a></div> <br> <!--go to general table-->
				<div class="button"><a href="champRelationships.php">See Champion Relationships</a></div> <br> <!--go to general table-->
	</body>
</html>




