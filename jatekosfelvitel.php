<?php

include_once("fuggvenyek.php"); // fel fugjuk használni ezeket a függvényeket

// lekérjük a POST-tal átlküldött paramétereket,
// ellenőrizzük azt is, hogy kaptak-e értéket

$v_nev = $_POST['nev'];
$v_mezszám = $_POST['mezszám'];
$v_poz = $_POST['poz'];
$v_nemzetseg= $_POST["nem"];
$v_csapat = $_POST["csapat"];

if ( isset($v_nev) && isset($v_mezszám) && 
     isset($v_poz) && isset($v_nemzetseg) && isset($v_csapat)) {

	// beszúrjuk az új rekordot az adatbázisba
	jatekos_beszur($v_nev, $v_mezszám, $v_poz, $v_csapat, $v_nemzetseg);
	
	// visszatérünk az index.php-re
	header("Location: jatekosok.php");

} else {
	error_log("Nincs beállítva valamely érték");
	
}




?>