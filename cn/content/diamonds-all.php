<?php
if ($_SESSION ['account_level'] == '0') {
	$superAdmin = true;
} else {
	$superAdmin = false;
}
?>
<?php require_once('../_admin/log.php');?>
<div id="filter_box">
  <div id="dia_filter_box" class="filter_box_inner">
    <div class="filter_line">
    	  <div class="filter_line_inner" id="filter_line_color" style="border-width: 1px;">
      	<button type="button" id="btn_dia" class="btn_selected">白钻</button>
      	<button type="button" id="btn_dia_fancy">彩钻</button>
      </div>
      <div class="filter_line_inner" id="filter_line_color" style="width:400px;border-width: 1px;">
        <span class="filter_title">公司:<br/>comp</span>
        <ul><li>
        <select multiple="multiple" id="fromCompanySelect"  style="width:350px;border-width: 1px;" name="filter_fromCompany" >
			<?php foreach($conn->query('select distinct  from_company as d from diamonds order by from_company') as $row_orderDate){?>
			<option value='"<?php echo $row_orderDate['d'];?>"' <?php if(strpos($crr_orderDate, $row_orderDate['d'])) {echo 'selected="selected"';} ?>><?php echo $row_orderDate['d'];?></option>
			<?php }?>
		</select></li></ul>
	<script src="/js/multiple-select.js"></script>
    <script>
        $('select').multipleSelect();
    </script>
      </div>
    </div>
    <div id="dia_choose_box" style="display: block">
    <div class="filter_line">
    	  <div class="filter_line_inner" id="filter_line_color" style="border-width: 1px;">
      <span class="filter_title" id="filter_title_shape">形状<br />shape
      </span>
      <ul class="fileber_shape_outer">
        <li class="filter_clarity filter_shape" id="filter_shapeBR" onclick="filter_shape('BR')"><img
          src="../images/site_elements/icons/01.gif" /></li>
        <li class="filter_clarity filter_shape" id="filter_shapePS" onclick="filter_shape('PS')"><img
          src="../images/site_elements/icons/02.gif" /></li>
        <li class="filter_clarity filter_shape" id="filter_shapePR" onclick="filter_shape('PR')"><img
          src="../images/site_elements/icons/03.gif" /></li>
        <li class="filter_clarity filter_shape" id="filter_shapeHS" onclick="filter_shape('HS')"><img
          src="../images/site_elements/icons/08.gif" /></li>
        <li class="filter_clarity filter_shape" id="filter_shapeMQ" onclick="filter_shape('MQ')"><img
          src="../images/site_elements/icons/05.gif" /></li>
        <li class="filter_clarity filter_shape" id="filter_shapeOV" onclick="filter_shape('OV')"><img
          src="../images/site_elements/icons/11.gif" /></li>
        <li class="filter_clarity filter_shape" id="filter_shapeEM" onclick="filter_shape('EM')"><img
          src="../images/site_elements/icons/10.gif" /></li>
        <li class="filter_clarity filter_shape" id="filter_shapeRAD" onclick="filter_shape('RAD')"><img
          src="../images/site_elements/icons/06.gif" /></li>
        <li class="filter_clarity filter_shape" id="filter_shapeCU" onclick="filter_shape('CU')"><img
          src="../images/site_elements/icons/12.gif" /></li>
      </ul>
      </div>
      <div class="filter_line_inner" style="border-width: 1px;">
        <span class="filter_title" style="top: -5px;">价格(美元)<br />price($)
        </span>
        <div id="filter_line_price">
          <input type="text" id="price_from" class="inputChg" value="50" /> - <input type="text" id="price_to" class="inputChg" value="999999" />
          <!--  <div id="slider-range" style="display: inline-block; width: 108px; margin-left: 25px;"></div>-->
        </div>
      </div>
      <div class="filter_line_inner" style="border-width: 1px;"> 
        <span class="filter_title" style="top: -4px;">重量<br />carat
        </span>
        <div id="filter_line_weight">
          <input type="text" id="weight_from" class="inputChg" value="0.01" /> - <input type="text" id="weight_to" class="inputChg" value="50" />
          <!--  <div id="slider-range-weight" style="display: inline-block; width: 188px; margin-left: 25px;"></div>-->
        </div>
      </div>
    </div>
    
    <div class="filter_line">
      <div class="filter_line_inner" id="filter_line_color" style="border-width: 1px;">
        <span class="filter_title">颜色<br />color
        </span>
        <ul>
          <li class="filter_clarity filter_color" id="filter_colorD" onclick="filter_color('D')">D</li>
          <li class="filter_clarity filter_color" id="filter_colorE" onclick="filter_color('E')">E</li>
          <li class="filter_clarity filter_color" id="filter_colorF" onclick="filter_color('F')">F</li>
          <li class="filter_clarity filter_color" id="filter_colorG" onclick="filter_color('G')">G</li>
          <li class="filter_clarity filter_color" id="filter_colorH" onclick="filter_color('H')">H</li>
          <li class="filter_clarity filter_color" id="filter_colorI" onclick="filter_color('I')">I</li>
          <li class="filter_clarity filter_color" id="filter_colorJ" onclick="filter_color('J')">J</li>
          <li class="filter_clarity filter_color" id="filter_colorK" onclick="filter_color('K')">K</li>
          <li class="filter_clarity filter_color" id="filter_colorL" onclick="filter_color('L')">L</li>
          <li class="filter_clarity filter_color" id="filter_colorM" onclick="filter_color('M')">M</li>
        </ul>
      </div>
      <div class="filter_line_inner" id="filter_line_clarity" style="border-width: 1px;">
        <span class="filter_title">净度<br />clarity
        </span>
        <ul>
          <li class="filter_clarity" id="filter_clarityFL" onclick="filter_clarity('FL')">FL</li>
          <li class="filter_clarity" id="filter_clarityIF" onclick="filter_clarity('IF')">IF</li>
          <li class="filter_clarity" id="filter_clarityWS1" onclick="filter_clarity('WS1')">VVS1</li>
          <li class="filter_clarity" id="filter_clarityWS2" onclick="filter_clarity('WS2')">VVS2</li>
          <li class="filter_clarity" id="filter_clarityVS1" onclick="filter_clarity('VS1')">VS1</li>
          <li class="filter_clarity" id="filter_clarityVS2" onclick="filter_clarity('VS2')">VS2</li>
          <li class="filter_clarity" id="filter_claritySI1" onclick="filter_clarity('SI1')">SI1</li>
          <li class="filter_clarity" id="filter_claritySI2" onclick="filter_clarity('SI2')">SI2</li>
        </ul>
      </div>
      <div class="filter_line_inner">
        <span class="filter_title">荧光<br />fluo
        </span>
        <ul>
          <li class="filter_clarity" id="filter_fluoVST" onclick="filter_fluo('VST')">极强</li>
          <li class="filter_clarity" id="filter_fluoSTG" onclick="filter_fluo('STG')">强</li>
          <li class="filter_clarity" id="filter_fluoMED" onclick="filter_fluo('MED')">中</li>
          <li class="filter_clarity" id="filter_fluoFNT" onclick="filter_fluo('FNT')">弱</li>
          <li class="filter_clarity" id="filter_fluoNON" onclick="filter_fluo('NON')">无</li>
        </ul>
      </div>
    </div>
    <div class="filter_line">
      <div class="filter_line_inner" id="filter_line_cut" style="border-width: 1px;">
        <span class="filter_title">切工<br />cut
        </span>
        <ul>
          <li class="filter_3ex filter_clarity ex" id="filter_cutEX" onclick="filter_cut('EX')">EX</li>
          <li class="filter_3ex filter_clarity" id="filter_cutVG" onclick="filter_cut('VG')">VG</li>
          <li class="filter_3ex filter_clarity" id="filter_cutG" onclick="filter_cut('G')">G</li>
          <li class="filter_3ex filter_clarity" id="filter_cutF" onclick="filter_cut('F')">F</li>
        </ul>
      </div>
      <div class="filter_line_inner" id="filter_line_polish" style="border-width: 1px;">
        <span class="filter_title">抛光<br />polish
        </span>
        <ul>
          <li class="filter_3ex filter_clarity ex" id="filter_polishEX" onclick="filter_polish('EX')">EX</li>
          <li class="filter_3ex filter_clarity" id="filter_polishVG" onclick="filter_polish('VG')">VG</li>
          <li class="filter_3ex filter_clarity" id="filter_polishG" onclick="filter_polish('G')">G</li>
          <li class="filter_3ex filter_clarity" id="filter_polishF" onclick="filter_polish('F')">F</li>
        </ul>
      </div>
      <div class="filter_line_inner" id="filter_line_symm" style="border-width: 1px;">
        <span class="filter_title">对称性<br />sym
        </span>
        <ul>
          <li class="filter_3ex filter_clarity ex" id="filter_symEX" onclick="filter_sym('EX')">EX</li>
          <li class="filter_3ex filter_clarity" id="filter_symVG" onclick="filter_sym('VG')">VG</li>
          <li class="filter_3ex filter_clarity" id="filter_symG" onclick="filter_sym('G')">G</li>
          <li class="filter_3ex filter_clarity" id="filter_symF" onclick="filter_sym('F')">F</li>
        </ul>
      </div>
      <div class="filter_line_inner" id="filter_line_symm" style="border-width: 1px;">
        <button type="button" id="btn_3ex" >3EX</button>
      </div>
      <div class="filter_line_inner" id="filter_line_symm" style="border-width: 1px;">
        <input type="checkbox" name="sold_status" value="SOLD">rapnet已售出
      </div>
    </div>
    <div class="filter_line">
      <div class="filter_line_inner" id="filter_line_lab" style="border-width: 1px;">
        <span class="filter_title">证书<br />Certi
        </span>
        <ul>
          <li class="filter_clarity" id="filter_certiIGI" onclick="filter_certi('IGI')">IGI</li>
          <li class="filter_clarity" id="filter_certiHRD" onclick="filter_certi('HRD')">HRD</li>
          <li class="filter_clarity" id="filter_certiGIA" onclick="filter_certi('GIA')">GIA</li>
        </ul>
      </div>
      <div class="filter_line_inner" id="filter_line_stockref" style="left: 0;">
        <span class="filter_title" style="display: inline-block; position: relative;">按库存编号/证书编号查询</span> <input
          name="stockreftosearch" id="stockreftosearch" style="width: 128px; position: relative; margin-left: 25px;" />
        <button id="stockrefbtn" onclick="searchbystockref()">查找</button><button id="orderBtn" onclick="hide()">隐藏购物车</button>
      </div>
    </div>
    <p id="filtertab">筛选结果</p>
  </div>
  </div>
  <div id="dia_fancy_box" style="display:none">
  	<div class="filter_line">
    	  <div class="filter_line_inner" id="filter_line_color" style="border-width: 1px;">
      <span class="filter_title" id="filter_title_shape">形状<br />shape
      </span>
      <ul class="fileber_shape_outer">
        <li class="filter_clarity filter_shape" id="filter_shapeBR" onclick="filter_shape('BR')"><img
          src="../images/site_elements/icons/01.gif" /></li>
        <li class="filter_clarity filter_shape" id="filter_shapePS" onclick="filter_shape('PS')"><img
          src="../images/site_elements/icons/02.gif" /></li>
        <li class="filter_clarity filter_shape" id="filter_shapePR" onclick="filter_shape('PR')"><img
          src="../images/site_elements/icons/03.gif" /></li>
        <li class="filter_clarity filter_shape" id="filter_shapeHS" onclick="filter_shape('HS')"><img
          src="../images/site_elements/icons/08.gif" /></li>
        <li class="filter_clarity filter_shape" id="filter_shapeMQ" onclick="filter_shape('MQ')"><img
          src="../images/site_elements/icons/05.gif" /></li>
        <li class="filter_clarity filter_shape" id="filter_shapeOV" onclick="filter_shape('OV')"><img
          src="../images/site_elements/icons/11.gif" /></li>
        <li class="filter_clarity filter_shape" id="filter_shapeEM" onclick="filter_shape('EM')"><img
          src="../images/site_elements/icons/10.gif" /></li>
        <li class="filter_clarity filter_shape" id="filter_shapeRAD" onclick="filter_shape('RAD')"><img
          src="../images/site_elements/icons/06.gif" /></li>
        <li class="filter_clarity filter_shape" id="filter_shapeCU" onclick="filter_shape('CU')"><img
          src="../images/site_elements/icons/12.gif" /></li>
      </ul>
      </div>
      <div class="filter_line_inner" style="border-width: 1px;">
        <span class="filter_title" style="top: -5px;">价格(美元)<br />price($)
        </span>
        <div id="filter_line_price">
          <input type="text" id="price_from" class="inputChg" value="50" /> - <input type="text" id="price_to" class="inputChg" value="999999" />
          <!--  <div id="slider-range" style="display: inline-block; width: 108px; margin-left: 25px;"></div>-->
        </div>
      </div>
      <div class="filter_line_inner" style="border-width: 1px;"> 
        <span class="filter_title" style="top: -4px;">重量<br />carat
        </span>
        <div id="filter_line_weight">
          <input type="text" id="weight_from" class="inputChg" value="0.01" /> - <input type="text" id="weight_to" class="inputChg" value="50" />
          <!--  <div id="slider-range-weight" style="display: inline-block; width: 188px; margin-left: 25px;"></div>-->
        </div>
      </div>
    </div>
    
    <div class="filter_line">
      <div class="filter_line_inner" id="filter_line_cut" style="border-width: 1px;">
        <span class="filter_title">颜色<br />cut
        </span>
        <ul>
          <li class="filter_clarity filter_fancy_color" fancy="Y" >黄</li>
          <li class="filter_clarity filter_fancy_color" fancy="R" >红</li>
          <li class="filter_clarity filter_fancy_color" fancy="P" >粉</li>
          <li class="filter_clarity filter_fancy_color" fancy="G" >绿</li>
          <li class="filter_clarity filter_fancy_color" fancy="B" >蓝</li>
        </ul>
      </div>
      <div class="filter_line_inner" id="filter_line_polish" style="border-width: 1px;">
        <span class="filter_title">抛光<br />polish
        </span>
        <ul>
          <li class="filter_clarity" id="filter_polishEX" onclick="filter_polish('EX')">EX</li>
          <li class="filter_clarity" id="filter_polishVG" onclick="filter_polish('VG')">VG</li>
          <li class="filter_clarity" id="filter_polishG" onclick="filter_polish('G')">G</li>
          <li class="filter_clarity" id="filter_polishF" onclick="filter_polish('F')">F</li>
        </ul>
      </div>
      <div class="filter_line_inner" id="filter_line_symm" style="border-width: 1px;">
        <span class="filter_title">对称性<br />sym
        </span>
        <ul>
          <li class="filter_clarity" id="filter_symEX" onclick="filter_sym('EX')">EX</li>
          <li class="filter_clarity" id="filter_symVG" onclick="filter_sym('VG')">VG</li>
          <li class="filter_clarity" id="filter_symG" onclick="filter_sym('G')">G</li>
          <li class="filter_clarity" id="filter_symF" onclick="filter_sym('F')">F</li>
        </ul>
      </div>
    </div>
    <div class="filter_line">
      <div class="filter_line_inner" id="filter_line_color" style="border-width: 1px;">
        <span class="filter_title">颜色<br />color
        </span>
        <ul>
          <li class="filter_clarity filter_fancy" fancy="FL">Fancy Light</li>
          <li class="filter_clarity filter_fancy" fancy="F">Fancy</li>
          <li class="filter_clarity filter_fancy" fancy="FI">Fancy Intence</li>
          <li class="filter_clarity filter_fancy" fancy="FD">Fancy Deep</li>
          <li class="filter_clarity filter_fancy" fancy="FV">Fancy Vivld</li>
        </ul>
      </div>
      <div class="filter_line_inner" id="filter_line_clarity" style="border-width: 1px;">
        <span class="filter_title">净度<br />clarity
        </span>
        <ul>
          <li class="filter_clarity" id="filter_clarityFL" onclick="filter_clarity('FL')">FL</li>
          <li class="filter_clarity" id="filter_clarityIF" onclick="filter_clarity('IF')">IF</li>
          <li class="filter_clarity" id="filter_clarityWS1" onclick="filter_clarity('WS1')">VVS1</li>
          <li class="filter_clarity" id="filter_clarityWS2" onclick="filter_clarity('WS2')">VVS2</li>
          <li class="filter_clarity" id="filter_clarityVS1" onclick="filter_clarity('VS1')">VS1</li>
          <li class="filter_clarity" id="filter_clarityVS2" onclick="filter_clarity('VS2')">VS2</li>
          <li class="filter_clarity" id="filter_claritySI1" onclick="filter_clarity('SI1')">SI1</li>
          <li class="filter_clarity" id="filter_claritySI2" onclick="filter_clarity('SI2')">SI2</li>
        </ul>
      </div>
      <div class="filter_line_inner">
        <span class="filter_title">荧光<br />fluo
        </span>
        <ul>
          <li class="filter_clarity" id="filter_fluoVST" onclick="filter_fluo('VST')">极强</li>
          <li class="filter_clarity" id="filter_fluoSTG" onclick="filter_fluo('STG')">强</li>
          <li class="filter_clarity" id="filter_fluoMED" onclick="filter_fluo('MED')">中</li>
          <li class="filter_clarity" id="filter_fluoFNT" onclick="filter_fluo('FNT')">弱</li>
          <li class="filter_clarity" id="filter_fluoNON" onclick="filter_fluo('NON')">无</li>
        </ul>
      </div>
    </div>
    
    <div class="filter_line">
      <div class="filter_line_inner" id="filter_line_lab" style="border-width: 1px;">
        <span class="filter_title">证书<br />Certi
        </span>
        <ul>
          <li class="filter_clarity" id="filter_certiIGI" onclick="filter_certi('IGI')">IGI</li>
          <li class="filter_clarity" id="filter_certiHRD" onclick="filter_certi('HRD')">HRD</li>
          <li class="filter_clarity" id="filter_certiGIA" onclick="filter_certi('GIA')">GIA</li>
        </ul>
      </div>
      <div class="filter_line_inner" id="filter_line_stockref" style="left: 0;">
        <span class="filter_title" style="display: inline-block; position: relative;">按库存编号/证书编号查询</span> <input
          name="stockreftosearch" id="stockreftosearch" style="width: 128px; position: relative; margin-left: 25px;" />
        <button id="stockrefbtn" onclick="searchbystockref()">查找</button><button id="orderBtn" onclick="hide()">隐藏购物车</button>
      </div>
    </div>
  </div>
    
