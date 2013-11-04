<?php
	require_once('constants.php');
	class MySQL{
	private $conn;
	function __construct(){
		$this->conn = new mysqli(DB_SERVER,DB_USER,DB_PWD,DB_NAME) or die ("Error connection database");
	}
	// Name: verify_email
	// Input: $email
	// Desc: Check in the logged in user is in our DB
	function verify_email($email){
		$query = "SELECT * FROM people_info WHERE email=? LIMIT 1";
		if($stm = $this->conn->prepare($query)){ #Note we can not have $ here
			$stm->bind_param('s',$email);
			$stm->bind_result($user_name,$user_email);
			$stm->execute();
		if($stm->fetch()){
			$stm->close();
			return true;
		}
		return false;
		}
	}
	// Name: verify_account_exist
	// Input: $username 
	// Desc: During create account ,verify if the account already in DB or not
	function verify_account_exist($username){
		$query = "select username from  account_info where(username = '$username') limit 1";
		if($stm = $this->conn->prepare($query)){
			$stm->bind_result($username);
			if($stm->execute()){
				if($stm->fetch()){
					$stm->close();
					return true;
				}
				return false;
			}
		 }		
	}
	function verify_account($username,$password){
		$password = md5($username.$password);
		$query = "select username from  account_info where(username = '$username' and password = '$password') limit 1";
		if($stm = $this->conn->prepare($query)){
			$stm->bind_result($username);
			if($stm->execute()){
				if($stm->fetch()){
					$stm->close();
					return $username;
				}
				return "";
			}
		 }
		
	}
	// Name: Add user to DB
	// Input: $email $password
	// Desc: Add email and password to DB	
	function Add_Account_to_DB($email,$password,$phone){
		$password = md5($email.$password);
		$query = "insert  into account_info values('$email','$password','$phone')";
		 if($stm = $this->conn->prepare($query)){
			if($stm->execute()){
				$stm->close();
				return true;
			}
		 }		
	}
	// Name: Add user to DB
	// Input: $name $email
	// Desc: Add name and email to DB
	function Add_Email_to_DB($name,$email){
		 $query = "insert  into people_info values('$name','$email')";
		 if($stm = $this->conn->prepare($query)){
			if($stm->execute()){
				$stm->close();
				return true;
			}
		 }
		 return false;
	}//end of function Add_Email_to_DB
	}//end of class MySQL
	class COMMON_FUNCTION{
	// Name: Verify_Status_Exist
	// Input:
	// Desc: Return the value of $_SESSION['status'], check if $_SESSION is set first
	function Verify_Status_Exist(){
			if(isset($_SESSION)){
			if(isset($_SESSION['status'])){
				return true;
			}
			return false;
			}
	}
	}
	class SHOPPING_CART{
	private $conn;
	function __construct(){
		$this->conn = new mysqli(DB_SERVER,DB_USER,DB_PWD,DB_NAME) or die ("Error connection database");
	}
	// Name: count_total_products
	// Input: $email
	// Desc: count total items for a user
	function count_total_products($email){
		$query = "select sum(quantity) from cart where email='$email' limit 1";
		if($stm = $this->conn->prepare($query)){
			$stm->bind_result($quantity);
			if($stm->execute()){
				if($stm->fetch()){
					return $quantity;
				}
				else{
					return 0;
				}
			}
			$stm->close();
		}
	}
	function Add_to_Cart($email,$product_id,$quantity){
		$query = "select quantity from ".DB_CART." where(email='$email' and product_id='$product_id') ";
		if($stm = $this->conn->prepare($query)){
			$stm->bind_result($quantity_old);
			if($stm->execute()){
				if($stm->fetch()){
					if($quantity_old+$quantity <=0){
						$query = "delete from ".DB_CART." where(email='$email' and product_id='$product_id')";
					}
					else{
						$query = "update ".DB_CART." set quantity=quantity+$quantity where(email='$email' and product_id='$product_id')";
					}
				}
				else{
					$query = "insert  into ".DB_CART." values('$email','$product_id',1)";
				}
				$stm->close();
				if($stm = $this->conn->prepare($query)){
					if($stm->execute()){
						$stm->close();
				}
				return true;
				}
				
			}
		return false;
		}
	}//end of funciton Add_to_Cart
	// Name: list_products
	// Input:
	// Desc: list all products stored in product_info
	function list_products(){
		$products =array();
		$query = "select * from ".DB_PRODUCT;
		if($stm = $this->conn->prepare($query)){
			$stm->bind_result($id,$name,$pic_id,$price,$notes);
			if($stm->execute()){
			while($stm->fetch()){
				array_push($products,array($id,$name,$pic_id,$price,$notes));
			}
				$stm->close();
			}
		 }
		return $products;
	}
	// Name: list_user_cart
	// Input: $email
	// Desc: list all products for a specific user
	function list_user_cart($email){
		$products = array();
		$products_detail = array();
		$count = 0;
		$query = "select product_id,quantity from ".DB_CART." where(email='$email') ";
		if($stm = $this->conn->prepare($query)){
			$stm->bind_result($product_id,$quantity);
			if($stm->execute()){
				while($stm->fetch()){
					array_push($products,array($product_id,$quantity));
				}
			}
			$stm->close();
		}
		foreach($products as &$each_product){
			$product_id = $each_product[0];
			$quantity = $each_product[1];
			$query = "select * from ".DB_PRODUCT." where(product_id='$product_id') ";
			if($stm = $this->conn->prepare($query)){
				$stm->bind_result($id,$name,$pic_id,$price,$notes);
				if($stm->execute()){
					while($stm->fetch()){
						array_push($products_detail,array($id,$name,$pic_id,$price*$quantity,$quantity));
					}
					$stm->close();
				}
			}
			$count++;
		}
		return $products_detail;
	}//end of function list_user_cart
	}//end of class shopping cart
?>
