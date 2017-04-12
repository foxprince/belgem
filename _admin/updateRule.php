<?php
/*===================session========================*/
session_start();

if(isset($_POST['logout'])){
	if(isset($_SESSION['authenticated'])){
			$_SESSION=array();
			if (isset($_COOKIE[session_name()])){
			    setcookie(session_name(), '', time()-86400, '/');
			}
			session_destroy();
	 }
	 header('Location: login.php');
     exit;
}

// if session variable not set, redirect to login page
if(!isset($_SESSION['authenticated'])) {
  header('Location: login.php');
  exit;
}

if($_SESSION['authenticated']!='SiHui'){
	$_SESSION=array();
	if (isset($_COOKIE[session_name()])){
		setcookie(session_name(), '', time()-86400, '/');
	}
	session_destroy();
	header('Location: login.php');
    exit;
}

if(!isset($_POST['source']) || !isset($_POST['target']) || !isset($_POST['recordid']) || !isset($_POST['carat_from']) || !isset($_POST['carat_to'])){
	exit('error');
}

require_once('../includes/connection.php');
$conn=dbConnect('write','pdo');
$conn->query("SET NAMES 'utf8'");



$source=$_POST['source'];
$target=$_POST['target'];
$recordid=$_POST['recordid'];
$carat_from=$_POST['carat_from'];
$carat_to=$_POST['carat_to'];
$color=$_POST['color'];
$clarity=$_POST['clarity'];
$cut=$_POST['cut'];
$polish = $_POST['polish'];
$symmetry = $_POST['symmetry'];
$shape = $_POST['shape'];
$certificate = $_POST['certificate'];
$fluo = $_POST['fluo'];
$the_para_value=$_POST['the_para_value'];


$sql='UPDATE price_settings  SET carat_from = '.$carat_from.', carat_to = '.$carat_to.', color = "'.$color.'", clarity = "'.$clarity.'", cut = "'.$cut.'", symmetry = "'.$symmetry.'", polish = "'.$polish.'", certificate = "'.$certificate.'", fluo = "'.$fluo.'", shape = "'.$shape.'", the_para_value = '.$the_para_value.' WHERE id = '.$recordid;

$stmt=$conn->query($sql);		
$OK=$stmt->rowCount();

if($OK){
	echo 'ok';
}else{
	echo 'error';
}