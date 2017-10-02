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
	<nav>
		<ul>
			<li><a href="#">Home</a></li>
			<li><a href="#">Account Mgmt</a>
				<ul>
					<li><a href="#">Add</a></li>
					<li><a href="#">Edit</a></li>
				</ul>
			</li>
			<li><a href="#">Categories</a>
				<ul>
					<li><a href="#">Add</a></li>
					<li><a href="#">Edit</a></li>
				</ul>
			</li>
			<li><a href="#">Cart</a>
				<ul>
					<li><a href="#">Add</a></li>
					<li><a href="#">View</a></li>
				</ul>
			</li>
			<li><a href="#">Sales Record</a>
				<ul>
					<li><a href="#">Add</a></li>
					<li><a href="#">Edit</a></li>
				</ul>
			</li>
			<li><a href="#">Sales Record</a>
				<ul>
					<li><a href="#">Add</a></li>
					<li><a href="#">Edit</a></li>
				</ul>
			</li>
			<li><a href="#">Redeem Point</a>
				<ul>
					<li><a href="#">Add</a></li>
					<li><a href="#">Edit</a></li>
				</ul>
			</li>
			<li><a href="#">Rate Produts</a>
				<ul>
					<li><a href="#">Add</a></li>
					<li><a href="#">Edit</a></li>
				</ul>
			</li>
			<li><a href="#">Promotion</a>
				<ul>
					<li><a href="#">Add</a></li>
					<li><a href="#">Edit</a></li>
				</ul>
			</li>
			<li><a href="#">Subscribe</a>
				<ul>
					<li><a href="#">Add</a></li>
					<li><a href="#">Edit</a></li>
				</ul>
			</li>
			<li><a href="#">Payment</a>
				<ul>
					<li><a href="#">Add</a></li>
					<li><a href="#">Edit</a></li>
				</ul>
			</li>
			<li><a href="#">Report</a>
				<ul>
					<li><a href="report.php">Sales Report</a></li>
					<li><a href="report.php?mode=consultation">Consultation Fee Report</a></li>
					<li><a href="report.php?mode=drug">Drug Sales Report</a></li>
					<li><a href="report.php?mode=inventory">Inventory Report</a></li>
				</ul>
			</li>
			<li><a href="index.php?id=logout">Logout</a></li>
		</ul>
	</nav>
</body>
</html>