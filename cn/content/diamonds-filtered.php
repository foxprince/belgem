<div id="filter_box">
<div class="filter_line">
<span class="filter_title">形状</span>
<ul>
<li class="filter_shape" onclick="filter_shape('BR')"><img src="../../images/site_elements/icons/01.gif" />圆形</li>
<li class="filter_shape" onclick="filter_shape('PS')"><img src="../../images/site_elements/icons/02.gif" />公主方</li>
<li class="filter_shape" onclick="filter_shape('PR')"><img src="../../images/site_elements/icons/03.gif" />梨形</li>
<li class="filter_shape" onclick="filter_shape('HS')"><img src="../../images/site_elements/icons/08.gif" />心形</li>
<li class="filter_shape" onclick="filter_shape('MQ')"><img src="../../images/site_elements/icons/05.gif" />橄榄形</li>
<li class="filter_shape" onclick="filter_shape('OV')"><img src="../../images/site_elements/icons/11.gif" />椭圆</li>
<li class="filter_shape" onclick="filter_shape('EM')"><img src="../../images/site_elements/icons/10.gif" />祖母绿</li>
<li class="filter_shape" onclick="filter_shape('RAD')"><img src="../../images/site_elements/icons/06.gif" />蕾蒂恩</li>
<li class="filter_shape" onclick="filter_shape('CU')"><img src="../../images/site_elements/icons/12.gif" />垫形</li>
</ul>
</div>
<div class="filter_line">
<span class="filter_title">颜色</span>
</div>
<div class="filter_line">
<span class="filter_title">净度</span>
</div>
<div class="filter_line">
<span class="filter_title">重量</span>
</div>
<div class="filter_line">
<span class="filter_title">价格</span>
</div>
</div>




<?php
$sql='SELECT * FROM diamonds WHERE shape = "BR" ORDER BY id DESC';

if(isset($_POST['sortby'])){
	$by=$_POST['sortby'];
	$sql='SELECT * FROM diamonds WHERE shape = "BR" ORDER BY stock_ref ASC';
	switch ($by){
		case "ref";
		$sql='SELECT * FROM diamonds WHERE shape = "BR" ORDER BY stock_ref ASC';
		break;
		
		case "shape";
		$sql='SELECT * FROM diamonds WHERE shape = "BR" ORDER BY shape ASC';
		break;
		
		case "weight";
		$sql='SELECT * FROM diamonds WHERE shape = "BR" ORDER BY carat ASC';
		break;
		
		case "color";
		$sql='SELECT * FROM diamonds WHERE shape = "BR" ORDER BY color ASC';
		break;
		
		case "clarity";
		$sql='SELECT * FROM diamonds WHERE shape = "BR" ORDER BY clarity ASC';
		break;
		
		case "certi";
		$sql='SELECT * FROM diamonds WHERE shape = "BR" ORDER BY grading_lab ASC';
		break;
		
		case "cut";
		$sql='SELECT * FROM diamonds WHERE shape = "BR" ORDER BY cut_grade ASC';
		break;
		
		case "polish";
		$sql='SELECT * FROM diamonds WHERE shape = "BR" ORDER BY polish ASC';
		break;
		
		case "symm";
		$sql='SELECT * FROM diamonds WHERE shape = "BR" ORDER BY symmetry ASC';
		break;
		
		case "country";
		$sql='SELECT * FROM diamonds WHERE shape = "BR" ORDER BY country ASC';
		break;	
	}
}

$stmt=$conn->query($sql);

?>



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
	$r++;
?>
<tr class="<?php echo $r; ?>">
<td align="center" class="ref_number"><?php echo $row['stock_ref']; ?></td>
<td align="center"><img height="25" src="../images/site_elements/icons/01.gif" /></td>
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
?>
</table>







<form action="" method="post" id="sort">
<input type="hidden" name="sortby" id="sortby" value="ref" />
</form>


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