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
	li a:hover, li.nav {
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
	input, select {
		padding: 6px 10px;
		margin: 8px 0;
		border: 2px solid dodgerblue;
		border-radius: 4px;
	}
	input[type=button] {
		background-color: dodgerblue;
		color: white;
	}
	#input {
		background-image: url("https://cdn1.iconfinder.com/data/icons/hawcons/32/698627-icon-111-search-512.png");
		background-position: 10px 8px;
		background-size: 10% 55%;
		background-repeat: no-repeat;
		padding: 12px 20px 12px 40px;
	}
	select {
		padding: 12px 20px;
	}
</style>
<?php
	session_start();
	$dbc = mysqli_connect("localhost", "root", "", "online_bookstore") OR die(mysqli_connect_error());
	$r = mysqli_query($dbc, "SELECT * FROM books");
?>
<body>
	<div id="background"></div>
	<h1><img src="https://ubisafe.org/images/transparent-logo-book-3.png" alt="" width="100" height="100" />ONLINE BOOKSTORE</h1>
	<ul>
		<li><a href="Home.php">Home</a></li>
		<li class="nav"><a>Book List</a></li>
		<?php if(!isset($_SESSION['username'])) { ?>
			<li style="float:right"><a href="Login.php">Login</a></li>
		<?php }else{ ?>
			<li><?php if($_SESSION['user_type'] == "member") {echo "<a href='Shoppingcart.php'>Shopping Cart</a>";} ?></li>
			<li><a href="Myaccount.php">My Account</a></li>
			<li style="float:right"><a href="Logout.php">Logout</a></li>
		<?php } ?>
		<li style="float:right"><?php if(isset($_SESSION['username'])) {echo "Welcome, ".$_SESSION['username'];} ?></li>
	</ul>
	<h2>BOOKLIST</h2>
	<ul class="nav">
		<li><b>Search:</b> <input type="text" id="input" placeholder="Search for book title" onkeyup="search()"></li>
		<li style="float:right"><b>Sort by:</b> <select onchange="sort(this.value)"><option value="0">Book ID</option><option value="1">Title</option><option value="5">Price</option></select></li>
	</ul>
	<br>
	<table id="booklist">
		<tr>
			<th>Book ID</th>
			<th>Title</th>
			<th>Author</th>
			<th>Image</th>
			<th>Description</th>
			<th>Price (RM)</th>
			<th>Publisher</th>
			<?php if(isset($_SESSION['username'])) { ?>
				<th>&nbsp;</th>
			<?php } ?>
		</tr>
		<?php while($row = mysqli_fetch_array($r)) { ?>
		<tr>
			<td><?php echo $row['book_id']; ?></td>
			<td><?php echo $row['title']; ?></td>
			<td><?php echo $row['author']; ?></td>
			<td><?php if($row['image'] != "") {echo '<img src="'.$row['image'].'" height="100" width="100">';} ?></td>
			<td><?php echo $row['description']; ?></td>
			<td><?php echo $row['price']; ?></td>
			<td><?php echo $row['publisher']; ?></td>
			<?php if(isset($_SESSION['username'])) { ?>
				<?php if($_SESSION['user_type'] == "admin") {echo "
					<td><pre><a href='Edit.php?book_id=".$row['book_id']."' title='Edit'><img src='https://upload.wikimedia.org/wikipedia/commons/thumb/4/4c/Edit_font_awesome.svg/500px-Edit_font_awesome.svg.png' alt='' width='15' height='15' /></a>    <a href='Delete.php?book_id=".$row['book_id']."' title='Delete'><img src='https://img.icons8.com/metro/1600/delete.png' alt='' width='15' height='15' /></a></pre></td>
				";}
				else {echo "<td><a href='Addtocart.php?book_id=".$row['book_id']."' title='Add to cart'><img src='http://cdn.onlinewebfonts.com/svg/download_334581.png' alt='' width='15' height='15' /></a></td>";} ?>
			<?php } ?>
		</tr>
		<?php } ?>
	</table>
	<br>
	<?php if(isset($_SESSION['username'])) {
		if($_SESSION['user_type'] == "admin") {echo "<a href='Add.php'><input type='button' value='Add'></a>";}
	} ?>
<script>
	function search() {
		var input, filter, table, tr, td, value;
		input = document.getElementById("input");
		filter = input.value.toUpperCase();
		table = document.getElementById("booklist");
		tr = table.getElementsByTagName("tr");
		for(var i = 0; i < tr.length; i++) {
			td = tr[i].getElementsByTagName("td")[1];
			if(td) {
				value = td.textContent;
				if(value.toUpperCase().indexOf(filter) > -1) {
					tr[i].style.display = "";
				}
				else {
					tr[i].style.display = "none";
				}
			}
		}
	}
	function sort(value) {
		var table, rows, column, switching, x, y, shouldSwitch;
		table = document.getElementById("booklist");
		column = value;
		switching = true;
		while(switching) {
			switching = false;
			rows = table.getElementsByTagName("tr");
			for(var i = 1; i < (rows.length - 1); i++) {
				shouldSwitch = false;
				x = rows[i].getElementsByTagName("td")[column];
				y = rows[i + 1].getElementsByTagName("td")[column];
				if(x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
					shouldSwitch = true;
					break;
				}
			}
			if (shouldSwitch) {
				rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
				switching = true;
			}
		}
	}
</script>
</body>
</html>