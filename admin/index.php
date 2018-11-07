<?php
session_start();
header('Expires: Sun, 01 Jan 2014 00:00:00 GMT');
header('Cache-Control: no-store, no-cache, must-revalidate');
header('Cache-Control: post-check=0, pre-check=0', FALSE);
header('Pragma: no-cache');
header('Content-Type: text/html; charset=UTF-8');
$_SESSION["dbdefault"]="";
$_SESSION["NomEve"]="";	

if ($_SERVER["REQUEST_METHOD"] == "POST") { // routine pour chercher si le mdp existe 
	include_once '../include/config.php';
	$db = mysqli_connect($dbhost, $dbuser, $dbpass, $dbase);

	// Test if connection ok
	if (mysqli_connect_errno()) {
		die("Database connection failed 1: " . mysqli_connect_error() . " (" . mysqli_connect_errno() . ")");
	}

	$mdp=$_POST["mdp"];

	if (empty($_POST["mdp"])) { // test s'il y a eu une entrée
	    $nameErr = "* un code est requis";
	  	} else {
	    	$name = test_input($_POST["mdp"]);
    		// test pour n'autoriser que lettres et chiffres
    		if (!preg_match("/^[a-zA-Z0-9]*$/",$name)) {
      		$nameErr = "* lettres ou chiffre seulement"; 
    		}
    	}
	

    	// prepared statement
    	// prepare et bind
    	$sql="SELECT MdpAdmin, NomOpe, NomOpe2 FROM Mdp WHERE MdpAdmin=? ";
		$stmt = $db->prepare($sql);
		$stmt->bind_param("s", $mdp);

		// set parameters and execute
		$stmt->execute();
		$stmt->store_result(); 
		$rowcount = $stmt->num_rows(); 
		$stmt->bind_result($mdpAdmin, $NomOpe, $NomOpe2);

	while($stmt->fetch()) //use fetch() fetch_assoc() is not a member of mysqli_stmt class
 		{ 
			$ope= $NomOpe;
		}
	
	
	if($rowcount==1){ // si la fiche existe on créée cookie pour nommer la base par defaut
	
		if($ope=="Sollea"){
			$_SESSION["Admin"]="oui"; // marqueur session pour enlever les fonctions non admin (créer op par ex)
			echo "<script type='text/javascript'>document.location.replace('listop.php');</script>";
				} else {
				$_SESSION["Admin"]="";
				$_SESSION["dbdefault"]=$ope;
				$_SESSION["NomEve"]=$NomOpe2;
				echo " - session :".$_SESSION["dbdefault"];
				echo "<script type='text/javascript'>document.location.replace('tdb.php');</script>";
				}
			} else {
			$nameErr = "* le code est eronné";
		 	//echo "<script type='text/javascript'>document.location.replace('index.php?');</script>";
	}
		 mysqli_free_result($result);
		 mysqli_close($db);
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
			<meta Charset='UTF-8'>
			<title>Sollea</title>
			<link  rel="stylesheet" href="../css/main.css?v=492">
			
			
		</head>

<!DOCTYPE html >
<style type="text/css">
	.responsiveimgs{
	width: 50%;
    height: auto;
	}
	.error {color: #FF0000;}
</style>
<body>
<div class="start">
	<div class="corpsstart">
		<div class="content">
			<table border="0">
				<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post">
					<tr>
						<td align="center">
							<img src="../imgs/logosollea.png" alt="" class="responsiveimgs">
						</td>
					</tr>
				<tr>
					<td align="center" height="130px">
						<span style="color:white; font-size: 2em; font-weight:bold">Séminaire connecté</span>
						<br>
						<span style="color:#3b05ff; font-size: 2em">Administration</span>
						
					</td>
				</tr>
				<tr>
					<td align="center" height="50px">
						<span style="color:white; font-size: 1.2em; font-weight:bold">Veuillez entrer<br>le code administrateur</span>
				</td>
				</tr>
				<tr>
					<td align="center" height="80px">
						<span class="error"><?php echo $nameErr;?></span>
						<br>
						<input type="text" name="mdp" style="font-size: 1.5em" size="10">	
					</td>
				</tr>
				<tr>
					<td align="center" height="100px">
						<input class="submitstart" name="submit" type="submit" value="OK">
					</td>
				</tr>
				</form>
			</table>
		</div>
	</div>

</div>
			
</body>
</html>