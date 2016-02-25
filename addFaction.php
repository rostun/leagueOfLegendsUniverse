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
		<div> <!--add champion-->
		<?php
		if(!($stmt = $mysqli->prepare("INSERT INTO lol_factions(name) VALUES (?)"))){
			echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
		}
		//bind parameters
		if(!($stmt->bind_param("s", $_POST['factionName']))){
			echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
		}
		if(!$stmt->execute()){
			echo "Execute failed: "  . $stmt->errno . " " . $stmt->error;
		} else {
			echo "Added '" . $_POST['factionName'] . "' to the list of factions.";
		}
		//save region name
		//$factionName = $_POST['factionName']; //echo $champName;
		?>
		</div>
		<div> <!--FACTION TABLE-->
			<table>
				<thead>
					<tr>
						<th> Faction/Nation's in the Database </th>
					</tr>
				</thead>
				<?php				
					if(!($stmt = $mysqli->prepare(	"SELECT	lol_factions.name
													From lol_factions
													WHERE lol_factions.name != ' '"
													))){
						echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
					}
					if(!$stmt->execute()){
						echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
					}
					if(!$stmt->bind_result($Cname)){
						echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
					}
					while($stmt->fetch()){
						echo "<tr>\n<td>\n" . $Cname;
					}
					$stmt->close();
				?>
			</table>
		</div>
	</body>
</html>