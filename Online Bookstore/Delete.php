<?php
	$dbc = mysqli_connect("localhost", "root", "", "online_bookstore") OR die(mysqli_connect_error());
	$book_id = $_GET["book_id"];
	$q = "DELETE FROM books WHERE book_id='$book_id'";
	$r = mysqli_query($dbc, $q);
	if($r) {
		echo "<script>
			  window.alert('Successfully removed selected book');
			  window.location.href = 'Booklist.php';
			  </script>";
	}
	else {
		die(mysqli_error($dbc));
	}
?>