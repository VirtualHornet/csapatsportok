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
		<a href="jatekosok.php">Játékosok</a>
		<a class="active" href="lovostatisztika.php">Statisztika</a>
	</div>
</section>

<hr/>
<h1>Meccs adatok mentése</h1>
<?php
	$id=0;
  $val = MeccsID();
  while( $egySor = mysqli_fetch_assoc($val) ) { 
	$id = $egySor["meccs_id"];
} 
mysqli_free_result($val);
if($id > 0){

 
echo '<form method="POST" action="statmentés.php" accept-charset="utf-8">';
echo'<table border="1">';



  
	$jatekos =hazaicsapatleker(); // ez egy eredményhalmazt ad vissza
	
	// soronként dolgozzuk fel az eredményt
	// minden sort egy asszociatív tömbben kapunk meg
    while( $egySor = mysqli_fetch_assoc($jatekos) ) { 
		echo '<tr>';
		echo '<td>'.'Hazai csapat:'.'</td>';
		echo '<td>'.$egySor["hazai_csapat"] .'</td>';
		echo '</tr>';
		//$gol = $egySor["hazai_gól"];
	} 
	mysqli_free_result($jatekos);// töröljük a listát a memóriából



	$golok = kiosztottHgolok();
	while( $egySor = mysqli_fetch_assoc($golok) ) { 
		echo '<tr>';
		echo '<td>'.'Rúgott gólok'.'</td>';
		echo '<td>'.$egySor["h_gol"] .'</td>';
		$gol1 = $egySor["h_gol"];
		echo '<tr>';
	} 
	mysqli_free_result($golok); // töröljük a listát a memóriából


	$asszist = hasziszt();
	while( $egySor = mysqli_fetch_assoc($asszist) ) { 
		echo '<tr>';
		echo '<td>'.'Gólpassz'.'</td>';
		echo '<td>'.$egySor["h_assz"] .'</td>';
		$assz1 = $egySor["h_assz"];
		echo '<tr>';
	} 
	mysqli_free_result($asszist);



	echo'<td>'.'Ki rúgta őket:'.'</td>';



if($gol1>0 || $assz1>0){
	echo '<td>';
	echo '<select name="jatekosok1">';
	$jatekos= Hazaijatekosok();
	while( $egySor = mysqli_fetch_assoc($jatekos) ) {
		echo '<option value="'.$egySor["játékos_név"].'">'.$egySor["játékos_név"].'</option>';
	}
	echo '</select>';
	echo '</td>';	
	mysqli_free_result($jatekos);
	}else{
	
		echo '<td>'. "Nem rúgtak több gólt".'</td>';
		
		//golbeszur($jatekos, $gol1, $assz1);	
	}



echo'<tr>';
echo'<td>'.'Hány gólt rúgott:'.'</td>';
echo'<td>'.'<input type="number" name="gol1" />'.'</td>';
echo'</tr>';
echo'<tr>';
echo'<td>'.'Hány gólpasszt adott:'.'</td>';
echo'<td>'.'<input type="number" name="assziszt1" />'.'</td>';
echo'</tr>';
echo'<tr>';
echo'<td>'.'</td>';
echo'<td>'.
	'<input type="submit" value="Elküld" />'.
'</td>';
echo'</tr>';
echo'</table>';

echo'<form method="POST" action="statmentés.php" accept-charset="utf-8">';
echo'<table border="1">';


	$jatekos = vendegcsapatleker(); // ez egy eredményhalmazt ad vissza
	
	// soronként dolgozzuk fel az eredményt
	// minden sort egy asszociatív tömbben kapunk meg
    while( $egySor = mysqli_fetch_assoc($jatekos) ) { 
		echo '<tr>';
		echo '<td>'.'Vendég csapat:'.'</td>';
		echo '<td>'.$egySor["vendég_csapat"] .'</td>';
		echo '</tr>';
		//$gol = $egySor["hazai_gól"];
	} 
	mysqli_free_result($jatekos); // töröljük a listát a memóriából
	$golok = kiosztottVgolok();
	while( $egySor = mysqli_fetch_assoc($golok) ) { 
		echo '<tr>';
		echo '<td>'.'Rúgott gólok'.'</td>';
		echo '<td>'.$egySor["v_gol"] .'</td>';
		$gol2 = $egySor["v_gol"];
		echo '<tr>';
	} 
	mysqli_free_result($golok); // töröljük a listát a memóriából

	$asszist = vasziszt();
	while( $egySor = mysqli_fetch_assoc($asszist) ) { 
		echo '<tr>';
		echo '<td>'.'Gólpassz'.'</td>';
		echo '<td>'.$egySor["v_assz"] .'</td>';
		$assz2 = $egySor["v_assz"];
		echo '<tr>';
	} 
	mysqli_free_result($asszist);


	echo"<td>".'Ki rúgta őket:'.'</td>';


if($gol2>0 || $assz2>0){
	echo'<td>';
	echo '<select name="jatekosok2">';
	$jatekos= Vendegjatekosok();
	while( $egySor = mysqli_fetch_assoc($jatekos) ) {
		echo '<option value="'.$egySor["játékos_név"].'">'.$egySor["játékos_név"].'</option>';
	}
	echo '</select>';
	echo'</td>';
	mysqli_free_result($jatekos);
	}else{
		//echo '<tr>';
		//echo '<td>'.'Ki rúgta őket:'.'</td>';
		echo '<td>'. "Nem rúgtak több gólt".'</td>';
		//golbeszur($jatekos, $gol2, $assz2);
		//echo '</tr>';
	}	
	segédvissza($gol1, $assz1,$gol2,$assz2);



	echo'<tr>';
	echo'<td>'.'Hány gólt rúgott:'.'</td>';
	echo'<td>'.'<input type="number" name="gol2" />'.'</td>';
	echo'</tr>';
	echo'<tr>';
	echo'<td>'.'Hány gólpasszt adott:'.'</td>';
	echo'<td>'.'<input type="number" name="assziszt2" />'.'</td>';
	echo'</tr>';
	echo'<tr>';
	echo'<td>'.'</td>';
	echo'<td>'.
		'<input type="submit" value="Elküld" />'.
	'</td>';
	echo'</tr>';
	echo'</table>';

 }else {
	 echo '<p>'.'Nincs lejátszott meccs.'.'</p>';
 }
