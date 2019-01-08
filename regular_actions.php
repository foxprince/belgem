<?php
###################### download the data and save it to the csv file #############################
//1 - Authenticate with TechNet. The authentication ticket will be stored in $auth_ticket. Note this MUST be HTTPS.
$auth_url = "https://technet.rapaport.com/HTTP/Authenticate.aspx";
$post_string = "username=90733&password=" . urlencode("G4n8m4G9");
//create HTTP POST request with curl:
$request = curl_init($auth_url); // initiate curl object
curl_setopt($request, CURLOPT_HEADER, 0); // set to 0 to eliminate header info from response
curl_setopt($request, CURLOPT_RETURNTRANSFER, 1); // Returns response data instead of TRUE(1)
curl_setopt($request, CURLOPT_POSTFIELDS, $post_string); // use HTTP POST to send form data
curl_setopt($request, CURLOPT_SSL_VERIFYPEER, FALSE); // uncomment this line if you get no gateway response.
$auth_ticket = curl_exec($request); // execute curl post and store results in $auth_ticket
curl_close ($request);

//2 - prepare HTTP request for data.
$feed_url = "http://technet.rapaport.com/HTTP/DLS/GetFile.aspx";
$feed_url .= "?ticket=".$auth_ticket; //add authentication ticket:
//prepare to save response as file.
$fp = fopen('rapnetfeed.csv', 'wb');
if ($fp == FALSE)
{
echo "File not opened";
exit;
}
//create HTTP GET request with curl 
$request = curl_init($feed_url); // initiate curl object
curl_setopt($request, CURLOPT_FILE, $fp); //Ask cURL to write the contents to a file
curl_setopt($request, CURLOPT_HEADER, 0); // set to 0 to eliminate header info from response
curl_setopt($request, CURLOPT_TIMEOUT, 300); //set timeout to 5 mins
curl_exec($request); // execute curl post
// additional options may be required depending upon your server configuration
// you can find documentation on curl options at http://www.php.net/curl_setopt
curl_close ($request); // close curl object 
fclose($fp); //close file;

echo '***<br>data file download successful...now read the data...<br>***<br><br><br>';
$status='file downloaded-trying to insert';
################ read the csv file and save the data to the database #############################
require_once('includes/connection.php');
$conn=dbConnect('write','pdo');
$conn->query("SET NAMES 'utf8'");
########################################################################### log
$sql_log='INSERT INTO dataupdate_log (status) VALUES (:status)';##### log
		##### log##### log##### log##### log##### log##### log##### log##### log##### log
			##### log##### log##### log##### log##### log##### log##### log##### log##### log
$stmt_log=$conn->prepare($sql_log);	  ##### log##### log##### log##### log##### log
$stmt_log->execute(array(
		'status'=> $status
));
###########################################################################

// first first delete the imcomplete records
if(isset($_GET['newprice']) && $_GET['newprice']=='tobeupdated'){
	echo '<br><br>***<br>checking if there are bad records in the database, if yes, delete<br>***<br>';
	//$sql_del_imcomplete='DELETE FROM diamonds WHERE ordered_by IS NULL AND wholesale_ordered_by IS NULL AND source = "RAPNET"';
	$sql_bak='insert into diamonds_history select * from diamonds WHERE  source = "RAPNET" and visiable!=1';
	$stmt_bak = $conn->prepare ( $sql_bak );
	$stmt_bak->execute();
	
	$sql_del_imcomplete='DELETE FROM diamonds WHERE  source = "RAPNET" and visiable!=1';
	$stmt_del_incomplete=$conn->query($sql_del_imcomplete);
	$del_incomplete_num=$stmt_del_incomplete->rowCount();
	echo '<br>deleted records with wrong price: '.$del_incomplete_num;
}
// first put the existing records in an array
$records_in_db=array();
$sql_ids='SELECT stock_ref FROM diamonds WHERE source = "RAPNET"';
$stmt_ids=$conn->query($sql_ids);
foreach($stmt_ids as $row_id){
	$records_in_db[]=$row_id['stock_ref'];
}


$file = fopen("rapnetfeed.csv","r");

