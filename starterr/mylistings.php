<?php include_once("header.php")?>
<?php require("utilities.php")?>

<div class="container">

<h2 class="my-3">My listings</h2>

<?php
  // This page is for showing a user the auction listings they've made.
  // It will be pretty similar to browse.php, except there is no search bar.
  // This can be started after browse.php is working with a database.
  // Feel free to extract out useful functions from browse.php and put them in
  // the shared "utilities.php" where they can be shared by multiple files.

  // CARD CSS


  // TODO: Check user's credentials (cookie/session).
  if (isset($_SESSION['account_type']) && $_SESSION['account_type'] != 'buyer') {

    // TODO: Perform a query to pull up their auctions.
    $conn = openConn();
    $userid=$_SESSION['userid'];
    $sql = "SELECT * FROM items WHERE user_id=$userid";
    $result = mysqli_query($conn,$sql);
  
    if (mysqli_num_rows($result) > 0) {
      while($row = mysqli_fetch_assoc($result)) {
        // echo "id: " . $row["id"]. " - Name: " . $row["firstname"]. " " . $row["lastname"]. "<br>";
        $item_id = $row['item_id'];
        $title = $row['itemName'];
        $desc = $row['description'];
        $end_time = $row['endDate'];
        $img_url = $row['image'];
  
        // both these variables need to be changed to highest of bids when bids features are added

        $startP = $row['startPrice'];

        $sql1 = "SELECT MAX(bid_price) FROM bids WHERE item_id=$item_id";
        $result1 = mysqli_query($conn,$sql1) or exit(mysqli_error()); 
        $row = mysqli_fetch_array($result1);
        if ($row[0]==NULL) {
            $price = $startP;
            
        }
        else{
            $price = $row[0];
        }

        $num_bids = bidNums($item_id);
        
        // This uses a function defined in utilities.php
        print_listing_li($item_id, $img_url, $title, $desc, $price, $num_bids, $end_time);
    // TODO: Loop through results and print them out as list items

    }
  }
  else {
    echo 'no listings to show yet.';
  }
  CloseConn($conn);
}

  else {
    header('Location: browse.php');
  }
  
  // TODO: Perform a query to pull up their auctions.
  
  // TODO: Loop through results and print them out as list items.
  
?>

<?php include_once("footer.php")?>