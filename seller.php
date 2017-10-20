<?php
  session_cache_limiter('private, must-revalidate');
  session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="description" content="">
<meta name="author" content="">
<title>E-Market Portal</title>
<!-- Bootstrap core CSS -->
<link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

<!-- Custom fonts for this template -->
<link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
<link href='https://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
<link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>

<!-- Custom styles for this template -->
<link href="css/clean-blog.min.css" rel="stylesheet">
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</head>
    <?php 
        include('dbEMarketplace.php');
    ?>
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
  	  $sellerID = mysql_query("SELECT * FROM tblpersonnel RIGHT JOIN tblseller ON tblpersonnel.personnelID = tblseller.personnelID ORDER BY tblseller.personnelID");
  		$count = 1;
      while ($row = mysql_fetch_array($sellerID, MYSQL_ASSOC))
		  {
  			$string = "btn_change".$count;
  			if($_POST["btn_change$count"])
  			{
  				$update_status = mysql_query("UPDATE tblseller SET 
  			status = 'ACTIVE' WHERE sellerID = '".$row['sellerID']."'");
				$update_account_status = mysql_query("UPDATE tblaccount SET 
  			accType = 'SELLER' WHERE accountID = '".$row['accountID']."'");
  			}
  			$count += 1;
  		}
      if($_POST['btnBackForward'])
      {
        echo '<script>location="index.php";</script>';
      }
      else
      {
        if($_SESSION['account_type'] == "ADMINISTRATOR" || $_SESSION['account_type'] == "STAFF")
        {
      ?>
          <form id="formProduct" name="formProduct" method="post" style="margin-top: 100px;" action="">
            <div class="container">
              <div style="margin: 10px;">
                  <h2 style="text-align: center;">Seller List</h2><br>       
                  <table id="productTable" class="table table-hover" style="width: 100%">
                      <thead>
                          <tr>
                            <th>No</th>
                            <th>Seller Name</th>
                					  <th>IC</th>
                					  <th>Email</th>
                            <th>Bank Account</th>
                            <th>Status</th>
      					             <th>Accept Seller</th>
                          </tr>
                      </thead>
                      <tbody>
                        <?php 
      				  $sellerID = mysql_query("SELECT * FROM tblpersonnel RIGHT JOIN tblseller ON tblpersonnel.personnelID = tblseller.personnelID ORDER BY tblseller.personnelID");
      					$count = 0;
                          if(mysql_num_rows($sellerID) > 0)
                          {
                            while ($row = mysql_fetch_array($sellerID, MYSQL_ASSOC))
      					  {
      						 $count += 1;
      						  $id = $row['personnelID'];
      						  echo "<tr>";
      						  echo "<td>".$row['sellerID']."</td>";
      						  echo "<td>".$row['name']."</td>";
      						   echo "<td>".$row['NRIC']."</td>";
      						  echo "<td>".$row['email']."</td>";
      						  echo "<td>".$row['bankAccount']."</td>";
      						  echo "<td>".$row['status']."</td>";
      						  echo "<td><button type=\"submit\" class=\"btn btn-danger\" name=\"btn_change$count\" id=\"btn_change\" value=\"submit\">Accept</button></td>";
      						  echo "</tr>";
      					
      						  
      					  }
    					  
                        }
                        else
                        {
                          echo "<tr><td colspan='7' align='center'>There are not seller yet.</td></tr>";
                        }
                      ?>
                      <tr><td colspan="7" align="center"><button type="submit" class="btn btn-danger" name="btnBackForward" id="btnBackForward" value="submit">Back</button></td></tr>
                    </tbody>
                </table>
                <br>
            </div>
            </div>
          </form>
      <?php
        }
        elseif ($_SESSION['account_type'] == "CUSTOMER") {
          $getSeller = "SELECT * FROM tblaccount WHERE accType = 'SELLER'";
          $checkGetSeller = mysql_query($getSeller, $dbLink);
      ?>
    <form id="formProduct" name="formProduct" method="post" style="margin-top: 100px;" action="">
      <div class="container">
        <div style="margin: 10px;">
            <h2 style="text-align: center;">Seller List</h2><br>       
            <table id="productTable" class="table table-hover" style="width: 100%">
                <thead>
                    <tr>
                      <th>No</th>
                      <th>Seller Name</th>
                      <th>Product</th>
                      <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                  <?php 
                    if(mysql_num_rows($checkGetSeller) > 0)
                    {
                      for($i = 0; $i < mysql_num_rows($checkGetSeller); $i++)
                      {
                        $soldProducts = "";
                        $accID = mysql_fetch_array($checkGetSeller);
                        $getSellerInfo = "SELECT * FROM tblpersonnel WHERE accountID = ".$accID['accountID']."";
                        $checkGetSellerInfo = mysql_query($getSellerInfo, $dbLink);
                        if($checkGetSellerInfo) $sellerInfo = mysql_fetch_array($checkGetSellerInfo);
                        echo '<tr>';
                        echo '<td>'.($i+1).'</td>';
                        echo '<td>'.$sellerInfo['name'].'</td>';
                        echo '<input type="hidden" id="txtsellername'.($i+1).'" name="txtsellername'.($i+1).'" value="'.$sellerInfo['name'].'"/>';
                        $getSoldProducts = "SELECT * FROM tblproduct WHERE sellerID = '".$accID['accountID']."' AND status = 'ACTIVE'";
                        $checkGetSoldProducts = mysql_query($getSoldProducts, $dbLink);
                        if(mysql_num_rows($checkGetSoldProducts) > 1)
                        {
                          for($i = 0; $i < mysql_num_rows($checkGetSoldProducts); $i++)
                          {
                            $getResult = mysql_fetch_array($checkGetSoldProducts);
                            $soldProducts.=$getResult['productName'] + " ";
                          }
                        }
                        else
                        {
                          $getResult = mysql_fetch_array($checkGetSoldProducts);
                          $soldProducts.=$getResult['productName'];
                        }
                        echo '<td>'.ucwords(strtolower($soldProducts)).'</td>';
                        echo '<td><input type="button" class="btn btn-primary" name="btnSubscribe'.($i+1).'" onClick="location=\'sendingmail.php?sID='.$accID['accountID'].'\';" value="Subscribe"/></td>';
                        echo '</tr>';
                      }
                    }
                    else
                    {
                      echo "<tr><td colspan='4' align='center'>There are not seller yet.</td></tr>";
                    }
                  ?>
                  <tr><td colspan="6" align="center"><button type="submit" class="btn btn-danger" name="btnBackForward" id="btnBackForward" value="submit">Back</button></td></tr>
                </tbody>
            </table>
            <br>
        </div>
      </div>
    </form>
    <?php
        }
      } 
    ?>
    <hr>

    <!-- Footer -->
    <?php
    include('footer.php');
    ?>

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/popper/popper.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Contact Form JavaScript -->


    <!-- Custom scripts for this template -->
    <script src="js/clean-blog.min.js"></script>
</body>
</html>