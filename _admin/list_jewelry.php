<?php
/*===================session========================*/
session_start();

require_once ('../cn/includes/header_ele.php');


require_once('../includes/connection.php');
$conn=dbConnect('write','pdo');
$conn->query("SET NAMES 'utf8'");




?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>珠宝首饰目录</title>
<style type="text/css">
td{
	background:#FFF9FF;
	border-bottom-style:dotted;
	border-width:1px;
	border-color:#CC6699;
	padding:3px;
}
.filterbtn{
	display:inline-block;
}
a.modifybtn{
	display:inline-block;
	text-decoration:none;
	color:#FFF;
	padding:1px 8px;
	background-color:#CC6699;
	border-radius:4px;
}
a.modifybtn:hover{
	color:#000;
}
</style>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script type="text/javascript">
function delete_j($id){
	var r=confirm("Are you sure to delete this submission ?");
	if(r){
		$("#indi").fadeIn('fast');
		$.post(         
			"deletejewelry.php", 
			{id: $id}, 
			function(data){
				//if the returned data indicates ok, then do the actions
				if(data=="ok"){
					alert("删除成功!");
					var Idtodelete="tr#record"+$id;
					$(Idtodelete).remove();
					$("#indi").fadeOut('fast');
				}else{
					alert(data);
					$("#indi").fadeOut('fast');
				}
			}
		);
	}
}
</script>
</head>

<body>


<?php
include('navi.php');
?>
<hr />

<h3>珠宝首饰管理页面</h3>


<p>
<a href="new_jewelry.php" style="display:inline-block; padding:8px 35px; border-style:outset; border-width:1px; background-color:#CC6699; color: #FFF; text-decoration:none; border-radius:6px;">＋添加新首饰</a>
</p>



<?php
$sql="SELECT * FROM jewelry ORDER BY id DESC";
$ooh=$conn->query($sql);
?>
<table>

<tr>
<td width="90" align="center" style="font-size:14px; background-color:#CC6699; color:#FFF;">类别</td>
<td width="220" align="center" style="font-size:14px; background-color:#CC6699; color:#FFF;">名称</td>
<td width="390" align="center" style="font-size:14px; background-color:#CC6699; color:#FFF;">图片</td>
<td width="160" colspan="2" align="center" style="font-size:14px; background-color:#CC6699; color:#FFF;">操作</td>
</tr>
<?php
foreach($ooh as $row){
?>
<tr id="record<?php echo $row['id']; ?>">
<td align="center"><?php echo $row['category']; ?></td>
<td align="center"><?php echo $row['name_en']; ?><br /><?php echo $row['name_ch']; ?></td>
<td align="center">
<?php
if($row['image1']!=NULL && $row['image1']!='' && $row['image1']!="NO"){
?>
<img src="../images/sitepictures/<?php echo $row['image1']; ?>" height="58" />	
<?php
}
if($row['image2']!=NULL && $row['image2']!='' && $row['image2']!="NO"){
?>
<img src="../images/sitepictures/<?php echo $row['image2']; ?>" height="58" />	
<?php
}

if($row['image3']!=NULL && $row['image3']!='' && $row['image3']!="NO"){
?>
<img src="../images/sitepictures/<?php echo $row['image3']; ?>" height="58" />	
<?php
}
?>

</td>

<td align="center"><a class="modifybtn" href="<?php echo 'jewelry_edit.php?id='.$row['id']; ?>">修改</a></td>
<td align="center">
<!--
<a href="<?php echo 'jewelry_delete.php?id='.$row['id']; ?>"></a>
-->
<button type="button" onclick="delete_j('<?php echo $row['id']; ?>')">删除</button>
</td>
</tr>
<?php
}
?>

</table>

<p id="indi" style="position:fixed; top:50px; left:50px; width:150px; text-align:center; padding: 12px 30px; border-style:solid; border-width:3px; border-color:#000; background-color:#FF9; font-size:24px; font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif; display:none;"> Saving ... </p>
<p style="height:50px;">&nbsp;</p>
</body>
</html>