<?php
	ob_start();
	require "constants.php";
	require_once('Membership.php');
	session_start();
	if(isset($_SESSION['email'])){		
			$my_email = $_SESSION['email'];
			$shopping_cart = new SHOPPING_CART();
			if($_POST&&!empty($_POST['product_id'])){
			if($shopping_cart->Add_to_Cart($my_email,$_POST['product_id'],-1)){
			?>

			<?php				
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
<body>
	<div class="wrap">
	<nav>
		<ul class="menu">
			<li><a href="index.php" class='home'>UCSD1SHOP</a></li>
			<li>
			<a href="" class='icon'>
			<?php
				echo "Cart";
				if($quantity > 0){
					echo "($quantity)";
				}
			?>
			</a>
			</li>
			<li><a href="checkout.php" class='icon'>Check Out</a></li>
			<li><a href="logout.php" class='icon'>Logout</a></li>
			<li><a class='icon'>
			Welcome <?= $my_email?>
			</a></li>
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
		$product_price = round($value[3],2);
		echo "<div class='desc'>Price \$$product_price</div>";
		echo "<div class='desc'>Quantity $value[4]</div>";
		echo "<input type='hidden' name='product_id' value='$value[0]'>";
		echo "<input type='submit' class=form_submit value='Delete one from cart'>";
		echo "</form>";
		echo "</div>";
	}
?>
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
