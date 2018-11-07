<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 1);
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
    $base=$_SESSION["dbdefault"];
    
    
?>

<head>
	<meta http-equiv="Cache-control" content="no-cache">
	<meta http-equiv="Expires" content="-1">
	<meta name="apple-mobile-web-app-capable" content="yes" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="apple-touch-icon" href="imgs/icon-touchmots.png"/>
	<meta name="apple-mobile-web-app-title" content="Ipad v2">
	<meta Charset='UTF-8'>
	<title>Statistiques</title>
	<link  rel="stylesheet" href="../css/main.css">
</head>

<?php
	$query = "SELECT * FROM Question  WHERE NomOpe = '$base' ORDER BY Ordre ASC " ;
    $result = mysqli_query($db, $query);
    $rowcount = mysqli_num_rows($result);
    //$row = mysqli_fetch_assoc($result);
	$Question=array();
	$id=array();
	$nbrvot=array();
	while ($row = mysqli_fetch_assoc($result)) { 
			$Question[]=$row['Question'];
			$id[]=$row['IdQuest'];
		}

	foreach ($id as $value) {
		$query = "SELECT * FROM Reponses  WHERE IdQuest = $value  " ;
		$result = mysqli_query($db, $query);
		$rowcountquest = mysqli_num_rows($result);
		
		$nbrvot[]=$rowcountquest;
	}

		
?>

<!DOCTYPE html >
<body>
<style type="text/css">
	/*.fond{
		background-color: #b8d5ff;
		height:2000px;
		margin:-10px;
	}*/
	.container{
	display:flex;
	flex-direction: column;
	font-family: Arial, sans-serif;
	}
	.nomOp {
		display: flex;
  		justify-content: center;
  		flex-direction: column;
  		margin-right: 30px;
  		text-align: right;
		font-size: 3vw;
	}
	.corps{
	display:flex;
	/*background-color: green;*/
	width:90%;
	flex-wrap: wrap;
	align-items:center;
	font-family: Arial, sans-serif;
	margin-top: 5%;
	margin-left: 20px;
	}
	.question{
		width:50%;
		margin-bottom: 2%;
		height:25%;
		font-size:2vw;
		/*font-weight: bold;*/
		color:Indigo;
	}
	

	.tableau{
	display: flex;
	/*background-color: gold;*/
	width:70%;
	margin-top: 2%;	
	}
	
	.num{
		width:4%;
		font-size:2.5vw;
		font-weight: bold;
		color :red;

	}
	.proposition{
		font-size:2.5vw;
		width:85%;
	}
	.resultat{
		height:10%;
		font-size:2vw;
		width:10%;
		/*content: "<br />";*/
		/*vertical-align: middle;*/
	}

	.containgraph{
		width:70%;
		margin-top: 1%;
	}
	.bar{
		display:flex;
		width: 85%;
		-webkit-transition: width 2s; /* Safari */
    	transition: width 2s;
	}
	.pourcentage{
		background: Indigo;
		height:5%;
		text-align: right;
		color:white;
		font-size:2vw;
	}
	.containbar{
		width:100%;
	}


</style>
<div class="startAdm">	
	<!-- <div class="container"> -->

		<div class="titre">
			<div class="logo">
				<a href="../admin/tdb.php"> <img src="../imgs/logosollea.png" alt="" class="responsiveimgs"></a>
			</div>
			<div class="nomOpAdm">
				<span class="TitreAdmin3">Statistiques</span>
				<span class="TitreAdmin4"><?php echo $_SESSION["NomEve"]; ?></span>
			</div>
		</div>
		
		<div class="corps">
			<table border="0">
				<tr>
					<td height="50px">
						<span style="font-size:2vw; font-weight:bold;color:DarkRed;"> Questions </span>
					</td>
					<td align="middle">
						<span style="font-size:1.5vw; font-weight:bold;color:DarkRed;">Nbr de votes</span>
					</td>
				</tr>
				<?php 
				for ($x = 0; $x <= ($rowcount-1); $x++) { ?>
				<tr>
					<td class="question"  >
						<?php echo $Question[$x] ?>
					</td>
				
					<td class="resultat" align="middle">
						<?php echo $nbrvot[$x] ?>
					</td>
				</tr>	
				<tr>
					<td colspan="2" height="5px" style="background-color: indigo;">
						
					</td>
				</tr>
			<?php  } ?>
			</table>
		</div>
	<!-- </div> -->
</div>
<?php 
$QuestionId="";
mysqli_free_result($result);
mysqli_close($db);
?>	
			
</body>
</html>