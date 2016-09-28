<div class="subnavi_box">

<?php
if($crr_page=='diamonds'){
	include_once('content/sub_navi/diamonds.php');
}
?>

</div>













<div id="filter_box">



<div id="filter_box_inner">
<div class="filter_line">
<span class="filter_title" id="filter_title_shape">形状<br />shape</span>
<ul class="fileber_shape_outer">
<li class="filter_shape" id="filter_shapeBR" onclick="filter_shape('BR')"><img src="../images/site_elements/icons/01.gif" /></li>
<li class="filter_shape" id="filter_shapePS" onclick="filter_shape('PS')"><img src="../images/site_elements/icons/02.gif" /></li>
<li class="filter_shape" id="filter_shapePR" onclick="filter_shape('PR')"><img src="../images/site_elements/icons/03.gif" /></li>
<li class="filter_shape" id="filter_shapeHS" onclick="filter_shape('HS')"><img src="../images/site_elements/icons/08.gif" /></li>
<li class="filter_shape" id="filter_shapeMQ" onclick="filter_shape('MQ')"><img src="../images/site_elements/icons/05.gif" /></li>
<li class="filter_shape" id="filter_shapeOV" onclick="filter_shape('OV')"><img src="../images/site_elements/icons/11.gif" /></li>
<li class="filter_shape" id="filter_shapeEM" onclick="filter_shape('EM')"><img src="../images/site_elements/icons/10.gif" /></li>
<li class="filter_shape" id="filter_shapeRAD" onclick="filter_shape('RAD')"><img src="../images/site_elements/icons/06.gif" /></li>
<li class="filter_shape" id="filter_shapeCU" onclick="filter_shape('CU')"><img src="../images/site_elements/icons/12.gif" /></li>
</ul>
</div>

<div class="filter_line">
<div class="filter_line_inner" id="filter_line_color" style="border-width:1px;">
<span class="filter_title">颜色<br />color</span>
<ul>
<li class="filter_color" id="filter_colorD" onclick="filter_color('D')">D</li>
<li class="filter_color" id="filter_colorE" onclick="filter_color('E')">E</li>
<li class="filter_color" id="filter_colorF" onclick="filter_color('F')">F</li>
<li class="filter_color" id="filter_colorG" onclick="filter_color('G')">G</li>
<li class="filter_color" id="filter_colorH" onclick="filter_color('H')">H</li>
<li class="filter_color" id="filter_colorI" onclick="filter_color('I')">I</li>
<li class="filter_color" id="filter_colorJ" onclick="filter_color('J')">J</li>
<li class="filter_color" id="filter_colorK" onclick="filter_color('K')">K</li>
<li class="filter_color" id="filter_colorL" onclick="filter_color('L')">L</li>
<li class="filter_color" id="filter_colorM" onclick="filter_color('M')">M</li>
</ul>
</div>


<div class="filter_line_inner">
<span class="filter_title" style="top:-4px;">重量<br />carat</span>
<div id="filter_line_weight">
<input type="text" id="weight_from" /> - <input type="text" id="weight_to" /> <button type="button" id="btn_weight">更新结果</button>
</div>
</div>
</div>

<div class="filter_line">
<div class="filter_line_inner" id="filter_line_clarity" style="border-width:1px;">
<span class="filter_title">净度<br />clarity</span>
<ul>
<li class="filter_clarity" id="filter_clarityFL" onclick="filter_clarity('FL')">FL</li>
<li class="filter_clarity" id="filter_clarityIF" onclick="filter_clarity('IF')">IF</li>
<li class="filter_clarity" id="filter_clarityWS1" onclick="filter_clarity('WS1')">WS1</li>
<li class="filter_clarity" id="filter_clarityWS2" onclick="filter_clarity('WS2')">WS2</li>
<li class="filter_clarity" id="filter_clarityVS1" onclick="filter_clarity('VS1')">VS1</li>
<li class="filter_clarity" id="filter_clarityVS2" onclick="filter_clarity('VS2')">VS2</li>
<li class="filter_clarity" id="filter_claritySI1" onclick="filter_clarity('SI1')">SI1</li>
<li class="filter_clarity" id="filter_claritySI2" onclick="filter_clarity('SI2')">SI2</li>
</ul>
</div>

