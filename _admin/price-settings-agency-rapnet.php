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


if($account_level!=0){
	exit;
}

require_once('../includes/connection.php');
$conn=dbConnect('write','pdo');
$conn->query("SET NAMES 'utf8'");



$sql_discount='SELECT * FROM price_discount';
$stmt_disc=$conn->query($sql_discount);
$disc_num=$stmt_disc->rowCount();
if($disc_num){
	foreach($conn->query($sql_discount) as $rd){
		$general_discount=abs($rd['rapnet_discount_agency']);
	}
}

if(!isset($general_discount) || $general_discount==NULL || 	$general_discount=='' ){
		$general_discount=0;
}
if(isset($_POST['discount_percentage'])){
	$thenew_disc_num=$_POST['discount_percentage'];
	if($thenew_disc_num==$general_discount){
		$disc_message='折扣数额没有更改';
	}else{
		$sql_disc_update='UPDATE price_discount SET rapnet_discount_agency = '.$thenew_disc_num;
		$stmt_disc_update=$conn->query($sql_disc_update);
		$disc_updated=$stmt_disc_update->rowCount();
		if($disc_updated){
			$disc_message='折扣数额已经更改';
			$general_discount=$_POST['discount_percentage'];
		}else{
			$disc_message='错误：无法更改折扣数额，请重试';
		}
	}
}



?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>管理界面:价格管理</title>
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
div#maincontent{
	padding-left:120px;
}
a.thebigbtn{
	display:inline-block;
	padding:58px 128px;
	background-color:#333;
	color:#FFF;
	font-size:18px;
	margin-right:20px;
	text-decoration:none;
}
a.thebigbtn:hover{
	background-color:#000;
}
.feedback{
	font-size:18px;
	font-weight:bold;
	color:#F00;
}
.emph{
	font-size:18px;
}
input.emph{
	font-size:18px;
	padding:5px;
	background-color:#FFC;
}
.buttontoclick{
	background-color:#F00;
	color:#FFF;
	font-size:16px;
	border-width:1px;
}
div#conditionbox{
	margin-top:20px;
	padding-top:20px;
	border-top-style:dashed;
	border-width:1px;
	border-color:#333;
}
.weightfromvalue, .weighttovalue{
	width:50px;
}


p.weightchoice-box, div.theouterbox-color, div.theouterbox-clarity, div.colorchoicebox, div.claritychoicebox, div.theouterbox-shape, div.shapechoicebox, div.theouterbox-cut, div.cutchoicebox, div.theouterbox-polish, div.polishchoicebox, div.theouterbox-symmetry, div.symmetrychoicebox, div.theouterbox-certificate, div.certificatechoicebox, div.theouterbox-fluo, div.fluochoicebox{
	display:inline-block;
}
p.weightchoice-box, div.theouterbox-color, div.theouterbox-clarity, div.theouterbox-shape, div.theouterbox-cut, div.theouterbox-polish, div.theouterbox-symmetry, div.theouterbox-certificate, div.theouterbox-fluo{
	margin:0 15px 8px 0;
	padding:0 18px 8px 0;
}
span.color-switch-btn, span.clarity-switch-btn, span.cut-switch-btn, span.polish-switch-btn, span.symmetry-switch-btn, span.certificate-switch-btn, span.fluo-switch-btn{
	display:inline-block;
	padding:2px 5px;
	background-color:#cfcfcf;
	color:#999;
	cursor:pointer;
}
.chosen{
	background-color:#F99 !important;
	color:#000 !important;
}
#existingrules{
	padding:10px;
	background-color:#CFF;
	width:1030px;
}
div.newrulecontainer{
	border-color:#CCF;
	border-style:solid;
	border-width:12px;
	background-color:#FFF;
	width:1000px;
	padding:0 10px;
}
li.therule{
	padding:0 20px 10px 10px;
	width:980px;
	border-style:solid;
	border-width:5px;
	border-color:#CCC;
	list-style:none;
	margin-top:8px;
	background-color:#FFF;
}
.title{
	font-size:18px;
}
div.conditionsbox{
	padding:15px;
	background-color:#EEE;
}
input.price-para{
	font-size:18px;
	padding:5px 8px;
	width:58px;
	background-color:#CFF;
	margin-left:12px;
}
p.the-price-para-box{
	display:inline-block;
	margin-right:25px;
	padding:5px;
}
button{
	cursor:pointer;
}
button.modifyrulesbtn{
	font-size:18px;
	background-color:#6CF;
	color:#000;
	padding:12px 26px;
	border-width:1px;
}
button.deleterulesbtn{
	font-size:16px;
	padding:6px 12px;
	background-color:#F00;
	color:#000;
	border-width:1px;
}
#update_data_btn{
	display:inline-block;
	padding:15px 50px;
	font-size:18px;
	background-color:#C00;
	color:#FFF;
	text-decoration:none;
}
span.shape-switch-btn{
	display:inline-block;
	padding:2px;
	position:relative;
	top:5px;
	background-color:#cfcfcf;
	cursor:pointer;
}
img.shapeicon{
	width:26px;
}
</style>
<script src="http://edecenter.com/lab/jquery-1.11.2.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>

<script type="text/javascript">
$(document).ready(function(){
	
});

function switchShapeChoice(crrid, crrvalue){
	var crr_id=crrid;
	var crr_value=crrvalue;
	var crr_ele=$('div.shapechoicebox_'+crr_id+' span.shape-switch-btn[title="'+crr_value+'"]');
	
	crr_ele.toggleClass('chosen');
	
	$('button#modifyrules-'+crr_id).html('保存更改');
}

function switchColorChoice(crrid, crrvalue){
	var crr_id=crrid;
	var crr_value=crrvalue;
	var crr_ele=$('div.colorchoicebox_'+crr_id+' span.color-switch-btn[title="'+crr_value+'"]');
	
	crr_ele.toggleClass('chosen');
	
	$('button#modifyrules-'+crr_id).html('保存更改');
}

