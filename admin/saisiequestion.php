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
$opedefaut=$_SESSION['dbdefault'];
$db = mysqli_connect($dbhost, $dbuser, $dbpass, $dbase);

// Test if connection ok
if (mysqli_connect_errno()) {
	die("Database connection failed 1: " . mysqli_connect_error() . " (" . mysqli_connect_errno() . ")");
	 }

	 // routine pour trouver le n° d'ordre
		   $sql = "SELECT IdQuest FROM Question  WHERE NomOpe = ? " ;
		   	$stmt = $db->prepare($sql);
        	$stmt->bind_param("s", $opedefaut);
        	$stmt->execute();
        	$stmt->store_result(); 
        	$rowcount = $stmt->num_rows();
        	$stmt->bind_result($IdQuest);
   //      	while ($stmt->fetch()) {
			// $idquestdef= $IdQuest;
			// echo "bla".$idquestdef;
			// }
	   		if ($rowcount==0){
	   			$ordre=1;
	   		} else {
	   			$ordre=$rowcount+1;
	   		}
			$stmt->close();

	// Routine pour ajout d'une question
	if (isset($_POST["submit1"])) {
		$question = test_input(addslashes($_POST['question']));
		$opedefaut=$_SESSION["dbdefault"];
		//$ordre2=$ordre;
		$sql="INSERT INTO Question (NomOpe, Question, Ordre) VALUES (?, ?, ?)";
		$stmt = $db->prepare($sql);
        $stmt->bind_param("ssi", $opedefaut, $question, $ordre);
        $stmt->execute();
        $stmt->close();
	
	// recherche pour retrouver l'id de la question qui vient dêtre créée
	   $sql = "SELECT IdQuest FROM Question  WHERE NomOpe = ? AND Question = ? " ;
	   $stmt = $db->prepare($sql);
        $stmt->bind_param("ss", $opedefaut, $question);
        $stmt->execute();
        $stmt->store_result(); 
        $rowcount = $stmt->num_rows();
        $stmt->bind_result($IdQuest);
        while ($stmt->fetch()) {
			$idquestdef= $IdQuest;
			$ordre= $Ordre;
			$question=$Question;
			echo "bla".$idquestdef;
		}
		$stmt->close();
	   	$_SESSION['QuestId']=$idquestdef; // variable session pour le n° Id de la Question (pour modifquestion)
    		
    	echo "<script type='text/javascript'>document.location.replace('modifquestion.php?id=$idquestdef');</script>";
	}   // fin pour isset submit

	function test_input($data) {
	  $data = trim($data);
	  $data = stripslashes($data);
	  $data = htmlspecialchars($data);
	  return $data;
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
	<link  rel="stylesheet" href="../css/main.css?v=319">
	
	<meta Charset='UTF-8'>
</head>

<!DOCTYPE html >
<body>
<style type="text/css">
	.saisie {
    background-color : #e4b8ff;
    -webkit-border-radius: 5px;
    border-radius: 5px;
    font-size: 1.2em;
    color:Indigo;
    vertical-align: baseline;
    }
</style>
<div class="start">
	<div class="titre">
		<div class="logo">
		<a href ="tdb.php"><img src="../imgs/logosollea.png" alt="" class="responsiveimgs"></a>
		</div>
		<div class="nomOpAdm">
			<span class="TitreAdmin3">Saisie Question</span>
			<span class="TitreAdmin4"><?php echo $_SESSION["NomEve"]; ?></span>
		</div>
	</div>

	<div class="corpsAjoutQuest">
		<div class="content">			
			<div class="corps">
				<!-- <?php //if(!$idquestdef) { ?> -->
				<table>
					<tr>
						<td width="450px">
							<span style="font-size:1.4em; color:Indigo; font-weight: bold;">Saisissez la question n°<?php echo $ordre ?></span>
						</td>
					</tr>
					<tr>
						<td>
							<form action="saisiequestion.php" method="post">
							<input type="hidden" name="ordre" value="<?php echo $i; ?>">	
							<input class="saisie" type="text" name="question" size="60"  ">
						</td>
					</tr>
					<tr>
						<td align="center">
							<input class="submitstart" name="submit1" type="submit" value="Ajouter">
							</form>
						</td>
					</tr>
					
				
				</table>
				<!-- <?php //} ?> -->
			</div>
		</div>
	</div>
</div>
			
</body>
</html>