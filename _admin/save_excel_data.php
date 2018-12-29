<?php
/*===================session========================*/
session_start();



// if session variable not set, redirect to login page
if(!isset($_SESSION['authenticated'])) {
  //header('Location: login.php');
  exit('session timeout');
}

if($_SESSION['authenticated']!='SiHui'){
	$_SESSION=array();
	if (isset($_COOKIE[session_name()])){
		setcookie(session_name(), '', time()-86400, '/');
	}
	session_destroy();
	//header('Location: login.php');
    exit('session timeout');
}

$username=$_SESSION['username'];
$account_level=$_SESSION['account_level'];
if($_REQUEST['confirmed']!="YES"){
	echo $_REQUEST['confirmed'];
	exit('NO PERMISSION');
}



$col_stock_ref=$_SESSION['col_stock_ref'];
$col_shape=$_SESSION['col_shape'];
$col_carat=$_SESSION['col_carat'];
$col_color=$_SESSION['col_color'];
$col_clarity=$_SESSION['col_clarity'];
$col_grading_lab=$_SESSION['col_grading_lab'];
$col_certificate_number=$_SESSION['col_certificate_number'];
$col_cut_grade=$_SESSION['col_cut_grade'];
$col_polish=$_SESSION['col_polish'];
$col_symmetry=$_SESSION['col_symmetry'];
$col_fluorescence_intensity=$_SESSION['col_fluorescence_intensity'];
$col_percentage=$_SESSION['col_percentage'];
$col_fancy_price=$_SESSION['col_fancy_price'];
$col_raw_price_total=$_SESSION['col_raw_price_total'];
$feedback_main='SUCCESS';
$feedbackmessage='';
$log='';
$total_status_updated=0;
//excelreader
require_once 'excelreader/excel_reader2.php';
$data = new Spreadsheet_Excel_Reader("excelfile/file.xls");
$totalrow = $data->rowcount($sheet_index=0);
$total_repeated=0;
$total_new=0;
$the_3ex_error=0;
$totalupdated=0;
$total_skipped=0;
$total_ignored=0;

