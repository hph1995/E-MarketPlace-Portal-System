<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>e-MarketPlace Portal System</title>

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts for this template -->
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href='https://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>

    <!-- Custom styles for this template -->
    <link href="css/clean-blog.min.css" rel="stylesheet">

  </head>

  <body>
<?php 
	$accountID = mysql_query("SELECT * FROM tblaccount WHERE username = '".$_SESSION['account_login']."'");
			while ($row = mysql_fetch_array($accountID, MYSQL_ASSOC))
			{
				
				$id = $row['accountID'];
				$type = $row['accType'];
			}
	?>
  <!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
      <div class="container">
        <a class="navbar-brand" href="index.php">Deallo</a>
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          Menu
          <i class="fa fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
			<?php if(!isset($_SESSION['account_login']))
			{
			echo '<li class="nav-item">
              <a class="nav-link" href="index.php"></a>
		
            </li>
			
			<li class="nav-item">
          <form class="form-inline my-2 my-lg-0 mr-lg-2">
            <div class="input-group">
              <input class="form-control" type="text" placeholder="Search for...">
              <span class="input-group-btn">
                <button class="btn btn-warning" type="button">
                  <i class="fa fa-search"></i>
                </button>
              </span>
            </div>
          </form>
        </li>
            <li class="nav-item">
              <a class="nav-link" href="about.html">About</a>
            </li>
			
			<li class="nav-item">
              <a class="nav-link" href="#">Sell on Deallo</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="login.php">LogIn</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="register.php">SignUp</a>
            </li>';
			}
			else if(isset($_SESSION['account_login']) && $type == "ADMINISTRATOR")
			{
				echo '
				
        <li class="nav-item">
        <a class="nav-link" href="seller.php">Seller</a>
            </li>
        <li class="nav-item">
				<li class="nav-item">
				<a class="nav-link" href="customer.php">Customer</a>
            </li>
				<li class="nav-item">
				<a class="nav-link" href="staff.php">Staff</a>
            </li>
        <li class="nav-item">
        <a class="nav-link" href="category.php">Category</a>
				<li class="nav-item">
				<a class="nav-link" href="account_profile.php">'.$_SESSION['account_login'].'</a>
            </li>
				<li class="nav-item">
				<a class="nav-link" href="logout.php">logout</a>
            </li>';
			} else if(isset($_SESSION['account_login']) && $type == "CUSTOMER")
			{
				echo '
				<li class="nav-item">
          <form class="form-inline my-2 my-lg-0 mr-lg-2">
            <div class="input-group">
              <input class="form-control" type="text" placeholder="Search for...">
              <span class="input-group-btn">
                <button class="btn btn-warning" type="button">
                  <i class="fa fa-search"></i>
                </button>
              </span>
            </div>
          </form>
        </li>
        <li class="nav-item">
        <a class="nav-link" href="seller.php">Subscribe Seller</a>
            </li>
				<li class="nav-item">
        <a class="nav-link" href="seller_form.php">Apply a Seller</a>
            </li>
				<li class="nav-item">
				<a class="nav-link" href="account_profile.php">'.$_SESSION['account_login'].'</a>
            </li>
				<li class="nav-item">
				<a class="nav-link" href="logout.php">logout</a>
            </li>';
			} else if(isset($_SESSION['account_login']) && $type == "SELLER")
			{
				echo '
				<li class="nav-item">
          <form class="form-inline my-2 my-lg-0 mr-lg-2">
            <div class="input-group">
              <input class="form-control" type="text" placeholder="Search for...">
              <span class="input-group-btn">
                <button class="btn btn-warning" type="button">
                  <i class="fa fa-search"></i>
                </button>
              </span>
            </div>
          </form>
        </li>
		    <li class="nav-item">
				<a class="nav-link" href="product.php">Product</a>
        </li>
        <li class="nav-item">
        <a class="nav-link" href="stock_control.php">Stock Control</a>
        </li>
				<li class="nav-item">
				<a class="nav-link" href="account_profile.php">'.$_SESSION['account_login'].'</a>
            </li>
				<li class="nav-item">
				<a class="nav-link" href="logout.php">logout</a>
            </li>';
			
			} else if(isset($_SESSION['account_login']) && $type == "STAFF")
			{
				echo '
				
        <li class="nav-item">
        <a class="nav-link" href="seller.php">Seller</a>
            </li>
        <li class="nav-item">
				<li class="nav-item">
				<a class="nav-link" href="customer.php">Customer</a>
            </li>
				
        <li class="nav-item">
        <a class="nav-link" href="category.php">Category</a>
				<li class="nav-item">
				<a class="nav-link" href="account_profile.php">'.$_SESSION['account_login'].'</a>
            </li>
				<li class="nav-item">
				<a class="nav-link" href="logout.php">logout</a>
            </li>';
			} 
			else
			{
				echo '<li class="nav-item">
              <a class="nav-link" href="index.php"></a>
			<li class="nav-item">
          <form class="form-inline my-2 my-lg-0 mr-lg-2">
            <div class="input-group">
              <input class="form-control" type="text" placeholder="Search for...">
              <span class="input-group-btn">
                <button class="btn btn-warning" type="button">
                  <i class="fa fa-search"></i>
                </button>
              </span>
            </div>
          </form>
        </li>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="about.html">About</a>
            </li>
			<li class="nav-item">
              <a class="nav-link" href="#">Sell on Deallo</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="login.php">LogIn</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="register.php">SignUp</a>
            </li>';
			}
			?>
          </ul>
        </div>
      </div>
    </nav>
	
  </body>

</html>