function switchClarityChoice(crrid, crrvalue){
	var crr_id=crrid;
	var crr_value=crrvalue;
	var crr_ele=$('div.claritychoicebox_'+crr_id+' span.clarity-switch-btn[title="'+crr_value+'"]');
	
	crr_ele.toggleClass('chosen');
	$('button#modifyrules-'+crr_id).html('保存更改');
}

function switchCutChoice(crrid, crrvalue){
	var crr_id=crrid;
	var crr_value=crrvalue;
	var crr_ele=$('div.cutchoicebox_'+crr_id+' span.cut-switch-btn[title="'+crr_value+'"]');
	
	crr_ele.toggleClass('chosen');
	$('button#modifyrules-'+crr_id).html('保存更改');
}

function switchPolishChoice(crrid, crrvalue){
	var crr_id=crrid;
	var crr_value=crrvalue;
	var crr_ele=$('div.polishchoicebox_'+crr_id+' span.polish-switch-btn[title="'+crr_value+'"]');
	
	crr_ele.toggleClass('chosen');
	$('button#modifyrules-'+crr_id).html('保存更改');
}

function switchSymmetryChoice(crrid, crrvalue){
	var crr_id=crrid;
	var crr_value=crrvalue;
	var crr_ele=$('div.symmetrychoicebox_'+crr_id+' span.symmetry-switch-btn[title="'+crr_value+'"]');
	
	crr_ele.toggleClass('chosen');
	$('button#modifyrules-'+crr_id).html('保存更改');
}

function switchCertificateChoice(crrid, crrvalue){
	var crr_id=crrid;
	var crr_value=crrvalue;
	var crr_ele=$('div.certificatechoicebox_'+crr_id+' span.certificate-switch-btn[title="'+crr_value+'"]');
	
	crr_ele.toggleClass('chosen');
	$('button#modifyrules-'+crr_id).html('保存更改');
}
function switchFluoChoice(crrid, crrvalue){
	var crr_id=crrid;
	var crr_value=crrvalue;
	var crr_ele=$('div.fluochoicebox_'+crr_id+' span.fluo-switch-btn[title="'+crr_value+'"]');
	
	crr_ele.toggleClass('chosen');
	$('button#modifyrules-'+crr_id).html('保存更改');
}



function updateRule(ruleID){
	
	
	var idoftherule=ruleID;
	
	var $carat_from=$('input#weightfrom_for_'+idoftherule).val();
	var $carat_to=$('input#weightto_for_'+idoftherule).val();
	
	var $color='';
	var $clarity='';
	
	var $shape='';
	var $cut='';
	var $polish='';
	var $symmetry='';
	var $certificate='';
	var $fluo='';
	
	var colorchoiceCounter=0;
	$('.colorchoicebox_'+idoftherule+' > span.chosen').each(function(){
		var crr_color=$(this).attr('title');
		if(colorchoiceCounter>0){
			$color+=',';
		}
		$color+=crr_color;
		colorchoiceCounter++;
	});
	
	var claritychoiceCounter=0;
	$('.claritychoicebox_'+idoftherule+' > span.chosen').each(function(){
		var crr_clarity=$(this).attr('title');
		if(claritychoiceCounter>0){
			$clarity+=',';
		}
		$clarity+=crr_clarity;
		claritychoiceCounter++;
	});
	
	var $the_para_value=$('input#para-for-condition-'+idoftherule).val();
	
	var shapechoiceCounter=0;
	$('.shapechoicebox_'+idoftherule+' > span.chosen').each(function(){
		var crr_shape=$(this).attr('title');
		if(shapechoiceCounter>0){
			$shape+=',';
		}
		$shape+=crr_shape;
		shapechoiceCounter++;
	});
	
	var cutchoiceCounter=0;
	$('.cutchoicebox_'+idoftherule+' > span.chosen').each(function(){
		var crr_cut=$(this).attr('title');
		if(cutchoiceCounter>0){
			$cut+=',';
		}
		$cut+=crr_cut;
		cutchoiceCounter++;
	});
	
	var polishchoiceCounter=0;
	$('.polishchoicebox_'+idoftherule+' > span.chosen').each(function(){
		var crr_polish=$(this).attr('title');
		if(polishchoiceCounter>0){
			$polish+=',';
		}
		$polish+=crr_polish;
		polishchoiceCounter++;
	});
	
	var symmetrychoiceCounter=0;
	$('.symmetrychoicebox_'+idoftherule+' > span.chosen').each(function(){
		var crr_symmetry=$(this).attr('title');
		if(symmetrychoiceCounter>0){
			$symmetry+=',';
		}
		$symmetry+=crr_symmetry;
		symmetrychoiceCounter++;
	});
	
	var certificatechoiceCounter=0;
	$('.certificatechoicebox_'+idoftherule+' > span.chosen').each(function(){
		var crr_certificate=$(this).attr('title');
		if(certificatechoiceCounter>0){
			$certificate+=',';
		}
		$certificate+=crr_certificate;
		certificatechoiceCounter++;
	});
	
	var fluochoiceCounter=0;
	$('.fluochoicebox_'+idoftherule+' > span.chosen').each(function(){
		var crr_fluo=$(this).attr('title');
		if(fluochoiceCounter>0){
			$fluo+=',';
		}
		$fluo+=crr_fluo;
		fluochoiceCounter++;
	});
	
	
	if($color=='' || $clarity=='' || $carat_from=='' || $carat_to=='' || $the_para_value=='' || $cut=='' || $polish=='' || $symmetry=='' || $certificate=='' || $shape=='' || $fluo==''){
		alert('请完成所有条件');
		
		return;
	}
	
	$('button#modifyrules-'+idoftherule).html('保存中...');
	
	if(idoftherule=='new'){
		$.post(
				"addRule.php", 
				{source:'rapnet', target:'agency', carat_from: $carat_from, carat_to: $carat_to, color: $color, clarity: $clarity, shape: $shape, cut: $cut, polish: $polish, symmetry: $symmetry, certificate: $certificate, fluo: $fluo, the_para_value:$the_para_value}, 
				function(data){
					if(data=='ok'){
						$('button#modifyrules-'+idoftherule).html('保存成功！');
						location.reload();
					}else{
						alert('未知错误，即将刷新浏览器，请稍后重试'+data);
						location.reload();
					}
				}
		);
	}else{
		$.post(
				"updateRule.php", 
				{source:'rapnet', target:'agency', recordid:idoftherule, carat_from: $carat_from, carat_to: $carat_to, color: $color, clarity: $clarity, shape: $shape, cut: $cut, polish: $polish, symmetry: $symmetry, certificate: $certificate, fluo: $fluo, the_para_value:$the_para_value}, 
				function(data){
					if(data=='ok'){
						$('button#modifyrules-'+idoftherule).html('保存成功！');
					}else{
						alert('未知错误，请稍后重试'+data);
					}
				}
		);
	}
	
	
}

