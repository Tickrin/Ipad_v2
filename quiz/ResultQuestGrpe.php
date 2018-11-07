<?php
session_start();
header('Expires: Sun, 01 Jan 2014 00:00:00 GMT');
header('Cache-Control: no-store, no-cache, must-revalidate');
header('Cache-Control: post-check=0, pre-check=0', FALSE);
header('Pragma: no-cache');
header('Content-Type: text/html; charset=UTF-8');
include_once '../include/config.php';
    $base=$_SESSION['dbdefault'];
    $db = mysqli_connect($dbhost, $dbuser, $dbpass, $dbase);

    // Test if connection ok
    if (mysqli_connect_errno()) {
    	die("Database connection failed 1: " . mysqli_connect_error() . " (" . mysqli_connect_errno() . ")");
    }
    // Pour retrouver les éléments dans parametres
    $query = "SELECT NomOpe2, NomOpe3, Logo, Langue FROM Parametres  WHERE NomOpe = '$base' " ;
    $result = mysqli_query($db, $query);
    $rowcount = mysqli_num_rows($result);
    $row = mysqli_fetch_assoc($result);
    $NomOpe2=$row['NomOpe2'];
    $NomOpe3=$row['NomOpe3'];
    $Logo=$row['Logo'];
    $Langue=$row['Langue'];
	
?>

<head>
	<meta http-equiv="Cache-control" content="no-cache">
	<meta http-equiv="Expires" content="-1">
	<meta name="apple-mobile-web-app-capable" content="yes" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="apple-touch-icon" href="imgs/icon-touchmots.png"/>
	<meta name="apple-mobile-web-app-title" content="Ipad v2">
	<meta Charset='UTF-8'>
	<title>Résultat Groupes</title>
	<link  rel="stylesheet" href="../css/main.css">
</head>

<?php
	$NbrGrpe=$_SESSION['NbrGrpeAdmin']; // récupération du nbr de groupes
	if(isset($_POST["result"])){  // à partir de la liste de question
		$QuestionId=$_POST['idquest'];
	}

	$query = "SELECT * FROM Propositions  WHERE NomOpe = '$base' AND IdQuest = '$QuestionId'  " ;
    $result = mysqli_query($db, $query);
    $rowcountProp = mysqli_num_rows($result);
    
    
    $TableauBonRep=array(); // création d'un tableau pour lister les bonnes réponses (IdProp)
    
    while($rowQ = mysqli_fetch_assoc($result)) // boucle dans les propositions pour trouver celles avec bonnes rep
	{
		if($rowQ['BonneRep']=="oui"){ // si bonne réponse on l'insère dans le tableau
	   	$TableauBonRep[] = $rowQ['IdProp'];
		}
	}

	foreach ($TableauBonRep as $value){ 
	
	}

	$query = "SELECT * FROM Question  WHERE NomOpe = '$base' AND IdQuest = '$QuestionId' ORDER BY Ordre ASC " ;
    $result = mysqli_query($db, $query);
    $rowcount = mysqli_num_rows($result);
    $rowQ = mysqli_fetch_assoc($result);


?>

<!DOCTYPE html >
<body>
	<style type="text/css">
	.container{
	display:flex;
	flex-direction: column;
	font-family: Arial, sans-serif;
	}
	.nomOp {
		display: flex;
  		justify-content: center;
  		flex-direction: column;
  		margin-right: 30px;
  		text-align: right;
		font-size: 3vw;
	}
	.corps{
	display:flex;
	/*background-color: green;*/
	width:100%;
	flex-wrap: wrap;
	align-items:center;
	font-family: Arial, sans-serif;
	margin-top: 5%;
	}
	.question{
		width:70%;
		font-size:3vw;
		font-weight: bold;
	}
	.tableau{
	display: flex;
	/*background-color: gold;*/
	width:70%;
	margin-top: 2%;	
	}
	.num{
		width:40%;
		font-size:2vw;

	}
	.proposition{
		font-size:2vw;
		width:60%;
	}
	</style>
<div class="container">
	<div class="titre">
			<div class="logo">
				<a href ="index.php"><img src="../logos/<?php echo $Logo; ?>" alt="" class="responsiveimgs"></a>
			</div>
			<div class="nomOp">
				<?php echo $NomOpe2; ?>
				<br>
			<span><?php echo $NomOpe3; ?></span>
			</div>
	</div>

			
	<div class="corps">
			<div class="question">
					<?php echo $rowQ['Question']; ?>
			</div>

			
			<?php
			$ArrayResgrp=array(); //création d'un tableau pour lister les groupes
			
			for($x = 1; $x <= $NbrGrpe; $x++){

			$query = "SELECT * FROM Reponses  WHERE  IdQuest = '$QuestionId' AND  NumGroupe='$x'  " ;
		    $result = mysqli_query($db, $query);
		    $rowcountRepGrpe = mysqli_num_rows($result);
		    $rowQ = mysqli_fetch_assoc($result);

		    $query = "SELECT * FROM Reponses  WHERE IdQuest='$QuestionId' AND NumGroupe='$x' AND BonRep='oui' " ;
		    $result = mysqli_query($db, $query);
		    $rowcountarray = mysqli_num_rows($result);
		    $rowS = mysqli_fetch_assoc($result);
		    if($Langue=="ang"){ // intitulé Groupe en fonction de la langue
		    	$txtgrpe="Team ".$x;
		    } else{
		    	$txtgrpe="Groupe ".$x;
		    }
		    
		    if ($rowcountarray !=0) {
		    $resultatpargrpe=number_format((($rowcountarray/$rowcountRepGrpe)*100),0); //résultat final
		    } else {
		    	$resultatpargrpe= 0;
		    }
		    $ArrayResgrp[]=array("Grpe"=>$txtgrpe, "resultat"=>$resultatpargrpe); //tableau 2 dimensions
			}
			$keys = array_column($ArrayResgrp, 'resultat'); // pour trier le tableau en fonction de la key resultat
			array_multisort($keys, SORT_DESC, $ArrayResgrp);
			$z=1;
			foreach ($ArrayResgrp as $value) {
			
			?>	
			<div class="tableau">
				<div class="num">
					<?php if($z==1 && $value['resultat']!=0) {  //si 1er de la liste on passe en rouge ?>
					<span style="color:red; font-weight:bold;"><?php echo $value['Grpe'] ?></span>
					<?php } else { 
					echo $value['Grpe']; 
					}?>
				</div>
				<div class="proposition">
					<?php echo $value['resultat']." %" ?>

				</div>
			</div>

			<?php $z=$z+1; } ?>
			 
		
	</div>
	<?php 
	mysqli_free_result($result);
	mysqli_close($db);
	?>	
			
</body>
</html>