<?php
require_once('database.php');
$email = $_POST['email'];
$conn = OpenConn('auction');
if(!$conn) {
    echo json_encode($conn -> connect_error);

}
$sql2 = "SELECT * FROM `users` WHERE email='$email'";
$result2 = mysqli_query($conn,$sql2);
if ($result2===false) {
    echo json_encode($conn -> error);
}
if(mysqli_num_rows($result2)==0) {
    $target_text = 'unused email';
}
else {
    $target_text = 'email already exists';
}
echo json_encode($target_text);
?>
