<?php include_once("header.php")?>
<?php require("utilities.php")?>
<?php include_once("session.php");?>
<?php include_once("debug_to_console.php");?>


<?php
  // Get info from the URL:
  $item_id = $_GET['item_id'];
//  $user_id = $_SESSION['userid'];

  // TODO: check for success or not if a bid was placed
  if (isset($_GET['result'])) {
     if($_GET['result']=="success"){
      echo "<p>your bid has been successfully placed!</p>";
     }
     elseif($_GET['result']=="my_sql_error"){
        echo "<p>database connection error</p>";
     }

     elseif($_GET['result']=="validation_error"){
        $errors = $_SESSION['errors'];
        foreach($errors as $e){
          echo "$e <br>";
        }
      }
      elseif($_GET['result']=="empty"){
        echo "<p>you cannot submit an empty bid</p>";
      }
      elseif (!isset($_SESSION['logged_in']) && !isset($_SESSION['account_type'])) {
        echo "<p>please login to submit a bid</p>";

      }
      elseif (isset($_SESSION['account_type']) && $_SESSION['account_type'] == 'seller') {
        echo "<p>you must have a buyer account to place bids</p>";

      }

  }
  ?>
  <head>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>
  
</head>
<?php
  // TODO: Use item_id to make a query to the database.
  $conn = OpenConn();

  $sql = "SELECT * FROM items WHERE item_id=$item_id";
  $result = mysqli_query($conn,$sql) or exit(mysqli_error()); 
  $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
  $title = $row["itemName"];
  $end_time = new DateTime($row['endDate']);
  $description = $row['description'];
  $img_url = $row['image'];
  $startPrice = $row['startPrice'];

  // make current item information appear in $_SESSION
  $_SESSION['current_item_id'] = $item_id;
  $endDateAsString = $end_time->format('Y-m-d H:i:s');
  debug_to_console($endDateAsString);
  $_SESSION['end_date'] = $endDateAsString;
  debug_to_console($endDateAsString);

  // find current highest price
  // sql to find all bids with the select item_id
  $sql1 = "SELECT MAX(bid_price) FROM bids WHERE item_id=$item_id";
  $result1 = mysqli_query($conn,$sql1) or exit(mysqli_error()); 
  $row = mysqli_fetch_array($result1);
  if ($row[0]==NULL) {
      $current_price = 0;
      
  }
  else{
      $current_price = $row[0];
  }

  // find all num of bids

// find whether the user is watching this item
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    $has_session = true;
    $user_id = $_SESSION['userid'];
    $sql2 = "SELECT * FROM `watchlist` WHERE userid=$user_id and itemid=$item_id";
    $result2 = mysqli_query($conn,$sql2) or exit(mysqli_error());
    $row = mysqli_fetch_array($result2, MYSQLI_ASSOC);
    // if there is no watch created for this user with this item
    if (!$row) {
        $watching = false;
    }
    else {
        $watching = true;
    }

}
else {
    $has_session = false;
    $watching = false;
}


  CloseConn($conn);

  // till here


  // DELETEME: For now, using placeholder data.

  //$current_price = 30.50;
  $num_bids = 1;
  
  // $end_time = new DateTime('2020-11-02T00:00:00');

  // TODO: Note: Auctions that have ended may pull a different set of data,
  //       like whether the auction ended in a sale or was cancelled due
  //       to lack of high-enough bids. Or maybe not.
  
  // Calculate time to auction end:
  $now = new DateTime();
  
  if ($now < $end_time) {
    $time_to_end = date_diff($now, $end_time);
    $time_remaining = ' (in ' . display_time_remaining($time_to_end) . ')';
  }
  
  // TODO: If the user has a session, use it to make a query to the database
  //       to determine if the user is already watching this item.
  //       For now, this is hardcoded.
?>


<div class="container">

<div class="row"> <!-- Row #1 with auction title + watch button -->
  <div class="col-sm-8"> <!-- Left col -->
    <h2 class="my-3"><?php echo($title); ?></h2>
  </div>
  <div class="col-sm-4 align-self-center"> <!-- Right col -->
<?php
  /* The following watchlist functionality uses JavaScript, but could
     just as easily use PHP as in other places in the code */
  if ($now < $end_time && isset($user_id)):
