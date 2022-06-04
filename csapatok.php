<?php
include_once('fuggvenyek.php');
?>

<!DOCTYPE HTML>
<HTML lang="hu">
<HEAD>
	<meta charset="UTF-8">
	<meta http-equiv="content-type" content="text/html; charset=UTF8" >
    <link rel="stylesheet" href="style.css">
</HEAD>
<BODY>
<section id = "header">
	<div class="topnav">
		<a href="index.php">Kezdőlap</a>
		<a href="meccs.php">Meccsek</a>
		<a class="active" href="csapatok.php">Csapatok</a>
		<a href="jatekosok.php">Játékosok</a>
		<a href="lovostatisztika.php">Statisztika</a>
	</div>
</section>
<hr/>

<h1>Csapat felvitele</h1>

<form method="POST" action="csapatfelvitel.php" accept-charset="utf-8">
<table>
<tr>
<td>Csapat neve: </td>
<td><input type="text" name="csapat" /></td>
</tr>
<tr>
<td>Győzelmek száma: </td>
<td><input type="number" name="gyozelem" /></td>
</tr>
<tr>
<td>Döntetlenek száma: </td>
<td><input type="number" name="dontetlen" /></td>
</tr>
<tr>
<td>Vereségek száma: </td>
<td><input type="number" name="vereseg" /></td>
</tr>
<tr>
<td>Stadion neve: </td>
<td><input type="text" name="stadion" /></td>
</tr>
<tr>
<td>Város neve: </td>
<td><input type="text" name="varos" /></td>
</tr>
<tr>
<td></td>
<td><input type="submit" value="Elküld" /></td>
</tr>
</table>
</form>


<hr/>
<h1>Csapatok listája</h1>

<table border="1">
<tr>
<th>Csapatnév</th>
<th>Győzelmek száma</th>
<th>Döntetlenek száma</th>
<th>Vereseg száma</th>
<th>Stadion neve</th>
<th>Város neve</th>
</tr>

<?php

	$csapatok = csapatokLeker(); 

    while( $egySor = mysqli_fetch_assoc($csapatok) ) { 
		echo '<tr>';
		echo '<td>'. $egySor["név"] .'</td>';
		echo '<td>'. $egySor["győzelem"] .'</td>';
		echo '<td>'. $egySor["döntetlen"] .'</td>';
		echo '<td>'. $egySor["vereség"] .'</td>';
		echo '<td>'. $egySor["stadion"] .'</td>';
        echo '<td>'. $egySor["város"] .'</td>';
		echo '</tr>';
	} 
	mysqli_free_result($csapatok); 
?>
</table>


</BODY>
</HTML>
