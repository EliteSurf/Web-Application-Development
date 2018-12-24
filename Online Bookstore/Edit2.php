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
		
		$q = "UPDATE books SET book_id='$book_id', title='$title', author='$author', description='$description', price='$price', publisher='$publisher', image='$image' WHERE book_id='$book_id'";
		$r = mysqli_query($dbc, $q);
		if($r) {
			echo "<script>
				  window.alert('Successfully updated selected book');
				  window.location.href = 'Booklist.php';
				  </script>";
		}
		else {
			die(mysqli_error($dbc));
		}
	}
?>