function deleteRule(ruleID){
	var idoftherule=ruleID;
	r=confirm('确定要删除该规则吗？');
	if(r){
		$('button#deleterules-'+idoftherule).html('处理中...');
		$.post(
				"deleteRule.php", 
				{source:'rapnet', target:'agency', recordid:idoftherule}, 
				function(data){
					if(data=='ok'){
						$('button#deleterules-'+idoftherule).html('删除成功！');
						$('li.therule[title="'+idoftherule+'"]').delay(500).fadeOut('normal',function(){
							$('li.therule[title="'+idoftherule+'"]').remove();
						});
					}
				}
		);
	}
}
function updatedata(){
	r=confirm('只有新价格规则制定后才有必要刷新数据，确定刷新？');
	if(r){
		window.open('http://happyeurope.eu/regular_actions.php?newprice=tobeupdated', '_blank');
	}
}
</script>

</head>

<body>

<?php
include('navi.php');
?>
<div id="maincontent">


<h2>价格设定：代购网站价格 由Rapnet提取的数据</h2>

<div id="box-general-ratio-discount">
<form action="" method="post">
<?php
if(isset($disc_message)){
?>
<p class="feedback"><?php echo $disc_message; ?></p>
<?php
}
?>
<label>总折扣(-x%)：</label> <span class="emph">-</span> <input name="discount_percentage" class="emph" style="position:relative; width:38px;" type="text" value="<?php echo 	$general_discount; ?>" /> <span class="emph">%</span> (请只添数字，不要添负号和百分号)
<input type="submit" value="提交" class="buttontoclick" />
</form>
</div>



<div id="conditionbox">
<h3>已有规则</h3>
  <ul id="existingrules">
  
<?php
$sql_rules='SELECT * FROM price_settings_rapnet_agency ORDER BY priority ASC';
$stmt_rules=$conn->query($sql_rules);
$rulesfound=$stmt_rules->rowCount();


