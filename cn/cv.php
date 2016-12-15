<?php
session_start();
require_once('../log.php');
logger("update visiable");
require_once('../includes/connection.php');
$conn=dbConnect('write','pdo');
$conn->query("SET NAMES 'utf8'");

$action=$_POST['action'];
$stockref=$_POST['stockref'];
if($action=='removeFromSession'){
	$listarray=&$_SESSION['searchArray'];
	foreach ($listarray as $i => $value) {
    	if($listarray[$i]==$stockref)
    		unset($listarray[$i]);
    	}
    $listarray = array_values($listarray);
    echo 1;
}
else if($action=='chgVisiable'){
	$sql='UPDATE diamonds SET visiable = ABS(visiable-1) WHERE stock_ref ="'.$stockref.'"';
	logger($sql);
	$stmt=$conn->query($sql);
	$OK=$stmt->rowCount();

	if($OK){
	        $sql='select visiable from diamonds WHERE stock_ref ="'.$stockref.'"';
	        foreach($conn->query($sql) as $num){
	                $visiable=$num['visiable'];
	        }
	        echo $visiable;
	}else{
	        echo 'error';
	}
}
else if($action=='deleteK'){
	$sql='delete from diamonds WHERE stock_ref like	"K%"';
	logger($sql);
	$stmt=$conn->query($sql);
	$OK=$stmt->rowCount();

	if($OK){
		echo $OK;
	}else{
		echo 'error';
	}
}
?>
