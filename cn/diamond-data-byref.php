<?php
session_start ();

if (! isset ( $_SESSION ['username'] )) {
	exit ( '' );
}
if($_SESSION ['account_level']=='0'){
	$superAdmin=true;
}else{
	$superAdmin=false;
}

if (! isset ( $_POST ['stockref'] )) {
	exit ( 'no data posted' );
}

$crr_search = strtoupper ( $_POST ['stockref'] );

// $query_sorting =' ORDER BY price ASC';

require_once ('../includes/connection.php');
$conn = dbConnect ( 'write', 'pdo' );
$conn->query ( "SET NAMES 'utf8'" );


$sql_crr = 'SELECT * FROM diamonds WHERE stock_ref = "' . $crr_search . '" OR certificate_number = "' . $crr_search . '" OR stock_num_rapnet = "' . $crr_search . '"';

$stmt_crr = $conn->query ( $sql_crr );
$error = $conn->errorInfo ();
if (isset ( $error [2] ))
	exit ( $error [2] );
foreach ( $stmt_crr as $row_crr ) {
	$crr_ref = $row_crr ['stock_ref'];
}
$listarray = array ();
if (isset ( $_SESSION ['searchArray'] )) {
	$listarray = $_SESSION ['searchArray'];
}
array_unshift ( $listarray, $crr_ref );
$listarray = array_unique ( $listarray );
$_SESSION ['searchArray'] = $listarray;

?>
<table cellpadding="2" cellspacing="0" border="0">