?>
    <div id="watch_nowatch" <?php if ($has_session && $watching) echo('style="display: none"');?> >
      <button type="button" class="btn btn-outline-secondary btn-sm" onclick="addToWatchlist()">+ Add to watchlist</button>
    </div>
    <div id="watch_watching" <?php if (!$has_session || !$watching) echo('style="display: none"');?> >
      <button type="button" class="btn btn-success btn-sm" disabled>Watching</button>
      <button type="button" class="btn btn-danger btn-sm" onclick="removeFromWatchlist()">Remove watch</button>
    </div>
<?php endif /* Print nothing otherwise */ ?>
  </div>
</div>

<div class="row"> <!-- Row #2 with auction description + bidding info -->
  <div class="col-sm-8"> <!-- Left col with item info -->
  <!-- Added image -->
    <div>
      <?php echo('<img src="uploads/'.$img_url.'" width="150" height="150">'); ?>
    </div>
    <div class="itemDescription">
    <?php echo($description); ?>
    </div>

  </div>

  <div class="col-sm-4"> <!-- Right col with bidding info -->

    <p>
<?php if ($now > $end_time): ?>
  <!-- if logged in:-->
  <?php if (isset($user_id)): ?>

      <!--if the current user is the winner then they see you've won this auction, if not then same display-->
      <?php
      
      $conn = OpenConn();
      $winnersql = "SELECT * FROM `bids` WHERE item_id = $item_id and winner=1 and user_id=$user_id;";
      $result = mysqli_query($conn,$winnersql);
      CloseConn($conn);
      // check if the current user won this auction
      if (mysqli_num_rows($result) > 0) {
        $winner = 'yes';
      }
      else {
        $winner = 'no';
      }
      ?>
  
     This auction ended <?php echo(date_format($end_time, 'j M H')).', ' ?> <?php if ($winner === 'yes') {echo "you have won this auction";} else {echo "you've not won this auction";};?>
  <?php else: ?>
    This auction ended <?php echo(date_format($end_time, 'j M H')).', ' ;?>
  <?php endif ?>

     <!-- TODO: Print the result of the auction here? -->
<?php else: ?>
</p>
    <slot>Auction ends <?php echo(date_format($end_time, "Y/m/d H:i:s")) ?>  </slot>
    <p id="timeRemaining"></p>
    <p class="lead">Start price: £<?php echo($startPrice) ?></p>
    <p class="lead">Current highest bid: £<?php echo(number_format($current_price, 2)) ?></p>
    <!-- Bidding form -->
    <form method="POST" id="biddingForm" action="place_bid.php?id=<?php echo $item_id ?>">
      <div class="input-group">
        <div class="input-group-prepend">
          <span class="input-group-text">£</span>
        </div>
	    <input type="number" class="form-control" id="bid" name="bid">
      </div>
      <button type="submit" class="btn btn-primary form-control">Place bid</button>
    </form>
<?php endif ?>

  
  </div> <!-- End of right col with bidding info -->

</div> <!-- End of row #2 -->


