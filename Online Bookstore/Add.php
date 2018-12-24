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
		border-radius: 4px;
	}
</style>
<?php
	session_start();
	$dbc = mysqli_connect("localhost", "root", "", "online_bookstore") OR die(mysqli_connect_error());
	function test_input($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}
	if($_SERVER["REQUEST_METHOD"] == "POST") {
		$book_id = test_input($_POST["book_id"]);
		$title = test_input($_POST["title"]);
		$author = test_input($_POST["author"]);
		$description = test_input($_POST["description"]);
		$price = test_input($_POST["price"]);
		$publisher = test_input($_POST["publisher"]);
		$image = "";
		
		if(isset($_FILES["image"]) && $_FILES["image"]["name"] != "") {
			$image = "book_image/".$_FILES["image"]["name"];
			$target = "book_image/".basename($image);
			$imageFileType = strtolower(pathinfo($target, PATHINFO_EXTENSION));
			if ($_FILES["image"]["size"] > 500000) {
				echo "<script>
					  window.alert('Image file is too large');
					  window.location.href = 'Booklist.php';
					  </script>";
			}
			if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
				echo "<script>
					  window.alert('Only JPG, JPEG, PNG & GIF files are allowed');
					  window.location.href = 'Booklist.php';
					  </script>";
			}
			if(!move_uploaded_file($_FILES["image"]["tmp_name"], $target)) {
				echo "<script>
				  window.alert('Failed to upload image');
				  window.location.href = 'Booklist.php';
				  </script>";
			}
		}
		
		$q1 = "SELECT book_id FROM books WHERE book_id='$book_id'";
		$r1 = mysqli_query($dbc, $q1);
		if(!$r1) {
			die(mysqli_error($dbc));
		}
		if(mysqli_num_rows($r1) > 0) {
			echo "<script>
				  window.alert('Book ID has been used');
				  window.history.back();
				  </script>";
		}
		
		$q = "INSERT INTO books VALUES ('$book_id', '$title', '$author', '$description', '$price', '$publisher', '$image')";
		$r = mysqli_query($dbc, $q);
		if($r) {
			echo "<script>
				  window.alert('Successfully added new book');
				  window.location.href = 'Booklist.php';
				  </script>";
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
			<li></li>
			<li><a href="Myaccount.php">My Account</a></li>
			<li style="float:right"><a href="Logout.php">Logout</a></li>
		<?php } ?>
		<li style="float:right"><?php if(isset($_SESSION['username'])) {echo "Welcome, ".$_SESSION['username'];} ?></li>
	</ul>
	<h2>ADD BOOK</h2>
	<form action="Add.php" method="post" enctype="multipart/form-data">
		<table>
			<tr>
				<th>Book ID</th>
				<td><input type="text" name="book_id" autocomplete="off" required></td>
			</tr>
			<tr>
				<th>Title</th>
				<td><input type="text" name="title" autocomplete="off" required></td>
			</tr>
			<tr>
				<th>Author</th>
				<td><input type="text" name="author" autocomplete="off" required></td>
			</tr>
			<tr>
				<th>Image</th>
				<td><input type="file" name="image"></td>
			</tr>
			<tr>
				<th>Description</th>
				<td><textarea name="description" cols="40" rows="5"></textarea></td>
			</tr>
			<tr>
				<th>Price</th>
				<td><input type="number" name="price" min="0" step="0.01" required></td>
			</tr>
			<tr>
				<th>Publisher</th>
				<td><input type="text" name="publisher" autocomplete="off" required></td>
			</tr>
		</table>
		<input type="submit" value="Add new book">
		<input type="reset" value="Cancel">
	</form>
</body>
</html>