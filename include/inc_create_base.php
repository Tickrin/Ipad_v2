<?php
	$db = mysqli_connect($dbhost, $dbuser, $dbpass);

	// Test if connection ok
	if (mysqli_connect_errno()) {
	die("Database connection failed 1: " . mysqli_connect_error() . " (" . mysqli_connect_errno() . ")");
	}

	if ($db->query ("DESCRIBE Motdp"  )) {
	// Si la table existe :
		} else{	
		// si la table n'existe pas : creation de la BASE mdp
		$sql = "CREATE DATABASE `Motdp`";
		if ($db->query($sql) === TRUE) {
	    echo "Database Motdp created successfully";
		} else {
	    echo "Error creating database: " . $db->error;
		}
		

		// création d'une table mots de passe
		$base='Motdp';
		// on se reconnecte en utilisant le nom de la base
		$db = mysqli_connect($dbhost, $dbuser, $dbpass, $base);
		// Test if connection ok
		if (mysqli_connect_errno()) {
		die("Database connection failed 1: " . mysqli_connect_error() . " (" . mysqli_connect_errno() . ")");
		}

		$sql = "CREATE TABLE Mdp (IdMdp int NOT NULL AUTO_INCREMENT PRIMARY KEY, NomOpe VARCHAR(100), NomOpe2 VARCHAR(150),NomOpe3 VARCHAR(150),MdpAdmin VARCHAR(20), MdpUtil VARCHAR(20))";
		if ($db->query($sql) === TRUE) {
	    echo "Table created successfully";
		} else {
	    echo "Error creating Table: " . $db->error;
		}
	}	

	


	// création de la BASE opération
	$sql = "CREATE DATABASE `$NomOpe`";
	if ($db->query($sql) === TRUE) {
    echo "Database created successfully";
	} else {
    echo "Error creating database: " . $db->error;
	}

	$db = mysqli_connect($dbhost, $dbuser, $dbpass, $NomOpe);
	// Test if connection ok
	if (mysqli_connect_errno()) {
	die("Database connection failed 1: " . mysqli_connect_error() . " (" . mysqli_connect_errno() . ")");
	}
	// création table Parametres
	$sql = "CREATE TABLE Parametres (IdOpe int NOT NULL AUTO_INCREMENT PRIMARY KEY, NomOpe VARCHAR(100), NomOpe2 VARCHAR(150), NomOpe3 VARCHAR(150),DateDebutOpe VARCHAR(10), DateFinOpe VARCHAR(10), MdpAdmin VARCHAR (20), MdpUtil VARCHAR (20), ColTitre VARCHAR (20), ColTxt VARCHAR (20), ColBtn VARCHAR (20), ModulQuiz VARCHAR (3),ModulQuest VARCHAR (3),ModulFilInfo VARCHAR (3),Groupe VARCHAR (3), NbrGroupe tinyint(2), Temps tinyint(2), Logo VARCHAR(60), Langue VARCHAR(4))";
	if ($db->query($sql) === TRUE) {
    echo "Table created successfully";
	} else {
    echo "Error creating Table: " . $db->error;
	}
	
	// création table Question
	$sql = "CREATE TABLE Question (IdQuest int NOT NULL AUTO_INCREMENT PRIMARY KEY, NomOpe VARCHAR(50), Question VARCHAR(150),Ouverte VARCHAR(3) NOT NULL DEFAULT 'non', Affichee VARCHAR(3) NOT NULL DEFAULT 'non', Ordre tinyint(2))";
			if ($db->query($sql) === TRUE) {
    			echo "Table created successfully";
				// $sql="INSERT INTO Question (NomOpe, Question) VALUES ('$base', '$question')";
			if ($db -> query($sql) === FALSE) {
				echo "Une erreur est survenue (insert), veuillez nous en excuser" . $sql . "<br>" . $db -> error;
			     } 
			}
	// creation de la table reponses
	$sql = "CREATE TABLE Reponses (IdRep int NOT NULL AUTO_INCREMENT PRIMARY KEY, NomOpe VARCHAR(50), IdQuest VARCHAR(50),IdProp VARCHAR(50),Reponse VARCHAR(4), NumGroupe tinyint(2),BonRep VARCHAR(4))";
		    if ($db->query($sql) === TRUE) {
			    echo "Table created successfully";
			 } else {
		      echo "Error creating Table: " . $db->error;
			}	

	$sql = "CREATE TABLE Propositions (IdProp int NOT NULL AUTO_INCREMENT PRIMARY KEY, NomOpe VARCHAR(50), IdQuest VARCHAR(50), Proposition VARCHAR(150),BonneRep VARCHAR(3))";
            if ($db->query($sql) === TRUE) {
                echo "Table created successfully";
             }   else {
		      echo "Error creating Table: " . $db->error;
			}		
            

	// création du cookie dbdefaut pour faire de l'ope créée l'ope par defaut
			$cookie_name = "dbdefaut";
	$cookie_value = $NomOpe;
	setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day

?>