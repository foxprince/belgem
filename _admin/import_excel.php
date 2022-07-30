<?php
/*===================session========================*/
session_start();

require_once ('../cn/includes/header_ele.php');

$username=$_SESSION['username'];
$account_level=$_SESSION['account_level'];



$new_file_uploaded=false;




// #######################################################
//examine the uploaded file
// #######################################################
if(isset($_POST['thefilebutton'])){
try {
    
    // Undefined | Multiple Files | $_FILES Corruption Attack
    // If this request falls under any of them, treat it invalid.
    if (
        !isset($_FILES['upfile']['error']) ||
        is_array($_FILES['upfile']['error'])
    ) {
        throw new RuntimeException('Invalid parameters.');
    }

    // Check $_FILES['upfile']['error'] value.
    switch ($_FILES['upfile']['error']) {
        case UPLOAD_ERR_OK:
            break;
        case UPLOAD_ERR_NO_FILE:
            throw new RuntimeException('No file sent.');
        case UPLOAD_ERR_INI_SIZE:
        case UPLOAD_ERR_FORM_SIZE:
            throw new RuntimeException('Exceeded filesize limit.');
        default:
            throw new RuntimeException('Unknown errors.');
    }

    // You should also check filesize here. 
    if ($_FILES['upfile']['size'] > 16000000) {
        throw new RuntimeException('Exceeded filesize limit check.');
    }


    // You should name it uniquely.
    // DO NOT USE $_FILES['upfile']['name'] WITHOUT ANY VALIDATION !!
    // On this example, obtain safe unique name from its binary data.
    if (!move_uploaded_file(
        $_FILES['upfile']['tmp_name'],
        'excelfile/file.xls'
    )) {
        throw new RuntimeException('Failed to move uploaded file.');
    }

    //echo 'File is uploaded successfully.';
	//savethenewdata();
	//verifythedata();
	$new_file_uploaded=true;

} catch (RuntimeException $e) {
	echo $e;
    echo $e->getMessage();

}
//exit('ok');
}











if(!isset($_SESSION['col_stock_ref']) || $new_file_uploaded){
	$_SESSION['col_stock_ref']=-8;//----------------------1
}
if(!isset($_SESSION['col_shape']) || $new_file_uploaded){	
	$_SESSION['col_shape']=-8;//----------------------|||2
}
if(!isset($_SESSION['col_carat']) || $new_file_uploaded){
	$_SESSION['col_carat']=-8;//----------------------3
}//
if(!isset($_SESSION['col_color']) || $new_file_uploaded){
	$_SESSION['col_color']=-8;//----------------------4
}//
if(!isset($_SESSION['col_clarity']) || $new_file_uploaded){
	$_SESSION['col_clarity']=-8;//----------------------5
}//
if(!isset($_SESSION['col_grading_lab']) || $new_file_uploaded){
	$_SESSION['col_grading_lab']=-8;//----------------------6
}//
if(!isset($_SESSION['col_certificate_number']) || $new_file_uploaded){
	$_SESSION['col_certificate_number']=-8;//----------------------7
}//
if(!isset($_SESSION['col_cut_grade']) || $new_file_uploaded){
	$_SESSION['col_cut_grade']=-8;//----------------------8
}//
if(!isset($_SESSION['col_polish']) || $new_file_uploaded){
	$_SESSION['col_polish']=-8;//----------------------9
}//
if(!isset($_SESSION['col_symmetry']) || $new_file_uploaded){
	$_SESSION['col_symmetry']=-8;//----------------------10
}//
if(!isset($_SESSION['col_fluorescence_intensity']) || $new_file_uploaded){
	$_SESSION['col_fluorescence_intensity']=-8;//----------------------11
}//
if(!isset($_SESSION['col_percentage']) || $new_file_uploaded){
	$_SESSION['col_percentage']=-8;//----------------------12
}//
if(!isset($_SESSION['col_fancy_price']) || $new_file_uploaded){
	$_SESSION['col_fancy_price']=-8;//----------------------13
}
if(!isset($_SESSION['col_raw_price_total']) || $new_file_uploaded){
	$_SESSION['col_raw_price_total']=-8;//----------------------14
}//



