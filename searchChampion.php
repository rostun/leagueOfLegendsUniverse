<!--
	Rosa Tung
	search for a champion
-->

<?php
	ini_set('display_errors', 'On');//Turn on error reporting
	//Connects to the database
	$mysqli = new mysqli("oniddb.cws.oregonstate.edu","tungr-db","6cBDKtK64QENNcPP","tungr-db");
	if($mysqli->connect_errno){
		echo "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
		}
?>

<!DOCTYPE html>
<html>
    <head>
		<meta charset="utf-8"/>
		<link rel="stylesheet" type="text/css" href="style.css" />
	</head>
	<body>
		<div class="button"><a href="lolgendsMain.php">Return To Main Page</a></div> <br> <!--go back to homescreen-->
		<div class="button"><a href="lolgendsSearch.php">Search Something Else</a></div> <br> <!--go back to add page-->	
		<div class="button"><a href="lolgendsAdd.php">Add Something to the Database</a></div> <br> <!--go back to add page-->
		<div> <!--Search Champion-->
		<legend class="topLabel"> Champion Details </legend> <br>
			<table>
				<thead>
					<tr>
						<th> Champion </th>
						<th> Gender </th>
						<th> Race </th>
						<th> Origin (Nation/Faction, Region) </th>
						<th> Date Released </th>
					</tr>
				</thead>
				<?php				
					if(!($stmt = $mysqli->prepare(	"SELECT	lol_champions.name,
															lol_champions.gender,
															lol_races.name,
															IFNULL(lol_factions.name, 'n/a'),
															IFNULL(lol_regions.name, 'n/a'),
															lol_champions.releaseDate
													FROM lol_champions
													LEFT JOIN lol_races ON lol_champions.race_id = lol_races.race_id
													LEFT JOIN lol_factions ON lol_champions.birth_faction_id = lol_factions.faction_id
													lEFT JOIN lol_regions ON lol_champions.birth_region_id = lol_regions.region_id
													WHERE lol_champions.champion_id = ?"
													))){
						echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
					}
					if(!($stmt->bind_param("i",$_GET['champName']))){
						echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
					}
					if(!$stmt->execute()){
						echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
					}
					if(!$stmt->bind_result($Cname, $gender, $Rname, $Fname, $Rename, $releaseDate)){
						echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
					}
					while($stmt->fetch()){
						echo "<tr>\n<td>\n" . $Cname . "\n</td>\n<td>\n" . $gender . "\n</td>\n<td>\n" . $Rname . "\n</td>\n<td>" . $Fname . ", " . $Rename . "\n</td>\n<td>" . $releaseDate;
					}
					$stmt->close();
				?>
			</table> 
		</div> <br>
		<div> <!--aliases-->
			<table>
				<thead>
					<tr>
						<th> Aliases </th>
					</tr>
				</thead>
				<?php				
					if(!($stmt = $mysqli->prepare(	"SELECT 	lol_aliases.alias
													FROM lol_champions
													INNER JOIN lol_aliases ON lol_aliases.champion_id = lol_champions.champion_id
													WHERE lol_champions.champion_id = ?
													ORDER BY lol_aliases.alias ASC"
													))){
						echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
					}
					if(!($stmt->bind_param("i", $_GET['champName']))){
						echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
					}
					if(!$stmt->execute()){
						echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
					}
					if(!$stmt->bind_result($alias)){
						echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
					}
					while($stmt->fetch()){
						echo "<tr>\n<td>\n" . $alias;
					}
					$stmt->close();
				?>
			</table>
		</div> <br>
		<div> <!--Allegiances-->
			<table>
				<thead>
					<tr>
						<th> Allegiances </th>
					</tr>
				</thead>
				<?php				
					if(!($stmt = $mysqli->prepare(	"SELECT 	lol_factions.name
													FROM lol_factions
													LEFT JOIN lol_championFactions ON lol_factions.faction_id = lol_championFactions.faction_id
													LEFT JOIN lol_champions ON lol_championFactions.champion_id = lol_champions.champion_id
													WHERE lol_champions.champion_id = ?
													ORDER BY lol_factions.name ASC"
													))){
						echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
					}
					if(!($stmt->bind_param("i", $_GET['champName']))){
						echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
					}
					if(!$stmt->execute()){
						echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
					}
					if(!$stmt->bind_result($alias)){
						echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
					}
					while($stmt->fetch()){
						echo "<tr>\n<td>\n" . $alias;
					}
					$stmt->close();
				?>
			</table>
		</div> <br>
		<div> <!--Occupations-->
			<table>
				<thead>
					<tr>
						<th> Occupations </th>
					</tr>
				</thead>
				<?php				
					if(!($stmt = $mysqli->prepare(	"SELECT 	lol_occupations.title
													FROM lol_occupations
													INNER JOIN lol_championOccupations ON lol_occupations.occupation_id = lol_championOccupations.occupation_id
													INNER JOIN lol_champions ON lol_championOccupations.champion_id = lol_champions.champion_id
													WHERE lol_champions.champion_id = ?
													ORDER BY lol_occupations.title ASC"
													))){
						echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
					}
					if(!($stmt->bind_param("i", $_GET['champName']))){
						echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
					}
					if(!$stmt->execute()){
						echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
					}
					if(!$stmt->bind_result($title)){
						echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
					}
					while($stmt->fetch()){
						echo "<tr>\n<td>\n" . $title;
					}
					$stmt->close();
				?>
			</table>
		</div> <br>	
		<div> <!--Relationships-->
			<label >Relationships</label>
			<table>
				<thead>
					<tr>
						<th> Champion </th>
						<th> Related </th>
						<th> Romantic </th>
						<th> Allies </th>
						<th> Rivals </th>
					</tr>
				</thead>
				<?php		
					if(!($stmt = $mysqli->prepare(	"SELECT 	D.name,
																B.related,
																B.romantic,
																B.ally,
																B.rival
													FROM lol_champions A
													INNER JOIN lol_championRelationships B ON A.champion_id = B.champion_id
													INNER JOIN lol_champions C ON B.champion_id2 = C.champion_id
													INNER JOIN lol_champions D
													WHERE A.champion_id = ? AND C.champion_id != ? AND D.champion_id = C.champion_id
													OR A.champion_id != ? AND C.champion_id = ? AND D.champion_id = A.champion_id"
													))){
						echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
					}
					//$champID = $_GET['champName'];
					if(!($stmt->bind_param("iiii", $_GET['champName'], $_GET['champName'], $_GET['champName'], $_GET['champName']))){
						echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
					}
					if(!$stmt->execute()){
						echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
					}
					if(!$stmt->bind_result($champ1, $related, $romantic, $allies, $rivals)){
						echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
					}
					while($stmt->fetch()){
						echo "<tr>\n<td>\n" . $champ1 . "\n</td>\n<td>\n" . $related . "\n</td>\n<td>\n" . $romantic . "\n</td>\n<td>\n" . $allies . "\n</td>\n<td>\n" . $rivals;
					}
					$stmt->close();
				?>
			</table>
		</div> <br>			
	</body>
</html>