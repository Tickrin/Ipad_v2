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
$QuestionId=$_POST['idquest'];
	
	 // à partir de la liste de question
	
	$query = "SELECT * FROM Question  WHERE NomOpe = '$base' AND IdQuest = '$QuestionId' ORDER BY Ordre ASC " ;
    $result = mysqli_query($db, $query);
    $rowcount = mysqli_num_rows($result);
    $row = mysqli_fetch_assoc($result);
	
?>

<!DOCTYPE html >
<body>
<style type="text/css">
	body { margin:0; }

	.fond{
		font-family: Arial, sans-serif;
		
	}

	.container{
	display:flex;
	flex-direction: column;
	height:100%;
	/*background-color:lightgreen;*/
	}

	.centre{
	display:flex;
	flex-direction: column;
	justify-content: space-around;
	height:100%;
	/*background-color: grey;*/
	}

	.corps{
	margin-top: -80px;
	display:flex;
	justify-content: center;
	/*background-color: green;*/
	width:100%;
	flex-wrap: wrap;
	align-items:center;
	/*font-family: Arial, sans-serif;*/
	/*margin-top: 5%;*/
	}



	.question{
		/*background-color: lightblue;*/
		width:70%;
		margin-bottom: 2%;
		font-size:5vw;
		font-size:5vh;
		font-weight: bold;
	}
	
	.ligne{
		margin-top: -30px;
		width:70%;
		height:7px;
		background-color:Indigo;
	}

	.nomOp {
		display: flex;
  		justify-content: center;
  		flex-direction: column;
  		margin-right: 30px;
  		margin-top: 10px;
  		text-align: right;
		font-size: 3vw;
	}
	
	
	.tableau{
	display: flex;
	/*background-color: gold;*/
	width:70%;
	margin-top: 2%;	
	}
	
	.num{
		width:4%;
		font-size:2.5vw;
		font-weight: bold;
		color :red;

	}
	.proposition{
		font-size:2.5vw;
		width:85%;
	}
	
</style>
<div class="fond">	
	<div class="container">
		<div class="titre">
			<div class="logo">
				<img src="../logos/<?php echo $Logo; ?>" alt="" class="responsiveimgs">
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
				<div class="ligne"></div>
				
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
						$i=1;
						while ($row = mysqli_fetch_assoc($result)) { // Boucle pour lister les propositions
						?>
				<div class="tableau">
					<div class="num">
						<?php echo $i ?>
					</div>
					<div class="proposition">
						<?php 
						echo stripslashes($row['Proposition']);
						?>
					</div>
				</div>
				
				<?php $i=$i+1;  } ?>
			
			</div>
	</div>
</div>
</div>
<?php 
$QuestionId="";
mysqli_free_result($result);
mysqli_close($db);
?>	
			
</body>
</html>