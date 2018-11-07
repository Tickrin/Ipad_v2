<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
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
	<title>Ipad v2 - Ajout Ope</title>
	<link  rel="stylesheet" href="../css/main.css?v=212">
	
	<!-- Pour Color Picker -->
	<link rel="stylesheet" href="../css/bootstrap-3.0.0.min.css">
	<link rel="stylesheet" href="../css/pick-a-color-1.2.3.min.css">
	<!-- fin color picker -->

	<!-- Pour Date Picker : -->
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	<link rel="stylesheet" href="/resources/demos/style.css">
	<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<!-- fin date picker -->

	<!-- Fonction pour Date Picker -->
	<script>
	$( function() {
	$( "#datepicker" ).datepicker();
	} );
	</script>
	<script>
	$( function() {
	$( "#datepicker2" ).datepicker();
	} );
	</script>
</head>

<!DOCTYPE html >
<body>
<div class="startAdm">	

	<div class="titre">	
		<div class="logo">
		<a href ="tdb.php"><img src="../imgs/logosollea.png" alt="" class="responsiveimgs"></a>
		</div>
		<div class="nomOpAdm">
			<span class="TitreAdmin3">Ajout Evénement</span>
			<span class="TitreAdmin4"><?php //echo $_SESSION["NomEve"]; ?></span>
		</div>
	</div>

	<form action="tdb.php" method="post" enctype="multipart/form-data"> 