<?php
// ###########################################################################
// ###########################################################################
// ###########################################################################
// ###########################################################################
// ###########################################################################
// ###########################################################################
foreach ( $listarray as $ref ) {
	
	// $sql_crr_list='SELECT * FROM diamonds WHERE stock_ref = "'.$ref.'" OR certificate_number = "'.$ref.'" OR stock_num_rapnet = "'.$ref.'"';
	$sql_crr_list = 'SELECT * FROM diamonds WHERE stock_ref = "' . $ref . '"';
	
	$stmt_list = $conn->query ( $sql_crr_list );
	$found_list = $stmt_list->rowCount ();
	if ($found_list) {
		foreach ( $stmt_list as $row ) {
			$r ++;
			// ###########################################################################
			?>

<tr id="visiable-<?php echo $row['stock_ref']; ?>"
    class="<?php echo $r; ?> valueline sourse_<?php echo $row['source']; ?>" title="<?php echo $row['stock_ref']; ?>">
    <td width="38" style="width: 38px;" align="center"><input type="checkbox" class="selectcheckbox"
      id="check_<?php echo $row['stock_ref']; ?>" onchange="makeorder('<?php echo $row['stock_ref']; ?>')" />
      <button class="deleterulesbtn" onclick="chgVisiable(<?php echo $row['stock_ref'].','.$row['visiable']; ?>)"
        id="visiable-<?php echo $row['stock_ref']; ?>"><?php echo $row['visiable']==1?'隐藏':'取消隐藏'; ?></button></td>
    <td align="center" class="ref_number" style="width: 80px;"><span class="valuetxt"
      style="width: 80px; font-size: 1.1em; font-weight: bold;">
<?php echo $row['stock_ref']; ?>
</span> <br />
<?php
			if ($row ['stock_num_rapnet'] == '') {
				$stock_num_rapnet = '-';
			} else {
				$stock_num_rapnet = $row ['stock_num_rapnet'];
			}
			?>
<span style="font-size: 10px; color: #999;">(# <?php echo $stock_num_rapnet; ?>)</span></td>
    <td align="center" style="width: 40px;">
<?php
			switch ($row ['shape']) {
				case "BR" :
					$pic_where = "01.gif";
					break;
				
				case "CU" :
					$pic_where = "12.gif";
					break;
				
				case "EM" :
					$pic_where = "10.gif";
					break;
				
				case "AS" :
					$pic_where = "10.gif";
					break;
				
				case "HS" :
					$pic_where = "08.gif";
					break;
				
				case "MQ" :
					$pic_where = "05.gif";
					break;
				
				case "OV" :
					$pic_where = "11.gif";
					break;
				
				case "PR" :
					$pic_where = "03.gif";
					break;
				
				case "PS" :
					$pic_where = "02.gif";
					break;
				
				case "RAD" :
					$pic_where = "06.gif";
					break;
				
				case "TRI" :
					$pic_where = "04.gif";
					break;
				
				default :
					$pic_where = "01.gif";
			}
			?>


<img height="25" src="../images/site_elements/icons/<?php echo $pic_where; ?>" />
    </td>
    <td align="center" class="value_carat" style="width: 35px;"><span class="valuetxt">
<?php echo number_format($row['carat'],2); ?>
</span></td>
    <td align="center" class="value_color" style="width: 26px;"><span class="valuetxt">
<?php echo $row['color']; ?>
</span></td>
    <td align="center" class="value_clarity" style="width: 38px;"><span class="valuetxt"><?php echo $row['clarity']; ?></span></td>



<?php
			$certi_num = $row ['certificate_number'];
			$thelab = $row ['grading_lab'];
			if ('GIA' == $thelab) {
				$certi_link = 'http://www.gia.edu/cs/Satellite?pagename=GST%2FDispatcher&childpagename=GIA%2FPage%2FReportCheck&c=Page&cid=1355954554547&reportno=' . $certi_num;
			} else if ('IGI' == $thelab) {
				// $certi_link='http://www.igiworldwide.com/igi/verify.php?r='.$certi_num;
				$certi_link = 'http://www.igiworldwide.com/verify.php?r=' . $certi_num;
			} else if ('HRD' == $thelab) {
				$certi_link = 'http://www.hrdantwerplink.be/index.php?record_number=' . $certi_num;
			} else {
				$certi_link = '#not-available';
			}
			?>
<td align="center" class="value_certificate" style="width: 94px;"><span class="valuetxt"><a target="_blank"
        style="color: #000; font-weight: bold;" href="<?php echo $certi_link; ?>"><?php echo $thelab; ?></a></span><br />
      <span class="lab-num" style="font-size: 10px;">(<?php echo $certi_num; ?>)</span></td>
    <td align="center" class="value_cut" style="width: 35px;"><span class="valuetxt"><?php echo $row['cut_grade']; ?></span></td>
    <td align="center" class="value_polish" style="width: 35px;"><span class="valuetxt"><?php echo $row['polish']; ?></span></td>
    <td align="center" class="value_symmetry" style="width: 35px;"><span class="valuetxt"><?php echo $row['symmetry']; ?></span></td>
    <td style="width: 72px; text-align: center;">

<?php echo $row["fluorescence_intensity"]; ?>

</td>

<?php
			if ($superAdmin) {
				?>
<td align="center">
<?php echo $row['retail_price']; ?>
</td>
<?php } ?>
<td align="center">
<?php
if($superAdmin&&$_SESSION['username']!='gnkf'){
				?>
<span class="valuetxt" style="width: 70px;">
<?php echo $row['price']; ?>
</span>

<?php
				if ($row ['source'] == 'RAPNET') {
					?>
<br /> <span style="font-size: 10px;">
(原价:<?php echo $row['raw_price']; ?>)
</span>
<?php
				} else {
					?>
<br /> <span style="font-size: 10px;">
(折扣:<?php echo $row['raw_price']; ?>)
</span>
<?php
				}
				?>

<?php
			} 
			?>
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
</td>
    <td align="center"><span class="valuetxt" style="width: 70px;"><?php echo round($row['price']*$eur); ?></span></td>
    <td align="center"><span class="valuetxt" style="width: 70px;"><?php echo round($row['price']*$cny); ?></span></td>
    <td align="center"><span class="valuetxt" style="width: 70px;"><?php echo round($row['price']*$gbp); ?></span></td>
    <td width="30" style="width: 28px; overflow: hidden; white-space: normal;" class="companyname"
      id="c_name_dia_<?php echo $row['stock_ref']; ?>">

<?php }
			if ($superAdmin) {
				?>

<span style="font-size: 14px; white-space: normal;" class="nameofcompany"><?php echo $row['from_company']; ?></span><br />
      <span style="font-size: 10px;" class="telofcompany"><?php echo $row['contact_tel']; ?></span>

<?php
			}
			?>
</td>
  </tr>






<?php
			// ###########################################################################
		}
	}
}
?>


</table>
<p id="dia-page-navi-bottom"></p>
<div id="howmanyrecords" style="display: none;"></div>
