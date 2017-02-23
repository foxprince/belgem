<?php
session_start();
if(!isset($_SESSION['username'])){
	exit('');
}
if($_SESSION ['account_level']=='0'){
	$superAdmin=true;
}else{
	$superAdmin=false;
}

if(!isset($_POST['shape'])){
	exit('no data posted - shape');
}
if(!isset($_POST['color'])){
	exit('no data posted - color');
}
if(!isset($_POST['clarity'])){
	exit('no data posted - clarity');
}
if(!isset($_POST['weight_from'])){
	exit('no data posted - weightfrom');
}
if(!isset($_POST['weight_to'])){
	exit('no data posted -weightto');
}
if(!isset($_POST['price_from'])){
	exit('no data posted - pricefrom');
}
if(!isset($_POST['price_to'])){
	exit('no data posted - priceto');
}
if(!isset($_POST['featured'])){
	exit('no data posted - featured');
}
if(!isset($_POST['sorting'])){
	exit('no data posted - sorting');
}


if($_POST || $_GET){include('../includes/nuke_magic_quotes.php');}


$and='';

if($_POST['shape']==''){
	$query_shape='';
}else{
	$query_shape=' ('.$_POST['shape'].')';
	$and=' AND ';
}

if($_POST['color']==''){
	$query_color='';
}else{
	$query_color=$and.' ('.$_POST['color'].')';
	$and=' AND ';
}

if($_POST['clarity']==''){
	$query_clarity='';
}else{
	$query_clarity=$and.' ('.$_POST['clarity'].')';
	$and=' AND ';
}

if($_POST['cut']==''){
	$query_cut='';
}else{
	$query_cut=$and.' ('.$_POST['cut'].')';
	$and=' AND ';
}

if($_POST['polish']==''){
	$query_polish='';
}else{
	$query_polish=$and.' ('.$_POST['polish'].')';
	$and=' AND ';
}

if($_POST['sym']==''){
	$query_sym='';
}else{
	$query_sym=$and.' ('.$_POST['sym'].')';
	$and=' AND ';
}

if($_POST['fluo']==''){
	$query_fluo='';
}else{
	$query_fluo=$and.' ('.$_POST['fluo'].')';
	$and=' AND ';
}

if($_POST['certi']==''){
	$query_certi='';
}else{
	$query_certi=$and.' ('.$_POST['certi'].')';
	$and=' AND ';
}

if($_POST['weight_from']==''&&$_POST['weight_to']==''){
	$query_weight_from=0;$query_weight_to=100;
}else if($_POST['weight_from']==''&&$_POST['weight_to']!=''){
	$query_weight_to = str_replace(',','.',$_POST['weight_to']);
	$query_weight_from=$query_weight_to;
}else if($_POST['weight_from']!=''&&$_POST['weight_to']==''){
	$query_weight_from = str_replace(',','.',$_POST['weight_from']);
	$query_weight_to=$query_weight_from;
}else if($_POST['weight_from']!=''&&$_POST['weight_to']!=''){
	$query_weight_from = str_replace(',','.',$_POST['weight_from']);
	$query_weight_to = str_replace(',','.',$_POST['weight_to']);
}
//if($query_weight_from==$query_weight_to) {
	$query_weight_to = $query_weight_to+0.001;
	$query_weight_from = $query_weight_from-0.001;
//}

if($_POST['price_from']==''){
	$query_price_from=0;
}else{
	$query_price_from=$_POST['price_from'];
}

if($_POST['price_to']==''){
	$query_price_to=9999999;
}else{
	$query_price_to=$_POST['price_to'];
}

$featured=$_POST['featured'];
if($featured=='YES'){
	$featured=' AND featured = "YES" ';
}else{
	$featured='';
}

if(isset($_POST['crr_page'])){
	$crr_page=$_POST['crr_page'];
}else{
	$crr_page=1;
}

$startfrom=($crr_page-1)*35;




$sorting_direction=$_POST['sorting_direction'];

$sorting=$_POST['sorting'];


switch ($sorting){

	case "weight":
	$query_sorting =' ORDER BY carat '.$sorting_direction;
	break;

	case "color":
	$query_sorting =' ORDER BY color '.$sorting_direction;
	break;

	case "clarity":
	$query_sorting =' ORDER BY clarity_number '.$sorting_direction;
	break;

	case "cut":
	$query_sorting =' ORDER BY cut_number '.$sorting_direction;
	break;

	case "price":
	$query_sorting =' ORDER BY price '.$sorting_direction;
	break;

	default:
	$query_sorting =' ORDER BY price '.$sorting_direction;
	break;

}




