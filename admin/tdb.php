<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 1);
session_start();
header('Expires: Sun, 01 Jan 2014 00:00:00 GMT');
header('Cache-Control: no-store, no-cache, must-revalidate');
header('Cache-Control: post-check=0, pre-check=0', FALSE);
header('Pragma: no-cache');
header('Content-Type: text/html; charset=UTF-8');

include_once '../include/config.php';
$db = mysqli_connect($dbhost, $dbuser, $dbpass, $dbase);
// Test if connection ok
if (mysqli_connect_errno()) {
	die("Database connection failed 1: " . mysqli_connect_error() . " (" . mysqli_connect_errno() . ")");
	}
//$ope=$_SESSION["dbdefault"];


// Choisir la base par defaut et création des variables session
if(isset($_GET["dbdef"])){

	if ($_GET["dbdef"]!=""){
		$_SESSION["dbdefault"] = $_GET["dbdef"];
		$ope=$_GET["dbdef"];
		$query = "SELECT * FROM Parametres  WHERE NomOpe='$ope' " ;
		$result = mysqli_query($db, $query);
		$row = mysqli_fetch_assoc($result);
		$rowcount = mysqli_num_rows($result);
		$_SESSION["GroupeAdmin"]=$row['Groupe'];
		$_SESSION["NbrGrpeAdmin"]=$row['NbrGroupe'];
		$_SESSION["NomEve"]=$row['NomOpe2'];
		$_SESSION["NomOpe3"]=$row['NomOpe3'];
    	$_SESSION["Logos"]=$row['Logo'];
	}
}
// pour supprimer une Operation
if(isset($_POST["sup"])){
	$sup=$_POST["sup"];
	if ($sup=="oui"){
	//echo "bla".$_GET["sup"].$_SESSION["dbdefault"];
	$basesup=$_SESSION["dbdefault"];
	$sql = "DELETE FROM Parametres WHERE NomOpe='$basesup'";
	if ($db->query($sql) === TRUE) {
    //echo "Record deleted successfully";
	} else {
    //echo "Error deleting record: " . $db->error;
	}
	$_SESSION["dbdefault"]=""; // remise à 0 de la variable ope par defaut
	$_SESSION["NomEve"]="";
	echo "<script type='text/javascript'>document.location.replace('tdb.php');</script>"; // retour index pour choix ope defaut
	}
}

// Test pour savoir si supprimer toutes les réponses
if(isset($_GET["vider"])){
	$vider=$_GET["vider"];
	echo "bla";
	if ($vider=="oui"){
	
	$base=$_GET["ba"];
	$nomop=$_SESSION["NomEve"];
	//$db = mysqli_connect($dbhost, $dbuser, $dbpass, $dbase);
	$sql = "DELETE FROM Reponses WHERE NomOpe='$nomop'";
	if ($db->query($sql) === TRUE) {
    //echo "Database created successfully";
	} else {
    //echo "Error creating database: " . $db->error;
	}

	//echo "<script type='text/javascript'>document.location.replace('listeope.php?liste=oui');</script>";
	}
}	

