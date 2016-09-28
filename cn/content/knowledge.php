<div class="subnavi_box">

<?php
if($crr_page=='guide'){
	include_once('content/sub_navi/guide.php');
}
?>

</div>


<div class="main_contentbox">
<?php 
$sql_count='SELECT COUNT(*) AS num_articles FROM usefulinfo WHERE category = "knowledge"';
foreach($conn->query($sql_count) as $number){
	$articleCount=$number['num_articles'];
}

$totalpages=ceil($articleCount/25);

if(isset($_GET['n'])){
	$crr_page=$_GET['n'];
	if($crr_page>$totalpages){
		$crr_page=$totalpages;
	}
}else{
	$crr_page=1;
}

$startnumber=($crr_page-1)*25;

$sql='SELECT * FROM usefulinfo WHERE category = "knowledge" ORDER BY id DESC LIMIT '.$startnumber.', 25';
$stmt=$conn->query($sql);
?>


<ul class="news-box">
<?php
foreach($stmt as $row){
?>
<li class="newspiece">
<a class="imglinker" href="guide.php?p=article&ref=knowledge&id=<?php echo $row['id']; ?>">
<img class="article_img" src="<?php echo $row['main_image_ch']; ?>" />
</a>
<a class="txtlinker" href="guide.php?p=article&ref=knowledge&id=<?php echo $row['id']; ?>">
<?php echo $row['title_ch']; ?>
</a>
</li>
<?php
}
?>

<li class="pagesbtn">
<?php
if(isset($totalpages) && $totalpages>1){
	
	for($i=1; $i<=$totalpages; $i++){
	?>
	<a class="articlepagelinker" href="guide.php?p=knowledge&n=<?php echo $i; ?>">
	<?php 
	if($crr_page==$i){
		echo '<span style="font-weight:bold; font-size:16px;">'.$i.'</span>'; 
	}else{
		echo $i;
	}
	?>
    </a>
	<?php
	}
}
?>
</li>

</ul>
</div>
<script type="text/javascript">
$('document').ready(function(){
	$('a#knowledgebtn').css({'border-bottom-style':'solid',
	'border-width':'2px'});
});
</script>