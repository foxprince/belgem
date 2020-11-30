<?php
$error = '';
session_start ();

if (isset ( $_POST ['login'] ) && isset ( $_POST ['pwd'] )) {
	// echo $_POST['login'];
	$username = addslashes($_POST ['login']);
	$password = addslashes($_POST ['pwd']);
	require_once('../log.php');
	require_once ('../includes/connection.php');
	$conn = dbConnect ( 'write', 'pdo' );
	$conn->query ( "SET NAMES 'utf8'" );
	
	$sql = 'SELECT * FROM users WHERE disable=0 and user_name = binary "' . $username . '" AND pass_word = binary "' . $password . '"';
	$stmt = $conn->query ( $sql );
	$userexits = $stmt->rowCount ();
	
	// exit($userexits);
	
	if (! $userexits) {
		$_SESSION = array ();
		if (isset ( $_COOKIE [session_name ()] )) {
			setcookie ( session_name (), '', time () - 86400, '/' );
		}
		session_destroy ();
		$wrongmessage = '用户名密码不正确，请重试';
	} else {
		foreach ( $stmt as $row_account ) {
			$username = $row_account['user_name'];
			$account_level = $row_account ['account_level'];
		}
		$_SESSION ['username'] = $username;
		$_SESSION ['account_level'] = $account_level;
		
		$the_action = '登陆';
		
		$sql_record_login = 'INSERT INTO login_history (theuser, the_action, action_time) VALUES(:theuser, :the_action, NOW())';
		
		$stmt = $conn->prepare ( $sql_record_login );
		$stmt->bindParam ( ':theuser', $username, PDO::PARAM_STR );
		$stmt->bindParam ( ':the_action', $the_action, PDO::PARAM_STR );
		$stmt->execute ();
		$insertOK = $stmt->rowCount ();
		logger($sql.' '.$_SESSION ['username']);

		header ( 'Location: index.php' );
		exit ( '' );
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<script src="../js/jquery-1.11.2.min.js"></script>
<script src="../js/jquery-ui.min.js"></script>
<style>
body {
	font-family: Georgia, "Times New Roman", Times, serif;
	font-size: 14px;
	font-weight: 100;
	padding: 0;
	margin: 0;
	border-top-style: solid;
	border-width: 5px;
	border-color: #333;
	background-color: #333;
}

img {
	width: 300px;
	position: relative;
}

h1 {
	position: relative;
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

.warning {
	position: relative;
	font-family: "Courier New", Courier, monospace;
	color: #F00;
	text-align: center;
}

input {
	font-size: 16px;
	padding: 8px 50px;
	color: #FFF;
	background-color: #666;
	border-style: none;
	border-width: 0;
	text-align: center;
	margin-bottom: 5px;
}
</style>
<title>BELGEM: login</title>
<!-- plugin placeholder -->
<!-- plugin placeholder -->
<!-- plugin placeholder -->
<script type="text/javascript">
/*! http://mths.be/placeholder v2.0.8 by @mathias */
;(function(window, document, $) {

	var isOperaMini = Object.prototype.toString.call(window.operamini) == '[object OperaMini]';
	var isInputSupported = 'placeholder' in document.createElement('input') && !isOperaMini;
	var isTextareaSupported = 'placeholder' in document.createElement('textarea') && !isOperaMini;
	var prototype = $.fn;
	var valHooks = $.valHooks;
	var propHooks = $.propHooks;
	var hooks;
	var placeholder;

	if (isInputSupported && isTextareaSupported) {

		placeholder = prototype.placeholder = function() {
			return this;
		};

		placeholder.input = placeholder.textarea = true;

	} else {

		placeholder = prototype.placeholder = function() {
			var $this = this;
			$this
				.filter((isInputSupported ? 'textarea' : ':input') + '[placeholder]')
				.not('.placeholder')
				.bind({
					'focus.placeholder': clearPlaceholder,
					'blur.placeholder': setPlaceholder
				})
				.data('placeholder-enabled', true)
				.trigger('blur.placeholder');
			return $this;
		};

		placeholder.input = isInputSupported;
		placeholder.textarea = isTextareaSupported;

		hooks = {
			'get': function(element) {
				var $element = $(element);

				var $passwordInput = $element.data('placeholder-password');
				if ($passwordInput) {
					return $passwordInput[0].value;
				}

				return $element.data('placeholder-enabled') && $element.hasClass('placeholder') ? '' : element.value;
			},
			'set': function(element, value) {
				var $element = $(element);

				var $passwordInput = $element.data('placeholder-password');
				if ($passwordInput) {
					return $passwordInput[0].value = value;
				}

				if (!$element.data('placeholder-enabled')) {
					return element.value = value;
				}
				if (value == '') {
					element.value = value;
					// Issue #56: Setting the placeholder causes problems if the element continues to have focus.
					if (element != safeActiveElement()) {
						// We can't use `triggerHandler` here because of dummy text/password inputs :(
						setPlaceholder.call(element);
					}
				} else if ($element.hasClass('placeholder')) {
					clearPlaceholder.call(element, true, value) || (element.value = value);
				} else {
					element.value = value;
				}
				// `set` can not return `undefined`; see http://jsapi.info/jquery/1.7.1/val#L2363
				return $element;
			}
		};

		if (!isInputSupported) {
			valHooks.input = hooks;
			propHooks.value = hooks;
		}
		if (!isTextareaSupported) {
			valHooks.textarea = hooks;
			propHooks.value = hooks;
		}

		$(function() {
			// Look for forms
			$(document).delegate('form', 'submit.placeholder', function() {
				// Clear the placeholder values so they don't get submitted
				var $inputs = $('.placeholder', this).each(clearPlaceholder);
				setTimeout(function() {
					$inputs.each(setPlaceholder);
				}, 10);
			});
		});

		// Clear placeholder values upon page reload
		$(window).bind('beforeunload.placeholder', function() {
			$('.placeholder').each(function() {
				this.value = '';
			});
		});

	}

	function args(elem) {
		// Return an object of element attributes
		var newAttrs = {};
		var rinlinejQuery = /^jQuery\d+$/;
		$.each(elem.attributes, function(i, attr) {
			if (attr.specified && !rinlinejQuery.test(attr.name)) {
				newAttrs[attr.name] = attr.value;
			}
		});
		return newAttrs;
	}

	function clearPlaceholder(event, value) {
		var input = this;
		var $input = $(input);
		if (input.value == $input.attr('placeholder') && $input.hasClass('placeholder')) {
			if ($input.data('placeholder-password')) {
				$input = $input.hide().next().show().attr('id', $input.removeAttr('id').data('placeholder-id'));
				// If `clearPlaceholder` was called from `$.valHooks.input.set`
				if (event === true) {
					return $input[0].value = value;
				}
				$input.focus();
			} else {
				input.value = '';
				$input.removeClass('placeholder');
				input == safeActiveElement() && input.select();
			}
		}
	}

	function setPlaceholder() {
		var $replacement;
		var input = this;
		var $input = $(input);
		var id = this.id;
		if (input.value == '') {
			if (input.type == 'password') {
				if (!$input.data('placeholder-textinput')) {
					try {
						$replacement = $input.clone().attr({ 'type': 'text' });
					} catch(e) {
						$replacement = $('<input>').attr($.extend(args(this), { 'type': 'text' }));
					}
					$replacement
						.removeAttr('name')
						.data({
							'placeholder-password': $input,
							'placeholder-id': id
						})
						.bind('focus.placeholder', clearPlaceholder);
					$input
						.data({
							'placeholder-textinput': $replacement,
							'placeholder-id': id
						})
						.before($replacement);
				}
				$input = $input.removeAttr('id').hide().prev().attr('id', id).show();
				// Note: `$input[0] != input` now!
			}
			$input.addClass('placeholder');
			$input[0].value = $input.attr('placeholder');
		} else {
			$input.removeClass('placeholder');
		}
	}

	function safeActiveElement() {
		// Avoid IE9 `document.activeElement` of death
		// https://github.com/mathiasbynens/jquery-placeholder/pull/99
		try {
			return document.activeElement;
		} catch (err) {}
	}

}(this, document, jQuery));
</script>
<!-- end of the placeholder plugin -->
<!-- end of the placeholder plugin -->
<!-- end of the placeholder plugin -->
</head>
<body>
  <p style='text-align: center;'>
    <img src="../images/belgemlogo.png" style="width: 128px;" />
  </p>
  <h1 style="margin-top: 20px; text-align: center; color: #FFF;">
    BELGEM BVBA<br />Jewelry products and new design
  </h1>
<?php
if (isset ( $wrongmessage )) {
	echo "<p class='warning'>$wrongmessage</p>";
}
?>

<form id="loginform" method="post" action="">
    <p style="text-align: center;">
      <input type="text" name="login" id="login" placeholder="用户名"><br /> <input type="password" name="pwd" id="pwd"
        placeholder="密码"><br /> <input name="denglu" type="submit"  value="登陆"
          style="background-color: #000; margin-top: 55px;">
    
    </p>
  </form>
  <script>
$(function() {
// Invoke the plugin
	$('input, textarea').placeholder();
});
</script>
</body>
</html>
