<?php

include_once("fuggvenyek.php"); // fel fugjuk használni ezeket a függvényeket

// lekérjük a POST-tal átlküldött paramétereket,
// ellenőrizzük azt is, hogy kaptak-e értéket



$v_dat = $_POST['date'];
$new_date = date("Y/m/d", strtotime($v_dat));
$v_hazg = $_POST['hazg'];
$v_veng = $_POST['veng'];
$v_haz = $_POST['hazcs'];
$v_ven = $_POST['vencs'];




if ( isset($new_date) && 
     isset($v_hazg) && isset($v_veng) && isset($v_haz) &&
     isset($v_ven)) {
	
	
	// beszúrjuk az új rekordot az adatbázisba
	meccs_beszur($new_date, $v_hazg, $v_veng, $v_haz, $v_ven);
	$id=MeccsID2();

	while( $egySor = mysqli_fetch_assoc($id) ) {
		$valami=($egySor["meccs_id"]);
	}
	kinyer($v_hazg,$v_haz,$v_ven,$v_veng);
	id_beszur($valami);
	mysqli_free_result($id);

	
	header("Location: meccs.php");

} else {
	error_log("Nincs beállítva valamely érték");
	
}

kinyer($v_hazg,$v_haz,$v_ven,$v_veng);


?>