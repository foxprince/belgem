<?php
/*===================session========================*/
session_start();
include_once('../log.php');
$username=$_SESSION['username'];
$account_level=$_SESSION['account_level'];

require_once('../includes/connection.php');
$conn=dbConnect('write','pdo');
$conn->query("SET NAMES 'utf8'");

$OK=true;


if(isset($_POST['stock_ref'])){
	$action = $_REQUEST['action'];
	$stock_ref=$_POST['stock_ref'];
	if($action=='order')
		$sql_UPDATE='UPDATE diamonds SET ordered_by = "'.$username.'", ordered_time = NOW() WHERE stock_ref in '.$stock_ref;
	else if($action=='appointment')
		$sql_UPDATE='UPDATE diamonds SET ordered_by = "'.$username.'", ordered_time = NOW(),customer = "'.$_REQUEST['customer'].'", appointment_time = "'.$_REQUEST['appointment_time'].'" WHERE stock_ref in '.$stock_ref;
	logger($sql_UPDATE);
	$stmt=$conn->query($sql_UPDATE);	  
	$insertOK=$stmt->rowCount();
	if(!$insertOK){ $OK=false; }
	if($OK){ echo 'OK'; }
	else{
		echo 'error';
	}
}
