<?php

session_start();

unset($_SESSION['logged_in']);
unset($_SESSION['account_type']);
unset($_SESSION['status']);
unset($_SESSION['errors']); 
unset($_SESSION['username']); 
unset($_SESSION['userid']); 
unset($_SESSION['data']); 
setcookie(session_name(), "", time() - 360);
session_destroy();


// Redirect to index
header("Location: index.php");


?>