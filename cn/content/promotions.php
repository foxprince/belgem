<div class="subnavi_box">

<?php
if($crr_page=='news'){
	include_once('content/sub_navi/news.php');
}
?>

</div>


<div class="main_contentbox">



<?php 
$querywhere='WHERE (category = "promotion-diamond" OR category = "promotion-jewelry")';
if(isset($_GET['ref'])){
	if($_GET['ref']=='diamonds'){
		$querywhere='WHERE category = "promotion-diamond"';
?>
<script type="text/javascript">
$('document').ready(function(){
	$('a#promotiondiamondbtn').css({'border-bottom-style':'solid',
	'border-width':'2px'});
});
</script>
<?php
	}else if($_GET['ref']=='jewelry'){
		$querywhere='WHERE category = "promotion-jewelry"';
?>
<script type="text/javascript">
$('document').ready(function(){
	$('a#promotionjewelrybtn').css({'border-bottom-style':'solid',
	'border-width':'2px'});
});
</script>
<?php
	}
}


$sql='SELECT * FROM usefulinfo '.$querywhere.' ORDER BY id DESC';
$stmt=$conn->query($sql);
?>


<ul>


<?php
foreach($stmt as $row){
?>
<li class="newspiece">
<a class="imglinker" href="news.php?p=article&id=<?php echo $row['id']; ?>">
<img src="<?php echo $row['main_image_ch']; ?>" />
</a>
<a class="txtlinker" href="news.php?p=article&id=<?php echo $row['id']; ?>">
<?php echo $row['title_ch']; ?>
</a>
</li>
<?php
}
?>




</ul>
</div>