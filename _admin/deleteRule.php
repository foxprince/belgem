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

if(!isset($_POST['source']) || !isset($_POST['target']) || !isset($_POST['recordid'])){
	exit('error');
}

require_once('../includes/connection.php');
$conn=dbConnect('write','pdo');
$conn->query("SET NAMES 'utf8'");



$source=$_POST['source'];
$target=$_POST['target'];
$recordid=$_POST['recordid'];

$sql='DELETE FROM price_settings_'.$source.'_'.$target.' WHERE id = '.$recordid;
$stmt=$conn->query($sql);
$deleted=$stmt->rowcount();


if($deleted){
	echo 'ok';
}else{
	echo 'error';
}