if (isset($_POST["submit"])) {
		$query = "SELECT * FROM Parametres" ; // pour déterminer le code unique de l'Opération
		$result = mysqli_query($db, $query);
		$rowcount = mysqli_num_rows($result);;


		$NomOpe3 = addslashes($_POST['NomOpe3']);
		$NomOpe2 = addslashes($_POST['NomOpe2']);
		$NomOpe = "OP".($rowcount+1);
		$DateDebutOpe = $_POST['DateDebutOpe'];
		$DateFinOpe = $_POST['DateFinOpe'];
		$MdpAdmin = addslashes($_POST['MdpAdmin']);
		$MdpUtil = addslashes($_POST['MdpUtil']);
		$ColTitre = $_POST['ColTitre'];
		$ColTxt = $_POST['ColTxt'];
		$ColBtn = addslashes($_POST['ColBtn']);
		$ColBoutVot = addslashes($_POST['ColBoutVot']);
		$ColTxtVot = addslashes($_POST['ColTxtVot']);
		$ColTitQuest = addslashes($_POST['ColTitQuest']);
		$ColBonRep = addslashes($_POST['ColBonRep']);
		$ModulQuiz = addslashes($_POST['ModulQuiz']);
		$ModulQuest = $_POST['ModulQuest'];
		$ModulFilInfo = $_POST['ModulFilInfo'];
		$Groupe = $_POST['Groupe'];
		$Temps = $_POST['Temps'];
		$NbrGroupe = $_POST['NbrGroupe'];
		$fileToUpload=basename( $_FILES["fileToUpload"]["name"]);
		$langue = $_POST['Langue'];
		$BackgCol = $_POST['BackgCol'];
		$fileToUpload2=basename( $_FILES["fileToUpload2"]["name"]);
	// création d'une variable session pour savoir si on gère des groupes ou non
		$_SESSION["GroupeAdmin"] = $Groupe;
	// création d'une variable session pour connaître le nbr de groupes
		$_SESSION["NbrGrpeAdmin"] = $NbrGroupe;
	// création d'une variable session pour définir l'Ope par défaut
		$_SESSION["dbdefault"]=$NomOpe;
		$_SESSION["NomEve"]=$NomOpe2;

	// enregistrement des mdp dans BASE Mdp et Table Mdp
		$sql= "INSERT INTO Mdp (NomOpe, NomOpe2, NomOpe3, MdpAdmin, MdpUtil) VALUES ('$NomOpe', '$NomOpe2', '$NomOpe3', '$MdpAdmin', '$MdpUtil') ";
		if ($db -> query($sql) === FALSE) {
				echo "Une erreur est survenue (insert), veuillez nous en excuser" . $sql . "<br>" . $db -> error;
			} 

	// mise à jour de la table Parametres
		$sql= "INSERT INTO Parametres (NomOpe, NomOpe2, NomOpe3,DateDebutOpe, DateFinOpe, MdpAdmin, MdpUtil, ColTitre, ColTxt, ColBtn, ColBoutVot, ColTxtVot, ColTitQuest, ColBonRep, ModulQuiz, ModulQuest, ModulFilInfo,Groupe, NbrGroupe, Temps, Logo, Langue, BackgCol, BackgImage) VALUES ('$NomOpe', '$NomOpe2', '$NomOpe3','$DateDebutOpe', '$DateFinOpe','$MdpAdmin','$MdpUtil', '$ColTitre', '$ColTxt', '$ColBtn' , '$ColBoutVot', '$ColTxtVot', '$ColTitQuest', '$ColBonRep', '$ModulQuiz', '$ModulQuest', '$ModulFilInfo','$Groupe', '$NbrGroupe','$Temps', '$fileToUpload', '$langue', '$BackgCol', '$fileToUpload2') ";
		if ($db -> query($sql) === FALSE) {
				echo "Une erreur est survenue (insert), veuillez nous en excuser" . $sql . "<br>" . $db -> error;
			}
		
	
	// Routine pour l'upload d'images (logo)
		$target_dir = "/home/solleaweab/www/logos/";
		$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
		$uploadOk = 1;
		$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

		if (file_exists($target_file)) {
    		//echo "Sorry, file already exists.";
    		$uploadOk = 0;
		}

		// Check file size
		if ($_FILES["fileToUpload"]["size"] > 500000) {
    		//echo "Sorry, your file is too large.";
    		$uploadOk = 0;
		}

		if ($uploadOk == 0) {
    		//echo "Sorry, your file was not uploaded.";
		// if everything is ok, try to upload file
		} else {
    	if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        //echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
    	} else {
        //echo "Sorry, there was an error uploading your file.". basename( $_FILES["fileToUpload"]["name"]);
    	}
		}

	// routine pour l'upload Image de fond
		if(basename($_FILES["fileToUpload2"]["name"])!=""){
			$target_dir2 = "/home/solleaweab/www/logos/";
			$target_file2 = $target_dir2 . basename($_FILES["fileToUpload2"]["name"]);
			$uploadOk2 = 1;
			$imageFileType2 = strtolower(pathinfo($target_file2,PATHINFO_EXTENSION));
			//echo basename($_FILES["fileToUpload2"]["name"]);
		}else {
		 	$fileToUpload2=$Logo;
		}

		if ($uploadOk2 == 0) {
    		//echo "Sorry, your file was not uploaded.";
			// if everything is ok, try to upload file
			} else {
    		if (move_uploaded_file($_FILES["fileToUpload2"]["tmp_name"], $target_file2)) {
        	//echo "The file ". basename( $_FILES["fileToUpload2"]["name"]). " has been uploaded.";
    		} else {
        	//echo "Sorry, there was an error uploading your file.". basename( $_FILES["fileToUpload2"]["name"]);
    		}
		}	

		if (file_exists($target_file2)) {
			//echo "Sorry, file already exists.";
			$uploadOk2 = 0;
			}
		// Check file size
		if ($_FILES["fileToUpload2"]["size"] > 500000) {
			//echo "Sorry, your file is too large.";
			$uploadOk2 = 0;
			}	

} 	
?>

