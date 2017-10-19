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
	if($_POST['btn_change'])
	{
		//take out all picture name from staff_picture_name.txt and store each of name into array
$file="customer picture/customer_picture_name.txt";
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
			$file2="product picture/".$_GET['id'];
			unlink($file2);
			$target_dir = "product picture/";
			$target_file = $target_dir . basename($_FILES["product_pic"]["name"]);
			$uploadOk = 1;
			$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
			// Check if image file is a actual image or fake image
			if(isset($_POST["btn_change"])) {
   			$check = getimagesize($_FILES["product_pic"]["tmp_name"]);
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
			if ($_FILES["product_pic"]["size"] > 900000)
			{
   				 $uploadOk = 0;
			}

			// Allow certain file formats
			if($imageFileType != "jpg" && $imageFileType != "png" && 					$imageFileType != "jpeg" && $imageFileType != "gif" && $imageFileType != "JPG" && $imageFileType != "PNG" && $imageFileType != "JPEG" && $imageFileType != "GIF") {
    		$uploadOk = 0;
			}
			//change the picture name when upload
			$name = explode(".",$_GET['id']);
			$_FILES["product_pic"]["name"] = $name[0].".".$imageFileType;
$target_file = $target_dir . basename($_FILES["product_pic"]["name"]); //file
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION); //get the file extension
// Check if $uploadOk is set to 0 by an error
			if ($uploadOk == 0)
			{
			}
			else 
			{
    			if (move_uploaded_file($_FILES["product_pic"]["tmp_name"], $target_file))
				{
					echo "<script>alert('Changed'); location = 'product.php';</script>";
    			} 
				else 
				{
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
		   
          <form name="sentMessage" id="contactForm" method="post" enctype="multipart/form-data">
            <div style="margin: 10px;">
                <h2 style="text-align: center;">Change your product picture</h2><br>       
                <table id="productTable" class="table table-hover">
                        <tr>
                          <td align="center"><strong>Product Picture</strong></td>  
						  
                        </tr>
						<tr>
                          <td align="center"><img src="<?php echo "product picture/".$_GET['id'].""?>" class="img-responsive img-thumbnail"  style="max-width:300px" /></td>  
                        </tr>
						<tr>
							<td align="center"><input type="file" name="product_pic" id="product_pic" class="form-control" style="width:250px;"/></td>
						</tr>
						<tr>
						<td align="center">
						<div class="form-group">
              <input type="submit" class="btn btn-secondary" id="btn_change" name="btn_change" value="Change">
			  </td>
						</tr>
          <tr>
					</table>
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
