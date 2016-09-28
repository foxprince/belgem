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
	exit('未找到公司');
}

$sellerdetials=$obj_reply->{'response'}->{'body'}->{'seller'};

$seller_account_id=$sellerdetials->{'account_id'};
$seller_company=$sellerdetials->{'company'};
$seller_name=$sellerdetials->{'name'};
$seller_email=$sellerdetials->{'email'};
$seller_phone=$sellerdetials->{'phone'};
$seller_country=$sellerdetials->{'country'};
$seller_state=$sellerdetials->{'state'};
$seller_city=$sellerdetials->{'city'};


$sql_co='UPDATE diamonds SET from_company = "'.$seller_company.'", contact_tel = "'.$seller_phone.'" WHERE stock_ref = "'.$diamondid.'"';
$stmt=$conn->query($sql_co);
?>



<span style="font-size:14px; white-space:normal;"><?php echo $seller_company; ?></span><br />
<span style="font-size:10px;"><?php echo $seller_phone; ?></span>