<head>
	<meta http-equiv="Cache-control" content="no-cache">
	<meta http-equiv="Expires" content="-1">
	<meta name="apple-mobile-web-app-capable" content="yes" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="apple-touch-icon" href="imgs/icon-touchmots.png"/>
	<meta name="apple-mobile-web-app-title" content="Ipad v2">
	<title>Ipad v2 - Index</title>
	<link  rel="stylesheet" href="../css/main.css?v=166">
	<meta Charset='UTF-8'>
</head>

<!DOCTYPE html >
<body>
<div class="start">
	<div class="titre">
		<div class="logo">
		<img src="../imgs/logosollea.png" alt="" class="responsiveimgs">
		</div>
		<div class="nomOpAdm">
			<span class="TitreAdmin3">Administration</span>
			<span class="TitreAdmin4"><?php echo $_SESSION["NomEve"]; ?></span>
		</div>
	</div>


			
<div class="corps">
	
	<div class="box">
		<div class="soustitre">
			Quiz
		</div>
		<div class="bouton centretext sizetxtbout" style="cursor: pointer;" onclick="window.location='saisiequestion.php';">
			Saisir Question
		</div>
		<div class="bouton centretext sizetxtbout" style="cursor: pointer;" onclick="window.location='listequestions.php';">
			Liste Questions
		</div>
		<div class="bouton centretext sizetxtbout" style="cursor: pointer;" onclick="window.location='../quiz/stats.php';">
			Statistiques
		</div>
	</div>


	<div class="box">
		<div class="soustitre">
			Questions
		</div>
		<div class="bouton centretext sizetxtbout">
			xx xxx
		</div>
		<div class="bouton centretext sizetxtbout">
			xx xx
		</div>
		<div class="bouton centretext sizetxtbout">
			xx xx
		</div>
	</div>

	<div class="box">
		<div class="soustitre">
			Fil Infos
		</div>
		<div class="bouton centretext sizetxtbout">
			xx xxx
		</div>
		<div class="bouton centretext sizetxtbout">
			xx xx
		</div>
		<div class="bouton centretext sizetxtbout">
			xx xx
		</div>
	</div>


	<div class="box">
		<div class="soustitre">
			Param&egrave;tres
		</div>
		<?php if($_SESSION["Admin"]=="oui") { ?>
		<div class="bouton centretext sizetxtbout" style="cursor: pointer;" onclick="window.location='ajoutope.php';">
			Cr&eacute;er Op&eacute;ration
		</div>
		<?php } ?>
		<div class="bouton centretext sizetxtbout" style="cursor: pointer;" onclick="window.location='modifope.php';">
			Modifier Opération
		</div>
		<?php if($_SESSION["Admin"]=="oui") { ?>
		<div class="bouton centretext sizetxtbout" style="cursor: pointer;" onclick="window.location='listop.php?liste=oui';">
			Choisir évén. par défaut
		</div>
		<?php } ?>
	</div>

</div>
</div>
		<?php
		mysqli_free_result($result); 
		mysqli_close($db);
		?>	
			
</body>
</html>