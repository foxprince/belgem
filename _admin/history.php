<?php
/*===================session========================*/
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
if(!isset($_SESSION['authenticated'])) {
  header('Location: login.php');
  exit;
}

if($_SESSION['authenticated']!='SiHui'){
	$_SESSION=array();
	if (isset($_COOKIE[session_name()])){
		setcookie(session_name(), '', time()-86400, '/');
	}
	session_destroy();
	header('Location: login.php');
    exit;
}

$username=$_SESSION['username'];
$account_level=$_SESSION['account_level'];

require_once('../includes/connection.php');
$conn=dbConnect('write','pdo');
$conn->query("SET NAMES 'utf8'");



	
if(isset($_POST['therefs']) && isset($_POST['thecomment_returnpoints'])){
	
	$return_p_comment=$_POST['thecomment_returnpoints'];
	$therefs=$_POST['therefs'];
	
	if($therefs!=''){
		$therefs_array=explode(',', $therefs);
		$sql_ref='';
		$sql_ref_between='';
		$sql_ref_counter=0;
		foreach($therefs_array as $ref_condi){
			if($sql_ref_counter>0){
				$sql_ref_between=' OR ';
			}
			if(trim($ref_condi)!=''){
				$sql_ref.=$sql_ref_between.' stock_ref = "'.$ref_condi.'"';
				$sql_ref_counter++;
			}			
		}
	}
		
	$sql_update='UPDATE diamonds SET point_returned = "YES", point_returned_date = NOW(), point_returned_comment = "'.$return_p_comment.'" WHERE order_sent = "YES" AND ('.$sql_ref.')';
	//exit($sql_update);
	
	$stmt_returnpoints=$conn->query($sql_update);
	$returndone=$stmt_returnpoints->rowCount();
	
}




?>





<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>管理界面:交易历史纪录</title>
<link rel="stylesheet" href="adminstyle.css">
<link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css" />
<style>
body{
	font-family:'Microsoft Yahei', 微软雅黑, STHeiti, simsun, Arial, sans-serif;
	font-size:14px;
	font-weight:100;
	}

h1{
	position:relative;
	left:40px;
	font-family:Verdana, Geneva, sans-serif;
	font-weight:bold;
	font-size:20px;
	color:#000;
	margin-top:0px;
}
tr.returned{
	background-color:#9FC;
}
.returned td.returnedstatusbox{
	background-image:URL(../images/tick.png);
	background-position:right top;
	background-repeat:no-repeat;
	background-size:38px;
}
td{
	vertical-align:top;
	padding:5px;
	border-style:solid;
	border-width:1px;
	border-color:#CCC;
}
span.inditxt{
	font-weight:bold;
	color:#F60;
}
a.agentbtn{
	display:inline-block;
	padding:2px 5px;
	margin:3px 5px;
	background-color:#0CF;
}

span.priceattention{
	font-size:14px;
	font-weight:bold;
	color:#F00;
}
</style>
<script src="/js/jquery-1.11.2.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$('#returnpointbtn').click(function(){
		$('#returnpointsbox').fadeIn('fast');
	});
	$('#pointsreturncancelbtn').click(function(){
		$('#returnpointsbox').fadeOut('fast');
	});
});
$(function() {
    $( "#datepicker_fromdate, #datepicker_todate" ).datepicker({
		dateFormat: "yy-mm-dd"
	});
});

function save_returnpoints(therefs){
	$('input#therefs').val(therefs);
	$('#if_returnpoint').val('YES');
	$('#thecomment_returnpoints').val($('#thereturnpointscomments').val());
	$('form#the_form').submit();
}
</script>


</head>

<body>

<?php
include('navi.php');
?>

<div id="maincontent" style="padding-bottom:50px;">



<?php
if(isset($returndone) && $returndone){
?>
<h4 style="color:#F00;">返点标记成功</h4>
<?php
}
?>


<h1 style="display:none;">交易历史纪录</h1>

