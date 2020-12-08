<?php
session_start();

$crr_page='diamonds';
include_once('includes/header_ele.php');
?>


<style type="text/css">
div#bodycontent{
	padding-top:20px;
}
#navi ul li a#diamondsbtn{
	color:#FFF;
	border-bottom-style:solid;
	border-width:2px;
	border-color:#FFF;
	text-shadow: 0 0 2px #FFF;
}

div#tableheader, div#diamondsdata{
	position:relative;
	margin-left:35px;
}

.btn_selected {
	font-size: 18px;
    color: #FFF;
    background-color: #960;
    margin: 1px 15px;
    padding: 3px 12px;
    border-width: 1px;
}
#filter_box{
	margin-bottom:5px;
	padding-bottom:25px;
	position:relative;
	z-index:5;
	margin-top:0;
	margin-left:35px;
	height:218px;
}
div#filter_box_inner{
	position:relative;
	background-color:#FFF;
	border-style:solid;
	border-width:5px;
	border-color:#FFF;
	box-shadow: 0 0 3px rgba(128,128,128,.5);
	margin-right:38px;
	border-radius:8px;
	overflow:hidden;
}
#filter_line_clarity ul{
	white-space:nowrap;
}
#filter_line_color ul{
	white-space:nowrap;
}
p#listdescription{
	margin:0 0 5px 0;
	font-size:12px;
}
span#resulthowmany{
	font-size:16px;
	font-weight:bold;
}



p#listdescription{
	position:relative;
}
span#dia-page-selector{
	position:absolute;
	right:80px;
	top:1px;
}
span.dia-page-btn{
	display:inline-block;
	margin:0 1px;
	font-size:12px;
	cursor:pointer;
	padding: 1px 2px;
}
span#crr_page{
	font-size:14px;
	border-style:solid;
	border-width:1px;
	border-color:#999;
}


/* for table */
tr{
}
td{
	padding:5px 3px;
	border-width:1px;
	font-size:12px;
	overflow:hidden;
}
tr:hover{
	background-color:#FFF;
}
td.ref_number{
	font-size:10px;
	border-left-style:solid;
	border-width:1px;
}
td.detail_1stcol{
	border-left-style:solid;
	border-right-style:solid;
	border-width:1px;
}

td.value_symmetry{
	white-space:nowrap;
	overflow:hidden;
}
span.valuetxt{
	display:inline-block;
	overflow:hidden;
	padding:0;
	margin:0;
}
td.seedetail{
	cursor:pointer;
	color:#06F;
	font-size:14px;
	border-right-style:solid;
}
tr.details{
	display:none;
}
.t_h td{
	color: #333;
	width: 36px;
	font-weight:bold;
	border-right-style:solid;
	border-width:1px;
	border-right-color:#999;
}
.valueline td{
	width:58px;
	border-style:solid;
	border-width:1px;
	border-color:#FFF;
	border-bottom-color:#EEE;
	background-color:#FFF;;
}
.details td{
	vertical-align:top;
	text-align:left;
	background-color:#FFF;
}
.detailsbox td{
	border-style:solid;
	border-top:none;
	border-bottom:none;
	border-width:1px;
	border-color:#3CF;
	padding:0;
}
img.iconarrow{
	position:relative;
	left:-3px;
}

p.details_txt{
	padding:3px 20px;
	margin:0;
	text-align:center;
}
p.details_txt2{
	padding-left:8px;
}
div.detailboxtop{
	clear:both;
}
div.detailboxleft{
	float:left;
	width:300px;
	margin-right:15px;
}
div.detailboxright{
	float:left;
	width:360px;
}
p.commentbox, p.stars{
	padding-left:20px;
	margin:5px 0;
}

div.picbox{
	display:inline-block;
	width:138px;
	height:138px;
	padding:3px;
	border-style:solid;
	border-width:1px;
	border-color:#CC6699;
	margin:0 0 3px 0;
}
div.picbox img{
	position:relative;
	width:138px;
	height:138px;
}
button.sortbtn{
	border:none; 
	background-color:#06F;
	font-size:12px; 
	color:#FFF; 
	cursor:pointer;
	margin:0;
	padding:0;
}

div.imagescontainer{
	padding:0;
}

div.thumbsbox{
	position:relative;
	padding:10px 12px;
	border-radius:6px;
	margin-top:15px;
	background-color:#F8F5EB;
	text-align:left;
	margin-left:20px;
	margin-bottom:20px;
}
a.thumbbox{
	display:inline-block;
	font-size:0;
	width:70px;
	height:70px;
	overflow:hidden;
	padding:0px;
	border-width:3px;
	border-style:solid;
	border-color:#993300;
	margin:3px;
	border-radius:4px;
	text-align:center;
	cursor:pointer;
}
.thumbbox img{
	height:100%;
}


