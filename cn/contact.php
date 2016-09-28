<?php
$crr_page='contact';
include_once('includes/header_ele.php');
?>



<style type="text/css">
#navi ul li a#contactmainbtn{
	color:#FFF;
	border-bottom-style:solid;
	border-width:2px;
	border-color:#FFF;
	text-shadow: 0 0 2px #FFF;
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
.map a{
	color:#333;
	font-size:12px;
}
.main_contentbox p{
	margin:7px 0;
}
</style>
<script type="text/javascript">

</script>
<title>利美钻石 - 联系我们</title>
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
	case 'contact':
	$the_page='content/contact.php';
	break;
	
	case 'info':
	$the_page='content/contactinfo.php';
	break;
	
	case 'buyeasy':
	$the_page='content/buyeasy.php';
	break;

	default:
	$the_page='content/contactinfo.php';
}


include_once("$the_page");
?>



</div>




<?php
include_once('includes/footer.php');
?>


<div id="bgbox">
<div id="bginner">
<img style="width:100%;" src="../images/background_image7.jpg" />
</div>
</div>

</body>
</html>