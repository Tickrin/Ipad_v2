<?php




$query = "SELECT * FROM Reponses  WHERE IdQuest='$QuestionId'  AND Reponse='$Px' " ;
		$result2 = mysqli_query($db, $query);
		$rowcountrep = mysqli_num_rows($result2);
		

		
		if ($rowcountrep !=0) {
		$resQuestfinal=number_format((($rowcountrep/$rowcountquest)*100),0);
		} else {
	    	$resQuestfinal=0;
	    }

?>