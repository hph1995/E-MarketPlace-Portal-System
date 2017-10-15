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
	<?php 
	$accountID = mysql_query("SELECT accountID FROM tblaccount WHERE username = '".$_SESSION['account_login']."'");
			while ($row = mysql_fetch_array($accountID, MYSQL_ASSOC))
			{
				
				$id = $row['accountID'];
			}
			$personnelID = mysql_query("SELECT * FROM tblpersonnel WHERE accountID = $id");
			while ($row = mysql_fetch_array($personnelID, MYSQL_ASSOC))
			{
				$id = $row['personnelID'];
				$name = $row['name'];
				$ic = $row['NRIC'];
				$phone = $row['contactNum'];
			}
	?>
    <!-- Navigation -->
    <?php include('navbar.php'); ?>
	
    <!-- Page Header -->
    <header class="masthead" style="background-image: url('img/home-bg.jpg')">
      <div class="container">
        <div class="row">
          <div class="col-lg-8 col-md-10 mx-auto">
            <div class="site-heading">
              <h1>Staff Management</h1>
              <span class="subheading"></span>
            </div>
          </div>
        </div>
      </div>
    </header>
<?php
	if($_POST['register_btn'])
	{
		$id = $id - 1;
			$sellerID = mysql_query("SELECT * FROM tblseller WHERE personnelID = '$id'");
			if(mysql_num_rows($sellerID) > 0)
			{
				echo "<script>alert('You have applied seller. Please wait for staff accept!');location = 'seller_form.php';</script>";
			}
			else{
				
			$seller_SQL = "INSERT INTO tblseller(personnelID, bankAccount, status)
			VALUE($id,'". strtoupper(trim($_POST['bank_account']))."','INACTIVE')";
		
			$seller_SQL_result = mysql_query($seller_SQL,$dbLink);
			
			if($seller_SQL_result)
			{
				echo "<script>alert('Seller Applied!');location = 'seller.php';</script>";
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

          <p>Please fill in real information to register seller account</p>
          
          <form name="sentMessage" id="contactForm" method="post">
            <div class="control-group">
              <div class="form-group floating-label-form-group controls">
                <label>Username</label>
                <input type="text" class="form-control" placeholder="<?php echo $_SESSION[account_login];?>" id="username" name="username" disabled>
                <p class="help-block text-danger"></p>
              </div>
            </div>

			<div class="control-group">
              <div class="form-group floating-label-form-group controls">
                <label>Enter your Full Name</label>
                <input type="text" class="form-control" placeholder="<?php echo $name;?>" id="full_name" name="full_name" disabled>
                <p class="help-block text-danger"></p>
              </div>
            </div>
			<div class="control-group">
              <div class="form-group floating-label-form-group controls">
                <label>Enter your NRIC</label>
                <input type="text" class="form-control" placeholder="<?php echo $ic;?>" id="ic" name="ic" disabled>
                <p class="help-block text-danger"></p>
              </div>
            </div>
			<div class="control-group">
              <div class="form-group floating-label-form-group controls">
                <label>Enter your Phone Number (exclude -)</label>
                <input type="tel" class="form-control" placeholder="<?php echo $phone;?>" id="phone_num" name="phone_num" disabled>
                <p class="help-block text-danger"></p>
              </div>
            </div>
			<div class="control-group">
              <div class="form-group floating-label-form-group controls">
                <label>Enter your Bank Account</label>
                <input type="tel" class="form-control" placeholder="Bank Account" id="bank_account" name="bank_account" required data-validation-required-message="Please enter your username."  pattern="[1-90-]+" title="Please use numbers.">
                <p class="help-block text-danger"></p>
              </div>
            </div>
            <br>
			
            <div id=""></div>
            <div class="form-group">
              <input type="submit" class="btn btn-secondary" id="register_btn" name = "register_btn" value="Register"/>
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
