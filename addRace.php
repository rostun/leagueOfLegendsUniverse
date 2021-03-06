<!--
	Rosa Tung
	2.29.16
	add race
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
		<div> <!--add race-->
			<?php
			if(!($stmt = $mysqli->prepare("INSERT INTO lol_races(name) VALUES (?)"))){
				echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
			}
			//bind parameters
			if(!($stmt->bind_param("s", $_POST['raceName']))){
				echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
			}
			if(!$stmt->execute()){
				echo "Execute failed: "  . $stmt->errno . " " . $stmt->error;
			} else {
				echo "Added '" . $_POST['raceName'] . "' to the list of races.";
			}
			?>
		</div>
		<div> <!--display current races in the database-->
			<table>
				<thead>
					<tr>
						<th> Races in the Database </th>
					</tr>
				</thead>
				<?php				
					if(!($stmt = $mysqli->prepare(	"SELECT	lol_races.name
													From lol_races"
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