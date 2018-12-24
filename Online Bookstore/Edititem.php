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
	form {
		width: 24%;
		margin: 0 auto;
	}
	table {
		border-collapse: collapse;
		margin: 0 auto;
	}
	td, th {
		border: 1px solid #ddd;
		padding: 8px;
		background-color: lightgrey;
	}
	th {
		padding-top: 12px;
		padding-bottom: 12px;
		padding-right: 50px;
		text-align: left;
	}
	input {
		padding: 6px 10px;
		margin: 8px 0;
		border: 2px solid dodgerblue;
		border-radius: 4px;
	}
	input[type=submit] {
		background-color: dodgerblue;
		color: white;
	}
	input[type=reset] {
		border: 2px solid lightgrey;
	}
</style>
<?php
	session_start();
	$dbc = mysqli_connect("localhost", "root", "", "online_bookstore") OR die(mysqli_connect_error());
	$username = $_SESSION["username"];
	function test_input($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}
	if($_SERVER["REQUEST_METHOD"] == "POST") {
		$book_id = test_input($_POST["book_id"]);
		$quantity = test_input($_POST["quantity"]);
		$q1 = "UPDATE shopping_cart SET quantity='$quantity' WHERE book_id='$book_id' AND username='$username'";
		$r1 = mysqli_query($dbc, $q1);
		if($r1) {
			echo "<script>
				  window.alert('Successfully updated quantity');
				  window.location.href = 'Shoppingcart.php';
				  </script>";
		}
		else {
			die(mysqli_error($dbc));
		}
	}
	else {
		$book_id = $_GET["book_id"];
		$q = "SELECT * FROM shopping_cart WHERE book_id='$book_id' AND username='$username'";
		$r = mysqli_query($dbc, $q);
		if($r) {
			$row = mysqli_fetch_array($r);
		}
		else {
			die(mysqli_error($dbc));
		}
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
			<li><a href="Shoppingcart.php">Shopping Cart</a></li>
			<li><a href="Myaccount.php">My Account</a></li>
			<li style="float:right"><a href="Logout.php">Logout</a></li>
		<?php } ?>
		<li style="float:right"><?php if(isset($_SESSION['username'])) {echo "Welcome, ".$_SESSION['username'];} ?></li>
	</ul>
	<h2>UPDATE SHOPPING CART</h2>
	<form action="Edititem.php" method="post">
		<table>
			<tr>
				<th>Book ID</th>
				<td><input type="text" name="book_id" value="<?php echo $row['book_id']; ?>" readOnly="true"></td>
			</tr>
			<tr>
				<th>Price</th>
				<td><input type="number" min="0" step="0.01" name="price" value="<?php echo $row['price']; ?>" readOnly="true"></td>
			</tr>
			<tr>
				<th>Quantity</th>
				<td><input type="number" min="1" name="quantity" value="<?php echo $row['quantity']; ?>" required></td>
			</tr>
		</table>
		<input type="submit" value="Change">
		<input type="reset" value="Cancel">
	</form>
</body>
</html>