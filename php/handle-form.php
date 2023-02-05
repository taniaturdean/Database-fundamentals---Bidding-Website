<?php
session_start();
$username = "";
$firstname = "";
$lastname = "";
$password = "";
$email = "";
$gender = "";
$interests = "";

$data = [];
/*
 * validation:
 */
$errors = [];

// 0. token


//  username - required and less than 25 chars

    if (!empty($_POST['username'])) {
        $username = $_POST['username'];
        if (strlen($username > 25)) {
            $errors[] = 'username should be at most 25 characters in length.';
        };
    } else {
        $errors[] = 'username field cannot be empty';
    }

//  firstname - required only alphabet
    if (!empty($_POST['firstname'])) {
        $firstname = $_POST['firstname'];
        $firstname = strtolower($firstname);
        if (ctype_alpha($firstname) === false) {
            $errors[] = 'firstname must be only letters';
        }
    } else {
        $errors[] = 'firstname field cannot be empty';
    }
// 2. lastname
    if (!empty($_POST['lastname'])) {
        $lastname = $_POST['lastname'];
        $lastname = strtolower($lastname);
        if (ctype_alpha($lastname) === false) {
            $errors[] = 'lastname must be only letters';
        }
    } else {
        $errors[] = 'lastname field cannot be empty';
    }
//3. password - requiered and must go through tests for password strength
    if (!empty($_POST['password'])) {
        $password = $_POST['password'];
        /* Validate password strength */
        $uppercase = preg_match('@[A-Z]@', $password);
        $lowercase = preg_match('@[a-z]@', $password);
        $number = preg_match('@[0-9]@', $password);
        $specialChars = preg_match('@[^\w]@', $password);
        if (!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 8) {
            $errors[] = 'Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one special character.';
        };
        if (strlen($password > 25)) {
            $errors[] = 'Password should be at most 25 characters in length.';
        };
    } else {
        $errors[] = 'password field cannot be empty';
    }

// 4. email - required and has validity constraint
    if (!empty($_POST['email'])) {
        $email = $_POST['email'];
        if (filter_var($email, FILTER_VALIDATE_EMAIL) !== $email) {
            $errors[] = 'email must be valid';
        }
    } else {
        $errors[] = 'email field cannot be empty';
    }

// 5. gender - required
    if (!empty($_POST['gender'])) {
        $gender = $_POST['gender'];
        $allowed_genders = array('Male', 'Female', 'Other');
        if (!in_array($gender, $allowed_genders)) {
            $errors[] = 'must be a valid gender option';
        }
    } else {
        $errors[] = 'gender field cannot be empty';
    }
    /*we are going to change the gender var to single char */
    $gender = substr($gender, 0, 1);

// 6. interests - not required, but must be in selected list

    if( isset($_POST['interests'])) {
        $interests = $_POST['interests'];
        $allowed_interests = ['books', 'clothes', 'electronics', 'gaming', 'jewellery', 'pet_supplies', 'shoes'];
        foreach ($interests as $interest) {
            if (!in_array($interest, $allowed_interests)) {
                $errors[] = "$interest is an invalid interest";
                break;
            }
        }
        /* I'm going to enter the interests into the database as a joined string*/
        $interests = implode(",", $interests);
    }
    else {
        $interests = '';
    }

if ($errors) {
    $_SESSION['status'] = 'error';
    $_SESSION['errors'] = $errors;
    header('Location:index.php?result=validation_error');
    die();
} else {
    $data = [
        'username' => $username,
        'firstname' => $firstname,
        'lastname' => $lastname,
        'password' => $password,
        'email' => $email,
        'gender' => $gender,
        'interests' => $interests

    ];
    $res = save_data($data, $username, $firstname, $lastname, $password, $email, $gender, $interests);

    if ($res[0] === 1) { //if successful
        $_SESSION['status'] = 'success';
        $_SESSION['data'] = $data;
        $_SESSION['username'] = $username;
        header('Location:newpage.php');
        die();
    } elseif ($res[0] === 0) {
        $_SESSION['status'] = 'error';
        $errors[] = $res[1];
        $_SESSION['errors'] = $errors;
        header('Location:newpage.php');
    }


}

function save_data($data, $username, $firstname, $lastname, $password, $email, $gender, $interests)
{
    $dbhost = "localhost";
    $dbuser = "root";
    $dbpass = "";
    $db = "example";

    $conn = new mysqli($dbhost,$dbuser,$dbpass,$db);
    if ($conn->connect_error) { // catching error with connecting with the database (usually wrong details)
        return array(0,'there was an error with connecting with the database' );
    }
    //the purpose of the following code is to prevent SQL injection with prepared statements
    // the method I'm now using is the procedural method.
            /* 
            //$stmt = $conn->prepare("INSERT INTO users(firstname, lastname, email, gender,interests)
            //        VALUES (?,?,?,?,?)"); 
            //$stmt -> bind_param('sssss',...[$data['firstname'],$data['lastname'],$data['email'],$data['gender'],$data['interests']]);
            //$stmt->execute();*/
    $sql = "INSERT INTO users(username, firstname, lastname, password, email, gender,interests)
            VALUES (?,?,?,?,?,?,?)";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)) {
        return array(0, 'there was some MySQL error');
    } else {
        mysqli_stmt_bind_param($stmt, "sssssss", $username, $firstname, $lastname, $password, $email, $gender, $interests);
        mysqli_stmt_execute($stmt);
    }
    
    return array(1);
}