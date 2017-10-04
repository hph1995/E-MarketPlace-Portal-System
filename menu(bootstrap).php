<?php
	session_cache_limiter('private, must-revalidate');
	session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>E-Market Portal</title>
<link rel="stylesheet" href="css/bootstrap.min.css">
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<link rel="stylesheet" type="text/css" href="css/menuBootstrap.css">
</head>

    <?php 
        include('dbEMarketplace.php');
    ?>
<body>
    <nav class="navbar navbar-fixed-top">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand" href="#">E-Market Portal</a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                    <li class="active dropdown">
                        <a href="#" class="dropdown-toggle " data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Account Mgmt <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li class=" dropdown">
                                <a href="#" class="dropdown-toggle " data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Add</a>
                            </li>
                            <li><a href="#">Edit</a></li>
                        </ul>
                    </li>
                    <li class=" dropdown">
                    	<a href="#" class="dropdown-toggle " data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Categories <span class="caret"></span>
                    	</a>
                        <ul class="dropdown-menu">
                            <li><a href="#">Add Product</a></li>
                            <li><a href="#">Edit Product</a></li>
                        </ul>
                    </li>
                    <li class=" dropdown">
                    	<a href="#" class="dropdown-toggle active" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Cart <span class="caret"></span>
                    	</a>
                        <ul class="dropdown-menu">
                            <li><a href="#">View Staff</a></li>
                        </ul>
                    </li>
                    <li class=" down">
                    	<a href="#" class="dropdown-toggle active" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Sales Record <span class="caret"></span>
                    	</a>
                        <ul class="dropdown-menu">
                            <li><a href="#">Change Time Entry</a></li>
                            <li><a href="#">Report</a></li>
                        </ul>
                    </li>
                    <li class=" down">
                    	<a href="#" class="dropdown-toggle active" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Redeem Point <span class="caret"></span>
                    	</a>
                        <ul class="dropdown-menu">
                            <li><a href="#">Change Time Entry</a></li>
                            <li><a href="#">Report</a></li>
                        </ul>
                    </li>
                    <li class=" down">
                    	<a href="#" class="dropdown-toggle active" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Rate Product <span class="caret"></span>
                    	</a>
                        <ul class="dropdown-menu">
                            <li><a href="#">Change Time Entry</a></li>
                            <li><a href="#">Report</a></li>
                        </ul>
                    </li>
                    <li class=" down">
                    	<a href="#" class="dropdown-toggle active" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Promotion <span class="caret"></span>
                    	</a>
                        <ul class="dropdown-menu">
                            <li><a href="#">Change Time Entry</a></li>
                            <li><a href="#">Report</a></li>
                        </ul>
                    </li>
                    <li class=" down">
                    	<a href="#" class="dropdown-toggle active" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Subscribe <span class="caret"></span>
                    	</a>
                        <ul class="dropdown-menu">
                            <li><a href="#">Change Time Entry</a></li>
                            <li><a href="#">Report</a></li>
                        </ul>
                    </li>
                    <li class=" down">
                    	<a href="#" class="dropdown-toggle active" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Payment <span class="caret"></span>
                    	</a>
                        <ul class="dropdown-menu">
                            <li><a href="#">Change Time Entry</a></li>
                            <li><a href="#">Report</a></li>
                        </ul>
                    </li>
                    <li class=" down">
                    	<a href="#" class="dropdown-toggle active" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Report <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="#">Change Time Entry</a></li>
                            <li><a href="#">Report</a></li>
                        </ul>
                    </li>
                </ul>
                <ul class="nav navbar-nav pull-right">
                    <li class=" dropdown">
                    	<a href="#" class="dropdown-toggle active" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Signed in as  <span class="caret"></span>
                    	</a>
                        <ul class="dropdown-menu">
                            <li><a href="#">Change Password</a></li>
                            <li><a href="#">My Profile</a></li>
                        </ul>
                    </li>
                    <li class=""><a href="#">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>
</body>
</html>