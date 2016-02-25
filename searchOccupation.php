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
		<legend class="topLabel"> Champion-Faction Details </legend> <br>
		<div> <!--Search Champion-->
		<label> Champions-Occupations that Match Search </label> <br>
			<table>
				<thead>
					<tr>
						<th> Champion </th>
						<th> Occupation Title </th>
					</tr>
				</thead>
				<?php		
					$keyword = $_GET['occupation'];				
					if(!($stmt = $mysqli->prepare(	"SELECT 	lol_champions.name,
																lol_occupations.title
														FROM lol_champions
														INNER JOIN lol_championOccupations ON lol_champions.champion_id = lol_championOccupations.champion_id
														INNER JOIN lol_occupations ON lol_championOccupations.occupation_id = lol_occupations.occupation_id 
														WHERE lol_occupations.title
														LIKE '%$keyword%' 
														ORDER BY lol_champions.name ASC"
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