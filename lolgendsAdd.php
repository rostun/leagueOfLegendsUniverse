<!--
	Rosa Tung
	CS 340
	add things to the database
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
		<legend class="topLabel"> Add Things to the Database </legend> <br><br>
		<div class="button"><a href="lolgendsMain.php">Return To Main Page</a></div> <br><br> <!--go back to homescreen-->
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
		<div class="button"><a href="aliases.php">See Champion Aliases</a></div> <br> <!--go to general table-->
		<div> <!--ADD CHAMPION ALIAS-->
			<form method="post" action="addAlias.php"> 
				<fieldset> <legend>Add Champion Alias</legend>
						<fieldset> <legend>Champion</legend>
							<select name="champion">
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
						<fieldset> <legend>Alias </legend>
								<p> <input type="text" name="alias" /></p>
						</fieldset>
						&nbsp <input type="submit" name="add" value="Add Alias" />
				</fieldset>
			</form>
		</div> <br>
		<div class="button"><a href="champOccupations.php">See Champion Occupations</a></div> <br> <!--go to general table-->
		<div> <!--ADD OCCUPATION TO CHAMPION-->
			<form method="post" action="setChampOccupation.php"> 
				<fieldset> <legend>Set Champion Occupation</legend>
						<fieldset> <legend>Champion</legend>
							<select name="champ">
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
						&nbsp <legend>Occupation</legend>
							<select name="occupation">
								<?php
									if(!($stmt = $mysqli->prepare(	"SELECT lol_occupations.occupation_id, lol_occupations.title 
																	FROM lol_occupations"
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
						&nbsp <input type="submit" name="add" value="Set Champion Occupation" />
				</fieldset>
			</form>
		</div> <br>
		<div class="button"><a href="champAllegiances.php">See Champion Allegiances</a></div> <br> <!--go to general table-->
		<div> <!--ADD ALLEGIANCE-->
			<form method="post" action="setChampAllegiance.php"> 
				<fieldset> <legend>Set Champion Allegiance</legend>
						<fieldset> <legend>Champion</legend>
							<select name="champ">
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
						&nbsp <legend>Faction</legend>
							<select name="faction">
								<?php
									if(!($stmt = $mysqli->prepare(	"SELECT lol_factions.faction_id, lol_factions.name 
																	FROM lol_factions
																	WHERE lol_factions.faction_id != 1"
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
						&nbsp <input type="submit" name="add" value="Set Champion Allegiance" />
				</fieldset>
			</form>
		</div> <br>
		<div class="button"><a href="champRelationships.php">See Champion Relationships</a></div> <br> <!--go to general table-->
		<div> <!--ADD CHAMPION RELATIONSHIP-->
			<form method="post" action="setChampRelationships.php"> 
				<fieldset> <legend>Add Relationship</legend>
						<fieldset> <legend>First Champion</legend>
							<select name="champ1">
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
						&nbsp <legend>Second Champion</legend>
							<select name="champ2">
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
						<fieldset> <legend>Relationships</legend>	
							Related? 	<input type="radio" name="related" value="Y" checked> Yes 
										<input type="radio" name="related" value="N" checked> No <br>
							Romantic? 	<input type="radio" name="romantic" value="Y" checked> Yes 
										<input type="radio" name="romantic" value="N" checked> No <br>
							Allies? 	<input type="radio" name="allies" value="Y" checked> Yes 
										<input type="radio" name="allies" value="N" checked> No <br>
							Rivals? 	<input type="radio" name="rivals" value="Y" checked> Yes 
										<input type="radio" name="rivals" value="N" checked> No 
										</fieldset>
						&nbsp <input type="submit" name="add" value="Add Relationship" />
				</fieldset>
			</form>
		</div> <br>
	</body>
</html>




