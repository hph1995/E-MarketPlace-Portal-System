<?php

//start the session
session_start();

//delete all variables of session
session_unset();

//destroy the session
session_destroy();

//jump to index.php automatic
echo "<script>location='login.php';</script>";

?>