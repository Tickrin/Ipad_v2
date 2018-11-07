<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 1);
session_start();
header('Expires: Sun, 01 Jan 2014 00:00:00 GMT');
header('Cache-Control: no-store, no-cache, must-revalidate');
header('Cache-Control: post-check=0, pre-check=0', FALSE);
header('Pragma: no-cache');
header('Content-Type: text/html; charset=UTF-8');

$base=$_SESSION["dbdefault"]; //pour récupérer le nom base 

include_once '../include/config.php';
$db = mysqli_connect($dbhost, $dbuser, $dbpass, $dbase);
// Test if connection ok
if (mysqli_connect_errno()) {
	die("Database connection failed 1: " . mysqli_connect_error() . " (" . mysqli_connect_errno() . ")");
}

// routine pour supprimer image de fond
if(isset($_GET["bki"])){
	$fileToUpload2 ="";
	$_FILES["fileToUpload2"]["name"]="";
	$sql = "UPDATE Parametres  SET BackgImage=? WHERE NomOpe=? ";
		$stmt = $db->prepare($sql);
        $stmt->bind_param("ss", $fileToUpload2, $base);
        $stmt->execute();
        $stmt->close();
}

// routine pour supprimer le logo
if(isset($_GET["log"])){
	$Logo="";
	$sql = "UPDATE Parametres  SET Logo=? WHERE NomOpe=? ";
		$stmt = $db->prepare($sql);
        $stmt->bind_param("ss", $Logo, $base);
        $stmt->execute();
        $stmt->close();
}