<div class="filter_line_inner">
<span class="filter_title" style="top:-5px;">价格<br />price</span>
<div id="filter_line_price">
美元($)<input type="text" id="price_from" /> - <input type="text" id="price_to" /> <button type="button" id="btn_price">更新结果</button>
</div>
</div>
</div>


</div>
<p id="filtertab">筛选结果</p>
</div>





<div class="main_contentbox" id="diamondscontentbox">



<?php

$sql_count='SELECT COUNT(*) AS num FROM diamonds';

//exit($sql_count);

foreach($conn->query($sql_count) as $num){
	$result_number=$num['num'];
}



$sql='SELECT * FROM diamonds ORDER BY stock_ref DESC';


$stmt=$conn->query($sql);

?>


<div id="tableheader">
<p id="listdescription">为您找到 <span id="resulthowmany"><?php echo $result_number; ?></span> 条结果:</p>
<table cellpadding="2" cellspacing="0" border="0">
<tr class="t_h">
<td align="center" class="1st_col" style="width:102px;">库存编号</td>
<td align="center" style="width:32px;">形状</td>
<td align="center"><img class="iconarrow" id="arrow_sorting_weight" width="8" src="../images/site_elements/arrow-down.png" /><button type="button" class="sortbtn" title="点击排序" onclick="sorting_weight()">重量</button></td>
<td align="center"><img class="iconarrow" id="arrow_sorting_color" width="8" src="../images/site_elements/arrow-down.png" /><button type="button" class="sortbtn" title="点击排序" onclick="sorting_color()">色级</button></td>
<td align="center"><img class="iconarrow" id="arrow_sorting_clarity" width="8" src="../images/site_elements/arrow-down.png" /><button type="button" class="sortbtn" title="点击排序" onclick="sorting_clarity()">净度</button></td>
<td align="center">证书</td>
<td align="center"><img class="iconarrow" id="arrow_sorting_cut" width="8" src="../images/site_elements/arrow-down.png" /><button type="button" class="sortbtn" title="点击排序" onclick="sorting_cut()">切工</button></td>
<td align="center">抛光</td>
<td align="center" style="white-space:nowrap;">对称性</td>
<td align="center" style="width:112px;"><img class="iconarrow" id="arrow_sorting_price" width="8" src="../images/site_elements/arrow-down.png" /><button type="button" class="sortbtn" title="点击排序" onclick="sorting_price()">价格(美元)</button></td>
<td align="center" style="width:30px;">&nbsp;</td>
</tr>
</table>
</div>


<div id="diamondsdata" style="height:200px; overflow:auto;">
<table cellpadding="2" cellspacing="0" border="0">

