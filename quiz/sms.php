<?php
header('Expires: Sun, 01 Jan 2014 00:00:00 GMT');
header('Cache-Control: no-store, no-cache, must-revalidate');
header('Cache-Control: post-check=0, pre-check=0', FALSE);
header('Pragma: no-cache');
header('Content-Type: text/html; charset=iso-8859-1');
include_once '../include/config.php';
$db = mysqli_connect($dbhost, $dbuser, $dbpass, $dbase);
// Test if connection ok
if (mysqli_connect_errno()) {
	die("Database connection failed 1: " . mysqli_connect_error() . " (" . mysqli_connect_errno() . ")");
}

// chercher et sélectionner la "seule" question ouverte
$query = "SELECT * FROM Question  WHERE Ouverte='oui' " ;
$result = mysqli_query($db, $query);
$row = mysqli_fetch_assoc($result);
$rowcount = mysqli_num_rows($result);
$IDQuest= $row['IdQuest'];
$NomOpe=$row['NomOpe'];

// sélection des propositions qui vont avec question
$query = "SELECT * FROM Propositions  WHERE IdQuest='$IDQuest' " ;
$result = mysqli_query($db, $query);
$rowcount = mysqli_num_rows($result);
$ArrIdProp=array();
$ArrBonRep=array();

// on construit un tableau pour récupérer l'Id de la prop et Bonne réponse
while ($row = mysqli_fetch_assoc($result)) {
	$ArrIdProp[]=$row['IdProp'];
	$ArrBonRep[]=$row['BonneRep'];
}
// foreach ($ArrIdProp as $value) { // assignation des valeurs dans tableau
// 	echo $value."<br>";
// }

// valeurs envoyées par Twilio
$repquiz = $_POST['Body'];
$numvotant=$_POST['From'];

// recherche dans la table votesms si le pax à déjà voté
$query = "SELECT * FROM votesms  WHERE numtel='$numvotant' AND idQuestsms='$IDQuest' " ;
$result = mysqli_query($db, $query);
$rowcountsms = mysqli_num_rows($result);

if ($rowcountsms==0) {

// boucle pour assigner les valeurs afin de les insérer ensuite
	for ($x = 0; $x <= $rowcount; $x++) {
	    if ($repquiz==$x) {
	    $repquiz="P".($x);
		$BonneRep=$ArrBonRep[($x-1)];
		$IdProp=$ArrIdProp[($x-1)];
		}
	 }

	// enregistrement de la reponse dans Reponses		
	$sql = "INSERT INTO Reponses (NomOpe, IDQuest, IdProp, Reponse, BonRep) VALUES ('$NomOpe', '$IDQuest','$IdProp', '$repquiz', '$BonneRep')";
			if ($db -> query($sql) === FALSE) {
					echo "Une erreur est survenue, veuillez nous en excuser" . $sql . "<br>" . $db -> error;
				} 
	// enregistrement de la reponse dans votesms
	$sql = "INSERT INTO votesms (numtel, idQuestsms) VALUES ('$numvotant','$IDQuest')";
			if ($db -> query($sql) === FALSE) {
					echo "Une erreur est survenue, veuillez nous en excuser" . $sql . "<br>" . $db -> error;
				} 

} // fin if rowcount
mysqli_free_result($result);
mysqli_close($db);

?>






<!DOCTYPE html >
<html>
		<head>
			
		</head>
		<body>
		
		</body>
	</html>
