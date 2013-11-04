<?php
	require "constants.php";
	require_once('Membership.php');
	session_start();
	if(isset($_SESSION['status'])){
		if($_SESSION['status']) {
			$my_email = $_SESSION['email'];
			$shopping_cart = new SHOPPING_CART();
			if($_POST&&!empty($_POST['product_id'])){
			if($shopping_cart->Add_to_Cart($my_email,$_POST['product_id'],-1)){
				
			}
			else{
				echo "fail";
			}
			}
			$quantity = $shopping_cart->count_total_products($my_email);
?>

<html>
<head>
<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<title>ucsd1shop</title>
		<link href="css/style.css" media="all" rel="stylesheet" type="text/css" />
		<link href="css/style2.css" media="screen" rel="stylesheet" type="text/css" />
</head>
	<div class="wrap">
	<nav>
		<ul class="menu">
			<li><a href="index.php"><span class="icon home"></span> UCSD1Shop</a></li>
			<li>
			<a href=""><span class="icon home"></span>
			<?php
				echo "Cart";
				if($quantity > 0){
					echo "($quantity)";
				}
			?>
			</a>
			</li>
			<li><a href="logout.php"><span class="icon home"></span> Check Out</a></li>
			<li><a href="logout.php"><span class="icon home"></span> Logout</a></li>
			<br />
			Welcome <?= $my_email?>
		</ul>
		<div class="clearfix"></div>
	</nav>
	</div>
<section class="pic">
<?php

	$products = $shopping_cart->list_user_cart($my_email);
	foreach ($products as &$value){
		echo '<div class="gallery_item">';
		echo "<form name = 'cart_form' method='post' action='Cart.php'> ";
		echo "<input class='item_pic' type='image' src='images/$value[2].png'  width='100%'/>";
		echo "<div class='desc'>$value[1]</div>";
		echo "<div class='desc'>Price \$$value[3]</div>";
		echo "<div class='desc'>Quantity $value[4]</div>";
		echo "<input type='hidden' name='product_id' value='$value[0]'>";
		echo "<input type='submit' value='Delete from cart by 1'>";
		echo "</form>";
		echo "</div>";
	}
?>
</section>
</html>
<?php
	}#end if of $_SESSION['status'] equals true
	else{
		header('Location:'. URL.'/login.php');
		exit();
	} #end of else
	}#end if of isset $_SESSION['status']
	else{
		header('Location:'. URL.'/login.php');
		exit();
	} #end of else
?>
