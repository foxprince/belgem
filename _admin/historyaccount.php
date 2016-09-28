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

$username=$_SESSION['username'];
$account_level=$_SESSION['account_level'];

if($account_level>0){
	exit('no permit');
}

require_once('../includes/connection.php');
$conn=dbConnect('write','pdo');
$conn->query("SET NAMES 'utf8'");

?>





<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>管理界面:管理历史纪录</title>
<link rel="stylesheet" href="adminstyle.css">
<style>
body{
	font-family:'Microsoft Yahei', 微软雅黑, STHeiti, simsun, Arial, sans-serif;
	font-size:14px;
	font-weight:100;
	}

h1{
	position:relative;
	left:40px;
	font-family:Verdana, Geneva, sans-serif;
	font-weight:bold;
	font-size:20px;
	color:#000;
	margin-top:0px;
}
td{
	vertical-align:top;
	padding:5px;
	border-style:solid;
	border-width:1px;
	border-color:#CCC;
}
span.inditxt{
	font-weight:bold;
	color:#F60;
}
a.agentbtn{
	display:inline-block;
	padding:2px 5px;
	margin:3px 5px;
	background-color:#0CF;
}
</style>
<script src="http://sigway.be/lab/jquery-1.11.2.min.js"></script>

<script type="text/javascript">
$(document).ready(function(){
	
});
</script>


</head>

<body>

<?php
include('navi.php');
?>


<div id="maincontent" style="padding-bottom:50px;">



<div>
<h3 style="display:none;">历史纪录</h3>
<?php

	
$sql='SELECT * FROM login_history ORDER BY action_time DESC';
	
	
?>

<table cellpadding="0" cellspacing="0">
<tr style="background-color:#EEE;">
<td width="88">时间</td>
<td width="88">操作人</td>
<td width="158">事件</td>
</tr>

<?php

foreach($conn->query($sql) as $row){
?>
<tr>

<td><?php echo $row['action_time']; ?></td>
<td><?php echo $row['theuser']; ?></td>
<td><?php echo $row['the_action']; ?></td>


</tr>
<?php	
}
?>
</table>


</div>


<div id="#indication" style="position:fixed; width:100%; height:100%; background-color:rgba(255,255,255, 0.88); top:0; left:0; z-index:28; display:none;">
<div id="#indiinner" style="position:relative; width:200px; background-color:#0CF; margin:150px auto; padding:20px; text-align:center;">
正在存储。。。
</div>
</div>


</div>
</body>
</html>