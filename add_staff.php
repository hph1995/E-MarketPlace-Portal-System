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
     <header class="masthead" style="background:#F54700; max-height:80px">
      <div class="container">
        <div class="row">
          <div class="col-lg-8 col-md-10 mx-auto">
            <div class="site-heading">
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
		<div class="dropdown">
  <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Staff Management
  <span class="caret"></span></button>
  <ul class="dropdown-menu">
    <li><a href="add_staff.php">Add</a></li>
    <li><a href="edit_staff.php">Edit</a></li>
    <li><a href="delete_staff">Delete</a></li>
  </ul>
</div>
          <p>Please fill in all information to register your account</p>
          
          <form name="sentMessage" id="contactForm" method="post">
            <div class="control-group">
              <div class="form-group floating-label-form-group controls">
                <label>Enter your Username</label>
                <input type="text" class="form-control" placeholder="Username" id="username" name="username" required data-validation-required-message="Please enter your username."  pattern="[A-Za-z @.1-90]+" title="Please use numbers or characters.">
                <p class="help-block text-danger"></p>
              </div>
            </div>
            <div class="control-group">
              <div class="form-group floating-label-form-group controls">
                <label>Enter your password</label>
                <input type="password" class="form-control" placeholder="Password" id="password" name="password" required data-validation-required-message="Please enter your password." minlength="6">
                <p class="help-block text-danger"></p>
              </div>
            </div>
			<div class="control-group">
              <div class="form-group floating-label-form-group controls">
                <label>Enter your password</label>
                <input type="password" class="form-control" placeholder="Confirm Password" id="c_password" name="c_password" required data-validation-required-message="Please enter your password." minlength="6" title="Short passwords are easy to guess. Try one with at least 8 characters">
                <p class="help-block text-danger"></p>
              </div>
            </div>
			<div class="control-group">
              <div class="form-group floating-label-form-group controls">
                <label>Enter your Full Name</label>
                <input type="text" class="form-control" placeholder="Full Name" id="full_name" name="full_name" required data-validation-required-message="Please enter your name." pattern = "[A-Za-z ]+" title="Please use characters as your name">
                <p class="help-block text-danger"></p>
              </div>
            </div>
			<div class="control-group">
              <div class="form-group floating-label-form-group controls">
                <label>Enter your NRIC</label>
                <input type="text" class="form-control" placeholder="IRIC" id="ic" name="ic" required data-validation-required-message="Please enter your NRIC number." pattern = "[1-90]{6}-[1-9]{2}-[1-90]{4}" title="Please use xxxxxx-xx-xxxx as your NRIC format">
                <p class="help-block text-danger"></p>
              </div>
            </div>
			<div class="control-group">
              <div class="form-group floating-label-form-group controls">
                <label>Enter your Email</label>
                <input type="email" class="form-control" placeholder="Email" id="email" name="email" required data-validation-required-message="Please enter your email." pattern = "[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" title="Please use xxxx@yourdomain.com as email format.">
                <p class="help-block text-danger"></p>
              </div>
            </div>
			<div class="control-group">
              <div class="form-group floating-label-form-group controls">
                <label>Enter your Home Address</label>
                <input type="text" class="form-control" placeholder="Home Address" id="address" name="address" required data-validation-required-message="Please enter your home address.">
                <p class="help-block text-danger"></p>
              </div>
            </div>
			<div class="control-group">
              <div class="form-group floating-label-form-group controls">
                <label>Enter your Country</label>
                <input type="text" class="form-control" placeholder="Country" id="country" name="country" required data-validation-required-message="Please enter your country." pattern="[A-Za-z ]+" title="Please use your country name.">
                <p class="help-block text-danger"></p>
              </div>
            </div>
			<div class="control-group">
              <div class="form-group floating-label-form-group controls">
                <label>Enter your State</label>
                <input type="text" class="form-control" placeholder="State" id="state" name="state" required data-validation-required-message="Please enter your state." pattern="[A-Za-z ]+" title="Please use your state name">
                <p class="help-block text-danger"></p>
              </div>
            </div>
			<div class="control-group">
              <div class="form-group floating-label-form-group controls">
                <label>Enter your City</label>
                <input type="text" class="form-control" placeholder="City" id="city" name="city" required data-validation-required-message="Please enter your city." pattern="[A-Za-z ]+" title="Please use your city name">
                <p class="help-block text-danger"></p>
              </div>
            </div>
			<div class="control-group">
              <div class="form-group floating-label-form-group controls">
                <label>Enter your Phone Number (exclude -)</label>
                <input type="tel" class="form-control" placeholder="Phone Number" id="phone_num" name="phone_num" required data-validation-required-message="Please enter your phone number." minlength="10" maxlength="11" pattern="[1-90]+" title="Please use a correct phone number exclude -.">
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
