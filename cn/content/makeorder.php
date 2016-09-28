<div class="subnavi_box">

<?php
if($crr_page=='guide'){
	include_once('content/sub_navi/guide.php');
}
?>

</div>


<div class="main_contentbox">
<?php 

?>


<div id="makeorderbox">

<ul>

<li class="box" style="background-color:#F93;">
<a href="diamonds.php">
<img style="border:none; width:133px; border-radius:8px;" alt="选择裸钻" src="../images/site_elements/shopping_guide1.png" />
</a>
<ul>
<li><a href="diamonds.php">按4C选择心仪的钻石</a></li>
<li><a href="diamonds.php">记录钻石代号</a></li>
</ul>
</li>

<li class="box" style="background-color:#C60;">
<a href="jewelry.php"><img style="border:none; width:133px; border-radius:8px;" alt="定制嵌饰" src="../images/site_elements/shopping_guide2.png" /></a>
<ul>
<li><a href="diamonds.php">选择裸钻</a></li>
<li><a href="jewelry.php">选择款式</a></li>
<li>选择金属材质<br /><span style="font-size:12px;">(18K铂金、玫瑰金)</span></li>
<li>选择刻字</li>
</ul>
</li>


<li class="box">
<a href="contact.php"><img style="border:none; width:133px; border-radius:8px;" alt="联系客服" src="../images/site_elements/shopping_guide3.png" /></a>
<ul>
<li><a href="contact.php">咨询利美客服</a></li>
<li><a href="contact.php">确认下单</a></li>
</ul>
</li>



</ul>
<br style="clear:both;" />
</div>

</div>

<script type="text/javascript">
$('document').ready(function(){
	$('a#makeorderbtn').css({'border-bottom-style':'solid',
	'border-width':'2px'});
});
</script>