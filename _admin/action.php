<?php
date_default_timezone_set("Asia/Shanghai");
include_once '../log.php';
if(!isset($conn)){
	require_once('../includes/connection.php');
	$conn=dbConnect('write','pdo');
	$conn->query("SET NAMES 'utf8'");
}
$userid = $_COOKIE["userId"];
if (isset($_COOKIE["userId"]))
	$userid = $_COOKIE["userId"];
else
	$userid = $_COOKIE["everUserId"];

if($_REQUEST['action']) {
	$action = $_REQUEST['action'];
	switch($action) {
		case "deleteTranc":
			$sql_delete='delete from transaction WHERE id = '.$_REQUEST['id'];
			$conn->query($sql_delete);
			$sql_delete='delete from tranc_detail WHERE tranc_id = '.$_REQUEST['id'];
			$conn->query($sql_delete);
			echo "OK";
			break;
		case "trancDetail":
			$stmt=$conn->prepare('select * from transaction where id=:id');
			$stmt->execute(array('id'=>$_REQUEST['id']));
			foreach($stmt as $r){
				$transactionDetail=$r;
			}
			$stmt=$conn->prepare('select * from tranc_detail where tranc_id=:tranc_id');
			$stmt->execute(array('tranc_id'=>$_REQUEST['id']));
			$tranc_detailList=array();
			foreach($stmt as $row){
				$tranc_detailList[]=$row;
			}
			$result = array('trancDetail'=>$transactionDetail,'list'=>$tranc_detailList);
			echo json_encode($result);
			break;
		case "trancList":
			$totalSql = 'select count(*) as t from transaction';
			$sql='select id,type,invoice_no,tranc_date,name,currency,vat_price,total_price from transaction ';
			$clause = ' where 1=1 ';
			if($_REQUEST['type']!=null)
				$clause .= ' and type ="'.$_REQUEST['type'].'"';
			if($_REQUEST['currency']!=null)
				$clause .= ' and currency ="'.$_REQUEST['currency'].'"';
			if($_REQUEST['name']!=null)
				$clause .= ' and name like "%'.$_REQUEST['name'].'%"';
			if($_REQUEST['invoice_no']!=null)
				$clause .= ' and invoice_no like "%'.$_REQUEST['invoice_no'].'%"';
			if($_REQUEST['start']!=null)
				$clause .= ' and tranc_date>='.$_REQUEST['start'];
			if($_REQUEST['end']!=null)
				$clause .= ' and tranc_date<'.$_REQUEST['end'];
			$pagesize = 10;
			if(isset($_REQUEST['page'])&&$_REQUEST['page']!=null){
				$crr_page=$_REQUEST['page'];
			}else{
				$crr_page=1;
			}
			$startfrom=($crr_page-1)*$pagesize;
			$totalSql .= $clause;
			$sql .= $clause.' order by id desc limit '.$startfrom.','.$pagesize;
			foreach($conn->query($totalSql) as $r_r){
				$total=$r_r['t'];
			}
			if($total>0) {
				$transactionList=array();$i=0;
				foreach($conn->query($sql) as $row){
					$transactionList[]=$row;
					$i++;
				}
			}
			$tpages = ceil ( $total / $pagesize );
			$result = array('total'=>$total,'page'=>$crr_page,'total_pages'=>$tpages,'list'=>$transactionList);
			echo json_encode($result);
			break;
		case "updateTranc":
			$obj=json_decode($_REQUEST['transaction'],TRUE);
			$sql = 'update transaction set type=?,name=?,passport=?,street=?,city=?,postcode=?,country=?,tranc_date=?,invoice_no=?,currency=?,vat_price=?,total_price=? where id=?';
			$stmt=$conn->prepare($sql);
			$stmt->execute(array($obj['type'],$obj['name'],
					$obj['passport'],
					$obj['street'],$obj['city'],
					$obj['postcode'],
					$obj['country'],
					$obj['tranc_date'],
					$obj['invoice_no'],$obj['currency'],$obj['vat_price'],$obj['total_price'],$obj['id']));
			//删除原有纪录
			$sql_delete='delete from tranc_detail WHERE tranc_id = '.$obj['id'];
			$conn->query($sql_delete);
			$num=count($obj["list"]);
			//--遍历数组，将对应信息添加入数据库
			for ($i=0;$i<$num;$i++) {
				$item = $obj["list"][$i];
				if($item["type"]=='jew') {
					$insert_sql="INSERT INTO tranc_detail (tranc_id,type,jewerly,material,jewerly_price,ctime)
						VALUES (?,?,?,?,?,now())";
					$result = $conn -> prepare($insert_sql);
					$result -> execute(array( $obj['id'],$item["type"],$item["jewerly"], $item["material"],
							$item["jewerly_price"]
					));
				}
				else{
					$insert_sql="INSERT INTO tranc_detail (tranc_id,type,report_no,shape,color,fancy,grading_lab,carat,
						clarity,cut_grade,polish,symmetry,price,jewerly,material,jewerly_price,ctime)
						VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,now())";
					$result = $conn -> prepare($insert_sql);
					$result -> execute(array( $obj['id'],$item["type"],$item["report_no"],$item["shape"],$item["color"],
							$item["fancy"],$item["grading_lab"],$item["carat"], $item["clarity"],$item["cut_grade"],
							$item["polish"], $item["symmetry"],$item["price"],$item["jewerly"], $item["material"],
							$item["jewerly_price"]
					));
				}
			}
			echo $obj['id'];
			break;
		case "addTranc":
			$obj=json_decode($_REQUEST['transaction'],TRUE);logger($_REQUEST['transaction']);
			$sql = 'insert into transaction(name,passport,street,city,postcode,country,type,tranc_date,invoice_no,currency,vat_price,total_price,ctime) 
					values(:name,:passport,:street,:city,:postcode,:country,:type,:tranc_date,:invoice_no,:currency,:vat_price,:total_price,now())';
			$stmt=$conn->prepare($sql);
			$stmt->execute(array('name'=>$obj['name'],
					'passport'=>$obj['passport'],
					'street'=>$obj['street'],'city'=>$obj['city'],
					'postcode'=>$obj['postcode'],
					'country'=>$obj['country'],'type'=>$obj['type'],
					'tranc_date'=>$obj['tranc_date'],
					'invoice_no'=>$obj['invoice_no'],'currency'=>$obj['currency'],'vat_price'=>$obj['vat_price'],'total_price'=>$obj['total_price']));
			$transactionId = $conn->lastInsertId();
			//--得到Json_list数组长度
			$num=count($obj["list"]);
			//--遍历数组，将对应信息添加入数据库
			for ($i=0;$i<$num;$i++) {
				$item = $obj["list"][$i];
				if($item["type"]=='jew') {
					$insert_sql="INSERT INTO tranc_detail (tranc_id,type,jewerly,material,jewerly_price,ctime)
						VALUES (?,?,?,?,?,now())";
					$result = $conn -> prepare($insert_sql);
					$result -> execute(array( $transactionId,$item["type"],$item["jewerly"], $item["material"],
							$item["jewerly_price"]
					));
				}
				else{
					$insert_sql="INSERT INTO tranc_detail (tranc_id,type,report_no,shape,color,fancy,grading_lab,carat,
						clarity,cut_grade,polish,symmetry,price,jewerly,material,jewerly_price,ctime)
						VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,now())";
					$result = $conn -> prepare($insert_sql);
					$result -> execute(array( $transactionId,$item["type"],$item["report_no"],$item["shape"],$item["color"],
							$item["fancy"],$item["grading_lab"],$item["carat"], $item["clarity"],$item["cut_grade"],
							$item["polish"], $item["symmetry"],$item["price"],$item["jewerly"], $item["material"],
							$item["jewerly_price"]
					));
				}
			}
			echo $transactionId;
			break;
		case "currencyRate":
			$from=$_REQUEST['from'];
			$to=$_REQUEST['to'];
			foreach($conn->query('SELECT * FROM convert_currency') as $row_currency){
				$USD_EUR=$row_currency['USD_EUR'];
				$USD_GBP=$row_currency['USD_GBP'];
				$USD_CNY=$row_currency['USD_CNY'];
			}
			if($from=='EUR'&&$to=='CNY') 
				$rate=($USD_CNY/$USD_EUR);
			if($from=='EUR'&&$to=='USD')
				$rate=1/$USD_EUR;
			if($from=='CNY'&&$to=='EUR') 
				$rate=($USD_EUR/$USD_CNY);
			if($from=='CNY'&&$to=='USD')
				$rate=(1/$USD_CNY);
			if($from=='USD'&&$to=='EUR')
				$rate=($USD_EUR);
			if($from=='USD'&&$to=='CNY')
				$rate=($USD_CNY);
			echo $rate;
				break;
		case "fetchDia":
			$ref=$_REQUEST['ref'];
			$currency=$_REQUEST['currency'];
			if($_REQUEST['ref']!=null){
				$sql_currency='SELECT * FROM convert_currency';
				foreach($conn->query($sql_currency) as $row_currency){
					$USD_EUR=$row_currency['USD_EUR'];
					$USD_GBP=$row_currency['USD_GBP'];
					$USD_CNY=$row_currency['USD_CNY'];
				}
				$sql_dia='SELECT * FROM diamonds WHERE visiable=1 and stock_ref LIKE "'.$ref.'" OR certificate_number = "'.$ref.'"';
				$stmt_dia=$conn->query($sql_dia);
				foreach($stmt_dia as $r_d){
					$item=$r_d;
					if($currency!=null&&$currency=='CNY')
						$item['retail_price']=round($r_d['retail_price']*$USD_CNY);
					else 
						$item['retail_price']=round($r_d['retail_price']*$USD_EUR);
				}
				echo json_encode($item);
			}
			break;
		case "invoiceNo":
			$transactionNo = 1;
			$sql_dia='select max(invoice_no) as t from transaction';
			foreach($conn->query($sql_dia) as $r_r){
				$transactionNo=$r_r['t']+1;
			}
			//$transactionStr=  date('Y').sprintf('%04s', $transactionNo);
			echo $transactionNo;
			break;
		default:
			echo "wrong action";
			break;
	}
}
?>