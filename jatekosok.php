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
		<a href="meccs.php">Meccsek</a>
		<a href="csapatok.php">Csapatok</a>
		<a class="active" href="jatekosok.php">Játékosok</a>
		<a href="lovostatisztika.php">Statisztika</a>
	</div>
</section>

<h1>Játékos felvitele</h1>

<form method="POST" action="jatekosfelvitel.php" accept-charset="utf-8">
<table>
<tr>
<td>Játékos neve: </td>
<td><input type="text" name="nev" /></td>
</tr>
<tr>
<td>Mez száma: </td>
<td><input type="number" name="mezszám" /></td>
</tr>
<tr>
<td>Pozício: </td>
<td><input type="text" name="poz" /></td>
</tr>
<tr>
<td>Nemzetség: </td>
<td><input type="text" name="nem" /></td>
</tr>
<form>
<tr>
<td>Csapat: </td>
<td>
<select name="csapat">
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
</form>
<tr>
<td></td>
<td>
	<input type="submit" value="Elküld" />
</td>
</tr>
</table>
</form>


<hr/>
<hr/>
<h1>Játékosok listája</h1>

<table border="1">
<tr>
<th>Játékos név:</th>
<th>Mezszám:</th>
<th>Pozício:</th>
<th>Csapat:</th>
<th>Nemzetség:</th>
</tr>

<?php

	$jatekos = jatekosLeker(); // ez egy eredményhalmazt ad vissza
	
	// soronként dolgozzuk fel az eredményt
	// minden sort egy asszociatív tömbben kapunk meg
    while( $egySor = mysqli_fetch_assoc($jatekos) ) { 
		echo '<tr>';
		echo '<td>'. $egySor["játékos_név"] .'</td>';
		echo '<td>'. $egySor["mez_szám"] .'</td>';
		echo '<td>'. $egySor["pozició"] .'</td>';
		echo '<td>'. $egySor["csapat"] .'</td>';
		echo '<td>'. $egySor["nemzetség"] .'</td>';
		echo '</tr>';
	} 
	mysqli_free_result($jatekos); // töröljük a listát a memóriából

?>
</table>


<h1>Csapat szerint:</h1>

<form method="POST" action="csapatvalasztas.php" accept-charset="utf-8">
<table border="1">
<tr>
<th>
<select name="csapat">
<?php 
	$csapatok = csapatLeker();
	while( $egySor = mysqli_fetch_assoc($csapatok) ) {
		echo '<option value="'.$egySor["név"].'">'.$egySor["név"].'</option>';
	}
	mysqli_free_result($csapatok);

?>
</select>

</th>
</tr>
</tr>
<tr>
<td>
	<input type="submit" value="Elküld" />
</td>
</tr>
<?php

	$jatekos = jatekosLekerCsapatSzerint(); // ez egy eredményhalmazt ad vissza
	
	// soronként dolgozzuk fel az eredményt
	// minden sort egy asszociatív tömbben kapunk meg
    while( $egySor = mysqli_fetch_assoc($jatekos) ) { 
		echo '<tr>';
		echo '<td>'. $egySor["játékos_név"] .'</td>';
		echo '<td>'. $egySor["mez_szám"] .'</td>';
		echo '<td>'. $egySor["pozició"] .'</td>';
		echo '<td>'. $egySor["nemzetség"] .'</td>';
		echo '</tr>';
	} 
	mysqli_free_result($jatekos); // töröljük a listát a memóriából
	urit();
?>

</table>
</form>

</BODY>
</HTML>



