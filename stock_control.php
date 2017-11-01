<?php
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
<script language="javascript">
    function editRow(num, proID, proName, qty, price) {
        var tbl = document.getElementById("productTable");
        row = document.getElementById("stockRow"+num);

        //remove button and add button
        for(var i = 0; i < countRow; i++){
            document.getElementById("btnEditStockControl"+(i+1)).disabled = true;
            document.getElementById("btnEditStockControl"+(i+1)).style.cursor = "not-allowed";
        }
        var newCell = row.deleteCell(0);
        newCell = row.insertCell(0);
        newCell.innerHTML = num;
        newCell = row.deleteCell(1);
        newCell = row.insertCell(1);
        newCell.innerHTML = proName;
        newCell = row.deleteCell(2);
        newCell = row.insertCell(2);
        newCell.innerHTML = '<input type="text" name="txtQTY" id="txtQTY" value="" placeholder="  Quantity" style="width:100%;" autofocus required="required" />';
        document.getElementById("txtQTY").value = qty;
        newCell = row.deleteCell(3);
        newCell = row.insertCell(3);
        newCell.innerHTML = '<input type="text" name="txtPrice" id="txtPrice" value="" placeholder="  Price" style="width:100%;" autofocus required="required" />';
        document.getElementById("txtPrice").value = price;
        newCell = row.deleteCell(4);
        newCell = row.insertCell(4);
        newCell.innerHTML = '<button type="submit" id="btnSaveStockControl" name="btnSaveStockControl" title="Save" style="border: 0; background: transparent; cursor:pointer;" value="" ><img src="img/save.png" width="20" height="20" /></button><button type="submit" id="btnBack" name="btnBack" title="Back" style="border: 0; background: transparent; margin-left:5px; cursor:pointer;" formnovalidate value="#"><img src="img/back.png" width="20" height="20" /></button>';
        document.getElementById("btnSaveStockControl").value = proID;
    }

</script>
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
          <div class="">
            <div class="site-heading">
            </div>
          </div>
        </div>
      </div>
    </header>
    <?php
    if($_POST['btnSaveStockControl'])
    {
        $updatePrice = "UPDATE tblsellingprice SET sellingPrice = ".$_POST['txtPrice']." WHERE productID = '".$_POST['btnSaveStockControl']."' AND sellerID = '".$_SESSION['account_id']."'";
        $checkupdatePrice = mysql_query($updatePrice, $dbLink);

        $updateQuantity = "UPDATE tblstockcontrol SET quantity = ".$_POST['txtQTY']." WHERE productID = '".$_POST['btnSaveStockControl']."' AND sellerID = '".$_SESSION['account_id']."'";
        $checkupdateQuantity = mysql_query($updateQuantity, $dbLink);

        if($checkupdatePrice && $checkupdateQuantity)
        {
            echo '<script>alert("Stock updated successfully.");location="";</script>';
        }
    }
    else if($_POST['btnBack'])
    {
        echo '<script>location="stock_control.php";</script>';
    }
    else
    { ?>
    <form id="formCategory" name="formCategory" method="post" style="margin-top: 100px;" action="">
    <?php   
        $getNumProduct = "SELECT COUNT(productID) AS intProduct FROM tblproduct WHERE sellerID = '".$_SESSION['account_id']."' AND status = 'ACTIVE'";
        $checkNum = mysql_query($getNumProduct, $dbLink);
        $numInfo = mysql_fetch_array($checkNum);
        echo '<script type="text/javascript">var countRow = '.$numInfo['intProduct'].';</script>';

        $getAllProduct = "SELECT * FROM tblproduct WHERE sellerID = '".$_SESSION['account_id']."' AND status = 'ACTIVE'";
        $checkgetAllProduct = mysql_query($getAllProduct, $dbLink);
        ?>
        <div class="container">
            <h2 style="text-align: center;">Stock Control</h2><br>       
            <table id="productTable" class="table table-hover" style="width: 100%">
                <thead>
                    <tr>
                      <th>No</th>
                      <th>Product Name</th>
                      <th>Quantity</th>
                      <th>Unit Price</th>
                      <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    echo "<script>var countProductRow = 0;</script>";
                    if(mysql_num_rows($checkgetAllProduct) > 0)
                    {
                        for($i = 0; $i < mysql_num_rows($checkgetAllProduct); $i++)
                        {
                            $allProduct = mysql_fetch_array($checkgetAllProduct);
                            echo "<script>countProductRow++;</script>";
                            echo '<tr id="stockRow'.($i+1).'">';
                            echo '<td>'.($i+1).'</td>';
                            echo '<td>'.ucwords(strtolower($allProduct['productName'])).'</td>';
                            $getPrice = "SELECT * FROM tblsellingprice WHERE productID = '".$allProduct['productID']."' AND sellerID = '".$_SESSION['account_id']."' AND status = 'ACTIVE'";
                            $checkGetPrice = mysql_query($getPrice, $dbLink);
                            if($checkGetPrice) $price = mysql_fetch_array($checkGetPrice);

                            $getQuantity = "SELECT * FROM tblstockcontrol WHERE productID = '".$allProduct['productID']."' AND sellerID = '".$_SESSION['account_id']."' AND status = 'ACTIVE'";
                            $checkGetQuantity = mysql_query($getQuantity, $dbLink);
                            if($checkGetQuantity) $quantity = mysql_fetch_array($checkGetQuantity);
                            echo '<td>'.$quantity['quantity'].'</td>';
                            echo '<td>RM '.$price['sellingPrice'].'</td>';
                            echo '<td><button type="button" id="btnEditStockControl'.($i+1).'" name="btnEditStockControl" title="Edit" onClick="editRow('.($i+1).', \''.ucwords(strtolower($allProduct['productID'])).'\', \''.ucwords(strtolower($allProduct['productName'])).'\', \''.$price['sellingPrice'].'\', \''.$quantity['quantity'].'\');" style="border: 0; background: transparent; cursor:pointer;" value="'.$allProduct['productID'].'" ><img src="img/edit.png" width="20" height="20" alt="submit" /></button></td>';
                            echo '</tr>';
                        }
                    }
                    else
                    {
                        echo '<tr class="noCategory"><td colspan="6" align="center">There is no product yet.</td></tr>';
                    }
                    ?>
                </tbody>
            </table>
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