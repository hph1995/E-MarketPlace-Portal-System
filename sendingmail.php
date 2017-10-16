<?php
session_cache_limiter('private, must-revalidate');
session_start();

    require_once "Mail.php";
    require_once "dbEMarketplace.php";

    if($_GET['sID'] != "")
    {
        $getSeller = "SELECT * FROM tblpersonnel WHERE accountID = ".$_GET['sID']."";
        $checkGetSeller = mysql_query($getSeller, $dbLink);
        $addSubscriber = "INSERT INTO tblsubscribe (sellerID, customerID) VALUES('".$_GET['sID']."', '".$_SESSION['account_id']."')";
        $checkAddSubscriber = mysql_query($addSubscriber, $dbLink);
        if($checkGetSeller) $sender = mysql_fetch_array($checkGetSeller);
        $senderName = $sender['name'];

        $from = "emarketplaceportal@gmail.com"; 
        $to = $_SESSION['account_email'];  
        $subject = "E-MarketPlace Admin";
        $body =  "Dear Sir/Madam,\n\n\n\tYou had subscribed this seller ".$senderName."\n\nBest regards,\n".$senderName."";

        $host = "ssl://smtp.gmail.com";
        $port = "465";
        $username = "emarketplaceportal@gmail.com";
        $password = "EMarketPlace@123";

        $headers = array ('From' => $from,
          'To' => $to,
          'Subject' => $subject);
        $smtp = @Mail::factory('smtp',
          array ('host' => $host,
            'port' => $port,
            'auth' => true,
            'username' => $username,
            'password' => $password));

        $mail = @$smtp->send($to, $headers, $body);

        if (@PEAR::isError($mail)) {
          echo("<p>" . $mail->getMessage() . "</p>");
        }
        else {
          echo "<script> alert('Subscribed successfully'); location='index.php';</script>"; 
        }
    }
    elseif ($_GET['addPID'] != "") {
        $getSeller = "SELECT * FROM tblpersonnel WHERE accountID = ".$_SESSION['account_id']."";
        $checkGetSeller = mysql_query($getSeller, $dbLink);
        $getSubscriber = "SELECT * FROM tblsubscribe WHERE sellerID = '".$_SESSION['account_id']."'";
        $checkGetSubscriber = mysql_query($getSubscriber, $dbLink);
        $getProName = "SELECT * FROM tblproduct WHERE productID = ".$_GET['addPID']."";
        $checkGetProName = mysql_query($getProName, $dbLink);
        if($checkGetProName) $proName = mysql_fetch_array($checkGetProName);
        if($checkGetSeller) $sender = mysql_fetch_array($checkGetSeller);
        $senderName = $sender['name'];

        for($i = 0; $i < mysql_num_rows($checkGetSubscriber); $i++)
        {
            $subInfo = mysql_fetch_array($checkGetSubscriber);
            $getSubscriberEmail = "SELECT * FROM tblpersonnel WHERE accountID = ".$subInfo['customerID']."";
            $checkGetSubscriberEmail = mysql_query($getSubscriberEmail, $dbLink);
            $customerInfo = mysql_fetch_array($checkGetSubscriberEmail);

            $from = "emarketplaceportal@gmail.com"; 
            $to = $customerInfo['email'];  
            $subject = "E-MarketPlace Admin";
            $body =  "Dear Sir/Madam,\n\n\n\t".$senderName." had added new product \"".$proName['productName']."\".\n\nBest regards,\n".$senderName."";

            $host = "ssl://smtp.gmail.com";
            $port = "465";
            $username = "emarketplaceportal@gmail.com";
            $password = "EMarketPlace@123";

            $headers = array ('From' => $from,
              'To' => $to,
              'Subject' => $subject);
            $smtp = @Mail::factory('smtp',
              array ('host' => $host,
                'port' => $port,
                'auth' => true,
                'username' => $username,
                'password' => $password));

            $mail = @$smtp->send($to, $headers, $body);
        }

        if (@PEAR::isError($mail)) {
          echo("<p>" . $mail->getMessage() . "</p>");
        }
        else {
          echo "<script> alert('Product added successfully'); location='product.php';</script>"; 
        }
    }
    elseif ($_GET['updatePID'] != "") {
       $getSeller = "SELECT * FROM tblpersonnel WHERE accountID = ".$_SESSION['account_id']."";
        $checkGetSeller = mysql_query($getSeller, $dbLink);
        $getSubscriber = "SELECT * FROM tblsubscribe WHERE sellerID = '".$_SESSION['account_id']."'";
        $checkGetSubscriber = mysql_query($getSubscriber, $dbLink);
        $getProName = "SELECT * FROM tblproduct WHERE productID = ".$_GET['updatePID']."";
        $checkGetProName = mysql_query($getProName, $dbLink);
        if($checkGetProName) $proName = mysql_fetch_array($checkGetProName);
        if($checkGetSeller) $sender = mysql_fetch_array($checkGetSeller);
        $senderName = $sender['name'];

        for($i = 0; $i < mysql_num_rows($checkGetSubscriber); $i++)
        {
            $subInfo = mysql_fetch_array($checkGetSubscriber);
            $getSubscriberEmail = "SELECT * FROM tblpersonnel WHERE accountID = ".$subInfo['customerID']."";
            $checkGetSubscriberEmail = mysql_query($getSubscriberEmail, $dbLink);
            $customerInfo = mysql_fetch_array($checkGetSubscriberEmail);

            $from = "emarketplaceportal@gmail.com"; 
            $to = $customerInfo['email'];  
            $subject = "E-MarketPlace Admin";
            $body =  "Dear Sir/Madam,\n\n\n\t".$senderName." had updated the product \"".$proName['productName']."\".\n\nBest regards,\n".$senderName."";

            $host = "ssl://smtp.gmail.com";
            $port = "465";
            $username = "emarketplaceportal@gmail.com";
            $password = "EMarketPlace@123";

            $headers = array ('From' => $from,
              'To' => $to,
              'Subject' => $subject);
            $smtp = @Mail::factory('smtp',
              array ('host' => $host,
                'port' => $port,
                'auth' => true,
                'username' => $username,
                'password' => $password));

            $mail = @$smtp->send($to, $headers, $body);
        }

        if (@PEAR::isError($mail)) {
          echo("<p>" . $mail->getMessage() . "</p>");
        }
        else {
          echo "<script> alert('Product updated successfully'); location='product.php';</script>"; 
        }
    }

?>