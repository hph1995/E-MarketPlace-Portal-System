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
<script language="javascript">
    $(document).ready(function(){
        $("#btnAddProduct").click(function(){
            $('.noProduct').css({display:'none'});
        });
    });

    function addRow(num, tableID, divName, buttonId, numberOfBtn) {
        ++num;
        var tbl = document.getElementById(tableID);
        row = tbl.insertRow(num);

        //remove button and add button
        var elem = document.getElementById(buttonId);
        elem.parentNode.removeChild(elem);
        var add = document.createElement("BUTTON");
        var cancel = document.createElement("BUTTON");
        var t = document.createTextNode("Submit");
        var c = document.createTextNode("Cancel");
        add.appendChild(t);
        cancel.appendChild(c);
        add.setAttribute("style", "float:left; position:relative; left: 45%;");
        add.setAttribute("class", "btn btn-primary");
        add.setAttribute("name", "btnSubmitProduct");
        add.setAttribute("type", "submit");
        cancel.setAttribute("style", "float:left; position:relative; left: 46%;");
        cancel.setAttribute("class", "btn btn-danger");
        cancel.setAttribute("type", "submit");
        cancel.setAttribute("formnovalidate", "formnovalidate");
        cancel.setAttribute("value", "#");
        for(var i = 0; i < numberOfBtn; i++){
            document.getElementById("btnEditProduct"+(i+1)).disabled = true;
            document.getElementById("btnDelProduct"+(i+1)).disabled = true;
            document.getElementById("btnEditProduct"+(i+1)).style.cursor = "not-allowed";
            document.getElementById("btnDelProduct"+(i+1)).style.cursor = "not-allowed";
        }
        var newCell = row.insertCell(0);
        newCell.setAttribute("align", "center");
        newCell.innerHTML = num;    
        newCell = row.insertCell(1);
        newCell.innerHTML = '<input type="text" name="txtproName" id="txtproName" placeholder="  Product Name" style="width:100%;" autofocus required="required" />';
        newCell = row.insertCell(2);
        <?php 
        echo "newCell.innerHTML = '<select name=\'sCategory\'>";
        $getCategory = "SELECT * FROM tblcategory";
        $checkGetCategory = mysql_query($getCategory, $dbLink);
        if($checkGetCategory)
        {
            for($i = 0; $i < mysql_num_rows($checkGetCategory); $i++)
            {
                $categoryInfo = mysql_fetch_array($checkGetCategory);
                echo '<option value="'.$categoryInfo['catName'].'">'.ucwords(strtolower($categoryInfo['catName'])).'</option>';
            }
        } 
        echo "</select>';";?>
        newCell = row.insertCell(3);
        newCell.innerHTML = '<input type="text" name="txtDescr" id="txtDescr" placeholder="  Description" style="width:100%;" autofocus required="required" />';
        newCell = row.insertCell(4);
        newCell.innerHTML = '<input type="text" name="txtPlaceManufacture" id="txtPlaceManufacture" placeholder="  Place Manufacture" style="width:100%;" autofocus required="required" />';
        newCell = row.insertCell(5);
        newCell.innerHTML = '<input type="file" name="product_pic" id="product_pic" class="form-control" style="width:250px;" required/>';
        add.setAttribute("value", "#");
        cancel.setAttribute("name", "btnCAddProduct");
        
        document.getElementById(divName).appendChild(add);
        document.getElementById(divName).appendChild(cancel);
    }

    function editRow(num, stockID, pName, dIndication, descr, pManufature) {
        var tbl = document.getElementById("productTable");
        row = document.getElementById("stockRow"+num);

        //remove button and add button
        for(var i = 0; i < countRow; i++){
            document.getElementById("btnEditProduct"+(i+1)).disabled = true;
            document.getElementById("btnDelProduct"+(i+1)).disabled = true;
            document.getElementById("btnEditProduct"+(i+1)).style.cursor = "not-allowed";
            document.getElementById("btnDelProduct"+(i+1)).style.cursor = "not-allowed";
        }
        var newCell = row.deleteCell(0);
        newCell = row.insertCell(0);
        newCell.setAttribute("align", "center");
        newCell.innerHTML = num;
        newCell = row.deleteCell(1);
        newCell = row.insertCell(1);
        newCell.innerHTML = '<input type="text" name="txtProductName" id="txtProductName" value="" placeholder="  Product Name" style="width:100%;" autofocus required="required" />';
        document.getElementById("txtProductName").value = pName;
        newCell = row.deleteCell(2);
        newCell = row.insertCell(2);
        <?php 
        echo "newCell.innerHTML = '<select name=\'sCategory\'>";
        $getCategory = "SELECT * FROM tblcategory";
        $checkGetCategory = mysql_query($getCategory, $dbLink);
        if($checkGetCategory)
        {
            for($i = 0; $i < mysql_num_rows($checkGetCategory); $i++)
            {
                $categoryInfo = mysql_fetch_array($checkGetCategory);
                echo '<option value="'.$categoryInfo['catName'].'">'.ucwords(strtolower($categoryInfo['catName'])).'</option>';
            }
        } 
        echo "</select>';";?>
        newCell = row.deleteCell(3);
        newCell = row.insertCell(3);
        newCell.innerHTML = '<input type="text" name="txtDescr" id="txtDescr" value="" placeholder="  Usage" style="width:100%;" required="required" required="required" />';
        document.getElementById("txtDescr").value = descr;
        newCell = row.deleteCell(4);
        newCell = row.insertCell(4);
        newCell.innerHTML = '<input type="text" name="txtPManufature" id="txtPManufature" value="" placeholder="  Indications" style="width:100%;" required="required" required="required" />';
        document.getElementById("txtPManufature").value = pManufature;
        newCell = row.deleteCell(5);
        newCell = row.insertCell(5);
        newCell.innerHTML = '<button type="submit" id="btnSaveProduct" name="btnSaveProduct" title="Save" style="border: 0; background: transparent; cursor:pointer;" value="" ><img src="img/save.png" width="20" height="20" /></button><button type="submit" id="btnBack" name="btnBack" title="Back" style="border: 0; background: transparent; margin-left:5px; cursor:pointer;" formnovalidate value="#"><img src="img/back.png" width="20" height="20" /></button>';
        document.getElementById("btnSaveProduct").value = stockID;
    }