?>  



<table border="1">
<tr>
<h1>Legtöbb rúgott gól</h1>
</tr>
<?php

    $kiraly = kiraly();
        while( $egySor = mysqli_fetch_assoc($kiraly)){
        echo '<tr>';
        echo '<td>'. $egySor["név"] .'</td>';
        echo '<td>'. $egySor["max"] .'</td>';
        echo '</tr>';
}
mysqli_free_result($kiraly);
?>
</table>

<table border="1">
<tr>
<h1>Legtöbb gólpassz</h1>
</tr>
<?php

    $kiraly = passz();
        while( $egySor = mysqli_fetch_assoc($kiraly)){
        echo '<tr>';
        echo '<td>'. $egySor["név"] .'</td>';
        echo '<td>'. $egySor["sum"] .'</td>';
        echo '</tr>';
}
mysqli_free_result($kiraly);
?>
</table>

<hr/>
<h1>Játékosok listája</h1>

<table border="1">
<tr>
<th>Játékos név:</th>
<th>Rúgott gólok száma:</th>
<th>Gólpasszok száma:</th>
</tr>


<?php

	$jatekos = statLeker(); // ez egy eredményhalmazt ad vissza
	
	// soronként dolgozzuk fel az eredményt
	// minden sort egy asszociatív tömbben kapunk meg
    while( $egySor = mysqli_fetch_assoc($jatekos) ) { 
		echo '<tr>';
		echo '<td>'. $egySor["név"] .'</td>';
		echo '<td>'. $egySor["lőtt_gól"] .'</td>';
		echo '<td>'. $egySor["gólpassz"] .'</td>';
		echo '</tr>';
	} 
	mysqli_free_result($jatekos); // töröljük a listát a memóriából

?>
</table>
</BODY>
</HTML>