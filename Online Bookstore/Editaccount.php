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
	li a:hover, li:nth-child(4) {
		background-color: #111;
	}
	form {
		width: 25%;
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
	$username = $_SESSION['username'];
	function test_input($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}
	if($_SERVER["REQUEST_METHOD"] == "POST") {
		$address = test_input($_POST["address"]);
		$phone = test_input($_POST["phone"]);
		$q1 = "UPDATE users SET address='$address', phone='$phone' WHERE username='$username'";
		$r1 = mysqli_query($dbc, $q1);
		if($r1) {
			echo "<script>
				  window.alert('Successfully updated account information');
				  window.location.href = 'Myaccount.php';
				  </script>";
		}
		else {
			die(mysqli_error($dbc));
		}
	}
	else {
		$q = "SELECT * FROM users WHERE username='$username'";
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
			<li><?php if($_SESSION['user_type'] == "member") {echo "<a href='Shoppingcart.php'>Shopping Cart</a>";} ?></li>
			<li><a href="Myaccount.php">My Account</a></li>
			<li style="float:right"><a href="Logout.php">Logout</a></li>
		<?php } ?>
		<li style="float:right"><?php if(isset($_SESSION['username'])) {echo "Welcome, ".$_SESSION['username'];} ?></li>
	</ul>
	<h2>UPDATE ACCOUNT</h2>
	<form action="Editaccount.php" method="post">
		<table>
			<tr>
				<th>Username</th>
				<td><input type="text" name="username" value="<?php echo $row['username']; ?>" readOnly="true"></td>
			</tr>
			<tr>
				<th>Email</th>
				<td><input type="email" name="email" value="<?php echo $row['email']; ?>" readOnly="true"></td>
			</tr>
			<tr>
				<th>Address</th>
				<td><input type="text" name="address" value="<?php echo $row['address']; ?>" autocomplete="off" required></td>
			</tr>
			<tr>
				<th>Phone</th>
				<td><input type="number" max="99999999999" name="phone" value="<?php echo $row['phone']; ?>" required></td>
			</tr>
		</table>
		<input type="submit" value="Change">
		<input type="reset" value="Cancel">
	</form>
</body>
</html>