include('nuke_magic_quotes.php');
require_once('../includes/connection.php');
$conn=dbConnect('write','pdo');
$conn->query("SET NAMES 'utf8'");
###delete the old first
$sql_bak='insert into diamonds_history select * from diamonds WHERE  ordered_by IS NULL AND wholesale_ordered_by IS NULL AND source <> "RAPNET"';
$stmt_bak = $conn->prepare ( $sql_bak );
$stmt_bak->execute();
$sql_del='DELETE FROM diamonds WHERE ordered_by IS NULL AND wholesale_ordered_by IS NULL AND source <> "RAPNET"';
$stmt_del=$conn->query($sql_del);
$deleted=$stmt_del->rowCount();
$records_in_db=array();
$sql_ids='SELECT stock_ref FROM diamonds WHERE source <> "RAPNET"';
$stmt_ids=$conn->query($sql_ids);
foreach($stmt_ids as $row_id){
	$records_in_db[]=$row_id['stock_ref'];
}
$sql_data_importing_status='UPDATE datafile_importing_status SET added = 0, passed = 0, proceeded = 0, status = "BUSY" WHERE id = 1';
$stmt_status=$conn->query($sql_data_importing_status);
$dia_ids_array=array();
require_once('processPrice.php');
$ii=0;//counter for status updating 
for ($i = 1; $i <= $totalrow; $i++) {		
	################################################################### prepare data
	$stock_ref_raw=$data->raw($i,$col_stock_ref);
	if(trim($stock_ref_raw)==''){
		$stock_ref_raw=$data->val($i,$col_stock_ref);
	}
	$stock_ref='K'.trim($stock_ref_raw);
	if (in_array($stock_ref, $records_in_db)) {
		continue;
	}
	$shape=trim($data->val($i,$col_shape));
	$carat=$data->raw($i,$col_carat);
	if(trim($carat)==''){
		$carat=$data->val($i,$col_carat);
	}
	//$feedbackmessage.="<br />第 $i carat: $carat; shape: $shape; stock_ref: $stock_ref";
	$color=trim($data->val($i,$col_color));
	
	//$fancy_color=trim($data->val($i,7));//??????
	$fancy_color='-';//??????
	
	$clarity=trim($data->val($i,$col_clarity));
	$grading_lab=trim($data->val($i,$col_grading_lab));
	$certificate_number=trim($data->raw($i,$col_certificate_number));
	if($certificate_number==''){
		$certificate_number=trim($data->val($i,$col_certificate_number));
	}
	$cut_grade=trim($data->val($i,$col_cut_grade));
	$polish=trim($data->val($i,$col_polish));
	$symmetry=trim($data->val($i,$col_symmetry));
	$fluorescence_intensity=trim($data->val($i,$col_fluorescence_intensity));
	
	//$country=trim($data->val($i,13));
	$country='-';
	
	$raw_price_total=trim($data->raw($i,$col_raw_price_total));
	if(trim($raw_price_total)==''){
		$raw_price_total=trim($data->val($i,$col_raw_price_total));
	}
	if(strlen($color)>1&&substr($color,0,1)=='F') {
		$fancy_color=substr($color,strlen($color)-1);
		$raw_price_total=trim($data->raw($i,$col_fancy_price));
	}
	$raw_price_total_proceeded=str_replace(',', '', $raw_price_total);
	//echo $raw_price_total001.'===========';
	
	$percentage=trim($data->raw($i,$col_percentage));
	if($percentage==''){
		$percentage=trim($data->val($i,$col_percentage));
	}
	
	if($percentage==NULL || $percentage==''){
		$percentage=0;
	}
	if(strlen($color)>1&&substr($color,0,1)=='F') {
		$raw_price_total_novalue = $raw_price_total_proceeded;
		$percentage = 0;
	}
	else
		$raw_price_total_novalue=$raw_price_total_proceeded*($percentage+100)/100;//for retail raw price(without the ratio)

	$price=processPrice($carat, $color, $clarity, $cut_grade, $polish, $symmetry, $grading_lab, $shape, $fluorescence_intensity, $raw_price_total_proceeded, $percentage, 'excel', 'agency');
	$retail_price=processPrice($carat, $color, $clarity, $cut_grade, $polish, $symmetry, $grading_lab, $shape, $fluorescence_intensity, $raw_price_total_proceeded, $percentage, 'excel', 'retail');
	//$feedbackmessage.="<br/>".$color."::".$raw_price_total_proceeded."::".$raw_price_total_novalue.",".$retail_price.",".$price."<br/>";
	
	$from_company='-';
	################################################################### 检查数据可用性
	
	if($stock_ref=='' || $stock_ref==NULL){
		$feedbackmessage.="<br />第 $i 条纪录没有导入数据库，因为是空纪录或标题。";
	}else if(trim(strtoupper($clarity))!='FL' && trim(strtoupper($clarity))!='IF' && trim(strtoupper($clarity))!='VVS1' && trim(strtoupper($clarity))!='VVS2' && trim(strtoupper($clarity))!='VS1' && trim(strtoupper($clarity))!='VS2' && trim(strtoupper($clarity))!='SI1' && trim(strtoupper($clarity))!='SI2' && trim(strtoupper($clarity))!='I1' && trim(strtoupper($clarity))!='I2' && trim(strtoupper($clarity))!='I3'){
		$total_skipped++;
		$feedbackmessage.="<br />第 $i 条纪录没有导入数据库，因为数据格式不正确: 钻石净度参数缺失或不正确:".trim(strtoupper($clarity)).":".$stock_ref;
	}else if($carat<0.90){
		$total_ignored++;
	}else if($price<35 || $price==NULL || $price==''){
		$feedbackmessage.="<br />第 $i 条纪录没有导入数据库，因为价格不正确: 价格为".$price;
		$total_skipped++;
	}else{
		$dia_ids_array[]=$stock_ref;
		################################################################### 可用数据执行操作
		$sql_check='SELECT * FROM diamonds WHERE stock_ref = "'.$stock_ref.'"';
		$stmt_check=$conn->query($sql_check);
		$found=$stmt_check->rowCount();
		//$found=true;/////////////////////////////////////////////////////////////////////////
		if(!$found){
			################################################################### 新数据存储操作
			if((trim(strtoupper($cut_grade))!='F' && trim(strtoupper($cut_grade))!='G' && trim(strtoupper($cut_grade))!='VG' && trim(strtoupper($cut_grade))!='EX') || trim((strtoupper($polish))!='F' && trim(strtoupper($polish))!='G' && trim(strtoupper($polish))!='VG' && trim(strtoupper($polish))!='EX') || (trim(strtoupper($symmetry))!='F' && trim(strtoupper($symmetry))!='G' && trim(strtoupper($symmetry))!='VG' && trim(strtoupper($symmetry))!='EX')){
				$the_3ex_error++;
			}
			switch($clarity){
				case "IF":
				$clarity_number='0';
				break;
				
				case "VVS1":
				$clarity_number='1';
				break;
				
				case "VVS2":
				$clarity_number='2';
				break;
				
				case "VS1":
				$clarity_number='3';
				break;
				
				case "VS2":
				$clarity_number='4';
				break;
				
				case "SI1":
				$clarity_number='5';
				break;
				
				case "SI2":
				$clarity_number='6';
				break;
				
				default:
				$clarity_number='-';
		
			}
			
			switch($cut_grade){
				case "EX":
				$cut_number='0';
				break;
				
				case "VG":
				$cut_number='1';
				break;
				
				case "G":
				$cut_number='2';
				break;
				
				case "F":
				$cut_number='3';
				break;
				
				default:
				$cut_number='-';
		
			}
			
			$source='EXCEL';
			$sql_insert='INSERT INTO diamonds (id, stock_ref, shape, carat, color, fancy_color, clarity, grading_lab, certificate_number, cut_grade, polish, symmetry, fluorescence_intensity, country, raw_price, raw_price_retail, price, retail_price, from_company, clarity_number, cut_number, added_at, source) VALUES (:id, :stock_ref, :shape, :carat, :color, :fancy_color, :clarity, :grading_lab, :certificate_number, :cut_grade, :polish, :symmetry, :fluorescence_intensity, :country, :raw_price, :raw_price_retail, :price, :retail_price, :from_company, :clarity_number, :cut_number, NOW(), :source)';
			$stmt=$conn->prepare($sql_insert);	  
			
			$stmt->bindParam(':id', $available_line, PDO::PARAM_INT);
			$stmt->bindParam(':stock_ref', $stock_ref, PDO::PARAM_STR);
			$stmt->bindParam(':shape', $shape, PDO::PARAM_STR);
			$stmt->bindParam(':carat', $carat, PDO::PARAM_STR);
			$stmt->bindParam(':color', $color, PDO::PARAM_STR);
			$stmt->bindParam(':fancy_color', $fancy_color, PDO::PARAM_STR);
			$stmt->bindParam(':clarity', $clarity, PDO::PARAM_STR);
			$stmt->bindParam(':grading_lab', $grading_lab, PDO::PARAM_STR);
			$stmt->bindParam(':certificate_number', $certificate_number, PDO::PARAM_STR);
			$stmt->bindParam(':cut_grade', $cut_grade, PDO::PARAM_STR);
			$stmt->bindParam(':polish', $polish, PDO::PARAM_STR);
			$stmt->bindParam(':symmetry', $symmetry, PDO::PARAM_STR);
			$stmt->bindParam(':fluorescence_intensity', $fluorescence_intensity, PDO::PARAM_STR);
			$stmt->bindParam(':country', $country, PDO::PARAM_STR);
			$stmt->bindParam(':raw_price', $percentage, PDO::PARAM_STR);
			$stmt->bindParam(':raw_price_retail', $raw_price_total_novalue, PDO::PARAM_INT);
			$stmt->bindParam(':price', $price, PDO::PARAM_INT);	
			$stmt->bindParam(':retail_price', $retail_price, PDO::PARAM_INT);			
			$stmt->bindParam(':from_company', $from_company, PDO::PARAM_STR);			
			$stmt->bindParam(':clarity_number', $clarity_number, PDO::PARAM_STR);
			$stmt->bindParam(':cut_number', $cut_number, PDO::PARAM_STR);
			$stmt->bindParam(':source', $source, PDO::PARAM_STR);			
			$stmt->execute();
			$OK=$stmt->rowCount();
			
			$error=$conn->errorInfo();
			$log.='<br/>result:'.$OK.',id:'.$available_line.' --shape:'.$shape.' --stock_ref: '.$stock_ref_raw.' --cert_num:'.$certificate_number.'err:';
			logger($log);
			if(isset($error[2])){
				//echo($error[2]);
				$feedbackmessage.="<br />EXCEL文件中第 $i 条纪录导入数据库出现未知错误。";
			}
			if($OK>0&&$shape!='BR'){
				$feedbackmessage.="<br />导入异形钻:".$shape.",cert_num:".$certificate_number;
			}
			//if(isset($error[1])) echo($error[1]);
			
			$total_new++;
			
		}else{
			################################################################### 重复数据更新操作
			$total_repeated++;
			foreach($stmt_check as $row){
				$crr_cut_db=$row['cut_grade'];
				$crr_polish_db=$row['cut_grade'];
				$crr_sym_db=$row['symmetry'];				
			}
			if((($crr_cut_db==NULL || $crr_cut_db=='') && $cut_grade!=NULL && $cut_grade!='') || (($crr_polish_db==NULL || $crr_polish_db=='') && $polish!=NULL && $polish!='') || (($crr_sym_db==NULL || $crr_sym_db=='') && $symmetry!=NULL && $symmetry!='')){
				$sql_update='UPDATE diamonds SET cut_grade = "'.$cut_grade.'", polish = "'.$polish.'", symmetry = "'.$symmetry.'" WHERE stock_ref = "'.$stock_ref.'"';
				$stmt_update=$conn->query($sql_update);
				$updated=$stmt_update->rowCount();
				if($updated){
					$totalupdated++;
				}
			}
			
		}
	}
	
	if($ii<58){//每处理58条纪录更新一次状态纪录，以减少系统资源消耗
		$ii++;
	}else{
		$ii=0;
		$sql_data_file='UPDATE datafile_importing_status SET added = "'.$total_new.'", passed = "'.$total_skipped.'", proceeded = "'.$i.'", total_records = "'.$totalrow.'", status = "BUSY" WHERE id = 1';
		$stmt_importing_status=$conn->query($sql_data_file);
	}
}//end for循环
if($deleted){ ?> <?php echo 'delete 删除记录数：'.$deleted; ?> <?php }


