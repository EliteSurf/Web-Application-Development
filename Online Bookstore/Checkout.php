<!DOCTYPE html>
<html>
<head>
	<title>Online Bookstore</title>
	<link rel="stylesheet" type="text/css" href="Header.css">
</head>
<style>
	li:nth-child(6) {
		display: block;
		color: lime;
		text-align: center;
		padding: 14px 16px;
		text-decoration: none;
	}
	li a {
		display: block;
		color: white;
		text-align: center;
		padding: 14px 16px;
		text-decoration: none;
	}
	li a:hover, li:nth-child(3) {
		background-color: #111;
	}
	div.form {
		text-align: center;
	}
	form {
		display: inline-block;
		text-align: left;
		background-color: lightgrey;
		padding: 12px 80px;
	}
	input, select {
		padding: 6px 10px;
		margin: 8px 0;
		border: 2px solid dodgerblue;
		border-radius: 4px;
	}
	input[type=submit] {
		background-color: dodgerblue;
		color: white;
	}
</style>
<?php
	session_start();
	$dbc = mysqli_connect("localhost", "root", "", "online_bookstore") OR die(mysqli_connect_error());
	$username = $_SESSION["username"];
	if($_SERVER["REQUEST_METHOD"] == "POST") {
		$r = mysqli_query($dbc, "DELETE FROM shopping_cart WHERE username='$username'");
		if($r) {
			echo "<script>
				  window.alert('Successfully checkout');
				  window.location.href = 'Shoppingcart.php';
				  </script>";
		}
		else {
			die(mysqli_error($dbc));
		}
	}
	else {
		$total = $_GET["total"];
	}
?>
<body>
	<div id="background"></div>
	<h1><img src="https://ubisafe.org/images/transparent-logo-book-3.png" alt="" width="100" height="100" />ONLINE BOOKSTORE</h1>
	<ul>
		<li><a href="Home.php">Home</a></li>
		<li><a href="Booklist.php">Book List</a></li>
		<?php if(!isset($_SESSION['username'])) { ?>
			<li style="float:right"><a href="Login.php">Login</a></li>
		<?php }else{ ?>
			<li><a>Shopping Cart</a></li>
			<li><a href="Myaccount.php">My Account</a></li>
			<li style="float:right"><a href="Logout.php">Logout</a></li>
		<?php } ?>
		<li style="float:right"><?php if(isset($_SESSION['username'])) {echo "Welcome, ".$_SESSION['username'];} ?></li>
	</ul>
	<h2>CHECKOUT</h2>
	<div class="form">
		<form action="Checkout.php" method="post">
			<b>Total payment</b><br>
			<input type="text" value="<?php echo "RM".sprintf("%.2f", $total); ?>" readOnly="true">
			<br>
			<br>
			<b>Payment method</b><br>
			<select onchange="payment(this.value)"><option value="1">Cash on delivery</option><option value="2">Credit card</option><option value="3">Online banking</option></select>
			<p id="payment"></p>
			<br>
			<input type="submit" value="Checkout">
		</form>
	</div>
<script>
	function payment(value) {
		switch(value) {
			case "1":
				document.getElementById("payment").innerHTML = "";
				break;
			case "2":
				document.getElementById("payment").innerHTML = "<b>Credit card channel</b><br><pre><input type='radio' name='creditcard' title='VISA' checked> <img src='http://pngimg.com/uploads/visa/visa_PNG3.png' alt='' width='45' height='30' />	<input type='radio' name='creditcard' title='Mastercard'> <img src='https://upload.wikimedia.org/wikipedia/commons/thumb/b/b7/MasterCard_Logo.svg/2000px-MasterCard_Logo.svg.png' alt='' width='50' height='30' />	<input type='radio' name='creditcard' title='Amex'> <img src='https://cdn3.iconfinder.com/data/icons/flat-icons-web/40/Amex-512.png' alt='' width='50' height='50' /></pre><br><br><b>CVV code</b><br><input type='password' oninput='javascript: if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);' maxlength='4' autocomplete='off' required><br>";
				break;
			case "3":
				document.getElementById("payment").innerHTML = "<b>Online banking channel</b><br><pre><input type='radio' name='bank' title='RHB Bank' checked> <img src='https://assets.sunwaypyramid.com/shops/b7e5d9550b6bad70abe4b47d8f1c1fb5/w320.png' alt='' width='50' height='50' />	<input type='radio' name='bank' title='Hong Leong Bank'> <img src='http://riverwalkvillage.com.my/i/logo-hlb.png' alt='' width='70' height='30' />	<input type='radio' name='bank' title='Public Bank'> <img src='https://www.1300.com.my/wp-content/uploads/2014/11/Public_Bank_Berhad_Logo.png' alt='' width='70' height='30' />	<input type='radio' name='bank' title='Affin Bank'> <img src='https://www.affinbank.com.my/AFFINBANK/media/Content-Images/Main-Page/logo-Affin-big.png' alt='' width='70' height='30' /></pre><br><br><b>Bank account number</b><br><input type='number' oninput='javascript: if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);' maxlength='14' autocomplete='off' required><br>";
				break;
		}
	}
</script>
</body>
</html>