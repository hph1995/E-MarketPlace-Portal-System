<?php
session_start();

    require_once "Mail.php";

    $from = "emarketplaceportal@gmail.com"; 
    $to = "puonghock9@gmail.com";  
    $subject = "E-MarketPlace Admin";
    $body =  "Dear Sir/Madam,\n\n\n\tYou had subscribed this seller";

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