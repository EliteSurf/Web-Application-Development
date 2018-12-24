<!DOCTYPE html>
<html>
<head>
	<title>Exercise 3</title>
</head>
<style>
	h1 {
		background-color: black;
		color: white;
		padding: 30px;
		text-align: center;
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
		background-color: blue;
		color: white;
	}
	input {
		padding: 6px 10px;
		margin: 8px 0;
		border: 2px solid blue;
		border-radius: 4px;
	}
	input[type=submit], input[type=button] {
		background-color: blue;
		color: white;
	}
</style>
<?php
	$dbc = mysqli_connect("localhost", "root", "", "book_db") OR die(mysqli_connect_error());
	mysqli_set_charset($dbc, "utf-8");
	if(isset($_GET["book_id"])) {
		$book_id = trim($_GET["book_id"], '"');
		$q = "SELECT * FROM book WHERE book_id='$book_id'";
		$r = mysqli_query($dbc, $q);
		if($r) {
			$row = mysqli_fetch_array($r);
		}
		else {
			die(mysqli_error($dbc));
		}
	}
	$publisher = $year_published = $image_of_book = "";
	function test_input($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}
	if($_SERVER["REQUEST_METHOD"] == "POST") {
		$book_id = test_input($_POST["book_id"]);
		$title = test_input($_POST["title"]);
		$price = test_input($_POST["price"]);
		$publisher = test_input($_POST["publisher"]);
		$year_published = test_input($_POST["year_published"]);
		
		if(isset($_FILES["image_of_book"]) && $_FILES["image_of_book"]["name"] != "") {
			$image_of_book = "book_image/".$_FILES["image_of_book"]["name"];
			$target = "book_image/".basename($image_of_book);
			$imageFileType = strtolower(pathinfo($target, PATHINFO_EXTENSION));
			if ($_FILES["image_of_book"]["size"] > 500000) {
				echo "<script>
					  window.alert('Image file is too large');
					  window.location.href = 'List.php';
					  </script>";
			}
			if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
				echo "<script>
					  window.alert('Only JPG, JPEG, PNG & GIF files are allowed');
					  window.location.href = 'List.php';
					  </script>";
			}
			if(!move_uploaded_file($_FILES["image_of_book"]["tmp_name"], $target)) {
				echo "<script>
					  window.alert('Failed to upload image');
					  window.location.href = 'List.php';
					  </script>";
			}
		}
		
		$q1 = "UPDATE book SET book_id='$book_id', title='$title', price='$price', publisher='$publisher', year_published='$year_published', image_of_book='$image_of_book' WHERE book_id='$book_id'";
		$r1 = mysqli_query($dbc, $q1);
		if($r1) {
			echo "<script>
				  window.alert('Successfully updated selected book');
				  window.location.href = 'List.php';
				  </script>";
		}
		else {
			die(mysqli_error($dbc));
		}
	}
?>
<body>
	<h1>BOOKSTORE</h1>
	<form action="Update.php" method="post" enctype="multipart/form-data">
		<table>
			<tr>
				<th>Book ID</th>
				<td><input type="number" name="book_id" min="0" max="999" value="<?php echo $row['book_id']; ?>" readOnly="true"></td>
			</tr>
			<tr>
				<th>Title</th>
				<td><input type="text" name="title" value="<?php echo $row['title']; ?>" autocomplete="off" required></td>
			</tr>
			<tr>
				<th>Price</th>
				<td><input type="number" name="price" min="0" value="<?php echo $row['price']; ?>" required></td>
			</tr>
			<tr>
				<th>Publisher</th>
				<td><input type="text" name="publisher" value="<?php echo $row['publisher']; ?>" autocomplete="off"></td>
			</tr>
			<tr>
				<th>Year Published</th>
				<td><input type="number" name="year_published" min="0" max="2018" value="<?php echo $row['year_published']; ?>"></td>
			</tr>
			<tr>
				<th>Image of Book</th>
				<td><input type="file" name="image_of_book" value="<?php echo $row['image_of_book']; ?>"></td>
			</tr>
		</table>
		<input type="submit" value="Update">
		<a href="List.php"><input type="button" value="Cancel"></a>
	</form>
</body>
</html>