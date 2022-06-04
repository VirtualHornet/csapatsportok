<?php

include_once("fuggvenyek.php"); 


$v_csap = $_POST['csapat'];

if (isset($v_csap)) {
	if ( !($conn = csapatsportok_csatlakozas()) ) { // ha nem sikerult csatlakozni, akkor kilepunk
		return false;
	}
	
	
	// elokeszitjuk az utasitast
	$stmt = mysqli_prepare( $conn,"INSERT INTO segéd(csapat_név) VALUES (?)");
	
	// bekotjuk a parametereket (igy biztonsagosabb az adatkezeles)
	mysqli_stmt_bind_param($stmt, "s", $v_csap);
	
	// lefuttatjuk az SQL utasitast
	$sikeres = mysqli_stmt_execute($stmt); 
		// ez logikai erteket ad vissza, ami megmondja, hogy sikerult-e 
		// vegrehajtani az utasitast 
		
	mysqli_close($conn);
	
	// beszúrjuk az új rekordot az adatbázisba
	jatekosLekerCsapatSzerint();
	// visszatérünk az index.php-re
	header("Location: jatekosok.php");
    return $sikeres;
} else {
	error_log("Nincs beállítva valamely érték");
	
}




?>