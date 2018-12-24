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
	li a:hover, li:nth-child(2) {
		background-color: #111;
	}
	form {
		width: 35%;
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
	input, textarea {
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
	$book_id = $_GET["book_id"];
	$q = "SELECT * FROM books WHERE book_id='$book_id'";
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
			<li></li>
			<li><a href="Myaccount.php">My Account</a></li>
			<li style="float:right"><a href="Logout.php">Logout</a></li>
		<?php } ?>
		<li style="float:right"><?php if(isset($_SESSION['username'])) {echo "Welcome, ".$_SESSION['username'];} ?></li>
	</ul>
	<h2>UPDATE BOOK</h2>
	<form action="Edit2.php" method="post" enctype="multipart/form-data">
		<table>
			<tr>
				<th>Book ID</th>
				<td><input type="text" name="book_id" value="<?php echo $row['book_id']; ?>" autocomplete="off" readOnly="true"></td>
			</tr>
			<tr>
				<th>Title</th>
				<td><input type="text" name="title" value="<?php echo $row['title']; ?>" autocomplete="off" required></td>
			</tr>
			<tr>
				<th>Author</th>
				<td><input type="text" name="author" value="<?php echo $row['author']; ?>" autocomplete="off" required></td>
			</tr>
			<tr>
				<th>Image</th>
				<td><input type="file" name="image" value="<?php echo $row['image']; ?>"></td>
			</tr>
			<tr>
				<th>Description</th>
				<td><textarea name="description" cols="40" rows="5"><?php echo $row['description']; ?></textarea></td>
			</tr>
			<tr>
				<th>Price</th>
				<td><input type="number" min="0" step="0.01" name="price" value="<?php echo $row['price']; ?>" required></td>
			</tr>
			<tr>
				<th>Publisher</th>
				<td><input type="text" name="publisher" value="<?php echo $row['publisher']; ?>" autocomplete="off" required></td>
			</tr>
		</table>
		<input type="submit" value="Change">
		<input type="reset" value="Cancel">
	</form>
</body>
</html>