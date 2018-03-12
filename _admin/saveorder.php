<?php
/*===================session========================*/
session_start();
include_once('../log.php');

// if session variable not set, redirect to login page
if(!isset($_SESSION['authenticated'])) {
  header('Location: login.php');
  exit('error');
}

if($_SESSION['authenticated']!='SiHui'){
	$_SESSION=array();
	if (isset($_COOKIE[session_name()])){
		setcookie(session_name(), '', time()-86400, '/');
	}
	session_destroy();
	header('Location: login.php');
    exit('error');
}


$username=$_SESSION['username'];
$account_level=$_SESSION['account_level'];



require_once('../includes/connection.php');
$conn=dbConnect('write','pdo');
$conn->query("SET NAMES 'utf8'");

$OK=true;


if(isset($_POST['stock_ref'])){
	$stock_ref_raw=$_POST['stock_ref'];
	$stock_refs=explode("|",$stock_ref_raw);
	foreach($stock_refs as $_sref){
		
		if(trim($_sref)!=''){
			$stock_ref=	$_sref;
			$sql_UPDATE='UPDATE diamonds SET ordered_by = "'.$username.'", ordered_time = NOW() WHERE stock_ref = "'.$stock_ref.'" ';
		logger($sql_UPDATE);	
			$stmt=$conn->query($sql_UPDATE);	  
			$insertOK=$stmt->rowCount();
			if(!$insertOK){
				$OK=false;
			}
		}
	}
if($OK){
	echo 'OK';
}
}else{
	echo 'error';
}
