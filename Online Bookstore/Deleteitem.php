<?php
	session_start();
	$dbc = mysqli_connect("localhost", "root", "", "online_bookstore") OR die(mysqli_connect_error());
	$book_id = $_GET["book_id"];
	$username = $_SESSION["username"];
	$q = "DELETE FROM shopping_cart WHERE book_id='$book_id' AND username='$username'";
	$r = mysqli_query($dbc, $q);
	if($r) {
		echo "<script>
			  window.alert('Successfully removed selected item');
			  window.location.href = 'Shoppingcart.php';
			  </script>";
	}
	else {
		die(mysqli_error($dbc));
	}
?>