</div>
<div class="main_contentbox" id="diamondscontentbox">
  <div id="tableheader">
    <p id="listdescription">
      为您找到 <span id="resulthowmany">0</span> 条结果: <span id="dia-page-selector">第 <span id="diapagenavi">1</span> 页
      </span>
      <!--<span id="more">更多》</span>-->
    </p>
    <table cellpadding="2" cellspacing="0" border="0"
      style="border-style: solid; border-width: 1px; border-color: #666;">
      <tr class="t_h">
        <td align="center" class="1st_col" style="width: 37px;"><input id="checkAll" type="checkbox" />预定</td>
        <td align="center" class="1st_col" style="width: 80px;">库存编号</td>
        <td align="center" style="width: 41px;">形状</td>
        <td align="center" style="width: 38px;"><img class="iconarrow" id="arrow_sorting_weight" width="8"
          src="../images/site_elements/arrow-down.png" />
          <button type="button" class="sortbtn" title="点击排序" style="background-color: #FFF; color: #000;"
            onclick="sorting_weight()">重量</button></td>
        <td align="center" style="width: 28px;">色级</td>
        <td align="center" style="width: 38px;">净度</td>
        <td align="center" style="width: 96px;">证书</td>
        <td align="center">切工</td>
        <td align="center">抛光</td>
        <td align="center" style="white-space: nowrap;">对称性</td>
        <td align="center" style="width: 72px;">荧光</td>
