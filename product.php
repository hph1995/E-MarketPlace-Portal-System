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
        $("#btnStock").click(function(){
            $('.noStock').css({display:'none'});
        });
    });

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
    <header class="masthead" style="background-image: url('img/home-bg.jpg')">
      <div class="container">
        <div class="row">
          <div class="col-lg-8 col-md-10 mx-auto">
            <div class="site-heading">
              <h1>Product Information</h1>
              <span class="subheading">Sign in with your Deallo Account</span>
            </div>
          </div>
        </div>
      </div>
    </header>
    <?php
    if($_POST['btnSubmitProduct'])
    {
        $sendEmail = false;
        $addProduct = 'INSERT INTO tblproduct (productName, category, description, placeManufacture, sellerID, status) VALUES("'.strtoupper(trim($_POST['txtproName'])).'", "'.strtoupper(trim($_POST['selCategory'])).'", "'.strtoupper(trim($_POST['txtDescr'])).'", "'.strtoupper(trim($_POST['txtPlaceManufacture'])).'", "'.$_SESSION['account_id'].'", "ACTIVE")';
        $checkAddProduct = mysql_query($addProduct, $dbLink);
        $subscribedBuyer = "SELECT * FROM tblsubscribe WHERE sellerID = '".$_SESSION['account_id']."'";
        $checkSubscribedBuyer = mysql_query($subscribedBuyer, $dbLink);
        if(mysql_num_rows($checkSubscribedBuyer) > 0) $sendEmail = true;
        if($checkAddProduct){
            echo "<script>alert('Product Information Added');location='';</script>";
            if($sendEmail == true)
            {
                //send email to subscribed
                $getProductID = "SELECT COUNT(productID) as intPID FROM tblproduct";
                $checkGetProductID = mysql_query($getProductID, $dbLink);
                $numPID = mysql_fetch_array($checkGetProductID);
                echo "<script>location='sendingmail.php?addPID=".$numPID['intPID']."';</script>";
            }
         }
        else{
            echo "<script>alert('Fail to add product!!');window.history.go(-1);</script>";
        }
    }
    else if ($_POST['btnDelProduct']) {
        $delProduct = "UPDATE tblproduct SET status = 'INACTIVE' WHERE productID = ".$_POST['btnDelProduct']."";
        $checkDelProduct = mysql_query($delProduct, $dbLink);
        if($checkDelProduct) echo "<script>location='';</script>";
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
            echo '<script>alert("Product updated successfully.");location="";</script>';
            if($sendEmail == true)
            {
                //send email to subscribed
                echo "<script>location='sendingmail.php?updatePID=".$_POST['btnSaveProduct']."';</script>";
            }
        }
    }
    else if($_POST['btnBack'])
    {
        echo '<script>location="";</script>';
    }
    else if($_POST['btnBackForward'])
    {
        echo '<script>location="product_manage.php";</script>';
    }
    else if($_POST['btnCancelProduct'])
    {
        echo "<script>location='';</script>";
    }
    else
    { ?>
    <form id="formProduct" name="formProduct" method="post" style="margin-top: 100px;" action="">
    <?php   
        if($_GET['mode'] == 'view')
        { 
            $getNumProduct = "SELECT COUNT(productID) AS intProduct FROM tblproduct";
            $checkNum = mysql_query($getNumProduct, $dbLink);
            $numInfo = mysql_fetch_array($checkNum);
            echo '<script type="text/javascript">var countRow = '.$numInfo['intProduct'].';</script>';

            $getAllProduct = "SELECT * FROM tblproduct WHERE status = 'ACTIVE'";
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
                          <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        if(mysql_num_rows($checkGetAllProduct) > 0)
                        {
                            for($i = 0; $i < mysql_num_rows($checkGetAllProduct); $i++)
                            {
                                $allProduct = mysql_fetch_array($checkGetAllProduct);
                                echo '<tr id="stockRow'.($i+1).'">';
                                echo '<td>'.($i+1).'</td>';
                                echo '<td>'.ucwords(strtolower($allProduct['productName'])).'</td>';
                                echo '<td>'.ucwords(strtolower($allProduct['category'])).'</td>';
                                echo '<td>'.ucwords(strtolower($allProduct['description'])).'</td>';
                                echo '<td>'.ucwords(strtolower($allProduct['placeManufacture'])).'</td>';
                                echo '<td><button type="button" id="btnEditProduct'.($i+1).'" name="btnEditProduct" title="Edit" onClick="editRow('.($i+1).', \''.ucwords(strtolower($allProduct['productID'])).'\', \''.ucwords(strtolower($allProduct['productName'])).'\', \''.ucwords(strtolower($allProduct['category'])).'\', \''.ucwords(strtolower($allProduct['description'])).'\', \''.ucwords(strtolower($allProduct['placeManufacture'])).'\');" style="border: 0; background: transparent; cursor:pointer;" value="'.$stockInfo['drugID'].'" ><img src="img/edit.png" width="20" height="20" alt="submit" /></button>
                                <button onclick="if(confirm(\'Are you sure want to delete?\') == true ){ return true; } else { return false;}" type="submit" id="btnDelProduct'.($i+1).'" name="btnDelProduct" title="Delete" style="border: 0; background: transparent; margin-left:5px; cursor:pointer;" value="'.$allProduct['productID'].'"><img src="img/remove.png" width="20" height="20" alt="delete" /></button></td>';
                                echo '</tr>';
                            }
                        }
                        else
                        {
                            echo '<tr><td colspan="6" align="center">There are no product can be shown.</td></tr>';
                        }
                        echo '<tr><td colspan="6" align="center"><button type="submit" class="btn btn-danger" name="btnBackForward" id="btnBackForward" value="submit">Back</button></td></tr>';
                        ?>
                    </tbody>
                </table>
                <br>
            </div>
        <?php }
        else
        {
    ?>
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-10 mx-auto">
				<div class="dropdown">
  <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Product Management
  <span class="caret"></span></button>
  <ul class="dropdown-menu">
    <li><a href="product.php">Add</a></li>
    <li><a href="product.php?mode=view">Edit</a></li>
    <li><a href="product.php?mode=view">Delete</a></li>
  </ul>
</div>
                    <p>Please fill in all information</p>
                    <div class="control-group">
                        <div class="form-group floating-label-form-group controls">
                            <label>Product Name</label>
                            <input type="text" class="form-control" id="txtproName" name="txtproName" placeholder="Enter product name" value="<?php if($_GET['mode'] == 'view') echo $proInfo['productName'];?>">
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="form-group floating-label-form-group controls"">
                            <label>Category</label>
                            <select class="form-control" id="selCategory" name="selCategory">
                                <?php
                                $getCategory = "SELECT * FROM tblcategory";
                                $checkGetCategory = mysql_query($getCategory, $dbLink);
                                if($checkGetCategory)
                                {
                                    for($i = 0; $i < mysql_num_rows($checkGetCategory); $i++)
                                    {
                                        $categoryInfo = mysql_fetch_array($checkGetCategory);
                                        echo $categoryInfo['catName'];
                                        echo '<option value="'.$categoryInfo['catName'].'">'.ucwords(strtolower($categoryInfo['catName'])).'</option>';
                                    }
                                } 
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="form-group floating-label-form-group controls"">
                            <label>Description</label>
                            <textarea class="form-control" id="txtDescr" name="txtDescr" rows="3" placeholder="Enter product description"><?php if($_GET['mode'] == 'view') echo $proInfo['description']; ?></textarea>
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="form-group floating-label-form-group controls"">
                            <label>Place of Manufacture</label>
                            <input type="text" class="form-control" id="txtPlaceManufacture" name="txtPlaceManufacture" placeholder="Enter place manufacture" value="<?php if($_GET['mode'] == 'view') echo $proInfo['placeManufacture'];?>">
                        </div>
                    </div>
                    <br>
                    <div class="form-group">
                        <input type="submit" name="btnSubmitProduct" class="btn btn-secondary" value="<?php if($_GET['mode'] == 'view') echo 'Edit'; else echo 'Submit';?>">
                        <input type="submit" name="btnCancelProduct" class="btn btn-danger" value="Cancel">
                    </div>
                </div>
            </div>
        </div>
    </form> 

    <?php } } ?>

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