<?php

	/**
	 * 注：本邮件类都是经过我测试成功了的，如果大家发送邮件的时候遇到了失败的问题，请从以下几点排查：
	 * 1. 用户名和密码是否正确；
	 * 2. 检查邮箱设置是否启用了smtp服务；
	 * 3. 是否是php环境的问题导致；
	 * 4. 将26行的$smtp->debug = false改为true，可以显示错误信息，然后可以复制报错信息到网上搜一下错误的原因；
	 * 5. 如果还是不能解决，可以访问：http://www.daixiaorui.com/read/16.html#viewpl 
	 *    下面的评论中，可能有你要找的答案。
	 */
require_once('getaccesstoken.php');
require_once('log.php');
if(isset($_GET['toemail'])){
	$urltopost='https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token='.$theaccesstoken;
	$data = '{
	        "touser":"'.$_POST['toemail'].'",
	        "msgtype":"text",
	        "text":
	        {
	             "content":"'.$_POST['content'].'"
	        }
	    }';
	                                                                  
	//$data_string = json_encode($data);                                                                                   
	$ch = curl_init($urltopost);     
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);                                                                                                                   
	$result = curl_exec($ch);
	logger($result);
	$obj_reply = json_decode($result);
	$reply_feedback=$obj_reply->{'errmsg'};
	logger($reply_feedback);
}
else if(isset($_GET['update'])){
	require_once('includes/connection_user.php');        #
	$conn=dbConnect('write','pdo');                      # database connected here 
	$conn->query("SET NAMES 'utf8'"); 
	$sql="SELECT wechat_open_id FROM clients_list where 1=1";
	if(isset($_GET['id']))
		$sql .= " and wechat_open_id='".$_GET['id']."'";
	$ooh=$conn->query($sql);
	foreach($ooh as $row){
					$curl_ci = curl_init();//client info
					curl_setopt_array($curl_ci, array(
						CURLOPT_RETURNTRANSFER => 1,
						CURLOPT_URL =>'https://api.weixin.qq.com/cgi-bin/user/info?access_token='.$theaccesstoken.'&openid='.$row['wechat_open_id'].'&lang=zh_CN',
						CURLOPT_USERAGENT => 'Codular Sample cURL Request'
					));
					// Send the request & save response to $resp
					$resp_ci = curl_exec($curl_ci);
					// Close request to clear up some resources
					curl_close($curl_ci);
					
					$obj_ci = json_decode($resp_ci);
					if ($obj_ci->{'errcode'} == 0) {
						$wechat_name=$obj_ci->{'nickname'}; // 12345
						$sex=$obj_ci->{'sex'};
						$address001=$obj_ci->{'city'};
						$address002=$obj_ci->{'province'};
						$address002=$obj_ci->{'country'};
						$address=$address001.', '.$address002.', '.$address003;
						$usericon=$obj_ci->{'headimgurl'};
						$reference='FINAL-WECHAT';					
						$sql='UPDATE clients_list SET wechat_name = ?, sex = ?, address = ?, icon = ? WHERE wechat_open_id = ?';//$fromUsername
						logger(" update wechat_name:".$wechat_name);
						$stmt=$conn->prepare($sql);		
						$stmt->execute(array($wechat_name, $sex, $address, $usericon, $row['wechat_open_id']));
						$OK=$stmt->rowCount();
					}
					else{
						logger("get wechat user info err:".$resp_ci);
					}
						
			}
					
}
?>