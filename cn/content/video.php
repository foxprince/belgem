<?php
if(!isset($_GET['ref'])){
	exit('no ref');
}
include('../../_admin/nuke_magic_quotes.php');
$ref=$_GET['ref'];


require_once('../../includes/connection.php');
$conn=dbConnect('write','pdo');
$conn->query("SET NAMES 'utf8'");


$sql_v='SELECT * FROM video_diamond WHERE ref_number = "'.$ref.'" ORDER BY id DESC LIMIT 1';
foreach($conn->query($sql_v) as $row){}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Lumiagem::video</title>
<link rel="stylesheet" href="//releases.flowplayer.org/5.4.6/skin/minimalist.css" >
<script src="//code.jquery.com/jquery-1.10.2.min.js"></script>
<script src="//releases.flowplayer.org/5.4.6/flowplayer.min.js"></script>
</head>

<body>
<?php
echo $row['thelink_clean'];
?>
</body>
</html>