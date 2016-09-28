<ul>
<li class="submenu-cate"><a href="jewelry.php">全部</a></li>
<?php
$sql_jewelry_cate='SELECT * FROM jewelry_category';
foreach($conn->query($sql_jewelry_cate) as $row){
	$crr_cate_en=$row['category_en'];
	$crr_cate_cn=$row['category_cn'];
?>
<li class="submenu-cate">
<?php echo $crr_cate_cn; ?>

<ul class="brands-submenu">
<li><a href="jewelry.php?p=all&ref=<?php echo $crr_cate_en; ?>">全部</a></li>
<?php
$sql_jewelry_brand='SELECT * FROM jewelry_brands';
foreach($conn->query($sql_jewelry_brand) as $row_b){
?>
<li class="submenu-br">
<a href="jewelry.php?p=all&ref=<?php echo $crr_cate_en; ?>&brand=<?php echo $row_b['brand_en']; ?>"><?php echo $row_b['brand_cn']; ?></a>
</li>
<?php
}
?>
</ul>
</li>
<?php
}
?>

</ul>

<script type="text/javascript">
$(document).ready(function(){
	$('.submenu-cate').click(function(){
		$('.brands-submenu').css('display','none');
		$(this).children('ul').stop(true).slideDown('fast');
	});
});
</script>