<?php
$r=0;
foreach($stmt as $row){
	$r++;
?>
<tr class="<?php echo $r; ?>">
<td align="center" class="ref_number">
<span class="valuetxt" style="width:102px;">
<?php echo $row['stock_ref']; ?>
</span>
</td>
<td align="center" style="width:32px;">
<?php
switch ($row['shape']){
	case "BR":
	$pic_where="01.gif";
	break;
	
	case "CU":
	$pic_where="12.gif";
	break;
	
	case "EM":
	$pic_where="10.gif";
	break;
	
	case "HS":
	$pic_where="08.gif";
	break;
	
	case "MQ":
	$pic_where="05.gif";
	break;
	
	
	case "OV":
	$pic_where="11.gif";
	break;
	
	
	case "PR":
	$pic_where="03.gif";
	break;
	
	case "PS":
	$pic_where="02.gif";
	break;
	
	case "RAD":
	$pic_where="06.gif";
	break;
	
	case "TRI":
	$pic_where="04.gif";
	break;
	
	default:
	$pic_where="01.gif";
}
?>
<img height="25" src="../images/site_elements/icons/<?php echo $pic_where; ?>" />
</td>
<td align="center" class="value_carat">
<span class="valuetxt">
<?php echo $row['carat']; ?>
</span>
</td>
<td align="center" class="value_color">
<span class="valuetxt">
<?php echo $row['color']; ?>
</span>
</td>
<td align="center" class="value_clarity">
<span class="valuetxt">
<?php echo $row['clarity']; ?>
</span>
</td>
<td align="center" class="value_certificate">
<span class="valuetxt">
<?php echo $row['grading_lab']; ?>
</span>
</td>
<td align="center" class="value_cut">
<span class="valuetxt">
<?php echo $row['cut_grade']; ?>
</span>
</td>
<td align="center" class="value_polish">
<span class="valuetxt">
<?php echo $row['polish']; ?>
</span>
</td>
<td align="center" class="value_symmetry">
<span class="valuetxt">
<?php echo $row['symmetry']; ?>
</span>
</td>

<td align="center" class="value_price">
<span class="valuetxt" style="width:112px;">
<?php echo $row['price']; ?>
</span>
</td>
<td class="seedetail" align="center" title="open"><span style="display:inline-block;width:28px; text-align:center; white-space:nowrap;">详情</span></td>
</tr>

<tr id="d_<?php echo $r; ?>" class="details">
<td colspan="5" class="detail_1stcol">
<p class="details_txt">
荧光强度:
<?php 
echo $row["fluorescence_intensity"];
?> &nbsp; &nbsp; 
所在地: <?php echo $row['country']; ?>
</p>






<div class="imagescontainer">




<?php		
		$thumbs_dir='../images/contentimgs/'.$row['stock_ref'].'/thumbs/';
		
		$picsinfolder=array();	
		/* step one:  read directory, make array of files */
		if ($handle = opendir($thumbs_dir)) {
			while (false !== ($file = readdir($handle))) {
				if ($file != '.' && $file != '..' && $file != '.DS_Store') 
				{					
			        $picsinfolder[] = $file;					
				}
			}
			closedir($handle);
		}
		
		/* step two: loop through, format gallery */
		if(count($picsinfolder)){
			$c=0;		
			foreach($picsinfolder as $file){
				if($c==0){
					$pic1=$file;
					?>
                    
                    
            <div class="thumbsbox">
                    <?php
				
				}
				?>						
                
                <a class="thumbbox" rel="thumbbox<?php echo $row['stock_ref']; ?>" id="pic_<?php echo $row['stock_ref'].$c; ?>" href="../images/contentimgs/<?php echo $row['stock_ref']; ?>/<?php echo urldecode($file); ?>">
                <img src="<?php echo urldecode($thumbs_dir.$file); ?>" />
                </a>

                
                <?php
				$c++;
			}
		}
?>
			</div>
</div>




</td>
<td colspan="6" class="detail_2ndcol">
<p class="details_txt2">
证书编号: <?php echo $row['certificate_number']; ?>

 &nbsp; &nbsp; 
<?php
if(trim($row["grading_lab"])=='HRD'){
?>
<a class="certi_linker" target="_blank" href="http://www.hrdantwerplink.be/index.php?record_number=<?php echo $row['certificate_number']; ?>&weight=<?php echo $row['carat']; ?>&L=">查看证书</a>
<?php
}else if(trim($row["grading_lab"])=='GIA'){
?>
<a class="certi_linker" target="_blank" href="http://www.gia.edu/cs/Satellite?pagename=GST%2FDispatcher&childpagename=GIA%2FPage%2FReportCheck&c=Page&cid=1355954554547&reportno=<?php echo $row['certificate_number']; ?>">查看证书</a>
<?php
}else if(trim($row["grading_lab"])=='IGI'){
?>
<a class="certi_linker" target="_blank" href="http://www.igiworldwide.com/igi/verify.php?r=<?php echo $row['certificate_number']; ?>">查看证书</a>
<?php
}
?>
</p>
<?php
$sql_v='SELECT * FROM video_diamond WHERE ref_number = "'.$row["stock_ref"].'"';
foreach($conn->query($sql_v) as $v){
?>
<div class="videobox" title="<?php echo $v['thelink']; ?>">

</div>
<?php
} 
?>

</td>
</tr>
<?php
}
?>
</table>

