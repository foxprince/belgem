<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>管理界面</title>
<link rel="stylesheet" href="../adminstyle.css"/>
</head>
<body>
<?php
include('../navi.php');
?>
<hr />
<div id="maincontent" style="padding-bottom:50px;">
<?php
//$url = "http://www.lumiagem.com/cn/invoice/list.html";
//$contents = file_get_contents($url); 
//echo $contents;
?>
include('list.html');
</div>
</body>
</html>