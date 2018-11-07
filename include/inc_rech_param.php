<?php
$query = "SELECT * FROM Parametres  WHERE NomOpe='$ope' " ;
		$result = mysqli_query($db, $query);
		$row = mysqli_fetch_assoc($result);
		$rowcount = mysqli_num_rows($result);

		
		$_SESSION["dbdefaut"] = $ope;
		$_SESSION["NomOpe2"] = $row['NomOpe2'];
		$_SESSION["NomOpe3"] = $row['NomOpe3'];
		$_SESSION["ColTitre"] = $row['ColTitre'];
		$_SESSION["ColTxt"] = $row['ColTxt'];
		$_SESSION["ColBtn"] = $row['ColBtn'];
		$_SESSION["ColBoutVot"] = $row['ColBoutVot'];
		$_SESSION["ColTxtVot"] = $row['ColTxtVot'];
		$_SESSION["ColTitQuest"] = $row['ColTitQuest'];
		$_SESSION["ColBonRep"] = $row['ColBonRep'];
		$_SESSION["Logo"] = $row['Logo'];
		$_SESSION["BackgImage"] = $row['BackgImage'];
		$_SESSION["BackgCol"] = $row['BackgCol'];
		$_SESSION["ModulQuest"] = $row['ModulQuest'];
		$_SESSION["ModulQuiz"] = $row['ModulQuiz'];
		$_SESSION["ModulFilInfo"] = $row['ModulFilInfo'];
		$_SESSION["Groupe"] = $row['Groupe'];
		$_SESSION["NbrGroupe"] = $row['NbrGroupe'];
		$_SESSION["Langue"] = $row['Langue'];
		$_SESSION["Temps"] = $row['Temps'];
		

?>