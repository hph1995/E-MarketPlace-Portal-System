<?php
include('dbEMarketplace.php'); //include database.
session_start();
?>
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

    <!-- Navigation -->
    <?php include('navbar.php'); ?>

    <!-- Page Header -->
    <header class="masthead" style="background-image: url('img/home-bg.jpg')">
      <div class="container">
        <div class="row">
          <div class="col-lg-8 col-md-10 mx-auto">
            <div class="site-heading">
              <h1>Product Management</h1>
              <span class="subheading"></span>
            </div>
          </div>
        </div>
      </div>
    </header>
<?php
	if($_POST['register_btn'])
	{
		$username_SQL = "SELECT * FROM tblaccount WHERE username ='".$_POST['username']."'"; 
		$username_SQL_result = mysql_query($username_SQL,$dbLink);
		if(mysql_num_rows($username_SQL_result) > 0)
		{
			$flag = 1;
			echo "<script>alert('Username exists !');window.history.back();</script>";
		}
		else if($_POST['password'] != $_POST['c_password'])
		{
			echo "<script>alert('Confirm password is not correct!'); window.history.back();</script>";
		}
		else
		{
		// insert username and password into tblaccount.
			$account_SQL = "INSERT INTO tblaccount(username, password, accType, status)
			VALUE('". strtoupper(trim($_POST['username']))."',
			'". strtoupper(md5($_POST['password']))."', 'STAFF','ACTIVE')";
		
		// select last accountID from tblaccount
		$accountID = mysql_query("SELECT accountID FROM tblaccount ORDER BY accountID DESC LIMIT 1");
		while ($row = mysql_fetch_array($accountID, MYSQL_ASSOC))
		{
			$id = $row['accountID'] + 1;
		}
	
		
			// insert rest of the data into tblpersonal
			$personal_SQL = "INSERT INTO tblpersonnel(accountID, name, NRIC, email, addr, city, state, country, contactNum)
			VALUE('".$id."',
				  '". strtoupper(trim($_POST['full_name']))."',
				  '". strtoupper(trim($_POST['ic']))."',
				  '". strtoupper(trim($_POST['email']))."',
				  '". strtoupper(trim($_POST['address']))."',
				  '". strtoupper(trim($_POST['city']))."', 
				  '". strtoupper(trim($_POST['state']))."', 
				  '". strtoupper(trim($_POST['country']))."', 
				  '". strtoupper(trim($_POST['phone_num']))."')";
		
			$account_SQL_result = mysql_query($account_SQL,$dbLink);
			$personal_SQL_result = mysql_query($personal_SQL,$dbLink);
			
			if($account_SQL_result && $personal_SQL_result)
			{
				echo "<script>alert('Staff Added!');location = 'login.php';</script>";
			}
			else
			{
				echo "<script>alert('Failed to register account! Please inform our staff.'); location = 'login.php';</script>";
			}
		}
	}
	else
	{
?>
    <!-- Main Content -->
    <div class="container">
      <div class="row">
        <div class="col-lg-8 col-md-10 mx-auto">
		<p>Please select a operation for product</p>
		<div class="dropdown">
  <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Product Management
  <span class="caret"></span></button>
  <ul class="dropdown-menu">
    <li><a href="product.php">Add</a></li>
    <li><a href="product.php?mode=view">Edit</a></li>
    <li><a href="product.php?mode=view">Delete</a></li>
  </ul>
</div>
         
          </form>
        </div>
      </div>
    </div>
	<?php } ?>
    <hr>

    <!-- Footer -->
    <?php include('footer.php');?>

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/popper/popper.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Contact Form JavaScript -->

	
    <!-- Custom scripts for this template -->
    <script src="js/clean-blog.min.js"></script>

  </body>

</html>
