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
div#visual-side-box{
	position:relative;
	width:980px;
	margin:0 auto;
}
img#visual-side{
	float:right;
	margin-left:120px;
}
</style>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
<script type="text/javascript" src="../fancyBox/source/jquery.fancybox.pack.js?v=2.1.5"></script>
<script type="text/javascript">

</script>
<title>LUMIA JEWELRY</title>
</head>

<body>



<?php
if(!isset($_GET['id'])){exit('error: id required');}

$id=$_GET['id'];

require_once('../includes/connection.php');
$conn=dbConnect('write','pdo');
$conn->query("SET NAMES 'utf8'");


$sql='SELECT * FROM usefulinfo WHERE id = "'.$id.'"';
foreach($conn->query($sql) as $row){}
?>

<?php

include_once('header.php');


if($row['category']=='news'){
	$cate='最新消息';
}else if($row['category']=='industry'){
	$cate='产业新闻';	
}else if($row['category']=='knowledge'){
	$cate='钻石知识';
	
}
?>



<div id="visual-side-box">
<img id="visual-side" src="../images/site_elements/visualside.jpg" />
</div>

<div id="bodycontent">

<h3 class="blocktitle">利美钻石 : <?php echo $cate; ?></h3>

<h3 id="articletitle"><?php echo $row['title_ch']; ?></h3>


<div id="txt_box" style="margin-top:12px;">
<?php echo $row['text_ch']; ?>
</div>




</div>







<?php
include_once('footer.php');
?>

<div id="bgbox">
<div id="bginner">
<img style="width:100%;" src="../images/sitepictures/v006.JPG" />
</div>
</div>


</body>
</html>