<div id="howmanyrecords" style="display:none;"><?php echo $result_number; ?></div>

</div>





</div>





<div id="loading_indi" style="position:fixed; top:0; left:0; width:100%; height:100%; background-color:#FFF; background-color:rgba(255, 255, 255, 0.7); display:none;">
<p style="position:relative; top:50%; margin-top:-35px; text-align:center;"><img width="25px" src="../images/site_elements/loadingGraphic.gif" /><br /><span style="position:relative; left:8px; display:inline-block; margin-top:12px;">载入中...</span></p>
</div>

<script type="text/javascript">
var $featured='NO';



var $shapeBR=false;
var $shapePS=false;
var $shapePR=false;
var $shapeHS=false;
var $shapeMQ=false;
var $shapeOV=false;
var $shapeEM=false;
var $shapeRAD=false;
var $shapeCU=false;

var $shape = '';


var $colorD = false;
var $colorE = false;
var $colorF = false;
var $colorG = false;
var $colorH = false;
var $colorI = false;
var $colorJ = false;
var $colorK = false;
var $colorL = false;
var $colorM = false;

var $color = '';



var $clarityFL = false;
var $clarityIF = false;
var $clarityWS1 = false;
var $clarityWS2 = false;
var $clarityVS1 = false;
var $clarityVS2 = false;
var $claritySI1 = false;
var $claritySI2 = false;

var $clarity = '';



var $weight_from = '';
var $weight_to = '';
var $price_from = '';
var $price_to = '';
var $sorting = 'ref';
var $sorting_weight_direction = 'ASC';
var $sorting_color_direction = 'ASC';
var $sorting_clarity_direction = 'ASC';
var $sorting_cut_direction = 'ASC';
var $sorting_price_direction = 'ASC';
var $sorting_direction = 'ASC';

$(document).ready(function(){
	$('button#btn_weight').click(function(){
		$weight_from=parseFloat($("input#weight_from").val())+'';
		$weight_to=parseFloat($("input#weight_to").val())+'';
		
		if($weight_from=="NaN"){
			$weight_from=0.05;
		}
		if($weight_to=="NaN"){
			$weight_to=99.05;
		}
		update();
	});
	$('button#btn_price').click(function(){
		$price_from=parseFloat($("input#price_from").val())+'';
		$price_to=parseFloat($("input#price_to").val())+'';
		
		if($price_from=="NaN"){
			$price_from=5;
		}
		if($price_to=="NaN"){
			$price_to=99999999;
		}
		
		update();
	});
});


