<?php
// playing around with jQuery and MySQL
include_once("database.php");
$conn = OpenConn('auction');
$userid = $_POST['recommendationUpdate'];
$sql2 = "SELECT * FROM `watchlist` WHERE userid=$userid";
$result2 = mysqli_query($conn, $sql2);
if (mysqli_num_rows($result2) > 0) {
    while ($row = mysqli_fetch_assoc($result2)) {
        echo "<p>";
        echo $row['userid'] . ' ' . $row['itemid'];
        echo "<p/>";
    }
}
else{
    echo "<p>";
    echo "No results for this user $userid";
    echo "<p/>";
}

?>