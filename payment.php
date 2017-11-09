<?php
  session_cache_limiter('private, must-revalidate');
  session_start();
  include('dbEMarketplace.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
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
<body>
    <!-- Navigation -->
    <?php include('navbar.php'); ?>

    <!-- Page Header -->
     <header class="masthead" style="background:#F54700; max-height:80px">
      
        <div class="row">
          <div class="">
            <div class="site-heading">
            </div>
          </div>
        </div>
      </div>
    </header>
	<?php
	$pro_name = array();
	$quantity = array();
	$pro_id = array();
	$check1 = 0;
	$check2 = 0;
		$getCartList = "SELECT * FROM tblcart NATURAL JOIN tblpersonnel WHERE accountID = '".$_SESSION['account_id']."' AND status = 'ACTIVE'";
            $checkGetCartList = mysql_query($getCartList, $dbLink);
            for($i = 0; $i < mysql_num_rows($checkGetCartList); $i++)
            {
				$cartDetails = mysql_fetch_array($checkGetCartList);
				$name = $cartDetails['name'];
				$ic = $cartDetails['NRIC'];
				$email = $cartDetails['email'];
				$addr = $cartDetails['addr'];
				$contactNum = $cartDetails['contactNum'];
				$check1 ++;
			}
		$product = "SELECT * FROM tblcart NATURAL JOIN tblproduct WHERE accountID = '".$_SESSION['account_id']."' AND status = 'ACTIVE'";
		$checkGetCartList = mysql_query($product, $dbLink);
	for($i = 0; $i < mysql_num_rows($checkGetCartList); $i++)
            {
				$cartDetails = mysql_fetch_array($checkGetCartList);
				$pro_name[$check2] = $cartDetails['productName'];
				$quantity[$check2] = $cartDetails['quantity'];
				$proID = "SELECT * FROM tblsellingprice  WHERE productID = '".$cartDetails['productID']."' AND status = 'ACTIVE'";
				$admin_SQL_result = mysql_query($proID);
				while ($row = mysql_fetch_array($admin_SQL_result, MYSQL_ASSOC))
				{
					$pro_id[$check2] = $row['sellingPrice'];
				}
				$check2 ++;
			}
  
            if(isset($_POST['btn_pay']))
			{
				for($i=0; $i<count($pro_name);$i++)
				{
					if($i != count($pro_name)-1)
					{
						$pro_name1 .= $pro_name[$i].",";
					}
					else
					{
						$pro_name1 .= $pro_name[$i];
					}
				}
				for($i=0; $i<count($quantity);$i++)
				{
					if($i != count($quantity)-1)
					{
						$quantity1 .= $quantity[$i].",";
					}
					else
					{
						$quantity1 .= $quantity[$i];
					}
				}
				for($i=0; $i<count($pro_id);$i++)
				{
					$total += ($quantity[$i] * $pro_id[$i]);
					if($i != count($pro_id)-1)
					{
						$pro_id1 .= $pro_id[$i].",";
					}
					else
					{
						$pro_id1 .= $pro_id[$i];
					}
				}
				date_default_timezone_set("Asia/Kuala_Lumpur");
				$date = date("Y-m-d");
				$add_payment = "INSERT INTO tblpayment (itemName, qty, price, totalAmt,dateCr,pic, status) VALUES('$pro_name1', '$quantity1', '$pro_id1', '$total', '$date','','INACTIVE')";
				$add_payment_result = mysql_query($add_payment,$dbLink);
				 if($add_payment_result)
				 {
					 echo "<script>location='upload_receipt.php'</script>";
				 }
				
			}
	?>
<form id="form1" name="form1" method="post" action="">
<br />
<div class="container">

<span class="label label-danger">MYR = Malaysia Ringgit (RM)</span>
<br /><br />
<table border="0" cellspacing="0" class="table">
<tr>
<td>
<br />
<div id="printableArea">
<table border="0" cellspacing="0" class="table" style="border: 1px solid #000000; max-width:250px">
<tr>
<td>
<div class="container" style="width:350px;">
<div class="row">
<br />
<table border="0" cellspacing="0">
<tr>
<td align="center"  colspan="2"><h2>Receipt</h2></td>
</tr>
<tr>
  <th colspan="2" >
 	<span class="text-nowrap"><u>Product DETAILS</u></span>
  </th>
   </tr>
   
  <tr>
    <th colspan="2"><span class="text-nowrap">Product Name:</span></th>
  </tr>
  <tr>

    <td colspan="2"><span class="text-nowrap h5" style="">
	
	  <?php
		for($i=0; $i<count($pro_name);$i++)
		{
			echo $pro_name[$i]."<br>";
		}
  ?>
	</span></td>
  </tr>

  <tr>
    <td colspan="2"><span class="text-nowrap h5"></span></td>
  </tr>
  
  <tr>
    <th colspan="2"><span class="text-nowrap">Quantity:</span></th>
  </tr>
  <tr>
    <td colspan="2"><span class="text-nowrap h5">
	   <?php
		for($i=0; $i<count($quantity);$i++)
		{
			echo $pro_name[$i].": ".$quantity[$i]." units <br>";
		}
  ?>
  </span></td>
  </tr>

  <th colspan="2">
 	 <br /><br /><span class="text-nowrap"><u>Account Owner<br />DETAILS</u></span>
  </th>
   </tr>
  <tr>
    <td><span class="text-nowrap h5">Name</span></td>
    <td align=""><span class="h5"><?php echo $name;?></span></td>
  </tr>
  <tr>
    <td><span class="text-nowrap h5">NRIC</span></td>
    <td align=""><span class="h5"><?php echo $ic;?></span></td>
  </tr>
  <tr>
  <th colspan="2">
 	 <br /><br /><span class="text-nowrap"><u>PAYMENT DETAILS</u></span>
  </th>
  </tr>
  <tr>
    <td><span class="text-nowrap h5">Unit Price</span></td>
    <td><span class="text-nowrap h5">
	<?php
		for($i=0; $i<count($pro_id);$i++)
		{
			echo $pro_name[$i].": RM ".$pro_id[$i]."<br>";
		}
  ?>
	</span></td>
  </tr>
  <tr>
    <td><span class="text-nowrap h5">Total Quantity</span></td>
    <td align=""><span class="text-nowrap h5">
	<?php
		for($i=0; $i<count($quantity);$i++)
		{
			$total += $quantity[$i];
		}
		echo $total;
  ?>
	</span></td>
  </tr>
   <tr>
    <td><span class="text-nowrap h5">TOTAL
	</span></td>
    
    <td align="right"><span class="text-nowrap"><strong><strong>
		<?php
		$total =0;
		for($i=0; $i<count($quantity);$i++)
		{
			$total += ($quantity[$i] * $pro_id[$i]);
		}
		echo "MYR ".number_format($total,2);
	?>
	</span></td>
  </tr>
  </tr>
</table>
</div>
</td>
</tr>
</table>
</div></div>
</td>
<td>
<br />
<table border="0" cellspacing="0" class="table">
<tr>
<th class="h3" colspan="2"><strong>ACCOUNT DETAILS & MAKE PAYMENT</strong></th>
</tr>
<tr>
<td class="h6" colspan="2"><u>THINGS TO CHECK BEFORE MAKE PAYMENT</u><br />1. Product Name, Product Quantity, and Account Details.<br />2. Amount you are purchasing are correct.<br />3. Account Info are fully correct. If not, please check your account profile and remake payment or inform our staff.</td>
</tr>
<tr>
<td class="h5" colspan="2"><strong>Account Information</strong></td>
</tr>
<tr>
<td class="h5"  style="max-width:30px;">Name:</td>
<td class="h5"><input type="text" name="textfield" id="textfield" class="form-control" disabled="disabled" value="<?php echo $name;?>" style="max-width:300px; height:25px"/></td>
</tr>
<tr>
<td class="h5" style="max-width:30px;">NRIC:</td>
<td class="h5"><input type="text" name="textfield" id="textfield" class="form-control" disabled="disabled" value="<?php echo $ic;?>" style="max-width:300px; height:25px"/></td>
</td>
</tr>
<tr>
<td class="h5" style="max-width:30px;">Email:</td>
<td class="h5"><input type="text" name="textfield" id="textfield" class="form-control" disabled="disabled" value="<?php echo $email;?>" style="max-width:300px; height:25px"/></td>
</td>
</tr>
<tr>
<td class="h5" style="max-width:120px;">Contact Number:</td>
<td class="h5"><input type="text" name="textfield" id="textfield" class="form-control" disabled="disabled" value="<?php echo $contactNum;?>" style="max-width:300px; height:25px"/>&nbsp;<span class="label label-default">Please make sure contact number is correct. Staff can contact if any emergency happend.</span></td>
</td>
</tr>
<tr>
<td class="h5" style="max-width:60px;">Address:</td>
<td class="h5"><input type="text" name="textfield" id="textfield" class="form-control" disabled="disabled" value="<?php echo $addr;?>" style="max-width:300px; height:25px"/></td>
</td>
</tr>
<tr>
<td class="h5" style="max-width:60px;">Total Amount:</td>
<td class="h5"><input type="text" name="textfield" id="textfield" class="form-control" disabled="disabled" value="<?php echo "MYR ".number_format($total,2);?>" style="max-width:300px; height:25px"/></td>
</td>
</tr>
<tr>
<td colspan="2"><input name="btn_pay" id="btn_pay" type="submit" value="Pay now" class="btn btn-primary"/></td>

</tr>
</table>
</td>
</table>
</div>
</form>

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