function filter_shape(theshape){
	var $theshape=theshape;
	var $or='';
	$shape='';
	
	if($theshape=='BR'){
		if($shapeBR){
			$shapeBR=false;
			$('#filter_shapeBR').removeAttr('style');
		}else{
			$shapeBR=true;
			$('#filter_shapeBR').css('background-color','#E9E3CF');
		}
	}else if($theshape=='PS'){
		if($shapePS){			
			$shapePS=false;
			$('#filter_shapePS').removeAttr('style');
		}else{
			$shapePS=true;
			$('#filter_shapePS').css('background-color','#E9E3CF');
		}
	}else if($theshape=='PR'){		
		if($shapePR){
			$shapePR=false;
			$('#filter_shapePR').removeAttr('style');
		}else{
			$shapePR=true;
			$('#filter_shapePR').css('background-color','#E9E3CF');
		}
	}else if($theshape=='HS'){
		if($shapeHS){
			$shapeHS=false;
			$('#filter_shapeHS').removeAttr('style');
		}else{
			$shapeHS=true;
			$('#filter_shapeHS').css('background-color','#E9E3CF');
		}
	}else if($theshape=='MQ'){
		if($shapeMQ){
			$shapeMQ=false;
			$('#filter_shapeMQ').removeAttr('style');
		}else{
			$shapeMQ=true;
			$('#filter_shapeMQ').css('background-color','#E9E3CF');
		}
	}else if($theshape=='OV'){
		if($shapeOV){
			$shapeOV=false;
			$('#filter_shapeOV').removeAttr('style');
		}else{
			$shapeOV=true;
			$('#filter_shapeOV').css('background-color','#E9E3CF');
		}
	}else if($theshape=='EM'){
		if($shapeEM){
			$shapeEM=false;
			$('#filter_shapeEM').removeAttr('style');
		}else{
			$shapeEM=true;
			$('#filter_shapeEM').css('background-color','#E9E3CF');
		}
	}else if($theshape=='RAD'){
		if($shapeRAD){
			$shapeRAD=false;
			$('#filter_shapeRAD').removeAttr('style');
		}else{
			$shapeRAD=true;
			$('#filter_shapeRAD').css('background-color','#E9E3CF');
		}
	}else if($theshape=='CU'){
		if($shapeCU){
			$shapeCU=false;
			$('#filter_shapeCU').removeAttr('style');
		}else{
			$shapeCU=true;
			$('#filter_shapeCU').css('background-color','#E9E3CF');
		}
	}
	
	if($shapeBR){
		$shape+=' shape = "BR" ';
		$or = ' OR ';
	}
	if($shapePS){
		$shape+=$or+' shape = "PS" ';
		$or = ' OR ';
	}
	if($shapePR){
		$shape+=$or+' shape = "PR" ';
		$or = ' OR ';
	}
	if($shapeHS){
		$shape+=$or+' shape = "HS" ';
		$or = ' OR ';
	}
	if($shapeMQ){
		$shape+=$or+' shape = "MQ" ';
		$or = ' OR ';
	}
	if($shapeOV){
		$shape+=$or+' shape = "OV" ';
		$or = ' OR ';
	}
	if($shapeEM){
		$shape+=$or+' shape = "EM" ';
		$or = ' OR ';
	}
	if($shapeRAD){
		$shape+=$or+' shape = "RAD" ';
		$or = ' OR ';
	}
	if($shapeCU){
		$shape+=$or+' shape = "CU" ';
		$or = ' OR ';
	}
	
	update();
}
function filter_color(thecolor){
	var $thecolor=thecolor;
	var $or='';
	$color='';
	
	if($thecolor=='D'){
		if($colorD){
			$colorD=false;
			$('#filter_colorD').removeAttr('style');
		}else{
			$colorD=true;
			$('#filter_colorD').css('background-color','#E9E3CF');
		}
	}else if($thecolor=='E'){
		if($colorE){
			$colorE=false;
			$('#filter_colorE').removeAttr('style');
		}else{
			$colorE=true;
			$('#filter_colorE').css('background-color','#E9E3CF');
		}
	}else if($thecolor=='F'){
		if($colorF){
			$colorF=false;
			$('#filter_colorF').removeAttr('style');
		}else{
			$colorF=true;
			$('#filter_colorF').css('background-color','#E9E3CF');
		}
	}else if($thecolor=='G'){
		if($colorG){
			$colorG=false;
			$('#filter_colorG').removeAttr('style');
		}else{
			$colorG=true;
			$('#filter_colorG').css('background-color','#E9E3CF');
		}
	}else if($thecolor=='H'){
		if($colorH){
			$colorH=false;
			$('#filter_colorH').removeAttr('style');
		}else{
			$colorH=true;
			$('#filter_colorH').css('background-color','#E9E3CF');
		}
	}else if($thecolor=='I'){
		if($colorI){
			$colorI=false;
			$('#filter_colorI').removeAttr('style');
		}else{
			$colorI=true;
			$('#filter_colorI').css('background-color','#E9E3CF');
		}
	}else if($thecolor=='J'){
		if($colorJ){
			$colorJ=false;
			$('#filter_colorJ').removeAttr('style');
		}else{
			$colorJ=true;
			$('#filter_colorJ').css('background-color','#E9E3CF');
		}
	}else if($thecolor=='K'){
		if($colorK){
			$colorK=false;
			$('#filter_colorK').removeAttr('style');
		}else{
			$colorK=true;
			$('#filter_colorK').css('background-color','#E9E3CF');
		}
	}else if($thecolor=='L'){
		if($colorL){
			$colorL=false;
			$('#filter_colorL').removeAttr('style');
		}else{
			$colorL=true;
			$('#filter_colorL').css('background-color','#E9E3CF');
		}
	}else if($thecolor=='M'){
		if($colorM){
			$colorM=false;
			$('#filter_colorM').removeAttr('style');
		}else{
			$colorM=true;
			$('#filter_colorM').css('background-color','#E9E3CF');
		}
	}
	
	if($colorD){
		$color+=' color = "D" ';
		$or=' OR ';
	}
	if($colorE){
		$color+=$or+' color = "E" ';
		$or=' OR ';
	}
	if($colorF){
		$color+=$or+' color = "F" ';
		$or=' OR ';
	}
	if($colorG){
		$color+=$or+' color = "G" ';
		$or=' OR ';
	}
	if($colorH){
		$color+=$or+' color = "H" ';
		$or=' OR ';
	}
	if($colorI){
		$color+=$or+' color = "I" ';
		$or=' OR ';
	}
	if($colorJ){
		$color+=$or+' color = "J" ';
		$or=' OR ';
	}
	if($colorK){
		$color+=$or+' color = "K" ';
		$or=' OR ';
	}
	if($colorL){
		$color+=$or+' color = "L" ';
		$or=' OR ';
	}
	if($colorM){
		$color+=$or+' color = "M" ';
	}
	
	update();
}