<?php
###############################**************************************##################################
###############################**************************************##################################
###############################************  START 最高权限操作区    ************#########################
###############################**************************************##################################
###############################**************************************##################################
if($account_level==0){
?>
<div class="filterbox" style="padding:15px; background-color:#F5F5F5; width:700px;">
<form method="get" id="the_filter_form" action="">
<span style="font-size:24px; color:#CCC;">选择代理商</span>
<div style="position:relative; width:700px;">
<h4 style="margin-bottom:5px; color:#960;">一级代理</h4>
<?php
####################################--------- 列出一级代理
############################################# 列出一级代理
############################################# 列出一级代理
$sql_groups='SELECT DISTINCT user_name, real_name FROM users WHERE account_level = 1';
foreach($conn->query($sql_groups) as $row_group){
	$checkedinfo='';
	if(isset($_GET['agent'])){
		if($row_group['user_name']==$_GET['agent']){
			$checkedinfo='checked="checked"';
		}
	}else if(isset($_POST['agent'])){
		if($row_group['user_name']==$_POST['agent']){
			$checkedinfo='checked="checked"';
		}
	}
	$main_agent_name=$row_group['user_name'];
?>
<!--
<a class="agentbtn" href="history.php?agent=<?php echo $main_agent_name; ?>"><?php echo $row_group['real_name'] ?></a>
-->

<div class="mainagentbox" style="display:block; padding:3px 5px; border-style:solid; border-color:#960; border-width:1px; background-color:#e3dac5; margin:3px;">
<input type="radio" name="agent" value="<?php echo $main_agent_name; ?>" <?php echo $checkedinfo; ?> /> 
<span style="font-size:18px;"><?php echo $row_group['real_name'] ?></span>

<div class="subagentbox" style="margin-left:20px;">
<?php
$sql_subuser='SELECT * FROM users WHERE account_level = 2 AND given_by = "'.$main_agent_name.'"';
foreach($conn->query($sql_subuser) as $row_subagent){
?>
<p style="display:inline-block; margin:2px; padding:0px 3px; font-size:12px; background-color:#FFF;">
<input type="radio" name="agent" value="<?php echo $row_subagent['user_name']; ?>" /><?php echo $row_subagent['real_name']; ?>
</p>
<?php
}
?>
</div><!-- subagentbox -->
</div><!-- mainagentbox -->

<?php
}
?>

<h4 style="margin-bottom:5px; color:#960;">独立代理</h4>
<?php
####################################--------- 列出独立代理
############################################# 列出独立代理
############################################# 列出独立代理
$sql_groups='SELECT DISTINCT user_name, real_name FROM users WHERE account_level = 8';
foreach($conn->query($sql_groups) as $row_group){
	$checkedinfo='';
	if(isset($_GET['agent'])){
		if($row_group['user_name']==$_GET['agent']){
			$checkedinfo='checked="checked"';
		}
	}else if(isset($_POST['agent'])){
		if($row_group['user_name']==$_POST['agent']){
			$checkedinfo='checked="checked"';
		}
	}
?>

<div style="display:inline-block; padding:3px 5px; border-style:solid; border-color:#960; border-width:1px; background-color:#e3dac5; margin:3px;">
<input type="radio" name="agent" value="<?php echo $row_group['user_name'] ?>" <?php echo $checkedinfo; ?> /> 
<?php echo $row_group['real_name'] ?>
</div>

<?php
}
?>
</div>





<?php
if(isset($_GET['fromdate'])){
	$the_f_date=$_GET['fromdate'];
}else{
	$the_f_date='2014-01-01';
}
if(isset($_GET['todate'])){
	$the_t_date=$_GET['todate'];
}else{
	$the_t_date= date("Y-m-d");
}
?>

<p style="position:relative; width:450px; padding:12px 8px; border-style:solid; border-color:#960;; border-width:2px; background-color:#e3dac5;">选择查看日期：从<input type="text" name="fromdate" id="datepicker_fromdate" value="<?php echo $the_f_date; ?>"> 至 <input type="text" name="todate" id="datepicker_todate" value="<?php echo $the_t_date; ?>"></p>
<input type="submit" value="更新结果" style="background-color:#960; color:#FFF; padding:6px 12px; font-size:16px; border-width:1px;" />
</form>



<form action="" method="post" id="the_form">
<input type="hidden" name="thecomment_returnpoints" id="thecomment_returnpoints" value="" />
<input type="hidden" name="therefs" id="therefs" value="" />
</form>

</div>
<?php
}
###############################**************************************##################################
###############################**************************************##################################
###############################************  END 最高权限操作区    ************###########################
###############################**************************************##################################
###############################**************************************##################################
?>


