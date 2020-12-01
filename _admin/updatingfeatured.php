<?php
/*===================session========================*/
session_start();

require_once ('../cn/includes/header_ele.php');


require_once('../includes/connection.php');
$conn=dbConnect('write','pdo');
$conn->query("SET NAMES 'utf8'");



if(isset($_POST['id'])){
	
	include('nuke_magic_quotes.php');
	
	$id=$_POST['id'];
	$thevalue=$_POST['thevalue'];
	
	$sql_update="UPDATE diamonds SET featured = '".$thevalue."' WHERE id = ".$id;
	$stmt=$conn->query($sql_update);
    $OK=$stmt->rowCount();
			

	if($OK){
		echo 'OK';
	}else{
		echo "ERROR";
	}
}
?>

