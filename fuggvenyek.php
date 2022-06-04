<?php
//Celluska Attila
//T4XSEH
//h647738

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//csatlakozás az adatbázishoz

function csapatsportok_csatlakozas(){
    $conn = mysqli_connect("localhost", "root", "") or die("Csatlakozási hiba");
	if ( false == mysqli_select_db($conn, "csapatsportok" )  ) {
		
		return null;
	}
	
	// a karakterek helyes megjelenítése miatt be kell állítani a karakterkódolást!
	mysqli_query($conn, 'SET NAMES UTF-8');
	mysqli_query($conn, 'SET character_set_results=utf8');
	mysqli_set_charset($conn, 'utf8');
	
	return $conn;	
}
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//csapatok oldat által használt függvények

//csapat adattag lekérése az adatbázisból a csapetfelvitel táblázat select részéhez
function csapatoklistatLeker() {
	
	if ( !($conn = csapatsportok_csatlakozas()) ) { // ha nem sikerult csatlakozni, akkor kilepunk
		return false;
	}
	
	// elokeszitjuk az utasitast
	$result = mysqli_query( $conn,"SELECT csapat FROM csapat");
	
	mysqli_close($conn);
	return $result;
}
//csapat táblázat adatainak lekérése 
function csapatokLeker() {
	
	if ( !($conn = csapatsportok_csatlakozas()) ) { // ha nem sikerult csatlakozni, akkor kilepunk
		return false;
	}
	
	// elokeszitjuk az utasitast
	$result = mysqli_query( $conn,"SELECT név, döntetlen, győzelem, stadion, vereség, város FROM csapat ORDER BY győzelem DESC");
	
	mysqli_close($conn);
	return $result;
	
}
//adatok mentése a csapat táblázatba
function csapat_beszur($csapat, $gyoz, $don, $ver, $stadion, $varos){

    if ( !($conn = csapatsportok_csatlakozas()) ) { // ha nem sikerult csatlakozni, akkor kilepunk
		return false;
	}
	
	
	// elokeszitjuk az utasitast
	$stmt = mysqli_prepare( $conn,"INSERT INTO csapat(név, döntetlen, győzelem, stadion, vereség, város) VALUES (?, ?, ?, ?, ? ,?)");
	
	// bekotjuk a parametereket (igy biztonsagosabb az adatkezeles)
	mysqli_stmt_bind_param($stmt, "sddsds", $csapat, $don, $gyoz, $stadion, $ver, $varos );
	
	// lefuttatjuk az SQL utasitast
	$sikeres = mysqli_stmt_execute($stmt); 
		// ez logikai erteket ad vissza, ami megmondja, hogy sikerult-e 
		// vegrehajtani az utasitast 
		
	mysqli_close($conn);
	return $sikeres;
	
}
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//meccs oldat által használt függvények

