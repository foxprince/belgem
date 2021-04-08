<div class="subnavi_box">

<?php
if($crr_page=='jewelry'){
	include_once('content/sub_navi/jewelry.php');
}
?>

</div>




<div class="main_contentbox">
<?php
if(!isset($_GET['id'])){exit('error: id required');}

$id=$_GET['id'];


$sql='SELECT * FROM jewelry WHERE id = "'.$id.'"';
foreach($conn->query($sql) as $row){}
?>

<?php


if($row['category']=='ring'){
	$cate='Ring';
	$cate_linker='ring.php';
}else if($row['category']=='necklace'){
	$cate='Necklace';
	$cate_linker='necklace.php';
}else if($row['category']=='earring'){
	$cate='Earring';
	$cate_linker='earring.php';
}else if($row['category']=='bracelet'){
	$cate='Bracelet';
	$cate_linker='bracelet.php';
}
?>




<h3 class="blocktitle"><?php echo $row['name_en']; ?></h3>





<div id="txt_box" style="margin-top:12px;">
<?php echo $row['text_en']; ?>
</div>


<div id="img_show_box">


<div id="thumbsbox">


<a class="thumb" href="http://www.lumiagem.com/images/sitepictures/<?php echo $row['image1']; ?>" rel="pics">
<span class="thumbpicbox" style="background-image:url(http://www.lumiagem.com/images/sitepictures/thumbs/<?php echo $row['image1']; ?>);">
</span>
</a>

<?php
if($row['image2']!=NULL && $row['image2']!=''){
?>

<a class="thumb" href="http://www.lumiagem.com/images/sitepictures/<?php echo $row['image2']; ?>" rel="pics">
<span class="thumbpicbox" style="background-image:url(http://www.lumiagem.com/images/sitepictures/thumbs/<?php echo $row['image2']; ?>);">
</span>
</a>

<?php
}
?>
<?php
if($row['image3']!=NULL && $row['image3']!=''){
?>

<a class="thumb" href="http://www.lumiagem.com/images/sitepictures/<?php echo $row['image3']; ?>" rel="pics">
<span class="thumbpicbox" style="background-image:url(http://www.lumiagem.com/images/sitepictures/thumbs/<?php echo $row['image3']; ?>);">
</span>
</a>

<?php
}
?>
<?php
if($row['image4']!=NULL && $row['image4']!=''){
?>

<a class="thumb" href="http://www.lumiagem.com/images/sitepictures/<?php echo $row['image4']; ?>" rel="pics">
<span class="thumbpicbox" style="background-image:url(http://www.lumiagem.com/images/sitepictures/thumbs/<?php echo $row['image4']; ?>);">
</span>
</a>

<?php
}
?>
<?php
if($row['image5']!=NULL && $row['image5']!=''){
?>

<a class="thumb" href="http://www.lumiagem.com/images/sitepictures/<?php echo $row['image5']; ?>" rel="pics">
<span class="thumbpicbox" style="background-image:url(http://www.lumiagem.com/images/sitepictures/thumbs/<?php echo $row['image5']; ?>);">
</span>
</a>

<?php
}
?>
<?php
if($row['image6']!=NULL && $row['image6']!=''){
?>

<a class="thumb" href="http://www.lumiagem.com/images/sitepictures/<?php echo $row['image6']; ?>" rel="pics">
<span class="thumbpicbox" style="background-image:url(http://www.lumiagem.com/images/sitepictures/thumbs/<?php echo $row['image6']; ?>);">
</span>
</a>

<?php
}
?>
<?php
if($row['image7']!=NULL && $row['image7']!=''){
?>

<a class="thumb" href="http://www.lumiagem.com/images/sitepictures/<?php echo $row['image7']; ?>" rel="pics">
<span class="thumbpicbox" style="background-image:url(http://www.lumiagem.com/images/sitepictures/thumbs/<?php echo $row['image7']; ?>);">
</span>
</a>

<?php
}
?>
<?php
if($row['image8']!=NULL && $row['image8']!=''){
?>

<a class="thumb" href="http://www.lumiagem.com/images/sitepictures/<?php echo $row['image8']; ?>" rel="pics">
<span class="thumbpicbox" style="background-image:url(http://www.lumiagem.com/images/sitepictures/thumbs/<?php echo $row['image8']; ?>);">
</span>
</a>

<?php
}
?>




</div>

<div id="txtvideobox">
<?php
if($row['videolink']!=NULL && $row['videolink']!=''){

//echo $row['videolink']; 

}
?>
</div>


<br style="clear:both;" />
</div>








<script type="text/javascript" src="../fancyBox/source/jquery.fancybox.pack.js?v=2.1.5"></script>
<script type="text/javascript">
$("a.thumb").fancybox({
	beforeLoad: function(){
					$('iframe').css('visibility',"hidden");
				},
	afterClose: function(){
					$('iframe').css('visibility',"visible");
				}
});
</script>

</div>