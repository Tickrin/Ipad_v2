<?php
session_start();
header('Expires: Sun, 01 Jan 2014 00:00:00 GMT');
header('Cache-Control: no-store, no-cache, must-revalidate');
header('Cache-Control: post-check=0, pre-check=0', FALSE);
header('Pragma: no-cache');
header('Content-Type: text/html; charset=UTF-8');
include_once '../include/config.php';
$db = mysqli_connect($dbhost, $dbuser, $dbpass, $dbase);
$base=$_SESSION["dbdefault"];
//echo $_SERVER['SCRIPT_FILENAME'];

// Test if connection ok
    if (mysqli_connect_errno()) {
	   die("Database connection failed 1: " . mysqli_connect_error() . " (" . mysqli_connect_errno() . ")");
    }

// routine pour changer le num d'ordre
    if(isset($_POST["voirordre"])){ 
        $id=$_POST["idquest"];
        $ordre=test_input(addslashes($_POST["ordre"]));
        
        $sql = "UPDATE `Question` SET Ordre=? WHERE `IdQuest`=? ";
        $stmt = $db->prepare($sql);
        $stmt->bind_param("ii", $ordre, $id);
        $stmt->execute();
        $stmt->close();
    }

// routine pour fermer la question
    if(isset($_POST["ouverte"])){ 
        $id=$_POST["idquest"];
        $statut="non";
        
        $sql = "UPDATE `Question` SET Ouverte=? WHERE `IdQuest`=? ";
        $stmt = $db->prepare($sql);
        $stmt->bind_param("si", $statut, $id);
        $stmt->execute();
        $stmt->close(); 
    }

// routine pour ouvrir la question
    if(isset($_POST["fermee"])){ 
        $id=$_POST["idquest"];
        $statut="oui";
    $sql = "UPDATE `Question` SET Ouverte=? WHERE `IdQuest`=? ";
        $stmt = $db->prepare($sql);
        $stmt->bind_param("si", $statut, $id);
        $stmt->execute();
        $stmt->close();
    }


// update de la question en provenance de modifquestion.php
    if (isset($_POST["submit"])) {
	   $idquest=$_POST["idquest"];
	   $question=$_POST["question"];
    $sql = "UPDATE `Question` SET Question=? WHERE `IdQuest`=? ";
		$stmt = $db->prepare($sql);
        $stmt->bind_param("si", $question, $idquest);
        $stmt->execute();
        $stmt->close();
    }

// pour supprimer la fiche question à partir de modifquestion
    if (isset($_POST["supprimer"])) {
        $idquest=$_POST["idquest"];
	$sql = "DELETE FROM Question WHERE `IdQuest`=? ";
        $stmt = $db->prepare($sql);
        $stmt->bind_param("i", $idquest);
        $stmt->execute();
        $stmt->close();
    	echo "<script type='text/javascript'>document.location.replace('listequestions.php');</script>";
		  
    }