<div style="position:relative;">
<h3 style="position:relative; margin:55px 200px 5px 0; border-bottom-style:solid; border-width:1px; border-color:#960;">
<span style="display:inline-block; color:#960; background-color:#e3dac5; font-size:20px; margin:0; padding: 3px 12px; border-style:solid; border-width:1px;
border-color:#960;">
历史纪录</span>
</h3>
<?php
$str_the_refs_to_return='';
if($account_level==0){//||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
###################################################################################################################
###################################################################################################################
###################################################################################################################
################################ ----- 开始的最开始，检查用户权限，并根据权限生成内容 ----#################################
############################################## ----- 最高权限 ----- ################################################
###################################################################################################################
###################################################################################################################
	
//$sql='SELECT diamonds.id AS dia_id, stock_ref, shape, carat, color, fancy_color, clarity, grading_lab, certificate_number, cut_grade, polish, symmetry, fluorescence_intensity, price, diamonds.from_company, ordered_by, ordered_time, sent_time, paid_amount, paid_at, point_returned, point_returned_date, point_returned_comment, comment, real_name, account_level, given_by FROM diamonds, users WHERE diamonds.order_sent = "YES" AND diamonds.ordered_by = users.user_name '.$searchcondition.' ORDER BY ordered_time DESC';  @@@@@@@@@@@@@@@@ old script


//第一步，先检查和准备各种检索条件

if(isset($_GET['agent'])){//000 最先检查是否有过滤条件
	//001 是一级还是下属代理
	$agent_username=$_GET['agent'];
	
	$user_check='SELECT account_level FROM users WHERE user_name = "'.$agent_username.'"';
	foreach($conn->query($user_check) as $r){
		$userlevel=$r['account_level'];
	}
	//002 三种代理两种情况的条件
	if($userlevel==1){
		$search_condition_user=' ordered_by = "'.$agent_username.'" ';
		//找到所有下属代理并写在检索条件中
		$sql_subagents='SELECT user_name FROM users WHERE given_by = "'.$agent_username.'"';
		foreach($conn->query($sql_subagents) as $r){
			$subagent=$r['user_name'];
			if($subagent){
				$search_condition_user.=' OR ordered_by = "'.$subagent.'"';
			}
		}
		//$search_condition_user='ordered_by = "''"';
	}else{
		$search_condition_user=' ordered_by = "'.$agent_username.'" ';
	}
	
	$start_time=$_GET['fromdate'];
	$to_time=$_GET['todate'];
	
	//$search_condition_since='';
	
	$sql='SELECT * FROM diamonds WHERE order_sent = "YES" AND (sold_status = "AGENCY" OR sold_status IS NULL) AND ('.$search_condition_user.') AND ordered_time >= "'.$start_time.'" AND ordered_time <= "'.$to_time.'" ORDER BY ordered_time DESC';
	
}else{//0000 如果没有过滤条件，则全部列出
	$sql='SELECT * FROM diamonds WHERE order_sent = "YES" AND (sold_status = "AGENCY" OR sold_status IS NULL) ORDER BY ordered_time DESC';
}
?>

<button onclick="hidefinido()" style="display:inline-block; position:absolute; padding:5px 20px; background-color:#CFF; border-width:1px; font-size:16px; top:0; left:158px; background-color:#e3dac5; cursor:pointer;">隐藏/显示 已经返点的纪录</button>
<script type="text/javascript">
var showfinido=true;
function hidefinido(){
	if(showfinido){
		$('tr.returned').fadeOut('fast');
		showfinido=false;
	}else{
		$('tr.returned').fadeIn('fast');
		showfinido=true;
	}
}
</script>

<table cellpadding="0" cellspacing="0" width="820">
<tr style="background-color:#EEE;">
<td width="38">#</td>
<td width="88">发货时间</td>
<td width="258">钻石</td>
<td width="88">预定人</td>
<td width="88">总代理</td>
<td width="88">金额</td>
<td width="380">返点情况</td>
</tr>

<?php
$counter=0;
$total_sold_amount=0;
$total_amount_for_points_to_return=0;

	foreach($conn->query($sql) as $row){
		$counter++;
		
		if($row['point_returned']=="NO"){
			$classofrow='';
		}else{
			$classofrow=' class="returned" ';
		}
		
	?>
<tr<?php echo $classofrow; ?>>
<td><?php echo $counter; ?></td>
<td><?php echo $row['sent_time']; ?></td>
<td>
库存编号：<?php echo $row['stock_ref']; ?><br />
形状:<?php echo $row['shape']; ?>, <?php echo $row['carat']; ?>克拉，
<?php
if($row['color']!=NULL && $row['color']!=''){
?>
颜色:<?php echo $row['color']; ?>，
<?php
}
if($row['fancy_color']!=NULL && $row['fancy_color']!=''){
?>
彩色:<?php echo $row['fancy_color']; ?>,
<?php
}
?>
<br /> 净度:<?php echo $row['clarity']; ?>, 切工:<?php echo $row['cut_grade']; ?>,<br />
抛光:<?php echo $row['polish']; ?>, 对称性:<?php echo $row['symmetry']; ?>, 荧光:<?php echo $row['fluorescence_intensity']; ?>,<br />
<?php echo $row['grading_lab']; ?>
</td>

<td>
<?php
$sql_realname='SELECT * FROM users WHERE user_name = "'.$row['ordered_by'].'"';
foreach($conn->query($sql_realname) as $row_user){
	$real_name=$row_user['real_name'];
}
echo $real_name; 
?>
</td>

<td>
<?php
if($row_user['account_level']==2){
	foreach($conn->query('SELECT real_name FROM users WHERE user_name = "'.$row_user['given_by'].'"') as $row_agent){
		echo $row_agent['real_name'];
	}
}else if($row_user['account_level']==1){
	echo "预定人即为总代理";
}else if($row_user['account_level']==8){
	echo "预定人为独立代理";
}
?>
</td>


<td>
<?php 

$total_sold_amount=$total_sold_amount+$row['paid_amount'];

$crr_d_price=$row['price'];
$crr_d_paid=$row['paid_amount'];
if($crr_d_price>$crr_d_paid){
?>
<span class="priceattention"><?php echo $crr_d_paid; ?> / <?php echo $crr_d_price; ?><br />! 未付全款 </span>
<?php
}else{
?>
<span class="pricenormal"><?php echo $crr_d_paid; ?> / <?php echo $crr_d_price; ?> </span>
<?php
}
?>
</td>

<td class="returnedstatusbox">
<?php
if($row_user['account_level']==2){
?>
二级代理，返点给其上级代理: 
<?php 
echo $row_agent['real_name']; 
?>
<br />
<?php
}

if($row['point_returned']=="NO"){
	$total_amount_for_points_to_return=$total_amount_for_points_to_return+$row['paid_amount'];
	$str_the_refs_to_return.=$row['stock_ref'].',';
	echo '未返点';
}else{
?>
已经返点。<br />
返点时间:<?php echo $row['point_returned_date']; ?><br />
备注信息:<p><?php echo $row['point_returned_comment']; ?></p>
<?php
}
?>  
</td>

</tr>
	<?php	
	}
?>

<tr><td colspan="7" align="center"> -- -- -- -- -- --</td></tr>


<tr><td colspan="7" align="center" style="background-color:#e3dac5;">
<?php
if(isset($row_user['account_level']) && ($row_user['account_level']==1 || $row_user['account_level']==8)){
?>
<span style="display:inline-block; padding:3px 10px; border-style:solid; border-width:1px; border-color:#960; margin:0 8px; background-color:#FFF; font-size:20px; font-weight:bold;">总销售金额:<?php echo $total_sold_amount; ?></span> <span style="display:inline-block; padding:3px 10px; border-style:solid; border-width:1px; border-color:#960; margin:0 8px; background-color:#FFF; font-size:20px; font-weight:bold;">尚未返点的金额:<?php echo $total_amount_for_points_to_return; ?></span> 
<?php
if(isset($_GET['agent']) && isset($_GET['fromdate']) && isset($_GET['todate']) && $total_amount_for_points_to_return>0){
?>
<button id="returnpointbtn" style="background-color:#960; color:#FFF; padding:3px 12px; font-size:16px; border-width:1px;">把这些纪录中，未返点的标记为已返点</button>
<?php
}//end for if(isset($_GET['agent']) && isset($_GET['fromdate']) && isset($_GET['todate']) && $total_amount_for_points_to_return>0)
}//end for if($row_user['account_level']==1 || $row_user['account_level']==8){
?>
</td></tr>


</table>

<?php
}else if($account_level==1){//||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
###################################################################################################################
###################################################################################################################
###################################################################################################################
################################ ----- 开始的最开始，检查用户权限，并根据权限生成内容 ----#################################
############################################## ----- 一级代理 ----- ################################################
###################################################################################################################
###################################################################################################################	

	
	$sql='SELECT diamonds.id, stock_ref, shape, carat, color, fancy_color, clarity, grading_lab, certificate_number, cut_grade, polish, symmetry, fluorescence_intensity, price, diamonds.from_company, ordered_by, ordered_time, sent_time, paid_amount, paid_at, comment, real_name, account_level, given_by FROM diamonds, users WHERE diamonds.order_sent = "YES" AND diamonds.ordered_by = users.user_name AND (diamonds.ordered_by = "'.$username.'" OR users.given_by = "'.$username.'") ORDER BY ordered_time DESC';
	
?>
<table cellpadding="0" cellspacing="0" width="820">
<tr style="background-color:#9CF;">
<td width="38">#</td>
<td width="88">发货时间</td>
<td width="158">钻石（库存编号）</td>
<td width="88">预定人</td>
<td width="88">金额</td>

</tr>


<?php
$counter=0;
$total_sold_amount=0;
$total_amount_for_points_to_return=0;
	foreach($conn->query($sql) as $row){
		$counter++;
?>
<tr>
<td><?php echo $counter; ?></td>
<td><?php echo $row['sent_time']; ?></td>
<td><?php echo $row['stock_ref']; ?></td>
<td>
<?php
if($row['account_level']==2){
	foreach($conn->query('SELECT real_name FROM users WHERE user_name = "'.$row['given_by'].'"') as $row_agent){
		echo $row_agent['real_name'];
	}
}else if($row['account_level']==1){
	echo $row['real_name'];
}
?>
</td>


<td>
<?php
	$total_sold_amount+=$row['paid_amount'];
 	//echo $row['paid_amount'];
	$crr_d_price=$row['price'];
	$crr_d_paid=$row['paid_amount'];
	if($crr_d_price>$crr_d_paid){
?>
<span class="priceattention"><?php echo $crr_d_paid; ?> / <?php echo $crr_d_price; ?></span>
<?php
	}else{
?>
<span class="pricenormal"><?php echo $crr_d_paid; ?> / <?php echo $crr_d_price; ?></span>
<?php
	}
?>
</td>

</tr>
<?php
	}
?>



</table>
<?php
}else{
	############################################################################
	############################################################################
	############################################################################
	############################################################################
	############################################################################
	
	$sql='SELECT stock_ref, sent_time, paid_amount, paid_at, comment FROM diamonds WHERE ordered_by = "'.$username.'" ORDER BY ordered_time DESC';
?>


<table cellpadding="0" cellspacing="0" width="820">
<tr style="background-color:#9CF;">
<td width="38">#</td>
<td width="88">发货时间</td>
<td width="158">钻石（库存编号）</td>


</tr>


<?php

$counter=0;
	foreach($conn->query($sql) as $row){
		$counter++;
?>
<tr>
<td><?php echo $counter; ?></td>
<td><?php echo $row['sent_time']; ?></td>
<td><?php echo $row['stock_ref']; ?></td>
</tr>
<?php
	}
?>



</table>




<?php
}
?>


</div>


<div id="indication" style="position:fixed; width:100%; height:100%; background-color:rgba(255,255,255, 0.88); top:0; left:0; z-index:28; display:none;">
<div id="indiinner" style="position:relative; width:200px; background-color:#0CF; margin:150px auto; padding:20px; text-align:center;">
正在存储。。。
</div>
</div>

<div id="returnpointsbox" style="position:fixed; width:100%; height:100%; background-color:rgba(255,255,255, 0.88); top:0; left:0; z-index:28; display:none;">
<div id="returnpointsboxinner" style="position:relative; width:450px; background-color:#e3dac5; margin:150px auto; padding:20px; text-align:center;">
<label style="display:inline-block; margin-bottom:15px;">返点备注信息（可选）</label><br />
<textarea id="thereturnpointscomments" style="width:350px; height:120px;"></textarea>
<br /><br />
<button id="pointsreturnconfirmbtn" style="background-color:#960; color:#FFF; padding:3px 12px; font-size:16px; border-width:1px;" onclick="save_returnpoints('<?php echo $str_the_refs_to_return; ?>')">确定返点</button>
<button id="pointsreturncancelbtn">取消</button>
</div>
</div>



</div>
</body>
</html>