//adatok lekérése a meccs táblázatból
function meccsLeker() {
	
	if ( !($conn = csapatsportok_csatlakozas()) ) { // ha nem sikerult csatlakozni, akkor kilepunk
		return false;
	}
	
	// elokeszitjuk az utasitast
	$result = mysqli_query( $conn,"SELECT meccs_id, dátum, hazai_gól, vendég_gól, hazai_csapat, vendég_csapat FROM meccs");
	
	mysqli_close($conn);
	return $result;
	
}
//adatok feltöltése a meccs és a segéd táblázatba
function meccs_beszur($dátum, $hazg, $veng, $haz, $ven){

    if ( !($conn = csapatsportok_csatlakozas()) ) { // ha nem sikerult csatlakozni, akkor kilepunk
		return false;
	}
	
	
	// elokeszitjuk az utasitast
	$stmt = mysqli_prepare( $conn,"INSERT INTO meccs(dátum, hazai_gól, vendég_gól, hazai_csapat, vendég_csapat) VALUES (?, ?, ?, ? ,?)");
	
	// bekotjuk a parametereket (igy biztonsagosabb az adatkezeles)
	mysqli_stmt_bind_param($stmt, "siiss", $dátum, $hazg, $veng, $haz, $ven );
	
	// lefuttatjuk az SQL utasitast
	$sikeres = mysqli_stmt_execute($stmt); 
		// ez logikai erteket ad vissza, ami megmondja, hogy sikerult-e 
		// vegrehajtani az utasitast 
	mysqli_close($conn);

	if ( !($conn = csapatsportok_csatlakozas()) ) { // ha nem sikerult csatlakozni, akkor kilepunk
		return false;
	}
	
	
	// elokeszitjuk az utasitast
	$stmt1 = mysqli_prepare( $conn,"INSERT INTO segéd(h_gol,v_gol,h_assz,v_assz) VALUES (?, ?, ?, ?)");
	
	// bekotjuk a parametereket (igy biztonsagosabb az adatkezeles)
	mysqli_stmt_bind_param($stmt1, "iiii", $hazg, $veng, $hazg, $veng);
	
	// lefuttatjuk az SQL utasitast
	$sikeres1 = mysqli_stmt_execute($stmt1); 
		// ez logikai erteket ad vissza, ami megmondja, hogy sikerult-e 
		// vegrehajtani az utasitast 
	mysqli_close($conn);

	return $sikeres1;

	if ( !($conn = csapatsportok_csatlakozas()) ) { // ha nem sikerult csatlakozni, akkor kilepunk
		return false;
	}
	$stmt2 = mysqli_prepare( $conn,"SELECT meccs_id FROM meccs INSERT INTO segéd(meccs_id) VALUES meccs_id");
	$sikeres2 = mysqli_stmt_execute($stmt2); 	
	mysqli_close($conn);
	return $sikeres2;
	
}
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//játékos oldat által használt függvények

//adatok feltöltése a játékos táblázatba
function jatekos_beszur($nev, $mezszám, $poz, $csapat, $nemzetseg){
	if ( !($conn = csapatsportok_csatlakozas()) ) { // ha nem sikerult csatlakozni, akkor kilepunk
		return false;
	}
	
	
	// elokeszitjuk az utasitast
	$stmt = mysqli_prepare( $conn,"INSERT INTO játékos(játékos_név, mez_szám , pozició, csapat, nemzetség) VALUES (?, ?, ?, ? ,?)");
	
	// bekotjuk a parametereket (igy biztonsagosabb az adatkezeles)
	mysqli_stmt_bind_param($stmt, "sisss", $nev, $mezszám, $poz, $csapat, $nemzetseg);
	
	// lefuttatjuk az SQL utasitast
	$sikeres = mysqli_stmt_execute($stmt); 
		// ez logikai erteket ad vissza, ami megmondja, hogy sikerult-e 
		// vegrehajtani az utasitast 
		
	mysqli_close($conn);
	return $sikeres;
	

}
// csapat táblázat név adattagjának lekérése a játékosmentés táblázat select részéhez 
function csapatLeker() {
	
	if ( !($conn = csapatsportok_csatlakozas()) ) { // ha nem sikerult csatlakozni, akkor kilepunk
		return false;
	}
	
	// elokeszitjuk az utasitast
	$result = mysqli_query( $conn,"SELECT név FROM csapat");
	
	mysqli_close($conn);
	return $result;
}

//adatok lekérése a játékos táblázatból
function jatekosLeker(){
	if ( !($conn = csapatsportok_csatlakozas()) ) { // ha nem sikerult csatlakozni, akkor kilepunk
		return false;
	}
	
	// elokeszitjuk az utasitast
	$result = mysqli_query( $conn,"SELECT játékos_név, mez_szám , pozició, csapat, nemzetség FROM játékos");
	
	mysqli_close($conn);
	return $result;
	
}
//adatok lekérése a csapatok szerinti lekéréshez
function jatekosLekerCsapatSzerint(){
	if ( !($conn = csapatsportok_csatlakozas()) ) { // ha nem sikerult csatlakozni, akkor kilepunk
		return false;
	}
	
	// elokeszitjuk az utasitast
	$result = mysqli_query( $conn,"SELECT játékos.játékos_név, játékos.mez_szám , játékos.pozició, játékos.csapat, játékos.nemzetség, segéd.csapat_név FROM játékos,segéd WHERE játékos.csapat = segéd.csapat_név");

	mysqli_close($conn);
	return $result;	
}
//segéd táblázat üritése
function urit(){
	if ( !($conn = csapatsportok_csatlakozas()) ) { // ha nem sikerult csatlakozni, akkor kilepunk
		return false;
	}
	$stmt1 = mysqli_prepare( $conn,"UPDATE segéd SET segéd.csapat_név = NULL");
	$sikeres1 = mysqli_stmt_execute($stmt1); 	
	mysqli_close($conn);
	return $sikeres1;	
}
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//lovostatisztika oldat által használt függvények

