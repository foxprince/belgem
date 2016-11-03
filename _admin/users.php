<?php
/* ===================session======================== */
session_start ();

if (isset ( $_POST ['logout'] )) {
	if (isset ( $_SESSION ['authenticated'] )) {
		$_SESSION = array ();
		if (isset ( $_COOKIE [session_name ()] )) {
			setcookie ( session_name (), '', time () - 86400, '/' );
		}
		session_destroy ();
	}
	header ( 'Location: login.php' );
	exit ();
}

// if session variable not set, redirect to login page
if (! isset ( $_SESSION ['authenticated'] )) {
	header ( 'Location: login.php' );
	exit ();
}

if ($_SESSION ['authenticated'] != 'SiHui') {
	$_SESSION = array ();
	if (isset ( $_COOKIE [session_name ()] )) {
		setcookie ( session_name (), '', time () - 86400, '/' );
	}
	session_destroy ();
	header ( 'Location: login.php' );
	exit ();
}

$username = $_SESSION ['username'];
$account_level = $_SESSION ['account_level'];
if ($account_level >= 2) {
	exit ( 'no permit' );
}

require_once ('../includes/connection.php');
$conn = dbConnect ( 'write', 'pdo' );
$conn->query ( "SET NAMES 'utf8'" );

$existinguser = false;

if (isset ( $_POST ['user_name'] ) && isset ( $_POST ['pass_word'] )) {
	$real_name = $_POST ['real_name'];
	$user_name = $_POST ['user_name'];
	$pass_word = $_POST ['pass_word'];
	$account_level_db = $_POST ['account_level'];
	$given_by = $_POST ['given_by'];
	$more_info = $_POST ['more_info'];

	$sql_check = 'SELECT id FROM users WHERE user_name = "' . $user_name . '"';
	$stmt_check = $conn->query ( $sql_check );
	$found = $stmt_check->rowCount ();
	if ($found) {
		$existinguser = true;
	} else {
		$existinguser = false;
	}

	if (! $existinguser) {
		$sql_insert = 'INSERT INTO users (user_name, pass_word, real_name, more_info, account_level, given_by) VALUES(:user_name, :pass_word, :real_name, :more_info, :account_level, :given_by)';
		$stmt = $conn->prepare ( $sql_insert );
		$stmt->bindParam ( ':user_name', $user_name, PDO::PARAM_STR );
		$stmt->bindParam ( ':pass_word', $pass_word, PDO::PARAM_STR );
		$stmt->bindParam ( ':real_name', $real_name, PDO::PARAM_STR );
		$stmt->bindParam ( ':more_info', $more_info, PDO::PARAM_STR );
		$stmt->bindParam ( ':account_level', $account_level_db, PDO::PARAM_INT );
		$stmt->bindParam ( ':given_by', $given_by, PDO::PARAM_STR );

		$stmt->execute ();
		$insertOK = $stmt->rowCount ();
	}
}