<?php
if ($superAdmin) {
	?>
<td align="center" style="width: 72px;">零售价格($)</td>
<?php } ?>
<?php if($_SESSION['username']!='gnkf'){ ?>
        <td align="center" style="width: 72px;"><img class="iconarrow" id="arrow_sorting_price" width="8"
          src="../images/site_elements/arrow-down.png" />
          <button type="button" class="sortbtn" title="点击排序" style="background-color: #FFF; color: #000;"
            onclick="sorting_price()">价格($)</button></td>
        <td align="center" style="width: 72px;">价格(€)</td>
        <td align="center" style="width: 72px;">价格(¥)</td>
        <td align="center" style="width: 72px;">价格(£)</td>
		<?php }?>


<?php
if ($superAdmin) {
	?>
<td align="center" style="width: 59px;">公司名</td>
<?php
}
?>

</tr>
    </table>
  </div>
  <div id="diamondsdata" style="padding-bottom: 35px;"></div>
</div>
<div id="loading_indi"
  style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: #FFF; background-color: rgba(255, 255, 255, 0.7); z-index: 6; display: none;">
  <p
    style="position: relative; top: 50%; margin-top: -50px; width: 128px; height: 70px; margin-left: auto; margin-right: auto; text-align: center; background-color: #FFF; padding-top: 20px; border-radius: 8px;">
    <img width="25px" src="../images/site_elements/loadingGraphic.gif" /><br /> <span
      style="position: relative; left: 8px; display: inline-block; margin-top: 12px;">载入中...</span>
  </p>