</script>
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
    <?php
    if($_POST['btnSubmitProduct'])
    {
		//upload picture
			$target_dir = "product picture/";
			$target_file = $target_dir . basename($_FILES["product_pic"]["name"]);
			$uploadOk = 1;
			$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
			// Check if image file is a actual image or fake image
			if(isset($_POST["btnSubmitProduct"])) {
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
			if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" && $imageFileType != "JPG" && $imageFileType != "PNG" && $imageFileType != "JPEG" && $imageFileType != "GIF") {
    		$uploadOk = 0;
			}
			//change the picture name when upload
			$last_id = mysql_query("SELECT productID FROM `tblproduct` ORDER BY productID DESC LIMIT 1");
			$id = 0;
			if(mysql_num_rows($last_id) > 0)
			{
				while ($row = mysql_fetch_array($last_id, MYSQL_ASSOC))
				{
					$id = $row['productID'] + 1;	
				}
			}
			else
			{
				$id = 1;
			}
			$_FILES["product_pic"]["name"] = $id.".".$imageFileType;
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
					//write the picture name into logo_name.txt
					$myfile = fopen("product picture/product_picture_name.txt", "a"); // "a" can allow write new data into text file without delete existing data
					$newline = "\r\n"; // write new data into text file with newline
					fwrite($myfile,$_FILES["product_pic"]["name"].$newline);
					fclose($myfile);
					$img_name = $_FILES["product_pic"]["name"];
    			} 
				else 
				{
    			}
			}
        $sendEmail = false;
        $addProduct = 'INSERT INTO tblproduct (image_name,productName, category, description, placeManufacture, sellerID, status) VALUES("'.strtoupper(trim($img_name)).'", "'.strtoupper(trim($_POST['txtproName'])).'", "'.strtoupper(trim($_POST['sCategory'])).'", "'.strtoupper(trim($_POST['txtDescr'])).'", "'.strtoupper(trim($_POST['txtPlaceManufacture'])).'", "'.$_SESSION['account_id'].'", "ACTIVE")';
        $checkAddProduct = mysql_query($addProduct, $dbLink);

        $getProductID = 'SELECT COUNT(productID) as intProdutID FROM tblproduct';
        $checkGetProductID = mysql_query($getProductID, $dbLink);
        if($checkGetProductID) $tempProID = mysql_fetch_array($checkGetProductID);

        $setPrice = 'INSERT INTO tblsellingprice (productID, sellerID, sellingPrice, status) VALUES("'.strtoupper(trim($tempProID['intProdutID'])).'", "'.$_SESSION['account_id'].'", 0, "ACTIVE")';
        $checkSetPrice = mysql_query($setPrice, $dbLink);

        $setQuantity = 'INSERT INTO tblstockcontrol (productID, sellerID, quantity, status,paymentID) VALUES("'.strtoupper(trim($tempProID['intProdutID'])).'", "'.$_SESSION['account_id'].'", 0, "ACTIVE","")';
        $checkSetQuantity = mysql_query($setQuantity, $dbLink);


        $subscribedBuyer = "SELECT * FROM tblsubscribe WHERE sellerID = '".$_SESSION['account_id']."'";
        $checkSubscribedBuyer = mysql_query($subscribedBuyer, $dbLink);
        if(mysql_num_rows($checkSubscribedBuyer) > 0) $sendEmail = true;
        if($checkAddProduct && $checkSetPrice && $checkSetQuantity){
            if($sendEmail == true)
            {
                //send email to subscribed
                $getProductID = "SELECT COUNT(productID) as intPID FROM tblproduct";
                $checkGetProductID = mysql_query($getProductID, $dbLink);
                $numPID = mysql_fetch_array($checkGetProductID);
                echo "<script>location='sendingmail.php?addPID=".$numPID['intPID']."';</script>";
            }
            else{
                echo "<script>location='product.php';</script>";
            }
         }
        else{
            echo "<script>alert('Fail to add product!!');window.history.go(-1);</script>";
        }
    }
    else if ($_POST['btnDelProduct']) {
        $delProduct = "UPDATE tblproduct SET status = 'INACTIVE' WHERE productID = ".$_POST['btnDelProduct']."";
        $checkDelProduct = mysql_query($delProduct, $dbLink);

        $delPrice = "UPDATE tblsellingprice SET status = 'INACTIVE' WHERE productID = ".$_POST['btnDelProduct']."";
        $checkDelPrice = mysql_query($delPrice, $dbLink);

        $delQuantity = "UPDATE tblstockcontrol SET status = 'INACTIVE' WHERE productID = ".$_POST['btnDelProduct']."";
        $checkDelQuantity = mysql_query($delQuantity, $dbLink);

        if($checkDelProduct && $checkDelPrice && $checkDelQuantity) echo "<script>location='product.php';</script>";
    }
    else if($_POST['btnSaveProduct'])
    {
        $sendEmail = false;
        $updateProduct = "UPDATE tblproduct SET productName = '".strtoupper(trim($_POST['txtProductName']))."', category = '".strtoupper(trim($_POST['sCategory']))."', description = '".strtoupper(trim($_POST['txtDescr']))."', placeManufacture = '".strtoupper(trim($_POST['txtPManufature']))."' WHERE productID = ".$_POST['btnSaveProduct']."";
        $checkupdateProduct = mysql_query($updateProduct, $dbLink);
        $subscribedBuyer = "SELECT * FROM tblsubscribe WHERE sellerID = '".$_SESSION['account_id']."'";
        $checkSubscribedBuyer = mysql_query($subscribedBuyer, $dbLink);
        if(mysql_num_rows($checkSubscribedBuyer) > 0) $sendEmail = true;
        if($checkupdateProduct)
        {
            if($sendEmail == true)
            {
                //send email to subscribed
                echo "<script>location='sendingmail.php?updatePID=".$_POST['btnSaveProduct']."';</script>";
            }
        }
    }
    else if($_POST['btnCAddProduct'])
    {
        echo '<script>location="product.php";</script>';
    }
    else if($_POST['btnBack'])
    {
        echo '<script>location="product.php";</script>';
    }
    else
    { ?>
    <form id="formProduct" name="formProduct" method="post" style="margin-top: 100px;" action="" enctype="multipart/form-data">
    <?php   
            $getNumProduct = "SELECT COUNT(productID) AS intProduct FROM tblproduct WHERE status = 'ACTIVE' AND sellerID = '".$_SESSION['account_id']."'";
            $checkNum = mysql_query($getNumProduct, $dbLink);
            $numInfo = mysql_fetch_array($checkNum);
            echo '<script type="text/javascript">var countRow = '.$numInfo['intProduct'].';</script>';

            $getAllProduct = "SELECT * FROM tblproduct WHERE status = 'ACTIVE' AND sellerID = '".$_SESSION['account_id']."'";
            $checkGetAllProduct = mysql_query($getAllProduct, $dbLink);
            ?>
            <div style="margin: 10px;">
                <h2 style="text-align: center;">Product Table</h2><br>       
                <table id="productTable" class="table table-hover" style="width: 100%">
                    <thead>
                        <tr>
                          <th>No</th>
                          <th>Product Name</th>
                          <th>Category</th>
                          <th>Description</th>
                          <th>Place Manufacture</th>
						  <th align="center">Change Product Picture</th>
                          <th>Action</th>
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
                                echo '<td>'.ucwords(strtolower($allProduct['productName'])).'</td>';
                                echo '<td>'.ucwords(strtolower($allProduct['category'])).'</td>';
                                echo '<td>'.ucwords(strtolower($allProduct['description'])).'</td>';
                                echo '<td>'.ucwords(strtolower($allProduct['placeManufacture'])).'</td>';
								echo "<td><a href=\"edit_product_pic.php?id=$picture_name[$i]\"><img src=\"product picture/".$allProduct['image_name']."\" class=\"img-responsive img-thumbnail\" alt=\"Responsive image\" style=\"max-width:80px\"></a></td>";
								
                                echo '<td><button type="button" id="btnEditProduct'.($i+1).'" name="btnEditProduct" title="Edit" onClick="editRow('.($i+1).', \''.ucwords(strtolower($allProduct['productID'])).'\', \''.ucwords(strtolower($allProduct['productName'])).'\', \''.ucwords(strtolower($allProduct['category'])).'\', \''.ucwords(strtolower($allProduct['description'])).'\', \''.ucwords(strtolower($allProduct['placeManufacture'])).'\');" style="border: 0; background: transparent; cursor:pointer;" value="'.$stockInfo['drugID'].'" ><img src="img/edit.png" width="20" height="20" alt="submit" /></button>
                                <button onclick="if(confirm(\'Are you sure want to delete?\') == true ){ return true; } else { return false;}" type="submit" id="btnDelProduct'.($i+1).'" name="btnDelProduct" title="Delete" style="border: 0; background: transparent; margin-left:5px; cursor:pointer;" value="'.$allProduct['productID'].'"><img src="img/remove.png" width="20" height="20" alt="delete" /></button></td>';
                                echo '</tr>';
                            }
                        }
                        else
                        {
                            echo '<tr class="noProduct"><td colspan="7" align="center">There are no product can be shown.</td></tr>';
                        }
                        /*echo '<tr><td colspan="7" align="center"><button type="submit" class="btn btn-danger" name="btnBackForward" id="btnBackForward" value="submit">Back</button></td></tr>';*/
                        ?>
                    </tbody>
                </table>
                <br>
                <div id="divButton">
                <?php
                echo '<center><button type="button" class="btn btn-primary" id="btnAddProduct" onClick="addRow(countStockRow, \'productTable\', \'divButton\', \'btnAddProduct\', countStockRow);" value="submit">Add</button></center>';
                ?>
                </div>
            </div>

    <?php } ?>

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