if($rulesfound){foreach($stmt_rules as $rr){
?>
<li class="therule" title="<?php echo $rr['id']; ?>">
<p class="title">符合条件：</p>
<div class="conditionsbox">

<div class="theouterbox-shape"><label>形状：</label>
<div class="shapechoicebox shapechoicebox_<?php echo $rr['id']; ?>">

<?php
$crr_shape_choice_raw=$rr['shape'];
$crr_shape_choice_array=array();
$crr_shape_choice_array=explode(',',$crr_shape_choice_raw);


$crr_shape_BR_Chosen='';
$crr_shape_PS_Chosen='';
$crr_shape_PR_Chosen='';
$crr_shape_HS_Chosen='';
$crr_shape_MQ_Chosen='';
$crr_shape_OV_Chosen='';
$crr_shape_EM_Chosen='';
$crr_shape_RAD_Chosen='';
$crr_shape_CU_Chosen='';

if(in_array("BR", $crr_shape_choice_array)){
	$crr_shape_BR_Chosen=' chosen';
}
if(in_array("PS", $crr_shape_choice_array)){
	$crr_shape_PS_Chosen=' chosen';
}
if(in_array("PR", $crr_shape_choice_array)){
	$crr_shape_PR_Chosen=' chosen';
}
if(in_array("HS", $crr_shape_choice_array)){
	$crr_shape_HS_Chosen=' chosen';
}
if(in_array("MQ", $crr_shape_choice_array)){
	$crr_shape_MQ_Chosen=' chosen';
}
if(in_array("OV", $crr_shape_choice_array)){
	$crr_shape_OV_Chosen=' chosen';
}
if(in_array("EM", $crr_shape_choice_array)){
	$crr_shape_EM_Chosen=' chosen';
}
if(in_array("RAD", $crr_shape_choice_array)){
	$crr_shape_RAD_Chosen=' chosen';
}
if(in_array("CU", $crr_shape_choice_array)){
	$crr_shape_CU_Chosen=' chosen';
}
?>

<span class="shape-switch-btn<?php echo $crr_shape_BR_Chosen; ?>" title="BR" onclick="switchShapeChoice(<?php echo $rr['id']; ?>, 'BR')"><img class="shapeicon" src="/images/site_elements/icons/01.gif" /></span>
<span class="shape-switch-btn<?php echo $crr_shape_PS_Chosen; ?>" title="PS" onclick="switchShapeChoice(<?php echo $rr['id']; ?>, 'PS')"><img class="shapeicon" src="/images/site_elements/icons/02.gif" /></span>
<span class="shape-switch-btn<?php echo $crr_shape_PR_Chosen; ?>" title="PR" onclick="switchShapeChoice(<?php echo $rr['id']; ?>, 'PR')"><img class="shapeicon" src="/images/site_elements/icons/03.gif" /></span>
<span class="shape-switch-btn<?php echo $crr_shape_HS_Chosen; ?>" title="HS" onclick="switchShapeChoice(<?php echo $rr['id']; ?>, 'HS')"><img class="shapeicon" src="/images/site_elements/icons/08.gif" /></span>
<span class="shape-switch-btn<?php echo $crr_shape_MQ_Chosen; ?>" title="MQ" onclick="switchShapeChoice(<?php echo $rr['id']; ?>, 'MQ')"><img class="shapeicon" src="/images/site_elements/icons/05.gif" /></span>
<span class="shape-switch-btn<?php echo $crr_shape_OV_Chosen; ?>" title="OV" onclick="switchShapeChoice(<?php echo $rr['id']; ?>, 'OV')"><img class="shapeicon" src="/images/site_elements/icons/11.gif" /></span>
<span class="shape-switch-btn<?php echo $crr_shape_EM_Chosen; ?>" title="EM" onclick="switchShapeChoice(<?php echo $rr['id']; ?>, 'EM')"><img class="shapeicon" src="/images/site_elements/icons/10.gif" /></span>
<span class="shape-switch-btn<?php echo $crr_shape_RAD_Chosen; ?>" title="RAD" onclick="switchShapeChoice(<?php echo $rr['id']; ?>, 'RAD')"><img class="shapeicon" src="/images/site_elements/icons/06.gif" /></span>
<span class="shape-switch-btn<?php echo $crr_shape_CU_Chosen; ?>" title="CU" onclick="switchShapeChoice(<?php echo $rr['id']; ?>, 'CU')"><img class="shapeicon" src="/images/site_elements/icons/12.gif" /></span>
</div><!-- end shapechoicebox -->
</div><!-- END theouterbox-shape -->



<p class="weightchoice-box"><label>重量：</label> <input id="weightfrom_for_<?php echo $rr['id']; ?>" class="weightfromvalue emph" type="text" value="<?php echo $rr['carat_from']; ?>" /> - <input id="weightto_for_<?php echo $rr['id']; ?>" class="weighttovalue emph" type="text" value="<?php echo $rr['carat_to']; ?>" /> ct</p>

<div class="theouterbox-color"><label>颜色：</label>

<?php
$crr_color_choice_raw=$rr['color'];
$crr_color_choice_array=array();
$crr_color_choice_array=explode(',',$crr_color_choice_raw);
$crr_color_D_Chosen='';
$crr_color_E_Chosen='';
$crr_color_F_Chosen='';
$crr_color_G_Chosen='';
$crr_color_H_Chosen='';
$crr_color_I_Chosen='';
$crr_color_J_Chosen='';
$crr_color_K_Chosen='';
$crr_color_L_Chosen='';
$crr_color_M_Chosen='';

if(in_array("D", $crr_color_choice_array)){
	$crr_color_D_Chosen=' chosen';
}
if(in_array("E", $crr_color_choice_array)){
	$crr_color_E_Chosen=' chosen';
}
if(in_array("F", $crr_color_choice_array)){
	$crr_color_F_Chosen=' chosen';
}
if(in_array("G", $crr_color_choice_array)){
	$crr_color_G_Chosen=' chosen';
}
if(in_array("H", $crr_color_choice_array)){
	$crr_color_H_Chosen=' chosen';
}
if(in_array("I", $crr_color_choice_array)){
	$crr_color_I_Chosen=' chosen';
}
if(in_array("J", $crr_color_choice_array)){
	$crr_color_J_Chosen=' chosen';
}
if(in_array("K", $crr_color_choice_array)){
	$crr_color_K_Chosen=' chosen';
}
if(in_array("L", $crr_color_choice_array)){
	$crr_color_L_Chosen=' chosen';
}
if(in_array("M", $crr_color_choice_array)){
	$crr_color_M_Chosen=' chosen';
}
?>

<div class="colorchoicebox colorchoicebox_<?php echo $rr['id']; ?>">

<span class="color-switch-btn<?php echo $crr_color_D_Chosen ?>" title="D" onclick="switchColorChoice(<?php echo $rr['id']; ?>, 'D')">D</span>
<span class="color-switch-btn<?php echo $crr_color_E_Chosen ?>" title="E" onclick="switchColorChoice(<?php echo $rr['id']; ?>, 'E')">E</span>
<span class="color-switch-btn<?php echo $crr_color_F_Chosen ?>" title="F" onclick="switchColorChoice(<?php echo $rr['id']; ?>, 'F')">F</span>
<span class="color-switch-btn<?php echo $crr_color_G_Chosen ?>" title="G" onclick="switchColorChoice(<?php echo $rr['id']; ?>, 'G')">G</span>
<span class="color-switch-btn<?php echo $crr_color_H_Chosen ?>" title="H" onclick="switchColorChoice(<?php echo $rr['id']; ?>, 'H')">H</span>
<span class="color-switch-btn<?php echo $crr_color_I_Chosen ?>" title="I" onclick="switchColorChoice(<?php echo $rr['id']; ?>, 'I')">I</span>
<span class="color-switch-btn<?php echo $crr_color_J_Chosen ?>" title="J" onclick="switchColorChoice(<?php echo $rr['id']; ?>, 'J')">J</span>
<span class="color-switch-btn<?php echo $crr_color_K_Chosen ?>" title="K" onclick="switchColorChoice(<?php echo $rr['id']; ?>, 'K')">K</span>
<span class="color-switch-btn<?php echo $crr_color_L_Chosen ?>" title="L" onclick="switchColorChoice(<?php echo $rr['id']; ?>, 'L')">L</span>
<span class="color-switch-btn<?php echo $crr_color_M_Chosen ?>" title="M" onclick="switchColorChoice(<?php echo $rr['id']; ?>, 'M')">M</span>


</div><!-- end colorchoicebox -->
</div><!-- END theouterbox-color -->



<div class="theouterbox-clarity"><label>净度：</label>

<?php
$crr_clarity_choice_raw=$rr['clarity'];
$crr_clarity_choice_array=array();
$crr_clarity_choice_array=explode(',',$crr_clarity_choice_raw);
$crr_clarity_FL_Chosen='';
$crr_clarity_IF_Chosen='';
$crr_clarity_VVS1_Chosen='';
$crr_clarity_VVS2_Chosen='';
$crr_clarity_VS1_Chosen='';
$crr_clarity_VS2_Chosen='';
$crr_clarity_SI1_Chosen='';
$crr_clarity_SI2_Chosen='';



if(in_array("FL", $crr_clarity_choice_array)){
	$crr_clarity_FL_Chosen=' chosen';
}
if(in_array("IF", $crr_clarity_choice_array)){
	$crr_clarity_IF_Chosen=' chosen';
}
if(in_array("VVS1", $crr_clarity_choice_array)){
	$crr_clarity_VVS1_Chosen=' chosen';
}
if(in_array("VVS2", $crr_clarity_choice_array)){
	$crr_clarity_VVS2_Chosen=' chosen';
}
if(in_array("VS1", $crr_clarity_choice_array)){
	$crr_clarity_VS1_Chosen=' chosen';
}
if(in_array("VS2", $crr_clarity_choice_array)){
	$crr_clarity_VS2_Chosen=' chosen';
}
if(in_array("SI1", $crr_clarity_choice_array)){
	$crr_clarity_SI1_Chosen=' chosen';
}
if(in_array("SI2", $crr_clarity_choice_array)){
	$crr_clarity_SI2_Chosen=' chosen';
}

?>
<div class="claritychoicebox claritychoicebox_<?php echo $rr['id']; ?>">

<span class="clarity-switch-btn<?php echo $crr_clarity_FL_Chosen ?>" title="FL" onclick="switchClarityChoice(<?php echo $rr['id']; ?>, 'FL')">FL</span>
<span class="clarity-switch-btn<?php echo $crr_clarity_IF_Chosen ?>" title="IF" onclick="switchClarityChoice(<?php echo $rr['id']; ?>, 'IF')">IF</span>
<span class="clarity-switch-btn<?php echo $crr_clarity_VVS1_Chosen ?>" title="VVS1" onclick="switchClarityChoice(<?php echo $rr['id']; ?>, 'VVS1')">VVS1</span>
<span class="clarity-switch-btn<?php echo $crr_clarity_VVS2_Chosen ?>" title="VVS2" onclick="switchClarityChoice(<?php echo $rr['id']; ?>, 'VVS2')">VVS2</span>
<span class="clarity-switch-btn<?php echo $crr_clarity_VS1_Chosen ?>" title="VS1" onclick="switchClarityChoice(<?php echo $rr['id']; ?>, 'VS1')">VS1</span>
<span class="clarity-switch-btn<?php echo $crr_clarity_VS2_Chosen ?>" title="VS2" onclick="switchClarityChoice(<?php echo $rr['id']; ?>, 'VS2')">VS2</span>
<span class="clarity-switch-btn<?php echo $crr_clarity_SI1_Chosen ?>" title="SI1" onclick="switchClarityChoice(<?php echo $rr['id']; ?>, 'SI1')">SI1</span>
<span class="clarity-switch-btn<?php echo $crr_clarity_SI2_Chosen ?>" title="SI2" onclick="switchClarityChoice(<?php echo $rr['id']; ?>, 'SI2')">SI2</span>

</div><!-- end claritychoicebox -->
</div><!-- end theouterbox-clarity -->








<div class="theouterbox-cut"><label>切工：</label>
<?php
$crr_cut_choice_raw=$rr['cut'];
$crr_cut_choice_array=array();
$crr_cut_choice_array=explode(',',$crr_cut_choice_raw);
$crr_cut_EX_Chosen='';
$crr_cut_VG_Chosen='';
$crr_cut_G_Chosen='';
$crr_cut_F_Chosen='';

if(in_array("EX", $crr_cut_choice_array)){
	$crr_cut_EX_Chosen=' chosen';
}
if(in_array("VG", $crr_cut_choice_array)){
	$crr_cut_VG_Chosen=' chosen';
}
if(in_array("G", $crr_cut_choice_array)){
	$crr_cut_G_Chosen=' chosen';
}
if(in_array("F", $crr_cut_choice_array)){
	$crr_cut_F_Chosen=' chosen';
}

?>
<div class="cutchoicebox cutchoicebox_<?php echo $rr['id']; ?>">

<span class="cut-switch-btn<?php echo $crr_cut_EX_Chosen; ?>" title="EX" onclick="switchCutChoice(<?php echo $rr['id']; ?>, 'EX')">EX</span>
<span class="cut-switch-btn<?php echo $crr_cut_VG_Chosen; ?>" title="VG" onclick="switchCutChoice(<?php echo $rr['id']; ?>, 'VG')">VG</span>
<span class="cut-switch-btn<?php echo $crr_cut_G_Chosen; ?>" title="G" onclick="switchCutChoice(<?php echo $rr['id']; ?>, 'G')">G</span>
<span class="cut-switch-btn<?php echo $crr_cut_F_Chosen; ?>" title="F" onclick="switchCutChoice(<?php echo $rr['id']; ?>, 'F')">F</span>

</div><!-- end claritychoicebox -->
</div><!-- end theouterbox-clarity -->


<div class="theouterbox-polish"><label>抛光：</label>
<?php
$crr_polish_choice_raw=$rr['polish'];
$crr_polish_choice_array=array();
$crr_polish_choice_array=explode(',',$crr_polish_choice_raw);
$crr_polish_EX_Chosen='';
$crr_polish_VG_Chosen='';
$crr_polish_G_Chosen='';
$crr_polish_F_Chosen='';

if(in_array("EX", $crr_polish_choice_array)){
	$crr_polish_EX_Chosen=' chosen';
}
if(in_array("VG", $crr_polish_choice_array)){
	$crr_polish_VG_Chosen=' chosen';
}
if(in_array("G", $crr_polish_choice_array)){
	$crr_polish_G_Chosen=' chosen';
}
if(in_array("F", $crr_polish_choice_array)){
	$crr_polish_F_Chosen=' chosen';
}

?>
<div class="polishchoicebox polishchoicebox_<?php echo $rr['id']; ?>">

<span class="polish-switch-btn<?php echo $crr_polish_EX_Chosen; ?>" title="EX" onclick="switchPolishChoice(<?php echo $rr['id']; ?>, 'EX')">EX</span>
<span class="polish-switch-btn<?php echo $crr_polish_VG_Chosen; ?>" title="VG" onclick="switchPolishChoice(<?php echo $rr['id']; ?>, 'VG')">VG</span>
<span class="polish-switch-btn<?php echo $crr_polish_G_Chosen; ?>" title="G" onclick="switchPolishChoice(<?php echo $rr['id']; ?>, 'G')">G</span>
<span class="polish-switch-btn<?php echo $crr_polish_F_Chosen; ?>" title="F" onclick="switchPolishChoice(<?php echo $rr['id']; ?>, 'F')">F</span>

</div><!-- end claritychoicebox -->
</div><!-- end theouterbox-clarity -->

<div class="theouterbox-symmetry"><label>对称性：</label>
<?php
$crr_symmetry_choice_raw=$rr['symmetry'];
$crr_symmetry_choice_array=array();
$crr_symmetry_choice_array=explode(',',$crr_symmetry_choice_raw);
$crr_symmetry_EX_Chosen='';
$crr_symmetry_VG_Chosen='';
$crr_symmetry_G_Chosen='';
$crr_symmetry_F_Chosen='';

if(in_array("EX", $crr_symmetry_choice_array)){
	$crr_symmetry_EX_Chosen=' chosen';
}
if(in_array("VG", $crr_symmetry_choice_array)){
	$crr_symmetry_VG_Chosen=' chosen';
}
if(in_array("G", $crr_symmetry_choice_array)){
	$crr_symmetry_G_Chosen=' chosen';
}
if(in_array("F", $crr_symmetry_choice_array)){
	$crr_symmetry_F_Chosen=' chosen';
}

?>
<div class="symmetrychoicebox symmetrychoicebox_<?php echo $rr['id']; ?>">

<span class="symmetry-switch-btn<?php echo $crr_symmetry_EX_Chosen; ?>" title="EX" onclick="switchSymmetryChoice(<?php echo $rr['id']; ?>, 'EX')">EX</span>
<span class="symmetry-switch-btn<?php echo $crr_symmetry_VG_Chosen; ?>" title="VG" onclick="switchSymmetryChoice(<?php echo $rr['id']; ?>, 'VG')">VG</span>
<span class="symmetry-switch-btn<?php echo $crr_symmetry_G_Chosen; ?>" title="G" onclick="switchSymmetryChoice(<?php echo $rr['id']; ?>, 'G')">G</span>
<span class="symmetry-switch-btn<?php echo $crr_symmetry_F_Chosen; ?>" title="F" onclick="switchSymmetryChoice(<?php echo $rr['id']; ?>, 'F')">F</span>

</div><!-- end claritychoicebox -->
</div><!-- end theouterbox-clarity -->


<div class="theouterbox-certificate"><label>证书：</label>
<?php
$crr_certificate_choice_raw=$rr['certificate'];
$crr_certificate_choice_array=array();
$crr_certificate_choice_array=explode(',',$crr_certificate_choice_raw);
$crr_certificate_GIA_Chosen='';
$crr_certificate_IGI_Chosen='';
$crr_certificate_HRD_Chosen='';


if(in_array("GIA", $crr_certificate_choice_array)){
	$crr_certificate_GIA_Chosen=' chosen';
}
if(in_array("IGI", $crr_certificate_choice_array)){
	$crr_certificate_IGI_Chosen=' chosen';
}
if(in_array("HRD", $crr_certificate_choice_array)){
	$crr_certificate_HRD_Chosen=' chosen';
}
?>
<div class="certificatechoicebox certificatechoicebox_<?php echo $rr['id']; ?>">

<span class="certificate-switch-btn<?php echo $crr_certificate_GIA_Chosen; ?>" title="GIA" onclick="switchCertificateChoice(<?php echo $rr['id']; ?>, 'GIA')">GIA</span>
<span class="certificate-switch-btn<?php echo $crr_certificate_HRD_Chosen; ?>" title="HRD" onclick="switchCertificateChoice(<?php echo $rr['id']; ?>, 'HRD')">HRD</span>
<span class="certificate-switch-btn<?php echo $crr_certificate_IGI_Chosen; ?>" title="IGI" onclick="switchCertificateChoice(<?php echo $rr['id']; ?>, 'IGI')">IGI</span>

</div><!-- end claritychoicebox -->
</div><!-- end theouterbox-clarity -->

<div class="theouterbox-fluo"><label>荧光：</label>
<?php
$crr_fluo_choice_raw=$rr['fluo'];
$crr_fluo_choice_array=array();
$crr_fluo_choice_array=explode(',',$crr_fluo_choice_raw);
$crr_fluo_VST_Chosen='';
$crr_fluo_ST_Chosen='';
$crr_fluo_M_Chosen='';
$crr_fluo_SL_Chosen='';
$crr_fluo_F_Chosen='';
$crr_fluo_VSL_Chosen='';
$crr_fluo_NONE_Chosen='';



if(in_array("Very Strong", $crr_fluo_choice_array)){
	$crr_fluo_VST_Chosen=' chosen';
}
if(in_array("Strong", $crr_fluo_choice_array)){
	$crr_fluo_ST_Chosen=' chosen';
}
if(in_array("Medium", $crr_fluo_choice_array)){
	$crr_fluo_M_Chosen=' chosen';
}
if(in_array("Slight", $crr_fluo_choice_array)){
	$crr_fluo_SL_Chosen=' chosen';
}
if(in_array("Faint", $crr_fluo_choice_array)){
	$crr_fluo_F_Chosen=' chosen';
}
if(in_array("Very Slight", $crr_fluo_choice_array)){
	$crr_fluo_VSL_Chosen=' chosen';
}
if(in_array("None", $crr_fluo_choice_array)){
	$crr_fluo_NONE_Chosen=' chosen';
}
?>
<div class="fluochoicebox fluochoicebox_<?php echo $rr['id']; ?>">

<span class="fluo-switch-btn<?php echo $crr_fluo_VST_Chosen; ?>" title="Very Strong" onclick="switchFluoChoice(<?php echo $rr['id']; ?>, 'Very Strong')">Very Strong</span>
<span class="fluo-switch-btn<?php echo $crr_fluo_ST_Chosen; ?>" title="Strong" onclick="switchFluoChoice(<?php echo $rr['id']; ?>, 'Strong')">Strong</span>
<span class="fluo-switch-btn<?php echo $crr_fluo_M_Chosen; ?>" title="Medium" onclick="switchFluoChoice(<?php echo $rr['id']; ?>, 'Medium')">Medium</span>
<span class="fluo-switch-btn<?php echo $crr_fluo_SL_Chosen; ?>" title="Slight" onclick="switchFluoChoice(<?php echo $rr['id']; ?>, 'Slight')">Slight</span>
<span class="fluo-switch-btn<?php echo $crr_fluo_F_Chosen; ?>" title="Faint" onclick="switchFluoChoice(<?php echo $rr['id']; ?>, 'Faint')">Faint</span>
<span class="fluo-switch-btn<?php echo $crr_fluo_VSL_Chosen; ?>" title="Very Slight" onclick="switchFluoChoice(<?php echo $rr['id']; ?>, 'Very Slight')">Very Slight</span>
<span class="fluo-switch-btn<?php echo $crr_fluo_NONE_Chosen; ?>" title="None" onclick="switchFluoChoice(<?php echo $rr['id']; ?>, 'None')">None</span>

</div><!-- end claritychoicebox -->
</div><!-- end theouterbox-clarity -->











</div><!-- end conditionbox -->


<p class="the-price-para-box">
<label class="title">价格系数</label> <input type="text" id="para-for-condition-<?php echo $rr['id']; ?>" class="price-para" value="<?php echo $rr['the_para_value'] ?>" />
</p>

<button id="modifyrules-<?php echo $rr['id']; ?>" class="modifyrulesbtn" onclick="updateRule(<?php echo $rr['id']; ?>)">保存更改</button>
<button id="deleterules-<?php echo $rr['id']; ?>" class="deleterulesbtn" onclick="deleteRule(<?php echo $rr['id']; ?>)">删除规则</button>
</li>
<?php
}}
?>  
  </ul><!-- end existingrules -->
  
  <p style="font-size:12px; padding-left:20px; margin-bottom:35px;"><span style="color:#F00;">注：</span>越靠下面的规则优先级越高。比如同时符合第三条和第四条规则，以第四条的价格参数为准。</p>
