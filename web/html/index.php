<?php

	include_once( './functions/all.php' );

	if( is_loged())
		mov_to_home();

?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<link rel="stylesheet" href="code/style.css" />
		<script type="text/javascript" src="code/script.js"></script>
	</head>
	<body>
		<form action="login.php", method="post">
			<input type="email" name="email" placeholder="E-mail" />
			<input type="password" name="password" placeholder="Password" />
			<input type="submit" value="Login" />
		</form>
		<form action="register.php" method="post">
			<input type="email" name="email" placeholder="E-mail" />
			<input type="password" name="password" placeholder="Password" />
			<input type="password" name="password2" placeholder="Repeat password" />
			<input type="submit" value="Register" />
		</form>
		<form action="activate.php" method="post">
			<input type="text" name="token" placeholder="Token" />
			<input type="submit" value="Active account" />
		</form>
		<form action="restore.php" method="post">
			<input type="email" name="email" placeholder="E-mail" />
			<input type="submit" value="Restore password" />
		</form>
		<form action="change.php" method="post">
			<input type="text" name="token" placeholder="Token" />
			<input type="password" name="password" placeholder="Password" />
			<input type="password" name="password2" placeholder="Repear password" />
			<input type="submit" value="Change password" />
		</form>
		<div style="color: red;">
<?php
	if( isset( $_GET['err'] ))
		print( $_GET['err'] );
?>
		</div>
	</body>
</html>