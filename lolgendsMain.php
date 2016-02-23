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
												ORDER BY lol_champions.name ASC"
												))){
					echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
				}
				if(!$stmt->execute()){
					echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
				}
				if(!$stmt->bind_result($var1, $var2, $var3, $var4, $var5, $var6)){
					echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
				}
				while($stmt->fetch()){
					echo "<tr>\n<td>\n" . $var1 . "\n</td>\n<td>\n" . $var2 . "\n</td>\n<td>\n" . $var3 . "\n</td>\n<td>" . $var4 . ", " . $var5 . "\n</td>\n<td>" . $var6;
				}
				$stmt->close();
			?>
		</table>
	</body>
</html>




