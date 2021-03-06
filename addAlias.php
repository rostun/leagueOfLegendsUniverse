<!--
	Rosa Tung
	2.29.16
	add alias
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
			if(!($stmt = $mysqli->prepare("INSERT INTO lol_aliases(champion_id, alias) VALUES  (?,?)"))){
				echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
			}
			//bind parameters
			if(!($stmt->bind_param("is",$_POST['champion'], $_POST['alias']))){
				echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
			}
			if(!$stmt->execute()){
				echo "Execute failed: "  . $stmt->errno . " " . $stmt->error;
			} else {
				echo "Added '" . $_POST['alias'] . "' to champions aliases.";
			}
			//save champion name
			$champID = $_POST['champion']; //echo $champName;
			?>
		</div>
		<div> <!--display champions current aliases-->
			<table>
				<thead>
					<tr>
						<th> Champion </th>
						<th> Alias </th>
					</tr>
				</thead>
				<?php //use saved champion name in selection				
					if(!($stmt = $mysqli->prepare(	"SELECT	lol_champions.name,
															lol_aliases.alias
													FROM lol_champions
													INNER JOIN lol_aliases ON lol_aliases.champion_id = lol_champions.champion_id
													WHERE lol_champions.champion_id = $champID"
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