//góllövő_lista táblázat adatainak lekérése
function statLeker(){
	if ( !($conn = csapatsportok_csatlakozas()) ) { // ha nem sikerult csatlakozni, akkor kilepunk
		return false;
	}
	
	// elokeszitjuk az utasitast
	$result = mysqli_query( $conn,"SELECT név, lőtt_gól , gólpassz FROM góllövő_lista");
	
	mysqli_close($conn);
	return $result;
}

//eldönti egy meccsen melyik csapat nyer,veszit,döntetlent játszik, majd updateli a csapat táblázatot
function kinyer($hazg,$haz,$ven,$veng){
	if ( !($conn = csapatsportok_csatlakozas()) ) { // ha nem sikerult csatlakozni, akkor kilepunk
		return false;
	}

	if($hazg > $veng){
		$stmt1 = mysqli_prepare( $conn,"UPDATE csapat SET győzelem = 1 WHERE név = ?");
		$stmt2 = mysqli_prepare( $conn,"UPDATE csapat SET vereség = 1 WHERE név = ?");
		mysqli_stmt_bind_param($stmt1, "s", $haz);
		mysqli_stmt_bind_param($stmt2, "s", $ven);
		$sikeres1 = mysqli_stmt_execute($stmt1);
		$sikeres2 = mysqli_stmt_execute($stmt2);
		mysqli_close($conn);
		return $sikeres2; 
	}else if($hazg === $veng){
		$stmt3 = mysqli_prepare( $conn,"UPDATE csapat SET döntetlen = 1 WHERE név = ?");
		$stmt4 = mysqli_prepare( $conn,"UPDATE csapat SET döntetlen = 1 WHERE név = ?");
		mysqli_stmt_bind_param($stmt3, "s", $haz);
		mysqli_stmt_bind_param($stmt4, "s", $ven);
		$sikeres3 = mysqli_stmt_execute($stmt3);
		$sikeres4 = mysqli_stmt_execute($stmt4);
		mysqli_close($conn);
		return $sikeres4; 
	}else {
		$stmt5 = mysqli_prepare( $conn,"UPDATE csapat SET győzelem = 1 WHERE név = ?");
		$stmt6 = mysqli_prepare( $conn,"UPDATE csapat SET vereség = 1 WHERE név = ?");
		mysqli_stmt_bind_param($stmt5, "s", $ven);
		mysqli_stmt_bind_param($stmt6, "s", $haz);
		$sikeres5 = mysqli_stmt_execute($stmt5);
		$sikeres6 = mysqli_stmt_execute($stmt6);
		mysqli_close($conn);
		return $sikeres6; 
	}

}
//rendezi a táblázatot a legtöbb gólt rúgó játékos alapjén
function kiraly(){
	if ( !($conn = csapatsportok_csatlakozas()) ) { // ha nem sikerult csatlakozni, akkor kilepunk
		return false;
	}
	
	// elokeszitjuk az utasitast
	$result = mysqli_query( $conn,"SELECT név, SUM(lőtt_gól) AS max FROM góllövő_lista GROUP BY név ORDER BY max DESC LIMIT 10");
	
	mysqli_close($conn);
	return $result;
}
//hazai csapat lekérése csapat táblázatból, a gól mentés miatt
function hazaicsapatleker(){
	if ( !($conn = csapatsportok_csatlakozas()) ) { // ha nem sikerult csatlakozni, akkor kilepunk
		return false;
	}
	
	// elokeszitjuk az utasitast
	$result = mysqli_query( $conn,"SELECT hazai_csapat, hazai_gól, meccs_id FROM meccs ORDER BY meccs_id DESC LIMIT 1");
	//SELECT * FROM Table ORDER BY ID DESC LIMIT 1
	mysqli_close($conn);
	return $result;
}
//vendég csapat lekérése csapat táblázatból, a gól mentés miatt
function vendegcsapatleker(){
	if ( !($conn = csapatsportok_csatlakozas()) ) { // ha nem sikerult csatlakozni, akkor kilepunk
		return false;
	}
	
	// elokeszitjuk az utasitast
	$result = mysqli_query( $conn,"SELECT vendég_gól, vendég_csapat, meccs_id FROM meccs ORDER BY meccs_id DESC LIMIT 1");
	
	mysqli_close($conn);
	return $result;
}
//hazai játékosok lekérése csapat táblázatból, a gól mentés miatt
function Hazaijatekosok(){
	if ( !($conn = csapatsportok_csatlakozas()) ) { // ha nem sikerult csatlakozni, akkor kilepunk
		return false;
	}
	
	// elokeszitjuk az utasitast
	$result = mysqli_query( $conn,"SELECT játékos.játékos_név, meccs.hazai_csapat, játékos.csapat,meccs.meccs_id FROM játékos,meccs WHERE játékos.csapat = meccs.hazai_csapat ORDER BY meccs_id DESC LIMIT 4");

	mysqli_close($conn);
	return $result;	
}
//adatok feltöltése a góllövő_lista és a segéd táblába
function golbeszur($jatekos, $gol, $assz){
	if ( !($conn = csapatsportok_csatlakozas()) ) { // ha nem sikerult csatlakozni, akkor kilepunk
		return false;
	}

	$stmt2 = mysqli_prepare( $conn,"INSERT INTO góllövő_lista(név,lőtt_gól,gólpassz) VALUES (?,?,?)");
	
	mysqli_stmt_bind_param($stmt2, "sii", $jatekos, $gol, $assz);
	
	// lefuttatjuk az SQL utasitast
	$sikeres = mysqli_stmt_execute($stmt2); 
		// ez logikai erteket ad vissza, ami megmondja, hogy sikerult-e 
		// vegrehajtani az utasitast 
		
	mysqli_close($conn);
	return $sikeres;
if($gol=0 && $assz =0){
		$stmt = mysqli_prepare( $conn,"UPDATE segéd SET segéd.meccs_id = 0, segéd.h_gol = 0, segéd.v_gol = 0, segéd.h_assz = 0, segéd.v_assz = 0");
		
		$sikeres1 = mysqli_stmt_execute($stmt); 	
		mysqli_close($conn);
		return $sikeres;	
	}
}
//segéd táblázat egyik felének ürítése
function urit2($gol,$assz){
	if ( !($conn = csapatsportok_csatlakozas()) ) { // ha nem sikerult csatlakozni, akkor kilepunk
		return false;
	}
	$stmt1 = mysqli_prepare( $conn,"UPDATE segéd SET segéd.h_gol = segéd.h_gol-$gol, segéd.h_assz=segéd.h_assz-$assz");
	$sikeres1 = mysqli_stmt_execute($stmt1); 	
	mysqli_close($conn);
	return $sikeres1;
}
//segéd táblázat másik felének ürítése
function urit3($gol,$assz){
	if ( !($conn = csapatsportok_csatlakozas()) ) { // ha nem sikerult csatlakozni, akkor kilepunk
		return false;
	}
	$stmt1 = mysqli_prepare( $conn,"UPDATE segéd SET segéd.v_gol = segéd.v_gol-$gol, segéd.v_assz=segéd.v_assz-$assz");
	$sikeres1 = mysqli_stmt_execute($stmt1); 	
	mysqli_close($conn);
	return $sikeres1;
}
//hazai rúgott gólok lekérése , hogy be tudjuk állítani ki mennyit lőtt
function kiosztottHgolok(){
	if ( !($conn = csapatsportok_csatlakozas()) ) { // ha nem sikerult csatlakozni, akkor kilepunk
		return false;
	}
	// elokeszitjuk az utasitast
	$result = mysqli_query( $conn,"SELECT h_gol FROM segéd");
	
	mysqli_close($conn);
	return $result;
}
//hazai gólpasszok lekérése
function hasziszt(){
	if ( !($conn = csapatsportok_csatlakozas()) ) { // ha nem sikerult csatlakozni, akkor kilepunk
		return false;
	}
	// elokeszitjuk az utasitast
	$result = mysqli_query( $conn,"SELECT h_assz FROM segéd");
	
	mysqli_close($conn);
	return $result;
}
//vendég gólpasszok lekérése
function vasziszt(){
	if ( !($conn = csapatsportok_csatlakozas()) ) { // ha nem sikerult csatlakozni, akkor kilepunk
		return false;
	}
	// elokeszitjuk az utasitast
	$result = mysqli_query( $conn,"SELECT v_assz FROM segéd");
	
	mysqli_close($conn);
	return $result;
}
//vendég gólok lekérése lekérése
function kiosztottVgolok(){
	if ( !($conn = csapatsportok_csatlakozas()) ) { // ha nem sikerult csatlakozni, akkor kilepunk
		return false;
	}
	
	// elokeszitjuk az utasitast
	$result = mysqli_query( $conn,"SELECT v_gol, v_assz FROM segéd");
	
	mysqli_close($conn);
	return $result;
}
//vendégjátékosok gólok lekérése
function Vendegjatekosok(){
	if ( !($conn = csapatsportok_csatlakozas()) ) { // ha nem sikerult csatlakozni, akkor kilepunk
		return false;
	}
	
	// elokeszitjuk az utasitast
	$result = mysqli_query( $conn,"SELECT játékos.játékos_név, meccs.vendég_csapat, játékos.csapat,meccs.meccs_id FROM játékos,meccs WHERE játékos.csapat = meccs.vendég_csapat ORDER BY meccs_id DESC LIMIT 4");

	mysqli_close($conn);
	return $result;	
}
//meccs_id lekérése a segéd táblázatból
function MeccsID(){
	if ( !($conn = csapatsportok_csatlakozas()) ) { // ha nem sikerult csatlakozni, akkor kilepunk
		return false;
	}
	
	// elokeszitjuk az utasitast
	$result = mysqli_query( $conn,"SELECT meccs_id FROM segéd");

	mysqli_close($conn);
	return $result;	
}
//meccs_id lekérése a meccs táblázatból
function MeccsID2(){
	if ( !($conn = csapatsportok_csatlakozas()) ) { // ha nem sikerult csatlakozni, akkor kilepunk
		return false;
	}
	
	// elokeszitjuk az utasitast
	$result = mysqli_query( $conn,"SELECT meccs_id FROM meccs");

	mysqli_close($conn);
	return $result;	
}
//id feltöltése a segéd táblázat meccs_id részébe
function id_beszur($id){
	if ( !($conn = csapatsportok_csatlakozas()) ) { // ha nem sikerult csatlakozni, akkor kilepunk
		return false;
	}
	$stmt = mysqli_prepare( $conn,"UPDATE segéd SET segéd.meccs_id = segéd.meccs_id+$id");
	
	$sikeres1 = mysqli_stmt_execute($stmt); 	
	mysqli_close($conn);
	return $sikeres;
}
//segéd táblázat ürítése
function segédvissza($hgol,$vgol,$hassz,$vassz){
	if ($hgol<=0 && $vgol<=0 && $hassz<=0 && $vassz<=0){
		if ( !($conn = csapatsportok_csatlakozas()) ) { // ha nem sikerult csatlakozni, akkor kilepunk
			return false;
		}
		$result=mysqli_query($conn,'TRUNCATE TABLE segéd');
		 	
		mysqli_close($conn);
		return $result;
	}
}
//góllövő lista adatainak rendezése legtöbb gólpassz alapján
function passz(){
	if ( !($conn = csapatsportok_csatlakozas()) ) { // ha nem sikerult csatlakozni, akkor kilepunk
		return false;
	}
	
	// elokeszitjuk az utasitast
	$result = mysqli_query( $conn,"SELECT név, SUM(gólpassz) AS sum FROM góllövő_lista GROUP BY név ORDER BY sum DESC LIMIT 10");
	
	mysqli_close($conn);
	return $result;
}

?>


