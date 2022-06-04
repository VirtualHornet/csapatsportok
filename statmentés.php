<?php

include_once("fuggvenyek.php"); // fel fugjuk használni ezeket a függvényeket

// lekérjük a POST-tal átlküldött paramétereket,
// ellenőrizzük azt is, hogy kaptak-e értéket

//$v_ez=$_GET['hazcs'];


$v_jatekos1 = $_POST["jatekosok1"];
$v_gol1 = $_POST["gol1"];
$v_assz1 = $_POST["assziszt1"];
$v_hgol1 = $_POST["gol1"];


$v_jatekos2 = $_POST["jatekosok2"];
$v_gol2 = $_POST["gol2"];
$v_assz2 = $_POST["assziszt2"];
$v_vgol2 = $_POST["gol2"];



if ( isset($v_jatekos1)&&isset($v_gol1) && isset($v_assz1) && isset($v_hgol1)) {

	// beszúrjuk az új rekordot az adatbázisba
	
	
	golbeszur($v_jatekos1, $v_gol1, $v_assz1);
	urit2($v_gol1, $v_assz1);
	// visszatérünk az index.php-re
	header("Location: lovostatisztika.php");
	
}else if( isset($v_jatekos2)&&isset($v_gol2) && isset($v_assz2) && isset($v_vgol2)){
	golbeszur($v_jatekos2, $v_gol2, $v_assz2);
	urit3($v_gol2, $v_assz2);
	// visszatérünk az index.php-re
	header("Location: lovostatisztika.php");
} else {
	error_log("Nincs beállítva valamely érték");
	
}