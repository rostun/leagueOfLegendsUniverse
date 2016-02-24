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
		<div class="button"><a href="champions.php">See Champion List</a></div> <br> <!--go to general table-->
		<div> <!--ADD CHAMPION-->
			<form method="post" action="addChampion.php"> 
				<fieldset> <legend>Add Champion</legend>
						<fieldset>
							<p>Name: <input type="text" name="champName" /></p>
						</fieldset>
						<fieldset> <legend>Gender</legend>
							<input type="radio" name="gender" value="M" checked> M 
							<input type="radio" name="gender" value="F" checked> F <br>
						</fieldset>
						<fieldset> <legend>Race</legend>
							<select name="Race">
								<?php
									if(!($stmt = $mysqli->prepare(	"SELECT lol_races.race_id, lol_races.name 
																	FROM lol_races"
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
						<fieldset>
							<legend>Origin</legend>
							Birth Nation/Faction <select name="bFaction">
								<?php 
									if(!($stmt = $mysqli->prepare(	"SELECT lol_factions.faction_id, lol_factions.name 
																	FROM lol_factions
																	ORDER BY CASE lol_factions.name
																	WHEN ' ' THEN 1 ELSE 2 END"
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
							&nbsp Birth Region <select name="bRegion">
								<?php
									if(!($stmt = $mysqli->prepare(	"SELECT lol_regions.region_id, lol_regions.name 
																	FROM lol_regions
																	ORDER BY CASE lol_regions.name
																	WHEN ' ' THEN 1 ELSE 2 END"
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
						<fieldset>
							<legend>Release Date</legend>
							<p><input type="date" name="releaseDate" /></p>
						</fieldset>
						&nbsp <input type="submit" name="add" value="Add Champion" />
				</fieldset>
			</form>
		</div> <br>
		<div class="button"><a href="regions.php">See Region List</a></div> <br> <!--go to regions table-->
		<div> <!--ADD REGION-->
			<form method="post" action="addRegion.php"> 
				<fieldset> <legend>Add Region</legend>
						<fieldset>
							<p>Name: <input type="text" name="regionName" /></p>
						</fieldset>
						&nbsp <input type="submit" name="add" value="Add Region" />
				</fieldset>
			</form>
		</div> <br>
		<div class="button"><a href="factions.php">See Faction/Nation List</a></div> <br> <!--go to factions table-->
		<div> <!--ADD FACTION-->
			<form method="post" action="addFaction.php"> 
				<fieldset> <legend>Add Faction/Nation </legend>
						<fieldset>
							<p>Name: <input type="text" name="factionName" /></p>
						</fieldset>
						&nbsp <input type="submit" name="add" value="Add Faction/Nation" />
				</fieldset>
			</form>
		</div> <br>
		<div class="button"><a href="races.php">See Race List</a></div> <br> <!--go to races table-->
		<div> <!--ADD RACE-->
			<form method="post" action="addRace.php"> 
				<fieldset> <legend>Add Race </legend>
						<fieldset>
							<p>Name: <input type="text" name="raceName" /></p>
						</fieldset>
						&nbsp <input type="submit" name="add" value="Add Race" />
				</fieldset>
			</form>
		</div> <br>
		<div class="button"><a href="occupations.php">See Occupations List</a></div> <br> <!--go to races table-->
		<div> <!--ADD OCCUPATION-->
			<form method="post" action="addOccupation.php"> 
				<fieldset> <legend>Add Occupation </legend>
						<fieldset>
							<p>Title: <input type="text" name="jobTitle" /></p>
						</fieldset>
						&nbsp <input type="submit" name="add" value="Add Occupation" />
				</fieldset>
			</form>
		</div>
	</body>
</html>




