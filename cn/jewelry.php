<?php
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
//$permit=true;

if(!isset($_SESSION['authenticated'])) {
  $permit=false;
}

if($_SESSION['authenticated']!='SiHui'){
	$_SESSION=array();
	if (isset($_COOKIE[session_name()])){
		setcookie(session_name(), '', time()-86400, '/');
	}
	session_destroy();
	$permit=false;
}

if($_SESSION['authenticated']=='SiHui'){
	$permit=true;
	$username=$_SESSION['username'];
	$account_level=$_SESSION['account_level'];
}




$crr_page='jewelry';
include_once('includes/header_ele.php');
?>


<link rel="stylesheet" href="../fancyBox/source/jquery.fancybox.css?v=2.1.5" type="text/css" media="screen" />
<style type="text/css">
div#bodycontent{
	min-height:350px;
}
div.main_contentbox{
	margin-left:220px;
	padding-top:20px;
}
#jewelrybtn{
	border-bottom-style: solid;
    border-width: 2px;
}
div.r_box{
	background-color: #CCCCCC;
    display: inline-block;
    height: 165px;
    list-style: none outside none;
    margin: 2px;
    padding: 0;
    position: relative;
    width: 165px;
}
a.j_linker{
	height: 165px;
    left: 0;
    overflow: hidden;
    position: absolute;
    top: 0;
    width: 165px;
}
.j_linker img{
	width:100%;
}
a.j_linker_txt{
	background-color: rgba(255, 255, 255, 0.95);
    bottom: 0;
    color: #000000;
    font-size: 12px;
    left: 0;
    padding: 5px;
    position: absolute;
    text-decoration: none;
    width: 155px;
	text-align:center;
}



h3.blocktitle{
	text-align:left;
}

div#thumbsbox{
	position:relative;
	float:left;
	width:350px;
}
div#txtvideobox{
	position:relative;
	float:left;
	margin:5px 0 0 3px;
	width:350px;
}
a.thumb{
	display:inline-block;
	width: 98px;
	height:98px;
	overflow:hidden;
	padding:0;
	margin:3px;
	border-width:3px;
	border-color:#FFF;
	border-style:solid;
	background-color:#999;
}
a.thumb img{
	width:100%;
}
span.jewelrypic{
	display:inline-block;
	position:relative;
	width:165px;
	height:145px;
	background-repeat:no-repeat;
	background-position:center center; 
	background-size: auto 165px;
}

span.thumbpicbox{
	display:inline-block;
	position:relative;
	width:98px;
	height:98px;
	background-position:center center;
	background-size: auto 98px;
}





label{
	display:inline-block;
	width:108px;
}
#contactform input{
	width:208px;
}
#cformsendbtn{
	font-size:14px; 
	font-weight:bold; 
	padding:12px 30px; 
	background-color:#CC6699;
	color:#FFF; 
	border-width:1px; 
	width:200px;
}
p.pq{
	margin:5px 0;
}
h4#feedbackmessage{
	color:#CC6699;
	font-size:20px;
}
#contactinfo{
	margin-bottom:20px;
	border-bottom-style:dotted;
	border-width:1px;
	border-color:#CC6699;
	padding-bottom:20px;
}

.subnavi_box{
	margin-left:20px;
}
ul.brands-submenu{
	font-size:16px;
	padding-left:20px;
	display:none;
}
li.submenu-cate{
	margin-bottom:10px;
	cursor:pointer;
}
.brands-submenu li{
	list-style:none;
	padding-left:15px;
	font-size:14px;
	cursor:pointer !important;
}
.brands-submenu li a{
	font-size:14px !important;
}
div#thumbsbox{
	float:none;
	width:auto;
}
</style>
<script type="text/javascript">

</script>
<title>利美钻石 - 精品首饰</title>
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
	$the_page='content/jewelry-all.php';
	break;
	
	
	case 'detail':
	$the_page='content/jewelry-detail.php';
	break;
	

	default:
	$the_page='content/jewelry-all.php';
}

if($permit){
include_once("$the_page");
}else{
?>
<div style="position:relative; height:266px;">
<a href="../_admin" style="display:inline-block; margin:50px; text-decoration:none; padding:5px 20px; background-color:#CCC; border-style:solid; border-width:1px; border-color:#999; color:#000;">请先登陆</a>
</div>
<?php
}
?>

</div>




<?php
include_once('includes/footer.php');
?>


<div id="bgbox">
<div id="bginner">
<img style="width:100%;" src="../images/background_image11.jpg" />
</div>
</div>

</body>
</html>