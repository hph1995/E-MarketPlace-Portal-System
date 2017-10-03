<?php
	session_cache_limiter('private, must-revalidate');
	session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>E-Market Portal</title>
<link rel="stylesheet" href="css/bootstrap.min.css">
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<link rel="stylesheet" type="text/css" href="css/menuBootstrap.css">
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
        echo '<option value="CLOTHING">Clothing</option>';
        echo '<option value="ELECTRONIC">Electronic</option>';
        echo '<option value="SPORT">Sport</option>';
        echo '<option value="TRAVEL">Travel</option>';
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

    <?php 
        //include('menu(bootstrap).php');
        include('dbEMarketplace.php');
    ?>
<body>
    <?php
    if($_POST['btnSubmitProduct'])
    {
        $addProduct = 'INSERT INTO tblproduct (productName, category, description, placeManufacture) VALUES("'.strtoupper(trim($_POST['txtproName'])).'", "'.strtoupper(trim($_POST['selCategory'])).'", "'.strtoupper(trim($_POST['txtDescr'])).'", "'.strtoupper(trim($_POST['txtPlaceManufacture'])).'")';
        $checkAddProduct = mysql_query($addProduct, $dbLink);
        if($checkAddProduct){
            echo "<script>alert('Product Information Added');location='';</script>";
        }
        else{
            echo "<script>alert('Fail to add product!!');window.history.go(-1);</script>";
        }
    }
    else if ($_POST['btnDelProduct']) {
        $delProduct = "DELETE FROM tblproduct WHERE productID = ".$_POST['btnDelProduct']."";
        $checkDelProduct = mysql_query($delProduct, $dbLink);
        if($checkDelProduct) echo "<script>location='';</script>";
    }
    else if($_POST['btnSaveProduct'])
    {
        $updateProduct = "UPDATE tblproduct SET productName = '".strtoupper(trim($_POST['txtProductName']))."', category = '".strtoupper(trim($_POST['sCategory']))."', description = '".strtoupper(trim($_POST['txtDescr']))."', placeManufacture = '".strtoupper(trim($_POST['txtPManufature']))."' WHERE productID = ".$_POST['btnSaveProduct']."";
        $checkupdateProduct = mysql_query($updateProduct, $dbLink);
        if($checkupdateProduct)
        {
            echo '<script>alert("Product updated successfully.");location="";</script>';
        }
    }
    else if($_POST['btnBack'])
    {
        echo '<script>location="";</script>';
    }
    else if($_POST['btnCancelProduct'])
    {
        echo "<script>location='';</script>";
    }
    else
    { ?>
    <form id="formProduct" name="formProduct" method="post" class="form-horizontal" style="margin-top: 100px;" action="">
    <?php   
        if($_GET['mode'] == 'view')
        { 
            $getNumProduct = "SELECT COUNT(productID) AS intProduct FROM tblproduct";
            $checkNum = mysql_query($getNumProduct, $dbLink);
            $numInfo = mysql_fetch_array($checkNum);
            echo '<script type="text/javascript">var countRow = '.$numInfo['intProduct'].';</script>';

            $getAllProduct = "SELECT * FROM tblproduct";
            $checkGetAllProduct = mysql_query($getAllProduct, $dbLink);
            ?>
            <div class="container" style="background-color: #FFFFFF; width: 60%">
              <h2>Product Table</h2>           
              <table id="productTable" class="table table-hover">
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
                    ?>
                </tbody>
              </table>
            </div>
        <?php }
        else
        {
            /*if($_GET['mode'] == 'view')
            {
                $getProduct = "SELECT * FROM tblproduct WHERE productID = ".$_GET['pID']."";
                $checkGetProduct = mysql_query($getProduct, $dbLink);
                if(mysql_num_rows($checkGetProduct) > 0)
                {
                    $proInfo = mysql_fetch_array($checkGetProduct);
                }
            }*/
    ?>
        <div class="container" style="background-color: #FFFFFF; width: 60%">
            <div class="form-group">
                <label class="control-label col-sm-7"><h3>Product Information</h3></label>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-5">Product Name:</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="txtproName" name="txtproName" placeholder="Enter product name" value="<?php if($_GET['mode'] == 'view') echo $proInfo['productName'];?>">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-5">Category:</label>
                <div class="col-sm-4">
                    <select class="form-control" id="selCategory" name="selCategory">
                        <option value="CLOTHING" <?php if($_GET['mode'] == 'view'){if($proInfo['category'] == "CLOTHINGS") echo 'selected';}?>>Clothing</option>
                        <option value="ELECTRONIC" <?php if($_GET['mode'] == 'view'){if($proInfo['category'] == "ELECTRONIC") echo 'selected';}?>>Electronic</option>
                        <option value="SPORT" <?php if($_GET['mode'] == 'view'){if($proInfo['category'] == "SPORT") echo 'selected';}?>>Sport</option>
                        <option value="TRAVEL" <?php if($_GET['mode'] == 'view'){if($proInfo['category'] == "TRAVEL") echo 'selected';}?>>Travel</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-5">Description:</label>
                <div class="col-sm-4">
                    <textarea class="form-control" id="txtDescr" name="txtDescr" rows="3" placeholder="Enter product description"><?php if($_GET['mode'] == 'view') echo $proInfo['description']; ?></textarea>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-5">Place of Manufacture:</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="txtPlaceManufacture" name="txtPlaceManufacture" placeholder="Enter place manufacture" value="<?php if($_GET['mode'] == 'view') echo $proInfo['placeManufacture'];?>">
                </div>
            </div>
            <div class="form-group">
                <div class="control-label col-sm-6">
                    <input type="submit" name="btnSubmitProduct" class="btn btn-primary" value="<?php if($_GET['mode'] == 'view') echo 'Edit'; else echo 'Submit';?>">
                </div>
                <div class="control-label col-sm-1  ">
                    <input type="submit" name="btnCancelProduct" class="btn btn-danger" value="Cancel">
                </div>
            </div>
        </div>
    </form> 
    <?php } } ?>
</body>
</html>