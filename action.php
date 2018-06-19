<?php
session_start();
date_default_timezone_set("Asia/Shanghai");
include_once 'log.php';
if(!isset($conn)){
	require_once('includes/connection.php');
	$conn=dbConnect('write','pdoption');
	$conn->query("SET NAMES 'utf8'");
}
if($_REQUEST['action']) {
	$action = $_REQUEST['action'];
	switch($action) {
		case "distinctCompany":
			$sql = 'select distinct  from_company  from diamonds where 1=1 and '.$_SESSION ['queryClause'] .'order by from_company';
			$companyList='';
				foreach($conn->query($sql) as $row){
					$companyList .= $row['from_company'].',';
				}
			logger($sql.json_encode($companyList));
			echo ($companyList);
			break;
		default:
			echo "wrong action";
			break;
	}
}