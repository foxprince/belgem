<?php
/*===================session========================*/
session_start();


if(!isset($_POST['source']) || !isset($_POST['target']) || !isset($_POST['carat_from']) || !isset($_POST['carat_to'])){
	exit('error');
}

require_once('../includes/connection.php');
$conn=dbConnect('write','pdo');
$conn->query("SET NAMES 'utf8'");



$source=$_POST['source'];
$target=$_POST['target'];
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

$maxnum=88;

$sql_max_records='SELECT COUNT(*) AS totalrules FROM price_settings where source="'.$source.'" and target="'.$target.'"';
$stmt_mum=$conn->query($sql_max_records);
$maxnumfound=$stmt_mum->rowcount();

if($maxnumfound){
	foreach($stmt_mum as $r){
		$maxnum=$r['totalrules'];
	}	
}


$sql='INSERT INTO price_settings (source,target,carat_from, carat_to, color, clarity, cut, symmetry, polish, fluo, certificate, shape, the_para_value, priority) VALUES (:source,:target,:carat_from, :carat_to, :color, :clarity, :cut, :symmetry, :polish, :fluo, :certificate, :shape, :the_para_value, :priority)';
$stmt=$conn->prepare($sql);	  
$stmt->bindParam(':source', $source, PDO::PARAM_STR);
$stmt->bindParam(':target', $target, PDO::PARAM_STR);
$stmt->bindParam(':carat_from', $carat_from, PDO::PARAM_STR);
$stmt->bindParam(':carat_to', $carat_to, PDO::PARAM_STR);
$stmt->bindParam(':color', $color, PDO::PARAM_STR);
$stmt->bindParam(':clarity', $clarity, PDO::PARAM_STR);

$stmt->bindParam(':cut', $cut, PDO::PARAM_STR);
$stmt->bindParam(':symmetry', $symmetry, PDO::PARAM_STR);
$stmt->bindParam(':polish', $polish, PDO::PARAM_STR);
$stmt->bindParam(':certificate', $certificate, PDO::PARAM_STR);
$stmt->bindParam(':fluo', $fluo, PDO::PARAM_STR);
$stmt->bindParam(':shape', $shape, PDO::PARAM_STR);

$stmt->bindParam(':the_para_value', $the_para_value, PDO::PARAM_STR);
$stmt->bindParam(':priority', $maxnum, PDO::PARAM_INT);
$stmt->execute();
$insertOK=$stmt->rowCount();

if($insertOK){
	echo 'ok';
}else{
	echo 'error';
}