</div><!-- end conditionbox -->




<div id="createconditionbox">
<h3>增加新规则</h3>
<div class="newrulecontainer">
<p class="title">符合条件：</p>


<div class="conditionsbox">



<div class="theouterbox-shape"><label>形状：</label>
<div class="shapechoicebox shapechoicebox_new">

<span class="shape-switch-btn" title="BR" onclick="switchShapeChoice('new', 'BR')"><img class="shapeicon" src="/images/site_elements/icons/01.gif" /></span>
<span class="shape-switch-btn" title="PS" onclick="switchShapeChoice('new', 'PS')"><img class="shapeicon" src="/images/site_elements/icons/02.gif" /></span>
<span class="shape-switch-btn" title="PR" onclick="switchShapeChoice('new', 'PR')"><img class="shapeicon" src="/images/site_elements/icons/03.gif" /></span>
<span class="shape-switch-btn" title="HS" onclick="switchShapeChoice('new', 'HS')"><img class="shapeicon" src="/images/site_elements/icons/08.gif" /></span>
<span class="shape-switch-btn" title="MQ" onclick="switchShapeChoice('new', 'MQ')"><img class="shapeicon" src="/images/site_elements/icons/05.gif" /></span>
<span class="shape-switch-btn" title="OV" onclick="switchShapeChoice('new', 'OV')"><img class="shapeicon" src="/images/site_elements/icons/11.gif" /></span>
<span class="shape-switch-btn" title="EM" onclick="switchShapeChoice('new', 'EM')"><img class="shapeicon" src="/images/site_elements/icons/10.gif" /></span>
<span class="shape-switch-btn" title="RAD" onclick="switchShapeChoice('new', 'RAD')"><img class="shapeicon" src="/images/site_elements/icons/06.gif" /></span>
<span class="shape-switch-btn" title="CU" onclick="switchShapeChoice('new', 'CU')"><img class="shapeicon" src="/images/site_elements/icons/12.gif" /></span>
</div><!-- end shapechoicebox -->
</div><!-- END theouterbox-shape -->




