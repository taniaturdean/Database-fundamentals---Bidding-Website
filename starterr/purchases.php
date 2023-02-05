<?php include_once("header.php")?>
<?php include_once("database.php")?>
<?php include_once("session.php") ?>
<?php require("utilities.php")?>

<div class="container">

<h2 class="my-3">Your Purchases</h2>

<?php
  $conn = OpenConn();
  $userid = $_SESSION['userid'];
  $sql = "SELECT `item_id`, `bid_price` FROM `bids` WHERE `user_id`=$userid and `winner`=1;";

  $result = mysqli_query($conn,$sql);
  // this goes through the item_ids and prints out the items the user has won auctions for 
  if (mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {

      $item_id = $row['item_id'];
      $purchase_price = $row['bid_price'];
      $sql1 = "SELECT * FROM `items` WHERE `item_id`=$item_id;";
      $result1 = mysqli_query($conn,$sql1);
      $item_info = mysqli_fetch_assoc($result1);
      $title = $item_info['itemName'];
      $desc = $item_info['description'];
      $end_time = $item_info['endDate'];
      $img_url = $item_info['image'];
      
      $num_bids=bidNums($item_id);
      // This uses a function defined in utilities.php



      // TODO: was too lazy to change this function but it prints out the number of bids
      print_listing_li($item_id, $img_url, $title, $desc, $purchase_price,$num_bids, $end_time);
  }
}
else {
  echo 'no purchases to show yet.';
}
CloseConn($conn);
 

?>


</div>



<?php include_once("footer.php")?>

