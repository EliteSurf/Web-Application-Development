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
		width: 26%;
		margin: 0 auto;
	}
	table {
		border-collapse: collapse;
		margin: 0 auto;
		table-layout: fixed;
	}
	td, th {
		border: 2px solid dodgerblue;
		padding: 8px;
		background-color: lightgrey;
	}
	td {
		overflow: hidden;
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
		background-color: dodgerblue;
		color: white;
	}
</style>
<?php
	session_start();
	$dbc = mysqli_connect("localhost", "root", "", "online_bookstore") OR die(mysqli_connect_error());
	$username = $_SESSION['username'];
	$q = "SELECT * FROM users WHERE username='$username'";
	$r = mysqli_query($dbc, $q);
	if($r) {
		$row = mysqli_fetch_array($r);
	}
	else {
		die(mysqli_error($dbc));
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
			<li><a>My Account</a></li>
			<li style="float:right"><a href="Logout.php">Logout</a></li>
		<?php } ?>
		<li style="float:right"><?php if(isset($_SESSION['username'])) {echo "Welcome, ".$_SESSION['username'];} ?></li>
	</ul>
	<h2>MY ACCOUNT</h2>
	<form action="Myaccount.php" method="post">
		<table>
			<col width="100px">
			<col width="1000px">
			<tr>
				<th>Username</th>
				<td><?php echo $row['username']; ?></td>
			</tr>
			<tr>
				<th>Email</th>
				<td><?php echo $row['email']; ?></td>
			</tr>
			<tr>
				<th>Address</th>
				<td><?php echo $row['address']; ?></td>
			</tr>
			<tr>
				<th>Phone</th>
				<td><?php echo $row['phone']; ?></td>
			</tr>
		</table>
		<a href="Editaccount.php"><input type="button" value="Edit"></a>
	</form>
</body>
</html>