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


require_once('../includes/connection.php');
$conn=dbConnect('write','pdo');
$conn->query("SET NAMES 'utf8'");




?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>利美-客户信息管理</title>
<style type="text/css">
td{
	background:#EFF;
	padding:5px;
}
.filterbtn{
	display:inline-block;
}
</style>
<script src="http://sigway.be/lab/jquery-1.11.2.min.js"></script>
<script type="text/javascript">
function deleteNEWS($id){
	var theid=$id;
	var r=confirm("确定删除该条新闻记录?");
	if(r){
		$.post(         
			"delete_news.php", 
			{id: $id}, 
			function(data){
				if(data=="ok"){
					alert("该记录已经成功删除。")
					$('tr#r_'+theid).remove();
					//window.location.reload(true);
				}else{
					alert(data);					
				}
			}
		);
	}else{
		//window.location.reload(true);
	}
}

</script>
</head>

<body>


<?php
include('navi.php');
?>
<hr />

<h3>微信客户管理：</h3>





<?php
$sql="SELECT * FROM clients_list ORDER BY id DESC";
$ooh=$conn->query($sql);
?>
<table>
<tr>
<td colspan="4" style="background-color:#FFF;">
微信客户列表：
</td>
</tr>
<tr>
<td width="108" align="center" style="font-size:14px; background-color:#6CF">微信名</td>
<td width="108" align="center" style="font-size:14px; background-color:#6CF">实名</td>
<td width="100" align="center" style="font-size:14px; background-color:#6CF">注册时间</td>
<td width="100" align="center" style="font-size:14px; background-color:#6CF">账户状态</td>
<td width="258" align="center" style="font-size:14px; background-color:#6CF">行为记录</td>
</tr>
<?php
foreach($ooh as $row){
?>
<tr id="<?php echo $row['wechat_open_id']; ?>">
<td class="wechatname"><?php echo $row['wechat_name']; ?></td>
<td class="realname"><?php echo $row['name']; ?></td>
<td align="center"><?php echo $row['subscribed_time']; ?></td>
<td align="center"><?php echo $row['suscribe_status']; ?></td>
<td align="center">
<?php
$sql_history='SELECT COUNT(*) AS num FROM wechat_record WHERE wechat_open_id = "'.$row['wechat_open_id'].'"';
foreach($conn->query($sql_history) as $row_history){
	$num=$row_history['num'];
}
if($num>0){
?>
该用户发送过<?php echo $num; ?>条信息。

<a href="clientrecords.php?user=<?php echo $row['wechat_open_id']; ?>">历史记录</a>

<?php
}else{
?>

该用户没有历史记录。

<?php
}
?>
</td>
</tr>
<?php
}
?>

</table>


<p style="height:50px;">&nbsp;</p>
</body>
</html>