// Recherche de toutes les question pour cette op
    $sql = "SELECT IdQuest, NomOpe, Question, Ouverte, Ordre FROM Question  WHERE NomOpe = ? ORDER BY Ordre ASC " ;
        $stmt = $db->prepare($sql);
        $stmt->bind_param("s", $base);
        $stmt->execute();
        $stmt->store_result(); 
        $rowcount = $stmt->num_rows(); 
        $stmt->bind_result($IdQuest, $NomOpe, $Question, $Ouverte ,$Ordre);

    if($rowcount==0){ // si pas de questions on redirige vers créa question
    echo "<script type='text/javascript'>document.location.replace('saisiequestion.php');</script>"; 
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
	<title>Sollea - Liste Questions</title>
	<link  rel="stylesheet" href="../css/main.css?v=142">
</head>

<!DOCTYPE html >
<body>
    <style type="text/css">
    
        .form1 {
        float: left;
        margin-left: 10px;
        }

        .form2 {
        float: left;
        margin-left: 0px;
        margin-top: 20px;
        }

        .ordre {
        background-color : #e4b8ff;
        -webkit-border-radius: 5px;
        border-radius: 5px;
        font-size: 1em;
        color:Indigo;
        vertical-align: baseline;
        }

        .cellordre{
            margin-bottom: -20px;
            background-color : white;
        }

    </style>
<div class="startAdm">
	<div class="titre">
    	<div class="logo">
    		<a href ="tdb.php"><img src="../imgs/logosollea.png" alt="" class="responsiveimgs"></a>
    	</div>
            <div class="nomOpAdm">
            <span class="TitreAdmin3">Liste Questions</span>
            <span class="TitreAdmin4"><?php echo $_SESSION["NomEve"]; ?></span>
        </div>
    </div>

    <div class="corps">
    	<table border="0">
            <tr>
                <td>
                    
                </td>
                <td>
                    
                </td>
                <td align="center">
                    <span style="font-size:1em; color:Indigo; font-weight: bold;">Statut</span>
                </td>
                <td align="center">
                    <span style="font-size:1em; color:Indigo; font-weight: bold;">Résultats</span>
                </td>
                <td align="center">
                    <span style="font-size:1em; color:Indigo; font-weight: bold;">Ordre</span>
                </td>
                
            </tr>
    	<?php 
        $i="1";
        while ($stmt->fetch()) { ?>
        <tr>
            <td width="40px">
                <div class="boutlisteAdm"><?php echo $i ?></div>
            </td>
    		<td width="450px">
    			<a href="modifquestion.php?id=<?php echo $IdQuest; ?>" style="text-decoration:none;">
                    <span style="font-size:1.2em; color:white; font-weight: bold;"><?php echo $Question; ?></span></a>
    		</td>
    		<td >  <?php // routine pour afficher et changer le statut ouvert/fermé ?>
                    <?php if ($Ouverte=='oui'){ ?>
                    <form action="listequestions.php" method="post">
                        <input type="hidden" name="idquest" value="<?php echo $IdQuest; ?>">
                        <input class="submitstart-5" name="ouverte" type="submit" value="ouverte">
                    </form>
                    <?php } else { ?>
                    <form action="listequestions.php" method="post">
                        <input type="hidden" name="idquest" value="<?php echo $IdQuest; ?>">
                        <input class="submitstart-6" name="fermee" type="submit" value="fermée">
                    </form>
                    <?php } ?>
             </td>
             <td width="100px" align="center"> <?php // routine pour afficher les résultats par Question ?>
                        <div> 
                        <form class="form1" action="../quiz/ResultQuest.php" method="post" target="resultat">
                        <input type="hidden" name="idquest" value="<?php echo $IdQuest; ?>">
                        <?php if($_SESSION['GroupeAdmin']=="oui"){  ?>
                        <input class="submitstart-7" name="result" type="submit" value="S">
                        <?php } else { ?>
                        <input class="submitstart-9" name="result" type="submit" value="Simple">
                        <?php } ?>
                        </form>
                        </div>
                    <?php if($_SESSION['GroupeAdmin']=="oui"){  ?>
                        <div>
                        <form class="form1" action="../quiz/ResultQuestGrpe.php" method="post" target="resultat">
                        <input type="hidden" name="idquest" value="<?php echo $IdQuest; ?>">
                        <input class="submitstart-8" name="result" type="submit" value="G">
                        </form>
                        </div>
                    <?php } ?>
            </td>
             <td valign="middle"> <?php // routine pour montrer et modifier le num d'ordre ?>
                    <div class="cellordre">
                    <form class="form2" action="listequestions.php" method="post">
                        <input class="ordre" type="text" name="ordre" size="2" value="<?php echo $Ordre; ?>" >
                        <input type="hidden" name="idquest" value="<?php echo $IdQuest; ?>">
                        <input class="submitstart3bis" name="voirordre" type="submit" value="modifier">
                    </form>
                    </div>
             </td>
             <td>
                 <div> 
                        
                        <form class="form1" action="../quiz/AffQuest.php" method="post" target="resultat">
                        <input type="hidden" name="idquest" value="<?php echo $IdQuest; ?>">
                        <input class="submitstart-9" name="aff" type="submit" value="Afficher">
                        </form>
                        
             </td>
             <tr>
                <td colspan="6" height="5px" style="background-color: indigo;">
                 
                </td>
            </tr>    
    		<?php 
            $i=$i+1;

            } ?>	
    	   <tr>
            <td colspan="5" height="80px" align="center">
                <form action="saisiequestion.php" method="post">
                <input class="submitstart" name="submit" type="submit" value="Nouvelle Question">
                </form>
            </td>   
           </tr>
    	</table> 
    </div>
</div>
<?php 
$stmt->close();
mysqli_free_result($result);
mysqli_close($db);
?> 
</body>
</html>