<p class="weightchoice-box"><label>重量：</label> <input id="weightfrom_for_new" class="weightfromvalue emph" type="text" value="" /> - <input id="weightto_for_new" class="weighttovalue emph" type="text" value="" /> ct</p>

<div class="theouterbox-color"><label>颜色：</label>
<div class="colorchoicebox colorchoicebox_new">

<span class="color-switch-btn" title="D" onclick="switchColorChoice('new', 'D')">D</span>
<span class="color-switch-btn" title="E" onclick="switchColorChoice('new', 'E')">E</span>
<span class="color-switch-btn" title="F" onclick="switchColorChoice('new', 'F')">F</span>
<span class="color-switch-btn" title="G" onclick="switchColorChoice('new', 'G')">G</span>
<span class="color-switch-btn" title="H" onclick="switchColorChoice('new', 'H')">H</span>
<span class="color-switch-btn" title="I" onclick="switchColorChoice('new', 'I')">I</span>
<span class="color-switch-btn" title="J" onclick="switchColorChoice('new', 'J')">J</span>
<span class="color-switch-btn" title="K" onclick="switchColorChoice('new', 'K')">K</span>
<span class="color-switch-btn" title="L" onclick="switchColorChoice('new', 'L')">L</span>
<span class="color-switch-btn" title="M" onclick="switchColorChoice('new', 'M')">M</span>


