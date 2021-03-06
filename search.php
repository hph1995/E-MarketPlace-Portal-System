<?php
	session_cache_limiter('private, must-revalidate');
	session_start();
    include('dbEMarketplace.php');
?>
<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>E-MarketPlace Portal</title>

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
    <?php require_once('navbar.php'); ?>

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
    <!-- Main Content -->
	<?php
	$getAllClothing = "SELECT MAX(tblproduct.productID) as number FROM tblproduct, tblsellingprice, tblstockcontrol WHERE tblproduct.productID = tblsellingprice.productID AND tblstockcontrol.productID = tblproduct.productID AND tblsellingprice.sellingPrice > 0 AND tblstockcontrol.quantity > 0 LIMIT 1";
      $checkGetAllClothing = mysql_query($getAllClothing, $dbLink);
      $result = mysql_fetch_array($checkGetAllClothing);
      $count = 1;
	  $int =1;
      for($i = 0; $i < $result['number']; $i++)
      {
        if($_POST["btnAddCart$count"])
        {
          $update_status = mysql_query("INSERT INTO tblcart (productID, accountID, quantity, total_price, status) VALUES('".$count."', '".$_SESSION['account_id']."', 0,0, 'ACTIVE')");
        }
        $count += 1;
      }
	    for($x = 0; $x < $result['number']; $x++)
	  {
		  if($_POST["addToFav$int"])
		  {
			  $update_status = mysql_query("INSERT INTO tblfavourite (productID, accountID, status) VALUES('".$int."', '".$_SESSION['account_id']."', 'ACTIVE')");
		  }
		  $int += 1;
	  }
	  ?>
	<form id="index" name="index" method="post" style="" action="" enctype="multipart/form-data">
    <div class="container" style="box-shadow: 0 0 15px #dbdbdb; padding:0 15px 0 15px;">
      <div class="row">
        <div class="col-lg-8 col-md-10 mx-auto">
		 <h2 class="post-title" align="center">
		 <br>
              All Products
            </h2>
			
			<table id="productTable" class="" style="" align="center" border=0>
            <tr align="">
			<br>
			<td>SORT BY:</td>
			<td>
			<select name="category" id="category" onChange="form.submit()" class="form-control" style="max-width:250px;">
			<option value="" disabled selected></option>
			<option <?php if($_POST['category'] == "All") echo " selected";?>>All</option>
			<?php
			$category = mysql_query("SELECT * FROM tblcategory");
			while($row = mysql_fetch_array($category, MYSQL_ASSOC))
			{	
					?>
					<option value = <?php echo $row['catName'];?> <?php if($_POST['category'] == $row['catName']) echo " selected";?>><?php echo $row['catName'];?></option>
					<?php
			}
			?>
			</select></td>
			<td> Price:</td>
			<td>
			<select name="price" id="price" onChange="form.submit()" class="form-control" style="max-width:250px;">
			<option value="" disabled selected></option>
			<option value = "ORDER BY tblsellingprice.sellingPrice" <?php if($_POST['price'] == "ORDER BY tblsellingprice.sellingPrice") echo " selected";?>>Acending Order</option>
			<option value="ORDER BY tblsellingprice.sellingPrice DESC" <?php if($_POST['price'] == "ORDER BY tblsellingprice.sellingPrice DESC") echo " selected";?>>Decending Order</option>
			</select>
			</td>
			</td>
			</tr>
			</table>
		<?php   
        $getNumProduct = "SELECT COUNT(productID) AS intProduct FROM tblproduct";
        $checkNum = mysql_query($getNumProduct, $dbLink);
        $numInfo = mysql_fetch_array($checkNum);
		$value = $_POST['btn_cat'];
		if($_POST['category'] == "All")
		{
        $getAllClothing = "SELECT * FROM tblproduct, tblsellingprice, tblstockcontrol WHERE tblproduct.productID = tblsellingprice.productID AND tblstockcontrol.productID = tblproduct.productID AND tblsellingprice.sellingPrice > 0 AND tblstockcontrol.quantity > 0 AND tblproduct.productName LIKE '%".$_GET['id']."%'";
		}
		else if(isset($_POST['category']))
		{
			$getAllClothing = "SELECT * FROM tblproduct, tblsellingprice, tblstockcontrol WHERE tblproduct.productID = tblsellingprice.productID AND tblstockcontrol.productID = tblproduct.productID AND tblsellingprice.sellingPrice > 0 AND tblstockcontrol.quantity > 0 AND tblproduct.productName LIKE '%".$_GET['id']."%' AND tblproduct.category='".$_POST['category']."'";
		}
		else
		{
			$getAllClothing = "SELECT * FROM tblproduct, tblsellingprice, tblstockcontrol WHERE tblproduct.productID = tblsellingprice.productID AND tblstockcontrol.productID = tblproduct.productID AND tblsellingprice.sellingPrice > 0 AND tblstockcontrol.quantity > 0 AND tblproduct.productName LIKE '%".$_GET['id']."%'";
		}
		
		if(isset($_POST['price']))
		{
			if($_POST['category'] == "All")
			{
				$getAllClothing = "SELECT * FROM tblproduct, tblsellingprice, tblstockcontrol WHERE tblproduct.productID = tblsellingprice.productID AND tblstockcontrol.productID = tblproduct.productID AND tblsellingprice.sellingPrice > 0 AND tblstockcontrol.quantity > 0 AND tblproduct.productName LIKE '%".$_GET['id']."%' ".$_POST['price']."";
			}
			else
			{
				$getAllClothing = "SELECT * FROM tblproduct, tblsellingprice, tblstockcontrol WHERE tblproduct.productID = tblsellingprice.productID AND tblstockcontrol.productID = tblproduct.productID AND tblsellingprice.sellingPrice > 0 AND tblstockcontrol.quantity > 0 AND tblproduct.productName LIKE '%".$_GET['id']."%' AND tblproduct.category='".$_POST['category']."' ".$_POST['price']."";
			}
		}
		
        $checkGetAllClothing = mysql_query($getAllClothing, $dbLink);
        ?>
    
            <div style="margin: 10px;">  
                <table id="productTable" class="table table-hover" style="width: 80%; margin-left: 10%;">
                    <tr align="center">
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
                    	if(mysql_num_rows($checkGetAllClothing) > 0)
          						{
          							for($i = 0; $i < mysql_num_rows($checkGetAllClothing); $i++)
          							{
          								$allProduct = mysql_fetch_array($checkGetAllClothing);
          								echo "<td>";
          		            echo '<figure class="figure">';
          								echo '<center><img src="product picture/'.$allProduct['image_name'].'" style="max-width:100px" class="img-responsive img-fluid img-thumbnail" alt="'.ucwords(strtolower($allProduct['productName'])).'"></center>';
          								echo '<figcaption class="figure-caption" style="text-align:center; color: #000000; font-size: 20px;">'.ucwords(strtolower($allProduct['productName'])).'</figcaption>';
          								echo '<figcaption class="figure-caption" style="text-align:center; color: #000000; font-size: 15px;">'.ucwords(strtolower($allProduct['description'])).'</figcaption>';
                          $getProPrice = "SELECT * FROM tblsellingprice WHERE productID = '".$allProduct['productID']."'";
                          $checkGetProPrice = mysql_query($getProPrice, $dbLink);
                          if($checkGetProPrice) $price = mysql_fetch_array($checkGetProPrice);
                          echo '<figcaption class="figure-caption" style="text-align:center; color: #000000; font-size: 15px;"><i>RM '.$price['sellingPrice'].'</i></figcaption>';
                          $getProSeller = "SELECT * FROM tblpersonnel WHERE tblpersonnel.accountID = '".$allProduct['sellerID']."'";
                          $checkGetProSeller = mysql_query($getProSeller, $dbLink);
                          if($checkGetProSeller) $sellerName = mysql_fetch_array($checkGetProSeller);
                          echo '<figcaption class="figure-caption" style="text-align:center; color: #000000; font-size: 15px;"><i>Sold By '.$sellerName['name'].'</i></figcaption>';
						  
                          $checkCart = "SELECT * FROM tblcart WHERE productID = '".$allProduct['productID']."' AND accountID = '".$_SESSION['account_id']."' AND status = 'ACTIVE'";
                          $getCheckCart = mysql_query($checkCart, $dbLink);
          								echo '<button name="btnAddCart'.$allProduct['productID'].'" class="btn btn-info btn-xs" style="text-align:center;" value="submit" ';
                          if(mysql_num_rows($getCheckCart) > 0) echo "disabled";
                          echo '><span class="fa fa-shopping-cart"></span> Add to Cart</button>';
						  
						  $checkFav = "SELECT * FROM tblfavourite WHERE productID = '".$allProduct['productID']."' AND accountID = '".$_SESSION['account_id']."' AND status = 'ACTIVE'";
                          $getCheckFav = mysql_query($checkFav, $dbLink);
          								echo '<br><button style="background:none!important; color:inherit; border:none; padding:0!important; font: inherit; border-bottom:1px solid #444; cursor: pointer;" name="addToFav'.$allProduct['productID'].'" class="btn btn-info btn-xs" style="text-align:center;" value="submit" align="center"';
                          if(mysql_num_rows($getCheckFav) > 0) echo "disabled";
                          echo '><span class="fa fa-my-collection"></span> Add to Favourite</button><br>';
										
                          $getRate = "SELECT * FROM tblrating WHERE productID = '".$allProduct['productID']."' AND accountID = '".$_SESSION['account_id']."'";
                          $checkGetRate = mysql_query($getRate, $dbLink);
                          if(mysql_num_rows($checkGetRate) > 0) {
                            $result = mysql_fetch_array($checkGetRate);
                            $rNumber = $result['rateNumber'];
                            $flagPresent = "true";
                          }
                          else {
                            $rNumber = 0;
                            $flagPresent = "false";
                          }
						  $id = $_GET['id'];
                          ?>
                          <button type="button" id="btnStar1" name="btnStar1" title="Edit" onClick="location='rate.php?rateNum=&&search=<?php echo $id;?>&pID=<?php echo $allProduct['productID'];?>&flagPresent=<?php echo $flagPresent;?>&accID=<?php echo $_SESSION['account_id'];?>&cat=<?php echo $value;?>';" style="border: 0; background: transparent; cursor:pointer;"><img src="<?php if($rNumber >= 1) echo 'img/yellow.png'; else echo 'img/white.png'; ?>" width="20" height="20" alt="submit" /></button>
                          <button type="button" id="btnStar2" name="btnStar2" title="Edit" onClick="location='rate.php?rateNum=2&search=<?php echo $id;?>&pID=<?php echo $allProduct['productID'];?>&flagPresent=<?php echo $flagPresent;?>&accID=<?php echo $_SESSION['account_id'];?>&cat=<?php echo $value;?>';" style="border: 0; background: transparent; cursor:pointer;"><img src="<?php if($rNumber >= 2) echo 'img/yellow.png'; else echo 'img/white.png'; ?>" width="20" height="20" alt="submit" /></button>
                          <button type="button" id="btnStar3" name="btnStar3" title="Edit" onClick="location='rate.php?rateNum=3&search=<?php echo $id;?>&pID=<?php echo $allProduct['productID'];?>&flagPresent=<?php echo $flagPresent;?>&accID=<?php echo $_SESSION['account_id'];?>&cat=<?php echo $value;?>';" style="border: 0; background: transparent; cursor:pointer;"><img src="<?php if($rNumber >= 3) echo 'img/yellow.png'; else echo 'img/white.png'; ?>" width="20" height="20" alt="submit" /></button>
                          <button type="button" id="btnStar4" name="btnStar4" title="Edit" onClick="location='rate.php?rateNum=4&search=<?php echo $id;?>&pID=<?php echo $allProduct['productID'];?>&flagPresent=<?php echo $flagPresent;?>&accID=<?php echo $_SESSION['account_id'];?>&cat=<?php echo $value;?>';" style="border: 0; background: transparent; cursor:pointer;"><img src="<?php if($rNumber >= 4) echo 'img/yellow.png'; else echo 'img/white.png'; ?>" width="20" height="20" alt="submit" /></button>
                          <button type="button" id="btnStar5" name="btnStar5" title="Edit" onClick="location='rate.php?rateNum=5&search=<?php echo $id;?>&pID=<?php echo $allProduct['productID'];?>&flagPresent=<?php echo $flagPresent;?>&accID=<?php echo $_SESSION['account_id'];?>&cat=<?php echo $value;?>';" style="border: 0; background: transparent; cursor:pointer;"><img src="<?php if($rNumber >= 5) echo 'img/yellow.png'; else echo 'img/white.png'; ?>" width="20" height="20" alt="submit" /></button>
                          <?php
          								echo '</figure>';
          		            echo '</td>';
          		            if((($i+1) % 3) == 0)
          		            {
          		            	echo '</tr><tr align="center">';
          		        7;    }
          							}
          						}?>
                    </tr>
                </table>
        </div>
      </div>
    </div>

    <hr>
</form>
    <!-- Footer -->
    <?php include('footer.php');?>

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/popper/popper.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Custom scripts for this template -->
    <script src="js/clean-blog.min.js"></script>

  </body>

</html>