$crr_row=0;
$col_counter=0;


$sellername_col_num=-1;
$RapNetAccountID_col_num=-1;
$NameCode_col_num=-1;
$Shape_col_num=-1;
$Color_col_num=-1;
$Clarity_col_num=-1;
$Cut_col_num=-1;
$Polish_col_num=-1;
$Symmetry_col_num=-1;
$FluorescenceIntensity_col_num=-1;
$Lab_col_num=-1;
$CertificateNumber_col_num=-1;
$StockNumber_col_num=-1;
$PricePerCarat_col_num=-1;
$PricePercentage_col_num=-1;
$TotalPrice_col_num=-1;
$CashPricePerCarat_col_num=-1;
$CashPricePercentage_col_num=-1;
$TotalCashPrice_col_num=-1;
$City_col_num=-1;
$State_col_num=-1;
$Country_col_num=-1;
$CertificateURL_col_num=-1;
$ImageURL_col_num=-1;
$DiamondID_col_num=-1; 

$records_from_rapnet=array();


require_once('_admin/processPrice.php');

echo '<br><br>***<br>check downloaded records piece by piece now<br>***<br><br>';

while(! feof($file)){
	$crr_row_content_array=fgetcsv($file);
	if($Shape_col_num<=0 && $Color_col_num<=0 && $Clarity_col_num<=0 && $crr_row<9){
		## store the correct col number to the vars
		foreach($crr_row_content_array as $col_title){
			if($col_title=='Seller Name'){
				$sellername_col_num=$col_counter;
			}else if($col_title=='RapNet Account ID'){
				$RapNetAccountID_col_num=$col_counter;
			}else if($col_title=='Name Code'){
				$NameCode_col_num=$col_counter;
			}else if($col_title=='Shape'){
				$Shape_col_num=$col_counter;
			}else if($col_title=='Weight'){
				$Weight_col_num=$col_counter;
			}else if($col_title=='Color'){
				$Color_col_num=$col_counter;
			}else if($col_title=='Clarity'){
				$Clarity_col_num=$col_counter;
			}else if($col_title=='Cut'){
				$Cut_col_num=$col_counter;
			}else if($col_title=='Polish'){
				$Polish_col_num=$col_counter;
			}else if($col_title=='Symmetry'){
				$Symmetry_col_num=$col_counter;
			}else if($col_title=='Fluorescence Intensity'){
				$FluorescenceIntensity_col_num=$col_counter;
			}else if($col_title=='Lab'){
				$Lab_col_num=$col_counter;
			}else if($col_title=='Certificate Number'){
				$CertificateNumber_col_num=$col_counter;
			}else if($col_title=='Stock Number'){
				$StockNumber_col_num=$col_counter;
			}else if($col_title=='Price Per Carat'){
				$PricePerCarat_col_num=$col_counter;
			}else if($col_title=='Price Percentage'){
				$PricePercentage_col_num=$col_counter;
			}else if($col_title=='Total Price'){
				$TotalPrice_col_num=$col_counter;
			}else if($col_title=='Cash Price Per Carat'){
				$CashPricePerCarat_col_num=$col_counter;
			}else if($col_title=='Cash Price Percentage'){
				$CashPricePercentage_col_num=$col_counter;
			}else if($col_title=='Total Cash Price'){
				$TotalCashPrice_col_num=$col_counter;
			}else if($col_title=='City'){
				$City_col_num=$col_counter;
			}else if($col_title=='State'){
				$State_col_num=$col_counter;
			}else if($col_title=='Country'){
				$Country_col_num=$col_counter;
			}else if($col_title=='Certificate URL'){
				$CertificateURL_col_num=$col_counter;
			}else if($col_title=='Image URL'){
				$ImageURL_col_num=$col_counter;
			}else if($col_title=='Diamond ID'){
				$DiamondID_col_num=$col_counter;
			}
			$col_counter++;
		}
	}else{
		
		## get the records and save to the database line by line
		
		if($Shape_col_num<0 || $Color_col_num<0 || $Clarity_col_num<0 || $sellername_col_num<0 || $DiamondID_col_num<0){
			exit('error :: no table title found');
		}else{
			$DiamondID=$crr_row_content_array[$DiamondID_col_num];
			$records_from_rapnet[]=$DiamondID;
			if (in_array($DiamondID, $records_in_db)) {
				//echo '<br>*************** found in db: '.$DiamondID.' do nothing';
			}else{
				//echo '<br>not in db: '.$DiamondID.' now insert ::<br>';
				$sellername=$crr_row_content_array[$sellername_col_num];
				$RapNetAccountID=$crr_row_content_array[$RapNetAccountID_col_num];
				//echo '<br>NameCode :'.$crr_row_content_array[$NameCode_col_num];
				$shape=$crr_row_content_array[$Shape_col_num];
				$Weight=$crr_row_content_array[$Weight_col_num];
				$Color=$crr_row_content_array[$Color_col_num];
				$Clarity=$crr_row_content_array[$Clarity_col_num];
				$cut=$crr_row_content_array[$Cut_col_num];
				$polish=$crr_row_content_array[$Polish_col_num];
				$symmetry=$crr_row_content_array[$Symmetry_col_num];
				$FluorescenceIntensity=$crr_row_content_array[$FluorescenceIntensity_col_num];
				$Lab=$crr_row_content_array[$Lab_col_num];
				$CertificateNumber=$crr_row_content_array[$CertificateNumber_col_num];
				$StockNumber=$crr_row_content_array[$StockNumber_col_num];
				$PricePerCarat=$crr_row_content_array[$PricePerCarat_col_num];
				$PricePercentage=$crr_row_content_array[$PricePercentage_col_num];
				$TotalPrice=$crr_row_content_array[$TotalPrice_col_num];
				$CashPricePerCarat=$crr_row_content_array[$CashPricePerCarat_col_num];
				$CashPricePercentage=$crr_row_content_array[$CashPricePercentage_col_num];
				$TotalCashPrice=$crr_row_content_array[$TotalCashPrice_col_num];
				//$City=$crr_row_content_array[$City_col_num];
				//echo '<br>State :'.$crr_row_content_array[$State_col_num];
				$Country=$crr_row_content_array[$Country_col_num];
				$CertificateURL=$crr_row_content_array[$CertificateURL_col_num];
				$ImageURL=$crr_row_content_array[$ImageURL_col_num];
					
				$fancy_color_dominant_color='';
				$source='RAPNET';
				
				
				if($TotalCashPrice!=''){
					$raw_price_total=floatval($TotalCashPrice);
				}else if($TotalPrice!=''){
					$raw_price_total=floatval($TotalPrice);
				}else{
					$raw_price_total=0;
				}
				
				if($CashPricePercentage!=''){
					$percentage=floatval($CashPricePercentage)*100;
				}else if($PricePercentage!=''){
					$percentage=floatval($PricePercentage)*100;
				}else{
					$percentage=0;
				}
				if($percentage==0)
					echo $DiamondID.':cash percentage:'.$CashPricePercentage.',PricePercentage:'.$PricePercentage.',percentage:'.$percentage.'---------------- the total price <br>';
					
				$raw_price=$percentage;//te put in the database raw_price
				$raw_price_retail=$raw_price_total;//for retail raw price(without the ratio)
				$clarity_number='-';
				$cut_number='-';
				
				if($cut=='Excellent'){
					$cut = 'EX';
				}else if($cut=='Very Good'){
					$cut='VG';
				}else if($cut=='Good'){
					$cut='G';
				}else if($cut=='Fair'){
					$cut='F';
				}
				
				if($polish=='Excellent'){
					$polish = 'EX';
				}else if($polish=='Very Good'){
					$polish='VG';
				}else if($polish=='Good'){
					$polish='G';
				}else if($polish=='Fair'){
					$polish='F';
				}
				
				if($symmetry=='Excellent'){
					$symmetry = 'EX';
				}else if($symmetry=='Very Good'){
					$symmetry='VG';
				}else if($symmetry=='Good'){
					$symmetry='G';
				}else if($symmetry=='Fair'){
					$symmetry='F';
				}
				
				if($shape=='Round'){
					$shape='BR';
				}else if($shape=='Princess'){
					$shape='PR';
				}else if($shape=='Pear'){
					$shape='PS';
				}else if($shape=='Marquise'){
					$shape='MQ';
				}else if($shape=='Oval'){
					$shape='OV';
				}else if($shape=='Radiant'){
					$shape='RAD';
				}else if($shape=='Emerald'){
					$shape='EM';
				}else if($shape=='Heart'){
					$shape='HS';
				}else if($shape=='Cushion'){
					$shape='CU';
				}else if($shape=='Asscher'){
					$shape='AS';
				}
				$price=processPrice($Weight, $Color, $Clarity, $cut, $polish, $symmetry, $Lab, $shape, $FluorescenceIntensity, $raw_price_total, 0, 'rapnet', 'agency');
				$retail_price=processPrice($Weight, $Color, $Clarity, $cut, $polish, $symmetry, $Lab, $shape, $FluorescenceIntensity, $raw_price_total, 0, 'rapnet', 'retail');
				//echo $DiamondID.',weight:'.$Weight.':rapnet price:'.$raw_price_total.'-';
				//echo ':agency price:'.$price.'-';
				//echo ':retail price:'.$retail_price;
			//	echo '网上价格：'.$TotalCashPrice.'---------------- the total price cash <br> '.$DiamondID;
				
				//echo '<br>++++++++++++++++++++++++++<br><br>++++++++++++++++++++++++++<br>';
				/**/
				$insertTotal = 0;
				if($price>0 && $retail_price>0){
					$sql_insert='INSERT INTO diamonds (stock_ref, stock_num_rapnet, shape, carat, color, fancy_color, clarity, grading_lab, certificate_number,certificatelink, cut_grade, polish, symmetry, fluorescence_intensity, country, raw_price, raw_price_retail, price, retail_price, from_company, clarity_number, cut_number, added_at, source) VALUES (:stock_ref, :stock_num_rapnet, :shape, :carat, :color, :fancy_color, :clarity, :grading_lab, :certificate_number, :certificatelink,:cut_grade, :polish, :symmetry, :fluorescence_intensity, :country, :raw_price, :raw_price_retail, :price, :retail_price, :from_company, :clarity_number, :cut_number, NOW(), :source)';
					$stmt=$conn->prepare($sql_insert);	  
// 					$stmt->bindParam(':stock_ref', $DiamondID, PDO::PARAM_STR);
// 					$stmt->bindParam(':stock_num_rapnet', $StockNumber, PDO::PARAM_STR);
// 					$stmt->bindParam(':shape', $shape, PDO::PARAM_STR);
// 					$stmt->bindParam(':carat', $Weight, PDO::PARAM_STR);
// 					$stmt->bindParam(':color', $Color, PDO::PARAM_STR);
// 					$stmt->bindParam(':fancy_color', $fancy_color_dominant_color, PDO::PARAM_STR);
// 					$stmt->bindParam(':clarity', $Clarity, PDO::PARAM_STR);
// 					$stmt->bindParam(':grading_lab', $Lab, PDO::PARAM_STR);
// 					$stmt->bindParam(':certificate_number', $CertificateNumber, PDO::PARAM_STR);
// 					$stmt->bindParam(':cut_grade', $cut, PDO::PARAM_STR);
// 					$stmt->bindParam(':polish', $polish, PDO::PARAM_STR);
// 					$stmt->bindParam(':symmetry', $symmetry, PDO::PARAM_STR);
// 					$stmt->bindParam(':fluorescence_intensity', $FluorescenceIntensity, PDO::PARAM_STR);
// 					$stmt->bindParam(':country', $Country, PDO::PARAM_STR);
// 					$stmt->bindParam(':raw_price', $percentage, PDO::PARAM_STR);	
// 					$stmt->bindParam(':raw_price_retail', $raw_price_retail, PDO::PARAM_STR);
// 					$stmt->bindParam(':retail_price', $retail_price, PDO::PARAM_STR);	
// 					$stmt->bindParam(':price', $price, PDO::PARAM_INT);
// 					$stmt->bindParam(':from_company', $sellername, PDO::PARAM_STR);
// 					$stmt->bindParam(':clarity_number', $clarity_number, PDO::PARAM_STR);
// 					$stmt->bindParam(':cut_number', $cut_number, PDO::PARAM_STR);
// 					$stmt->bindParam(':source', $source, PDO::PARAM_STR);
// 					$stmt->execute();
					$stmt->execute(array(
							'stock_ref'=>$DiamondID,
							'stock_num_rapnet'=>$StockNumber,
							'shape'=>$shape,
							'carat'=>$Weight,
							'color'=>$Color,
							'fancy_color'=>$fancy_color_dominant_color,
							'clarity'=>$Clarity,
							'grading_lab'=>$Lab,
							'certificate_number'=>$CertificateNumber,
							'certificatelink'=>$CertificateURL,
							'cut_grade'=>$cut,
							'polish'=>$polish,
							'symmetry'=>$symmetry,
							'fluorescence_intensity'=>$FluorescenceIntensity,
							'country'=>$Country,
							'raw_price'=>$percentage,
							'raw_price_retail'=>$raw_price_retail,
							'retail_price'=>$retail_price,
							'price'=>$price,
							'from_company'=>$sellername,
							'clarity_number'=>$clarity_number,
							'cut_number'=>$cut_number,
							'source'=>$source
					));
					$OK=$stmt->rowCount();$insertTotal++;
					echo ' inserted: '.$OK.'  :  '.$DiamondID.'<br>';
				}else{
					echo ' inserted NO !!!: no price for this diamond :'.$DiamondID.'<br>';
				}
			}
			
		}
	}
	$crr_row++;
}

