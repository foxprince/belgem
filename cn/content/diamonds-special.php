<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link href="../styles/main.css?v=1395407389" media="screen" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="../fancyBox/source/jquery.fancybox.css?v=2.1.5" type="text/css" media="screen" />
<style type="text/css">
tr{
	background-color:#FFE0F0;
}
td{
	padding:5px 3px;
	border-bottom-style:dotted;
	border-width:1px;
	border-color:#CC6699;
	
	font-size:12px;
	overflow:hidden;
}
tr:hover{
	background-color:#FFF;
}
td.ref_number{
	font-size:12px;
	border-left-style:solid;
	border-width:1px;
}
td.detail_1stcol{
	border-left-style:solid;
	border-width:1px;
}
td.detail_2ndcol{
	border-right-style:solid;
}
td.seedetail{
	cursor:pointer;
	color:#CC6699;
	font-size:14px;
	border-right-style:solid;
}
tr.details{
	display:none;
	
}

.t_h td{
	background-color:#CC6699;
	color: #FFF;
}
.details td{
	vertical-align:top;
	text-align:left;
	background-color:#FFF;
}


p.details_txt{
	padding-left:20px;
}


div.picbox{
	display:inline-block;
	width:138px;
	height:138px;
	padding:3px;
	border-style:solid;
	border-width:1px;
	border-color:#CC6699;
	margin:0 0 3px 0;
}
div.picbox img{
	position:relative;
	width:138px;
	height:138px;
}
button.sortbtn{
	border:none; 
	background-color:#CC6699; 
	font-size:12px; 
	color:#FFF; 
	cursor:pointer;
}




div.imagescontainer{
	padding:0;
}
div.big_imgbox{
	width:412px;
	height:250px;
	background-color:#FFF3FC;
	border-radius:6px;
	padding:10px;
	text-align:center;
	overflow:hidden;
	margin-left:20px;
	margin-top:20px;
}
img.bigimage{
	width:350px;
}
div.thumbsbox{
	position:relative;
	width:412px;
	padding:10px;
	border-radius:6px;
	margin-top:25px;
	background-color:#FFF3FC;
	text-align:left;
	margin-left:20px;
	margin-bottom:20px;
}
a.thumbbox{
	display:inline-block;
	font-size:0;
	width:88px;
	height:88px;
	overflow:hidden;
	padding:0px;
	border-width:3px;
	border-style:solid;
	border-color:#CC6699;
	margin:3px;
	border-radius:4px;
	text-align:center;
	cursor:pointer;
}
.thumbbox img{
	height:100%;
}


div.videobox{
	padding-top:10px;
}
div.videobox iframe{
	overflow:hidden;
}
</style>


<title>LUMIA JEWELRY</title>
</head>

<body>



<?php
include_once('header.php');



require_once('../includes/connection.php');
$conn=dbConnect('write','pdo');
$conn->query("SET NAMES 'utf8'");

$sql='SELECT * FROM diamonds WHERE shape <> "BR" ORDER BY id DESC';

if(isset($_POST['sortby'])){
	$by=$_POST['sortby'];
	$sql='SELECT * FROM diamonds WHERE shape <> "BR" ORDER BY stock_ref ASC';
	switch ($by){
		case "ref";
		$sql='SELECT * FROM diamonds WHERE shape <> "BR" ORDER BY stock_ref ASC';
		break;
		
		case "shape";
		$sql='SELECT * FROM diamonds WHERE shape <> "BR" ORDER BY shape ASC';
		break;
		
		case "weight";
		$sql='SELECT * FROM diamonds WHERE shape <> "BR" ORDER BY carat ASC';
		break;
		
		case "color";
		$sql='SELECT * FROM diamonds WHERE shape <> "BR" ORDER BY color ASC';
		break;
		
		case "clarity";
		$sql='SELECT * FROM diamonds WHERE shape <> "BR" ORDER BY clarity ASC';
		break;
		
		case "certi";
		$sql='SELECT * FROM diamonds WHERE shape <> "BR" ORDER BY grading_lab ASC';
		break;
		
		case "cut";
		$sql='SELECT * FROM diamonds WHERE shape <> "BR" ORDER BY cut_grade ASC';
		break;
		
		case "polish";
		$sql='SELECT * FROM diamonds WHERE shape <> "BR" ORDER BY polish ASC';
		break;
		
		case "symm";
		$sql='SELECT * FROM diamonds WHERE shape <> "BR" ORDER BY symmetry ASC';
		break;
		
		case "country";
		$sql='SELECT * FROM diamonds WHERE shape <> "BR" ORDER BY country ASC';
		break;	
	}
}

