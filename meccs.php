<?php
include_once('fuggvenyek.php');
?>

<!DOCTYPE HTML>
<HTML>
<HEAD>
	<meta http-equiv="content-type" content="text/html; charset=UTF8" >
    <link rel="stylesheet" href="style.css">
</HEAD>
<BODY>
	
<section id = "header">
	<div class="topnav">
		<a href="index.php">Kezdőlap</a>
		<a class="active" href="meccs.php">Meccsek</a>
		<a href="csapatok.php">Csapatok</a>
		<a href="jatekosok.php">Játékosok</a>
		<a href="lovostatisztika.php">Statisztika</a>
	</div>
</section>

<h1>Meccs bevitele</h1>

<form method="POST" action="meccsfelvitel.php" accept-charset="utf-8">
<table>
<td>Dátum: </td>
<td><input type="date" name="date"/></td>
</tr>
<tr>
<td>Hazai gólok: </td>
<td><input type="number" name="hazg" /></td>
</tr>
<tr>
<td>Vendég gólok: </td>
<td><input type="number" name="veng" /></td>
</tr>
<tr>
<td>Hazai csapat: </td>
<td>
<select type="text" name="hazcs">
<?php 
	$csapatok = csapatLeker();
	while( $egySor = mysqli_fetch_assoc($csapatok) ) {
		echo '<option value="'.$egySor["név"].'">'.$egySor["név"].'</option>';
	}
	mysqli_free_result($csapatok);


?>
</select>
</td>
</tr>
<tr>
<td>Vendég csapat: </td>
<td>
<select type="text" name="vencs">
<?php 
	$csapatok = csapatLeker();
	while( $egySor = mysqli_fetch_assoc($csapatok) ) {
		echo '<option value="'.$egySor["név"].'">'.$egySor["név"].'</option>';
	}
	mysqli_free_result($csapatok);

?>
</select>
</td>
</tr>
<tr>
<td></td>
<td><input type="submit" value="Elküld" /></td>
</tr>
</table>
</form>


<hr/>
<h1>Meccsek listája</h1>

<table border="1">
<tr>
<th>Meccs id:</th>
<th>Hazai csapat:</th>
<th>Hazai golók:</th>
<th>Vendég gólok</th>
<th>Vendég csapat</th>
<th>Dátum</th>
</tr>

<?php

	$meccs = meccsLeker(); // ez egy eredményhalmazt ad vissza
	
	// soronként dolgozzuk fel az eredményt
	// minden sort egy asszociatív tömbben kapunk meg
    while( $egySor = mysqli_fetch_assoc($meccs) ) { 
		echo '<tr>';
		echo '<td>'. $egySor["meccs_id"] .'</td>';
		echo '<td>'. $egySor["hazai_csapat"] .'</td>';
		echo '<td>'. $egySor["hazai_gól"] .'</td>';
		echo '<td>'. $egySor["vendég_gól"] .'</td>';
		echo '<td>'. $egySor["vendég_csapat"] .'</td>';
		echo '<td>'. $egySor["dátum"] .'</td>';
		echo '</tr>';
	} 
	mysqli_free_result($meccs); // töröljük a listát a memóriából

?>
</table>


</BODY>
</HTML>
