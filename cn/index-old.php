<?php
include_once('includes/header_ele.php');
?>



<style type="text/css">
div#bodycontent{
	background-color:transparent;
}


div.sloganbox{
    position:absolute;
	width:100%;
	height:200px;
    text-align: right;
	top: 128px;
}
div.sloganboxinner{
	position:relative;
	margin:0 120px;
}
.sloganboxinner img.theslogan{
	width:450px;
	margin-right:25px;
}
img.visuallinker{
	width:108px;
	margin-right:25px;
	border:none;
}
div#bgbox2{
	position:absolute;
	top:0;
	left:0;
	width:100%;
}
div#bgbox{
	z-index:-2;
}
div#bgbox2{
	z-index:-1;
}
div#bginner2{
	position:relative;
	margin:0 120px;
	height:500px;
	background-image:url(../images/site_elements/top.png);
	background-repeat:no-repeat;
	background-position:left bottom;
}
div.empart span, div.empart em{
	font-size:10px !important;
}
</style>
<script type="text/javascript">

</script>
<title>利美钻石 - 首页</title>
</head>

<body>



<?php
include_once('includes/header.php');
?>


<div class="sloganbox">
<div class="sloganboxinner">
<img class="theslogan" src="../images/top_1.png" /><br />
<a href="diamonds.php?p=all&ref=featured" style="text-decoration:none; display:inline-block; padding-top:12px;">
<img class="visuallinker" src="../images/top_2.png" />
</a>
</div>
</div>




<div id="bodycontent">


<?php
//include_once('content/home.php');
?>



</div>




<?php
include_once('includes/footer.php');
?>


<div id="bgbox">
<div id="bginner">
<img style="width:100%;" src="../images/bottom3.jpg" />

</div>
</div>





<div id="bgbox2">
<div id="bginner2">
&nbsp;
</div>
</div>

</body>
</html>