<?php
/*===================session========================*/
session_start();

require_once ('../cn/includes/header_ele.php');

if(!isset($_POST['source']) || !isset($_POST['target']) || !isset($_POST['recordid'])){
	exit('error');
}

require_once('../includes/connection.php');
$conn=dbConnect('write','pdo');
$conn->query("SET NAMES 'utf8'");



$source=$_POST['source'];
$target=$_POST['target'];
$recordid=$_POST['recordid'];

$sql='DELETE FROM price_settings where id = '.$recordid;
$stmt=$conn->query($sql);
$deleted=$stmt->rowcount();


if($deleted){
	echo 'ok';
}else{
	echo 'error';
}