<?php
/*===================session========================*/
session_start();

require_once ('../cn/includes/header_ele.php');


require_once('../includes/connection.php');
$conn=dbConnect('write','pdo');
$conn->query("SET NAMES 'utf8'");

if(!isset($_POST['openid']) || !isset($_POST['wechatname'])){
	exit('error');
}

$wechatname=$_POST['wechatname'];
$openid=$_POST['openid'];

$sql='UPDATE clients_list SET wechat_name = ? WHERE wechat_open_id = ?';
$stmt=$conn->prepare($sql);		
$stmt->execute(array($wechatname, $openid));
$OK=$stmt->rowCount();

if($OK){
	echo '<p id="message">ok</p>';
	echo '<p id="where">savewechatname</p>';
}