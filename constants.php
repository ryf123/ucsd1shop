<?php
	define('DB_USER','UCSDSHOP1');
	#define('DB_USER','ucsd1shop');
	define('DB_PWD','Firewall12!');
	define('DB_NAME','UCSDSHOP1');
	#define('DB_NAME','ucsd1shop');
	#define('DB_SERVER','localhost');
	define('DB_SERVER',"50.63.105.83");
	#define('URL','http://localhost/ucsd1shop/');
	define('URL', 'http://ucsd1shop.com/ucsd1shop/');
	define('DB_CART','cart');//DB name of shopping cart
	define('DB_PRODUCT','product_info');//DB name of product_info
	define('DB_ORDER','order');//DB Order
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$headers .= 'From: ucsd1shop@ucsd1shop.com' . "\r\n";
	define('MAIL_HEADER',$headers);
	define('MAIL_SUBJECT','Order | Confirmation');
	define('MAIL_MESSAGE','Thank you for shopping');
	define('MY_EMAIL','ucsd1shop@gmail.com');
?>
