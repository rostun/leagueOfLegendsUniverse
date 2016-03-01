<!--
	Rosa Tung
	champion relationships
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
		<legend class="topLabel"> Champion Relationships </legend> <br>
		<div class="button"><a href="lolgendsMain.php">Return To Main Page</a></div> <br> <!--go back to homescreen-->
		<div class="button"><a href="lolgendsAdd.php">Add Something to the Database</a></div> <br> <!--go back to add page-->
		<div> <!--champion relationships table-->
			<table>
				<thead>
					<tr>
						<th> Champion </th>
						<th> Champion </th>
						<th> Related </th>
						<th> Romantic </th>
						<th> Allies </th>
						<th> Rivals </th>
					</tr>
				</thead>
				<?php				
					if(!($stmt = $mysqli->prepare(	"SELECT A.name,
															C.name,
															B.related,
															B.romantic,
															B.ally,
															B.Rival
													FROM lol_champions A
													INNER JOIN lol_championRelationships B ON A.champion_id = B.champion_id
													INNER JOIN lol_champions C ON B.champion_id2 = C.champion_id"
													))){
						echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
					}
					if(!$stmt->execute()){
						echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
					}
					if(!$stmt->bind_result($champ1, $champ2, $related, $romantic, $allies, $rivals)){
						echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
					}
					while($stmt->fetch()){
						echo "<tr>\n<td>\n" . $champ1 . "\n</td>\n<td>\n" . $champ2 . "\n</td>\n<td>\n" . $related . "\n</td>\n<td>\n" . $romantic . "\n</td>\n<td>\n" . $allies . "\n</td>\n<td>\n" . $rivals;
					}
					$stmt->close();
				?>
			</table>
		</div>
	</body>
</html>
