<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link href="../styles/main.css?v=1395407389" media="screen" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="../fancyBox/source/jquery.fancybox.css?v=2.1.5" type="text/css" media="screen" />

<style type="text/css">
body{
	margin:0;
	border:0;
}
#bodycontent{
	display:block;
	position:relative;
}
#img_show_box{
	position:relative;
	width:458px;
	top:35px;
	left:0;
}

#thumbsbox{
	position:relative;
	width:438px;
	padding:12px 5px;
	background-color:#FFE0F0;
	border-radius:8px;
	text-align:center;
	margin-bottom:50px;
}
div.thumbbox{
	position:relative;
	font-size:0;
	width:118px;
	height:118px;
	margin:8px;
	display:inline-block;
}
#thumbsbox a{
	text-decoration:none;
	position:absolute;
	font-size:0;
	width:118px;
	height:118px;
	margin:0;
	border-style:solid;
	border-color:#FFF;
	border-width:2px;
	text-align:center;
	overflow:hidden;
	top:0;
	left:0;
}
#thumbsbox img{
	height:100%;
}

#txtvideobox{
	position:absolute;
	margin-left:470px;
	top:12px;
}
</style>


<title>LUMIA JEWELRY</title>
</head>

<body>



<?php
if(!isset($_GET['id'])){exit('error: id required');}

$id=$_GET['id'];

require_once('../includes/connection.php');
$conn=dbConnect('write','pdo');
$conn->query("SET NAMES 'utf8'");


$sql='SELECT * FROM jewelry WHERE id = "'.$id.'"';
foreach($conn->query($sql) as $row){}
?>

<?php

include_once('header.php');


if($row['category']=='ring'){
	$cate='Ring';
	$cate_linker='ring.php';
}else if($row['category']=='necklace'){
	$cate='Necklace';
	$cate_linker='necklace.php';
}else if($row['category']=='earring'){
	$cate='Earring';
	$cate_linker='earring.php';
}else if($row['category']=='bracelet'){
	$cate='Bracelet';
	$cate_linker='bracelet.php';
}
?>

<div id="headervisualbox" style="display:none;">
<img class="header_bg" src="../images/site_elements/header1.jpg" />
</div>

<div id="bodycontent">

<h3 class="blocktitle">利美钻石 : <a class="locationindicator" href="jewelry.php">珠宝首饰</a> : <a class="locationindicator" href="<?php echo $cate_linker; ?>"><?php echo $cate; ?></a> : <?php echo $row['name_ch']; ?></h3>





<div id="txt_box" style="margin-top:12px;">
<?php echo $row['text_ch']; ?>
</div>


<div id="img_show_box">


<div id="thumbsbox">

<div class="thumbbox">
<a class="thumb" href="../images/sitepictures/<?php echo $row['image1']; ?>" rel="pics">
<img id="thumb1" src="../images/sitepictures/<?php echo $row['image1']; ?>" />
</a>
</div>
<?php
if($row['image2']!=NULL && $row['image2']!=''){
?>
<div class="thumbbox">
<a class="thumb" href="../images/sitepictures/<?php echo $row['image2']; ?>" rel="pics">
<img id="thumb2" src="../images/sitepictures/<?php echo $row['image2']; ?>" />
</a>
</div>
<?php
}
?>
<?php
if($row['image3']!=NULL && $row['image3']!=''){
?>
<div class="thumbbox">
<a class="thumb" href="../images/sitepictures/<?php echo $row['image3']; ?>" rel="pics">
<img id="thumb3" src="../images/sitepictures/<?php echo $row['image3']; ?>" />
</a>
</div>
<?php
}
?>
<?php
if($row['image4']!=NULL && $row['image4']!=''){
?>
<div class="thumbbox">
<a class="thumb" href="../images/sitepictures/<?php echo $row['image4']; ?>" rel="pics">
<img id="thumb4" src="../images/sitepictures/<?php echo $row['image4']; ?>" />
</a>
</div>
<?php
}
?>
<?php
if($row['image5']!=NULL && $row['image5']!=''){
?>
<div class="thumbbox">
<a class="thumb" href="../images/sitepictures/<?php echo $row['image5']; ?>" rel="pics">
<img id="thumb5" src="../images/sitepictures/<?php echo $row['image5']; ?>" />
</a>
</div>
<?php
}
?>
<?php
if($row['image6']!=NULL && $row['image6']!=''){
?>
<div class="thumbbox">
<a class="thumb" href="../images/sitepictures/<?php echo $row['image6']; ?>" rel="pics">
<img id="thumb6" src="../images/sitepictures/<?php echo $row['image6']; ?>" />
</a>
</div>
<?php
}
?>
<?php
if($row['image7']!=NULL && $row['image7']!=''){
?>
<div class="thumbbox">
<a class="thumb" href="../images/sitepictures/<?php echo $row['image7']; ?>" rel="pics">
<img id="thumb7" src="../images/sitepictures/<?php echo $row['image7']; ?>" />
</a>
</div>
<?php
}
?>
<?php
if($row['image8']!=NULL && $row['image8']!=''){
?>
<div class="thumbbox">
<a class="thumb" href="../images/sitepictures/<?php echo $row['image8']; ?>" rel="pics">
<img id="thumb8" src="../images/sitepictures/<?php echo $row['image8']; ?>" />
</a>
</div>
<?php
}
?>



<div id="txtvideobox">
<?php echo $row['videolink']; ?>
</div>
</div>

</div>








</div>







<?php
include_once('footer.php');
?>

<script type="text/javascript" src="../fancyBox/source/jquery.fancybox.pack.js?v=2.1.5"></script>
<script type="text/javascript">
$("a.thumb").fancybox({
	beforeLoad: function(){
					$('iframe').css('visibility',"hidden");
				},
	afterClose: function(){
					$('iframe').css('visibility',"visible");
				}
});
</script>


</body>
</html>