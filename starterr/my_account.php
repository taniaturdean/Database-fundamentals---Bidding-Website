<?php 
include_once('session.php');
include_once("header.php");
include('database.php');
?>
<head>
    <title> Here are your details:   </title>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>


<body>
<div id="success_and_errors">
<?php
if( isset($_SESSION['status']) && $_SESSION['status'] === 'password error'){
      $errors = $_SESSION['password errors'];
      echo 'Password change failed';
      foreach($errors as $e){
        echo "<br>$e";
      }
      unset($_SESSION['status']);
      unset($_SESSION["password errors"]);
  }
if(isset($_SESSION['password_change']) && $_SESSION['password_change'] ==='yes') {
    echo "password successfully changed";
    unset($_SESSION['password_change']);
}
?>
<header>Your details: </header>
<?php

$conn = OpenConn();
$user_id = $_SESSION['userid'];
$sql = "SELECT * FROM `users` WHERE user_id = $user_id; ";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
echo "<br>Firstname: ".$row['firstname'];
echo "<br>Lastname: ".$row['lastname'];
echo "<br>Email: ".$row['email'];
echo "<br>Account Type: ".$row['account_type'];



?>
</div>
<?php
?>

</div>
</body>

<?php include_once("footer.php")?>