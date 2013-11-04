<?php
require 'Membership.php';
session_start();
if($_POST && $_POST['email'] && $_POST['password']){
	$mysql = new MySQL();
	if($mysql->verify_account($_POST['email'],md5($_POST['password']))!=""){
		$_SESSION['email'] = $_POST['email'];
		$_SESSION['status']=true;
        header('Location:'. URL.'index.php');
	}
}
?>
<html>
<head>
<title>UCSD1Shop</title>
		<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
		<link href="css/style.css" media="all" rel="stylesheet" type="text/css" />
		<link href="css/style2.css" media="screen" rel="stylesheet" type="text/css" />
</head>
<body>
	<div class="wrap">
	<nav>
		<ul class="menu">
			<li><a href="index.php"><span class="icon home"></span> UCSD1Shop</a></li>
			<li><a href="login.php"><span class="icon"></span> Login</a></li>
		</ul>
		<div class="clearfix"></div>
	</nav>
	</div>
<section class="loginform cf">
<form name="regular_login" action = "login.php" method="post" value="Regular_SignIn">
		<input type="email" name="email" id="email" value="" size="40" maxlength="40" required placeholder="yourname@email.com"/>
		<br />
		<input type="password"  name="password" id="password" value="" size="40" maxlength="40" required placeholder="password"/>
		<br />        
		<input type="submit" name="subform" value="Sign In"/>
</form>
</section>
</body>
</html>