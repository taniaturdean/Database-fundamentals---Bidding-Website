<?php
include("session.php");
include('database.php');
include('debug_to_console.php');

$errors = [];
$user_id = $_SESSION["userid"];

// check passwords are the same
if(!empty($_POST['password1'])) {
    // check that repeat is entered
    if (!empty($_POST['passwordConfirmation'])) {
        // check that they match
        $password = $_POST['password1'];
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $confirmation = $_POST['passwordConfirmation'];
        if ($password!==$confirmation) {
            $errors[] = 'passwords do not match';

        }
    }
    else {
        $errors[] = 'repeat password';
    }

} else {
    $errors[] = 'password field cannot be empty';
}
if ($errors) {
    $_SESSION['status'] = 'password error';
    $_SESSION['password errors'] = $errors;
    header('Location:my_account.php?result=fail');
    die();
}
else {
    $conn = OpenConn();
    $sql = "UPDATE users SET password = '$hash' WHERE user_id = $user_id;";
    if (mysqli_query($conn, $sql)) {
        CloseConn($conn);
        $_SESSION['status'] = 'success';
        $_SESSION['password_change'] = 'yes';
        header('Location:my_account.php?result=success');
    }
    else {
        echo mysqli_error($conn);
    }
    
}
?>