fclose($file);

$status='inserting fini, not delete yet';



//last step :: delete the records that are not in the rapnet anymore
//###################################################################################################################
//###################################################################################################################
//###### step 2. go through the DB, delete ones not in the list array, delete ones in the array not in the db #######
//###################################################################################################################
//###################################################################################################################
echo 'finish inserting, now deleting...<br><br><br>-------------------------<br><br><br>';
//print_r($diamond_ids);

echo 'records_from_rapnet:'.$records_from_rapnet;




//$sql_gothroug='SELECT stock_ref FROM diamonds WHERE source = "RAPNET" AND ordered_by IS NULL AND wholesale_ordered_by IS NULL';
$sql_gothroug='SELECT stock_ref, ordered_by, wholesale_ordered_by FROM diamonds WHERE source = "RAPNET" AND status = "AVAILABLE"';
foreach($conn->query($sql_gothroug) as $row){
	$crr_dia=$row['stock_ref'];
	$ordered_by=$row['ordered_by'];
	$wholesale_ordered_by=$row['wholesale_ordered_by'];
	//echo 'checking: '.$crr_dia;
	if(!in_array($crr_dia, $records_from_rapnet)){
		if(($ordered_by!=NULL && $ordered_by!='') || ($wholesale_ordered_by!='' && $wholesale_ordered_by!=NULL)){
			$sql_update_sold='UPDATE diamonds SET status = "SOLD" WHERE stock_ref = "'.$crr_dia.'"';
			$stmt_update_sold=$conn->query($sql_update_sold);
			echo ' not in array, but ordered. updated status. '.$crr_dia.'||||||||<br>';
		}else{
			//如果数据库中数据不在数组里，说明该钻石已经不在。删除该纪录
			$sql_del='DELETE FROM diamonds WHERE stock_ref = "'.$crr_dia.'"';
			$stmt_del=$conn->query($sql_del);
			echo ' not in array, deleted '.$crr_dia.'||||||||<br>';
		}
		
	}else{
		//echo ' in array. stays.<br>';
	}
}

