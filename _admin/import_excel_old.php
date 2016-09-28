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
    if ($_FILES['upfile']['size'] > 5000000) {
        throw new RuntimeException('Exceeded filesize limit.');
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

    echo $e->getMessage();

}
//exit('ok');
}

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
	width:1%;
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
</style>
<script src="http://sigway.be/lab/jquery-1.11.2.min.js"></script>
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
<img id="working_indi" style="position:absolute; height:35px; left:10px; top:8px;" src="../images/loader.gif" />已处理 <span id="num_proccessed">0</span> 条纪录...
<p id="message_bg"></p>
</div>
--
<p id="additional-message">重复，跳过: <span id="skippednum">0</span>; &nbsp; &nbsp; 过滤掉: <span id="ignorednum">0</span>; &nbsp; &nbsp; 新增: <span id="addednum">0</span>;  &nbsp; &nbsp; 更新: <span id="renewednum">0</span>;</p>
<p id="additional-message2"></p>
<p id="additional-errormessage">!注意:导入结果中有 <span id="errorednum">0</span> 条纪录中切工、抛光或对称性数值存在错误：数值缺失或参数不正确。</p>
</div>

<div id="fb_container" style="display:none;"></div>


<script type="text/javascript">
var $crr_turn=0;
var $total_row=0;
$(document).ready(function(){
	proceedthedata();
});

function proceedthedata(){
	$crr_turn++;
	console.log($crr_turn+' -sent');
	$.post( "save_excel_data.php", 
	{ confirmed: "YES", crr_turn: $crr_turn }, 
	function( data ) {
	    console.log($crr_turn+' -return');
		console.log(data);
		
		$('#fb_container').html(data);
		
		var messagemain=$('#fb_container').children('p#messagemain').html();
		if(messagemain!='SUCCESS'){
			alert('未知错误');
		}
			
		$total_row=parseInt($('#fb_container').children('p#total_records').html());
		var crr_percent=Math.round($crr_turn*28/$total_row*100);		
		var crr_fb_message=$('#fb_container').children('p#fmessage').html();
		var crr_added=parseInt($('#fb_container').children('p#added').html());
		//alert(crr_added);
		var crr_skipped=parseInt($('#fb_container').children('p#skipped').html());
		var crr_renewed=parseInt($('#fb_container').children('p#renewed').html());
		var crr_errored=parseInt($('#fb_container').children('p#errored').html());
		var crr_ignored=parseInt($('#fb_container').children('p#ignored').html());
		
		$('#message_bg').css('width', crr_percent+'%');
		$('#num_proccessed').html($crr_turn*28);
		
		$('#additional-message2').prepend(crr_fb_message);
		$('#skippednum').html(parseInt($('#skippednum').html())+crr_skipped);
		$('#ignorednum').html(parseInt($('#ignorednum').html())+crr_ignored);
		$('#addednum').html(parseInt($('#addednum').html())+crr_added);
		$('#renewednum').html(parseInt($('#renewednum').html())+crr_renewed);
		$('#errorednum').html(parseInt($('#errorednum').html())+crr_errored);
		if(parseInt($('#errorednum').html())>0){
			$('#additional-errormessage').fadeIn('fast');
		}
		if($('#additional-message2').html()!=''){
			$('#additional-message2').fadeIn('fast');
		}
		
		if(($crr_turn*28)>=$total_row){
			$('h4#finimessage').fadeIn('fast');
			$('img#working_indi').fadeOut('fast');
		}else{
			proceedthedata();
			
		}
		/**/
	}).fail(function(){
		console.log($crr_turn+' ******************** error ***********************');
		$crr_turn=$crr_turn-1;
		setTimeout('proceedthedata()',5000);
	});
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
}
</script>


</div>

<?php
if($new_file_uploaded){
	require_once 'excelreader/excel_reader2.php';
    $data = new Spreadsheet_Excel_Reader("excelfile/file.xls");
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
<td width="88">所在地</td>
<td width="88">价格(原始)</td>
<td width="128">所在公司</td>
</tr>



<?php
for ($i = 1; $i <= 6; $i++) {
?>
<tr>
<td><?php echo $i; ?></td><!--        -->
<td><?php echo trim('K'.trim($data->raw($i,1))); ?></td><!--    库存编号    -->
<td><?php echo trim($data->val($i,3)); ?></td><!--    形状    -->
<td><?php echo $data->raw($i,5); ?></td><!--    重量    -->
<td><?php echo trim($data->val($i,7)); ?></td><!--   颜色     -->
<td> 无该项 </td><!--    彩钻颜色    -->
<td><?php echo trim($data->val($i,8)); ?></td><!--   净度     -->
<td><?php echo trim($data->val($i,6)); ?></td><!--    证书    -->
<td><?php echo trim($data->raw($i,18)); ?></td><!--    证书编号    -->
<td><?php echo trim($data->val($i,9)); ?></td><!--   切工     -->
<td><?php echo trim($data->val($i,10)); ?></td><!--   抛光     -->
<td><?php echo trim($data->val($i,11)); ?></td><!--    对称性    -->

<td><?php echo trim($data->val($i,12)); ?></td><!--   荧光     -->

<td> 无该项 </td><!--    所在地    -->
<td><?php echo $data->raw($i,14); ?></td><!--    价格    -->
<td> 无该项 </td><!--   所在公司     -->

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
<td>...</td>
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
}
?>



<br /><br />
<div style="font-size:18px; background-color:#0FF; padding:8px; margin:25px 0; position:relative; width:380px; display:none;">注：Excel数据表格请按这个顺序排列:<p style="background-color:#FFF; margin:8px; padding:20px; line-height:25px;">1.库存编号, <br />2.形状, <br />3.重量, <br />4.颜色(彩钻可为空白), <br />5.彩钻颜色(可为空白), <br />6.净度(彩钻可为空白), <br />7.证书, <br />8.证书编号, <br />9.切工, <br />10.抛光, <br />11.对称性, <br />12.荧光, <br />13.所在地, <br />14.价格, <br />15.钻石所在公司</p>
</div>

<br /><br /><br /><br />
</div>
</body>
</html>