</div><!-- end colorchoicebox -->
</div><!-- END theouterbox-color -->



<div class="theouterbox-clarity"><label>净度：</label>
<div class="claritychoicebox claritychoicebox_new">

<span class="clarity-switch-btn" title="FL" onclick="switchClarityChoice('new', 'FL')">FL</span>
<span class="clarity-switch-btn" title="IF" onclick="switchClarityChoice('new', 'IF')">IF</span>
<span class="clarity-switch-btn" title="VVS1" onclick="switchClarityChoice('new', 'VVS1')">VVS1</span>
<span class="clarity-switch-btn" title="VVS2" onclick="switchClarityChoice('new', 'VVS2')">VVS2</span>
<span class="clarity-switch-btn" title="VS1" onclick="switchClarityChoice('new', 'VS1')">VS1</span>
<span class="clarity-switch-btn" title="VS2" onclick="switchClarityChoice('new', 'VS2')">VS2</span>
<span class="clarity-switch-btn" title="SI1" onclick="switchClarityChoice('new', 'SI1')">SI1</span>
<span class="clarity-switch-btn" title="SI2" onclick="switchClarityChoice('new', 'SI2')">SI2</span>


</div><!-- end claritychoicebox -->
</div><!-- end theouterbox-clarity -->




<div class="theouterbox-cut"><label>切工：</label>
<div class="cutchoicebox cutchoicebox_new">

