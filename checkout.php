<?php
	ob_start();
	require "constants.php";
	require_once('Membership.php');
	session_start();
	if(isset($_SESSION['email'])){
			$my_email = $_SESSION['email'];
			$shopping_cart = new SHOPPING_CART();
			$mysql = new MySQL();
			if($_POST&&!empty($_POST['phone'])&&!empty($_POST['name'])&&!empty($_POST['location'])&&!empty($_POST['date'])){
				$shopping_cart->check_out($_POST['name'],$_POST['phone'],$_POST['location'],$_POST['date'],$_SESSION['email']);			
				$mail_message = "Your order will arrive". $_POST['date']." at ".$_POST['location']." \n Phone number: ".$_POST['phone']."for ".$_POST['name']." \n Total Amount:".$_POST['total_amount']."\nThank you for shopping!";
				if(DB_USER=="UCSDSHOP1"){
					mail($my_email, MAIL_SUBJECT, $mail_message,MAIL_HEADER);
				}
				header('Location:'. URL.'index.php');
				exit();
			}			
			$info = $mysql->fetch_user_info($my_email);
			$user_name = $info[0];
			$user_phone = $info[1];
?>
<html>
<head>
<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<title>ucsd1shop</title>
		<link href="css/style.css" media="all" rel="stylesheet" type="text/css" />
		<link href="css/style2.css" media="screen" rel="stylesheet" type="text/css" />
</head>
<body>
	<div class="wrap">
	<nav>
		<ul class="menu">
			<li><a href="index.php"><span class="icon home"></span> UCSD1Shop</a></li>
			</li>
			<li><a href="logout.php"><span class="icon home"></span> Logout</a></li>
			<li><a>
			Hi <?= $my_email?>
			</a></li>
		</ul>
		<div class="clearfix"></div>
	</nav>
	</div>
<section class="pic">
<form name ='checkout_form' class='checkout_form' method='post' action='checkout.php'> 
<?php
	$products = $shopping_cart->list_user_cart($my_email);
	$total_value = 0;
	echo "<table class='checkout_table'>";
	echo "<tr><th>Name</th><th>Quantity</th><th>Price</th></tr>";
	foreach ($products as &$value){
		echo "<tr>";
		echo "<td>$value[1]</td>";
		echo "<td>$value[4]</td>";
		echo "<td>\$$value[3]</td>";
		echo "</tr>";
		$total_value = $total_value+$value[3];
	}
	echo "<tr><td>Total</td><td></td><td>\$$total_value</td></tr>";
	echo "</table>";
?>
<input type="hidden" name="total_amount" value='<?=$total_value?>'>
<div class="order">
	<label class="time_select" for="order_delivery_time">Choose a Time Slot</label>
	<select required name="location" class="time_select" id="order_delivery_time">
		<option value=""></option>
		<option value="rita">rita atkinson hall 9:00 pm</option>
		<option value="nobel">Nobel Court 9:45 pm</option>
	</select>
</div>
<br/>
<div class="order">
	<label class="date_select" for="order_delivery_date">Choose Date for delivery</label>
	<select required name="date" class="date_select" id="order_delivery_date">
		<option value=""></option>
		<option value="<?=date("Y-m-d")?>"><?php echo date("Y-m-d")?></option>
		<?php $tomorrow = mktime(0,0,0,date("m"),date("d")+1,date("Y"))?>
		<option value="<?=date("Y-m-d", $tomorrow)?>"><?php echo date("Y-m-d", $tomorrow)?></option>
	</select>
</div>
<br/>
<div class="order">
	<label >Person to Pickup</label>
	<input name="name" id="name" maxlength="40" size="47" required placeholder="your name" value="<?=$user_name ?>"></input>
</div>
<br/>
<div class="order">
	<label>Phone Number</label>
	<input name="phone" id="phone" maxlength="11" size="47" required placeholder="Phone Number" value=<?=$user_phone ?> ></input>
</div>
<br/>
<input class="check_out_submit" type="submit" name="subform" value="Check Out"/>
</form>
</section> 
</body>
</html>
<?php
	}#end if of isset $_SESSION['status']
	else{
		header('Location:'. URL.'login.php');
		exit();
	} #end of else
?>