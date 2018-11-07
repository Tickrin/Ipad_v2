<?php
session_start();
header('Expires: Sun, 01 Jan 2014 00:00:00 GMT');
header('Cache-Control: no-store, no-cache, must-revalidate');
header('Cache-Control: post-check=0, pre-check=0', FALSE);
header('Pragma: no-cache');
header('Content-Type: text/html; charset=UTF-8');

	

if(isset($_POST["submit"])){ // routine pour chercher si le mdp existe 
	include_once 'include/config.php';
	$db = mysqli_connect($dbhost, $dbuser, $dbpass, $dbase);

	// Test if connection ok
	if (mysqli_connect_errno()) {
		die("Database connection failed 1: " . mysqli_connect_error() . " (" . mysqli_connect_errno() . ")");
	}

	$mdpUtil=$_POST["mdpUtil"];

	if (empty($_POST["mdpUtil"])) { // test s'il y a eu une entrée
	    $nameErr = "* un code est requis";
	  	} else {
	    	$name = test_input($_POST["mdpUtil"]);
    		// test pour n'autoriser que lettres et chiffres
    		if (!preg_match("/^[a-zA-Z0-9]*$/",$name)) {
      		$nameErr = "* lettres ou chiffre seulement"; 
    		}
    	}
    // prepared statement
	$query = "SELECT MdpUtil, NomOpe FROM Mdp  WHERE MdpUtil='$mdpUtil' " ;
	$stmt = $db->prepare($sql);
	$stmt->bind_param("s", $mdpUtil);
	// set parameters and execute
	$stmt->execute();
	$stmt->store_result(); 
	$rowcount = $stmt->num_rows();
	$stmt->bind_result($mdpUtil, $NomOpe);
	
	$op=$row["NomOpe"];

	if($rowcount==1 AND $op!="Sollea"){ // si la fiche existe on créée cookie pour nommer la base par defaut
	$ope= $row['NomOpe'];
	

	include  'include/inc_rech_param.php'; // on écrit les données Parametres dans des variables session
			if($_SESSION["Groupe"]=="oui"){
				echo "<script type='text/javascript'>document.location.replace('ChxGroupe.php');</script>";
			} else {
				echo "<script type='text/javascript'>document.location.replace('Chxmodule.php');</script>";
			}

		} else {
		 	echo "<script type='text/javascript'>document.location.replace('index.php');</script>";
		 }
		 mysqli_free_result($result);
		 mysqli_close($db);
}
// fonction pour valider les entrées
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
	<title>Vote</title>
	<link  rel="stylesheet" href="css/main.css?v=492">
</head>

<!DOCTYPE html >
<body>
<div class="start">
		
	<div class="corpsstart">
		<div class="content">
			<table border="0">
				<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post">
				<tr>
					<td align="center" height="130px">
						<span style="color:white; font-size: 2em; font-weight:bold">Bienvenue</span>
						<br>
						<span style="color:#3b05ff; font-size: 2em">Welcome</span>
						
					</td>
				</tr>
				<tr>
					<td align="center" height="50px">
						<span style="color:white; font-size: 1.2em; font-weight:bold">Veuillez entrer le code</span>
					<br>
					<span style="color:#3b05ff; font-size: 1.2em">Please enter your code</span>
				</td>
				</tr>
				<tr>
					<td align="center" height="80px">
						<input type="text" name="mdpUtil" style="font-size: 1.5em" size="10">	
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