$status='ok except currency';








//###################################################################################################################
//###################################################################################################################
//###### step 3. UPDATE CURRENCY  #######
//###################################################################################################################
//###################################################################################################################
 echo '<br><br><br><br><br><br><br>**********<br>**********<br>**********<br>fini... data updated succefull (-_-) <br>**********<br>**********<br>**********<br><br><br><br><br><br><br>';
echo 'now change currency (currency changing is now disabled. proceed.)';

//$yql_query = 'SELECT * FROM yahoo.finance.xchange WHERE pair in ("USDEUR", "USDGBP", "USDCNY")'; //YQL query to retrieve search results
//$value = "bangalore";

//var_dump(getResultFromYQL(sprintf($yql_query)));
//print_r(getResultFromYQL(sprintf($yql_query)));
/**
 * Function to get results from YQL
 *
 * @param String $yql_query - The YQL Query
 * @param String $env - Environment in which the YQL Query should be executed. (Optional)
 *
 * @return object response
 */
 /*
$c=getResultFromYQL(sprintf($yql_query));
$id0=$c->{'query'}->{'results'}->{'rate'}[0]->{'id'};
$id1=$c->{'query'}->{'results'}->{'rate'}[1]->{'id'};
$id2=$c->{'query'}->{'results'}->{'rate'}[2]->{'id'};

if($id0=='USDEUR'){
	$eur=$c->{'query'}->{'results'}->{'rate'}[0]->{'Rate'};
}else if($id0=='USDGBP'){
	$gbp=$c->{'query'}->{'results'}->{'rate'}[0]->{'Rate'};
}else if($id0=='USDCNY'){
	$cny=$c->{'query'}->{'results'}->{'rate'}[0]->{'Rate'};
}
if($id1=='USDEUR'){
	$eur=$c->{'query'}->{'results'}->{'rate'}[1]->{'Rate'};
}else if($id1=='USDGBP'){
	$gbp=$c->{'query'}->{'results'}->{'rate'}[1]->{'Rate'};
}else if($id1=='USDCNY'){
	$cny=$c->{'query'}->{'results'}->{'rate'}[1]->{'Rate'};
}
if($id2=='USDEUR'){
	$eur=$c->{'query'}->{'results'}->{'rate'}[2]->{'Rate'};
}else if($id2=='USDGBP'){
	$gbp=$c->{'query'}->{'results'}->{'rate'}[2]->{'Rate'};
}else if($id2=='USDCNY'){
	$cny=$c->{'query'}->{'results'}->{'rate'}[2]->{'Rate'};
}

if($cny==0 || empty($cny)){
	$cny=6.50;
}


$sql_c='UPDATE convert_currency SET USD_EUR = "'.$eur.'", USD_GBP = "'.$gbp.'", USD_CNY = "'.$cny.'" WHERE id = 1';
$stmt_c=$conn->query($sql_c);	  
//$stmt_log->execute(array($eur, $gbp, $cny));
$c_done=$stmt_c->rowCount();
if($c_done){
	$status='all ok';
    echo '<br><br><br><br><br><br><br>**********<br>**********<br>**********<br>fini... currency updated succefull (-_-) <br>**********<br>**********<br>**********<br><br><br><br><br><br><br>';
}


*/


