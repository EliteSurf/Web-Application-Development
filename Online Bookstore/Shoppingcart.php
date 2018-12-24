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
	table {
		border-collapse: collapse;
		width: 100%;
	}
	td, th {
		border: 1px solid #ddd;
		padding: 8px;
	}
	tr {
		background-color: #f2f2f2;
	}
	tr:hover {
		background-color: #ddd;
	}
	th {
		padding-top: 12px;
		padding-bottom: 12px;
		text-align: left;
		background-color: dodgerblue;
		color: white;
	}
	input[type=number], input[type=button] {
		padding: 6px 10px;
		margin: 8px 0;
		border: 2px solid dodgerblue;
		border-radius: 4px;
	}
	input[type=button] {
		background-color: dodgerblue;
		color: white;
	}
	#total {
		border: 2px solid black;
	}
</style>
<?php
	session_start();
	$dbc = mysqli_connect("localhost", "root", "", "online_bookstore") OR die(mysqli_connect_error());
	$username = $_SESSION["username"];
	$r = mysqli_query($dbc, "SELECT * FROM shopping_cart WHERE username='$username'");
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
	<h2>SHOPPING CART</h2>
	<form action="Shoppingcart.php" method="post">
		<table>
			<tr>
				<th>Book ID</th>
				<th>Price (RM)</th>
				<th>Quantity</th>
				<th>&nbsp;</th>
			</tr>
			<?php $total = 0; ?>
			<?php while($row = mysqli_fetch_array($r)) { ?>
			<tr>
				<td><?php echo $row['book_id']; ?></td>
				<td><?php echo $row['price']; ?></td>
				<td><?php echo $row['quantity']; ?></td>
				<td><pre><a href="Edititem.php?book_id=<?php echo $row['book_id']; ?>" title="Edit"><img src="https://upload.wikimedia.org/wikipedia/commons/thumb/4/4c/Edit_font_awesome.svg/500px-Edit_font_awesome.svg.png" alt="" width="15" height="15" /></a>    <a href="Deleteitem.php?book_id=<?php echo $row['book_id']; ?>" title="Delete"><img src="https://img.icons8.com/metro/1600/delete.png" alt="" width="15" height="15" /></a></pre></td>
				<?php $total += $row['price'] * $row['quantity']; ?>
			</tr>
			<?php } ?>
			<tr id="total">
				<th>Total price (RM)</th>
				<td id="total" colspan="3"><?php echo sprintf("%.2f", $total); ?></td>
			</tr>
		</table>
		<?php if($total != 0) {echo "<a href='Checkout.php?total=".$total."'><input type='button' value='Checkout'></a>";} ?>
	</form>
</body>
</html>