<!--
	Rosa Tung
	search champions per race distribution
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
		<legend class="topLabel"> Champion-Race Details </legend> <br>
		<div> <!--champion per race-->		
			<table>
			<label> Champions Per Race Distribution </label>
				<thead>
					<tr>
						<th> Race </th>
						<th> Number of Champions </th>
					</tr>
				</thead>
				<?php				
					if(!($stmt = $mysqli->prepare(	"SELECT 	lol_races.name,
																COUNT(IFNULL(lol_champions.champion_id, '0'))
														FROM lol_races
														LEFT JOIN lol_champions ON lol_races.race_id = lol_champions.race_id
														GROUP BY lol_races.name
														ORDER BY lol_races.name ASC"
													))){
						echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
					}
					if(!$stmt->execute()){
						echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
					}
					if(!$stmt->bind_result($Cname, $gender)){
						echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
					}
					while($stmt->fetch()){
						echo "<tr>\n<td>\n" . $Cname . "\n</td>\n<td>\n" . $gender;
					}
					$stmt->close();
				?>
			</table> 
		</div> <br>
		<div> <!--champions organized by faction-->		
			<table>
			<label> Champions in Factions </label>
				<thead>
					<tr>
						<th> Champion </th>
						<th> Race </th>
					</tr>
				</thead>
				<?php				
					if(!($stmt = $mysqli->prepare(	"SELECT 	lol_champions.name,
																lol_races.name
														FROM lol_races
														INNER JOIN lol_champions on lol_races.race_id = lol_champions.race_id
														ORDER BY lol_races.name ASC"
													))){
						echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
					}
					if(!$stmt->execute()){
						echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
					}
					if(!$stmt->bind_result($Cname, $gender)){
						echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
					}
					while($stmt->fetch()){
						echo "<tr>\n<td>\n" . $Cname . "\n</td>\n<td>\n" . $gender;
					}
					$stmt->close();
				?>
			</table> 
		</div> <br>
	</body>
</html>