$status='all ok';
    echo '<br><br><br><br><br><br><br>**********<br>**********<br>**********<br>fini... currency updated succefull (-_-) <br>**********<br>**********<br>**********<br><br><br><br><br><br><br>';

$sql_log='INSERT INTO dataupdate_log (status) VALUES (:status)';
		
			
$stmt_log=$conn->prepare($sql_log);	  
$stmt_log->bindParam(':status', $status, PDO::PARAM_STR);
					
$stmt_log->execute();


function getResultFromYQL($yql_query, $env = 'store://datatables.org/alltableswithkeys') {
    $yql_base_url = "https://query.yahooapis.com/v1/public/yql";
    $yql_query_url = $yql_base_url . "?q=" . urlencode($yql_query);
    $yql_query_url .= "&format=json";

    if ($env != '') {
        $yql_query_url .= '&env=' . urlencode($env);
    }

    $session = curl_init($yql_query_url);
    curl_setopt($session, CURLOPT_RETURNTRANSFER, true);

    //Uncomment if you are behind a proxy

    //curl_setopt($session, CURLOPT_PROXY, 'Your proxy url');
    //curl_setopt($session, CURLOPT_PROXYPORT, 'Your proxy port');
    //curl_setopt($session, CURLOPT_PROXYUSERPWD, 'Your proxy password');

    $json = curl_exec($session);
    curl_close($session);

    return json_decode($json);
}

?>
