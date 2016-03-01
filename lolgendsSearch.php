<!--
	Rosa Tung
	get information from the database
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
		<legend class="topLabel"> Queries for the Database </legend> <br><br>
		<div class="button"><a href="lolgendsMain.php">Return To Main Page</a></div> <br><br> <!--go back to homescreen-->
		<div><label>Champion Demographics</label></div>
			<div class="button"><a href="searchChampFactions.php">Champion-Faction Details</a></div> <br> <!--champ tally per faction, champions grouped by factions-->
			<div class="button"><a href="searchChampRaces.php">Champion-Race Details</a></div> <br> <!--champ tally per race, champions grouped by race-->
		<div><label>Champions that are...</label></div>
			<div class="button"><a href="searchRelated.php">Related</a></div> <br> <!--champions that are related-->
			<div class="button"><a href="searchRomantic.php">Romantically Involved</a></div> <br> <!--champions in relationships-->	
			<div class="button"><a href="searchRivals.php">Rivals</a></div> <br> <!--champions that don't like each other-->
			<div class="button"><a href="searchAllies.php">Allies</a></div> <br> <!--champions that like each other-->		
			<div class="button"><a href="searchRelatedRivals.php">Related but Rivals</a></div> <br> <!--champions that are related but don't like each other-->
		<div><label >General</label></div>
		<div> <!--Champion Details-->
			<form method="get" action="searchChampion.php"> 
				<fieldset> <legend>Display Champion Details</legend>
						<fieldset> <legend>Champion</legend>
							<select name="champName">
								<?php
									if(!($stmt = $mysqli->prepare(	"SELECT lol_champions.champion_id, lol_champions.name 
																	FROM lol_champions"
																	))){
										echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
									}

									if(!$stmt->execute()){
										echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
									}
									if(!$stmt->bind_result($id, $pname)){
										echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
									}
									while($stmt->fetch()){
									 echo '<option value=" '. $id . ' "> ' . $pname . '</option>\n';
									}
									$stmt->close();
								?>
							</select>
						</fieldset>
						&nbsp <input type="submit" name="search" value="search champion" />
				</fieldset>
			</form>
		</div> <br>
		<div> <!--Champion Occupation-->
			<form method="get" action="searchOccupation.php"> 
				<fieldset> <legend>Search for Occupation</legend>
						<fieldset>
							<p>Search: <input type="text" name="occupation" /></p>
						</fieldset>
						&nbsp <input type="submit" name="search" value="search jobs" />
				</fieldset>
			</form>
		</div> <br>
	</body>
</html>







