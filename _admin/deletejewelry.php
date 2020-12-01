<?php
/*===================session========================*/
session_start();

require_once ('../cn/includes/header_ele.php');


require_once('../includes/connection.php');
$conn=dbConnect('write','pdo');
$conn->query("SET NAMES 'utf8'");



$id=$_POST['id'];


$sql_delete="DELETE FROM jewelry WHERE id = ?";

					
$stmt=$conn->prepare($sql_delete);	  
$stmt->execute(array($id));
$OK=$stmt->rowCount();
$error=$stmt->errorInfo();
if(isset($error[2])){
	$error=$error[2];
	exit($error);
}
if($OK){
	echo "ok";
}else{
	echo "Error: unkown problem";
}
?>
