<!--
	Rosa Tung
	CS 340
	Final Project
	lolgendsMain.php
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
	</head>
	<body>
		<div> <!--Champion Table-->
			<table border="1">
				<thead>
					<tr>
						<th> Champion </th>
						<th> Alias </th>
						<th> Gender </th>
						<th> Race </th>
						<th> Birth Region </th>
						<th> Date Released </th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<th> Kennen </th>
						<td> The Heart of the Tempest </td>
						<td> Male </td>
						<td><a href="yordle.html?id=1"> Yordle</a> </td> 
						<td>Yordle Land</td> <!--example-->
						<td> 2010-04-08 </td>
					</tr>
				</tbody>
			</table>
		</div>
		<div> <!--Add Champion-->
			<form method="post" action="lolgends.html"><!--change this later to whatever page is handling the form-->
				<fieldset>
					<legend>Add Champion</legend>
						<p> Name: 
							<input type="text" name="text_input" size="30" maxlength="50"> 
						</p>
						<p> Alias: 	
							<input type="text" name="text_input" size="30" maxlength="50"> 
						</p>
						<p> Gender: 	
							<input type="radio" name="gender" value="M" checked> M 
							<input type="radio" name="gender" value="F"> F 
						</p>
						<p> Race:	
							<select>
								<option value = "1">Yordle</option>
								<option value = "2">Human</option>
							</select> 
						</p>
						<p> Starting Region:	
							<select>
								<option value = "1">Yordle Land</option>
								<option value = "2">Ionia</option>
							</select>
						</p>
						<p>Release Date:
							<input type="date" name = "release-date"> 
						</p>		
						<p> <input type="submit" value="Submit"> </p>
				</fieldset>
			</form>
		</div>
		<div> <!--add occupations-->
			<form method="post" action="lolgends.html"> <!--change this later-->
				<fieldset>
					<legend>Add Occupation</legend>
						<p> Title:
							<input type="text" name="text_input" size="30" maxlength="50">
						</p>
					<p> 
						<input type="submit" value="add" value="Add Occupation">
						<input type="submit" value="update" value="Update Occupation"> 
					</p>
				</fieldset>
			</form>
		</div>
	</body>
</html>