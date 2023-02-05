<?php include_once("header.php")?>
<?php require("utilities.php")?>
<?php include_once("database.php")?>

<div class="container">

<h2 class="my-3">My bids</h2>

<?php
  // This page is for showing a user the auctions they've bid on.
  // It will be pretty similar to browse.php, except there is no search bar.
  // This can be started after browse.php is working with a database.
  // Feel free to extract out useful functions from browse.php and put them in
  // the shared "utilities.php" where they can be shared by multiple files.

  // TODO: Check user's credentials (cookie/session).

  if (isset($_SESSION['account_type']) && $_SESSION['account_type'] != 'seller') {
        // TODO: Perform a query to pull up their auctions.
        $conn = OpenConn();
        $userid=$_SESSION['userid'];
        
        // find the item_ids that the user has bid on 
        $query = "SELECT DISTINCT item_id FROM bids WHERE user_id=$userid";
        $queryResult=mysqli_query($conn,$query);


        // grab the distinct item_id values that the user has bid on 
        // find the max bid placed by the user for each item
        while($row = mysqli_fetch_array($queryResult)) {
          // grab the item id
          $item = $row['item_id'];

          // max bid
          $sql = "SELECT MAX(bid_price) FROM bids WHERE item_id=$item AND user_id=$userid";
          $sqlResult=mysqli_query($conn,$sql);
          $sqlrow = mysqli_fetch_array($sqlResult);
          $maxbid = $sqlrow[0];

          // grab relavent information from items table
          $sql1 = "SELECT * FROM items WHERE item_id=$item";
          $sqlResult1=mysqli_query($conn,$sql1);
          $sqlrow1 = mysqli_fetch_array($sqlResult1);
          
          // image
          $img_url = $sqlrow1['image'];
          $title = $sqlrow1['itemName'];
          $desc = $sqlrow1['description'];
          $end_time = $sqlrow1['endDate'];

          // both these variables need to be changed to highest of bids when bids features are added
          // highest bid for item 
          $startP = $sqlrow1['startPrice'];

          $sql1 = "SELECT MAX(bid_price) FROM bids WHERE item_id=$item";
          $result1 = mysqli_query($conn,$sql1) or exit(mysqli_error()); 
          $row = mysqli_fetch_array($result1);
          if ($row[0]==NULL) {
              $price = $startP;
              
          }
          else{
              $price = $row[0];
          }

          // total number of bids
          $num_bids = bidNums($item); 

        
          print_bids_li($item, $img_url, $title, $desc, $price, $num_bids, $end_time,$maxbid);
          //echo "<p><b> My highest bid: £".$maxbid."</b></p>";


      }


        CloseConn($conn);
  }
  else {
    header('Location: browse.php');
    CloseConn($conn);

  }
  

?>

<?php include_once("footer.php")?>