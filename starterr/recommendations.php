<?php include_once("header.php")?>
<?php include_once("database.php")?>
<?php include_once("session.php") ?>
<?php require("utilities.php")?>

<div class="container">

<h2 class="my-3">Recommendations for you</h2>

<?php
  $conn = OpenConn();
  // This executes the python recommender code adding top 3 recommended categories to the recommender table in our database
  $userid = $_SESSION['userid'];

  // Decision whether we execute the python script
  // If user hasn't bid then we don't execute it
  $query = "SELECT bid_id FROM bids WHERE user_id = ".$userid;
  $result_set = mysqli_query($conn, $query);
  if(mysqli_num_rows($result_set) > 0) {
    // This calles the python recommender script
    $python = 'C:\Users\fsuli\anaconda3\python.exe';
    $pyscript = 'ML_mechanism.py';
    $out = exec("$python $pyscript $userid", $userid);
    echo $out;
  }  
  
  // This collects recommended category ids and names from users
  $userid = $_SESSION['userid'];
  $query  = "SELECT u.rec1, a.category_name crec1, u.rec2, b.category_name crec2, u.rec3, c.category_name crec3 ";
  $query .= "FROM users u, category a, category b, category c WHERE user_id = ".$userid;
  $query .= " AND a.category_id=u.rec1 AND b.category_id=u.rec2 AND c.category_id=u.rec3";
  $result_set = mysqli_query($conn, $query);
  if (!$result_set) {
    exit("Database query failed.");
  }
  $recommends = mysqli_fetch_assoc($result_set);

  mysqli_free_result($result_set);
?>

<h3 class="my-3"><?php echo $recommends['crec1'];?></h3>

<?php

  // This chooses 5 random items from items under the top 3 recommnded categories
  if (empty($recommends)) {

    echo "<div> No recommendations to show yet! </div>";
    closeConn($conn);
    
  } else {
    $sql="SELECT * FROM items
    WHERE items.category_id=".$recommends['rec1'];
    $sql.=" ORDER BY RAND() LIMIT 3";

    $result = mysqli_query($conn,$sql);

    if (mysqli_num_rows($result) > 0) {
      while($row = mysqli_fetch_assoc($result)) {
        //echo "id: " . $row["id"]. " - Name: " . $row["firstname"]. " " . $row["lastname"]. "<br>";
        $item_id = $row['item_id'];
        $title = $row['itemName'];
        $desc = $row['description'];
        $end_time = $row['endDate'];
        $img_url = $row['image'];

        // NEEDS TO CHANGE WHEN WE HAVE
        // both these variables need to be changed to highest of bids when bids features are added
        $price= $row['startPrice'];
        $num_bids = 1; 
        
        // This uses a function defined in utilities.php
        print_listing_li($item_id, $img_url, $title, $desc, $price, $num_bids, $end_time);

      }}}
?>

<h3 class="my-3"><?php echo $recommends['crec2'];?></h3>

<?php
  if (empty($recommends)) {

    echo "<div> No recommendations to show yet! </div>";
    closeConn($conn);
    
  } else {
    $sql="SELECT * FROM items
    WHERE items.category_id=".$recommends['rec2'];
    $sql.=" ORDER BY RAND() LIMIT 3";

    $result = mysqli_query($conn,$sql);

    if (mysqli_num_rows($result) > 0) {
      while($row = mysqli_fetch_assoc($result)) {
        //echo "id: " . $row["id"]. " - Name: " . $row["firstname"]. " " . $row["lastname"]. "<br>";
        $item_id = $row['item_id'];
        $title = $row['itemName'];
        $desc = $row['description'];
        $end_time = $row['endDate'];
        $img_url = $row['image'];
  
        // NEEDS TO CHANGE WHEN WE HAVE
        // both these variables need to be changed to highest of bids when bids features are added
        $price= $row['startPrice'];
        $num_bids = 1; 
        
        // This uses a function defined in utilities.php
        print_listing_li($item_id, $img_url, $title, $desc, $price, $num_bids, $end_time);
  
      }}}
?>

<h3 class="my-3"><?php echo $recommends['crec3'];?></h3>

<?php
  if (empty($recommends)) {

    echo "<div> No recommendations to show yet! </div>";
    closeConn($conn);
    
  } else {
    $sql="SELECT * FROM items
    WHERE items.category_id=".$recommends['rec3'];
    $sql.=" ORDER BY RAND() LIMIT 3";

    $result = mysqli_query($conn,$sql);

    if (mysqli_num_rows($result) > 0) {
      while($row = mysqli_fetch_assoc($result)) {
        //echo "id: " . $row["id"]. " - Name: " . $row["firstname"]. " " . $row["lastname"]. "<br>";
        $item_id = $row['item_id'];
        $title = $row['itemName'];
        $desc = $row['description'];
        $end_time = $row['endDate'];
        $img_url = $row['image'];
  
        // NEEDS TO CHANGE WHEN WE HAVE
        // both these variables need to be changed to highest of bids when bids features are added
        $price= $row['startPrice'];
        $num_bids = 1; 
        
        // This uses a function defined in utilities.php
        print_listing_li($item_id, $img_url, $title, $desc, $price, $num_bids, $end_time);
  
      }


closeConn($conn);

  }};
?>


</div>



<?php include_once("footer.php")?>