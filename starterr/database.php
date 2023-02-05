<?php 


function OpenConn() {
    $servername = "localhost";
    $database = "auction";
    $username = "root";
    $dbpassword = "";
    $conn = mysqli_connect($servername,$username,$dbpassword,$database);
    if (!$conn) { 
        echo "error";
    } 

    return $conn;

}
     
function CloseConn($conn){
    mysqli_close($conn);
}

require_once('email.php');

?>