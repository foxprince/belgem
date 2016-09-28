<?php
/*===================session========================*/
session_start();



// if session variable not set, redirect to login page
if(!isset($_SESSION['authenticated'])) {
  //header('Location: login.php');
  exit('session timeout');
}

if($_SESSION['authenticated']!='SiHui'){
	$_SESSION=array();
	if (isset($_COOKIE[session_name()])){
		setcookie(session_name(), '', time()-86400, '/');
	}
	session_destroy();
	//header('Location: login.php');
    exit('session timeout');
}

$username=$_SESSION['username'];
$account_level=$_SESSION['account_level'];



if(!isset($_POST['check'])){
	exit('NO PERMISSION');
}
if($_POST['check']!="YES"){
	exit('NO PERMISSION');
}



include('nuke_magic_quotes.php');
require_once('../includes/connection.php');
	

$conn=dbConnect('write','pdo');
$conn->query("SET NAMES 'utf8'");


$sql='SELECT * FROM datafile_importing_status';
$stmt=$conn->query($sql);
foreach($stmt as $row){
	$feedback_main=$row['status'];
	$total_new=$row['added'];
	$$total_skipped=$row['passed'];
	$total_proceeded=$row['proceeded'];
	$total_recordes=$row['total_records'];
}
?>

<p id="messagemain"><?php echo $feedback_main; ?></p>
<p id="added"><?php echo $total_new; ?></p>
<p id="ignored"><?php echo $total_skipped; ?></p>
<p id="proceeded"><?php echo $total_proceeded; ?></p>
<p id="totalrecords"><?php echo $total_recordes; ?></p>