</div>
<script>
$(document).ready(function(){
  	$("#appointmentTime").val(moment().format("YYYY-MM-DD hh:mm"));
  	$('#appointmentTime').datetimepicker({format:'Y-m-d H:i',step: 30});
})
</script>
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
//======================= cut ==========================
var $cutEX=false;
var $cutVG=false;
var $cutG=false;
var $cutF=false;

var $cut='';

//======================= sym ==========================
var $symEX=false;
var $symVG=false;
var $symG=false;
var $symF=false;

var $sym='';

//======================= polish ==========================
var $polishEX=false;
var $polishVG=false;
var $polishG=false;
var $polishF=false;

var $polish='';

//======================= certi ==========================
var $certiIGI=false;
var $certiHRD=false;
var $certiGIA=false;

var $certi='';

//======================= fluo ==========================
var $fluoVST=false;
var $fluoSTG=false;
var $fluoMED=false;
var $fluoFNT=false;
var $fluoNON=false;
var $fluo='';
var $weight_from = '';
var $weight_to = '';
var $price_from = '';
var $price_to = '';
var $sorting = 'price';
var $sorting_weight_direction = 'ASC';
var $sorting_color_direction = 'ASC';
var $sorting_clarity_direction = 'ASC';
var $sorting_cut_direction = 'ASC';
var $sorting_price_direction = 'ASC';
var $sorting_direction = 'ASC';

