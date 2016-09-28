<?php
$crr_page='news';
include_once('includes/header_ele.php');
?>



<style type="text/css">
#newsbtn{
	border-bottom-style:solid;
	border-width:2px;
}
img.sidevisual{
	width:360px; 
	margin: 20px 35px 185px 0; 
	float:left;
}



.main_contentbox>ul{
	padding:0;
}
li.newspiece{
	background-color: #CCCCCC;
    display: inline-block;
    height: 128px;
    list-style: none outside none;
    margin: 2px;
    padding: 0;
    position: relative;
    width: 165px;
}
a.imglinker{
	height: 128px;
    left: 0;
    overflow: hidden;
    position: absolute;
    top: 0;
    width: 165px;
}
a.txtlinker{
	background-color: rgba(255, 255, 255, 0.95);
    bottom: 0;
    color: #000000;
    font-size: 12px;
    left: 0;
    padding: 5px;
    position: absolute;
    text-decoration: none;
    width: 155px;
}
a.imglinker img{
    width: 100%;
}
</style>
<title>利美钻石 - 特惠资讯</title>
</head>

<body>



<?php
include_once('includes/header.php');
?>



<div id="bodycontent">

<?php

if(isset($_GET['p'])){
	$p=$_GET['p'];
}else{
	$p='';
}

switch($p){
	case 'all':
	$the_page='content/promotions.php';
	break;
	
	case 'article':
	$the_page='content/article.php';
	break;

	default:
	$the_page='content/promotions.php';
}



include_once($the_page);
?>

</div>




<?php
include_once('includes/footer.php');
?>

<div id="bgbox">
<div id="bginner">
<img style="width:100%;" src="../images/background_image3.jpg" />
</div>
</div>


</body>
</html>