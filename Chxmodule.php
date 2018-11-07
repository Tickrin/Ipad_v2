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
	<title>Vote</title>
	<link  rel="stylesheet" href="css/main.css?v=372">
</head>

<?php  // creation variable session pour fixer le groupe
	if(isset($_GET["grpe"])){
		$_SESSION["grpeparticipant"] = $_GET["grpe"];
	}
?>

<!DOCTYPE html >
<style type="text/css">
	.TitreUt{
		color:<?php echo $_SESSION['ColTitre']; ?>;
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
	.corps{
		display:flex;
		flex-direction: column;
		width:100%;
		flex-wrap: wrap;
		justify-content:space-around;
		align-items:center;
		font-family: Arial, sans-serif;
		margin-top: 100px;
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
	.boutton{
	/*background-color: #4CAF50;*/
	-webkit-appearance: none;
	-moz-appearance: none;
	appearance: none;
	border: none;
	border-radius:25px;
    width:150px;
    font-weight: bold;
    padding-top: 15px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 4px 2px;
    cursor: pointer;

}
</style>
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
			<div>
			<?php if($_SESSION["ModulQuiz"]=='oui') { ?>
			<a href="quiz/index.php" class="boutton" style="background-color: <?php echo $_SESSION['ColBtn']; ?>; color:<?php echo $_SESSION['ColTxt']; ?>">
			<?php if ($_SESSION['Langue']=="fra") {
					echo "Voter";
				} else {
					echo "Vote";
				} ?>
			</a>
			<?php } ?>
			</div>
			<div style="margin-top: 30px;" >
			<?php if($_SESSION["ModulQuest"]=='oui') { ?>
			<a href="quiz/index.php" class="boutton" style="background-color: <?php echo $_SESSION['ColBtn']; ?>; color:<?php echo $_SESSION['ColTxt']; ?>">
			<?php if ($_SESSION['Langue']=="fra") {
					echo "Questions";
				} else {
					echo "Questions";
				} ?>
			</a>
			<?php } ?>
			</div>
			<div style="margin-top: 30px;" >
			<?php if($_SESSION["ModulFilInfo"]=='oui') { ?>
			<a href="quiz/index.php" class="boutton" style="background-color: <?php echo $_SESSION['ColBtn']; ?>; color:<?php echo $_SESSION['ColTxt']; ?>">
			<?php if ($_SESSION['Langue']=="fra") {
					echo "Fil Infos";
				} else {
					echo "News Stream";
				} ?>
			</a>
			<?php } ?>
			</div>
		</div>
	</div>
			
</body>
</html>