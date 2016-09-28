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
     exit();
}

// if session variable not set, redirect to login page
if(!isset($_SESSION['authenticated'])) {
  header('Location: login.php');
  exit();
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
if($account_level>=2){
	exit('no permit');
}

if(!isset($_GET['id'])){
	exit('no user defined to edit');
}

$theid=$_GET['id'];

require_once('../includes/connection.php');
$conn=dbConnect('write','pdo');
$conn->query("SET NAMES 'utf8'");



if(isset($_POST['user_name']) && isset($_POST['pass_word'])){
	$real_name=$_POST['real_name'];
	$user_name=$_POST['user_name'];
	$pass_word=$_POST['pass_word'];
	$account_level_db=$_POST['account_level'];
	//$given_by=$_POST['given_by'];
	$more_info=$_POST['more_info'];
	
	$sql_check='SELECT * FROM users WHERE id <> '.$theid.' AND user_name = "'.$user_name.'"';
	$stmt_check=$conn->query($sql_check);
	$found=$stmt_check->rowCount();
	if($found){
		$existinguser=true;
	}else{
		$existinguser=false;
	}
	
	if(!$existinguser){
		$sql_renew='UPDATE users SET user_name = ?, pass_word = ?, real_name = ?, more_info = ?, account_level = ? WHERE id = ?';
		$stmt=$conn->prepare($sql_renew);	  
		
	
		$stmt->execute(array($user_name, $pass_word, $real_name, $more_info, $account_level_db, $theid));
		$updateOK=$stmt->rowCount();
	}
}

?>





<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>管理界面</title>
<style>
body{
	font-family:'Microsoft Yahei', 微软雅黑, STHeiti, simsun, Arial, sans-serif;
	font-size:14px;
	font-weight:100;
	}
h3.listtitle{
	padding:5px 20px;
	margin:20px;
	border-bottom-style:solid;
	border-width:1px;
	border-color:#CCC;
	font-size:32px;
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
	}

p{
	margin-top:30px;
	}
label{
	background-color:#CFF;
	display:inline-block;
	width:88px;
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
div.newuser{
	display:block;
	position:relative;
	width:380px;
	padding:20px;
	background-color:#CCC;
	border-style:solid;
	border-color:#03F;
	border-radius:8px;
	border-width:1px;
	margin-left:50px;
}	
div.userbox{
	position:relative;
	width: 250px;
	padding:15px;
	margin:8px;
	border-style:solid;
	border-width:1px;
	border-color:#999;
	display:inline-block;
	height:380px;
	float:left;
	overflow-y:auto;
}
.leveltitle{
	margin:0;
	font-size:18px;
	color:#99C;
}
div.level2user{
	background-color:#F5F5F5;
	padding:12px;
	margin-top:8px;
}
.leveltitlesub{
	margin:3px 0 3px 0;
	position:relative;
	left:-10px;
	top:-10px;
	font-size:16px;
}
.userbox p{
	margin: 3px 0;
}
.tipsbox{
	padding:5px;
	border-style:solid;
	border-width:1px;
	border-color:#CCC;
}
.l2realname{
	display:inline-block;
	padding:2px;
	margin:3px;
	background-color:#FFF;
}
p.realname{
	margin-top:0;
	font-size:26px;
}

h3.createtitle{
	font-size:20px;
	margin-top:0;
}

a.edituserbtn{
	display:inline-block;
	position:absolute;
	top:3px;
	right:3px;
	border-style:solid;
	border-width:1px;
	border-color:#09F;
	text-decoration:none;
	color:#666;
	font-size:12px;
	background-color:#CFF;
	padding:1px 5px;
}
a.edituserbtn:hover{
	background-color:#CCC;
}
</style>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>

<script type="text/javascript">

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

<?php
include('navi.php');
?>
<hr />

<h1 style="font-size:34px; color:#06F; margin:25px 0 25px 12px;">用户管理界面</h1>

<div class="newuser">
<h3 class="createtitle">
编辑代理账户
</h3>

<?php
if(isset($updateOK) && $updateOK){
?>
<h2 style="color:#F00;">用户修改成功。</h2>
<?php
}else if(isset($existinguser) && $existinguser){
?>
<h2 style="color:#F00;">用户修改失败：<br />用户名‘<?php echo $user_name; ?>’已被占用</h2>
<?php
}

$sql_search='SELECT * FROM users WHERE id = '.$theid;
$stmt_search=$conn->query($sql_search);
foreach($stmt_search as $row){}
?>

<form action="" method="post">
<label>实名：</label> <input name="real_name" type="text" value="<?php echo htmlentities($row['real_name'], ENT_COMPAT, 'UTF-8') ?>" /><br />
<label>用户名：</label> <input name="user_name" type="text" value="<?php echo htmlentities($row['user_name'], ENT_COMPAT, 'UTF-8') ?>" /> 英文字母、数字组合<br />
<label>密码：</label> <input name="pass_word" type="text" value="<?php echo htmlentities($row['pass_word'], ENT_COMPAT, 'UTF-8') ?>" /> 英文字母、数字组合<br />
<?php
if($account_level==0){
?>


<label>代理级别：</label>
<select name="account_level">
<option value="1"<?php if($row['account_level']==1){echo ' selected="selected"';} ?>>一级代理</option>
<option value="2"<?php if($row['account_level']==2){echo ' selected="selected"';} ?>>二级代理（下属代理）</option>
<option value="8"<?php if($row['account_level']==8){echo ' selected="selected"';} ?>>独立代理</option>
</select>

<br />

<?php
}else{
?>
<input type="hidden" name="account_level" value="2" />

<?php
}
?>
<p style="margin-top:0;">
<label style="display:inline-block; float:left;">备注信息：</label>
<textarea name="more_info" style="width:260px; height:70px; display:inline-block; float:left; margin-left:5px;"><?php echo $row['more_info']; ?></textarea>
<br style="clear:both;" />
</p>

<p style="text-align:right; padding-right:20px; margin:0;">
<input type="submit" name="tianjia" style="background-color:#06F; padding:3px 20px; font-size:18px; color:#FFF; border-style:solid; border-width:1px; cursor:pointer;" value="保存" />
</p>
</form>

</div>



</body>
</html>