//now check the ordered, but not exits in excel anymore
$sql_ordered_check='SELECT stock_ref FROM diamonds WHERE (ordered_by IS NOT NULL OR wholesale_ordered_by IS NOT NULL) AND source <> "RAPNET"';
foreach($conn->query($sql_ordered_check) as $row_ordered){
	$crr_ref=$row_ordered['stock_ref'];
	if(!in_array($crr_ref, $dia_ids_array)){
		$sql_update_ordered='UPDATE diamonds SET status = "SOLD" WHERE stock_ref = "'.$crr_ref.'"';
		$stmt_update_ordered=$conn->query($sql_update_ordered);
	    $done_updated=$stmt_update_ordered->rowCount();
		if($done_updated){
			$total_status_updated++;
		}
	}
}
$sql_data_file='UPDATE datafile_importing_status SET added = "'.$total_new.'", passed = "'.$total_skipped.'", proceeded = "'.$i.'", total_records = "'.$totalrow.'", status = "DONE" WHERE id = 1';
$stmt_importing_status=$conn->query($sql_data_file);
$feedback_main='fini';
?>

<p id="messagemain"><?php echo $feedback_main; ?></p>
<p id="total_records"><?php echo $totalrow; ?></p>
<p id="fmessage">
共处理<?php echo $i; ?>条纪录。其中<?php echo $total_new;  ?>条导入；<?php echo $total_repeated+$total_skipped; ?>条因数据不完整而略过；<?php echo $total_ignored; ?>条因为钻石克拉数不足0.9而略过。
<br />
有<?php echo $total_status_updated; ?>条被预订钻石的纪录已经不存在，已标注为下架。
<br />
<?php echo $feedbackmessage; ?>
<br />

</p>



<p id="added"><?php echo $total_new; ?></p>
<p id="skipped"><?php echo $total_repeated; ?></p>
<p id="ignored"><?php echo $total_skipped; ?></p>
<p id="renewed"><?php echo $totalupdated; ?></p>
<p id="errored"><?php echo $the_3ex_error; ?></p>
<p id="general"><?php echo $log; ?></p>