function filter_clarity(theclarity){
	var $theclarity=theclarity;
	var $or='';
	$clarity='';
	
	if($theclarity=='FL'){
		if($clarityFL){
			$clarityFL=false;
			$('#filter_clarityFL').removeAttr('style');
		}else{
			$clarityFL=true;
			$('#filter_clarityFL').css('background-color','#E9E3CF');
		}
	}else if($theclarity=='IF'){
		if($clarityIF){
			$clarityIF=false;
			$('#filter_clarityIF').removeAttr('style');
		}else{
			$clarityIF=true;
			$('#filter_clarityIF').css('background-color','#E9E3CF');
		}
	}else if($theclarity=='WS1'){
		if($clarityWS1){
			$clarityWS1=false;
			$('#filter_clarityWS1').removeAttr('style');
		}else{
			$clarityWS1=true;
			$('#filter_clarityWS1').css('background-color','#E9E3CF');
		}
	}else if($theclarity=='WS2'){
		if($clarityWS2){
			$clarityWS2=false;
			$('#filter_clarityWS2').removeAttr('style');
		}else{
			$clarityWS2=true;
			$('#filter_clarityWS2').css('background-color','#E9E3CF');
		}
	}else if($theclarity=='VS1'){
		if($clarityVS1){
			$clarityVS1=false;
			$('#filter_clarityVS1').removeAttr('style');
		}else{
			$clarityVS1=true;
			$('#filter_clarityVS1').css('background-color','#E9E3CF');
		}
	}else if($theclarity=='VS2'){
		if($clarityVS2){
			$clarityVS2=false;
			$('#filter_clarityVS2').removeAttr('style');
		}else{
			$clarityVS2=true;
			$('#filter_clarityVS2').css('background-color','#E9E3CF');
		}
	}else if($theclarity=='SI1'){
		if($claritySI1){
			$claritySI1=false;
			$('#filter_claritySI1').removeAttr('style');
		}else{
			$claritySI1=true;
			$('#filter_claritySI1').css('background-color','#E9E3CF');
		}
	}else if($theclarity=='SI2'){
		if($claritySI2){
			$claritySI2=false;
			$('#filter_claritySI2').removeAttr('style');
		}else{
			$claritySI2=true;
			$('#filter_claritySI2').css('background-color','#E9E3CF');
		}
	}
	if($clarityFL){
		$clarity+=' clarity = "FL" ';
		$or = ' OR ';
	}
	if($clarityIF){
		$clarity+=$or+' clarity = "IF" ';
		$or = ' OR ';
	}
	if($clarityWS1){
		$clarity+=$or+' clarity = "WS1" ';
		$or = ' OR ';
	}
	if($clarityWS2){
		$clarity+=$or+' clarity = "WS2" ';
		$or = ' OR ';
	}
	if($clarityVS1){
		$clarity+=$or+' clarity = "VS1" ';
		$or = ' OR ';
	}
	if($clarityVS2){
		$clarity+=$or+' clarity = "VS2" ';
		$or = ' OR ';
	}
	if($claritySI1){
		$clarity+=$or+' clarity = "SI1" ';
		$or = ' OR ';
	}
	if($claritySI2){
		$clarity+=$or+' clarity = "SI2" ';
		$or = ' OR ';
	}
	
	
	update();
}

