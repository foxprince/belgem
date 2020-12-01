<?php

session_start();

require_once ('../cn/includes/header_ele.php');
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Untitled Document</title>
</head>

<body>
<?php
include('navi.php');
?>
<hr />

<h1>图片上传页面</h1>



<form enctype="multipart/form-data" action="imageuploading.php" method="post">
<input name="image" type="file" />
<input type="submit" name="imageUploading" value="上传图片" />
</form>


</body>
</html>