//$query_sorting =' ORDER BY price ASC';

require_once('../includes/connection.php');
$conn=dbConnect('write','pdo');
$conn->query("SET NAMES 'utf8'");

$sql_count='SELECT COUNT(*) AS num FROM diamonds WHERE'.$query_shape.$query_color.$query_clarity.$query_cut.$query_polish.$query_sym.$query_fluo.$query_certi.$and.'(carat >= '.$query_weight_from.' AND carat <= '.$query_weight_to.') AND (price BETWEEN '.$query_price_from.' AND '.$query_price_to.') AND status = "AVAILABLE" '.$featured;
if(!$superAdmin)
	$sql_count = $sql_count.' AND visiable=1';
foreach($conn->query($sql_count) as $num){
	$result_number=$num['num'];
}
/**/

$sql='SELECT * FROM diamonds WHERE'.$query_shape.$query_color.$query_clarity.$query_cut.$query_polish.$query_sym.$query_fluo.$query_certi.$and.'(carat >= '.$query_weight_from.' AND carat <= '.$query_weight_to.') AND (price BETWEEN '.$query_price_from.' AND '.$query_price_to.') AND status = "AVAILABLE" '.$featured;
if(!$superAdmin)
	$sql_ = $sql.' AND visiable=1';
$sql = $sql.' '.$query_sorting.' LIMIT '.$startfrom.', 35';
include_once('../log.php');
logger($sql);
//exit($sql);


$stmt=$conn->query($sql);
$error=$conn->errorInfo();
if(isset($error[2])) exit($error[2]);
?>




<table cellpadding="2" cellspacing="0" border="0">



