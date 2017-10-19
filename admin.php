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
	if($_POST['login_btn'])
	{
		//check whether account is correct or not
		$account_SQL = "SELECT * FROM tblaccount WHERE username = '".strtoupper(trim($_POST['username']))."' AND password = '".strtoupper(md5($_POST['password']))."' AND status ='ACTIVE'";
		$account_SQL_result = mysql_query($account_SQL,$dbLink);
		while ($row = mysql_fetch_array($account_SQL_result, MYSQL_ASSOC))
		{
    		$account_id =  $row['accountId'];
			$acc_type = $row['accType'];
		}
		if(mysql_num_rows($account_SQL_result) > 0)
		{
			
			if($acc_type == 'CUSTOMER')
			{
				echo "<script>alert('Correct. you are customer. GG LAU YI CHENG HAHAHAHA');location = 'login.php';</script>";
			}
			else if($acc_type == 'ADMINISTRATOR')
			{
				echo "<script>alert('Correct. you are admin');location = 'admin.php';</script>";
			}
		}
		else
		{
			echo "<script>alert('Account or password is not correct');location = 'login.php';</script>";
		}
	}
	else
	{
?>
    <!-- Main Content -->
    <div class="container">
      <div class="row">
        <div class="col-lg-8 col-md-10 mx-auto">

          <form name="sentMessage" id="contactForm" method="post">
            <div class="control-group">
              <div class="form-group floating-label-form-group controls">
         
            </div>
            <br>
            <div id=""></div>
           
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

