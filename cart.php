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
<script language="javascript">

  function checkTotalAmount(totalRow)
  {
    var total = 0;
    for(var i = 0; i < totalRow; i++)
    {
      qty = document.getElementById("txtQTY"+(i+1)).value;
      price = document.getElementById("txtPrice"+(i+1)).value;
      total += qty * price;
    }
    document.getElementById('totalResult').innerHTML = total;
    document.getElementById('txtStoreTotalRow').value = i;
    //return total;
  }

  function changeTotalAmount()
  {
    totalRow = document.getElementById("txtStoreTotalRow").value;
    var total = 0;
    for(var i = 0; i < totalRow; i++)
    {
      qty = document.getElementById("txtQTY"+(i+1)).value;
      price = document.getElementById("txtPrice"+(i+1)).value;
      total += qty * price;
    }
    document.getElementById('totalResult').innerHTML = total;
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
    $getLastCartID = "SELECT MAX(cartID) as number FROM tblcart WHERE accountID = '".$_SESSION['account_id']."' AND status = 'ACTIVE'";
    $checkGetLastCartID = mysql_query($getLastCartID, $dbLink);
    $result = mysql_fetch_array($checkGetLastCartID);
    $count = 1;
    for($i = 0; $i < $result['number']; $i++)
    {
      if($_POST["btnDeleteList$count"])
      {
        $update_status = mysql_query("UPDATE tblcart SET status = 'INACTIVE' WHERE cartID = ".$count."");
      }
      $count += 1;
    }

    if($_GET['pid'] != "")
    {
      
    }
    else
    { ?>
    <form id="formCart" name="formCart" method="post" style="margin-top: 100px;" action="" enctype="multipart/form-data">
      <div class="container">
        <h2 style="text-align: center;">Cart List</h2><br>       
        <table id="productTable" class="table table-hover" style="width: 100%">
          <thead>
            <tr>
              <th>No</th>
              <th>Product Name</th>
              <th>Quantity</th>
              <th>Price</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $getCartList = "SELECT * FROM tblcart WHERE accountID = '".$_SESSION['account_id']."' AND status = 'ACTIVE'";
            $checkGetCartList = mysql_query($getCartList, $dbLink);
            for($i = 0; $i < mysql_num_rows($checkGetCartList); $i++)
            {
              echo "<script>var count$i = 0;</script>";
              $cartDetails = mysql_fetch_array($checkGetCartList);
              echo '<tr>';
              echo '<td>'.($i+1).'</td>';
              $getProDetail = "SELECT * FROM tblproduct, tblsellingprice, tblstockcontrol WHERE tblproduct.productID = tblsellingprice.productID AND tblproduct.productID = tblstockcontrol.productID AND tblproduct.productID = ".$cartDetails['productID']."";
              $checkGetProDetail = mysql_query($getProDetail, $dbLink);
              if($checkGetProDetail) $proDetail = mysql_fetch_array($checkGetProDetail);
              echo '<td>'.$proDetail['productName'].'</td>';
              echo '<td><input type="number" id="txtQTY'.($i+1).'" name="txtQTY'.($i+1).'" value="1" min="1" max="'.$proDetail['quantity'].'" onkeyup="changeTotalAmount()" /></td>';
              echo '<td>RM '.$proDetail['sellingPrice'].'</td>';
              echo '<input type="hidden" id="txtPrice'.($i+1).'" name="txtPrice'.($i+1).'" value="'.$proDetail['sellingPrice'].'" />';
              echo '<td><button name="btnDeleteList'.$cartDetails['cartID'].'" value="submit"><i class="fa fa-times" aria-hidden="true"></i></button></td>';
              echo '</tr>';
            }
            ?>              
            <tr><td colspan="3" align="right">Total</td><td>RM <span id="totalResult"></span></td></tr>
            <input type="hidden" id="txtStoreTotalRow" />
            <?php echo "<script>checkTotalAmount(".$i.");</script>";?>
          </tbody>
        </table>
      </div>
    </form>

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