if(isset($_POST['label-shape'])){
	$_SESSION['col_shape']=$_POST['label-shape'];//1
}
if(isset($_POST['label-carat'])){
	$_SESSION['col_carat']=$_POST['label-carat'];//2
}
if(isset($_POST['label-color'])){
	$_SESSION['col_color']=$_POST['label-color'];//3
	}
if(isset($_POST['label-clarity'])){
	$_SESSION['col_clarity']=$_POST['label-clarity'];//4
}
if(isset($_POST['label-grading_lab'])){
	$_SESSION['col_grading_lab']=$_POST['label-grading_lab'];//5
}
if(isset($_POST['label-certificate_number'])){
	$_SESSION['col_certificate_number']=$_POST['label-certificate_number'];//6
}
if(isset($_POST['label-cut_grade'])){
	$_SESSION['col_cut_grade']=$_POST['label-cut_grade'];//7
}
if(isset($_POST['label-polish'])){
	$_SESSION['col_polish']=$_POST['label-polish'];//8
}
if(isset($_POST['label-symmetry'])){
	$_SESSION['col_symmetry']=$_POST['label-symmetry'];//11
}
if(isset($_POST['label-fluorescence_intensity'])){
	$_SESSION['col_fluorescence_intensity']=$_POST['label-fluorescence_intensity'];//9
}	
if(isset($_POST['label-percentage'])){
	$_SESSION['col_percentage']=$_POST['label-percentage'];//10
}	
if(isset($_POST['label-therawprice'])){
	$_SESSION['col_fancy_price']=$_POST['label-therawprice'];//12
}	
if(isset($_POST['label-raw_price_total'])){
	$_SESSION['col_raw_price_total']=$_POST['label-raw_price_total'];//13
}
	
		

$all_label_found=true;
?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>利美珠宝::excel数据导入</title>
<link rel="stylesheet" href="adminstyle.css">
<style type="text/css">
body{
	font-family:'Microsoft Yahei', 微软雅黑, STHeiti, simsun, Arial, sans-serif;
	font-size:14px;
	font-weight:100;
}

td{
	border-style:solid;
	border-width:1px;
	border-color:#09F;
	font-size:14px;
	text-align:center;
	vertical-align:middle;
	padding:3px;
	background-color:#FFF;
}
#table-title td{
	padding:7px;
	background-color:#0CF;
	color:#000;
	font-size:16px;
	font-weight:bold;
}
#moreindi td{
	padding:7px 0 15px 0;
}

#thefeedbackbox{
	color:#06F;
	font-size:16px;
}
div#processed{
	position:relative;
	width:450px;
	padding:18px;
	border-style:solid;
	border-width:3px;
	border-color:#09F;
	text-align:center;
	color:#000;
	z-index:0;
}
#message_bg{
	position:absolute;
	top:0;
	left:0;
	height:100%;
	width:0;
	background-color:#0CF;
	z-index:-1;
	margin:0;
}
#thefeedbackbox h4{
	font-size:24px;
	font-weight:bold;
}
#finimessage{
	display:none;
}
#additional-message2, #additional-errormessage{
	display:none;
}
p.label-choosing-para{
	padding:12px;
	border-style:solid;
	border-width:1px;
	border-color:#F00;
	width: 500px;
}
</style>
<script src="/js/jquery-1.11.2.min.js"></script>
</head>

<body>

<?php
include('navi.php');

?>


<div id="maincontent" style="padding-bottom:50px;">



