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

require_once('../includes/connection.php');
$conn=dbConnect('write','pdo');
$conn->query("SET NAMES 'utf8'");


/*

if(isset($_POST['content_en']) && isset($_POST['content_ch'])){
	
	include('nuke_magic_quotes.php');
	
	$content_en=$_POST['content_en'];
	$content_ch=$_POST['content_ch'];
	$title_en=$_POST['title_en'];
	$title_ch=$_POST['title_ch'];
	
	
	
	
	
	$sql_insert='INSERT INTO news (title_en, title_ch, content_en, content_ch) 
	VALUES(:title_en, :title_ch, :content_en, :content_ch)';
	
	
	$stmt=$conn->prepare($sql_insert);	  
	$stmt->bindParam(':title_en', $title_en, PDO::PARAM_STR);
	$stmt->bindParam(':title_ch', $title_ch, PDO::PARAM_STR);
	$stmt->bindParam(':content_en', $content_en, PDO::PARAM_STR);
	$stmt->bindParam(':content_ch', $content_ch, PDO::PARAM_STR);
	
	$stmt->execute();
	$OK=$stmt->rowCount();
	
	
	if($OK){
		$message_db="发布成功";
		//echo "db ok";
	}else{
		//echo "db no ok";
		$error=$stmt->errorInfo();
			if(isset($error[2])){
				$error=$error[2];
				//echo $error;
			}
	}	
}
*/
?>





<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>管理界面</title>
<style>
body{
	font-family:Georgia, "Times New Roman", Times, serif;
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
form{
	position:relative;
	left:40px;
	}

p{
	margin-top:30px;
	}
label{
	background-color:#CFF;
	}
.formbox{
	width:450px;}
.alert{
	font-family:"Courier New", Courier, monospace;
	font-size:14px;
	color:#F00;
	position:relative;
	left:40px;}
span{
	color:#F00;
	}
.logout{
	position:absolute;
	left:100%;
	top:20px;
	margin-left:-58px;}
.mnavic{
	position:absolute;
	left:380px;
	top:20px;
	}
.mnavic a{
	margin:10px;
	padding-left:5px;
	padding-right:5px;
	cursor:pointer;
	}
.mnavi{
	background-color:#CFF;
	border-style:outset;
	border-width:2px;
	font-family:Verdana, Geneva, sans-serif;
	font-size:12px;
	text-decoration: none;
	color:#000;
	}
.instruction{
	background-color:#FF9;
	color:#000;
	font-weight:bold;
	}
	

</style>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script type="text/javascript" src="tinymce/tinymce.min.js"></script>
<script type="text/javascript">
tinymce.init({
    selector: "textarea",
	theme: "modern",
    width: 650,
    height: 300,
    plugins: [
         "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
         "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
         "save table contextmenu directionality emoticons template paste textcolor"
    ],
    toolbar: "insertfile undo redo | fontsizeselect | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage | forecolor backcolor emoticons"
 });
</script>

<script type="text/javascript">
$(document).ready(function(){
	
	$("#submit_article").click(function(){
		
			$("form#uploadArticle").submit();
		
	});
});


function formcomplete(){
	
	
	if($.trim($('#title').val())==''){
		alert('没有标题！');
		return false;
	}
	
	return true;
}

</script>


</head>

<body>
<!--
<div class="mnavic">

<a class="mnavi" href="index.php">SUBMISSION</a><a class="mnavi" href="list.php">MANAGEMENT</a>
<a class="mnavi" href="banner.php">BANNER</a>
</div>
-->
<?php
include('navi.php');
?>
<hr />

<h1>订单</h1>

<table>
<tr>
<td>#</td>
<td>钻石（库存编号）</td>
<td>预定代理</td>
<td>总代理</td>
<td>预定时间</td>
<td>操作</td>

</tr>

<?php
if($account_level==0){	
$sql_orders='SELECT diamonds.id, stock_ref, ordered_time, real_name, account_level, given_by FROM diamonds, users WHERE diamonds.ordered_by IS NOT NULL AND diamonds.ordered_by <> "" AND order_sent IS NULL AND diamonds.ordered_by = users.user_name ORDER BY ordered_time DESC';
}else if($account_level==1){
	//$sql_orders='SELECT id, stock_ref, ordered_time FROM diamonds WHERE ordered_by IS NOT NULL AND ordered_by <> "" AND order_sent <> "YES" ORDER BY ordered_time DESC';
	//$sql_orders='SELECT id, stock_ref, ordered_time, real_name, account_level, given_by FROM diamonds, users WHERE diamonds.ordered_by IS NOT NULL AND diamonds.ordered_by <> "" AND diamonds.ordered_by = users.user_name AND order_sent <> "YES" AND (users.user_name = "'.$username.'" OR users.given_by = "'.$username.'") ORDER BY ordered_time DESC';
}


if($account_level<2){
$counter=0;
foreach($conn->query($sql_orders) as $row_order){
	$byuser=$row_order['ordered_by'];
	$counter++;
	
	foreach($conn->query('SELECT * FROM users WHERE user_name = "'.$byuser.'"') as $row_user){
	}
	
?>

<tr>
<td><?php echo $counter; ?></td>
<td><?php echo $row_order['stock_ref']; ?></td>
<td><?php echo $row_user['real_name']; ?></td>

<td>
<?php 
if($row_order['account_level']==2){
	$givenby=$row_user['given_by'];
	foreach($conn->query('SELECT real_name FORM users WHERE user_name = "'.$givenby.'"') as $row_mainagent){
		$mainagent=$row_mainagent['real_name'];
	}
	echo $mainagent;
}else{
	echo $row_user['real_name']; 
}
?>
</td>



<td><?php echo $row_order['ordered_time']; ?></td>
<td><button type="button" onclick="cancelorder(<?php echo $row_order['id']; ?>)">取消预定</button>
<button type="button" onclick="sendorder(<?php echo $row_order['id']; ?>)">发货</button>
</td>
</tr>

<?php
}
}
?>








</table>
</body>
</html>