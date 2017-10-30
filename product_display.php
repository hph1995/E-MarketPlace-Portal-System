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
      <div class="container">
        <div class="row">
          <div class="">
            <div class="site-heading">
            </div>
          </div>
        </div>
      </div>
    </header>
	
	<!-- Main Content -->
    <div class="container">
      <div class="row">
        <div class="col-lg-8 col-md-10 mx-auto">
          <div class="post-preview">
            <h1 class="post-title" align="center">
				<?php echo ucwords(strtolower($_GET['mode'])); ?>
			</h1>
		  </div>
        </div>
      </div>
    </div>
	
    <form id="formProduct" name="formProduct" method="post" style="margin-top: 100px;" action="" enctype="multipart/form-data">
    <?php   
        $getNumProduct = "SELECT COUNT(productID) AS intProduct FROM tblproduct";
        $checkNum = mysql_query($getNumProduct, $dbLink);
        $numInfo = mysql_fetch_array($checkNum);

        $getAllClothing = "SELECT * FROM tblproduct WHERE category = '".$_GET['mode']."'";
        $checkGetAllClothing = mysql_query($getAllClothing, $dbLink);
        ?>
    
            <div style="margin: 10px;">  
                <table id="productTable" class="table table-hover" style="width: 80%; margin-left: 10%;">
                    <!--<thead>
                        <tr>
                          <th>No</th>
                          <th>Product Name</th>
                          <th>Category</th>
                          <th>Description</th>
                          <th>Place Manufacture</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php				
							/*if(mysql_num_rows($checkGetAllClothing) > 0)
							{
								for($i = 0; $i < mysql_num_rows($checkGetAllClothing); $i++)
								{
									$allProduct = mysql_fetch_array($checkGetAllClothing);
									echo '<tr id="stockRow'.($i+1).'">';
									echo '<td>'.($i+1).'</td>';
									echo '<td>'.ucwords(strtolower($allProduct['productName'])).'</td>';
									echo '<td>'.ucwords(strtolower($allProduct['category'])).'</td>';
									echo '<td>'.ucwords(strtolower($allProduct['description'])).'</td>';
									echo '<td>'.ucwords(strtolower($allProduct['placeManufacture'])).'</td>';
									echo '</tr>';
								}
							}*/
						?>
                    </tbody>-->
                    <tr>
                    	<?php
                    	if(mysql_num_rows($checkGetAllClothing) > 0)
						{
							for($i = 0; $i < mysql_num_rows($checkGetAllClothing); $i++)
							{
								$allProduct = mysql_fetch_array($checkGetAllClothing);
								echo "<td>";
		                    	echo '<figure class="figure">';
								echo '<img src="img/android.jpg" class="img-fluid img-thumbnail" alt="'.ucwords(strtolower($allProduct['productName'])).'">';
								echo '<figcaption class="figure-caption" style="text-align:center; color: #000000; font-size: 20px;">'.ucwords(strtolower($allProduct['productName'])).'</figcaption>';
								echo '<figcaption class="figure-caption" style="text-align:center; color: #000000;">'.ucwords(strtolower($allProduct['description'])).'</figcaption>';
								echo '<div style="text-align:center"><a href="#" class="btn btn-info" style="text-align:center;"><span class="fa fa-shopping-cart"></span> Add to Cart</a></div>';
								echo '<div style="text-align:center"><a href="#" style="font-size:12px;">Add to favourite</a></div>';
								echo '</figure>';
		                    	echo '</td>';
		                    	if((($i+1) % 3) == 0)
		                    	{
		                    		echo '</tr><tr>';
		                    	}
							}
						}?>
                    </tr>
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