<?php
$r=0;
foreach($stmt as $row){
	$r++;

?>
<tr class="<?php echo $r; ?> valueline sourse_<?php echo $row['source']; ?>" title="<?php echo $row['stock_ref']; ?>">
<td width="38" style="width:38px;" align="center"><input type="checkbox" class="selectcheckbox" id="check_<?php echo $row['stock_ref']; ?>" onchange="makeorder('<?php echo $row['stock_ref']; ?>')" />
<?php if($superAdmin){?>
<button class="deleterulesbtn" onclick="chgVisiable(<?php echo $row['stock_ref'].','.$row['visiable']; ?>)"
        id="visiable-<?php echo $row['stock_ref']; ?>"><?php echo $row['visiable']==1?'隐藏':'取消隐藏'; ?></button><?php } ?>
</td>

<td align="center" class="ref_number" style="width:80px;">
<?php if($row['visiable']==1){?>
<span class="valuetxt" style="width:80px; font-size:1.1em; font-weight:bold;">
<?php echo $row['stock_ref']; ?>
</span>
<?php } else { ?>
<span style="font-size:10px; color:#999;">(# <?php echo $row['stock_ref']; ?>)</span>
<?php } ?>
<br />
<?php
if($row['stock_num_rapnet']==''){
	$stock_num_rapnet='-';
}else{
	$stock_num_rapnet=$row['stock_num_rapnet'];
}
?>
<span style="font-size:10px; color:#999;">(# <?php echo $stock_num_rapnet; ?>)</span>
</td>
<td align="center" style="width:40px;">
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

	case "AS":
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
<img height="25" src="../images/site_elements/icons/<?php echo $pic_where; ?>" /></td>


<td align="center" class="value_carat" style="width:35px;">
<span class="valuetxt">
<?php echo number_format($row['carat'],2); ?>
</span>
</td>


<td align="center" class="value_color" style="width:26px;">
<span class="valuetxt">
<?php echo $row['color']; ?>
</span>
</td>


<td align="center" class="value_clarity" style="width:38px;"><span class="valuetxt"><?php echo $row['clarity']; ?></span></td>



<?php
$certi_num=$row['certificate_number'];
$thelab=$row['grading_lab'];
if('GIA'==$thelab){
	$certi_link='http://www.gia.edu/cs/Satellite?pagename=GST%2FDispatcher&childpagename=GIA%2FPage%2FReportCheck&c=Page&cid=1355954554547&reportno='.$certi_num;
}else if('IGI'==$thelab){
	//$certi_link='http://www.igiworldwide.com/igi/verify.php?r='.$certi_num;
	$certi_link='http://www.igiworldwide.com/verify.php?r='.$certi_num;
}else if('HRD'==$thelab){
	$certi_link='http://www.hrdantwerplink.be/index.php?record_number='.$certi_num;
}else{
	$certi_link='#not-available';
}
?>
<td align="center" class="value_certificate" style="width:94px;">
<span class="valuetxt"><a target="_blank" style="color:#000; font-weight:bold;" href="<?php echo $certi_link; ?>"><?php echo $thelab; ?></a></span><br />
<span class="lab-num" style="font-size:10px;">(<?php echo $certi_num; ?>)</span>

</td>



<td align="center" class="value_cut" style="width:35px;"><span class="valuetxt"><?php echo $row['cut_grade']; ?></span></td>


<td align="center" class="value_polish" style="width:35px;"><span class="valuetxt"><?php echo $row['polish']; ?></span></td>


<td align="center" class="value_symmetry" style="width:35px;"><span class="valuetxt"><?php echo $row['symmetry']; ?></span></td>

<td style="width:72px; text-align:center;">

<?php echo $row["fluorescence_intensity"]; ?>

</td>
<?php
if($superAdmin){
?>
<td align="center">
<?php echo $row['retail_price']; ?>
</td>
<?php } ?>
<td align="center">
<?php
if($superAdmin&&$_SESSION['username']!='gnkf'){
?>
<span class="valuetxt" style="width:70px;">
<?php echo $row['price']; ?>
</span>

	<?php
	if($row['source']=='RAPNET'){
	?>
	<br />
	<span style="font-size:10px;">
	(原价:<?php echo $row['raw_price']; ?>)
	</span>
	<?php
	}else{
	?>
	<br />
	<span style="font-size:10px;">
	(折扣:<?php echo $row['raw_price']; ?>)
	</span>
	<?php
	}
	?>

<?php
}?></td>
<?php
if($_SESSION['username']!='gnkf'){
$sql_currency='SELECT * FROM convert_currency';
$stmt_c=$conn->query($sql_currency);
foreach($stmt_c as $row_c){
	$eur=$row_c['USD_EUR'];
	$gbp=$row_c['USD_GBP'];
	$cny=$row_c['USD_CNY'];
}
?>


<td align="center">
<span class="valuetxt" style="width:70px;"><?php echo round($row['price']*$eur); ?></span>
</td>

<td align="center">
<span class="valuetxt" style="width:70px;"><?php echo round($row['price']*$cny); ?></span>
</td>

<td align="center">
<span class="valuetxt" style="width:70px;"><?php echo round($row['price']*$gbp); ?></span>
</td>
<?php }?>
<td width="30" style="width:28px; overflow:hidden; white-space:normal;" class="companyname" id="c_name_dia_<?php echo $row['stock_ref']; ?>">

<?php
if($superAdmin){
?>

<span style="font-size:14px; white-space:normal;" class="nameofcompany"><?php echo $row['from_company']; ?></span><br />
<span style="font-size:10px;" class="telofcompany"><?php echo $row['contact_tel']; ?></span>

<?php
}
?>
</td>

</tr>


<?php
}
?>
</table>

<p id="dia-page-navi-bottom">
为您找到<span><?php echo $result_number; ?></span>条结果。

<?php
$total_page_NUM=ceil($result_number/35);
$crr_page_Round=ceil($crr_page/10);
if($crr_page_Round>1){
?>
<button class="pre-pages-btn" onclick="choosethispage('<?php echo ($crr_page_Round-1)*10-9; ?>')">前10页...</button>
<?php
}
?>
第
<?php
for ($x=1; $x<=10; $x++) {
	$p=($crr_page_Round-1)*10+$x;
	if($p<=$total_page_NUM){
		if($p==$crr_page){
			$crr_class=' crr-dia-p';
		}else{
			$crr_class='';
		}
?>
<button class="gotopagebtn<?php echo $crr_class; ?>" onclick="choosethispage('<?php echo $p; ?>')"><?php echo $p; ?></button>
<?php
	}
}
?>
页

<?php
if(($crr_page_Round*10)<$total_page_NUM){
?>
<button class="next-pages-btn" onclick="choosethispage('<?php echo ($crr_page_Round*10+1); ?>')">...后10页</button>
<?php
}
?>
</p>
<button class="next-pages-btn" onclick="deleteK()">删除K字头</button>
<div id="howmanyrecords" style="display:none;"><?php echo $result_number; ?></div>