function sorting_weight(){
	$sorting='weight';
	if($sorting_weight_direction == 'ASC'){
		$sorting_weight_direction = 'DESC';
		$('#arrow_sorting_weight').attr('src','../images/site_elements/arrow-down.png');
	}else{
		$sorting_weight_direction = 'ASC';
		$('#arrow_sorting_weight').attr('src','../images/site_elements/arrow-up.png');
	}
	$sorting_direction=$sorting_weight_direction;
	update();
}
function sorting_color(){
	$sorting = 'color';
	if($sorting_color_direction == 'ASC'){
		$sorting_color_direction = 'DESC';
		$('#arrow_sorting_color').attr('src','../images/site_elements/arrow-down.png');
	}else{
		$sorting_color_direction = 'ASC';
		$('#arrow_sorting_color').attr('src','../images/site_elements/arrow-up.png');
	}
	$sorting_direction=$sorting_color_direction;
	update();
}
function sorting_clarity(){
	$sorting = 'clarity';
	if($sorting_clarity_direction == 'ASC'){
		$sorting_clarity_direction = 'DESC';
		$('#arrow_sorting_clarity').attr('src','../images/site_elements/arrow-down.png');
	}else{
		$sorting_clarity_direction = 'ASC';
		$('#arrow_sorting_clarity').attr('src','../images/site_elements/arrow-up.png');
	}
	$sorting_direction=$sorting_clarity_direction;
	update();
}
function sorting_cut(){
	$sorting = 'cut';
	if($sorting_cut_direction == 'ASC'){
		$sorting_cut_direction = 'DESC';
		$('#arrow_sorting_cut').attr('src','../images/site_elements/arrow-down.png');
	}else{
		$sorting_cut_direction = 'ASC';
		$('#arrow_sorting_cut').attr('src','../images/site_elements/arrow-up.png');
	}
	$sorting_direction=$sorting_cut_direction;
	update();
}
function sorting_price(){
	$sorting = 'price';
	if($sorting_price_direction == 'ASC'){
		$sorting_price_direction = 'DESC';
		$('#arrow_sorting_price').attr('src','../images/site_elements/arrow-down.png');
	}else{
		$sorting_price_direction = 'ASC';
		$('#arrow_sorting_price').attr('src','../images/site_elements/arrow-up.png');
	}
	$sorting_direction=$sorting_price_direction;
	update();
}

function arrowDirection(){
	if($sorting_weight_direction == 'ASC'){
		$('#arrow_sorting_weight').attr('src','../images/site_elements/arrow-down.png');
	}else{
		$('#arrow_sorting_weight').attr('src','../images/site_elements/arrow-up.png');
	}
	if($sorting_color_direction == 'ASC'){
		$('#arrow_sorting_color').attr('src','../images/site_elements/arrow-down.png');
	}else{
		$('#arrow_sorting_color').attr('src','../images/site_elements/arrow-up.png');
	}
	if($sorting_clarity_direction == 'ASC'){
		$('#arrow_sorting_clarity').attr('src','../images/site_elements/arrow-down.png');
	}else{
		$('#arrow_sorting_clarity').attr('src','../images/site_elements/arrow-up.png');
	}
	if($sorting_cut_direction == 'ASC'){
		$('#arrow_sorting_cut').attr('src','../images/site_elements/arrow-down.png');
	}else{
		$('#arrow_sorting_cut').attr('src','../images/site_elements/arrow-up.png');
	}
	if($sorting_price_direction == 'ASC'){
		$('#arrow_sorting_price').attr('src','../images/site_elements/arrow-down.png');
	}else{
		$('#arrow_sorting_price').attr('src','../images/site_elements/arrow-up.png');
	}
}

