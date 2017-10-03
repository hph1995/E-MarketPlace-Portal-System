<?php
	session_cache_limiter('private, must-revalidate');
	session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>E-Market Portal</title>
<link rel="stylesheet" type="text/css" href="css/mainmenu.css">
</head>

<body>
	<header>
		<h1>Log in</h1>
	</header>
	
	<div>
		<p><label for="username">Enter your Username</label>
			<input type="text" name="username" id="username" size="20" />
		</p>
	</div>
	
	<div>
		<p><label for="password">Enter your Password</label>
			<input type="text" name="password" id="password" size="20" />
		</p>
	</div>
	
</body>
</html>