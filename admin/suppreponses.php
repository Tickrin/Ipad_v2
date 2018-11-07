<?php
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


// routine pour supprimer TOUTES les réponses pour cet événement
	if(isset($_POST["confirm"])){ 
	$sql = "DELETE FROM Reponses WHERE NomOpe=? ";
            $stmt = $db->prepare($sql);
        	$stmt->bind_param("s", $opedefaut);
        	$stmt->execute();
        	$stmt->close();
            echo "<script type='text/javascript'>document.location.replace('tdb.php');</script>";
    		
    }
	
?>

<head>
	<meta http-equiv="Cache-control" content="no-cache">
	<meta http-equiv="Expires" content="-1">
	<meta name="apple-mobile-web-app-capable" content="yes" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="apple-touch-icon" href="imgs/icon-touchmots.png"/>
	<meta name="apple-mobile-web-app-title" content="Ipad v2">
	<title>Sollea - Supprimer</title>
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
			<span class="TitreAdmin3">Supprimer Réponses</span>
			<span class="TitreAdmin4"><?php echo $_SESSION["NomEve"]; ?></span>
		</div>
	</div>

	<div class="corpsAjoutQuest">
		<div class="content">			
			<div class="corps">
				
				<table>
					<tr>
						<td height="100px">
							
						</td>
						<td>
							
						</td>
					</tr>
					<tr>
						<td colspan="2" align="center" width="600px">
							<span style="font-size:1.4em; color:Indigo; font-weight: bold;">Etes-vous sûr de vouloir supprimer<br>toutes les réponses pour cet événement ?</span>
						</td>
					</tr>
					<tr>
						<td height="100px" colspan="2" align="center">
							<span style="font-size:1.2em; color:white; font-weight: bold;"><?php echo $_SESSION["NomEve"]; ?></span>
						</td>
					</tr>
					
					<tr>
						<td align="left" height="100px">
							<form action="modifope.php" method="post">
							<input type="hidden" name="id" value="<?php echo $idquest; ?>">
							<input class="submitstart" name="retour" type="submit" value="retour">
							</form>
						</td>
						<td align="right">
							<form action="suppreponses.php" method="post">
							<input type="hidden" name="idquest" value="<?php echo $idquest; ?>">
							<input class="submitstart2bis" name="confirm" type="submit" value="OK">
							</form>
						</td>
					</tr>
					
				
				</table>
				
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