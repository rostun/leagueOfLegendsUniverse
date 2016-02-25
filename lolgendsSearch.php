<!--
	Rosa Tung
	CS 340
	Final Project
	lolgendsAdd.php
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
		<div><label >General</label></div>
		<div class="button"><a href="searchChampFactions.php">Champion-Faction Details</a></div> <br><br> <!--champ tally per faction, champions grouped by factions-->
		<div class="button"><a href="searchChampRaces.php">Champion-Race Details</a></div> <br><br> <!--champ tally per faction, champions grouped by factions-->
		<div><label >By Champion</label></div>
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
	</body>
</html>







