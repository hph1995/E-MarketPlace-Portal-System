<?php
  session_cache_limiter('private, must-revalidate');
  session_start();
  include('dbEMarketplace.php');
  //check if the directory not exists, then create directory
	$filename = 'payment picture'; // directory
	if (file_exists($filename)){
	} else {
	mkdir("payment picture");
	$myfile = fopen("payment picture/payment_name.txt", "w") or die("Unable to open file!");
	fwrite($myfile,"");
	fclose($myfile);
	}
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
  
            if(isset($_POST['btn_payment']))
			{
					//upload picture
			$target_dir = "payment picture/";
			$target_file = $target_dir . basename($_FILES["payment_pic"]["name"]);
			$uploadOk = 1;
			$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
			// Check if image file is a actual image or fake image
			if(isset($_POST["btn_payment"])) {
   			$check = getimagesize($_FILES["payment_pic"]["tmp_name"]);
    		if($check !== false) 
			{
      		  	$uploadOk = 1;
    		} 
			else 
			{
        		$uploadOk = 0;
  		 	}
		}
			// Check file size
			if ($_FILES["payment_pic"]["size"] > 900000)
			{
   				 $uploadOk = 0;
			}

			// Allow certain file formats
			if($imageFileType != "jpg" && $imageFileType != "png" && 					$imageFileType != "jpeg" && $imageFileType != "gif" && $imageFileType != "JPG" && $imageFileType != "PNG" && $imageFileType != "JPEG" && $imageFileType != "GIF") {
    			$uploadOk = 0;
			}
			//change the picture name when upload
			$last_id = mysql_query("SELECT ID FROM `tblpayment` ORDER BY ID DESC LIMIT 1");
			$id = 0;
			if(mysql_num_rows($last_id) > 0)
			{
				while ($row = mysql_fetch_array($last_id, MYSQL_ASSOC))
				{
					$id = $row['ID'];	
				}
			}
			else
			{
				$id = 1;
			}
			$_FILES["payment_pic"]["name"] = $id.".".$imageFileType;
$target_file = $target_dir . basename($_FILES["payment_pic"]["name"]); //file
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION); //get the file extension


			// Check if $uploadOk is set to 0 by an error
			if ($uploadOk == 0)
			{
			}
			else 
			{
    			if (move_uploaded_file($_FILES["payment_pic"]["tmp_name"], $target_file))
				{
					//write the picture name into logo_name.txt
					$myfile = fopen("payment picture/payment_name.txt", "a"); // "a" can allow write new data into text file without delete existing data
					$newline = "\r\n"; // write new data into text file with newline
					fwrite($myfile,$_FILES["payment_pic"]["name"].$newline);
					fclose($myfile);
					$img_name = $_FILES["payment_pic"]["name"];
					$addpic = "UPDATE tblpayment SET pic = '$img_name' WHERE ID = ".$id."";
					$addpic = mysql_query($addpic, $dbLink);
					echo "<script>location='index.php';</script>";
    			} 
				else 
				{
    			}
			}
			}
	?>
<form id="form1" name="form1" method="post" action="" enctype="multipart/form-data">
<br />
<div class="container">

<span class="label label-danger">MYR = Malaysia Ringgit (RM)</span>
<br /><br />
<table border="0" cellspacing="0" class="table">
<tr>
<td>
<br />
<table border="0" cellspacing="0" class="table" style="border: 1px solid #000000; max-width:250px">
<tr>
<td>
<div class="container" style="width:350px;">
<div class="row">
<br />
<div id="printableArea">
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
    
    <td align="left"><span class="text-nowrap"><strong><strong>
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
<br /><table border="0" cellspacing="0" class="table table-condensed">
<tr>
<th class="h3" colspan="2"><strong>MAKE PAYMENT</strong></th>
</tr>
<tr>
<td class="h6" colspan="2"><u>UPLOAD BANKING SLIP PICTURE</u><br />1. Capture your banking slip(bank,amount and time) at bright environment and upload picture.<br /></strong>2. If captured's banking slip without clealry on behalf of the <strong class="text-danger">FAILED</strong>.<br />3. Bank Account: <b>Hong Leong 100082053</b>. Bank Name: <b>1X ENTERPRISE</b><br></td>
</tr>
<tr>
<td class="h5"><strong><br />Payment Status:</strong><div style="color:#F00">unsuccessful</div></td>
</tr>

<tr>
<td class="h5"><strong>Upload Picture:</strong></td>
</tr>
<tr>
<td class="h5"><input type="file" name="payment_pic" id="payment_pic" class="form-control" style="max-width:300px;" required/></td>
</tr>
<tr><td><input type="submit" name="btn_payment" id="btn_payment" value="Make Payment" class="btn btn-primary"/></td></tr>
<tr>
<td><input type="button" onclick="printDiv('printableArea')" value="Print Ticket" class="btn btn-info"/></td>
</tr>
</table>
</td>
</tr>
</td>
</tr>
</table>
</td>
</table>
</div>
</form>

    <hr>
<script>
function printDiv(divName) {
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;

     window.print();

     document.body.innerHTML = originalContents;
}
</script>
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