<!--
	Rosa Tung
	champions
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
		<legend class="topLabel"> General Champion List</legend> <br>
		<div class="button"><a href="lolgendsMain.php">Return To Main Page</a></div> <br> <!--go back to homescreen-->
		<div class="button"><a href="lolgendsAdd.php">Add Something to the Database</a></div> <br> <!--go back to add page-->
		<div> <!--GENERAL CHAMPION INFORMATION TABLE-->
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
					if(!$stmt->bind_result($Cname, $gender, $Rname, $Fname, $Rename, $releaseDate)){
						echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
					}
					while($stmt->fetch()){
						echo "<tr>\n<td>\n" . $Cname . "\n</td>\n<td>\n" . $gender . "\n</td>\n<td>\n" . $Rname . "\n</td>\n<td>" . $Fname . ", " . $Rename . "\n</td>\n<td>" . $releaseDate;
					}
					$stmt->close();
				?>
			</table>
		</div>
	</body>
</html>