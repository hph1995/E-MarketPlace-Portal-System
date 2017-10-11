<?php
session_cache_limiter('private, must-revalidate');
session_start();

    require_once "Mail.php";

    $from = "emarketplaceportal@gmail.com"; 
    $to = $_SESSION['account_email'];  
    $subject = "E-MarketPlace Admin";
    $body =  "Dear Sir/Madam,\n\n\n\tYou had subscribed this seller ".$_SESSION['sellerName']."";

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