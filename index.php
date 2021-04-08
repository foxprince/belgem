<?php
header('Location: _admin/login.php');

exit('');

$theRequestedURL="$_SERVER[HTTP_HOST]";
if(trim($theRequestedURL)=='sigway.be' || trim($theRequestedURL)=='www.sigway.be'){
	$location='http://www.lumiagem.com/cn';
	header("HTTP/1.1 301 Moved Permanently"); 
	header("location:$location");
	exit();
}

header("HTTP/1.1 301 Moved Permanently"); 
header("location:cn");

session_start();
if(isset($_SESSION['lang'])){
	if($_SESSION['lang']=='cn'){
		header('Location: cn/');
	}else if($_SESSION['lang']=='en'){
		header('Location: en/');
	}
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta content="比利时安特卫普钻石交易所唯一华人钻石公司 婚戒定制专家 为您专业定制 独一无二的钻戒 每颗钻石都配有国际钻石证书 欧洲 中国 香港" name="description">
<title>LUMIA JEWELRY</title>
<style type="text/css">
body{
	padding:0;
	margin:0;
	background-color:#333;
	background-image:url(images/bottom3.jpg);
	background-position:top center;
}
#content{
	position:absolute;
	width:100%;
	top:50px;
	text-align:center;
}
#logo{
	width:200px;
}
p.lang_btn{
	margin-top:35px;
	font-family:"Lucida Grande", sans-serif;
}

p.lang_btn a{
	color:#FFF;
	text-decoration:none;
	font-size:14px;
}
p.lang_btn a:hover{
	color:#CCC;
}

#footer{
	bottom: 35px;
    height: 20px;
    padding: 5px 0 !important;
    position: fixed;
    text-align: center;
    width: 100%;
}
div.footer-inner {
	background-color: rgba(248, 245, 235, 0.9);
    font-family: STHeiti,simsun,Arial,sans-serif;
    margin: 0;
    position: relative;
	padding: 5px;
	cursor:default;
}
</style>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-84729490-2', 'auto');
  ga('send', 'pageview');

</script>
<!--百度seo自动推送 -->
<script>
(function(){
    var bp = document.createElement('script');
    var curProtocol = window.location.protocol.split(':')[0];
    if (curProtocol === 'https') {
        bp.src = 'https://zz.bdstatic.com/linksubmit/push.js';        
    }
    else {
        bp.src = 'http://push.zhanzhang.baidu.com/push.js';
    }
    var s = document.getElementsByTagName("script")[0];
    s.parentNode.insertBefore(bp, s);
})();
</script>
</head>

<body>
<!-- site on new location -->
<div style="position:fixed; width:100%; margin:0 auto; background-color:#FF0; color:#000; top:0; left:0;">服务器升级中，请不要进行任何操作，否则您的操作纪录有可能会丢失<br />升级完成后此信息会消失，请耐心等待几个小时</div>


<div id="content">
<img id="logo" src="images/site_elements/logo.gif" />
<p class="lang_btn"><a href="en">English</a> &nbsp;  &nbsp;  &nbsp; <a href="cn">中文</a></p>
</div>


<div id="footer">

<div class="footer-inner"><img style="width:500px; position:absolute; bottom:0; right:0;" src="images/site_elements/homepageele.png" />
Lumia diamond | 利美钻石
<p style="position:absolute; right:50px; top:25px; color:#FFF; font-size:10px; font-family:'Lucida Grande', sans-serif">Website by <a target="_blank" href="http://sigway.be" style="color:#FFF;">Studio Sigway</a></p>
</div>
</div>


</body>
</html>