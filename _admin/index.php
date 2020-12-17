<?php
/*===================session========================*/
session_start();
require_once('../log.php');
if(isset($_POST['logout'])){
	 session_unset();
	 header('Location: login.php');
     exit;
}
// if session variable not set, redirect to login page
if(!isset($_SESSION['username'])) {
  header('Location: login.php');
  exit;
}
$username=$_SESSION['username'];
$account_level=$_SESSION['account_level'];
require_once('../log.php');
require_once('../includes/connection.php');
$conn=dbConnect('write','pdo');
$conn->query("SET NAMES 'utf8'");
if(isset($_POST['filter_company']) && $_POST['filter_company']!='all'){
	$crr_company=$_POST['filter_company'];
	$thefromcompany=$_POST['filter_company'];
	$companyfiltercondition=' AND diamonds.from_company = "'.$thefromcompany.'" ';
}else{
	$companyfiltercondition='';
	$crr_company="all";
}
if(isset($_REQUEST['filter_orderDate']) && $_REQUEST['filter_orderDate']!='all'){
	$crr_orderDate=$_REQUEST['filter_orderDate'];
	if($_REQUEST['filter_orderDate']!='null')
		$orderDateCondition=' AND diamonds.ordered_time in ('.$crr_orderDate.')';
	if(isset($_REQUEST['customer']) && $_REQUEST['customer']!='all'&& $_REQUEST['customer']!='null')
		$orderDateCondition .= ' and diamonds.customer in('.$_REQUEST['customer'].')';
	if(isset($_REQUEST['appointment_time']) && $_REQUEST['appointment_time']!='all'&& $_REQUEST['appointment_time']!='null')
		$orderDateCondition .= ' and diamonds.appointment_time in('.$_REQUEST['appointment_time'].')';
}else{
	$orderDateCondition='';
	$crr_orderDate="all";
}
if(isset($_POST['filter_user']) && $_POST['filter_user']!='all'){
	$crr_searching_user=$_POST['filter_user'];
	//$thefromcompany=$_POST['filter_user'];
	$userfiltercondition=' AND users.user_name = "'.$crr_searching_user.'" ';
}else{
	$userfiltercondition='';
	$crr_searching_user="all";
}
if(isset($_POST['filter_price'])){
	$crr_searching_price=$_POST['filter_price'];
}else{
	$crr_searching_price="retail_price";
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>管理界面</title>
<link rel="stylesheet" href="./adminstyle.css">
<link rel="stylesheet" href="../styles/jquery-ui.css">
<!-- <link rel="stylesheet" href="../styles/multi-select.css"> -->
<link rel="stylesheet" href="../styles/jquery.multiselect.css">

<link rel="stylesheet" href="../styles/jquery.dataTables.min.css">

<style>
body{
	font-family:'Microsoft Yahei', 微软雅黑, STHeiti, simsun, Arial, sans-serif;
	font-size:14px;
	font-weight:100;
	}
h1{
	position:relative;
	left:40px;
	font-family:Verdana, Geneva, sans-serif;
	font-weight:bold;
	font-size:20px;
	color:#000;
	margin-top:0px;
}
td{
	vertical-align:top;
	padding:5px;
	border-bottom-style:solid;
	border-left-style:solid;
	border-width:1px;
	border-color:#CCC;
	font-size:12px;
}
span.inditxt{
	color:#DDD;
	font-size:10px;
}
tr.finido{
	background-color:#9FC;
}
.finido td.numberrow{
	background-image:URL(../images/tick.png);
	background-position:center center;
	background-repeat:no-repeat;
	background-size:38px;
}
p.Stock_Num{
	padding:0;
	margin: 0;
}
.cell_stock_ref, .cell_dia_id{
	font-size:10px;
}
td.lastcell{
	border-right-style:solid;
	border-width:1px;
	position:static;
}
td.crrOperationLine{
	background-color:#CFF !important;
}
.d td{
	background-color:#EFEFEF;
}
#tablehead td{
	border-top-style:solid;
	background-color:#BBB;
}
button.operationbutton{
	background-color:#6CF;
	border-width:1px;
	padding:2px 3px;
	font-size:12px;
	margin-left:15px;
	display:inline-block;
	border-style:solid;
}
div.operationbox{
	display:none;
	position:absolute;
	background-color:#CFF;
	width:420px;
	padding:15px;
	right: 0;
	box-shadow: 0 0 5px #666;
	border-radius:6px;
}
span.operationXbtn{
	border-style:solid;
	border-width:1px;
	border-color:#333;
	display:inline-block;
	padding:0 4px;
	float:right;
	background-color:#FFF;
}
button#normalmodebtn{
	background-color:#F90;
	padding:5px 12px;
	font-size:18px;
	border-style:solid;
	border-width:1px;
	display:none;
}
</style>
<script src="../js/jquery-1.11.2.min.js"></script>
<script src="../js/jquery-ui.min.js"></script>

