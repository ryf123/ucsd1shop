<?php
require_once ('constants.php');
session_start();
if(isset($_SESSION['email'])){	
		session_destroy();
		header('Location:'. URL.'/index.php');
}
?>