div.videobox{
	padding-top:15px;
	padding-left:5px;
}
div.videobox iframe{
	overflow:hidden;
}


p#filtertab{
	position:absolute;
	top:-23px;
	right:20px;
	font-size:28px;
	font-weight:bold;
	color:#FFF;
	text-shadow:0 1px 0px #C0C0C0;
}
#filter_box ul{
	margin-left:0px;
	padding-left:55px;
}

div.filter_line{
	background-color:#e3dac5;
	position:relative;
	font-size:12px;
	margin-bottom:1px;
	padding: 3px 0;
}
div.filter_line_inner{
	display:inline-block;
	padding-right:15px;
	border-width: 1px;
	border-right-style:solid;
	border-color:#FFF;
	position:relative;	
}

div#filter_line_clarity, div#filter_line_color, div#filter_line_symm, div#filter_line_polish, div#filter_line_cut{
	width:auto;
}
div#filter_line_price, div#filter_line_weight{
	padding: 0px 0 0px 85px;
}
div#filter_line_price input, div#filter_line_weight input{
	width:55px;
}
div#filter_line_price button, div#filter_line_weight button{
	display:inline-block;
	border-radius:6px;
	cursor:pointer;
	padding:3px 8px;
	margin:0px 0 0px 15px;
	background-color:#FFF;
	border:none;
}

div.filter_line ul{
	margin:0 0 0 45px;
}
ul.fileber_shape_outer{
	margin-left:45px;
}
.filter_line li{
	list-style:none;
	display:inline-block;
	border-radius:5px;
	cursor:pointer;
	padding:2px 3px;
	margin:5px 0;
	background-color:#FFF;
	white-space:nowrap;
}
.filter_line li:hover{
	background-color:#bba983;
}
span.filter_title{
	position:absolute;
	top:0;
	left:12px;
	font-size:12px;
}
span#filter_title_shape{
	top:9px;
	left:12px;
}
li.filter_shape{
	text-align:center;
	width:25px;
	margin-right: 3px;
	height:25px;
	background-color:#FFF;
	padding:2px;
	font-size:12px;
	text-align:center;
}
li.filter_color{
	text-align:center;
}
li.filter_clarity{
}
.filter_shape img{
	width:25px;
}
li.chosen{
	background-color:#dccaaa;
}
li.chosen:hover{
	background-color:#dccaaa;
}
button#updateBTN{
	position:absolute;
	right:10px;
	bottom:0;
	background-color:#9f6a0e;
	color:#FFF;
	font-size:18px;
	border-width:1px;
	border-style:solid;
	padding:5px 12px;
}

div.videobox{
	position:relative;
}
p.loadingvideo_indi{
	position:absolute;
	top:12px;
	left:20px;
	z-index:-1;
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

a.certi_linker{
	color:#000;
}
span.ratingicon{
	display:inline-block;
	position:relative;
	top:2px;
}
div.videobox_clean{
	position:relative;
}
a.openupvideo{
	display:inline-block;
	position:absolute;
	width:25px;
	height:25px;
	top:10px;
	right:10px;
	z-index:58;
}

span#more{
	position:absolute;
	top:5px;
	right:20px;
	cursor:pointer;
}


table{
	font-family:Arial, Helvetica, sans-serif;
}


div#wechatscanbox{
	position:fixed;
	width:100%;
	height:100%;
	left:0;
	top:0;
	background-color:#FFF;
	background-color:rgba(255,255,255,0.78);
	display:none;
	z-index:8;
}
div#wechatscanboxinner{
	position:relative;
	width:208px;
	padding:35px;
	border-style:solid;
	border-width:1px;
	border-color:#993300;
	border-radius:6px;
	margin:180px auto 0 auto;
	background-color:#FFF;
}
#wechatscanboxinner p{
	text-align:center;
}
span#wechatscanboxclosebtn{
	display:inline-block;
	position:absolute;
	top:-50px;
	right:-50px;
	font-family:'Helvetica neue', Arial, Helvetica, sans-serif;
	font-weight:100;
	padding:3px 8px;
	border-style:solid;
	border-width:1px;
	border-color:#993300;
	background-color:#FFF;
	cursor:pointer;
}

span.an_order{
	display:inline-block;
	font-size:11px;
	padding:1px 3px;
	border-style:solid;
	border-width:1px;
	border-color:#0CF;
	margin:1px;
}


button.gotopagebtn{
	display:inline-block;
	padding:1px 3px;
	border-style:solid;
	border-width:1px;
	border-color:#CCC;
	background-color:#FFF;
	font-size:12px;
	margin:0;
	cursor:pointer;
}
button.crr-dia-p{
	background-color:rgb(233, 227, 207);
}
button.pre-pages-btn{
	margin-right:20px;
}
button.next-pages-btn{
	margin-left:20px;
}


