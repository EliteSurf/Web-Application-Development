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
	input[type=submit], input[type=button] {
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
		$user_type = test_input($_POST["user_type"]);
		$vpassword = $vuser_type = false;
		
		$q1 = "SELECT username FROM users WHERE username='$username'";
		$r1 = mysqli_query($dbc, $q1);
		if(!$r1) {
			die(mysqli_error($dbc));
		}
		
		$q2 = "SELECT password FROM users WHERE username='$username'";
		$r2 = mysqli_query($dbc, $q2);
		if(!$r2) {
			die(mysqli_error($dbc));
		}
		while($row = mysqli_fetch_array($r2)) {
			if($row['password'] == $password) {
				$vpassword = true;
			}
		}
		
		$q3 = "SELECT user_type FROM users WHERE username='$username'";
		$r3 = mysqli_query($dbc, $q3);
		if(!$r3) {
			die(mysqli_error($dbc));
		}
		while($row = mysqli_fetch_array($r3)) {
			if($row['user_type'] == $user_type) {
				$vuser_type = true;
			}
		}
		
		if(mysqli_num_rows($r1) > 0 && $vpassword && $vuser_type) {
			$_SESSION['username'] = $username;
			$_SESSION['user_type'] = $user_type;
			echo "<script>
				  window.location.href = 'Home.php';
				  </script>";
		}
		else {
			echo "<script>
				  window.alert('Username and password do not match');
				  window.history.back();
				  </script>";
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
	<h2>LOGIN</h2>
	<div class="form">
		<form action="Login.php" method="post">
			<b>Username</b><br>
			<input type="text" name="username" autocomplete="off" required>
			<br>
			<br>
			<b>Password</b><br>
			<input type="password" name="password" id="password" autocomplete="off" required>
			<br>
			<br>
			<b>Log in as</b><br>
			<input type="radio" name="user_type" value="member" checked> Member	
			<input type="radio" name="user_type" value="admin"> Admin
			<br>
			<br>
			<input type="submit" value="Log in">
			<a href="Register.php"><input type="button" value="Create an account"></a>
		</form>
	</div>
</body>      
</html>