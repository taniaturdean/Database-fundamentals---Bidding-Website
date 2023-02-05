<?php include_once("database.php");
$conn = OpenConn('auction');
?>
<html lang="en">
<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>
    <title></title>
    Hello world

    <script>
        $(document).ready(function() {
            userid = 27;
            $("#btn").click(function() {
                console.log(userid);
                userid ++;
                $("#recommendations").load("load_watchlist.php", {
                    recommendationUpdate: userid
                });
            });

        });

    </script>
</head>
<body>
<div id="recommendations">
    <?php
    $userid = 27;
    $sql2 = "SELECT * FROM `watchlist` WHERE userid=$userid";
    $result2 = mysqli_query($conn,$sql2);
    $table = mysqli_fetch_array($result2);
    if (mysqli_num_rows($result2)>0) {
        while($row = mysqli_fetch_assoc($result2)) {
            echo "<p>";
            echo $row['userid'].' '.$row['itemid'];
            echo "<p/>";
        }

    }
    ?>
</div>
<button id="btn" >Click me</button>
</body>
</html>