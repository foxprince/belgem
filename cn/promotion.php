<?php
include_once('includes/header_ele.php');
?>



<style type="text/css">

</style>
<script type="text/javascript">

</script>
<title>利美钻石 - 特惠信息</title>
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
	case 'diamond':
	$the_page='content/promotion-diamond.php';
	break;
	
	case 'jewelry':
	$the_page='content/promotion-jewelry.php';
	break;

	default:
	$the_page='content/promotion-all.php';
}


include_once("$the_page");
?>



</div>




<?php
include_once('includes/footer.php');
?>


<div id="bgbox">
<div id="bginner">
<img style="width:100%;" src="../images/sitepictures/v006.JPG" />
</div>
</div>

</body>
</html>