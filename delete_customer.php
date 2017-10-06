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
              <h1>Delete Account</h1>
              <span class="subheading">Delete Staff Account</span>
            </div>
          </div>
        </div>
      </div>
    </header>
<?php
	if($_POST['register_btn'])
	{
		$username_SQL = "SELECT * FROM tblaccount WHERE username ='".$_POST['username']."' AND accType='CUSTOMER'"; 
		$username_SQL_result = mysql_query($username_SQL,$dbLink);
		if(!mysql_num_rows($username_SQL_result) > 0)
		{
			echo "<script>alert('Username not exists !');window.history.back();</script>";
		}
		else
		{
		
		// select last accountID from tblaccount
		$accountID = mysql_query("SELECT accountID FROM tblaccount WHERE username = '".$_POST['username']."'");
		while ($row = mysql_fetch_array($accountID, MYSQL_ASSOC))
		{
			$id = $row['accountID'];
		}
		$delete_account = "DELETE FROM tblaccount WHERE accountID='$id'";
		$delete_personnel = "DELETE FROM tblpersonnel WHERE accountID='$id'";
			$delete_account_result = mysql_query($delete_account,$dbLink);
			$delete_personnel_result = mysql_query($delete_personnel,$dbLink);
			
			if($delete_account_result && $delete_account_result)
			{
				echo "<script>alert('Customer deleted!');location = 'staff.php';</script>";
			}
			else
			{
				echo "<script>alert('Failed to delete account! Please inform our staff.');</script>";
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
          <p>Please fill in all information to register your account</p>
          
          <form name="sentMessage" id="contactForm" method="post">
            <div class="control-group">
              <div class="form-group floating-label-form-group controls">
                <label>Enter your Username</label>
                <input type="text" class="form-control" placeholder="Username" id="username" name="username" required data-validation-required-message="Please enter your username."  pattern="[A-Za-z @.1-90]+" title="Please use numbers or characters.">
                <p class="help-block text-danger"></p>
              </div>
            </div>
            <br>
			
            <div id=""></div>
            <div class="form-group">
              <input type="submit" class="btn btn-secondary" id="register_btn" name = "register_btn" value="Delete"/>
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
