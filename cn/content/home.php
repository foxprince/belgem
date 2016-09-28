<?php
$sql_home='SELECT * FROM homepage';
foreach($conn->query($sql_home) as $row){}
?>


<div class="home_block" id="home_block0">
</div>


<div class="home_block" id="home_block1">


<a class="ele_linker1" href="<?php echo $row['p1_link1']; ?>">
<span class="imgbox">
<img src="../images/sitepictures/<?php echo $row['p1_img1']; ?>" />
</span>
<p class="ele_words"><?php echo $row['p1_txt1']; ?></p>
</a>


<a class="ele_linker2" href="<?php echo $row['p1_link2']; ?>">
<span class="imgbox">
<img src="../images/sitepictures/<?php echo $row['p1_img2']; ?>" />
</span>
<p class="ele_words"><?php echo $row['p1_txt2']; ?></p>
</a>

<a class="ele_linker3" href="<?php echo $row['p1_link3']; ?>">
<span class="imgbox">
<img src="../images/sitepictures/<?php echo $row['p1_img3']; ?>" />
</span>
<p class="ele_words"><?php echo $row['p1_txt3']; ?></p>
</a>

</div>



<div class="home_block" id="home_block2">

<a class="ele_linker1" href="<?php echo $row['p2_link1']; ?>">
<span class="imgbox">
<img src="../images/sitepictures/<?php echo $row['p2_img1']; ?>" />
</span>
<p class="ele_words"><?php echo $row['p2_txt1']; ?></p>
</a>


<a class="ele_linker2" href="<?php echo $row['p2_link2']; ?>">
<span class="imgbox">
<img src="../images/sitepictures/<?php echo $row['p2_img2']; ?>" />
</span>
<p class="ele_words"><?php echo $row['p2_txt2']; ?></p>
</a>

<a class="ele_linker3" href="<?php echo $row['p2_link3']; ?>">
<span class="imgbox">
<img src="../images/sitepictures/<?php echo $row['p2_img3']; ?>" />
</span>
<p class="ele_words"><?php echo $row['p2_txt3']; ?></p>
</a>

</div>



<div class="home_block" id="home_block3">

<a class="ele_linker1" href="<?php echo $row['p3_link1']; ?>">
<span class="imgbox">
<img src="../images/sitepictures/<?php echo $row['p3_img1']; ?>" />
</span>
<p class="ele_words"><?php echo $row['p3_txt1']; ?></p>
</a>


<a class="ele_linker2" href="<?php echo $row['p3_link2']; ?>">
<span class="imgbox">
<img src="../images/sitepictures/<?php echo $row['p3_img2']; ?>" />
</span>
<p class="ele_words"><?php echo $row['p3_txt2']; ?></p>
</a>

<a class="ele_linker3" href="<?php echo $row['p3_link3']; ?>">
<span class="imgbox">
<img src="../images/sitepictures/<?php echo $row['p3_img3']; ?>" />
</span>
<p class="ele_words"><?php echo $row['p3_txt3']; ?></p>
</a>
</div>

<!--
<div class="home_block" id="home_block4">

<a class="ele_linker1" href="<?php echo $row['p4_link1']; ?>">
<span class="imgbox">
<img src="../images/sitepictures/<?php echo $row['p4_img1']; ?>" />
</span>
<p class="ele_words"><?php echo $row['p4_txt1']; ?></p>
</a>


<a class="ele_linker2" href="<?php echo $row['p4_link2']; ?>">
<span class="imgbox">
<img src="../images/sitepictures/<?php echo $row['p4_img2']; ?>" />
</span>
<p class="ele_words"><?php echo $row['p4_txt2']; ?></p>
</a>

<a class="ele_linker3" href="<?php echo $row['p4_link3']; ?>">
<span class="imgbox">
<img src="../images/sitepictures/<?php echo $row['p4_img3']; ?>" />
</span>
<p class="ele_words"><?php echo $row['p4_txt3']; ?></p>
</a>

</div>
-->

<br style="clear:both;" />


<p id="slidernavi"><a onclick="prev()" href="#pre">&lt;</a> &nbsp; &nbsp; &nbsp; 点击查看详细信息 &nbsp; &nbsp; &nbsp; <a onclick="next()" href="#nex">&gt;</a></p>


<script type="text/javascript">
var crr_block=0;
var abcttt=0;
$(document).ready(function(){
	$('div.home_block').css('width',($('#bodycontent').width()+280));	
	
	changinghomeBlock();
	
	//abcttt=setInterval("changinghomeBlock()", 6800);
});

var tttt=0;

function changinghomeBlock(){
	
	if(crr_block<3){
		crr_block++;
	}else{
		crr_block=1;
	}
	
	
	if(crr_block<=2){
		var nextblock=crr_block+1;
	}else{
		var nextblock=1;
	}
	
	
	if(crr_block>=2){
		var pre_block=crr_block-1;
	}else{
		var pre_block=3;
	}
	
	tttt++;
	
	$('div#home_block'+nextblock).css({'left':($(window).width()-120),'display':'block','opacity':0});
	$('div#home_block'+nextblock).animate({'left':-120, 'opacity':1},1080);
	
	$('div#home_block'+crr_block).animate({'left':-($('div#home_block'+crr_block).width()),'opacity':0},1080, function(){
		$('div#home_block'+crr_block).css({'display':'none','opacity':1});
	});
	
	
	$('div#home_block'+pre_block).animate({'left':-($('div#home_block'+crr_block).width()),'opacity':0},1080, function(){
		$('div#home_block'+pre_block).css({'display':'none','opacity':1});
	});
	
	$('#monitor').html(crr_block+' ****** '+nextblock);
	
	clearTimeout(abcttt);
	abcttt=setTimeout("changinghomeBlock()", 6800);
	
}

function prev(){
	
	if(crr_block<=2){
		var nextblock=crr_block+1;
	}else{
		var nextblock=1;
	}
	
	
	if(crr_block>=2){
		var pre_block=crr_block-1;
	}else{
		var pre_block=3;
	}

	
	$('div#home_block'+pre_block).css({'left':-($(window).width()+120),'display':'block','opacity':0});
	$('div#home_block'+pre_block).stop(true).animate({'left':-120, 'opacity':1},1080);
	
	
	$('div#home_block'+crr_block).stop(true).animate({'left':($('div#home_block'+crr_block).width()),'opacity':0},1080, function(){
		$('div#home_block'+crr_block).css({'display':'none','opacity':1});
		if(crr_block>1){
			crr_block--;
		}else{
			crr_block=3;
		}
		
		$('#monitor').html(crr_block);
	});
	
	$('div#home_block'+nextblock).stop(true).animate({'left':($('div#home_block'+crr_block).width()),'opacity':0},1080, function(){
		$('div#home_block'+nextblock).css({'display':'none','opacity':1});
	});

	
	clearTimeout(abcttt);
	abcttt=setTimeout("changinghomeBlock()", 6800);
}


function next(){
	changinghomeBlock();
}


</script>





<div id="monitor" style="position:fixed; top:8px; left:8px; width:300px; background-color:#FFC; display:none;">abc</div>
<!-- -->