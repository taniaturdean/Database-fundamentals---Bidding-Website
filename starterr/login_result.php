<?php
include('database.php');
include_once("session.php");


// Create & Check connection
$conn = OpenConn();


// TODO: Extract $_POST variables, check they're OK, and attempt to login.
// Notify user of success/failure and redirect/give navigation options.

// For now, I will just set session variables and redirect.
$email = $_POST['email'];
$password = $_POST['password'];

// check if it exists 
$query = "SELECT password FROM users WHERE email='$email'";

$result = mysqli_query($conn,$query);

if (mysqli_num_rows($result) != 0) {
    while ($row = mysqli_fetch_array($result)) {

        if (password_verify($password, $row['password'])) {
            // password is correct
            session_start();
            $_SESSION['logged_in'] = true;

            // now let's get the info to set the rest of the session
            // user_id
            $sql = "SELECT user_id, account_type, firstname FROM users WHERE email='$email'";
            $result = mysqli_query($conn,$sql) or exit(mysqli_error()); 
            $row = mysqli_fetch_array($result);
            
            $_SESSION['userid'] = $row['user_id'];
            $_SESSION['account_type'] = $row['account_type'];
            $_SESSION['username'] = $row['firstname'];

            ///echo "<h1>".$_SESSION['userid']."<br>".$_SESSION['account_type']."<br>".$_SESSION['username']."</h1>";

            CloseConn($conn);
            echo('<div class="text-center">You are now logged in! You will be redirected shortly.</div>');
            
            // Redirect to index after 5 seconds
            header("refresh:2;url=index.php");        
        }
        else {
            CloseConn($conn);
            header('Location: browse.php?error=incorrectdetails');
        }
    } 
}

else {
    CloseConn($conn);
    header('Location: browse.php?error=emailnotexistant');
}
/*
echo('<div class="text-center">You are now logged in! You will be redirected shortly.</div>');
*/
// Redirect to index after 5 seconds
// header("refresh:5;url=index.php");

?>