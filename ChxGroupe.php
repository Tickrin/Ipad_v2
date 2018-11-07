<?php
session_start();
header('Expires: Sun, 01 Jan 2014 00:00:00 GMT');
header('Cache-Control: no-store, no-cache, must-revalidate');
header('Cache-Control: post-check=0, pre-check=0', FALSE);
header('Pragma: no-cache');
header('Content-Type: text/html; charset=UTF-8');
?>

<head>
			<meta http-equiv="Cache-control" content="no-cache">
			<meta http-equiv="Expires" content="-1">
			<meta name="apple-mobile-web-app-capable" content="yes" />
			<meta name="viewport" content="width=device-width, initial-scale=1">
			<link rel="apple-touch-icon" href="imgs/icon-touchmots.png"/>
			<meta name="apple-mobile-web-app-title" content="Ipad v2">
			<meta Charset='UTF-8'>
			<title>Choix Groupe</title>
			<link  rel="stylesheet" href="css/main.css?v=322">
			
			
		</head>

<style> /*le css pour formater les boutons groupe*/
	a:hover, a:visited, a:link, a:active
	{
	    text-decoration: none;
	}
#btngrpe {
	border-radius   : 15px;
	text-decoration : none;
	background-color:<?php echo $_SESSION['ColBtn']; ?>;
	color           :<?php echo $_SESSION['ColTxt']; ?>;
	font-size       : 1.5em;
	margin          : 10px;
	padding         : 30px; 
	width           : 30px;
	height          : 15px;    
	}

	.fond {
		padding-bottom: 50px;
		margin:-10px;
		height:2000px;
		<?php if($_SESSION['BackgImage']==""){ ?>
		background-color: <?php echo $_SESSION["BackgCol"] ?>;
		<?php } else { ?>
		background-image: url("logos/<?php echo $_SESSION['BackgImage'] ?>");
		background-repeat: repeat;
		<?php } ?>
	}

	.TitreUt{
		color:<?php echo $_SESSION['ColTitre']; ?>;
	}

	.nomOp {
		/*display: flex;*/
  		/*justify-content: center;
  		flex-direction: column;*/
  		font-family: Arial, sans-serif;
  		margin-top: 10px;
  		margin-right: 15px;
		text-align: right;
		/*background-color: green;*/
		font-size: 1.3em;
	}
	
	.question{
	margin-top: 50px;
	margin-bottom: 20px;
	color:<?php echo $_SESSION['ColTitQuest']; ?>;
	font-size:1.4em;
	font-weight: bold;
}
</style>

<!DOCTYPE html >
<body>
<div class="fond">
	<div class="titre">
		<div class="logo">
		<img src="../logos/<?php echo $_SESSION['Logo']; ?>" alt="" class="responsiveimgs">
		</div>
		<div class="nomOp">
		<span class="TitreUt"><?php echo $_SESSION['NomOpe2']; ?></span>
		<span class="TitreUt"><?php echo $_SESSION['NomOpe3']; ?></span>
		</div>
	</div>
	
	<div class="corps">
		<table border="0" width=80% >
			<tr>
				<td height="80px" align="center">
					<?php if ($_SESSION['Langue']=="fra") { ?>
						<span class="question">Veuillez choisir<br>le numéro de votre équipe</span>
						<?php } else { ?>
						<span class="question">Please choose<br>your team number</span>
						<?php } ?>
				</td>
			</tr>
		</table>
		<?php if($_SESSION['Groupe']=='oui'){ // création du tableau avec les groupes
		$nbrgroupes=$_SESSION['NbrGroupe'];
		$nbrCol=3;
		$nbrRow=ceil($nbrgroupes / $nbrCol);

		echo "<table border =\"0\" style='border-collapse: collapse'>";
		$p = 1;
			for ($row=1; $row <= $nbrRow; $row++) { 
				echo "<tr> \n";
				
				for ($col=1; $col <= $nbrCol; $col++) { 
				   if ($p<=$nbrgroupes) {
				   echo "<td>
				   		<a href='Chxmodule.php?grpe=$p'><p id='btngrpe'>$p</p></a>
						</td> \n";
					}
					$p=$p+1;
				}
				echo "</tr>";
			}
			echo "</table>";
		} else {
		echo "<script type='text/javascript'>document.location.replace('Chxmodule.php');</script>";
		} ?>
	</div>
</div>

<script>
function validationgrpe() {
    var txt;
    if (confirm("Press a button!")) {
        txt = "You pressed OK!";
    } else {
        txt = "You pressed Cancel!";
    }
    document.getElementById("demo").innerHTML = txt;
}
</script>
</body>
</html>