.ui-state-default, .ui-widget-content .ui-state-default, .ui-widget-header .ui-state-default{
	background-color:#C90;
	background-image:none;
	border-color:#960;
}

li.btn-active{
	background-color:#ffc008;
}

tr.searchresult td{
	background-color:#FFC;
}
</style>
<script type="text/javascript">
$(document).ready(function(){
	$('div#wechatscanbox').click(function(){closeWechatbox();});
});
function openwechatimage(){
	$('div#wechatscanbox').fadeIn('fast');
}
function closeWechatbox(){
	$('div#wechatscanbox').fadeOut('fast');
}
function hide(){
    $("#order_basket").fadeOut('slow');$("#orderBtn").attr("onclick","showOrder()");
    $("#orderBtn").text('显示购物车');
}
function showOrder(){
    $("#order_basket").fadeIn('slow');$("#orderBtn").text('隐藏购物车');$("#orderBtn").attr("onclick","hide()");
}
</script>
<title>精品钻石</title>
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
	$the_page='content/diamonds-all.php';
	break;
		
	case 'color':
	$the_page='content/diamonds-color.php';
	break;
	
	case 'steps':
	$the_page='content/steps.php';
	break;
	
	case 'contact':
	$the_page='content/contact.php';
	break;
	
	case 'buyeasy':
	$the_page='content/buyeasy.php';
	break;
	
	default:
	$the_page='content/diamonds-all.php';
}
include_once("$the_page");
?>



<div id="wechatscanbox">
<div id="wechatscanboxinner">
<span id="wechatscanboxclosebtn" onClick="closeWechatbox()">X</span>
<p>请加微信询问价格</p>
<p><img style="width:128px;" src="../images/site_elements/wechat_scan.jpg"></p>
</div>
</div>
</div>

<?php
include_once('includes/footer.php');
?>


<?php
if($permit){
?>
<div id="order_basket" style="position:fixed; top:168px; right:28px; width:30%; height:200px; background-color:#e3dac5; border-style:solid; border-width:3px; box-shadow:0 0 3px #666; border-color:#960; padding:10px; overflow:auto; z-index:8;">
购物车(已选钻石):
<div id="theorders" style="position:relative; background-color:#FFF; min-height:20px; margin:5px 0">

</div>
		<div id="appointment" style="display:none;position:relative; background-color:#FFF; min-height:20px; margin:5px 0">
			<p>客户：<input type="text" id="customer"name="customer"/>
			<select class="customerSel" name="customerSel">
				<option value="">--请选择--</option>
				<?php 
				foreach($conn->query('select distinct customer as customer from diamonds where customer is not null') as $num){
					$result_number=$num['customer'];?>
					<option value="<?php echo $result_number;?>"><?php echo $result_number;?></option>
				<?php }
				?>
			</select>
			</p>
			<p>预约时间：
			<input type="text" id="appointmentTime"name="appointmentTime" value="yyyy-mm-dd hh:mi"/></p>
		</div>

<button id="makeorderbtn" onClick="confirmorder()" style="font-size:18px; color:#FFF; background-color:#960; padding:3px 12px; border-width:1px;">预定</button>
<button id="makeAppointmentBtn" onClick="appointment()" style="font-size:18px; color:#FFF; background-color:#290; padding:3px 12px; border-width:1px;">预约</button>
<button id="hiddenButton" onclick="hide()">隐藏</button> 
<div id="alreadyorderedbox" style="position:relative; margin-top:5px; border-top-style:solid; border-width:1px; border-color:#06F; padding-top:8px;">
已经预定:<br>
<div id="alreadyordered">
<?php
//if($username!='super001'){
$sql_orders='SELECT stock_ref FROM diamonds WHERE ordered_by = "'.$username.'" AND order_sent IS NULL';
//$sql_orders='SELECT stock_ref FROM diamonds WHERE ordered_by = "'.$username.'"';
foreach($conn->query($sql_orders) as $row_order){
?>
<span class="an_order2" id="ordered_<?php echo $row_order['stock_ref']; ?>"><?php echo $row_order['stock_ref']; ?></span>
<?php
}
/*
}else{
	echo '超级管理员不能预定自己的产品';
}
*/
?>
</div><!-- end alreadyordered  -->


</div><!-- end alreadyorderedbox  -->
<div><button id="hiddenButton" onclick="hide()">隐藏</button> ｜ 
<?php if($_SESSION['username']=='superadmin'){ ?>
<button class="next-pages-btn" onclick="deleteK()">删除K字头</button>
<?php }?>
</div>
</div>

<?php
}
?>

<a href="../_admin" style="position:fixed; top:5px; right:8px; display:inline-block; font-size:12px; background-color:#FFF; padding:2px;">用户名: <?php echo $username; ?></a>
</body>
</html>
