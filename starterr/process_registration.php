<?php

include_once('session.php');
include('database.php');

$errors = [];
// add account type selected
$accounttype = $_POST['accountType'];

// check firstname 
if(!empty($_POST['firstname'])) {
    $firstname = $_POST['firstname'];
    if (ctype_alpha($firstname) === false) {
        $errors[] = 'firstname must be only letters';
    }
} else {
    $errors[] = 'firstname field cannot be empty';
}

// check lastname
if(!empty($_POST['lastname'])) {
    $lastname = $_POST['lastname'];
    if (ctype_alpha($lastname) === false) {
        $errors[] = 'lastname must be only letters';
    }
} else {
    $errors[] = 'lastname field cannot be empty';
}

// email checking
if(!empty($_POST['email'])) {
    $email = $_POST['email'];
    if (filter_var($email, FILTER_VALIDATE_EMAIL) !== $email) {
        $errors[] = 'email must be valid';
    }
    // check for repeat emails
    else {
        $conn = OpenConn();
        $result = mysqli_query($conn,"SELECT * FROM  users WHERE email = '$email'") or exit(mysqli_error()); //check for duplicates
        $num_rows = mysqli_num_rows($result);
        if ($num_rows != 0) {
            $errors[] = 'this email address is already in use';
        }
        CloseConn($conn);
     
    }
} else {
    $errors[] = 'email field cannot be empty';
}


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

if(count($_POST['interests']) < 3) {
    $errors[] = 'must select 3 categories';
}


// Errors
if ($errors) {
    $_SESSION['status'] = 'error';
    $_SESSION['errors'] = $errors;
    header('Location:register.php?result=validation_error');
    die();
}

// if there are no errors add to database 
else {

    $data = [
        'firstname' => $firstname,
        'lastname' => $lastname,
        'password' => $hash,
        'email' => $email,
        'accounttype' => $accounttype,
    ];



    $res = save_data($data, $firstname, $lastname, $hash, $email, $accounttype);
    //$res1 = addToBuyerSeller($accounttype);

    // check for errors adding to both tables 
    if($res[0] === 1) { //if successful

        // sessions that detect log in
        $_SESSION['logged_in'] = true;
        $_SESSION['username'] = $firstname;
        $_SESSION['account_type'] = $accounttype;        
        $_SESSION['status'] = 'success';
        $_SESSION['data'] = $data;
        
        echo('<div class="text-center">You have successfully created an account! You will be redirected shortly.</div>');
            
        // Redirect to index after 5 seconds
        header("refresh:2;url=index.php?result=success");        
        
       // header('Location:browse.php?result=success');
        die();
    } 
    
    elseif($res[0] === 0) {
        $_SESSION['status'] = 'error';
        $errors[] = $res[1];
        $_SESSION['errors'] = $errors;
        header('Location:browse.php?result=mysql_error');
    }

}


function save_data($data, $firstname, $lastname, $password, $email, $accounttype) {

    $conn = OpenConn();

    $sql = "INSERT INTO users(firstname, lastname, password, email, account_type, rec1, rec2, rec3) VALUES (?,?,?,?,?,?,?,?)";
    $stmt = mysqli_stmt_init($conn);
    
    // The interests are being directly saved inside the function
    $interests = $_POST['interests'];

    if(!mysqli_stmt_prepare($stmt, $sql)) {
        return array(0, 'there was some MySQL error');
    } else {
        mysqli_stmt_bind_param($stmt, "ssssssss", $firstname, $lastname, $password, $email, $accounttype, $interests[0], $interests[1], $interests[2]);
        mysqli_stmt_execute($stmt);
    }

    $findidsql = "SELECT user_id FROM users WHERE email='$email'";
    $result = mysqli_query($conn,$findidsql) or exit(mysqli_error()); 
    $row = mysqli_fetch_array($result);
    // the user if is store to sessions for future reference
    $_SESSION['userid'] = $row[0];

    CloseConn($conn);
    return array(1);
}


// TODO: Extract $_POST variables, check they're OK, and attempt to create
// an account. Notify user of success/failure and redirect/give navigation 
// options.

?>