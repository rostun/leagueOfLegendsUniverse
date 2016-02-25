<!--
	Rosa Tung
	CS 340
	Final Project
	regions.php
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
		<legend class="topLabel"> Regions </legend> <br>
		<div class="button"><a href="lolgendsMain.php">Return To Main Page</a></div> <br> <!--go back to homescreen-->
		<div class="button"><a href="lolgendsAdd.php">Add Something to the Database</a></div> <br> <!--go back to add page-->
		<div> <!--aliases-->
			<table>
				<thead>
					<tr>
						<th> Champion </th>
						<th> Occupation Title </th>
					</tr>
				</thead>
				<?php				
					if(!($stmt = $mysqli->prepare(	"SELECT 	lol_champions.name,
																lol_occupations.title
														FROM lol_champions
														INNER JOIN lol_championOccupations ON lol_champions.champion_id = lol_championOccupations.champion_id
														INNER JOIN lol_occupations ON lol_championOccupations.occupation_id = lol_occupations.occupation_id 
														ORDER BY lol_champions.name ASC"
													))){
						echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
					}
					if(!$stmt->execute()){
						echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
					}
					if(!$stmt->bind_result($Cname, $alias)){
						echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
					}
					while($stmt->fetch()){
						echo "<tr>\n<td>\n" . $Cname . "\n</td>\n<td>\n" . $alias;
					}
					$stmt->close();
				?>
			</table>
		</div>
	</body>
</html>