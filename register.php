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
		<h1>Registration</h1>
	</header>
	
	<div>
		<p><label for="username">Enter your Username</label>
			<input type="text" name="username" id="username" size="20" />
		</p>
	</div>
	
	<div>
		<p><label for="fullname">Enter your Full Name</label>
			<input type="text" name="fullname" id="fullname" size="20" />
		</p>
	</div>
	
	<div>
		<p><label for="dob">Enter your Date of Birth</label>
			<input type="text" name="dob" id="dob" size="20" />
		</p>
	</div>

	<div>
		<p><label for="gender">Enter your Gender</label>
			<input type="text" name="gender" id="gender" size="20" />
		</p>
	</div>
	
	<div>
		<p><label for="address">Enter your Address</label>
			<input type="text" name="address" id="address" size="20" />
		</p>
	</div>
	
	<div>
		<p><label for="postcode">Enter your PostCode</label>
			<input type="text" name="postcode" id="postcode" size="20" />
		</p>
	</div>
	
	<div>
		<p><label for="city">Enter your City</label>
			<input type="text" name="City" id="city" size="20" />
		</p>
	</div>
	
	<div>
		<p><label for="state">Enter your State</label>
			<input type="text" name="state" id="state" size="20" />
		</p>
	</div>
	
	<div>
		<p><label for="country">Enter your Country</label>
			<input type="text" name="country" id="country" size="20" />
		</p>
	</div>
	
	<div>
		<p><label for="telno">Enter your Contact Number</label>
			<input type="text" name="telno" id="telno" size="20" />
		</p>
	</div>
	
	<div>
		<p><label for="email">Enter your Email Address</label>
			<input type="text" name="email" id="email" size="20" />
		</p>
	</div>

	<div>
		<p><label for="nric">Enter your NRIC</label>
			<input type="text" name="nric" id="nric" size="20" />
		</p>
	</div>
	
	<div>
		<p><label for="acctype">Register as</label>
			<input type="text" name="acctype" id="acctype" size="20" />
		</p>
	</div>

	<div>
		<p><label for="password">Enter your Password</label>
			<input type="text" name="password" id="password" size="20" />
		</p>
	</div>
	
	<div>
		<p><label for="password2">Confirm your Password</label>
			<input type="text" name="password2" id="password2" size="20" />
		</p>
	</div>
</body>
</html>