$stmt=$conn->query($sql);

?>

<div id="headervisualbox" style="display:none;">
<img class="header_bg" src="../images/site_elements/header1.jpg" />
</div>

<div id="bodycontent">


<h3 class="blocktitle">利美钻石 : <a class="locationindicator" href="diamonds.php">钻石目录</a> : 异形钻石</h3>



<table cellpadding="2" cellspacing="0" border="0">
<tr class="t_h">
<td style="width:84px;" align="center" class="1st_col"><img width="12" src="../images/site_elements/arrow-down.png" /><button type="button" class="sortbtn" title="点击排序" onclick="sorting('ref')">库存编号</button></td>
<td style="width:119px;" align="center"><img width="12" src="../images/site_elements/arrow-down.png" /><button type="button" class="sortbtn" title="点击排序" onclick="sorting('shape')">形状</button></td>
<td style="width:76px;" align="center"><img width="12" src="../images/site_elements/arrow-down.png" /><button type="button" class="sortbtn" title="点击排序" onclick="sorting('weight')">重量</button></td>
<td style="width:80px;" align="center"><img width="12" src="../images/site_elements/arrow-down.png" /><button type="button" class="sortbtn" title="点击排序" onclick="sorting('color')">色级</button></td>
<td style="width:80px;" align="center"><img width="12" src="../images/site_elements/arrow-down.png" /><button type="button" class="sortbtn" title="点击排序" onclick="sorting('clarity')">净度</button></td>
<td style="width:76px;" align="center"><img width="12" src="../images/site_elements/arrow-down.png" /><button type="button" class="sortbtn" title="点击排序" onclick="sorting('certi')">证书</button></td>
<td style="width:80px;" align="center"><img width="12" src="../images/site_elements/arrow-down.png" /><button type="button" class="sortbtn" title="点击排序" onclick="sorting('cut')">切工</button></td>
<td style="width:80px;" align="center"><img width="12" src="../images/site_elements/arrow-down.png" /><button type="button" class="sortbtn" title="点击排序" onclick="sorting('polish')">抛光</button></td>
<td style="width:80px;" align="center"><img width="12" src="../images/site_elements/arrow-down.png" /><button type="button" class="sortbtn" title="点击排序" onclick="sorting('symm')">对称性</button></td>
<td style="width:80px;" align="center"><img width="12" src="../images/site_elements/arrow-down.png" /><button type="button" class="sortbtn" title="点击排序" onclick="sorting('country')">所在国家</button></td>
<td style="width:80px;" align="center">&nbsp;</td>
</tr>
<?php
$r=0;
foreach($stmt as $row){
	
	$color=$row['color'];
	
	$color_str_length=strlen($color);
	$first_letter=substr($color, 0, 1);
	
	if($color_str_length>1 && $first_letter=='F'){
	}else{
	$r++;
?>
<tr class="<?php echo $r; ?>">
<td align="center" class="ref_number"><?php echo $row['stock_ref']; ?></td>
<td align="center">



<?php 
switch ($row['shape']){
	case "BR":
	$pic_where="01.gif";
	break;
	
	case "CU":
	$pic_where="12.gif";
	break;
	
	case "EM":
	$pic_where="10.gif";
	break;
	
	case "HS":
	$pic_where="08.gif";
	break;
	
	case "MQ":
	$pic_where="05.gif";
	break;
	
	
	case "OV":
	$pic_where="11.gif";
	break;
	
	
	case "PR":
	$pic_where="03.gif";
	break;
	
	case "PS":
	$pic_where="02.gif";
	break;
	
	case "RAD":
	$pic_where="06.gif";
	break;
	
	case "TRI":
	$pic_where="04.gif";
	break;
	
	default:
	$pic_where="01.gif";
}
?>
<img height="25" src="../images/site_elements/icons/<?php echo $pic_where; ?>" />



</td>
<td align="center"><?php echo $row['carat']; ?></td>
<td align="center"><?php echo $row['color']; ?></td>
<td align="center"><?php echo $row['clarity']; ?></td>
<td align="center"><?php echo $row['grading_lab']; ?></td>
<td align="center"><?php echo $row['cut_grade']; ?></td>
<td align="center"><?php echo $row['polish']; ?></td>
<td align="center"><?php echo $row['symmetry']; ?></td>
<td align="center"><?php echo $row['country']; ?></td>
<td class="seedetail" align="center" title="open">查看详情</td>
</tr>

<tr id="d_<?php echo $r; ?>" class="details">
<td colspan="5" class="detail_1stcol">
<p class="details_txt">
证书编号: 
<?php 
echo $row["certificate_number"];
?>
&nbsp; &nbsp; &nbsp; 
荧光强度:
<?php 
echo $row["fluorescence_intensity"];
?>

<?php
if($row["certificatelink"]!=NULL || $row["certificatelink"]!=''){
?>
&nbsp; &nbsp; &nbsp; 
<a class="certi_linker" target="_blank" href="<?php echo $row['certificatelink']; ?>">查看证书</a>
<?php
}
?>
</p>






<div class="imagescontainer">




<?php		
		$thumbs_dir='../images/contentimgs/'.$row['stock_ref'].'/thumbs/';
		
		$picsinfolder=array();	
		/* step one:  read directory, make array of files */
		if ($handle = opendir($thumbs_dir)) {
			while (false !== ($file = readdir($handle))) {
				if ($file != '.' && $file != '..' && $file != '.DS_Store') 
				{					
			        $picsinfolder[] = $file;					
				}
			}
			closedir($handle);
		}
		
		/* step two: loop through, format gallery */
		if(count($picsinfolder)){
			$c=0;		
			foreach($picsinfolder as $file){
				if($c==0){
					$pic1=$file;
					?>
                   
                    
            <div class="thumbsbox">
                    <?php
				
				}
				?>						
                
                <a class="thumbbox" rel="thumbbox<?php echo $row['stock_ref']; ?>" id="pic_<?php echo $row['stock_ref'].$c; ?>" href="../images/contentimgs/<?php echo $row['stock_ref']; ?>/<?php echo urldecode($file); ?>">
                <img src="<?php echo urldecode($thumbs_dir.$file); ?>" />
                </a>

                
                <?php
				$c++;
			}
		}
?>
			</div>
</div>




</td>
<td colspan="6" class="detail_2ndcol">
<p class="details_txt">&nbsp;</p>
<?php
$sql_v='SELECT * FROM video_diamond WHERE ref_number = "'.$row["stock_ref"].'"';
foreach($conn->query($sql_v) as $v){
?>
<div class="videobox" title="<?php echo $v['thelink']; ?>">

</div>
<?php
} 
?>

</td>
</tr>
<?php
	}
}
?>
</table>