<div class="corpstxt">
	
	<div class="boxtxt">

		<table border="0" >
			<tr>
				<td colspan="2" height="40px">
					<span style="color:white; font-size: 1.4em; font-weight:bold">Informations générales</span>
				</td>
			</tr>
			<tr>
				<td width="400px">
					<div class="input"><span style="color:Indigo; font-size: 1.2em; font-weight:bold">Intitulé de l'événement (ligne1) :</span>
					<br>
					<input type="text" name="NomOpe2" size="30" style="font-size: 1.2em; ">
					</div>
				</td>
				<td width="400px">
					<div class="input"><span style="color:Indigo; font-size: 1.2em; font-weight:bold">Date de debut :</span>
					<br>
					<input type="text" name="DateDebutOpe" id="datepicker">
					</div>
				</td>
			</tr>
			<tr>
				<td>
					<div class="input"><span style="color:Indigo; font-size: 1.2em; font-weight:bold">Intitulé de l'événement (ligne2) :</span>
					<br>
					<input type="text" name="NomOpe3" size="30" style="font-size: 1.2em; ">
					</div>
				</td>
				<td>
					<div class="input"><span style="color:Indigo; font-size: 1.2em; font-weight:bold">Date de fin :</span>
					<br>
					<input type="text" name="DateFinOpe" id="datepicker2">
					</div>
				</td>
			</tr>
			<tr>
				<td>
					<div class="input"><span style="color:Indigo; font-size: 1.2em; font-weight:bold">Mot de passe administrateur :</span>
					<br>
					<input type="text" name="MdpAdmin" size="10" style="font-size: 1.2em; ">
					</div>
				</td>
				<td>
					<div class="input"><span style="color:Indigo; font-size: 1.2em; font-weight:bold">Mot de passe utilisateur :</span>
					<br>
					<input type="text" name="MdpUtil" size="10" style="font-size: 1.2em; ">
					</div>
				</td>
			</tr>
			<tr>
				<td height="50px" colspan="2">
					<span style="color:white; font-size: 1.4em; font-weight:bold">Codes couleur</span>
				</td>
			</tr>
			<tr>
				<td>
					<div class="input"><span style="color:Indigo; font-size: 1.2em; font-weight:bold">Titres :</span>
					<br>
					<input type="text" class="pick-a-color form-control" name="ColTitre" size="20" style="font-size: 1.2em; ">
					</div>
				</td>
				<td>
					<div class="input"><span style="color:Indigo; font-size: 1.2em; font-weight:bold">Texte bouton système :</span>
					<br>
					<input type="text" class="pick-a-color form-control" name="ColTxt" size="20" style="font-size: 1.2em; ">
					</div>
				</td>
			</tr>
			<tr>
				<td>
					<div class="input"><span style="color:Indigo; font-size: 1.2em; font-weight:bold">Fond d'écran :</span>
					<br>
					<input type="text" class="pick-a-color form-control" name="BackgCol" size="20" style="font-size: 1.2em; ">
					</div>
				</td>
				<td>
					<div class="input"><span style="color:Indigo; font-size: 1.2em; font-weight:bold">Bouton système :</span>
					<br>
					<input type="text" class="pick-a-color form-control" name="ColBtn" size="20" style="font-size: 1.2em; ">
					</div>
				</td>
			</tr>
			<tr>
				<td>
					<div class="input"><span style="color:Indigo; font-size: 1.2em; font-weight:bold">Bouton vote :</span>
					<br>
					<input type="text" class="pick-a-color form-control" name="ColBoutVot" size="20" style="font-size: 1.2em; ">
					</div>
				</td>
				<td>
					<div class="input"><span style="color:Indigo; font-size: 1.2em; font-weight:bold">Texte bouton vote :</span>
					<br>
					<input type="text" class="pick-a-color form-control" name="ColTxtVot" size="20" style="font-size: 1.2em; ">
					</div>
				</td>
			</tr>
			<tr>
				<td>
					<div class="input"><span style="color:Indigo; font-size: 1.2em; font-weight:bold">Texte question :</span>
					<br>
					<input type="text" class="pick-a-color form-control" name="ColTitQuest" size="20" style="font-size: 1.2em; ">
					</div>
				</td>
				<td>
					<div class="input"><span style="color:Indigo; font-size: 1.2em; font-weight:bold">Choix réponse :</span>
					<br>
					<input type="text" class="pick-a-color form-control" name="ColBonRep" size="20" style="font-size: 1.2em; ">
					</div>
				</td>
			</tr>
			<tr>
				<td colspan="2" height="50px">
					<span style="color:white; font-size: 1.4em; font-weight:bold">Visuels</span>
				</td>
			</tr>
			<tr>
				<td>
					<div class="input" height="50px"><span style="color:Indigo; font-size: 1.2em; font-weight:bold">Image de fond écran :</span>
					<br>
					<input type="file" name="fileToUpload2" id="fileToUpload2">
					</div>
				</td>
				<td>
					<div class="input"><span style="color:Indigo; font-size: 1.2em; font-weight:bold">Logo :</span>
					<br>
					<input type="file" name="fileToUpload" id="fileToUpload">
					</div>
				</td>
			</tr>
			<tr>
				<td height="50px">
					<span style="color:white; font-size: 1.4em; font-weight:bold">Modules</span>
				</td>
				<td>
					<span style="color:white; font-size: 1.4em; font-weight:bold">Groupes</span>
				</td>
			</tr>
			<tr>
				<td>
					<div class="input">
					<input type="checkbox" name="ModulQuiz" value="oui"  ">  <span style="color:Indigo; font-size: 1.2em; font-weight:bold">Module Quiz</span>
					</div>
				</td>
				<td>
					<div class="input">
					<input type="checkbox" name="Groupe" value="oui"  ">  <span style="color:Indigo; font-size: 1.2em; font-weight:bold">Gestion par groupe</span>
					</div>
				</td>
			</tr>
			<tr>
				<td>
					<div class="input">
					<input type="checkbox" name="ModulQuest" value="oui"  ">  <span style="color:Indigo; font-size: 1.2em; font-weight:bold">Module Questions</span>
					</div>
				</td>
				<td>
					<div class="input"><span style="color:Indigo; font-size: 1.2em; font-weight:bold">Nombre de groupes :</span>
						<select name="NbrGroupe" style="font-size: 1em; color: #008bcb;">
						<option value="0" style="font-size: 1em; color: #008bcb;" >0</option>
						<option value="1" style="font-size: 1em; color: #008bcb;" >1</option>
						<option value="2" style="font-size: 1em; color: #008bcb;" >2</option>
						<option value="3" style="font-size: 1em; color: #008bcb;" >3</option>
						<option value="4" style="font-size: 1em; color: #008bcb;" >4</option>
						<option value="5" style="font-size: 1em; color: #008bcb;" >5</option>
						<option value="6" style="font-size: 1em; color: #008bcb;" >6</option>
						<option value="7" style="font-size: 1em; color: #008bcb;" >7</option>
						<option value="8" style="font-size: 1em; color: #008bcb;" >8</option>
						<option value="9" style="font-size: 1em; color: #008bcb;" >9</option>
						<option value="10" style="font-size: 1em; color: #008bcb;">10</option>
						<option value="11" style="font-size: 1em; color: #008bcb;">11</option>
						<option value="12" style="font-size: 1em; color: #008bcb;">12</option>
						<option value="13" style="font-size: 1em; color: #008bcb;">13</option>
						<option value="14" style="font-size: 1em; color: #008bcb;">14</option>
						<option value="15" style="font-size: 1em; color: #008bcb;">15</option>
						<option value="16" style="font-size: 1em; color: #008bcb;">16</option>
						<option value="17" style="font-size: 1em; color: #008bcb;">17</option>
						<option value="18" style="font-size: 1em; color: #008bcb;">18</option>
						<option value="19" style="font-size: 1em; color: #008bcb;">19</option>
						<option value="20" style="font-size: 1em; color: #008bcb;">20</option>
					</select>
					</div>
				</td>
			</tr>
			<tr>
				<td>
					<div class="input">
					<input type="checkbox" name="ModulFilInfo" value="oui"  ">  <span style="color:Indigo; font-size: 1.2em; font-weight:bold">Module Fil-Info</span>
					</div>
				</td>
				<td>
					<span style="color:white; font-size: 1.4em; font-weight:bold">Langue</span>
				</td>
			</tr>
			<tr>
				<td>
					<div class="input"><span style="color:Indigo; font-size: 1.2em; font-weight:bold">Temps entre votes :</span>
						<select name="Temps" style="font-size: 1em; color: #008bcb;">
						<option value="0" style="font-size: 1em; color: #008bcb;" >0</option>
						<option value="1" style="font-size: 1em; color: #008bcb;" >1</option>
						<option value="2" style="font-size: 1em; color: #008bcb;" >2</option>
						<option value="3" style="font-size: 1em; color: #008bcb;" >3</option>
						<option value="4" style="font-size: 1em; color: #008bcb;" >4</option>
						<option value="5" style="font-size: 1em; color: #008bcb;" >5</option>
						<option value="6" style="font-size: 1em; color: #008bcb;" >6</option>
						<option value="7" style="font-size: 1em; color: #008bcb;" >7</option>
						<option value="8" style="font-size: 1em; color: #008bcb;" >8</option>
						<option value="9" style="font-size: 1em; color: #008bcb;" >9</option>
						<option value="10" style="font-size: 1em; color: #008bcb;">10</option>
						</select>
					</div>
				</td>
				<td>
					<div class="input"><span style="color:Indigo; font-size: 1.2em; font-weight:bold">Langue :</span>
						<select name="Langue" style="font-size: 1em; color: #008bcb;">
						<option value="fra" style="font-size: 1em; color: #008bcb;" >Français</option>
						<option value="ang" style="font-size: 1em; color: #008bcb;" >Anglais</option>
						</select>
					</div>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<div class="input">
					<br>
					<input name="submit" type="submit" value="Soumettre" class="submitstart">	
					</div>
				</td>
			</tr>
		</table>

	</div>
</div>
</div>

</form>

  <script src="../js/tinycolor-0.9.15.min.js"></script>
  <script src="../js/pick-a-color-1.2.3.min.js"></script>	

  <script type="text/javascript">

   $(document).ready(function () {
    $(".pick-a-color").pickAColor();
   });

  </script>			
</body>
</html>