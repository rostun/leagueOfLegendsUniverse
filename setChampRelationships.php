<!--
	Rosa Tung
	add champion relationship
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
		<div class="button"><a href="lolgendsAdd.php">Add Something Else</a></div> <br> <!--go back to add page-->
		<div> <!--add alias-->
		<?php
		if(!($stmt = $mysqli->prepare("INSERT INTO lol_championRelationships(champion_id, champion_id2, related, romantic, ally, rival) VALUES  (?,?,?,?,?,?)"))){
			echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
		}
		//bind parameters
		if(isset($_POST['add'])){
			$champ1 = $_POST['champ1']; //echo $bFaction;
			$champ2 = $_POST['champ2']; //echo $bRegion;
		}
		if($champ1 == $champ2){ //check if champ1 == champ2
			echo "Champions can't have relationships with themselves. I think.";
		}
		else
		{
			$query = "SELECT champion_id, champion_id2 FROM lol_championRelationships";
			$result = $mysqli->query($query); //put query results into array
			$flag = 0; //good to go
			//echo $champ1 . "X" . $champ2 . "X";
			while($row = $result->fetch_assoc()){ //check if champ1, champ2 combination already exists
				//echo $row['champion_id'] . " "; //echo $champ2test = $row['champion_id2'] . "|"; 
				//if ($row['champion_id'] == intval($champ2)){echo "champ2";} //if ($row['champion_id2'] == intval($champ1)){echo "champ1";}
				if (($row['champion_id2'] == intval($champ1)) && ($row['champion_id'] == intval($champ2))){
					//echo "B" . $champ1 . " " . $champ2 . "B mirror";
					$flag = 1; //echo "flag set"; 
				}
			}
			if($flag == 1){
				echo "Champion relationships already exists.";
			} //if it's unique through and through, add it in
			else{
				if(!($stmt->bind_param("iissss", $champ1, $champ2, $_POST['related'], $_POST['romantic'], $_POST['allies'], $_POST['rivals']))){
					echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
				}
				if(!$stmt->execute()){
					echo "Execute failed: "  . $stmt->errno . " " . $stmt->error;
				} else {
					echo "Champion Relationship Added";
				}
				//save champion name
				$champ1 = $_POST['champ1']; //echo $champName;
				$champ2 = $_POST['champ2']; //echo $champName;					
			}
		}
		?>
		</div>
		<div> <!--display champion just added-->
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