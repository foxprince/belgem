<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<link href="../styles/main.css?v=1395407389" media="screen" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="../fancyBox/source/jquery.fancybox.css?v=2.1.5" type="text/css" media="screen" />


<style type="text/css">
div#contentinner{
	text-align:center;
	padding:35px 0;
}
div.r_box{
	display:inline-block;
	padding:0;
	width:164px;
	height:200px;
	margin: 5px;
	position:relative;
	text-align:center;
}
a.j_linker{
	display:inline-block;
	padding:0;
	position:absolute;
	text-align:center;
	text-decoration:none;
	color:#000;
	border-style:solid;
	border-width:3px;
	border-color:#FFF;
	border-radius:100%;
	width:160px;
	height:160px;
	top:35px;
	top:0;
	left:0;
	overflow:hidden;
}
img.thumb{
	height:100%;
	position:relative;
}
a.j_linker_txt{
	position:absolute;
	top:180px;
	width:160px;
	text-decoration:none;
	color:#000;
	left:0;
}
a.j_linker:hover{	
	border-color:#F1E7A8;
}
a.j_linker_txt:hover{
	color:#999;
}
</style>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
<script type="text/javascript" src="../fancyBox/source/jquery.fancybox.pack.js?v=2.1.5"></script>

<title>LUMIA JEWELRY</title>
</head>

<body>



<?php
require_once('../includes/connection.php');
$conn=dbConnect('write','pdo');
$conn->query("SET NAMES 'utf8'");



include_once('header.php');
?>

<div id="headervisualbox" style="display:none;">
<img class="header_bg" src="../images/site_elements/header1.jpg" />
</div>

<div id="bodycontent">


<h3 class="blocktitle">利美钻石 : <a class="locationindicator" href="jewelry.php">珠宝首饰</a> : 耳环</h3>

<div id="contentinner">


<?php
$sql='SELECT * FROM jewelry WHERE category = "earring" ORDER BY id';
foreach($conn->query($sql) as $row){
?>
<div class="r_box">
<a class="j_linker" href="jewelry_detail.php?id=<?php echo $row['id']; ?>">
<img class="thumb" src="../images/sitepictures/<?php echo $row['image1']; ?>" />
</a>
<a class="j_linker_txt" href="jewelry_detail.php?id=<?php echo $row['id']; ?>">
<span class="jewlery_name">
<?php echo $row['name_ch']; ?>
</span>
</a>
</div>
<?php
}
?>


</div><!-- end contentinner -->



</div>




<?php
include_once('footer.php');
?>




</body>
</html>