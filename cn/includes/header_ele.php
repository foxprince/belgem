<?php
if(isset($crr_page) && $crr_page=='jewelry'){
	require_once('../includes/connection-retail.php');
	$conn=dbConnect('write','pdo');
	$conn->query("SET NAMES 'utf8'");
}else{
	require_once('../includes/connection.php');
	$conn=dbConnect('write','pdo');
	$conn->query("SET NAMES 'utf8'");
}

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta content="BELGEM" name="description">
<link href="../styles/main.css?v=<?php echo strtotime('now'); ?>" media="screen" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="http://edecenter.com/lab/jquery-ui.css" />
<script src="http://edecenter.com/lab/jquery-1.11.2.min.js"></script>
<script src="http://edecenter.com/lab/jquery-ui.min.js"></script>
<script type="text/javascript" src="../jscontrol.js?v=<?php echo strtotime('now'); ?>"></script>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-84729490-2', 'auto');
  ga('send', 'pageview');

</script>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-84729490-2', 'auto');
  ga('send', 'pageview');

</script>
<link rel="shortcut icon" href="../images/site_elements/icon.ico" />
