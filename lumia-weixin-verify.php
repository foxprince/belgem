<?php
/**
  * wechat php test
  */

//define your token
require_once('includes/connection.php');
$conn=dbConnect('write','pdo');
$conn->query("SET NAMES 'utf8'");





define("TOKEN", "lumia123weixin");
$wechatObj = new wechatCallbackapiTest();
//$wechatObj->valid();
if($wechatObj->valid()){
	/*
	$message00=$_SERVER[REQUEST_URI];
	
	$sql='INSERT INTO wechat_record (message) VALUES(:message)';
	$stmt=$conn->prepare($sql);	  
	$stmt->bindParam(':message', $message00, PDO::PARAM_STR);
	$stmt->execute();
	$OK=$stmt->rowCount();
	*/
	
	$wechatObj->responseMsg();
}


class wechatCallbackapiTest
{
	public function valid()
    {
        $echoStr = $_GET["echostr"];

        //valid signature , option
        if($this->checkSignature()){
        	//echo $echoStr;
        	//exit;
			return true;
        }else{
			return false;
		}
    }

    public function responseMsg()
    {
		//get post data, May be due to the different environments
		$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];

      	//extract post data
		if (!empty($postStr)){
                /* libxml_disable_entity_loader is to prevent XML eXternal Entity Injection,
                   the best way is to check the validity of xml by yourself */
				   
				   
				   
				   
                libxml_disable_entity_loader(true);
              	$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
				
                $fromUsername = $postObj->FromUserName;
                $toUsername = $postObj->ToUserName;
                //$keyword = trim($postObj->Content);
                $time = time();
				
				
				
				
				
				
				$wechat_name='not set yet';
				
				
				$MsgType=$postObj->MsgType;
				
				
				if($MsgType=='text'){
					$keyword = trim($postObj->Content);
				}else if($MsgType=='image'){
					$keyword = trim($postObj->PicUrl);
					$MediaId=$postObj->MediaId;
				}else if($MsgType=='voice'){
					$keyword = 'voice & video';
					$MediaId=$postObj->MediaId;
					$Format=$postObj->Format;
				}else if($MsgType=='video'){
					$keyword = 'voice & video';
					$MediaId=$postObj->MediaId;
					$Format=$postObj->Format;
					$ThumbMediaId=$postObj->ThumbMediaId;
				}else if($MsgType=='location'){
					$keyword = 'location';
					$Location_X=$postObj->Location_X;
					$Location_Y=$postObj->Location_Y;
					$Label=$postObj->Label;
				}else if($MsgType=='link'){
					$keyword = 'Url';
					$Title=$postObj->Title;
					$Description=$postObj->Description;
				}
				
				$MsgId=$postObj->MsgId;
				
				if(!isset($keyword)){
					$keyword='-';
				}
				if(!isset($MediaId)){
					$MediaId='-';
				}
				if(!isset($Format)){
					$Format='-';
				}
				if(!isset($ThumbMediaId)){
					$ThumbMediaId='-';
				}
				if(!isset($Location_X)){
					$Location_X='-';
				}
				if(!isset($Location_Y)){
					$Location_Y='-';
				}
				if(!isset($Label)){
					$Label='-';
				}
				if(!isset($Title)){
					$Title='-';
				}
				if(!isset($Description)){
					$Description='-';
				}
				
				
				
				
				
                $textTpl = "<xml>
							<ToUserName><![CDATA[%s]]></ToUserName>
							<FromUserName><![CDATA[%s]]></FromUserName>
							<CreateTime>%s</CreateTime>
							<MsgType><![CDATA[%s]]></MsgType>
							<Content><![CDATA[%s]]></Content>
							<FuncFlag>0</FuncFlag>
							</xml>"; 
				/**/
				
				
				
				
				require_once('includes/connection.php');
				$conn=dbConnect('write','pdo');
				$conn->query("SET NAMES 'utf8'");
				
				    
				if(!empty( $keyword ) && $keyword!='-' && $MsgType!='event')
                {
					
					$sql_check='SELECT * FROM wechat_record WHERE wechat_open_id = "'.$fromUsername.'"';
					$stmt_search=$conn->query($sql_check);
					$found_record=$stmt_search->rowCount();
					if(!$found_record){					
						$msgType = "text";
						$contentStr = "感谢您关注比利时BELGEM钻石公司，利美钻石是我司专营比利时优质钻石的品牌。由于微信公众号现阶段只能在电脑上回复信息，没有移动回复功能。所以为了在第一时间回复您的信息，我们特意开通了手机客服微信号limeikefu，欢迎您加入。直接在添加朋友中输入limeikefu即可添加。";
						$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
						/**/
						echo $resultStr;
					}
					
					
					
					$sql='INSERT INTO wechat_record (wechat_open_id, wechat_name, message, CreateTime, MsgType, MsgId, MediaId, Format, ThumbMediaId, Location_X, Location_Y, Label, Title, Description) VALUES(:wechat_open_id, :wechat_name, :message, NOW(), :MsgType, :MsgId, :MediaId, :Format, :ThumbMediaId, :Location_X, :Location_Y, :Label, :Title, :Description)';
					$stmt=$conn->prepare($sql);	  
					
					$stmt->bindParam(':wechat_open_id', $fromUsername, PDO::PARAM_STR);
					$stmt->bindParam(':wechat_name', $wechat_name, PDO::PARAM_STR);
					$stmt->bindParam(':message', $keyword, PDO::PARAM_STR);
					$stmt->bindParam(':MsgType', $MsgType, PDO::PARAM_STR);
					$stmt->bindParam(':MsgId', $MsgId, PDO::PARAM_STR);
					$stmt->bindParam(':MediaId', $MediaId, PDO::PARAM_STR);
					$stmt->bindParam(':Format', $Format, PDO::PARAM_STR);
					$stmt->bindParam(':ThumbMediaId', $ThumbMediaId, PDO::PARAM_STR);
					$stmt->bindParam(':Location_X', $Location_X, PDO::PARAM_STR);
					$stmt->bindParam(':Location_Y', $Location_Y, PDO::PARAM_STR);
					$stmt->bindParam(':Label', $Label, PDO::PARAM_STR);
					$stmt->bindParam(':Title', $Title, PDO::PARAM_STR);
					$stmt->bindParam(':Description', $Description, PDO::PARAM_STR);
					
					$stmt->execute();
					$OK=$stmt->rowCount();
					
                }else if($MsgType=='event'){
					
					
					$wechat_name='-';
					$name='-';
					$sex='-';
					$address='-';
					$suscribe_status=$postObj->Event;
					
					
					$sql_search='SELECT * FROM clients_list WHERE wechat_open_id="'.$fromUsername.'"';
					$stmt=$conn->query($sql_search);
					$ok=$stmt->rowCount();
					if(!$ok){
						$sql='INSERT INTO clients_list (wechat_open_id, wechat_name, name, sex, address, subscribed_time, suscribe_status) VALUES(:wechat_open_id, :wechat_name, :name, :sex, :address, NOW(), :suscribe_status)';
						$stmt=$conn->prepare($sql);	  
					
						$stmt->bindParam(':wechat_open_id', $fromUsername, PDO::PARAM_STR);
						$stmt->bindParam(':wechat_name', $wechat_name, PDO::PARAM_STR);
						$stmt->bindParam(':name', $name, PDO::PARAM_STR);
						$stmt->bindParam(':sex', $sex, PDO::PARAM_STR);
						$stmt->bindParam(':address', $address, PDO::PARAM_STR);
						$stmt->bindParam(':suscribe_status', $suscribe_status, PDO::PARAM_STR);
						
						$stmt->execute();
						$OK=$stmt->rowCount();
						
						
						
						
						/**/
						
						
						$msgType = "text";
						$contentStr = "感谢您关注比利时Belgem公司!";
						$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
						
						echo $resultStr;
						
						
						
					}else{
						$sql='UPDATE clients_list SET suscribe_status = ? WHERE wechat_open_id = ?';
						$stmt=$conn->prepare($sql);		
						$stmt->execute(array($suscribe_status, $fromUsername));
						$OK=$stmt->rowCount();
						
					}
					
					
					
					
					
					
					
				}else{
                	echo "Input something...";
                }

        }else {
        	echo "";
        	exit;
        }
    }
		
	private function checkSignature()
	{
        // you must define TOKEN by yourself
        if (!defined("TOKEN")) {
            throw new Exception('TOKEN is not defined!');
        }
        
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];
        		
		$token = TOKEN;
		$tmpArr = array($token, $timestamp, $nonce);
        // use SORT_STRING rule
		sort($tmpArr, SORT_STRING);
		$tmpStr = implode( $tmpArr );
		$tmpStr = sha1( $tmpStr );
		
		if( $tmpStr == $signature ){
			return true;
		}else{
			return false;
		}
	}
}

?>