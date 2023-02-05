<?php

require_once('database.php');
function check_email() {
    $email = $_POST['email'];
    $conn = OpenConn();
    $sql2 = "SELECT * FROM `users` WHERE email='$email'";
    $result2 = mysqli_query($conn, $sql2);

    if (mysqli_num_rows($result2) == 0) {
        $target_text = 'unused email';
    } else {
        $target_text = 'email already exists';
    }
    return $target_text;
}
if($_POST['desired_function'] == 'check_email') {
    $res = check_email();
    echo $res;
}
?>
