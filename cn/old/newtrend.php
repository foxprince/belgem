<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link href="../styles/main.css?v=1395407389" media="screen" rel="stylesheet" type="text/css" />

<style type="text/css">
img.sidevisual{
	width:360px; 
	margin: 20px 35px 185px 0; 
	float:left;
}
.newspiece a{
	color:#000;
	text-decoration:none;
	font-size:14px;
}
.newspiece a:hover{
	color:#999;
}
li.newspiece{
	line-height:22px;
}
li.pagesbtn{
	margin-top:35px;
	list-style:none;
}
li.pagesbtn a{
	display:inline-block;
	padding:1px 3px;
	background-color:#FFC;
	color:#000;
	border-style:solid;
	border-width:1px;
	border-color:#FC3;
	border-radius:2px;
	font-size:10px;
	text-decoration:none;
}
</style>

<title>LUMIA JEWELRY</title>
</head>

<body>



<?php
include_once('header.php');
require_once('../includes/connection.php');
$conn=dbConnect('write','pdo');
$conn->query("SET NAMES 'utf8'");

$sql_count='SELECT COUNT(*) AS num_articles FROM usefulinfo WHERE category = "industry"';
foreach($conn->query($sql_count) as $number){
	$articleCount=$number['num_articles'];
}

$totalpages=ceil($articleCount/25);

if(isset($_GET['p'])){
	$crr_page=$_GET['p'];
	if($crr_page>$totalpages){
		$crr_page=$totalpages;
	}
}else{
	$crr_page=1;
}

$startnumber=($crr_page-1)*25;


$sql='SELECT * FROM usefulinfo WHERE category = "industry" ORDER BY id DESC LIMIT '.$startnumber.',25';
$stmt=$conn->query($sql);


$sql_element='SELECT industryimage FROM settings';
foreach($conn->query($sql_element) as $pic){}
?>



<div id="bodycontent">

<h3 class="blocktitle">利美钻石 : 产业新闻</h3>


<img class="sidevisual" src="<?php echo $pic['industryimage']; ?>" />
<div style="position:relative; float:left; width:500px; margin-left:30px;">
<ul>
<?php
foreach($stmt as $row){
?>
<li class="newspiece">
<a href="article.php?id=<?php echo $row['id']; ?>">
<?php echo $row['title_ch']; ?>
</a>
</li>
<?php
}
?>


<li class="pagesbtn">
<?php
if(isset($totalpages) && $totalpages>1){
	
	for($i=1; $i<=$totalpages; $i++){
	?>
	<a class="articlepagelinker" href="newtrend.php?p=<?php echo $i; ?>"><?php echo $i; ?></a>
	<?php
	}
	
}
?>
</li>

</ul>
</div>
  
  <br style="clear:both" />
</div>




<?php
include_once('footer.php');
?>




</body>
</html>