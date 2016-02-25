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
		<div> <!--champion per faction-->		
			<label> Champions that are Related </label> <br>
				<?php				
					if(!($stmt = $mysqli->prepare(	"SELECT CONCAT(A.name, ' and ', C.name)
													FROM lol_champions A
													INNER JOIN lol_championRelationships B ON A.champion_id = B.champion_id
													INNER JOIN lol_champions C ON B.champion_id2 = C.champion_id
													WHERE B.romantic = 'Y';"
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
						echo $Cname . "<br>";
					}
					$stmt->close();
				?>
		</div> <br>
	</body>
</html>