</div>

<form action="" method="post" id="sort">
<input type="hidden" name="sortby" id="sortby" value="ref" />
</form>

<?php
include_once('footer.php');
?>

<script type="text/javascript" src="../fancyBox/source/jquery.fancybox.pack.js?v=2.1.5"></script>
<script type="text/javascript">
$(document).ready(function(){
	$('td.seedetail').click(function(){
		var crr_obj=$(this);
		var theid='#d_'+crr_obj.parent('tr').attr('class');
		if(crr_obj.attr('title')=='open'){
			$(theid).find('div.thumbbox').eq(0).click();		
		    $(theid).slideDown("slow", function(){
				crr_obj.attr('title','close');
				var thelink=$(theid).find('div.videobox').attr('title');
				$(theid).find('div.videobox').html('<iframe height=338 width=482 src="" frameborder=0 allowfullscreen></iframe>');
				$(theid).find('div.videobox iframe').attr('src',thelink);
				$(theid).find('div.thumbbox').eq(0).click();
			});
		}else{
			$(theid).slideUp("fast", function(){
				crr_obj.attr('title','open');
			});
		}
	});
	
	$("a.thumbbox").fancybox({
		beforeLoad: function(){
						$('iframe').css('visibility',"hidden");
					},
		afterClose: function(){
						$('iframe').css('visibility',"visible");
					}
	});
});

function sorting($by){
	$('input#sortby').val($by);
	$('form#sort').submit();
}


function thumbclicked($theid, $picname, $bigimgid){
	var thethumb=$('div#pic_'+$theid+' img');
	var w=thethumb.width();
	var h=thethumb.height();
	//
	var r=w/h;
	//alert(r);
	var bigpic=$('#'+$bigimgid+' img.bigimage');
	bigpic.attr('src',$picname);
	if(r>(412/250)){
		var w_b=412;
		var h_b=412/r;
		var t_b=Math.round((250-h_b)/2);
	}else{
		var h_b=250;
		var w_b=250*r;
		var t_b=0;
	}
	bigpic.css({'width':w_b, "height":h_b, 'top':t_b});
}
</script>


</body>
</html>