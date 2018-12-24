<!DOCTYPE html>
<html>
<head>
	<title>Online Bookstore</title>
	<link rel="stylesheet" type="text/css" href="Header.css">
</head>
<style>
	li a {
		display: block;
		color: white;
		text-align: center;
		padding: 14px 16px;
		text-decoration: none;
	}
	li a:hover, li:nth-child(3) {
		background-color: #111;
	}
	div.form {
		text-align: center;
	}
	form {
		display: inline-block;
		text-align: left;
		background-color: lightgrey;
		padding: 12px 80px;
	}
	input {
		padding: 6px 10px;
		margin: 8px 0;
		border: 2px solid dodgerblue;
		border-radius: 4px;
	}
	input[type=submit] {
		background-color: dodgerblue;
		color: white;
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
		$username = test_input($_POST["username"]);
		$password = test_input($_POST["password"]);
		$email = test_input($_POST["email"]);
		$address = test_input($_POST["address"]);
		$phone = test_input($_POST["phone"]);
		
		$q1 = "SELECT username FROM users WHERE username='$username'";
		$r1 = mysqli_query($dbc, $q1);
		if(!$r1) {
			die(mysqli_error($dbc));
		}
		if(mysqli_num_rows($r1) > 0) {
			echo "<script>
				  window.alert('Username has been used');
				  window.history.back();
				  </script>";
		}
		
		$q2 = "SELECT username FROM users WHERE email='$email'";
		$r2 = mysqli_query($dbc, $q2);
		if(!$r2) {
			die(mysqli_error($dbc));
		}
		if(mysqli_num_rows($r2) > 0) {
			echo "<script>
				  window.alert('Email has been used');
				  window.history.back();
				  </script>";
		}
		
		$q = "INSERT INTO users VALUES ('$username', '$password', '$email', '$address', '$phone', 'member')";
		$r = mysqli_query($dbc, $q);
		if($r) {
			echo "<script>
				  window.alert('Successfully registered');
				  window.location.href = 'Login.php';
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
		<li style="float:right"><a>Login</a></li>
	</ul>
	<h2>REGISTER</h2>
	<div class="form">
		<form action="Register.php" method="post" onsubmit="return test_password(this)">
			<b>Username</b><br>
			<input type="text" name="username" autocomplete="off" required>
			<br>
			<br>
			<b>Password</b><br>
			<input type="password" name="password" id="password" autocomplete="off" required>
			<br>
			<br>
			<b>Confirm password</b><br>
			<input type="password" name="cpassword" id="cpassword" autocomplete="off" required>
			<br>
			<br>
			<b>Email</b><br>
			<input type="email" name="email" autocomplete="off" required>
			<br>
			<br>
			<b>Address</b><br>
			<input type="text" name="address" autocomplete="off" required>
			<br>
			<br>
			<b>Phone</b><br>
			<input type="number" name="phone" oninput="javascript: if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="11" required>
			<br>
			<br>
			<input type="submit" value="Sign me up!">
		</form>
	</div>
<script>
	function test_password(scope) {
		var password = document.getElementById("password").value;
		var cpassword = document.getElementById("cpassword").value;
		if(password != cpassword) {
			window.alert("Password and confirm password do not match");
			document.getElementById("password").value = "";
			document.getElementById("cpassword").value = "";
			console.log(scope);
			return false;
		}
	}
</script>
</body>      
</html>