/*
 *
 * if(isset($_POST['content_en']) && isset($_POST['content_ch'])){
 *
 * include('nuke_magic_quotes.php');
 *
 * $content_en=$_POST['content_en'];
 * $content_ch=$_POST['content_ch'];
 * $title_en=$_POST['title_en'];
 * $title_ch=$_POST['title_ch'];
 *
 *
 *
 *
 *
 * $sql_insert='INSERT INTO news (title_en, title_ch, content_en, content_ch)
 * VALUES(:title_en, :title_ch, :content_en, :content_ch)';
 *
 *
 * $stmt=$conn->prepare($sql_insert);
 * $stmt->bindParam(':title_en', $title_en, PDO::PARAM_STR);
 * $stmt->bindParam(':title_ch', $title_ch, PDO::PARAM_STR);
 * $stmt->bindParam(':content_en', $content_en, PDO::PARAM_STR);
 * $stmt->bindParam(':content_ch', $content_ch, PDO::PARAM_STR);
 *
 * $stmt->execute();
 * $OK=$stmt->rowCount();
 *
 *
 * if($OK){
 * $message_db="发布成功";
 * //echo "db ok";
 * }else{
 * //echo "db no ok";
 * $error=$stmt->errorInfo();
 * if(isset($error[2])){
 * $error=$error[2];
 * //echo $error;
 * }
 * }
 * }
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>管理界面</title>
<link rel="stylesheet" href="adminstyle.css">
  <style>
body {
	font-family: 'Microsoft Yahei', 微软雅黑, STHeiti, simsun, Arial, sans-serif;
	font-size: 14px;
	font-weight: 100;
}

h3.listtitle {
	padding: 5px 20px;
	margin: 20px;
	border-bottom-style: solid;
	border-width: 1px;
	border-color: #CCC;
	font-size: 32px;
}

h1 {
	position: relative;
	left: 40px;
	font-family: Verdana, Geneva, sans-serif;
	font-weight: bold;
	font-size: 20px;
	color: #000;
	margin-top: 0px;
}

form {
	position: relative;
}

p {
	margin-top: 30px;
}

label {
	display: inline-block;
	width: 88px;
	font-size: 14px;
}

.formbox {
	width: 450px;
}

.alert {
	font-family: "Courier New", Courier, monospace;
	font-size: 14px;
	color: #F00;
	position: relative;
	left: 40px;
}

span {
	color: #F00;
}

.logout {
	position: absolute;
	left: 100%;
	top: 20px;
	margin-left: -58px;
}

.mnavic {
	position: absolute;
	left: 380px;
	top: 20px;
}

.mnavic a {
	margin: 10px;
	padding-left: 5px;
	padding-right: 5px;
	cursor: pointer;
}

.mnavi {
	background-color: #CFF;
	border-style: outset;
	border-width: 2px;
	font-family: Verdana, Geneva, sans-serif;
	font-size: 12px;
	text-decoration: none;
	color: #000;
}

.instruction {
	background-color: #FF9;
	color: #000;
	font-weight: bold;
}

div.newuser {
	display: block;
	position: relative;
	width: 380px;
	padding: 20px;
	background-color: #f1e7df;
	border-style: solid;
	border-color: #960;
	border-radius: 8px;
	border-width: 1px;
	margin-left: 8px;
}

div.userbox {
	position: relative;
	width: 250px;
	padding: 15px;
	margin: 8px;
	border-style: solid;
	border-width: 1px;
	border-color: #999;
	display: inline-block;
	height: 380px;
	float: left;
	overflow-y: auto;
	background-color: #f1e7df;
}

.userbox a {
	color: #960;
}

.leveltitle {
	margin: 0;
	font-size: 18px;
	color: #D3AA71;
}

div.level2user {
	background-color: #F5F5F5;
	padding: 12px;
	margin-top: 8px;
}

.leveltitlesub {
	margin: 3px 0 3px 0;
	position: relative;
	left: -10px;
	top: -10px;
	font-size: 16px;
}

.userbox p {
	margin: 3px 0;
}

.tipsbox {
	padding: 5px;
	border-style: solid;
	border-width: 1px;
	border-color: #CCC;
}

.l2realname {
	display: inline-block;
	padding: 2px;
	margin: 3px;
	background-color: #FFF;
}

p.realname {
	margin-top: 0;
	font-size: 26px;
}

h3.createtitle {
	font-size: 20px;
	margin-top: 0;
}

a.edituserbtn {
	display: inline-block;
	position: absolute;
	top: 3px;
	right: 3px;
	border-style: solid;
	border-width: 1px;
	border-color: #C90;
	text-decoration: none;
	color: #FFF;
	font-size: 12px;
	background-color: #960;
	padding: 1px 5px;
}

a.edituserbtn:hover {
	background-color: #C90;
}
</style>
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
  <script type="text/javascript">

</script>
  <script type="text/javascript">
$(document).ready(function(){

	$("#submit_article").click(function(){

			$("form#uploadArticle").submit();

	});
});


function formcomplete(){


	if($.trim($('#title').val())==''){
		alert('没有标题！');
		return false;
	}

	return true;
}

</script>

</head>
<body>

<?php
include ('navi.php');
function genRandomString() {
	$length = 9;
	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$string = '';

	for($p = 0; $p < $length; $p ++) {
		$string .= $characters [mt_rand ( 0, (strlen ( $characters ) - 1) )];
	}

	return $string;
}
?>


<div id="maincontent">
    <h1 style="font-size: 20px; color: #333; margin: 0 0 12px 0; display: none;">用户管理界面</h1>
    <div class="newuser">
      <h3 class="createtitle" style="color: #CA5;">创建代理账户</h3>

<?php
if (isset ( $insertOK ) && $insertOK) {
	?>
<h2 style="color: #F00;">用户创建成功。</h2>
<?php
} else if ($existinguser) {
	?>
<h2 style="color: #F00;">
        用户创建失败：<br />用户名‘<?php echo $user_name; ?>’已被占用</h2>
<?php
}
?>

<form action="" method="post">
        <label>实名：</label> <input name="real_name" type="text" /><br /> <label>用户名：</label> <input name="user_name"
          type="text" value="B<?php echo strtotime('now'); ?>" /> <span
          style="font-size: 10px; white-space: nowrap; color: #999;">英文字母、数字组合</span><br /> <label>密码：</label> <input
          name="pass_word" type="text" value="<?php echo genRandomString(); ?>" /> <span
          style="font-size: 10px; white-space: nowrap; color: #999;">英文字母、数字组合</span><br />
<?php
if ($account_level == 0) {
	?>


<label>代理级别：</label> <select name="account_level">
          <option value="1">一级代理</option>
          <option value="2">二级代理（下属代理）</option>
          <option value="8">独立代理</option>
        </select> <br /> <input type="hidden" name="given_by" value="" />
<?php
} else {
	?>
<input type="hidden" name="account_level" value="2" /> <input type="hidden" name="given_by"
          value="<?php echo $username; ?>" />
<?php
}
?>
<p style="margin-top: 0;">
          <label style="display: inline-block; float: left;">备注信息：</label>
          <textarea name="more_info"
            style="width: 260px; height: 70px; display: inline-block; float: left; margin-left: 5px;"></textarea>
          <br style="clear: both;" />
        </p>
        <p style="text-align: right; padding-right: 20px; margin: 0;">
          <input type="submit" name="tianjia"
            style="background-color: #960; padding: 3px 20px; font-size: 18px; color: #FFF; border-style: solid; border-width: 1px; cursor: pointer;"
            value="创建" />
        </p>
      </form>
    </div>
    <h3 class="listtitle"
      style="padding: 0; margin: 0 258px 15px 8px; border-bottom-style: solid; border-bottom-width: 1px; border-color: #960;">
      <span
        style="display: inline-block; color: #960; background-color: #f1e7df; font-size: 20px; margin: 65px 0 0 0; padding: 3px 12px; border-style: solid; border-width: 1px; border-color: #960;">代理列表</span>
    </h3>


<?php
if ($account_level == 0) {
	$sql_ursers = 'SELECT * FROM users WHERE account_level = 1 ORDER BY id DESC';
	foreach ( $conn->query ( $sql_ursers ) as $row ) {
		?>
		<div class="userbox">
      <div class="level1user">
        <h3 class="leveltitle">一级代理</h3>
        <p class="realname" <?php if($row['disable']){?> style="background-color: yellow;" <?php } ?>><?php echo $row['real_name']; ?></p>
        <p>用户名：<?php echo $row['user_name']; ?></p>
        <p>密码：<?php echo $row['pass_word']; ?></p>
        备注信息：
        <p class="tipsbox"><?php echo $row['more_info']; ?></p>
        <p>
          <a href="/_admin/history.php?agent=<?php echo $row['user_name']; ?>">查看历史纪录</a>
        </p>
      </div>
            <?php $given_by_user=$row['user_name']; ?>
            <div class="level2user">
        <h3 class="leveltitlesub">下属二级代理</h3>
                <?php
		$sql_urser_level2 = 'SELECT * FROM users WHERE given_by = "' . $given_by_user . '" ORDER BY id DESC';
		foreach ( $conn->query ( $sql_urser_level2 ) as $row_level2 ) {
			?>
                <p class="agentlevel2box">
          <a class="l2realname" title="点击查看历史纪录"
            href="/_admin/history.php?agent=<?php echo $row_level2['user_name']; ?>"><?php echo $row_level2['real_name']; ?></a>
        </p>
                <?php
		}
		?>
            </div>
      <a class="edituserbtn" href="useredit.php?id=<?php echo $row['id']; ?>">修改</a>
    </div>
	<?php
	}
	$sql_user_ind = 'SELECT * FROM users WHERE account_level > 1 AND given_by = ""  ORDER BY id DESC';
	foreach ( $conn->query ( $sql_user_ind ) as $row_ind ) {
		?>
        <div class="user_independent userbox">
        <?php
		if ($row_ind ['account_level'] == 2) {
			?>
            <h3 class="leveltitle">独立二级代理</h3>
            <?php
		} else {
			?>
             <h3 class="leveltitle">独立代理</h3>
             <?php
		}
		?>
      <p class="realname" <?php if($row_ind['disable']){?> style="background-color: yellow;" <?php } ?>><?php echo $row_ind['real_name']; ?></p>
      <p>用户名：<?php echo $row_ind['user_name']; ?></p>
      <p>密码：<?php echo $row_ind['pass_word']; ?></p>
      备注信息：
      <p class="tipsbox"><?php echo $row_ind['more_info']; ?></p>
      <p>
        <a href="/_admin/history.php?agent=<?php echo $row_ind['user_name']; ?>">查看历史纪录</a>
      </p>
      <a class="edituserbtn" href="useredit.php?id=<?php echo $row_ind['id']; ?>">修改</a>
    </div>
        <?php
	}
} else if ($account_level == 1) {
	$sql_ursers = 'SELECT * FROM users WHERE given_by = "' . $username . '" ORDER BY id DESC';

	if (isset ( $sql_ursers )) {
		foreach ( $conn->query ( $sql_ursers ) as $row ) {
			?>
            <div class="userbox">
      <p class="realname" <?php if($row['disable']){?> style="background-color: yellow;" <?php } ?>><?php echo $row['real_name']; ?></p>
      <p>用户名：<?php echo $row['user_name']; ?></p>
      <p>密码：<?php echo $row['pass_word']; ?></p>
      备注信息：
      <p class="tipsbox"><?php echo $row['more_info']; ?></p>
      <p>
        <a href="/_admin/history.php?agent=<?php echo $row['user_name']; ?>">查看历史纪录</a>
      </p>
      <a class="edituserbtn" href="useredit.php?id=<?php echo $row['id']; ?>">修改</a>
    </div>
		<?php
		}
	}
} else {
	echo $account_level;
}
?>
<p style="clear: both; text-align: center;">以上是所有代理</p>
  </div>
  <!-- end maincontent -->
</body>
</html>