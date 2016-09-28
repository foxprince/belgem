<?php
header('Access-Control-Allow-Origin: *');

if(!isset($_POST['diamond_id'])){
	exit('NO_DATA');
}

$diamondid=$_POST['diamond_id'];


require_once('../includes/connection.php');
$conn=dbConnect('write','pdo');
$conn->query("SET NAMES 'utf8'");


$urltopost='https://technet.rapaport.com/HTTP/JSON/RetailFeed/GetSingleDiamond.aspx';


$data = '
{
	"request": {
		"header": {
		"username": "90733", 
		"password": "G4n8m4G9"
		
		}, 
		"body": {
		"diamond_id": '.$diamondid.' 
		}
	}
}';
                                                        
                                                                                 
 
$ch = curl_init($urltopost);     
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);                                                                                                                   
 
$result = curl_exec($ch);
//echo '<!-- '.$result.'-->';
$obj_reply = json_decode($result);
//$reply_feedback=$obj_reply->{'response'};

//echo $reply_feedback;
//print_r($obj_reply);


$feedback_message=$obj_reply->{'response'}->{'header'}->{'error_code'};
//echo $feedback_message;
if($feedback_message!=0){
	//echo 'FEEDBACKERROR';
	exit('未找到钻石');
}



$dia_details=$obj_reply->{'response'}->{'body'}->{'diamond'};

$stocknum=$dia_details->{'stock_num'};


$sql_s='UPDATE diamonds SET stock_num_rapnet = "'.$stocknum.'" WHERE stock_ref = "'.$diamondid.'"';
$stmt=$conn->query($sql_s);
?>


<?php echo $stocknum; ?>