if (isset($_POST["submit3"])) { // routine pour la MAJ
		$base=$_SESSION["dbdefault"];
		$NomOpe=$_SESSION["dbdefault"];
		$NomOpe2 = test_input(addslashes($_POST['NomOpe2']));
		$NomOpe3 = test_input(addslashes($_POST['NomOpe3']));
		$DateDebutOpe = test_input($_POST['DateDebutOpe']);
		$DateFinOpe = test_input($_POST['DateFinOpe']);
		$MdpAdmin = test_input(addslashes($_POST['MdpAdmin']));
		$MdpUtil = test_input(addslashes($_POST['MdpUtil']));
		$ColTitre = test_input($_POST['ColTitre']);
		$ColTxt = test_input($_POST['ColTxt']);
		$ColBtn = test_input(addslashes($_POST['ColBtn']));
		$ColBoutVot = test_input(addslashes($_POST['ColBoutVot']));
		$ColTxtVot = test_input(addslashes($_POST['ColTxtVot']));
		$ColTitQuest = test_input(addslashes($_POST['ColTitQuest']));
		$ColBonRep = test_input(addslashes($_POST['ColBonRep']));
		$ModulQuiz = test_input($_POST['ModulQuiz']);
		$ModulQuest = test_input($_POST['ModulQuest']);
		$ModulFilInfo = test_input($_POST['ModulFilInfo']);
		$Groupe = test_input($_POST['Groupe']);
		$NbrGroupe = test_input($_POST['NbrGroupe']);
		$Temps = test_input($_POST['Temps']);
		$Logo=test_input($_POST['Logo']);
		$BackgImage=test_input($_POST['BackgImage']);
		$fileToUpload=test_input(basename($_FILES["fileToUpload"]["name"]));
		$langue=test_input($_POST['Langue']);
		$BackgCol = test_input($_POST['BackgCol']);
		$fileToUpload2=test_input(basename($_FILES["fileToUpload2"]["name"]));
		
		
		
		// création d'un cookie pour savoir si on gère des groupes ou non
		$_SESSION["GroupeAdmin"] = $Groupe;
		
		// création d'un cookie pour connaître le nbr de groupes
		$_SESSION["NbrGrpeAdmin"] = $NbrGroupe;

		// création d'une variable session pour connaître la couleur de fond
		$_SESSION["BackgCol"] = $BackgCol;

		// mise à jour paramètres
		$db = mysqli_connect($dbhost, $dbuser, $dbpass, $dbase);
		// Test if connection ok
		if (mysqli_connect_errno()) {
		die("Database connection failed 1: " . mysqli_connect_error() . " (" . mysqli_connect_errno() . ")");
		}

		// routine pour l'upload logo
			if(basename($_FILES["fileToUpload"]["name"])!=""){
			$target_dir = "/home/solleaweab/www/logos/";
			$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
			$uploadOk = 1;
			$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
			//echo basename($_FILES["fileToUpload"]["name"]);
			}else {
			 	$fileToUpload=$Logo;
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

			if (file_exists($target_file)) {
    		//echo "Sorry, file already exists.";
    		$uploadOk = 0;
			}
			// Check file size
			if ($_FILES["fileToUpload"]["size"] > 500000) {
    		//echo "Sorry, your file is too large.";
    		$uploadOk = 0;
			}

			// routine pour l'upload Image de fond
			if(basename($_FILES["fileToUpload2"]["name"])!=""){
			$target_dir2 = "/home/solleaweab/www/logos/";
			$target_file2 = $target_dir2 . basename($_FILES["fileToUpload2"]["name"]);
			$uploadOk2 = 1;
			$imageFileType2 = strtolower(pathinfo($target_file2,PATHINFO_EXTENSION));
			//echo basename($_FILES["fileToUpload2"]["name"]);
			}else {
			 	$fileToUpload2=$BackgImage;
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

		$sql = "UPDATE Parametres  SET NomOpe=?, NomOpe2=?,NomOpe3=?,DateDebutOpe=?, DateFinOpe=?,MdpAdmin=?,MdpUtil=?, ColTitre=?, ColTxt=?, ColBtn=?, ColBoutVot=?, ColTxtVot=?, ColTitQuest=?, ColBonRep=?, ModulQuiz=?, ModulQuest=?, ModulFilInfo=?, Groupe=?, NbrGroupe=?, Temps=?, Logo=?, Langue=? , BackgCol=?, BackgImage=? WHERE NomOpe=? ";


		$stmt = $db->prepare($sql);
        $stmt->bind_param("ssssssssssssssssssiisssss", $NomOpe, $NomOpe2, $NomOpe3, $DateDebutOpe, $DateFinOpe, $MdpAdmin, $MdpUtil, $ColTitre, $ColTxt, $ColBtn, $ColBoutVot, $ColTxtVot, $ColTitQuest, $ColBonRep, $ModulQuiz, $ModulQuest, $ModulFilInfo, $Groupe, $NbrGroupe, $Temps, $fileToUpload, $langue, $BackgCol, $fileToUpload2,$NomOpe);
        $stmt->execute();
        $stmt->close();
			
		// mise à jour des mdp dans BASE Motdp
		//$basemdp="Motdp";
		// $db2 = mysqli_connect($dbhost, $dbuser, $dbpass, $dbase);
		// // Test if connection ok
		// if (mysqli_connect_errno()) {
		// die("Database connection failed 1: " . mysqli_connect_error() . " (" . mysqli_connect_errno() . ")");
		// }


		$sql2 = "UPDATE Mdp  SET NomOpe=?, NomOpe2=?,NomOpe3=?,MdpAdmin=?,MdpUtil=? WHERE NomOpe=? ";
			$stmt = $db->prepare($sql2);
        	$stmt->bind_param("ssssss", $NomOpe, $NomOpe2, $NomOpe3, $MdpAdmin, $MdpUtil, $NomOpe);
        	$stmt->execute();
        	$stmt->close();

			//echo "<script type='text/javascript'>document.location.replace('tdb.php');</script>";

	} 

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}



$sql = "SELECT * FROM Parametres  WHERE NomOpe=? " ;
		$stmt = $db->prepare($sql);
        $stmt->bind_param("s", $base);
        $stmt->execute();
        $stmt->store_result(); 
        $rowcount = $stmt->num_rows(); 
        $stmt->bind_result($IdOpe, $NomOpe, $NomOpe2, $NomOpe3, $DateDebutOpe, $DateFinOpe, $MdpAdmin, $MdpUtil, $ColTitre, $ColTxt, $ColBtn, $ColBoutVot, $ColTxtVot, $ColTitQuest, $ColBonRep, $ModulQuiz, $ModulQuest, $ModulFilInfo, $Groupe, $NbrGroupe, $Temps, $Logo, $langue, $BackgCol, $BackgImage);

	
	?>

		<head>
			<meta http-equiv="Cache-control" content="no-cache">
			<meta http-equiv="Expires" content="-1">
			<meta name="apple-mobile-web-app-capable" content="yes" />
			<meta name="viewport" content="width=device-width, initial-scale=1">
			<link rel="apple-touch-icon" href="imgs/icon-touchmots.png"/>
			<meta name="apple-mobile-web-app-title" content="Ipad v2">
			<title>Ipad v2 - Ajout Ope</title>
			<link  rel="stylesheet" href="../css/main.css?v=322">
			
			<!-- Pour Color Picker -->
  			<link rel="stylesheet" href="../css/bootstrap-3.0.0.min.css">
  			<link rel="stylesheet" href="../css/pick-a-color-1.2.3.min.css">
  			<!-- fin color picker -->

  			<!-- Pour Date Picker : -->
			<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  			<link rel="stylesheet" href="/resources/demos/style.css">
  			<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  			<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  			<!-- fin date picker -->
			<script>
  			$( function() {
    		$( "#datepicker" ).datepicker();
  			} );
  			</script>
  			<script>
  			$( function() {
    		$( "#datepicker2" ).datepicker();
  			} );
  			</script>
  			<script>
			function validateFormsup() {
    		var x = document.forms["suppeve"]["sup"].value;
    		if (x == "") {
        	alert("Voulez-vous vraiment supprimer cet événement ?");
        	return false;
    		}
			}
			</script>

			<meta Charset='UTF-8'>
		</head>

<!DOCTYPE html >
<style type="text/css">

	input[type=checkbox] {
  	transform: scale(1);
	}

	.checkB {
   	margin-left: 50px;
   	margin-bottom: 20px;
    border-radius: 50px;
    }

	.champs {
  	background-color : white;
  	-webkit-border-radius: 5px;
  	border-radius: 5px;
	}

	.valider{
	-webkit-appearance: none;
	padding:10px 25px;
	width:200px; 
    background:green;
    font-weight:bold;
    font-size:1em;
    color:white; 
    border:0 white;
    cursor:pointer;
    -webkit-border-radius: 5px;
    border-radius: 5px; 
	}

	.vider{
	-webkit-appearance: none;
	padding:10px; 
	width:200px;
    background:FireBrick;
    font-weight:bold;
    font-size:1em;
    color:white; 
    border:0 white;
    cursor:pointer;
    -webkit-border-radius: 5px;
    border-radius: 5px; 
	}	
	
	.visualiser{
	-webkit-appearance: none;
	padding:10px 25px;
	width:200px; 
    background:LightCoral;
    font-weight:bold;
    font-size:1em;
    color:white; 
    border:0 white;
    cursor:pointer;
    -webkit-border-radius: 5px;
    border-radius: 5px; 
	}

	.supprimer{
	-webkit-appearance: none;
	padding:10px; 
	width:200px;
    background:red;
    font-weight:bold;
    font-size:1em;
    color:white; 
    border:0 white;
    cursor:pointer;
    -webkit-border-radius: 5px;
    border-radius: 5px; 
	}
</style>
<body>
<div class="startAdm">	

	<div class="titre">	
		<div class="logo">
		<a href ="tdb.php"><img src="../imgs/logosollea.png" alt="" class="responsiveimgs"></a>
		</div>
		<div class="nomOpAdm">
			<span class="TitreAdmin3">Modification Evénement</span>
			<span class="TitreAdmin4"><?php echo $_SESSION["NomEve"]; ?></span>
		</div>
	</div>

	<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" enctype="multipart/form-data"> 
	<input type="hidden" name="NomOpe" value="<?php echo $base; ?>" >
	<div class="corpstxt">
	
		<div class="boxtxt">
		<?php while ($stmt->fetch()) { ?>
		<table border="0" >
			<tr>
				<td colspan="2" height="40px">
					<span style="color:white; font-size: 1.4em; font-weight:bold">Informations générales</span>
				</td>
			</tr>
			<tr>
				<td width="400px">
					<div class="input"><span style="color:Indigo; font-size: 1.2em; font-weight:bold">Intitulé de l'événement (ligne1) :</span>
					<br>
					<input class="champs" type="text" name="NomOpe2" value="<?php echo $NomOpe2; ?>" size="30" style="font-size: 1.2em; ">
					</div>
				</td>
				<td width="400px">
					<div class="input"><span style="color:Indigo; font-size: 1.2em; font-weight:bold">Date de debut :</span>
					<br>
					<input class="champs" type="text" name="DateDebutOpe" id="datepicker" value="<?php echo $DateDebutOpe; ?>"size="30" style="font-size: 1.2em; ">
					</div>
				</td>
			</tr>
			<tr>
				<td>
					<div class="input"><span style="color:Indigo; font-size: 1.2em; font-weight:bold">Intitulé de l'événement (ligne2) :</span>
					<br>
					<input class="champs" type="text" name="NomOpe3" value="<?php echo $NomOpe3; ?>" size="30" style="font-size: 1.2em; ">
					</div>
				</td>
				<td>
					<div class="input"><span style="color:Indigo; font-size: 1.2em; font-weight:bold">Date de fin :</span>
					<br>
					<input class="champs" type="text" name="DateFinOpe" id="datepicker2" value="<?php echo $DateFinOpe; ?>"size="30" style="font-size: 1.2em; ">
					</div>
				</td>
			</tr>
			<tr>
				<td>
					<div class="input"><span style="color:Indigo; font-size: 1.2em; font-weight:bold">Mot de passe administrateur :</span>
					<br>
					<input class="champs" type="text" name="MdpAdmin" value="<?php echo $MdpAdmin; ?>" size="30" style="font-size: 1.2em; ">
					</div>
				</td>
				<td>
					<div class="input"><span style="color:Indigo; font-size: 1.2em; font-weight:bold">Mot de passe utilisateur :</span>
					<br>
					<input class="champs" type="text" name="MdpUtil" value="<?php echo $MdpUtil; ?>" size="30" style="font-size: 1.2em; ">
					</div>
				</td>
			</tr>
			<tr>
				<td height="50px" colspan="2">
					<span style="color:white; font-size: 1.4em; font-weight:bold">Codes couleur</span>
				</td>
			</tr>
			<tr>
				<td>
					<div class="input"><span style="color:Indigo; font-size: 1.2em; font-weight:bold">Fond d'écran :</span>
					<br>
					<input type="text" class="pick-a-color form-control" name="BackgCol" size="30" style="font-size: 1.2em;" value="<?php echo $BackgCol; ?>"">
					</div>
				</td>
				<td>
					<div class="input"><span style="color:Indigo; font-size: 1.2em; font-weight:bold">Titre événement :</span>
					<br>
					<input type="text" class="pick-a-color form-control" name="ColTitre" value="<?php echo $ColTitre; ?>" size="30" style="font-size: 1.2em; ">
					</div>
				</td>
				
			</tr>
			<tr>
				<td>
					<div class="input"><span style="color:Indigo; font-size: 1.2em; font-weight:bold">Bouton système :</span>
					<br>
					<input type="text" class="pick-a-color form-control" name="ColBtn" value="<?php echo $ColBtn; ?>" size="30" style="font-size: 1.2em; ">
					</div>
				</td>
				<td>
					<div class="input"><span style="color:Indigo; font-size: 1.2em; font-weight:bold">Texte bouton système :</span>
					<br>
					<input type="text" class="pick-a-color form-control" name="ColTxt" value="<?php echo $ColTxt; ?>" size="30" style="font-size: 1.2em; ">
					</div>
				</td>
			</tr>
			<tr>
				<td>
					<div class="input"><span style="color:Indigo; font-size: 1.2em; font-weight:bold">Bouton vote :</span>
					<br>
					<input type="text" class="pick-a-color form-control" name="ColBoutVot" size="30" style="font-size: 1.2em;" value="<?php echo $ColBoutVot; ?>"">
					</div>
				</td>
				<td>
					<div class="input"><span style="color:Indigo; font-size: 1.2em; font-weight:bold">Texte bouton vote :</span>
					<br>
					<input type="text" class="pick-a-color form-control" name="ColTxtVot" value="<?php echo $ColTxtVot; ?>" size="30" style="font-size: 1.2em; ">
					</div>
				</td>
			</tr>
			<tr>
				<td>
					<div class="input"><span style="color:Indigo; font-size: 1.2em; font-weight:bold">Texte question :</span>
					<br>
					<input type="text" class="pick-a-color form-control" name="ColTitQuest" size="30" style="font-size: 1.2em;" value="<?php echo $ColTitQuest; ?>"">
					</div>
				</td>
				<td>
					<div class="input"><span style="color:Indigo; font-size: 1.2em; font-weight:bold">Choix réponse :</span>
					<br>
					<input type="text" class="pick-a-color form-control" name="ColBonRep" value="<?php echo $ColBonRep; ?>" size="30" style="font-size: 1.2em; ">
					</div>
				</td>
			</tr>
			<tr>
				<td colspan="2" height="50px">
					<span style="color:white; font-size: 1.4em; font-weight:bold">Visuels</span>
				</td>
			</tr>
			<tr>
				<td>
					<div class="input" height="50px">
						<span style="color:Indigo; font-size: 1.2em; font-weight:bold">
						Image de fond écran :</span>
						<br>
						<span style="color:#096b00; font-size: 1.1em; font-weight:bold"><?php echo " ".$BackgImage; ?></span>
					<br>
					<input type="hidden" name="BackgImage" value="<?php echo $BackgImage; ?>">
					<input type="file" name="fileToUpload2" id="fileToUpload2">
					</div><br>
					<a href="modifope.php?bki=oui"><span style="color:#8a0000; text-decoration: none; font-size: 1em; font-weight:bold">Supprimer image</span></a>
				</td>
				<td>
					<div class="input"><span style="color:Indigo; font-size: 1.2em; font-weight:bold">
						Logo :</span>
						<br>
						<span style="color:#096b00; font-size: 1.1em; font-weight:bold"><?php echo " ".$Logo; ?></span>
					<br>
					<input type="hidden" name="Logo" value="<?php echo $Logo; ?>">
					<input type="file" name="fileToUpload" id="fileToUpload">
					</div><br>
					<a href="modifope.php?log=oui"><span style="color:#8a0000; text-decoration: none; font-size: 1em; font-weight:bold">Supprimer logo</span></a>
				</td>
			</tr>
			<tr>
				<td height="50px">
					<span style="color:white; font-size: 1.4em; font-weight:bold">Modules</span>
				</td>
				<td>
					<span style="color:white; font-size: 1.4em; font-weight:bold">Groupes</span>
				</td>
			</tr>
			<tr>
				<td>
					<div class="input">
					<input type="checkbox" name="ModulQuiz" value="oui" <?php if ($ModulQuiz=="oui") echo "checked";?> ">  <span style="color:Indigo; font-size: 1.2em; font-weight:bold">Module Quiz</span>
					</div>
				</td>
				<td>
					<div class="input">
					<input type="checkbox" name="Groupe" value="oui" <?php if ($Groupe=="oui") echo "checked";?> ">  <span style="color:Indigo; font-size: 1.2em; font-weight:bold">Gestion par groupe</span>
					</div>
				</td>
			</tr>
			<tr>
				<td>
					<div class="input">
					<input type="checkbox" name="ModulQuest" value="oui" <?php if ($ModulQuest=="oui") echo "checked";?> ">  <span style="color:Indigo; font-size: 1.2em; font-weight:bold">Module Questions</span>
					</div>
				</td>
				<td>
					<div class="input"><span style="color:Indigo; font-size: 1.2em; font-weight:bold">Nombre de groupes :</span>
						<select name="NbrGroupe" style="font-size: 1.5em; color: #008bcb;">
							<option value="0" style="font-size: 1em; color: #008bcb;" <?php if ($NbrGroupe=="0") echo "selected";?> >0</option>
							<option value="1" style="font-size: 1em; color: #008bcb;" <?php if ($NbrGroupe=="1") echo "selected";?> >1</option>
							<option value="2" style="font-size: 1em; color: #008bcb;" <?php if ($NbrGroupe=="2") echo "selected";?> >2</option>
							<option value="3" style="font-size: 1em; color: #008bcb;" <?php if ($NbrGroupe=="3") echo "selected";?> >3</option>
							<option value="4" style="font-size: 1em; color: #008bcb;" <?php if ($NbrGroupe=="4") echo "selected";?> >4</option>
							<option value="5" style="font-size: 1em; color: #008bcb;" <?php if ($NbrGroupe=="5") echo "selected";?> >5</option>
							<option value="6" style="font-size: 1em; color: #008bcb;" <?php if ($NbrGroupe=="6") echo "selected";?> >6</option>
							<option value="7" style="font-size: 1em; color: #008bcb;" <?php if ($NbrGroupe=="7") echo "selected";?> >7</option>
							<option value="8" style="font-size: 1em; color: #008bcb;" <?php if ($NbrGroupe=="8") echo "selected";?> >8</option>
							<option value="9" style="font-size: 1em; color: #008bcb;" <?php if ($NbrGroupe=="9") echo "selected";?> >9</option>
							<option value="10" style="font-size: 1em; color: #008bcb;" <?php if ($NbrGroupe=="10") echo "selected";?> >10</option>
							<option value="11" style="font-size: 1em; color: #008bcb;" <?php if ($NbrGroupe=="10") echo "selected";?> >11</option>
							<option value="12" style="font-size: 1em; color: #008bcb;" <?php if ($NbrGroupe=="10") echo "selected";?> >12</option>
							<option value="13" style="font-size: 1em; color: #008bcb;" <?php if ($NbrGroupe=="10") echo "selected";?> >13</option>
							<option value="14" style="font-size: 1em; color: #008bcb;" <?php if ($NbrGroupe=="10") echo "selected";?> >14</option>
							<option value="15" style="font-size: 1em; color: #008bcb;" <?php if ($NbrGroupe=="10") echo "selected";?> >15</option>
							<option value="16" style="font-size: 1em; color: #008bcb;" <?php if ($NbrGroupe=="10") echo "selected";?> >16</option>
							<option value="17" style="font-size: 1em; color: #008bcb;" <?php if ($NbrGroupe=="10") echo "selected";?> >17</option>
							<option value="18" style="font-size: 1em; color: #008bcb;" <?php if ($NbrGroupe=="10") echo "selected";?> >18</option>
							<option value="19" style="font-size: 1em; color: #008bcb;" <?php if ($NbrGroupe=="10") echo "selected";?> >19</option>
							<option value="20" style="font-size: 1em; color: #008bcb;" <?php if ($NbrGroupe=="10") echo "selected";?> >20</option>
							</select>
					</div>
				</td>
			</tr>
			<tr>
				<td>
					<div class="input">
					<input type="checkbox" name="ModulFilInfo" value="oui" <?php if ($ModulFilInfo=="oui") echo "checked";?> ">  <span style="color:Indigo; font-size: 1.2em; font-weight:bold">Module Fil-Info</span>
					</div>
				</td>
				<td>
					<span style="color:white; font-size: 1.4em; font-weight:bold">Langue</span>
				</td>
			</tr>
			<tr>
				<td>
					<div class="input"><span style="color:Indigo; font-size: 1.2em; font-weight:bold">Temps entre votes :</span>
						<select name="Temps" style="font-size: 1.5em; color: #008bcb;">
							<option value="0" style="font-size: 1em; color: #008bcb;" <?php if ($Temps=="0") echo "selected";?> >0</option>
							<option value="1" style="font-size: 1em; color: #008bcb;" <?php if ($Temps=="1") echo "selected";?> >1</option>
							<option value="2" style="font-size: 1em; color: #008bcb;" <?php if ($Temps=="2") echo "selected";?> >2</option>
							<option value="3" style="font-size: 1em; color: #008bcb;" <?php if ($Temps=="3") echo "selected";?> >3</option>
							<option value="4" style="font-size: 1em; color: #008bcb;" <?php if ($Temps=="4") echo "selected";?> >4</option>
							<option value="5" style="font-size: 1em; color: #008bcb;" <?php if ($Temps=="5") echo "selected";?> >5</option>
							<option value="6" style="font-size: 1em; color: #008bcb;" <?php if ($Temps=="6") echo "selected";?> >6</option>
							<option value="7" style="font-size: 1em; color: #008bcb;" <?php if ($Temps=="7") echo "selected";?> >7</option>
							<option value="8" style="font-size: 1em; color: #008bcb;" <?php if ($Temps=="8") echo "selected";?> >8</option>
							<option value="9" style="font-size: 1em; color: #008bcb;" <?php if ($Temps=="9") echo "selected";?> >9</option>
							<option value="10" style="font-size: 1em; color: #008bcb;" <?php if ($Temps=="10") echo "selected";?> >10</option>
							</select>
					</div>
				</td>
				<td>
					<div class="input"><span style="color:Indigo; font-size: 1.2em; font-weight:bold">Langue :</span>
						<select name="Langue" style="font-size: 1em; color: #008bcb;" >
							<option value="fra" style="font-size: 1em; color: #008bcb;" <?php if ($Langue=="fra") echo "selected";?> >Français</option>
							<option value="ang" style="font-size: 1em; color: #008bcb;" <?php if ($Langue=="ang") echo "selected";?> >Anglais</option>
							</select>
					</div>
				</td>
			</tr>
			<tr>
				<td align="left" valign="middle" height="100px">
					<br>
					<input name="submit3" type="submit" value="Valider" class="valider">
					</form>
				</td>

				<form action="suppreponses.php" method="post" name="suppeve" ">
				<td align="right" valign="middle">
					<input name="suprep" type="submit" value="Vider Réponses" class="vider">
					</form>
				</td>
			</tr>

			<tr>
				<form action="../quiz/colquizvote.php" target="resultat" method="post"  ">
				<td align="left">
					<!-- <div class="input"> -->
					<input type="hidden" name="visualiser" value="<?php echo $base; ?>">
					<input name="visu" type="submit" value="Visualiser" class="visualiser">
					</form>
					<!-- </div> -->
				</form>	
				</td>

				<form action="suppevenement.php" method="post" name="suppeve" ">
				<td align="right" >
					<?php if($_SESSION["Admin"]=="oui" AND $NomOpe!="Sollea") { ?>
					<input name="submit2" type="submit" value="Supprimer événement" class="supprimer">
					</form>
					<?php } }?>
				</td>
			</tr>
		</table>
		</div>
	</div>

</div>
</div>
<script src="../js/tinycolor-0.9.15.min.js"></script>
  <script src="../js/pick-a-color-1.2.3.min.js"></script>	

  <script type="text/javascript">

   $(document).ready(function () {
    $(".pick-a-color").pickAColor();
   });

  </script>	
<?php 
mysqli_free_result($result);
mysqli_close($db);
?>					
</body>
</html>