function update(){
	nowworkingonfilter=true;
	$('div#loading_indi').fadeIn('fast');
	$.post(
		"diamond-data.php", 
		{shape:$shape, color:$color, clarity:$clarity, weight_from:$weight_from, weight_to:$weight_to, price_from:$price_from, price_to:$price_to, featured: $featured, sorting:$sorting, sorting_direction:$sorting_direction}, 
		function(data){
			var contentLoaded=data;
			//alert(data);
			$('div#loading_indi').fadeOut('fast');
			$('div#diamondsdata').html(data);
			var howmanyrecords=$("div#howmanyrecords").html();
			$('span#resulthowmany').html(howmanyrecords);
			arrowDirection();
			addlisteners();
		}
	);
}
</script>

<script type="text/javascript" src="../fancyBox/source/jquery.fancybox.pack.js?v=2.1.5"></script>
<script type="text/javascript">
$(document).ready(function(){
	addlisteners();
<?php
if(isset($_GET['ref']) && $_GET['ref']=='round'){
?>
	$('#roundbtn').css({'border-bottom-style':'solid',
	'border-width':'2px'});
	$('#filter_shapeBR').click();
<?php
}else if(isset($_GET['ref']) && $_GET['ref']=='featured'){
?>
	$('#featuredbtn').css({'border-bottom-style':'solid','border-width':'2px'});
	$featured='YES';
	update();
<?php
}else if(isset($_GET['ref']) && $_GET['ref']=='special'){
?>
$('#specialbtn').css({'border-bottom-style':'solid',
	'border-width':'2px'});
$shapePS=true;
$shapePR=true;
$shapeHS=true;
$shapeMQ=true;
$shapeOV=true;
$shapeEM=true;
$shapeRAD=true;
$('#filter_shapePS').css('background-color','#FFEEFE');
$('#filter_shapePR').css('background-color','#FFEEFE');
$('#filter_shapeHS').css('background-color','#FFEEFE');
$('#filter_shapeMQ').css('background-color','#FFEEFE');
$('#filter_shapeOV').css('background-color','#FFEEFE');
$('#filter_shapeEM').css('background-color','#FFEEFE');
$('#filter_shapeRAD').css('background-color','#FFEEFE');
$('#filter_shapeCU').click();
<?php
}
?>
});

function addlisteners(){
	$('td.seedetail').click(function(){
		var crr_obj=$(this);
		var theid='#d_'+crr_obj.parent('tr').attr('class');
		if(crr_obj.attr('title')=='open'){
			$(theid).find('div.thumbbox').eq(0).click();		
		    $(theid).slideDown("slow", function(){
				crr_obj.attr('title','close');
				var thelink=$(theid).find('div.videobox').attr('title');
				$(theid).find('div.videobox').css({'background-image':'URL(../images/site_elements/loading.gif)','background-repeat':'no-repeat'});
				$(theid).find('div.videobox').html('<iframe height=268 width=352 src="" frameborder=0 allowfullscreen></iframe>');
				$(theid).find('div.videobox iframe').attr('src',thelink);
				$(theid).find('div.thumbbox').eq(0).click();
			});
		}else{
			$(theid).slideUp("fast", function(){
				crr_obj.attr('title','open');
			});
		}
	});
	
	$("a.thumbbox").fancybox({
		beforeLoad: function(){
						$('iframe').css('visibility',"hidden");
					},
		afterClose: function(){
						$('iframe').css('visibility',"visible");
					}
	});
}


</script>

