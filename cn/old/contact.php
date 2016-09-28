<?php
if(isset($_POST['thetxt']) && isset($_POST['email'])){
	
	
	 $input_email=$_POST['email'];
	 $input_name=$_POST['name'];
	 $input_address=$_POST['address'];
	 $input_country=$_POST['country'];
	 $input_question=$_POST['thetxt'];
	 $input_price=$_POST['price'];
	
	require_once('../includes/recaptchalib.php');
	$privatekey = "6LcO9u0SAAAAAGMQoM3deCE6Pw9eZ8oFOeZAZYVc";
	$resp = recaptcha_check_answer ($privatekey,
									$_SERVER["REMOTE_ADDR"],
									$_POST["recaptcha_challenge_field"],
									$_POST["recaptcha_response_field"]);

	if (!$resp->is_valid) {
	// What happens when the CAPTCHA was entered incorrectly
	/*
	die ("The reCAPTCHA wasn't entered correctly. Go back and try it again." .
		 "(reCAPTCHA said: " . $resp->error . ")");
		 */
		 $message="验证码输入错误，请重试";
		 
	}else if(!filter_var($input_email, FILTER_VALIDATE_EMAIL)){
		$message="电子邮件地址无效，请核实";
	}else if($input_question==''){
		$message="您发送的消息不能为空";
	}else {
	// Your code here to handle a successful verification
		$to      = 'info@lumiagem.com';
		$subject = '您有一则通过网站发送的新留言';
		$message = "发信人: $input_name\n发信人地址: $input_address\n发信人国家: $input_country\n价格范围: $input_price\n\n信息内容:\n".$input_question;
		$headers = "From: $input_name <$input_email>";
		
		mail($to, $subject, $message, $headers);
		$message = "谢谢您的留言，我们会尽快和您联系";
		$input_email="";
		$input_name="";
		$input_address='';
		$input_question="";
		$input_price="";
		$input_country="";
	}

	
	
}else{
	$input_email="";
	$input_name="";
	$input_address='';
	$input_question="";
	$input_price="";
	$input_country="";
}
?>




<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link href="../styles/main.css?v=1395407389" media="screen" rel="stylesheet" type="text/css" />
<style type="text/css">
img.sidevisual{
	width:360px; 
	margin: 20px 35px 185px 0; 
	float:left;
}
label{
	display:inline-block;
	width:108px;
}
#contactform input{
	width:208px;
}
#cformsendbtn{
	font-size:14px; 
	font-weight:bold; 
	padding:12px 30px; 
	background-color:#CC6699;
	color:#FFF; 
	border-width:1px; 
	width:200px;
}
p.pq{
	margin:5px 0;
}
h4#feedbackmessage{
	color:#CC6699;
	font-size:20px;
}
#contactinfo{
	margin-bottom:20px;
	border-bottom-style:dotted;
	border-width:1px;
	border-color:#CC6699;
	padding-bottom:20px;
}
</style>
<script type="text/javascript">
var RecaptchaOptions = {
theme : 'clean'
};
</script>
<title>LUMIA JEWELRY</title>
</head>

<body>



<?php
include_once('header.php');

require_once('../includes/connection.php');
$conn=dbConnect('write','pdo');
$conn->query("SET NAMES 'utf8'");


$sql_element='SELECT * FROM settings';
foreach($conn->query($sql_element) as $ele){}

$sql_txt='SELECT content_ch FROM contact_txt';
foreach($conn->query($sql_txt) as $txt){}
?>


<div id="bodycontent">
<h3 class="blocktitle">利美钻石 : 联系我们</h3>
<img class="sidevisual" src="<?php echo $ele['contactimage']; ?>" />

<div style="position:relative; float:left; width:500px; margin-left:15px; margin-top:12px;">

<div id="contactinfo">
<?php echo $txt['content_ch']; ?>
</div>

<?php
if(isset($message)){
?>
<h4 id="feedbackmessage"><?php echo $message; ?></h4>
<?php
}
?>

<p style="margin-bottom:20px; font-weight:bold;">留言给我们:</p>
<form action="" method="post" id="contactform">
<p class="pq"><label for="name" class="cformlabel">姓名</label> <input type="text" name="name" id="visitorname" value="<?php echo $input_name; ?>" /></p>
<p class="pq"><label for="name" class="cformlabel">邮寄地址</label> <input type="text" name="address" id="visitorname" value="<?php echo $input_address; ?>" /></p>
<p class="pq"><label for="name" class="cformlabel">国家</label> <input type="text" name="country" id="visitorname" value="<?php echo $input_country; ?>" /></p>

<p class="pq"><label for="email" class="cformlabel">E-mail</label> <input type="text" name="email" id="visitoremail" value="<?php echo $input_email; ?>" /></p>
<p class="pq">
<label for="subject" class="cformlabel">价格范围</label>

<select name="price" id="subjectselect">
<option value="">请选择...</option>
<option value="less than 3000€" <?php if($input_price=='less than 3000€'){ echo 'selected="selected"';} ?>>3000€以内</option>
<option value="3000 - 5000€" <?php if($input_price=='3000 - 5000€'){ echo 'selected="selected"';} ?>>3000 - 5000€</option>
<option value="5000 - 7000€" <?php if($input_price=='5000 - 7000€'){ echo 'selected="selected"';} ?>>5000 - 7000€</option>
<option value="7000 - 10000€" <?php if($input_price=='7000 - 10000€'){ echo 'selected="selected"';} ?>>7000 - 10000€</option>
<option value="10000 - 15000€" <?php if($input_price=='10000 - 15000€'){ echo 'selected="selected"';} ?>>10000 - 15000€</option>
<option value="15000 - 20000€" <?php if($input_price=='15000 - 20000€'){ echo 'selected="selected"';} ?>>15000 - 20000€</option>
<option value="20000€ or more" <?php if($input_price=='20000€ or more'){ echo 'selected="selected"';} ?>>20000€以上</option>

</select>
</p>
<p class="pq" style="margin-top:12px;"><label for="thetxt" class="cformlabel">留言:</label></p>
<textarea name="thetxt" id="thetxt" style="width:350px; height:165px;"><?php echo $input_question; ?></textarea>


<br /><br />


<?php
  require_once('../includes/recaptchalib.php');
  $publickey = "6LcO9u0SAAAAANawStaX2pepCvdjPzfACk8Pizeo"; // you got this from the signup page
  echo recaptcha_get_html($publickey);
?>

<br /><br />
<input type="submit" id="cformsendbtn" value="发送信息">

</form>


</div>
  
<br style="clear:both" />  
  
  
</div>




<?php
include_once('footer.php');
?>




</body>
</html>