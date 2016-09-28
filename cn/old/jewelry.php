<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link href="../styles/main.css?v=1395407389" media="screen" rel="stylesheet" type="text/css" />

<style type="text/css">
a.b{
	display:inline-block;
	padding:0;
	margin: 10px 10px;
	text-align:center;
	text-decoration:none;
	color:#000;
	border-style:solid;
	border-width:3px;
	border-color:#FFF;
	border-radius:100%;
	width:210px;
	height:210px;
	top:35px;
}
a.b img{
	position:relative;
	top:25px;
}
span.dtitle{
	position:relative;
	display:inline-block;
	top:25px;
}
a.b:hover{	
	border-color:#F1E7A8;
}
a.b img{
	width:180px;
	height:180px;
	border:none;
	margin-bottom:20px;
}
</style>
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


<h3 class="blocktitle">利美钻石 : 珠宝首饰</h3>


<div style="padding:50px 0; text-align:center">
<a class="b" href="ring.php">
<img src="../images/site_elements/ring.png" /><br />
<span class="dtitle">戒指</span>
</a>
<a class="b" href="bracelet.php">
<img src="../images/site_elements/bracelet.png" /><br />
<span class="dtitle">手链</span>
</a>
<a class="b" href="necklace.php">
<img src="../images/site_elements/necklace.png" /><br />
<span class="dtitle">项链</span>
</a>
<a class="b" href="earring.php">
<img src="../images/site_elements/earrings.png" /><br />
<span class="dtitle">耳环</span>
</a>
</div>


</div>




<?php
include_once('footer.php');
?>




</body>
</html>