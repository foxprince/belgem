<div id="headerbox" class="headerbox">
<div class="header">

<a id="logolinker" href="/"><img id="logo" src="../images/belgemlogo.png" /></a>

<div id="navi">
<ul>
<li><a id="aboutbtn" href="/cn/about.php">Brand</a></li>

<!--<li><a id="diamondsbtn" href="/cn/diamonds.php">Diamond</a></li>-->
<li><a id="diamondsbtn" href="/cn/jewelry.php">Jewelry</a></li>
<li><a id="contactmainbtn" href="/cn/contact.php">Contact</a></li>
<li id="lastnavibtn"><a id="myaccountbtn" href="/_admin/index.php">MyAccount</a></li>
<li style="width:100%; height:0" id="naviplaceholder"></li>
</ul>
<h2 id="headerwords" style="display:none;">比利时钻石交易所(Diamond Club)唯一中国公司</h2>
</div>

</div><!-- end header -->
</div>





<div class="mng_navi">

<?php
if($account_level==0&&$_SESSION['username']!='gnkf'){
?>
<a style="color:#000; text-decoration:none; font-weight:900; font-size:20px; position:relative; top:-5px;" href="/_admin/users.php">用户管理</a>

<a style="color:#000; text-decoration:none; font-weight:900; font-size:20px; position:relative; top:-5px;" href="/_admin/index.php">Order Mng</a>

<a style="color:#000; text-decoration:none; font-weight:900; font-size:20px; position:relative; top:-5px;" href="/_admin/history.php">交易历史记录</a>

<a style="color:#000; text-decoration:none; font-weight:900; font-size:20px; position:relative; top:-5px;" href="/_admin/historyaccount.php">管理历史记录</a>

<a style="color:#000; text-decoration:none; font-weight:900; font-size:20px; position:relative; top:-5px;" href="/_admin/import_excel.php">产品管理</a>

<a style="color:#000; text-decoration:none; font-weight:900; font-size:20px; position:relative; top:-5px;" href="/_admin/price-settings.php">价格管理</a>
<a style="color:#000; text-decoration:none; font-weight:900; font-size:20px; position:relative; top:-5px;" href="http://www.lumiagem.com/cn/jewMng/ivtMng.html" target="_blank">首饰管理</a>
<a style="color:#000; text-decoration:none; font-weight:900; font-size:20px; position:relative; top:-5px;" href="/">回到网站</a>
<?php
}else if($account_level==0&&$_SESSION['username']=='gnkf'){
?>
<a style="color:#000; text-decoration:none; font-weight:900; font-size:20px; position:relative; top:-5px;" href="/_admin/index.php">Order Mng</a>
<a style="color:#000; text-decoration:none; font-weight:900; font-size:20px; position:relative; top:-5px;" href="http://www.lumiagem.com/cn/jewMng/ivtMng.html" target="_blank">首饰管理</a>
<a style="color:#000; text-decoration:none; font-weight:900; font-size:20px; position:relative; top:-5px;" href="/">回到网站</a>
<?php
}else if($account_level==1){
?>
<a style="color:#000; text-decoration:none; font-weight:900; font-size:20px; position:relative; top:-5px;" href="/_admin/users.php">用户管理</a>

<a style="color:#000; text-decoration:none; font-weight:900; font-size:20px; position:relative; top:-5px;" href="/_admin/history.php">历史记录</a>

<a style="color:#000; text-decoration:none; font-weight:900; font-size:20px; position:relative; top:-5px;" href="/">回到网站</a>
<?php
}else{
?>

<a style="color:#000; text-decoration:none; font-weight:900; font-size:20px; position:relative; top:-5px;" href="/_admin/index.php">Order Mng</a>

<a style="color:#000; text-decoration:none; font-weight:900; font-size:20px; position:relative; top:-5px;" href="/">GoToWebsite</a>
<?php
}
?>


</div>



<form id="logoutForm"class="logout" action="" method="post" style="position:absolute; top:5px; right:0px; width:80px;"> 
     <input type="submit" name="logout" id="logout" value="logout">
</form>