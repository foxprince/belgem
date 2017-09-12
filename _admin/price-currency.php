<?php
/*
#在此处修改钻石价格参数(该参数只对代购网站有效)：


#小于1.5克拉时参数
$price_ratio_001=1.2;


#1.5克拉到3克拉时参数
$price_ratio_002=1.2;


#3克拉以上参数
$price_ratio_003=1.2;
*/


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


if($account_level!=0){
	exit;
}

require_once('../includes/connection.php');
$conn=dbConnect('write','pdo');
$conn->query("SET NAMES 'utf8'");



if(isset($_POST['USD_EUR']) && isset($_POST['USD_GBP']) && isset($_POST['USD_CNY'])){
	
	$USD_EUR = $_POST['USD_EUR'];
	$USD_GBP = $_POST['USD_GBP'];
	$USD_CNY = $_POST['USD_CNY'];
	
	$sql_crr_update='UPDATE convert_currency SET USD_EUR = '.$USD_EUR.', USD_GBP = '.$USD_GBP.', USD_CNY = '.$USD_CNY.' WHERE id = 1';
	$stmt=$conn->query($sql_crr_update);
	$updated=$stmt->rowCount();
}



$sql_currency='SELECT * FROM convert_currency';
foreach($conn->query($sql_currency) as $r){
	$USD_EUR = $r['USD_EUR'];
	$USD_GBP = $r['USD_GBP'];
	$USD_CNY = $r['USD_CNY'];
}
?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>管理界面:交易历史纪录</title>
<link rel="stylesheet" href="adminstyle.css">
<link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css" />
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
div#maincontent{
	padding-left:120px;
}
a.thebigbtn{
	display:inline-block;
	padding:58px 128px;
	background-color:#333;
	color:#FFF;
	font-size:18px;
	margin-right:20px;
	text-decoration:none;
}
a.thebigbtn:hover{
	background-color:#000;
}
</style>
<script src="/js/jquery-1.11.2.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>



</head>

<body>

<?php
include('navi.php');
?>
<div id="maincontent">


<?php
if(!empty($updated)){
?>
<h3 style="color:#C00;">汇率已经更新</h3>
<?php
}
?>

<h3>设定汇率</h3>
<form id="theform" action="" method="post">
<p>1美元 = <input name="USD_EUR" value="<?php echo $USD_EUR; ?>" />欧元 </p>
<p>1美元 ＝ <input name="USD_GBP" value="<?php echo $USD_GBP; ?>" />英镑</p>
<p>1美元 ＝ <input name="USD_CNY" value="<?php echo $USD_CNY; ?>" />人民币</p>

<input type="submit" value="保存" />
</form>





</div>


<div id="indication" style="position:fixed; width:100%; height:100%; background-color:rgba(255,255,255, 0.88); top:0; left:0; z-index:28; display:none;">
<div id="indiinner" style="position:relative; width:200px; background-color:#0CF; margin:150px auto; padding:20px; text-align:center;">
正在存储。。。
</div>
</div>


</body>
</html>