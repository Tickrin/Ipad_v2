<?php
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
?>

<head>
	<meta http-equiv="Cache-control" content="no-cache">
	<meta http-equiv="Expires" content="-1">
	<meta name="apple-mobile-web-app-capable" content="yes" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="apple-touch-icon" href="imgs/icon-touchmots.png"/>
	<meta name="apple-mobile-web-app-title" content="Ipad v2">
	<title>Sollea - Liste Evenements</title>
	<link  rel="stylesheet" href="../css/main.css?v=481">
</head>


<!DOCTYPE html >
<style>
.corpsstart{
height:0%;
padding-top: 100px;

}
</style>
<body>
<div class="start">

	<div class="titre">
		<div class="logo">
		<img src="../imgs/logosollea.png" alt="" class="responsiveimgs">
		</div>
 	</div>
	<div class="corpsAjoutQuest">
		<div class="content">
			<table border="0">
			<tr >
				<td width="600px" height="50px" align="center">
					<span style="font-size: 1.7em; font-weight: bold; color:Indigo">Administration
					Séminaire connecté</span>
				</td>
			</tr>
			<tr>
				<td height="50px" align="center">
					<span style="font-size: 1.3em; color:Indigo">Veuillez choisir un événement :</span>
				</td>
			</tr>	
			<?php 
			// Afficher les Evenements pour choix de l'Ope par defaut 
			$sql = "SELECT NomOpe, NomOpe2 FROM Parametres " ;
			$stmt = $db->prepare($sql);
	        //$stmt->bind_param("s", $base);
	        $stmt->execute();
	        $stmt->store_result(); 
	        $rowcount = $stmt->num_rows(); 
	        $stmt->bind_result($NomOpe, $NomOpe2);

		  	while ($stmt->fetch()) { ?>
		  	<tr>
		  		<td align="center" height="50px">
			  		<a href="tdb.php?dbdef=<?php echo $NomOpe; ?> " style="text-decoration:none;">
			  			<div class="boutlisteAdm"><?php echo $NomOpe2; ?>
			  			</div>
			  		</a>
				</td>
			</tr>
			<?php } $stmt->close(); ?> <?php //fin de la boucle while ?>
			<tr>
				<td height="50px" align="center">
					<span style="font-size: 1.3em; color:Indigo">ou</span>
				</td>
			</tr>
		 	<tr>
				<td align="center">
					 <div class="boutsubmitAdm" style="cursor: pointer;" onclick="window.location='ajoutope.php';">
					Cr&eacute;er Op&eacute;ration
					</div>
				</td>
			</tr>
			</table>
		</div> <?php // fin content ?>
	</div> <?php // fin corpsstart ?>
</div> <?php // fin start ?>

<?php 
mysqli_free_result($result);
mysqli_close($db);
?>
		
</body>
</html>