<?php
function OpenConn($database) {
    $servername = "localhost";
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
?>