<span class="cut-switch-btn" title="EX" onclick="switchCutChoice('new', 'EX')">EX</span>
<span class="cut-switch-btn" title="VG" onclick="switchCutChoice('new', 'VG')">VG</span>
<span class="cut-switch-btn" title="G" onclick="switchCutChoice('new', 'G')">G</span>
<span class="cut-switch-btn" title="F" onclick="switchCutChoice('new', 'F')">F</span>

</div><!-- end claritychoicebox -->
</div><!-- end theouterbox-clarity -->


<div class="theouterbox-polish"><label>抛光：</label>
<div class="polishchoicebox polishchoicebox_new">

<span class="polish-switch-btn" title="EX" onclick="switchPolishChoice('new', 'EX')">EX</span>
<span class="polish-switch-btn" title="VG" onclick="switchPolishChoice('new', 'VG')">VG</span>
<span class="polish-switch-btn" title="G" onclick="switchPolishChoice('new', 'G')">G</span>
<span class="polish-switch-btn" title="F" onclick="switchPolishChoice('new', 'F')">F</span>

</div><!-- end claritychoicebox -->
</div><!-- end theouterbox-clarity -->

<div class="theouterbox-symmetry"><label>对称性：</label>
<div class="symmetrychoicebox symmetrychoicebox_new">

<span class="symmetry-switch-btn" title="EX" onclick="switchSymmetryChoice('new', 'EX')">EX</span>
<span class="symmetry-switch-btn" title="VG" onclick="switchSymmetryChoice('new', 'VG')">VG</span>
<span class="symmetry-switch-btn" title="G" onclick="switchSymmetryChoice('new', 'G')">G</span>
<span class="symmetry-switch-btn" title="F" onclick="switchSymmetryChoice('new', 'F')">F</span>

</div><!-- end claritychoicebox -->
</div><!-- end theouterbox-clarity -->


<div class="theouterbox-certificate"><label>证书：</label>
<div class="certificatechoicebox certificatechoicebox_new">

<span class="certificate-switch-btn" title="GIA" onclick="switchCertificateChoice('new', 'GIA')">GIA</span>
<span class="certificate-switch-btn" title="HRD" onclick="switchCertificateChoice('new', 'HRD')">HRD</span>
<span class="certificate-switch-btn" title="IGI" onclick="switchCertificateChoice('new', 'IGI')">IGI</span>

</div><!-- end claritychoicebox -->
</div><!-- end theouterbox-clarity -->

<div class="theouterbox-fluo"><label>荧光：</label>
<div class="fluochoicebox fluochoicebox_new">

<span class="fluo-switch-btn" title="Very Strong" onclick="switchFluoChoice('new', 'Very Strong')">Very Strong</span>
<span class="fluo-switch-btn" title="Strong" onclick="switchFluoChoice('new', 'Strong')">Strong</span>
<span class="fluo-switch-btn" title="Medium" onclick="switchFluoChoice('new', 'Medium')">Medium</span>
<span class="fluo-switch-btn" title="Slight" onclick="switchFluoChoice('new', 'Slight')">Slight</span>
<span class="fluo-switch-btn" title="Faint" onclick="switchFluoChoice('new', 'Faint')">Faint</span>
<span class="fluo-switch-btn" title="Very Slight" onclick="switchFluoChoice('new', 'Very Slight')">Very Slight</span>
<span class="fluo-switch-btn" title="None" onclick="switchFluoChoice('new', 'None')">None</span>

</div><!-- end claritychoicebox -->
</div><!-- end theouterbox-clarity -->






</div><!-- end conditionbox -->


<p class="the-price-para-box">
<label class="title">价格系数</label> <input type="text" id="para-for-condition-new" class="price-para" value="" />
</p>

<button id="modifyrules-new" class="modifyrulesbtn" onclick="updateRule('new')" style="background-color:#C9F;">保存规则</button>

</div>
</div>

<div id="updatingdatabtnbox" style="margin:120px 0 0 0; padding:15px;">
<button id="update_data_btn" target="_blank" onclick="updatedata()">刷新数据</button>
<p style="font-size:12px; padding-left:0px; margin-bottom:35px;"><span style="color:#F00;">注：</span>制定新规则以后要点击刷新数据才能生效</p>
</div>

</div>






<div><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /></div>

</body>
</html>