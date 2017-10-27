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
    $(document).ready(function(){
        $("#btnAddCategory").click(function(){
            $('.noCategory').css({display:'none'});
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
        add.setAttribute("name", "btnAddCategory");
        add.setAttribute("type", "submit");
        cancel.setAttribute("style", "float:left; position:relative; left: 46%;");
        cancel.setAttribute("class", "btn btn-danger");
        cancel.setAttribute("type", "submit");
        cancel.setAttribute("formnovalidate", "formnovalidate");
        cancel.setAttribute("value", "#");
        for(var i = 0; i < numberOfBtn; i++){
            document.getElementById("btnEditCategory"+(i+1)).disabled = true;
            document.getElementById("btnDelCategory"+(i+1)).disabled = true;
            document.getElementById("btnEditCategory"+(i+1)).style.cursor = "not-allowed";
            document.getElementById("btnDelCategory"+(i+1)).style.cursor = "not-allowed";
        }
        var newCell = row.insertCell(0);
        newCell.setAttribute("align", "center");
        newCell.innerHTML = num;    
        newCell = row.insertCell(1);
        newCell.innerHTML = '<input type="text" name="txtcatname" id="txtcatname" placeholder="  Category Name" style="width:100%;" autofocus required="required" />';
        add.setAttribute("value", "#");
        cancel.setAttribute("name", "btnCAddCategory");
        
        document.getElementById(divName).appendChild(add);
        document.getElementById(divName).appendChild(cancel);
    }

    function editRow(num, catid, cName) {
        var tbl = document.getElementById("productTable");
        row = document.getElementById("stockRow"+num);

        //remove button and add button
        for(var i = 0; i < countRow; i++){
            document.getElementById("btnEditCategory"+(i+1)).disabled = true;
            document.getElementById("btnDelCategory"+(i+1)).disabled = true;
            document.getElementById("btnEditCategory"+(i+1)).style.cursor = "not-allowed";
            document.getElementById("btnDelCategory"+(i+1)).style.cursor = "not-allowed";
        }
        document.getElementById("btnAddCategory").disabled = true;
        document.getElementById("btnAddCategory").style.cursor = "not-allowed";
        var newCell = row.deleteCell(0);
        newCell = row.insertCell(0);
        newCell.innerHTML = num;
        newCell = row.deleteCell(1);
        newCell = row.insertCell(1);
        newCell.innerHTML = '<input type="text" name="txtCatName" id="txtCatName" value="" placeholder="  Category Name" style="width:100%;" autofocus required="required" />';
        document.getElementById("txtCatName").value = cName;
        newCell = row.deleteCell(2);
        newCell = row.insertCell(2);
        newCell.innerHTML = '<button type="submit" id="btnSaveCategory" name="btnSaveCategory" title="Save" style="border: 0; background: transparent; cursor:pointer;" value="" ><img src="img/save.png" width="20" height="20" /></button><button type="submit" id="btnBack" name="btnBack" title="Back" style="border: 0; background: transparent; margin-left:5px; cursor:pointer;" formnovalidate value="#"><img src="img/back.png" width="20" height="20" /></button>';
        document.getElementById("btnSaveCategory").value = catid;
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
    if($_POST['btnAddCategory'])
    {
        $addCategory = 'INSERT INTO tblcategory (catName, status) VALUES("'.strtoupper(trim($_POST['txtcatname'])).'", "ACTIVE")';
        $checkAddCategory = mysql_query($addCategory, $dbLink);
        if($checkAddCategory){
            echo "<script>alert('Category Information Added');location='category.php';</script>";
        }
        else{
            echo "<script>alert('Fail to add category!!');window.history.go(-1);</script>";
        }
    }
    else if ($_POST['btnDelCategory']) {
        $delProduct = "UPDATE tblcategory SET status = 'INACTIVE' WHERE catID = ".$_POST['btnDelCategory']."";
        $checkDelProduct = mysql_query($delProduct, $dbLink);
        if($checkDelProduct) echo "<script>location='';</script>";
    }
    else if($_POST['btnSaveCategory'])
    {
        $updateCategory = "UPDATE tblcategory SET catName = '".strtoupper(trim($_POST['txtCatName']))."' WHERE catID = ".$_POST['btnSaveCategory']."";
        $checkupdateCategory = mysql_query($updateCategory, $dbLink);
        if($checkupdateCategory)
        {
            echo '<script>alert("Category updated successfully.");location="";</script>';
        }
    }
    else if($_POST['btnCAddCategory'])
    {
        echo "<script>location='category.php';</script>";
    }
    else if($_POST['btnBack'])
    {
        echo "<script>location='category.php';</script>";
    }
    else
    { ?>
    <form id="formCategory" name="formCategory" method="post" style="margin-top: 100px;" action="">
    <?php   
        $getNumProduct = "SELECT COUNT(catID) AS intCategory FROM tblcategory WHERE status = 'ACTIVE'";
        $checkNum = mysql_query($getNumProduct, $dbLink);
        $numInfo = mysql_fetch_array($checkNum);
        echo '<script type="text/javascript">var countRow = '.$numInfo['intCategory'].';</script>';

        $getAllCategory = "SELECT * FROM tblcategory WHERE status = 'ACTIVE'";
        $checkgetAllCategory = mysql_query($getAllCategory, $dbLink);
        ?>
        <div class="container">
            <h2 style="text-align: center;">Category Table</h2><br>       
            <table id="productTable" class="table table-hover" style="width: 100%">
                <thead>
                    <tr>
                      <th>No</th>
                      <th>Category Name</th>
                      <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    echo "<script>var countCategoryRow = 0;</script>";
                    if(mysql_num_rows($checkgetAllCategory) > 0)
                    {
                        for($i = 0; $i < mysql_num_rows($checkgetAllCategory); $i++)
                        {
                            $allProduct = mysql_fetch_array($checkgetAllCategory);
                            echo "<script>countCategoryRow++;</script>";
                            echo '<tr id="stockRow'.($i+1).'">';
                            echo '<td>'.($i+1).'</td>';
                            echo '<td>'.ucwords(strtolower($allProduct['catName'])).'</td>';
                            echo '<td><button type="button" id="btnEditCategory'.($i+1).'" name="btnEditCategory" title="Edit" onClick="editRow('.($i+1).', \''.ucwords(strtolower($allProduct['catID'])).'\', \''.ucwords(strtolower($allProduct['catName'])).'\');" style="border: 0; background: transparent; cursor:pointer;" value="'.$stockInfo['drugID'].'" ><img src="img/edit.png" width="20" height="20" alt="submit" /></button>
                            <button onclick="if(confirm(\'Are you sure want to delete?\') == true ){ return true; } else { return false;}" type="submit" id="btnDelCategory'.($i+1).'" name="btnDelCategory" title="Delete" style="border: 0; background: transparent; margin-left:5px; cursor:pointer;" value="'.$allProduct['catID'].'"><img src="img/remove.png" width="20" height="20" alt="delete" /></button></td>';
                            echo '</tr>';
                        }
                    }
                    else
                    {
                        echo '<tr class="noCategory"><td colspan="6" align="center">There is no category. Add Now!!</td></tr>';
                    }
                    ?>
                </tbody>
            </table>
            <br>
            <div id="divButton">
            <?php
            echo '<center><button type="button" class="btn btn-primary" id="btnAddCategory" onClick="addRow(countCategoryRow, \'productTable\', \'divButton\', \'btnAddCategory\', countCategoryRow);" value="submit">Add</button></center>';
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