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

	// update de la question en provenance de modifquestion.php
	    if (isset($_POST["submit1"])) {
	    	$idquest=$_POST["idquest"];
	    	$id=$idquest;
	    	$question=test_input(addslashes($_POST["question"]));
			$sql = "UPDATE `Question` SET Question=? WHERE IdQuest=? ";
	    		$stmt = $db->prepare($sql);
        		$stmt->bind_param("si", $question, $idquest);
        		$stmt->execute();
        		$stmt->close();
			}
    	
	// id de la question à partir de liste ou après créer question
		if(isset($_GET["id"])){
			$id=$_GET['id']; 
		}
		if(isset($_POST["id"])){
			$id=$_POST['id']; 
		}

	// routine pour ajouter une nouvelle proposition
		if(isset($_POST["idquestdef"])){ 
		$id=$_POST["idquestdef"];
		$blank="";
		$bon="non";
		$sql = "INSERT INTO `Propositions` (NomOpe, IdQuest, Proposition, BonneRep) VALUES (?, ?, ?, ?) ";
	    	$stmt = $db->prepare($sql);
        	$stmt->bind_param("siss", $base, $id, $blank, $bon);
        	$stmt->execute();
        	$stmt->close();
		}

	// routine pour modifier une proposition
		if(isset($_POST["modifier"])){ 
		$idprop=$_POST["idprop"];
		$id=$_POST["idquest"];
		$proposition=test_input(addslashes($_POST["proposition"]));
		$BonRep=$_POST["BonneRep"];
		if($BonRep!="oui"){
			$BonRep="non";
		}
		$sql = "UPDATE `Propositions` SET Proposition=?, BonneRep=? WHERE IdProp=? ";
	    	$stmt = $db->prepare($sql);
        	$stmt->bind_param("ssi", $proposition, $BonRep, $idprop);
        	$stmt->execute();
        	$stmt->close();
		}

	// routine pour supprimer une proposition
		if(isset($_POST["supp"])){ 
		$idprop=$_POST["supp"];
		$id=$_POST["idquest"];
		$sql = "DELETE FROM Propositions WHERE IdProp=? ";
			$stmt = $db->prepare($sql);
        	$stmt->bind_param("i", $idprop);
        	$stmt->execute();
        	$stmt->close();
		}

	// Recherche de la Question à traiter
		$sql = "SELECT IdQuest, Question, Ordre FROM Question  WHERE IdQuest=? " ;
		$stmt = $db->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->store_result(); 
        $rowcount = $stmt->num_rows();
        $stmt->bind_result($IdQuest, $Question, $Ordre);
        while ($stmt->fetch()) {
			$idquestdef= $IdQuest;
			$ordre= $Ordre;
			$question=$Question;
		}
		$stmt->close();

	// recherche s'il y a déjà des propositions pour cette question
		$sql = "SELECT * FROM Propositions  WHERE IdQuest=? " ;
			$stmt = $db->prepare($sql);
	        $stmt->bind_param("i", $id);
	        $stmt->execute();
	        $stmt->store_result(); 
	        $rowcountprop = $stmt->num_rows();
	        $stmt->bind_result($IdProp, $NomOpe, $IdQuest, $Proposition ,$BonneRep);
	        $stmt->close();
	        
	// Si pas encore de propositions : boucle pour en créer 2 vierges
		if($rowcountprop==0){
			for ($x = 0; $x <= 1; $x++) {
	    	$blank="";
			$bon="non";
			$sql = "INSERT INTO `Propositions` (NomOpe, IdQuest, Proposition, BonneRep) VALUES (?, ?, ?, ?) ";
	    	$stmt = $db->prepare($sql);
        	$stmt->bind_param("siss", $base, $id, $blank, $bon);
        	$stmt->execute();
        	$stmt->close();
			} 
		}
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
	<title>Sollea - Modifier</title>
	<link  rel="stylesheet" href="../css/main.css?v=448">
	<meta Charset='UTF-8'>
</head>

<!DOCTYPE html >
<style type="text/css">

	input[type=checkbox] {
  	transform: scale(1.8);
	}

	.checkB {
   	margin-left: 50px;
   	margin-bottom: 20px;
    border-radius: 50px;
    }

	input, textarea {
  	background-color : #e4b8ff;
  	-webkit-border-radius: 5px;
  	border-radius: 5px;
	}	

	.submitstart{
		color:yellow;
	}

