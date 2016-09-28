<div class="subnavi_box">

<?php
if($crr_page=='guide'){
	include_once('content/sub_navi/guide.php');
}else if($crr_page=='news'){
	include_once('content/sub_navi/news.php');
}else if($crr_page=='about'){
	include_once('content/sub_navi/about.php');
}
?>

</div>


<div class="main_contentbox">
<?php 
if(!isset($_GET['id'])){exit('error: id required');}

$id=$_GET['id'];
$sql='SELECT * FROM usefulinfo WHERE id = "'.$id.'"';
foreach($conn->query($sql) as $row){}
?>
<h3 id="articletitle"><?php echo $row['title_ch']; ?></h3>


<div id="txt_box" style="margin-top:12px;">
<?php echo $row['text_ch']; ?>
</div>


</div>