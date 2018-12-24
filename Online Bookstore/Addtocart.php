<?php
	session_start();
	$dbc = mysqli_connect("localhost", "root", "", "online_bookstore") OR die(mysqli_connect_error());
	$username = $_SESSION['username'];
	$book_id = $_GET["book_id"];
	$q = "SELECT * FROM books WHERE book_id='$book_id'";
	$r = mysqli_query($dbc, $q);
	if(!$r) {
		die(mysqli_error($dbc));
	}
	$row = mysqli_fetch_array($r);
	$price = $row['price'];
	$quantity = 1;
	
	$q1 = "SELECT * FROM shopping_cart WHERE book_id='$book_id' AND username='$username'";
	$r1 = mysqli_query($dbc, $q1);
	if(!$r1) {
		die(mysqli_error($dbc));
	}
	if(mysqli_num_rows($r1) > 0) {
		$row1 = mysqli_fetch_array($r1);
		$quantity = $row1['quantity'] + 1;
		$q2 = "UPDATE shopping_cart SET book_id='$book_id', price='$price', quantity='$quantity' WHERE book_id='$book_id' AND username='$username'";
		$r2 = mysqli_query($dbc, $q2);
		if($r2) {
			echo "<script>
				  window.alert('Successfully added selected book to shopping cart');
				  window.location.href = 'Booklist.php';
				  </script>";
		}
		else {
			die(mysqli_error($dbc));
		}
	}
	else {
		$q3 = "INSERT INTO shopping_cart (book_id, price, quantity, username) VALUES ('$book_id', '$price', '$quantity', '$username')";
		$r3 = mysqli_query($dbc, $q3);
		if($r3) {
			echo "<script>
				  window.alert('Successfully added selected book to shopping cart');
				  window.location.href = 'Booklist.php';
				  </script>";
		}
		else {
			die(mysqli_error($dbc));
		}
	}
?>