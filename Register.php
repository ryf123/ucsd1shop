<?php
	define('APP_VERSION',1);
	require_once ('constants.php');
	require_once ('Membership.php');
    session_start();
    $common = new COMMON_FUNCTION();

?>
<html>
<head>
<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<title>ucsd1shop</title>
<link href="css/style.css" media="all" rel="stylesheet" type="text/css" />
<link href="css/style2.css" media="screen" rel="stylesheet" type="text/css" />
</head>
<style>
</style>
<body>
<div class="wrap">
	<nav>
		<ul class="menu">
			<li><a href="index.php"><span class="icon home"></span> UCSD1Shop</a></li>
			<li><a href="login.php"><span class="icon"></span> Login</a></li>
			<?php
				if($common->Verify_Status_Exist()){
					if($_SESSION['status']){
						echo '<li><a href="index.php"><span class="icon"></span> Home</a></li>';
					}
				}
			?>
		</ul>
		<div class="clearfix"></div>
	</nav>
</div>
<section class="loginform cf">
<form name="login" action="Register.php" method="post">

	<input type="email" name="email" id="email" value="" size="50" maxlength="50" required placeholder="yourname@email.com"/>
	<br />
	<input type="password"  name="password" id="password" value="" size="40" maxlength="40" required placeholder="password"/>
	<br />
	<input type="phone"  name="phone" id="phone" value="" size="40" maxlength="11" required placeholder="phone number"/>
	<br />		
	<input type="submit" name="subform" value="Create Account"/>
</form>

<?php
if(isset($add_db_status)){
	if($add_db_status){
	echo "<hr />";
	echo "Email $added_email successfully Added to Database <br />";
	$_POST['username']=NULL;
	$_POST['email']=NULL;
	$_POST = NULL;
	}
	else{
		echo "Email  $added_email already in DB<br />";
	}
	}
if(isset($_SESSION)){
	if(isset($_SESSION['status'])){
	if($_SESSION['status']){
		$my_email = $_SESSION['email'];

	echo "<hr />";
	echo "Successfully Login, $my_email<br />";
	}
	else{
	echo "<hr />";
	echo "Please add you email to DB <br />";
	}#end of else
	}#end of isset $_SESSION['status'])
	}#end of isset($_SESSION)
?>
<?php
	
    if($_POST&&!empty($_POST['email'])&&!empty($_POST['password'])){
		$mysql = new MySQL();
		if($mysql->verify_account_exist($_POST['email'])){
			echo "<div class='account_exist_font'>Account already exists</div>";
		}
		else{
			$add_db_status = $mysql->Add_Account_to_DB($_POST['email'],md5($_POST['password']),$_POST['phone']);
			$added_email = $_POST['email'];
			echo "<div class='account_welcome'>Successfully registered</div>";
			$_SESSION['email'] = $_POST['email'];
			header('Location:'. URL.'index.php');
			//mail($_POST['email'] , MAIL_SUBJECT, MAIL_MESSAGE,MAIL_HEADER);
		}
    }
?>
</section>
</body>
</html>