<?php 
if(isset($_POST['confirmed']) && $_POST['confirmed']=="YES"){
?>

<div id="thefeedbackbox">
<h4 id="finimessage">数据已全部处理完成。</h4>
<div id="processed">
<img id="working_indi" style="position:absolute; height:45px; left:55px; top:5px;" src="../images/icon_loading.gif" /><span id="fini-message"> &nbsp; ... &nbsp; </span>
<p id="message_bg"></p>
</div>

--
<p id="additional-message">正在处理数据... 预计等待时间：<span id="waitingtimer" style="font-size:16px; color:#F00;">60</span>秒</p>
<p id="additional-message2"></p>
<p id="additional-errormessage">!注意:导入结果中有 <span id="errorednum">0</span> 条纪录中切工、抛光或对称性数值存在错误：数值缺失或参数不正确。</p>
</div>

<div id="fb_container" style="display:none;"></div>
<div id="fb_status_container" style="display:none;"></div>

<script type="text/javascript">
var $crr_turn=0;//to note how many times checking updating status
var $total_row=0;
var $fini_confirmed=false;//this is true when the proceedthedata() returns positive value, otherwise it means busy updating.
var t=0;//for settimeout
var tt=0;//for settimeout timer
var $total_waiting_seconds=60;

$(document).ready(function(){
	proceedthedata();
	waitingIimerIndi();
});

function proceedthedata(){
	console.log('******************** main updating request sent *******************');
	$.post( "save_excel_data.php", 
	{ confirmed: "YES", crr_turn: $crr_turn }, 
	function( data ) {
	    console.log('****************** main updating feedback returns *********************');
		
		$('#fb_container').html(data);
		
		var messagemain=$('#fb_container').children('p#messagemain').html();
		if(messagemain!='fini'){
			alert('未知错误');
		}else{
			$fini_confirmed=true;
			//$('h4#finimessage').fadeIn('fast');
			$('img#working_indi').fadeOut('fast');
			$('#message_bg').css('width', '100%');
			$('#additional-message').html($('#fb_container').children('p#fmessage').html());
			$('#fini-message').html('数据处理全部完成');
			clearTimeout(t);
			clearTimeout(tt);
			return;
		}
		
	}).fail(function(){
		console.log(' ******************** error ***********************');
		alert('读取数据出现未知错误，请重试');
	});
	
	checkImportStatus();
}


function checkImportStatus(){
	$crr_turn++;
	$.post( "import_status.php", 
	{ check: "YES" }, 
	function( data ) {
	    console.log($crr_turn+' -return');
		console.log(data);
		
		$('#fb_status_container').html(data);
		
		
		$total_row=parseInt($('#fb_status_container').children('p#totalrecords').html());
		var totalproceeded=parseInt($('#fb_status_container').children('p#proceeded').html());
		var crr_percent=Math.round(totalproceeded/$total_row*100);		
		var crr_fb_message=$('#fb_container').children('p#fmessage').html();
		var crr_added=parseInt($('#fb_status_container').children('p#added').html());
		
		var crr_skipped=parseInt($('#fb_status_container').children('p#ignored').html());
		
		$('#message_bg').css('width', crr_percent+'%');
		$('#num_proccessed').html(totalproceeded);
		
		$('#additional-message2').prepend(crr_fb_message);
		
		if($('#additional-message2').html()!=''){
			$('#additional-message2').fadeIn('fast');
		}
		
		
		if(!$fini_confirmed){
			t=setTimeout('checkImportStatus()',500);
		}else{
			clearTimeout(t);
		}
	}).fail(function(){
		console.log($crr_turn+' ******************** error reading status ***********************');
		if(!$fini_confirmed){
			t=setTimeout('checkImportStatus()',500);
		}else{
			clearTimeout(t);
		}
	});
}


function waitingIimerIndi(){
	if($total_waiting_seconds>0){
		$total_waiting_seconds=$total_waiting_seconds-0.1;
	}else{
		$total_waiting_seconds=25;
	}
	$('#waitingtimer').html($total_waiting_seconds.toFixed(2));
	if(!$fini_confirmed){
		tt=setTimeout('waitingIimerIndi()',100);
	}else{
		clearTimeout(tt);
	}
}
</script>


<?php 
} 
?>

<div style="margin-top:35px;">
<form action="" method="post" enctype="multipart/form-data" id="excelform">
<label style="font-size:18px; font-weight:bold;">上传EXCEL文档：</label><br />
<p style="display:inline-block; width:400px; border-style:solid; border-width:3px; border-color:#0CF; padding:20px;">
<input type="file" name="upfile" />
<input type="hidden" name="thefilebutton" />
</p>
<button type="button" id="exceluploadbtn" onclick="excelupload()" style="font-size:18px; background-color:#06F; padding:15px 68px; border-width:1px; color:#FFF;">上传</button>
</form>
<script type="text/javascript">
function excelupload(){	
	$('#excelform').submit();
	$('#exceluploadbtn').attr('disabled','disabled');
	$('#exceluploadbtn').html('上传中...');
	console.log('uppppppp');
}
</script>


</div>

