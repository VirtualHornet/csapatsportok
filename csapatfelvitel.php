<?php

include_once("fuggvenyek.php"); // fel fugjuk használni ezeket a függvényeket

// lekérjük a POST-tal átlküldött paramétereket,
// ellenőrizzük azt is, hogy kaptak-e értéket

$v_csapat = $_POST['csapat'];
$v_gyoz = $_POST['gyozelem'];
$v_don = $_POST['dontetlen'];
$v_ver = $_POST['vereseg'];
$v_stadion = $_POST['stadion'];
$v_varos = $_POST['varos'];

if ( isset($v_csapat) && isset($v_gyoz) && 
     isset($v_don) && isset($v_ver) && isset($v_stadion) &&
     isset($v_varos)) {

	// beszúrjuk az új rekordot az adatbázisba
	csapat_beszur($v_csapat, $v_gyoz, $v_don, $v_ver, $v_stadion, $v_varos);
	
	// visszatérünk az index.php-re
	header("Location: csapatok.php");

} else {
	error_log("Nincs beállítva valamely érték");
	
}




?>