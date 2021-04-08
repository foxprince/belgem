<div class="subnavi_box">

<?php
if($crr_page=='jewelry'){
	include_once('content/sub_navi/jewelry.php');
}
?>

</div>



<div class="main_contentbox">
<script type="text/javascript" src="../fancyBox/source/jquery.fancybox.pack.js?v=2.1.5"></script>




<?php
$querywhere=' ';
$querybrand='';

if(isset($_GET['ref'])){	
	$querywhere=' AND category = "'.$_GET['ref'].'" ';	
}
if(isset($_GET['brand'])){
	$querybrand=' AND brand = "'.$_GET['brand'].'" ';	
}


$sql='SELECT * FROM jewelry WHERE online_agency = "YES" '.$querywhere.$querybrand.' ORDER BY id';
foreach($conn->query($sql) as $row){
?>
<div class="r_box">
<a class="j_linker" href="jewelry.php?p=detail&id=<?php echo $row['id']; ?>">
<!--
<img class="thumb" src="http://www.lumiagem.com/images/sitepictures/thumbs/<?php echo $row['image1']; ?>" />
-->
<span class="jewelrypic" style="background-image:url(http://www.lumiagem.com/images/sitepictures/thumbs/<?php echo $row['image1']; ?>);"></span>
</a>
<a class="j_linker_txt" href="jewelry.php?p=detail&id=<?php echo $row['id']; ?>">
<span class="jewlery_name">
<?php echo $row['name_ch']; ?>
</span>
</a>
</div>
<?php
}
?>


</div>
