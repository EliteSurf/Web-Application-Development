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
	input[type=button] {
		background-color: blue;
		color: white;
	}
</style>
<?php
	$dbc = mysqli_connect("localhost", "root", "", "book_db") OR die(mysqli_connect_error());
	mysqli_set_charset($dbc, "utf-8");
	$q = "SELECT * FROM book";
	$r = mysqli_query($dbc, $q);
?>
<body>
	<h1>BOOKSTORE</h1>
	<h2><img src="https://img.icons8.com/cotton/2x/search.png" alt="" width="35" height="35" />Search</h2>
	Price: from RM<input type="number" id="fpinput" min="0" onkeyup="searchPrice()"> to RM<input type="number" id="lpinput" min="0" oninput="searchPrice()">
	<br>
	<br>
	Year Published: from year<input type="number" id="fypinput" min="0" max="2018" onkeyup="searchYearPublished()"> to year<input type="number" id="lypinput" min="0" max="2018" oninput="searchYearPublished()">
	<br>
	<br>
	Publisher: <input type="text" id="input" onkeyup="searchPublisher()">
	<br>
	<br>
	<table id="mytable">
		<tr>
			<th>Book ID</th>
			<th>Title</th>
			<th>Price (RM)</th>
			<th>Publisher</th>
			<th>Year Published</th>
			<th>Image of Book</th>
			<th>&nbsp;</th>
		</tr>
		<?php while($row = mysqli_fetch_array($r)) { ?>
		<tr>
			<td><?php echo $row['book_id']; ?></td>
			<td><?php echo $row['title']; ?></td>
			<td><?php echo $row['price']; ?></td>
			<td><?php echo $row['publisher']; ?></td>
			<td><?php echo $row['year_published']; ?></td>
			<td><?php if($row['image_of_book'] != "") {echo '<img src="'.$row['image_of_book'].'" height="100" width="100">';} ?></td>
			<td><a href='Update.php?book_id="<?php echo $row['book_id']; ?>"'><input type='button' value='Update'></a></td>
		</tr>
		<?php } ?>
	</table>
	<a href="Add.php"><input type="button" value="Add"></a>
<script>
	function searchPrice() {
		var fpinput, lpinput, table, tr, td, value;
		fpinput = parseInt(document.getElementById("fpinput").value);
		lpinput = parseInt(document.getElementById("lpinput").value);
		table = document.getElementById("mytable");
		tr = table.getElementsByTagName("tr");
		for(var i = 0; i < tr.length; i++) {
			td = tr[i].getElementsByTagName("td")[2];
			if(td) {
				value = parseInt(td.textContent);
				if(value >= fpinput && value <= lpinput && fpinput <= lpinput) {
					tr[i].style.display = "";
				}
				else {
					tr[i].style.display = "none";
				}
			}
		}
	}
	function searchYearPublished() {
		var fypinput, lypinput, table, tr, td, value;
		fypinput = parseInt(document.getElementById("fypinput").value);
		lypinput = parseInt(document.getElementById("lypinput").value);
		table = document.getElementById("mytable");
		tr = table.getElementsByTagName("tr");
		for(var i = 0; i < tr.length; i++) {
			td = tr[i].getElementsByTagName("td")[4];
			if(td) {
				value = parseInt(td.textContent);
				if(value >= fypinput && value <= lypinput && fypinput <= lypinput) {
					tr[i].style.display = "";
				}
				else {
					tr[i].style.display = "none";
				}
			}
		}
	}
	function searchPublisher() {
		var input, filter, table, tr, td, value;
		input = document.getElementById("input");
		filter = input.value.toUpperCase();
		table = document.getElementById("mytable");
		tr = table.getElementsByTagName("tr");
		for(var i = 0; i < tr.length; i++) {
			td = tr[i].getElementsByTagName("td")[3];
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
</script>
</body>
</html>