var $crr_page=1;
var $fromCompany;
function filterFromCompany() {
	$fromCompany = ""+$('#fromCompanySelect').val();
	if($fromCompany=="all"||$fromCompany=="null")
		$fromCompany = null;
	//update();
}
function filter_shape(theshape){
	var $theshape=theshape;
	var $or='';
	$shape='';

	if($theshape=='BR'){
		if($shapeBR){
			$shapeBR=false; 
		}else{
			$shapeBR=true;
		}
	}else if($theshape=='PS'){
		if($shapePS){
			$shapePS=false;
		}else{
			$shapePS=true;
		}
	}else if($theshape=='PR'){
		if($shapePR){
			$shapePR=false;
		}else{
			$shapePR=true;
		}
	}else if($theshape=='HS'){
		if($shapeHS){
			$shapeHS=false;
		}else{
			$shapeHS=true;
		}
	}else if($theshape=='MQ'){
		if($shapeMQ){
			$shapeMQ=false;
		}else{
			$shapeMQ=true;
		}
	}else if($theshape=='OV'){
		if($shapeOV){
			$shapeOV=false;
		}else{
			$shapeOV=true;
		}
	}else if($theshape=='EM'){
		if($shapeEM){
			$shapeEM=false;
		}else{
			$shapeEM=true;
		}
	}else if($theshape=='RAD'){
		if($shapeRAD){
			$shapeRAD=false;
		}else{
			$shapeRAD=true;
		}
	}else if($theshape=='CU'){
		if($shapeCU){
			$shapeCU=false;
		}else{
			$shapeCU=true;
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

	//update();
}
function filter_color(thecolor){
}

function filter_clarity(theclarity){
	var $theclarity=theclarity;
	var $or='';
	$clarity='';

	if($theclarity=='FL'){
		if($clarityFL){
			$clarityFL=false;
		}else{
			$clarityFL=true;
		}
	}else if($theclarity=='IF'){
		if($clarityIF){
			$clarityIF=false;
		}else{
			$clarityIF=true;
		}
	}else if($theclarity=='WS1'){
		if($clarityWS1){
			$clarityWS1=false;
		}else{
			$clarityWS1=true;
		}
	}else if($theclarity=='WS2'){
		if($clarityWS2){
			$clarityWS2=false;
		}else{
			$clarityWS2=true;
		}
	}else if($theclarity=='VS1'){
		if($clarityVS1){
			$clarityVS1=false;
		}else{
			$clarityVS1=true;
		}
	}else if($theclarity=='VS2'){
		if($clarityVS2){
			$clarityVS2=false;
		}else{
			$clarityVS2=true;
		}
	}else if($theclarity=='SI1'){
		if($claritySI1){
			$claritySI1=false;
		}else{
			$claritySI1=true;
		}
	}else if($theclarity=='SI2'){
		if($claritySI2){
			$claritySI2=false;
		}else{
			$claritySI2=true;
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
		$clarity+=$or+' clarity = "VVS1" ';
		$or = ' OR ';
	}
	if($clarityWS2){
		$clarity+=$or+' clarity = "VVS2" ';
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


	//update();
}


function filter_cut(thegrade){
	var $thecutgrade=thegrade;
	var $or='';
	$cut='';

	if($thecutgrade=='EX'){
		if($cutEX){
			$cutEX=false;
		}else{
			$cutEX=true;
		}
	}else if($thecutgrade=='VG'){
		if($cutVG){
			$cutVG=false;
		}else{
			$cutVG=true;
		}
	}else if($thecutgrade=='G'){
		if($cutG){
			$cutG=false;
		}else{
			$cutG=true;
		}
	}else if($thecutgrade=='F'){
		if($cutF){
			$cutF=false;
		}else{
			$cutF=true;
		}
	}

	if($cutEX){
		$cut+=' cut_grade = "EX" ';
		$or= ' OR ';
	}
	if($cutVG){
		$cut+=$or+' cut_grade = "VG" ';
		$or= ' OR ';
	}
	if($cutG){
		$cut+=$or+' cut_grade = "G" ';
	    $or= ' OR ';
	}
	if($cutF){
		$cut+=$or+' cut_grade = "F" ';
		$or= ' OR ';
	}


	//update();
}

//filter polish =============================
//filter polish =============================
//filter polish =============================
//filter polish =============================
function filter_polish(thegrade){
	var $thepolishgrade=thegrade;
	var $or='';
	$polish='';

	if($thepolishgrade=='EX'){
		if($polishEX){
			$polishEX=false;
		}else{
			$polishEX=true;
		}
	}else if($thepolishgrade=='VG'){
		if($polishVG){
			$polishVG=false;
		}else{
			$polishVG=true;
		}
	}else if($thepolishgrade=='G'){
		if($polishG){
			$polishG=false;
		}else{
			$polishG=true;
		}
	}else if($thepolishgrade=='F'){
		if($polishF){
			$polishF=false;
		}else{
			$polishF=true;
		}
	}

	if($polishEX){
	    $polish+=' polish = "EX" ';
		$or= ' OR ';
	}
	if($polishVG){
		$polish+=$or+' polish = "VG" ';
		$or= ' OR ';
	}
	if($polishG){
		$polish+=$or+' polish = "G" ';
		$or= ' OR ';
	}
	if($polishF){
		$polish+=$or+' polish = "F" ';
		$or= ' OR ';
	}
	//update();
}

function filter_sym(thegrade){
	var $thesymgrade=thegrade;
	var $or='';
	$sym='';

	if($thesymgrade=='EX'){
		if($symEX){
			$symEX=false;
		}else{
			$symEX=true;
		}
	}else if($thesymgrade=='VG'){
		if($symVG){
			$symVG=false;
		}else{
			$symVG=true;
		}
	}else if($thesymgrade=='G'){
		if($symG){
			$symG=false;
		}else{
			$symG=true;
		}
	}else if($thesymgrade=='F'){
		if($symF){
			$symF=false;
		}else{
			$symF=true;
		}
	}

	if($symEX){
		$sym+=' symmetry = "EX" ';
		$or= ' OR ';
	}
	if($symVG){
		$sym+=$or+' symmetry = "VG" ';
		$or= ' OR ';
	}
	if($symG){
		$sym+=$or+' symmetry = "G" ';
		$or= ' OR ';
	}
	if($symF){
		$sym+=$or+' symmetry = "F" ';
		$or= ' OR ';
	}
	//update();
}

function filter_certi(thelab){
	var $thecerti=thelab;
	var $or='';
	$certi='';

	if($thecerti=='IGI'){
		if($certiIGI){
			$certiIGI=false;
		}else{
			$certiIGI=true;
		}
	}else if($thecerti=='GIA'){
		if($certiGIA){
			$certiGIA=false;
		}else{
			$certiGIA=true;
		}
	}else if($thecerti=='HRD'){
		if($certiHRD){
			$certiHRD=false;
		}else{
			$certiHRD=true;
		}
	}

	if($certiIGI){
		$certi+=' grading_lab = "IGI" ';
		$or= ' OR ';
	}
	if($certiGIA){
		$certi+=$or+' grading_lab = "GIA" ';
		$or= ' OR ';
	}
	if($certiHRD){
		$certi+=$or+' grading_lab = "HRD" ';
		$or= ' OR ';
	}

	//update();
}

function filter_fluo(thegrade){
	var $thefluo=thegrade;
	var $or='';
	$fluo='';
	//VST STG MED FNT NON
	if($thefluo=='VST'){
		if($fluoVST){
			$fluoVST=false;
		}else{
			$fluoVST=true;
		}
	}else if($thefluo=='STG'){
		if($fluoSTG){
			$fluoSTG=false;
		}else{
			$fluoSTG=true;
		}
	}else if($thefluo=='MED'){
		if($fluoMED){
			$fluoMED=false;
		}else{
			$fluoMED=true;
		}
	}else if($thefluo=='FNT'){
		if($fluoFNT){
			$fluoFNT=false;
		}else{
			$fluoFNT=true;
		}
	}else if($thefluo=='NON'){
		if($fluoNON){
			$fluoNON=false;
		}else{
			$fluoNON=true;
		}
	}

	if($fluoVST){
		$fluo+=' fluorescence_intensity = "VST" OR fluorescence_intensity = "Very Strong" ';
		$or= ' OR ';
	}
	if($fluoSTG){
		$fluo+=$or+' fluorescence_intensity = "STG" OR fluorescence_intensity = "Strong" ';
		$or= ' OR ';
	}
	if($fluoMED){
		$fluo+=$or+' fluorescence_intensity = "MED" OR fluorescence_intensity = "Medium" ';
		$or= ' OR ';
	}
	if($fluoFNT){
		$fluo+=$or+' fluorescence_intensity = "FNT" OR fluorescence_intensity = "SLT"  OR fluorescence_intensity = "VSL" OR fluorescence_intensity = "Faint" OR fluorescence_intensity = "Very Slight" OR fluorescence_intensity = "Slight" ';
		$or= ' OR ';
	}
	if($fluoNON){
		$fluo+=$or+' fluorescence_intensity = "NON" OR fluorescence_intensity = "None"';
		$or= ' OR ';
	}
	//update();
}


function sorting_weight(){
	$sorting='weight';
	if($sorting_weight_direction == 'ASC'){
		$sorting_weight_direction = 'DESC';
		$('#arrow_sorting_weight').attr('src','../images/site_elements/arrow-down.png?v=2');
	}else{
		$sorting_weight_direction = 'ASC';
		$('#arrow_sorting_weight').attr('src','../images/site_elements/arrow-up.png?v=2');
	}
	$sorting_direction=$sorting_weight_direction;
	//update();
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
	//update();
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
	//update();
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
	//update();
}
function sorting_price(){
	$sorting = 'price';
	if($sorting_price_direction == 'ASC'){
		$sorting_price_direction = 'DESC';
		$('#arrow_sorting_price').attr('src','../images/site_elements/arrow-down.png?v=2');
	}else{
		$sorting_price_direction = 'ASC';
		$('#arrow_sorting_price').attr('src','../images/site_elements/arrow-up.png?v=2');
	}
	$sorting_direction=$sorting_price_direction;
	//update();
}

function arrowDirection(){
	if($sorting_weight_direction == 'ASC'){
		$('#arrow_sorting_weight').attr('src','../images/site_elements/arrow-down.png?v=2');
	}else{
		$('#arrow_sorting_weight').attr('src','../images/site_elements/arrow-up.png?v=2');
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
function count(o){
	var t = typeof o;
	if(t == 'string'){
	return o.length;
	}else if(t == 'object'){
	var n = 0;
	for(var i in o){
	n++;
	}
	return n;
	}
	return false;
}
function update(){
	$colorArr = new Array();
	$('.filter_color').each(function(){
		if($(this).hasClass('btn-active'))
			$colorArr.push('"'+$(this).text()+'"');
	});
	if($("#btn_dia_fancy").hasClass('btn_selected')) {
		$color = $fancy;
		$('.filter_fancy_color').each(function(){
			if($(this).hasClass('btn-active')) {
				$colorArr.push('color like "F%'+$(this).attr("fancy")+'"');
			}
		});
		if(count($colorArr)>0)
			$color += " and ( "+$colorArr.join(" or ")+")";
		$colorArr = new Array();
		$('.filter_fancy').each(function(){
			if($(this).hasClass('btn-active')) {
				$colorArr.push('color like "'+$(this).attr("fancy")+'%"');
			}
		});
		if(count($colorArr)>0)
			$color += " and ( "+$colorArr.join(" or ")+")";
	}
	else if(count($colorArr)>0) 
		$color = " color in ("+$colorArr.join(",")+")";
	$weight_from=$('#weight_from').val();
	$weight_to=$('#weight_to').val();
	$price_from=$('#price_from').val();
	$price_to=$('#price_to').val();
	$sold_status=$('input[name="sold_status"]').is(':checked')?"SOLD":"";
	nowworkingonfilter=true;
	$('div#loading_indi').fadeIn('fast');
	$.post(
		"diamond-data.php",
		{sold_status:$sold_status,fromCompany:$fromCompany, shape:$shape, color:$color, clarity:$clarity, cut:$cut, polish:$polish, sym:$sym, fluo:$fluo, certi:$certi, weight_from:$weight_from, weight_to:$weight_to, price_from:$price_from, price_to:$price_to, featured: $featured, sorting:$sorting, sorting_direction:$sorting_direction, crr_page:$crr_page},
		function(data){
			var contentLoaded=data;
			//alert(data);
			$('div#loading_indi').fadeOut('fast');
			$('div#diamondsdata').html(data);
			//var howmanyrecords=$("div#howmanyrecords").html();
			//$('span#resulthowmany').html(howmanyrecords);
			//dia-page-navi-bottom
			$('p#listdescription').html($('#dia-page-navi-bottom').html());
			diamondlistpagenavi(howmanyrecords);
			arrowDirection();
			addlisteners();
			//fetchCompanies();
			update_selected();
			//更新公司列表
		}
	);
}

function choosethispage(page){
	$crr_page=page;
	update();
}

var crrlistnavipage=0;
var $intotalhowmanyrecords=0;
function diamondlistpagenavi(howmanyrecords){
	$intotalhowmanyrecords=howmanyrecords;
	$('span#diapagenavi').empty();
	var totalrecords=parseFloat(howmanyrecords);
	var totalpages=Math.ceil(totalrecords/35);
	for(var i=crrlistnavipage*10+1; i<=totalpages; i++){
		if(i<=crrlistnavipage*35+10){
			if(i==$crr_page){
				$('span#diapagenavi').append('<span class="dia-page-btn" id="crr_page">'+i+'</span>');
			}else{
				$('span#diapagenavi').append('<span class="dia-page-btn" onclick="choosethispage('+i+')">'+i+'</span>');
			}
		}
	}
}

function update_selected(){
	orderlist=[];
	$('span.an_order').each(function(){
		var crr_order=$(this).html();
		orderlist.push(crr_order);
	});
	//$.inArray(
	$('input.selectcheckbox').each(function(){
		var crr_obj=$(this);
		var crr_id_raw=crr_obj.attr('id');
		var crr_ref=crr_id_raw.replace('check_', '');
		if($.inArray(crr_ref, orderlist)>-1){
			//alert(orderlist);
			crr_obj.prop( "checked", true );
		}
	});
}

function fetchCompanies(){
	//company doesn't need to fetch anymore
	$.get("/action.php?action=distinctCompany",
		function(data){
			$('#fromCompanySelect').empty();
			var array = data.split(",")
			for(j = 0,len=array.length; j < len-1; j++) {
				console.log(array[j]);
				//$("#fromCompanySelect").append("<option value="+array[j]+">"+array[j]+"</option>");
			}
			
		}
	);
}

function searchbystockref(){
	var theStockRef=$('input#stockreftosearch').val();
	if($.trim(theStockRef)==''){$crr_page=1;
		update();
		return;
	}else {
		$.post(
			"diamond-data-byref.php",
			{stockref:theStockRef},
			function(data){
				var contentLoaded=data;
				//alert(data);
				$('div#loading_indi').fadeOut('fast');
				$('div#diamondsdata').html(data);
				//var howmanyrecords=$("div#howmanyrecords").html();
				//$('span#resulthowmany').html(howmanyrecords);
				//dia-page-navi-bottom
				$('p#listdescription').html($('#dia-page-navi-bottom').html());
				diamondlistpagenavi(howmanyrecords);
				arrowDirection();
				addlisteners();
				//fetchCompanies();
				update_selected();
			}
		);
	}
}
</script>
<script type="text/javascript">
$(document).ready(function(){
	$(".filter_clarity").click(function () {
		if($(this).hasClass("btn-active"))
        		$(this).removeClass("btn-active");
		else
			$(this).addClass("btn-active");
		//update();
	});
    $("#fromCompanySelect").change(function() { filterFromCompany(); });
	$("#checkAll").click(function(){
		var c = this.checked;
		$("input.selectcheckbox").each(function(){
			var crr_obj=$(this);
			crr_obj.prop('checked', c);
			var crr_id_raw=crr_obj.attr('id');
			var crr_ref=crr_id_raw.replace('check_', '');
			if(c) {
				makeorder(crr_ref);
			}
			else {
				$('span#order_'+crr_ref).remove();
			}
		}); 
	});
    $("#stockreftosearch").keydown(function(e){
      var curKey = e.which;
      if(curKey == 13){
        $("#stockrefbtn").click();
        return false;
      }
    });

	addlisteners();
<?php
if (isset ( $_GET ['ref'] ) && $_GET ['ref'] == 'round') {
	?>
	$('#roundbtn').css({'border-bottom-style':'solid', 'border-width':'2px'});
	filter_shape("BR");
<?php
} else if (isset ( $_GET ['ref'] ) && $_GET ['ref'] == 'featured') {
	?>
	$('#featuredbtn').css({'border-bottom-style':'solid','border-width':'2px'});
	$featured='YES';
	//update();
<?php
} else if (isset ( $_GET ['ref'] ) && $_GET ['ref'] == 'special') {
	?>
	$('#specialbtn').css({'border-bottom-style':'solid','border-width':'2px'});
	$shapePS=true;
	$shapePR=true;
	$shapeHS=true;
	$shapeMQ=true;
	$shapeOV=true;
	$shapeEM=true;
	$shapeRAD=true;

	$('#filter_shapePS').addClass('btn-active');
	$('#filter_shapePR').addClass('btn-active');
	$('#filter_shapeHS').addClass('btn-active');
	$('#filter_shapeMQ').addClass('btn-active');
	$('#filter_shapeOV').addClass('btn-active');
	$('#filter_shapeEM').addClass('btn-active');
	$('#filter_shapeRAD').addClass('btn-active');

	filter_shape("CU");
<?php
} else {
	?>
	//update();
<?php
}
?>
});

function addlisteners(){
	//$('#weight_from, #price_from').off();

	$('#btn_price, #btn_weight').off();

	$('#btn_weight').click(function(){

		$weight_from=$('#weight_from').val();
		$weight_to=$('#weight_to').val();

		//update();
	});

	$('#btn_price').click(function(){

		$price_from=$('#price_from').val();
		$price_to=$('#price_to').val();

		//update();
	});

	$('span#more').click(function(){
		crrlistnavipage++;//$intotalhowmanyrecords
		diamondlistpagenavi($intotalhowmanyrecords);
	});
<?php
if ($username == 'super001' && isset ( $allowdisableselection )) {
	?>
	$('input.selectcheckbox').attr('disabled','disabled');
<?php
}
?>

}

function makeorder(theRef){
	<?php
	if ($username == 'super001' && isset ( $allowdisableselection )) {
		?>
	alert('您现在的账户是超级管理员，自己不能购买自己的产品');
	<?php
	} else {
		?>
	if($("#check_"+theRef).prop("checked")){
		//alert('c');
		$('#theorders').prepend('<span class="an_order" id="order_'+theRef+'">'+theRef+'</span>');
	}else{
		$('span#order_'+theRef).remove();
	}
	return;
	var refnumber=theRef;
	$('#indication').fadeIn('fast');
	$.post(
		"../_admin/saveorder.php",
		{stock_ref: refnumber},
		function(data){
			logger("save order result:".data);
			if($.trim(data)=='OK'){
				alert('ordered');
			}else{
				alert('Server is busy, please try later!');
			}
			$('#indication').fadeOut('fast');
		}
	);
	<?php
	}
	?>
}
function appointment(){
	$('#appointment').show();
	$('#makeAppointmentBtn').text('确定预约');
	$('#makeAppointmentBtn').attr('onClick','appointmentConfirm()');
}
function appointmentConfirm(){
	var stockref='(';
	$('span.an_order').each(function(){
		stockref+="'"+$(this).html()+"',";
	});stockref = stockref.substring(0,stockref.length-1);
	stockref+=')';
	$.post(
			"../_admin/saveorder.php",
			{action:'appointment',stock_ref: stockref,customer:$('#customer').val(),appointment_time:$('#appointmentTime').val()},
			function(data){
				if($.trim(data)=='OK'){
					alert('已经成功预约，客户：'+$('#customer').val()+"，时间："+$('#appointmentTime').val());
					$('#alreadyordered').prepend($('#theorders').html());
					$('#theorders').html('');
				}else{
					alert('Server is busy, please try later!');
				}
				$('#indication').fadeOut('fast');
			}
		);
	$('#appointment').hide();
	$('#makeAppointmentBtn').text('预约');
	$('#makeAppointmentBtn').attr('onClick','appointment()');
}
function confirmorder(){
	var stockref='(';
	$('span.an_order').each(function(){
		stockref+="'"+$(this).html()+"',";
	});
	stockref = stockref.substring(0,stockref.length-1);
	stockref+=')';
	$.post(
		"../_admin/saveorder.php",
		{stock_ref: stockref,action:'order'},
		function(data){
			if($.trim(data)=='OK'){
				alert('已经成功预定');
				$('#alreadyordered').prepend($('#theorders').html());
				$('#theorders').html('');
			}else{
				alert('Server is busy, please try later!');
			}
			$('#indication').fadeOut('fast');
		}
	);
}

function removeFromSession(stockref){
		$.post(
				"cv.php",
				{stockref:stockref, action:'removeFromSession'},
				function(data){
					if(data=='error'){
						alert('未知错误，即将刷新浏览器，请稍后重试'+data);
					}
					else {
						$('#visiable-'+stockref).remove();
					}
				}
		);
}


function chgVisiable(stockref,visiable){
$('button#visiable-'+stockref).html('修改中...');
		$.post(
				"cv.php",
				{stockref:stockref, visiable:visiable,action:'chgVisiable'},
				function(data){
					if(data=='error'){
						alert('未知错误，即将刷新浏览器，请稍后重试'+data);
					}
					else {
						if(data=='1')
							$('button#visiable-'+stockref).html('隐藏');
						else
							$('button#visiable-'+stockref).html('取消隐藏');
					}
				}
		);
}
	function deleteK(){
	var r=confirm("您确认全部删除K字头的钻石信息吗？");
		if(r==true){	
			$.post(
					"cv.php",
					{action:'deleteK'},
					function(data){
						if(data=='error'){
							alert('未知错误，即将刷新浏览器，请稍后重试'+data);
						}
						else {
							alert('共删除了'+data+'条纪录。');
							//update();
						}
					}
			);
		}
	}

$allEX=false;
$diaChoose=true;
$diaFancyChoose=false;
$fancy="";
function clearChoose() {
	$(".filter_clarity").removeClass("btn_selected");
	$fromCompany="";$fancy="";
	$shape=""; $color="";$clarity="";$cut="";$polish="";$sym="";$fluo="";$certi="";
	$weight_from="";$weight_to="";$price_from="";$price_to="";
	$featured="";$sorting="";$sorting_direction="";;
	
}
$(function() {
	$('.customerSel').change(function(){
		$('#customer').val($(this).val());
	});
	$("#btn_dia_fancy").click(function(){
		$("#btn_dia_fancy").addClass("btn_selected");
		$("#dia_choose_box").hide();
		$("#dia_fancy_box").show();
		$("#btn_dia").removeClass("btn_selected");
		clearChoose();
		$fancy=' length(color)>1 and color like "F%"';
		//update();
	});
	$("#btn_dia").click(function(){
		$("#btn_dia_fancy").removeClass("btn_selected");
		$("#dia_choose_box").show();
		$("#dia_fancy_box").hide();
		$("#btn_dia").addClass("btn_selected");
		clearChoose();
		//update();
	});
	$(".inputChg").change(function(){
		//update();
	});
	$(".ex").click(function(){
		var i = 0;
		$('.ex').each(function(){
			if(!$(this).hasClass('btn-active'))
				$('#btn_3ex').removeClass('btn_selected');
			else
				i++;
		});
		if(i==3)
			$('#btn_3ex').addClass('btn_selected');
	});
	$("#btn_3ex").click(function(){
		if($allEX){
			$allEX=false;
			$('#btn_3ex').removeClass('btn_selected');
			//$cut=' cut_grade in("EX","VG","G","F")';
			//$sym=' symmetry in("EX","VG","G","F")';
			//$polish=' polish in("EX","VG","G","F")';
			$('.filter_3ex').removeClass('btn-active');
		}else{
			$allEX=true;
			$('#btn_3ex').addClass('btn_selected');
			$cut=' cut_grade = "EX" ';
			$sym=' symmetry = "EX" ';
			$polish=' polish = "EX" ';
			$('.filter_3ex').removeClass('btn-active');
			$('#filter_cutEX').addClass('btn-active');$('#filter_symEX').addClass('btn-active');
			$('#filter_polishEX').addClass('btn-active');
		}
		//update();
	});
    $( "#slider-range-weight" ).slider({
      range: true,
	  step: 0.1,
      min: 0,
      max: 20,
      values: [ 0.5, 3 ],
      slide: function( event, ui ) {
        //$( "#amount" ).val( "$" + ui.values[ 0 ] + " - $" + ui.values[ 1 ] );
		$('#weight_from').val(ui.values[ 0 ]);
		$('#weight_to').val(ui.values[ 1 ]);
		$weight_from=$('#weight_from').val();
		$weight_to=$('#weight_to').val();
		//update();
      }
    });
  });

$(function() {
    $( "#slider-range" ).slider({
      range: true,
	  step: 100,
      min: 50,
      max: 599999,
      values: [ 75, 30000 ],
      slide: function( event, ui ) {
        //$( "#amount" ).val( "$" + ui.values[ 0 ] + " - $" + ui.values[ 1 ] );
		$('#price_from').val(ui.values[ 0 ]);
		$('#price_to').val(ui.values[ 1 ]);
		$price_from=$('#price_from').val();
		$price_to=$('#price_to').val();
		//update();
      }
    });
  });
</script>