<?php
if(($new_file_uploaded || $_SESSION['col_stock_ref']>0) && !isset($_POST['confirmed'])){
	require_once 'excelreader/excel_reader2.php';
    $data = new Spreadsheet_Excel_Reader("excelfile/file.xls");

//####################################################################################################
//####################################################################################################	
//#####################################自动寻找正确的列代码块#############################################	
//####################################################################################################
//####################################################################################################


//#############################********************###################################
//第一步，找到标题行 $row_label
$row_label=0;
$stock_ref_label_found=false;
$total_cols=$data->colcount();

for ($i = 1; $i <= 8; $i++) {
	if(!$stock_ref_label_found){
		$row_label=$i;
		for ($ii=1; $ii<=5; $ii++){
			$searchforRow_LabelofLotID=trim(strtolower($data->val($i,$ii)));
			
			//echo "第".$i."行，第".$ii.'列：'.$searchforRow_LabelofLotID.' ----- <br>';
			
			if((strpos($searchforRow_LabelofLotID,'stock id') !== false)||(strpos($searchforRow_LabelofLotID,'lotid') !== false) || (strpos($searchforRow_LabelofLotID,'lot id') !== false) || ((strpos($searchforRow_LabelofLotID,'stock') !== false) && (strpos($searchforRow_LabelofLotID,'ref') !== false))){
				$stock_ref_label_found=true;
				if(isset($_SESSION['authenticated'])){
					$_SESSION['col_stock_ref']=$ii;
				}else{
					exit('error: session expired!');
				}
				break;
			}
		}
	}else{
		break;
	}
}


if($stock_ref_label_found){
	for($iii = 1; $iii<=$total_cols; $iii++){
		$crr_label=trim(strtolower($data->val($row_label,$iii)));
		//$crr_label_raw=$data->raw($row_label,$iii); non-number values, if use raw function, returns empty value. so mush use val() function.
		if((strpos($crr_label,'shape') !== false)||(strpos($crr_label,'shp') !== false)){
				$_SESSION['col_shape']=$iii;//----------------------
		}else if((strpos($crr_label,'weight') !== false) || strpos($crr_label,'carat') !== false || strpos($crr_label,'crt.') !== false){
				$_SESSION['col_carat']=$iii;//----------------------			
		}else if((strpos($crr_label,'lab') !== false)){
				$_SESSION['col_grading_lab']=$iii;//----------------------
		}else if((strpos($crr_label,'color') !== false||strpos($crr_label,'col') !== false) ){
				$_SESSION['col_color']=$iii;//----------------------
		}else if((strpos($crr_label,'clarity') !== false||strpos($crr_label,'cla') !== false)){
				$_SESSION['col_clarity']=$iii;//----------------------
		}else if((strpos($crr_label,'cut') !== false)){
				$_SESSION['col_cut_grade']=$iii;//----------------------//
		}else if((strpos($crr_label,'polish') !== false||strpos($crr_label,'pol') !== false)){
				$_SESSION['col_polish']=$iii;//----------------------//
		}else if((strpos($crr_label,'symmetry') !== false)){
				$_SESSION['col_symmetry']=$iii;//----------------------//
		}else if((strpos($crr_label,'fluo') !== false)){
				$_SESSION['col_fluorescence_intensity']=$iii;//----------------------//
		}else if($crr_label=='list') {
			$_SESSION['col_raw_price_total']=$iii;
		}else if($crr_label=='back -%') {
			$_SESSION['col_percentage']=$iii;
		}else if($crr_label=='sym') {
			$_SESSION['col_symmetry']=$iii;
		}else if(strpos($crr_label,'msp total') !== false){
				$_SESSION['col_fancy_price']=$iii;//----------------------//
		}
		/*else if((strpos($crr_label,'list') !== false) ){
				$_SESSION['col_raw_price_total']=$iii;//----------------------//
		}else if((strpos($crr_label,'back') !== false)){
				$_SESSION['col_percentage']=$iii;//----------------------//
		}*/
		else if(strpos($crr_label,'certificate no') !== false|| strpos($crr_label,'certi') !== false || strpos($crr_label,'cert. no') !== false){
				$_SESSION['col_certificate_number']=$iii;//----------------------
		}
	}
?>
<form action="" method="post" id="labelchoosing-form">
<?php
###############################################
###############################################
###############################################
if($_SESSION['col_shape']<0){
	$all_label_found=false;
?>
<p class="label-choosing-para">
形状(shape)：
<select name="label-shape">
<option value="-">请选择：</option>
<?php
for($iiii = 1; $iiii<=$total_cols; $iiii++){
	$crr_label=trim($data->val($row_label,$iiii));
?>
<option value="<?php echo $iiii; ?>"><?php echo $crr_label; ?></option>
<?php
}	
?>
</select>
</p>
<?php
}
###############################################
###############################################
###############################################

if($_SESSION['col_carat']<0){
	$all_label_found=false;
?>
<p class="label-choosing-para">
重量(carat)：
<select name="label-carat">
<option value="-">请选择：</option>
<?php
for($iiii = 1; $iiii<=$total_cols; $iiii++){
	$crr_label=trim($data->val($row_label,$iiii));
?>
<option value="<?php echo $iiii; ?>"><?php echo $crr_label; ?></option>
<?php
}	
?>
</select>
</p>
<?php
}
###############################################
###############################################
###############################################

if($_SESSION['col_grading_lab']<0){
	$all_label_found=false;
?>
<p class="label-choosing-para">
证书(grading lab)：
<select name="label-grading_lab">
<option value="-">请选择：</option>
<?php
for($iiii = 1; $iiii<=$total_cols; $iiii++){
	$crr_label=trim($data->val($row_label,$iiii));
?>
<option value="<?php echo $iiii; ?>"><?php echo $crr_label; ?></option>
<?php
}	
?>
</select>
</p>
<?php
}
if($_SESSION['col_certificate_number']<0){
	$all_label_found=false;
	?>
<p class="label-choosing-para">
证书编号：
<select name="label-certificate_number">
<option value="-">请选择：</option>
<?php
for($iiii = 1; $iiii<=$total_cols; $iiii++){
	$crr_label=trim($data->val($row_label,$iiii));
?>
<option value="<?php echo $iiii; ?>"><?php echo $crr_label; ?></option>
<?php
}	
?>
</select>
</p>
<?php
}
###############################################
###############################################
###############################################

if($_SESSION['col_color']<0){
	$all_label_found=false;
?>
<p class="label-choosing-para">
颜色(color)：
<select name="label-color">
<option value="-">请选择：</option>
<?php
for($iiii = 1; $iiii<=$total_cols; $iiii++){
	$crr_label=trim($data->val($row_label,$iiii));
?>
<option value="<?php echo $iiii; ?>"><?php echo $crr_label; ?></option>
<?php
}	
?>
</select>
</p>
<?php
}
###############################################
###############################################
###############################################

if($_SESSION['col_clarity']<0){
	$all_label_found=false;
?>
<p class="label-choosing-para">
净度(clarity)：
<select name="label-clarity">
<option value="-">请选择：</option>
<?php
for($iiii = 1; $iiii<=$total_cols; $iiii++){
	$crr_label=trim($data->val($row_label,$iiii));
?>
<option value="<?php echo $iiii; ?>"><?php echo $crr_label; ?></option>
<?php
}	
?>
</select>
</p>
<?php
}
###############################################
###############################################
###############################################

if($_SESSION['col_cut_grade']<0){
	$all_label_found=false;
?>
<p class="label-choosing-para">
切工(cut)：
<select name="label-cut_grade">
<option value="-">请选择：</option>
<?php
for($iiii = 1; $iiii<=$total_cols; $iiii++){
	$crr_label=trim($data->val($row_label,$iiii));
?>
<option value="<?php echo $iiii; ?>"><?php echo $crr_label; ?></option>
<?php
}	
?>
</select>
</p>
<?php
}
###############################################
###############################################
###############################################

if($_SESSION['col_polish']<0){
	$all_label_found=false;
?>
<p class="label-choosing-para">
抛光(polish)：
<select name="label-polish">
<option value="-">请选择：</option>
<?php
for($iiii = 1; $iiii<=$total_cols; $iiii++){
	$crr_label=trim($data->val($row_label,$iiii));
?>
<option value="<?php echo $iiii; ?>"><?php echo $crr_label; ?></option>
<?php
}	
?>
</select>
</p>
<?php
}
###############################################
###############################################
###############################################

if($_SESSION['col_symmetry']<0){
	$all_label_found=false;
?>
<p class="label-choosing-para">
对称性(symmetry)：
<select name="label-symmetry">
<option value="-">请选择：</option>
<?php
for($iiii = 1; $iiii<=$total_cols; $iiii++){
	$crr_label=trim($data->val($row_label,$iiii));
?>
<option value="<?php echo $iiii; ?>"><?php echo $crr_label; ?></option>
<?php
}	
?>
</select>
</p>
<?php
}
###############################################
###############################################
###############################################


if($_SESSION['col_fluorescence_intensity']<0){
	$all_label_found=false;
?>
<p class="label-choosing-para">
荧光(fluorescence intensity)：
<select name="label-fluorescence_intensity">
<option value="-">请选择：</option>
<?php
for($iiii = 1; $iiii<=$total_cols; $iiii++){
	$crr_label=trim($data->val($row_label,$iiii));
?>
<option value="<?php echo $iiii; ?>"><?php echo $crr_label; ?></option>
<?php
}	
?>
</select>
</p>
<?php
}
###############################################
###############################################
###############################################

if($_SESSION['col_raw_price_total']<0){
	$all_label_found=false;
?>
<p class="label-choosing-para">
原价无折扣：
<select name="label-raw_price_total">
<option value="-">请选择：</option>
<?php
for($iiii = 1; $iiii<=$total_cols; $iiii++){
	$crr_label=trim($data->raw($row_label,$iiii));
?>
<option value="<?php echo $iiii; ?>"><?php echo $crr_label; ?></option>
<?php
}	
?>
</select>
</p>
<?php
}
###############################################
###############################################
###############################################

if($_SESSION['col_percentage']<0){
	$all_label_found=false;
?>
<p class="label-choosing-para">
原有折扣：
<select name="label-percentage">
<option value="-">请选择：</option>
<?php
for($iiii_ori_discount = 1; $iiii_ori_discount<=$total_cols; $iiii_ori_discount++){
	$crr_label=trim($data->val($row_label,$iiii_ori_discount));
?>
<option value="<?php echo $iiii_ori_discount; ?>"><?php echo $crr_label; ?></option>
<?php
}	
?>
</select>
</p>
<?php
}
###############################################
###############################################
###############################################



###############################################
###############################################
###############################################
if(!$all_label_found){
?>
<p>请为上面的项目选择正确的列，并提交</p>
<input type="submit" value="提交" style="position:relative; margin-bottom:50px; background-color:#06F; color:#FFF; padding:15px 68px; font-size:18px; border-width:1px;" />
<?php
}
?>
</form>

<?php
if($all_label_found){
?>
<div style="padding:12px; border-style:solid; border-width:3px; border-color:#0CF; background-color:#DEF9FF">
    <h4 style="font-size:24px;">请核对每一列数据，是否出现在正确位置，数值是否格式正确</h4>
    
    <table cellpadding="0" cellspacing="0">
    <tr id="table-title">
    <td width="32"></td>
    <td width="88">库存编号</td>
    <td width="88">形状</td>
    <td width="88">重量</td>
    <td width="88">颜色</td>
    <td width="128">彩钻颜色<br />fancy color</td>
    <td width="88">净度</td>
    <td width="88">证书</td>
    <td width="88">证书编号</td>
    <td width="88">切工</td>
    <td width="88">抛光</td>
    <td width="88">对称性</td>
    <td width="88">荧光</td>
    <td width="88">价格(原始)</td>
    <td width="88">折扣</td>
    
    </tr>
    
    <?php
    for ($i = ($row_label+1); $i <= (12+$row_label); $i++) {
    ?>
    <tr>
    <td><?php echo $i; ?></td><!--        -->
    <td>
	<?php
		$stock_ref_value=$data->raw($i,$_SESSION['col_stock_ref']);
		if(trim($stock_ref_value)==''){
			$stock_ref_value=$data->val($i,$_SESSION['col_stock_ref']);
		}
		echo trim('K'.trim($stock_ref_value)); 
	?>
    </td><!--    库存编号    -->
    <td><?php echo trim($data->val($i,$_SESSION['col_shape'])); ?></td><!--    形状    -->
    <td><?php
		$carat=$data->raw($i,$_SESSION['col_carat']); 
		echo $carat;
	?></td><!--    重量    -->
    <td><?php echo trim($data->val($i,$_SESSION['col_color'])); ?></td><!--   颜色     -->
    <td> 无该项 </td><!--    彩钻颜色    -->
    <td><?php echo trim($data->val($i,$_SESSION['col_clarity'])); ?></td><!--   净度     -->
    <td><?php echo trim($data->val($i,$_SESSION['col_grading_lab'])); ?></td><!--    证书    -->
    <td>
	<?php
		$certi_value = $data->raw($i,$_SESSION['col_certificate_number']);
		if(trim($certi_value)==''){
			$certi_value = $data->val($i,$_SESSION['col_certificate_number']);
		}
	    echo trim($certi_value); 
	?>
    </td><!--    证书编号    -->
    <td><?php echo trim($data->val($i,$_SESSION['col_cut_grade'])); ?></td><!--   切工   -->
    <td><?php echo trim($data->val($i,$_SESSION['col_polish'])); ?></td><!--   抛光     -->
    <td><?php echo trim($data->val($i,$_SESSION['col_symmetry'])); ?></td><!--    对称性    -->
    
    <td><?php echo trim($data->val($i,$_SESSION['col_fluorescence_intensity'])); ?></td><!--   荧光     -->
    
    <td><?php 
		$raw_price_total=$data->raw($i,$_SESSION['col_raw_price_total']);
	    echo $raw_price_total; 
	?></td><!--  价格  -->
    <td><?php 
		$percentage=$data->raw($i,$_SESSION['col_percentage']);
		echo $percentage; 
	?></td><!--  折扣  -->
    <!--<td>
    <?php
		/*
	require_once('price-settings.php');
	$raw_price_total_novalue=$raw_price_total*($percentage+100-5)/100;
	if($carat<1.5){
		$price_agency=round(($price_ratio_001*$raw_price_total_novalue));
	}else if($carat>=1.5 && $carat<3){
		$price_agency=round(($price_ratio_002*$raw_price_total_novalue));
	}else if($carat>=3){
		$price_agency=round(($price_ratio_003*$raw_price_total_novalue));
	}
	echo $price_agency;*/
	?>
    
    </td>   卖价(代购)     -->
    
    </tr>
    <?php
    }
    ?>
    
    <tr id="moreindi">
    <td>...</td>
    <td>...</td>
    <td>...</td>
    <td>...</td>
    <td>...</td>
    <td>...</td>
    <td>...</td>
    <td>...</td>
    <td>...</td>
    <td>...</td>
    <td>...</td>
    <td>...</td>
    <td>...</td>
    <td>...</td>
    <td>...</td>
    <!--<td>...</td>-->
    </tr>
    
    
    
    </table>
    
    
    <form action="" method="post" id="confirmform">
    <input type="hidden" name="confirmed" value="YES" />
    <!--
    <input type="submit" value="确认数据正确并保存在数据库中" style="background-color:#06F; color:#FFF; font-size:18px; padding:8px 25px; border-width:1px; margin-top:30px;" />
    -->
    <button type="button" id="theconfirmbtn" onclick="confirmthedata()" style="background-color:#06F; color:#FFF; font-size:18px; padding:8px 25px; border-width:1px; margin-top:30px;">确认数据正确并保存在数据库中</button>
    </form>
    
    <p>如果有错误，请修改Excel文档后重新上传</p>

</div>


<script type="text/javascript">
function confirmthedata(){
	$('#theconfirmbtn').attr('disabled','disabled');
	$('#theconfirmbtn').html('保存中...');
	$('#confirmform').submit();
}
</script>

<?php
}// end for if($all_label_found)
}else{// ----------------- end for if($stock_ref_label_found)
?>
<h3 style="color:#F00;">错误：在表中没有找到 Lot ID 标签。请确定表中有标题。</h3>
<?php
}
}// ----------------- end for if($new_file_uploaded)
?>



<br /><br />
<div style="font-size:18px; background-color:#0FF; padding:8px; margin:25px 0; position:relative; width:380px; display:none;">注：Excel数据表格请按这个顺序排列:<p style="background-color:#FFF; margin:8px; padding:20px; line-height:25px;">1.库存编号, <br />2.形状, <br />3.重量, <br />4.颜色(彩钻可为空白), <br />5.彩钻颜色(可为空白), <br />6.净度(彩钻可为空白), <br />7.证书, <br />8.证书编号, <br />9.切工, <br />10.抛光, <br />11.对称性, <br />12.荧光, <br />13.所在地, <br />14.价格, <br />15.钻石所在公司</p>
</div>

<br /><br /><br /><br />
</div>
</body>
</html>