<script src="../js/jquery.dataTables.min.js"></script>
<!-- <script src="../js/jquery.multi-select.js"></script> -->
<script src="../js/jquery.multiselect.js"></script>


<script type="text/javascript">
$(document).ready(function(){
	$("#submit_article").click(function(){
			$("form#uploadArticle").submit();
	});
	$('#filter_company').change(function(){
		$('form#companyfilterform').submit();
	});
	$('#filter_orderDate').change(function(){
		$('form#orderDateForm').submit();
	});
	$('#filter_user').change(function(){
		$('form#userfilterform').submit();
	});
	$('#filter_price').change(function(){
		$('form#pricefilterform').submit();
	});
	$("#checkAll").click(function() {
		if(this.checked){ 
    			$("input[name='subBox']").each(function(){this.checked=true;}); 
    		}else{ 
    			$("input[name='subBox']").each(function(){this.checked=false;}); 
    		} 
	});
	
	getDiaCompany();
	getDiaStock();
	$('#orderTable').DataTable();
});
function filterOrderDate() {
	window.location.href="index.php?filter_orderDate="+$('#orderDateSelect').val()+"&customer="+$('#customerSelect').val()+"&appointment_time="+$('#appointmentSelect').val();
}
function choosethispage(index) {
	window.location.href="index.php?crr_page="+index;
}
function formcomplete(){
	if($.trim($('#title').val())==''){
		alert('没有标题！');
		return false;
	}
	return true;
}
function paidrecord(the_number){
	var refnumber=the_number;
	var theamount=$('input#paid_'+refnumber).val();
	if(theamount==0){
		alert('金额为0,不能保存');
		return false;
	}
	$('#indication').fadeIn('fast');
	$.post(
		"_save_paidamount.php", 
		{stock_ref: refnumber, amount: theamount}, 
		function(data){
			//alert(data);
			if($.trim(data)=='OK'){
				$('#paidbtn_'+refnumber).attr('disabled','disabled');
				$('button#paidbtn_'+refnumber).html('<span class="inditxt">已存</span>');
				$('input#paid_'+refnumber).attr('title',theamount);
				$('input#paid_'+refnumber).css('background-color','#FC9');
			}else{
				alert('Server is busy, please try later!');
			}
			$('#indication').fadeOut('fast');
		}
	);
}
function cancelorder(the_number){
var refnumber="";
	if(the_number!=0&&!the_number){
		var selected = [];
		$('input[name="subBox"]').each(function() {
               	if(this.checked){
			selected.push('"'+$(this).val()+'"');
		}});
		refnumber=selected.join(',');
	}
	else {
		refnumber='"'+the_number+'"';
	}
	$('#indication').fadeIn('fast');
	var r=confirm('确定要取消预定吗？');
	if(r){
		$.post(
			"_cancel_order.php", 
			{stock_ref: refnumber}, 
			function(data){
				console.log(data);
				//alert(data);
				if($.trim(data)=='OK'){
					//$('button#cancelorderbtn_'+refnumber).html('<span class="inditxt">已取消</span>');
					//$('tr#record_'+refnumber+' td button').attr('disabled','disabled');
					//$('tr#record_'+refnumber).css('background-color','#F0F0F0');
					//$('tr#record_'+refnumber).delay(500).fadeOut('slow');
					location.replace(location.href);
				}else{
					alert('Server is busy, please try later!');
				}
				$('#indication').fadeOut('fast');
			}
		);
	}
}
function reserveddiamond(the_number){
	var refnumber=the_number;
	if(refnumber=='no-action'){
		alert('该钻石已经预留，或已经售出');
		return;
	}
	$('#indication').fadeIn('fast');
	$.post(
		"_reserve_diamond.php", 
		{stock_ref: refnumber}, 
		function(data){
			//alert(data);
			if($.trim(data)=='OK'){
				$('button#reservedbtn_'+refnumber).attr('disabled','disabled');
				$('tr#record_'+refnumber+' td.cell_dia_id').append('<br /><span style="color:#F00;">已预留</span>');
				//$('tr#record_'+refnumber).css('background-color','#F0F0F0');
			}else{
				alert('Server is busy, please try later!');
			}
			$('#indication').fadeOut('fast');
		}
	);
}
function sendorder(the_number){
	var refnumber=the_number;
	var r=false;
	var paid_amount_forthis=parseFloat($('#paid_'+refnumber).attr('title'));
	var ori_price_diamond=parseFloat($('#ori_price_'+refnumber).html());
	var just_put_amout=parseFloat($('#paid_'+refnumber).val());
	if(just_put_amout!=paid_amount_forthis){
		alert("已付金额尚未保存，请先保存。");
		return;
	}
	if(paid_amount_forthis<paid_amount_forthis){
		r=confirm('已付金额小于钻石原有价格。确定已发货吗？');
	}else if(paid_amount_forthis==0){
		r=confirm('已付金额为0。确定已发货吗？');
	}else{
		r=true;
	}
	if(r){
		$('#indication').fadeIn('fast');
		$.post(
			"_send_order.php", 
			{stock_ref: refnumber}, 
			function(data){
				//alert(data);
				if($.trim(data)=='OK'){
					$('button#paidbtn_'+refnumber+', button#cancelorderbtn_'+refnumber+', button#reservedbtn_'+refnumber).fadeOut('fast');					
					$('button#sendbtn_'+refnumber).html('<span class="inditxt">已发货</span>');
					$('tr#record_'+refnumber+' td button').attr('disabled','disabled');
					$('tr#record_'+refnumber).css('background-color','#F0F0F0');
				}else{
					alert('Server is busy, please try later!');
				}
				$('#indication').fadeOut('fast');
			}
		);
	}
}
function commentsave(the_number){
	var refnumber=the_number;
	var thetext=$('textarea#comment_'+refnumber).val();
	$('#indication').fadeIn('fast');
	$.post(
		"_save_ordernote.php", 
		{stock_ref: refnumber, content: thetext}, 
		function(data){
			//alert(data);
			if($.trim(data)=='OK'){
				//alert('ordered');
				$('button#commentsavebtn_'+refnumber).html('<span class="inditxt">已存</span>');
			}else{
				alert('Server is busy, please try later!');
			}
			$('#indication').fadeOut('fast');
		}
	);
}
function getDiaCompany(){
	$('.fromcampanytofetch').each(function(){
		var crrObj=$(this);
		var crr_stock_ref=crrObj.attr('title');
		$.post(
			"getdiamondcompany.php", 
			{diamond_id: crr_stock_ref}, 
			function(data){
				$('td.fromcampanytofetch[title="'+crr_stock_ref+'"]').html(data);
			}
		);
	});
}
function getDiaStock(){
	$('.stocknum_to_fetch').each(function(){
		var crrObj=$(this);
		var crr_stock_ref=crrObj.attr('title');
		$.post(
			"getdiamondstock.php", 
			{diamond_id: crr_stock_ref}, 
			function(data){
				$('p.Stock_Num[title="'+crr_stock_ref+'"]').html(data);
			}
		);
	});
}
function openOperationBox(stockref){
	var thestockref=stockref;
	$('#record_'+thestockref+' td').addClass('crrOperationLine');
	$('#record_'+thestockref+' div.operationbox').fadeIn('fast');
}
function closeOperationBox(){
	$('div.operationbox').fadeOut('fast');
	$('td.crrOperationLine').removeClass('crrOperationLine');
}
function printingmode(){
	$('.hideforprint, div.mng_navi').fadeOut('fast',function(){
		$('button#printingmodebtn').hide();
		$('button#normalmodebtn').show();
	});
	$('.paidfield').hide();
	$('#headerbox').hide();$('#logoutForm').hide();
	$('#contentNavi').hide();
	$('tr').find('th:eq(0)').hide(); $('tr').find('td:eq(0)').hide();
	$('tr').find('th:eq(16)').hide(); $('tr').find('td:eq(16)').hide();
	$('div#maincontent').css('margin-left',20);
}
function operationmode(){
	$('.hideforprint, div.mng_navi').fadeIn('fast',function(){
		$('button#normalmodebtn').hide();
		$('button#printingmodebtn').show();
	});
	$('div#maincontent').removeAttr('style');
	$('.paidfield').show();
	$('#headerbox').show();$('#logoutForm').show();
	$('tr').find('th:eq(0)').show(); $('tr').find('td:eq(0)').show();
	$('tr').find('th:eq(16)').show(); $('tr').find('td:eq(16)').show();
}
$('#orderDateSelect').multiselect();
</script>
</head>
<body>
<?php
include('navi.php');
?>
<div id="maincontent">
<?php if($account_level==0){ ?>
    <p id="contentNavi"><span style="font-size:18px; font-weight:bold; display:inline-block; margin-right:35px;">订单管理</span>
    <button onclick="printingmode()" id="printingmodebtn">
    <img style="width:20px; position:relative; top:3px; left:-3px;" src="../images/print.ico" />打印布局</button>
    <button onclick="operationmode()" id="normalmodebtn">操作布局</button>
    <button id="deleteChecked" onclick="cancelorder()"><img title="取消" style="width:20px; position:relative; top:3px; left:-3px;" src="../images/delete.png" />删除选中</button>
    预定日期：<select multiple="multiple" id="orderDateSelect"  name="filter_orderDate" >
        <option value="all">全部</option>
        <?php foreach($conn->query('select distinct  ordered_time as d from diamonds where ordered_time is not null order by d desc') as $row_orderDate){?>
        <option value='"<?php echo $row_orderDate['d'];?>"' <?php if(strpos($crr_orderDate, $row_orderDate['d'])) {echo 'selected="selected"';} ?>><?php echo $row_orderDate['d'];?></option>
        <?php }?>
            </select>
    客户：<select multiple="multiple" id="customerSelect"  name="filter_customer" >
        <option value="all">全部</option>
        <?php foreach($conn->query('select distinct  customer as d from diamonds where customer is not null order by CONVERT(trim(d) USING gbk)') as $row_orderDate){?>
        <option value='"<?php echo $row_orderDate['d'];?>"' <?php if(strpos($crr_orderDate, $row_orderDate['d'])) {echo 'selected="selected"';} ?>><?php echo $row_orderDate['d'];?></option>
        <?php }?>
    </select>
    预约时间：<select multiple="multiple" id="appointmentSelect"  name="filter_appointment" >
        <option value="all">全部</option>
        <?php foreach($conn->query('select distinct  appointment_time as d from diamonds where customer is not null order by d desc') as $row_orderDate){?>
        <option value='"<?php echo $row_orderDate['d'];?>"' <?php if(strpos($crr_orderDate, $row_orderDate['d'])) {echo 'selected="selected"';} ?>><?php echo $row_orderDate['d'];?></option>
        <?php }?>
    </select>
    <button id="filterOrderBtn" onclick="filterOrderDate()" value="筛选">筛选</button>
    </p>

    <table cellpadding="0" cellspacing="0" id="orderTable">
    <thead>
    <tr id="tablehead">
    <td ><input type="checkbox" id="checkAll"/>全选</td>
    <td width="68">客户</td>
    <td width="68">预约时间</td>
    <td width="68">钻石ID</td>
    <td width="48">Stock #</td>
    <td width="30">Shp</td>
    <td width="38">重量</td>
    <td width="38">Col</td>
    <td width="38">净度</td>
    <td width="88">切工</td>
    <td width="58">荧光</td>
    <td width="78">证书</td>
    <td width="128">钻石所在公司
        <form action="" method="post" id="companyfilterform" class="hideforprint">
        <select name="filter_company" id="filter_company" >
        <option value="all" <?php if($crr_company=="all") {echo 'selected="selected"';} ?>>全部</option>
        <?php
        //fetch all the companies
        foreach($conn->query('SELECT DISTINCT from_company FROM diamonds ') as $row_company){
        ?>
        <option value="<?php echo $row_company['from_company']; ?>" <?php if($crr_company==$row_company['from_company']) {echo 'selected="selected"';} ?>><?php echo $row_company['from_company']; ?></option>
        <?php
        }
        ?>
        </select>
        </form>
    </td>
    <td width="68" >
    价格($)
        <?php if($_SESSION['username']!='gnkf'){?>
        <form action="" method="post" id="pricefilterform" class="hideforprint">
        <select name="filter_price" id="filter_price">
        <option value="price" <?php if($crr_searching_price=="price") {echo 'selected="selected"';} ?>>批发价</option>
        <option value="retail_price" <?php if($crr_searching_price=="retail_price") {echo 'selected="selected"';} ?>>零售价</option>
        </select>
        </form>
        <?php }?>
    </td>
    <td width="68"> 预定人
        <form action="" method="post" id="userfilterform" class="hideforprint">
        <select name="filter_user" id="filter_user">
        <option value="all">全部</option>
        <?php
        //fetch all the companies
        foreach($conn->query('SELECT DISTINCT ordered_by FROM diamonds WHERE order_sent IS NULL') as $row_user){
            $crrusername=$row_user['ordered_by'];
            if($crrusername!=''){
        ?>
        <option value="<?php echo $crrusername; ?>" <?php if($crr_searching_user==$crrusername) {echo 'selected="selected"';} ?>>
        <?php
        foreach($conn->query('SELECT real_name FROM users WHERE user_name = "'.$crrusername.'"') as $rowusername){
            echo $rowusername['real_name'];
        }
        ?>
        </option>
        <?php
            }
        }
        ?>
        </select>
        </form>
    </td>
    <td width="88">预定时间</td>
    <?php if($_SESSION['username']!='gnkf'){?><td width="88">原价</td><?php } ?>
    <td width="68">Agent</td>
    <td class="lastcell">操作</td>
    </tr>
    </thead>
    <tbody>
    <?php
        $sql_where ='  diamonds.ordered_by IS NOT NULL AND diamonds.ordered_by <> ""
             AND diamonds.order_sent IS NULL '.$companyfiltercondition.$userfiltercondition.$orderDateCondition.' ORDER BY ordered_time DESC';
        if(isset($_REQUEST['crr_page'])){ $crr_page=$_REQUEST['crr_page']; }else{ $crr_page=1; }
        $startfrom=($crr_page-1)*35;
        $sql_total = 'select count(*) as num from diamonds diamonds where '.$sql_where;
        foreach($conn->query($sql_total) as $num){
            $result_number=$num['num'];
        }
        $sql_orders='SELECT diamonds.customer,diamonds.appointment_time,diamonds.id, diamonds.stock_ref, stock_num_rapnet, shape, carat, color, fancy_color, clarity,
            grading_lab, certificate_number, cut_grade, polish, symmetry, fluorescence_intensity, raw_price_retail, price,
            raw_price,retail_price,diamonds.from_company, diamonds.ordered_time, paid_amount, comment, source, status,
            users.user_name, users.real_name, users.account_level, users.given_by
            FROM diamonds diamonds,users users where diamonds.ordered_by = users.user_name and '.$sql_where.' LIMIT '.$startfrom.', 35';
        foreach($conn->query($sql_orders) as $row){
            if(ceil($counter/2)>($counter/2)){
                $cellclass='o';
            }else{
                $cellclass='d';
            }
        ?>
    <tr id="record_<?php echo $row['stock_ref']; ?>" class="<?php echo $cellclass; ?>">
    <!--
    <td><?php echo $counter; ?></td>
    -->
    <td><input type="checkbox" name="subBox" value="<?php echo $row['stock_ref']; ?>"/></td>
    <td class="cell_dia_id"><?php echo $row['customer']; ?></td><td class="cell_dia_id"><?php echo $row['appointment_time']; ?></td>
    <td class="cell_dia_id">
    <?php echo $row['stock_ref']; ?>
    <?php if($row['status']=='SOLD'){ ?>
        <br /><span style="color:#F00;">已售出</span>
    <?
    }elseif($row['status']=='RESERVED'){
    ?>
        <br /><span style="color:#F00;">已预留</span>
    <?php } ?>
    </td>
    <td class="cell_stock_ref">
    <?php
    if(($row['stock_num_rapnet']=='-' || $row['stock_num_rapnet']=='') && $row['source']=="RAPNET"){
    ?>
        <p class="Stock_Num stocknum_to_fetch" title="<?php echo $row['stock_ref']; ?>">
        调取中...
        </p>
    <?php
    }else{
    ?>
        <p class="Stock_Num">
        <?php echo $row['stock_num_rapnet']; ?>
        </p>
    <?php } ?>
    </td>
    <td><?php echo $row['shape']; ?></td>
    <td><?php echo $row['carat']; ?></td>
    <td>
    <?php
    if($row['color']!=NULL && $row['color']!=''){
        echo $row['color'];
    }
    if($row['fancy_color']!=NULL && $row['fancy_color']!=''){
        echo $row['fancy_color'];
    }
    ?>
    </td>
    <td><?php echo $row['clarity']; ?></td>
    <td><?php echo $row['cut_grade']; ?> <?php echo $row['polish']; ?> <?php echo $row['symmetry']; ?></td>
    <td><?php echo $row['fluorescence_intensity']; ?></td>
    <td align="center">
    <?php
        $thelab=$row['grading_lab'];
    ?>
    <span class="lab-title"><?php echo $thelab; ?></span><br />
    <?php
    $certi_num=$row['certificate_number'];
    if('GIA'==$thelab){
        $certi_link='http://www.gia.edu/cs/Satellite?pagename=GST%2FDispatcher&childpagename=GIA%2FPage%2FReportCheck&c=Page&cid=1355954554547&reportno='.$certi_num;
    }elseif('IGI'==$thelab){
        //$certi_link='http://www.igiworldwide.com/igi/verify.php?r='.$certi_num;
        $certi_link='http://www.igiworldwide.com/verify.php?r='.$certi_num;
    }elseif('HRD'==$thelab){
        $certi_link='http://www.hrdantwerplink.be/index.php?record_number='.$certi_num;
    }else{
        $certi_link='#not-available';
    }
    ?>
    <a target="_blank" style="color:#000; font-size:9px;" href="<?php echo $certi_link; ?>"><?php echo $certi_num; ?></a>
    </td>
    <?php
    if($row['from_company']=='-' || $row['from_company']=='' || $row['from_company']==NULL){
        if($row['source']=='EXCEL'){
        ?>
            <td>K</td>
        <?php }else{ ?>
            <td class="fromcampanytofetch" title="<?php echo $row['stock_ref']; ?>">正在调取数据...</td>
        <?php }
    }else{ ?>
        <td><?php echo $row['from_company']; ?></td>
    <?php } ?>
    <td>
    <?php if($crr_searching_price=="price"){echo $row['price'];}else if ($crr_searching_price=="retail_price"){echo $row['retail_price'];}?>
    （<?php echo $row['raw_price']; ?>）
    </td>
    <td>
    <?php
    if($row['account_level']<=1){
        echo $row['real_name'];
    }else{
        foreach($conn->query('SELECT real_name FROM users WHERE user_name = "'.$row['given_by'].'"') as $row_mainagent){
            echo $row_mainagent['real_name'];
        }
    }
    ?>
    </td>
    <td><?php echo $row['ordered_time']; ?></td>
    <?php if($_SESSION['username']!='gnkf'){?><td><?php echo $row['raw_price_retail']; ?></td><?php } ?>


    <td><?php echo $row['real_name']; ?></td>
    <td class="lastcell" style="overflow:hidden;">
    已付：<input id="paid_<?php echo $row['stock_ref']; ?>" type="text" class="paidfield" title="<?php echo $row['paid_amount']; ?>" style="width:65px;" value="<?php echo $row['paid_amount']; ?>" />$<span style="display:none;" id="ori_price_<?php echo $row['stock_ref']; ?>"><?php echo $row['price']; ?></span>
    <p style="white-space:nowrap; margin-bottom:2px;" class="actionbox hideforprint">
    <button class="paidbtn" type="button" title="保存" id="paidbtn_<?php echo $row['stock_ref']; ?>" onclick="paidrecord('<?php echo $row['stock_ref']; ?>')" style="background-color:#F90; padding:2px; border-width:1px;"><img title="保存" style="width:16px;" src="../images/save.png" /></button> |
    <button class="cancelorderbtn" title="取消" id="cancelorderbtn_<?php echo $row['stock_ref']; ?>" type="button" onclick="cancelorder('<?php echo $row['stock_ref']; ?>')" style="background-color:#CCC; border-width:1px; padding:2px;"><img title="取消" style="width:16px;" src="../images/delete.png" /></button> |
    <?php
    if($row['status']=='RESERVED' || $row['status']=='SOLD'){
        $stockvalue='no-action';
    }else{
        $stockvalue=$row['stock_ref'];
    }
    ?>
    <button class="reservedbtn" title="预留" id="reservedbtn_<?php echo $row['stock_ref']; ?>" type="button" onclick="reserveddiamond('<?php echo $stockvalue; ?>')" style="background-color:#FFF; border-width:1px; padding:0;"><img title="预留" align="预留" style="width:20px;" src="../images/icon350x350.jpeg" /></button> |
    <button class="sendbtn" title="发货" style="background-color:#96F; font-size:16px; border-width:1px; padding:2px;" type="button" id="sendbtn_<?php echo $row['stock_ref']; ?>" onclick="sendorder('<?php echo $row['stock_ref']; ?>')" ><img title="发货" style="width:18px;" src="../images/deliver_flat_icon.png" /></button>
    <button class="operationbutton" onclick="openOperationBox('<?php echo $row['stock_ref']; ?>')">备注</button>
    </p>
    <!--
    <p style="margin:12px 0; border-style:solid; border-width:1px; border-color:#CCC; padding:5px; background-color:rgba(255,255,255,0.9);"></p>
    -->
    <div class="operationbox">
    <span class="operationXbtn" onclick="closeOperationBox()">X</span>
    <span style="background-color:#FFF;">钻石ID: <?php echo $row['stock_ref']; ?></span>
    <textarea id="comment_<?php echo $row['stock_ref']; ?>" style="width:330px; height:50px;">
    <?php
    if($row['comment']!=NULL || $row['comment']!=''){
        echo $row['comment'];
    }else{
        echo '备注信息：';
    }
    ?>
    </textarea>
    <button class="commentsavebtn" id="commentsavebtn_<?php echo $row['stock_ref']; ?>" type="button" onclick="commentsave('<?php echo $row['stock_ref']; ?>')" style="background-color:#6CF; padding:2px 8px; border-style:solid; border-width:1px; font-size:16px;">保存</button>
    </div>
    </td>
    </tr>
        <?php
        }
    ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="20">
            <p id="dia-page-navi-bottom">
    为您找到<span><?php echo $result_number; ?></span>条结果。

    <?php
    $total_page_NUM=ceil($result_number/35);
    $crr_page_Round=ceil($crr_page/10);
        if($crr_page_Round>1){
        ?>
        <button class="pre-pages-btn" onclick="choosethispage('<?php echo ($crr_page_Round-1)*10-9; ?>')">前10页...</button>
        <?php } ?>
        第
        <?php
        for ($x=1; $x<=10; $x++) {
            $p=($crr_page_Round-1)*10+$x;
            if($p<=$total_page_NUM){
                if($p==$crr_page){
                    $crr_class=' crr-dia-p';
                }else{
                    $crr_class='';
                }
        ?>
        <button class="gotopagebtn<?php echo $crr_class; ?>" onclick="choosethispage('<?php echo $p; ?>')"><?php echo $p; ?></button>
        <?php } } ?>
        页

    <?php
    if(($crr_page_Round*10)<$total_page_NUM){
    ?>
    <button class="next-pages-btn" onclick="choosethispage('<?php echo ($crr_page_Round*10+1); ?>')">...后10页</button>
    <?php
    }
    ?>
    </p>
            </td>
        </tr>
    </tfoot>
    </table>


<?php } elseif($account_level==1){ ?>


    <button onclick="hidefinido()" style="display:inline-block; margin:25px; padding:5px 20px; background-color:#e3dac5; border-width:1px; font-size:16px;">隐藏/显示 已经发货的纪录</button>
    <script type="text/javascript">
    var showfinido=true;
    function hidefinido(){
        if(showfinido){
            $('tr.finido').fadeOut('fast');
            showfinido=false;
        }else{
            $('tr.finido').fadeIn('fast');
            showfinido=true;
        }
    }
    </script>
    <table cellpadding="0" cellspacing="0">
    <tr id="tablehead">
    <td width="68">钻石ID</td>
    <td width="30">形状</td>
    <td width="38">重量</td>
    <td width="38">颜色</td>
    <td width="38">净度</td>
    <td width="88">切工</td>
    <td width="58">荧光</td>
    <td width="78" align="center">证书</td>
    <td width="78">价格(美元)</td>
    <td width="88">预定代理</td>
    <td width="88">预定时间</td>
    <td width="78">操作</td>
    <td width="128" class="lastcell">订单状态</td>
    </tr>
    <?php
    $sql_orders='SELECT diamonds.id, diamonds.stock_ref, shape, carat, color, fancy_color, clarity, grading_lab, certificate_number, cut_grade, polish, symmetry, fluorescence_intensity, price, diamonds.from_company, diamonds.ordered_time, paid_amount, order_sent, comment, status, users.user_name, users.real_name, users.account_level, users.given_by FROM diamonds, users WHERE diamonds.ordered_by IS NOT NULL AND diamonds.ordered_by <> "" AND diamonds.ordered_by = users.user_name AND (diamonds.ordered_by = "'.$username.'" OR (diamonds.ordered_by = users.user_name AND users.given_by = "'.$username.'")) ORDER BY diamonds.ordered_time DESC';
    $counter=0;
        ?>
    </table>
<?php } ?>



</div><!-- end maincontent -->
<div id="#indication" style="position:fixed; width:100%; height:100%; background-color:rgba(255,255,255, 0.88); top:0; left:0; z-index:28; display:none;">
<div id="#indiinner" style="position:relative; width:200px; background-color:#0CF; margin:150px auto; padding:20px; text-align:center;">
正在存储。。。
</div>
</div>
</body>
</html>