<?php
	session_start();
	header('Expires: Sun, 01 Jan 2014 00:00:00 GMT');
	header('Cache-Control: no-store, no-cache, must-revalidate');
	header('Cache-Control: post-check=0, pre-check=0', FALSE);
	header('Pragma: no-cache');
	header('Content-Type: text/html; charset=UTF-8');
	include_once '../include/config.php';
    $base=$_SESSION["dbdefault"];
    
    $db = mysqli_connect($dbhost, $dbuser, $dbpass, $dbase);

    // Test if connection ok
    if (mysqli_connect_errno()) {
    	die("Database connection failed 1: " . mysqli_connect_error() . " (" . mysqli_connect_errno() . ")");
    }
    // Pour retrouver les éléments dans parametres
    $query = "SELECT NomOpe, NomOpe2, NomOpe3, Logo FROM Parametres  WHERE NomOpe = '$base' " ;
    $result = mysqli_query($db, $query);
    $rowcount = mysqli_num_rows($result);
    $row = mysqli_fetch_assoc($result);
    $NomOpe2=$row['NomOpe2'];
    $NomOpe3=$row['NomOpe3'];
    $Logo=$row['Logo'];
    
?>

<head>
	<meta http-equiv="Cache-control" content="no-cache">
	<meta http-equiv="Expires" content="-1">
	<meta name="apple-mobile-web-app-capable" content="yes" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="apple-touch-icon" href="imgs/icon-touchmots.png"/>
	<meta name="apple-mobile-web-app-title" content="Ipad v2">
	<meta Charset='UTF-8'>
	<title>Résultats Vote S</title>
	<link  rel="stylesheet" href="../css/main.css">
</head>

<?php
	if(isset($_POST["result"])){  // à partir de la liste de question
		$QuestionId=$_POST['idquest'];
	}
	$query = "SELECT * FROM Question  WHERE NomOpe = '$base' AND IdQuest = '$QuestionId' ORDER BY Ordre ASC " ;
    $result = mysqli_query($db, $query);
    $rowcount = mysqli_num_rows($result);
    $row = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html >
<body>
<style type="text/css">
	.fond{
		display:flex;
		flex-direction: column;
		font-family: Arial, sans-serif;
		background-color: #b8d5ff;
		height:110%;
		margin:-10px;
	}
	.container{
	/*display:flex;
	flex-direction: column;
	font-family: Arial, sans-serif;
	height:100%;*/
	flex-grow: 1;
	/*background-color:DarkSalmon ;*/
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
	margin-top: 2vh;
	/*background-color:green ;*/
	}
	.question{
		width:70%;
		font-size:5vw;
		font-size:5vh;
		font-weight: bold;
		margin-bottom: 1vh;
		/*background-color:DarkSeaGreen ;*/
		
	}
	.tableau{
	display: flex;
	/*background-color: gold;*/
	width:70%;
	margin-top: 1vh;
	/*background-color:LightBlue  ;*/	
	}
	
	.num{
		width:3%;
		font-size:2vw;

	}
	.proposition{
		font-size:3vw;
		font-size:3vh;
		width:85%;
		height:2vh;
		margin-bottom: 0.5vh;
		/*background-color:Khaki   ;*/
	}
	.resultat{
		height:5%;
		font-size:3vw;
		font-size:3vh;
		width:15%;
		content: "<br />";
		/*vertical-align: middle;*/
	}
	.containgraph{
		width:70%;
		margin-top: 1vh;
		
	}
	.bar{
		display:flex;
		width: 85%;
	}
	.pourcentage{
		background: Indigo;
		height:3%;
		text-align: right;
		color:white;
		font-size:2vw;
		font-size:2vh;
	}
	.containbar{
		width:100%;
	}
</style>
<div class="fond">	
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

		<div class="centre">
			<div class="corps">
				<div class="question">
					<?php echo $row['Question']; ?>
				</div>
				<?php
					// Pour avoir le nbr de votes total de la question
						$query = "SELECT * FROM Reponses  WHERE IdQuest='$QuestionId'  " ;
						$result = mysqli_query($db, $query);
						$rowcountquest = mysqli_num_rows($result);
					
					// on liste toutes les propositioins pour cette question
						$query = "SELECT * FROM Propositions  WHERE IdQuest='$QuestionId' ORDER BY IdProp ASC" ;
						$result = mysqli_query($db, $query);
						$rowcountprop = mysqli_num_rows($result);
						$ArrayResult=array();
						$num=1;
						while ($row = mysqli_fetch_assoc($result)) { // Boucle pour lister les propositions
							$proposition=addslashes($row['Proposition']);
							$propId=$row['IdProp'];
							$bonneRep=$row['BonneRep'];
							$Px="P".$num;
							include '../include/CalculQuest.php'; // calcul des résultats par proposition
							$ArrayResult[]=array("prop"=>$proposition, "res"=>$resQuestfinal, "bonRep"=>$bonneRep); // création d'un array
							$num=$num+1; }
							$i=1; // pour avoir le num d'ordre des propositions, classées
							$keys = array_column($ArrayResult, 'res'); // pour trier les valeurs en fonction du résultat
							array_multisort($keys, SORT_DESC, $ArrayResult);
							foreach($ArrayResult as $value){ //un loop dans le tableau à 2 dimensions
						
				?>
				<div class="tableau">
					<!-- <div class="num">
						<?php //echo $i ?>
					</div> -->
					<div class="proposition">
						<?php 
						if ($value['bonRep']=="oui"){ // test pour savoir si bonne réponse et mis en avant 
						echo "<span style='color:red; font-weight:bold'>".stripslashes($value['prop'])."</span>"; 
						} else {
						echo stripslashes($value['prop']);
						}
						?>
					</div>
				</div>
				<div class="containgraph">
					<div class="bar">
						<div class="containbar">
							<div class="pourcentage" style="width:<?php echo $value['res'] ?>%;">
							</div>
						</div>
						<div class="resultat">
							<?php 
						if ($value['bonRep']=="oui"){ // test pour savoir si bonne réponse et mis en avant 
						echo "<span style='color:red; font-weight:bold'>".stripslashes($value['res'])." %</span>"; 
						} else {
						echo stripslashes($value['res'])." %";
						}
						?>
							<?php //echo "&ensp;".$value['res']."%" ?>
						</div>
					</div>
				</div>
				<?php $i=$i+1;  } ?>
			</div>
		</div>
	</div>
</div>
<?php 
mysqli_free_result($result);
mysqli_close($db);
?>	
			
</body>
</html>