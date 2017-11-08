<?php
	session_cache_limiter('private, must-revalidate');
	session_start();
    include('dbEMarketplace.php');
	//check if the directory not exists, then create directory
	$filename = 'product picture'; // directory
	if (file_exists($filename)){
	} else {
	mkdir("product picture");
	$myfile = fopen("product picture/product_picture_name.txt", "w") or die("Unable to open file!");
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
      <div class="container">
        <div class="row">
          <div class="">
            <div class="site-heading">
            </div>
          </div>
        </div>
      </div>
    </header>

    <form id="formProduct" name="formProduct" method="post" style="margin-top: 100px;" action="" enctype="multipart/form-data">
		<?php   
			$getNumProduct = "SELECT COUNT(productID) AS intProduct FROM tblproduct WHERE status = 'ACTIVE' AND sellerID = '".$_SESSION['account_id']."'";
			$checkNum = mysql_query($getNumProduct, $dbLink);
			$numInfo = mysql_fetch_array($checkNum);
			echo '<script type="text/javascript">var countRow = '.$numInfo['intProduct'].';</script>';

			$getAllProduct = "SELECT * FROM tblfavourite NATURAL JOIN tblproduct WHERE status = 'ACTIVE' AND sellerID = '".$_SESSION['account_id']."'";
			$checkGetAllProduct = mysql_query($getAllProduct, $dbLink);
		?>
            <div style="margin: 10px;">
                <h2 style="text-align: center;">My Collection</h2><br>       
                <table id="productTable" class="table table-hover" style="width: 100%">
                    <thead>
                        <tr>
                          <th>No</th>
						  <th>Product Picture</th>
                          <th>Product Name</th>
                          <th>Category</th>
                          <th>Description</th>
                          <th>Place Manufacture</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
						//take out all picture name from staff_picture_name.txt and store each of name into array
                        $file="product picture/product_picture_name.txt";
                        $page = join("",file("$file")); //Converts the array to a string. Join is an alias for implode. It takes each piece of the array, and glues them together, using the first argument as "glue."
                        $picture_name = explode("\n", $page);
                        $picture_type_array = array("gif","png","jpg","jpeg","GIF","PNG","JPG","JPEG"); //all image type available
                        for($i=0;$i<count($picture_name);$i++)
                        {
                        	for($k=0;$k<count($picture_type_array);$k++)
                        	{
                        		if(trim(strtolower($username)).".".$picture_type_array[$k] == trim(strtolower($picture_name[$i])))
                        		{
                        			$picture_name = $picture_name[$i];
                        		}
                        	}
                        }
                        echo "<script>var countStockRow = 0;</script>";
                        if(mysql_num_rows($checkGetAllProduct) > 0)
                        {
                            for($i = 0; $i < mysql_num_rows($checkGetAllProduct); $i++)
                            {
                                echo "<script>countStockRow++;</script>";
                                $allProduct = mysql_fetch_array($checkGetAllProduct);
                                echo '<tr id="stockRow'.($i+1).'">';
                                echo '<td>'.($i+1).'</td>';
								echo "<td><img src=\"product picture/$picture_name[$i]\" class=\"img-responsive img-thumbnail\" alt=\"Responsive image\" style=\"max-width:80px\"></td>";
                                echo '<td>'.ucwords(strtolower($allProduct['productName'])).'</td>';
                                echo '<td>'.ucwords(strtolower($allProduct['category'])).'</td>';
                                echo '<td>'.ucwords(strtolower($allProduct['description'])).'</td>';
                                echo '<td>'.ucwords(strtolower($allProduct['placeManufacture'])).'</td>';
                                echo '</tr>';
                            }
                        }
                        else
                        {
                            echo '<tr class="noProduct"><td colspan="7" align="center">There are no product can be shown.</td></tr>';
                        }
						?>
                    </tbody>
                </table>
                <br>
            </div>
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