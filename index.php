<?php
	require "constants.php";
	require_once('Membership.php');
	session_start();
	$shopping_cart = new SHOPPING_CART();
	if(isset($_SESSION['email'])){
		$my_email = $_SESSION['email'];
		if($_POST&&!empty($_POST['product_id'])){
			if($shopping_cart->Add_to_Cart($my_email,$_POST['product_id'],1)){
			}
			else{
				echo "fail";
			}
		}
	$quantity = $shopping_cart->count_total_products($my_email);
	}
	else{
		if($_POST&&!empty($_POST['product_id'])){
			header('Location:'. URL.'login.php');
			exit;
		}
	}
?>
<html>
<head>
<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<title>UCSD1SHOP</title>
<link href="css/style.css" media="all" rel="stylesheet" type="text/css" />
<link href="css/style2.css" media="screen" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="tooltip.js"></script>
</head>
<body>
<div class="wrap">
	<nav class="my_nav">
		<ul class="menu">
			<li><a href="index.php"><span class="icon home"></span> UCSD1SHOP</a></li>
			<?php
				if(!isset($_SESSION['email'])){
					echo "<li><a href='login.php'><span class='icon'></span>";
					echo "Login";
					echo "</a></li>";
				}

				if(!isset($_SESSION['email'])){
					echo "<li><a href='Register.php'><span class='icon'></span>";
					echo "New Acccount";
					echo "</a></li>";
				}
				if(isset($_SESSION['email'])){
					echo "<li><a href='Logout.php'><span class='icon'></span>";
					echo "Logout";
					echo "</a></li>";
				} 	
				if(isset($_SESSION['email'])){
					echo "<li><a href='cart.php'><span class='icon'></span>";
					echo "Check Out";
					echo "</a></li>";
				}
			?>							
			<li><a href="Cart.php">		
			<?php
				if(isset($_SESSION['email'])){
				if($quantity > 0){
					echo "<span class = 'cart_quantity'>$quantity</span>";
				}
				}
			?>
			<input type="image" src="images/cart.png"  width='30px' class="cart_pic"/>
			</a></li>
			<li><a>
			<?php
			if(isset($_SESSION['email'])){
				echo "Welcome $my_email";
			}
			?>
			</a></li>
		</ul>
		<div class="clearfix"></div>
	</nav>
</div>
<section class="pic">
<?php

	$products = $shopping_cart->list_products();
	foreach ($products as &$value){
		echo '<div class="gallery_item">';
		echo "<form name = 'cart_form' method='post' action='index.php'> ";
		echo "<h2 class='product_font' >$value[1]</h2>";
		$image_source = "\"images/$value[2].png\""; 
		echo "<input class='item_pic' type='image' src='images/$value[2].png' alt=' ' width='100%'/>";
		echo "<h2 class='product_font'>Price \$$value[3]</h2>";
		echo "<h2 class='product_font'>$value[4]</h2>";
		echo "<input type='hidden' name='product_id' value='$value[0]'>";
		echo "<input class='form_submit' class ='Add_to_Cart' type='submit' value='Add to cart'>";
		echo "</form>";
		echo "</div>";
	}

?>
</section>
</body>
</html>
