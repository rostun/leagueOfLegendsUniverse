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
		if(!($stmt = $mysqli->prepare("INSERT INTO lol_championOccupations(champion_id, occupation_id) VALUES  (?,?)"))){
			echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
		}
		//bind parameters
		if(isset($_POST['add'])){
			$champID = $_POST['champ']; //echo $bFaction;
			$jobID = $_POST['occupation']; //echo $bRegion;
		}
		if(!($stmt->bind_param("ii", $champID, $jobID))){
			echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
		}
		if(!$stmt->execute()){
			echo "Execute failed: "  . $stmt->errno . " " . $stmt->error;
		} else {
			echo "Added occupation to champions list of occupations.";
		}
		//save champion name
		$champID = $_POST['champ']; //echo $champName;
		?>
		</div>
		<div> <!--display champion just added-->
			<table>
				<thead>
					<tr>
						<th> </th>
						<th> Champions Current Occupations </th>
					</tr>
				</thead>
				<?php				
					if(!($stmt = $mysqli->prepare(	"SELECT 	lol_champions.name, lol_occupations.title
													FROM lol_champions
													INNER JOIN lol_championOccupations ON lol_champions.champion_id = lol_championOccupations.champion_id
													INNER JOIN lol_occupations ON lol_championOccupations.occupation_id = lol_occupations.occupation_id 
													WHERE lol_champions.champion_id = $champID"
													))){
						echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
					}
					if(!$stmt->execute()){
						echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
					}
					if(!$stmt->bind_result($name, $occupation)){
						echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
					}
					while($stmt->fetch()){
						echo "<tr>\n<td>\n" . $name ."\n</td>\n<td>\n" . $occupation;
					}
					$stmt->close();
				?>
			</table>
		</div>	
	</body>
</html>