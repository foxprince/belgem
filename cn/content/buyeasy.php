<div class="subnavi_box">

<?php
if($crr_page=='about'){
	include_once('content/sub_navi/about.php');
}else if($crr_page=='guide'){
	include_once('content/sub_navi/guide.php');
}else if($crr_page=='diamonds'){
	include_once('content/sub_navi/diamonds.php');
}else if($crr_page=='jewelry'){
	include_once('content/sub_navi/jewelry.php');
}else if($crr_page=='contact'){
	include_once('content/sub_navi/contact.php');
}
?>

</div>


<div class="main_contentbox">
<img style="float:right; width:128px; margin: 20px 0 12px 22px;" src="http://www.lumiagem.com/images/sitepictures/limei20140512_050456.jpg" />
<p>有心仪的钻石克拉数和明确的预算？对钻石不太了解却又想带性价比最高的钻石回家？</p>
<p>赶快用电话、邮件或者微信联系我们的钻石专家。我们会根据您的个人情况和预算</p>
<p>帮您做出最贴心的选择建议!</p>
<p><strong style="color:#900;">清晰的解释，贴心的建议和优惠的价格是利美对您的承诺。</strong></p>



<div class="contacticonsbox" style="position:relative; padding-left:0; margin-left:0; left:0;">
<a class="contacticon" href="contact.php">
<img src="../images/phone.gif" />
</a> 
<a class="contacticon" href="mailto:info@lumiagem.com">
<img src="../images/mail.gif" />
</a> 

<!--
<a class="contacticon" href="">
<img src="../images/skype.gif" />
</a> 
-->
</div>



</div>




<script type="text/javascript">
$('document').ready(function(){
	$('a#buyeasybtn').css({'border-bottom-style':'solid',
	'border-width':'2px'});
});
</script>