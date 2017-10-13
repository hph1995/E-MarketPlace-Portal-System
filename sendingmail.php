<?php
session_cache_limiter('private, must-revalidate');
session_start();

    require_once "Mail.php";
    require_once "dbEMarketplace.php";

    if($_GET['sID'] != "")
    {
        $getSeller = "SELECT * FROM tblpersonnel WHERE accountID = ".$_GET['sID']."";
        $checkGetSeller = mysql_query($getSeller, $dbLink);
        if($checkGetSeller) $sender = mysql_fetch_array($checkGetSeller);
        $senderName = $sender['name'];
    }

    $from = "emarketplaceportal@gmail.com"; 
    $to = $_SESSION['account_email'];  
    $subject = "E-MarketPlace Admin";
    $body =  "Dear Sir/Madam,\n\n\n\tYou had subscribed this seller ".$senderName."";

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
?>