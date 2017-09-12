<div class="headerbox">
<div class="header">

<a id="logolinker" href="/"><img id="logo" src="http://happyeurope.eu/images/belgemlogo.png" /></a>

<div id="navi">
<ul>
<li><a id="aboutbtn" href="/cn/about.php">品牌故事</a></li>

<li><a id="diamondsbtn" href="/cn/diamonds.php">精品钻石</a></li>
<li><a id="diamondsbtn" href="/cn/jewelry.php">精品首饰</a></li>
<li><a id="contactmainbtn" href="/cn/contact.php">联系我们</a></li>
<li id="lastnavibtn"><a id="myaccountbtn" href="/_admin">我的账户</a></li>
<li style="width:100%; height:0" id="naviplaceholder"></li>
</ul>
<h2 id="headerwords" style="display:none;">比利时钻石交易所(Diamond Club)唯一中国公司</h2>
</div>

</div><!-- end header -->
</div>





<div class="mng_navi">

<?php
if($account_level==0){
?>
<a style="color:#000; text-decoration:none; font-weight:900; font-size:20px; position:relative; top:-5px;" href="users.php">用户管理</a>

<a style="color:#000; text-decoration:none; font-weight:900; font-size:20px; position:relative; top:-5px;" href="index.php">订单处理</a>

<a style="color:#000; text-decoration:none; font-weight:900; font-size:20px; position:relative; top:-5px;" href="history.php">交易历史记录</a>

<a style="color:#000; text-decoration:none; font-weight:900; font-size:20px; position:relative; top:-5px;" href="historyaccount.php">管理历史记录</a>

<a style="color:#000; text-decoration:none; font-weight:900; font-size:20px; position:relative; top:-5px;" href="import_excel.php">产品管理</a>

<a style="color:#000; text-decoration:none; font-weight:900; font-size:20px; position:relative; top:-5px;" href="price-settings.php">价格管理</a>
<a style="color:#000; text-decoration:none; font-weight:900; font-size:20px; position:relative; top:-5px;" href="invoice/list.html">发票管理</a>

<a style="color:#000; text-decoration:none; font-weight:900; font-size:20px; position:relative; top:-5px;" href="../">回到网站</a>
<?php
}else if($account_level==1){
?>
<a style="color:#000; text-decoration:none; font-weight:900; font-size:20px; position:relative; top:-5px;" href="users.php">用户管理</a>

<a style="color:#000; text-decoration:none; font-weight:900; font-size:20px; position:relative; top:-5px;" href="index.php">订单处理</a>

<a style="color:#000; text-decoration:none; font-weight:900; font-size:20px; position:relative; top:-5px;" href="history.php">历史记录</a>

<a style="color:#000; text-decoration:none; font-weight:900; font-size:20px; position:relative; top:-5px;" href="../">回到网站</a>
<?php
}else{
?>

<a style="color:#000; text-decoration:none; font-weight:900; font-size:20px; position:relative; top:-5px;" href="index.php">订单处理</a>

<a style="color:#000; text-decoration:none; font-weight:900; font-size:20px; position:relative; top:-5px;" href="../">回到网站</a>
<?php
}
?>


</div>



<form class="logout" action="" method="post" style="position:absolute; top:5px; right:0px; width:80px;"> 
     <input type="submit" name="logout" id="logout" value="logout">
</form>