<!-- TODO: Live Bid Updates -->
<div> Bid History </div>
<div class="table-wrapper-scroll-y my-custom-scrollbar">
  
  <table class="table table-bordered table-striped mb-0">
    <thead>
      <tr>
        <th scope="col">Timestamp</th>
        <th scope="col">Bid (£)</th>
        <th scope="col">User First Name</th>
        <th scope="col"> User Last Name</th>
      </tr>
    </thead>

    <tbody>

    <?php
      $conn = OpenConn();
      $sql="SELECT bids.timestamp,bids.bid_price, users.firstname, users.lastname FROM bids,users WHERE bids.item_id=$item_id  and  bids.user_id=users.user_id ORDER BY bid_price DESC";
      $result = mysqli_query($conn,$sql) or exit(mysqli_error()); 
  

      while ($bidrow = mysqli_fetch_array($result)){
        $bidtime = new DateTime($bidrow['timestamp']);
        echo('<tr>
              <td>'.date_format($bidtime,'h:i:sa d-m-Y').'</td>
              <td>'.$bidrow['bid_price'].'</td>
              <td>'.$bidrow['firstname'].'</td>
              <td>'.$bidrow['lastname'].'</td>
              </tr>'
        );
      }
     
      echo ('</tbody>
      </table>');

      CloseConn($conn);
    ?>

</div>

<?php include_once("footer.php")?>


<script>

// execute every second (1000 milliseconds) to find the real time for auction end
$(document).ready(function() {
  setInterval(function () {
    var dateString = <?php if (isset($endDateAsString)) {echo json_encode($endDateAsString);} else {echo 'nothing';}?>;
    expiration = new Date(dateString);
    currDate = new Date();
    // check if the expiration isn't after now:
      if (expiration>currDate) {
      // seconds between datetimes
      fullSeconds = Math.abs(expiration - currDate) / 1000;
      // getting days
      days = Math.floor(fullSeconds / 86400);
      fullSeconds -= days*86400;
      // getting hours
      hours = Math.floor(fullSeconds / 3600) % 24;
      fullSeconds -= hours * 3600;
      // getting minutes
      minutes = Math.floor(fullSeconds / 60) % 60;
      fullSeconds -= minutes * 60;
      //seconds
      seconds = Math.floor(fullSeconds % 60);
      if (minutes == 0 && hours ==0 && days==0) {
        timeRemaining = `${seconds} seconds`;
        $("#timeRemaining").html(timeRemaining).css('color', 'red');
      } else if (hours == 0 && days==0) {
        timeRemaining = `${minutes} minutes, ${seconds} seconds`;
        $("#timeRemaining").html(timeRemaining).css('color', 'orange');
      } else if (days == 0) {
        timeRemaining = `${hours} hours, ${minutes} minutes, ${seconds} seconds`;
        $("#timeRemaining").html(timeRemaining);
      } else {
        timeRemaining = `${days} days, ${hours} hours, ${minutes} minutes, ${seconds} seconds`;
        $("#timeRemaining").html(timeRemaining);
      }
      
} else {document.getElementById('biddingForm').style.display='none';};}, 1000); 
});
</script>

<?php // for the watchlist funcs we only want to call them if the user is logged in ->
if(isset($user_id)):?>
<script> 
// JavaScript functions: addToWatchlist and removeFromWatchlist.

function addToWatchlist(button) {
  console.log("These print statements are helpful for debugging btw");

  // This performs an asynchronous call to a PHP function using POST method.
  // Sends item ID as an argument to that function.
  $.ajax('watchlist_funcs.php', {
    type: "POST",
    data: {functionname: 'add_to_watchlist', arguments: [<?php echo($item_id);?>, <?php echo($user_id);?>]},

    success: 
      function (obj, textstatus) {
        // Callback function for when call is successful and returns obj
        console.log("Success");
        var objT = obj.trim();
 
        if (objT == "success") {
          $("#watch_nowatch").hide();
          $("#watch_watching").show();
        }
        else {
          var mydiv = document.getElementById("watch_nowatch");
          mydiv.appendChild(document.createElement("br"));
          mydiv.appendChild(document.createTextNode("Add to watch failed. Try again later."));
        }
      },

    error:
      function (obj, textstatus) {
        console.log("Error");
      }
  }); // End of AJAX call

} // End of addToWatchlist func

function removeFromWatchlist(button) {
  // This performs an asynchronous call to a PHP function using POST method.
  // Sends item ID as an argument to that function.
  $.ajax('watchlist_funcs.php', {
    type: "POST",
    data: {functionname: 'remove_from_watchlist', arguments: [<?php echo($item_id);?>,<?php echo($user_id);?>]},

    success: 
      function (obj, textstatus) {
        // Callback function for when call is successful and returns obj
        console.log("Success");
        var objT = obj.trim();
 
        if (objT == "success") {
          $("#watch_watching").hide();
          $("#watch_nowatch").show();
        }
        else {
          var mydiv = document.getElementById("watch_watching");
          mydiv.appendChild(document.createElement("br"));
          mydiv.appendChild(document.createTextNode("Watch removal failed. Try again later."));
        }
      },

    error:
      function (obj, textstatus) {
        console.log("Error");
      }
  }); // End of AJAX call

} // End of addToWatchlist func
</script>

<?php endif?>