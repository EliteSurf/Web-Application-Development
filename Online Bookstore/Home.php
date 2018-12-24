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
	li a:hover, li:nth-child(1) {
		background-color: #111;
	}
	form {
		background-color: lightgrey;
		padding: 12px 80px;
		width: 30%;
		margin: 0 auto;
	}
	table {
		background-color: lightgrey;
		height: 300px;
		margin: 0 auto;
	}
	td {
		padding: 10px 10px;
	}
	#image {
		border: 3px solid black;
	}
</style>
<?php
	session_start();
	$dbc = mysqli_connect("localhost", "root", "", "online_bookstore") OR die(mysqli_connect_error());
	$q = "SELECT image FROM books";
	$r = mysqli_query($dbc, $q);
	if(!$r) {
		die(mysqli_error($dbc));
	}
	$image_array = array();
	while($row = mysqli_fetch_array($r)) {
		if($row['image'] != "") {
			$image_array[] = $row['image'];
		}
	}
?>
<body onload="startTimer()">
	<div id="background"></div>
	<h1><img src="https://ubisafe.org/images/transparent-logo-book-3.png" alt="" width="100" height="100" />ONLINE BOOKSTORE</h1>
	<ul>
		<li><a>Home</a></li>
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
	<form>
		<table>
			<caption><h2>BOOK COVER PREVIEW</h2></caption>
			<tr>
				<td><button type="button" onclick="displayPreviousImage()"><img src="http://www.pngmart.com/files/3/Previous-Button-PNG-Picture.png" alt="" width="50" height="50" /></button></td>
				<td><img id="image" src="https://vignette.wikia.nocookie.net/epicrapbattlesofhistory/images/4/4f/White_square.jpg" alt="" width="200" height="300" /></td>
				<td><button type="button" onclick="displayNextImage()"><img src="http://www.pngmart.com/files/3/Previous-Button-PNG-Picture.png" alt="" width="50" height="50" style="transform:rotate(180deg)" /></button></td>
			</tr>
		</table>
	</form>
<script>
	var image_array = [];
	<?php
		$array_size = count($image_array);
		for($i = 0; $i < $array_size; $i++) {
			echo "image_array[$i] = '".$image_array[$i]."';\n";
		}
	?>
	var x = -1;
	function displayNextImage() {
		x = (x == image_array.length - 1) ? 0 : x + 1;
		document.getElementById("image").src = "/Online Bookstore/" + image_array[x];
	}
	function displayPreviousImage() {
		x = (x <= 0) ? image_array.length - 1 : x - 1;
		document.getElementById("image").src = "/Online Bookstore/" + image_array[x];
	}
	function startTimer() {
		displayNextImage();
		setInterval(displayNextImage, 3000);
	}
</script>
</body>
</html>