</style>
<body>
<div class="startAdm">

	<div class="titre">
		<div class="logo">
		<a href ="listequestions.php"><img src="../imgs/logosollea.png" alt="" class="responsiveimgs"></a>
		</div>

		<div class="nomOpAdm">
			<span class="TitreAdmin3">Modifier Question</span>
			<span class="TitreAdmin4"><?php echo $_SESSION["NomEve"]; ?></span>
		</div>
	</div>

	<div class="corpsAjoutQuest">
		<div class="content">
		<table>
			<tr>
				<td>
					<span class="TitreAdmin">Question n° <?php echo $ordre ?></span>
				</td>
			</tr>
			<tr>
				<td>
					<form action="modifquestion.php" method="post">
					<input type="hidden" name="idquest" value="<?php echo $IdQuest; ?>">	
					<input type="text" size="65" name="question" value="<?php echo $question; ?>" class="txtInput">
				</td>
			</tr>
			<tr>
				<td align="right">
					<input class="submitstart22" name="submit1" type="submit" value="Valider Question">
				</td>
			</tr>
		</table>
		</form>

		<?php
		$sql = "SELECT * FROM Propositions  WHERE IdQuest=? " ;
			$stmt = $db->prepare($sql);
	        $stmt->bind_param("i", $id);
	        $stmt->execute();
	        $stmt->store_result(); 
	        $rowcountprop = $stmt->num_rows();
	        $stmt->bind_result($IdProp, $NomOpe, $IdQuest, $Proposition ,$BonneRep);
		?>

		<table border="0">
			<tr>
				<td >
					<span class="TitreAdmin">Propositions</span>
				</td>
				<td>
					<span class="TitreAdmin2">Bonne Réponse</span>
				</td>
				<td>
					
				</td>
				<td>
					
				</td>
			</tr>
	    	<?php 
	    	while ($stmt->fetch()) { 
	    	$idprop=$IdProp;
	    	$idquest=$IdQuest;
	    	?>
	    	<tr>
	    		<td width="440px"> <!-- contient le bouton modifier -->
	    			<form action="modifquestion.php" method="post">
					<input type="hidden" name="idprop" value="<?php echo $IdProp; ?>">
					<input type="hidden" name="idquest" value="<?php echo $IdQuest; ?>">	
					<input type="text" size="37" name="proposition" value="<?php echo $Proposition; ?>" class="txtInput">
				</td>
	    		<td width="100px">
	    			<?php 
	    			if ($BonneRep=="oui"){
	    			echo "<input type='checkbox' class='checkB' name='BonneRep' value='oui' checked>";
	    			} else {
	    			echo "<input type='checkbox' class='checkB' name='BonneRep' value='oui' >";
					}
	    			?>
	    		</td>
	    		<td width="90px">	
					<input class="submitstart3" name="modifier" type="submit" value="Valider"></form>
	    		</td>
	    		<form action="modifquestion.php" method="post">
	    		<td >  <!-- contient le bouton supprimer -->
	    			
					<input type="hidden" name="supp" value="<?php echo $idprop; ?>">
					<input type="hidden" name="idquest" value="<?php echo $idquest; ?>">	
					<input class="submitstart4" name="supprimer" type="submit" value="Supprimer"></form>
				</td>
	    		<?php } $stmt->close(); ?>	
	    		</tr>
	    		<tr>
	    			<td colspan="4" align="left">
	    				<form action="modifquestion.php" method="post">
						<input type="hidden" name="idquestdef" value="<?php echo $idquestdef; ?>">
						<input class="submitstart2" name="Ajouter" type="submit" value="Ajouter proposition">
						</form>
	    			</td>
	    		</tr>
	    		<tr>
	    			<td colspan="2" align="left">
	    				<form action="saisiequestion.php" method="post">
                		<input class="submitstartbis" name="submit" type="submit" value="Nouvelle Question">
                		</form>
	    			</td>
	    			<td colspan="2" align="right">
	    				<form action="suppquestion.php" method="post">
						<input type="hidden" name="idquest" value="<?php echo $idquestdef; ?>">
						<input type="hidden" name="ordre" value="<?php echo $ordre; ?>">
						<input type="hidden" name="question" value="<?php echo $question; ?>">
						<input class="submitstart2bis" name="supprimer" type="submit" value="Supprimer Question">
						</form>
	    			</td>
	    		</tr>
		</table> 
			
		</div>
	</div>		
</div>
<?php 
mysqli_free_result($result);
mysqli_close($db);
?>
				
</body>
</html>